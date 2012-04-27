<?php
class USUARIO {
    var $tabla;
    var $valores;
    var $valores1;

    function USUARIO() {
        $this->tabla = array('ad_usuario');
        $this->valores1[0]= array(_usu_per_id,_usu_id,_usu_password,_msg_estado);
        $this->valores1[1]= array("ad_usuario.usu_per_id","ad_usuario.usu_id","ad_usuario.usu_password","ad_usuario.usu_estado");
        $this->valores1[2]= array("50","15","40","4");
        $this->valores1[3]= array("9","14","6","7");
        $this->valores1[4]= array("0","1","0","0");
        //$ventana_conf=array("per_nombres","per_apellidopat","per_apellidomat","gr_persona");
        $val_radio=array('valorradio'=>array("1","0"),'datoradio'=>array("Si","No"));
        $this->valores1[5]= array("","","",$val_radio);
        $this->valores1[9]= array("index.php?mod_id=usuario");
        $this->valores1[6]= array("personal","","","");
        $this->valores1[7]= array("","","","","1");

        // Desde aqui es la modificacion y la visualizacion
        $this->valores[0]= array(_usu_per_id,_usu_id,_msg_estado);
        $this->valores[1]= array("ad_usuario.usu_per_id","ad_usuario.usu_id","ad_usuario.usu_estado");
        $this->valores[2]= array("50","15","4");
        $this->valores[3]= array("9","14","7");
        $this->valores[4]= array("1","1","0");
        $ventana_conf=array("per_nombres","per_apellidopat","per_apellidomat","gr_persona");
        $val_radio=array('valorradio'=>array("1","0"),'datoradio'=>array("Si","No"));
        $this->valores[5]= array($ventana_conf,"",$val_radio);
        $this->valores[9]= array("index.php?mod_id=usuario");
        $this->valores[6]= array("personal","","");
        $this->valores[7]= array("","","1");
        $this->valores[25]=array("Codigo de Persona","Codigo de Usuario","Estado del Usuario");
    }

    function ingresar() {
        if(isset($_POST['tipo'])) {
            $query_change = new QUERY;
            $sentencia = "select per_id
							from gr_persona
							where per_ci  = '".$_POST['usu_per_id']."'";
            $resultado=$query_change->consulta($sentencia);
            list($usu_per_id_base)=$query_change->valores_fila();
            // verificamos si el administrador ya esta registrado
            $query_ver = new QUERY;
            $sentencia = "select usu_id
							from ad_usuario
							where  usu_per_id = '".$usu_per_id_base."'";
            $resultado=$query_ver->consulta($sentencia);
            list($usu_per_id_exist)=$query_ver->valores_fila();
            if(trim($usu_per_id_exist)<>'') {
                echo "<center>";
                echo "Este USUARIO ya se encuentra REGISTRADO. <br> Volver a Registrarlo<br>";
                echo "<input class=boton name=Continuar type=button value='Volver' onclick=\"location='index.php?mod_id=usuario' \"/><br>";
                echo "</center>";
                //exit;
            }
            $_POST['usu_per_id']= $usu_per_id_base;
        }
        require_once("clases/formulario.php");
        $tablas=array('ad_usuario');
        $f=new FORMULARIO();
        $f->inicializa("usuario",_usu_titulo,$this->tabla, "form", _msg_comp, "100%");
        $f->cargar_valores($this->valores1);
        $f->mostrar_formulario();
    }

    function modificar() {
        $this->valores1[0]= array(_usu_id,_usu_password,_msg_estado);
        $this->valores1[1]= array("ad_usuario.usu_id","ad_usuario.usu_password","ad_usuario.usu_estado");
        $this->valores1[2]= array("15","40","4");
        $this->valores1[3]= array("14","6","7");
        $this->valores1[4]= array("1","0","0");
        //$ventana_conf=array("per_nombres","per_apellidopat","per_apellidomat","gr_persona");
        $val_radio=array('valorradio'=>array("1","0"),'datoradio'=>array("Si","No"));
        $this->valores1[5]= array("","",$val_radio);
        $this->valores1[9]= array("index.php?mod_id=usuario");
        $this->valores1[6]= array("","","","");
        $this->valores1[7]= array("","","","1");
        if(isset($_POST['tipo'])) {

        }
        require_once("clases/formulario.php");
        $tablas=array('ad_usuario');
        $f=new FORMULARIO();
        $f->inicializa("usuario",_usu_titulo,$this->tabla, "form", _msg_comp, "100%");
        $f->cargar_valores($this->valores1);
        $f->mostrar_formulario(1);
    }

    function ver() {
        require_once("clases/formulario.php");
        $f=new FORMULARIO();

        $f->inicializa("usuario",_usu_titulo, $this->tabla, "form", _msg_comp, "100%");
        $this->valores[25]=array();
        $f->cargar_valores($this->valores);
        $f->ver_formulario();
    }

    function modificar_pass() {
        require_once("usuario.form.php");
        $f=new FORM();
        $f->inicializa("usuario",_usu_titulo, $this->tabla, "form", _msg_comp, "100%");
        $valores[0]= array(_usu_id,_usu_per_id,_usu_conf_password1,_usu_conf_password2);
        $valores[1]= array("ad_usuario.usu_id","ad_usuario.usu_per_id","ad_usuario.usu_password","ad_usuario.usu_observaciones");
        $valores[2]= array("15","50","40","40");
        $valores[3]= array("15","9","6","6");
        $valores[4]= array("2","2","1","1");
        $ventana_conf=array("per_nombres","per_apellidopat","per_apellidomat","gr_persona");
        $valores[5]= array("",$ventana_conf,"");
        $valores[6]= array("","personal","");
        $valores[9]= array("index.php?mod_id=usuario");
        $valores[25]=array("","","Password","Confirmacion de Password");
        $f->cargar_valores($valores);
        $f->mostrar_formulario(2);
    }

    function busqueda() {
        require_once("usuario.bus.php");
        $b=new BUS();
        $b->inicializa("usuario",_usu_titulo_busqueda, "ad_usuario", "form", "100%", "usu_id");
        $valores[0]= array(_usu_id,_usu_nombre_completo,_msg_estado);
        $valores[1]= array("usu_id","CONCAT(per_nombres,' ',per_apellidopat,' ',per_apellidomat) as usu_nom","usu_estado");
        $valores[2]= array("15","30","5");
        $valores[3]= array("1","1","17");
        $array=array("valorcombo"=>array('1','0',''),"datocombo"=>array("SI","NO","TODOS"));
        $valores[5]= array("","",$array);
        $valores['tjoin'][1]= array("1");
        $valores['join'][1]= array("gr_persona");
        $valores['on'][1]= array("usu_per_id=per_id");
        //	   $valores['order']= array("0","1","0");
        $valores['tipo_bit']= array("0","0","1");
        $b->cargar_parametros($valores);
        $b->mostrar_busqueda();
    }

    function busquedae() {
        require_once("clases/busquedae.php");
        $b=new BUSQUEDAE();
        $b->inicializa("usuario",_usu_titulo_busqueda, "ad_usuario", "form", "100%", "usu_id","1");
        $valores[0]= array(_usu_id,_usu_nombre_completo);
        $valores[1]= array("usu_id","CONCAT(per_nombres,' ',per_apellidopat,' ',per_apellidomat) as usu_nom");
        $valores[2]= array("15","45");
        $valores[3]= array("1","1");
        $valores['tjoin'][1]= array("1");
        $valores['join'][1]= array("gr_persona");
        $valores['on'][1]= array("usu_per_id=per_id");
        $b->cargar_parametros($valores);
        $b->mostrar_busqueda();
        echo "<center>";
        echo "<input class=boton name=Ingresar type=button value='"._men_cerrar."' onclick=\"javascript:window.close()\"/><br><br>";
        echo "</center>";
    }
    ///// codigo de eliminar
    function eliminar() {

        require_once("clases/formulario.php");
        //echo "hola"; exit;
        $formu=new FORMULARIO();
        //$tabla = array('gr_persona');
        //	echo $this->tabla[0] ;
        //	echo $this->tabla[1] ;
        //	echo $this->tabla[2] ;
        //	echo exit;

        $formu->inicializa("usuario","eliminado",$this->tabla, "form","", "100%");


        $formu->eliminar_formulario();
        $valores[9]= array("index.php?mod_id=usuario");
    }

};
?>
