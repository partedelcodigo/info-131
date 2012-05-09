<?PHP

class CONTROL {

    /**
     * tamano del control
     */
    var $tamano;

    /**
     * cantidad maxima de caracteres
     */
    var $cant_caracteres;

    /**
     * nombre del control
     */
    var $nombre;

    /**
     * valor recibido por el control
     */
    var $valor;

    /**
     * permiso para el control [0=no requerido,1=requerido,2=solo lectura]
     */
    var $permiso;

    /**
     * expresion regular de validacion colocar en vacio de no ser requerida
     */
    var $exp_regular;

    /**
     * nombre del control a mostrar en pantalla
     */
    var $mensaje;

    /**
     * id o clase para la carga del css
     */
    var $clase_css;

    /**
     * valor por defecto del control
     */
    var $defecto;

    /**
     * para la carga de parametros
     */
    function cargar_parametros() {
        
    }

    /**
     * para dibujar el control
     */
    function dibujar() {
        
    }

    /**
     * para verificar la prioridad del control
     */
    function ver_prioridad() {
        
    }

    /**
     * poder verificar ordenes
     */
    function verificar() {
        
    }

    /**
     * para poder realizar la validacion 
     */
    function validar() {
        /* echo strlen($_POST[$this->nombre]); */
        /* echo '<script>alert("'.$this->valor.'")</script>'; */
        if ((isset($this->valor)) and (strlen($this->valor) > 0)) {
            if ($this->permiso == 0) {
                return true;
            } else {
                if (trim($this->exp_regular) <> "") {
                    //echo ereg($this->exp_regular,$cadena);
                    if(@ereg($this->exp_regular, $this->valor)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        } else {
            if (($this->permiso == 0) or ($this->permiso == 2)) {
                return true;
            } else {
                return false;
            }
        }
    }

}

;
?>
