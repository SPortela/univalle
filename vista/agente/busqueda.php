<?php
if(isset($_POST["buscaNotifica"])){
    include_once("../../AnsTek_libs/integracion.inc.php");
    include_once("../../model/notificaciones.class.php");
    $html = "<li>No hay ningun registro con este parametro de busqueda</li>";
    $Notification = new notificacion($db);
    $where = " Where nt.Id > 0 AND nt.Registro_Id = " . $_POST["idUser"] . " AND nt.Status = 1 AND rg.Nombre_completo LIKE '%" . $_POST["buscaNotifica"] . "%' ORDER BY nt.Id DESC";
    $result = $Notification->selectAll($where);
    if ($db->numRows($result) > 0) {
        while ($rD = $db->datos($result)) {
            $html .= '
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
    }
    echo $html; 
}
else{
    echo "";
}
?>