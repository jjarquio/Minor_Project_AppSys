<?php

$base = "/RasiComputers";
date_default_timezone_set("Asia/Manila");
require_once("DBConnection.php");
$_ERROR = array();

if($_SERVER['PHP_SELF'] != $base."/login.php"){
    if(!isLogged())
        header("location: login.php?redirect=".$_SERVER['REQUEST_URI']);
}else if(isLogged()) header("location: $base");

function isPost($name, $value){
	if(!isset($_POST[$name])) return;
	if($_POST[$name] == $value) return 1;
}

function retainValue($name){
	if(isset($_POST[$name])) if($_POST[$name] != '')
			echo "value=\"".$_POST[$name]."\"";
}

function isLogged(){
    $login = new DBConnection();
    if(!isset($_COOKIE['datas']) || !isset($_COOKIE['datar'])) return;
    $data['userid'] = $_COOKIE['datas'];
    $data['passcode'] = $_COOKIE['datar'];
    if($result = $login->verify($data)) return 1;
    header("location: ".$GLOBALS['base']."/logout.php");
}

function htmlspace($str){
    $str = htmlspecialchars($str);
    $newStr = '';
    for($x = 0; $x < strlen($str); $x++)
        if($str{$x} == ' ')
            $newStr .= "&nbsp;";
        else $newStr .= $str{$x};
    return $newStr;
}

function error($index, $str){
    $GLOBALS['_ERROR'][$index] = $str;
}

function displayerror($str){
    if(isset($GLOBALS['_ERROR'][$str]))
        echo "<p class=\"error\"><span>".$GLOBALS['_ERROR'][$str]."</span></p>";
    else return;
    return 1;
}

?>
