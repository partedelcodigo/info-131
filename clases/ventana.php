<?PHP

class VENTANA {

    var $izquierda;
    var $arriba;
    var $ancho;
    var $alto;
    var $titulo;
    var $arreglo_css;
    var $actual_css;

    function VENTANA() {
        $this->actual_css = 0;
    }

    function set_ventana($parametros) {
        /**
          Datos Requeridos
         */
        $this->izquierda = $parametros['izquierda'];
        $this->arriba = $parametros['arriba'];
        $this->ancho = $parametros['ancho'];
        $this->alto = $parametros['alto'];
        $this->titulo = $parametros['titulo'];
    }

    function generar_css() {

        echo '<style type=text/css>';
        echo '#' . $this->titulo;
        echo '{';
        echo 'position: absolute;';
        echo 'left:' . $this->izquierda . ';';
        echo 'top:' . $this->arriba . ';';
        echo 'width:' . $this->ancho . ';';
        echo 'height:' . $this->alto . ';';
        $this->get_arreglo_css();
        echo '}';
        echo '</style>';
    }

    function get_arreglo_css() {
        for ($i = 0; $i < count($this->arreglo_css[0]); $i++) {
            echo $this->arreglo_css[0][$i] . ':' . $this->arreglo_css[1][$i] . ';';
        }
    }

    function add_css_param($option, $valor) {
        $this->arreglo_css[0][$this->actual_css] = $option;
        $this->arreglo_css[1][$this->actual_css] = $valor;
        $this->actual_css++;
    }

    function abrir() {
        $this->generar_css();
        echo '<div id="' . $this->titulo . '">';
    }

    function cerrar() {
        echo '</div>';
    }

}

;
?>
