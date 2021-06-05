<?php
	include_once("../../AnsTek_libs/integracion.inc.php");
	include_once("../resourcesView.php");
	Session::valida_sesion("", "../../logout.php");
	include_once("../../model/contactos.class.php");
	include_once("../../model/usuarios.class.php");
	$userId = Session::get('Id');
	$user = new usuario($db);

	if ($userId == 1) {
		$where = " Where Id > 2 ";
		$rt = 'reporte';
	} else {
		$where = " Where Id >= 3 AND Sede = " . $userId;
		$rt = 'reporte';
	}
	$result = $user->selectAll($where);

	//Consulta para opcion 1
	$whereAdmin = " Where Status = 1 AND Id > 2 AND Perfil = 1 ";
	$optionA = "";
	$resultE = $user->selectAll($whereAdmin);
	if ($db->numRows($resultE) > 0) {
		while ($rA = $db->datos($resultE)) {
			$optionA .= "<option value=" . $rA["Id"] . ">" . $rA["Nombre"] . "</option>";
		}
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
	<?php recursos_css(); ?>
</head>

<body>
	<!-- Modal -->
	<div id="Modal_Usuarios" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Nuevo Usuario</h4>
				</div>
				<div class="modal-body">
					<form id="usuarios" enctype="multipart/form-data">
						<div class="form-group">
							<label class="">Adjuntar Foto</label>
							<input type="file" class="form-control" name="txtImg" id="txtImg" autofocus>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="txtDoc" name="txtDoc" placeholder="Ingrese su cedula">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="txtName" name="txtName" placeholder="Ingrese su nombre">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="txtDir" name="txtDir" placeholder="Ingrese su dirección">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="txtTel" name="txtTel" placeholder="Ingrese su teléfono">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="txtEml" name="txtEml" placeholder="Ingrese su E-mail">
						</div>

						<div class="form-group">
							<select class="form-control" name="SelPerfil" id="SelPerfil" required="">
								<option>Seleccione un perfil</option>
								<option value="1">SuperAdmin</option>
								<option value="0">Agente</option>
								<option value="5">Administrativo</option>
							</select>
						</div>
						<div class="form-group" id="selSuperAdmin">
							<select class="form-control" name="SelSuper" id="SelSuper">
								<option value="-1">Seleccione un super Administrador </option>
								<?php echo $optionA; ?>

							</select>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="txtUser" name="txtUser" placeholder="Ingrese un nombre de Usuario">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="txtPass" name="txtPass" placeholder="Genere una contraseña">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="txtPass2" name="txtPass2" placeholder="Confirme su contraseña">
							<input type="hidden" name="txtId" id="txtId" value="0">
							<input type="hidden" name="accion" id="" value="ins">
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
						<h3 class="page-header"><i class="fa fa-laptop"></i>Agentes</h3>
						<ol class="breadcrumb">
							<li><i class="fa fa-home"></i><a href="index.php">Inicio</a></li>
							<li><i class="fa fa-laptop"></i>Agentes</li>
						</ol>
					</div>
				</div>
				<button type="button" class="btn btn-primary" id="new_User">Nuevo</button>
				<section class="panel">
					<table class="table table-striped table-bordered table-hover " id="editable">
						<thead>
							<tr>
								<th><i class="icon_profile"></i>Status</th>
								<th><i class="icon_profile"></i>Nombre completo</th>
								<th><i class="icon_calendar"></i> Cedula</th>
								<th><i class="icon_mail_alt"></i>Direccion</th>
								<th><i class="icon_mobile"></i>E-mail</th>
								<th><i class="icon_mobile"></i>Usuario</th>
								<th><i class="icon_mobile"></i>Perfil</th>
								<th><i class="icon_mobile"></i>Foto</th>
								<th><i class="icon_cogs"></i> Privilegios</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($db->numRows($result) > 0) {
								while ($r = $db->datos($result)) {
									$perfil = ($r['Perfil'] == 1) ? "Administrador" : "Agente";
									$valStatus = ($r['Status'] == 1) ? "<img src='../../img/edo_ok.png' alt='Activo'>" : "<img src='../../img/edo_nok.png' alt='Inactivo'>";
									$Status = ($r['Status'] == 1) ? " <a href=\"#\" onclick=\"javascript:cambia_status('" . $r['Id'] . "' ,  '" . $r['Status'] . "');\" style=\"margin-bottom:-3px;\" class=\"btn btn-danger btn-md btn-xs\" title=\"Inactivo\">Desactivar</a>&nbsp;  " : "<a href=\"\"  onclick=\"javascript:cambia_status('" . $r['Id'] . "','" . $r['Status'] . "');\"  style=\"margin-bottom:-3px;\" class=\"btn btn-success btn-md btn-xs\" title=\"Editar\">Activar</a>&nbsp; ";
									echo "<tr>";
									echo "<td>" . $valStatus . "</td>";
									echo "<td>" . $r['Nombre'] . "</td>";
									echo "<td>" . $r['Cedula'] . "</td>";
									echo "<td>" . $r['Direccion'] . "</td>";
									echo "<td>" . $r['Email'] . "</td>";
									echo "<td>" . $r['Usuario'] . "</td>";
									echo "<td>" . $perfil . "</td>";
									echo "<td>" . '<center><img src=../../' . $r['Foto'] . ' width="60px"><center>' . "</td>";
									echo "<td>
				                  <center>
				             		<a href=\"../" . $rt . "/?v=" . $r['Id'] . "&n=" . $r['Cedula'] . "\" style=\"margin-bottom:-3px;\" class=\"btn btn-primary btn-md btn-xs\" title=\"Editar\">Reporte</a>&nbsp;
								" . $Status . "
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
	<script type="text/javascript" src="../../js/process/usuarios.js"></script>
	<script>
		$(document).ready(function() {
			$("#new_User").click(function() {
				$("#Modal_Usuarios").modal({
					keyboard: true
				});
			});
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