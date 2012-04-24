<?php
require_once('clases/ventana.php');

class PIE_PAGINA extends VENTANA {

    var $ventana;
    var $parametros;

    function PIE_PAGINA() {
        $this->ventana = new VENTANA();
        $this->parametros = array();
        $this->parametros['izquierda'] = '0px';
        $this->parametros['arriba'] = '95%';
        $this->parametros['ancho'] = '99.8%';
        $this->parametros['alto'] = '20px';
        $this->parametros['titulo'] = 'pie_pagina';
        $this->ventana->add_css_param('background-color', '#C13536');
        $this->ventana->add_css_param('background-image', 'url(' . _rutaraiz . '/graficos/fondoheader.gif)');
        $this->ventana->add_css_param('color', '#FFFFFF');
        $this->ventana->add_css_param('font_weight', 'normal');
        //$this->ventana->add_css_param('padding-bottom','3px');
        $this->ventana->set_ventana($this->parametros);
    }

    function dibujar() {
        $this->ventana->abrir();
        echo '<center><font size="2">' . _pie_pagina . '</font></center>';
        $this->ventana->cerrar();
    }

}

?>