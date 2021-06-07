<?php
	include_once("../../AnsTek_libs/integracion.inc.php");
	include_once("../resourcesView.php");
	Session::valida_sesion("","../../logout.php");
	// if(Session::get('Perfil') == 1 )
	// header('Location: ../../logout.php');
	include_once("../../model/hoja_ruta.class.php");
	include_once("../../model/contactos.class.php");
	include_once("../../model/usuarios.class.php");
	include_once("../../model/notificaciones.class.php");

	$userId = Session::get('Id');
	if($userId == 18){
		$userId = 5;		
	}else{
		$userId = Session::get('Id');
	}


	// *****************************************************************************
	$user = new usuario($db);

	$fecha1  = $_GET['date1'];
	$fecha2  = $_GET['date2'];

	/*CONSULTAS QUE DEBE REALIZAR INDEPENDIENTEMENTE EL FILTRO*/

	//consultas para traer los nombre de los agentes
	$whereU = " Where Us.Cedula = ".$_GET['n']."  AND Us.Status = 1";
	$whereU21 = " Where Us.Id > 2  AND Us.Sede = ".$userId ." ORDER BY Id ASC";

	$datosU  = $user->selectAll($whereU);
	$datosU2  = $user->selectAll($whereU);

	$datosGeneral  = $user->selectAll($whereU);

	$datosU21  = $user->selectAll($whereU21);
	$datosU213  = $user->selectAll($whereU21);


	//OBJJETO NOTIFICACIONES

	$notifi = new notificacion($db);


	// *****************************************************************************
	$cedula_agente = Session::get('Cedula');
	$hoja_rutaC = new  hojaruta($db);
	$registro = new  contacto($db);
	$whereH = " Where hr.Registro_Id = " . $_GET['v']. " Order by hr.Id ASC" ;



	/*OBJETO HOJA RUTA*/
	$Dcontac1 = new hojaruta($db);




	if (!isset($fecha1)) {

		//WHERE PARA ASIGNADOS
		$whereE1 = " Where rg.Asignado_a = ".$_GET['n'];

		// WHERE PARA GESTIONADOS
		$whereCount1= " WHERE rg.STATUS > 2 AND  rg.Asignado_a = ". $_GET['n'];

		//WHERE PARA SIN GESTIONAR
		$whereUserSin = " Where rg.Asignado_a = ".$_GET['n']. " AND rg.Status = 2";


		// WHERE CITAS REGISTRADAS PENDIENTES
		$whNotiR = " Where nt.Registro_id = ".$_GET['v']. " AND nt.Status = 1 ";

		// WHERE CITAS REGISTRADAS GESTIONADAS
		$whNotiG = " Where nt.Registro_id = ".$_GET['v']. " AND nt.Status = 2 ";

		//WHERE ASIGNADOS POR TRATAMIENTO
		$whereAsigTra = " Where Asignado_a = " . $_GET['n'] ;

		//WHERE GESTIONADOS POR TRATAMIENTO
		$whereGesTra = " Where Asignado_a = " . $_GET['n'] . " AND Status > 2 ";


		/*AGENTESSSSSSSSSSSSSSSSSSS  SEDE SALITRE*/

		//WHERE ASIGNADOS AGENTE 1 CEDULA #
		$whereUser1 = " Where rg.Asignado_a = 4255759";

		//WHERE ASIGNADOS AGENTE 2 CEDULA #
		$whereUser2 = " Where rg.Asignado_a = 4255760 ";
		
		
		//WHERE ASIGNADOS AGENTE 3 Luisa CEDULA #
		$whereUser3 = " Where rg.Asignado_a = 1030654840 ";
		
		//WHERE ASIGNADOS AGENTE 4 Johanna CEDULA #
		$whereUser4 = " Where rg.Asignado_a = 1032366822 ";
		
		//WHERE ASIGNADOS AGENTE 5 Milena CEDULA #
		$whereUser5 = " Where rg.Asignado_a = 52936079 ";

		//WHERE ASIGNADOS AGENTE 6 Xiomara CEDULA #
		$whereUser6 = " Where rg.Asignado_a = 1030627889 ";
		
		

		//WHERE GESTIONADOS AGENDE 1 CEDULA #
		$whereUser12 = " Where rg.Asignado_a = 4255759 AND rg.Status > 2";

		//WHERE GESTIONADOS AGENTE 2 CEDULA #
		$whereUser22 = " Where rg.Asignado_a = 4255760 AND rg.Status > 2";
		
		//WHERE GESTIONADOS AGENTE 3 LUISA CEDULA #
		$whereUser33 = " Where rg.Asignado_a = 1030654840 AND rg.Status > 2";
		
		//WHERE GESTIONADOS AGENTE 4 JOHANNA CEDULA #
		$whereUser44 = " Where rg.Asignado_a = 1032366822 AND rg.Status > 2";
		
		//WHERE GESTIONADOS AGENTE 5 MILENA CEDULA #
		$whereUser55 = " Where rg.Asignado_a = 52936079 AND rg.Status > 2";

		//WHERE GESTIONADOS AGENTE 6 XIOMARA CEDULA #
		$whereUser66 = " Where rg.Asignado_a = 1030627889 AND rg.Status > 2";
		

		/*AGENTESSSSSSSSSSSSSSSSSSS  SEDE UNICENTRO*/

		//WHERE ASIGNADOS AGENTE 1 CEDULA #
		$whereUserU1 = " Where rg.Asignado_a = 1022422712";

		//WHERE ASIGNADOS AGENTE 2 CEDULA #
		$whereUserU2 = " Where rg.Asignado_a = 1030530526 ";

		//WHERE GESTIONADOS AGENDE 1 CEDULA #
		$whereUserU12 = " Where rg.Asignado_a = 1022422712 AND rg.Status > 2";

		//WHERE GESTIONADOS AGENTE 2 CEDULA #
		$whereUserU22 = " Where rg.Asignado_a = 1030530526 AND rg.Status > 2";

		//titulo del reporte
		$tituloReporte = "REPORTE GENERAL";



	} elseif(isset($fecha1) AND $fecha1 != ""  AND $fecha2 == ""){



		//WHERE PARA ASIGNADOS
		$whereE1 = " Where rg.Asignado_a = ".$_GET['n'] . " AND Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		// WHERE PARA GESTIONADOS
		$whereCount1= " WHERE rg.STATUS > 2 AND  rg.Asignado_a = ". $_GET['n']. " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE PARA SIN GESTIONAR
		$whereUserSin = " Where rg.Asignado_a = ".$_GET['n']. " AND rg.Status = 2" .  " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		// WHERE CITAS REGISTRADAS PENDIENTES
		$whNotiR = " Where nt.Registro_id = ".$_GET['v']. " AND nt.Status = 1 " . " AND nt.Fecha_Cita  LIKE " . "'". '%'. $fecha1 . '%'."'";

		// WHERE CITAS REGISTRADAS GESTIONADAS
		$whNotiG = " Where nt.Registro_id = ".$_GET['v']. " AND nt.Status = 2 " . " AND nt.Fecha_Cita  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE ASIGNADOS POR TRATAMIENTO
		$whereAsigTra = " Where Asignado_a = " . $_GET['n'] . " AND tp.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE GESTIONADOS POR TRATAMIENTO
		$whereGesTra = " Where Asignado_a = " . $_GET['n'] . " AND Status > 2 " . " AND tp.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		/*AGENTESSSSSSSSSSSSSSSSSSS  SEDE SALITRE*/

		//WHERE ASIGNADOS AGENTE 1 CEDULA #
		$whereUser1 = " Where rg.Asignado_a = 4255759" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE ASIGNADOS AGENTE 2 CEDULA #
		$whereUser2 = " Where rg.Asignado_a = 4255760 " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";
		
		//WHERE ASIGNADOS AGENTE 3 LUISA CEDULA #
		$whereUser3 = " Where rg.Asignado_a = 1030654840  " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";
		
		//WHERE ASIGNADOS AGENTE 4 JOHANNA CEDULA #
		$whereUser4 = " Where rg.Asignado_a = 1032366822  " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";
		
		//WHERE ASIGNADOS AGENTE 5 MILENA CEDULA #
		$whereUser5 = " Where rg.Asignado_a = 52936079  " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE ASIGNADOS AGENTE 6 XIOMARA CEDULA #
		$whereUser6 = " Where rg.Asignado_a = 1030627889  " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";


		
		

		  

		//WHERE GESTIONADOS AGENDE 1 CEDULA #
		$whereUser12 = " Where rg.Asignado_a = 4255759 AND rg.Status > 2 " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE GESTIONADOS AGENTE 2 CEDULA #
		$whereUser22 = " Where rg.Asignado_a = 4255760 AND rg.Status > 2" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";
		
		//WHERE GESTIONADOS AGENTE 3 LUISA CEDULA #
		$whereUser33 = " Where rg.Asignado_a = 1030654840 AND rg.Status > 2" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";
		
		//WHERE GESTIONADOS AGENTE 4 JOHANNA CEDULA #
		$whereUser44 = " Where rg.Asignado_a = 1032366822 AND rg.Status > 2" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";
		
		//WHERE GESTIONADOS AGENTE 5 MILENA CEDULA #
		$whereUser55 = " Where rg.Asignado_a = 52936079 AND rg.Status > 2" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE GESTIONADOS AGENTE 6 XIOMARA CEDULA #
		$whereUser66 = " Where rg.Asignado_a = 1030627889 AND rg.Status > 2" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";



		/*AGENTESSSSSSSSSSSSSSSSSSS  SEDE UNICENTRO */

		//WHERE ASIGNADOS AGENTE 1 CEDULA #
		$whereUserU1 = " Where rg.Asignado_a = 1022422712" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE ASIGNADOS AGENTE 2 CEDULA #
		$whereUserU2 = " Where rg.Asignado_a = 1030530526 " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";

		//WHERE GESTIONADOS AGENDE 1 CEDULA #
		$whereUserU12 = " Where rg.Asignado_a = 1022422712 AND rg.Status > 2 " . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";


		//WHERE GESTIONADOS AGENTE 2 CEDULA #
		$whereUserU22 = " Where rg.Asignado_a = 1030530526 AND rg.Status > 2" . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";







		//titulo del reporte
		$tituloReporte = "REPORTE DEL DÍA -  ". $fecha1;



	} elseif(isset($fecha1) AND $fecha1 != "" AND isset($fecha2) AND $fecha2 != ""  ){



		//WHERE PARA ASIGNADOS
		$whereE1 = " Where rg.Asignado_a = ".$_GET['n'] . " AND Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		// WHERE PARA GESTIONADOS
		$whereCount1= " WHERE rg.STATUS > 2 AND  rg.Asignado_a = ". $_GET['n'] . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";


		//WHERE PARA SIN GESTIONAR
		$whereUserSin = " Where rg.Asignado_a = ".$_GET['n']. " AND rg.Status = 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		// WHERE CITAS REGISTRADAS PENDIENTES
		$whNotiR = " Where nt.Registro_id = ".$_GET['v']. " AND nt.Status = 1 ". " AND nt.Fecha_Cita  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		// WHERE CITAS REGISTRADAS GESTIONADAS
		$whNotiG = " Where nt.Registro_id = ".$_GET['v']. " AND nt.Status = 2 " . " AND nt.Fecha_Cita  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		//WHERE ASIGNADOS POR TRATAMIENTO
		$whereAsigTra = " Where Asignado_a = " . $_GET['n'] . " AND tp.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		//WHERE GESTIONADOS POR TRATAMIENTO
		$whereGesTra = " Where Asignado_a = " . $_GET['n'] . " AND Status > 2 " . " AND tp.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		/*AGENTESSSSSSSSSSSSSSSSSSS  SEDE SALITRE*/

		//WHERE ASIGNADOS AGENTE 1 CEDULA #
		$whereUser1 = " Where rg.Asignado_a = 4255759" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";


		//WHERE ASIGNADOS AGENTE 2 CEDULA #
		$whereUser2 = " Where rg.Asignado_a = 4255760 " . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		
		//WHERE ASIGNADOS AGENTE 3 LUISSA CEDULA #
		$whereUser3 = " Where rg.Asignado_a = 1030654840 " . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		
		//WHERE ASIGNADOS AGENTE 4 JOHANNA CEDULA #
		$whereUser4 = " Where rg.Asignado_a = 1032366822 " . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		
		//WHERE ASIGNADOS AGENTE 5 MILENA CEDULA #
		$whereUser5 = " Where rg.Asignado_a = 52936079 " . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		//WHERE ASIGNADOS AGENTE 6 XIOMARA CEDULA #
		$whereUser6 = " Where rg.Asignado_a = 1030627889 " . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		
		

		//WHERE GESTIONADOS AGENDE 1 CEDULA #
		$whereUser12 = " Where rg.Asignado_a = 4255759 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		//WHERE GESTIONADOS AGENTE 2 CEDULA #
		$whereUser22 = " Where rg.Asignado_a = 4255760 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		
		//WHERE GESTIONADOS AGENTE 3 Luisa CEDULA #
		$whereUser33 = " Where rg.Asignado_a = 1030654840 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		
		//WHERE GESTIONADOS AGENTE 4 Johanna CEDULA #
		$whereUser44 = " Where rg.Asignado_a = 1032366822 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		
		//WHERE GESTIONADOS AGENTE 5 Milena CEDULA #
		$whereUser55 = " Where rg.Asignado_a = 52936079 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		

		//WHERE GESTIONADOS AGENTE 6 XIOMARA CEDULA #
		$whereUser66 = " Where rg.Asignado_a = 1030627889 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
		

		

		/*AGENTESSSSSSSSSSSSSSSSSSS  SEDE UNICENTRO*/

		//WHERE ASIGNADOS AGENTE 1 CEDULA #
		$whereUserU1 = " Where rg.Asignado_a = 1022422712" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";


		//WHERE ASIGNADOS AGENTE 2 CEDULA #
		$whereUserU2 = " Where rg.Asignado_a = 1030530526 " . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		//WHERE GESTIONADOS AGENDE 1 CEDULA #
		$whereUserU12 = " Where rg.Asignado_a = 1022422712 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		//WHERE GESTIONADOS AGENTE 2 CEDULA #
		$whereUserU22 = " Where rg.Asignado_a = 1030530526 AND rg.Status > 2" . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";

		//titulo del reporte
		$tituloReporte = "REPORTE DESDE ". "( ". $fecha1 . " ) ". " HASTA " . " ( ".  $fecha2. " )";

	}



	//echo  "AQUI " .$whereUser2;





	// Metodo para contar asignados
	$resultE1 = $registro->Count($whereE1);
	if($db->numRows($resultE1) > 0){
	  $rA1 = $db->datos($resultE1);
	}

	// Cuenta numero de contactos gestionados

	//echo $whereCount;
	$gestionados1 = $registro->Count($whereCount1);
	if($db->numRows($gestionados1) > 0){
		$rows11 = $db->datos($gestionados1);
	}else{
		Echo "No hay data";
	}


	/*CUENTA NUMERO DE CONTACTOS SIN GESTIONAR*/

	$resultUserSin = $registro->Count($whereUserSin);
	if($db->numRows($resultUserSin) > 0){
	  $rUserSin = $db->datos($resultUserSin);

	}

	//CUENTA NUMERO DE CITAS REGISTRADAS
	$resultNoti = $notifi->Count($whNotiR);
	if($db->numRows($resultNoti) > 0){
	  $Not = $db->datos($resultNoti);
	}

	//CUENTA NUMERO DE CITAS GESTIONADAS
	$resultNotiG = $notifi->Count($whNotiG);
	if($db->numRows($resultNotiG) > 0){
	  $NotG = $db->datos($resultNotiG);
	}


	/* ASIGNADOS POR TRATAMIENTO */
	$resultCar = $registro->CountCarreras($whereAsigTra);
	$resultCarCont = $registro->CountCarreras($whereAsigTra);

	/*GESTIONADOS POR TRATAMIENTO */
	$resultCarGestionadas = $registro->CountCarreras($whereGesTra);
	$resultCarGestionadas2 = $registro->CountCarreras($whereGesTra);





	if ($userId == 3) {

		//AGENTES SALITRE

		/*ASIGNADOS AGENTE 1*/
		$resultUser1 = $registro->Count($whereUser1);
		if($db->numRows($resultUser1) > 0){
		  $rUser1 = $db->datos($resultUser1);
		}


		/*ASIGNADOS AGENTE 2*/
		$resultUser2 = $registro->Count($whereUser2);
		if($db->numRows($resultUser2) > 0){
		  $rUser2 = $db->datos($resultUser2);
		}
		
		/*ASIGNADOS AGENTE 3 Luisa */
		$resultUser3 = $registro->Count($whereUser3);
		if($db->numRows($resultUser3) > 0){
		  $rUser3 = $db->datos($resultUser3);
		}
		
		/*ASIGNADOS AGENTE 4 Johanna  */
		$resultUser4 = $registro->Count($whereUser4);
		if($db->numRows($resultUser4) > 0){
		  $rUser4 = $db->datos($resultUser4);
		}
		
		/*ASIGNADOS AGENTE 5 Milena  */
		$resultUser5 = $registro->Count($whereUser5);
		if($db->numRows($resultUser5) > 0){
		  $rUser5 = $db->datos($resultUser5);
		}

		/*ASIGNADOS AGENTE 6 XIOMARA */
		$resultUser6 = $registro->Count($whereUser6);
		if($db->numRows($resultUser6) > 0){
		  $rUser6 = $db->datos($resultUser6);
		}
		


		/* GESTIONADOS POR AGENDE */

		/*GESTIONADOS AGENTE 1*/
		$resultUser12 = $registro->Count($whereUser12);
		if($db->numRows($resultUser12) > 0){
		  $rUser12 = $db->datos($resultUser12);
		}


		/*GESTIONADOS AGENTE 2*/

		$resultUser22 = $registro->Count($whereUser22);
		if($db->numRows($resultUser22) > 0){
		  $rUser22 = $db->datos($resultUser22);
		}
		
		/*GESTIONADOS AGENTE 3 LUISA */

		$resultUser33 = $registro->Count($whereUser33);
		if($db->numRows($resultUser33) > 0){
		  $rUser33 = $db->datos($resultUser33);
		}
		
		
		/*GESTIONADOS AGENTE 4 JOHANNA */

		$resultUser44 = $registro->Count($whereUser44);
		if($db->numRows($resultUser44) > 0){
		  $rUser44 = $db->datos($resultUser44);
		}
		
		/*GESTIONADOS AGENTE 5 MILENA */

		$resultUser55 = $registro->Count($whereUser55);
		if($db->numRows($resultUser55) > 0){
		  $rUser55 = $db->datos($resultUser55);
		}


		/*GESTIONADOS AGENTE 6 XIOMARA */

		$resultUser66 = $registro->Count($whereUser66);
		if($db->numRows($resultUser66) > 0){
		  $rUser66 = $db->datos($resultUser66);
		}
		
		
		
		



	}elseif($userId == 5){


		//AGENTES UNICENTRO
		/*ASIGNADOS AGENTE 1*/

		$resultUser1 = $registro->Count($whereUserU1);
		if($db->numRows($resultUser1) > 0){
		  $rUser1 = $db->datos($resultUser1);
		}


		/*ASIGNADOS AGENTE 2*/

		$resultUser2 = $registro->Count($whereUserU2);
		if($db->numRows($resultUser2) > 0){
		  $rUser2 = $db->datos($resultUser2);
		}


		/* GESTIONADOS POR AGENDE */

		/*GESTIONADOS AGENTE 1*/

		$resultUser12 = $registro->Count($whereUserU12);
		if($db->numRows($resultUser12) > 0){
		  $rUser12 = $db->datos($resultUser12);
		}


		/*GESTIONADOS AGENTE 2*/

		$resultUser22 = $registro->Count($whereUserU22);
		if($db->numRows($resultUser22) > 0){
		  $rUser22 = $db->datos($resultUser22);
		}

	}


	// ******************CONTACTOS GESTIONADOS*************************

	$singestionar1 = "";

    $singestionar1 = $rUserSin['num'];


?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <title><?php echo $title; ?></title>
 	<!-- Recursos Css -->
 	<?php recursos_css(); ?>
 	<!-- Date Piker -->
 	<link href="../../assets/datepicker/jquery-ui.css" rel="stylesheet">
</head>
<body>

  <!-- container section start -->
  <section id="container" class="">
		<!-- pinta header -->
	   	<?php header_admin(); ?>
	    <!--header end-->
	    <!--pinta menu-->
	   	<?php getMenu($db); ?>
	    <!--sidebar end-->
		<section id="main-content">
		  <section class="wrapper">
		    <!--overview start-->
		    <div class="row">
		      <div class="col-md-4">
		        <h3 class="page-header"><i class="fa fa-laptop"></i> REPORTE ADMINISTRACIÓN </h3>
		        <ol class="breadcrumb">
		          <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
		          <li><i class="fa fa-laptop"></i>reporte</li>
		          <li><a href="reporte_agentes.php"><i class="fa fa-download"></i> Descargar Reporte</a></li>
		        </ol>



		      </div>


		      <div class="col-md-4">
		      	<h3 class="page-header"><i class="fa fa-laptop"></i> Filtre su reporte </h3>

		      <form class="form-inline" action="" method="get">
		        <div class="form-group">
		          <input type="text" class="form-control" id="date1" name="date1" required="" placeholder="Fecha 1" >
		        </div>
		        <div class="form-group">
		          <input type="text" class="form-control" id="date2" name="date2" placeholder="Fecha 2">
		          <input type="hidden" class="form-control" id="v" name="v" value="<?php echo $_GET['v']; ?>">
		          <input type="hidden" class="form-control" id="n" name="n"  value="<?php echo $_GET['n']; ?>" >
		        </div>
		        <div class="form-group">
		        	<button type="submit" class="btn btn-success">Buscar</button>
		        	<a class="btn btn-info" href="<?php echo "index.php?v=".$_GET['v']. "&&n=".$_GET['n']; ?>">Ver General</a>
		        </div>


		      </form>



		      </div>

		      <div class="col-md-4">
		        <h3 class="page-header"><i class="fa fa-laptop"></i>Tenga en cuenta !</h3>

				<div class="panel panel-default">
			        <p class="breadcrumb page-header">
						Para filtrar su reporte tenga en cuenta:
			        </p>
			        <ol>
			        	<li>seleccione una fecha en el campo fecha 1 si desea ver el reporte de un solo día</li>
			        	<li>seleccione una fecha en el campo fecha 1, y una fecha mayor en el campo fecha 2, para ver el reporte de un rango de fechas</li>
			        	<li>Luego de selecionar la fecha o las 2 fechas, debe hacer clic en el botón buscar</li>
			        	<li>Para volver al reporte general debe hacer clic en el botón azul "Ver General"</li>
			        </ol>
				</div>




		      </div>



		    </div>



		    <div class="row text-center">
		    	<div class="panel panel-success">
		    		<h2><strong><?php echo $tituloReporte; ?></strong> </h2>
		    	</div>


		    </div>







		    <div class="row">
		      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		        <div class="info-box blue-bg">
		          <i class="fa fa-cloud-download"></i>
		          <div class="count"><?php echo $rA1['num']; ?></div>
		          <div class="title">Contactos Asignados</div>
		        </div>
		        <!--/.info-box-->
		      </div>
		      <!--/.col-->

		      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		        <div class="info-box brown-bg">

		           <i class="fa fa-thumbs-o-up"></i>
		          <div class="count"><?php echo $rows11['num']; ?></div>
		          <div class="title">Gestionados</div>
		        </div>
		        <!--/.info-box-->
		      </div>
		      <!--/.col-->

		      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		        <div class="info-box dark-bg">
		         	<i class="fa fa-shopping-cart"></i>
		          <div class="count"><?php echo $singestionar1; ?></div>
		          <div class="title">Sin Gestionar</div>
		        </div>
		        <!--/.info-box-->
		      </div>
		      <!--/.col-->

		      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		        <div class="info-box green-bg">
		        	<p>Citas Registradas</p>
					<div class="col-md-6">
						<div class="count" style="color: red"><?php echo $Not['num']; ?></div>
						<div class="title" style="color: red">Citas Pendientes</div>
					</div>
					<div class="col-md-6">
						 <div class="count"><?php echo $NotG['num']; ?></div>
						<div class="title">Citas Gestionadas</div>
					</div>





		        </div>
		        <!--/.info-box-->
		      </div>
		      <!--/.col-->

		    </div>
		    <!--/.row-->

			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-success">
						<div class="wrapper">
							<label class="text-center TituloGrafica">GESTIÓN REALIZADA</label>
							<canvas id="myChart" width="400" height="400"></canvas>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel panel-success">
						<div class="wrapper">
							<label class="text-center TituloGrafica">ASIGNADOS POR TRATAMIENTO</label>
							<canvas id="BarraCarreras" width="400" height="400"></canvas>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="wrapper">


						<label class="text-center TituloGrafica">GESTIONADOS POR TRATAMIENTO</label>
						<canvas id="BarraCarrerasGestionadas" width="400" height="170"></canvas>


						</div>
					</div>
				</div>

			</div>


			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-body">
							<label class="text-center TituloGrafica">ASIGNADOS</label>
							<canvas id="BarraAgentes" width="" height=""></canvas>

						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="wrapper">
							<label class="text-center TituloGrafica">GESTIONADOS</label>
							<canvas id="BarraAgentesGestionados" width="400" height=""></canvas>
						</div>
					</div>
				</div>


				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">Número de Gestiones por estado</div>
						<div class="panel-body">

							<ul>
							<?php
								if($db->numRows($datosU2) > 0){
								  while ($rU = $db->datos($datosU2)) {
								  		/*echo $rU['Nombre'];*/

								  	$whE = " Where hr.Asignado_a = ". $rU['Cedula'] . " AND hr.Status >= 5 GROUP BY hr.Status";
								  	$resultGest = $hoja_rutaC->selectAll($whE);
								  	if ($db->numRows($resultGest) > 0) {
								  		while ($Est = $db->datos($resultGest)) {


								  				if (!isset($fecha1)) {
													$Wcount = " Where rg.Asignado_a = ". $rU['Cedula'] . " AND rg.Status = ". $Est['Status'];
												}elseif (isset($fecha1) AND $fecha1 != ""  AND $fecha2 == "") {
													$Wcount = " Where rg.Asignado_a = ". $rU['Cedula'] . " AND rg.Status = ". $Est['Status'] . " AND rg.Created_date  LIKE " . "'". '%'. $fecha1 . '%'."'";
												}elseif(isset($fecha1) AND $fecha1 != "" AND isset($fecha2) AND $fecha2 != ""){

													$Wcount = " Where rg.Asignado_a = ". $rU['Cedula'] . " AND rg.Status = ". $Est['Status'] . " AND rg.Created_date  BETWEEN " . "'". $fecha1 . " 00:00:00'". " AND " . "'". $fecha2. " 23:59:00'";
												}


								  			$rCount = $registro->Count($Wcount);
								  			if ($db->numRows($rCount) > 0) {
								  				$cuenta = $db->datos($rCount);
								  			}else{echo 'NO HAY DATA';}

								  			echo '
								  			        <li>'.$Est['Nombre_estado']. ' - '. $cuenta['num']. '</li>
								  			';

								  		}
								  	}

								  }

								 }


							 ?>

							</ul>
						</div>
						<div class="panel-footer"></div>
					</div>
				</div>


			</div>

		    <!-- Today status end -->
		    <!-- statics end -->
		    <!-- project team & activity start -->
		    <!-- project team & activity end -->
		  </section>
		</section>


	    <!--main content start-->
	    <section id="main-content">
	      <section class="wrapper">
	        <!--overview start-->
	        <div class="row">
	          <div class="col-lg-12">
	            <h3 class="page-header"><i class="fa fa-laptop"></i><strong>Reporte General Agente </strong></h3>
	            <a href="reporte_agentes.php" class="btn btn-success">Descargar Reporte</a>
	          </div>
	        </div>
			<!-- <button type="button" class="btn btn-primary" id="new_User">Nuevo</button>
			<button type="button" class="btn btn-warning" id="asigna_agente" onclick="asignar_agentes();">Asignar</button> -->
			<section class="panel">
	            <table class="table table-striped table-bordered table-hover " id="editable" >
		            <thead>
		            <tr>
						<th>Perfil</th>
		               <th>Nombre</th>
		               <th>Cédula</th>
		               <th>Asignados</th>
		               <th>Gestionados</th>
		               <th>Sin gestionar</th>
		               <th>Llamadas</th>
	                   <th>Email</th>
	                   <th>Gestión</th>
		            </tr>
		            </thead>
		            <tbody>
						<?php
						if($db->numRows($datosGeneral) > 0){
						  while ($rU = $db->datos($datosGeneral)) {
						  	echo '
								<tr>
									<td>'.$rU['Usuario'].'</td>
									<td>'.$rU['Nombre'].'</td>
									<td>'.$rU['Cedula'].'</td>
						  	';
						  	// ******************ASIGNADOS**********************
						  	// Objeto Contacto - Para ver numero de asignaciones.
						  	$Dcontac = new hojaruta($db);
						  	$whereE = " Where rg.Asignado_a = ".$rU['Cedula']. " ";
						  	$resultE = $registro->Count($whereE);
						  	if($db->numRows($resultE) > 0){
						  	  $rA = $db->datos($resultE);
						  	}
						  	echo '<td> '.$rA['num'].'  </td>';

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
						  	echo '<td> '.$rows1['num'].'  </td>';

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
						  	echo '<td> '.$rows['num'].'  </td>';


						  	// ******************LLAMADAS REALIZADAS*************************
						  	// Cuenta numero de llamadas
						  	$wherePhone= " WHERE STATUS = 3 AND  Asignado_a = ". $rU['Cedula'];
						  	$resultPhone = $hoja_rutaC->Count($wherePhone);
						  	if($db->numRows($resultPhone) > 0){
						  		$rowsPhone = $db->datos($resultPhone);
						  	}else{
						  		Echo "No hay data";
						  	}
						  	echo '<td> '.$rowsPhone['num'].'  </td>';


						  	// ******************Emails Enviados*************************
						  	// Cuenta numero de Emails
						  	$whereMail= " WHERE STATUS = 4 AND  Asignado_a = ". $rU['Cedula'];
						  	$resultMail = $hoja_rutaC->Count($whereMail);
						  	if($db->numRows($resultMail) > 0){
						  		$rowsMail = $db->datos($resultMail);
						  	}else{
						  		Echo "No hay data";
						  	}

						  	echo '<td> '.$rowsMail['num'].'  </td> <td>';



						  	$whE = " Where hr.Asignado_a = ". $rU['Cedula'] . " AND hr.Status >= 5 GROUP BY hr.Status";
						  	$resultGest = $hoja_rutaC->selectAll($whE);
						  	if ($db->numRows($resultGest) > 0) {
						  		while ($Est = $db->datos($resultGest)) {
						  			$Wcount = " Where rg.Asignado_a = ". $rU['Cedula'] . " AND rg.Status = ". $Est['Status'];
						  			$rCount = $registro->Count($Wcount);
						  			if ($db->numRows($rCount) > 0) {
						  				$cuenta = $db->datos($rCount);
						  			}else{echo 'NO HAY DATA';}
						  			echo $Est['Nombre_estado']. '('.$cuenta['num'].')'. '<br>';
						  		}
						  	}
						  	echo '</td> </tr>';
						  }
						}
						?>
					</tbody>
	            </table>
			</section>
	      </section>
	      <!-- statics end -->
	    </section>
	    <!--main content end-->
	</section>
  	<!-- Recursos javascripts -->
	<?php recursos_js() ?>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<!-- <script type="text/javascript" src="../../js/jquery.validate.min.js"></script> -->
	<script type="text/javascript" src="../../js/process/gestionar.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

	<script type="text/javascript" src="../../js/process/dist/utils.min.js"></script>
	<script type="text/javascript" src="../../assets/datepicker/jquery-ui.min.js"></script>
	<script>
	    $(document).ready(function() {



	    	$( function() {

	    	  $( "#date1" ).datepicker({
	    	    dateFormat: "yy-mm-dd",
	    	    dayNamesMin: [ "Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
	    	    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
	    	    minDate: "",
	    	    maxDate: ""
	    	  });

	    	  $( "#date2" ).datepicker({
	    	    dateFormat: "yy-mm-dd",
	    	    dayNamesMin: [ "Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
	    	    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
	    	    minDate: "",
	    	    maxDate: "",
	    	  });
	    	} );






	    	var ctx = document.getElementById('myChart').getContext('2d');
	    	var myChart = new Chart(ctx, {
	    	    type: 'pie',
	    	    data: {

	    	        labels: ['Asignados', 'Gestionados', 'Sin Gestionar'],
	    	        datasets: [{
	    	            label: 'GESTIÓN REALIZADA',
	    	            <?php
	    	            	$data = $rA1['num']. ','.$rows11['num']. ','. $singestionar1;
	    	            ?>

	    	            data: [<?php echo $data; ?>],
	    	            backgroundColor: [
	    	                'rgba(255, 99, 132, 0.2)',
	    	                'rgba(54, 162, 235, 0.2)',
	    	                'rgba(255, 206, 86, 0.2)',
	    	                'rgba(75, 192, 192, 0.2)',
	    	                'rgba(153, 102, 255, 0.2)',
	    	                'rgba(255, 159, 64, 0.2)'
	    	            ],
	    	            borderColor: [
	    	                'rgba(255, 99, 132, 1)',
	    	                'rgba(54, 162, 235, 1)',
	    	                'rgba(255, 206, 86, 1)',
	    	                'rgba(75, 192, 192, 1)',
	    	                'rgba(153, 102, 255, 1)',
	    	                'rgba(255, 159, 64, 1)'
	    	            ],
	    	            borderWidth: 1
	    	        }]
	    	    },
	    	    options: {
	    	        scales: {
	    	            yAxes: [{
	    	                ticks: {
	    	                    beginAtZero: true
	    	                }
	    	            }]
	    	        }
	    	    }
	    	});



	    	var ctx = document.getElementById('BarraCarreras').getContext('2d');
	    	var myChart = new Chart(ctx, {
	    	    type: 'bar',
	    	    data: {

            	        labels: [
            	        	<?php
            	        		if($db->numRows($resultCar) > 0){
            	        			$arrayNombresAgente = array ();
            	        		  while ($rCar = $db->datos($resultCar)) {
        								?>
        										'<?php echo $rCar['Tratamiento'] ?> ',
        							<?php
        							  }
        							}
            	        	 ?>


            	        ],
	    	        datasets: [{
	    	            label: 'PROGRAMAS',


	    	                	        data: [
	    	                	        	<?php
	    	                	        		if($db->numRows($resultCarCont) > 0){
	    	                	        			$arrayNombresAgente = array ();
	    	                	        		  while ($rCar2 = $db->datos($resultCarCont)) {
	    	            								?>
	    	            										'<?php echo $rCar2['total'] ?> ',
	    	            							<?php
	    	            							  }
	    	            							}
	    	                	        	 ?>


	    	                	        ],
	    	            backgroundColor: [
	    	                'rgba(255, 99, 132, 0.2)',
	    	                'rgba(54, 162, 235, 0.2)',
	    	                'rgba(255, 206, 86, 0.2)',
	    	                'rgba(75, 192, 192, 0.2)',
	    	                'rgba(153, 102, 255, 0.2)',
	    	                'rgba(255, 159, 64, 0.2)'
	    	            ],
	    	            borderColor: [
	    	                'rgba(255, 99, 132, 1)',
	    	                'rgba(54, 162, 235, 1)',
	    	                'rgba(255, 206, 86, 1)',
	    	                'rgba(75, 192, 192, 1)',
	    	                'rgba(153, 102, 255, 1)',
	    	                'rgba(255, 159, 64, 1)'
	    	            ],
	    	            borderWidth: 1
	    	        }]
	    	    },
	    	    options: {
	    	        scales: {
	    	            yAxes: [{
	    	                ticks: {
	    	                    beginAtZero: true
	    	                }
	    	            }]
	    	        }
	    	    }
	    	});




	    	/*TOP % CARRERAS GESTIONADAS*/
	    		    	var ctx = document.getElementById('BarraCarrerasGestionadas').getContext('2d');
	    		    	var myChart = new Chart(ctx, {
	    		    	    type: 'bar',
	    		    	    data: {

	    	            	        labels: [
	    	            	        	<?php
	    	            	        		if($db->numRows($resultCarGestionadas) > 0){
	    	            	        			$arrayNombresAgente = array ();
	    	            	        		  while ($rCar4 = $db->datos($resultCarGestionadas)) {
	    	        								?>
	    	        										'<?php echo $rCar4['Tratamiento'] ?> ',
	    	        							<?php
	    	        							  }
	    	        							}
	    	            	        	 ?>


	    	            	        ],
	    		    	        datasets: [{
	    		    	            label: 'PROGRAMAS',


	    		    	                	        data: [
	    		    	                	        	<?php
	    		    	                	        		if($db->numRows($resultCarGestionadas2) > 0){
	    		    	                	        			$arrayNombresAgente = array ();
	    		    	                	        		  while ($rCar22 = $db->datos($resultCarGestionadas2)) {
	    		    	            								?>
	    		    	            										'<?php echo $rCar22['total'] ?> ',
	    		    	            							<?php
	    		    	            							  }
	    		    	            							}
	    		    	                	        	 ?>


	    		    	                	        ],
	    		    	            backgroundColor: [
	    		    	                'rgba(255, 99, 132, 0.2)',
	    		    	                'rgba(54, 162, 235, 0.2)',
	    		    	                'rgba(255, 206, 86, 0.2)',
	    		    	                'rgba(75, 192, 192, 0.2)',
	    		    	                'rgba(153, 102, 255, 0.2)',
	    		    	                'rgba(255, 159, 64, 0.2)'
	    		    	            ],
	    		    	            borderColor: [
	    		    	                'rgba(255, 99, 132, 1)',
	    		    	                'rgba(54, 162, 235, 1)',
	    		    	                'rgba(255, 206, 86, 1)',
	    		    	                'rgba(75, 192, 192, 1)',
	    		    	                'rgba(153, 102, 255, 1)',
	    		    	                'rgba(255, 159, 64, 1)'
	    		    	            ],
	    		    	            borderWidth: 1
	    		    	        }]
	    		    	    },
	    		    	    options: {
	    		    	        scales: {
	    		    	            yAxes: [{
	    		    	                ticks: {
	    		    	                    beginAtZero: true
	    		    	                }
	    		    	            }]
	    		    	        }
	    		    	    }
	    		    	});



	    		        	var ctx = document.getElementById('BarraAgentes').getContext('2d');
	    		        	var myChart = new Chart(ctx, {
	    		        	    type: 'bar',
	    		        	    data: {

	    		        	        labels: [

	    		        	        	<?php
	    		        	        		if($db->numRows($datosU21) > 0){
	    		        	        			$arrayNombresAgente = array ();
	    		        	        		  while ($rU1 = $db->datos($datosU21)) {
	    		    								?>
	    		    										'<?php echo $rU1['Nombre'] ?> ',
	    		    							<?php
	    		    							  }
	    		    							}





	    		        	        	 ?>


	    		        	        ],
	    		        	        datasets: [{
	    		        	            label: 'AGENTE',
	    		        	            <?php
	    		        	                $cero = 0;
	    		        	            	$data1 = $rUser3['num']. ','.$rUser1['num']. ','.$rUser2['num']. ','.$cero. ','.    $rUser4['num']. ','. $rUser5['num'] . ',' .$rUser6['num']  ;
	    		        	            ?>

	    		        	            data: [<?php echo $data1; ?>],
	    		        	            backgroundColor: [
	    		        	                'rgba(255, 99, 132, 0.2)',
	    		        	                'rgba(54, 162, 235, 0.2)',
	    		        	                'rgba(255, 206, 86, 0.2)',
	    		        	                'rgba(75, 192, 192, 0.2)',
	    		        	                'rgba(153, 102, 255, 0.2)',
	    		        	                'rgba(255, 159, 64, 0.2)'
	    		        	            ],
	    		        	            borderColor: [
	    		        	                'rgba(255, 99, 132, 1)',
	    		        	                'rgba(54, 162, 235, 1)',
	    		        	                'rgba(255, 206, 86, 1)',
	    		        	                'rgba(75, 192, 192, 1)',
	    		        	                'rgba(153, 102, 255, 1)',
	    		        	                'rgba(255, 159, 64, 1)'
	    		        	            ],
	    		        	            borderWidth: 1
	    		        	        }]
	    		        	    },
	    		        	    options: {
	    		        	        scales: {
	    		        	            yAxes: [{
	    		        	                ticks: {
	    		        	                    beginAtZero: true
	    		        	                }
	    		        	            }]
	    		        	        }
	    		        	    }
	    		        	});





						/* BARRA GESTIONADOS */


						    	var ctx = document.getElementById('BarraAgentesGestionados').getContext('2d');
						    	var myChart = new Chart(ctx, {
						    	    type: 'bar',
						    	    data: {

						    	        labels: [

						    	        	<?php
						    	        		if($db->numRows($datosU213) > 0){
						    	        			$arrayNombresAgente = array ();
						    	        		  while ($rU13 = $db->datos($datosU213)) {
														?>
																'<?php echo $rU13['Nombre'] ?> ',
													<?php
													  }
													}





						    	        	 ?>


						    	        ],
						    	        datasets: [{
						    	            label: 'AGENTE',
						    	            <?php
						    	                $cero1 = 0;
						    	            	$data1 =  $rUser33['num']. ',' . $rUser12['num']. ','.$rUser22['num']. ','. $cero1 . ','.  $rUser44['num']. ','. $rUser55['num']. ',' .$rUser66['num'];
						    	            ?>

						    	            data: [<?php echo $data1; ?>],
						    	            backgroundColor: [
						    	                'rgba(255, 99, 132, 0.2)',
						    	                'rgba(54, 162, 235, 0.2)',
						    	                'rgba(255, 206, 86, 0.2)',
						    	                'rgba(75, 192, 192, 0.2)',
						    	                'rgba(153, 102, 255, 0.2)',
						    	                'rgba(255, 159, 64, 0.2)'
						    	            ],
						    	            borderColor: [
						    	                'rgba(255, 99, 132, 1)',
						    	                'rgba(54, 162, 235, 1)',
						    	                'rgba(255, 206, 86, 1)',
						    	                'rgba(75, 192, 192, 1)',
						    	                'rgba(153, 102, 255, 1)',
						    	                'rgba(255, 159, 64, 1)'
						    	            ],
						    	            borderWidth: 1
						    	        }]
						    	    },
						    	    options: {
						    	        scales: {
						    	            yAxes: [{
						    	                ticks: {
						    	                    beginAtZero: true
						    	                }
						    	            }]
						    	        }
						    	    }
						    	});








	    	// $("#gestionar_btn").click(function(){
	    	//   $("#gestionar_contacto").modal({keyboard: true});
	    	// });
	        /* Init DataTables */
	        // var oTable = $('#editable').dataTable();


	    });
	</script>
</body>
</html>