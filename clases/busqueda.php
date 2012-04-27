<?php
require_once ('componentes/barra_opciones.php');
require_once ('componentes/contenido2.php');

class BUSQUEDA {

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

    function inicializa($mod_id, $titulo, $tabla, $nombre, $ancho, $id, $tipo = '', $reg_pagina = 10) {
        $this->id = $id;
        $this->tabla = $tabla;
        $this->mod_id = $mod_id;
        $this->titulobus = $titulo;
        $this->nombreform = $nombre;
        $this->anchoform = $ancho;
        $this->sql = '';
        $this->tipobus = $tipo;
        $this->reg_pagina = $reg_pagina;
        $this->usuario = new PERSONA;
        $this->controles = new CONTROLES;
        $this->barra = new BARRA_OPCIONES;
        $this->contenido2 = new CONTENIDO2;
        $this->arreglo_permisos = array();
    }

    function cargar_parametros($valores) {
        $this->parametros = $valores;
    }

    function generar_sql() {
        //sujeto a cambio con una clase que genera ya la consulta por defecto
        /* ################################################## */
        if (isset($this->parametros['tUNION']) && $this->parametros['tUNION'] <> "") {
            $aux = count($this->parametros['tUNION']) + 1;
        } else {
            $aux = 1;
        }
        $w = 0;
        for ($j = 1; $j <= $aux; $j++) {

            $this->sql = "select ";
            if (isset($this->parametros['distinct']) && $this->parametros['distinct'] == 1) {
                $this->sql.=" distinct ";
            }

            //aca se generan la lista de campos a mostrar
            for ($i = 0; $i < count($this->parametros[0]); $i++) {
                $this->sql.=$this->parametros[1][$i] . ',';
            }
            $this->sql.=$this->id . ' ';
            if ($j == 1) {
                $this->sql.= " from " . $this->tabla;
            } else {
                $this->sql.= " from " . $this->parametros['UNION'][$j - 2];
            }
            if (isset($this->parametros['tjoin'][$j])) {
                for ($i = 0; $i < count($this->parametros['tjoin'][$j]); $i++) {
                    if (($this->parametros['tjoin'][$j][$i] <> "") and ($this->parametros['join'][$j][$i] <> "") and ($this->parametros['on'][$j][$i] <> "")) {
                        switch ($this->parametros['tjoin'][$j][$i]) {
                            case 1:
                                $this->sql.=" inner join " . $this->parametros['join'][$j][$i] . " on " . $this->parametros['on'][$j][$i];
                                break;
                            case 2:
                                $this->sql.=" left join " . $this->parametros['join'][$j][$i] . " on " . $this->parametros['on'][$j][$i];
                                break;
                            case 3:
                                $this->sql.=" right join " . $this->parametros['join'][$j][$i] . " on " . $this->parametros['on'][$j][$i];
                                break;
                        }
                    }
                }
            }
            $this->sql.= " where ";
            if (isset($this->parametros['where'][$j])) {
                for ($i = 0; $i < count($this->parametros['where'][$j]); $i++) {
                    if (($this->parametros['where'][$j][$i] <> "")) {
                        $this->sql.=$this->parametros['where'][$j][$i] . " and   ";
                    }
                }
            }
            for ($i = 0; $i < count($this->parametros[0]); $i++) {
                if (isset($this->parametros['tipo_bit'][$i]) && $this->parametros['tipo_bit'][$i] == 1) {
                    if (isset($_POST[$this->parametros[1][$i]])) {
                        if ($_POST[$this->parametros[1][$i]] <> "") {
                            $this->sql.=$this->parametros[1][$i] . " = '" . $_POST[$this->parametros[1][$i]] . "' and   ";
                        }
                    } else {
                        
                    }
                } else {
                    if (isset($_POST[$this->parametros[1][$i]]) && $_POST[$this->parametros[1][$i]] <> "") {
                        if (($this->parametros[3][$i] == 5) || ($this->parametros[3][$i] == 17)) {//si es un combobox no hace LIKE sino un "="
                            //mantiene las comparaciones mayusculas y minusculas por si hay combobox que no tengan valor num�rico
                            $this->sql.="(" . $this->parametros[1][$i] . " = '" .
                                    strtoupper($_POST[$this->parametros[1][$i]]) . "' or "
                                    . $this->parametros[1][$i] . " = '" .
                                    strtolower($_POST[$this->parametros[1][$i]]) . "' ) and   ";
                        } else {
                            $this->sql.="(" . $this->parametros[1][$i] . " like '" .
                                    strtoupper($_POST[$this->parametros[1][$i]]) . "%' or "
                                    . $this->parametros[1][$i] . " like '" .
                                    strtolower($_POST[$this->parametros[1][$i]]) . "%' ) and   ";
                        }

                        //$this->sql.=$this->parametros[1][$i]." like '" .$_POST[$this->parametros[1][$i]]."%' and ";
                    }
                }
                //$this->sql.=$this->parametros[1][$i]." like '" .$_POST[$this->parametros[1][$i]]."%' and ";
            }

            //			echo $this->sql."<br>#################<br>";
            $this->sql = substr($this->sql, 0, strlen($this->sql) - 6);

            if (isset($this->parametros['vopc']) && $this->parametros['vopc']) {
                //				echo 	$this->parametros['vopc']."<br>#################<br>";
                $this->sql.= $this->parametros['vopc'];
            }
            if ($j == 1) {
                $auxsql = $this->sql;
            } else {
                switch ($this->parametros['tUNION'][$j - 2]) {
                    case 1: $auxsql = $auxsql . " UNION " . $this->sql;
                        break;
                    case 2: $auxsql = $auxsql . " UNION ALL " . $this->sql;
                        break;
                }
            }
        }
        $this->sql = $auxsql;

        if (isset($this->parametros['din_orden']) && $this->parametros['din_orden']) {
            $this->sql.=" order by " . $this->parametros['din_orden'];
        } else if (isset($this->parametros['order']) && count($this->parametros['order']) > 0) {
            $this->sql.=" order by ";
            for ($i = 0; $i < count($this->parametros['order']); $i++) {
                if (($this->parametros['order'][$i] == 1)) {
                    $this->sql.=$this->parametros[1][$i] . " , ";
                }
            }
            $this->sql = substr($this->sql, 0, strlen($this->sql) - 2);
        }

        if (isset($this->parametros['inorden']) && $this->parametros['inorden']) {
            $this->sql.=" desc ";
        }
        //echo $this->sql;
//		echo "<br><br>##".$this->tipobus."<br>############################<br>";
    }

    function mostrar_resultados() {
        $query = new QUERY;
        $resultado = $query->consulta($this->sql);
        $num_columnas = $query->num_campos($resultado);
        $this->cargar_paginas($query->num_registros(), $num_columnas);
        echo '<tr class=fila_verde>';
        for ($j = 0; $j < $query->num_campos($resultado) - 1; $j++) {
            echo '<td>&nbsp;' . $this->parametros[0][$j] . '</td>';
        }
        echo '<td><center>Opciones.</center></td>';
        echo '</tr>';
        $actual = 0;
        if ($this->pagina <= 0) {
            $this->pagina = 1;
        }
        $registro = $this->pagina * $this->reg_pagina - $this->reg_pagina;
        $this->sql.=' LIMIT ' . $this->reg_pagina . ' OFFSET ' . $registro;
        //echo $this->sql;//GASTON AQUI###########################################
        $resultado = $query->consulta($this->sql);
        $this->reg_pagina = ($query->num_registros() < $this->reg_pagina) ? $query->num_registros() : $this->reg_pagina;
        for ($i = 0; $i < $this->reg_pagina; $i++) {
            $row = $query->valores_fila();
            //if(trim($row)<>"") {
            if (count($row) > 0) {
                $fila = fmod($i, 2) ? 'fila_blanca' : 'fila_gris';
                echo '<tr class="evento ' . $fila . '">';
                for ($j = 0; $j < $query->num_campos($resultado) - 1; $j++) {
                    //						echo '<td>&nbsp;'.$row[$j].'</td>';
                    switch ($this->parametros[3][$j]) {
                        case 4:
                            if ($row[$j] == 1) {
                                echo '<td>SI</td>';
                            } else {
                                echo '<td>NO</td>';
                            }
                            break;
                        case 5:
                            //para obtener el nombre del campo que relaciona las dos tablas
                            if (isset($this->parametros[5][$j])) {
                                if (is_string($this->parametros[5][$j])) {
                                    //para obtener el nombre del campo que relaciona las dos tablas
                                    $query_aux = new QUERY;
                                    $sql_aux = $this->parametros[5][$j];
                                    $resultado_aux = $query_aux->consulta($sql_aux);
                                    $campo_foraneo = $query_aux->nombre_campo(0);
                                    $query2 = new QUERY;

                                    //Verificar si es que ya existe el where
                                    $posicion = strpos(strtoupper($this->parametros[5][$j]), 'WHERE');
                                    if ($posicion == false)
                                        $condi = ' where ';
                                    else
                                        $condi = ' and ';
                                    $sql2 = $this->parametros[5][$j] . $condi . $campo_foraneo . "='" . $row[$j] . "'";
                                    if (isset($this->parametros['COMBO_ORDER'])) { //para el combo
                                        //$sql2.= " ". $this->parametros['COMBO_ORDER'];
                                        $sql2 = $sql2 . " order by " . $this->parametros['COMBO_ORDER'];
                                        //echo '---> '.$sql2;
                                    }
                                    //echo $sql2;
                                    $resultado2 = $query2->consulta($sql2);
                                    list($valorcombo, $datocombo) = $query2->valores_fila();
                                    echo '<td>&nbsp;' . $datocombo . '</td>';
                                    $query2->cerrar();
                                } else {
                                    switch ($row[$j]) {
                                        case '0':
                                            echo '<td>&nbsp;No</td>';
                                            break;
                                        case '1':
                                            echo '<td>&nbsp;Si</td>';
                                            break;
                                        default:
                                            echo '<td>&nbsp;' . $row[$j] . '</td>';
                                            break;
                                    }
                                    //echo '<td>&nbsp;'.$row[$j].'</td>';
                                }
                            }
                            break;
                        case 17:
                            //para obtener el nombre del campo que relaciona las dos tablas
                            if (isset($this->parametros[5][$j])) {
                                if (is_string($this->parametros[5][$j])) {
                                    //para obtener el nombre del campo que relaciona las dos tablas
                                    $query_aux = new QUERY;
                                    list($sql_aux) = split("where", $this->parametros[5][$j]);
                                    //$sql_aux=$this->parametros[5][$j];
                                    $resultado_aux = $query_aux->consulta($sql_aux);
                                    $campo_foraneo = $query_aux->nombre_campo(0);
                                    $query2 = new QUERY;
                                    list($sql2) = split("where", $this->parametros[5][$j]);
                                    $sql2.=" where " . $campo_foraneo . "='" . $row[$j] . "'";
                                    //$sql2=$this->parametros[5][$j]." where ".$campo_foraneo."='".$row[$j]."'";
                                    $resultado2 = $query2->consulta($sql2);
                                    list($valorcombo, $datocombo) = $query2->valores_fila();
                                    echo '<td>&nbsp;' . $datocombo . '</td>';
                                    $query2->cerrar();
                                } else {
                                    switch ($row[$j]) {
                                        case '0':
                                            echo '<td>&nbsp;No</td>';
                                            break;
                                        case '1':
                                            echo '<td>&nbsp;Si</td>';
                                            break;
                                        default:
                                            echo '<td>&nbsp;' . $row[$j] . '</td>';
                                            break;
                                    }
                                    //echo '<td>&nbsp;'.$row[$j].'</td>';
                                }
                            }
                            break;
                        default :
                            echo '<td>&nbsp;' . htmlentities($row[$j]) . '</td>';
                            break;
                    }
                }
                ?>
                <script type="text/javascript" language="JavaScript">
                    function confirma_eliminacion(arg1, arg2, arg3) {
                        url = "<? echo _PAG_PRINCIPAL; ?>?mod_id=" + arg1+"&tarea=eliminar&id="+ arg2+"&cpt="+ arg3;
                        if (confirm("Usted esta seguro de eliminar el registro "))
                            location=(url)
                    }
                </script>
                <?php
                echo '<td><center>';
                /*                 * Designacion de Permisos */
                for ($fila = 0; $fila < count($this->arreglo_permisos); $fila++) {
                    //modificado por Felix:
                    if ($this->arreglo_permisos[$fila]['tarea'] == 'eliminar') {
                        if (defined('_men_' . $this->arreglo_permisos[$fila]['permiso'] . '_' . $this->mod_id)) {
                            echo '&nbsp;<a href="javascript:confirma_eliminacion(' . "'" . $this->mod_id . "','" . $row[$j] . "','" . $this->id . "'" . ')" title="' . constant('_men_' . $this->arreglo_permisos[$fila]['permiso'] . '_' . $this->mod_id) . '">' . $this->arreglo_permisos[$fila]['icono'] . '</a>';
                        } else {
                            echo '&nbsp;<a href="javascript:confirma_eliminacion(' . "'" . $this->mod_id . "','" . $row[$j] . "','" . $this->id . "'" . ')" title="' . constant('_men_' . $this->arreglo_permisos[$fila]['permiso']) . '">' . $this->arreglo_permisos[$fila]['icono'] . '</a>';
                        }
                    } else {
                        if ($this->arreglo_permisos[$fila]['permiso'] <> "A") {
                            if (defined('_men_' . $this->arreglo_permisos[$fila]['permiso'] . '_' . $this->mod_id)) {
                                echo '&nbsp;<a href="' . _PAG_PRINCIPAL . '?mod_id=' . $this->mod_id . '&tarea=' . $this->arreglo_permisos[$fila]['tarea'] . '&id=' . $row[$j] . '&cpt=' . $this->id . '" title="' . constant('_men_' . $this->arreglo_permisos[$fila]['permiso'] . '_' . $this->mod_id) . '">' . $this->arreglo_permisos[$fila]['icono'] . '</a>';
                            } else {
                                echo '&nbsp;<a href="' . _PAG_PRINCIPAL . '?mod_id=' . $this->mod_id . '&tarea=' . $this->arreglo_permisos[$fila]['tarea'] . '&id=' . $row[$j] . '&cpt=' . $this->id . '" title="' . constant('_men_' . $this->arreglo_permisos[$fila]['permiso']) . '">' . $this->arreglo_permisos[$fila]['icono'] . '</a>';
                            }
                        }
                    }
                }
                /*                 * ----------------------------------- */
                echo '</center></td>';
                echo '</tr>';
            }
            $query->mover_siguiente();
        }
        $query->cerrar();
    }

    function validar_permisos() {
        if (trim($this->usuario->get_permisos($this->mod_id)) <> '') {
            $permisos = $this->usuario->get_permisos($this->mod_id);
            /*             * Leemos las opciones de los elementos y vemos si estos cumplen con los permisos asignados */
            for ($i = 0; $i < strlen($permisos); $i++) {
                /*                 * Generamos un script para cada opcion y posterior carga al arreglo de permisos */
                $query = new QUERY;
                /*                 * Cambiar a la nueva clase SQL */
                $sql1 = new SQL;
                $sql1->setS(array("opc_tarea", "opc_nombre", "opc_icono", "opc_permiso"));
                $sql1->setF(array("ad_opcion"));
                $sql1->setW(array("opc_estado", "opc_permiso"), array("=", "="), array("'H'", "'{$permisos[$i]}'"));
                $sql1->crearSQL();
                $sql1->cadena.=" and (opc_mod_id = '{$this->mod_id}' or opc_mod_id is null or opc_mod_id ='' ) ";


                $query->consulta($sql1->cadena);

                if ($query->num_registros() > 0) {
                    list($tarea, $nombre, $icono, $permiso) = $query->valores_fila();
                    $this->arreglo_permisos[$i]['tarea'] = $tarea;
                    $this->arreglo_permisos[$i]['icono'] = '<img width="20px" border="0" src="' . _url . '/graficos/' . $icono . '">';
                    $this->arreglo_permisos[$i]['permiso'] = $permiso;
                }
                $query->cerrar();
            }
        }
    }

    function obtienevalorcombo($i, $valor) {
        $query2 = new QUERY;
        $camp = '';
        $count = 0;
        $cons = '';
        for ($k = 0; $k < count($this->parametros[5][$i]) - 1; $k++) {
            $camp.=$this->parametros[5][$i][$k] . ' ,';
            $count++;
        };
        $camp = substr($camp, 0, -1);
        if ($camp == '')
            $camp = '*';
        $cons = "select {$camp} from {$this->parametros[5][$i][$k]} where {$this->parametros[1][$i]}='{$valor}'";
        if ($this->valores[5][$i][$k]) {
            $resultado = $query2->consulta($cons);
            $fila = $query2->valores_fila();
        }
        $camp = '';
        for ($k = 0; $k < count($this->parametros[5][$i]) - 1; $k++)
            $camp.=$fila[$k] . ' ';
        $query2->cerrar();
        return $camp;
    }

    function mostrar_busqueda($opc_espcific = '') {
        $modif = isset($modif) ? $modif : '';
        $sql = $modif;
        global $modulo, $tarea, $nombreform, $campo;
        $this->validar_permisos();
        $vall = count($this->parametros[0]);
        $vall2 = $vall + 1;
        if ($this->tipobus) {
            $tipobus = "?mod_id={$this->mod_id}&tarea=$tarea&nombreform=$nombreform&campo=$campo";
        } else {
            $this->barra->ventana->abrir();
            echo '<div align="right" id="status">';
            echo '<p>';
            for ($fila = 0; $fila < count($this->arreglo_permisos); $fila++) {
                if ($this->arreglo_permisos[$fila]['permiso'] == "A") {
                    echo '&nbsp;<a href="' . _PAG_PRINCIPAL . '?mod_id=' . $this->mod_id . '&tarea=' . $this->arreglo_permisos[$fila]['tarea'] . '&id=&cpt=' . $this->id . '" title="' . constant('_men_' . $this->arreglo_permisos[$fila]['permiso']) . '">' . $this->arreglo_permisos[$fila]['icono'];
                    echo '&nbsp;' . _men_nuevo;
                    echo '</a>&nbsp;';
                }
            }
            echo '&nbsp;<a href="' . _PAG_PRINCIPAL . '?mod_id=principal" title="' . constant('_men_cerrar') . '"><img width="20px" border="0" src="' . _url . '/graficos/back.png">';
            echo '&nbsp;' . _men_cerrar;
            echo '</a>&nbsp;';
            echo '</p>';
            echo '</div>';
            $this->barra->ventana->cerrar();
            $tipobus = "?mod_id={$this->mod_id}";
            if ($opc_espcific <> '') {
                $tipobus.="&opc={$opc_espcific}";
            }
        }
        $this->contenido2->ventana->abrir();
        echo "<center>
		 <form method=post name=$this->nombreform action='" . _PAG_PRINCIPAL . "{$tipobus}'>
		  <table width={$this->anchoform} border=0 cellpadding=0 cellspacing=0>
		     <tr>
		    	<th colspan='";
        echo $vall2;
        echo "' class=title>" . strtoupper($this->titulobus) . "</th>
			 </tr>
			 <tr>";
        for ($i = 0; $i < $vall; $i++) {
            echo "<td class=title>{$this->parametros[0][$i]}</td>";
        }
        echo " <td class=title></td>
			 </tr>";
        echo "<tr>";
        //para mostrar el index de paginas
        //echo "<td class=campo><input class=texto type=text size=3 maxlength=3 name='pag'></td>";
        for ($i = 0; $i < $vall; $i++) {
            /*             * Modificar con controles */
            echo '<td class=campo>&nbsp;&nbsp;';
            $parametros_control['nombre'] = $this->parametros[1][$i];
            $parametros_control['cant_caracteres'] = $this->parametros[2][$i];
            $parametros_control['tamano'] = $this->parametros[2][$i];
            $parametros_control['permiso'] = 0;
            $parametros_control['css'] = constant('_css_' . $this->parametros[3][$i]);
            //$parametros['defecto'];
            $parametros_control['tipo'] = $this->parametros[3][$i];
            if (($this->parametros[3][$i] == 5) or ($this->parametros[3][$i] == 17)) {
                if (is_string($this->parametros[5][$i])) {
                    unset($aux);
                    unset($aux1);
                    $q = new QUERY;
                    $sql = $this->parametros[5][$i];
                    $q->consulta($sql);
                    $aux[0] = '';
                    $aux1[0] = 'Todos';
                    for ($j = 1; $j <= $q->num_registros(); $j++) {
                        list($valorcombo, $datocombo) = $q->valores_fila();
                        $aux[$j] = $valorcombo;
                        $aux1[$j] = $datocombo;
                        //							print $aux1[$j];
                    }
                    $parametros_control['arreglo_valores'] = $aux;
                    $parametros_control['arreglo_mensajes'] = $aux1;
                } else {
                    $parametros_control['arreglo_valores'] = $this->parametros[5][$i]['valorcombo'];
                    $parametros_control['arreglo_mensajes'] = $this->parametros[5][$i]['datocombo'];
                }
            }
            $parametros_control['columnas'] = $this->parametros[2][$i];
            //$parametros_control['formulario']=$this->nombre;
            $parametros_control['formulario'] = $this->nombreform;
            $this->controles->cargar_parametros($parametros_control);
            $this->controles->dibujar_control();
            echo '</td>';
        }
        echo " <td class=title><input class=boton type=submit id=envio name=buscar value='" . _men_buscar . "' ></td>";
        $this->generar_sql();
        $this->mostrar_resultados();
        echo "</tr></table></form>";
        $this->leyendas();
        echo "</center>";
        $this->contenido2->ventana->cerrar();
    }

    function leyendas() {
        for ($fila = 0; $fila < count($this->arreglo_permisos); $fila++) {
            if ($this->arreglo_permisos[$fila]['permiso'] <> "A") {
                echo ' | ';
                //modificado por Felix:
                if (defined('_men_' . $this->arreglo_permisos[$fila]['permiso'] . '_' . $this->mod_id)) {
                    echo constant('_men_' . $this->arreglo_permisos[$fila]['permiso'] . '_' . $this->mod_id) . " : " . $this->arreglo_permisos[$fila]['icono'];
                } else {
                    echo constant('_men_' . $this->arreglo_permisos[$fila]['permiso']) . " : " . $this->arreglo_permisos[$fila]['icono'];
                }
            }
        } echo

        ' |';
    }

    function cargar_paginas($num_registros, $num_columnas) {
        require_once("paginacion.php");
        $paginacion = new PAGINACION($num_registros, $this->reg_pagina);
        $num_paginas = $paginacion->getnum_paginas();
        $paginacion->paginar($num_columnas);
        $this->pagina = $paginacion->getpag();
    }

}

;
?>
