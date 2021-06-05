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
    /* Obtiene un solo registro de Experiencias */
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
      $jsondata['Origen_Campana'] = $r["Origen_Campana"];
      $jsondata['Created_date'] = $r["Created_date"];
      $jsondata['Created_by'] = $r["Created_by"];
      $jsondata['NombreCreador'] = $r["NombreCreador"];
      $jsondata['Status'] = $r["Status"];
      $jsondata['Status2'] = $r["Status2"];
      $jsondata['Fecha_asignado'] = $r["Fecha_asignado"];
      $jsondata['Usuario_agente'] = $r["Usuario_agente"];
      $jsondata['Nombre_estado'] = $r["Nombre_estado"];
      $jsondata['success'] = true;
      $jsondata['message'] = "recuperado correctamente";
    } else {
      $jsondata['success'] = false;
      $jsondata['message'] = "Fallo al obtener el registro";
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;
    /* insert  de Servicios */

  case "ins":
    $tipoAsigna = "";
    $jsondata = array();
    $mail = new PHPMailer;
    // Realiza Insert
    //Consultamos el tipo de asignacion disponible por el admin Id 1
    $whereC = " Where Us.Id = 1";
    $resultC = $datosUsuario->selectAll($whereC);
    if ($db->numRows($resultC) > 0) {
      if ($d = $db->datos($resultC)) {
        $tipoAsigna = $d['TipoAsignacion'];
      }
    }
    /*validamos el tipo de asignacion 1 Manual - 2 Automatica*/
    if ($tipoAsigna == 1) {
      /*HACEMOS ASIGNACION MANUAL ES DECIR EL REGISTRO NORMAL*/
      $data = "";
      $data = array(
        "Nombre_completo" => $_REQUEST['txtName'],
        "Celular" => $_REQUEST['txtTel'],
        "Email" => $_REQUEST['txtEmail'],
        "Tratamiento" => $_REQUEST['txtTratamiento'],
        "Ciudad" => $_REQUEST['txtCiudad'],
        "Campana_Id" => $_REQUEST['txtId'],
        "Origen_Campana" => 'Google Ads',
        "Created_date" => date("Y-m-d H:i:s"),
        "Status" => 1
      );
      if ($contacto->insertData($data)) {
        $jsondata['success'] = true;
        $jsondata['message'] = ' Gracias por registrarte ' . $_REQUEST['txtName'] . ' pronto nos comunicaremos';
        // header('Location: http://www.unihorizonte.edu.co/inscripciones2/index.php?m=1');

      } else {
        $jsondata['success'] = false;
        $jsondata['message'] = "Falla al realizar el registro";
      }
    } else {
      /*validamos de que cuidad llega el registro*/
      /*HACEMOS ASIGNACION AUTOMATICA*/

      /*VALIDAMOS QUE EL NUMERO DE CELULAR NO SE REPITA*/
      $whereCel = " Where rg.Celular = " . "'" . $_REQUEST['txtTel'] . "'";
      $resultCel = $contacto->selectAll($whereCel);
      if ($db->numRows($resultCel) > 0) {
        if ($cel = $db->datos($resultCel)) {
          $jsondata['success'] = false;
          $jsondata['message'] = "Su celular ya se encuentra registrado";
        } else {
          /*NO EXISTE EL NUMERO DE TELEFONO*/
          $data = "";
          $data = array(
            "Nombre_completo" => $_REQUEST['txtName'],
            "Celular" => $_REQUEST['txtTel'],
            "Email" => $_REQUEST['txtEmail'],
            "Tratamiento" => $_REQUEST['txtTratamiento'],
            "Ciudad" => $_REQUEST['txtCiudad'],
            "Campana_Id" => $_REQUEST['txtId'],
            "Origen_Campana" => 'Google Ads',
            "Created_date" => date("Y-m-d H:i:s"),
            "Status" => 1
          );
          if ($contacto->insertData($data)) {
            // Ya se a registrado los datos
            $jsondata['success'] = true;
            $jsondata['message'] = 'Gracias por registrarte ' . $_REQUEST['txtName'] . ' pronto nos comunicaremos';
            /*Buscamos SEDES disponibles y activos */
            $whereUser = " Where Us.Id = 3 AND Us.Status = 1 AND Us.Perfil = 1 ORDER BY Id ASC ";
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
                } else {
                  $arrayAgenteIdNoDisp[] = $rUser['Id'];
                }
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
              if (empty($arrayIdAgenteDisponible) or $arrayIdAgenteDisponible[0] == 1) {
                foreach ($arrayAgenteIdNoDisp as $key) {
                  $Disponible = array(
                    "Disponible" => 1,
                    "Updated_at" => date("Y-m-d H:i:s")
                  );
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
                    $Disponible = array(
                      "Disponible" => 1,  
                      "Updated_at" => date("Y-m-d H:i:s")
                    );
                    $WhereDisponible = " Id =" . $key;
                    $datosUsuario->updateData($Disponible, $WhereDisponible);
                  }
                }
                /*TENEMOS ID DE SEDE DISPONIBLE*/
                $IdDisponible = $arrayIdAgenteDisponible[0];
                $CedulaDisponible = $arrayCedAgenteDisponible[0];
                /*$CedulaDisponible = $arrayCedAgenteDisponible[0];$NombreDisponible = $arrayConcesionario;*/
                $whereAgentesSede = " Where Us.Id = 4 AND Us.Status = 1 AND Us.Perfil = 0 AND Us.Sede = " . $IdDisponible . " ORDER BY Id ASC ";
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
                      //print_r($arrayIdAgenteSedeDisponible);
                    } else {
                      $arrayAgenteSedeIdNoDisp[] = $rUserSede['Id'];
                    }
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
                  if (empty($arrayIdAgenteSedeDisponible) or $arrayIdAgenteSedeDisponible[0] == 1) {
                    foreach ($arrayAgenteSedeIdNoDisp as $key) {
                      $Disponible = array(
                        "Disponible" => 1,
                        "Updated_at" => date("Y-m-d H:i:s")
                      );
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
                        $Disponible = array(
                          "Disponible" => 1,
                          "Updated_at" => date("Y-m-d H:i:s")
                        );
                        $WhereDisponible = " Id =" . $key;
                        $datosUsuario->updateData($Disponible, $WhereDisponible);
                      }
                    }
                    if ($arrayIdAgenteSedeDisponible[0] == 6) {
                      $Disponible2 = array(
                        "Disponible" => 1,
                        "Updated_at" => date("Y-m-d H:i:s")
                      );
                      $WhereDisponible2 = " Id = 11";
                      $datosUsuario->updateData($Disponible2, $WhereDisponible2);
                    }

                    $IdDisponibleAgente = $arrayIdAgenteSedeDisponible[0];
                    $CedulaDisponibleAgente = $arrayCedAgenteSedeDisponible[0];
                    $NombreDisponibleAgente = $arrayConcesionarioSede;

                    $data_ruta_Sede = array(
                      "Registro_id" => $EndIdASede,
                      "Detalle" => "El contacto a sido asignado a una sede",
                      "Asignado_a" => $CedulaDisponible,
                      "Status" => 100, "Created_by" => 0,
                      "Created_date" => date("Y-m-d H:i:s")
                    );
                    $hojaRuta->insertData($data_ruta_Sede);
                    $dataUpd = array(
                      "Asignado_a" => $CedulaDisponibleAgente,
                      "Status" => 2,
                      "Fecha_asignado" => date("Y-m-d H:i:s")
                    );
                    $data_ruta = array(
                      "Registro_id" => $EndIdASede,
                      "Detalle" => "El contacto a sido asignado a un agente disponible",
                      "Asignado_a" => $CedulaDisponibleAgente,
                      "Status" => 2,
                      "Created_by" => 0,
                      "Created_date" => date("Y-m-d H:i:s")
                    );
                    $whereUpd = " Id = " . $EndId;
                    if ($contacto->updateData($dataUpd, $whereUpd)) {
                      if ($hojaRuta->insertData($data_ruta)) {
                        /*ACTIVA CON 1 PARA UTILIZAR UN SOLO AGENTE  - SI NECESITAMOS AGREGAR OTRO AGENTE DEBEMOS PONER CERO */
                        $quitarDisponible = array(
                          "Disponible" => 1,
                          "Updated_at" => date("Y-m-d H:i:s")
                        );
                        $wherequitar = " Id = " . $IdDisponibleAgente;
                        if ($datosUsuario->updateData($quitarDisponible, $wherequitar)) {
                          $quitarDisponibleSede = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                          $wherequitarSede = " Id = " . $IdDisponible;
                          if ($datosUsuario->updateData($quitarDisponibleSede, $wherequitarSede)) {
                            $jsondata['success'] = true;
                            $jsondata['message'] = ' Gracias por registrarte ' . $_REQUEST['txtName'] . ' pronto nos comunicaremos';
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
                  }
                }
              }/*CIERRE ELSE*/
            } else {
              $jsondata['success'] = false;
              $jsondata['message'] = "No hay SEDES DISPONIBLES ";
            }
          } else {
            $jsondata['success'] = false;
            $jsondata['message'] = "No fue posible registrar ";
          }
        }
      }
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;
    /*Asigna agente a los regsitros*/
  case "asignaV":
    $jsondata = array();
    $data = "";
    $data_ruta = "";
    if (isset($_POST['pId'])) {

      foreach ($_POST['pId'] as $id) {
        if ($_REQUEST['txtAgente'] == 0) {
          $data = array("Asignado_a" => $_REQUEST['txtAgente'], "Status" => 1, "Fecha_asignado" => date("Y-m-d H:i:s"));
          $msj = "Se ha borrado la asignación.";
          $data_ruta = array("Registro_id" => $id, "Detalle" => "se ha borrado la asignación", "Asignado_a" => 0, "Status" => 1, "Created_by" => $user, "Created_date" => date("Y-m-d H:i:s"));
        } else {
          $data = array("Asignado_a" => $_REQUEST['txtAgente'], "Status" => 2, "Fecha_asignado" => date("Y-m-d H:i:s"));
          $msj = "El Agente ha sido asignado correctamente";
          $data_ruta = array("Registro_id" => $id, "Detalle" => "El contacto a sido asignado a un agente", "Asignado_a" => $_REQUEST['txtAgente'], "Status" => 2, "Created_by" => $user, "Created_date" => date("Y-m-d H:i:s"));
        }
        $where = " Id = " . $id;
        if ($contacto->updateData($data, $where)) {
          if ($hojaRuta->insertData($data_ruta)) {
            $jsondata['success'] = true;
            $jsondata['message'] = $msj;
          } else {
            $jsondata['success'] = false;
            $jsondata['message'] = "No fue posible registrar hoja de ruta";
          }
        } else {
          $jsondata['success'] = false;
          $jsondata['message'] = "No fue posible asignar el agente";
        }
      }
    }

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;

    // Asigna nuevo estado desde posicion agente
  case "estado":
    $jsondata = array();
    $data = "";
    $data = array("Status" => $_REQUEST['txtStatus'], "Status2" => $_REQUEST['txtStatus2'], "Updated_by" => $user, "Updated_date" => date("Y-m-d H:i:s"));
    $where = " Id = " . $_REQUEST['txtId'];
    if ($contacto->updateData($data, $where)) {
      $data_ruta = array("Registro_id" => $_REQUEST['txtId'], "Detalle" => $_REQUEST['txtObs'], "Asignado_a" => $cedula, "Status" => $_REQUEST['txtStatus'], "Status2" => $_REQUEST['txtStatus2'], "Created_by" => $user, "Created_date" => date("Y-m-d H:i:s"));

      if ($hojaRuta->insertData($data_ruta)) {
        $jsondata['success'] = true;
        $jsondata['message'] = "Gestión realizada con exito";
      } else {
        $jsondata['success'] = true;
        $jsondata['message'] = "No fue posible registrar en hoja de ruta";
      }
    } else {
      $jsondata['success'] = false;
      $jsondata['message'] = "No fue posible realizar la gestión";
    }



    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;





    // Asigna nuevo estado desde posicion agente
  case "notificacion":
    $jsondata = array();
    $data = "";

    if ($_REQUEST['vFechaReunion'] == "") {

      $data = array("Status" => $_REQUEST['txtStatus'], "Status2" => $_REQUEST['txtStatus2'], "Updated_by" => $user, "Updated_date" => date("Y-m-d H:i:s"));
      $where = " Id = " . $_REQUEST['txtId3'];

      //echo $where;

      if ($contacto->updateData($data, $where)) {
        $data_ruta = array("Registro_id" => $_REQUEST['txtId3'], "Detalle" => $_REQUEST['txtObs'], "Asignado_a" => $cedula, "Status" => $_REQUEST['txtStatus'], "Status2" => 0, "Created_by" => $user, "Created_date" => date("Y-m-d H:i:s"));

        if ($hojaRuta->insertData($data_ruta)) {
          $jsondata['success'] = true;
          $jsondata['message'] = "Gestión realizada con exito";
        } else {
          $jsondata['success'] = true;
          $jsondata['message'] = "No fue posible registrar en hoja de ruta";
        }
      } else {
        $jsondata['success'] = false;
        $jsondata['message'] = "No fue posible realizar la gestión";
      }
    } else {


      $whereNoti = " Where Fecha_Cita = " . "'" .  $_REQUEST['vFechaReunion'] . "'";
      $resultNoti = $Notifi->selectAll($whereNoti);
      // valida la existencia de una fecha iugal
      if ($db->numRows($resultNoti) > 0) {
        if ($n = $db->datos($resultNoti)) {
          $jsondata['success'] = false;
          $jsondata['message'] = "Ya tienes una cita agendada en la fecha seleccionada ";
        } else {

          $dataNotificacion = array("Empresa_Id" => $_REQUEST['txtId3'], "Registro_Id" => $user, "Fecha_Cita" => $_REQUEST['vFechaReunion'],  "Comentario" => $_REQUEST['txtObs'],   "Status" => 1,  "Created_by" => $user, "Created_date" => date("Y-m-d H:i:s"));
          if ($Notifi->insertData($dataNotificacion)) {

            $data = array("Status" => $_REQUEST['txtStatus'], "Status2" => $_REQUEST['txtStatus2'], "Updated_by" => $user, "Updated_date" => date("Y-m-d H:i:s"));
            $where = " Id = " . $_REQUEST['txtId3'];
            if ($contacto->updateData($data, $where)) {

              $data_ruta = array("Registro_id" => $_REQUEST['txtId3'], "Detalle" => $_REQUEST['txtObs'] . " - AGENDA UNA CITA ",  "Asignado_a" => $cedula, "Fecha_Cita" => $_REQUEST['vFechaReunion'], "Status" => $_REQUEST['txtStatus'], "Status2" => $_REQUEST['txtStatus2'], "Created_by" => $user, "Created_date" => date("Y-m-d H:i:s"));

              if ($hojaRuta->insertData($data_ruta)) {

                $jsondata['success'] = true;
                $jsondata['message'] = "Gestión realizada con exito - Cita Agenda para el " . $_REQUEST['vFechaReunion'];
              } else {
                $jsondata['success'] = true;
                $jsondata['message'] = "No fue posible registrar en hoja de ruta";
              }
            } else {
              $jsondata['success'] = false;
              $jsondata['message'] = "No fue posible realizar la gestión";
            }
          } else {
            $jsondata['success'] = false;
            $jsondata['message'] = "No fue posible realizar la gestión";
          }
        }
      }
    }






    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;


    /* Gestionar agendados  */
  case "GestionAgenda":
    $jsondata = array();

    $data = "";
    $data = array("Status" => $_REQUEST['txtStatus3'], "Status2" => $_REQUEST['txtStatus23'], "Updated_by" => $user, "Updated_date" => date("Y-m-d H:i:s"));
    $where = " Id = " . $_REQUEST['txtId'];
    if ($contacto->updateData($data, $where)) {
      $data_ruta = array("Registro_id" => $_REQUEST['txtId'], "Detalle" => $_REQUEST['txtObs3'] . " - REALIZA GESTION DEL AGENDADO ",  "Asignado_a" => $cedula, "Status" => $_REQUEST['txtStatus3'], "Status2" => $_REQUEST['txtStatus23'], "Created_by" => $user, "Created_date" => date("Y-m-d H:i:s"));
      if ($hojaRuta->insertData($data_ruta)) {
        $dataNotificacion = array("Status" => 2, "Updated_by" => $user, "Updated_date" => date("Y-m-d H:i:s"));
        $whereNoti = " Id = " . $_REQUEST['IdNotificacion'];
        if ($Notifi->updateData($dataNotificacion, $whereNoti)) {

          $jsondata['success'] = true;
          $jsondata['message'] = " Gestión Realizada con exito ";
        } else {

          $jsondata['success'] = false;
          $jsondata['message'] = " Ocurrio un error1 ";
        }
      } else {
        $jsondata['success'] = false;
        $jsondata['message'] = " Ocurrio un error2 ";
      }
    } else {

      $jsondata['success'] = false;
      $jsondata['message'] = " Ocurrio un error1 ";
    }

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;


    /* Crea delete de usuarios */
  case "del":
    $Id =  $_REQUEST['pId'];
    $jsondata = array();
    if (isset($_POST['pId'])) {
      foreach ($_POST['pId'] as $id) {
        if ($contacto->delData($id)) {
          $jsondata['success'] = true;
          $jsondata['message'] = "Eliminados correctamente";
        } else {
          $jsondata['success'] = false;
          $jsondata['message'] = "Falla al Eliminar los registros";
        }
      }
    }

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;

  case "car":
    $IdSede = Session::get('Id');
    set_time_limit(30000);
    $dir_subida = '../public/registros/';
    if (!file_exists($dir_subida)) {
      mkdir($carpeta, 0777, true);
    }
    //DATOS DEL ARCHIVO
    $nombre_archivo = $_FILES['fichero_usuario']['name'];
    $destino_archivo = "../public/registros/" . $nombre_archivo;
    $temp_archivo = $_FILES['fichero_usuario']['tmp_name'];

    // $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);
    // $temp =  $_FILES['fichero_usuario']['tmp_name'];
    // echo"temporal: ". $temp_archivo . " " . "ruta de archivo ". $destino_archivo;

    if (copy($temp_archivo, $destino_archivo)) {
      // echo "El fichero es válido y se subió con éxito.\n";
      $nombreArchivo = $destino_archivo;
      $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
      $objPHPExcel->setActiveSheetIndex(0);
      $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

      for ($i = 2; $i <= $numRows; $i++) {
        //Recojemos el valor de cada columna
        $NombreCompleto = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $celular = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $email = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $tratamiento = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $ciudad = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $origen = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        error_reporting(0);
        $data = array(
          "Nombre_completo" => $NombreCompleto, 
          "Celular" => $celular,
          "Email" => $email, 
          "Tratamiento" => $tratamiento, 
          "Ciudad" => $ciudad, "Campana_Id" => 0, 
          "Origen_Campana" => $origen, 
          "Created_by" => $user, 
          "Created_date" => date("Y-m-d H:i:s"),   
          "Status" => 3
        );

        $cedulaAgente = $_REQUEST['AgenteSel'];
        if ($cedulaAgente == 1) {
          /* Codigo Asignacion A todos Automaticamente */
          if ($contacto->insertData($data)) {
            /*ASIGNACION A SEDE SALITRE*/
            /* ACTUALIZAMOS A DISPONIBLE SEDE SALITRE */
            $DisponibleSalitre = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
            $WhereupdSalitre = " Id = " . $user;
            $datosUsuario->updateData($DisponibleSalitre, $WhereupdSalitre);

            /*Buscamos SEDES disponibles y activos */
            $whereUser = " Where Us.Id = " . $user . " AND Us.Status = 1 AND Us.Perfil = 1 ORDER BY Id ASC ";
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

                  // echo "Sede Disponible";
                  // print_r($arrayIdAgenteDisponible);

                } else {
                  $arrayAgenteIdNoDisp[] = $rUser['Id'];
                }

                // echo "Sede NO Disponible";
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
                  $Disponible = array(
                    "Disponible" => 1,  
                    "Updated_at" => date("Y-m-d H:i:s")
                  );
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
                    $Disponible = array(
                      "Disponible" => 1,  "
                      Updated_at" => date("Y-m-d H:i:s")
                    );
                    $WhereDisponible = " Id =" . $key;
                    $datosUsuario->updateData($Disponible, $WhereDisponible);
                  }
                }
                /*TENEMOS ID DE SEDE DISPONIBLE*/
                $IdDisponible = $arrayIdAgenteDisponible[0];
                $CedulaDisponible = $arrayCedAgenteDisponible[0];
                /*$CedulaDisponible = $arrayCedAgenteDisponible[0];$NombreDisponible = $arrayConcesionario;*/
                $whereAgentesSede = " Where Us.Id > 2 AND Us.Status = 1 AND Us.Perfil = 0 AND Us.Sede = " . $IdDisponible . " ORDER BY Id ASC ";
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
                        $quitarDisponible = array("Disponible" => 0,  "Updated_at" => date("Y-m-d H:i:s"));
                        $wherequitar = " Id = " . $IdDisponibleAgente;
                        if ($datosUsuario->updateData($quitarDisponible, $wherequitar)) {
                          $quitarDisponibleSede = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                          $wherequitarSede = " Id = " . $IdDisponible;
                          if ($datosUsuario->updateData($quitarDisponibleSede, $wherequitarSede)) {

                            $jsondata['success'] = true;
                            $jsondata['message'] = ' Gracias por registrarte ' . $_REQUEST['txtName'] . ' pronto nos comunicaremos';

                            header("Location: ../vista/info/");
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
          } else {
            $jsondata['success'] = false;
            $jsondata['message'] = "Algo no va bien ! Revisa tu conexión";
          }
        } else {



          if ($contacto->insertData($data)) {
            /* ACTUALIZAMOS A DISPONIBLE SEDE SALITRE */
            $Agente = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
            $WhereAgente = " Cedula = " . $cedulaAgente;
            $datosUsuario->updateData($Agente, $WhereAgente);


            /* Tomamos el Id del ultimo registro*/
            $ultimo = $contacto->UltimoId();
            if ($db->numRows($ultimo) > 0) {
              if ($end = $db->datos($ultimo)) {
                $EndId = $end['Id'];
                $EndNombre = $end['Nombre_completo'];
              }
            }



            $data_ruta_Sede = array("Registro_id" => $EndId, "Detalle" => "El contacto a sido asignado a una sede", "Asignado_a" => $cedula, "Status" => 100, "Created_by" => 0, "Created_date" => date("Y-m-d H:i:s"));
            $hojaRuta->insertData($data_ruta_Sede);

            $dataUpd = array("Asignado_a" => $cedulaAgente, "Status" => 2,  "Fecha_asignado" => date("Y-m-d H:i:s"));
            $data_ruta = array("Registro_id" => $EndId, "Detalle" => "El contacto a sido asignado a un agente disponible", "Asignado_a" => $cedulaAgente, "Status" => 2, "Created_by" => 0, "Created_date" => date("Y-m-d H:i:s"));
            $whereUpd = " Id = " . $EndId;

            if ($contacto->updateData($dataUpd, $whereUpd)) {
              if ($hojaRuta->insertData($data_ruta)) {

                $quitarDisponible = array("Disponible" => 1,  "Updated_at" => date("Y-m-d H:i:s"));
                $wherequitar = " Cedula = " . $cedulaAgente;

                if ($datosUsuario->updateData($quitarDisponible, $wherequitar)) {

                  $jsondata['success'] = true;
                  $jsondata['message'] = "TODO MUY BIEN";
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
          } else {
          } //CIERRE ELSE

        } //Cierre Else

      } //CIERRE FOR

    } else {
      echo "¡Posible ataque de subida de ficheros!\n";
    }
    break;
}
