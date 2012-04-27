<?php
/*
@file busquedae.php

Definicion de la clase busquedae

Atributos
		$nombreform
		$titulobusqueda
		$anchobus
		$mod_id
		$tipobus
		$parametros
		$sql
		$tabla
		$id

Lista de funciones:
		inicializa($mod_id,$titulo,$tabla,$nombre,$ancho,$id)
		cargar_parametros($valores)
		generar_sql()
		mostrar_resultados()
		mostrar_busqueda()
		validar_permisos()
*/
require_once ('componentes/contenido2.php');
include_once ('busqueda.php');

class BUSQUEDAE {
    var $nombreform;
    var $titulobusqueda;
    var $anchobus;
    var $mod_id;
    var $tipobus;
    var $parametros;
    var $sql;
    var $tabla;
    var $id;
    var $pagina;
    var $reg_pagina;
    var $controles;
    var $usuario;
    var $arreglo_permisos;

    function inicializa($mod_id,$titulo,$tabla,$nombre,$ancho,$id,$tipo='',$reg_pagina=10) {
        $this->id=$id;
        $this->tabla=$tabla;
        $this->mod_id=$mod_id;
        $this->titulobus=$titulo;
        $this->nombreform=$nombre;
        $this->anchoform=$ancho;
        $this->sql='';
        $this->tipobus=$tipo;
        $this->reg_pagina=$reg_pagina;
//		$this->usuario=new PERSONA;
        $this->controles=new CONTROLES;
        $this->contenido2=new CONTENIDO2;
//		$this->arreglo_permisos=array();
    }

    function cargar_parametros($valores) {
        BUSQUEDA::cargar_parametros($valores);
    }

    function generar_sql() {
        BUSQUEDA::generar_sql();
        //echo $this->sql; exit;
    }

    function mostrar_resultados() {

//sujeto a cambio con una clase que genera ya la consulta por defecto
        /*##################################################*/
        /*primero verifica */
        $query=new QUERY;
        $resultado=$query->consulta($this->sql);
        $num_columnas=$query->num_campos($resultado);
        //echo $query->num_registros();
        $this->cargar_paginas($query->num_registros(),$num_columnas);
        echo '<tr class=fila_verde>';
        for ($j=0;$j<$query->num_campos($resultado)-1;$j++) {
            echo '<td>&nbsp;'.$this->parametros[0][$j].'</td>';
        }
        echo '<td><center>Opciones</center></td>';
        echo '</tr>';
        $actual=0;
        $registro=$this->pagina * $this->reg_pagina-$this->reg_pagina;
        for ($o=0;$o<$registro;$o++) {
            $row = $query->valores_fila();
            $actual++;

        }
        //echo $this->sql;
        for ($i=0;$i<$this->reg_pagina;$i++) {
            $row = $query->valores_fila();
            //if(trim($row)<>"") {
            if(count($row)>0) {
                $fila=fmod($i,2)?'fila_blanca':'fila_gris';
                echo '<tr class="evento '.$fila.'">';
                $cadena='';
                for ($j=0;$j<$query->num_campos($resultado)-1;$j++) {
//						echo '<td>&nbsp;'.$row[$j].'</td>';
                    switch ($this->parametros[3][$j]) {
                        case 4:
                            if ($row[$j]==1) {
                                echo '<td>SI</td>';
                            }
                            else {
                                echo '<td>NO</td>';
                            }
                            break;
                        case 5:
                        //para obtener el nombre del campo que relaciona las dos tablas
                            if (isset($this->parametros[5][$j])) {
                                if(is_string($this->parametros[5][$j])) {
                                    //para obtener el nombre del campo que relaciona las dos tablas
                                    $query_aux=new QUERY;
                                    $sql_aux=$this->parametros[5][$j];
                                    $resultado_aux=$query_aux->consulta($sql_aux);
                                    $campo_foraneo=$query_aux->nombre_campo(0);
                                    $query2=new QUERY;
                                    $sql2=$this->parametros[5][$j]." where ".$campo_foraneo."='".$row[$j]."'";
                                    $resultado2=$query2->consulta($sql2);
                                    list($valorcombo,$datocombo) = $query2->valores_fila();
                                    echo '<td>&nbsp;'.$datocombo.'</td>';
                                    $query2->cerrar();
                                }
                                else {
                                    for ($xyz=0;$xyz<count($this->parametros[5][$j]['valorcombo']);$xyz++) {
                                        if ($row[$j]==$this->parametros[5][$j]['valorcombo'][$xyz]) {
                                            echo '<td>&nbsp;'.$this->parametros[5][$j]['datocombo'][$xyz].'</td>';
                                        }
                                    }
                                }
                            }
                            break;
                        case 17:
                        //para obtener el nombre del campo que relaciona las dos tablas
                            if (isset($this->parametros[5][$j])) {
                                if(is_string($this->parametros[5][$j])) {
                                    //para obtener el nombre del campo que relaciona las dos tablas
                                    $query_aux=new QUERY;
                                    list($sql_aux)=split("where",$this->parametros[5][$j]);
                                    //$sql_aux=$this->parametros[5][$j];
                                    $resultado_aux=$query_aux->consulta($sql_aux);
                                    $campo_foraneo=$query_aux->nombre_campo(0);
                                    $query2=new QUERY;
                                    list($sql2)=split("where",$this->parametros[5][$j]);
                                    $sql2.=" where ".$campo_foraneo."='".$row[$j]."'";
                                    //$sql2=$this->parametros[5][$j]." where ".$campo_foraneo."='".$row[$j]."'";
                                    $resultado2=$query2->consulta($sql2);
                                    list($valorcombo,$datocombo) = $query2->valores_fila();
                                    echo '<td>&nbsp;'.$datocombo.'</td>';
                                    $query2->cerrar();
                                }
                                else {
                                    switch ($row[$j]) {
                                        case '0':
                                            echo '<td>&nbsp;No</td>';
                                            break;
                                        case '1':
                                            echo '<td>&nbsp;Si</td>';
                                            break;
                                        default:
                                            echo '<td>&nbsp;'.$row[$j].'</td>';
                                            break;
                                    }
                                    //echo '<td>&nbsp;'.$row[$j].'</td>';
                                }
                            }
                            break;

                        default :
                            echo '<td>&nbsp;'.$row[$j].'</td>';
                            break;
                    }
                    if ($j>0) {
                        $cadena.=$row[$j].' ';
                    }
                }
                echo '<td><center>';
                //muestra o no los botones
                $tip=$_GET['tipo'];
                $da = $row[$j];
                //$da = $this->id;
                if ($tip==1) {
                    echo "&nbsp;&nbsp;<a href=\"javascrip:void(0)\" onclick=\"javascript:ponPrefijo('".$da."','".$cadena."')\" title=\"Seleccionar\">"._men_cargar."</a>";
                }
                else {
                    $dab = $row[0];
                    echo "&nbsp;&nbsp;<a href=\"javascrip:void(0)\" onclick=\"javascript:ponPrefijo('".$da."','".$dab."','".$cadena."')\" title=\"Seleccionar\">"._men_cargar."</a>";
                }
                echo '</center></td>';
                echo '</tr>';
            }
            $query->mover_siguiente();
        }
        $query->cerrar();
    }

    function validar_permisos() {
        BUSQUEDA::validar_permisos();
    }

    function obtienevalorcombo($i,$valor) {
        $query2=new QUERY;
        $camp='';
        $count=0;
        $cons='';
        for($k=0;$k<count($this->parametros[5][$i])-1;$k++) {
            $camp.=$this->parametros[5][$i][$k].' ,';
            $count++;
        };
        $camp=substr($camp,0,-1);
        if ($camp=='') $camp='*';
        $cons="select {$camp} from {$this->parametros[5][$i][$k]} where {$this->parametros[1][$i]}='{$valor}'";
        if ($this->valores[5][$i][$k]) {
            $resultado=$query2->consulta($cons);
            $fila = $query2->valores_fila();
        }
        $camp='';
        for ($k=0;$k<count($this->parametros[5][$i])-1;$k++) $camp.=$fila[$k].' ';
        $query2->cerrar();
        return $camp;
    }

    function mostrar_busqueda() {
        global $modulo, $tarea, $nombreform, $campo;
        //$this->validar_permisos();
        $vall=count($this->parametros[0]);
        $vall2=$vall+1;
        if ($this->tipobus) {
            $tipobus="?mod_id={$this->mod_id}&tarea=buscae&nombreform=$nombreform&campo=$campo&tipo=1";
        }
        else {
            $tipobus="?mod_id={$this->mod_id}";
        }
        $this->contenido2->ventana->abrir();
        echo "<center>
		 <form method=post name=$this->nombreform action='emergente.php".$tipobus."'>
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
            $parametros_control['nombre']=$this->parametros[1][$i];
            $parametros_control['cant_caracteres']=$this->parametros[2][$i];
            $parametros_control['tamano']=$this->parametros[2][$i];
            $parametros_control['permiso']=0;
            $parametros_control['css']=constant('_css_'.$this->parametros[3][$i]);
            //$parametros['defecto'];
            $parametros_control['tipo']=$this->parametros[3][$i];
            if (($this->parametros[3][$i]==5) or ($this->parametros[3][$i]==17)) {
                if(is_string($this->parametros[5][$i])) {
                    $q=new QUERY;
                    $sql=$this->parametros[5][$i];
                    $q->consulta($sql);
                    $aux[0]='';
                    $aux1[0]='Todos';
                    for ($j=1;$j<$q->num_registros()+1;$j++) {
                        list($valorcombo,$datocombo) = $q->valores_fila();
                        $aux[$j]=$valorcombo;
                        $aux1[$j]=$datocombo;
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
            $parametros_control['formulario']=$this->nombreform;
            $this->controles->cargar_parametros($parametros_control);
            $this->controles->dibujar_control();
            echo '</td>';
        }
        echo  " <td class=title><input class=boton type=submit id=envio name=buscar value='"._men_buscar."' ></td>";
        $this->generar_sql();
        $this->mostrar_resultados();
        echo "</tr></table></form></center>";
        $this->contenido2->ventana->cerrar();

    }

    function cargar_paginas($num_registros,$num_columnas) {
        require_once("paginacion.php");
        $paginacion = new PAGINACION($num_registros,$this->reg_pagina);
        $num_paginas=$paginacion->getnum_paginas();
        $paginacion->paginar($num_columnas);
        $this->pagina=$paginacion->getpag();
    }
};
?>
