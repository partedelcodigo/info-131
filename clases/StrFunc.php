<?php
@header("Content-Type: text/html; charset=utf-8");
/**
 * Clase abstracta para el manejo de cadenas
 *
 * @author juan
 */
abstract class StrFunc {
    
    /**
     * Funcion que retorna una variable del array GET
     *
     * @param string $varName, nombre de la variable
     * 
     * @return mixed, retorna el valor 
     * 
     * @access public
     * 
     * @static
     */
    public static function getg( $varName ) {
        if ( isset( $_GET[$varName] ) )
            return StrFunc::validar( $_GET[$varName] );
        else
            return '';
    }
    
    /**
     * Funcion que retorna una variable del array POST
     *
     * @param string $varName, nombre de la variable
     * 
     * @return mixed, retorna el valor 
     * 
     * @access public
     * 
     * @static
     */
    public static function getp( $varName ) {
        if ( isset( $_POST[$varName] ) )
            return StrFunc::validar( $_POST[$varName], 10000 );
        else
            return '';
    }
 
    /**
     * Funcion para validar las entradas desde el array GET y POST
     * 
     * @param string $variable, contenido de la variable a validar
     * @param int $tam, longitud maxima de la variable
     * 
     * @return mixed, retorna el contenido de la variable validado
     * 
     * @access public
     * 
     * @static
     */
    public static function validar( $variable , $tam = 100 ) {
        $va = htmlentities( $variable , ENT_QUOTES );
        $va = strip_tags($va);        
        $va = substr( $va , 0 , $tam );
        
        return $va;
    }
}
?>