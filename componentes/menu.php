<?PHP
require_once('clases/ventana.php');

class MENU extends VENTANA {
    var $ventana;
    var $parametros;
    var $lista;
    var $usuario;
    var $Array_Modulos;

    function MENU() {

        $this->ventana=new VENTANA();
        $this->usuario=new PERSONA();
        $this->parametros=array();

        $this->Array_Modulos=array();

        $this->parametros['izquierda']='4px';
        $this->parametros['arriba']='98px';
        $this->parametros['ancho']='160px';
        $this->parametros['alto']='0%';
        $this->parametros['titulo']='menu';
        $this->ventana->set_ventana($this->parametros);
    }

    function cargar_cabecera() {
        $ventana=new VENTANA();

        $parametros=array();

        $parametros['izquierda']='0px';
        $parametros['arriba']='69px';
        $parametros['ancho']='160px';
        $parametros['alto']='19px';
        $parametros['titulo']='menu_cabecera';
        $ventana->add_css_param ('background','url()');
        $ventana->add_css_param ('color','#000000');
        $ventana->add_css_param ('font-weight','normal');
        $ventana->add_css_param ('font-size','16px');

        $ventana->add_css_param ('border-bottom','0.5px #111111 solid');
        $ventana->add_css_param ('border-right','0.5px #111111 solid');
        $ventana->add_css_param ('border-top','0.5px #111111 solid');
        $ventana->add_css_param ('border-left','0.5px #111111 solid');

        $ventana->set_ventana($parametros);

        $ventana->generar_css();

        $ventana->abrir();

        echo '<center><a href="#">';
        echo _men_menu;
        echo '</a></center>';

        $ventana->cerrar();
    }

    function cargar_array_modulos() {
        $nombre_usuario=$this->usuario->get_usuario();
        $query=new QUERY;
        $sql="SELECT ele_origen,ele_descripcion,ele_icono
			FROM ad_elemento,ad_permiso_mod,ad_grupo_usuario
			WHERE gus_usu_id= '".$nombre_usuario."'
			AND gus_gru_id = elp_gru_id
			AND elp_ele_id=ele_id			
			AND ele_estado = 'H'				
			ORDER BY ele_orden,ele_tipo,ele_origen";

        $query->consulta($sql);

        for($i=0;$i<$query->num_registros();$i++) {
            list($origen,$descripcion,$icono)=$query->valores_fila();
            $array_aux = array($origen,$descripcion,$icono);
            $this->Array_Modulos[$i] = $array_aux;
        }
    }

    function obtener_array($origen) {
        $array_a = array();
        $tam     = count($this->Array_Modulos);
        for ($i=0; $i < $tam; $i++) {
            if ($this->Array_Modulos[$i][0]==$origen)
                $array_a[] = $this->Array_Modulos[$i];
        }
        return $array_a;
    }



    function cargar_pie() {
        $ventana=new VENTANA();

        $parametros=array();

        $parametros['izquierda']='0px';
        $parametros['arriba']='350px';
        $parametros['ancho']='16.6%';
        $parametros['alto']='19px';
        $parametros['titulo']='menu_pie';
        $ventana->add_css_param ('background','url('._url.'/graficos/fondo.png) repeat-x');
        $ventana->set_ventana($parametros);
        $ventana->abrir();
        $ventana->cerrar();
    }

    function dibujar() {
        $this->ventana->abrir();
        $this->cargar_menu_sesion();
        $this->ventana->cerrar();
    }

    function cargar_menu_sesion() {
        if ($this->usuario->sesion->sesion->existe_variable('menu')) {
            $menu = $this->usuario->sesion->get_variable_sesion('menu');
            echo $menu;
        }
        else {
            $menu = $this->cargar_menu();
            $this->usuario->sesion->set_variable_sesion('menu',$menu);
            echo $menu;
        }
    }

    function cargar_menu() {
        $menu_cad="";
        $menu_cad.='<script language="JavaScript">';
        $menu_cad.="var MenuPrincipal = [";
        $this->cargar_array_modulos();
        $array_principal = $this->obtener_array("/");
        $tam = count($array_principal);
        for($i=0;$i < $tam;$i++) {
            if(trim($array_principal[$i][2])<>'') {
                $imagen="'"._url."/graficos/".$array_principal[$i][2]."'";
            }
            else {
                $imagen="'"._url."/graficos/doc.png'";
            }
            //echo $array_principal[$i][1];exit;
            if ((($array_principal[$i][1]  != "deudas") and
                            ($array_principal[$i][1]  != "pagos") and
                            ($array_principal[$i][1]  != "bol_ins") and
                            ($array_principal[$i][1]  != "login") and
                            ($array_principal[$i][1]  != "horario") and
                            ($array_principal[$i][1]  != "not_hst") and
                            ($array_principal[$i][1]  != "not_act") and
                            ($array_principal[$i][1]  != "inscripcion") and
                            ($array_principal[$i][1]  != "pensum")) or
                    (($_SESSION['grupo'] == 'ALU'))) {
                $menu_cad.=" ,[".$imagen.",'".constant('_men_'.$array_principal[$i][1])."','javascript:cargar_menu("."\"contenido\",\"contenidoajax.php?mod_id=".$array_principal[$i][1]."\")','_self','".$array_principal[$i][1]."'";
                $origen=$array_principal[$i][1].'/';

                $this->cargar_submenu($menu_cad,$origen);

                $menu_cad.="]";
            }
        }

        $menu_cad.= "			   ];";
        $menu_cad.= '</script>';
        $menu_cad.= '<div id="menuapp">';
        $menu_cad.= '</div>';
        $menu_cad.= '<script language="JavaScript">';
        $menu_cad.= "cmDraw ('menuapp', MenuPrincipal, 'hbr', cmThemeOffice, 'ThemeOffice', '"._url."/graficos/iconos/Icon_174.ico');";
        $menu_cad.= '</script>';
        return $menu_cad;
    }

    function cargar_submenu(&$menu_cad,$nombre) {
        $array_secundario = $this->obtener_array($nombre);
        $tam = count($array_secundario);
        for($i=0;$i < $tam;$i++) {
            if(trim($array_secundario[$i][2])<>'') {
                $imagen="'"._url."/graficos/".$array_secundario[$i][2]."'";
            }
            else {
                $imagen="'"._url."/graficos/addedit.png'";
            }

            $menu_cad.=    " ,[".$imagen.",'".constant('_men_'.$array_secundario[$i][1])."','javascript:cargar_menu("."\"contenido\",\"contenidoajax.php?mod_id=".$array_secundario[$i][1]."\")','_self','".$array_secundario[$i][1]."'";

            $origen=$array_secundario[$i][1].'/';

            $this->cargar_submenu($menu_cad,$origen);

            $menu_cad.=    "]";
        }
    }
}
?>
