<?php

/**
 * Description of romaneo
 *
 * @author juan
 */
class ModRomaneo {
    public function __construct() {
        $this->nombreModulo="mod_transaccion";
    }
    /**
     *  Funcion encargada de crear por pasos
     */
    public function ingresar(){
        extract($_GET);
        $paso=isset($paso)?$paso:1;
        $cad='';
        switch($paso){
            case 1://Primero se introducen nombre y otros seria mejor rescatar con tiny
                $cad.='<form name="" action="?mod_id=mod_transaccion&tarea=ingresar&id=&cpt=id_transaccion&paso=2" method="post"><input type="text" name="tran_nombre" /><br /><input type="submit" value="Enviar"></form>';
                break;
            case 2:
                echo "<pre>";
                print_r($_POST);
                echo "</pre>";
                //primero almacenar y luego construir la matriz con recargas
                break;
                
        }
        
        echo $cad;
        
    }
    
    function busqueda() {
        require_once("clases/busqueda.php");
        $b = new BUSQUEDA();
        $b->inicializa_auto($this->nombreModulo);
        $b->mostrar_busqueda();
    }
}

?>