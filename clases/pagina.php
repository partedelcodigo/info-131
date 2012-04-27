<?php

require_once('componentes/cabecera.php');
require_once('componentes/pie_pagina.php');
require_once('componentes/contenido.php');
require_once('componentes/contenidoi.php');
require_once('componentes/barra_navegacion.php');
require_once('componentes/menu.php');
require_once('componentes/barra_configuracion.php');
//require_once('componentes/barra_configuracion1.php');
require_once('componentes/datos_generales.php');
require_once('componentes/cargando.php');
require_once('componentes/logo.php');

class PAGINA {

    var $modulo;
    var $usuario;
    var $cabecera;
    var $pie_pagina;
    var $contenido;
    var $contenidoi;
    var $datos_generales;
    var $menu;
    var $barra;
    var $barra1;
    var $servicios;
    var $cargando;
    var $barra_nav;
    var $certificado;
    var $logo;

    function PAGINA() {
        $this->cabecera = new CABECERA;
        $this->pie_pagina = new PIE_PAGINA;
        $this->datos_generales = new DATOS_GENERALES;
        $this->contenido = new CONTENIDO;
        $this->contenidoi = new CONTENIDOI;
        $this->menu = new MENU;
        $this->barra = new BARRA_CONFIGURACION;
        //$this->barra1 = new BARRA_CONFIGURACION1;
        //$this->servicios = new SERVICIOS;
        $this->usuario = new PERSONA;
        $this->cargando = new CARGANDO;
        $this->barra_nav = new BARRA_NAVEGACION;
        //$this->certificado = new CERTIFICADO;
        $this->logo = new LOGO;

        if (!empty($_GET['mod_id'])) {
            $this->modulo = $_GET['mod_id'];
        } else {
            $this->modulo = 'login';
        }
    }

    function cargar_modulo() {
        $this->dibujar();
    }

    function get_estilo() {
        echo '<link rel="stylesheet" type="text/css" href="css/' . _hoja_estilo . '">';
    }

    function get_cabecera() {
        $this->get_componente($this->cabecera);
    }

    function get_certificado() {
        $this->get_componente($this->certificado);
    }

    function get_logo() {
        $this->get_componente($this->logo);
    }

    function get_cargando() {
        if (trim($this->modulo) <> 'login') {
            $this->get_componente($this->cargando);
        }
    }

    function get_pie_pagina() {
        if (trim($this->modulo) <> 'login') {
            $this->get_componente($this->barra_nav);
            $this->get_componente($this->datos_generales);
        }
    }

    function get_origen($descripcion) {
        if (trim($descripcion) <> '') {
            $query = new QUERY;
            /* reemplazar por el modulo sql */
            $sql1 = new SQL;
            $sql1->setS(array("ele_origen"));
            $sql1->setF(array("ad_elemento"));
            $sql1->setW(array("ele_descripcion"), array(" like "), array("'{$descripcion}'"));
            $sql1->crearSQL();
            $query->consulta($sql1->cadena);
            list($origen) = $query->valores_fila();
            $query->cerrar();
            /*             * verificamos que la cadena '/' exista en la cadena central */
            if (strpos($origen, '/') > 0) {
                $descripcion = substr($origen, 0, strpos($origen, '/'));
            } else {
                $descripcion = '';
            }
            return $this->get_origen($descripcion) . $origen;
            /* 	echo '<script>alert("'.$descripcion.'")</script>';  --->yop */
        } else {
            return '';
        }
    }

    function get_tarea_valida($tarea, $permiso) {
        $valido = false;
        if (trim($tarea) <> '') {
            /*             * Consulta para verificar si alguien posee permiso para una tarea determinada */
            return $this->usuario->permiso_tarea($tarea, $permiso, $this->modulo);
        } else {
            $valido = true;
        }
        return $valido;
    }

    function check_path($dir) {
        if (file_exists($dir)) {
            return true;
        } else {
            return false;
        }
    }

    function get_contenido() {
        if (trim($this->modulo) <> 'login') {
            $this->contenido->ventana->abrir();
            if (trim($this->usuario->get_permisos($this->modulo)) <> '') {
                $tarea = isset($_GET['tarea']) ? $_GET['tarea'] : '';
                if ($this->get_tarea_valida($tarea, $this->usuario->get_permisos($this->modulo))) {
                    $path = _rutaraiz . '/modulo' . $this->get_origen($this->modulo) . $this->modulo . '/' . $this->modulo . '.php';
                    $this->contenido->set_path($path);
                } else {
                    $path = _rutaraiz . '/modulo/negado.php';
                    $this->contenido->set_path($path);
                }
                $this->get_componente($this->contenido);
            } else {
                $path = _rutaraiz . '/modulo/negado.php';
                $this->contenido->set_path($path);
                $this->get_componente($this->contenido);
            }
            $this->contenido->ventana->cerrar();
        } else {
            $path = _rutaraiz . '/modulo/login/login.php';
            $this->contenidoi->set_path($path);
            $this->get_componente($this->contenidoi);
        }
    }

    function get_menu() {
        if (trim($this->modulo) <> 'login') {
            $this->get_componente($this->menu);
        }
    }

    

    function get_servicios() {
        if (trim($this->modulo) <> 'login') {
            //$this->get_componente($this->servicios);
        }
    }

    function get_barra_configuracion() {
        if (trim($this->modulo) <> 'login') {
            $this->get_componente($this->barra);
        }
    }

    function get_barra_configuracion1() {
        if (trim($this->modulo) <> 'login') {
            $this->get_componente($this->barra1);
        }
    }

    function cargar_libs() {
        echo '<script type="text/javascript" language="JavaScript1.2" src="js/apytmenu.js"></script>';
        echo '<script language="javascript" type="text/javascript" src="js/prototype.js"></script>';
        
        echo '<script language="javascript" type="text/javascript" src="js/contenidoajax.js"></script>';
        echo '<script type="text/javascript" language="JavaScript1.2" src="js/config.js"></script>';
        echo '<script type="text/javascript" src="js/calendario.js"></script>';
        echo '<script type="text/javascript" src="js/valida.js"></script>';
        echo '<script type="text/javascript" src="js/eventos.js"></script>';
        // librería para cargar el lenguaje deseado
        echo '<script type="text/javascript" src="js/calendario2.js"></script>';
        // librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código
        echo '<script type="text/javascript" src="js/calendariosetup.js"></script>';
        echo '<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>';
        // librería para jalar valores de una ventana emergente
        echo '<script type="text/javascript" src="js/emergentebusqueda.js"></script>';
        echo '<link rel="stylesheet" type="text/css" media="all" href="css/estilo.css" title="win2k-cold-1" />';
        //GAS 2008-12-10 INI
        echo '<link rel="stylesheet" type="text/css" media="screen" href="css/face.css" />';
        //GAS 2008-12-10 FIN
        echo '<script language="JavaScript" src="js/JSCookMenu.js"></script>';
        echo '<link rel="stylesheet" href="css/theme.css" type="text/css">';
        echo '<link rel="shortcut icon" href="graficos/favicon.ico" />';
        echo '<script language="JavaScript" src="js/theme.js"></script>';
        echo '<script language="Javascript" type="text/javascript" src="js/wz_tooltip.js"></script>';
        echo '<script language="JavaScript" src="js/funciones.js" type="text/javascript"></script>';
        echo '<script language="JavaScript" src="js/cambiar_form_tipo.js" type="text/javascript"></script>';
        echo '<script language="JavaScript" src="js/combo_dinamico.js" type="text/javascript"></script>';
        echo '<link rel="stylesheet" href="css/fich_emp.css" type="text/css" />';
        //libreria para la subida de imagenes
        echo '<script language="JavaScript" src="js/sube.js"></script>';
        echo '<script language="javascript" type="text/javascript" src="js/jscripts/tiny_mce/tiny_mce.js"></script>';

        echo '<script language="javascript" type="text/javascript" src="js/ajax.js"></script>';
    }

    function dibujar() {
        if (!($this->usuario->registrado())) {
            $this->modulo = 'login';
        }
        echo '<html>';
        echo '<head>';
        echo '<title>';
        echo _titulo;
        echo '</title>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
        $this->cargar_libs();
        $this->get_estilo();
        echo '</head>';
        echo '<body>';
        /*         * Cabecera de la Pagina */
        $this->get_cabecera();
        $this->get_cargando();
        /*         * Panel Central */
        $this->get_contenido();
        //$this->comprueba();//scaba backups automatico
        /*         * Barra Menu */
        $this->get_menu();

        
        $this->get_logo();

        $grupo = $this->usuario->get_grupo();
        
        if (($grupo <> 'DOC')) {
            /*             * Barra panel superior derecho */
            $this->get_barra_configuracion();
            /*             * Barra panel inferior derecho */
            if (($grupo <> 'ACD')) {
                //$this->get_servicios();
            }
        }
        if ($grupo == 'DOC') {
            /*             * Barra panel superior derecho */
            //$this->get_barra_configuracion1();
        }

        /*         * Pie de Pagina */
        $this->get_pie_pagina();
        /* echo '<script>alert("'.$grupo.'")</script>'; */

        echo '</body>';
        echo '</html>';
    }

    function get_componente($obj) {
        $obj->dibujar();
    }

    function comprueba() {
        if (!isset($_SESSION['generado'])) {
//funcines que encuentran el ultimo viernes del mes actual para el dump
            $mes = date('m') + 1; //representa el proximo mes
            $ultimo_dia = date('N', mktime(0, 0, 0, $mes, 0, date('Y'))); //rescata el ultimo dia del mes (lunes,martes,...)
            $ultimodia1  = date('d', mktime(0, 0, 0, $mes, 0, date('Y'))); //cantidad de dias del mes
            if ($ultimo_dia < 5) {
                if (date('Y-m-d', mktime(0, 0, 0, $mes, $ultimodia1 - ($ultimo_dia + 2), date('Y'))) == (date('Y-m-d'))) {
                    $this->genera_backup();
                }
            } else {
                if (date('Y-m-d', mktime(0, 0, 0, $mes, $ultimodia1 - ($ultimo_dia - 5), date('Y'))) == (date('Y-m-d'))) {
                    $this->genera_backup();
                }
            }
            //$this->genera_backup();
        }
    }

    function genera_backup() {
        $d = dir('backup');
        $sw = 1;
        while (false !== ($entry = $d->read())) {
            if ($entry != "." and $entry != ".." and (ereg(".bz2$", $entry) or ereg(".gz$", $entry) or ereg(".sql$", $entry))) {
                $mtime = date("Y-m-d", filemtime('backup' . "/" . $entry));
                if ($mtime == date('Y-m-d'))
                    $sw = 0;
            }
        }
        if ($sw) {//solo por esta opcion crea un backup
            //echo 'generando';
            require_once 'modulo/backups/backups.class.php';
            $b = new BACK;
            $b->generate_back();
            $_SESSION['generado'] = 1;
        }
        //echo '--->'.$sw;
        //aca debemos comprobar si ya existe un backup del dia si es asi no se genera uno caso contrario se saca backup
    }

}

;
?>