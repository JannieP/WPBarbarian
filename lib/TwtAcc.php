<?php

  class tb_tw_acc{
      function tb_tw_acc($tw_user = '', $tw_ck = '', $tw_cs = '', $tw_at = '', $tw_as = '', $tw_hash = '')
      {
          $this->tw_user = $tw_user;
          $this->tw_ck = $tw_ck;
          $this->tw_cs = $tw_cs;
          $this->tw_at = $tw_at;
          $this->tw_as = $tw_as;
          $this->tw_hash = $tw_hash;
      }
  }

  class tb_tweet{
      function tb_tweet($tw_id = '', $tw_text = '', $tw_created_at = '', $tw_reply_username = null, $tw_reply_tweet = null)
      {
          $this->id = '';
          $this->modified = '';
          $this->tw_created_at = $tw_created_at;
          $this->tw_text = $tw_text;
          $this->tw_reply_username = $tw_reply_username;
          $this->tw_reply_tweet = $tw_reply_tweet;
          $this->tw_id = $tw_id;
      }
  }

?>