<?php
require_once('gusu.class.php');
$gusu =new GUSU;
$tarea=$_GET['tarea'];
switch($tarea) {
    case 'ingresar': 	$gusu->ingresar();  break;
    case 'modificar': 	$gusu->modificar(); break;
    case 'eliminar': 	$gusu->eliminar();  break;
    case 'ver':         $gusu->ver();       break;
    case 'cerrar': 	$login->cerrar();   break;
    case 'buscae': 	$gusu->busquedae(); break;
    default: 		$gusu->busqueda();  break;
  }
?>