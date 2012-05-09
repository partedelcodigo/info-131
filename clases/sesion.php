<?PHP

class SESION {

    function SESION() {
        
    }

    function iniciar_sesion() {
        if (!isset($_SESSION))
            session_start();
    }

    function set_nombre_sesion($nombre) {
        session_name($nombre);
    }

    function get_nombre() {
        return session_name();
    }

    function get_id() {
        return session_id();
    }

    function liberar_sesion() {
        session_unset();
        if (isset($nombre)) {
            session_destroy();
        }
    }

    function existe_variable($nombre) {
        /**
         * Changed by @Juan
         * Before: if (session_is_registered($nombre)) {
         * Now: if (isset($_SESSION[nombre)) {
         */
        if (isset($_SESSION[$nombre])) {
            return true;
        } else {
            return false;
        }
    }

    function set_variable($nombre, $valor) {
        //session_register($nombre);
        $_SESSION[$nombre] = $valor;
    }

    function get_variable($nombre) {
        if ($this->existe_variable($nombre)) {
            return $_SESSION[$nombre];
        } else {
            return false;
        }
    }

}

;
?>
