<?php
include_once('clases/busqueda.php');
class BUS extends BUSQUEDA {
    function generar_sql() {
        if (isset($this->parametros['tUNION']) && $this->parametros['tUNION']<>"") {
            $aux=count($this->parametros['tUNION'])+1;
        }
        else {
            $aux=1;
        }
        for ($j=1;$j<=$aux;$j++) {

            $this->sql="select ";
            if (isset($this->parametros['distinct']) && $this->parametros['distinct']==1) {
                $this->sql.=" distinct ";
            }

            //aca se generan la lista de campos a mostrar
            for ($i=0;$i<count($this->parametros[0]);$i++) {
                $this->sql.=$this->parametros[1][$i].',';
            }
            $this->sql.=$this->id.' ';
            if ($j==1) {
                $this->sql.= " from ".$this->tabla;
            }
            else {
                $this->sql.= " from ".$this->parametros['UNION'][$j-2];
            }
            for ($i=0;$i<count($this->parametros['tjoin'][$j]);$i++) {
                if (($this->parametros['tjoin'][$j][$i]<>"") and ($this->parametros['join'][$j][$i]<>"") and ($this->parametros['on'][$j][$i]<>"")) {
                    switch ($this->parametros['tjoin'][$j][$i]) {
                        case 1:
                            $this->sql.=" inner join ".$this->parametros['join'][$j][$i]." on ".$this->parametros['on'][$j][$i];
                            break;
                        case 2:
                            $this->sql.=" left join ".$this->parametros['join'][$j][$i]." on ".$this->parametros['on'][$j][$i];
                            break;
                        case 3:
                            $this->sql.=" right join ".$this->parametros['join'][$j][$i]." on ".$this->parametros['on'][$j][$i];
                            break;
                    }
                }
            }
            $this->sql.= " where ";
            if(isset($this->parametros['where'][$j])) {
                for ($i=0;$i<count($this->parametros['where'][$j]);$i++) {
                    if (($this->parametros['where'][$j][$i]<>"")) {
                        $this->sql.=$this->parametros['where'][$j][$i]." and   ";
                    }
                }
            }
            for ($i=0;$i<count($this->parametros[0]);$i++) {
                if ($this->parametros['tipo_bit'][$i]==1) {
                    if (isset($_POST[$this->parametros[1][$i]])) {
                        if ($_POST[$this->parametros[1][$i]]<>"") {
                            $this->sql.=$this->parametros[1][$i]." = '" .$_POST[$this->parametros[1][$i]]."' and   ";
                        }
                    }
                    else {
                        //	$this->sql.=$this->parametros[1][$i]." = '1' and ";
                    }
                }
                else {
                    if(isset($_POST[$this->parametros[1][$i]])) {
                        if ($_POST[$this->parametros[1][$i]]<>"") {
                            if ($this->parametros[3][$i]==5)//si es un combobox no hace LIKE sino un "="
                            {
                                //mantiene las comparaciones mayusculas y minusculas por si hay combobox que no tengan valor num�rico
                                $this->sql.="(".$this->parametros[1][$i]." = '" .
                                        strtoupper($_POST[$this->parametros[1][$i]])."' or "
                                        .$this->parametros[1][$i]." = '" .
                                        strtolower($_POST[$this->parametros[1][$i]])."' ) and   ";
                            }
                            else {
                                $this->sql.="(".$this->parametros[1][$i]." like '" .
                                        strtoupper($_POST[$this->parametros[1][$i]])."%' or "
                                        .$this->parametros[1][$i]." like '" .
                                        strtolower($_POST[$this->parametros[1][$i]])."%' ) and   ";
                            }
                            //$this->sql.=$this->parametros[1][$i]." like '" .$_POST[$this->parametros[1][$i]]."%' and ";
                        }
                    }
                }
                //$this->sql.=$this->parametros[1][$i]." like '" .$_POST[$this->parametros[1][$i]]."%' and ";
            }
            if (isset($_POST['usu_nom']) && $_POST['usu_nom']<>"") {
                $this->sql.="(per_nombres like '" .
                        strtoupper($_POST['usu_nom'])."%' or per_nombres like '" .
                        strtolower($_POST['usu_nom'])."%') and   ";
            }


            $this->sql=substr($this->sql,0,strlen($this->sql)-6);
            if ($j==1) {
                $auxsql=$this->sql;
            }
            else {
                switch ($this->parametros['tUNION'][$j-2]) {
                    case 1:  $auxsql=$auxsql." UNION ".$this->sql;
                        break;
                    case 2:  $auxsql=$auxsql." UNION ALL ".$this->sql;
                        break;
                }

            }

        }
        $this->sql=$auxsql;
        $this->sql.=" order by usu_nom";

    }

    function mostrar_busqueda() {
        global $modulo, $tarea, $nombreform, $campo;
        $this->validar_permisos();
        $vall=count($this->parametros[0]);
        $vall2=$vall+1;
        if ($this->tipobus) {
            $tipobus="?mod_id={$this->mod_id}&tarea=$tarea&nombreform=$nombreform&campo=$campo";
        }
        else {
            $this->barra->ventana->abrir();
            echo '<div align="right" id="status">';
            echo '<p>';
            for($fila=0;$fila<count($this->arreglo_permisos);$fila++) {
                if ($this->arreglo_permisos[$fila]['permiso']=="A") {
                    echo '&nbsp;<a href="'._PAG_PRINCIPAL.'?mod_id='.$this->mod_id.'&tarea='.$this->arreglo_permisos[$fila]['tarea'].'&id=&cpt='.$this->id.'" title="'.constant('_men_'.$this->arreglo_permisos[$fila]['permiso']).'">'.$this->arreglo_permisos[$fila]['icono'];
                    echo '&nbsp;'._men_nuevo;
                    echo '</a>&nbsp;';
                }
            }
            echo '&nbsp;<a href="'._PAG_PRINCIPAL.'?mod_id=principal" title="'.constant('_men_cerrar').'"><img width="20px" border="0" src="'._url.'/graficos/back.png">';
            echo '&nbsp;'._men_cerrar;
            echo '</a>&nbsp;';
            echo '</p>';
            echo '</div>';
            $this->barra->ventana->cerrar();
            $tipobus="?mod_id={$this->mod_id}";
        }
        $this->contenido2->ventana->abrir();
        echo "<center>
		 <form method=post name=$this->nombreform action='"._PAG_PRINCIPAL."{$tipobus}'>
		  <table width={$this->anchoform} border=0 cellpadding=0 cellspacing=0>
		     <tr>
		    	<th colspan='";
        echo $vall2;
        echo  "' class=title>".strtoupper($this->titulobus)."</th>
			 </tr>
			 <tr>";
        for ($i=0;$i<$vall;$i++) {
            echo  "<td class=title>{$this->parametros[0][$i]}</td>";
        }
        echo  " <td class=title></td>
			 </tr>";
        echo "<tr>";
        //para mostrar el index de paginas
        //echo "<td class=campo><input class=texto type=text size=3 maxlength=3 name='pag'></td>";
        for ($i=0;$i<$vall;$i++) {
            /**Modificar con controles*/
            echo '<td class=campo>&nbsp;&nbsp;';
            if ($i==1) {
                $parametros_control['nombre']="usu_nom";
            }
            else {
                $parametros_control['nombre']=$this->parametros[1][$i];
            }
            $parametros_control['cant_caracteres']=$this->parametros[2][$i];
            $parametros_control['tamano']=$this->parametros[2][$i];
            $parametros_control['permiso']=0;
            $parametros_control['css']=constant('_css_'.$this->parametros[3][$i]);
            //$parametros['defecto'];
            $parametros_control['tipo']=$this->parametros[3][$i];
            if (($this->parametros[3][$i]==5) or ($this->parametros[3][$i]==17)) {
                if(is_string($this->parametros[5][$i])) {
                    unset($aux);
                    unset($aux1);
                    $q=new QUERY;
                    $sql=$this->parametros[5][$i];
                    $q->consulta($sql);
                    $aux[0]='';
                    $aux1[0]='Todos';
                    for ($j=1;$j<=$q->num_registros();$j++) {
                        list($valorcombo,$datocombo) = $q->valores_fila();
                        $aux[$j]=$valorcombo;
                        $aux1[$j]=$datocombo;
//							print $aux1[$j];
                    }
                    $parametros_control['arreglo_valores']=$aux;
                    $parametros_control['arreglo_mensajes']=$aux1;
                }
                else {
                    $parametros_control['arreglo_valores']=$this->parametros[5][$i]['valorcombo'];
                    $parametros_control['arreglo_mensajes']=$this->parametros[5][$i]['datocombo'];
                }
            }
            $parametros_control['columnas']=$this->parametros[2][$i];
            //$parametros_control['formulario']=$this->nombre;
            $parametros_control['formulario']=$this->nombreform;
            $this->controles->cargar_parametros($parametros_control);
            $this->controles->dibujar_control();
            echo '</td>';
        }
        echo  " <td class=title><input class=boton type=submit id=envio name=buscar value='"._men_buscar."' ></td>";
        $this->generar_sql();
        $this->mostrar_resultados($modulo);
        echo "</tr></table></form>";
        $this->leyendas();
        echo "</center>";
        $this->contenido2->ventana->cerrar();
    }

};
?>
