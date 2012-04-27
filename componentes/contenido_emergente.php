<?php
require_once('clases/ventana.php');

class CONTENIDO extends VENTANA {
    var $ventana;
    var $parametros;
    var $path;

    function CONTENIDO() {
        $this->ventana=new VENTANA();
        $this->parametros=array();
        $this->parametros['izquierda']='0px';
        $this->parametros['arriba']='0px';
        $this->parametros['ancho']='99%';
        $this->parametros['alto']='100%';
        $this->parametros['titulo']='contenido';

        $this->ventana->add_css_param ('background-color','#FFFFFF');
        $this->ventana->add_css_param ('border-bottom','2px #AAAAAA solid');
        $this->ventana->add_css_param ('border-top','2px #AAAAAA solid');
        $this->ventana->add_css_param ('border-right','2px #AAAAAA solid');
        $this->ventana->add_css_param ('border-left','2px #AAAAAA solid');
        $this->ventana->set_ventana($this->parametros);
    }

    function set_path($path) {
        $this->path=$path;
    }

    function dibujar() {
        $this->ventana->abrir();
        include ($this->path);
        $this->ventana->cerrar();
    }
}
?>