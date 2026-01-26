<?php 
// echo "test"; die;
// pr($data);die;
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
->setLastModifiedBy("Maarten Balliauw")
->setTitle("Office 2007 XLSX Test Document")
->setSubject("Office 2007 XLSX Test Document")
->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
->setKeywords("office 2007 openxml php")
->setCategory("Test result file");

$style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'S.No.')
->setCellValue('B1', 'Name')
->setCellValue('C1', 'Mobile')
->setCellValue('D1', 'Village')
->setCellValue('E1', 'Animals')
->setCellValue('F1', 'Milk Quantity')
->setCellValue('G1', 'Date');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)->getStyle("A")->applyFromArray($style);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("B")->applyFromArray($style);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("C")->applyFromArray($style);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("D")->applyFromArray($style);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("E")->applyFromArray($style);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("F")->applyFromArray($style);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("G")->applyFromArray($style);

for($i=0; $i<count($data); $i++){ 
  //  pr($data); 
 $ii = $i+2;
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i+1);
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, ucwords(strtolower($data[$i]['name'])));
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $data[$i]['mobile']);
 $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $data[$i]['villagename']);
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $data[$i]['animalCount']);
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, $data[$i]['milkQuantity']);
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, date('d-M-Y', strtotime($data[$i]['created'])));

}

$date=date('d-m-Y');
// pr($date);die;
$objPHPExcel->setActiveSheetIndex(0);
$filename = "customer_".$date.".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
