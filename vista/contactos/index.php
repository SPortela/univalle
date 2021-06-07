<?php
include_once("../../AnsTek_libs/integracion.inc.php");
include_once("../resourcesView.php");
Session::valida_sesion("", "../../logout.php");
// if(Session::get('Perfil') != 1 or Session::get('Perfil') != 0 )
// header('Location: ../../logout.php');
include_once("../../model/contactos.class.php");
include_once("../../model/usuarios.class.php");
$contact = new contacto($db);
$cedula_agente = Session::get('Cedula');
$userId = Session::get('Id');

$cTotalTab = "";
if ($userId == 3) {
	$whTab =  " Where rg.Id > 0  AND us.Sede = " . $userId . " AND rg.Status > 0  OR rg.Created_by = " . $userId . "  OR rg.Asignado_a = 0 OR rg.Created_by = 12  ORDER BY rg.Status, rg.Created_date DESC";
	$cTab =  " Where rg.Id > 0  AND us.Sede = " . $userId . "  AND rg.Status > 0  OR rg.Created_by = " . $userId . "  OR rg.Asignado_a = 0  OR rg.Created_by = 12 ";
	$cTotalTab = " Where rg.Id > 0  AND us.Sede = " . $userId . " OR rg.Created_by = " . $userId . " OR rg.Asignado_a = 0 OR rg.Status = 1 OR rg.Created_by = 12 ";
}  

if ($userId == 1) {
	$where = " Where rg.Id > 0 GROUP BY rg.Id  ORDER BY rg.Status, rg.Created_date DESC";
	$whereC =  " Where rg.Id > 0 ";
	$title = "Total Contactos";
} else {
	if (empty($_GET)) {
		$where = $whTab;
		$whereC =  $cTab;
		$title = "Total Contactos";
		//echo $whereC ;
	} else {
		if (
			isset($_GET['Filtronombre']) and  $_GET['Filtronombre'] != ""  and  isset($_GET['FiltroCedula']) and  $_GET['FiltroCedula'] != ""
			and isset($_GET['FiltroPrograma']) and  $_GET['FiltroPrograma'] != "" and  isset($_GET['Filtrorigen']) and  $_GET['Filtrorigen'] != ""
		) {
			$where = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND  rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . " AND rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND  rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . " AND rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['Filtronombre']) and  $_GET['Filtronombre'] != ""  and  isset($_GET['FiltroCedula']) and  $_GET['FiltroCedula'] != "" and isset($_GET['FiltroPrograma']) and  $_GET['FiltroPrograma'] != "") {

			$where = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND  rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND  rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . " AND us.Sede = " . $userId;
		} elseif (isset($_GET['Filtronombre']) and  $_GET['Filtronombre'] != ""  and  isset($_GET['FiltroCedula']) and  $_GET['FiltroCedula'] != "") {

			$where = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['Filtronombre']) and  $_GET['Filtronombre'] != "" and isset($_GET['FiltroPrograma']) and  $_GET['FiltroPrograma'] != "") {
			$where = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['Filtronombre']) and  $_GET['Filtronombre'] != "" and isset($_GET['Filtrorigen']) and  $_GET['Filtrorigen'] != "") {
			$where = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['FiltroCedula']) and  $_GET['FiltroCedula'] != "" and isset($_GET['FiltroPrograma']) and  $_GET['FiltroPrograma'] != "") {
			$where = " Where rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['FiltroCedula']) and  $_GET['FiltroCedula'] != "" and isset($_GET['Filtrorigen']) and  $_GET['Filtrorigen'] != "") {
			$where = " Where rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['Filtronombre']) and  $_GET['Filtronombre'] != "") {

			$where  = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC";
			$whereC = " Where rg.Nombre_completo  LIKE  " . "'" .  '%' .  $_GET['Filtronombre'] . '%' . "'" . " AND us.Sede = " . $userId;
		} elseif (isset($_GET['FiltroCedula']) and  $_GET['FiltroCedula'] != "") {

			$where  = " Where rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC";
			$whereC = " Where rg.Cedula  LIKE  " . "'" .  '%' .  $_GET['FiltroCedula'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['FiltroPrograma']) and  $_GET['FiltroPrograma'] != "") {
			$where  = " Where rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC";
			$whereC = " Where rg.Tratamiento  LIKE  " . "'" .  '%' .  $_GET['FiltroPrograma'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif (isset($_GET['Filtrorigen']) and  $_GET['Filtrorigen'] != "") {

			$where  = " Where rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . " AND us.Sede = " . $userId . " GROUP BY rg.Id ORDER BY rg.Status, rg.Created_date DESC";
			$whereC = " Where rg.Origen_Campana  LIKE  " . "'" .  '%' .  $_GET['Filtrorigen'] . '%' . "'" . "AND us.Sede = " . $userId;
		} elseif ($_GET['v'] == 0) {
			$where = " Where rg.Id > 0 AND rg.Status > 1 AND rg.Status <> 3 AND rg.Created_date > '2019-06-17 23:00:00' AND us.Sede = " . $userId . " ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Id > 0 AND rg.Status > 1 AND rg.Status <> 3 AND rg.Created_date > '2019-06-17 23:00:00'" . " AND us.Sede = " . $userId;
			$title = "Contactos Gestionados";
		} elseif ($_GET['v'] == 1) {
			$where = " Where rg.Id > 0 AND rg.Status = " . $_GET['v'] . "   ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Id > 0  AND rg.Status = " . $_GET['v'];
			$title = "Contactos Registrados";
		} elseif ($_GET['v'] == 3) {
			$where = " Where rg.Id > 0 AND rg.Status = " . $_GET['v'] . "  AND rg.Created_by = " . $userId . "  ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Id > 0  AND rg.Status = " . $_GET['v'] . "" . " AND rg.Created_by = " . $userId;
			$title = "Contactos Cargados";
		} else {
			$where = " Where rg.Id > 0  AND rg.Created_by = " . $userId . "  ORDER BY rg.Status, rg.Created_date DESC";
			$whereC =  " Where rg.Id > 0 AND rg.Created_date > '2019-06-17 23:00:00'" . "AND us.Sede = " . $userId;
			$title = "Total Contactos";
		}
	}
}

$whereCT = $cTotalTab;

$result = $contact->selectAll($where);
// Objeto Usarios - Agentes
$agente = new usuario($db);
$whereA = " Where Us.Status = 1 AND  Us.Perfil = 0 AND Us.Sede = " . $userId;
$optionA = "";
$resultAgente = $agente->selectAll($whereA);
if ($db->numRows($resultAgente) > 0) {
	while ($rA = $db->datos($resultAgente)) {
		$optionA .= "<option value=" . $rA["Cedula"] . ">" . $rA["Nombre"] . "-" . $rA["Usuario"] . "</option>";
	}
}


/* CONSULTAMOS TIPO DE ASIGNACION */
$valorAsignacion = "";
$btnTipoAsig = "";
$til = "";
$btnAsignar = "";
$tipoAsigWhere = " Where Us.Status = 1 AND Us.Perfil = 1 AND Cedula = " . $cedula_agente;
$tipoA = $agente->selectAll($tipoAsigWhere);
if ($db->numRows($tipoA) > 0) {
	if ($tipoA = $db->datos($tipoA)) {
		$valorAsignacion = $tipoA['TipoAsignacion'];

		if ($valorAsignacion == 1) {
			$til = "Asignación Manual";
			$btnTipoAsig = '

				<button class="btn btn-primary dropdown-toggle tipoAsig" type="button" onclick="TipoAsignacion(' . $valorAsignacion . ',' . $cedula_agente . ')">' . $til . '</button>
			';
			$btnAsignar = '

				<button type="button" class="btn btn-primary" id="asigna_agente" onclick="asignar_agentes();">Asignar</button>

			';
		} else {

			$til = "Asignación Automática";
			$btnTipoAsig = '

				<button class="btn btn-danger dropdown-toggle tipoAsig" type="button" onclick="TipoAsignacion(' . $valorAsignacion . ',' . $cedula_agente . ')">' . $til . '</button>
			';

			$btnAsignar = '';
		}
	}
}



// COINSULTAR ORIGEN DE CAMPANAS

$whereOr = " Where rg.Status > 0 group by `Origen_Campana` ";
$resultOrigen = $contact->selectAll($whereOr);
$optionOr = "";
if ($db->numRows($resultOrigen) > 0) {
	while ($rOr = $db->datos($resultOrigen)) {
		$optionOr .= '<option>' . $rOr["Origen_Campana"] . '</option>';
	}
}


// COINSULTAR PROGRAMAS
$optionOrP = "";
$whereOrP = " Where rg.Status > 0 group by `Tratamiento` ";
$resultOrigenP = $contact->selectAll($whereOrP);
if ($db->numRows($resultOrigenP) > 0) {
	while ($rOrP = $db->datos($resultOrigenP)) {
		$optionOrP .= '<option>' . $rOrP["Tratamiento"] . '</option>';
	}
}



// Cuenta numero de contactos sin gestionar
$whereCount = $whereC;
//echo $whereCount;
$sin_gestionar = $contact->Count($whereCount);
if ($db->numRows($sin_gestionar) > 0) {
	$rows = $db->datos($sin_gestionar);
} else {
	echo "No hay data";
}



$program = "";
$orig = "";

if (empty($_GET['FiltroPrograma'])) {
	$program = "Seleccione un programa";
} else {
	$program = $_GET['FiltroPrograma'];
}

if (empty($_GET['Filtrorigen'])) {
	$orig = "Seleccione un programa";
} else {
	$orig = $_GET['Filtrorigen'];
}



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
		#asig {
			background-color: #fc7119 !important;
			color: #000;
		}

		#gest {
			background-color: #81ad4c !important;
			color: #000;
		}

		#car {
			background-color: #ebaf08 !important;
			color: #000;
		}

		#NoInter {
			background-color: #ff3636 !important;
			color: #000;
		}

		#Agenda {
			background-color: #e4e410 !important;
			color: #000;
		}

		.msj {
			color: #fc7119;
			font-size: 17px;
		}

		.date {
			border-radius: 2px;
			border: 1px solid #444;
			height: 32px;
			width: 180px;
			position: relative;
			top: 2px;
			text-align: center;
		}

		.update_registro {
			background-color: red;
		}

		.btn-success:hover {
			color: #fff;
			background: #4cd964;
			border-color: #4cd964;
			font-size: 15px;

		}

		.tipoAsig {
			float: right !important;
		}

		table {
			color: #000 !important;
		}
	</style>
</head>

<body>

	<!-- MODAL REGISTRO USUARIOS-->
	<div class="modal fade" id="verContacto">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Informacion del usuario</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered text-center">
						<tr>
							<td>
								<p>Estado</p>
							</td>
							<td>
								<div id="ft"></div>
							</td>
						</tr>

						<tr>
							<td>
								<p>Nombres</p>
							</td>
							<td>
								<p id="nombre"></p>
							</td>
						</tr>
						<tr>
							<td>
								<p>Celular</p>
							</td>
							<td>
								<p id="tel"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Programa</p>
							</td>
							<td>
								<p id="dir"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Email</p>
							</td>
							<td>
								<p id="mail"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Ciudad</p>
							</td>
							<td>
								<p id="per"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Origen</p>
							</td>
							<td>
								<p id="usu"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Asignado a:</p>
							</td>
							<td>
								<p id="reg"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Fecha Registro:</p>
							</td>
							<td>
								<p id="reg2"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Creado Por:</p>
							</td>
							<td>
								<p id="cre"></p>
							</td>
						</tr>



					</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


	<!-- Modal Subir Registros -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
					<form enctype="multipart/form-data" action="../../controller/contactosController.php" method="POST">
						<div class="form-group">
							<select class="form-control" name="AgenteSel" id="AgenteSel" required="">
								<option value="">Seleccione</option>
								<option value="1">Todos</option>
								<?php echo $optionA; ?>

							</select>
						</div>
						<div class="form-group">
							<label class="">Adjuntar archivo</label>
							<!-- <input type="file" class="form-control" name="uploadExcel" id="uploadExcel" autofocus> -->
							<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
							<input name="fichero_usuario" type="file" />
							<input type="hidden" class="form-control" name="accion" id="" value="car">
						</div>
						<button type="submit" class="btn btn-default">Enviar</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Fin Modal -->


	<!-- Modal ASigna varios -->
	<div id="Modal_Asigna_varios" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Agentes Disponibles</h4>
				</div>
				<div class="modal-body">
					<form id="asignar_varios">
						<div class="form-group">
							<select class="form-control" name="txtAgente" id="txtAgente" required="">
								<option value="">Seleccione</option>
								<?php echo $optionA; ?>
								<option value="0">Borrar asignación</option>
							</select>
						</div>
						<div class="form-group">
						</div>
						<button type="submit" class="btn btn-default">Enviar</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>

		</div>
	</div>
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
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i>Contactos</h3>
						<ol class="breadcrumb">
							<li><i class="fa fa-home"></i><a href="index.php">Inicio</a></li>
							<li><i class="fa fa-laptop"></i>Contactos</li>
							<!-- <li><strong class="msj"> Tienes <?php echo $rows["num"]; ?> Contactos sin asignar </strong></li> -->
						</ol>

						<?php

						$urlDescarga = "";
						$BtnEliminar = '';

						if ($userId == 1) {

							$urlDescarga = "descarga_excel.php";
							$BtnEliminar = '<button type="button" class="btn btn-danger" onclick="DelRegistro();">Eliminar</button>';
						} else {

							$urlDescarga = "ok.php";
							$BtnEliminar = '';
						}







						?>


						<form method="post" action="<?php echo $urlDescarga; ?>" style="position: relative; top:0px;">
							<input type="text" name="txtFecha1" id="txtFecha1" value="" class="date" placeholder="Fecha Numero1">
							<input type="text" name="txtFecha2" id="txtFecha2" value="" class="date" placeholder="Fecha Numero2">
							<input type="hidden" name="sedesTab" id="sedesTab" value="<?php echo $userId; ?>" class="date">
							<select name="tipo" id="tipo" class="date">
								<option value="">Seleccione</option>
								<?php echo $optionOr; ?>
							</select>
							<button type="submit" class="btn btn-info">Descargar</button>
							<a href="#" title="Contar" class="btn btn-info"><?php echo $title; ?>: <?php $rows = $contact->Count($whereCT);
																									if ($db->numRows($rows) > 0) {
																										$r = $db->datos($rows);
																										echo "<strong>" . $r['num'] . "</strong>";
																									} else {
																										echo "NO HAY REGISTROS PARA MOSTRAR";
																									} ?></a>
							<?php echo $btnAsignar; ?>
							<?php echo $btnTipoAsig; ?>
							<?php echo $BtnEliminar; ?>
							<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Cargar</button>
							<a href="../cargar_registros.xlsx" download="../cargar_registros.xlsx" class="btn btn-default" title="Descargar Formato"><img src="../../assets/archivo.png" width="25px" style="position: relative; "></a>
							<a class="btn btn-default" title="Marcar Registrados" id="all_Registrados"><img src="../../assets/exito1.png" width="25px" style="position: relative; "></a>
							<a href="#" class="btn btn-default" title="Marcar Gestionados" id="all_Gestionados"><img src="../../assets/exito.png" width="25px" style="position: relative; "></a>
							<a href="#" class="btn btn-default" title="Marcar Cargados" id="all_Cargados"><img src="../../assets/exito2.png" width="25px" style="position: relative; "></a>
							<input type="button" id="limpiar" value="Limpiar" class="btn btn-success">
						</form>
					</div>
				</div>


				<!-- Ccampos para filtrar informacion -->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i>Filtrar información</h3>


						<form method="get" action="index.php" style="position: relative; top:0px;" id="form-filtrar">
							<input type="text" name="Filtronombre" id="Filtronombre" value="<?php echo isset($_GET['Filtronombre']) ?? ""; ?>" class="date" placeholder="Busque por nombre">
							<select name="FiltroPrograma" id="FiltroPrograma" class="date">
								<option value="<?php echo isset($_GET['FiltroPrograma']) ?? ""; ?>"><?php echo $program; ?></option>
								
								<?php echo $optionOrP; ?>
							</select>
							<select name="Filtrorigen" id="Filtrorigen" class="date">
								<option value="<?php echo isset($_GET['Filtrorigen']) ?? ""; ?>"><?php echo $orig;  ?></option>
								<option value="">Seleccione un origen</option>
								<?php echo $optionOr; ?>
							</select>
							<input type="submit" class="btn btn-success" value="Buscar">
							<a href="#" title="Contar" class="btn btn-info">Resultado : <?php $rows = $contact->Count($whereC);
																						if ($db->numRows($rows) > 0) {
																							$r = $db->datos($rows);
																							echo "<strong>" . $r['num'] . "</strong>";
																						} else {
																							echo "NO HAY REGISTROS PARA MOSTRAR";
																						} ?></a>
							<input type="submit" class="btn btn-info" value="limpiar" id="Clean">

						</form>

						<form action="descarga_excel_filtro-new.php">
							<input type="hidden" name="valueWhere" id="valueWhere" value="<?php echo $where; ?>">
							<input type="submit" class="btn btn-info" value="Descargar" id="DescargarFiltro">
						</form>



					</div>
				</div>



				<section class="panel">

					<table class="table table-bordered " id="editable">
						<thead>
							<tr>
								<th><input type="checkbox" id="select_all" /> All</th>
								<th><i class="icon_profile"></i>Status</th>
								<th><i class="icon_profile"></i>Nombre</th>
								<th><i class="icon_profile"></i>Teléfono</th>
								<th><i class="icon_profile"></i>Email</th>
								<th><i class="icon_profile"></i>Ciudad</th>
								<th><i class="icon_profile"></i>Programa</th>
								<th><i class="icon_profile"></i>Fecha</th>
								<th><i class="icon_mobile"></i>Origen</th>
								<th><i class="icon_mobile"></i>Agente</th>
								<th><i class="icon_cogs"></i>Acciones</th>

							</tr>
						</thead>
						<tbody>
							<?php
							if ($db->numRows($result) > 0) {
								$i = "";
								$class = "";
								while ($r = $db->datos($result)) {
									$asignado = ($r['Asignado_a'] == 0) ? "No asignado" : "" . $r['Nombre_agente'] . " - " . $r['Asignado_a'] . " - " . $r['Usuario_agente'] . " ";
									$valStatus = ($r['Status'] == 1) ? "<img src='../../img/edo_ok.png' alt='Activo'>" : "<img src='../../img/edo_nok.png' alt='Inactivo'>";


									if ($r['Status'] == 1) {
										$id = "asig";
										$class = 'registrado update_registro';
									} elseif ($r['Status'] == 3) {
										$id = "car";
										$class = 'Cargados update_registro';
									} elseif ($r['Status'] == 9) {
										$id = 'NoInter';
										$class = 'NoInteresado update_registro';
									} elseif ($r['Status'] == 7) {
										$id = 'Agenda';
										$class = 'AgendaCita update_registro';
									} else {
										$id = 'gest';
										$class = 'Gestionado update_registro';
									}





									echo '<tr>';
									echo "<td>
				                    <center>
				    					<input type=\"checkbox\" name=\"IdsRegistros[]\" value='" . $r['Id'] . "' class = '" . $class . "'>
				                    </center>
				                  </td>";
									echo "<td style=\"background-color:" . $r['Color'] . "\">" . "1. " . $r['Nombre_estado'] . "</td>";
									echo "<td>" . $r['Nombre_completo'] . "</td>";
									echo "<td>" . $r['Celular'] . "</td>";
									echo "<td>" . $r['Email'] . "</td>";
									echo "<td>" . $r['Ciudad'] . "</td>";
									echo "<td>" . $r['Tratamiento'] . "</td>";
									echo "<td>" . $r['Created_date'] . "</td>";
									echo "<td>" . $r['Origen_Campana'] . "</td>";
									echo "<td>" . $asignado . "</td>";
									echo "<td>
				                  <center>
				                   	<a href=\"#\" onclick=\"javascript:cargaInfo('" . $r['Id'] . "');\" style=\"margin-bottom:-3px;border:1px #000 solid;\" class=\"btn btn-success btn-md btn-xs\" title=\"Actividades\">Ver</a><br>&nbsp;
				                   	<a href=\"../historial/?v=" . $r['Id'] . "\" style=\"margin-bottom:-3px;border:1px #000 solid;\" class=\"btn btn-info btn-md btn-xs\" title=\"Actividades\">Historial</a>&nbsp;
				                  </center>
				                </td>";
									echo "</tr>";
								}
							} else {
								echo "NO HAY REGISTROS PARA MOSTRAR";
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
	<script type="text/javascript" src="../../js/process/contactos.js"></script>

	<script type="text/javascript" src="../../assets/datepicker/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../js/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="../../js/process/sweetalert.min.js"></script>

	<script>
		function DelRegistro(Id) {
			/* Realiza conexión con el servidor */
			var id = [];
			$('.update_registro:checked').each(function(i) {
				id[i] = $(this).val();
			});
			if (id.length == 0) {
				// alert("No hay registros seleccionados para eliminar");
				swal("Error", "No hay registros seleccionados para eliminar", "error");
			} else {
				// if (!confirm("Esta seguro de ElIMINAR los registros seleccionados")) {
				//      return;
				//   }
				swal({
						title: "Eliminar Registros",
						text: "Esta seguro de eliminar los registros",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: 'btn-danger',
						cancelButtonText: 'Cancelar',
						confirmButtonText: 'Eliminar',
						closeOnConfirm: false,
						closeOnCancel: false

					},
					function(isConfirm) {
						if (isConfirm) {
							$.ajax({
									data: {
										"accion": "del",
										"pId": id
									},
									type: "POST",
									datatype: "json",
									url: "../../controller/contactosController.php",
								})
								.done(function(data) {
									swal({
											title: "Deleted!",
											text: data.message,
											type: "success"
										},
										function(isConfirm) {
											document.location.href = "index.php";
										}
									);

								})
								.fail(function() {
									alert("Ha ocurrido un problema");
								});

						} else {
							swal({
								title: "Cancelado!",
								text: "Your imaginary file has been deleted.",
								type: "error"
							});
						}

					});

			}
		}

		$(document).ready(function() {

			$("#Clean").click(function() { //"select all" change
				var vacio = "";
				$("#FiltroPrograma option[value=" + vacio + "]").attr("selected", true);
				$("#Filtrorigen option[value=" + vacio + "]").attr("selected", true);
				$("#Filtronombre").val("");
				$("#FiltroCedula").val("");
				/*$("#Filtrorigen option[value=""]").attr("selected",true);*/
			});

			$("#limpiar").click(function() { //"select all" change
				var status = this.checked; // "select all" checked status
				$('input[type=checkbox]').each(function() { //iterate all listed checkbox items
					$('input[type=checkbox]').prop("checked", false); //change ".checkbox" checked status
				});
			});

			$("#select_all").change(function() { //"select all" change
				var status = this.checked; // "select all" checked status
				$('input[type=checkbox]').each(function() { //iterate all listed checkbox items
					this.checked = status; //change ".checkbox" checked status
				});
			});

			$('#all_Registrados').click(function() {
				$('.registrado').each(function() { //iterate all listed checkbox items
					$('.registrado').prop("checked", true);
				});
			});

			$('#all_Gestionados').click(function() {
				$('.Gestionado').each(function() { //iterate all listed checkbox items
					$('.Gestionado').prop("checked", true);
				});

			});
			$('#all_Cargados').click(function() {
				$('.Cargados').each(function() { //iterate all listed checkbox items
					$('.Cargados').prop("checked", true);
				});

			});



			$(function() {

				$("#txtFecha1").datepicker({
					dateFormat: "yy-mm-dd",
					dayNamesMin: ["Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
					monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
					minDate: "",
					maxDate: ""
				});

				$("#txtFecha2").datepicker({
					dateFormat: "yy-mm-dd",
					dayNamesMin: ["Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
					monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
					minDate: "",
					maxDate: "",
				});
			});
			// $("#asigna_agente").click(function(){
			//   $("#Modal_Asigna_varios").modal({keyboard: true});
			// });
			$('.dataTables-example').dataTable({
				responsive: true,
				"dom": 'T<"clear">lfrtip',
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
			/* Init DataTables */
			var oTable = $('#editable').dataTable();
		});
	</script>
</body>

</html>