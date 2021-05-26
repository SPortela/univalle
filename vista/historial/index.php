<?php
	include_once("../../AnsTek_libs/integracion.inc.php");
	include_once("../resourcesView.php");
	Session::valida_sesion("","../../logout.php");
	// if(Session::get('Perfil') == 1 )
	// header('Location: ../../logout.php');
	include_once("../../model/hoja_ruta.class.php");
	include_once("../../model/estados.class.php");
	include_once("../../model/contactos.class.php");


	$cedula_agente = Session::get('Cedula');
	$hoja_rutaC = new  hojaruta($db);
	$whereH = " Where hr.Registro_Id = " . $_GET['v']. " Order by hr.Id ASC" ;



	//echo $whereH;
	$resultH = $hoja_rutaC->selectAll($whereH);
	$resultH2 = $hoja_rutaC->selectAll($whereH);

	if($db->numRows($resultH2) > 0){
		$r2 = $db->datos($resultH2);
	}


	// Objeto Usarios - Agentes.
	$stados = new estado($db);
	$whereE = " Where Status = 1 AND Id > 2";
	$resultE = $stados->selectAll($whereE);
	if($db->numRows($resultE) > 0){
	  while ($rA = $db->datos($resultE)) {
	    $optionA .= "<option value=" . $rA["Id"] . ">" . $rA["Nombre"]."</option>";
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

	<!-- Modal ASigna varios -->
	<div id="gestionar_contacto" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Gestionar Registro</h4>
	      </div>
	      <div class="modal-body">
	        <form id="gestionar">
	          <div class="form-group">
	            <select class="form-control" name="txtStatus" id="txtStatus" required="">
	            	<option value="">Seleccione</option>
	            	<?php echo $optionA; ?>
	            </select>
	          </div>
	          <div class="form-group">
	          	<textarea class="form-control" name="txtObs" id="txtObs" required="" rows="5" maxlength="200" placeholder=""></textarea>
	          </div>
	          <input type="text" name="txtId" id="txtId">
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
	   	<?php getMenuAgente($cedula_agente,$db); ?>
	    <!--sidebar end-->
	    <!--main content start-->
	    <section id="main-content">
	      <section class="wrapper">
	        <!--overview start-->
	        <div class="row">
	          <div class="col-lg-12">
	            <h3 class="page-header"><i class="fa fa-laptop"></i><strong>Historial:  <?php  echo $r2['contacto']  ?> </strong></h3>
	          </div>
	        </div>
			<!-- <button type="button" class="btn btn-primary" id="new_User">Nuevo</button>
			<button type="button" class="btn btn-warning" id="asigna_agente" onclick="asignar_agentes();">Asignar</button> -->
			<section class="panel">

	            <table class="table table-striped table-bordered table-hover " id="editable" >
		            <thead>
		            <tr>
		               <th>Detalle</th>
		               <th>Asignado a</th>
		               <th>Estado</th>
		               <th>Creado por</th>
	                   <th>Fecha detalle</th>
		            </tr>
		            </thead>
		            <tbody>
						<?php
						if($db->numRows($resultH) > 0){
						  while ($r = $db->datos($resultH)) {

						  	$asignado = ($r['Asignado_a'] == "") ? "No asignado" : "". $r['Agente']."";
						    $valStatus = ($r['Status'] == 1) ? "<img src='../../img/edo_ok.png' alt='Activo'>" : "<img src='../../img/edo_nok.png' alt='Inactivo'>";
						    echo "<tr>";
						    echo "<td>" . $r['Detalle']."</td>";
						    echo "<td>" . $asignado."</td>";
						    echo "<td>". " 1: "  . $r['Nombre_estado']. "<br>". "2: " . $r['Nombre_estado2']. "</td>";
						    echo "<td>" . $r['creado_por']."</td>";
						    echo "<td>" . $r['fechaDetalle']."</td>";

						    echo "</tr>";

						  }
						}
						else{
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
	<script>
	    $(document).ready(function() {
	    	// $("#gestionar_btn").click(function(){
	    	//   $("#gestionar_contacto").modal({keyboard: true});
	    	// });

	        /* Init DataTables */
	        // var oTable = $('#editable').dataTable();
	    });
	</script>
</body>
</html>