<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//<meta.*="(.*)".*content="(.*)".*\/>

$output_array = $results = array();

if(!empty($_POST['process'])){
  
  $text = $_POST['html'];
  
  preg_match_all('/\<meta.*="(.*)".*content="(.*)"/', $text, $output_array);
  
//  header("Content-Type: text/plain");
  
  foreach($output_array[1] as $id => $res){
	$name = $output_array[1][$id];
	$results[$name] = $output_array[2][$id];
  }

} 

include_once 'view.php';