<?php

function trim_value(&$value) 
{ 
    $value = trim($value); 
}

$fruit = array('apple','banana ', ' cranberry ');
var_dump($fruit);

array_walk($fruit, 'trim_value');
var_dump($fruit);

//echo time().'<br>';
//$time_start = microtime(true);
//echo $time_start.'<br>';
//usleep(1000000);
//$time_end = microtime(true);
//$time = $time_end - $time_start;
//echo $time_end.'<br>';
//echo "Did nothing in $time seconds\n";
//echo time().'<br>';

/*
include_once('twt.php');
$twt1 = new TWTrends();
$twt1->gettrends();

$trends = explode($twt1->delimiter,$twt1->trends);

foreach ($trends as $trend){
   echo "TWT:".$trend.'<br>';
}
*/
/*
include_once('ght.php');
$twt1 = new GHTrends();
$twt1->gettrends();
//echo $twt1->trends;

$trends = explode($twt1->delimiter,$twt1->trends);

foreach ($trends as $trend){
   echo "GHT:".$trend.'<br>';
}
*/
/*

include_once('tws.php');
$twt1 = new TWSearch();
$twt1->phrase = "hay fever";
$twt1->exclude = "http";
$twt1->rpp = "10";
$twt1->getresults();

$tweeple = explode($twt1->delimiter,$twt1->tweeple);

foreach ($tweeple as $tweep){
   echo "@".$tweep.'<br>';
}
*/

?>