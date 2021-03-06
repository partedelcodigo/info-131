<?php
@header("Content-Type: text/html; charset=utf-8");
require_once ('define/config.php');
require_once ('clases/persona.php');
require_once ('define/config_db.php');
//--require_once (_rutaraiz . '/clases/bd/' . _lib_conexion);
require_once ('clases/bd/' . _lib_conexion);
require_once ('componentes/pantalla_inicial.php');
if (isset($_SESSION['len']))
    require_once ('lenguaje/' . $_SESSION['len']);
else
    require_once ('lenguaje/' . _lenguaje);
require_once ('clases/ventana.php');
require_once ('clases/sesion_handle.php');
require_once ('clases/pagina.php');
require_once ('clases/controles.php');
require_once ('clases/bd/sql.php');

/**
 * Function to load automatically some class files
 * 
 * @param string $classname, class to be load
 */
function __autoload( $classname ) {
    switch ( $classname ) {
        case 'clsTinyButStrong':
            include_once('plugins/tbs_us/tbs_class.php');
            
            break;
        
        case 'comboTabla':
            include_once 'clases/control/comboTabla.php';
            break;
    }
}


$persona = new PERSONA;
$persona->iniciar_session();
$pagina = new PAGINA;
$pagina->cargar_modulo();
?>