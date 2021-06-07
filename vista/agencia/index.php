<?php
	include_once("../../AnsTek_libs/integracion.inc.php");
	include_once("../resourcesView.php");
	Session::valida_sesion("","../../logout.php");
	if(Session::get('Perfil') != 2)
	header('Location: ../../logout.php');
	include_once("../../model/contactos.class.php");
	include_once("../../model/usuarios.class.php");
	$contact = new contacto($db);
	$cedula_agente = Session::get('Cedula');

	if(empty($_GET)){

		$where = " Where rg.Id > 0 AND Origen_Campana = 'Google Ads' ORDER BY rg.Created_date DESC";
		// $where = " Where rg.Id > 0 AND Origen_Campana = 'Google Ads' GROUP BY rg.Cedula, rg.Mensaje, rg.Programa ORDER BY rg.Status, rg.Created_date DESC";
		$whereC =  " Where rg.Id > 0 ";
		$title = "Total Contactos";
	}elseif($_GET['v'] == 0){
			$where = " Where rg.Id > 0 AND rg.Status > 1 AND rg.Status <> 12 AND Origen_Campana = 'Google Ads' GROUP BY rg.Cedula, rg.Mensaje, rg.Programa ORDER BY rg.Status, rg.Created_date DESC ";
			$whereC = " Where rg.Id > 0 AND rg.Status > 1 AND rg.Status <> 12 AND Origen_Campana = 'Google Ads' ";
			$title = "Contactos Gestionados";
		}
	elseif($_GET['v'] == 1){
		$where = " Where rg.Id > 0 AND Origen_Campana = 'Google Ads'  AND  rg.Status = " .$_GET['v']. " GROUP BY rg.Cedula, rg.Mensaje,	 rg.Programa ORDER BY rg.Status, rg.Created_date DESC ";
		$whereC = " Where rg.Id > 0 AND Origen_Campana = 'Google Ads' AND rg.Status = " .$_GET['v']. "";
		$title = "Contactos Registrados";
	}else
	{
		$where = " Where rg.Id > 0 AND Origen_Campana = 'Google Ads'  AND rg.Status = " .$_GET['v']. " GROUP BY rg.Cedula, rg.Mensaje,	 rg.Programa ORDER BY rg.Status, rg.Created_date DESC ";
		$whereC = " Where rg.Id > 0 AND Origen_Campana = 'Google Ads'  AND rg.Status = " .$_GET['v']. "";
		$title = "Contactos Cargados";
	}


	// $where = " Where rg.Id > 0 ORDER BY rg.Status, rg.Created_date DESC ";
	$result = $contact->selectAll($where);
	// Objeto Usarios - Agentes
	$agente = new usuario($db);
	$whereA = " Where Us.Status = 1 AND  Us.Perfil = 0 ";
	$resultAgente = $agente->selectAll($whereA);
	if($db->numRows($resultAgente) > 0){
	  while ($rA = $db->datos($resultAgente)) {
	    $optionA .= "<option value=" . $rA["Cedula"] . ">" . $rA["Nombre"]."-". $rA["Usuario"]. "</option>";
	  }
	}
	// Cuenta numero de contactos sin gestionar
	$whereCount= $whereC;
	//echo $whereCount;
	$sin_gestionar = $contact->Count($whereCount);
	if($db->numRows($sin_gestionar) > 0){
		$rows = $db->datos($sin_gestionar);

	}else{
		Echo "No hay data";
	}

?>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <title>Agencia - Universidad del Valle</title>
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

 	</style>
</head>
<body>

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
            <form enctype="multipart/form-data"  action="../../controller/contactosAgenciaController.php" method="POST">
    			<div class="form-group">
    			<label class="">Adjuntar archivo</label>
    				<!-- <input type="file" class="form-control" name="uploadExcel" id="uploadExcel" autofocus> -->
    				 <input type="hidden" name="MAX_FILE_SIZE" value="90000" />
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
	             <!--  <li><strong class="msj"> Tienes <?php echo $rows["num"]; ?> Contactos sin asignar </strong></li> -->
	            </ol>
		            <form method="post" action="descarga2.php" style="position: relative; top:0px;">
						<input type="text" name="txtFecha1" id="txtFecha1" value="" class="date" placeholder="Fecha Numero1">
		        		<input type="text" name="txtFecha2" id="txtFecha2" value="" class="date" placeholder="Fecha Numero2">
						<button type="submit" class="btn btn-info">Descargar</button>
		            	<a href="#" title="Contar" class="btn btn-info"><?php echo $title; ?>: <?php $rows = $contact->Count($whereC); if($db->numRows($rows) > 0){ $r = $db->datos($rows);echo "<strong>". $r['num']. "</strong>";}else{echo "NO HAY REGISTROS PARA MOSTRAR";}?></a>
		            	<!-- <button type="button" class="btn btn-primary" id="asigna_agente" onclick="asignar_agentes();">Asignar</button> -->
		            	<button type="button" class="btn btn-danger" onclick="DelRegistro();">Eliminar</button>
		            	<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Cargar</button>
		            		<a href="../cargar_registros.xlsx" download="../cargar_registros.xlsx" class="btn btn-default" title="Descargar Formato"><img src="../../assets/archivo.png" width="25px" style="position: relative; "></a>

		            	<!-- <a  class="btn btn-default" title="Marcar Registrados" id="all_Registrados"><img src="../../assets/exito1.png" width="25px" style="position: relative; "></a>
		            	<a href="#"  class="btn btn-default" title="Marcar Gestionados" id="all_Gestionados"><img src="../../assets/exito.png" width="25px" style="position: relative; "></a>
		            	<a href="#"  class="btn btn-default" title="Marcar Cargados" id="all_Cargados"><img src="../../assets/exito2.png" width="25px" style="position: relative; "></a>
		            	<input type="button" id="limpiar" value="Limpiar" class="btn btn-success"> -->

		            </form>
	          </div>
	        </div>

			<section class="panel">

	            <table class="table table-bordered " id="editable" >
		            <thead>
		            <tr>
		               <th><input type="checkbox" id="select_all"/> All</th>
		               <th><i class="icon_profile"></i>Nombre</th>
		               <th><i class="icon_profile"></i>Teléfono</th>
		               <th><i class="icon_profile"></i>Email</th>
		               <th><i class="icon_profile"></i>Programa</th>
		               <th><i class="icon_profile"></i>Ciudad</th>
	                    <th><i class="icon_mobile"></i>Fecha registro</th>
	                    <th><i class="icon_mobile"></i>Origen</th>
	                    <th><i class="icon_mobile"></i>Campaña</th>
	                    <!-- <th><i class="icon_cogs"></i> Asinado a</th> -->
	                    <th width="10%"><i class="icon_cogs"></i> Acciones</th>
		            </tr>
		            </thead>
		            <tbody>
						<?php
						if($db->numRows($result) > 0){
						  while ($r = $db->datos($result)) {
						  	$asignado = ($r['Asignado_a'] == 0) ? "No asignado" : "". $r['Nombre_agente']." - ".$r['Asignado_a']. " - ".$r['Usuario_agente']." ";
						    $valStatus = ($r['Status'] == 1) ? "<img src='../../img/edo_ok.png' alt='Activo'>" : "<img src='../../img/edo_nok.png' alt='Inactivo'>";
						    // if($r['Status'] == 1){
						    // 	$id = "asig";
						    // 	$class = 'registrado update_registro';
						    // }elseif($r['Status'] == 3){
						    // 	$id = "car";
						    // 	$class = 'Cargados update_registro';
						    // }else{
						    // 	$id = 'gest';
						    // 	$class = 'Gestionado update_registro';
						    // }
						   echo '<tr id="">';
				            echo "<td>
				                    <center>
				    					<input type=\"checkbox\" name=\"IdsRegistros[]\" value='".$r['Id']."' class =\"update_registro\">
				                    </center>
				                  </td>";
						    echo "<td>" . $r['Nombre_completo']."</td>";
						    echo "<td>" . $r['Celular']."</td>";
						    echo "<td>" . $r['Email']."</td>";
						    echo "<td>" . $r['Tratamiento']."</td>";
						    echo "<td>" . $r['Ciudad']."</td>";
						    echo "<td>" . $r['Created_date']."</td>";
						    echo "<td>" . $r['Origen_Campana']."</td>";
						    echo "<td>" . $r['Campana_Id']."</td>";
						    // echo "<td>" . $asignado."</td>";
				          echo "<td>
				                  <center>
				                   	<a href=\"#\" onclick=\"javascript:cargaEstado('".$r['Id']."');\" style=\"margin-bottom:-3px;border:1px #000 solid;\" class=\"btn btn-success btn-md btn-xs\" title=\"Actividades\">Editar</a>&nbsp;
				                   	<a href=\"../historial/?v=".$r['Id']."\" style=\"margin-bottom:-3px;border:1px #000 solid;\" class=\"btn btn-info btn-md btn-xs\" title=\"Actividades\">Historial</a>&nbsp;
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
	<script type="text/javascript" src="../../js/process/contactos.js"></script>

	<script type="text/javascript" src="../../assets/datepicker/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../js/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="../../js/process/sweetalert.min.js"></script>

	<script>

		              function DelRegistro(Id){
		                /* Realiza conexión con el servidor */
		                var id = [];
		                $('.update_registro:checked').each(function(i){
		                		id[i] = $(this).val();
		                	});
		                if(id.length == 0){
		                		// alert("No hay registros seleccionados para eliminar");
		                		swal("Error", "No hay registros seleccionados para eliminar", "error");
		            		}else{
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
		      		       function(isConfirm){
		      		       	if (isConfirm){
		      		       		$.ajax({
		      		       		  data: {"accion":"del", "pId":id},
		      		       		  type: "POST",
		      		       		  datatype: "json",
		      		       		  url: "../../controller/contactosController.php",
		      		       		})
		      		       		.done(function(data){
		      		       		   swal({title: "Deleted!",
		      		       		         text: data.message,
		      		       		         type: "success"
		      		       		   },
		      		       		   function(isConfirm){document.location.href = "index.php";}
		      		       		   );

		      		       		})
		      		       		.fail(function(){
		      		       		    alert("Ha ocurrido un problema");
		      		       		});

		      		       	} else {
		                    		swal({title: "Cancelado!",
		                    		      text: "Your imaginary file has been deleted.",
		                    		      type: "error"
		                    		});
		                  	}

		      		       });

		            		}
		              }








	    $(document).ready(function() {

	    	$("#limpiar").click(function(){  //"select all" change
	    	    var status = this.checked; // "select all" checked status
	    	    $('input[type=checkbox]').each(function(){ //iterate all listed checkbox items
	    	        $('input[type=checkbox]').prop("checked", false); //change ".checkbox" checked status
	    	    });
	    	});

	    	$("#select_all").change(function(){  //"select all" change
	    	    var status = this.checked; // "select all" checked status
	    	    $('input[type=checkbox]').each(function(){ //iterate all listed checkbox items
	    	        this.checked = status; //change ".checkbox" checked status
	    	    });
	    	});

	    	$('#all_Registrados').click(function() {
	    		$('.registrado').each(function(){ //iterate all listed checkbox items
	    	   	$('.registrado').prop("checked", true);
	    	    });
	    	 });

	    	$('#all_Gestionados').click(function() {
	    		$('.Gestionado').each(function(){ //iterate all listed checkbox items
	    	   	$('.Gestionado').prop("checked", true);
	    	    });

	    	 });
	    	$('#all_Cargados').click(function() {
	    		$('.Cargados').each(function(){ //iterate all listed checkbox items
	    	   	$('.Cargados').prop("checked", true);
	    	    });

	    	 });



	    	$( function() {

	    	  $( "#txtFecha1" ).datepicker({
	    	    dateFormat: "yy-mm-dd",
	    	    dayNamesMin: [ "Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
	    	    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
	    	    minDate: "",
	    	    maxDate: ""
	    	  });

	    	  $( "#txtFecha2" ).datepicker({
	    	    dateFormat: "yy-mm-dd",
	    	    dayNamesMin: [ "Do", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
	    	    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
	    	    minDate: "",
	    	    maxDate: "",
	    	  });
	    	} );
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