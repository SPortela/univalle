<?php
    /** incluye todos los recursos */
    include_once("../AnsTek_libs/integracion.inc.php");
    include_once("../model/contactos.class.php");
    include_once("../model/hoja_ruta.class.php");
    require_once ("../AnsTek_libs/dllsPhp/libMailer/PHPMailerAutoload.php");
    date_default_timezone_set('America/Bogota'); //configuro un nuevo timezone

    /** Instancia la clase contactos*/
    $contacto = new contacto($db);

     $user= Session::get('Id');
     $cedula= Session::get('Cedula');
    // Instancia de la clase hoja ruja.
    $hojaRuta = new hojaruta($db);
    /** captura el tipo de accion a realizar*/
    $accion = $_REQUEST['accion'];
    /** conmutador que determina las acciones a realizar para
     * este modulo
     */
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
        $jsondata['Nombres'] = $r["Nombres"];
        $jsondata['Cedula'] = $r["Cedula"];
        $jsondata['Ciudad'] = $r["Ciudad"];
        $jsondata['Celular'] = $r["Celular"];
        $jsondata['Email'] = $r["Email"];
        $jsondata['Programa'] = $r["Programa"];
        $jsondata['Carrera'] = $r["Carrera"];
        $jsondata['Mensaje'] = $r["Mensaje"];
        $jsondata['Origen_Campana'] = $r["Origen_Campana"];
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
      $mail = new PHPMailer;
      // Realiza Insert

    	$data = "";
        $data = array("Cedula"=>$_REQUEST['txtDoc'], "Nombre_completo"=>$_REQUEST['txtName'],
         "Celular"=>$_REQUEST['txtCel'],  "Email"=>$_REQUEST['txtEmail'],
         "Programa"=>$_REQUEST['txtPro'],
          "Mensaje"=>$_REQUEST['txtMsj'], "Campana_Id"=>$_REQUEST['txtId'], "Origen_Campana"=>'Google Ads',  "Created_date"=>date("Y-m-d H:i:s") , "Status"=>1);




      if($contacto->insertData($data))
     {


     	    $jsondata['success'] = true;
     	    $jsondata['message'] = ' Gracias por registrarte '. $_REQUEST['txtName'] . ' pronto nos comunicaremos';
     	    // header('Location: http://www.unihorizonte.edu.co/inscripciones2/index.php?m=1');



      }
      else
      {
        $jsondata['success'] = false;
        $jsondata['message'] = "Falla al realizar el registro";
      }
      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
   break;

	  /*Asigna agente a los regsitros*/
	  case "asignaV":
	 	 $jsondata = array();
	 	 $data = "";
	 	 $data_ruta = "";
	 	 if(ISSET($_POST['pId'])){

	 	 	foreach($_POST['pId'] as $id ){
	 	 		if ($_REQUEST['txtAgente'] == 0) {
	 	 			$data = array("Asignado_a"=>$_REQUEST['txtAgente'], "Status"=>1, "Fecha_asignado"=>date("Y-m-d H:i:s"));
	 	 			$msj = "Se ha borrado la asignación.";
	 	 			$data_ruta = array("Registro_id"=>$id, "Detalle"=>"se ha borrado la asignación", "Asignado_a"=>0, "Status"=>1, "Created_by"=> $user, "Created_date"=>date("Y-m-d H:i:s"));
	 	 		}else{
	 	 			$data = array("Asignado_a"=>$_REQUEST['txtAgente'], "Status"=>2, "Fecha_asignado"=>date("Y-m-d H:i:s"));
	 	 			$msj = "El Agente ha sido asignado correctamente";
	 	 			$data_ruta = array("Registro_id"=>$id, "Detalle"=>"El contacto a sido asignado a un agente", "Asignado_a"=>$_REQUEST['txtAgente'], "Status"=>2, "Created_by"=> $user, "Created_date"=>date("Y-m-d H:i:s"));
	 	 		}
	 	 		$where = " Id = " . $id;
	 	 		if($contacto->updateData($data, $where))
	 	 		 {
					if($hojaRuta->insertData($data_ruta)){
						$jsondata['success'] = true;
						$jsondata['message'] = $msj;
					}else{
						$jsondata['success'] = false;
						$jsondata['message'] = "No fue posible registrar hoja de ruta";
					}

	 	 		 }else {
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
	  $data = array("Status"=>$_REQUEST['txtStatus'], "Updated_by"=>$user, "Updated_date"=>date("Y-m-d H:i:s"));
	  $where = " Id = ". $_REQUEST['txtId'];
	  if($contacto->updateData($data, $where)){
	  	$data_ruta = array("Registro_id"=>$_REQUEST['txtId'], "Detalle"=>$_REQUEST['txtObs'], "Asignado_a"=>$cedula, "Status"=>$_REQUEST['txtStatus'], "Created_by"=> $user, "Created_date"=>date("Y-m-d H:i:s"));

	  	if($hojaRuta->insertData($data_ruta)){
	  		$jsondata['success'] = true;
	  		$jsondata['message'] = "Gestión realizada con exito";
	  	}else{
	  		$jsondata['success'] = true;
	  		$jsondata['message'] = "No fue posible registrar en hoja de ruta";
	  	}

	  }else{
	  	$jsondata['success'] = false;
	  	$jsondata['message'] = "No fue posible realizar la gestión";
	  }



	  header('Content-type: application/json; charset=utf-8');
	  echo json_encode($jsondata);
	  break;



   	/* Crea delete de usuarios */
   	case "del":
   	  $Id =  $_REQUEST['pId'];
   	  $jsondata = array();
   	  if(ISSET($_POST['pId'])){
   	  	foreach($_POST['pId'] as $id ){
			if($contacto->delData($id))
			{
			  $jsondata['success'] = true;
			  $jsondata['message'] = "Eliminados correctamente";
			}
			else
			{
			 $jsondata['success'] = false;
			 $jsondata['message'] = "Falla al Eliminar los registros";
			}
		}
   	  }

   	  header('Content-type: application/json; charset=utf-8');
   	  echo json_encode($jsondata);
   	break;

   		// Carga contactos desde EXCEL
   	    case "car":
   	    include_once("../assets/Classes/PHPExcel/IOFactory.php");
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
   	        echo "El fichero es válido y se subió con éxito.\n";
   	        	$nombreArchivo = $destino_archivo;
   	            $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
   	            $objPHPExcel->setActiveSheetIndex(0);
   	            $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

   	                echo 'número de registros cargados '. ($numRows - 1). ' ';
   	                echo '
   	            		<html>
   	            		<head>
						<link href="../css/bootstrap.min.css" rel="stylesheet">
						<script type="text/javascript" src="../js/jquery.js"></script>
						<script type="text/javascript" src="../js/bootstrap.min.js"></script>
   	            		</head>
   	            		<body>
   	                    <table class="table table-striped table-bordered table-hover" border="1">
   	                        <thead>
   	                        <tr>
   	                           <th width="5%"><i class="icon_profile"></i>Cédula</th>
   	                           <th><i class="icon_profile"></i>Nombre_completo</th>
   	                            <th><i class="icon_calendar"></i>Celular</th>
   	                            <th><i class="icon_mail_alt"></i>Email</th>
   	                            <th width="10%"><i class="icon_mobile"></i>Programa</th>
   	                            <th><i class="icon_mobile"></i>Mensaje</th>
   	                            <th><i class="icon_mobile"></i>Origen Campaña</th>
   	                        </tr>
   	                        </thead>
       	            			<a href="../vista/agencia/" class="btn btn-primary" style="
    									width: 142px;
    								    background: #4CAF50;
    								    border-radius: 15px;
    								    padding: 10px;
    								    margin-bottom: 38px;
    								    color: #fff;
    								    text-align: center;
    								    text-decoration: none;
       	            			">Continuar</a> <br><br>
   	            			<tbody>

   	                ';

   	            for ($i=2; $i <= $numRows; $i++) {
   	            	//Recojemos el valor de cada columna
   	            	$cedula = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
   	            	$nombre = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
   	            	$celular = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
   	            	$email = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
   	            	$programa = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
   	            	$mensaje = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
   	            	$origen = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
   	            	$Fecha = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
   	            	$Id = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();

   	            	echo '<tr>';
   	            	echo '<td>'.$cedula.'</td>';
   	            	echo '<td>'.$nombre.'</td>';
   	            	echo '<td>'.$celular.'</td>';
   	            	echo '<td>'.$email.'</td>';
   	            	echo '<td>'.$programa.'</td>';
   	            	echo '<td>'.$mensaje.'</td>';
   	            	echo '<td>'.$origen.'</td>';
   	            	echo '<td>'.$Fecha.'</td>';
   	            	echo '<td>'.$Id.'</td>';

   	            	echo '</body> </html>';
   	            	$data = array("Cedula"=>$cedula, "Nombre_completo"=>$nombre, "Celular"=>$celular,
   	        	        "Email"=>$email, "Programa"=>$programa, "Mensaje"=>$mensaje, "Campana_Id"=>$Id, "Origen_Campana"=>$origen, "Created_date"=>$Fecha, "Status"=>3);
   	            	if($contacto->insertData($data)){
   	            		$jsondata['success'] = true;
   	            		$jsondata['message'] = "Registros cargados correctamente";
   	            		$jsondata['info'] = "Número de registros cargados". $numRows;



   	            	}else{
   	            		$jsondata['success'] = false;
   	            		$jsondata['message'] = "Algo no va bien ! Revisa tu conexión";
   	            	}
   	            }

   	    } else {
   	        echo "¡Posible ataque de subida de ficheros!\n";
   	    }
   	    break;
    }
?>