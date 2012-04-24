<?php
require_once('clases/ventana.php');

class LOGO extends VENTANA {

    var $ventana;
    var $parametros;

    function LOGO() {
        $this->ventana = new VENTANA();

        $this->parametros = array();
        $this->parametros['izquierda'] = '650px';
        $this->parametros['arriba'] = '0px';
        $this->parametros['ancho'] = '107px';
        $this->parametros['alto'] = '0px';
        $this->parametros['titulo'] = 'logo';
        $this->ventana->set_ventana($this->parametros);
    }

    function dibujar() {
        $this->ventana->abrir();
        echo '<center>';
        echo '</center>';
        $this->ventana->cerrar();
    }

}

?>
