<?php
require_once('clases/ventana.php');

class CARGANDO extends VENTANA {

    var $ventana;
    var $parametros;

    function CARGANDO() {
        $this->ventana = new VENTANA();

        $this->parametros = array();
        $this->parametros['izquierda'] = '65%';
        $this->parametros['arriba'] = '0.6%';
        $this->parametros['ancho'] = '23.3%';
        $this->parametros['alto'] = '40px';
        $this->parametros['titulo'] = 'cargando';

        $this->ventana->add_css_param('background-color', '#566F74');
        $this->ventana->add_css_param('color', '#FFFFFF');
        $this->ventana->add_css_param('font-size', '24px');
        $this->ventana->add_css_param('display', 'none');
        $this->ventana->add_css_param('padding-top', '0px');
        $this->ventana->add_css_param('padding-bottom', '0px');
        $this->ventana->add_css_param('background-position', '5%');
        $this->ventana->add_css_param('border-bottom', '1.5px #111111 solid');
        $this->ventana->add_css_param('border-top', '0.5px #111111 solid');
        $this->ventana->add_css_param('border-left', '0.5px #111111 solid');
        $this->ventana->add_css_param('border-right', '1.5px #111111 solid');
        $this->ventana->set_ventana($this->parametros);
    }

    function dibujar() {
        $this->ventana->abrir();
        echo '&nbsp;&nbsp;<img src="./graficos/loaded.gif">&nbsp;&nbsp;' . _men_cargando;
        $this->ventana->cerrar();
    }

}

?>
