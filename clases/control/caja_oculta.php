<?PHP

class CAJA_OCULTA extends CONTROL {

    function cargar_parametros($nombre, $clase_css, $defecto) {
        $this->nombre = $nombre;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        //$this->dibujar();
    }

    function get_valor() {
        if ((empty($_POST[$this->nombre]))) {
            if (trim($this->defecto) <> '') {
                $this->valor = $this->defecto;
            }
        }
        if ($this->verificar() <> 1) {
            $this->valor = '';
        }
        return $this->valor;
    }

    function dibujar() {
        if ($this->permiso == 2) {
            $mensaje = 'readonly';
        }
        echo $this->mensaje;
        echo '<input type="hidden" ' . $mensaje . ' class="' .
        $this->clase_css . '" name="' .
        $this->nombre . '" value="' . $this->get_valor() . '">';
    }

    function verificar() {
        return 1;
    }

}
?>
