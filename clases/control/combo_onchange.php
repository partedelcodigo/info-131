<?php
require_once("combo.php");

class COMBO_ONCHANGE extends COMBO {

    var $nombreform;

    function cargar_parametros($mensaje, $nombre, $permiso, $clase_css, $defecto, $arreglo_valores, $arreglo_mensajes, $formulario, $tip = '') {
        $this->nombre = $nombre;
        $this->valor = (isset($_POST[$nombre])) ? $_POST[$nombre] : '';
        $this->permiso = $permiso;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        $this->mensaje = $mensaje;
        $this->arreglo_valores = $arreglo_valores;
        $this->arreglo_mensajes = $arreglo_mensajes;
        $this->nombreform = $formulario;
        $this->tip = $tip;
    }

    function dibujar() {
        $mensaje = ($this->permiso == 2) ? 'readonly="readonly"' : '';
        $this->valor = $this->get_valor();
        echo $this->mensaje;
        echo '<select class="' . $this->clase_css . '" name="' . $this->nombre . '" ' . "onChange=" . $this->nombreform . '.submit() ' . $mensaje . '>';
        $this->cargar_opciones();
        echo '</select>';
        if ($this->tip != '') {
            echo '&nbsp;';
            echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '" . $this->tip . ".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> ";
        }
        //onChange=formfiltra.submit()
    }

}
?>