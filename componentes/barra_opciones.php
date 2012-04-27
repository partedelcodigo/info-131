<?php
require_once('clases/ventana.php');
class barra_opciones extends VENTANA {
    var $ventana;
    var $parametros;
    var $path;

    function barra_opciones() {
        $this->ventana=new VENTANA();
        $this->parametros=array();
        $this->parametros['izquierda']='0%';
        $this->parametros['arriba']='0px';
        $this->parametros['ancho']='100%';
        $this->parametros['alto']='10px';
        $this->parametros['titulo']='Opciones';
        $this->ventana->add_css_param ('background-image','url(graficos/fondoheader.gif)');
        $this->ventana->add_css_param ('color','#000000');
        $this->ventana->add_css_param ('font-weight','normal');
        $this->ventana->add_css_param ('font-size','16px');

        $this->ventana->set_ventana($this->parametros);
    }

    function iniciar() {
        $this->ventana->abrir();
    }

    function cerrar() {
        $this->ventana->cerrar();
    }

    function dibujar() {
    }
}
?>