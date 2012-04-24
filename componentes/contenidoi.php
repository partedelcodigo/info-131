<?PHP

require_once('clases/ventana.php');

class CONTENIDOI extends VENTANA {

    var $ventana;
    var $parametros;

    function CONTENIDOI() {
        $this->ventana = new VENTANA();

        $parametros = array();

        $parametros['izquierda'] = '25%';
        $parametros['arriba'] = '16.5%';
        $parametros['ancho'] = '520px';
        $parametros['alto'] = '200px';
        $parametros['titulo'] = 'login';
        $this->ventana->add_css_param('background', 'url()');
        $this->ventana->add_css_param('font-weight', 'bold');
        $this->ventana->add_css_param('border-top', '1px #111111 solid');
        $this->ventana->add_css_param('border-right', '3px #111111 solid');
        $this->ventana->add_css_param('border-left', '1px #111111 solid');
        $this->ventana->add_css_param('border-bottom', '3px #111111 solid');
        $this->ventana->add_css_param('background-color', '#C13536');
        $this->ventana->add_css_param('color', '#FFFFFF');
        $this->ventana->set_ventana($parametros);
    }

    function set_path($path) {
        $this->path = $path;
    }

    function dibujar() {
        $this->ventana->abrir();
        include ($this->path);
        $this->ventana->cerrar();
    }
}
?>