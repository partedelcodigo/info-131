<?PHP
/* * *******************************************************************
 *                                                                    *
 *                   CONTROL COMBOS ENLAZADOS                         *
 *                                                                    *
 *                                                                    *
 *                                                                    *
 *                                                                    *
 * ******************************************************************* */

class combo_link {

    var $lenguaje;   //archivo de lenguaje
    var $config_db;   //configuracion de la base de datos
    /*
      array de la configuracion de la base de datos
      $config_db['host']='hostpgsql';
      $config_db['basedatos']='bdpgsql';
      $config_db['usuario']='userpgsql';
      $config_db['contrasena']='passpgsql';
      $config_db['port']='portpgsql';
     */
    var $bdhost;
    var $bdbase;
    var $bduser;
    var $bdpass;
    var $bdport;
    var $valores_vacio;  //datos a mostrar cuando no se cargue el control
    var $valores_lleno;  //datos a mostrar cuando se cargue el control
    var $valores;
    var $url;    //archivo php a ejecutar
    var $url_final;   //archivo php a ejecutar despues de que se hayan seleccionado todos los combos

    function combo_link($url, $lenguaje, $configdb) {
        $this->lenguaje = $lenguaje;
        $this->config_db = $configdb;
        $this->url = $url;
    }

    function cargar_valores($valores_) {
        $this->valores = $valores_;
        $this->valores_vacio = $valores_['vacio'];
        $this->valores_vacio = $valores_['lleno'];
        $this->url_final = $this->valores[4];
    }

    function mostrar() {
        $nivel = 0;
        if ($_GET['nivel'])
            $nivel = $_GET['nivel'];
        $this->cargar_datos($nivel);
    }

    function cargar_datos($nivel) {
        //echo $nivel;
        //si el nivel es 0 mostrar todos, el primero con datos y el resto vacio
        if ($nivel <= 0) {
            $this->bdhost = _hostpgsql;
            $this->bdbase = _bdpgsql;
            $this->bduser = _userpgsql;
            $this->bdpass = _passpgsql;
            $this->bdport = _portpgsql;
            $num_combos = count($this->valores[0]);
            //echo $num_combos;
            echo "<table width='100%'>";
            //primer nivel
            echo "<tr><th colspan=50 class=title>" . $this->valores['titulo'] . "</th></tr>";
            echo "<tr>";
            echo "<td>"; //titulo
            echo $this->valores[1][0];
            echo "</td>";
            echo "<td>"; //combobx
            echo "<div id='div_cl_" . $this->valores[0][0] . "'>"; //combobx
            $this->dibujar_combo(0);
            echo "</div>"; //combobx
            echo "</td>";
            echo "</tr>";
            for ($i = 1; $i < ($num_combos - 1); $i++) {
                echo "<tr>";
                echo "<td>"; //titulo
                echo $this->valores[1][$i];
                echo "</td>";
                echo "<td>"; //combobx
                echo "<div id='div_cl_" . $this->valores[0][$i] . "'>"; //combobx
                echo $this->genera_div_vacio($i);
                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            //dibuja el ultimo parametro como un div pero con otra respuesta definida por el usuario
            echo "<div id='div_cl_" . $this->valores[0][$num_combos - 1] . "'>"; //combobx
            echo $this->genera_div_vacio($num_combos - 1);
            echo "</div>";
        } else {
            //en caso de que el nivel sea superior
            require_once($this->lenguaje);
            require_once($this->config_db);
            $this->bdhost = _hostpgsql;
            $this->bdbase = _bdpgsql;
            $this->bduser = _userpgsql;
            $this->bdpass = _passpgsql;
            $this->bdport = _portpgsql;
            //solo generara para el nivel especifico
            $this->dibujar_combo($nivel);
        }
    }

    function genera_div_vacio($idcom) {
        //si es el ultimo campo,no dibuja nada
        $temp = "";
        if ($idcom < count($this->valores[0]) - 1) {
            $temp = "<select name=com_cl_" . $this->valores[0][$idcom] . " id=com_cl_" . $this->valores[0][$idcom] . " disabled style=width:" . $this->valores[2][$idcom] . "px>" .
                    "<option>" . _men_esperando . "</option>"
                    . "</select>";
        }
        return $temp;
    }

    function dibujar_combo($idcombo) {
        $num_combos = count($this->valores[0]);
        //definimos la ruta de destino
        if ($idcombo == ($num_combos - 2)) {
            $destino = $this->url_final;
        } else {
            $destino = $this->url;
        }
        //echo $destino;
        //echo $this->valores[3][$idcombo];
        //solo dibuja si ha seleccionado un option con valor en el combo anterior, sino dibuja el div vacio
        if (($idcombo > 0) && !($_GET["" . $this->valores[0][$idcombo - 1]])) {
            echo $this->genera_div_vacio($idcombo);
        } else {
            $concat = $this->hayOtrosDatosGet($destino);
            /* echo "<script>alert('".$concat."');</script>"; */
            echo "<select name='com_cl_" . $this->valores[0][$idcombo] . "' id='com_cl_" . $this->valores[0][$idcombo] . "' style=width:" . $this->valores[2][$idcombo] . "px";
            //aki comienza el javascript del ajax
            echo " onchange=\"javascript:cargarCombo('" . $destino . $concat . "nivel=" . ($idcombo + 1) . "'," . //url que cargara
            //echo " onchange=\"javascript:cargarCombo('".$destino.$this->hayOtrosDatosGet($destino)."nivel=".($idcombo+1)."',".			//url que cargara
            "'div_cl_" . $this->valores[0][$idcombo + 1] . "'," . //div que va a cambiar
            "new Array(";
            $valores_pasar = "";
            for ($j = 0; $j <= $idcombo; $j++) {
                $valores_pasar.="'com_cl_" . $this->valores[0][$j] . "',";      //nombre del elemento del parametro a mandar
            }
            $valores_pasar = substr($valores_pasar, 0, strlen($valores_pasar) - 1);
            echo $valores_pasar;
            echo ")," .
            "new Array(";
            $valores_pasar = "";
            for ($j = 0; $j <= $idcombo; $j++) {
                $valores_pasar.="'" . $this->valores[0][$j] . "',"; //borrado el com_cl						
            }
            $valores_pasar = substr($valores_pasar, 0, strlen($valores_pasar) - 1);
            echo $valores_pasar;
            echo ")," . //parametro a mandar para generar el query
            "new Array(";
            $divs_limpiar = "";
            for ($j = $idcombo + 1; $j < $num_combos; $j++) {
                $divs_limpiar.="'div_cl_" . $this->valores[0][$j] . "',";
            }
            $divs_limpiar = substr($divs_limpiar, 0, strlen($divs_limpiar) - 1);
            echo $divs_limpiar;
            echo ")," . //divs a limpiar cuando este div se escoja
            "new Array(";
            $datos_divs_vacios = "";
            for ($j = $idcombo + 1; $j < $num_combos; $j++) {
                $datos_divs_vacios.="'" . $this->genera_div_vacio($j) . "',";
            }
            $datos_divs_vacios = substr($datos_divs_vacios, 0, strlen($datos_divs_vacios) - 1);
            echo $datos_divs_vacios;
            echo "));\"";
            echo ">";
            //llenando el combo
            echo utf8_encode("<option value=''>" . _men_seleccione . "</option>");
            if (isset($this->valores[3][$idcombo])) {
                if (is_string($this->valores[3][$idcombo])) {
                    $query = $this->valores[3][$idcombo];
                    $idcon = pg_Connect('host=' . $this->bdhost . ' port=' . $this->bdport .
                            ' dbname= ' . $this->bdbase . ' user= ' . $this->bduser . ' password = ' . $this->bdpass);
                    @$result = pg_query($idcon, $query);
                    $num = pg_num_rows($result);
                    @pg_close($idcon);
                    $k = 0;
                    while ($k < $num) {
                        $fila = @pg_fetch_row($result);
                        echo utf8_encode("<option class=combo value=" . $fila[0] . ">" . $fila[1] . "</option>");
                        $k++;
                        $result++;
                    }
                } else {
                    for ($j = 0; $j < count($this->valores[3][$idcombo]['valorcombo']); $j++) {
                        echo utf8_encode("<option class=combo value='{$this->valores[3][$idcombo]['valorcombo'][$j]}'>{$this->valores[3][$idcombo]['datocombo'][$j]}</option>");
                    }
                }
            }

            echo "</select>";
        }
    }

    function hayOtrosDatosGet($dat = "") {
        if ((strpos($dat, "?")) === false) {
            return "?";
        } else {
            return "&";
        }
    }

}
?>
<script type="text/javascript">
    var peticion = false;
    try 
    {
        peticion = new XMLHttpRequest();
    } 
    catch (trymicrosoft) 
    {
        try 
        {
            peticion = new ActiveXObject("Msxml2.XMLHTTP");
        } 
        catch (othermicrosoft) 
        {
            try 
            {
                peticion = new ActiveXObject("Microsoft.XMLHTTP");
            } 
            catch (failed) 
            {
                peticion = false;
            }
        }
    }
    if (!peticion)
        alert("ERROR AL INICIALIZAR!");
		
    function cargarCombo(url, element_id, comboAnterior, field_id,otro_id,otro_limpia)
    {
        //Obtenemos el contenido del div
        //donde se cargaran los resultados
        var element =  document.getElementById(element_id);
        //limpia los combos--->deberia limpiar la lista de tabla
        for (i=0;i<otro_id.length;i++)
        {
            if (otro_id[i].length>0)
            {
                //alert (otro_id[i].length);
                var otro = document.getElementById(otro_id[i]);
                otro.innerHTML=otro_limpia[i];
            }
        }
        //construimos la url definitiva
        //pasando como parametro el valor seleccionado
        //Obtenemos el valor seleccionado del combo anterior
        var valordepende = document.getElementById(comboAnterior[0]);
        var x = valordepende.value;
        var fragment_url = url+'&'+field_id[0]+'='+x;
        var txt='';
        var txt2='';
        for (i=1;i<comboAnterior.length;i++)
        {
            if (comboAnterior[i].length>0)
            {
                var valordepende = document.getElementById(comboAnterior[i]);
                var x = valordepende.value;
                fragment_url = fragment_url +'&'+field_id[i]+'='+x;
            }
        }
        //document.write ("hola");
        element.innerHTML = '<img src="modulo/reportes/loading.gif">';//se puede poner una imagen de cargando...
        //abrimos la url
        peticion.open("GET", fragment_url);
        peticion.onreadystatechange = function()
        {
            if (peticion.readyState == 4)
            {
                //escribimos la respuesta
                element.innerHTML = peticion.responseText;
                //cambiar por el unicode para las fuentes
                //txt=unescape(peticion.responseText);
                //txt2=txt.replace(/+/gi," ");
                //element.innerHTML=txt2;  
            }
        }
        peticion.send(null);
    }
</script>
