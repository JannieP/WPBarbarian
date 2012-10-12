<?php

class TWSearch {

   public $cookie = "";
   public $tweeple = "";
   public $delimiter = "<br>";
   public $phrase = "";
   public $ands = "";
   public $ors = "";
   public $tags = "";
   public $exclude = "";
   public $rpp = "50"; //10,15,20,25,30,50
   public $result = '';
   public $path = '';
   public $test = "&nots";
   public $proxy = "";

   public function getresults (){
      extract($GLOBALS);
      @set_time_limit(0);

      //http://search.twitter.com/search?q=&ands=&phrase=hay+fever&ors=&nots=http&tag=&lang=all&from=&to=&ref=&near=&within=15&units=mi&since=2011-05-09&until=2011-05-09&rpp=50
      
      $this->phrase = urlencode($this->phrase);
      $this->exclude = urlencode($this->exclude);

      $host = "http://search.twitter.com";
      $path = "/search?q=&ands=".$this->ands."&phrase=".$this->phrase."&ors=".$this->ors."&nots=".$this->exclude."&tag=".$this->tags."&lang=all&from=&to=&ref=&near=&within=15&units=mi&since=".date("Y-m-d")."&until=".date("Y-m-d")."&rpp=".$this->rpp."";

      $this->getNewCookie();
      
      include_once('tb_curl.php');
      $curl=new Curl();
      $curl->setDefaults();
      $curl->referer="http://search.twitter.com/advanced";
      $curl->url=$host.$path;
      $curl->cookieFileFrom=$this->cookie;
      $curl->cookieFileTo=$this->cookie;
      if($this->proxy != "") $curl->proxy=$this->proxy;
      $curl->timeout=60;

      $arr=$curl->doCurl();
      $this->result = $arr;
      $this->path = $path;

      $dom = new DOMDocument();
      @$dom->loadHTML($curl->content);
      
      $pathQuery = "//a";
         
      $xpath = new DOMXPath($dom);

      $elements = $xpath->query($pathQuery);

      $found=false;
      foreach($elements as $element){
         foreach ($element->attributes as $attribute){
            if($attribute->name=='class' && $attribute->value=='username'){
               //echo substr($element->textContent,0,1)."-----<br>";
               if (substr($element->textContent,0,1) != '@'){
                  if ($this->tweeple != ""){
                     $this->tweeple = $this->tweeple . $this->delimiter;
                  }
                  $this->tweeple = $this->tweeple . $element->textContent;
                  break;
               }
            }
         }
      }
   }

   private function getNewCookie(){
      $this->cookie =tempnam ("/tmp", "TWT");    
      if (!file_exists($this->cookie)) {
         fopen($this->cookie,'w');
      }
      return $this->cookie;
   }

}
?>