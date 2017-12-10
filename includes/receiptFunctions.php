<?php

require_once("receiptModel.php");
$db = new Receipt();

function left($str, $length){
	$newStr = substr($str, 0, $length);
	while(strlen($newStr) != $length)
		$newStr .= ' ';
	return $newStr;
}

function right($str, $length){
	$newStr = '';
	$newLength = $length - strlen($str);
	for($x = 0; $x < $newLength; $x++)
		$newStr .= ' ';
	if(strlen($str) > $length)
		$str = substr($str, strlen($str) - $length);
	$newStr .= $str;

	return $newStr;
}

function center($str, $length){
	$start = 0;
	if($length < strlen($str))
		$start = (strlen($str) - $length)/2;
	$newStr = substr($str, $start, $length);
	$length = ($length - strlen($newStr))/2;
	for($x = 0; $x < $length; $x++)
		$newStr = ' '.$newStr;
	return $newStr;
}

function repeat($str, $times){
	$newStr = '';
	while($times != 0){
		$newStr .= $str;
		--$times;
	}
	return $newStr;
}

function posnumber($number){
	return number_format($number, 2, '.', '');
}

function get(){
	if(!isset($_GET['id'])) return;
	return $GLOBALS['db']->get();
}


