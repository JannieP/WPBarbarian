<?php

   function formTitle1(){
      print('  
        <div class="wrap" id="tb_options_page">
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2>Wordpress Barbarian Level 1 Options</h2>
        <span style="font-size: medium">Incorrect USE of this Plugin Will Most likely result in your twitter account being suspended, OR your IP being blocked <br> (Use of this Plugin is at own risk.)</span>
      ');
   }
   
   function formContent1(){
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
          <div id="tb_barbarian1_config" class="postbox if-js-closed" >
            <h3 class=\'hndle\'>
              <span>
                ' . __('Barbarian Level1 Config', 'wp-barbarian') . '<br>
                <span style="font-size: xx-small">(' . __('This is where the fun starts.', 'wp-barbarian') . ')</span>
              </span>
            </h3>
            <div class="inside">
              <h4>' . __('Words:', 'wp-barbarian') . '</h4>
              <div class="table">
                <table class="widefat">
                  <tbody>
                    <tr>
                      <td width="30%"><label for="tb_l1_use_post_title">Use Post Title as Search</label></td>
                      <td width="30%"><select id="tb_l1_use_post_title" name="tb_l1_use_post_title">' . $l1_use_post_title_options . '</td>
                      <td><span style="font-size: xx-small">Could result in un expected results</span></td></tr>
                    <tr>
                      <td width="30%"><label for="tb_l1_and">All of these words</label></td>
                      <td width="30%"><input type="text" size="25" name="tb_l1_and" id="tb_l1_and" value="' . esc_attr($tb->l1_and) . '" autocomplete="off"></td>
                      <td><span style="font-size: xx-small">(All of these words)</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_phrase">This exact phrase</label></td>
                      <td><input type="text" size="25" name="tb_l1_phrase" id="tb_l1_phrase" value="' . esc_attr($tb->l1_phrase) . '" autocomplete="off"></td>
                      <td><span style="font-size: xx-small">(This exact phrase)</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_or">Any of these words</label></td>
                      <td><input type="text" size="25" name="tb_l1_or" id="tb_l1_or" value="' . esc_attr($tb->l1_or) . '" autocomplete="off"></td>
                      <td><span style="font-size: xx-small">(Any of these words)</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_not">None of these words</label></td>
                      <td><input type="text" size="25" name="tb_l1_not" id="tb_l1_not" value="' . esc_attr($tb->l1_not) . '" autocomplete="off"></td>
                      <td><span style="font-size: xx-small">(None of these words)</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_tag">This hashtag</label></td>
                      <td><input type="text" size="25" name="tb_l1_tag" id="tb_l1_tag" value="' . esc_attr($tb->l1_tag) . '" autocomplete="off"></td>
                      <td><span style="font-size: xx-small">(This hashtag)</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_rpp">Results</label></td>
                      <td><select id="tb_l1_rpp" name="tb_l1_rpp">' . $l1_rpp_options . '</td>
                      <td><span style="font-size: xx-small">(How many results do you want, To Much could cause your server php timeout to fire(Test what works for you))</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_only_once">Only Once Per Post</label></td>
                      <td><select id="tb_l1_only_once" name="tb_l1_only_once">' . $l1_only_once_options . '</td>
                      <td><span style="font-size: xx-small">(Only run this Barbaric Thing on first time a Post is published)</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_use_ght">Use Google Hot Trends</label></td>
                      <td><select id="tb_l1_use_ght" name="tb_l1_use_ght">' . $l1_use_ght_options . '</td>
                      <td><span style="font-size: xx-small">(Sticks a Google Hot Trend in the middle of the text to obfucate the footprint)</span></td></tr>
                    <tr>
                      <td><label for="tb_l1_uselinkinter">Link Interval</label></td>
                      <td><select id="tb_l1_uselinkinter" name="tb_l1_uselinkinter">' . $l1_uselinkinter_options . '</td>
                      <td><span style="font-size: xx-small">(Adds you link to the @ tweet interval (0 = No Links, let then check my twitter profile; 1 = All, go bokers and stick the link in every @post))</span></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      ');
   }
?>
