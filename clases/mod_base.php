<?php

class ModBase {

    var $codigo;
    var $nombreModulo;
    
    public function __construct() {
        $this->nombreModulo="mod_calidad";
    }

    public function ingresar() {
        require_once("formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa_auto($this->nombreModulo);
        $formz->mostrar_formulario();
    }

    public function modificar() {
        require_once("formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa_auto($this->nombreModulo);
        $formz->mostrar_formulario(1);
    }

    public function ver() {
        require_once("formulario.php");
        $formz = new FORMULARIO();
        $formz->inicializa_auto($this->nombreModulo);
        $formz->ver_formulario();
    }

    public  function eliminar() {
        require_once("formulario.php");
        $formu = new FORMULARIO();
        $tabla = array($this->nombreModulo);
        $formu->inicializa($this->nombreModulo, "eliminado", $tabla, "form", "", "100%");
        $formu->eliminar_formulario();
        $valores[9] = array("index.php?mod_id=".$this->nombreModulo);
    }

    public function busqueda() {
        require_once("busqueda.php");
        $b = new BUSQUEDA();
        $b->inicializa_auto($this->nombreModulo);
        $b->mostrar_busqueda();
    }
}
?>