<?php
    /** incluye todos los recursos */
    include_once("../AnsTek_libs/integracion.inc.php");
    include_once("../model/estados.class.php");
    /** Instancia la clase experiencia*/
    $stado = new estado($db);
    $user = 1;
    /** captura el tipo de accion a realizar*/
    $accion = $_REQUEST['accion'];
    /** conmutador que determina las acciones a realizar para
     * este modulo
     */
    switch($accion){
    /* Obtiene un solo registro de Estados */
      case "single":
      $jsondata = array();
      $where = " Where Id = " . $_REQUEST['pId'];
      $result = $stado->selectAll($where);
      if($db->numRows($result) > 0)
      {
        $r = $db->datos($result);
        $jsondata['Id'] = $r["Id"];
        $jsondata['Nombre'] = $r["Nombre"];
        $jsondata['Status'] = $r["Status"];
        $jsondata['Tipo'] = $r["Tipo"];
        $jsondata['Color'] = $r["Color"];
        $jsondata['Created_date'] = $r["Created_date"];
        $jsondata['success'] = true;
        $jsondata['message'] = "recuperado correctamente";
      }
     else
      {
          $jsondata['success'] = false;
          $jsondata['message'] = "Fallo al obtener el registro";
      }
      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
    break;
    /* insert  de Servicios */
    case "ins":
       $jsondata = array();


        /*VALIDAMOS QUE EL NUMERO DE CELULAR NO SE REPITA*/
        $whereCel = " Where Color = " . "'". $_REQUEST['txtColor']. "'";

        $resultCel = $stado->selectAll($whereCel);
        if($db->numRows($resultCel) > 0){
          if ($cel = $db->datos($resultCel)) {
            $jsondata['success'] = false;
            $jsondata['message'] = "El color seleccionado ya esta registrado, inténtelo con uno diferente  ";
          }else{
             // Realiza Insert
               $data = array("Nombre"=>$_REQUEST['txtName'], "Status"=>$_REQUEST['txtStatus'], "Tipo"=>$_REQUEST['txtTipo'], "Color"=>$_REQUEST['txtColor'],  "Created_date"=>date("Y-m-d H:i:s"));
             if($stado->insertData($data))
            {

              $jsondata['success'] = true;
              $jsondata['message'] = ' Registrado correctamente.';
             }
             else
             {
               $jsondata['success'] = false;
               $jsondata['message'] = "Falla al realizar el registro";
             }
          }
        }

       header('Content-type: application/json; charset=utf-8');
       echo json_encode($jsondata);
   break;


    /*crea update de Expereincias */

    case "upd":
      $jsondata = array();
      /*data para actualizar*/
      $data = array("Nombre"=>$_REQUEST['txtName'], "Status"=>$_REQUEST['txtStatus'], "Tipo"=>$_REQUEST['txtTipo'], "Tipo"=>$_REQUEST['txtTipo'], "Color"=>$_REQUEST['txtColor'], "Created_date"=>date("Y-m-d H:i:s"));
      $where = "Id = " . $_REQUEST['txtId'];
      if($stado->updateData($data, $where))
       {
         $jsondata['success'] = true;
         $jsondata['message'] = "Actualizado correctamente";
       }else {
        $jsondata['success'] = false;
        $jsondata['message'] = "No fue posible Actualizar sus Datos";
      }

      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
   break;


   /* Crea delete de usuarios */
   case "del":
     $Id =  $_REQUEST['pId'];
     $jsondata = array();
     if($stado->delData($Id))
     {
       $jsondata['success'] = true;
       $jsondata['message'] = "Eliminado correctamente";
     }
     else
     {
      $jsondata['success'] = false;
      $jsondata['message'] = "Falla al Desactivar el registro";
     }
     header('Content-type: application/json; charset=utf-8');
     echo json_encode($jsondata);
   break;
    }
?>