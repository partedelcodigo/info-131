<?php
class PERSONAL {
    function ingresar() {
        if(isset($_POST['tipo'])) {
            $this->validador_personal();
        }

        require_once("modulo/adm/personal/formulario.php");
        $formu=new FORMULARIO();
        $formu->inicializa("personal",_personal_titulo,
                array("gr_persona"), "formulario", _msg_comp, "100%");
        $valores[0]= array(_personal_nombres,_personal_appaterno,_personal_apmaterno,_personal_ci,_personal_direccion,_personal_tefono,_personal_celular,"Habilitado:");
        $valores[1]= array("gr_persona.per_nombres","gr_persona.per_apellidopat","gr_persona.per_apellidomat",
                "gr_persona.per_ci","gr_persona.per_direccion","gr_persona.per_telefono","gr_persona.per_celular","gr_persona.per_estado");
        $valores[2]= array("30","30","30","15","50","15","15","15");
        $valores[3]= array("14","14","14","14","14","14","14","4");
        $valores[4]= array("1","0","0","1","0","0","0","0");
        $valores[9]= array("index.php?mod_id=personal");
        $formu->cargar_valores($valores);
        $formu->mostrar_formulario();
    }

    function validador_personal() {
        $carnet_identidad=$_POST['per_ci'];
        $query_verificar = new QUERY;
        $sql= new SQL;
        $sql->setS(array("per_id"));
        $sql->setF(array("gr_persona"));
        $sql->setW(array("per_ci"),array(" like "),array("'{$_POST['per_ci']}'"));
        $sql->crearSQL();
        $query_verificar->consulta($sql->cadena);
        list($per_id_exist)=$query_verificar->valores_fila();
        if(trim($per_id_exist)<>'') {
            echo "<center>";
            echo "La PERSONA ya fue REGISTRADO(A) anteriormente. <br><br>";
            echo "<input class=boton name=Continuar type=button value='Volver'
			onclick=\"location='index.php?mod_id=personal' \"/><br>";
            echo "</center>";
            exit;
        }
    }

    function modificar() {
        require_once("modulo/adm/personal/formulario.php");
        $formu=new FORMULARIO();
        $formu->inicializa("personal",_personal_titulo,
                array("gr_persona"), "formulario", _msg_comp, "100%");

        $valores[0]= array(_personal_nombres,_personal_appaterno,_personal_apmaterno,_personal_ci,_personal_direccion,_personal_tefono,_personal_celular,"Habilitado:");
        $valores[1]= array("gr_persona.per_nombres","gr_persona.per_apellidopat","gr_persona.per_apellidomat",
                "gr_persona.per_ci","gr_persona.per_direccion","gr_persona.per_telefono","gr_persona.per_celular","gr_persona.per_estado");
        $valores[2]= array("30","30","30","15","50","15","15","15");
        $valores[3]= array("14","14","14","14","14","14","14","4");
        $valores[4]= array("1","0","0","1","0","0","0","0");
       //$valores[0]= array(_personal_nombres,_personal_appaterno,_personal_apmaterno,_personal_ci,_personal_tefono,"Habilitado:");
        //$valores[1]= array("gr_persona.per_nombres","gr_persona.per_apellidopat","gr_persona.per_apellidomat",
        //"gr_persona.per_ci","gr_persona.per_telefono","gr_persona.per_estado");
        //$valores[2]= array("30","30","30","15","15","15");
        //$valores[3]= array("14","14","14","14","14","4");
        //$valores[4]= array("1","0","0","1","0","0");
        $valores[7]= array("0","0","0","0","1","0");
        $valores[9]= array("index.php?mod_id=personal");
        $formu->cargar_valores($valores);
        $formu->mostrar_formulario(1);
    }

    function ver() {
        require_once("modulo/adm/personal/formulario.php");
        $formu=new FORMULARIO();
        $formu->inicializa("personal",_personal_titulo_ver,array("gr_persona"), "formulario", _msg_comp, "100%");

        $valores[0]= array(_personal_nombres,_personal_appaterno,_personal_apmaterno,_personal_ci,_personal_direccion,_personal_tefono,_personal_celular,"Habilitado:");
        $valores[1]= array("gr_persona.per_nombres","gr_persona.per_apellidopat","gr_persona.per_apellidomat",
                "gr_persona.per_ci","gr_persona.per_direccion","gr_persona.per_telefono","gr_persona.per_celular","gr_persona.per_estado");
        $valores[2]= array("30","30","30","15","50","15","15","15");
        $valores[3]= array("14","14","14","14","14","14","14","4");
        //$valores[0]= array(_personal_nombres,_personal_appaterno,_personal_apmaterno,_personal_ci,_personal_tefono,"Habilitado:");
        //$valores[1]= array("gr_persona.per_nombres","gr_persona.per_apellidopat","gr_persona.per_apellidomat",
        //"gr_persona.per_ci","gr_persona.per_telefono","gr_persona.per_estado");
        //$valores[2]= array("30","30","30","15","15","15");
        //$valores[3]= array("14","14","14","14","10","4");
        $formu->cargar_valores($valores);
        $formu->ver_formulario();
    }

    function busqueda() {
        require_once("clases/busqueda.php");
        $busq=new BUSQUEDA();
        $busq->inicializa("personal",_personal_titulo_busqueda, "gr_persona", "formulario", "100%","per_id");
        $valores[0]= array(_personal_ci,_personal_appaterno,_personal_apmaterno,_personal_nombres,_msg_estado);
        $valores[1]= array("per_ci","per_apellidopat","per_apellidomat","per_nombres","per_estado");
        $valores[2]= array("10","20","14","14","3");
        $valores[3]= array("1","1","1","1","5");
        $array=array("valorcombo"=>array('1','0',''),"datocombo"=>array("SI","NO","TODOS"));
        $valores[5]= array("","","","",$array);
        $valores['tipo_bit']= array("0","0","0","0","1");
        $busq->cargar_parametros($valores);
        $busq->mostrar_busqueda();
    }

    function eliminar() {
        $actualizar = new QUERY;
        $act= "update gr_persona set  per_estado ='0' where  per_id  = '".$_GET['id']."'";
        $resulset = $actualizar->consulta($act);
        echo "<center>";
        echo "LA PERSONA  A SIDO DESHABILITADA. <br><br>";
        echo "<input class=boton name=Continuar type=button value='Volver'
		onclick=\"location='index.php?mod_id=personal' \"/><br>";
        echo "</center>";
        exit;
    }

    function busquedae() {
        require_once("clases/busquedae.php");
        $busq=new BUSQUEDAE();
        $busq->inicializa("personal","Busqueda de todo el PERSONAL", "gr_persona", "form", "100%", "per_ci",1);
        $valores[0]= array("C.I.","Nombres","A.Paterno","A. Materno");
        $valores[1]= array("per_ci","per_nombres","per_apellidopat","per_apellidomat");
        $valores[2]= array("10","15","15","15");
        $valores[3]= array("1","1","1","1");
        $valores['where'][1]= array("per_estado='1'");
        $busq->cargar_parametros($valores);
        $busq->mostrar_busqueda();
        echo "<center>";
        echo "<input class=boton name=Ingresar type=button value='"._men_cerrar.
                "' onclick=\"javascript:window.close()\"/><br><br>";
        echo "</center>";
    }
};
?>
