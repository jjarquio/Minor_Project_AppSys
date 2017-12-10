<?php
require_once("includes/header.php"); 
require_once("includes/navigation.php");
require_once("includes/salesFunctions.php");
$data = sortSales();
$by = array(
	"id" => "OR#",
	"name" => "Cashier",
	"time" => "Date",
	"sale" => "Sale"
	);

$order = array(
	"ASC" => "Ascending",
	"DESC" => "Descending"
	);
?>
<div id="sales-wrapper" class="wrapper">
<div id="sales_left">

<h2><i class="fa fa-money" id="sales_center" aria-hidden="true"></i> Sales</h2>
<div id="sales_mar">
<br></br>
<form>
    Sort by
    <select id="select_by" name="by">
    <?php foreach($by as $value => $text):
    	$b = null;
    	if(isset($_GET['by']))
    		$b = $_GET['by'] == $value? " selected": null; ?>
    	<option value="<?php echo $value; ?>"<?php echo $b; ?>><?php echo $text; ?></option>;
    <?php endforeach; ?>
    </select>
    <select id="select_order" name="order">
    <?php foreach($order as $value => $text):
    	$b = null;
    	if(isset($_GET['order']))
    		$b = $_GET['order'] == $value? " selected": null; ?>
    	<option value="<?php echo $value; ?>"<?php echo $b; ?>><?php echo $text; ?></option>;
    <?php endforeach; ?>
    </select>
    
    <input type="submit" name="sort" value="Go">
</form>
</div>
<form>
	<br></br>

	<div id="gen_1">
	Generate report from<br>
	<select id="select_name" name="from">
	<?php foreach($db->get("time ASC") as $order): ?>
		<option value="<?php echo $order->time; ?>"><?php echo $order->time; ?></option>
	<?php endforeach; ?>
	</select>
	</div>
	<div id="gen_2">
	to</br>
	<select id="select_to" name="to">
	<?php foreach($db->get("time DESC") as $order): ?>
		<option value="<?php echo $order->time; ?>"><?php echo $order->time; ?></option>
	<?php endforeach; ?>
	</select>
	</div>
    <input id="gen_3" type="submit" name="report" value="Go">
    </br>
</form>
</div>

<div id="sales_div">
<table id="sales_table">
	<tr>
		<th>OR#</th>
		<th>Cashier</th>
		<th>Date</th>
		<th>Sale</th>
	</tr>

<?php 
$x = 0;
foreach($data as $order): 
	?>
	<tr<?php echo ++$x%2 == 1? null: " class=\"alt\""; ?>>
		<td><a href="receipt.php?id=<?php echo $order->id; ?>" class="or-link" target="_blank"><?php echo $order->id; ?></a></td>
		<td><?php echo $order->name; ?></td>
		<td><?php echo $order->time; ?></td>
		<td><?php echo number_format($order->sale, 2); ?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>
</div>
<?php require_once("includes/footer.php"); ?>
