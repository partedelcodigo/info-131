<?php
require_once('clases/ventana.php');

class CONTENIDO2 extends VENTANA {
    var $ventana;
    var $parametros;
    var $path;

    function CONTENIDO2() {
        $this->ventana=new VENTANA();

        $this->parametros=array();
        $this->parametros['izquierda']='0%';
        $this->parametros['arriba']='30px';
        $this->parametros['ancho']='100%';
        $this->parametros['alto']='80%';
        $this->parametros['titulo']='contenido2';
        $this->ventana->add_css_param ('background-color','#FFFFFF');
        $this->ventana->set_ventana($this->parametros);
    }

    function dibujar() {
        $this->ventana->abrir();
        include ($this->path);
        $this->ventana->cerrar();
    }
};
?>
