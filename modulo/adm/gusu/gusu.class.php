<?php
class GUSU {
    function ingresar() {
        require_once("clases/formulario.php");
        $f=new FORMULARIO();
        $f->inicializa("gusu",_gusu_titulo, array("ad_grupo_usuario"), "form",_msg_comp, "100%");
        $valores[0]= array(_gusu_gru_id,_gusu_usu_id);
        $valores[1]= array("ad_grupo_usuario.gus_gru_id","ad_grupo_usuario.gus_usu_id");
        $valores[2]= array("15","40");
        $valores[3]= array("5","9");
        $valores[4]= array("1","1");
        //$sql1="select gru_id,gru_obs from ad_grupo order by gru_obs";
        $sql1="select gru_id,gru_id from ad_grupo order by gru_id";
        $valores[5]= array($sql1,"");
        $valores[6]= array("","usuario");
        $valores[9]= array("index.php?mod_id=gusu");
        $f->cargar_valores($valores);

        $f->mostrar_formulario();

    }

    function modificar() {

        require_once("clases/formulario.php");
        $f=new FORMULARIO();
        $f->inicializa("gusu",_gusu_titulo, array("ad_grupo_usuario"), "form",_msg_comp,"100%");

        $valores[0]= array(_gusu_gru_id,_gusu_usu_id);
        $valores[1]= array("ad_grupo_usuario.gus_gru_id","ad_grupo_usuario.gus_usu_id");
        $valores[2]= array("15","40");
        $valores[3]= array("5","1");
        $valores[4]= array("1","1");
        $sql1="SELECT gru_id,gru_id FROM ad_grupo order by gru_obs";
        $ventana_conf='';
        $valores[5]= array($sql1,$ventana_conf);
        $valores[6]= array("","personal");
        $valores[9]= array("index.php?mod_id=gusu");
        $f->cargar_valores($valores);
        $f->mostrar_formulario(1);


    }

    function busqueda() {
        require_once("clases/busqueda.php");
        $b=new BUSQUEDA();
        $b->inicializa("gusu",_gusu_titulo, "ad_grupo_usuario", "form", "100%", "gus_id");
        $valores[0]= array(_gusu_gru_id,_gusu_usu_id);
        $valores[1]= array("gus_gru_id","gus_usu_id");
        $valores[2]= array("20","20");
        $valores[3]= array("5","1");
        $sql1="select gru_id,gru_id from ad_grupo";
        //$valores['COMBO_ORDER']="gru_obs"; // ordenar combo
        $valores[5]= array($sql1,"");
        $valores['order']= array("1","0");
        $b->cargar_parametros($valores);
        $b->mostrar_busqueda();
    }

    function eliminar() {
        require_once("clases/formulario.php");
        $formu=new FORMULARIO();
        $formu->inicializa("gusu",_gusu_titulo, array("ad_grupo_usuario"), "form", _msg_comp, "100%");
        $formu->eliminar_formulario();
    }

    function ver() {  //echo "aqui"; exit;
        require_once("clases/formulario.php");
        $f=new FORMULARIO();
        $f->inicializa("gusu",_gusu_titulo,array("ad_grupo_usuario") , "form", _msg_comp, "100%");
        //$this->valores[0]=array(*);

        //$this->valores[25]=array();

        $valores[0]= array(_gusu_gru_id,_gusu_usu_id);
        $valores[1]= array("ad_grupo_usuario.gus_gru_id","ad_grupo_usuario.gus_usu_id");
        $valores[2]= array("20","20");
        $valores[3]= array("1","14");
        $valores[4]= array("1","1");
        $sql1="select gus_gru_id,gus_usu_id from ad_grupo_usuario";
        $valores[5]= array($sql1,"");
        $valores[6]= array("","usuario");
        $valores[9]= array("index.php?mod_id=gusu");

        $f->cargar_valores($valores);

        $f->ver_formulario();

    }

};
?>