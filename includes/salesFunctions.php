<?php

require_once("salesModel.php");
$db = new Sales();
$format = "Y-m-d H:i:s";

if(isset($_GET['report'])
    && isset($_GET['from'])
    && isset($_GET['to'])
    && $_GET['report'] == 'Go'
    && DateTime::createFromFormat($format, $_GET['from'])
    && DateTime::createFromFormat($format, $_GET['to'])){
    $data = $db->report();
    $file = 'report.csv';
    $myfile = fopen($file, "w");
    fwrite($myfile, "OR#, CASHIER_NAME, DATETIME, SALE\n");
    foreach($data as $item)
        fwrite($myfile, "$item->id, $item->name, $item->time, $item->sale\n");
    fclose($myfile);
    echo "<script>window.open('report.csv')</script>";
    echo "<script>window.location = \"sales.php\"</script>";
}

function sortSales(){
    if(!isset($_GET["by"]) || !isset($_GET["order"]))
        return $GLOBALS['db']->get("id");
    $by = array("id", "cust", "time", "name", "sale");
    $order = array("ASC", "DESC");
    if(!in_array($_GET["by"], $by) 
        || !in_array($_GET["order"], $order))
        return;
    return $GLOBALS['db']->get($_GET["by"].' '.$_GET["order"]);
}

function reload(){
    header("location: ".$GLOBALS['base']."/sales.php");
}

