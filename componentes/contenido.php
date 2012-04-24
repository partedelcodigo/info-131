<?php
require_once('clases/ventana.php');

class CONTENIDO extends VENTANA {

    var $ventana;
    var $parametros;
    var $path;
    var $usuario;
    var $grupo;

    function CONTENIDO() {
        $this->ventana = new VENTANA();
        $this->usuario = new PERSONA();
        $this->grupo = $this->usuario->get_grupo();
        $this->parametros = array();
        $this->parametros['izquierda'] = '10px';
        $this->parametros['arriba'] = '120px';
        $this->parametros['ancho'] = '98%';
        $this->parametros['alto'] = '78%';
        $this->parametros['titulo'] = 'contenido';

        $this->ventana->add_css_param('background-color', '#FFFFFF');
        $this->ventana->add_css_param('overflow', 'auto');
        $this->ventana->add_css_param('border-bottom', '2px #111111 solid');
        $this->ventana->add_css_param('border-top', '0.5px #111111 solid');
        $this->ventana->add_css_param('border-right', '2px #111111 solid');
        $this->ventana->add_css_param('border-left', '1px #111111 solid');
        $this->ventana->set_ventana($this->parametros);
    }

    function set_path($path) {
        $this->path = $path;
    }

    function dibujar() {
        include ($this->path);
    }

}

?>
