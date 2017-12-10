<?php

require_once("productModel.php");
$db = new Product();

function add(){
	if(!isset($_POST['add'])) return;
	if($_POST['add'] != "Add") return;
	unset($_POST['add']);
	if(isPost('name', '')
		|| $_POST['quantity'] < 0
		|| $_POST['price'] < 0)
		return;
	$GLOBALS['db']->add($_POST);
	reload();
}

function setsub(){
	if(!isset($_POST['setsub']) || $_POST['setsub'] != 'Set') return;
	unset($_POST['setsub']);
	if(!isset($_POST['parent']) || !isset($_POST['child'])) return;
	if($_POST['parent'] == $_POST['child'])
		return error("NOSUBSELF", "Cannot set as child itself");
	if(!$GLOBALS['db']->setsub($_POST)) return;
	reload();
}

function unsub(){
	if(!isset($_GET['unlink']) || !isset($_GET['from'])) return;
	$GLOBALS['db']->unsub($_GET);
}

function edit(){
	if(!isset($_POST['save'])) return;
	if($_POST['save'] != "Save") return;
	unset($_POST['save']);
	if(isPost('name', '')
		|| $_POST['quantity'] < 0
		|| $_POST['price'] < 0)
		return;
	$_POST['id'] = $_GET['edit'];
	$GLOBALS['db']->set($_POST);
	reload();
}

function delete(){
	if(!isset($_POST['delete'])) return;
	if($_POST['delete'] != "Yes") return;
	if(!$GLOBALS['db']->delete($_GET['delete'])) return error('NODEL', 'Cannot delete product. Either the product exists in the cart or on any receipt');
	reload();
}

function reload(){
	header("location: ".$GLOBALS['base']."/product.php");
}

?>
