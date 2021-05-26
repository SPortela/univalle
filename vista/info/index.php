<?php
	include_once("../../AnsTek_libs/integracion.inc.php");
	include_once("../resourcesView.php");

	include_once("../../model/contactos.class.php");
	include_once("../../model/usuarios.class.php");
	$contact = new contacto($db);
	$cedula_agente = Session::get('Cedula');
	$userId = Session::get('Id');

	$numero = $_GET['n'];
	
	$numRows = ($_GET['r'] - 1) ;

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
 	<!-- Date Piker -->
 	<link href="../../assets/datepicker/jquery-ui.css" rel="stylesheet">
 	<link href="../../css/sweetalert.css" rel="stylesheet">
 	<?php recursos_css(); ?>
 	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 	<style type="text/css">
 		#asig{
			background-color: #fc7119 !important;
			color: #000;
 		}
 		#gest{
			background-color: #81ad4c !important;
			color: #000;
 		}
 		#car{
 			background-color: #ebaf08 !important;
 			color: #000;
 		}

		#NoInter{
			background-color: #ff3636 !important;
			color: #000;
		}

		#Agenda{
			background-color: #e4e410 !important;
			color: #000;
		}

		.msj{color:#fc7119; font-size: 17px; }
		.date{border-radius: 2px; border: 1px solid #444; height: 32px; width: 180px; position: relative; top:2px; text-align: center;}

		.update_registro{
			background-color: red;
		}
		.btn-success:hover{
			color: #fff;
			background: #4cd964;
			border-color: #4cd964;
			font-size: 15px;

		}

		.tipoAsig{
			float: right !important;
		}

		table{
			color: #000 !important;
		}

 	</style>
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
	    <!--main content start-->
	    <section id="main-content">
	      <section class="wrapper">
	        <!--overview start-->



			<section class="panel">
			<div class="panel-group">
			  <div class="panel panel-success">
			  	<div class="panel-heading">
			  		Info
			  	</div>
			    <div class="panel-body">
			    	<h3> Su Información ha sido cargada correctamente, <?php echo $numRows - 1  . ' Registros fueron agregados.' ?> </h3>
			    </div>
			  </div>
			  <div class="panel panel-default">
			  	<?php

			  		if ($numero == 13 or $numero == 22 ) {
			  			$url = "../administrativo/";
			  		}else{
			  			$url = "../contactos/";
			  		}


			  	 ?>
			    <div class="panel-body"><a href=<?php echo $url; ?> class="btn btn-success">Volver</a></div>
			  </div>
			</div>

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
	<script type="text/javascript" src="../../js/process/contactos.js"></script>

	<script type="text/javascript" src="../../assets/datepicker/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../js/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="../../js/process/sweetalert.min.js"></script>

	<script>


	</script>
</body>
</html>