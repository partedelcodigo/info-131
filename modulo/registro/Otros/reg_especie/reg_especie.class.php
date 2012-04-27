<?php

class RegEspecie {

    var $codigo;

    function RegEspecie() {
        
    }

    function ingresar() {
        require_once("clases/formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa("reg_especie", _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("ba_especie.esp_nombre", "ba_especie.esp_descripcion");//alias porque a veces se hace join
        $valores[2] = array( "50", "60");
        $valores[3] = array( "14", "3");
        $valores[4] = array( "1", "0");
        $valores[5] = array("", "");
        $valores[9] = array("index.php?mod_id=reg_especie");
        $formz->cargar_valores($valores);
        $formz->mostrar_formulario();
    }

    function modificar() {
        require_once("clases/formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa("reg_especie", _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("ba_especie.esp_nombre", "ba_especie.esp_descripcion");//alias porque a veces se hace join
        $valores[2] = array("50", "60");
        $valores[3] = array("14", "3");
        $valores[4] = array("1", "0");
        $valores[5] = array("", "");
        $valores[9] = array("index.php?mod_id=reg_especie");
        $formz->cargar_valores($valores);
        $formz->mostrar_formulario(1);//nica variante bandera
    }

    function ver() {
        require_once("clases/formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa("reg_especie", _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("ba_especie.esp_nombre", "ba_especie.esp_descripcion");//alias porque a veces se hace join
        $valores[2] = array("50", "60");
        $valores[3] = array("14", "3");
        $valores[4] = array("1", "0");
        $valores[5] = array("", "");
        $valores[9] = array("index.php?mod_id=reg_especie");
        $formz->cargar_valores($valores);
        $formz->ver_formulario();
    }

    function eliminar() {
        require_once("clases/formulario.php");
        $formu = new FORMULARIO();
        $tabla = array('ba_especie');
        $formu->inicializa("reg_especie", "eliminado", $tabla, "form", "", "100%");
        $formu->eliminar_formulario();
        $valores[9] = array("index.php?mod_id=reg_especie");
    }

    function busqueda() {
        require_once("clases/busqueda.php");
        $b = new BUSQUEDA();
        $b->inicializa("reg_especie", _reg_especie_bus_titulo, "ba_especie", "form", "99%", "esp_id");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);
        $valores[1] = array("esp_nombre", "esp_descripcion");
        $valores[2] = array("30", "50");
        $valores[3] = array("1", "1");
        $valores[5] = array("", "");
        $b->cargar_parametros($valores);
        $b->mostrar_busqueda();
    }

}

;
?>