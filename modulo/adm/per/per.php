<?PHP
  require_once('per.class.php');
  $per =new PER;
  $tarea=$_GET['tarea'];
  switch($tarea)
  {
    case 'ingresar':$per->ingresar();	break;
	case 'modificar':$per->modificar();	break;
	case 'ver':$per->ver(); 	break;
	case 'eliminar':$per->eliminar();	break;
	case 'cerrar':$login->cerrar();	break;
	case 'buscae':$per->busquedae();	break;
	default:$per->busqueda();	break;
  }
?>