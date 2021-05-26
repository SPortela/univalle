<?php
	/** incluye todos los recursos */
  include_once("../AnsTek_libs/integracion.inc.php");
	Session::valida_sesion("","../../index.php");
  include_once("../model/usuarios.class.php");
  /** Instancia la clase usuarios*/
	$objUser = new usuario($db);
	$vname = Session::get('Id');
  /** captura el tipo de accion a realizar*/
  $accion = $_REQUEST['accion'];
	/** conmutador que determina las acciones a realizar para
	 * este modulo
	 */
	switch($accion){
    /* Obtiene un solo registro de usuario */
		case "single":
		$jsondata = array();
      $where = " Where Us.Id = " . $_REQUEST['pId'];
      $result = $objUser->selectAll($where);
      if($db->numRows($result) > 0)
      {
        $r = $db->datos($result);
		$jsondata['Id'] = $r["Id"];
		$jsondata['Nombre'] = $r["Nombre"];
		$jsondata['Cedula'] = $r["Cedula"];
		$jsondata['Direccion'] = $r["Direccion"];
		$jsondata['Telefono'] = $r["Telefono"];
		$jsondata['Email'] = $r["Email"];
		$jsondata['Usuario'] = $r["Usuario"];
		$jsondata['Foto'] = $r["Foto"];
		$jsondata['Status'] = $r["Status"];
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
    /* Crea insert de usuarios */
    case "ins":
    $jsondata = array();
      // Datos necesarios para el registro
	$data = array("Nombre"=>$_REQUEST['txtName'],"Cedula"=>$_REQUEST['txtDoc'], "Direccion"=>$_REQUEST['txtDir'],
	        "Telefono"=>$_REQUEST['txtTel'], "Email"=>$_REQUEST['txtEml'],
	        "Usuario"=>$_REQUEST['txtUser'], "Password"=>md5($_REQUEST['txtPass']), "Perfil"=>$_REQUEST['SelPerfil'], "Sede"=>$_REQUEST['SelSuper'], "Status"=>1, "Sede"=>$vname, "Created_at"=>date('Y-m-d H:i:s')
	      );
		// clausulas where para validar cedula y usuario
      $whereC = " Where Us.Cedula = " . $_REQUEST['txtDoc'];
      $whereU = " Where Us.Usuario = " . "'". $_REQUEST['txtUser']. "'";
       $resultC = $objUser->selectAll($whereC);
       // valida la existencia de una cedula igual
       if($db->numRows($resultC) > 0){
	       	if ($r = $db->datos($resultC)) {
	       		$jsondata['success'] = false;
	       		$jsondata['message'] = "El numero de cedula ya existe";
	       	}else{
	       		// valida si hay un nombre de ususario igual
   		   		$resultU = $objUser->selectAll($whereU);
   		   		if($db->numRows($resultU) > 0){
   		   			if ($u = $db->datos($resultU)) {
   		   				$jsondata['success'] = false;
   		   				$jsondata['message'] = "El nombre de Usuario ya existe";
   		   			}else{
   		   				// Tomamos el formato de la imagen adjuntada
   		   				$vType = substr($_FILES['txtImg']['name'], strlen($_FILES['txtImg']['name'])-3, strlen($_FILES['txtImg']['name']));
   		   				// validamos el formato de la imagen 'png' o 'jpg'

   		   				if(($vType == "png") or ($vType == "jpg")){
   		   					// realiza el registro a la base de datos

   		   					if($objUser->insertData($data))
   		   					{

   		   						/* Tomamos el Id del ultimo registro*/
   		   						$vId = $db->lastInsert();

   		   						//echo "Ultimo Id ". $vId;

   		   						// creamos la carpeta
   		   						$carpeta = "../public/usuarios/".$vId;
   		   						if (!file_exists($carpeta)) {
   		   						    mkdir($carpeta, 0777, true);
   		   						}
   		   						// datos de la imagen necesarios para el registro
   		   						$name = $_FILES['txtImg']['name'];
   		   						$destino = "../public/usuarios/".$vId."/".$name;
   		   						$dest = "public/usuarios/".$vId."/".$name."'-";
   		   						$ruta = $_FILES['txtImg']['tmp_name'];
   		   						// se mueve el archivo en la carpeta indicada
   		   						if(copy($ruta,$destino)){
   		   						  $data = array("Foto"=>$dest);
   		   						  $where = " Id = " . $vId;
   		   						  // actualizamos el ultimo regsitro
   		   						  if($objUser->updateData($data, $where)){
   		   						    $jsondata['success'] = true;
   		   						    $jsondata['message'] = "Registrado correctamente";
   		   						  }else {
   		   						    $jsondata['success'] = false;
   		   						    $jsondata['message'] = "No fue posible Registrar sus datos";
   		   						  }

   		   						}else {
   		   						  $jsondata['success'] = false;
   		   						  $jsondata['message'] = "No fue posible subir su Imagen";
   		   						}
   		   					}
   		   					else
   		   					{
   		   					    $jsondata['success'] = false;
   		   					    $jsondata['message'] = "Falla al enviar el registro";
   		   					}

   		   				}else{
   		   				  $jsondata['success'] = false;
   		   				  $jsondata['message'] = "Formato de imagen Incorrecto, Debe ser png o jpg";
   		   				}
   		   			}
   		   		}
	       	}
       	}
      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
    break;
      /* Crea Update de usuarios */
    case "upd":
      $jsondata = array();
      $vimg = $_FILES['txtImg']['name'];
      if ($vimg != "") {
      	// si file viene lleno
      	$data = array("Nombre"=>$_REQUEST['txtName'],"Cedula"=>$_REQUEST['txtDoc'], "Direccion"=>$_REQUEST['txtDir'],
      	        "Telefono"=>$_REQUEST['txtTel'], "Email"=>$_REQUEST['txtEml'],
      	        "Usuario"=>$_REQUEST['txtUser'], "Perfil"=>$_REQUEST['SelPerfil'], "Sede"=>$_REQUEST['SelSuper'], "Status"=>1, "Updated_by"=>$vname,  "Updated_at"=>date('Y-m-d H:i:s')
      	      );
      	$where = " Id = " . $_REQUEST['txtId'];
      	$objUser->updateData($data, $where);
      	$vType = substr($_FILES['txtImg']['name'], strlen($_FILES['txtImg']['name'])-3, strlen($_FILES['txtImg']['name']));
      	if(($vType == "png") or ($vType == "jpg")){
      	  $carpeta = "../public/usuarios/".$_REQUEST['txtId'];
      	  $destino2 = "../public/usuarios/".$_REQUEST['txtId']."/".$vimg;
      	  $dest = "public/usuarios/".$_REQUEST['txtId']."/".$vimg."'-";
      	  $ruta2 = $_FILES['txtImg']['tmp_name'];
      	  if(copy($ruta2,$destino2)){
      	    $data = array("Foto"=>$dest);
      	    $where = " Id = " . $_REQUEST['txtId'];
      	    if($objUser->updateData($data, $where)){
      	      $jsondata['success'] = true;
      	      $jsondata['message'] = "Modificado Correctamente";
      	    }else {
      	      $jsondata['success'] = false;
      	      $jsondata['message'] = "No fue posible Actualizar sus Datos";
      	    }

      	  }else{
      	    $jsondata['success'] = false;
      	    $jsondata['message'] = "No Fue posible subir su Imagen";
      	  }

      	}else{
      	  $jsondata['success'] = false;
      	  $jsondata['message'] = "Formato de imagen Incorrecto, Debe ser png o jpg";
      	}

      }else{
      	/*si tipo file esta vacio*/
      	$data = array("Nombre"=>$_REQUEST['txtName'],"Cedula"=>$_REQUEST['txtDoc'], "Direccion"=>$_REQUEST['txtDir'],
      	        "Telefono"=>$_REQUEST['txtTel'], "Email"=>$_REQUEST['txtEml'],
      	        "Usuario"=>$_REQUEST['txtUser'], "Perfil"=>$_REQUEST['SelPerfil'], "Sede"=>$_REQUEST['SelSuper'], "Status"=>1, "Updated_by"=>$vname,  "Updated_at"=>date('Y-m-d H:i:s')
      	      );
      	$where = "Id = " . $_REQUEST['txtId'];
      	if($objUser->updateData($data, $where))
      	 {
      	   $jsondata['success'] = true;
      	   $jsondata['message'] = "Actualizado correctamente";
      	 }else {
      	  $jsondata['success'] = false;
      	  $jsondata['message'] = "No fue posible Actualizar sus Datos";
      	}

      }

      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
    break;

    // Modifica el estado del registro. ......................................

    case "Status":
       $jsondata = array();
       // Realiza Insert
         $data = array("Status"=>$_REQUEST['pStatus'],  "Updated_by"=>$user, "Updated_at"=>date("Y-m-d H:i:s") );
       $where = "Id = " . $_REQUEST['pId'];
      if($objUser->updateData($data, $where))
      {
        $jsondata['success'] = true;
        $jsondata['message'] = "Modificado correctamente";
       }
       else
       {
         $jsondata['success'] = false;
         $jsondata['message'] = "Falla al modificar el registro";
       }
       header('Content-type: application/json; charset=utf-8');
       echo json_encode($jsondata);
    break;


    case "tipoAsignacion":
       $jsondata = array();
       // Realiza Insert
         $data = array("tipoAsignacion"=>$_REQUEST['Tasig'],  "Updated_by"=>$user, "Updated_at"=>date("Y-m-d H:i:s") );
       $where = "Cedula = " . $_REQUEST['Cedula'];
      if($objUser->updateData($data, $where))
      {
        $jsondata['success'] = true;
        $jsondata['message'] = "Modificado correctamente";
       }
       else
       {
         $jsondata['success'] = false;
         $jsondata['message'] = "Falla al modificar el registro";
       }
       header('Content-type: application/json; charset=utf-8');
       echo json_encode($jsondata);
    break;




    /* Crea delete de usuarios */
    case "del":
      $Id =  $_REQUEST['pId'];
      $jsondata = array();
      if($objUser->delData($Id))
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
    /* Cambia el password del usuario */
    case "chg":
      // Determina el pasword
    	$jsondata = array();
		$pass = md5($_REQUEST['pPass']);
		$data = array("Password"=>"".$pass."''");
		$where = " Id = " . $_REQUEST['pId'];
      if($objUser->updateData($data, $where))
      {
          $jsondata['success'] = true;
          $jsondata['message'] = "Contraseña modificada correctamente";
      }
      else
      {
           $jsondata['success'] = false;
           $jsondata['message'] = "Falla al modificar el registro";
      }
      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
    break;

  }
?>