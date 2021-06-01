<?php
try {
  /** incluye todos los recursos */
  include_once("../AnsTek_libs/integracion.inc.php");
  include_once("../model/usuarios.class.php");
  include_once("../model/access.class.php");
  /** Instancia la clase usuarios*/
  $access = new access($db);
  $user = new usuario($db);
  /** captura el tipo de accion a realizar*/
  $accion = $_REQUEST['accion'];
  /** conmutador que determina las acciones a realizar para
   * este modulo dshb/index.php
   */
  switch ($accion) {
      /** Inicio de sesión */
    case "login":
      $jsondata = array();
      $r = $access->login($_REQUEST['txtUser'], md5($_REQUEST['txtPass']));
      if ($db->numRows($r)) {
        $d = $db->datos($r);
        if ($d['Id'] > 0) {
          //Session::set('sess_time',time());
          Session::set('sess_id', Session::getId());
          Session::set('sess_access', true);
          Session::set('Id', $d['Id']);
          Session::set('Nombre', $d['Nombre']);
          Session::set('Cedula', $d['Cedula']);
          Session::set('Direccion', $d['Direccion']);
          Session::set('Telefono', $d['Telefono']);
          Session::set('Foto', $d['Foto']);
          Session::set('Email', $d['Email']);
          Session::set('Perfil', $d['Perfil']);
          $jsondata['success'] = true;
          $jsondata['Perfil'] = $d['Perfil'];
          $jsondata['message'] = "Acceso permitido ";
        } else {
          $jsondata['success'] = false;
          $jsondata['message'] = "Información de acceso incorrecta ";
        }
      } else {
        $jsondata['success'] = false;
        $jsondata['message'] = "Datos de acceso incorrecta ";
      }
      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
      break;
    case "rem":
      $result = array();
      $whereS = " WHERE Cedula = " . $_REQUEST['txtNit'] . " AND Email = '" . $_REQUEST['txtEmail'] . "'";
      $result = $user->selectAll($whereS);
      if ($result > 0) {
        $Pass = $access->randomPass(8, TRUE, TRUE, TRUE);
        $passUpd = $Pass;
        $whereU = " Cedula = " . $_REQUEST['txtNit'] . " AND Email = '" . $_REQUEST['txtEmail'] . "'";
        $data = array("Password" => md5($passUpd), "Updated_by" => 0, "Updated_at" => date("Y-m-d H:i:s"));
        $jsondata = array();
        if ($access->RememberPass($data, $whereU)) {
          // $header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
          // $header .= "Mime-Version: 1.0 \r\n";
          // $header .= "Content-Type: text/plain";
          // $mensaje = " \r\n";
          //      $mensaje = '
          //  Nueva Contraseña: '.utf8_decode($passUpd).'';
          //       	$mensaje .= "Enviado el " . date('d/m/Y', time());
          // 			$para =  $_REQUEST['txtEmail'];
          // 			$asunto = 'Actualización Contraseña ';
          //       // mail($_REQUEST['txtEmailEmail'],"Recordar Password Sistema de Interevenciones de la Defensoría",$message, $headers);     
          // 		mail($para, $asunto, utf8_decode($mensaje), $header);
          $jsondata['success'] = true;
          $jsondata['pass'] = $passUpd;
          $jsondata['message'] = "Modificado correctamente";
          //header('Location: ../admin.php');
        }
      } else {
        $jsondata['success'] = false;
        $jsondata['message'] = "Falla al modificar el registro";
      }
      header('Content-type: application/json; charset=utf-8');
      echo json_encode($jsondata);
      break;
  }
} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
