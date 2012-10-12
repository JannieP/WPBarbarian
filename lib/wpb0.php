<?php

  include_once ('TwtAcc.php');

  class wp_barbarian  {

      function wp_barbarian(){
          $this->options = array(
          'accounts', 
          'do_post', 
          'do_barbarian_1', 
          'do_barbarian_2', 
          'do_barbarian_3', 
          'prefix', 
          'install_date', 
          'useragent', 
          'useragent_url', 
          'message', 
          'use_api', 
          'api_key', 
          'api_user', 'api_hash',
          'use_proxies', 
          'keep_logs', 
          'simulate', 
          'keep', 
          'last', 
          'random',
          'c0nan_oauth_consumer_key',
          'c0nan_oauth_consumer_secret',
          'c0nan_oauth_token',
          'c0nan_oauth_token_secret',
          'c0nan_oauth_hash',
          'l1_and', 'l1_phrase', 'l1_or', 'l1_not', 'l1_tag', 'l1_rpp', 'l1_use_ght', 'l1_only_once', 'l1_use_post_title', 'l1_all', 'l1_group_count', 'l1_uselinkinter', 
          'l2_interval', 'l2_only_once', 'l2_use_ght', 'l2_lasttime', 'l2_tpi', 'l2_tpt', 'l2_proxies', 'l2_uselinkinter', 
          'l3_tw_txt', 'l3_rq_tw', 'l3_rq_fb', 'l3_rq_st', 'l3_rq_gl', 'l3_tw_use_title', 'l3_title', 'l3_bg_color', 'l3_close_color', 'l3_title_color', 'l3_display_effect', 'l3_bh', 'l3_allways', 'l3_use_other_url', 'l3_other_url', 'l3_display_message',
          'db' 
          );
          
          $this->oauth_options = array('app_consumer_key', 'app_consumer_secret', 'oauth_token', 'oauth_token_secret');
                    
          $this->accounts = array();

          $this->do_post = '0';
          $this->do_barbarian_1 = '0';
          $this->do_barbarian_2 = '0';
          $this->do_barbarian_3 = '0';
          
          $this->prefix = '';
          $this->install_date = '';
          $this->useragent = 'WP Barbarian';
          $this->useragent_url = 'http://c0nan.net';
          $this->message = '';

          $this->use_api = '0';
          $this->api_key = '';
          $this->api_user = '';
          $this->api_hash = '0';

          $this->use_proxies = '0';
          $this->keep_logs = '1';
          $this->simulate = '0';
          $this->keep = '0';
          
          $this->app_consumer_key = '';
          $this->app_consumer_secret = '';
          $this->oauth_token = '';
          $this->oauth_token_secret = '';
          $this->twitter_username = '';
          $this->oauth_hash = '';
          $this->oauth_validated = '0';
          $this->tweet_format = $this->prefix . ': %s %s';

          $this->last = 0;
          $this->random = '0';
          
          $this->c0nan_oauth_consumer_key = '';
          $this->c0nan_oauth_consumer_secret = '';
          $this->c0nan_oauth_token = '';
          $this->c0nan_oauth_token_secret = '';
          $this->c0nan_oauth_hash = '';
          
          $this->l1_and = '';
          $this->l1_phrase = '';
          $this->l1_or = '';
          $this->l1_not = '';
          $this->l1_tag = '';
          $this->l1_rpp = '10';
          $this->l1_only_once = '1';
          $this->l1_use_post_title = '0';
          $this->l1_all = '0';
          $this->l1_group_count = '1';
          $this->l1_uselinkinter = '0';
          $this->l1_linkinterlast = 0;
          
          $this->l2_interval = '6';
          $this->l2_only_once = '1';
          $this->l2_lasttime = (time() - (1 * 60 * 60 * 24));
          $this->l2_tpi = '2';
          $this->l2_tpt = '2';
          $this->l2_all = '0';
          $this->l2_proxies = '';
          $this->l2_uselinkinter = '0';
          $this->l2_linkinterlast = 0;
          
          $this->l3_tw_txt = 'Found this great page ->';
          $this->l3_rq_tw = '1';
          $this->l3_rq_fb = '1';
          $this->l3_rq_st = '1';
          $this->l3_rq_gl = '1';
          $this->l3_tw_use_title = '1';
          $this->l3_title = "Help Promote This Page, Please.";
          $this->l3_display_message = "Please help us to promote this page, It will cost you no Money.<br>Just click on one of these buttons below.<br><br> Thank You.";
          $this->l3_bg_color = "#F5EBCC";
          $this->l3_close_color = "#000000";
          $this->l3_title_color = "#000000";
          $this->l3_display_effect = "lightbox";
          $this->l3_all = '0';
          $this->l3_bh = '0';
          $this->l3_allways = '0';
          $this->l3_use_other_url = '0';
          $this->l3_other_url = '';
          
          $this->version = TB_VERSION;
          $this->db = '0';

      }
      
      function upgrade(){
          if (get_option('tb_installed_version') == '1.0') {
              $this->upgrade_1();
          }
      }    

      function upgrade_1(){
          if (get_option('tb_oauth_validated') != '1') {
              tb_log('Require Upgrading');
              $tw = new tb_tw_acc($this->twitter_username, $this->app_consumer_key, $this->app_consumer_secret, $this->oauth_token, $this->oauth_token_secret, $this->oauth_hash);
              $this->accounts[] = $tw;
              update_option('tb_accounts', $this->accounts);
              delete_option('tb_counter');
              update_option('tb_installed_version', '2.0');
              tb_log('Upgraded to 2.0');
              return(true);
         }
      }
      
      function get_settings(){
          foreach ($this->options as $option) {
              $value = get_option('tb_' . $option);
              if (isset($value)) {
                  $this->$option = $value;
              } 
          }
          if (!empty($this->prefix)) {
              $this->tweet_format = $this->prefix . ': %s %s';
          } else {
              
              $this->tweet_format = '%s %s';
          }
      }
      
      function populate_settings(){
          foreach ($this->options as $option){
              if ($option != 'message') {
                  $value = stripslashes($_POST['tb_' . $option]);
                  if (isset($_POST['tb_' . $option])) {
                      foreach ($this->oauth_options as $oaoption) {
                          if ($option == $oaoption) {
                              if ($_POST['tb_' . $option] != get_option('tb_' . $oaoption)) {
                                  $this->oauth_validated = '0';
                              }
                          }
                      }
                      $this->$option = $value;
                  }
              }
          }
      }
      
      function update_settings(){
          if (current_user_can('manage_options')) {
              foreach ($this->options as $option) {
                  if ($option != 'message') {
                      update_option('tb_' . $option, $this->$option);
                  }
              }
              if (empty($this->install_date)) {
                  update_option('tb_install_date', current_time('mysql'));
              }
              $this->upgrade();
              update_option('tb_installed_version', TB_VERSION);
              update_option('tb_db', TB_DB);
          }
      }
      
      function do_tweet($tweet = ''){
          if (empty($tweet) || empty($tweet->tw_text)) {
              tb_log('Failed: Tweet empty...');
              return;
          }
          $tweet = apply_filters('tb_do_bitly', $tweet);
          if (!$tweet) {
              tb_log('Failed: Bit.ly Failed...');
              return;
          }
          $this->setNextAcc();
          test_oAuth();
          if (tb_oauth_test() && ($connection = tb_oauth_connection())) {
              if (get_option('tb_simulate') == '0') {
                  $connection->post(TB_API_POST_STATUS, array('status' => $tweet->tw_text, 'source' => 'c0nan'));
                  if (strcmp($connection->http_code, '200') == 0) {
                      tb_log('Tweeted:' . $tweet->tw_text);
                      return true;
                  } else {
                      
                  }
              } else {
                  
                  tb_log('Simulated:' . $tweet->tw_text);
                  return true;
              }
          } else {
              
          }
          return false;
      }
      
      function do_blog_post_tweet($post_id = 0){
          $post = get_post($post_id);
          if ($post->post_date <= $this->install_date) {
              return;
          }
          
          if ($post->post_status == 'private') {
              return;
          }
          
          $tweet = new tb_tweet;
          $url = apply_filters('tweet_blog_post_url', get_permalink($post_id));
          $tweet->tw_text = sprintf(__($this->tweet_format, 'wp-barbarian'), @html_entity_decode($post->post_title, ENT_COMPAT, 'UTF-8'), $url);
          $tweet = apply_filters('tb_do_blog_post_tweet', $tweet, $post);
          if (!$tweet) {
              return;
          }
          $this->do_tweet($tweet);
          add_post_meta($post_id, 'tb_tweeted', '1', true);
      }
      
      function tweet_test(){
          $this->setProxy();
          $tweet = new tb_tweet;
          $tweet->tw_text = TB_URI.' - '.md5(time());
          $this->do_tweet($tweet);
          tb_log('Test Completed!');
      }
      
      function do_barbarian_1($post_id = 0){
          $pre = get_option('tb_l1_and');
          if (get_option('tb_l1_use_post_title') == '1') {
              $post = get_post($post_id);
              update_option('tb_l1_and', @html_entity_decode($post->post_title, ENT_COMPAT, 'UTF-8'));
          }
          $tweeple = $this->barbarian_1_core();
          update_option('tb_l1_and', $pre);
          foreach ($tweeple as $tweep) {
              if ($tweep != '') {
                  tb_log('Tweep:@' . $tweep);
                  $tweet = new tb_tweet();
                  $linkinternext = $this->l1_linkinterlast + 1;
                  if ($this->l1_linlkinter != '0' || ($linkinternext >= $this->l1_linkinter)) {
                      $this->l1_linkinterlast = 0;
                      $url = apply_filters('tweet_blog_post_url', get_permalink($post_id));
                  } else {
                      
                      $url = '';
                  }
                  if (get_option('tb_l1_use_ght') == '1') {
                      $tweet->tw_text = "@" . $tweep . ' ' . $this->do_ght() . ' ' . $url;
                  } else {
                      
                      $tweet->tw_text = "@" . $tweep . ' for you... ' . $url;
                  }
                  $this->do_tweet($tweet);
                  sleep(1);
                  tb_log('TB1:' . $tweet->tw_text);
              }
          }
          add_post_meta($post_id, 'tb_barbarian1', '1', true);
      }
      
      function barbarian_1_core(){
          if (get_option('tb_l1_and') != '' || get_option('tb_l1_phrase') != '' || get_option('tb_l1_or') != '' || get_option('tb_l1_not') != '' || get_option('tb_l1_hash') != '') {
              include_once('tws.php');
              $twt1 = new TWSearch();
              $twt1->ands = get_option('tb_l1_and');
              $twt1->phrase = get_option('tb_l1_phrase');
              $twt1->ors = get_option('tb_l1_or');
              $twt1->exclude = get_option('tb_l1_not');
              $twt1->tags = get_option('tb_l1_hash');
              $twt1->rpp = get_option('tb_l1_rpp');
              $twt1->proxy = $this->getProxy();
              $twt1->getresults();
              return explode($twt1->delimiter, $twt1->tweeple);
          } else {
              
              tb_log('Barbarian Level 1:At least 1 parameters must be populated.');
              return '';
          }
      }
      
      function barbarian_1_test(){
          $this->setProxy();
          $tweeple = $this->barbarian_1_core();
          tb_log('Found:' . count($twt1->tweeple));
          foreach ($tweeple as $tweep) {
              if ($tweep != '') {
                  tb_log('@' . $tweep);
              }
          }
          tb_log('Test Completed!');
      }
      
      function do_barbarian_2($post_id = 0){
          if (get_option('tb_l2_interval') > 0 && (time() - get_option('tb_l2_lasttime')) < (get_option('tb_l2_interval') * 60 * 60)) {
              tb_log('Barbarian 2 NOT Run, interval not exausted');
              return;
          }
          $trends = $this->barbarian_2_core();
          $tptcounter = 0;
          $tpicounter = 0;
          foreach ($trends as $trend) {
              tb_log('Trend:' . $trend);
              $tptcounter++;
              $tpicounter++;
              $trends2go .= ' ' . $trend;
              if ($tptcounter == get_option('tb_l2_tpt')) {
                  $tptcounter = 0;
                  $tweet = new tb_tweet();
                  
                  $linkinternext = $this->l2_linkinterlast + 1;
                  if ($this->l2_linlkinter != '0' || ($linkinternext >= $this->l2_linkinter)) {
                      $this->l2_linkinterlast = 0;
                      $url = apply_filters('tweet_blog_post_url', get_permalink($post_id));
                  } else {
                      
                      $url = '';
                  }
                  if (get_option('tb_l2_use_ght') == '1') {
                      $tweet->tw_text = $trends2go . ' ' . $this->do_ght() . ' ' . $url;
                  } else {
                      
                      $tweet->tw_text = $trends2go . ' ' . $url;
                  }
                  $this->do_tweet($tweet);
                  sleep(1);
                  tb_log('TB2:' . $tweet->tw_text);
                  update_option('tb_l2_lasttime', time());
                  $trends2go = '';
              }
              if ($tpicounter == get_option('tb_l2_tpi')) {
                  break;
              }
          }
          add_post_meta($post_id, 'tb_barbarian2', '1', true);
      }
      
      function barbarian_2_core(){
          include_once('twt.php');
          $twt1 = new TWTrends();
          $twt1->proxy = $this->getProxy();
          $twt1->gettrends();
          return explode($twt1->delimiter, $twt1->trends);
      }
      
      
      function barbarian_2_test(){
          $this->setProxy();
          $trends = $this->barbarian_2_core();
          tb_log('Current Trends:');
          foreach ($trends as $trend) {
              tb_log($trend);
          }
          tb_log('Test Completed!');
      }
      
      function do_ght(){
          $trends = $this->ght_core();
          $rand = rand(1, 20);
          $index = 0;
          foreach ($trends as $trend) {
              $index++;
              if ($index == $rand) {
                  return $trend;
              }
          }
      }
      
      function ght_core(){
          include_once('ght.php');
          $ght1 = new GHTrends();
          $ght1->proxy = $this->getProxy();
          $ght1->gettrends();
          return explode($ght1->delimiter, $ght1->trends);
      }
      
      function ght_test(){
          $this->setProxy();
          $trends = $this->ght_core();
          tb_log('GHTrends:');
          foreach ($trends as $trend) {
              tb_log($trend);
          }
          tb_log('Test Completed!');
      }
      
      function addc0nan(){
         $this->c0nan_oauth_consumer_key = $_POST['tb_c0nan_oauth_consumer_key_i'];
         $this->c0nan_oauth_consumer_secret = $_POST['tb_c0nan_oauth_consumer_secret_i'];
         $this->c0nan_oauth_token = $_POST['tb_c0nan_oauth_token_i'];
         $this->c0nan_oauth_token_secret = $_POST['tb_c0nan_oauth_token_secret_i'];
      }

      function savec0nan(){
         update_settings();
      }

      function addtw(){
         $this->app_consumer_key = $_POST['tb_app_consumer_key_i'];
         $this->app_consumer_secret = $_POST['tb_app_consumer_secret_i'];
         $this->oauth_token = $_POST['tb_oauth_token_i'];
         $this->oauth_token_secret = $_POST['tb_oauth_token_secret_i'];
      }
      
      function savetw(){
          $tw = new tb_tw_acc($this->twitter_username, $this->app_consumer_key, $this->app_consumer_secret, $this->oauth_token, $this->oauth_token_secret, $this->oauth_hash);
          $this->accounts[] = $tw;
          update_option('tb_accounts', $this->accounts);
      }
      
      function deltw($tw_acc = '')
      {
          if (!empty($tw_acc)) {
              $tw = array();
              foreach ($this->accounts as $twacc) {
                  if ($tw_acc != $twacc->tw_user) {
                      $tw[] = $twacc;
                  }
              }
              $this->accounts = $tw;
          }
      }
      
      function setNextAcc()
      {
          if (count($this->accounts) > 0) {
              if ($this->random == '1') {
                  $ind = rand(0, count($this->accounts) - 1);
                  $tw = $this->accounts[$ind];
              } else {
                  
                  if ($this->last == count($this->accounts) - 1) {
                      $ind = 0;
                  } else {
                      
                      $ind = $this->last + 1;
                  }
                  $tw = $this->accounts[$ind];
              }
              $this->twitter_username = $tw->tw_user;
              $this->app_consumer_key = $tw->tw_ck;
              $this->app_consumer_secret = $tw->tw_cs;
              $this->oauth_token = $tw->tw_at;
              $this->oauth_token_secret = $tw->tw_as;
              $this->oauth_hash = $tw->tw_hash;
          }
      }
      
      function getProxy()
      {
          if ($this->proxy == "")
              $this->setProxy();
          
          return $this->proxy;
      }
      
      function setProxy()
      {
          if ($this->use_proxies == '1' && trim($this->l2_proxies) != '') {
              $proxies = explode(PHP_EOL, $this->l2_proxies);
              array_walk($proxies, 'trim_value');
              $index = rand(0, count($proxies) - 1);
              $this->proxy = $proxies[$index];
          } else {
              
              $this->proxy = '';
          }
          return($this->proxy);
      }
      
      function pr_test()
      {
          if (trim($this->l2_proxies) != '') {
              $proxies = explode(PHP_EOL, $this->l2_proxies);
              array_walk($proxies, 'trim_value');
              foreach ($proxies as $proxy) {
                  include_once('tb_curl.php');
                  $curl = new Curl();
                  $curl->setDefaults();
                  $curl->referer = "http://google.com";
                  $curl->url = "http://www.google.com";
                  $curl->proxy = $proxy;
                  $curl->timeout = 20;
                  $arr = $curl->doCurl();
                  tb_log($proxy . '->http://www.google.com->' . $arr[1]['http_code']);
                  break;
              }
          }
      }

  }

      function newTwAcc(){
            global $tb;
            $auth_test = false;
            $message = 'fail';
            if (!empty($_POST['tb_app_consumer_key_i']) && !empty($_POST['tb_app_consumer_secret_i']) && !empty($_POST['tb_oauth_token_i']) && !empty($_POST['tb_oauth_token_secret_i'])) {
               if ($connection = tb_oauth_connection()) {
                  $data = $connection->get('account/verify_credentials');
                  if ($connection->http_code == '200') {
                        $data = json_decode($data);
                        $tb->twitter_username = stripslashes($data->screen_name);
                        $oauth_hash = tb_oauth_credentials_to_hash();
                        $tb->oauth_hash = $oauth_hash;
                        $message = 'success';
                  } else {
                        tb_log('Twitter Account Failed');
                  }
               }
               return $message;
            }
      }
   
      function test_oAuth(){
            if ($connection = tb_oauth_connection()) {
               $data = $connection->get('account/verify_credentials');
               if ($connection->http_code == '200') {
               }
            } 
      }

      function formTitle0(){
         print('  
            <div class="wrap" id="tb_options_page">
            <div id="icon-options-general" class="icon32"><br /></div>
            <h2>Wordpress Barbarian Options</h2>
            <span style="font-size: medium">Incorrect USE of this Plugin Will Most likely result in your twitter account being suspended, OR your IP being blocked <br> (Use of this Plugin is at own risk.)</span>
         ');
      }
  
      function c0nanregister(){
          global $tb;
         ?>
               <script type="text/javascript">
               function doCustomSubmitForm(theget){
                     document.forms["tb_wpbarbarian0"].action=document.forms["tb_wpbarbarian0"].action + '?page=wp-barbarian' + theget;
                     document.forms["tb_wpbarbarian0"].submit();
               }
               </script>
         <?php
         print('  
            <div class="wrap" id="tb_options_page">
            <div id="icon-options-general" class="icon32"><br /></div>
            <h2>Wordpress Barbarian Registration</h2>
            <span style="font-size: medium">Please Register This Plugin before you can start Using it. Thanks You...</span>
         ');
      
            print('
               <form id="tb_wpbarbarian0" name="tb_wpbarbarian0" action="' . admin_url('options-general.php') . '" method="post">
                  <p class="submit">
                  <input type="submit" name="save_all" class="button-primary" value="Save Options" />
                  </p>
                  <fieldset class="options">
                  <div id="dashboard-widgets-wrap">
                     <div id="dashboard-widgets" class="metabox-holder">
                        <div id="postbox-container" style="width:75%; float:left;">
                        <div id="side-sortables" class="meta-box-sortables ui-sortable">
            ');
            
            print('
            <div id="tb_general_config" class="postbox if-js-closed" >
               <h3 class=\'hndle\'>
               <span>Wordpress Barbarian Registration Config<br>
                  <span style="font-size: xx-small">(Register this plugin for the sanity of the Author, Thanks)</span>
               </span>
               </h3>
               <div class="inside">
               <h4>c0nan API OAuth:</h4>
               <div class="table">
                  <table class="widefat">
                     <tbody>
                     <tr>
                        <td><label for="tb_c0nan_oauth_consumer_key">c0nan Consumer Key</label></td>
                        <td><input type="text" size="25" name="tb_c0nan_oauth_consumer_key" id="tb_c0nan_oauth_consumer_key" value="' . esc_attr($tb->c0nan_oauth_consumer_key) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small">(Register this site as an application <a href="http://c0nan.net/wpbarbarian/api/register" title="c0nan App Registration" target="_blank">HERE</a>)</span></td></tr>
                     <tr>
                        <td><label for="tb_c0nan_oauth_consumer_secret">c0nan Consumer Secret</label></td>
                        <td><input type="text" size="25" name="tb_c0nan_oauth_consumer_secret" id="tb_c0nan_oauth_consumer_secret" value="' . esc_attr($tb->c0nan_oauth_consumer_secret) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small"><span style="font-size: xx-small">(Once you have registered your site as an application, you will be provided with a consumer key and a comsumer secret.)</span></span></td></tr>
                     <tr>
                        <td width="30%"><label for="tb_c0nan_oauth_token">Access Token</label></td>
                        <td width="30%"><input type="text" disabled=disabled size="25" name="tb_c0nan_oauth_token" id="tb_c0nan_oauth_token" value="' . esc_attr($tb->c0nan_oauth_token) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small">(Since you are allready logged in to your account, this plugin I will AUTO athorise this...JUST CLICK THE "AUTHORISE" BUTTON)</span></td></tr>
                     <tr>
                        <td><label for="tb_c0nan_oauth_token_secret">Access Token Secret</label></td>
                        <td><input type="text" disabled=disabled size="25" name="tb_c0nan_oauth_token_secret" id="tb_c0nan_oauth_token_secret" value="' . esc_attr($tb->c0nan_oauth_token_secret) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small">(DITTO)</span></td></tr>
                     <tr>
                        <td><label for="tb_c0nan_oauth_hash">Authorised Hash</label></td>
                        <td><label for="tb_c0nan_oauth_hash">' . esc_attr($tb->c0nan_oauth_hash) . '</label></td>
                        <td><span style="font-size: xx-small">(If this is populated, you are Authorised.)</span></td></tr>
                     <tr>
                        <td colspan="3" align="right"><input type="button" name="c0nanacc" class="button-primary" value="Authorise Account" onclick="doCustomSubmitForm(\'&tb_action=oauthc0nan&break=true\')" /></td></tr>
                     </tbody>
                  </table>
               </div>
               </div>
            </div>
         ');
         print('

                     </div>
                     </div>
                  </div>
               </div>
            </fieldset>
            <p class="submit">
               <input type="submit" name="save_all" class="button-primary" value="Save Options" />
            </p>
            <input type="hidden" name="tb_action" value="tb_update_settings" class="hidden" style="display: none;" />
            ' . wp_nonce_field('tb_settings', '_wpnonce', true, false) . wp_referer_field(false) . '
            </form>
         ');

         print('
         <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
            <div id="postbox-container" style="width:75%; float:left;">
               <div id="side-sortables" class="meta-box-sortables ui-sortable">
         ');

         supportContent();

         print('
               </div>
            </div>
            </div>
         </div>
         ');

      }
  
      function formContent0(){
         global $tb;
         $yes_no = array('api_hash','do_post', 'do_barbarian_1', 'do_barbarian_2', 'do_barbarian_3', 'use_api', 'keep_logs', 'use_proxies', 'l1_only_once', 'l2_only_once', 'l1_use_ght', 'l2_use_ght', 'simulate', 'l1_use_post_title', 'l3_rq_tw', 'l3_rq_fb', 'l3_rq_st', 'l3_rq_gl', 'l3_tw_use_title', 'l3_bh', 'l3_allways', 'l3_use_other_url');
         
         foreach ($yes_no as $key) {
            $var = $key . '_options';
            if ($tb->$key == '0') {
               $$var = '
                  <option value="0" selected="selected">No</option>
                  <option value="1">Yes</option>
               ';
            } else {
               $$var = '
                  <option value="0">No</option>
                  <option value="1" selected="selected">Yes</option>
               ';
            }
         }
         
         $optionkeys = 'l1_rpp;10,15,20,25,30,50';
         $optionkeys .= ':l2_tpi;1,2,3,4,5,6,7,8,9,10';
         $optionkeys .= ':l2_tpt;1,2,3,4,5,6,7,8,9,10';
         $optionkeys .= ':l2_interval;0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,24';
         $optionkeys .= ':l3_display_effect;lightbox,popup';
         $optionkeys .= ':l1_uselinkinter;0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,24,25,26,27,28,29,30,31,32,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50';
         $optionkeys .= ':l2_uselinkinter;0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,24,25,26,27,28,29,30,31,32,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50';
         
         $optionkeys = explode(':', $optionkeys);
         foreach ($optionkeys as $optionkey) {
            $optionkeya = explode(';', $optionkey);
            $result = $tb->$optionkeya[0];
            $values = $optionkeya[1];
            $option = $optionkeya[0] . '_options';
            foreach (explode(',', $values) as $value) {
               $$option .= '<option value="' . $value . '" ';
               $$option .= ($result == $value) ? 'selected="selected"' : '';
               $$option .= '>' . $value . '</option>';
            }
         }

         print('
            <div id="tb_general_config" class="postbox if-js-closed" >
               <h3 class=\'hndle\'>
               <span>
                  ' . __('Wordpress Barbarian Config', 'wp-barbarian') . '<br>
                  <span style="font-size: xx-small">(' . __('Select \'Yes\' to activate levels...', 'wp-barbarian') . ')</span>
               </span>
               </h3>
               <div class="table">
                  <table class="widefat">
                     <thead>
                     <tr><th>Status</th><th>ConsumenrKey</th><th>ConsumerSecret</th><th>AccessToken</th><th>AccessSecret</th><th>X</th></tr>
                     </thead>
                     <tbody>
                        <tr><td>Authorised</td><td>' . esc_attr($tb->c0nan_oauth_consumer_key) . '</td><td>' . esc_attr($tb->c0nan_oauth_consumer_secret) . '</td><td>' . esc_attr($tb->c0nan_oauth_token) . '</td><td>' . esc_attr($tb->c0nan_oauth_token_secret) . '</td><td><input type="button" name="c0nandelacc" value="X" onclick="if(wpbConfirm(\'Cancel c0nan Auth?\')){doCustomSubmitForm(\'&tb_action=deleteC0nan&break=true\');}" /></td></tr>
                     </tbody>
                  </table>
               </div>
               <div class="inside">
               <div class="table">
                  <table class="widefat">
                     <tbody>
                     <tr>
                        <td width="30%"><label for="tb_do_post">' . __('Turn ON Post to Twitter?', 'wp-barbarian') . '</label></td>
                        <td width="30%"><select name="tb_do_post" id="tb_do_post">' . $do_post_options . '</select></td>
                        <td><span style="font-size: xx-small">(This is where Wordpress Barbarian tweets posts.)</span></td></tr>
                     <tr>
                        <td><label for="tb_do_barbarian_1">' . __('Turn ON Barbarian Level 1?', 'wp-barbarian') . '</label></td>
                        <td><select name="tb_do_barbarian_1" id="tb_do_barbarian_1">' . $do_barbarian_1_options . '</select></td>
                        <td><span style="font-size: xx-small">(This is where Wordpress Barbarian searches Twitter for a keyword, and "@" replies to those tweeple.)</span></td></tr>
                     <tr>
                        <td><label for="tb_do_barbarian_2">' . __('Turn ON Barbarian Level 2?', 'wp-barbarian') . '</label></td>
                        <td><select name="tb_do_barbarian_2" id="tb_do_barbarian_2">' . $do_barbarian_2_options . '</select></td>
                        <td><span style="font-size: xx-small">(This is where Wordpress Barbarian searches Twitter for trends, and tweets them.)</span></td></tr>
                     <tr>
                        <td><label for="tb_do_barbarian_3">' . __('Turn ON Barbarian Level 3?', 'wp-barbarian') . '</label></td>
                        <td><select name="tb_do_barbarian_3" id="tb_do_barbarian_3">' . $do_barbarian_3_options . '</select></td>
                        <td><span style="font-size: xx-small">(This is where Wordpress Barbarian requests the visitors to your page, to either Tweet the Page, or Like it.)</span></td></tr>
                     <tr>
                        <td><label for="tb_keep_logs">' . __('Keep Logs:', 'wp-barbarian') . '</label></td>
                        <td><select name="tb_keep_logs" id="tb_keep_logs">' . $keep_logs_options . '</select></td>
                        <td><span style="font-size: xx-small">(Enable logs, uses more memory. DO NOT LEAVE THIS ON, IT WILL BREAK THE PLUGIN, ONLY USE FOR TESTING)</span></td></tr>
                     <tr>
                        <td><label for="tb_simulate">' . __('Simultation Mode:', 'wp-barbarian') . '</label></td>
                        <td><select name="tb_simulate" id="tb_simulate">' . $simulate_options . '</select></td>
                        <td><span style="font-size: xx-small">(Turn on Logs for this to be meaningfull. NO Tweets will be made. Remember all simulated post will not process again.)</span></td></tr>
                     <tr>
                        <td><label for="tb_prefix">' . __('Tweet prefix:', 'wp-barbarian') . '</label></td>
                        <td><input type="text" size="25" name="tb_prefix" id="tb_prefix" value="' . esc_attr($tb->prefix) . '" /></td>
                        <td><span style="font-size: xx-small">(Just add what ever you want.)</span></td></tr>
                     </tbody>
                  </table>
               </div>
               </div>
            </div>
         ');
         print('
            <div id="tb_twitter_config" class="postbox if-js-closed" >
               <h3 class=\'hndle\'>
               <span>
                  ' . __('Twitter Config', 'wp-barbarian') . '<br>
                  <span style="font-size: xx-small">(' . __('In order to get started, we need to follow some steps to get this site registered with Twitter.', 'wp-barbarian') . ')</span>
               </span>
               </h3>
               <div class="inside">
               <h4>' . __('Twitter API OAuth:', 'wp-barbarian') . '</h4>
               <div class="table">
                  <table class="widefat">
                     <tbody>
                     <tr>
                        <td width="30%"><label>' . __('Twitter User Name:', 'wp-barbarian') . '</label></td>
                        <td width="30%"><label>' . esc_attr($tb->twitter_username) . '</label></td>
                        <td><span style="font-size: xx-small"> </span></td></tr>
                     <tr>
                        <td><label for="tb_app_consumer_key">' . __('Twitter Consumer Key', 'wp-barbarian') . '</label></td>
                        <td><input type="text" size="25" name="tb_app_consumer_key_i" id="tb_app_consumer_key_i" value="' . esc_attr($tb->app_consumer_key) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small">(' . __('Register this site as an application ', 'wp-barbarian') . '<a href="http://dev.twitter.com/apps/new" title="' . __('Twitter App Registration', 'wp-barbarian') . '" target="_blank">' . __('HERE', 'wp-barbarian') . '</a>)</span></td></tr>
                     <tr>
                        <td><label for="tb_app_consumer_secret">' . __('Twitter Consumer Secret', 'wp-barbarian') . '</label></td>
                        <td><input type="text" size="25" name="tb_app_consumer_secret_i" id="tb_app_consumer_secret_i" value="' . esc_attr($tb->app_consumer_secret) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small"><span style="font-size: xx-small">(' . __('Once you have registered your site as an application, you will be provided with a consumer key and a comsumer secret.', 'wp-barbarian') . ')</span></span></td></tr>
                     <tr>
                        <td width="30%"><label for="tb_oauth_token">' . __('Access Token', 'wp-barbarian') . '</label></td>
                        <td width="30%"><input type="text" size="25" name="tb_oauth_token_i" id="tb_oauth_token_i" value="' . esc_attr($tb->oauth_token) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small">(' . __('On the right hand side of your application page, click on \'My Access Token\'.', 'wp-barbarian') . ')</span></td></tr>
                     <tr>
                        <td><label for="tb_oauth_token_secret">' . __('Access Token Secret', 'wp-barbarian') . '</label></td>
                        <td><input type="text" size="25" name="tb_oauth_token_secret_i" id="tb_oauth_token_secret_i" value="' . esc_attr($tb->oauth_token_secret) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small"> </span></td></tr>
                     <tr>
                        <td colspan="3" align="right"><input type="button" name="twacc" class="button-primary" value="Add Account" onclick="doCustomSubmitForm(\'&tb_action=addTwitter&break=true\')" /></td></tr>
                     </tbody>
                  </table>
               </div>
               <h4>' . __('Twitter Accounts:', 'wp-barbarian') . '</h4>
               <div class="table">
                  <table class="widefat">
                     <thead>
                     <tr><th>UserName</th><th>ConsumenrKey</th><th>ConsumerSecret</th><th>AccessToken</th><th>AccessSecret</th><th>X</th></tr>
                     </thead>
                     <tbody>
                     ');
                        foreach ($tb->accounts as $acc) {
                           print('
                              <tr><td>' . esc_attr($acc->tw_user) . '</td><td>' . esc_attr($acc->tw_ck) . '</td><td>' . esc_attr($acc->tw_cs) . '</td><td>' . esc_attr($acc->tw_at) . '</td><td>' . esc_attr($acc->tw_as) . '</td><td><input type="button" name="twdelacc" value="X" onclick="doCustomSubmitForm(\'&tb_action=deleteTwitter&acc=' . esc_attr($acc->tw_user) . '&break=true\')" /></td></tr>
                                 ');
                        }
                     print('
                     </tbody>
                  </table>
               </div>
               <h4>' . __('Proxies:', 'wp-barbarian') . '</h4>
               <div class="table">
                  <table class="widefat">
                     <tbody>
                     <tr>
                        <td><label for="tb_use_proxies">Use Proxies</label></td>
                        <td><select name="tb_use_proxies" id="tb_use_proxies">' . $use_proxies_options . '</select></td>
                        <td><span style="font-size: xx-small">(Turn on The use of proxies.)</span></td></tr>
                     <tr>
                        <td width="30%"><label for="tb_l2_proxies">Proxies</label></td>
                        <td><textarea disable=disabled name="tb_l2_proxies" id="tb_l2_proxies">' . esc_attr($tb->l2_proxies) . '</textarea></td>
                        <td><span style="font-size: xx-small">Add Proxies here(one per line - I\'m OT going to validate this, so DONT be stupid). DON\'T overdo the proxies, or you will kill this plugin.</span></td></tr>
                     </tbody>
                  </table>
               </div>
               </div>
            </div>
         ');
        /* print('
            <div id="tb_bitly_config" class="postbox if-js-closed" >
               <h3 class=\'hndle\'>
               <span>
                  Bit.ly Config<br>
                  <span style="font-size: xx-small">(In order to get started, we need to follow some steps to get connectiont to Bit.ly API.)</span>
               </span>
               </h3>
               <div class="inside">
               <h4>Bit.ly API Key:</h4>
               <div class="table">
                  <table class="widefat">
                     <tbody>
                     <tr>
                        <td width="30%"><label for="tb_use_api">Use Bit.ly?</label></td>
                        <td width="30%"><select name="tb_use_api" id="tb_use_api">' . $use_api_options . '</select></td>
                        <td><span style="font-size: xx-small">(.)</span></td></tr>
                     <tr>
                        <td><label for="tb_api_user">Bit.ly API Username</label></td>
                        <td><input type="text" size="25" name="tb_api_user" id="tb_api_user" value="' . esc_attr($tb->api_user) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small">(Register at <a href="http://bit.ly/a/sign_up" title="Bit.Ly" target="_blank">HERE</a>)</span></td></tr>
                     <tr>
                        <td><label for="tb_api_key">Bit.ly API Key</label></td>
                        <td><input type="text" size="25" name="tb_api_key" id="tb_api_key" value="' . esc_attr($tb->api_key) . '" autocomplete="off"></td>
                        <td><span style="font-size: xx-small">(Once you have registered, click on your username, top right OR <a href="http://bit.ly/a/account" target="_blank">HERE</a> and get your API Key)</span></td></tr>
                     <tr>
                        <td width="30%"><label for="tb_api_hash">Add Hash</label></td>
                        <td width="30%"><select name="tb_api_hash" id="tb_api_hash">' . $api_hash_options . '</select></td>
                        <td><span style="font-size: xx-small">(Adds a md5 hash to the end of the url to force Bit.ly to return a different short Url for each Tweet)</span></td></tr>
                     </tbody>
                  </table>
               </div>
               </div>
            </div>
         ');*/
         }
   
      function testContent(){
         print('
         <div id="tb_test1" class="postbox if-js-closed" >
            <h3 class=\'hndle\'>
               <span>
               Testing <span style="font-size: xx-small">(This is to make sure it works for you.)</span>
               </span>
            </h3>
            <div class="inside">
               <div class="table">
               <table class="widefat">
                  <thead>
                     <tr><th>Twitter Post</th><th>Barbarian Level 1</th><th>Barbarian Level 2</th><th>Google Hot Trends</th><th>URL Shortner</th><th>Proxies</th></tr>
                  </thead>
                  <tbody>
                     <tr>
                     <td><form id="tb_tb" name="tb_tb" action="' . admin_url('options-general.php') . '?tb_action=tb_test_twitter" method="post"><p class="submit"><input type="submit" name="submit" value="' . __('Test Twitter Post', 'wp-barbarian') . '" /></p></form></td>
                     <td><form id="tb_l1" name="tb_l1" action="' . admin_url('options-general.php') . '?tb_action=tb_test_l1" method="post"><p class="submit"><input type="submit" name="submit" value="' . __('Test WP Barbarian Level 1', 'wp-barbarian') . '" /></p></form></td>
                     <td><form id="tb_l2" name="tb_l2" action="' . admin_url('options-general.php') . '?tb_action=tb_test_l2" method="post"><p class="submit"><input type="submit" name="submit" value="' . __('Test WP Barbarian Level 2', 'wp-barbarian') . '" /></p></form></td>
                     <td><form id="tb_ght" name="tb_ght" action="' . admin_url('options-general.php') . '?tb_action=tb_test_ght" method="post"><p class="submit"><input type="submit" name="submit" value="' . __('Test Google Hot Trends', 'wp-barbarian') . '" /></p></form></td>
                     <td><form id="tb_tp" name="tb_cr8" action="' . admin_url('options-general.php') . '?tb_action=tb_test_cr8" method="post"><p class="submit"><input type="submit" name="submit" value="' . 'Test Url Shortner' . '" /></p></form></td>
                     <td><form id="tb_tp" name="tb_tp" action="' . admin_url('options-general.php') . '?tb_action=tb_test_pr" method="post"><p class="submit"><input type="submit" name="submit" value="' . __('Test Proxies', 'wp-barbarian') . '" /></p></form></td>
                     </tr>
                  </tbody>
               </table>
               </div>
            </div>
         </div> ');
      }
   
      function supportContent(){
         print('
         <div id="tb_test1" class="postbox if-js-closed" >
            <h3 class=\'hndle\'>
               <span>
               Support WP Barbarian <span style="font-size: xx-small">(Give us a bit of a promote if you like this plugin.)</span>
               </span>
            </h3>
            <div class="inside">
               <div class="table">
               <table class="widefat">
                  <thead>
                     <tr><th>Google +1</th><th>Twitter</th><th>Facebook</th><th>Paypal</th></tr>
                  </thead>
                  <tbody>
                     <tr>
                     <td><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><g:plusone size="medium" count="false" callback="tb_relocate" href="<?php echo urlencode($url); ?>"></g:plusone></td>
                     <td><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://c0nan.net" data-text="Best WP / Twitter integration Pluggin ->" data-count="none" data-via="tbjello">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></td>
                     <td><iframe src="http://www.facebook.com/plugins/like.php?app_id=177348815654091&amp;href=http%3A%2F%2Fc0nan.net&amp;send=true&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe></td>
                     <td><form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="3YSK87DWDN7MS"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></form></td>
                     </tr>
                  </tbody>
               </table>
               </div>
            </div>
         </div>');
      }
   
      function logContent(){
         global $tb;
         print('
         <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
            <div id="postbox-container" style="width:75%; float:left;">
               <div id="side-sortables" class="meta-box-sortables ui-sortable">
                  <div id="tblog1" class="postbox if-js-closed" >
                  <h3 class=\'hndle\'>
                     <span>
                        Logs <span style="font-size: xx-small">(Just so you san see what happening.)</span>
                     </span>
                  </h3>
                  <div class="inside">
                     <div class="table">
                        <table class="widefat">
                        <thead>
                           <tr><th>LOG</th></tr>
                        </thead>
                        <tbody>
                           <tr><td>' . $tb->message . '</td></tr>
                           <tr><td><form id="tb_log1" name="tb_log1" action="' . admin_url('options-general.php') . '?tb_action=tb_reset_log" method="post"><p class="submit"><input type="submit" name="submit" value="' . __('Clear Logs', 'wp-barbarian') . '" /></p></form></td></tr>
                        </tbody>
                        </table>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
            </div>
         </div>
         ');
      }

      function siteContent(){
         global $tb;
         print('
         <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
            <div id="postbox-container" style="width:75%; float:left;">
               <div id="side-sortables" class="meta-box-sortables ui-sortable">
                  <div id="tblog1" class="postbox if-js-closed" >
                  <h3 class=\'hndle\'>
                     <span>
                        MORE <span style="font-size: xx-small">(This will keep you informed)</span>
                     </span>
                  </h3>
                  <div class="inside">
                     <div class="table">
                        <table class="widefat">
                           <tr><td><iframe src="http://c0nan.net/wpbarbarian/news" width=100% height=600px /></td></tr>
                        </table>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
            </div>
         </div>
         ');
      }

      function addSupportPanel(){
         global $tb;
         print('
         <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
            <div id="postbox-container" style="width:75%; float:left;">
               <div id="side-sortables" class="meta-box-sortables ui-sortable">
                  <div id="tblog1" class="postbox if-js-closed" >
                  <h3 class=\'hndle\'>
                     <span>
                        SUPPORT <span style="font-size: xx-small">(Thisis where YOU seek Help)</span>
                     </span>
                  </h3>
                  <div class="inside">
                     <div class="table">
                        <table class="widefat">
                           <tr><td><iframe src="http://c0nan.net/support/" width=100% height=600px /></td></tr>
                        </table>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
            </div>
         </div>
         ');
      }

?>