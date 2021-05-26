<?php
	include_once("../../AnsTek_libs/integracion.inc.php");
	include_once("../resourcesView.php");
	Session::valida_sesion("","../../logout.php");
	// if(Session::get('Perfil') != 1)
	// header('Location: ../../logout.php');
	include_once("../../model/contactos.class.php");
	include_once("../../model/estados.class.php");
	$stado = new estado($db);
	$whereE = " where Id > 4";
	$result = $stado->selectAll($whereE);
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
	        <h4 class="modal-title">Agregar Estado</h4>
	      </div>
	      <div class="modal-body">
	        <form id="estados">
	          <div class="form-group">
	          	<label for="txtStatus">Activo o Inactivo</label>
	            <select class="form-control" name="txtStatus" id="txtStatus">
	            	<option value="">Seleccione</option>
	            	<option value="1">Activo</option>
	            	<option value="0">Inactivo</option>
	            </select>
	          </div>
	          <div class="form-group">
	          	<label for="txtTipo">Seleccione una opción</label>
	            <select class="form-control" name="txtTipo" id="txtTipo">
	            	<option value="">Seleccione</option>
	            	<option value="1">opción 1</option>
	            	<option value="2">opción 2</option>
	            </select>
	          </div>
	          <div class="form-group">
	          	<label for="txtStatus">Nombre del estado</label>
	            <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Ingrese su nombre">
	          </div>

	          <div class="form-group" id="contColor">
	          	<label for="txtStatus">Seleccione un color</label>
	            <input type="color" class="form-control" id="txtColor" name="txtColor" placeholder="Color" value="#ffffff">
	          </div>
	          <div class="form-group">
	             <input type="hidden" name="txtId" id="txtId" value="0">
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
	            <h3 class="page-header"><i class="fa fa-laptop"></i>Estados</h3>
	            <ol class="breadcrumb">
	              <li><i class="fa fa-home"></i><a href="index.php">Inicio</a></li>
	              <li><i class="fa fa-laptop"></i>Estados</li>
	            </ol>
	          </div>
	        </div>
			<button type="button" class="btn btn-primary" id="new_User">Nuevo</button>
			<section class="panel">
	            <table class="table table-striped table-bordered table-hover " id="editable" >
		            <thead>
		            <tr>
		               <th width="5%"><i class="icon_profile"></i>Status</th>
		               <th><i class="icon_profile"></i>Nombre</th>
		               <th><i class="icon_profile"></i>Tipo</th>
		               <th><i class="icon_profile"></i>Color</th>
	                    <th><i class="icon_mobile"></i>Fecha</th>
	                    <th><i class="icon_cogs"></i> Acciones</th>
		            </tr>
		            </thead>
		            <tbody>
						<?php
						if($db->numRows($result) > 0){
						  while ($r = $db->datos($result)) {
						    $valStatus = ($r['Status'] == 1) ? "<img src='../../img/edo_ok.png' alt='Activo'>" : "<img src='../../img/edo_nok.png' alt='Inactivo'>";
						    echo "<tr>";
						    echo "<td>" . $valStatus       . "</td>";
						    echo "<td>" . $r['Nombre']     . "</td>";
						    echo "<td>" . $r['Tipo']     . "</td>";
						    echo "<td style=\"background-color:".$r['Color']."\">" . $r['Color']     . "</td>";
						    echo "<td>" . $r['Created_date'] . "</td>";
				          echo "<td>
				                  <center>
				                   	<a href=\"#\" onclick=\"javascript:cargaEstado('".$r['Id']."');\" style=\"margin-bottom:-3px;\" class=\"btn btn-success btn-md btn-xs\" title=\"Actividades\">Editar</a>&nbsp;
				                  </center>
				                </td>";
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
	<script type="text/javascript" src="../../js/process/estados.js"></script>
	<script>
	    $(document).ready(function() {
	    	$("#new_User").click(function(){
	    	  $("#Modal_Usuarios").modal({keyboard: true});
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