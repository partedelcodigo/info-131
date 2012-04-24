<?php

require_once('login.class.php');
$login = new LOGIN;
$tarea = isset($_GET['tarea']) ? $_GET['tarea'] : '';
switch ($tarea) {
    case 'verificar':
        $login->verificar();
        break;
    case 'cerrar':
        $login->cerrar();
        break;
    default: $login->ingreso();
        break;
}
?>
