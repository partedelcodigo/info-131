<?php

require_once('mod_ancho.class.php');
$rz = new ModAncho();
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