<?php

/* $Id: PDFTransPageHeaderPortrait.inc 4644 2011-07-30 06:58:14Z daintree $ */


if (!$FirstPage){ /* only initiate a new page if its not the first */
    $pdf->newPage();
}

$YPos = $Page_Height - $Top_Margin;

$pdf->addJpegFromFile($_SESSION['LogoFile'],$Page_Width/2 -160,$YPos-85,0,50);

$FontSize =15;
if ($InvOrCredit=='Invoice') {

    $pdf->addText($Page_Width/2 - 60, $YPos, $FontSize, _('FISCAL TAX INVOICE') . ' ');
} else {
    $pdf->addText($Page_Width/2 - 60, $YPos, $FontSize, _('FISCAL CREDIT NOTE') . ' ');
}

$FontSize = 10;
$pdf->addText($Page_Width-128, $YPos, $FontSize, _('Page'));
$pdf->addText($Page_Width-60, $YPos, $FontSize, $PageNumber);


$XPos = $Page_Width - 265;
$YPos -= 95;
/*draw a nice curved corner box around the billing details */
/*from the top right */
$pdf->partEllipse($XPos+225,$YPos+67,0,90,10,10);
/*line to the top left */
$pdf->line($XPos+225, $YPos+77,$XPos, $YPos+77);
/*Do top left corner */
$pdf->partEllipse($XPos, $YPos+67,90,180,10,10);
/*Do a line to the bottom left corner */
$pdf->line($XPos-10, $YPos+67,$XPos-10, $YPos-10);
/*Now do the bottom left corner 180 - 270 coming back west*/
$pdf->partEllipse($XPos, $YPos-10,180,270,10,10);
/*Now a line to the bottom right */
$pdf->line($XPos, $YPos-20,$XPos+225, $YPos-20);
/*Now do the bottom right corner */
$pdf->partEllipse($XPos+225, $YPos-10,270,360,10,10);
/*Finally join up to the top right corner where started */
$pdf->line($XPos+235, $YPos-10,$XPos+235, $YPos+67);

$YPos = $Page_Height - $Top_Margin - 10;

$FontSize = 10;
$LineHeight = 13;
$LineCount = 1;
$pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Document No'));
$pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, $FromTransNo);
$LineCount += 1;
$pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Invoice No'));
$pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, "");
$LineCount += 1;
$pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Customer Code'));
$pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['debtorno'] . ' ' . _('Branch') . ' ' . $myrow['branchcode']);
$LineCount += 1;
$pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Date'));
$pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, ConvertSQLDate($myrow['trandate']));
$LineCount += 1;
$pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Reason'));
$pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, "Refund");

if ($InvOrCredit=='Invoice') {
    $LineCount += 1;
    $pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Order No'));
    $pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['orderno']);
    $LineCount += 1;
    $pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Order Date'));
    $pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, ConvertSQLDate($myrow['orddate']));
    $LineCount += 1;
    $pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Dispatch Detail'));
    $pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['shippername'] . '-' . $myrow['consignment']);
    $LineCount += 1;
    $pdf->addText($Page_Width-268, $YPos-$LineCount*$LineHeight, $FontSize, _('Dispatched From'));
    $pdf->addText($Page_Width-180, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['locationname']);
}

/*End of the text in the right side box */

/*Now print out company info at the top left */

$XPos = $Left_Margin;
$YPos = $Page_Height - $Top_Margin - 20;

$FontSize = 10;
$LineHeight = 13;
$LineCount = 0;

$pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $_SESSION['CompanyRecord']['coyname']);

$FontSize = 8;
$LineHeight = 10;

if ($_SESSION['CompanyRecord']['regoffice1'] <> '') {
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight,$FontSize, $_SESSION['CompanyRecord']['regoffice1']);
}
if ($_SESSION['CompanyRecord']['regoffice2'] <> '') {
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight,$FontSize, $_SESSION['CompanyRecord']['regoffice2']);
}
if (($_SESSION['CompanyRecord']['regoffice3'] <> '') OR ($_SESSION['CompanyRecord']['regoffice4'] <> '') OR ($_SESSION['CompanyRecord']['regoffice5'] <> '')) {
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight,$FontSize, $_SESSION['CompanyRecord']['regoffice3'] . ' ' . $_SESSION['CompanyRecord']['regoffice4'] . ' ' . $_SESSION['CompanyRecord']['regoffice5']);  // country in 6 not printed
}
$LineCount += 1;
$pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, _('Phone') . ':' . $_SESSION['CompanyRecord']['telephone']);
$LineCount += 1;
$pdf->addText($XPos, $YPos-$LineCount*$LineHeight,$FontSize, _('Fax') . ': ' . $_SESSION['CompanyRecord']['fax']);
$LineCount += 1;
$pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, _('Email') . ': ' . $_SESSION['CompanyRecord']['email']);
$LineCount += 1;
$pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $_SESSION['TaxAuthorityReferenceName'] . ': ' . $_SESSION['CompanyRecord']['gstno']);
$LineCount += 1;
$pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, _('TIN') . ': ' . $_SESSION['CompanyRecord']['tinno']);

/*Now the customer company info */

$XPos = $Left_Margin;
$YPos = $Page_Height - $Top_Margin - 120;

$FontSize = 10;
$LineHeight = 10;
$LineCount = 0;

$pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, _('Customer Details') . ':');

$XPos += 5;
$FontSize = 10;
$LineHeight = 13;

if ($myrow['invaddrbranch']==0){
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['name']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['address1']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['address2']);
    $LineCount += 1;
    //$pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['address3'] . ' ' . $myrow['address4']  . ' ' . $myrow['address5']  . ' ' . $myrow['address6']);
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['address3']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['address4']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['address6']);
} else {
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['name']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['brpostaddr1']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['brpostaddr2']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['brpostaddr3'] . ' ' . $myrow['brpostaddr4'] . ' ' . $myrow['brpostaddr5'] . ' ' . $myrow['brpostaddr6']);
}

//$XPos = $Page_Width/2;
$XPos = $Page_Width - 265;
$YPos = $Page_Height - $Top_Margin - 120;

$FontSize = 10;
$LineHeight = 10;
$LineCount = 0;

if ($InvOrCredit=='Invoice') {
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, _('Delivered To (check Dispatch Detail)') . ':');
    $FontSize = 10;
    $LineHeight = 13;
    $XPos +=20;
    //$LineCount += 1;
// Before trying to call htmlspecialchars_decode, check that its supported, if not substitute a compatible version
    if (!function_exists('htmlspecialchars_decode')) {
        function htmlspecialchars_decode($str) {
            $trans = get_html_translation_table(HTML_SPECIALCHARS);

            $decode = ARRAY();
            foreach ($trans AS $char=>$entity) {
                $decode[$entity] = $char;
            }

            $str = strtr($str, $decode);

            return $str;
        }
    }
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['deliverto']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['deladd1']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['deladd2']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['deladd3'] . ' ' . $myrow['deladd4'] . ' ' . $myrow['deladd5'] . ' ' . $myrow['deladd6']);
    //$XPos -=80;
}
if ($InvOrCredit=='Credit'){
    /* then its a credit note */
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, _('Charge Branch') . ':');
    $FontSize = 10;
    $LineHeight = 13;
    $XPos +=20;
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['brname']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['braddress1']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['braddress2']);
    $LineCount += 1;
    $pdf->addText($XPos, $YPos-$LineCount*$LineHeight, $FontSize, $myrow['braddress3'] . ' ' . $myrow['braddress4'] . ' ' . $myrow['braddress5'] . ' ' . $myrow['braddress6']);
    //$XPos -=80;
}

$XPos = $Left_Margin;

$YPos = $Page_Height - $Top_Margin - 190;
$XPos = $Left_Margin;
$FontSize = 10;

$pdf->addText($XPos +=200, $YPos-8, $FontSize, _('All amounts stated in') . ' - ' . $myrow['currcode']);
//$pdf->addText($XPos, YPos-8, $FontSize, _('All amounts stated in ZWL'));

$XPos = $Left_Margin;
$BoxHeight = $Page_Height-282;

/*draw a box with nice round corner for entering line items */
/*90 degree arc at top right of box 0 degrees starts a bottom */
$pdf->partEllipse($Page_Width-$Right_Margin-10, $Bottom_Margin+$BoxHeight,0,90,10,10);


/*line to the top left */
$pdf->line($Page_Width-$Right_Margin-10, $Bottom_Margin+$BoxHeight+10,$Left_Margin+10, $Bottom_Margin+$BoxHeight+10);


/*Dow top left corner */
$pdf->partEllipse($Left_Margin+10, $Bottom_Margin+$BoxHeight,90,180,10,10);

/*Do a line to the bottom left corner */
//$pdf->line($Left_Margin, $Bottom_Margin+$BoxHeight,$Left_Margin, $Bottom_Margin+10);

/*Now do the bottom left corner 180 - 270 coming back west*/
$pdf->partEllipse($Left_Margin+10, $Bottom_Margin+10,180,270,10,10);
/*Now a line to the bottom right */
$pdf->line($Left_Margin+10, $Bottom_Margin,$Page_Width-$Right_Margin-10, $Bottom_Margin);
/*Now do the bottom right corner */
$pdf->partEllipse($Page_Width-$Right_Margin-10, $Bottom_Margin+10,270,360,10,10);
/*Finally join up to the top right corner where started */
//$pdf->line($Page_Width-$Right_Margin, $Bottom_Margin+10,$Page_Width-$Right_Margin, $Bottom_Margin+$BoxHeight);


$YPos -= 65;
/*Set up headings */
$FontSize=10;
$LineHeight = 12;
$LineCount = 0;

$pdf->addText($Left_Margin+2, ($YPos+$LineHeight)-$LineCount*$LineHeight+30, $FontSize, _('Customer TIN No.') . ':');
$pdf->addText($Left_Margin+12, ($YPos+$LineHeight)-$LineCount*$LineHeight+20, $FontSize, $myrow['tin']);

$pdf->addText($Left_Margin+2, ($YPos+$LineHeight)-$LineCount*$LineHeight, $FontSize, _('Customer VAT No.') . ':');
/*Print a vertical line */
$pdf->line($Left_Margin+178, $YPos+$LineHeight+31,$Left_Margin+178, $YPos-$LineHeight*2+4);
$pdf->addText($Left_Margin+180, ($YPos+$LineHeight)-$LineCount*$LineHeight, $FontSize, _('Cust. Reference No.') . ':');
/*Print a vertical line */
$pdf->line($Left_Margin+358, $YPos+$LineHeight+31,$Left_Margin+358, $YPos-$LineHeight*2+4);
$pdf->addText($Left_Margin+360, ($YPos+$LineHeight)-$LineCount*$LineHeight, $FontSize, _('Sales Person') . ':');
$LineCount += 1;
$pdf->addText($Left_Margin+12, ($YPos+$LineHeight)-$LineCount*$LineHeight, $FontSize, $myrow['taxref']);
if ($InvOrCredit=='Invoice'){
    $pdf->addText($Left_Margin+190, ($YPos+$LineHeight)-$LineCount*$LineHeight, $FontSize, $myrow['customerref']);
}
$pdf->addText($Left_Margin+370, ($YPos+$LineHeight)-$LineCount*$LineHeight, $FontSize, $myrow['salesmanname']);

$YPos -= 20;

/*draw a line */
$pdf->line($XPos, $YPos,$Page_Width-$Right_Margin, $YPos);

$YPos -= 12;

$TopOfColHeadings = $YPos;

$pdf->addText($Left_Margin+0, $YPos+12, $FontSize, _('Item Code'));
$pdf->addText($Left_Margin+90, $YPos+12, $FontSize, _('Description'));
$pdf->addText($Left_Margin+220, $YPos+12, $FontSize, _('Unit Price Incl'));
$pdf->addText($Left_Margin+300, $YPos+12, $FontSize, _('Qty'));
/*$pdf->addText($Left_Margin+340, $YPos+12, $FontSize, _('Qty'));*/
$pdf->addText($Left_Margin+330, $YPos+12, $FontSize, _('UOM'));
/*$pdf->addText($Left_Margin+420, $YPos+12, $FontSize, _('Disc.'));*/
$pdf->addText($Left_Margin+370, $YPos+12, $FontSize, _('VAT'));
$pdf->addText($Left_Margin+410, $YPos+12, $FontSize, _('Amount(Excl)'));
$pdf->addText($Left_Margin+480, $YPos+12, $FontSize, _('Amount(Incl)'));
/*$pdf->addText($Left_Margin+470, $YPos+12, $FontSize, _('Total') . ' ' .  $myrow['currcode']);*/

$YPos-=0;

/*draw a line */
$pdf->line($XPos, $YPos,$Page_Width-$Right_Margin, $YPos);

$BottomOfHeader = $YPos;
$pdf->line($Page_Width-$Right_Margin, $BottomOfHeader,$Page_Width-$Right_Margin, $Bottom_Margin+$BoxHeight);
$pdf->line($Left_Margin, $Bottom_Margin+$BoxHeight,$Left_Margin, $BottomOfHeader);

$pdf->line($Left_Margin, $Bottom_Margin+(4*$line_height),$Left_Margin,$Bottom_Margin+10);
$pdf->line($Page_Width-$Right_Margin, $Bottom_Margin+(4*$line_height),$Page_Width-$Right_Margin,$Bottom_Margin+10);

$YPos -= ($line_height);

?>
