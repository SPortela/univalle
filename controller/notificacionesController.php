<?php
    /** incluye todos los recursos */
    include_once("../AnsTek_libs/integracion.inc.php");
    include_once("../model/notificaciones.class.php");

    date_default_timezone_set('America/Bogota'); //configuro un nuevo timezone

    /* Instancia de la clase Notificaciones*/
    $Notifi = new notificacion($db);


     $user= Session::get('Id');
     $cedula= Session::get('Cedula');
    // Instancia de la clase hoja ruja.

    /** captura el tipo de accion a realizar*/
    $accion = $_REQUEST['accion'];
    /** conmutador que determina las acciones a realizar para
     * este modulo
     */
    switch($accion){
    /* Obtiene un solo registro de Experiencias */
      /* Obtiene un solo registro de Estados */
        case "single":
        $jsondata = array();
        $where = " Where nt.Id = " . $_REQUEST['pId'];
        $result = $Notifi->selectAll($where);
        if($db->numRows($result) > 0)
        {
          $r = $db->datos($result);
          $jsondata['Id'] = $r["Id"];
          $jsondata['Empresa_Id'] = $r["Empresa_Id"];
          $jsondata['Fecha_Cita'] = $r["Fecha_Cita"];
          $jsondata['Comentario'] = $r["Comentario"];
          $jsondata['Status'] = $r["Status"];
          $jsondata['Nombre'] = $r["Nombre"];
          $jsondata['Email'] = $r["Email"];
          $jsondata['Celular'] = $r["Celular"];
          $jsondata['IdEmp'] = $r["IdEmp"];
          $jsondata['Registro_Id'] = $r["Registro_Id"];
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


    /* HACEMOS ACTUALIZAR*/
    case "reprograma":
     $jsondata = array();


     $data = "";
        $data = array("Fecha_Cita"=>$_REQUEST['NuevaFecha'], "Updated_date"=>date("Y-m-d H:i:s"), "Updated_by"=>$user   );



    $where = " Id = " . $_REQUEST['vId'];
    if($Notifi->updateData($data, $where)){
      $jsondata['success'] = true;
      $jsondata['message'] = "Modificado Correctamente";

    }else {
      $jsondata['success'] = false;
      $jsondata['message'] = "No fue posible Actualizar sus Datos";
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    break;




}
