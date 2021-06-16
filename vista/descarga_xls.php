<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel*/
require_once('../assets/Classes/PHPExcel.php');
include_once("../AnsTek_libs/integracion.inc.php");
include_once("../model/contactos.class.php");

$date1 = isset($_REQUEST['txtFecha1']) ? $_REQUEST['txtFecha1'] : "";
$date2 = isset($_REQUEST['txtFecha2']) ? $_REQUEST['txtFecha2'] : "";
$CedulaAgente = isset($_REQUEST['CedulaAgente']) ? $_REQUEST['CedulaAgente'] : "";
$Perfil = isset($_REQUEST['Perfil']) ? $_REQUEST['Perfil'] : "";
$Sede = isset($_REQUEST['Id']) ? $_REQUEST['Id'] : "";

if ($date1 != "" and $date2 != "") {
	$where  = " rg.Created_date BETWEEN '" .  $date1 . " 00:00:00'" . " AND '" . $date2 . " 23:59:59' AND ";
} else {
	if ($date1 != "")
		$where  = " rg.Created_date BETWEEN '" .  $date1 . " 00:00:00'" . " AND '" . $date1 . " 23:59:59' AND ";
	else if (($date2 != ""))
		$where  = " rg.Created_date BETWEEN '" .  $date2 . " 00:00:00'" . " AND '" . $date2 . " 23:59:59' AND ";
	else {
		$hoy = date("Y-m-d");
		$where  = " rg.Created_date BETWEEN '" .  $hoy . " 00:00:00'" . " AND '" . $hoy . " 23:59:59' AND ";
	}
}

if ($Perfil == 0)
	$where = $where . " rg.Asignado_a = '" . $CedulaAgente . "'";
else if ($Perfil == 1)
	$where = $where . " rg.Sede = " . $Sede;
else if ($Perfil == 2)
	$where = $where . " rg.Origen_Campana = 'Google Ads' ";

$where = " WHERE " . $where . " ORDER BY rg.Created_date DESC ";

$user = new contacto($db);
$result = $user->selectDescarga($where);
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Conjunto Digital")
	->setLastModifiedBy("Developer")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Reporte registros campaña.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");

$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Nombres')
	->setCellValue('B1', 'Celular')
	->setCellValue('C1', 'Email')
	->setCellValue('D1', 'Programa')
	->setCellValue('E1', 'Nombre_estado')
	->setCellValue('F1', 'Asignado_a')
	->setCellValue('G1', 'Fecha Registro')
	->setCellValue('H1', 'Ciudad');

if ($Perfil == 2) {
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('I1', 'Campana_Id')
		->setCellValue('J1', 'Origen_Campaña');
}

if ($db->numRows($result) > 0) {
	$i = 2;
	$numReg = $db->numRows($result);
	while ($r = $db->datos($result)) {
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$i", $r['Nombre_completo'])
			->setCellValue("B$i", $r['Celular'])
			->setCellValue("C$i", $r['Email'])
			->setCellValue("D$i", $r['Tratamiento'])
			->setCellValue("E$i", $r['Nombre_estado'])
			->setCellValue("F$i", $r['Asignado_a'])
			->setCellValue("G$i", $r['Created_date'])
			->setCellValue("H$i", $r['Ciudad']);

		if ($Perfil == 2) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("I$i", $r['Campana_Id'])
				->setCellValue("J$i", $r['Origen_Campana']);
		}
		$i++;
	}
} else {
	echo "NO HAY REGISTROS PARA MOSTRAR";
}
$objPHPExcel->getActiveSheet()->setTitle('Registros_Univalle');
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=iso-8859-1');
header('Content-Disposition: attachment;filename="ContactosUnivalle - ' . date('d-m-y H:i:s') . '.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
