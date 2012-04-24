<?php

class COMBO extends CONTROL {

    var $arreglo_valores;
    var $arreglo_mensajes;

    function cargar_parametros($mensaje, $nombre, $permiso, $clase_css, $defecto, $arreglo_valores, $arreglo_mensajes, $tip = '') {
        $this->nombre = $nombre;
        $this->valor = (isset($_POST[$nombre])) ? $_POST[$nombre] : '';
        $this->permiso = $permiso;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        $this->mensaje = $mensaje;
        $this->arreglo_valores = $arreglo_valores;
        $this->arreglo_mensajes = $arreglo_mensajes;
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
        $this->valor = $this->get_valor();
        echo $this->mensaje;
        echo '<select class="' . $this->clase_css . '" name="' . $this->nombre . '" ' . $mensaje . '>';
        $this->cargar_opciones();
        echo '</select>';
        if ($this->tip != '') {
            echo '&nbsp;';
            echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '" . $this->tip . ".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> ";
        }
    }

    function cargar_opciones() {
        echo '<option selected="true" value="">' . _men_seleccione . '</option>';
        for ($i = 0; $i < count($this->arreglo_valores); $i++) {
            if ($this->arreglo_valores[$i] == $this->valor) {
                $this->arreglo_mensajes[$i] = htmlentities($this->arreglo_mensajes[$i]);
                echo '<option selected="true" value="' . $this->arreglo_valores[$i] . '">' . $this->arreglo_mensajes[$i] . '</option>';
            } else {
                $this->arreglo_mensajes[$i] = htmlentities($this->arreglo_mensajes[$i]);
                echo '<option value="' . $this->arreglo_valores[$i] . '">' . $this->arreglo_mensajes[$i] . '</option>';
            }
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