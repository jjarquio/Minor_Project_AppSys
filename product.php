<?php

require_once("includes/header.php");
require_once("includes/navigation.php");
require_once("includes/productFunctions.php");
unsub();

if(count($_GET) == 0){
	add();
    setsub();
	$items = $db->getAll();
?>

<div id="product-wrapper" class="wrapper">
<div id="product_left">
<div id="add_product">
<h2>Add Product</h2>
<form method="post">
	<input type="text" name="name" placeholder="Name" <?php retainValue('name'); ?>><br>
	<input type="text" name="description" placeholder="Description" <?php retainValue('description'); ?>><br>
	<input type="text" name="code" placeholder="Product Code" <?php retainValue('code'); ?>><br>
	<input type="number" name="quantity" placeholder="Quantity" <?php retainValue('quantity'); ?>><br>
	<input type="number" name="price" placeholder="Price" <?php retainValue('quantity'); ?>><br>
	<input type="text" name="model" placeholder="Product Model" <?php retainValue('model'); ?>><br>
	<input type="text" name="brand" placeholder="Product Brand" <?php retainValue('brand'); ?>><br>
	<input type="submit" name="add" id="addButton" value="Add">
</form>
</div>
<div id="subitem">
<h2> Set Sub-item</h2>
<?php
displayerror('NOSUBSELF');
displayerror('CHILDISPARENT');
displayerror('SUBEXISTS');
$sub = $db->getsub();
?>
<form method="post">
    <table>
        <tr>
            <td id="parent_p">Parent</td>
            <td>
                <select name="parent">
                    <?php foreach($items as $row): ?>
                        <option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td id="parent_p">Child</td>
            <td>
                <select name="child">
                    <?php foreach($items as $row): ?>
                        <option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            
            <td colspan="2" ><input type="submit" id="setBtn" name="setsub" value="Set"></td>
        </tr>
    </table>
</form>
</div>
</div>

<div id="product_div">
<h2 id="product_header">Products</h2>
<?php displayerror('SUBEXISTS'); ?>
<table id="product_table">
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>Product Code</th>
		<th>Quantity</th>
		<th>Price</th>
		<th>Product Model</th>
		<th>Product Brand</th>
		<th>Action</th>
	</tr>
<?php
$x = 0;
foreach($items as $row):
?>
	<tr<?php echo ++$x%2 == 1? null: " class=\"alt\""; ?>>
		<td>
            <?php echo $row->product_name;
            if(isset($sub[$row->product_id]))
                foreach($sub[$row->product_id] as $child)
                    echo "<br>&nbsp;<a href=\"?unlink=$child&from=$row->product_id\">[-]</a>&nbsp;<span class=\"small subitem\">".$items[$child]->product_name.'</span>';

            ?>
        </td>
		<td><?php echo $row->product_description; ?></td>
		<td><?php echo $row->product_code; ?></td>
		<td><?php echo $row->product_quantity; ?></td>
		<td><?php echo $row->product_price; ?></td>
		<td><?php echo $row->product_model; ?></td>
		<td><?php echo $row->product_brand; ?></td>
		<td>
			<a href="?edit=<?php echo $row->product_id; ?>">Edit</a>
			<a href="?delete=<?php echo $row->product_id; ?>">Delete</a>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php
}else if(count($_GET) == 1){
	if(isset($_GET['edit'])){
		edit();
		$currentProduct = $db->get($_GET['edit']);
?>
<div id="product_edit">
<h2>Edit Product #<?php echo $currentProduct->product_id; ?></h2>
<form method="post">
	<input type="text" name="name" placeholder="Name" value="<?php echo $currentProduct->product_name; ?>"><br>
	<input type="text" name="description" placeholder="Description" value="<?php echo $currentProduct->product_description; ?>"><br>
	<input type="text" name="code" placeholder="Product Code" value="<?php echo $currentProduct->product_code; ?>"><br>
	<input type="number" name="quantity" placeholder="Quantity" value="<?php echo $currentProduct->product_quantity; ?>"><br>
	<input type="number" name="price" placeholder="Price" value="<?php echo $currentProduct->product_price; ?>"><br>
	<input type="text" name="model" placeholder="Product Model" value="<?php echo $currentProduct->product_model; ?>"><br>
	<input type="text" name="brand" placeholder="Product Brand" value="<?php echo $currentProduct->product_brand; ?>"><br>
	<input type="submit" name="save" id="edit_p" value="Save">
</form>

<?php
	}else if(isset($_GET['delete'])){
		delete();
?>
<div id="delete_function">
<?php displayerror('NODEL'); ?>
<form method="post">
Delete product #<?php echo $_GET['delete'] ?>. Are you sure?
<br>
<input  id="delete_buttton" type="submit" name="delete" value="Yes"></br>

</form>
</div>
<?php
	}else reload();
}else reload();
?>
</div>
</div>
</div>
<?php require_once("includes/footer.php"); ?>
