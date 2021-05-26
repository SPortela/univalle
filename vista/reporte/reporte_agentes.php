<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel*/
require_once '../../assets/Classes/PHPExcel.php';
include_once("../../AnsTek_libs/integracion.inc.php");
include_once("../../model/contactos.class.php");
include_once("../../model/usuarios.class.php");
include_once("../../model/hoja_ruta.class.php");

    // *****************************************************************************
	$Gestion = "";
    $user = new usuario($db);
    $whereU = " Where Us.Id > 1 AND Us.Status = 1 AND Sede = 3 ";
    $datosU  = $user->selectAll($whereU);
    $datosU2  = $user->selectAll($whereU);
    // validamos si hay datos
    if($db->numRows($datosU) > 0){
        $Duser = $db->datos($datosU);
    }
    // *****************************************************************************
    $hoja_rutaC = new  hojaruta($db);
    //echo $whereH;
    // $resultH = $hoja_rutaC->selectAll();
    // $resultH2 = $hoja_rutaC->selectAll();

    // if($db->numRows($resultH2) > 0){
    //     $r2 = $db->datos($resultH2);
    // }
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Conjunto Digital")
                 ->setLastModifiedBy("Developer")
                 ->setTitle("Office 2007 XLSX Test Document")
                 ->setSubject("Office 2007 XLSX Test Document")
                 ->setDescription("Reporte registros campaña admisiones uan.")
                 ->setKeywords("office 2007 openxml php")
                 ->setCategory("Test result file");
            // Add some data

            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Perfil')
            ->setCellValue('B1', 'Nombre')
            ->setCellValue('C1', 'Cedula')
            ->setCellValue('D1', 'Asignados')
            ->setCellValue('E1', 'Gestionados')
            ->setCellValue('F1', 'Sin Gestionar')
            ->setCellValue('G1', 'no contesta')
            ->setCellValue('H1', 'Mensaje whatsapp')
            ->setCellValue('I1', 'Agenda Cita')
            ->setCellValue('J1', 'En proceso')
            ->setCellValue('K1', 'No interesado')
            ->setCellValue('L1', 'Correo Electronico')
            ->setCellValue('M1', 'Diagnostico Aprox');


            if($db->numRows($datosU2) > 0){
                $i=2;
              while ($rU = $db->datos($datosU2)) {

                // ******************ASIGNADOS**********************
                // Objeto Contacto - Para ver numero de asignaciones.
                $Dcontac = new hojaruta($db);
                $registro = new  contacto($db);
                $whereE = " Where Asignado_a = ".$rU['Cedula'];
                $resultE = $registro->Count($whereE);
                if($db->numRows($resultE) > 0){
                  $rA = $db->datos($resultE);
                }

                // ******************CONTACTOS GESTIONADOS*************************
                // Cuenta numero de contactos gestionados
                $whereCount= " WHERE STATUS > 2 AND  Asignado_a = ". $rU['Cedula'];
                //echo $whereCount;
                $gestionados = $Dcontac->Count($whereCount);
                if($db->numRows($gestionados) > 0){
                    $rows1 = $db->datos($gestionados);

                }else{
                    Echo "No hay data";
                }

                // ******************SIN GESTIONAR*************************
                // Cuenta numero de contactos sin gestionar
                $whereCount= " WHERE rg.STATUS = 2 AND  rg.Asignado_a = ". $rU['Cedula'];
                //echo $whereCount;
                $sin_gestionar = $registro->Count($whereCount);
                if($db->numRows($sin_gestionar) > 0){
                    $rows = $db->datos($sin_gestionar);

                }else{
                    Echo "No hay data";
                }

                // ******************LLAMADAS REALIZADAS*************************
                // Cuenta numero de llamadas
                $wherePhone= " WHERE rg.STATUS = 3 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultPhone = $registro->Count($wherePhone);
                if($db->numRows($resultPhone) > 0){
                    $rowsPhone = $db->datos($resultPhone);
                }else{
                    Echo "No hay data";
                }

                // ******************Emails Enviados*************************
                // Cuenta numero de Emails
                $whereMail= " WHERE rg.STATUS = 4 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultMail = $registro->Count($whereMail);
                if($db->numRows($resultMail) > 0){
                    $rowsMail = $db->datos($resultMail);
                }else{
                    Echo "No hay data";
                }

                //******************** NO CONTESTA************************
                // Cuenta numero de contactos para volver a llamar
                $whereVolver= " WHERE rg.STATUS = 5 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultVolver = $registro->Count($whereVolver);
                if($db->numRows($resultVolver) > 0){
                    $rowsVolver = $db->datos($resultVolver);
                }else{
                    Echo "No hay data";
                }
                //******************** MENSJAE WAHTSAPP ************************
                // Cuenta numero de contactos matriculados
                $whereMatri= " WHERE rg.STATUS = 6 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultMatri = $registro->Count($whereMatri);
                if($db->numRows($resultMatri) > 0){
                    $rowsMatri = $db->datos($resultMatri);
                }else{
                    Echo "No hay data";
                }

                //******************** AGENDA CITA ************************
                // Cuenta numero de contactos inscritos
                $whereIns= " WHERE rg.STATUS = 7 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultIns = $registro->Count($whereIns);
                if($db->numRows($resultIns) > 0){
                    $rowsIns = $db->datos($resultIns);
                }else{
                    Echo "No hay data";
                }

                //******************** EN PROCESO ************************
                // Cuenta numero de contactos con numero equivocado
                $whereEqui= " WHERE rg.STATUS = 8 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultEqui = $registro->Count($whereEqui);
                if($db->numRows($resultEqui) > 0){
                    $rowsEqui = $db->datos($resultEqui);
                }else{
                    Echo "No hay data";
                }

                //******************** NO ESTA INTERESADP  ************************
                // Cuenta numero de contactos con numero equivocado
                $whereNo= " WHERE rg.STATUS = 9 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultNo = $registro->Count($whereNo);
                if($db->numRows($resultNo) > 0){
                    $rowsNo = $db->datos($resultNo);
                }else{
                    Echo "No hay data";
                }

                //******************** COREO ELECTRONICO ************************
                // Cuenta numero de contactos duplicados
                $whereDup= " WHERE rg.STATUS = 10 AND  rg.Asignado_a = ". $rU['Cedula'];
                $resultDup = $registro->Count($whereDup);
                if($db->numRows($resultDup) > 0){
                    $rowsDup = $db->datos($resultDup);
                }else{
                    Echo "No hay data";
                }

				//******************** DIAGNOSTICO APROX ************************
				// Cuenta numero de contactos finalizada la gestion
				$whereEnd= " WHERE rg.STATUS = 11 AND  rg.Asignado_a = ". $rU['Cedula'];
				$resultEnd = $registro->Count($whereEnd);
				if($db->numRows($resultEnd) > 0){
				    $rowsEnd = $db->datos($resultEnd);
				}else{
				    Echo "No hay data";
				}


                // **********************************************************************
		        //******************* GESTION *******************************
                $whE = " Where hr.Asignado_a = ". $rU['Cedula'] . " AND hr.Status >= 1 GROUP BY hr.Status";

                $resultGest = $hoja_rutaC->selectAll($whE);

                if ($db->numRows($resultGest) > 0) {

                	while ($Est = $db->datos($resultGest)) {

                		$Wcount = " Where Asignado_a = ". $rU['Cedula'] . " AND Status = ". $Est['Status'];
                		$rCount = $hoja_rutaC->Count($Wcount);
                		if ($db->numRows($rCount) > 0) {
                			$cuenta = $db->datos($rCount);
                		}else{echo 'NO HAY DATA';}

                		$Gestion =  "Aqui". $Est['Nombre_estado']. '('.$cuenta['num'].')'. '<br>';
    		        		$objPHPExcel->setActiveSheetIndex(0)
    						->setCellValue("A$i", $rU['Usuario'])
    						->setCellValue("B$i", $rU['Nombre'])
    						->setCellValue("C$i", $rU['Cedula'])
    						->setCellValue("D$i", $rA['num'])
    						->setCellValue("E$i", $rows1['num'])
    						->setCellValue("F$i", $rows['num'])
    						->setCellValue("G$i", $rowsVolver['num'])
    						->setCellValue("H$i", $rowsMatri['num'])
    						->setCellValue("I$i", $rowsIns['num'])
    						->setCellValue("J$i", $rowsEqui['num'])
    						->setCellValue("K$i", $rowsNo['num'])
    						->setCellValue("L$i", $rowsDup['num'])
    						->setCellValue("M$i", $rowsEnd['num']);
    						

                	}
                }

				$i++;
              }
            }
            else{
              echo "NO HAY REGISTROS PARA MOSTRAR";
            }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Registros_unihorizonte');
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel; charset=iso-8859-1');
        header('Content-Disposition: attachment;filename="reporte_agentes - '.date('d-m-y H:i:s').'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
