<?php

class GHTrends {

   public $cookie = "";
   public $trends = "";
   public $delimiter = "<br>";
   public $proxy = "";

   public function gettrends (){
      extract($GLOBALS);
      @set_time_limit(0);

      $host = "http://www.google.com";
      $path = "/trends/hottrends/atom/hourly";

      $this->getNewCookie();
      
      include_once('tb_curl.php');
      $curl=new Curl();
      $curl->setDefaults();
      $curl->referer="http://google.com";
      $curl->url=$host.$path;
      $curl->cookieFileFrom=$this->cookie;
      $curl->cookieFileTo=$this->cookie;
      if($this->proxy != "") $curl->proxy=$this->proxy;
      $curl->timeout=60;

      $arr=$curl->doCurl();
      
      $dom = new DOMDocument();
      @$dom->loadHTML($curl->content);
      
      $pathQuery = "//a";
         
      $xpath = new DOMXPath($dom);

      $elements = $xpath->query($pathQuery);

      $found=false;
      foreach($elements as $element){
         if ($this->trends != ""){
            $this->trends .= $this->delimiter;
         }
         $this->trends .= $element->textContent;
      }
   }

   private function getNewCookie(){
      $this->cookie =tempnam ("/tmp", "GHT");    
      if (!file_exists($this->cookie)) {
         fopen($this->cookie,'w');
      }
      return $this->cookie;
   }

}
?>