<?php
$objPHPExcel = new PHPExcel();
// Set properties
$objSheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");

$objPHPExcel->setActiveSheetIndex(0)

	->setCellValue('A1', 'S.No.')
	->setCellValue('B1', 'Order ID')
	->setCellValue('C1', 'Name')
	->setCellValue('D1', 'Mobile')
	->setCellValue('E1', 'Amount')
	->setCellValue('F1', 'Delivery Date')
	->setCellValue('G1', 'Billing Address')
	->setCellValue('H1', 'Location')
	->setCellValue('I1', 'Pay. Mode')
	->setCellValue('J1', 'Status');


//pr($orders);die;
$cnt = 1;
if (isset($orders) && !empty($orders)) {
	foreach ($orders as $i => $people) {
		//pr($people); die;
		$ii = $i + 2;

		$objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $cnt++);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $people["id"]);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $people["user"]["name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $people["user"]["mobile"]);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $people["total_amount"]);
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, date('d-M-Y', strtotime($people['delivery_date'])));
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $people["billng_address"]);
		$objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $people["locality"]);
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $people["payment_mode"]);
		$objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $people["order_status"]);
	}
}



// Rename sheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "Export_Orders_Info_" . date('d-m-Y') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
