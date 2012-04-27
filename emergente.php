<?php
session_start();
require_once("define/config.php");	
require_once("clases/paginaemergente.php");
require_once("lenguaje/"._lenguaje);
require_once("clases/bd/"._lib_conexion);
define("PAG_PRINCIPAL","emergente.php");//@revisar - la variable ya fue definida
$pag =new PAGINA;
if(isset($_GET['mod_id'])) {
    $modulo=(isset($_GET['mod_id']))?$_GET['mod_id']:'';
    $tarea=(isset($_GET['tarea']))?$_GET['tarea']:'';
    $nombreform=(isset($_GET['nombreform']))?$_GET['nombreform']:'';
    $campo=(isset($_GET['campo']))?$_GET['campo']:'';
    $tipo=(isset($_GET['tipo']))?$_GET['tipo']:'';
}
$pag->dibujar($modulo,$tipo);
?>

