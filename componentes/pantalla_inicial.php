<?PHP

require_once('clases/ventana.php');

class PANTALLA_INICIAL extends VENTANA {

    var $ventana;
    var $parametros;

    function PANTALLA_INICIAL() {
        $this->ventana = new VENTANA();

        $this->parametros = array();
        $this->parametros['izquierda'] = '0%';
        $this->parametros['arriba'] = '0%';
        $this->parametros['ancho'] = '100%';
        $this->parametros['alto'] = '100%';
        $this->parametros['titulo'] = 'inicial';

        $this->ventana->add_css_param('background', 'url(' . _url . '/graficos/back.gif)');
        $this->ventana->set_ventana($this->parametros);
        $this->ventana->abrir();
        $this->dibujar();
        $this->ventana->cerrar();
    }

    function dibujar() {
        echo '<center></center>';
    }

}
?>