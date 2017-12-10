<?php

// TCPDF library Includes
require_once('TCPDF/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setFontSubsetting(true);
$pdf->SetFont('courier', '', 8, '', true);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
define('WIDTH', 73);

// PoS Includes
require_once("includes/functions.php");
require_once("includes/receiptFunctions.php");
if(!$current = get()) header("location: $base/sales.php");
$items = $db->items();
$names = $db->getname();
$subs = $db->getsub();

// Content
$pdf->Cell(WIDTH, 0, "  Rasicomputers (1629) ", 0, 1, 'C', 0, '', 2);

$content = "<br><br>".htmlspace(center("Operated By:Rasicomputers.", 42))."<br>";
$content .= htmlspace(center("14 Iñigo st. Bo. Obrero , Davao City", 42))."<br>";
$content .= htmlspace(center("VAT Reg TIN: 415-916-681-000", 42))."<br>";
$content .= htmlspace(center("POS02-SN: TPB70385", 42))."<br>";
$content .= htmlspace(center("MIN#110253391", 42))."<br>";
$content .= htmlspace(repeat('=', 42));

// Print text using writeHTMLCell()
$html = <<<EOD
$content
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$str = "$current->sale_time ".strtoupper(left($current->name, 5))." OR#";
$pdf->Cell( WIDTH / 42 * strlen( $str ), 0, $str, 0, 0, 'C', 0, '', 2 );
$str = $current->sale_id;
$pdf->Cell( WIDTH / 42 * strlen( $str ) * 2, 0, $str, 0, 1, 'C', 0, '', 2 );

$content = "<br><br>".htmlspace(repeat('=', 42));

// Print text using writeHTMLCell()
$html = <<<EOD
$content
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



$content = "<br><br>";

    $totalsale = 0;
    $totalqty = 0;
    foreach($items as $item){
    	$totalqty += $item->qty;
    	$totalsale += $item->subtotal;
        $price = '';
        if($item->qty > 1) $price = "@$item->price";
    	$str = right($item->qty, 3).' '.left($item->name.' '.$price, 26).' '.right($item->subtotal.'V', 11);
    	$content .= htmlspace($str)."<br>";
        if(isset($subs[$item->id]))
            foreach($subs[$item->id] as $sub)
                $content .= htmlspace(repeat(' ', 4).left($item->qty.' '.$names[$sub], 26))."<br>";
    }

    $change = $current->sale_cash - $totalsale;

$content .= htmlspace(repeat('-', 3).right(repeat('-', 11), 39))."<br>";

$content .= htmlspace(right($totalqty, 3).' '.left("Item(s)", 26).' '.right(posnumber($totalsale).' ', 11));

// Print text using writeHTMLCell()
$html = <<<EOD
$content
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$str = repeat(' ', 4).left("TOTAL DUE", 16);
$pdf->Cell( WIDTH / 42 * strlen( $str ), 0, $str, 0, 0, 'C', 0, '', 2 );
$str = right(posnumber($totalsale), 11);
$pdf->Cell( WIDTH / 42 * strlen( $str ) * 2, 0, $str, 0, 1, 'C', 0, '', 2 );

$content = '<br><br>'.htmlspace(repeat(' ', 4).left("CASH", 26).' '.right(posnumber($current->sale_cash), 11));

// Print text using writeHTMLCell()
$html = <<<EOD
$content
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$str = repeat(' ', 4).left("CHANGE", 16);
$pdf->Cell( WIDTH / 42 * strlen( $str ), 0, $str, 0, 0, 'C', 0, '', 2 );
$str = right(posnumber($change), 11);
$pdf->Cell( WIDTH / 42 * strlen( $str ) * 2, 0, $str, 0, 1, 'C', 0, '', 2 );

    $multiple = $totalsale / 112;
    $vatsale = $multiple * 100;
    $vat = $multiple * 12;

$content = '<br><br>'.htmlspace(repeat(' ', 4).left("VATable Sales", 26).' '.right(posnumber($vatsale), 11))."<br>";
$content .= htmlspace(repeat(' ', 4).left("VAT-Exempt Sales", 26).' '.right(posnumber(0), 11))."<br>";
$content .= htmlspace(repeat(' ', 4).left("VAT Zero-Rated Sales", 26).' '.right(posnumber(0), 11))."<br>";
$content .= htmlspace(repeat(' ', 4).left("VAT Amount", 26).' '.right(posnumber($vat), 11))."<br><br>";

$content .= htmlspace(right("Cust Name:".repeat('_', 32), 42))."<br>";
$content .= htmlspace(right("Address:".repeat('_', 32), 42))."<br>";
$content .= htmlspace(right("TIN:".repeat('_', 32), 42))."<br>";
$content .= htmlspace(right("Bus Style:".repeat('_', 32), 42))."<br><br>";

$content .= htmlspace(center("Pls txt rscmpt1629<Feedback> <Name, Address>", 42))."<br>";
$content .= htmlspace(center("to 0917-8007000 or call 898-7777 or", 42))."<br>";
$content .= htmlspace(center("send email to feedback@rasicomputers.com", 42))."<br>";
$content .= "<br>".htmlspace(center("This serves as an OFFICIAL RECEIPT", 42))."<br>";
$content .= htmlspace(center("ANSI Information Systems, Inc.", 42))."<br>";
$content .= htmlspace(center("Tytana St., Manila", 42))."<br>";
$content .= htmlspace(center("VAT Reg TIN: 000-330-515-0000", 42))."<br>";
$content .= htmlspace(center("ACCREDITATION NO.0300003305150000073451", 42))."<br>";
$content .= htmlspace(center("Date Issued: 07/04/2005", 42))."<br>";
$content .= htmlspace(center("PTU No. 1211-132-116592-000", 42))."<br>";
$content .= htmlspace(center("THIS INVOICE/RECEIPT SHALL BE VALID FOR", 42))."<br>";
$content .= htmlspace(center("FIVE (5) YEARS FROM THE DATE OF THE", 42))."<br>";
$content .= htmlspace(center("PERMIT TO USE.", 42))."<br>";

// Print text using writeHTMLCell()
$html = <<<EOD
$content
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output("$current->name-$current->sale_id", 'I');

