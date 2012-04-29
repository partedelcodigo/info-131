<?php

class TabTest {

    var $codigo;

    function TabTest() {
        //este es lo mismo que constructor
    }

    function ingresar() {
        require_once("clases/formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa("tab_test", _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $valores[0] = array("campo1","campo2","campo3","campo4","campo5","campo6","campo7","campo8","campo9","campo10","campo11","campo12","campo13","campo14","campo15","campo16","campo17","campo18","campo19");
        $valores[1] = array("campo1","campo2","campo3","campo4","campo5","campo6","campo7","campo8","campo9","campo10","campo11","campo12","campo13","campo14","campo15","campo16","campo17","campo18","campo19");//alias porque a veces se hace join Campo TABLA
        $valores[2] = array( "50","50","50","50", "60", "60","50","50","50","50", "60", "60","50","50","50", "60", "60");
        $valores[3] = array( "1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
        $valores[4] = array( "1", "0","1", "0","1", "0","1", "0","1", "0","1", "0","1", "0", "0","1", "0","1", "0");
        $sql="select * from ba_especie";
        $radio=array(0=>"NO",0=>"Si");
        $valores[5] = array("", "", "", "",$sql,"",array('valorradio'=>$radio));
        $valores[9] = array("index.php?mod_id=reg_especie");//significa redirect
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
        $formz->mostrar_formulario(1);//mismo que ingresar solo diferencia bandera para edit
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
        $formz->ver_formulario();//aqui funcion es ver no mostrar
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
        //llamada a clase busqueda
        require_once("clases/busqueda.php");
        //declaracion busqueda
        $b = new BUSQUEDA();
        //c1-nombre modulo
        //c2-as
        //c3-titulo a mostrar, se pone como variable que se recoje de lenguaje
        //c4-tabla, nombre de la tabla a rescatar
        //c5-nombre form
        //c6-tamano de form ancho
        //c7-id de la tabla
        $b->inicializa("tab_test", _reg_especie_bus_titulo, "ba_especie", "form", "99%", "esp_id");
        $valores[0] = array(_reg_especie_nom, _reg_especie_des);//titulos de campos
        $valores[1] = array("esp_nombre", "esp_descripcion");//nombres de campos en tabla
        $valores[2] = array("30", "50");//ancho comp en caso cajas u otros
        $valores[3] = array("1", "1");//tipo comp
        $valores[5] = array("", "");//en caso de combo aca rescata relacion con sql
        $b->cargar_parametros($valores);//carga de array
        $b->mostrar_busqueda();//construye form
    }

}
?>