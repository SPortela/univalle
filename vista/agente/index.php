<?php
include_once("../../AnsTek_libs/integracion.inc.php");
include_once("../resourcesView.php");
Session::valida_sesion("", "../../logout.php");
if (Session::get('Perfil') == 1)
	header('Location: ../../logout.php');
include_once("../../model/contactos.class.php");
include_once("../../model/estados.class.php");
include_once("../../model/notificaciones.class.php");
include_once("../../model/usuarios.class.php");

$cedula_agente = Session::get('Cedula');
$vId = Session::get('Id');
$contact = new contacto($db);
if (empty($_GET)) {
	$valor = 0;
} else {
	$valor = $_GET['v'];
}
$reception = "";
if ($vId == 22) {
	$reception = " OR rg.Created_by = " . $vId;
}
if (!isset($_GET['v'])) {
	$where = " WHERE (rg.Asignado_a = '" . $cedula_agente . "' " . $reception . ") GROUP BY rg.Id  ORDER BY Status ASC, Created_date DESC ";
} else {
	$where = " WHERE (rg.Asignado_a = " . $cedula_agente .  " " . $reception . ")  AND rg.Status =  " . $valor . " GROUP BY rg.Id  ORDER BY Status ASC, Created_date DESC ";
}

$UsuarioAct = new usuario($db);
$whereAct = " WHERE Id = " . $vId;
$resultAct = $UsuarioAct->selectAll($whereAct);
$Sede = 0;
if ($db->numRows($resultAct) > 0) {
	while ($rA = $db->datos($resultAct)) {
		$Sede = $rA["Sede"];
	}
}

$UsuariosObj = new usuario($db);
//CONSULTAMOS USUARIOS DE LA MISMA SEDE
$whereE = " WHERE Sede = " . $Sede . " AND Id <> " . $vId;
$resultE = $UsuariosObj->selectAll($whereE);
$optionAgentes = "";
if ($db->numRows($resultE) > 0) {
	while ($rA = $db->datos($resultE)) {
		$optionAgentes .= "<option value=" . $rA["Cedula"] . ">" .  $rA["Nombre"] . "</option>";
	}
}

//echo $where;
$result = $contact->selectAll($where);
// Objeto Usarios - Agentes
$stados = new estado($db);
//Consulta para opcion 1
$whereE = " WHERE Status = 1 AND Id > 3 AND Tipo = 1 ";
$resultE = $stados->selectAll($whereE);
$optionA = "";
if ($db->numRows($resultE) > 0) {
	while ($rA = $db->datos($resultE)) {
		$optionA .= "<option value=" . $rA["Id"] . ">" . $rA["Nombre"] . "</option>";
	}
}
//Consulta para opcion 2
$whereE2 = " WHERE Status = 1 AND Id > 3 AND Tipo = 2 ";
$resultE2 = $stados->selectAll($whereE2);
if ($db->numRows($resultE2) > 0) {
	while ($rA2 = $db->datos($resultE2)) {
		$optionA2 .= "<option value=" . $rA2["Id"] . ">" . $rA2["Nombre"] . "</option>";
	}
}
// Cuenta numero de contactos sin gestionar
$whereCount = " WHERE rg.STATUS = 2  AND Asignado_a =" . $cedula_agente;
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
$modalNoti = "";
$whereNoti = "where nt.Id > 0 AND Registro_Id = " . $IdUser . " AND nt.Status = 1 ORDER BY nt.Id DESC";
$resultD = $Notifi->selectAll($whereNoti);
$resultD2 = $Notifi->selectAll($whereNoti);
if ($db->numRows($resultD2) > 0) {
	while ($rD2 = $db->datos($resultD2)) {
		if (date("Y-m-d H:i:s") > $rD2['Fecha_Cita']) {
			$modalNoti =  '
					<div id="ModalNotificacion" class="modal fade" role="dialog">
					  <div class="modal-dialog">
					    <!-- Modal content-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Información Importante ahora : ' . date("Y-m-d H:i:s") . '</h4>
					      </div>
					      <div class="modal-body">
					        <p>Tienes una notificacion pendiente Agendada para hoy: ' . $rD2['Fecha_Cita'] . '</p>
							<table class="table table-bordered text-center">
							  <tr>
							    <td>
							      <p>Estado cita </p>
							    </td>
							    <td>
							      <div id="td">Agendado</div>
							    </td>
							  </tr>
							  <tr>
							    <td>
							      <p>Estado registro </p>
							    </td>
							    <td>
							      <div id=""> ' . $rD2['NombreEstado'] . '</div>
							    </td>
							  </tr>
							  <tr>
							    <td>
							      <p>Información Cliente</p>
							    </td>
							    <td>
							      <div id="td">
									<ul>
										<li>Nombre: ' . $rD2['Nombre'] . ' </li>
										<li>correo: ' . $rD2['Email'] . '</li>
										<li>Celular: ' . $rD2['Celular'] . ' </li>
									</ul>
							      </div>
							    </td>
							  </tr>
							  <tr>
							    <td>
							      <p>Fecha cita</p>
							    </td>
							    <td>
							      <div id="td">' . $rD2['Fecha_Cita'] . '</div>
							    </td>
							  </tr>
							  <tr>
							    <td>
							      <p>Observación</p>
							    </td>
							    <td>
							      <div id="td">' . $rD2['Comentario'] . '</div>
							    </td>
							  </tr>
							  <tr>
							    <td>
							      <p>atender después</p>
							    </td>
							    <td>
							      <div class="form-group">
							      	<form class="form-inline" autocomplete="off">
										<p>Cuando?</p>
										<div class="form-group">
										<input type="text" name="txtFechaEntrevista2" id="txtFechaEntrevista2" class="form-control" placeholder="Fecha">
										</div>
										<div class="form-group">
											<select class="form-control" name="" id="HoraDisp2" >
												<option>seleccione...</option>
											</select>
										</div>
										<input type="hidden" name="upNoti" id="upNoti" value="' . $rD2['Id'] . '">
										<button class="btn btn-success" id="NuevaFecha" type="button">Agendar</button>
							      	</form>
							      </div>
							    </td>
							  </tr>
							  <tr>
							    <td>
							      <p>Gestionar</p>
							    </td>
							    <td>
							      <button class="btn btn-success" id="BtnGestionarAgendado" type="button">Gestionar</button>
							    </td>
							  </tr>
							</table>
							<div class="panel panel-success" id="GestionarAgendado">
							  <div class="panel-body">
								<form id="Formgestionar1" autocomplete="off">
								  <div class="form-group">
									<label for="txtStatus">Estado 1</label>
								    <select class="form-control" name="txtStatus3" id="txtStatus3" required="">
								    	<option value="">Seleccione</option>
								    	' . $optionA . '
								    </select>
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
										<option value="14">Teleantioquia</option>
								    </select>
								  </div>
								  <div class="form-group">
								  	<label for="txtObs">Comentarios</label>
								  	<textarea class="form-control" name="txtObs3" id="txtObs3" required="" rows="12"  placeholder=""></textarea>
								  </div>
								  	<div class="form-group" id="opcionCita">
						          	<div class="col-md-12">
						          			<h4>DATOS REUNIÓN (opcional)</h4>
						          	</div>
						          	<div class="col-md-6">
						          		<label for="txtFechaEntrevista">Seleccione fecha</label>
						          		<input type="text" name="txtFechaEntrevistaG" id="txtFechaEntrevistaG" class="form-control">
						          	</div>
						          	<div class="col-md-6">
						          		<label for="txtFechaEntrevista">Seleccione una hora disponible </label>
						          		<select class="form-control" name="" id="HoraDispG" >
						          			<option>seleccione...</option>
						          		</select>
						          	</div>
						          </div>
								  <input type="hidden" name="txtId" id="txtId" value="' . $rD2['IdEmp'] . '">
								  <input type="hidden" name="IdNotificacion" id="IdNotificacion" value="' . $rD2['Id'] . '">
								  <input type="hidden" name="IdUsuario" id="IdUsuario" value="' . $rD2['Registro_Id'] . '">
								  <button type="button" class="btn btn-default" id="EnviarFormGestionado">Enviar</button>
								</form>
							  </div>
							  <div class="panel-footer">Panel Footer</div>
							</div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>';
		} else {
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
	<meta name="author" content="GeeksLabs">
	<meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
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

		#PanelGestionarNotificacion {
			display: none;
		}

		.notification {
			height: 500px;
			overflow-y: scroll;
			overflow-x: auto;
		}

		#opcionCita,
		#opcionCita2 {
			display: none;
		}

		table {
			color: #000 !important
		}
	</style>
</head>

<body>
	<?php echo $modalNoti; ?>
	<!-- Modal Subir Registros -->
	<div id="NuevaEmpresa" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registro Paciente</h4>
				</div>
				<div class="modal-body">
					<form id="Paciente" autocomplete="off">
						<div class="form-group">
							<label for="pwd">Nombre Completo:</label>
							<input type="text" class="form-control" id="txtNameO" name="txtNameO" placeholder="ingrese su nombre" required="">
						</div>
						<div class="form-group">
							<label for="pwd">Email:</label>
							<input type="email" class="form-control" id="txtEmailO" name="txtEmailO" placeholder="ingrese el email">
						</div>
						<div class="form-group">
							<label for="pwd">Teléfono o Celular:</label>
							<input type="text" class="form-control" id="txtCelO" name="txtCelO" placeholder="ingrese el teléfono fijo" required="">
						</div>
						<div class="form-group">
							<label for="pwd">Tratamiento:</label>
							<select class="form-control" name="txtTratamientoO" id="txtTratamientoO" required="">
								<option value="">Tratamiento de tu interes</option>
								<option value="Implante Capilar">Implante Capilar</option>
								<option value="Diagnóstico">Diagnóstico</option>
								<option value="Restauración de barba">Restauración de barba</option>
								<option value="Restauración de cejas">Restauración de cejas</option>
								<option value="Tratamiento de regeneración capilar">Tratamiento de regeneración capilar</option>
								<option value="Micropigmentación">Micropigmentación</option>
								<option value="Alopecia femenina">Alopecia femenina</option>
							</select>
						</div>
						<div class="form-group">
							<label>Ciudad</label>
							<select class="form-control input" name="txtCityO" id="txtCityO" require="">
								<option value="">Seleccione...</option>
								<option value="Arauca">Arauca</option>
								<option value="Armenia">Armenia</option>
								<option value="Barranquilla">Barranquilla</option>
								<option value="Bogotá">Bogotá</option>
								<option value="Bucaramanga">Bucaramanga</option>
								<option value="Cali">Cali</option>
								<option value="Cartagena">Cartagena</option>
								<option value="Cúcuta">Cúcuta</option>
								<option value="Florencia">Florencia</option>
								<option value="Ibagué">Ibagué</option>
								<option value="Leticia">Leticia</option>
								<option value="Manizales">Manizales</option>
								<option value="Medellín">Medellín</option>
								<option value="Mitú">Mitú</option>
								<option value="Mocoa">Mocoa</option>
								<option value="Montería">Montería</option>
								<option value="Neiva">Neiva</option>
								<option value="Pasto">Pasto</option>
								<option value="Pereira">Pereira</option>
								<option value="Popayán">Popayán</option>
								<option value="Puerto Carreño">Puerto Carreño</option>
								<option value="Puerto Inírida">Puerto Inírida</option>
								<option value="Quibdó">Quibdó</option>
								<option value="Riohacha">Riohacha</option>
								<option value="San Andrés">San Andrés</option>
								<option value="San José del Guaviare">San José del Guaviare</option>
								<option value="Santa Marta">Santa Marta</option>
								<option value="Sincelejo">Sincelejo</option>
								<option value="Tunja">Tunja</option>
								<option value="Valledupar">Valledupar</option>
								<option value="Villavicencio">Villavicencio</option>
								<option value="Yopal">Yopal</option>
							</select>
						</div>
						<div class="form-group">
							<label for="txtStatus2">Medio por el que se enteró</label>
							<select class="form-control" name="txtInfoPO" id="txtInfoPO" required="">
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
								<option value="14">Teleantioquia</option>

							</select>
						</div>
						<div class="form-group">
							<input type="hidden" class="form-control" id="txtTabO" name="txtTabO" value="0">
							<input type="hidden" class="form-control" id="txtIdO" name="txtIdO" value="0">
							<input type="hidden" class="form-control" id="txtCedulaO" name="txtCedulaO" value="<?php echo $cedula_agente; ?>">
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
	<!-- Fin Modal -->
	<div id="ModalNotificacion2" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Información Importante ahora </h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered text-center">
						<tr>
							<td>
								<p>Estado Cita </p>
							</td>
							<td>
								<div id="stGestion"></div>
							</td>
						</tr>

						<tr>
							<td>
								<p>Estado registro</p>
							</td>
							<td>
								<div id="stRegistro"></div>
							</td>
						</tr>

						<tr>
							<td>
								<p>Información Cliente</p>
							</td>
							<td>
								<div id="td">
									<ul>
										<li>Nombre:<p id="pName"></p>
										</li>
										<li>correo:<p id="pCor"></p>
										</li>
										<li>Celular: <p id="pCel"></p>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<p>Fecha cita</p>
							</td>
							<td>
								<div id="DateGestion"></div>
							</td>
						</tr>
						<tr>
							<td>
								<p>Observación</p>
							</td>
							<td>
								<div id="ComentAgendado"></div>
							</td>
						</tr>
						<tr>
							<td>
								<p>atender después</p>
							</td>
							<td>
								<div class="form-group">
									<form class="form-inline" autocomplete="off">
										<p>Cuando?</p>
										<div class="form-group">
											<input type="text" name="txtFechaGestionNoti" id="txtFechaGestionNoti" class="form-control">
										</div>
										<div class="form-group">
											<select class="form-control" name="" id="HoraDisp3">
												<option>seleccione...</option>
											</select>
										</div>
										<input type="hidden" name="upNotiGestion" id="upNotiGestion" value="">
										<button class="btn btn-success" id="NuevaFechaGestion" type="button">Agendar</button>
									</form>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<p>Gestionar</p>
							</td>
							<td>
								<button class="btn btn-success" id="BtnNotificacion" type="button">Gestionar</button>
							</td>
						</tr>
					</table>
					<div class="panel panel-success" id="PanelGestionarNotificacion">
						<div class="panel-body">

							<form id="Formgestionar2" autocomplete="off">
								<div class="form-group">
									<label for="txtStatus">Estado 1</label>
									<select class="form-control" name="txtStatusGestion" id="txtStatusGestion" required="">
										<option value="">Seleccione</option>
										<?php
										echo $optionA;
										?>

									</select>
								</div>

								<div class="form-group">
									<label for="txtStatus2">Medio por el que se enteró</label>
									<select class="form-control" name="txtInfoGestion" id="txtInfoGestion" required="">
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
										<option value="14">Teleantioquia</option>

									</select>
								</div>

								<div class="form-group">
									<label for="txtObs">Comentarios</label>
									<textarea class="form-control" name="txtObsGestion" id="txtObsGestion" required="" rows="12" placeholder=""></textarea>
								</div>



								<div class="form-group" id="opcionCita2">
									<div class="col-md-12">
										<h4>DATOS REUNIÓN (opcional)</h4>
									</div>

									<div class="col-md-6">
										<label for="txtFechaEntrevista">Seleccione fecha</label>
										<input type="text" name="txtFechaEntrevistaG2" id="txtFechaEntrevistaG2" class="form-control">
									</div>
									<div class="col-md-6">
										<label for="txtFechaEntrevista">Seleccione una hora disponible </label>
										<select class="form-control" name="" id="HoraDispG2">
											<option>seleccione...</option>
										</select>
									</div>
								</div>


								<input type="hidden" name="txtEmpGestion" id="txtEmpGestion" value="">
								<input type="hidden" name="IdNotiGestion" id="IdNotiGestion" value="">
								<input type="hidden" name="IdUsuarioGestion" id="IdUsuarioGestion" value="">
								<button type="button" class="btn btn-default" id="EnviarGestionado">Enviar</button>
							</form>


						</div>
						<div class="panel-footer">Panel Footer</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- MODAL REGISTRO USUARIOS-->
	<div class="modal fade" id="verEmpresa">
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
								<p>Estado 1</p>
							</td>
							<td>
								<p id="st1"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Como se entero</p>
							</td>
							<td>
								<p id="st2"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Nombre</p>
							</td>
							<td>
								<p id="nom"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Teléfono</p>
							</td>
							<td>
								<p id="tel"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Email</p>
							</td>
							<td>
								<p id="ema"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Ciudad</p>
							</td>
							<td>
								<p id="ciu"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Tratamiento</p>
							</td>
							<td>
								<p id="tra"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Fecha Registro</p>
							</td>
							<td>
								<p id="fec"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Origen</p>
							</td>
							<td>
								<p id="ori"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Fecha Asignado</p>
							</td>
							<td>
								<p id="Fas"></p>
							</td>
						</tr>

						<tr>
							<td>
								<p>Creado por</p>
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
	<!-- Modal Gestionar Contacto -->
	<div id="gestionar_contacto" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Gestionar Registro</h4>
				</div>
				<div class="modal-body">
					<form id="gestionar" autocomplete="off">
						<div class="form-group">
							<label for="txtStatus">Estado 1</label>
							<select class="form-control" name="txtStatus" id="txtStatus" required="">
								<option value="">Seleccione</option>
								<?php echo $optionA; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="txtStatus2">Medio por el que se enteró</label>
							<select class="form-control" name="txtStatus2" id="txtStatus2">
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
								<option value="14">Teleantioquia</option>
							</select>
						</div>
						<div class="form-group">
							<label for="txtObs">Comentarios</label>
							<textarea class="form-control" name="txtObs" id="txtObs" required="" rows="12" placeholder=""></textarea>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<h4>DATOS REUNIÓN (opcional)</h4>
							</div>
							<div class="col-md-6">
								<label for="txtFechaEntrevista">Seleccione fecha</label>
								<input type="text" name="txtFechaEntrevista" id="txtFechaEntrevista" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="txtFechaEntrevista">Seleccione una hora disponible </label>
								<select class="form-control" name="" id="HoraDisp">
									<option>seleccione...</option>
								</select>
							</div>
						</div>
						<input type="hidden" name="txtId3" id="txtId3">
						<button type="submit" class="btn btn-default">Enviar</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>

		</div>
	</div>
	<!-- End Gestionar Contacto -->

	<!-- BEGIN CEDER REGISTRO -->
	<div id="ceder-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Ceder Registro</h4>
				</div>
				<div class="modal-body">
					<form id="ceder-form" autocomplete="off">
						<div class="row g-3">
							<div class="col-sm-12 mb-3 text-center">
								<label for="txtAgente">Agente a Ceder
									<select class="form-control" name="txtAgente" id="txtAgente" required>
										<option value="">Seleccione</option>
										<?php echo $optionAgentes; ?>
									</select>
								</label>
							</div>
						</div>
						<div class="row g-3">
							<div class="col text-center">
								<input type="hidden" name="txtCederId" id="txtCederId">
								<button type="submit" class="btn btn-default">Enviar</button>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>

		</div>
	</div>
	<!-- END CEDER REGISTRO -->

	<!-- BEGIN CEDER REGISTROS -->
	<div id="ceder-varios-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Ceder Registros</h4>
				</div>
				<div class="modal-body">
					<form id="ceder-varios-form" autocomplete="off">
						<div class="row g-3">
							<div class="col-sm-6">
								<label for="txtAgenteV">
									Agente a Ceder
									<select class="form-control" name="txtAgenteV" id="txtAgenteV" required>
										<option value="">Seleccione</option>
										<?php echo $optionAgentes; ?>
									</select>
								</label>
							</div>
							<div class="col-sm-6">
								<label for="txtCantidad">
									Cantidad a Ceder
									<input class="form-control form-control-sm" type="number" name="txtCantidad" id="txtCantidad" required>
								</label>
							</div>
						</div>
						<div class="row g-3">
							<div class="col-sm-12">
								<input type="hidden" name="txtIdUser" value=<?php echo $vId ?>>
								<div class="form-text text-center">Se cederan solo registros en estado <strong>Asignado</strong></div>
							</div>
							<div class="col-sm-12 text-center">
								<button type="submit" class="btn btn-default">Enviar</button>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>

		</div>
	</div>
	<!-- END CEDER REGISTROS -->

	<!-- container section start -->
	<section id="container">
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
					<li id="alert_notificatoin_bar" class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<i class="icon-bell-l"></i>
							<?php
							if ($noti != 0) {
								echo ' <span class="badge bg-important">' . $noti . '</span> ';
							}
							?>
						</a>
						<ul class="dropdown-menu extended notification">
							<div class="notify-arrow notify-arrow-blue"></div>
							<li>
								<p class="blue">Tienes <?php echo $noti; ?> Notificaciones Pendientes </p>
							</li>
							<li>
								<div class="col-md ">
									<div class="input-group">
										<?php echo '<input type="hidden" id="idUser" value=' . $IdUser . ' />'; ?>
										<input type="text" class="form-control form-control-sm" id="buscaNotifica" />
										<span class="input-group-addon">
											<i class="fa fa-search"></i>
										</span>
									</div>
								</div>
							</li>
							<ul id="listNotifications">
								<?php
								if ($db->numRows($resultD) > 0) {
									while ($rD = $db->datos($resultD)) {
										echo '
											<li>
											<a href="#" onclick="javascript:cargaModal(' . $rD['Id'] . ')">
												<span class="label label-primary"><i class="icon_profile"></i></span>
												' . $rD['Nombre'] . '
												<p>' . $rD['Comentario'] . '</p>
												<span class="small italic pull-right">' . $rD['Fecha_Cita'] . '</span>
											</a>
											</li>
										';
									}
								} else {
									echo " No hay datos";
								}
								?>
							</ul>
							<ul class="d-none" id="listSearch">
							</ul>
							<li>
								<a href="#">See all notifications</a>
							</li>
						</ul>
					</li>
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
		<?php getMenuAgente($cedula_agente, $db); ?>
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
							<li><strong class="msj"> Tienes <?php echo $rows["num"]; ?> clientes sin gestionar </strong></li>

						</ol>
						<form method="post" action="descargar_excel_agente.php" style="position: relative; top:0px;" autocomplete="off">
							<input type="text" name="txtFecha1" id="txtFecha1" value="" class="date" placeholder="Fecha Numero1">
							<input type="text" name="txtFecha2" id="txtFecha2" value="" class="date" placeholder="Fecha Numero2">
							<input type="hidden" name="CedulaAgente" id="CedulaAgente" value=<?php echo $cedula_agente; ?>>
							<button type="submit" class="btn btn-info">Descargar</button>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#NuevaEmpresa"> Nuevo Paciente </button>
							<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ceder-varios-modal"> Ceder Contactos </button>
						</form>
					</div>
				</div>
				<br />
				<!-- <button type="button" class="btn btn-primary" id="new_User">Nuevo</button>
			<button type="button" class="btn btn-warning" id="asigna_agente" onclick="asignar_agentes();">Asignar</button> -->
				<section class="panel">
					<table class="table table-bordered" id="editable">
						<thead>
							<tr>
								<th width="10%">Status</th>
								<th>Nombre</th>
								<th>Email</th>
								<th>Celular</th>
								<th>Ciudad</th>
								<th>Fecha asignado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($db->numRows($result) > 0) {
								while ($r = $db->datos($result)) {
									$asignado = ($r['Asignado_a'] == "") ? "No asignado" : "Asignado a :" . $r['Nombre_agente'] . " - " . $r['Asignado_a'] . " - " . $r['Usuario_agente'] . " ";
									$valStatus = ($r['Status'] == 1) ? "<img src='../../img/edo_ok.png' alt='Activo'>" : "<img src='../../img/edo_nok.png' alt='Inactivo'>";
									
									echo "<td style=\"background-color:" . $r['Color'] . "\">" . "1. " . $r['Nombre_estado'] .  "</td>";
									echo "<td>" . $r['Nombre_completo'] . "</td>";
									echo "<td>" . $r['Email'] . "</td>";
									echo "<td>" . $r['Celular'] . "</td>";
									echo "<td>" . $r['Ciudad'] . "</td>";
									echo "<td>" . $r['Fecha_asignado'] . "</td>";
									$gestio = "";
									if ($r['IdNoti'] != ""  and  $r['NotiStatus'] == 1) {
										$gestio = "
											<td>
												<center>
													<a href=\"#\" onclick=\"javascript:VerDatos('" . $r['Id'] . "');\"  class=\"btn btn-default btn-md btn-xs\" title=\"Ver Información\">Ver</a>&nbsp;
													<a href=\"#\" onclick=\"javascript:cargaModal('" . $r['IdNoti'] . "');\"  class=\"btn btn-success btn-md btn-xs\" title=\"Gestionar Cita\" id=\"\">Gestionar Cita</a>&nbsp;
													<a href=\"../historial/?v=" . $r['Id'] . "\" class=\"btn btn-info btn-md btn-xs\" title=\"Actividades\">Historial</a>&nbsp;
													<a href=\"#\" onclick=\"javascript:cederContacto('" . $r['Id'] . "');\" class=\"btn btn-warning btn-md btn-xs\" title=\"Ceder Contacto\" id=\"\">Ceder Contacto</a>&nbsp;
												</center>
											</td>";
									} else {
										$gestio = "
											<td>
												<center>
													<a href=\"#\" onclick=\"javascript:VerDatos('" . $r['Id'] . "');\" class=\"btn btn-default btn-md btn-xs\" title=\"Ver Información\">Ver</a>&nbsp;
													<a href=\"#\" onclick=\"javascript:cargaGestion('" . $r['Id'] . "');\" class=\"btn btn-success btn-md btn-xs\" title=\"Gestionar\" id=\"\">Gestionar</a>&nbsp;
													<a href=\"../historial/?v=" . $r['Id'] . "\" class=\"btn btn-info btn-md btn-xs\" title=\"Historial\">Historial</a>&nbsp;
													<a href=\"#\" onclick=\"javascript:cederContacto('" . $r['Id'] . "');\" class=\"btn btn-warning btn-md btn-xs\" title=\"Ceder Contacto\" id=\"\">Ceder Contacto</a>&nbsp;	
												</center>
											</td>";
									}
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
	<script type="text/javascript" src="../../js/process/gestionar.js"></script>
	<script type="text/javascript" src="../../js/process/gestionarReserva.js"></script>
	<script type="text/javascript" src="../../js/process/CesionContacto.js"></script>
	<script type="text/javascript" src="../../js/process/datepiker/jquery-ui.js"></script>
	<script type="text/javascript" src="../../js/process/datepiker/jquery.datetimepicker.full.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".dropdown-menu").on("click", function(e) {
				e.stopPropagation();
			});
			$("#buscaNotifica").keyup(function() {
				var parametroBusca = {
					buscaNotifica: $(this).val(),
					idUser: $("#idUser").val()
				}
				$.ajax({
					data: parametroBusca,
					url: 'busqueda.php',
					type: 'post',
					beforeSend: function() {},
					success: function(response) {
						if (response == "") {
							$("#listNotifications").removeClass("d-none");
							$("#listSearch").addClass("d-none");
						} else {
							$("#listNotifications").addClass("d-none");
							$("#listSearch").removeClass("d-none");
							$("#listNotifications").html(response);
						}
					}
				})
			});
			$('#ModalNotificacion').modal({
				keyboard: false
			});
			/* Init DataTables */
			$('#editable').dataTable({
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
					},
				},
			});
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
			$('#txtFechaEntrevista').datetimepicker({
				timepicker: false,
				format: 'Y-m-d',
				minDate: '0',
				startDate: <?php echo "'" . date("Y-m-d") . "'" ?>,
				maxDate: '+2020-12-30', //tomorrow is maximum date calendar
				onChangeDateTime: function(dp, $input) {
					var date = $input.val();
					$.ajax({
							url: '../../controller/fecha.php',
							type: 'POST',
							dataType: 'json',
							data: {
								"Fecha": date
							},
						})
						.done(function(data) {
							var horasEnabled = data.message;
							var contador;
							$("#HoraDisp").empty();
							for (contador = 0; contador < horasEnabled.length; contador++) {

								//console.log("AQUI" +  horasEnabled[contador]);
								//$("# option[value='"+horasEnabled[contador]+"']").attr("selected",false);

								$("#HoraDisp").append("<option>" + horasEnabled[contador] + "</option>");
							}
						})
						.fail(function(data) {

						})
						.always(function() {
							console.log("complete");
						});

				},

			});
			$('#txtFechaEntrevista2').datetimepicker({
				timepicker: false,
				format: 'Y-m-d',
				minDate: '0',
				startDate: <?php echo "'" . date("Y-m-d") . "'" ?>,
				maxDate: '+2020-12-30', //tomorrow is maximum date calendar
				onChangeDateTime: function(dp, $input) {
					var date = $input.val();
					$.ajax({
							url: '../../controller/fecha.php',
							type: 'POST',
							dataType: 'json',
							data: {
								"Fecha": date
							},
						})
						.done(function(data) {
							var horasEnabled = data.message;
							var contador;
							$("#HoraDisp2").empty();
							for (contador = 0; contador < horasEnabled.length; contador++) {

								//console.log("AQUI" +  horasEnabled[contador]);
								//$("# option[value='"+horasEnabled[contador]+"']").attr("selected",false);

								$("#HoraDisp2").append("<option>" + horasEnabled[contador] + "</option>");
							}
						})
						.fail(function(data) {

						})
						.always(function() {
							console.log("complete");
						});

				},

			});
			$('#txtFechaGestionNoti').datetimepicker({
				timepicker: false,
				format: 'Y-m-d',
				minDate: '0',
				startDate: <?php echo "'" . date("Y-m-d") . "'" ?>,
				maxDate: '+2020-12-30', //tomorrow is maximum date calendar
				onChangeDateTime: function(dp, $input) {
					var date = $input.val();
					$.ajax({
							url: '../../controller/fecha.php',
							type: 'POST',
							dataType: 'json',
							data: {
								"Fecha": date
							},
						})
						.done(function(data) {
							var horasEnabled = data.message;
							var contador;
							$("#HoraDisp3").empty();
							for (contador = 0; contador < horasEnabled.length; contador++) {


								//$("# option[value='"+horasEnabled[contador]+"']").attr("selected",false);

								$("#HoraDisp3").append("<option>" + horasEnabled[contador] + "</option>");
							}
						})
						.fail(function(data) {

						})
						.always(function() {
							console.log("complete");
						});

				},

			});
			$('#txtFechaEntrevistaG').datetimepicker({
				timepicker: false,
				format: 'Y-m-d',
				minDate: '0',
				startDate: <?php echo "'" . date("Y-m-d") . "'" ?>,
				maxDate: '+2020-12-30', //tomorrow is maximum date calendar
				onChangeDateTime: function(dp, $input) {
					var date = $input.val();
					$.ajax({
							url: '../../controller/fecha.php',
							type: 'POST',
							dataType: 'json',
							data: {
								"Fecha": date
							},
						})
						.done(function(data) {
							var horasEnabled = data.message;
							var contador;
							$("#HoraDispG").empty();
							for (contador = 0; contador < horasEnabled.length; contador++) {

								//console.log("AQUI" +  horasEnabled[contador]);
								//$("# option[value='"+horasEnabled[contador]+"']").attr("selected",false);

								$("#HoraDispG").append("<option>" + horasEnabled[contador] + "</option>");
							}
						})
						.fail(function(data) {

						})
						.always(function() {
							console.log("complete");
						});

				},

			});
			$('#txtFechaEntrevistaG2').datetimepicker({
				timepicker: false,
				format: 'Y-m-d',
				minDate: '0',
				startDate: <?php echo "'" . date("Y-m-d") . "'" ?>,
				maxDate: '+2020-12-30', //tomorrow is maximum date calendar
				onChangeDateTime: function(dp, $input) {
					var date = $input.val();
					$.ajax({
							url: '../../controller/fecha.php',
							type: 'POST',
							dataType: 'json',
							data: {
								"Fecha": date
							},
						})
						.done(function(data) {
							var horasEnabled = data.message;
							var contador;
							$("#HoraDispG2").empty();
							for (contador = 0; contador < horasEnabled.length; contador++) {

								//console.log("AQUI" +  horasEnabled[contador]);
								//$("# option[value='"+horasEnabled[contador]+"']").attr("selected",false);

								$("#HoraDispG2").append("<option>" + horasEnabled[contador] + "</option>");
							}
						})
						.fail(function(data) {

						})
						.always(function() {
							console.log("complete");
						});

				},

			});
		});
	</script>
</body>

</html>