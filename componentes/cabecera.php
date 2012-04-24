<?PHP
require_once('clases/ventana.php');

class CABECERA extends VENTANA {

    var $ventana;
    var $parametros;

    function CABECERA() {
        $this->ventana = new VENTANA();

        $this->parametros = array();
        $this->parametros['izquierda'] = '4px';
        $this->parametros['arriba'] = '23px';
        $this->parametros['ancho'] = '99.38%';
        $this->parametros['alto'] = '75px';
        $this->parametros['titulo'] = 'cabecera';
        $this->ventana->add_css_param('background-color', '#C13536');
        $this->ventana->add_css_param('background-image', '');
        $this->ventana->add_css_param('padding-top', '0px');
        $this->ventana->add_css_param('padding-bottom', '0px');
        $this->ventana->set_ventana($this->parametros);
    }

    function dibujar() {
        $this->ventana->abrir();
        echo '<center><img src="' . _img_cabecera . '"></center>';
        $this->ventana->cerrar();
    }

}

?>
