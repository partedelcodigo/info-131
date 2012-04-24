<?php

class CAJA_TIQUEO extends CONTROL {

    function cargar_parametros($mensaje, $nombre, $permiso, $clase_css, $defecto, $tip = '') {
        $this->nombre = $nombre;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        $this->mensaje = $mensaje;
        $this->valor = (isset($_POST[$this->nombre])) ? $_POST[$this->nombre] : '';
        $this->permiso = $permiso;
        $this->exp_regular = '';
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
        if (!$this->valor) {
            $this->valor = '0';
        }
        return $this->valor;
    }

    function dibujar() {
        $mensaje = ($this->permiso == 2) ? 'readonly="readonly"' : '';
        echo $this->mensaje;
        if ($this->get_valor()) {
            echo '<input type="checkbox" ' . $mensaje . ' class="' .
            $this->clase_css . '" name="' .
            $this->nombre . '" value="1" checked>';
            // echo "<td class=campo>&nbsp;&nbsp;<input class=casilla type=checkbox value=1 name='{$this->valores[1][$i]}' checked></td>";
        } else {
            echo '<input type="checkbox" ' . $mensaje . ' class="' .
            $this->clase_css . '" name="' .
            $this->nombre . '" value="1">';
            //echo "<td class=campo>&nbsp;&nbsp;<input class=casilla type=checkbox  value=1 name='{$this->valores[1][$i]}' ></td>";
        }
        if ($this->tip != '') {
            echo '&nbsp;';
            echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '" . $this->tip . ".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> ";
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

    function ver_prioridad() {
        if ($this->permiso == 2) {
            return true;
        } else {
            if ($this->permiso == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    function valido() {
        return $this->validar();
    }
}
?>
