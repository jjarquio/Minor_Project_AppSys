<?php

require_once "menuFunctions.php";
add();

?>

<h2>Products</h2>
<?php if(isset($_ERROR['NOSTORE'])): ?>
<p><?php echo $_ERROR['NOSTORE']; ?></p>
<?php endif; ?>
<table>
    <tr>
        <td>Product Name</td>
        <td>Quantity</td>
        <td>Action</td>
    </tr>
<?php
$products = $productdb->getAll();
while($row = $products->fetch_object()):
?>
    <tr>
        <td><?php echo $row->product_name; ?></td>
        <td><?php echo $row->product_quantity; ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row->product_id; ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $row->product_quantity; ?>" required>
                <input type="submit" name="add" value="Add">
            </form>
        </td>
    </tr>
<?php endwhile; ?>
</table>
