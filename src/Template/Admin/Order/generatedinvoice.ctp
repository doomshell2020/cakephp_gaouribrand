<?php 
class xtcpdf extends TCPDF {
}
 //$subject=$this->Comman->findexamsubjectsresult($students['id'],$students['section']['id'],$students['acedmicyear']);

   $this->set('pdf', new TCPDF('1','mm','A4'));
$pdf = new TCPDF("H", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->setHeaderMargin(0);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, 0);
//$pdf->SetMargins(5, 0, 5, true);

$pdf->SetFont('', '', 6, '', 'true');
TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);

//$studetails=$this->Comman->findstudetails($sid);
  //pr($totlorderpdf['id']); die;
$ordercreate = date('d-m-Y', strtotime($order['order_date']));
 $invoicedate = date('d-m-Y', strtotime($order['order_date']));
 $admin=$this->Comman->user();
 function numberTowords($num)
{

$ones = array(
0 =>"ZERO",
1 => "ONE",
2 => "TWO",
3 => "THREE",
4 => "FOUR",
5 => "FIVE",
6 => "SIX",
7 => "SEVEN",
8 => "EIGHT",
9 => "NINE",
10 => "TEN",
11 => "ELEVEN",
12 => "TWELVE",
13 => "THIRTEEN",
14 => "FOURTEEN",
15 => "FIFTEEN",
16 => "SIXTEEN",
17 => "SEVENTEEN",
18 => "EIGHTEEN",
19 => "NINETEEN",
"014" => "FOURTEEN"
);
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY",
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
		$i=substr($i,1,5);
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
} 
if($decnum > 0){
$rettxt .= " and ";
if($decnum < 20){
$rettxt .= $ones[$decnum];
}elseif($decnum < 100){
$rettxt .= $tens[substr($decnum,0,1)];
$rettxt .= " ".$ones[substr($decnum,1,1)];
}
}
return $rettxt;
}
 //pr($order); die;
 
$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html.='
<table width="100%">
<tr>
<td width="50%">

</td>

<td width="50%">
<h5 style="text-align:right; font-size:14px; font-weight:bold;">Tax Invoice/Bill of Supply/Cash Memo</h5>
<h6 style="text-align:right; font-size:12px; font-weight:normal;">(Original for Recipient)</h6>
</td>
</tr>
</table>


<br>
<br>
<br>

<table width="100%">
<tr>
<td width="49%">


<h4 style="background-color:#f3f3f3;  color:#000; text-align:left; height:25px; line-height:28px; font-size:12px; margin:0px; verticale-align:30px;"> &nbsp; Sold By</h4>
<p></p>
<p style="text-align:left; color:#000; font-size:10px; height:8px; line-height:8px;"> &nbsp; Nusearch Pharma</p>
<p style="text-align:left; color:#000; font-size:10px;height:8px; line-height:8px;"> &nbsp; 
J-11 Subhash Marg C Scheme, <br><br>   Jaipur Rajasthan<br><br>
  (South) - 302001</p>
</td>

<td width="2%"></td>
<td width="49%">
<h4 style="background-color:#f3f3f3; padding:5px; color:#000; text-align:right; height:25px; line-height:25px; font-size:12px;"> &nbsp; Billing Address  &nbsp; </h4>
<p></p>
<p style="text-align:right; color:#000; font-size:10px; height:8px; line-height:20px;">'.$order['billng_address'].' &nbsp; </p>
<p style="text-align:right; color:#000; font-size:10px; height:8px; line-height:8px;">'.$order['user']['firm_name'].' &nbsp; </p>
</td>
</tr>
</table>


<br>
<br>
<br>
<table width="100%">
<tr>
<td width="49%">
<p style="text-align:left; color:#000; font-size:10px; height:8px; line-height:8px;"> &nbsp; <strong>GST Registration No:'.$admin['gst_no'].'</strong>  </p>
</td>


<td width="2%"></td>
<td width="49%">
<p style="text-align:right; color:#000; font-size:10px; height:8px; line-height:8px;">  <strong>GST Registration No: '.$order['user']['gst_no'].'</strong>  &nbsp; </p>



</td>
</tr>
</table>

<br>
<br>
<br>

<table width="100%">
<tr>
<td width="51%"></td>

<td width="49%">
<h4 style="background-color:#f3f3f3; padding:5px; color:#000; text-align:right; height:25px; line-height:25px; font-size:12px;"> &nbsp; Shipping Address  &nbsp; </h4>
<p></p>
<p style="text-align:right; color:#000; font-size:10px; height:8px; line-height:20px;"> '.$order['billng_address'].'&nbsp; </p>
<p style="text-align:right; color:#000; font-size:10px; height:8px; line-height:8px;">'.$order['user']['firm_name'].' &nbsp; </p>
</td>
</td>
</tr>
</table>


<br><br>
<table width="100%">
<tr>
<td width="49%">
<p style="text-align:left; color:#000; font-size:10px; height:8px; line-height:8px;"> &nbsp; <strong>Invoice Number:  </strong> #'.$order['id'].' </p>

<p style="text-align:left; color:#000; font-size:10px; height:8px; line-height:8px;"> &nbsp; <strong>Invoice Date: '.$ordercreate.'</strong> </p>
</td>


<td width="2%"></td>
<td width="49%">
<p style="text-align:right; color:#000; font-size:10px; height:8px; line-height:8px;">  <strong>GST Registration No: '.$order['user']['gst_no'].'</strong>  &nbsp; </p>

</td>
</tr>
</table>

<br><br>
<table width="100%">
<tr>
<td width="6%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> S.
No</td>
<td width="22%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Product Name </td>
<td width="10%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Unit
Price <span style="font-size:8px; text-align:right;">(Rs) &nbsp;</span></td>
<td width="5%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Qty</td>
<td width="13%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Net
Amount</td>
<td width="7%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Tax
Rate</td>
<td width="12%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Tax
Type</td>
<td width="12%" style="font-size:10px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Tax
Amount <span style="font-size:8px; text-align: right;">(Rs) &nbsp;</span></td>
<td width="13%" style="font-size:10px; text-align:center; border-right:1px solid #000;border-top:1px solid #000; border-bottom:1px solid #000; background-color:#ddd;"> Total
Amount <span style="font-size:8px; text-align: right;">(Rs) &nbsp;</span></td>
</tr>';



$total_product_gst_amnt =0;
$total_net_amnt =0;
$i=1; foreach  ($order['order_details'] as $value) { // pr($value); die;

$unit_price = $value['net_price']; 
$totalprice = $unit_price*$value['quantity'];
$total_net_amnt += $totalprice;
$product_gst = $value['cgst']+$value['sgst']+$value['igst'];

if($value['igst']){
  $applied_gst = "IGST";
}else{
  $applied_gst = "CGST+SGST";
}

$gsttotal = $totalprice * $product_gst/100;
$final_price = $totalprice + $gsttotal;
$total_weight = $order['total_weight']/1000;
$product=$this->Comman->product($value['product_id']);
$total_product_gst_amnt += round($gsttotal);
$html.= '<tr>
<td width="6%" style="font-size:9px; text-align:center; border-right:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;  border-top:1px solid #000;">'.$i.'</td>
<td width="22%" style="font-size:9px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;">'.$product['name'].'</td>

<td width="10%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;">'.number_format((float)$unit_price, 2, '.', '').' &nbsp;</td>
<td width="5%" style="font-size:9px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"> '.$value['quantity'].'</td>
<td width="13%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000;  border-top:1px solid #000;"> '.number_format((float)$total_net_amnt, 2, '.', '').' &nbsp;</td>
<td width="7%" style="font-size:9px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"> '.$order['total_gst'].'%</td>
<td width="12%" style="font-size:9px; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;  border-top:1px solid #000;"> '.$applied_gst.'</td>
<td width="12%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000;  border-top:1px solid #000;">'.number_format((float)$gsttotal, 2, '.', '').' &nbsp;</td>
<td width="13%" style="font-size:9px; text-align:right; border-right:1px solid #000;border-top:1px solid #000; border-bottom:1px solid #000; ">'.number_format((float)$final_price, 2, '.', '').' &nbsp;</td>
</tr>';
$i++; }




$html.= '<tr>
<td width="87%" style="font-size:10px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-left:1px solid #000;"> Total Net Amount &nbsp;</td>


<td width="13%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"> Rs. '.number_format((float)$total_net_amnt, 2, '.', '').' &nbsp;</td>
</tr>

<tr>
<td width="87%" style="font-size:10px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-left:1px solid #000;">  Total Weight &nbsp;</td>


<td width="13%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;">'.$total_weight.'kg &nbsp;</td>
</tr>

<tr>
<td width="87%" style="font-size:10px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-left:1px solid #000;">  Total Freight &nbsp;</td>


<td width="13%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;">Rs. '.number_format((float)$order['total_freight'], 2, '.', '').' &nbsp;</td>
</tr>

<tr>
<td width="87%" style="font-size:10px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-left:1px solid #000;">  Total Tax Amount &nbsp;</td>


<td width="13%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;">Rs. '.number_format((float)$total_product_gst_amnt, 2, '.', '').' &nbsp;</td>
</tr>

<tr>
<td width="87%" style="font-size:10px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-left:1px solid #000;"> <b>Grand Total &nbsp;</b></td>


<td width="13%" style="font-size:9px; text-align:right; border-right:1px solid #000; border-bottom:1px solid #000; background-color:#ddd; border-top:1px solid #000;"><b>Rs. '.round($order['total_amount']).'.00 &nbsp;</b></td>
</tr>

<tr>

<td width="100%" style="font-size:10px; text-align:left; font-weight:bold; border-right:1px solid #000;border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; "> &nbsp; Amount in Words:<br>
 &nbsp;'.numberTowords(round($order['total_amount'])).'</td>
</tr>


<tr>

<td width="100%" style="font-size:10px; text-align:right; font-weight:bold; border-right:1px solid #000;border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; "> For Nusearch Pharma: &nbsp; <br><br><br><br>
 Authorized Signatory  &nbsp; </td>
</tr>
</table>
';

$pdf->writeHTMLCell(0, 0, '', '', utf8_encode($html), 0, 1, 0, true, '', true);
//$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('orderlist.pdf');
exit;
?>




