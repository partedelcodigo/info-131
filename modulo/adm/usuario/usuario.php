<?PHP

	require_once('usuario.class.php');
  	$usuario =new USUARIO;
  	$tarea=$_GET['tarea'];
  	switch($tarea)
  	{
    	case 'ingresar':
    					$usuario->ingresar();
    					break;
		case 'modificar':
						$usuario->modificar();
						break;
		case 'modificar_pass':
						$usuario->modificar_pass();
						break;
		case 'ver':
						$usuario->ver();
						break;
		case 'cerrar':
						$login->cerrar();
						break;
		case 'buscae':
						$usuario->busquedae();
						break;
		case 'eliminar':
						$usuario->eliminar();
						break;
		default:
						$usuario->busqueda();
						break;
	}
?>