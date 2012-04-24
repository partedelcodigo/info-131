<?php
require_once('clases/ventana.php');

class DATOS_GENERALES extends VENTANA {

    var $ventana;
    var $parametros;
    var $usuario;

    function DATOS_GENERALES() {
        $this->ventana = new VENTANA();
        $this->usuario = new PERSONA();
        $this->parametros = array();
        $this->parametros['izquierda'] = '56%';
        $this->parametros['arriba'] = '1px';
        $this->parametros['ancho'] = '42%';
        $this->parametros['alto'] = '20px';
        $this->parametros['titulo'] = 'datos_generales';
        $this->ventana->add_css_param('background-color', '#C13536');
        $this->ventana->add_css_param('border-bottom', '1px #000000 solid');
        $this->ventana->add_css_param('border-top', '1px #000000 solid');
        $this->ventana->add_css_param('border-right', '2px #000000 solid');
        $this->ventana->add_css_param('border-left', '1px #000000 solid');
        $this->ventana->add_css_param('padding-left', '15px');
        $this->ventana->add_css_param('color', '#FFFFFF');
        $this->ventana->add_css_param('background-image', 'url(' . _url . '/graficos/fondo2.gif)');
        $this->ventana->add_css_param('font-weight', 'bold');
        $this->ventana->add_css_param('font-size', '12px');
        $this->ventana->set_ventana($this->parametros);
    }

    function get_datos() {
        /*         * Dibujamos otra ventana para la opcion dentro de los datos generales */
        $ventana = new VENTANA();
        $parametros = array();
        $parametros['izquierda'] = '88%';
        $parametros['arriba'] = '0px';
        $parametros['ancho'] = '54px';
        $parametros['alto'] = '20.3px';
        $parametros['titulo'] = 'dat_gen_cabecera';
        $ventana->add_css_param('background', 'url(' . _url . '/graficos/fondo.png) repeat-x');
        $ventana->add_css_param('color', '#000000');
        $ventana->add_css_param('font-weight', 'normal');
        $ventana->add_css_param('font-size', '12px');
        $ventana->set_ventana($parametros);
        $ventana->abrir();
        echo '<center>';
        echo '<a href="index.php?mod_id=login&tarea=cerrar">' . _men_salir . '</a>';
        echo '</center>';
        $ventana->cerrar();
        echo 'Usuario : ' . $this->usuario->get_nombre_completo() . ' / ' . $this->usuario->get_usuario();
    }

    function dibujar() {
        $this->ventana->abrir();
        $this->get_datos();
        $this->ventana->cerrar();
    }

}

?>
