<?php

/** incluye todos los recursos */
include_once("../AnsTek_libs/integracion.inc.php");
include_once("../model/contactos.class.php");
include_once("../model/hoja_ruta.class.php");


date_default_timezone_set('America/Bogota'); //configuro un nuevo timezone

/** Instancia la clase contactos*/
$contacto = new contacto($db);


 $user= Session::get('Id');
 $cedula= Session::get('Cedula');
// Instancia de la clase hoja ruja.
$hojaRuta = new hojaruta($db);


/** captura el tipo de accion a realizar*/
$accion = $_REQUEST['accion'];

switch($accion){


/* Obtiene un solo registro de Experiencias */
  case "single":

   $jsondata = array();
   $where = " Where rg.Id = " . $_REQUEST['pId'];
   $result = $contacto->selectAll($where);
   if($db->numRows($result) > 0)
   {
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
     $jsondata['NombreCreador'] = $r["NombreCreador"];
     $jsondata['Status'] = $r["Status"];
     $jsondata['Status2'] = $r["Status2"];
     $jsondata['Fecha_asignado'] = $r["Fecha_asignado"];
     $jsondata['Usuario_agente'] = $r["Usuario_agente"];

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



  case "ins":
  	$jsondata = array();
  	/*HACEMOS ASIGNACION MANUAL ES DECIR EL REGISTRO NORMAL*/
  	  $data = "";
  	    $data = array("Nombre_completo"=>$_REQUEST['txtName'],
  	     "Celular"=>$_REQUEST['txtCel'],  "Email"=>$_REQUEST['txtEmail'],
  	     "Tratamiento"=>$_REQUEST['txtTratamiento'], "Ciudad"=>$_REQUEST['txtCity'],
  	       "Campana_Id"=>$_REQUEST['txtId'], "Origen_Campana"=>"Organico Recepción", "Created_by"=>$user,  "Created_date"=>date("Y-m-d H:i:s") , "Status"=>1, "Status2"=>$_REQUEST['txtStatus2']);


  	/*VALIDAMOS QUE EL NUMERO DE CELULAR NO SE REPITA*/
  	$whereCel = " Where rg.Celular = " . "'". $_REQUEST['txtCel']. "'";
  	$resultCel = $contacto->selectAll($whereCel);
  	if($db->numRows($resultCel) > 0){
  	  if ($cel = $db->datos($resultCel)) {
  	    $jsondata['success'] = false;
  	    $jsondata['message'] = "El célular ya se encuentra registrado, inténtelo con uno diferente ";
  	  }else{

  	  	/*REALIZAMOS REGSITRO NORMAL*/
  	  	 if($contacto->insertData($data))
  	  	{

  	  		/* Tomamos el Id del ultimo registro*/
  	  		$ultimoASede = $contacto->UltimoId();
  	  		if($db->numRows($ultimoASede) > 0){
  	  		  if($endSede = $db->datos($ultimoASede)) {
  	  		    $EndIdASede = $endSede['Id'];
  	  		    $EndNombreASede = $endSede['Nombre_completo'];
  	  		  }
  	  		}


  	  		$data_ruta2 = array("Registro_id"=>$EndIdASede, "Detalle"=>"El contacto a sido registrado organicamente desde Recepción", "Asignado_a"=>0, "Status"=>1, "Created_by"=>$user, "Created_date"=>date("Y-m-d H:i:s"));

  	  		if($hojaRuta->insertData($data_ruta2)){

  	  			$jsondata['success'] = true;
  	  			$jsondata['message'] = ' Gracias por registrarte pronto nos comunicaremos';

  	  		}else{
  	  			$jsondata['success'] = false;
  	  			$jsondata['message'] = "NO FUE POSIBLE REGISTRAR HOJA RUTA";
  	  		}

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



      case "insSede":
    $jsondata = array();
    /*HACEMOS ASIGNACION MANUAL ES DECIR EL REGISTRO NORMAL*/
      $data = "";
        $data = array("Nombre_completo"=>$_REQUEST['txtName'],
         "Celular"=>$_REQUEST['txtCel'],  "Email"=>$_REQUEST['txtEmail'],
         "Tratamiento"=>$_REQUEST['txtTratamiento'], "Ciudad"=>$_REQUEST['txtCity'],
           "Campana_Id"=>$_REQUEST['txtId'], "Origen_Campana"=>"Organico Sede", "Created_by"=>$user,  "Created_date"=>date("Y-m-d H:i:s") , "Status"=>1, "Status2"=>$_REQUEST['txtStatus2']);


    /*VALIDAMOS QUE EL NUMERO DE CELULAR NO SE REPITA*/
    $whereCel = " Where rg.Celular = " . "'". $_REQUEST['txtCel']. "'";
    $resultCel = $contacto->selectAll($whereCel);
    if($db->numRows($resultCel) > 0){
      if ($cel = $db->datos($resultCel)) {
        $jsondata['success'] = false;
        $jsondata['message'] = "El célular ya se encuentra registrado, inténtelo con uno diferente ";
      }else{

        /*REALIZAMOS REGSITRO NORMAL*/
         if($contacto->insertData($data))
        {

          /* Tomamos el Id del ultimo registro*/
          $ultimoASede = $contacto->UltimoId();
          if($db->numRows($ultimoASede) > 0){
            if($endSede = $db->datos($ultimoASede)) {
              $EndIdASede = $endSede['Id'];
              $EndNombreASede = $endSede['Nombre_completo'];
            }
          }


          $data_ruta2 = array("Registro_id"=>$EndIdASede, "Detalle"=>"El contacto a sido registrado organicamente desde la sede ", "Asignado_a"=>0, "Status"=>1, "Created_by"=>$user, "Created_date"=>date("Y-m-d H:i:s"));

          if($hojaRuta->insertData($data_ruta2)){

            $jsondata['success'] = true;
            $jsondata['message'] = ' Gracias por registrarte pronto nos comunicaremos';

          }else{
            $jsondata['success'] = false;
            $jsondata['message'] = "NO FUE POSIBLE REGISTRAR HOJA RUTA";
          }

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


  case "insPerfil":
    $jsondata = array();
    /*HACEMOS ASIGNACION MANUAL ES DECIR EL REGISTRO NORMAL*/
      $data = "";
        $data = array("Nombre_completo"=>$_REQUEST['txtName'],
         "Celular"=>$_REQUEST['txtCel'],  "Email"=>$_REQUEST['txtEmail'],
         "Tratamiento"=>$_REQUEST['txtTratamiento'], "Ciudad"=>$_REQUEST['txtCity'],
           "Campana_Id"=>$_REQUEST['txtId'], "Origen_Campana"=>"Orgánico", "Created_by"=>$user,  "Created_date"=>date("Y-m-d H:i:s") , "Status"=>2, "Status2"=>$_REQUEST['txtStatus2'], "Asignado_a"=>$_REQUEST['txtCedulaA'], "Fecha_asignado"=>date("Y-m-d H:i:s"));


    /*VALIDAMOS QUE EL NUMERO DE CELULAR NO SE REPITA*/
    $whereCel = " Where rg.Celular = " . "'". $_REQUEST['txtCel']. "'";
    $resultCel = $contacto->selectAll($whereCel);
    if($db->numRows($resultCel) > 0){
      if ($cel = $db->datos($resultCel)) {
        $jsondata['success'] = false;
        $jsondata['message'] = "El célular ya se encuentra registrado, inténtelo con uno diferente ";
      }else{

        /*REALIZAMOS REGSITRO NORMAL*/
         if($contacto->insertData($data))
        {

          /* Tomamos el Id del ultimo registro*/
          $ultimoASede = $contacto->UltimoId();
          if($db->numRows($ultimoASede) > 0){
            if($endSede = $db->datos($ultimoASede)) {
              $EndIdASede = $endSede['Id'];
              $EndNombreASede = $endSede['Nombre_completo'];
            }
          }


          $data_ruta2 = array("Registro_id"=>$EndIdASede, "Detalle"=>"El contacto a sido registrado, orgánicamente y asignado al mismo perfil", "Asignado_a"=>$_REQUEST['txtCedulaA'], "Status"=>2, "Created_by"=>$user, "Created_date"=>date("Y-m-d H:i:s"));

          if($hojaRuta->insertData($data_ruta2)){

            $jsondata['success'] = true;
            $jsondata['message'] = ' Registro exitoso ! ';

          }else{
            $jsondata['success'] = false;
            $jsondata['message'] = "NO FUE POSIBLE REGISTRAR HOJA RUTA";
          }

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





  case "upd":
  	$jsondata = array();
  	/*HACEMOS ASIGNACION MANUAL ES DECIR EL REGISTRO NORMAL*/
  	  $data = "";
  	    $data = array("Nombre_completo"=>$_REQUEST['txtName'],
  	     "Celular"=>$_REQUEST['txtCel'],  "Email"=>$_REQUEST['txtEmail'],
  	     "Tratamiento"=>$_REQUEST['txtTratamiento'], "Ciudad"=>$_REQUEST['txtCity'],
  	        "Origen_Campana"=>"Organico Recepción", "Updated_by"=>$user,  "Updated_date"=>date("Y-m-d H:i:s"), "Status2"=>$_REQUEST['txtStatus2'] );


  	/*VALIDAMOS QUE EL NUMERO DE CELULAR NO SE REPITA*/
  		$whereU = " Id = " .$_REQUEST['txtId'];

  	  	/*REALIZAMOS REGSITRO NORMAL*/
  	  	 if($contacto->updateData($data, $whereU))
  	  	{

  	  		$data_ruta2 = array("Registro_id"=>$_REQUEST['txtId'], "Detalle"=>"El contacto a sido actualizado ", "Asignado_a"=>0, "Status"=>1,  "Created_by"=>$user, "Created_date"=>date("Y-m-d H:i:s"));

  	  		if($hojaRuta->insertData($data_ruta2)){

  	  			$jsondata['success'] = true;
  	  			$jsondata['message'] = ' ACTUALIZADO ';

  	  		}else{
  	  			$jsondata['success'] = false;
  	  			$jsondata['message'] = "NO FUE POSIBLE REGISTRAR HOJA RUTA";
  	  		}

  	  	 }
  	  	 else
  	  	 {
  	  	   $jsondata['success'] = false;
  	  	   $jsondata['message'] = "Falla al realizar el registro";
  	  	 }






  	  header('Content-type: application/json; charset=utf-8');
  	  echo json_encode($jsondata);
  break;




}












?>