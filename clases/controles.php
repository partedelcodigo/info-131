<?php
@header("Content-Type: text/html; charset=utf-8");
require_once("clases/control.php");
require_once("clases/control/area_texto.php");
require_once("clases/control/etiqueta.php");
require_once("clases/control/caja_texto.php");
require_once("clases/control/caja_generica.php");
require_once("clases/control/caja_codigo.php");
require_once("clases/control/caja_oculta.php");
require_once("clases/control/caja_tiqueo.php");
require_once("clases/control/calendario.php");
require_once("clases/control/calendario_combo.php");
require_once("clases/control/combo.php");
require_once("clases/control/combo_enlazado.php");
require_once("clases/control/combo_onchange.php");
require_once("clases/control/ventana_emergente.php");
require_once("clases/control/ventana_emergente2.php");
require_once("clases/control/casilla.php");
require_once("clases/control/hora_combo.php");
require_once("define/config_control.php");
require_once("clases/control/upload_file.php");
/*
 * caja de texto oculta			7	--> 0 
 * caja de texto 					--> 1
 * calendario 						--> 2
 * area de texto 					--> 3
 * check box 						--> 4
 * combo box 						--> 5
 * caja de texto password 			--> 6
 * radio button 					--> 7
 * check box varias opciones 		--> 8
 * ventana emergente 				--> 9
 * tipo numerico 					--> 10
 * tipo real 						--> 11
 * calendario combo 				--> 12
 * mail 							--> 13
 * caja_generica 					--> 14 +
 * etiqueta 						--> 15
 * combo onchange					--> 17 
 * comboenlazado 					--> 20
 * combo hora						--> 21
 */

class CONTROLES {

    /**
     * @var nombre : nombre del control
     */
    var $nombre;

    /**
     * @var cant_car : cantidad maxima de caracteres para el control
     */
    var $cant_caracteres;

    /**
     * @var tamaño
     */
    var $tamano;

    /**
     * @var permiso : permiso para el control [0=no requerido,1=requerido,2=solo lectura]
     */
    var $permiso;

    /**
     * @var exp_regular : expresion regular de validacion colocar en vacio de no ser requerida
     */
    var $exp_regular;

    /**
     * @var clase_css : id o clase para la carga del css
     */
    var $clase_css;

    /**
     * @var defecto : valor por defecto del control
     */
    var $defecto;

    /**
     * @var tipo : tipo de CONTROL (Guiado por numeros)
     */
    var $tipo;

    /**
     * @var mensaje : texto referente al control
     */
    var $mensaje;

    /**
     * @var columnas
     */
    var $columnas;

    /**
     * @var filas
     */
    var $filas;

    /**
     * @var arreglo valores : para algunos controles se utiliza este atributo (p.e. combos)
     */
    var $arreglo_valores;

    /**
     * @var arreglo mensajes : para algunos controles se utiliza este atributo (p.e. combos)
     */
    var $arreglo_mensajes;

    /**
     * @var tabla
     */
    var $tabla;

    /**
     * @var formulario : variable referente al nombre del formulario (uso de algunos controles)
     */
    var $formulario;

    /**
     * @var modulo : nombre del modulo
     */
    var $modulo;

    /**
     * @var all-rest : referentes a los controles asignados y creados
     */
    var $etiqueta;
    var $caja_texto;
    var $calendario;
    var $calendario_combo;
    var $ventana_emergente;
    var $ventana_emergente2;
    var $caja_oculta;
    var $area;
    var $codigo;
    var $tiqueo;
    var $combo;
    var $combo_enlazado;
    var $casilla;
    var $caja_generica;
    var $combochange;
    var $horacombo;
    
    /**
     * Variable para generar upload file 
     */
    private $uploadFile;

    /**
     * @function CONSTRUCTOR (instancia a los controles para su uso)
     */
    function CONTROLES() {
        /*
          $this->etiqueta = new ETIQUETA;
          $this->caja_texto = new CAJA_TEXTO;
          $this->calendario = new CALENDARIO;
          $this->calendario_combo = new CALENDARIO_COMBO;
          $this->area = new AREA_TEXTO;
          $this->codigo = new CAJA_CODIGO;
          $this->tiqueo = new CAJA_TIQUEO;
          $this->combo = new COMBO;
          $this->combo_enlazado = new COMBO_ENLAZADO;
          $this->casilla = new CASILLA;
          $this->caja_oculta = new CAJA_OCULTA;
          $this->ventana_emergente = new VENTANA_EMERGENTE;
          $this->ventana_emergente2= new VENTANA_EMERGENTE2;
          $this->caja_generica = new CAJA_GENERICA;
          $this->combochange=new COMBO_ONCHANGE;
          $this->horacombo=new HORA_COMBO;
         */
    }

    /**
     * @function valido
     * @param obj (control correspondiente)
     * @return objeto verificado
     */
    function valido($obj) {
        return $obj->verificar();
    }

    /**
     * @function cargar parametros referenciando sus atributos de cada control
     */
    function cargar_parametros($parametros) {
        $this->nombre = $parametros['nombre'];
        $this->cant_caracteres = $parametros['cant_caracteres'];
        $this->tamano = $parametros['tamano'];
        $this->permiso = $parametros['permiso'];
        $this->exp_regular = $this->expresion_regular($parametros['tipo']);
        $this->clase_css = (isset($parametros['css'])) ? $parametros['css'] : '';
        $this->defecto = (isset($parametros['defecto'])) ? $parametros['defecto'] : '';
        $this->tipo = $parametros['tipo'];
        $this->tip = (isset($parametros['tip'])) ? $parametros['tip'] : '';
        $this->mensaje = (isset($parametros['mensaje'])) ? $parametros['mensaje'] : '';
        $this->columnas = (isset($parametros['columnas'])) ? $parametros['columnas'] : '';
        $this->filas = (isset($parametros['filas'])) ? $parametros['filas'] : '';
        $this->arreglo_valores = (isset($parametros['arreglo_valores'])) ? $parametros['arreglo_valores'] : '';
        $this->arreglo_mensajes = (isset($parametros['arreglo_mensajes'])) ? $parametros['arreglo_mensajes'] : '';
        $this->tabla = (isset($parametros['tabla'])) ? $parametros['tabla'] : '';
        $this->formulario = (isset($parametros['formulario'])) ? $parametros['formulario'] : '';
        $this->modulo = (isset($parametros['modulo'])) ? $parametros['modulo'] : '';
        $this->cargar_control();
    }

    /**
     * @function expresion regular (validador de expresiones regulares)
     * @param tipo de acuerdo al control
     * @return tipo de expresion regular segun el control
     */
    function expresion_regular($tipo) {
        switch ($tipo) {
            /* solo texto */
            case 1:
                $exp = '^[A-Za-z][a-zA-Z .]*$';
                break;
            /* solo numeros */
            case 10:
                $exp = '^[0-9][0-9]*$';
                break;
            /* solo reales */
            case 11:
                $exp = '^[0-9]+([.]{0,1})[0-9]*$';
                break;
            /* solo calendario */
            /* case 12:
              {
              $exp='^[0-9][0-9][0-9][0-9]-([0][1-9]|[1][0-2])-[0-3][0-9]$';
              break;
              } */
            /* solo mail's */
            case 13:
                $exp = '^([a-z0-9_.])+@(([a-z0-9_]|-)+.)+[a-z]{2,4}$';
                break;
            /* por defecto (pa cualquier control no referenciado) */
            default:
                $exp = '';
                break;
        }
        return $exp;
    }

    /**
     * @function asignar valor a control
     * @param valor del control
     */
    function set_valor($valor) {
        $this->defecto = $valor;
        $this->cargar_control();
    }

    /**
     * @function asignar permiso a control
     * @param permiso
     */
    function set_permiso($permiso) {
        $this->permiso = $permiso;
        $this->cargar_control();
    }

    /**
     * @function cargar control
     */
    function cargar_control() {


        switch ($this->tipo) {
            /* caja de texto oculta */
            case 0:
                $this->caja_oculta = new CAJA_OCULTA;
                //$this->caja_oculta->cargar_parametros($this->mensaje,$this->nombre,$this->cant_caracteres,$this->tamano,$this->permiso,$this->exp_regular,$this->clase_css,$this->defecto);
                $this->caja_oculta->cargar_parametros($this->nombre, $this->clase_css, $this->defecto);
                break;

            /* caja de texto */
            case 1:
                $this->caja_texto = new CAJA_TEXTO;
                $this->caja_texto->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* calendario */
            case 2:
                $this->calendario = new CALENDARIO;
                $this->calendario->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* area de texto */
            case 3:
                $this->area = new AREA_TEXTO;
                $this->area->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->filas, $this->columnas, $this->permiso, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* check box */
            case 4:
                $this->tiqueo = new CAJA_TIQUEO;
                $this->tiqueo->cargar_parametros($this->mensaje, $this->nombre, $this->permiso, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* combo box */
            case 5:
                $this->combo = new COMBO;
                $this->combo->cargar_parametros($this->mensaje, $this->nombre, $this->permiso, $this->clase_css, $this->defecto, $this->arreglo_valores, $this->arreglo_mensajes, $this->tip);
                break;
            /* caja de texto password */
            case 6:
                $this->codigo = new CAJA_CODIGO;
                $this->codigo->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->tip);
                break;
            /* radio button */
            case 7:
                $this->casilla = new CASILLA;
                $this->casilla->cargar_parametros($this->mensaje, $this->nombre, $this->permiso, $this->clase_css, $this->defecto, $this->arreglo_valores, $this->arreglo_mensajes, $this->tip);
                break;
            /* check box varias opciones */
            case 8:
                ##checkbox con varias opciones
                break;
            /* ventana emergente */
            case 9:
                $this->ventana_emergente = new VENTANA_EMERGENTE;
                $this->ventana_emergente->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->arreglo_valores, $this->modulo, $this->formulario, $this->tip);
                break;
            /* tipo numerico */
            case 10:
                $this->caja_texto = new CAJA_TEXTO;
                $this->caja_texto->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* tipo real */
            case 11:
                $this->caja_texto = new CAJA_TEXTO;
                $this->caja_texto->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto);
                break;
            /* calendario combo */
            case 12:
                $this->calendario_combo = new CALENDARIO_COMBO;
                $this->calendario_combo->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* mail */
            case 13:
                $this->caja_texto = new CAJA_TEXTO;
                $this->caja_texto->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto);
                break;
            /* caja_generica */
            case 14:
                $this->caja_generica = new CAJA_GENERICA;
                $this->caja_generica->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* etiqueta */
            case 15:
                $this->etiqueta = new ETIQUETA;
                $this->etiqueta->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
            /* ventana emergente2 */
            case 16:
                $this->ventana_emergente2 = new VENTANA_EMERGENTE2;
                $this->ventana_emergente2->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->arreglo_valores, $this->modulo, $this->formulario);
                break;
            /* combo onchange */
            case 17:
                $this->combochange = new COMBO_ONCHANGE;
                $this->combochange->cargar_parametros($this->mensaje, $this->nombre, $this->permiso, $this->clase_css, $this->defecto, $this->arreglo_valores, $this->arreglo_mensajes, $this->formulario, $this->tip);
                break;
            /* comboenlazado */
            case 20:
                $this->combo_enlazado = new COMBO_ENLAZADO;
                $this->combo_enlazado->cargar_parametros($this->mensaje, $this->nombre, $this->permiso, $this->clase_css, $this->defecto, $this->arreglo_valores, $this->arreglo_mensajes, $this->formulario);
                break;
            /* hora combo */
            case 21:
                $this->horacombo = new HORA_COMBO;
                $this->horacombo->cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
            
            /* upload file */
            case 22:
                $this -> uploadFile = new upload_file;
                $this -> uploadFile -> cargar_parametros($this->mensaje, $this->nombre, $this->cant_caracteres, $this->tamano, $this->permiso, $this->exp_regular, $this->clase_css, $this->defecto, $this->tip);
                break;
        }
    }

    /**
     * @function control valido
     * @return valido (tipo bool)
     */
    function control_valido() {
        $valido = false;
        switch ($this->tipo) {
            /* caja de texto oculta */
            case 0:
                $valido = $this->valido($this->caja_oculta);
                break;
            /* caja de texto */
            case 1:
                $valido = $this->valido($this->caja_texto);
                break;
            /* calendario */
            case 2:
                $valido = $this->valido($this->calendario);
                break;
            /* area de texto */
            case 3:
                $valido = $this->valido($this->area);
                break;
            /* check box */
            case 4:
                $valido = $this->valido($this->tiqueo);
                break;
            /* combo box */
            case 5:
                $valido = $this->valido($this->combo);
                break;
            /* caja de texto password */
            case 6:
                $valido = $this->valido($this->codigo);
                break;
            /* radio button */
            case 7:
                $valido = $this->valido($this->casilla);
                break;
            /*  check box varias opciones */
            case 8:
                ##checkbox con varias opciones
                break;
            /* ventana emergente */
            case 9:
                $valido = $this->valido($this->ventana_emergente);
                break;
            /* tipo numerico */
            case 10:
                $valido = $this->valido($this->caja_texto);
                break;
            /* tipo real */
            case 11:
                $valido = $this->valido($this->caja_texto);
                break;
            /* calendario combo */
            case 12:
                $valido = $this->valido($this->calendario_combo);
                break;
            /* 	mail */
            case 13:
                $valido = $this->valido($this->caja_texto);
                break;
            /* caja_generica */
            case 14:
                $valido = $this->valido($this->caja_generica);
                break;
            /* etiqueta */
            case 15:
                $valido = $this->valido($this->etiqueta);
                break;
            /* ventana emergente */
            case 16:
                $valido = $this->valido($this->ventana_emergente2);
                break;
            /* combo onchange */
            case 17:
                $valido = $this->valido($this->combochange);
                break;
            /* comboenlazado */
            case 20:
                $valido = $this->valido($this->combo_enlazado);
                break;
            /* hora combo */
            case 21:
                $valido = $this->valido($this->horacombo);
                break;  
            
            /* upload file */
            case 22:
                $valido = $this->valido($this->caja_texto);
                break;
        }
        /* echo '<script>alert("'.$valido.'---'.$this->valor.'")</script>'; */
        if ($valido <> 1) {
            $valido = false;
        } else {
            $valido = true;
        }
        return $valido;
    }

    /**
     * @function dibujar control
     */
    function dibujar_control() {
        switch ($this->tipo) {
            /* caja de texto oculta */
            case 0: {
                    $this->caja_oculta->dibujar();
                    break;
                }
            /* caja de texto */
            case 1: {
                    $this->caja_texto->dibujar();
                    break;
                }
            /* calendario */
            case 2: {
                    $this->calendario->dibujar();
                    break;
                }
            /* area de texto */
            case 3: {
                    $this->area->dibujar();
                    break;
                }
            /* check box */
            case 4: {
                    $this->tiqueo->dibujar();
                    break;
                }
            /* combo box */
            case 5: {
                    $this->combo->dibujar();
                    break;
                }
            /* caja de texto password */
            case 6: {
                    $this->codigo->dibujar();
                    break;
                }
            /* radio button */
            case 7: {
                    $this->casilla->dibujar();
                    break;
                }
            /* check box varias opciones */
            case 8: {
                    ##checkbox con varias opciones
                    break;
                }
            /* ventana emergente */
            case 9: {
                    $this->ventana_emergente->dibujar();
                    break;
                }
            /* tipo numerico */
            case 10: {
                    $this->caja_texto->dibujar();
                    break;
                }
            /* tipo real */
            case 11: {
                    $this->caja_texto->dibujar();
                    break;
                }
            /* calendario combo */
            case 12: {
                    $this->calendario_combo->dibujar();
                    break;
                }
            /* mail */
            case 13: {
                    $this->caja_texto->dibujar();
                    break;
                }
            /* caja_generica */
            case 14: {
                    $this->caja_generica->dibujar();
                    break;
                }
            /* etiqueta */
            case 15: {
                    $this->etiqueta->dibujar();
                    break;
                }
            /* ventana emergente */
            case 16: {
                    $this->ventana_emergente2->dibujar();
                    break;
                }
            /* combo onchange */
            case 17: {
                    $this->combochange->dibujar();
                    break;
                }
            /* comboenlazado */
            case 20: {
                    $this->combo_enlazado->dibujar();
                    break;
                }
            /* calendario combo */
            case 21: {
                    $this->horacombo->dibujar();
                    break;
                }
                
            /* upload file */
            case 22: 
                $this -> uploadFile -> dibujar();
                break;
        }
    }

    /**
     * @function cargar valor al control
     * @return valor
     */
    function get_valor_control() {
        $valor = '';
        switch ($this->tipo) {
            /* caja de texto oculta */
            case 0: {
                    $valor = $this->caja_oculta->get_valor();
                    break;
                }
            /* caja de texto */
            case 1: {
                    $valor = $this->caja_texto->get_valor();
                    break;
                }
            /* calendario */
            case 2: {
                    $valor = $this->calendario->get_valor();
                    break;
                }
            /* area de texto */
            case 3: {
                    $valor = $this->area->get_valor();
                    break;
                }
            /* check box */
            case 4: {
                    $valor = $this->tiqueo->get_valor();
                    break;
                }
            /* combo box */
            case 5: {
                    $valor = $this->combo->get_valor();
                    break;
                }
            /* caja de texto password */
            case 6: {
                    $valor = $this->codigo->get_valor();
                    break;
                }
            /* radio button */
            case 7: {
                    $valor = $this->casilla->get_valor();
                    break;
                }
            /* check box varias opciones */
            case 8: {
                    ##checkbox con varias opciones
                    break;
                }
            /* ventana emergente */
            case 9: {
                    $valor = $this->ventana_emergente->get_valor();
                    break;
                }
            /* tipo numerico */
            case 10: {
                    $valor = $this->caja_texto->get_valor();
                    break;
                }
            /* tipo real */
            case 11: {
                    $valor = $this->caja_texto->get_valor();
                    break;
                }
            /* calendario combo */
            case 12: {
                    $valor = $this->calendario_combo->get_valor();
                    break;
                }
            /* mail */
            case 13: {
                    $valor = $this->caja_texto->get_valor();
                    break;
                }
            /* caja_generica */
            case 14: {
                    $valor = $this->caja_generica->get_valor();
                    break;
                }
            /* etiqueta */
            case 15: {
                    $valor = $this->etiqueta->get_valor();
                    break;
                }
            /* ventana emergente */
            case 16: {
                    $valor = $this->ventana_emergente2->get_valor();
                    break;
                }
            /* combo onchange */
            case 17: {
                    $valor = $this->combochange->get_valor();
                    break;
                }
            /* combo enlazado */
            case 20: {
                    $valor = $this->combo_enlazado->get_valor();
                    break;
                }
            /* calendario combo */
            case 21: {
                    $valor = $this->horacombo->get_valor();
                    break;
                }
                
            /* upload file */
            case 22:
                $valor = $this -> uploadFile -> get_valor();
                break;
        }
        return $valor;
    }

}
?>