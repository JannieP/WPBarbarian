<?php 

   function formTitle3(){
    print('  
      <div class="wrap" id="tb_options_page">
      <div id="icon-options-general" class="icon32"><br /></div>
      <h2>Wordpress Barbarian Level3 Options</h2>
      <span style="font-size: medium">Incorrect USE of this Plugin Will Most likely result in your twitter account being suspended, OR your IP being blocked <br> (Use of this Plugin is at own risk.)</span>
    ');
   }
   function formContent3(){
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
   
      ?>
       <div id="tb_barbarian3_config" class="postbox if-js-closed" >
         <h3 class=\'hndle\'>
           <span>Barbarian Level3 Config<br>
             <span style="font-size: xx-small">(Now Ask for some Mercy...)</span>
           </span>
         </h3>
         <div class="inside">
           <h4>Going Viral:</h4>
           <div class="table">
             <table class="widefat">
               <tbody>
                 <tr>
                   <td width="30%"><label for="tb_l3_allways">Display on All pageviews</label></td>
                   <td><select id="tb_l3_allways" name="tb_l3_allways"><?php echo $l3_allways_options;?></td>
                   <td><span style="font-size: xx-small">(Display this popup on every pageview, default is only from refered links)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_rq_tw">Ask for a Tweet</label></td>
                   <td><select id="tb_l3_rq_tw" name="tb_l3_rq_tw"><?php echo $l3_rq_tw_options;?></td>
                   <td><span style="font-size: xx-small">(Ask the visitor to tweet the page)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_rq_fb">Ask for a Like</label></td>
                   <td><select id="tb_l3_rq_fb" name="tb_l3_rq_fb"><?php echo $l3_rq_fb_options;?></td>
                   <td><span style="font-size: xx-small">(Ask the visitor to like the page)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_rq_st">Ask for a Stumble</label></td>
                   <td><select id="tb_l3_rq_st" name="tb_l3_rq_st"><?php echo $l3_rq_st_options;?></td>
                   <td><span style="font-size: xx-small">(Ask the visitor to add the page to stuble upon)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_rq_gl">Ask for a Google Plus One</label></td>
                   <td><select id="tb_l3_rq_gl" name="tb_l3_rq_gl"><?php echo $l3_rq_gl_options;?></td>
                   <td><span style="font-size: xx-small">(Ask the visitor to pluse one the page on google)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_tw_use_title">Use post Title to Tweet</label></td>
                   <td><select id="tb_l3_tw_use_title" name="tb_l3_tw_use_title"><?php echo $l3_tw_use_title_options;?></td>
                   <td><span style="font-size: xx-small">(This will ignore the next setting and add the post title as text to tweet.)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_tw_txt">Text to Tweet</label></td>
                   <td><input type="text" size="25" name="tb_l3_tw_txt" id="tb_l3_tw_txt" value="<?php echo esc_attr($tb->l3_tw_txt);?>" autocomplete="off"></td>
                   <td><span style="font-size: xx-small">(Suggested Text for visitor to tweet)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_title">Display Title</label></td>
                   <td><input type="text" size="25" name="tb_l3_title" id="tb_l3_title" value="<?php echo esc_attr($tb->l3_title);?>" autocomplete="off"></td>
                   <td><span style="font-size: xx-small">(Title for The Popup)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_display_message">Display Text</label></td>
                   <td><textarea name="tb_l3_display_message" id="tb_l3_display_message"><?php echo esc_attr($tb->l3_display_message);?></textarea></td>
                   <td><span style="font-size: xx-small">(Text for the Popup, DO NOT PUT in SCRIPT STUF, you WILL Break YOUR PAGE)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_bg_color">Background Color</label></td>
                   <td><input type="text" size="10" name="tb_l3_bg_color" id="tb_l3_bg_color" value="<?php echo esc_attr($tb->l3_bg_color);?>" autocomplete="off"></td>
                   <td><span style="font-size: xx-small">(Popup Background Color<br>Go <a href="http://www.w3schools.com/tags/ref_colorpicker.asp" target="_blank">HERE</a> for a color picker)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_close_color">Close Text Color</label></td>
                   <td><input type="text" size="10" name="tb_l3_close_color" id="tb_l3_close_color" value="<?php echo esc_attr($tb->l3_close_color);?>" autocomplete="off"></td>
                   <td><span style="font-size: xx-small">(Close link Color<br>Go <a href="http://www.w3schools.com/tags/ref_colorpicker.asp" target="_blank">HERE</a> for a color picker)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_title_color">Title Color</label></td>
                   <td><input type="text" size="10" name="tb_l3_title_color" id="tb_l3_title_color" value="<?php echo esc_attr($tb->l3_title_color);?>" autocomplete="off"></td>
                   <td><span style="font-size: xx-small">(Popup Title Color<br>Go <a href="http://www.w3schools.com/tags/ref_colorpicker.asp" target="_blank">HERE</a> for a color picker)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_display_effect">Display Effect</label></td>
                   <td><select id="tb_l3_display_effect" name="tb_l3_display_effect"><?php echo $l3_display_effect_options;?></td>
                   <td><span style="font-size: xx-small">(Popup - Standard DIV popup<br>Lightbox - Fades out the Page then shows popup)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_use_other_url">Promote Other URL</label></td>
                   <td><select id="tb_l3_use_other_url" name="tb_l3_use_other_url"><?php echo $l3_use_other_url_options;?></td>
                   <td><span style="font-size: xx-small">(Sneeky, when visitors click on the button, rather promote a different URL, then the current page. (Does NOT work with stumble YET))</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_other_url">Other URL</label></td>
                   <td><input type="text" size="25" name="tb_l3_other_url" id="tb_l3_other_url" value="<?php echo esc_attr($tb->l3_other_url);?>" autocomplete="off"></td>
                   <td><span style="font-size: xx-small">(Supply the URL her to promote, It is up to you for correctness, URL validator to be added later.)</span></td></tr>
                 <tr>
                   <td width="30%"><label for="tb_l3_bh">Add a FB blackhat Twist</label></td>
                   <td><select id="tb_l3_bh" name="tb_l3_bh"><?php echo $l3_bh_options;?></td>
                   <td><span style="font-size: xx-small">(Ads a hidden FB like button under the mouse, and above the. Use at own risk.)</span></td></tr>
               </tbody>
             </table>
           </div>
         </div>
       </div>
      <?php
   }

   function loadwpbPOP($post=''){
      global $tb;
      $post_id = $post->ID;
      if ($_GET['tb_l3_t'] == '1'){ 
         $url = 'http://c0nan.net';
      }else{
         $url = wpbcurPageURL();
      }
      loadPopStyle3();
      if ($tb->l3_bh == '1') {
         loadBH3();
      }
      loadPopupContent3($url);
      loadPopupScript3();
      if ($tb->l3_bh == '1') {
         loadFollowScript3();
      }
   }   

   function wpbcurPageURL() {
      $pageURL = 'http';
      if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
      $pageURL .= "://";
      if ($_SERVER["SERVER_PORT"] != "80") {
         $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
      } else {
         $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
      }
      return $pageURL;
   }

   function loadPopStyle3(){
    ?>

    <style>
      /* container for closelink */
      .wps_closewin_text {float:right;padding:5px;}
      .wps_closewin_text a{text-decoration:underline;font-size:small;}
      .wps_closewin_text a:hover{}
      /* container for content */
      .wps_content {border:thin dotted black;padding:3mm;} 
      .wps_body{padding:10px;}
      .wps_popup {border:thin solid #000000;}
      /* container for headline */
      .wps_headline {margin:0px 10px;clear:both;}
      .wps_headline h2{}
    </style>

    <?php
   }
   
   function loadBH3(){
      ?>
         <div id="fb-root"></div>
         <script>
            function tb_relocate(){
              window.location = "<?php echo admin_url('options-general.php') . '?tb_l3=2';?>";
            }
            window.fbAsyncInit = function() {
               FB.Event.subscribe('comment.create',
                  function (response) {
                     window.location = "<?php echo admin_url('options-general.php') . '?tb_l3=2';?>";
                  });
               FB.Event.subscribe('comments.remove',
                  function (response) {
                     window.location = "<?php echo admin_url('options-general.php') . '?tb_l3=2';?>";
                  });
            };
            (function() {
              var e = document.createElement('script');
              e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js#appId=202916159753728&amp;xfbml=1';
              e.async = true;
              document.getElementById('fb-root').appendChild(e);
            }());
         </script>
      <?php
   }
   
   function loadPopupContent3($url=''){
      global $tb;
      tb_db($url);
      if ($tb->l3_use_other_url == '1' && $tb->l3_other_url != '') {
         $url =  $tb->l3_other_url;
      } else {
         $url =  $url;
      }
      ?>
          <div id="tb_preview" class="wps_popup" style="margin:auto;z-index:100;position:absolute;left:0px;top:-400px;visibility:hidden"></div> 
          <div id="lightbox_div" style="overflow:auto;width:100%;background-color:#000000;z-index:50;position:absolute;left:0px;top:0px;visibility:hidden"></div>
          <div id="tb_tw_div" style="margin:auto;z-index:100;position:absolute;left:0px;top:-400px;visibility:hidden">
            <span style="float:left">
               <a href="http://twitter.com/share" 
                  class="twitter-share-button" 
                  data-url="<?php echo urlencode(tb_bitly_shorten_url($url));?>" 
                  data-text="<?php echo $tb->b3_twt_txt;?>" 
                  data-count="horizontal" 
                  data-via="<?php echo $tb->b3_tweep;?>">Tweet</a>
               <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </span>
         </div> 

         <div id="tb_fb_div" style="margin:auto;z-index:100;position:absolute;left:0px;top:-400px;visibility:hidden">
            <span style="float:left">
               <iframe src="http://www.facebook.com/plugins/like.php?app_id=177348815654091&amp;href=<?php echo urlencode(tb_bitly_shorten_url($url));?>&amp;send=true&amp;layout=standard&amp;width=50&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=30" 
                       scrolling="no" 
                       frameborder="1" 
                       style="border:none; overflow:hidden; width:50px; height:30px;" 
                       allowTransparency="true"></iframe>
            </span>
         </div> 

         <div id="tb_st_div" style="margin:auto;z-index:100;position:absolute;left:0px;top:-400px;visibility:hidden">
            <span style="float:left">
               <iframe src="http://www.stumbleupon.com/badge/embed/1/?url=<?php echo urlencode(tb_bitly_shorten_url($url));?>" 
                       style="border: medium none; overflow: hidden; width: 74px; height: 18px;" 
                       allowtransparency="true" 
                       frameborder="0" 
                       scrolling="no"></iframe>
            </span>
         </div>

         <div id="tb_gl_div" style="margin:auto;z-index:100;position:absolute;left:0px;top:-400px;visibility:hidden">
            <span style="float:left">
               <?php //<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script> ?>
               <?php //<g:plusone size="medium" count="false" callback="tb_relocate" href="<?php if ($tb->tb_l3_use_other_url == '1' && $tb->tb_l3_other_url != '') {echo urlencode(($tb->tb_l3_other_url));} else {echo urlencode(($url));}?><?php//"></g:plusone>?>
               <iframe src="https://plusone.google.com/u/0/_/+1/button?hl=en-US&amp;jsh=r%3Bgc%2F22203364-e7648d15#url=<?php echo urlencode(tb_bitly_shorten_url($url));?>&amp;size=medium&amp;count=false&amp;useSharedProxy=true&amp;rcache=true&amp;scache=true&amp;id=I2_1309952553641&amp;parent=<?php echo urlencode(tb_bitly_shorten_url($url));?>&amp;rpctoken=7091448&amp;_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe" 
                        style="border:none; overflow:hidden; width: 32px; height: 20px;" 
                        allowtransparency="true"
                        frameborder="0" 
                        scrolling="no"> </iframe>
            </span>
         </div>
      <?php   
   }

   function loadPopupScript3(){
      global $tb;
    ?>
      <script language=javascript>
         function tb_popupLeftPosition(popup_width){
            var myWidth = 0, outputWidth;
            if( typeof( window.innerWidth ) == 'number' ) {
               myWidth = window.innerWidth;
            } else if( document.documentElement && ( document.documentElement.clientWidth) ) {
               myWidth = document.documentElement.clientWidth;
            } else if( document.body && ( document.body.clientWidth) ) {
               myWidth = document.body.clientWidth;
            }
            outputWidth = (myWidth / 2) - (popup_width / 2);
            outputWidth = outputWidth ;
            return outputWidth;
         }
         function tb_popupTopPosition(){
            var outputHeight, myHeight = 0;
            if( typeof( window.innerHeight ) == 'number' ) {
               myHeight = window.innerHeight;
            } else if( document.documentElement && (document.documentElement.clientHeight ) ) {
               myHeight = document.documentElement.clientHeight;
            } else if( document.body && ( document.body.clientHeight ) ) {
               myHeight = document.body.clientHeight;
            }
            outputHeight = (myHeight / 2) - 50;
            outputHeight = outputHeight;
            return outputHeight;
         }
         function tb_getPageHeight() {
            var pagescroll,  winHeight;;
            if (window.innerHeight && window.scrollMaxY) {  
               pagescroll = window.innerHeight + window.scrollMaxY;
            } else if (document.body.scrollHeight > document.body.offsetHeight){
               pagescroll = document.body.scrollHeight;
            } else {
               pagescroll = document.body.offsetHeight;
            }
            if (self.innerHeight) {
               winHeight = self.innerHeight;
            } else if (document.documentElement && document.documentElement.clientHeight) {
               winHeight = document.documentElement.clientHeight;
            } else if (document.body) { 
               windowHeight = document.body.clientHeight;
            }  
            if(pagescroll < winHeight){
               pageHeight = winHeight;
            } else { 
               pageHeight = pagescroll;
            }
            return pageHeight;
         }
         function tb_lightbox(target){
            if (target.style.MozOpacity!=null) {
               target.style.MozOpacity = 0.8;
            } else if (target.style.opacity!=null) {
               target.style.opacity = 0.8;
            } else if (target.style.filter!=null) {
              target.style.filter = "alpha(opacity=80)";
            }
            target.style.visibility = "visible";
         }
         function tb_preview_popup(){
            var closetext = '<span style="color:<?php echo $tb->l3_close_color;?>">Close</span>';
            var popup_title = '<span style="color:<?php echo $tb->l3_title_color;?>"><?php echo $tb->l3_title;?></span>';
            var effect = "<?php echo $tb->l3_display_effect;?>";
            var popup_text = "<?php echo $tb->l3_display_message;?>";  
            var headline_align = "center";
            var bg_color = "<?php echo $tb->l3_bg_color;?>";
            var popup_width = "400";
            var popup_position = "center";
            var popup_left = "";
            var promote_text_tw = <?php if ($tb->l3_rq_tw == '1') {?> document.getElementById('tb_tw_div').innerHTML <?php }else{ ?> '' <?php }?>;
            var promote_text_fb = <?php if ($tb->l3_rq_fb == '1') {?> document.getElementById('tb_fb_div').innerHTML <?php }else{ ?> '' <?php }?>;
            var promote_text_st = <?php if ($tb->l3_rq_st == '1') {?> document.getElementById('tb_st_div').innerHTML <?php }else{ ?> '' <?php }?>;
            var promote_text_gl = <?php if ($tb->l3_rq_gl == '1') {?> document.getElementById('tb_gl_div').innerHTML <?php }else{ ?> '' <?php }?>;
            popup_text += '<br><br><table><tr>';
            popup_text += '<td>'+promote_text_gl+'</td>';
            popup_text += '<td>'+promote_text_st+'</td>';
            popup_text += '<td>'+promote_text_tw+'</td>';
            popup_text += '<td>'+promote_text_fb+'</td>';
            popup_text += '</tr></table><br><br>';
            if(effect == "lightbox"){
               popup_content  = '<div class="wps_closewin_text" align="right"><br>'
               popup_content += '<a href="" onclick="document.getElementById(\'tb_preview\').style.visibility=\'hidden\';document.getElementById(\'lightbox_div\').style.visibility=\'hidden\';return false;">'+closetext+'</a>'
               popup_content += '<br><br></div>'
               popup_content += '<div class="wps_headline"><h2 align="'+headline_align+'">'+popup_title+'</h2><p>'+popup_text+'</p></div>';
            }else{
               popup_content  = '<div class="wps_closewin_text" align="right"><br>'
               popup_content += '<a href="" onclick="document.getElementById(\'tb_preview\').style.visibility=\'hidden\';return false;">'+closetext+'</a>'
               popup_content += '<br><br></div>'
               popup_content += '<div class="wps_headline"><h2 align="'+headline_align+'">'+popup_title+'</h2><p>'+popup_text+'</p></div>';
            }
            popup_top = "";
            if(popup_position == 'center'){
               popup_left = tb_popupLeftPosition(popup_width);
               popup_top = tb_popupTopPosition();
            }else{
               popup_left = "200"; //-1
               popup_top = "200"; //-1
            }
            document.getElementById('tb_preview').style.left = popup_left+'px';
            document.getElementById('tb_preview').style.backgroundColor = bg_color;
            document.getElementById('tb_preview').style.width = popup_width+'px';
            document.getElementById('tb_preview').innerHTML = popup_content;
            if(effect == "popup"){
               document.getElementById('tb_preview').style.visibility = "visible";
               document.getElementById('tb_preview').style.top = popup_top+ "px";
            }else if(effect == "lightbox"){
               pageheight = tb_getPageHeight();
               document.getElementById('lightbox_div').style.height = pageheight+'px';
               tb_lightbox(document.getElementById('lightbox_div'));
               document.getElementById('tb_preview').style.top = popup_top + "px";
               document.getElementById('tb_preview').style.visibility = "visible";
            }
         }
         tb_preview_popup();

      </script>
    <?php
   }
   function loadFollowScript3(){
    ?>
      <script language=javascript>
         var divName = 'tb_fb_div';
         var offX = 0;
         var offY = 0;
         function mouseX(evt) {if (!evt) evt = window.event; if (evt.pageX) return evt.pageX; else if (evt.clientX)return evt.clientX + (document.documentElement.scrollLeft ?  document.documentElement.scrollLeft : document.body.scrollLeft); else return 0;}
         function mouseY(evt) {if (!evt) evt = window.event; if (evt.pageY) return evt.pageY; else if (evt.clientY)return evt.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop); else return 0;}
         function follow(evt) {if (document.getElementById) {var obj = document.getElementById(divName).style; obj.visibility = 'hidden';
         obj.left = (parseInt(mouseX(evt))+offX) + 'px';
         obj.top = (parseInt(mouseY(evt))+offY) + 'px';}}
         document.onmousemove = follow;
      </script>
    <?php
   }   
?>
