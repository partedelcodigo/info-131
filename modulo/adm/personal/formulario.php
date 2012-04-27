<?php
class FORMULARIO {
    var $nombreform;
    var $nombretablas;
    var $tituloform;
    var $detalleform;
    var $anchoform;
    var $mod_id;
    var $tarea;
    var $error;
    var $valores;
    var $titulos;
    var $controles;
    var $id;
    var $cpt;
    var $redireccion;
    var $foto;

    function FORMULARIO() {
        $this->controles=array();
        $this->error='';
    }

    function inicializa($mod_id,$titulo,$nombretablas,$nombre,$mensaje,$ancho) {
        $this->mod_id=$mod_id;
        $this->tituloform=$titulo;
        $this->nombretablas=$nombretablas;
        $this->nombreform=$nombre;
        $this->mensajeform=$mensaje;
        $this->anchoform=$ancho;
    }

    function get_nombre_campo($cadena) {
        $nuevo_nombre=substr($cadena,strpos($cadena,'.')+1,strlen(trim($cadena)));
        return $nuevo_nombre;
    }

    function get_tabla_campo($cadena) {
        $nuevo_origen=substr($cadena,0,strpos($cadena,'.'));
        return $nuevo_origen;
    }

    function cargar_valores($valores) {
        $this->valores=$valores;
        $this->redireccion=(isset($valores[_REDIRECCION][0]))?$valores[_REDIRECCION][0]:'';
        for($i=0;$i<count($valores[0]);$i++) {
            $parametros_control['nombre']=$this->get_nombre_campo($this->valores[_NOMBRES][$i]);
            $parametros_control['cant_caracteres']=(isset($this->valores[_CANT_CARACTERES][$i]))?$this->valores[_CANT_CARACTERES][$i]:'';
            $parametros_control['tamano']=$this->valores[_TAMANO][$i];
            $parametros_control['permiso']=(isset($this->valores[_PERMISO][$i]))?$this->valores[_PERMISO][$i]:'';
            $parametros_control['css']=constant('_css_'.$this->valores[_TIPO][$i]);
            $parametros_control['defecto']=(isset($this->valores[_VALORES_DEFECTO][$i]))?$this->valores[_VALORES_DEFECTO][$i]:'';
            $parametros_control['tipo']=$this->valores[_TIPO][$i];
            $parametros['mensaje']=$this->valores[_MENSAJES][$i];
            $parametros_control['columnas']=40;
            $parametros_control['filas']=5;
            $parametros_control['formulario']=$this->nombreform;
            /**manejo de los arreglos de valores y de mensajes*/
            $parametros_control['arreglo_valores']=$this->cargar_valores_arreglo($valores,$i);
            $parametros_control['arreglo_mensajes']=$this->cargar_mensajes_arreglo($valores,$i);
            /*echo '<script>alert("'.$this->valores[_CONF_VENTANA_EMERGENTE][$i].'--1")</script>';*/
            //$parametros_control['tabla']=$this->valores[_CONF_VENTANA_EMERGENTE][$i];
            $parametros_control['modulo']=(isset($this->valores[_CONF_VENTANA_EMERGENTE][$i]))?$this->valores[_CONF_VENTANA_EMERGENTE][$i]:'';
            $this->controles[$i]=new CONTROLES;
            $this->controles[$i]->cargar_parametros($parametros_control);
            $this->foto=(isset($this->valores['foto']))?$this->valores['foto']:'';
        }
    }

    function cargar_valores_arreglo($valores,$i) {
        $arreglo_valores=array();
        switch ($valores[_TIPO][$i]) {
            case 5: {
                    /**Combo carga de datos por SQL o mensajes*/
                    if(is_string($valores[_CONF_COMBOS][$i])) {
                        $query=new QUERY;
                        $sql=$this->valores[_CONF_COMBOS][$i];
                        $resultado=$query->consulta($sql);
                        for ($j=0;$j<$query->num_registros();$j++) {
                            list($valorcombo,$datocombo) = $query->valores_fila();
                            $arreglo_valores[$j]=$valorcombo;
                        }
                        $query->cerrar();
                    }
                    else {
                        for ($j=0;$j<count($this->valores[_CONF_COMBOS][$i]['valorcombo']);$j++) {
                            $arreglo_valores[$j]=$this->valores[_CONF_COMBOS][$i]['valorcombo'][$j];
                            /*echo '<script>alert("'.$arreglo_valores[$j].'")</script>';*/
                        }
                    }
                    break;
                }

            case 7: {
                    for ($j=0;$j<count($this->valores[_CONF_COMBOS][$i]['valorradio']);$j++) {
                        $arreglo_valores[$j]=$this->valores[_CONF_COMBOS][$i]['valorradio'][$j];
                        /*echo '<script>alert("'.$arreglo_valores[$j].'")</script>';*/
                    }
                    break;
                }

            case 8: {
                    for ($j=0;$j<count($this->valores[_CONF_COMBOS][$i]['valorcheck']);$j++) {
                        $arreglo_valores[$j]=$this->valores[_CONF_COMBOS][$i]['valorcheck'][$j];
                        /*echo '<script>alert("'.$arreglo_valores[$j].'")</script>';*/
                    }
                    break;
                }

            case 9: {
                    $arreglo_valores=$valores[_CONF_COMBOS][$i];
                    break;
                }
        }
        return $arreglo_valores;
    }

    function cargar_mensajes_arreglo($valores,$i) {
        $arreglo_valores=array();
        /* 	$men=$_POST[$valores[1][1]];
		        echo"";
		        echo '<script>alert("'.$men.'")</script>'; */
        switch ($valores[_TIPO][$i]) {
            case 5: {
                    /**Combo carga de datos por SQL o mensajes*/
                    if(is_string($valores[_CONF_COMBOS][$i])) {
                        $query=new QUERY;
                        $sql=$this->valores[_CONF_COMBOS][$i];
                        $resultado=$query->consulta($sql);
                        for ($j=0;$j<$query->num_registros();$j++) {
                            list($valorcombo,$datocombo) = $query->valores_fila();
                            $arreglo_valores[$j]=$datocombo;
                            /*echo '<script>alert("'.$arreglo_valores[$j].'")</script>';*/
                        }
                        $query->cerrar();
                    }
                    else {
                        for ($j=0;$j<count($this->valores[_CONF_COMBOS][$i]['datocombo']);$j++) {
                            $arreglo_valores[$j]=$this->valores[_CONF_COMBOS][$i]['datocombo'][$j];
                        }
                    }
                    break;
                }

            case 7: {
                    for ($j=0;$j<count($this->valores[_CONF_COMBOS][$i]['datoradio']);$j++) {
                        $arreglo_valores[$j]=$this->valores[_CONF_COMBOS][$i]['datoradio'][$j];
                        /*echo '<script>alert("'.$arreglo_valores[$j].'")</script>';*/
                    }
                    break;
                }

            case 8: {
                    for ($j=0;$j<count($this->valores[_CONF_COMBOS][$i]['datocheck']);$j++) {
                        $arreglo_valores[$j]=$this->valores[_CONF_COMBOS][$i]['datocheck'][$j];
                        /*echo '<script>alert("'.$arreglo_valores[$j].'")</script>';*/
                    }
                    break;
                }

            case 9: {
                    $arreglo_valores[0]=$this->valores[_CONF_VENTANA_EMERGENTE][$i][0];
                    break;
                }
        }
        return $arreglo_valores;
    }

    function get_lista_campos() {
        $cadena='';
        for ($i=0;$i<count($this->controles);$i++) {
            $cadena.=$this->get_nombre_campo($this->valores[_NOMBRES][$i]).',';
            /* echo '<script>alert("'.$cadena.'")</script>'; */

        }
        $cadena=substr($cadena,0,strlen($cadena)-1);
        return $cadena;
    }

    function get_lista_tablas() {
        $cadena='';
        for ($i=0;$i<count($this->nombretablas);$i++) {
            $cadena.=$this->nombretablas[$i].',';
        }
        $cadena=substr($cadena,0,strlen($cadena)-1);
        return $cadena;
    }

    function get_lista_campos_tabla($tabla,$lista_de_campos) {
        //lista_de_campos
        //$lista_de_campos[$i]=ad_elemento.ele_id
        $campos=array();
        $num_campos=0;
        /**verifica la correspondencia de campos para las tablas*/
        for($i=0;$i<count($lista_de_campos);$i++) {
            if(trim($tabla)==trim($this->get_tabla_campo($lista_de_campos[$i]))) {
                $campos[$num_campos]=$this->get_nombre_campo($lista_de_campos[$i]);
                /*echo '<script>alert("'.$campos[$num_campos].'")</script>';*/
                $num_campos++;
            }
        }
        return $campos;
    }

    function generar_sql($tipo) {

        /*	  $men = $this->valores[_NOMBRES];
		  echo '<script>alert("'.$men.'")</script>'; */
        /*		   echo '<script>alert("'.$bad_msg.'")</script>'; */
//		   $_POST['']
        $query=new QUERY;
        /**Generamos la lista de campos*/
        $lista_de_campos=$this->get_lista_campos();
        /**Generamos la lista de tablas*/
        $lista_de_tablas=$this->get_lista_tablas();
        switch ($tipo) {
            case 'SEE': {/**Se genera el sql para la carga de datos*/
                    if (!ctype_digit($this->id)) {
                        $aux="'".$this->id."'";
                    }
                    else {
                        $aux=$this->id;
                    }
                    $sql='SELECT '.$lista_de_campos.
                            ' FROM '.$lista_de_tablas.
                            ' WHERE '.$this->cpt.' = '.$aux;
                    $query->consulta($sql);

                    if($query->num_registros()>0) {
                        $arreglo=$query->valores_fila();
                    }
                    else {
                        /* echo'<script>alert("'._men_no_existe__registro.'")</script>';*/
                    }
                    break;
                }

            case 'UPDATE': {/**Se subdivide la lista de campos a las tablas que pertenecen*/
                    $sql=array();
                    for($i=0;$i<count($this->nombretablas);$i++) {
                        $sql[$i]='UPDATE '.$this->nombretablas[$i].' ';
                        $campos=$this->get_lista_campos_tabla($this->nombretablas[$i],$this->valores[_NOMBRES]);
                        $sql[$i].='set ';
                        for($j=0;$j<count($campos);$j++) {
                            if(trim($campos[$j])==trim($this->cpt)) {
                                $sql[$i].=$campos[$j]."='".$this->id."',";
                            }
                            else {
                                switch ($this->controles[$j]->tipo) {
                                    case 6:  $sql[$i].=$campos[$j]."='".md5($this->controles[$j]->get_valor_control())."',";
                                        break;
                                    default:
                                        $e = $this->controles[$j]->get_valor_control();
                                        if ($e == "") {

                                            if($campos[$j]=='per_apellidopat' || $campos[$j]=='per_apellidomat') {
                                                $sql[$i].=$campos[$j]."=' ',";
                                            }
                                            else {
                                                $sql[$i].=$campos[$j]."=null,";
                                            }
                                        }
                                        else {
                                            $sql[$i].=$campos[$j]."='".$e."',";
                                        }


                                        break;
                                }
                            }
                        }$sql
                        [$i]=substr($sql[$i],0,strlen($sql[$i])-1);
                        $sql[$i].=' where '.$this->cpt."='".$this->id."'";
                        /**Proceso para jalar los valores*/
                        /*cho'<script>alert("'.$sql[$i].'")</script>';*/


                    } $arreglo
                    =$sql;
                    break;
                }
            case 'INSERT': {
                    /**Se subdivide la lista de campos a las tablas que pertenecen*/
                    /*  $men=$_POST[$valores[1][1]];
		                                echo '<script>alert("'.$men.'")</script>'; */

                    $sql=array();
                    for($i=0;$i<count($this->nombretablas);$i++) {
                        $sql[$i]='INSERT INTO '.$this->nombretablas[$i].' (';
                        $campos=$this->get_lista_campos_tabla($this->nombretablas[$i],$this->valores[_NOMBRES]);
                        for($j=0;$j<count($campos);$j++) {
                            $sql[$i].=$campos[$j].",";
                        }
                        $sql[$i]=substr($sql[$i],0,strlen($sql[$i])-1);
                        $sql[$i].=') values (';
                        for($j=0;$j<count($this->controles);$j++) {
                            if(trim($this->controles[$j]->get_valor_control())<>'') {
                                $sql[$i].="'".$this->controles[$j]->get_valor_control()."',";
                            }
                            else {
                                /*		if($campos[$j]=='per_apellidopat' || $campos[$j]=='per_apellidomat')
															{
													  			$sql[$i].="' ' ,";
																echo $sql[$i];
													         }
															 else{
																$sql[$i].="NULL ,";
															 }
	                                                        }
	                                                        echo '<script>alert("'.$this->controles[$j]->get_valor_control().'");</script>';*/
                                /*		if (!isset($_SESSION['ficha_per_id']))
			                                       {
				                                        $bad_msg = "Debe elegir a un empleado!";
				                                        echo '<script>alert("'.$bad_msg.'")</script>';
			                                       } */						         
                                if($campos[$j]=='per_apellidopat' || $campos[$j]=='per_apellidomat') {
                                    $var_pat = $_POST["per_apellidopat"];
                                    $var_mat = $_POST["per_apellidomat"];
                                    if ($var_pat=='' ) {
                                        if ($var_mat=='') {
                                            echo "<center>";
                                            echo "Ingrese el apellido de la Persona Por favor. <br><br>";
                                            echo "<center><br><input class=boton name=Volver type=button value=Volver onclick=history.back()>";
                                            echo "</center>";
                                            exit();
                                        }
                                        else {
                                            $sql[$i].="' ' ,";
                                        }
                                    }
                                    else {
                                        $sql[$i].="' ' ,";
                                    }
                                }
                                else {
                                    $sql[$i].="NULL ,";
                                }
                            }
                            /*     echo '<script>alert("'.$this->controles[$j]->get_valor_control().'");</script>';*/
                            /*		if (!isset($_SESSION['ficha_per_id']))
			                                       {
				                                        $bad_msg = "Debe elegir a un empleado!";
				                                        echo '<script>alert("'.$bad_msg.'")</script>';
			                                       } */

                        }
                        $sql[$i]=substr($sql[$i],0,strlen($sql[$i])-1);
                        /**Proceso para jalar los valores*/
                        $sql[$i].=')';

                        /*echo '<script>alert("'.$sql[$i].'");</script>';*/
                        //echo $sql[$i];exit();

                    }

                    $arreglo=$sql;
                    break;
                }

            case 'DELETE': {
                    $f = split("_",$this->cpt);
                    $sql=array();
                    $campos=$lista_de_campos;
                    $tablas=$lista_de_tablas;
                    /**Se genera la lista de campos*/
                    for($i=0;$i<count($this->nombretablas);$i++) {
                        $sql[$i]='UPDATE ';
                        $sql[$i].=$this->nombretablas[$i];
                        $sql[$i].=" set ".$f[0]."_eliminado='1' where ".$this->cpt.'='.$this->id;
                    }
                    /**Se subdivide la lista de campos a las tablas que pertenecen*/
                    $arreglo=$sql;
                    break;
                }
        }
        $query->cerrar();
        return $arreglo;

    }

    function redireccionar() {
        echo '<script>';
        echo "location.href='".$this->redireccion."'";
        echo '</script>';
    }

    function dibujar_formulario($opcion) {

        echo '<center>';
        echo '<table width="100%" border=1 cellpadding=0 cellspacing=0>';
        echo '<tr>';
        echo '<th class=title>&nbsp;&nbsp;'.$this->tituloform.'</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo '<table border="0" width="100%">';
        echo '<tr>';
        echo '<td colspan=3 class=mensaje><center>'.$this->mensajeform.'</center></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan=3 height=10 align=center><font align=center color=red size=-1 face=Arial, Helvetica, sans-serif>'.$this->error.'</font><hr class=linea>';
        if ($this->foto == 1) {
            $this->fotografias($this->id,$opcion,$this->cpt);
        }
        echo '<form method="post" name="'.$this->nombreform.'" action="'._PAG_PRINCIPAL.'?mod_id='.$this->mod_id.'&tarea='.$this->tarea.'&id='.$this->id.'&cpt='.$this->cpt.'">';
        echo '</td>';
        echo '</tr>';
        /**Carga de controles*/
        for ($i=0;$i<count($this->controles);$i++) {
            if($this->valores[_TIPO][$i]>0) {
                echo '<tr class="evento">';
                echo '<td class="nombre">';
                echo '&nbsp;&nbsp;&nbsp;';
                if(isset($this->valores[_PERMISO][$i]) && $this->valores[_PERMISO][$i]==1) {
                    echo '&nbsp;(*)';
                }
                echo '&nbsp;&nbsp;';
                echo $this->valores[_MENSAJES][$i];
                echo '</td>';
                echo '<td class="campo">';
                echo '&nbsp;&nbsp;&nbsp;';
                $this->controles[$i]->dibujar_control();
                echo '</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '<div align = center>';
        echo '<input name="id" type="hidden" value="'.$this->id.'">';
        echo '<input name="cpt" type="hidden" value="'.$this->cpt.'">';
        echo '<input name="tipo" type="hidden" value="1">';
        echo '<br><br>';
        if($opcion==1) {
            echo '<input class="boton" name="limpiar" type="reset" value="'._men_limpiar.'">&nbsp;&nbsp;&nbsp;';
            echo '<input class="boton" type="submit" name="enviar" value="'._men_enviar.'">&nbsp;&nbsp;&nbsp;';
        }
        echo "<input class=boton name=Continuar type=button value='"._men_volver."' onclick=\"location='"._PAG_PRINCIPAL."?mod_id={$this->mod_id}' \"/><br>";
        echo '</div>';
        echo '</form>';
        echo '<br>';
        echo '<br>';
    }

    function mostrar_formulario($opcion=0) {
        /*  show_source("index.php");
			    $session_path = session_save_path(); 
                echo $session_path; */     

        $this->cpt=$_GET['cpt'];
        $this->id=$_GET['id'];
        $tipo=(isset($_POST['tipo']))?$_POST['tipo']:'';
        if($opcion==0) {
            $this->tarea='ingresar';
            $this->error='';
            if($tipo==1) {
                if(($this->verificar_valores())and($tipo==1)) {
                    $arreglo_sql=$this->generar_sql('INSERT');
                    /**aca se realiza el insert general ejecutando 1 a 1 las consultas*/
                    $query=new QUERY;
                    for($i=0;$i<count($arreglo_sql);$i++) {
                        $verificar=$query->consulta($arreglo_sql[$i]);
                        /*//                                                echo '<script>alert("'.$arreglo_sql[$i].'--'.$verificar.'");</script>';*/
//                                                echo $arreglo_sql[$i].'--'.$verificar;
                    }
                    $query->cerrar();
                    $this->redireccionar();
                }
                else {
                    $this->dibujar_formulario(1);
                }
            }
            else {

                $this->dibujar_formulario(1);
            }
        }
        else {
            $this->tarea='modificar';
            $this->error='';
            if($tipo==1) {
                if(($this->verificar_valores())and($tipo==1)) {
                    $arreglo_sql=$this->generar_sql('UPDATE');
                    /**Se realiza la modificacion del Registro ejecutando 1 a 1 las consultas*/
                    $query=new QUERY;
                    for($i=0;$i<count($arreglo_sql);$i++) {
                        $verificar=$query->consulta($arreglo_sql[$i]);
                        /*echo '<script>alert("'.$arreglo_sql[$i].'--'.$verificar.'");</script>';*/

                    }
                    $query->cerrar();
                    $this->redireccionar();
                }
                else {
                    $arreglo_valores=$this->generar_sql('SEE');
                    for($i=0;$i<count($this->controles);$i++) {
                        //asignamos un valor por defecto y recargamos el control
                        $this->controles[$i]->defecto=$arreglo_valores[$i];
                        $this->controles[$i]->cargar_control();
                    }
                    $this->dibujar_formulario(1);
                }
            }
            else {
                $arreglo_valores=$this->generar_sql('SEE');
                for($i=0;$i<count($this->controles);$i++) {
                    /*asignamos un valor por defecto y recargamos el control*/
                    $this->controles[$i]->defecto=$arreglo_valores[$i];
                    $this->controles[$i]->cargar_control();
                    /*echo '<script>alert("'.$arreglo_valores[$i].'");</script>';*/
                }
                $this->dibujar_formulario(1);
            }
        }
    }

    function verificar_valores() {
        $form_valido=false;
        for ($i=0;$i<count($this->controles);$i++) {
            if($this->controles[$i]->control_valido()) {
                $form_valido=true;
            }
            else {
                $this->error.=_men_campo_invalido.' -> '.constant('_'.$this->get_nombre_campo($this->valores[_NOMBRES][$i])).'<br>';
                return false;
            }
        }
        return $form_valido;
    }

    function ver_formulario() {
        $this->cpt=$_GET['cpt'];

        $this->id=$_GET['id'];

        /**aca se genera la consultq SQL y se setean lo datos para mostrar*/

        $arreglo_valores=$this->generar_sql('SEE');

        for($i=0;$i<count($this->controles);$i++) {
            $this->controles[$i]->set_permiso(2);
            $this->controles[$i]->defecto=$arreglo_valores[$i];
            $this->controles[$i]->cargar_control();
        }

        $this->dibujar_formulario(0);
    }

    function eliminar_formulario() {
        $this->cpt=$_GET['cpt'];
        $this->id=$_GET['id'];
        $query=new QUERY;
        $resultado=$query->consulta($sql);
        $arreglo_sql=$this->generar_sql('DELETE');
        /**Se realiza la modificacion del Registro ejecutando 1 a 1 las consultas*/
        $query=new QUERY;
        for($i=0;$i<count($arreglo_sql);$i++) {
            $verificar=$query->consulta($arreglo_sql[$i]);
            /*echo '<script>alert("'.$arreglo_sql[$i].'--'.$verificar.'");</script>';*/
        }
        $query->cerrar();
        $query->cerrar();
        echo '<center>';
        echo '<table width="100%" border=1 cellpadding=0 cellspacing=0>';
        echo '<tr>';
        echo '<th class=title>'.$muestra.'&nbsp;&nbsp;'.$this->tituloform.'</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo '<center>';
        echo _men_eliminado."<br><br>";
        echo "<input class=boton name=Continuar type=button value='"._men_continuar."' onclick=\"location='"._PAG_PRINCIPAL."?mod_id={$this->mod_id}' \"/><br>";
        echo '</center>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '<center>';
    }

    //###########################################################################
    //################## FOTOTGRAFIAS DEBERIA SER UNA CLASE INDEPENDIENTE####################
    function fotografias($id="",$opcion='0',$cpt) {

        if ($cpt<>"per_id") {
            switch ($cpt) {
                case 'alu_id'	:
                    $sid="select alu_per_id from ac_alumno where alu_id=".$id;
                    $ids= new QUERY;
                    $ids->consulta($sid);
                    $lid=$id;
                    $id = $ids->valores_fila();
                    $id=$id[0];
                    $ids->cerrar();
                    break;
            }
        }
        $tot=_fotos."/".$id.".jpg";
        $alt=_fotos."/nofoto.jpg";

        if (file_exists($tot)) {
            echo "<img src='$tot' alt='fotografia'>";


        }
        else {
            if($opcion==1 and $id<>"") {
                echo '<a href="#" onClick=window.open("'._url.'/componentes/subidor.php?mod_id='.$this->mod_id.'&tarea='.$this->tarea.'&id='.$id.'&cpt='.$this->cpt.'&lid='.$lid.'&eme=eme","Alertas","toolbar=no,width=400,height=100,scrollbars=no")><img src='.$alt.'></a>';
            }
            else {
                echo "<img src='$alt' alt='fotografia'>";
            }
        }
    }
}
?>
