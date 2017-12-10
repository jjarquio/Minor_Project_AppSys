<?php
require_once("includes/header.php");
require_once("includes/receiptFunctions.php");
if(!$current = get()) header("location: $base/sales.php");
$items = $db->items();
?>
<div id="receipt" class="monospace">
<?php

echo htmlspace(center("RasiComputers", 42))."<br><br>";
echo htmlspace(center("Loyola.", 42))."<br>";
echo htmlspace(center("14 Iñigo st. Bo. Obrero , Davao City", 42))."<br>";
echo htmlspace(center("VAT Reg TIN: 415-916-681-000", 42))."<br>";
echo htmlspace(center("POS02-SN: TPB70385", 42))."<br>";
echo htmlspace(center("MIN#110253391", 42))."<br><br><br>";
echo htmlspace(repeat('=', 42))."<br>";
echo htmlspace("$current->sale_time     ".strtoupper(left($current->name, 5))."     ".right("OR#".$current->sale_id, 11))."<br><br>";
echo htmlspace(repeat('=', 42))."<br>";
echo "<br>";

// 42 cols
$totalsale = 0;
$totalqty = 0;
foreach($items as $item){
	$totalqty += $item->qty;
	$totalsale += $item->subtotal;
	$str = right($item->qty, 3).' '.left($item->name, 26).' '.right($item->subtotal.'V', 11);
	echo htmlspace($str)."<br>";
}
$change = $current->sale_cash - $totalsale;
echo htmlspace(repeat('-', 3).right(repeat('-', 11), 39))."<br>";

echo htmlspace(right($totalqty, 3).' '.left("Item(s)", 26).' '.right(posnumber($totalsale).' ', 11))."<br>";

echo '<br>';

echo htmlspace(repeat(' ', 4).left("CASH", 26).' '.right(posnumber($current->sale_cash), 11))."<br>";
echo htmlspace(repeat(' ', 4).left("CHANGE", 26).' '.right(posnumber($change), 11))."<br><br>";

$multiple = $totalsale / 112;
$vatsale = $multiple * 100;
$vat = $multiple * 12;

echo htmlspace(repeat(' ', 4).left("VATable Sales", 26).' '.right(posnumber($vatsale), 11))."<br>";
echo htmlspace(repeat(' ', 4).left("VAT Amount", 26).' '.right(posnumber($vat), 11))."<br>";

echo "<br><br>".htmlspace(center("This serves as an OFFICIAL RECEIPT", 42))."<br>";
echo htmlspace(center("ANSI Information Systems, Inc.", 42))."<br>";
echo htmlspace(center("Tytana St., Manila", 42))."<br>";
echo htmlspace(center("VAT Reg TIN: 000-330-515-0000", 42))."<br>";
echo htmlspace(center("ACCREDITATION NO.0300003305150000073451", 42))."<br>";
echo htmlspace(center("Date Issued: 07/04/2005", 42))."<br>";
echo htmlspace(center("PTU No. 1211-132-116592-000", 42))."<br>";
echo htmlspace(center("THIS INVOICE/RECEIPT SHALL BE VALID FOR", 42))."<br>";
echo htmlspace(center("FIVE (5) YEARS FROM THE DATE OF THE", 42))."<br>";
echo htmlspace(center("PERMIT TO USE.", 42))."<br>";


?>
</div>
<?php require_once("includes/footer.php"); ?>
