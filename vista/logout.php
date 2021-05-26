<?php
include_once("../AnsTek_libs/integracion.inc.php");

if ($_REQUEST['error'] == 2) {
	Session::logout("../admin/index.php");
} elseif ($_REQUEST['error'] == 1) {
	Session::logout("../admin/index.php");
} else {
	Session::logout("../admin/index.php");
}
