<?php

require_once("cartFunctions.php");
add();
pay();
void();

?>

<div id="cart">
<h2>Cart</h2>
<?php
$items = $db->get();
//$sub = $proddb->getsub();
$products = $proddb->getAll();
if($items):
?>
<?php if(isset($_ERROR['NOVOID'])): ?>
<p class="error"><span><?php echo $_ERROR['NOVOID']; ?></span></p>
<?php endif; ?>
<form method="post">
<table>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>Subtotal</th>
    </tr>
    <?php
    $total = 0;
    foreach($items as $item):
    ?>
        <tr>
            <td><input type="checkbox" name="item[]" value="<?php echo $item->id; ?>"></td>
            <td><?php echo $item->qty; ?></td>
            <td>
                <?php
                echo "$item->name @$item->price";
                if(isset($sub[$item->id]))
                    foreach($sub[$item->id] as $subitem)
                        echo "<br>$item->qty ".$products[$subitem]->product_name;
                ?>
            </td>
            <td><?php echo number_format($item->subtotal, 2); ?></td>
        </tr>
    <?php
    $total += $item->subtotal;
    endforeach;
    ?>
</table>
    <input type="submit" name="void" value="VOID">
    SELECTED
    <?php if(!$db->isManager($_COOKIE['datas'])): ?>
    <div id="void-fields"><input type="number" name="id" placeholder="Manager ID"><input type="password" name="passcode" placeholder="Manager Passcode"></div>
    <?php endif; ?>
</form>

<h2> Customer</h2>
<?php if(isset($_ERROR['NOCASH'])): ?>
    <p class="error"><span><?php echo $_ERROR['NOCASH']; ?></span></p>
<?php endif; ?>

<form method="post"><table>
    <tr>
        <td>TOTAL</td>
        <td><?php echo number_format($total,2); ?></td>
    </tr>

    <tr>
        <td>CASH</td>
        <td>
            <input type="number" name="cash" min="<?php echo $total; ?>" required>
            <input type="submit" name="pay" value="Pay">
        </td>
    </tr>
</table></form>
<?php else: ?>
<div>Empty cart.</div>
<?php endif; ?>
</div>



<div id="menu-prod">
    <h2></i></h2>
    <?php
    displayerror('NOSTORE');
    foreach($products as $row):
        if(!$row->product_quantity) continue;
        ?><div id="menu-prod-<?php echo $row->product_id; ?>" class="prod">
    <div class="name"><?php echo $row->product_name; ?></div>
    <div class="qty">&times; <?php echo $row->product_quantity; ?></div>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $row->product_id; ?>">
        <input type="number" name="quantity" value="1" min="1" max="<?php echo $row->product_quantity; ?>" required>
        <input type="submit" name="add" value="Add">
    </form>
    </div><?php endforeach; ?>
</div>
