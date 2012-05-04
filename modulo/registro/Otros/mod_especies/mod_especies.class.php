<?php

class ModEspecies {

    var $codigo;

    function ModEspecies() {
        
    }

    function ingresar() {
        require_once("clases/formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa_auto("mod_especies");
        /*$formz->inicializa("reg_especie", _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("ba_especie.esp_nombre", "ba_especie.esp_descripcion");//alias porque a veces se hace join
        $valores[2] = array( "50", "60");
        $valores[3] = array( "14", "3");
        $valores[4] = array( "1", "0");
        $valores[5] = array("", "");
        $valores[9] = array("index.php?mod_id=reg_especie");
        $formz->cargar_valores($valores);*/
        $formz->mostrar_formulario();
    }

    function modificar() {
        require_once("clases/formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa_auto("mod_especies");
        /*$formz->inicializa("reg_especie", _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("ba_especie.esp_nombre", "ba_especie.esp_descripcion");//alias porque a veces se hace join
        $valores[2] = array("50", "60");
        $valores[3] = array("14", "3");
        $valores[4] = array("1", "0");
        $valores[5] = array("", "");
        $valores[9] = array("index.php?mod_id=reg_especie");
        $formz->cargar_valores($valores);*/
        $formz->mostrar_formulario(1);//unica variante bandera
    }

    function ver() {
        require_once("clases/formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa_auto("mod_especies");
        /*$formz->inicializa("reg_especie", _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("ba_especie.esp_nombre", "ba_especie.esp_descripcion");//alias porque a veces se hace join
        $valores[2] = array("50", "60");
        $valores[3] = array("14", "3");
        $valores[4] = array("1", "0");
        $valores[5] = array("", "");
        $valores[9] = array("index.php?mod_id=reg_especie");
        $formz->cargar_valores($valores);*/
        $formz->ver_formulario();
    }

    function eliminar() {
        require_once("clases/formulario.php");
        $formu = new FORMULARIO();
        $tabla = array('mod_especies');
        $formu->inicializa("mod_especies", "eliminado", $tabla, "form", "", "100%");
        $formu->eliminar_formulario();
        $valores[9] = array("index.php?mod_id=mod_especies");
    }

    function busqueda() {
        require_once("clases/busqueda.php");
        $b = new BUSQUEDA();
        $b->inicializa_auto("mod_especies");
        /*$valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("esp_nombre", "esp_descripcion");
        $valores[2] = array("30", "50");
        $valores[3] = array("1", "1");
        $valores[5] = array("", "");*/
        $b->mostrar_busqueda();
    }

}

;
?>