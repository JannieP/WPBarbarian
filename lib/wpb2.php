<?php

   function formTitle2(){
     print('  
      <div class="wrap" id="tb_options_page">
      <div id="icon-options-general" class="icon32"><br /></div>
      <h2>Wordpress Barbarian Level 2 Options</h2>
      <span style="font-size: medium">Incorrect USE of this Plugin Will Most likely result in your twitter account being suspended, OR your IP being blocked <br> (Use of this Plugin is at own risk.)</span>
    ');
   }
   function formContent2(){
   global $tb;

   $yes_no = array('do_post', 'do_barbarian_1', 'do_barbarian_2', 'do_barbarian_3', 'use_api', 'keep_logs', 'use_proxies', 'l1_only_once', 'l2_only_once', 'l1_use_ght', 'l2_use_ght', 'simulate', 'l1_use_post_title', 'l3_rq_tw', 'l3_rq_fb', 'l3_rq_st', 'l3_rq_gl', 'l3_tw_use_title', 'l3_bh', 'l3_allways', 'l3_use_other_url');
   
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
          <div id="tb_barbarian2_config" class="postbox if-js-closed" >
            <h3 class=\'hndle\'>
              <span>
                ' . __('Barbarian Level2 Config', 'wp-barbarian') . '<br>
                <span style="font-size: xx-small">(' . __('The fun just gets better and better.', 'wp-barbarian') . ')</span>
              </span>
            </h3>
            <div class="inside">
              <h4>' . __('Trends:', 'wp-barbarian') . '</h4>
              <div class="table">
                <table class="widefat">
                  <tbody>
                    <tr>
                      <td width="30%"><label for="tb_l2_interval">Interval(Hours)</label></td>
                      <td><select id="tb_l2_interval" name="tb_l2_interval">' . $l2_interval_options . '</td>
                      <td><span style="font-size: xx-small">(It is very important that you do NOT make this value to low, as this can get your Twitter account suspended. (Default=6 hours)(0=No Interval))</span></td></tr>
                    <tr>
                      <td width="30%"><label for="tb_l2_only_once">Only Once Per Post</label></td>
                      <td><select id="tb_l2_only_once" name="tb_l2_only_once">' . $l2_only_once_options . '</td>
                      <td><span style="font-size: xx-small">(Just as important dont over do it, just go to the post and republish it. This can get your Twitter account suspended aswell. (Default=Yes))</span></td></tr>
                    <tr>
                      <td><label for="tb_l2_use_ght">Use Google Hot Trends</label></td>
                      <td><select id="tb_l2_use_ght" name="tb_l2_use_ght">' . $l2_use_ght_options . '</td>
                      <td><span style="font-size: xx-small">(Uses Google Hot Trends in the tweets to minimise the footprint.(Default=Yes))</span></td></tr>
                    <tr>
                      <td><label for="tb_l2_tpi">Trends Per Interval</label></td>
                      <td><select id="tb_l2_tpi" name="tb_l2_tpi">' . $l2_tpi_options . '</td>
                      <td><span style="font-size: xx-small">(How many Trends should be tweeted per interval.)</span></td></tr>
                    <tr>
                      <td><label for="tb_l2_tpt">Trends Per Tweet</label></td>
                      <td><select id="tb_l2_tpt" name="tb_l2_tpt">' . $l2_tpt_options . '</td>
                      <td><span style="font-size: xx-small">(How many Trends should be added per tweet(140 chars limit))</span></td></tr>
                    <tr>
                      <td><label for="tb_l2_uselinkinter">Link Interval</label></td>
                      <td><select id="tb_l2_uselinkinter" name="tb_l2_uselinkinter">' . $l2_uselinkinter_options . '</td>
                      <td><span style="font-size: xx-small">(Adds you link to the trends tweet interval(0 = None; 1 = All))</span></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
     ');
   }
?>
