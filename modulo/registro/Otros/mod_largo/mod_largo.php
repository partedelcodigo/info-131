<?php

require_once('mod_largo.class.php');
$rz = new ModLargo();
$tarea = isset($_GET['tarea'])?$_GET['tarea']:'';
switch ($tarea) {
    case 'ver': $rz->ver();
        break;
    case 'ingresar':
        $rz->ingresar();
        break;

    case 'modificar':
        $rz->modificar();
        break;

    case 'eliminar':
        $rz->eliminar();
        break;

    case 'confirmar':
        $rz->confirmar();
        break;

    default: $rz->busqueda();
        break;
}
?>
