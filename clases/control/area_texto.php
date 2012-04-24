<?PHP

class AREA_TEXTO extends CONTROL {

    var $filas;
    var $columnas;

    function cargar_parametros($mensaje, $nombre, $cant_caracteres, $filas = 20, $columnas = 5, $permiso, $clase_css, $defecto, $tip = '') {
        $this->nombre = $nombre;
        $this->filas = $filas;
        $this->columnas = $columnas;
        $this->mensaje = $mensaje;
        $this->permiso = $permiso;
        $this->defecto = $defecto;
        $this->clase_css = $clase_css;
        $this->cant_caracteres = $cant_caracteres;
        $this->valor = (isset($_POST[$this->nombre])) ? $_POST[$this->nombre] : '';
        $this->tip = $tip;
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
        $mensaje = ($this->permiso == 2) ? 'readonly="readonly"' : '';
        echo $this->mensaje;
        echo '<textarea ' . $mensaje . ' class="' .
        $this->clase_css . '" name="' .
        $this->nombre . '" rows="' .
        $this->filas . '" cols="' .
        $this->columnas . '">' .
        $this->get_valor() . '</textarea>';
        if ($this->tip != '') {
            echo '&nbsp;';
            echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '" . $this->tip . ".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> ";
        }
    }

    function ver_prioridad() {
        if ($this->permiso == 2) {
            return true;
        } else {
            if (($this->permiso == 1) and (trim($this->valor) <> "")) {
                return true;
            } else {
                if ($this->permiso == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function verificar() {
        if ($this->ver_prioridad()) {
            if ($this->valido()) {
                return 1;
            } else {
                $this->valor = '';
                return 2;
            }
        } else {
            $this->valor = '';
            return 0;
        }
    }

    function valido() {
        return $this->validar();
    }

}
?>