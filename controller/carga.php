<?php
  include_once("../AnsTek_libs/integracion.inc.php");
  include_once("../model/contactos.class.php");
  include_once("../model/usuarios.class.php");
  include_once("../model/hoja_ruta.class.php");
  //require_once ("../AnsTek_libs/dllsPhp/libMailer/PHPMailerAutoload.php");
  include_once("../assets/Classes/PHPExcel/IOFactory.php");
  date_default_timezone_set('America/Bogota');

    /** Instancia la clase contactos*/
    $contacto = new contacto($db);


  set_time_limit(30000);
            $dir_subida = '../public/registros/';
            if (!file_exists($dir_subida)) {
                mkdir($carpeta, 0777, true);
            }
            //DATOS DEL ARCHIVO
            $nombre_archivo = $_FILES['fichero_usuario']['name'];
            $destino_archivo = "../public/registros/".$nombre_archivo;
            $temp_archivo = $_FILES['fichero_usuario']['tmp_name'];


            // $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);
            // $temp =  $_FILES['fichero_usuario']['tmp_name'];

           // echo"temporal: ". $temp_archivo . " " . "ruta de archivo ". $destino_archivo;



            if (copy($temp_archivo, $destino_archivo )) {
               // echo "El fichero es válido y se subió con éxito.\n";
                  $nombreArchivo = $destino_archivo;
                    $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
                    $objPHPExcel->setActiveSheetIndex(0);
                    $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


                    for ($i=2; $i <= $numRows; $i++) {
                      //Recojemos el valor de cada columna
                      $nombre = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                      $celular = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                      $email = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                      $tratamiento = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                      $ciudad = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                      $origen = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();





                      $data = array("Nombre_completo"=>$nombre, "Celular"=>$celular,
                          "Email"=>$email, "Tratamiento"=>$tratamiento, "Ciudad"=>$ciudad, "Campana_Id"=>0, "Origen_Campana"=>$origen, "Created_date"=>date("Y-m-d H:i:s"), "Status"=>3);
                      $contacto->insertData($data);

                      echo "AQIU";

                    }

            } else {
                echo "¡Posible ataque de subida de ficheros!\n";
            }




 ?>
