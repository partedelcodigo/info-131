<?php
require_once('clases/ventana.php');

class BARRA_NAVEGACION extends VENTANA {

    var $ventana;
    var $parametros;
    var $path;

    function BARRA_NAVEGACION() {
        $this->ventana = new VENTANA();
        $this->parametros = array();
        $this->parametros['izquierda'] = '45%';
        $this->parametros['arriba'] = '22px';
        $this->parametros['ancho'] = '500px';
        $this->parametros['alto'] = '25px';
        $this->parametros['titulo'] = 'barra_navegacion';

        $this->ventana->add_css_param('color', '#000000');
        $this->ventana->add_css_param('font-weight', 'normal');
        $this->ventana->add_css_param('font-size', '10px');
        $this->ventana->add_css_param('display', 'inline');
        $this->ventana->add_css_param('text-align', 'center');
        $this->ventana->set_ventana($this->parametros);
    }

    function dibujar() {
        
    }

}
?>