<?php
require_once('personal.class.php');
$personal =new PERSONAL;
$tarea=$_GET['tarea'];
switch($tarea) {
    case 'ingresar': 	$personal->ingresar();
        break;
    case 'modificar': 	$personal->modificar();
        break;
    case 'ver': 		$personal->ver();
        break;
    case 'eliminar': 	$personal->eliminar();
        break;
    case 'cerrar': 		$login->cerrar();
        break;
    case 'buscae': 		$personal->busquedae();
        break;
    case 'a�adirtipo': 	$personal->a�adirtipo();break;
    default: 			$personal->busqueda();
        break;
}
?>