<?php

require_once(_rutaraiz . '/clases/ventana.php');

class LOGIN {

    var $codigo;
    var $nombre;
    var $sede_actual;

    function LOGIN() {
        $this->nombre = new CONTROLES;
        $parametros = array();
        $parametros['nombre'] = 'name';
        $parametros['cant_caracteres'] = 15;
        $parametros['tamano'] = 20;
        $parametros['permiso'] = 1;
        $parametros['tipo'] = _CAJA_G;
        $this->nombre->cargar_parametros($parametros);

        $this->codigo = new CONTROLES;
        $parametros_cod = array();
        $parametros_cod['nombre'] = 'pass';
        $parametros_cod['cant_caracteres'] = 15;
        $parametros_cod['tamano'] = 20;
        $parametros_cod['permiso'] = 1;
        $parametros_cod['tipo'] = _CAJA_CODIGO;
        $this->codigo->cargar_parametros($parametros_cod);

        $this->generar_formulario();
    }

    function generar_formulario() {
        $this->ventana = new VENTANA();
        //$pantalla=new PANTALLA_INICIAL;
        $parametros = array();
        $parametros['izquierda'] = '1%';
        $parametros['arriba'] = '1%';
        $parametros['ancho'] = '98%';
        $parametros['alto'] = '98%';
        $parametros['titulo'] = 'login_back';
        $this->ventana->add_css_param('color', '#3d5b99');
        $this->ventana->add_css_param('font-weight', 'bold');
        $this->ventana->set_ventana($parametros);
    }

    function abrir_formulario() {
        $this->ventana->abrir();
        echo '<form name="form" action="index.php?mod_id=login&tarea=verificar" method="POST">';
        echo '<br><br>';
        echo '<center><font color="#FFFFFF" size="4" face="Verdana, Arial, Helvetica, sans-serif">';
        echo _titulo_login;
        echo '</font></center><br><br>';
        echo '<center>';
        echo '<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF">';
        echo _name_login;
        echo '&nbsp;&nbsp;</font>';
    }

    function cerrar_formulario() {
        echo '<p>';
        echo '<center>';
        echo '<input class="boton" name="enviar" type="submit" id="enviar" value="';
        echo _ingreso;
        echo '">&nbsp;&nbsp;';
        echo '<input class="boton" type="reset" name="Reset" value="';
        echo _cancelar;
        echo '">';
        echo '</center>';
        echo '</p><br>';
        echo '</center>';
        echo '</form>';
        $this->ventana->cerrar();
    }

    function ext_formulario() {
        echo '</center><br>';
        echo '<center>';
        echo '<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF">';
        echo _codigo_login;
        echo '&nbsp;&nbsp;&nbsp;&nbsp;</font>';
    }

    function ingreso() {
        $this->abrir_formulario();
        $this->nombre->dibujar_control();
        $this->ext_formulario();
        $this->codigo->dibujar_control();
        $this->cerrar_formulario();
        echo '<div style="left:10%;top:105%;position:absolute;">';
        echo '<center><font color="#FFFFFF" size="2">El sistema reconoce la diferencia entre may&uacute;sculas y min&uacute;sculas, verifique su informaci&oacute;n al momento de ingresar sus datos</font></center>';
        echo '</div>';
    }

    function verificar() {
        $this->abrir_formulario();
        $this->nombre->dibujar_control();
        $valido_nombre = $this->nombre->get_valor_control();
        $cad = '';
        if ($valido_nombre != "") {
            $nombre = $this->nombre->get_valor_control();
        } else {
            echo '<div style="left:80%;top:39%;position:absolute;">';
            echo '<center><font color="#f8bc00" size="4px">Incorrecto</font></center>';
            echo '</div>';
            //$cad.=  '<br><font color="#FF0000" size="4px">'._men_nombre_usuario_invalido.'</font>';
        }
        $this->ext_formulario();
        $this->codigo->dibujar_control();
        $valido_cod = $this->nombre->get_valor_control();
        if ($valido_cod != "") {
            $cod = $this->codigo->get_valor_control();
        } else {
            echo '<div style="left:80%;top:57%;position:absolute;">';
            echo '<center><font color="#f8bc00" size="4px">Incorrecto</font></center>';
            echo '</div>';

            //$cad.= '<br>';
        }
        if ((trim($valido_nombre) <> '') and (trim($valido_cod) <> '')) {
            /**
              Se realiza la verificaci�n de la BD
             */
            $usuario = new PERSONA;

            $usuario->set_datos($nombre, $cod);
            $usuario->verificar();
            if ($usuario->registrado()) {
                echo '<script language="javascript">';
                echo '  location.href="index.php?mod_id=principal";';
                echo '</script>';
            } else {
                echo '<div style="left:80%;top:39%;position:absolute;">';
                echo '<center><font color="#f8bc00" size="4px">Incorrecto</font></center>';
                echo '</div>';
                echo '<div style="left:80%;top:57%;position:absolute;">';
                echo '<center><font color="#f8bc00" size="4px">Incorrecto</font></center>';
                echo '</div>';
                /* $cad= '<center><font color="#FF0000" size="4px">'._men_nombre_usuario_invalido.'</font></center>';
                  $cad.= '<center><font color="#FF0000" size="4px">'._men_codigo_usuario_invalido.'</font></center>'; */
            }
        }

        $this->cerrar_formulario();
        echo '<div class="mensaje" style="left:5%;top:-32%;position:absolute;">';
        echo '<center>' . $cad . '</center>';
        echo '</div>';
        echo '<div style="left:10%;top:105%;position:absolute;">';
        echo '<center><font color="#FFFFFF" size="2">El sistema reconoce la diferencia entre may&uacute;sculas y min&uacute;sculas, verifique su informaci&oacute;n al momento de ingresar sus datos</font></center>';
        echo '</div>';
    }

    function cerrar() {
        $usuario = new PERSONA;
        $usuario->cerrar_session();
        echo '<h3>' . _cerrarsesion . '</h3>';
        echo '<script language="javascript">';
        echo '   location.href="index.php";';
        echo '</script>';
    }

}

;
?>
