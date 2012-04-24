<?php
require_once('clases/ventana.php');

class BARRA_CONFIGURACION extends VENTANA {

    var $ventana;
    var $parametros;
    var $grupo;

    function BARRA_CONFIGURACION() {
        $this->ventana = new VENTANA();
        $this->usuario = new PERSONA();
        $this->grupo = $this->usuario->get_grupo();
        $this->parametros = array();
        $this->parametros['izquierda'] = '88.3%';
        $this->parametros['arriba'] = '118px';
        $this->parametros['ancho'] = '117px';
        $this->parametros['alto'] = '26px';
        $this->ventana->add_css_param('display', 'none');
        $this->parametros['titulo'] = 'barra_config';
        $this->ventana->add_css_param('background-color', '#000000');
        $this->ventana->set_ventana($this->parametros);
    }

    function cargar_cabecera() {
        $ventana = new VENTANA();
        $parametros = array();
        $parametros['izquierda'] = '88.3%';
        $parametros['arriba'] = '98px';
        $parametros['ancho'] = '118px';
        $parametros['alto'] = '20px';
        $parametros['titulo'] = 'barra_cabecera';
        $ventana->add_css_param('background', 'url(' . _url . '/graficos/fondo.png) repeat-x');
        $ventana->add_css_param('color', '#000000');
        $ventana->add_css_param('font-weight', 'normal');
        $ventana->add_css_param('font-size', '12px');
        $ventana->set_ventana($parametros);
        $ventana->abrir();
        echo '<center>';
        include_once('imprimir_ventana.php');
        $extra2 = '';
        echo '<a href="javascript:var c = window.open(' . $page . ',' . $extpage . ',' . $features . ');
							var dato =document.getElementById(' . $pagina . ').innerHTML;
							c.document.write(' . $extra1 . ');
							c.document.write(dato);
							c.document.write(' . $extra2 . ');">
							<img src="' . _img_imprimir . '" width="18" heigth="18" border=0>&nbsp;' . _men_imprimir . '</a>';
        echo '</center>';
        $ventana->cerrar();
    }

    function cargar_pie() {
        
    }

    function dibujar() {
        $this->cargar_cabecera();
        $this->ventana->abrir();
        $this->ventana->cerrar();
    }

}

?>
