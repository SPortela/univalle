<?php
include_once("../../AnsTek_libs/integracion.inc.php");
include_once("../resourcesView.php");
//Session::valida_sesion("","../../logout.php");
if (Session::get('Perfil') != 6)
	header('Location: ../../logout.php');
include_once("../../model/contactos.class.php");
include_once("../../model/usuarios.class.php");
include_once("../../model/estados.class.php");
include_once("../../model/notificaciones.class.php");

$cedula_agente = Session::get('Cedula');
$perfil_usr = Session::get('Perfil');
$vId = Session::get('Id');
$contact = new contacto($db);
$where = " Where rg.Created_by = " . $vId . " GROUP BY rg.Id  ORDER BY Status ASC, Created_date DESC ";
//echo $where;
$result = $contact->selectAll($where);
// Objeto Usarios - Agentes
$stados = new estado($db);
$UsuariosObj = new usuario($db);
if ($vId == 22) {
	$optionA = "<option value='3'>Salitre</option>";
	$sedes = '';
} else {
	//CONSULTAMOS LAS SEDES DISPONIBLES
	$whereE = " Where Status = 1 AND Id > 1 AND Id != 19  AND Perfil = 1 ";
	$resultE = $UsuariosObj->selectAll($whereE);
	if ($db->numRows($resultE) > 0) {
		while ($rA = $db->datos($resultE)) {
			$optionA .= "<option value=" . $rA["Id"] . ">" . $rA["Nombre"] . "</option>";
		}
	}
	$sedes = '		
    		<option value="5">Medellin</option>
    		<option value="30">Villavicencio</option>
    		';
}
// Cuenta numero de contactos sin gestionar
$whereCount = " WHERE rg.Id > 1  AND rg.Created_by =" . $vId;
$sin_gestionar = $contact->Count($whereCount);
if ($db->numRows($sin_gestionar) > 0) {
	$rows = $db->datos($sin_gestionar);
} else {
	echo "No hay data";
}
$vroll = '';
$prof = Session::get('Perfil');
$IdUser = Session::get('Id');
if ($prof == 1) {
	$vroll = 'Administrador';
}
if ($prof == 0) {
	$vroll = 'Agente';
}
if ($prof == 2) {
	$vroll = 'Agencia';
}
$vname = Session::get('Nombre');
$vfoto = Session::get('Foto');
/* NOTIFICACIONES POR AGENTE*/
$Notifi = new notificacion($db);
$where = " Where nt.Id > 0 AND nt.Registro_Id = " . $IdUser . " AND nt.Status = 1";
$resultCC = $Notifi->Count($where);
if ($db->numRows($resultCC) > 0) {
	if ($r = $db->datos($resultCC)) {
		$noti = $r['num'];
	}
} else {
	echo " No hay datos";
}
/* Traemos datos de las notificaciones */
$whereNoti = "where nt.Id > 0 AND Registro_Id = " . $IdUser . " AND nt.Status = 1 ORDER BY nt.Id DESC";
$resultD = $Notifi->selectAll($whereNoti);
$resultD2 = $Notifi->selectAll($whereNoti);
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="CRM - Conjunto Digital">
	<meta name="keyword" content="CRM, Dashboard, Admin">
	<link rel="stylesheet" type="text/css" href="../../js/process/datepiker/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="../../js/process/datepiker/jquery.datetimepicker.css">
	<title>Agente</title>
	<!-- Recursos Css -->
	<?php recursos_css(); ?>
	<style type="text/css">
		#asig {
			background-color: #fc7119 !important;
			color: #000;
		}

		#gest {
			background-color: #81ad4c !important;
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

		#GestionarAgendado {
			display: none;
		}

		table {
			color: #000 !important
		}
	</style>
</head>
<body>
	<!-- Modal Subir Registros -->
	<div id="NuevaEmpresa" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registro</h4>
				</div>
				<div class="modal-body">
					<form id="Paciente">
						<div class="form-group">
							<label for="pwd">Nombre Completo:</label>
							<input type="text" class="form-control" id="txtName" name="txtName" placeholder="ingrese la razón social" required="">
						</div>
						<div class="form-group">
							<label for="pwd">Email:</label>
							<input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="ingrese el email" required="">
						</div>
						<div class="form-group">
							<label for="pwd">Teléfono o Celular:</label>
							<input type="text" class="form-control" id="txtCel" name="txtCel" placeholder="ingrese el teléfono fijo" required="">
						</div>
						<div class="form-group">
							<label for="pwd">Programa:</label>
							<select class="form-control" name="txtTratamiento" id="txtTratamiento" required="">
								
							</select>
						</div>

						<div class="form-group">
							<label>Ciudad</label>
							<input type="text" class="form-control input" name="txtCity" id="txtCity" value="Bogotá" disabled="">
						</div>


						<div class="form-group">
							<label for="txtStatus2">Medio por el que se enteró</label>
							<select class="form-control" name="txtStatus23" id="txtStatus23" required="">
								<option value="0">Seleccione</option>
								<option value="1">Whatsapp</option>
								<option value="2">Celular</option>
								<option value="3">Asistencia Fisica</option>
								<option value="4">Tv caracol</option>
								<option value="5">Tv city</option>
								<option value="6">Referido </option>
								<option value="7">Google</option>
								<option value="8">Facebook </option>
								<option value="9">Instagram </option>
								<option value="10">Llamada</option>
								<option value="11">Otro </option>
								<option value="12">Valla publicitaria</option>
								<option value="13">Página Web</option>

							</select>
						</div>

						<div class="form-group">
							<input type="hidden" class="form-control" id="txtTab" name="txtTab" value="1">
							<input type="hidden" class="form-control" id="txtId" name="txtId" value="0">
						</div>

						<div id="vId"></div>

						<button type="submit" class="btn btn-default">Enviar</button>
					</form>



				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
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
	<!-- /.modal CARGA DE REGISTROS -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
					<form enctype="multipart/form-data" action="../../controller/administrativoController.php" method="post" id="EnviarCarga">
						<div class="form-group">
							<select class="form-control" name="SedeSel" id="SedeSel" required="">
								<option value="">Seleccione</option>
								<?php echo $optionA;
								echo $sedes; ?>
							</select>
						</div>
						<div class="form-group">
							<label class="">Adjuntar archivo</label>
							<!-- <input type="file" class="form-control" name="uploadExcel" id="uploadExcel" autofocus> -->
							<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
							<input name="fichero_usuario" type="file" required="" class="form-control" />
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
	<!-- container section start -->
	<section id="container" class="">
		<!-- pinta header -->
		<header class="header dark-bg">
			<div class="toggle-nav">
				<div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
			</div>
			<!--logo start-->
			<a href="index.php" class="logo"><img src="../../assets/logo_mailing.png" width="50%"></a>
			<!--logo end-->
			<div class="nav search-row" id="top_menu">
				<!--  search form start -->
				<!--  search form end -->
			</div>
			<div class="top-nav notification-row">
				<!-- notificatoin dropdown start-->
				<ul class="nav pull-right top-menu">
					<!-- task notificatoin start -->
					<!-- task notificatoin end -->
					<!-- inbox notificatoin start-->
					<!-- inbox notificatoin end -->
					<!-- alert notification start-->
					<!-- alert notification end-->
					<!-- Notifi login dropdown start-->
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<span class="profile-ava">
								<img alt="" src="../../<?php echo $vfoto;  ?>">
							</span>
							<span class="username"><?php echo $vname . ' - ' . $vroll ?></span>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu extended logout">
							<div class="log-arrow-up"></div>
							<li class="eborder-top">
								<a href="../perfil.php"><i class="icon_profile"></i> Mi Perfil</a>
							</li>
							<li>
								<a href="../../admin/logout.php"><i class="icon_key_alt"></i> Cerrar Session</a>
							</li>
							<li>
								<a href="cambiarpass.php"><i class="icon_key_alt"></i> Cambiar Contraseña</a>
							</li>
						</ul>
					</li>
					<!-- user login dropdown end -->
				</ul>
				<!-- notificatoin dropdown end-->
			</div>
		</header>
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
						<h3 class="page-header"><i class="fa fa-laptop"></i>Clientes</h3>
						<ol class="breadcrumb">
							<li><i class="fa fa-home"></i><a href="index.php">Inicio</a></li>
							<li><i class="fa fa-laptop"></i>Clientes</li>
							<li><strong class="msj"> Tienes <?php echo $rows["num"]; ?> Clientes registrados </strong></li>
							<li></li>
						</ol>
						<form method="post" action="../descargar_xls.php" style="position: relative; top:0px;">
							<input type="text" name="txtFecha1" id="txtFecha1" value="" class="date" placeholder="Fecha Numero1">
							<input type="text" name="txtFecha2" id="txtFecha2" value="" class="date" placeholder="Fecha Numero2">
							<input type="hidden" name="CedulaAgente" id="CedulaAgente" value=<?php echo $cedula_agente; ?>>
							<input type="hidden" name="Sede" id="Sede" value=<?php echo $IdUser; ?>>
							<input type="hidden" name="Perfil" id="Perfil" value="<? echo $perfil_usr ?>">
							<button type="submit" class="btn btn-info">Descargar</button>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#NuevaEmpresa"> Nuevo Paciente </button>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"> Cargar Contactos </button>
							<a href="../cargar_registros.xlsx" download="../cargar_registros.xlsx" class="btn btn-default" title="Descargar Formato"><img src="../../assets/archivo.png" width="25px" style="position: relative; "></a>
						</form>
					</div>
				</div>
				<!-- <button type="button" class="btn btn-primary" id="new_User">Nuevo</button>
			<button type="button" class="btn btn-warning" id="asigna_agente" onclick="asignar_agentes();">Asignar</button> -->
				<section class="panel">
					<table class="table  table-bordered  " id="editable">
						<thead>
							<tr>
								<th width="8%">Status</th>
								<th>Nombre</th>
								<th>Email</th>
								<th>Celular</th>
								<th>Ciudad</th>
								<th>Programa</th>
								<th>Sede</th>
								<th width="15%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($db->numRows($result) > 0) {
								while ($r = $db->datos($result)) {
									$asignado = ($r['Asignado_a'] == "") ? "No asignado" : "Asignado a :" . $r['Nombre_agente'] . " - " . $r['Asignado_a'] . " - " . $r['Usuario_agente'] . " ";
									$valStatus = ($r['Status'] == 1) ? "<img src='../../img/edo_ok.png' alt='Activo'>" : "<img src='../../img/edo_nok.png' alt='Inactivo'>";
									if ($r['Status'] == 2) {
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
									$NameSede = "";
									if ($r['Sede'] == 3) {
										$NameSede = "Salitre";
									} elseif ($r['Sede'] == 5) {
										$NameSede = "Unicentro";
									}
									echo '<tr>';
									echo "<td style=\"background-color:" . $r['Color'] . "\">" . "1. " . $r['Nombre_estado'] . "</td>";
									echo "<td>" . $r['Nombre_completo'] . "</td>";
									echo "<td>" . $r['Email'] . "</td>";
									echo "<td>" . $r['Celular'] . "</td>";
									echo "<td>" . $r['Ciudad'] . "</td>";
									echo "<td>" . $r['Tratamiento'] . "</td>";
									echo "<td>" . $NameSede . "</td>";
									$gestio = "";
									$gestio = "
			    					<td>
			    	                  <center>
			    	                  	<a href=\"#\" onclick=\"javascript:VerDatos('" . $r['Id'] . "');\" style=\"margin-bottom:-3px;border:1px #000 solid;\" class=\"btn btn-default btn-md btn-xs\" title=\"Ver Información\">Ver</a>&nbsp;
			    						<a href=\"#\" onclick=\"javascript:cargaUpdateU('" . $r['Id'] . "');\" style=\"margin-bottom:-3px; border:1px #000 solid;font-weight:700;font-size:12px;\" class=\"btn btn-success btn-md btn-xs\" title=\"Actividades\" id=\"\">Editar</a>&nbsp;
			    	                   	<a href=\"../historial/?v=" . $r['Id'] . "\" style=\"margin-bottom:-3px; font-weight:700;font-size:12px;border:1px #000 solid;\" class=\"btn btn-info btn-md btn-xs\" title=\"Actividades\">Historial</a>&nbsp;
			    	                  </center>
			    	                </td>
			    		    	 ";
									echo $gestio;
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
	<script type="text/javascript" src="../../js/process/recepcion.js"></script>
	<script type="text/javascript" src="../../js/process/datepiker/jquery-ui.js"></script>
	<script type="text/javascript" src="../../js/process/datepiker/jquery.datetimepicker.full.js"></script>
	<script>
		$(document).ready(function() {
			$('#EnviarCarga').submit(function() {
				$(this).find('input[type=submit]').attr('disabled', 'disabled');
			});
			$('#ModalNotificacion').modal({
				keyboard: false
			})
			// $("#gestionar_btn").click(function(){
			//   $("#gestionar_contacto").modal({keyboard: true});
			// });
			$('#editable').DataTable({
				'paging': true,
				'lengthChange': true,
				'searching': true,
				'ordering': false,
				'info': true,
				'autoWidth': true,
				'responsive': true,
				'select': true,
				'language': {
					"emptyTable": "No hay datos disponibles en la tabla.",
					"info": "Del _START_ al _END_ de _TOTAL_ ",
					"infoEmpty": "Mostrando 0 registros de un total de 0.",
					"infoFiltered": "(filtrados de un total de _MAX_ registros)",
					"infoPostFix": "(actualizados)",
					"lengthMenu": "Mostrar _MENU_ registros",
					"loadingRecords": "Cargando...",
					"processing": "Procesando...",
					"search": "Buscar:",
					"searchPlaceholder": "Dato para buscar",
					"zeroRecords": "No se han encontrado coincidencias.",
					"paginate": {
						"first": "Primera",
						"last": "Última",
						"next": "Siguiente",
						"previous": "Anterior"
					}
				}
			});
			$(function() {
				$("#txtFecha1").datepicker({
					defaultDate: new Date(),
					dateFormat: "yy-mm-dd",
					icons: {
						time: 'far fa-clock',
						date: 'far fa-calendar',
						close: 'far fa-times'
					},
					dayNamesMin: ["Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
					monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
					minDate: "",
					maxDate: ""
				});
				$("#txtFecha2").datepicker({
					defaultDate: new Date(),
					dateFormat: "yy-mm-dd",
					dayNamesMin: ["Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
					monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
					minDate: "",
					maxDate: "",
				});
				$('#txtFechaEntrevista').datetimepicker({
					dayOfWeekStart: 1,
					startDate: <?php echo "'" . date("Y-m-d H:i:s") . "'" ?>,
					formatDate: 'Y/m/d',
					minDate: '-2019/07/22', //yesterday is minimum date(for today use 0 or -1970/01/01)
					maxDate: '+2019/08/30', //tomorrow is maximum date calendar
					allowTimes: ['8:00', '8:10', '8:20', '8:30', '8:40', '8:50',
						'9:00', '9:10', '9:20', '9:30', '9:40', '9:50',
						'10:00', '10:10', '10:20', '10:30', '10:40', '10:50',
						'11:00', '11:10', '11:20', '11:30', '11:40', '11:50',
						'12:00', '12:10', '12:20', '12:30', '12:40', '12:50',
						'13:00', '13:10', '13:20', '13:30', '13:40', '13:50',
						'14:00', '14:10', '14:20', '14:30', '14:40', '14:50',
						'15:00', '15:10', '15:20', '15:30', '15:40', '15:50',
						'16:00', '16:10', '16:20', '16:30', '16:40', '16:50'
					],
				});
				$('#txtFechaEntrevista2').datetimepicker({
					dayOfWeekStart: 1,
					startDate: <?php echo "'" . date("Y-m-d H:i:s") . "'" ?>,
					formatDate: 'Y/m/d',
					minDate: '-2019/07/22', //yesterday is minimum date(for today use 0 or -1970/01/01)
					maxDate: '+2019/08/30', //tomorrow is maximum date calendar
					allowTimes: ['8:00', '8:10', '8:20', '8:30', '8:40', '8:50',
						'9:00', '9:10', '9:20', '9:30', '9:40', '9:50',
						'10:00', '10:10', '10:20', '10:30', '10:40', '10:50',
						'11:00', '11:10', '11:20', '11:30', '11:40', '11:50',
						'12:00', '12:10', '12:20', '12:30', '12:40', '12:50',
						'13:00', '13:10', '13:20', '13:30', '13:40', '13:50',
						'14:00', '14:10', '14:20', '14:30', '14:40', '14:50',
						'15:00', '15:10', '15:20', '15:30', '15:40', '15:50',
						'16:00', '16:10', '16:20', '16:30', '16:40', '16:50'
					],
				});
			});
		});
	</script>
</body>
</html>