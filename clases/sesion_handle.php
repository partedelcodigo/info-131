<?PHP

require_once('sesion.php');

class SESION_HANDLE {

    var $sesion;
    var $nombre_variables_de_sesion;

    function SESION_HANDLE() {
        $this->sesion = new SESION;
    }

    function set_sesion($nombre) {
        $this->sesion->set_nombre_sesion($nombre);
    }

    function valida() {
        if (trim($this->sesion->get_nombre()) <> "") {
            return true;
        } else {
            return false;
        }
    }

    function cerrar() {
        $this->sesion->liberar_sesion();
    }

    function set_variable_sesion($nombre, $valor) {
        $this->sesion->set_variable($nombre, $valor);
    }

    function get_variable_sesion($nombre) {
        return $this->sesion->get_variable($nombre);
    }

    function iniciar_session() {
        $this->sesion->iniciar_sesion();
    }

}

;
?>
