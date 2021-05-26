<?php

/** incluye todos los recursos */
include_once("../AnsTek_libs/integracion.inc.php");
include_once("../model/contactos.class.php");
include_once("../model/usuarios.class.php");
include_once("../model/hoja_ruta.class.php");
include_once("../model/notificaciones.class.php");
//require_once ("../AnsTek_libs/dllsPhp/libMailer/PHPMailerAutoload.php");
include_once("../assets/Classes/PHPExcel/IOFactory.php");
date_default_timezone_set('America/Bogota'); //configuro un nuevo timezone

/** Instancia la clase contactos*/
$contacto = new contacto($db);
$datosUsuario = new usuario($db);
/* Instancia de la clase Notificaciones*/
$Notifi = new notificacion($db);
$user = Session::get('Id');
$cedula = Session::get('Cedula');
// Instancia de la clase hoja ruja.
$hojaRuta = new hojaruta($db);
/** captura el tipo de accion a realizar*/
$accion = $_REQUEST['accion'];
/** conmutador que determina las acciones a realizar para
 * este modulo
 */
switch ($accion) {
  case "single":
    $jsondata = array();
    $where = " Where rg.Id = " . $_REQUEST['pId'];
    $result = $contacto->selectAll($where);
    if ($db->numRows($result) > 0) {
      $r = $db->datos($result);
      $jsondata['Id'] = $r["Id"];
      $jsondata['Nombre_completo'] = $r["Nombre_completo"];
      $jsondata['Celular'] = $r["Celular"];
      $jsondata['Email'] = $r["Email"];
      $jsondata['Tratamiento'] = $r["Tratamiento"];
      $jsondata['Ciudad'] = $r["Ciudad"];
      $jsondata['Mensaje'] = $r["Mensaje"];
      $jsondata['Origen_Campana'] = $r["Origen_Campana"];
      $jsondata['Created_date'] = $r["Created_date"];
      $jsondata['Status'] = $r["Status"];
      $jsondata['Status2'] = $r["Status2"];
      $jsondata['Fecha_asignado'] = $r["Fecha_asignado"];
      $jsondata['Usuario_agente'] = $r["Usuario_agente"];
      $jsondata['success'] = true;
      $jsondata['message'] = "recuperado correctamente";
    } else {
      $jsondata['success'] = false;
      $jsondata['message'] = "Fallo al obtener el registro";
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;



    // Carga contactos desde EXCEL
  case "car":
    try
    {
      echo "OrigenId: " . $_REQUEST['OrigenId'];
      $user = Session::get('Id');
      include_once("../assets/Classes/PHPExcel/IOFactory.php");
      set_time_limit(30000);
      $dir_subida = '../public/administrativo/';
      if (!file_exists($dir_subida)) {
        mkdir($carpeta, 0777, true);
      }
      //DATOS DEL ARCHIVO
      $nombre_archivo = $_FILES['fichero_usuario']['name'];
      $destino_archivo = "../public/administrativo/" . $nombre_archivo;
      $temp_archivo = $_FILES['fichero_usuario']['tmp_name'];
      if (copy($temp_archivo, $destino_archivo)) {
        //echo "El fichero es válido y se subió con éxito.\n";
        $nombreArchivo = $destino_archivo;
        $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
        $objPHPExcel->setActiveSheetIndex(0);
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        for ($i = 2; $i <= $numRows; $i++) {
          //Recojemos el valor de cada columna
          $fechaBuena = 0;
          $nombre = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
          $celular = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
          $email = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
          $tratamiento = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
          $ciudad = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
          $ciudad = ucfirst(strtolower($ciudad));
          $origen =  $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
          $origen = ucfirst(strtolower($origen));
          $data = array(
            "Nombre_completo" => $nombre, 
            "Celular" => $celular,
            "Email" => $email, 
            "Tratamiento" => $tratamiento, 
            "Ciudad" => $ciudad, 
            "Campana_Id" => 0, 
            "Origen_Campana" => $origen,  
            "Created_date" => date("Y-m-d H:i:s"),
            "Created_by" => $user,  
            "Status" => 3
          );
          $sedeSelecionada = $_REQUEST['SedeSel'];
          if ($contacto->insertData($data)) {
            $DisponibleSalitre = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
            $WhereupdSalitre = " Id = " . $sedeSelecionada;
            $datosUsuario->updateData($DisponibleSalitre, $WhereupdSalitre);
            /*Buscamos SEDES disponibles y activos */
            $whereUser = " Where Us.Id = " . $sedeSelecionada . " AND Us.Status = 1 AND Us.Perfil = 1 ORDER BY Id ASC ";
            $resultUser = $datosUsuario->selectAll($whereUser);
            if ($db->numRows($resultUser) > 0) {
              $arrayIdAgenteDisponible = array();
              $arrayCedAgenteDisponible = array();
              $arrayAgenteIdNoDisp = array();
              $arrayConcesionario = array();
              while ($rUser = $db->datos($resultUser)) {
                $Disponible = $rUser['Disponible'];
                if ($Disponible == 1) {
                  $IdAgente  = $rUser['Id'];
                  $CedulaAgente = $rUser['Cedula'];
                  $NombreConcesionario = $rUser['Nombre'];
                  $arrayIdAgenteDisponible[] = $IdAgente;
                  $arrayCedAgenteDisponible[] = $CedulaAgente;
                  $arrayConcesionario[] = $NombreConcesionario;
                  //echo "Sede Disponible";
                  //print_r($arrayIdAgenteDisponible);
                } else {
                  $arrayAgenteIdNoDisp[] = $rUser['Id'];
                }
                //echo "Sede NO Disponible";
                // print_r($arrayAgenteIdNoDisp);
                /* Tomamos el Id del ultimo registro*/
                $ultimo = $contacto->UltimoId();
                if ($db->numRows($ultimo) > 0) {
                  if ($end = $db->datos($ultimo)) {
                    $EndId = $end['Id'];
                    $EndNombre = $end['Nombre_completo'];
                  }
                }
              }/*END WHILE*/

              /* VALIDAMOS SI EL ARRAY ESTA VACIO*/
              if (empty($arrayIdAgenteDisponible) or $arrayIdAgenteDisponible[0] == 2) {
                foreach ($arrayAgenteIdNoDisp as $key) {
                  $Disponible = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                  $WhereDisponible = " Id = " . $key;
                  if ($datosUsuario->updateData($Disponible, $WhereDisponible)) {
                    $jsondata['success'] = true;
                    $jsondata['message'] = "ACTUALIZADO correctamente";
                  } else {
                    $jsondata['success'] = false;
                    $jsondata['message'] = "No fue posible Registrar sus datos";
                  }
                }
              } else {
                /* REALIZAMOS ASGINACION AL ID DISPONIBLE */
                $longitud = count($arrayIdAgenteDisponible);
                if ($longitud == 1) {
                  foreach ($arrayAgenteIdNoDisp as $key) {
                    $Disponible = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                    $WhereDisponible = " Id =" . $key;
                    $datosUsuario->updateData($Disponible, $WhereDisponible);
                  }
                }

                /*TENEMOS ID DE SEDE DISPONIBLE*/
                $IdDisponible = $arrayIdAgenteDisponible[0];
                $CedulaDisponible = $arrayCedAgenteDisponible[0];
                /*$CedulaDisponible = $arrayCedAgenteDisponible[0];$NombreDisponible = $arrayConcesionario;*/
                if ($_REQUEST['OrigenId'] == 1)
                  $whereAgentesSede = " Where Us.Id = 15 AND Us.Status = 1 AND Us.Perfil = 0 AND Us.Sede = " . $IdDisponible . " ORDER BY Id ASC ";
                else
                  $whereAgentesSede = " Where Us.Id > 1 AND Us.Status = 1 AND Us.Perfil = 0 AND Us.Sede = " . $IdDisponible . " ORDER BY Id ASC ";
                $resultAgentesSede = $datosUsuario->selectAll($whereAgentesSede);

                if ($db->numRows($resultAgentesSede) > 0) {
                  $arrayIdAgenteSedeDisponible = array();
                  $arrayCedAgenteSedeDisponible = array();
                  $arrayAgenteSedeIdNoDisp = array();
                  $arrayConcesionarioSede = array();

                  while ($rUserSede = $db->datos($resultAgentesSede)) {
                    $DisponibleAgenteSede = $rUserSede['Disponible'];
                    if ($DisponibleAgenteSede == 1) {
                      $IdAgenteSede  = $rUserSede['Id'];
                      $CedulaAgenteSede = $rUserSede['Cedula'];
                      $NombreConcesionario = $rUserSede['Nombre'];
                      $arrayIdAgenteSedeDisponible[] = $IdAgenteSede;
                      $arrayCedAgenteSedeDisponible[] = $CedulaAgenteSede;
                      $arrayConcesionarioSede[] = $NombreConcesionario;
                      // echo "Agente Disponible";
                      // print_r($arrayIdAgenteSedeDisponible);

                    } else {
                      $arrayAgenteSedeIdNoDisp[] = $rUserSede['Id'];
                    }

                    // echo "Agente NO Disponible";
                    // print_r($arrayAgenteSedeIdNoDisp);

                    /* Tomamos el Id del ultimo registro*/
                    $ultimoASede = $contacto->UltimoId();
                    if ($db->numRows($ultimoASede) > 0) {
                      if ($endSede = $db->datos($ultimoASede)) {
                        $EndIdASede = $endSede['Id'];
                        $EndNombreASede = $endSede['Nombre_completo'];
                      }
                    }
                  }/*END WHILE*/


                  /* VALIDAMOS SI EL ARRAY ESTA VACIO*/
                  if (empty($arrayIdAgenteSedeDisponible) or $arrayIdAgenteSedeDisponible[0] == 2) {

                    foreach ($arrayAgenteSedeIdNoDisp as $key) {
                      $Disponible = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                      $WhereDisponible = " Id = " . $key;
                      if ($datosUsuario->updateData($Disponible, $WhereDisponible)) {
                        $jsondata['success'] = true;
                        $jsondata['message'] = "ACTUALIZADO correctamente";
                      } else {
                        $jsondata['success'] = false;
                        $jsondata['message'] = "No fue posible Registrar sus datos";
                      }
                    }
                  } else {

                    /* REALIZAMOS ASGINACION AL ID DEL AGENTE DISPONIBLE DISPONIBLE */
                    $longitudAgentes = count($arrayIdAgenteSedeDisponible);

                    if ($longitudAgentes == 1) {
                      foreach ($arrayAgenteSedeIdNoDisp as $key) {
                        $Disponible = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                        $WhereDisponible = " Id =" . $key;
                        $datosUsuario->updateData($Disponible, $WhereDisponible);
                      }
                    }

                    if ($arrayIdAgenteSedeDisponible[0] == 6) {
                      $Disponible2 = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                      $WhereDisponible2 = " Id = 7";
                      $datosUsuario->updateData($Disponible2, $WhereDisponible2);
                    }

                    $IdDisponibleAgente = $arrayIdAgenteSedeDisponible[0];
                    $CedulaDisponibleAgente = $arrayCedAgenteSedeDisponible[0];
                    $NombreDisponibleAgente = $arrayConcesionarioSede;



                    $data_ruta_Sede = array("Registro_id" => $EndIdASede, "Detalle" => "El contacto a sido asignado a una sede", "Asignado_a" => $CedulaDisponible, "Status" => 100, "Created_by" => 0, "Created_date" => date("Y-m-d H:i:s"));
                    $hojaRuta->insertData($data_ruta_Sede);

                    $dataUpd = array("Asignado_a" => $CedulaDisponibleAgente, "Status" => 2, "Fecha_asignado" => date("Y-m-d H:i:s"));
                    $data_ruta = array("Registro_id" => $EndIdASede, "Detalle" => "El contacto a sido asignado a un agente disponible", "Asignado_a" => $CedulaDisponibleAgente, "Status" => 2, "Created_by" => 0, "Created_date" => date("Y-m-d H:i:s"));
                    $whereUpd = " Id = " . $EndId;

                    if ($contacto->updateData($dataUpd, $whereUpd)) {
                      if ($hojaRuta->insertData($data_ruta)) {
                        $quitarDisponible = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                        $wherequitar = " Id = " . $IdDisponibleAgente;
                        if ($datosUsuario->updateData($quitarDisponible, $wherequitar)) {
                          $quitarDisponibleSede = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                          $wherequitarSede = " Id = " . $IdDisponible;
                          if ($datosUsuario->updateData($quitarDisponibleSede, $wherequitarSede)) {

                            $jsondata['success'] = true;
                            $jsondata['message'] = ' Gracias por registrarte ' . $_REQUEST['txtName'] . ' pronto nos comunicaremos';

                            header("Location: ../vista/info/?n=" . $user);
                          } else {
                            $jsondata['success'] = false;
                            $jsondata['message'] = "No fue posible Registrar sus datos";
                          }
                        } else {
                          $jsondata['success'] = false;
                          $jsondata['message'] = "No fue posible Registrar sus datos";
                        }
                      } else {
                        $jsondata['success'] = false;
                        $jsondata['message'] = "No fue posible registrar hoja de ruta";
                      }
                    } else {
                      $jsondata['success'] = false;
                      $jsondata['message'] = "No fue posible asignar el agente";
                    }
                  } //CIERRE ELSE


                } else {
                }/*CIERRE ELSE*/
              }/*CIERRE ELSE AGENTE*/
            } else {
              $jsondata['success'] = false;
              $jsondata['message'] = "NO HAY SEDES DISPONIBLES";
            }
            $jsondata['success'] = true;
            $jsondata['message'] = "Registros cargados correctamente";
            $jsondata['info'] = "Número de registros cargados" . $numRows;
          } else {
            $jsondata['success'] = false;
            $jsondata['message'] = "NO SE PUEDE INSERTA EL REGISTRO CARGADO";
          }
        }
      } else {
        echo "¡Posible ataque de subida de ficheros!\n" . $_REQUEST['OrigenId'];
      }
      break;
  }
  catch(Exception $e){
    echo 'Excepción capturada: ' . $_REQUEST['OrigenId'] . ' ',  $e->getMessage(), "\n";
  }
}
