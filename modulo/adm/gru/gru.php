<?PHP

	require_once('gru.class.php');
  	$gru = new GRU;
  	$tarea=$_GET['tarea'];
  	switch($tarea)
    {
    	case 'ingresar':
        				$gru->ingresar();
                        break;
		case 'modificar':
        				$gru->modificar();
                        break;
		case 'ver':
        				$gru->ver();
                        break;
		case 'cerrar':
        				$login->cerrar();
                        break;
		case 'buscae':
        				$gru->busquedae();
                        break;
		case 'eliminar':
						$gru->eliminar();
						break;			
		
		default:
        				$gru->busqueda();
                        break;
	}
?>