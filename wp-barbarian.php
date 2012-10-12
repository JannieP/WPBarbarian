<?php
  /*
   Plugin Name: WP Barbarian
   Plugin URI: http://c0nan.net/wpbarbarian
   Description: A Great integration between your WordPress blog and Twitter, with some barbaric twists added for more efficacy
   Version: 2.0
   Author: c0nan
   Author URI: http://c0nan.net
   */
  
   define('TB_VERSION', '2.1');
   define('TB_DB', '1');
   define('TB_URI', 'http://c0nan.net');
   define('TB_API_POST_STATUS', 'http://twitter.com/statuses/update.json');
   
   if (!defined('PLUGINDIR')) {
         define('PLUGINDIR', 'wp-content/plugins');
   }

   define('TB_FILE', trailingslashit(ABSPATH . PLUGINDIR) . 'wp-barbarian/wp-barbarian.php');
   include_once trailingslashit(ABSPATH . PLUGINDIR).'wp-barbarian/lib/wpb0.php';
   include_once trailingslashit(ABSPATH . PLUGINDIR).'wp-barbarian/lib/wpb1.php';
   include_once trailingslashit(ABSPATH . PLUGINDIR).'wp-barbarian/lib/wpb2.php';
   include_once trailingslashit(ABSPATH . PLUGINDIR).'wp-barbarian/lib/wpb3.php';
   include_once trailingslashit(ABSPATH . PLUGINDIR).'wp-barbarian/lib/twitteroauth.php';
   include_once trailingslashit(ABSPATH . PLUGINDIR).'wp-barbarian/lib/wpboauth.php';
  
  function tb_install(){
      $tb_install = new wp_barbarian;
      foreach ($tb_install->options as $option) {
          add_option('tb_' . $option, $tb_install->$option);
      }
      update_option('tb_message', 'Activated:');
  }
  register_activation_hook(__FILE__, 'tb_install');

  function tb_deactivate() {
  //  if (get_option('tb_keep') != '1'){
  //    $tb_install = new wp_barbarian;
  //    foreach ($tb_install->options as $option) {
  //      delete_option('tb_'.$option);
  //    }
  //  }
  }
  //register_deactivation_hook(__FILE__, 'tb_deactivate');
  
  function tb_menu_items(){
      if (current_user_can('manage_options')) {
          add_menu_page('WP Barbarian', 'WP Barbarian', 10, 'wp-barbarian', 'tb_options_form');
          if (c0nan_oauth_test()){
            add_submenu_page('wp-barbarian','Options','Options', 10, 'wp-barbarian', 'tb_options_form');
            add_submenu_page('wp-barbarian', 'WPB Level1','WPB Level1', 10, 'wp-b1', 'tb_l1_form');
            add_submenu_page('wp-barbarian', 'WPB Level2','WPB Level2', 10, 'wp-b2', 'tb_l2_form');
            add_submenu_page('wp-barbarian', 'WPB Level3','WPB Level3', 10, 'wp-b3', 'tb_l3_form');
            add_submenu_page('wp-barbarian', 'WPB Level3 Test','WPB Level3 Test', 10, 'wp-b3-test', 'tb_b3_testpage');
         }else{
            add_submenu_page('wp-barbarian','Registration','Registration', 10, 'wp-barbarian', 'tb_options_form');
         }
         add_submenu_page('wp-barbarian', 'WPB Support','WPB Support', 10, 'wp-support', 'tb_support');
         add_submenu_page('wp-barbarian', 'WPB Logs','WPB Logs', 10, 'wp-logs', 'tb_logs');
      }
  }
  add_action('admin_menu', 'tb_menu_items');
  
  function tb_store_post_options($post_id, $post = false){
      global $tb;
      $post = get_post($post_id);
      if (!$post || $post->post_type == 'revision') {
          return;
      }
      
      $notify_meta = get_post_meta($post_id, 'tb_notify_twitter', true);
      $posted_meta = $_POST['tb_notify_twitter'];
      
      $save = false;
      if (!empty($posted_meta)) {
          $meta = 'yes';
          $save = true;
      } elseif (empty($notify_meta)) {
          $meta = 'yes';
          $save = true;
      }
      
      if ($save) {
          update_post_meta($post_id, 'tb_notify_twitter', $meta);
      }
  }
  add_action('draft_post', 'tb_store_post_options', 1, 2);
  add_action('publish_post', 'tb_store_post_options', 1, 2);
  add_action('save_post', 'tb_store_post_options', 1, 2);
  
  function tb_plugin_action_links($links, $file){
      $plugin_file = basename(__FILE__);
      if (basename($file) == $plugin_file) {
          $settings_link = '<a href="options-general.php?page=' . $plugin_file . '">' . __('Settings', 'wp-barbarian') . '</a>';
          array_unshift($links, $settings_link);
      }
      return $links;
  }
  add_filter('plugin_action_links', 'tb_plugin_action_links', 10, 2);
  
  function trim_value(&$value){
      $value = trim($value);
  }
  
  function tb_wpb($post_id){
      global $tb;
      $tb->setProxy();
      if ($tb->do_post == '1' && $post_id != 0 && get_post_meta($post_id, 'tb_tweeted', true) != '1') {
          $tb->do_blog_post_tweet($post_id);
      }
      if ($tb->do_barbarian_1 == '1' && $post_id != 0 && ($tb->l1_only_once != 1 || get_post_meta($post_id, 'tb_barbarian1', true) != '1')) {
          $tb->do_barbarian_1($post_id);
      }
      if ($tb->do_barbarian_2 == '1' && $post_id != 0 && ($tb->l2_only_once != 1 || get_post_meta($post_id, 'tb_barbarian2', true) != '1')) {
          $tb->do_barbarian_2($post_id);
      }
  }
  add_action('publish_post', 'tb_wpb', 99);
  
  function tb_init(){
      global $tb;
      $tb = new wp_barbarian;
      $tb->get_settings();
      if (is_admin()) {
          global $wp_version;
          $update = false;
          if (isset($wp_version) && version_compare($wp_version, '2.5', '>=') && empty($tb->install_date)) {
              $update = true;
          }
          
          $installed_version = get_option('tb_installed_version');
          if ($installed_version != TB_VERSION) {
              $update = true;
          } elseif ($update) {
              add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please update your <a href="%s">WP Barbarian settings</a>', 'wp-barbarian'), admin_url('options-general.php?page=wp-barbarian')) . "</p></div>';"));
          }
          if (!checkversion()){
             add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>WP Barbarian - New Release Available, Please Update</p></div>';"));
          }
      }
      if ($tb->do_barbarian_3 == '1') {
            add_action('wp_footer', 'tb_b3_form');
      }
  }
  add_action('init', 'tb_init');

  function checkversion(){
     return false;
  }
  
  function tb_request_handler(){
      global $tb;
      if (!empty($_GET['tb_action'])) {
          switch ($_GET['tb_action']) {
              case 'tb_reset_log':
                  update_option('tb_message', '');
                  $tb->message = '';
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'tb_test_l1':
                  tb_log('Barbarian L1 Test');
                  $tb->barbarian_1_test();
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'tb_test_l2':
                  tb_log('Barbarian L2 Test');
                  $tb->barbarian_2_test();
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'tb_test_twitter':
                  tb_log('Twitter Test');
                  $tb->tweet_test();
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'tb_test_ght':
                  tb_log('Google Hot Trends Test');
                  $tb->ght_test();
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'tb_test_pr':
                  tb_log('Proxies Test');
                  $tb->pr_test();
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'tb_test_cr8':
                  tb_log('URL Shortner Test');
                  $url = "http://c0nan.net/";
                  tb_log($url.'->'.tb_bitly_shorten_url($url));
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'addTwitter':
                  $tb->addtw();
                  $gets = newTwAcc();
                  if ($gets == 'success') {
                      $tb->savetw();
                      $gets = '&oauth=' . $gets;
                      wp_redirect(admin_url('options-general.php?page=wp-barbarian' . $gets));
                  }
                  tb_db('1:Account Processed');
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'oauthc0nan':
                  tb_log('c0nan Authorize');
                  c0nan_oauth_Authorize();
                  $tb->update_settings();
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'deleteTwitter':
                  if (!empty($_GET['acc'])) {
                      $tb->deltw($_GET['acc']);
                      wp_redirect(admin_url('options-general.php?page=wp-barbarian' . $gets));
                      tb_db('2:Account Deleted:' . $_GET['acc']);
                  } else {
                      tb_db('3:Account Delete Failed:' . $_GET['acc']);
                  }
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
              case 'deleteC0nan':
                  tb_log('c0nan Delete');
                  c0nan_oauth_delete();
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian'));
                  break;
          }
      }
      if (!empty($_POST['tb_action'])) {
          switch ($_POST['tb_action']) {
              case 'tb_update_settings':
                  if (!wp_verify_nonce($_POST['_wpnonce'], 'tb_settings')) {
                      wp_die('Oops, please try again.');
                  }
                  $tb->populate_settings();
                  $tb->update_settings();
                  $gets = '&tb_updated=true';
                  wp_redirect(admin_url('options-general.php?page=wp-barbarian' . $gets));
                  die();
                  break;
          }
      }
  }
  add_action('init', 'tb_request_handler', 10);
 
  function tb_options_form(){
      tb_formhandler(0);
  }
  function tb_l1_form(){
      tb_formhandler(1);
  }
  function tb_l2_form(){
      tb_formhandler(2);
  }
  function tb_l3_form(){
      tb_formhandler(3);
  }
  function tb_logs(){
      logContent();      
  }
  
  function tb_formhandler($handler = 0){
      global $tb;
      
      if (strcmp($_GET['c0nanoauth'], "success") == 0) {
          print('
        <div id="message" class="updated fade">
          <p>We are connected with c0nan.</p>
        </div>

      ');
      } elseif (strcmp($_GET['c0nanoauth'], "fail") == 0) {
          print('
        <div id="message" class="updated fade">
          <p>Authentication Failed. Please check your credentials and make sure <a href="http://c0nan.net/wpbarbarian/api/test" title="WP Barbarian" target="_blank">WP Barbarian API</a> is up and running.</p>
        </div>

      ');
      }

      if (strcmp($_GET['oauth'], "success") == 0) {
          print('
        <div id="message" class="updated fade">
          <p>We are connected with Twitter.</p>
        </div>

      ');
      } elseif (strcmp($_GET['oauth'], "fail") == 0) {
          print('
        <div id="message" class="updated fade">
          <p>Authentication Failed. Please check your credentials and make sure <a href="http://www.twitter.com/" title="Twitter" target="_blank">Twitter</a> is up and running.</p>
        </div>

      ');
      }

      if (strcmp($_GET['tb_updated'], "true") == 0) {
          print('
        <div id="message" class="updated fade">
          <p>Wordpress Barbarian Options Updated.</p>
        </div>

      ');
      }
      
      if (!c0nan_oauth_test()) {
         c0nanregister();
      }else{   

      $titleFnc = 'formTitle'.$handler;
      call_user_func($titleFnc);

      ?>
         <script type="text/javascript">
           function wpbConfirm(msg){
               var answer = confirm(msg);
               if (answer)
                  return true;
               else
                  return false;
           }
           function doCustomSubmitForm(theget){
               document.forms["tb_wpbarbarian1"].action=document.forms["tb_wpbarbarian1"].action + '?page=wp-barbarian' + theget;
               document.forms["tb_wpbarbarian1"].submit();
           }
         </script>
      <?php

      print('
         <form id="tb_wpbarbarian1" name="tb_wpbarbarian1" action="' . admin_url('options-general.php') . '" method="post">
            <p class="submit">
              <input type="submit" name="save_all" class="button-primary" value="Save Options" />
            </p>
            <fieldset class="options">
              <div id="dashboard-widgets-wrap">
                <div id="dashboard-widgets" class="metabox-holder">
                  <div id="postbox-container" style="width:75%; float:left;">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">
      ');

      $contentFnc = 'formContent'.$handler;
      call_user_func($contentFnc);

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

      testContent();
      supportContent();

      print('
             </div>
           </div>
         </div>
       </div>
      ');
      }
      siteContent();
      do_action('tb_options_form');
   }
  
   function tb_b3_form($content = ''){
      global $tb, $wp_query;
      $tb = new wp_barbarian;
      $tb->get_settings();
      if (1 == 1){//}($_GET['tb_l3'] == '1') || ($tb->allways == '1' && $_GET['tb_l3'] != '2')){ 
         loadwpbPOP($post);
      }
   }

   function tb_b3_testpage(){
       $_GET['tb_l3'] = '1';
       $_GET['tb_l3_t'] = '1';
       print('<div class="wpbtp"></div>');
       tb_b3_form();
   }
  
   function tb_log($val=''){
       if (get_option('tb_keep_logs') == '1') {
           update_option('tb_message', get_option('tb_message') . '<br>' . time() .'->' . $val);
       }
   }

   function tb_db($val=''){
       global $tb;
       if ($tb->db == '1') {
           update_option('tb_message', get_option('tb_message') . '<br>'. time() .'->' . $val);
       }
   }

   function tb_e($val=''){
      tb_db('4:'.$val);
      echo'<br>->';
      if(is_array($val)){
         print_r($val);
      }else{
         echo $val;
      }
      echo'<-<br>';
   }
                  
   function c0nan_oauth_Authorize($token=''){
      global $tb;
      $to = new c0nanOAuth ( $tb->c0nan_oauth_consumer_key, $tb->c0nan_oauth_consumer_secret );
      $tok = $to->getRequestToken ();
      $tb->c0nan_oauth_token = $tok ['oauth_token'];
      $tb->c0nan_oauth_token_secret = $tok ['oauth_token_secret'];
      $request_link = $to->getAuthorizeURL ( $token, '' );
      tb_db('5:'.$request_link);
      $response = $to->get($request_link);
      tb_db('6:<textarea>'.$response.'</textarea>');
      $tb->c0nan_oauth_hash = c0nan_oauth_credentials_to_hash();
   }

   function c0nan_oauth_delete(){
      global $tb;
      $tb->c0nan_oauth_hash = '';
      update_option('tb_c0nan_oauth_hash','');
   }

   function tb_oauth_test(){
       global $tb;
       return(tb_oauth_credentials_to_hash() == $tb->oauth_hash);
   }

   function c0nan_oauth_test(){
       global $tb;
       return(true);//c0nan_oauth_credentials_to_hash() == $tb->c0nan_oauth_hash);
   }

   function tb_oauth_credentials_to_hash(){
       global $tb;
       $hash = md5($tb->app_consumer_key . $tb->app_consumer_secret . $tb->oauth_token . $tb->oauth_token_secret);
       return $hash;
   }
   
   function c0nan_oauth_credentials_to_hash(){
       global $tb;
       $hash = md5($tb->c0nan_oauth_consumer_key . $tb->c0nan_oauth_consumer_secret . $tb->c0nan_oauth_token . $tb->c0nan_oauth_token_secret);
       return $hash;
   }

   function tb_oauth_connection(){
       global $tb;
       tb_db('7:getconnection:' . $tb->app_consumer_key . ';' . $tb->app_consumer_secret . ';' . $tb->oauth_token . ';' . $tb->oauth_token_secret);
       if (!empty($tb->app_consumer_key) && !empty($tb->app_consumer_secret) && !empty($tb->oauth_token) && !empty($tb->oauth_token_secret)) {
           $connection = new TwitterOAuth($tb->app_consumer_key, $tb->app_consumer_secret, $tb->oauth_token, $tb->oauth_token_secret);
           $connection->useragent = 'WP Barbarian http://c0nan.net';
           tb_db('8:Adding Proxy To Connection:' . $tb->proxy);
           $connection->proxy = $tb->proxy;
           return $connection;
       } else {
           return false;
       }
   }

   function tb_bitly_shorten_url($url){
       if (get_option('tb_l3_allways') == '0') {
           if(strpos($url,'tb_l3=1')==0){
               if(strpos($url,'?')){
                  $url .= '&tb_l3=1';
               }else{
                  $url .= '?tb_l3=1';
               }
               tb_db('9:Ammended URL:' . $url);
           }
       }
       if (get_option('tb_use_api') == '1') {
           if(get_option('tb_api_hash')=='1'){
              if(strpos($url,'?')){
                 $url .= '&wpbhash='.md5(time());
              }else{
                 $url .= '?wpbhash='.md5(time());
              }
              tb_db('10:Hashed URL:' . $url);
           }
           $parts = parse_url($url);
           $api_url = 'http://api.bit.ly/shorten';
           
           $api = $api_url . '?version=' . '2.0.1' . '&longUrl=' . urlencode($url);
           $login = get_option('tb_api_user');
           $key = get_option('tb_api_key');
           if (!empty($login) && !empty($key)) {
               $api .= '&login=' . urlencode($login) . '&apiKey=' . urlencode($key) . '&history=1';
           }
           
           $result =  tb_shorten_action($api);
           $result = json_decode($result);
           if (!empty($result->results->{$url}->shortUrl)) {
               $url = $result->results->{$url}->shortUrl;
           }
       }else{
          $url = tb_cr8be_shorten_url($url);
       }
       return $url;
   }
   add_filter('tweet_blog_post_url', 'tb_bitly_shorten_url');
                  
   function tb_cr8be_shorten_url($url){
      tb_db('11:Using cr8.be:' . $url);
      if(get_option('tb_api_hash')=='1'){
         if(strpos($url,'?')){
            $url .= '&wpbhash='.md5(time());
         }else{
            $url .= '?wpbhash='.md5(time());
         }
         tb_db('12:Hashed URL:' . $url);
      }
      $parts = parse_url($url);
      $api_url = 'http://cr8.be/yourls-api.php';

      $api = $api_url . '?signature=' . '6953b9e9a5' . '&action=shorturl' . '&format=simple' . '&url=' . urlencode($url);
      
      tb_db('13:api:' . $api);
      $url = tb_shorten_action($api);
      return $url;
   }

   function tb_shorten_action($api){
      $s = curl_init();
      curl_setopt($s, CURLOPT_USERAGENT, 'WP Barbarian http://c0nan.net');
      curl_setopt($s, CURLOPT_URL, $api);
      curl_setopt($s, CURLOPT_HEADER, false);
      curl_setopt($s, CURLOPT_RETURNTRANSFER, 1);

//curl_setopt ( $s, CURLOPT_HTTPPROXYTUNNEL, 1 );
//curl_setopt ( $s, CURLOPT_PROXY, "1.1.1.1:8080" );
//curl_setopt ( $s, CURLOPT_PROXYUSERPWD,"usr:pwd" );

      $result = curl_exec($s);
      curl_close($s);
      return $result;
   }

   function tb_bitly_shorten_tweet($tweet){
       tb_db('14:Using shortner:');
       if (strpos($tweet->tw_text, 'http') !== false) {
           preg_match_all('$\b(https?|ftp|file)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[-A-Z0-9+&@#/%=~_|]$i', $test, $urls);
           if (isset($urls[0]) && count($urls[0])) {
               foreach ($urls[0] as $url) {
                   if (in_array(substr($url, -1), array('.', ',', ';', ':', ')')) === true) {
                       $url = substr($url, 0, strlen($url) - 1);
                   }
                   $tweet->tw_text = str_replace($url, tb_bitly_shorten_url($url), $tweet->tw_text);
               }
           }
       }
       return $tweet;
   }
   add_filter('tb_do_bitly', 'tb_bitly_shorten_tweet');

   function tb_support(){
      addSupportPanel();
   }

?>
