<?PHP

require_once('modu.class.php');
$modulo = new MOD;
$tarea = isset($_GET['tarea'])?$_GET['tarea']:'';
switch ($tarea) {
    case 'ingresar': $modulo->ingresar();
        break;
    case 'modificar': $modulo->modificar();
        break;
    case 'ver': $modulo->ver();
        break;
    case 'cerrar': $login->cerrar();
        break;
    case 'buscae': $modulo->busquedae();
        break;
    case 'eliminar': $modulo->eliminar();
        break;
    default: $modulo->busqueda();
        break;
}
?>

