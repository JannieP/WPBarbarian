<?php

/*
 * Author: c0nan - c0nan.net
 *
 * PHP Library to support OAuth for c0nan.net REST API.
 */

require_once('OAuth.php');

if (!class_exists('c0nanOAuth')) {

   class c0nanOAuth {

	   /* Contains the last HTTP status code returned */
	   private $http_status;
	   /* Contains the last API call */
	   private $last_api_call;
	   /* Set up the API root URL */
	   public $host = "http://c0nan.net/wpbarbarian/api";

	   /**
	    * Set API URLS
	    */
	   function requestTokenURL() {
		   return $this->host . '/request-token/';
	   }
	   function authorizeURL() {
		   return $this->host . '/auth/';
	   }
	   function accessTokenURL() {
		   return $this->host . '/access-token/';
	   }
	
	   /**
	    * Debug helpers
	    */
	   function lastStatusCode() {
		   return $this->http_status;
	   }
	   function lastAPICall() {
		   return $this->last_api_call;
	   }
	
	   /**
	    * construct WPOAuth object
	    */
	   function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL) {
		   $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1 ( );
		   $this->consumer = new OAuthConsumer ( $consumer_key, $consumer_secret );
		   if (! empty ( $oauth_token ) && ! empty ( $oauth_token_secret )) {
			   $this->token = new OAuthConsumer ( $oauth_token, $oauth_token_secret );
		   } else {
			   $this->token = NULL;
		   }
	   }
	
	   /**
	    * Get a request_token from WP-API
	    *
	    * @returns a key/value array containing oauth_token and oauth_token_secret
	    */
	   function getRequestToken() {
		   $r = $this->oAuthRequest ( $this->requestTokenURL () );
		   $token = $this->oAuthParseResponse ( $r );
		   $this->token = new OAuthConsumer ( $token ['oauth_token'], $token ['oauth_token_secret'] );
		   return $token;
	   }
	
	   /**
	    * Parse a URL-encoded OAuth response
	    *
	    * @return a key/value array
	    */
	   function oAuthParseResponse($responseString) {
		   $r = array ();
		   foreach ( explode ( '&', $responseString ) as $param ) {
			   $pair = explode ( '=', $param, 2 );
			   if (count ( $pair ) != 2)
				   continue;
			   $r [urldecode ( $pair [0] )] = urldecode ( $pair [1] );
		   }
		   return $r;
	   }
	
	   /**
	    * Get the authorize URL
	    *
	    * @returns a string
	    */
	   function getAuthorizeURL($token,$callback = '') {
		   if (is_array ( $token ))
			   $token = $token ['oauth_token'];
		   if(!empty($callback)) {
			   $callback = "&oauth_callback=".urlencode($callback);
		   }
		   return $this->authorizeURL () . '?oauth_token=' . $token . $callback;
	   }
	
	   /**
	    * Exchange the request token and secret for an access token and
	    * secret, to sign API calls.
	    *
	    * @returns array("oauth_token" => the access token,
	    *                "oauth_token_secret" => the access secret)
	    */
	   function getAccessToken($token = NULL) {
		   $r = $this->oAuthRequest ( $this->accessTokenURL () );
		   $token = $this->oAuthParseResponse ( $r );
		   $this->token = new OAuthConsumer ( $token ['oauth_token'], $token ['oauth_token_secret'] );
		   return $token;
	   }

      /**
      * GET wrapper for oAuthRequest.
      */
      function get($url, $parameters = array()) {
         $response = $this->oAuthRequest($url, 'GET', $parameters);
         //if ($this->format === 'json' && $this->decode_json) {
        //    return json_decode($response);
        // }
         return $response;
      }

      /**
      * POST wrapper for oAuthRequest.
      */
      function post($url, $parameters = array()) {
         $response = $this->oAuthRequest($url, 'POST', $parameters);
         //if ($this->format === 'json' && $this->decode_json) {
         //   return json_decode($response);
        // }
         return $response;
      }

      /**
      * DELETE wrapper for oAuthReqeust.
      */
      function delete($url, $parameters = array()) {
         $response = $this->oAuthRequest($url, 'DELETE', $parameters);
         //if ($this->format === 'json' && $this->decode_json) {
         //   return json_decode($response);
         //}
         return $response;
      }
	
	   /**
	    * Format and sign an OAuth / API request
	    */
	   function oAuthRequest($url, $args = array(), $method = NULL) {
         if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
            $url = $this->host.'/'.$url;
         }
		   if (empty ( $method )) $method = empty ( $args ) ? "GET" : "POST";
		   $req = OAuthRequest::from_consumer_and_token ( $this->consumer, $this->token, $method, $url, $args );
		   $req->sign_request ( $this->sha1_method, $this->consumer, $this->token );
		   switch ($method) {
			   case 'GET' :
				   return $this->http ( $req->to_url () );
			   case 'POST' :
				   return $this->http ( $req->get_normalized_http_url (), $req->to_postdata () );
		   }
	   }
	
	   /**
	    * Make an HTTP request
	    *
	    * @return API results
	    */
	   function http($url, $post_data = null) {
		   $ch = curl_init ();
		   if (defined ( "CURL_CA_BUNDLE_PATH" ))
			   curl_setopt ( $ch, CURLOPT_CAINFO, CURL_CA_BUNDLE_PATH );
		   curl_setopt ( $ch, CURLOPT_URL, $url );
		   curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
		   curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
		   curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		   //////////////////////////////////////////////////
		   ///// Set to 1 to verify Hots SSL Cert ///////
		   //////////////////////////////////////////////////
		   curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		   if (isset ( $post_data )) {
			   curl_setopt ( $ch, CURLOPT_POST, 1 );
			   curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		   }

//curl_setopt ( $s, CURLOPT_HTTPPROXYTUNNEL, 1 );
//curl_setopt ( $s, CURLOPT_PROXY, "1.1.1.1:8080" );
//curl_setopt ( $s, CURLOPT_PROXYUSERPWD,"usr:pwd" );

		   $response = curl_exec ( $ch );
		   $this->http_status = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		   $this->last_api_call = $url;
		   curl_close ( $ch );
		   if(empty($response)) {
			   return 'c0nan-API might be down or unresponsive. Please go to http://c0nan.net/wpbarbarian and check if the main website is working. Send us an email to support@c0nan.net in case you have more doubts.';
		   }
		   if(preg_match("/request\-token/i",$response) || preg_match("/access\-token/i",$response)) {
			   //echo "<br/><br/>".preg_replace(array("/.*oauth\_version\=1\.0/i"),array(""),urldecode($response))."<br/><br/>";
			   return preg_replace(array("/.*oauth\_version\=1\.0/i"),array(""),urldecode($response));
		   } else {
			   //echo "<br/><br/>".$response."<br/><br/>";
			   return $response;
		   }
	   }
   }

}

?>
