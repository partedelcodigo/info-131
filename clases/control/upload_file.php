<?php
@header("Content-Type: text/html; charset=utf-8");
/**
 * Description of upload_file
 *
 * @author the programator
 */
class upload_file extends CONTROL {
    function cargar_parametros($mensaje, $nombre, $cant_caracteres, $tamano, $permiso, $exp_regular, $clase_css, $defecto, $tip = '') {
        $this->nombre = $nombre;
        $this->cant_caracteres = $cant_caracteres;
        $this->tamano = $tamano;
        $this->valor = (isset($_POST[$nombre])) ? $_POST[$nombre] : '';
        $this->permiso = $permiso;
        $this->exp_regular = $exp_regular;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        $this->mensaje = $mensaje;
        $this->tip = $tip;
    }

    function get_valor() {
        
        if (!(trim($this->valor) <> '')) {
            if (trim($this->defecto) <> '') {
                $this->valor = $this->defecto;
            }
        }
        if ($this->verificar() <> 1) {
            $this->valor = '';
        }
        
        
        return $this->valor;
    }

    function dibujar() {
        
        $mensaje = ($this->permiso == 2) ? 'readonly="readonly"' : '';
        echo $this->mensaje;
        
        # si la imagen fue cargada mostramos la imagen y no el control
        if( strlen( trim( $this->get_valor() ) ) > 0 ) {
            echo '<img src="/uploads/medium_'.$this->get_valor().'" width="'.ImageConfig::$ImageSizes['medium'][0].'" /><br />';
            echo '<a href="javascript:changeFormElement(\'image_action\', 1),toggleElement(\'hide_file\');">Cambiar imagen</a> - <a href="javascript:changeFormElement(\'image_action\', 2),changeVisibility(\'hide_file\',0)">Borrar imagen</a><br />';
            echo '<input type="hidden" name="image_action" id="image_action" value="0" />';
            echo '<div style="display: none" id="hide_file" name="hide_file"><input type="file" name="'.$this -> nombre.'" /></div>';
        }
        else {
            echo '<input type="file" ' . $mensaje . ' class="' .
            $this->clase_css . '" name="' .
            $this->nombre . '" value="' .
            $this->get_valor() . '">';
        }
        
        if ($this->tip != '') {
            echo '&nbsp;';
            echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '" . $this->tip . ".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> ";
        }
    }

    function ver_prioridad() {
        if ($this->permiso == 2) {
            return true;
        } else {
            if (($this->permiso == 1) and (trim($this->valor) <> "")) {
                return true;
            } else {
                if ($this->permiso == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function verificar() {
        if ($this->ver_prioridad()) {
            if ($this->valido()) {
                return 1;
            } else {
                $this->valor = '';
                return 2;
            }
        } else {
            $this->valor = '';
            return 0;
        }
    }

    function valido() {
        return $this->validar();
    }
}
?>