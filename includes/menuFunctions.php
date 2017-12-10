<?php

require_once("productModel.php");
require_once("menuModel.php");
$productdb = new Product();

function add(){
    // Check form elements
    if(!isset($_POST['add'])) return;
    if($_POST['add'] != "Add") return;
    unset($_POST['add']);

    // Get product
    $product = (new Product())->get($_POST['id']);

    // If insufficient storage
    if($product->product_quantity < $_POST['quantity']) return error('NOSTORE','Insufficient Storage');

    $GLOBALS['cartdb']->add($_POST);

    reload();
}
