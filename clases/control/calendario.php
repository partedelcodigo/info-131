<?php

class CALENDARIO extends CONTROL {

    function cargar_parametros($mensaje, $nombre, $cant_caracteres, $tamano, $permiso, $exp_regular, $clase_css, $defecto, $tip = '') {
        $this->nombre = $nombre;
        $this->cant_caracteres = $cant_caracteres;
        $this->tamano = $tamano;
        $this->valor = (isset($_POST[$nombre])) ? $_POST[$nombre] : '';
        $this->permiso = $permiso;
        $this->exp_regular = $exp_regular;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        $this->mensaje = $mensaje;
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
        echo '<input class="' .
        $this->clase_css . ' type="text" size ="' .
        $this->tamano . '"  maxlength="' .
        $this->cant_caracteres . '" name="' .
        $this->nombre . '" id="' .
        $this->nombre . '" value="' .
        $this->get_valor() . '" onclick="' . 'but' . $this->nombre . '.click();"' . '">';
        echo '&nbsp;';
        echo '<input name="but' .
        $this->nombre . '" id="but' .
        $this->nombre . '" type="button"
				class="boton_fecha" value="">';
        echo '<script type="text/javascript">
				Calendar.setup({inputField     :    "' . $this->nombre .
        '",ifFormat     :     "%Y-%m-%d",
				button     :    "but' . $this->nombre .
        '"});</script>';
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
