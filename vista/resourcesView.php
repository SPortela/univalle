 <?php
	$title =  "Administrador";
	function recursos_css()
	{
		$css = '
			<link rel="shortcut icon" href="../../img/favicon.png">
			<!-- Bootstrap CSS -->
			<link href="../../css/bootstrap.min.css" rel="stylesheet">
			<!-- bootstrap theme -->
			<link href="../../css/bootstrap-theme.css" rel="stylesheet">
			<!--external css-->
			<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
			<!-- font icon -->
			<link href="../../css/elegant-icons-style.css" rel="stylesheet" />
			<link href="../../css/font-awesome.min.css" rel="stylesheet" />
			<!-- full calendar css-->
			<link href="../../assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
			<link href="../../assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
			<!-- easy pie chart-->
			<link href="../../assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
			<!-- owl carousel -->
			<link rel="../../stylesheet" href="css/owl.carousel.css" type="text/css">
			<link href="../../css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
			<!-- Custom styles -->
			<link rel="stylesheet" href="../../css/fullcalendar.css">
			<link href="../../css/widgets.css" rel="stylesheet">
			<link href="../../css/style-login.css" rel="stylesheet">
			<link href="../../css/style-responsive.css" rel="stylesheet" />
			<link href="../../css/xcharts.min.css" rel=" stylesheet">
			<link href="../../css/jquery-ui-1.10.4.min.css" rel="stylesheet">
			<!-- Data Tables -->
			<link href="../../css/dataTables.bootstrap.css" rel="stylesheet">
			<link href="../../css/dataTables.responsive.css" rel="stylesheet">
			<link href="../../css/dataTables.tableTools.min.css" rel="stylesheet">
			<!-- Alertify -->
			<link href="../../css/alertify.default.css" rel="stylesheet">
			<link href="../../css/alertify.core.css" rel="stylesheet">';
		echo $css;
	}
	function recursos_js()
	{
		$js = '
			<script type="text/javascript" src="../../js/process/facebook.js"></script>
			<script src="../../js/jquery.js"></script>
			<script src="../../js/jquery-ui-1.10.4.min.js"></script>
			<script type="text/javascript" src="../../js/jquery-ui-1.9.2.custom.min.js"></script>
			<!-- bootstrap -->
			<script src="../../js/bootstrap.min.js"></script>
			<!-- nice scroll -->
			<script src="../../js/jquery.scrollTo.min.js"></script>
			<script src="../../js/jquery.nicescroll.js" type="text/javascript"></script>
			<!-- charts scripts -->
			<script src="../../assets/jquery-knob/js/jquery.knob.js"></script>
			<script src="../../js/jquery.sparkline.js" type="text/javascript"></script>
			<script src="../../assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
			<script src="../../js/owl.carousel.js"></script>
			<!-- jQuery full calendar -->
			<script src="../../js/fullcalendar.min.js"></script>
			<!-- Full Google Calendar - Calendar -->
			<script src="../../assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
			<!--script for this page only-->
			<script src="../../js/calendar-custom.js"></script>
			<script src="../../js/jquery.rateit.min.js"></script>
			<!-- custom select -->
			<script src="../../js/jquery.customSelect.min.js"></script>
			<script src="../../assets/chart-master/Chart.js"></script>

			<!--custome script for all page-->
			<script src="../../js/scripts.js"></script>
			<!-- custom script for this page-->
			<script src="../../js/sparkline-chart.js"></script>
			<script src="../../js/easy-pie-chart.js"></script>
			<script src="../../js/jquery-jvectormap-1.2.2.min.js"></script>
			<script src="../../js/jquery-jvectormap-world-mill-en.js"></script>
			<script src="../../js/xcharts.min.js"></script>
			<script src="../../js/jquery.autosize.min.js"></script>
			<script src="../../js/jquery.placeholder.min.js"></script>
			<script src="../../js/gdp-data.js"></script>
			<script src="../../js/morris.min.js"></script>
			<script src="../../js/sparklines.js"></script>
			<script src="../../js/charts.js"></script>
			<script src="../../js/jquery.slimscroll.min.js"></script>

			<!-- Data Tables -->
			<script src="../../js/jquery.dataTables.js"></script>
			<script src="../../js/dataTables.bootstrap.js"></script>
			<script src="../../js/dataTables.responsive.js"></script>
			<script src="../../js/dataTables.tableTools.min.js"></script>
			<!-- alertify -->
			<script type="text/javascript" src="../../js/alertify.min.js"></script>
		';
		echo $js;
	}
	function header_admin()
	{
		$vroll = '';
		$prof = Session::get('Perfil');
		if ($prof == 1) {
			$vroll = 'Administrador';
		} else if ($prof == 0) {
			$vroll = 'Agente';
		} else if ($prof == 2) {
			$vroll = 'Agencia';
		}
		$vname = Session::get('Nombre');
		$vfoto = Session::get('Foto');
		$header = '
		    <header class="header dark-bg">
		      <div class="toggle-nav">
		        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
		      </div>
		      <!--logo start-->
		      <a href="index.php" class="logo"><img src="../../assets/logo_mailing.png" width="50%"/></a>
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
		          <!-- user login dropdown start-->
		          <li class="dropdown">
		            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
		                <span class="profile-ava">
		                    <img alt="" src=../../' . $vfoto . '>
		                </span>
		                <span class="username">' . $vname . ' - ' . $vroll . '</span>
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
		    </header>';
		echo $header;
	}
	function getMenu($db)
	{
		$prof = Session::get('Perfil');
		$userId = Session::get('Id');
		$menu = "";
		if ($prof == 1) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			     <li class="sub-menu">
			       <a href="javascript:;" class="">
			         <i class="icon_document_alt"></i>
			         <span>Agentes</span>
			         <span class="menu-arrow arrow_carrot-right"></span>
			       </a>
			       <ul class="sub">
			         <li><a class="" href="../home/">Gestionar</a></li>
			       </ul>
			     </li>
			      <li class="sub-menu">
			        <a href="javascript:;" class="">
			          <i class="icon_document_alt"></i>
			          <span>Contactos</span>
			          <span class="menu-arrow arrow_carrot-right"></span>
			        </a>
			        <ul class="sub">
			          <li><a class="" href="../contactos/">Todos</a></li>
			          <li><a class="" href="../contactos/index.php?v=1">Registrados</a></li>
			          <li><a class="" href="../contactos/index.php?v=0">Gestionados</a></li>
			          <li><a class="" href="../contactos/index.php?v=3">Cargados</a></li>
			        </ul>
			      </li>
			      <li class="">
			        <a class="" href="../estados/">
			            <i class="icon_house_alt"></i>
			            <span>Estados</span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		} else if ($prof == 2) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			      <li class="sub-menu" >
			        <a href="../agencia/" class="">
			          <i class="icon_document_alt"></i>
			          <span>Contactos</span>
			          <span class="menu-arrow arrow_carrot-right"></span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		}else if ($prof == 5) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			      <li class="active">
			        <a class="" href="../recepcion/">
			            <i class="icon_house_alt"></i>
			            <span>Pacientes</span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		}else if ($prof == 6) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			      <li class="active">
			        <a class="" href="../administrativo/">
			            <i class="icon_house_alt"></i>
			            <span>Gestión</span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		}
		if ($userId == 18) {
			$contact = new contacto($db);
			$where = " Where rg.Asignado_a = ' 52508344 ' GROUP BY rg.Status  ORDER BY Id DESC";
			//echo $where;
			$result = $contact->selectAll($where);
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
				<ul class="sidebar-menu">
					<li class="sub-menu active">
						<a href="javascript:;" class="">						
						<span>Gestión Unicentro</span>
						<span class="menu-arrow arrow_carrot-right"></span>
						</a>
						<ul class="sub">
						<li><a class="" href="../home/">Reportes</a></li>
						<li><a class="" href="../contactos/">Contactos</a></li>
						<li><a class="" href="../estados/">Estados</a></li>
						</ul>
					</li>
			      <li class="active">
			         <a class="" href="../agente/">
			           <i class="icon_house_alt"></i>
			            <span>Gestionar</span>
			         </a>
			         <li><a class="" href="../agente/">Todos</a></li>';
			if ($db->numRows($result) > 0) {
				while ($rA = $db->datos($result)) {
					$Wcount = ' WHERE  rg.Status =' . $rA['Id_estado'] . ' AND rg.Asignado_a = 52508344';
					$rCount = $contact->Count($Wcount);
					if ($db->numRows($rCount) > 0) {
						$cuenta = $db->datos($rCount);
					} else {
						echo 'NO HAY DATA';
					}
					$menu .= '<li><a class="" href="../agente/?v=' . $rA['Id_estado'] . '">' . $rA['Nombre_estado'] .  ' - ' . $cuenta['num'] .    '</a></li>';
				}
			}
			$menu .= '</li>
			    </ul>
			  </div>
			</aside>';
		}
		echo $menu;
	}

	function getMenuAgente($cedula_agente, $db)
	{
		$prof = Session::get('Perfil');
		$userId = Session::get('Id');
		if ($prof == 1) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			     <li class="sub-menu">
			       <a href="javascript:;" class="">
			         <i class="icon_document_alt"></i>
			         <span>Agentes</span>
			         <span class="menu-arrow arrow_carrot-right"></span>
			       </a>
			       <ul class="sub">
			         <li><a class="" href="../home/">Gestionar</a></li>
			       </ul>
			     </li>
			      <li class="sub-menu">
			        <a href="javascript:;" class="">
			          <i class="icon_document_alt"></i>
			          <span>Contactos</span>
			          <span class="menu-arrow arrow_carrot-right"></span>
			        </a>
			        <ul class="sub">
			          <li><a class="" href="../contactos/">Todos</a></li>
			          <li><a class="" href="../contactos/index.php?v=1">Registrados</a></li>
			          <li><a class="" href="../contactos/index.php?v=0">Gestionados</a></li>
			          <li><a class="" href="../contactos/index.php?v=3">Cargados</a></li>
			        </ul>
			      </li>
			      <li class="">
			        <a class="" href="../estados/">
			            <i class="icon_house_alt"></i>
			            <span>Estados</span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		} else if ($prof == 2) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			      <li class="sub-menu" >
			        <a href="../agencia/" class="">
			          <i class="icon_document_alt"></i>
			          <span>Contactos</span>
			          <span class="menu-arrow arrow_carrot-right"></span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		} else if ($prof == 0) {
			if ($userId == 18) {
				$contact = new contacto($db);
				$where = " Where rg.Asignado_a = '" . $cedula_agente . " ' GROUP BY rg.Status  ORDER BY Id DESC";
				//echo $where;
				$result = $contact->selectAll($where);
				$menu = '
					<!--sidebar start-->
					<aside>
					  <div id="sidebar" class="nav-collapse ">
						<!-- sidebar menu start-->
						<ul class="sidebar-menu">
							<li class="sub-menu">
								<a href="javascript:;" class="">							
								<span>Gestión Unicentro</span>
								<span class="menu-arrow arrow_carrot-right"></span>
								</a>
								<ul class="sub">
								<li><a class="" href="../home/">Reportes</a></li>
								<li><a class="" href="../contactos/">Contactos</a></li>
								<li><a class="" href="../estados/">Estados</a></li>
								</ul>
							</li>
						  <li class="active">
							 <a class="" href="../agente/">
							   <i class="icon_house_alt"></i>
								<span>Gestionar</span>
							 </a>
							 <li><a class="" href="../agente/">Todos</a></li>';

				if ($db->numRows($result) > 0) {
					while ($rA = $db->datos($result)) {
						$Wcount = ' WHERE  rg.Status =' . $rA['Id_estado'] . ' AND rg.Asignado_a = ' . $cedula_agente;
						$rCount = $contact->Count($Wcount);
						if ($db->numRows($rCount) > 0) {
							$cuenta = $db->datos($rCount);
						} else {
							echo 'NO HAY DATA';
						}
						$menu .= '<li><a class="" href="../agente/?v=' . $rA['Id_estado'] . '">' . $rA['Nombre_estado'] .  ' - ' . $cuenta['num'] .    '</a></li>';
					}
				}
				$menu .= '</li>
						</ul>
					  </div>
					</aside>';
			} else {
				$contact = new contacto($db);
				$where = " Where rg.Asignado_a = '" . $cedula_agente . " ' GROUP BY rg.Status  ORDER BY Id DESC";
				//echo $where;
				$result = $contact->selectAll($where);
				$menu = '
					<!--sidebar start-->
					<aside>
						<div id="sidebar" class="nav-collapse ">
						<!-- sidebar menu start-->
						<ul class="sidebar-menu">
							
							<li class="active">
								<a class="" href="../agente/">
								<i class="icon_house_alt"></i>
								<span>Gestionar</span>
								</a>
								<li><a class="" href="../agente/">Todos</a></li>';
				if ($db->numRows($result) > 0) {
					while ($rA = $db->datos($result)) {
						$Wcount = ' WHERE  rg.Status =' . $rA['Id_estado'] . ' AND rg.Asignado_a = ' . $cedula_agente;
						$rCount = $contact->Count($Wcount);
						if ($db->numRows($rCount) > 0) {
							$cuenta = $db->datos($rCount);
						} else {
							echo 'NO HAY DATA';
						}
						$menu .= '<li><a class="" href="../agente/?v=' . $rA['Id_estado'] . '">' . $rA['Nombre_estado'] .  ' - ' . $cuenta['num'] .    '</a></li>';
					}
				}
				$menu .= '</li>
			    			</ul>
			 			 		</div>
						  </aside>';
			}
		} else if ($prof == 5) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			      <li class="active">
			        <a class="" href="../recepcion/">
			            <i class="icon_house_alt"></i>
			            <span>Pacientes</span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		} else if ($prof == 6) {
			$menu = '
			<!--sidebar start-->
			<aside>
			  <div id="sidebar" class="nav-collapse ">
			    <!-- sidebar menu start-->
			    <ul class="sidebar-menu">
			      <li class="active">
			        <a class="" href="../administrativo/">
			            <i class="icon_house_alt"></i>
			            <span>Gestión</span>
			        </a>
			      </li>
			    </ul>
			  </div>
			</aside>';
		}
		echo $menu;
	}
?>