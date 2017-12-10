<?php

require_once("productModel.php");
require_once("cartModel.php");
$db = new Cart();
$proddb = new Product();

function add(){
    // Check form elements
    if(!isset($_POST['add'])) return;
    if($_POST['add'] != "Add") return;
    unset($_POST['add']);

    // Get product
    $product = (new Product())->get($_POST['id']);

    // If insufficient storage
    if($product->product_quantity < $_POST['quantity']) return error('NOSTORE','Insufficient Storage');

    $_POST['stockqty'] = $product->product_quantity;
    if(!$GLOBALS['db']->add((object) $_POST)) return error('NOSTORE','Insufficient Storage');

    reload();
}

function pay(){
    if(!isset($_POST['pay'])) return;
    if($_POST['pay'] != "Pay") return;
    unset($_POST['pay']);
    if(!isset($_POST['cash'])) return;
    if($_POST['cash'] == '' || $_POST['cash'] < 0) return;
    $cash = $_POST['cash'];
    $total = $GLOBALS['db']->total();
    if($cash < $total) return error('NOCASH', 'Insufficient cash');
    echo "<script>window.open('receipt.php?id=".$GLOBALS['db']->pay((object) $_POST)."')</script>";
    echo "<script>window.location = \"\"</script>";
}

function void(){
    if(!isset($_POST['void'])) return;
    if($_POST['void'] != "VOID") return;
    unset($_POST['void']);
    if(!isset($_POST['item'])) return;
    $_POST['item'] = implode(", ", $_POST['item']);
    if(!$GLOBALS['db']->isManager($_COOKIE['datas']))
        if(!$GLOBALS['db']->isInputtedManager($_POST))
            return error("NOVOID", "Only manager can void");
    unset($_POST['id']);
    unset($_POST['passcode']);
    $GLOBALS['db']->void($_POST);
    reload();
}

function reload(){
    header("location: ".$GLOBALS['base']);
}
