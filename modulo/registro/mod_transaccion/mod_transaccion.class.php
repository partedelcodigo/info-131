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
                
                # merge combo elements
                $template -> MergeBlock('calidad',$this -> generateTableBlock( 'mod_calidad', array('id_calidad','nombre')));
                $template -> MergeBlock('especie',$this -> generateTableBlock( 'mod_especies', array('id_especies','nombre')));
                
                
                $contentTemp = $template -> Source;
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
    
    /**
     * Function to generate select blocks with TBS
     *
     * @param string $tableName, table name
     * @param array|mixed $fields, fields of table name
     * 
     * @return array|mixed, return an array with table's elements
     * 
     * @access private
     */
    private function generateTableBlock($tableName, $fields) {
        $comboCalidad = new comboTabla();
        $comboCalidad -> setTableName( array( $tableName ) );
        $comboCalidad -> setTableFields( $fields );
        
        return $comboCalidad -> getElements();
    }
    
    function busqueda() {
        require_once("clases/busqueda.php");
        $b = new BUSQUEDA();
        $b->inicializa_auto($this->nombreModulo);
        $b->mostrar_busqueda();
    }
}
?>