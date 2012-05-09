<?php
@header("Content-Type: text/html; charset=utf-8");

require_once 'clases/StrFunc.php';

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
    var $modi=array();
    function FORMULARIO() {
        $this->controles=array();
        $this->error='';

    }

    function inicializa_auto($mod_id) {
        $q=new QUERY;
        $sql="SELECT * from ad_elemento where ele_descripcion='$mod_id'";

        $q->consulta($sql);

        if($q->num_registros()>0) {
            $r=$q->valores_row();
            
            /**
             * Obtiene el nombre del campo que es primary key de la tabla $mod_id
             */
            $llave=$r['ele_llave'];
            
            
            $id_mod=$r['ele_id'];
        }
        
        //$this->inicializa($mod_id, _reg_especie_ing_titulo, array("ba_especie"), "formulario", _msg_comp, "100%");
        $this->inicializa($mod_id, constant("_".$mod_id."_ing_titulo"), array($mod_id), "formulario", _msg_comp, "100%");
        
        /**
         * Obtiene informacion del modulo para generar el formulario
         */
        $sql="SELECT * from adm_registro where borrado=0 AND ele_id='$id_mod'";
        //echo "<br>--->" . $sql;
        $q->consulta($sql);
        $valores=array();
        if($q->num_registros()>0) {
            while($r=$q->valores_row()){
                $valores[0][]=$r['titulo'];//esto puede ser concatenado par alos idiomas
                $valores[1][]=$mod_id.".".$r['campo'];
                $valores[2][]=$r['ancho'];
                $valores[3][]=$r['tipo'];
                $valores[4][]=$r['requerido'];
                $valores[5][]=$r['relacion'];
            }
            
            $valores[9] = array("index.php?mod_id=$mod_id");
        }
        $this->cargar_valores($valores);
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
        /*echo '<script>alert("'.$nuevo_origen.'");</script>';*/
        return $nuevo_origen;
    }

    function cargar_valores($valores) {
        $this->valores=$valores;
        $this->redireccion=(isset($valores[_REDIRECCION][0]))?$valores[_REDIRECCION][0]:'';
        for($i=0;$i<count($valores[0]);$i++) {
            $parametros_control['nombre']=$this->get_nombre_campo($this->valores[_NOMBRES][$i]);
            $parametros_control['cant_caracteres']=(isset($this->valores[_CANT_CARACTERES][$i]))?$this->valores[_CANT_CARACTERES][$i]:'';
            $parametros_control['tamano']=(isset($this->valores[_TAMANO][$i]))?$this->valores[_TAMANO][$i]:'';
            $parametros_control['permiso']=(isset($this->valores[_PERMISO][$i]))?$this->valores[_PERMISO][$i]:'';
            $parametros_control['css'] = @constant( '_css_' . $this -> valores[_TIPO][$i] );
            $parametros_control['defecto']=(isset($this->valores[_VALORES_DEFECTO][$i]))?$this->valores[_VALORES_DEFECTO][$i]:'';
            $parametros_control['tipo']=$this->valores[_TIPO][$i];
            $parametros_control['tip']=(isset($this->valores[_REFERENCIA][$i]))?$this->valores[_REFERENCIA][$i]:'';
            $parametros['mensaje']=$this->valores[_MENSAJES][$i];
            $parametros_control['columnas']=50;
            $parametros_control['filas']=4;
            $parametros_control['formulario']=$this->nombreform;
            /**manejo de los arreglos de valores y de mensajes*/
            $parametros_control['arreglo_valores']=$this->cargar_valores_arreglo($valores,$i);
            $parametros_control['arreglo_mensajes']=$this->cargar_mensajes_arreglo($valores,$i);
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
                    //echo "<br>--->" . _CONF_COMBOS;
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
                    $arreglo_valores=(isset($valores[_CONF_COMBOS][$i]))?$valores[_CONF_COMBOS][$i]:'';
                    break;
                }
            case 17: {
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

        }
        return $arreglo_valores;
    }

    function cargar_mensajes_arreglo($valores,$i) {
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
            case 17: {
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
        }
        return $arreglo_valores;
    }

    function get_lista_campos() {
        $cadena='';
        for ($i=0;$i<count($this->controles);$i++) {
            $cadena.=$this->get_nombre_campo($this->valores[_NOMBRES][$i]).',';
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
                        if (trim($lista_de_tablas)=='ad_usuario')
                            $aux="'".$this->id."'";
                        else
                            $aux=$this->id;
                    }
                    $sql='SELECT '.$lista_de_campos.
                            ' FROM '.$lista_de_tablas.
                            ' WHERE '.$this->cpt.' = '.$aux;
                    //echo $sql;
                    if (isset($this->valores['where']) && $this->valores['where']) {
                        $sql.= " and ".$this->valores['where'][0];
                        //echo "########################<br>".$sql;
                    }
                    $query->consulta($sql);
                    if($query->num_registros()>0) {
                        //echo "########################<br>".$sql;
                        $arreglo=$query->valores_fila();

                        $modificado='';
                        //$modi=Array();
                        for($i=0;$i<count($this->nombretablas);$i++) {
                            $modificado.=$this->nombretablas[$i]."\n############\n";
                            $campos=$this->get_lista_campos_tabla($this->nombretablas[$i],$this->valores[_NOMBRES]);
                            for($j=0;$j<count($arreglo);$j++) {
                                $modificado.=$campos[$j]."=".$arreglo[$j]."\n";
                                $modi[$j]=$arreglo[$j];
                                //echo $modi[$j];
                            }
                        }

                        //echo $modificado;
                        //######### GASTON
//		$hoy = date("Y-m-d H:i:s");
                        //$modificado='';
//		$L = new QUERY;
//		$insert = "insert into fr_segimiento(seg_loc_id,seg_usu_id,seg_fecha_mod,seg_mod)values
//					(".$_GET['id'].",".$_SESSION['per_id'].",'".$hoy."','".$modificado."'); ";
                        //'hola'); ";
                        //echo $insert;
                        //echo 'generasql';
                        //$L->consulta($insert);
                        //##################
                    }
                    else {
                        /* echo'<script>alert("'._men_no_existe__registro.'")</script>';*/
                    }
                    break;
                }
            case 'UPDATE': {/**Se subdivide la lista de campos a las tablas que pertenecen*/
                    $sql=array();
                    $modi2=array();
                    $campos1=array();
                    $modificado='';
                    
                    for($i=0;$i<count($this->nombretablas);$i++) {
                        
                        $sql[$i]='UPDATE '.$this->nombretablas[$i].' ';
                        $modificado.=$this->nombretablas[$i];
                        $campos=$this->get_lista_campos_tabla($this->nombretablas[$i],$this->valores[_NOMBRES]);
                        $campos1=$campos;
                        $sql[$i].='set ';
                        
                        for($j=0;$j<count($campos);$j++) {		//echo"MODIFICAR";
                            //echo $campos[$j];
                            //echo $modi[$j];
                            
                            $modi2[$j]=$this->controles[$j]->get_valor_control();
                            
                            # verifica si el campo actual es el la llave primaria de la tabla
                            if(trim($campos[$j])==trim($this->cpt)) {
                                $sql[$i].=$campos[$j]."='".$this->id."',";
                            }
                            else {
                                # verificamos el tipo campo
                                switch ($this->controles[$j]->tipo) {
                                    # para el campo de tipo password
                                    case 6:  
                                        $sql[$i].=$campos[$j]."='".md5($this->controles[$j]->get_valor_control())."',";
                                        break;
                                    
                                    # para el campo de tipo upload file
                                    case 22:
                                        /*echo '<br>el array de archivos<pre>';
                                        print_r($_FILES);
                                        echo '</pre>';*/
                                        /*echo '<pre>';
                                        print_r($_POST);
                                        echo '</pre>';*/
                                        //--exit;
                                        
                                        $imageAction = (int) StrFunc::getp('image_action');
                                        
                                        switch($imageAction) {
                                            # carga la imagenes y retorna el nombre utilizado
                                            case 0: # para nueva imagen
                                                include_once('class_upload.php');
                                        
                                                $upload_class = new Upload_Files; 
                                                $upload_class->temp_file_name = trim($_FILES['imagen']['tmp_name']);
                                                $upload_class->file_name = trim(strtolower($_FILES['imagen']['name']));
                                                $upload_class->upload_dir = ImageConfig::$ImagePath."/";
                                                $upload_class->upload_log_dir = ImageConfig::$ImagePath."/upload_logs/";

                                                # establecemos como tamaño maximo 8 megas
                                                $upload_class->max_file_size = 8000000;
                                                $upload_class->banned_array = array("");
                                                $upload_class->ext_array = array(".jpg",".gif",".jpeg",".png");


                                                //--$valid_ext = $upload_class -> validate_extension();
                                                //--$valid_size = $upload_class->validate_size();
                                                //--$valid_user = $upload_class->validate_user();
                                                //--$max_size = $upload_class->get_max_size();
                                                //--$file_size = $upload_class->get_file_size();
                                                //--$upload_directory = $upload_class->get_upload_directory();
                                                //--$upload_log_directory = $upload_class->get_upload_log_directory();
                                                $upload_file = $upload_class->upload_file_with_validation();


                                                if($upload_file) {
                                                    $newFileName = $upload_class -> file_name;

                                                    $sql[$i].=$campos[$j]."='".$newFileName."',";
                                                }
                                                else
                                                    $sql[$i].=$campos[$j]."=null,";
                                                
                                                break;
                                            
                                            case 1: # para cambio de imagen
                                                # borramos las imagenes previamente cargadas
                                                $lastImage = StrFunc::getp('last_image');
                                                    
                                                # borramos la imagen relacionada
                                                if ( @!unlink( ImageConfig::$ImagePath . '/' . $lastImage ) || @!unlink( ImageConfig::$ImagePath . '/medium_' . $lastImage ) ||
                                                     @!unlink( ImageConfig::$ImagePath . '/large_' . $lastImage ) ) {
                                                    //--echo '<br>ocurrio un error al borrado ';
                                                }
                                                
                                                include_once('class_upload.php');
                                        
                                                $upload_class = new Upload_Files; 
                                                $upload_class->temp_file_name = trim($_FILES['imagen']['tmp_name']);
                                                $upload_class->file_name = trim(strtolower($_FILES['imagen']['name']));
                                                $upload_class->upload_dir = ImageConfig::$ImagePath."/";
                                                $upload_class->upload_log_dir = ImageConfig::$ImagePath."/upload_logs/";

                                                # establecemos como tamaño maximo 8 megas
                                                $upload_class->max_file_size = 8000000;
                                                $upload_class->banned_array = array("");
                                                $upload_class->ext_array = array(".jpg",".gif",".jpeg",".png");


                                                //--$valid_ext = $upload_class -> validate_extension();
                                                //--$valid_size = $upload_class->validate_size();
                                                //--$valid_user = $upload_class->validate_user();
                                                //--$max_size = $upload_class->get_max_size();
                                                //--$file_size = $upload_class->get_file_size();
                                                //--$upload_directory = $upload_class->get_upload_directory();
                                                //--$upload_log_directory = $upload_class->get_upload_log_directory();
                                                $upload_file = $upload_class->upload_file_with_validation();


                                                if($upload_file) {
                                                    $newFileName = $upload_class -> file_name;

                                                    $sql[$i].=$campos[$j]."='".$newFileName."',";
                                                }
                                                else
                                                    $sql[$i].=$campos[$j]."=null,";
                                                
                                                break;
                                                
                                            # borra la imagen y pone el registro en NULL
                                            case 2:
                                                $lastImage = StrFunc::getp('last_image');
                                                    
                                                # borramos la imagen relacionada
                                                if ( @!unlink( ImageConfig::$ImagePath.'/' . $lastImage ) || @!unlink( ImageConfig::$ImagePath.'/medium_' . $lastImage ) ||
                                                     @!unlink( ImageConfig::$ImagePath.'/large_' . $lastImage ) ) {
                                                    //--echo '<br>ocurrio un error al borrado ';
                                                }

                                                $sql[$i].=$campos[$j]."=null,";
                                                
                                                break;
                                        }
                                        
                                        break;
                                    
                                    default:
                                        $e = $this->controles[$j]->get_valor_control();
                                        if ($e == "") {
                                            $sql[$i].=$campos[$j]."=null,";
                                        }
                                        else {
                                            $sql[$i].=$campos[$j]."='".$e."',";
                                        }
                                        break;
                                }
                            }
                        }
                        
                        $sql[$i]=substr($sql[$i],0,strlen($sql[$i])-1);
                        $sql[$i].=' WHERE '.$this->cpt."='".$this->id."'";

                        if (isset($this->valores['where']) && $this->valores['where']) {
                            $sql[$i].= " and ".$this->valores['where'][0];
                        }
                        
                        //--echo '<br>consulta-> '; print_r($sql); exit;
                        
                        /**Proceso para jalar los valores*/
                        /*echo'<script>alert("'.$sql[$i].'")</script>';*/

                    } 
                    
                    $arreglo=$sql;
                    //###########################################################
                    //REFERENCIA#######################333
                    //echo $antes[$j];
                    $query=new QUERY;
                    $aux=$this->id;
                    $sql1='SELECT '.$lista_de_campos.
                            ' FROM '.$lista_de_tablas.
                            ' WHERE '.$this->cpt.' = '.$aux;
                    //echo "SQL";
                    //echo $sql1;

                    $query->consulta($sql1);

                    if($query->num_registros()>0) {

                        //echo "########################<br>".$sql;
                        $arreglo1=$query->valores_fila();

                        $modificado='';
                        //echo 'arreglo1=  ';
                        for($i=0;$i<count($this->nombretablas);$i++) {
                            //echo "moyor 0";
                            $modificado.=$this->nombretablas[$i]."\n############\n";
                            //$campos=$this->get_lista_campos_tabla($this->nombretablas[$i],$this->valores[_NOMBRES]);
                            for($k=0;$k<count($arreglo1);$k++) {
                                //echo "DENTRO K 0".$arreglo1[$k];
                                //$modificado.=$campos[$j]."=".$arreglo[$j]."\n";
                                $modi[$k]=$arreglo1[$k];
                                //echo $modi[$k];
                                //echo $modi2[$k];
                                //$campos1=$this->get_lista_campos_tabla($this->nombretablas[$i],$this->valores[_NOMBRES]);
                                //echo $campos1[$k]
                                if (trim($modi[$k])!=trim($modi2[$k])) {	//echo "CAMBIO";
                                    $modificado.=$campos1[$k]."=".$modi[$k]."\n";
                                }else {//echo "NO CAMBIO";
                                }
                            }
                        }
                    }
                    break;
                }
            case 'INSERT': {
                    /**Se subdivide la lista de campos a las tablas que pertenecen*/
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
                                
                                #verificamos la cadena de consulta dependiendo del tipo de campo
                                switch($this->controles[$j]->tipo) {
                                    case 6:
                                        $sql[$i].="'".md5($this->controles[$j]->get_valor_control())."',";
                                        break;
                                    
                                    default :
                                        $sql[$i].="'".$this->controles[$j]->get_valor_control()."',";
                                        break;
                                }
                            }
                            elseif ( $this -> controles[$j] -> tipo == 22 ) {
                                # para el tipo de dato imagen
                                include_once('class_upload.php');
                                        
                                $upload_class = new Upload_Files; 
                                $upload_class->temp_file_name = trim($_FILES['imagen']['tmp_name']);
                                $upload_class->file_name = trim(strtolower($_FILES['imagen']['name']));
                                $upload_class->upload_dir = ImageConfig::$ImagePath."/";
                                $upload_class->upload_log_dir = ImageConfig::$ImagePath."/upload_logs/";

                                # establecemos como tamaño maximo 8 megas
                                $upload_class->max_file_size = 8000000;
                                $upload_class->banned_array = array("");
                                $upload_class->ext_array = array(".jpg",".gif",".jpeg",".png");


                                //--$valid_ext = $upload_class -> validate_extension();
                                //--$valid_size = $upload_class->validate_size();
                                //--$valid_user = $upload_class->validate_user();
                                //--$max_size = $upload_class->get_max_size();
                                //--$file_size = $upload_class->get_file_size();
                                //--$upload_directory = $upload_class->get_upload_directory();
                                //--$upload_log_directory = $upload_class->get_upload_log_directory();
                                $upload_file = $upload_class->upload_file_with_validation();


                                if($upload_file) {
                                    $newFileName = $upload_class -> file_name;

                                    $sql[$i].="'".$newFileName."',";
                                }
                                else
                                    $sql[$i].=$campos[$j]."=null,";
                            }
                            else {
                                //$sql[$i].="'null',";
                                $sql[$i].="'',";
                            }
                            /*echo '<script>alert("'.$this->controles[$j]->get_valor_control().'");</script>';*/
                        }
                        $sql[$i]=substr($sql[$i],0,strlen($sql[$i])-1);
                        /**Proceso para jalar los valores*/
                        $sql[$i].=')';
                        /*echo '<script>alert("'.$sql[$i].'");</script>'; exit();*/
                        //echo $sql[$i];exit();
                    }
                    //--echo $sql[0]; exit;
                    $arreglo=$sql;

                    break;
                }
            case 'DELETE': {
                    /**
                     * Changed by @Juan
                     * Before: $f = split("_",$this->cpt);
                     * Now: $f = explode("_",$this->cpt);
                     */

                    $f = explode("_",$this->cpt);
                    $sql=array();
                    $campos=$lista_de_campos;
                    $tablas = $lista_de_tablas;
                    
                    # inicializa las variables de control
                    $this -> inicializa_auto( 'mod_especies' );
                    
                    /**Se genera la lista de campos*/
                    for($i=0;$i<count($this->nombretablas);$i++) {
                        
                        # obtenemos los valores del registro actual
                        $elements = $this -> generar_sql('SEE');
                        
                        # verificamos si tenemos un campo de tipo imagen
                        for($j=0;$j<count($this->controles);$j++) {
                            
                            # si tenemos un campo de tipo imagen
                            if ( $this -> controles[$j] -> tipo == 22 ) {
                            
                                # borramos la imagen relacionada
                                if ( @!unlink( ImageConfig::$ImagePath.'/' . $elements[$j] ) || @!unlink( ImageConfig::$ImagePath.'/medium_' . $elements[$j] ) ||
                                        @!unlink( ImageConfig::$ImagePath.'/large_' . $elements[$j] ) ) {
                                    //--echo '<br>ocurrio un error al borrado ';
                                }
                            }
                        }
                        
                        $sql[$i]='DELETE FROM ';
                        $sql[$i].=$this->nombretablas[$i];
                        $sql[$i].=" where ".$this->cpt.'='."'$this->id'";
                    }
                    /**Se subdivide la lista de campos a las tablas que pertenecen*/
                    $arreglo=$sql;
                    //--echo $sql[0]; exit;
                    break;
                }
        }
        // echo $sql[0]; exit;
        $query->cerrar();
        return $arreglo;
    }

    function redireccionar() {
        echo '<script>';
        echo "location.href='".$this->redireccion."'";
        echo '</script>';
    }

    function dibujar_formulario($opcion) {
        echo '<form method="post" name="'.$this->nombreform.'" enctype="multipart/form-data" action="'._PAG_PRINCIPAL.'?mod_id='.$this->mod_id.'&tarea='.$this->tarea.'&id='.$this->id.'&cpt='.$this->cpt.'">';
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
        /*Carga de controles*/
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
        //echo "<input class=boton name=Continuar type=button value='"._men_volver."' onclick=\"location='"._PAG_PRINCIPAL."?mod_id={$this->mod_id}' \"/><br>";
        echo "<input class=boton name=Continuar type=button value='"._men_volver."' onclick=\"location='javascript:history.go(-1)' \"/><br>";
        echo '</div>';
        echo '</form>';
        echo '<br>';
        echo '<br>';
    }

    function mostrar_formulario($opcion=0) {
        $this->cpt=(isset($_GET['cpt']))?$_GET['cpt']:'';
        $this->id=(isset($_GET['id']))?$_GET['id']:'';
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

                    $arreglo_valores=$this->generar_sql('SEE');
                    for($i=0;$i<count($this->controles);$i++) {
                        /*asignamos un valor por defecto y recargamos el control*/
                        $antes[$i]=$arreglo_valores[$i];
                        //echo $antes[$i];
                    }


                    $arreglo_sql=$this->generar_sql('UPDATE');

                    /**Se realiza la modificacion del Registro ejecutando 1 a 1 las consultas*/
                    $query=new QUERY;
                    for($i=0;$i<count($arreglo_sql);$i++) {
                        //	echo $antes[$i];
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
            else { //--echo 'hola';
                
                $arreglo_valores=$this->generar_sql('SEE');
                /*echo '<pre>'; print_r($arreglo_valores); echo '</pre>';*/
                
                for($i=0;$i<count($this->controles);$i++) {
                    /*asignamos un valor por defecto y recargamos el control*/
                    $this->controles[$i]->defecto=$arreglo_valores[$i];
                    
                    $antes[$i]=$arreglo_valores[$i];
                    //echo $arreglo_valores[$i];
                    //echo $antes[$i];
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
                /*echo '<script>alert("'.$this->controles[$i]->control_valido().'");</script>';*/
                $form_valido=true;
            }
            else {
                $men='_'.$this->get_nombre_campo($this->valores[_NOMBRES][$i]);
                echo "<br>--->" . $men;
                if (defined($men)) {
                    $this->error.=_men_campo_invalido.' -> '.constant($men).'<br>';
                }
                else {
                    echo '<h2>'._def_no.'</h2>';
                }
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
        $muestra=isset($muestra)?$muestra:'';
        $this->redireccion=_PAG_PRINCIPAL."?mod_id=".$this->mod_id;
        $this->cpt=$_GET['cpt'];
        $this->id=$_GET['id'];
        $query=new QUERY;
        //$resultado=$query->consulta($sql);
        $arreglo_sql=$this->generar_sql('DELETE');
        /**Se realiza la modificacion del Registro ejecutando 1 a 1 las consultas*/
        $query=new QUERY;
        for($i=0;$i<count($arreglo_sql);$i++) {
            $verificar=$query->consulta($arreglo_sql[$i]);
            /*echo '<script>alert("'.$arreglo_sql[$i].'--'.$verificar.'");</script>';*/
        }
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
    function consulta_formulario() {
        $this->cpt=$_GET['cpt'];
        $this->id=$_GET['id'];
        $this->tarea='ejecutar';
        $tipo=$_POST['tipo'];
        if ($tipo==1) {
            /*
    		for ($i=0;$i<count($this->valores[0]);$i++)
			{
				echo $this->valores[0][$i];
				echo $_POST[$this->valores[0][$i]]."<br>";
				echo $this->controles[$i]->get_valor_control();
			}
            */
            require_once("clases/reporte.php");
            $rep=new REPORTE;
            $query1=new QUERY;
            $sql="select con_options,con_query from ad_consulta where con_id like '".$_GET["id"]."'";
            $query1->consulta($sql);
            list ($options, $sql_query) = $query1->valores_fila();
            $query1->cerrar();
            $rep->cargar_sql($sql_query,$options);
            for ($i=0;$i<count($this->valores[1]);$i++) {
                $rep->reemplazar_parametros1('@'.trim($this->controles[$i]->nombre),"'".$this->controles[$i]->get_valor_control()."%'");
            }
            //$rep->reemplazar_parametros1('@CAMPO',"'".$_POST['CAMPO']."%'");
            $rep->ejecutar_sql();
            //print $rep->sql;
        }
        else {
            /**aca se genera la consultq SQL y se setean lo datos para mostrar*/
            for($i=0;$i<count($this->controles);$i++) {
                $this->controles[$i]->set_permiso(1);
                $this->controles[$i]->defecto=$arreglo_valores[$i];
                $this->controles[$i]->cargar_control();
            }
            $this->dibujar_formulario(1);
        }
    }

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
            //echo "<img src='$tot' alt='fotografia'>";
            echo '<a href="#" onClick=window.open("'._rutaraiz.'/componentes/subidor.php?mod_id='.$this->mod_id.'&tarea='.$this->tarea.'&id='.$id.'&cpt='.$this->cpt.'&lid='.$lid.'&eme=eme","Alertas","toolbar=no,width=400,height=100,scrollbars=no")><img width=200 src='.$tot.'></a>';


        }
        else {
            if($opcion==1 and $id<>"") {
                echo '<a href="#" onClick=window.open("'._rutaraiz.'/componentes/subidor.php?mod_id='.$this->mod_id.'&tarea='.$this->tarea.'&id='.$id.'&cpt='.$this->cpt.'&lid='.$lid.'&eme=eme","Alertas","toolbar=no,width=400,height=100,scrollbars=no")><img width=200 src='.$alt.'></a>';
            }
            else {
                echo "<img src='$alt' alt='fotografia'>";
            }
        }

    }

}
?>
