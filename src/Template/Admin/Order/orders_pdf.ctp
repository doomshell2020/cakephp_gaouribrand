<?php
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, true);
$pdf->SetPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->AddPage();

// $pdf->SetFont('freesans', '', 10);
$pdf->SetFont('freesans', '', 8, '', 'false');
TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);


  $pdf->SetTitle("Orders List");
  $html.='
  <table width="100%" border-collapse: collapse; style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;">
  <thead>
  <tr>
  <th width="5%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">S.No</th> 

  <th width="7%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Order ID</th>  

  <th width="12%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Name</th>
  
  <th width="10%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Mobile</th>  

  <th width="7%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Amount</th>  

  <th width="10%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Delivery Date</th>
   
  <th width="20%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Billing Address</th> 

  <th width="8%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Location</th> 

  <th width="8%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Pay. Mode</th> 

  <th width="8%" style="border: 1px solid #ddd; padding: 8px; padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #4CAF50; color: white;">Status</th> 

  </tr>
    </thead>
  <tbody>';

  $i=1;
  if($orders){
  foreach($orders as $key => $value){
//   pr($orders); die;
    // $sub_cat=$this->Comman->company($value['id']);
    foreach($value as $values){
      $att[] = $values['id'];
    }
    // $List = implode(', ', $att); 
    if($i%2==0)
    {
    $html.='
  <tr style="background-color: white;">';
    }else{
      $html.='
      <tr style="background-color: #f2f2f2;">';
    }

  $html.='
  <td width="5%" style="border: 1px solid #ddd; padding: 8px;">'.$i.'</td>
  <td width="7%" style="border: 1px solid #ddd; padding: 8px;">#'.$value['id'].'</td>
  <td width="12%" style="border: 1px solid #ddd; padding: 8px;">'.$value['user']['name'].'</td>
  <td width="10%" style="border: 1px solid #ddd; padding: 8px;">'.$value['user']['mobile'].'</td>
  <td width="7%" style="border: 1px solid #ddd; padding: 8px;">'.$value['total_amount'].'</td>
  <td width="10%" style="border: 1px solid #ddd; padding: 8px;">'.date('d-M-Y', strtotime($value['delivery_date'])).'</td>
  <td width="20%" style="border: 1px solid #ddd; padding: 8px;">'.$value['billng_address'].'</td>
  <td width="8%" style="border: 1px solid #ddd; padding: 8px;">'.$value['locality'].'</td>
  <td width="8%" style="border: 1px solid #ddd; padding: 8px;">'.$value['payment_mode'].'</td>
  <td width="8%" style="border: 1px solid #ddd; padding: 8px;">'.$value['order_status'].'</td>
  </tr>';
  $i++;
  }
  }else{
   $html.='<br><br><br><tr><td>No Data Found</td></tr>'; 
  } 

  $html.='
  </tbody>
  </table>';
  //echo $html;die;
  //$pdf->WriteHTML($html);
  $pdf->WriteHTML($html, true, 0, true, 0);
  ob_end_clean();
  echo $pdf->Output('Orders List.pdf'); 
  

exit;