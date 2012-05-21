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
        
        $template = new clsTinyButStrong;
        
        
        switch($paso){
            case 1://Primero se introducen nombre y otros seria mejor rescatar con tiny
                # Load template with initial form
                $template -> LoadTemplate('modulo/registro/mod_transaccion/_template_initial_data.html');
                $template -> Show( TBS_NOTHING );
                $contentTemp = $template -> Source;
                
                $comboCalidad = new comboTabla();
                $cad.= $contentTemp;
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