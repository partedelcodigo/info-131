<?php
@header("Content-Type: text/html; charset=utf-8");
if (file_exists(_rutaraiz . '/clases/persona.php'))
    require_once(_rutaraiz . '/clases/persona.php');

if (file_exists(_rutaraiz . '/define/config_db.php'))
    require_once (_rutaraiz . '/define/config_db.php');

//set_time_limit(120);	
set_time_limit(240); //aumente el tiempo de consultas a 240 .... gaston
$SQL_Debug = 1;

class QUERY {
    /* variables de conexion? */

    var $BaseDatos;
    var $ServConexion_IDor;
    var $Usuario;
    var $Clave;
    /* Conexion_IDentificador de conexion? y consulta */
    var $Conexion_ID = 0;
    var $Consulta_ID = 0;
    var $row;      // the current row index
    /* numero de error y texto error */
    var $Errno = 0;
    var $Error = "";

    /* Modo Constructor: Cada vez que creemos una variable
      de esta clase, se ejecutar?esta funcion? */
    /* Conexion? a la base de datos */

    function query() {
        $this->BaseDatos = _bdmysql;
        $this->ServConexion_IDor = _hostmysql;
        $this->Usuario = _usermysql;
        $this->Clave = _passmysql;
        // Conectamos al servConexion_IDor
        $this->Conexion_ID = mysql_connect($this->ServConexion_IDor, $this->Usuario, $this->Clave);
        
        /**
         * Added by @Juan
         * Comment: Agregado para realizar conecciones con juego de caracteres en UTF-8
         */
        mysql_query("SET CHARACTER SET utf8");  
        mysql_query("SET NAMES utf8");  
        
        if (!$this->Conexion_ID) {
            $this->Error = "Ha fallado la conexion.";
            return 0;
        }
        //seleccionamos la base de datos
        if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
            $this->Error = "Imposible abrir " . $this->BaseDatos;
            return 0;
        }
        /* Si hemos tenConexion_IDo ?ito conectando devuelve
          el Conexion_IDentificador de la conexi?, sino devuelve 0 */
        return $this->Conexion_ID;
    }

    function cerrar() {
        @mysql_close($this->Conexion_ID);
    }

    /* Ejecuta un consulta */

    function consulta($sql = "") {
        //echo "==>".$sql; 
        if ($sql == "") {
            $this->Error = "No ha especificado una consulta SQL";
            return 0;
        }
        //ejecutamos la consulta
        $this->LogSQL($sql);
        //echo $sql."<br>";
        $this->Consulta_ID = @mysql_query($sql, $this->Conexion_ID);
        if (!$this->Consulta_ID) {
            $this->Errno = mysql_errno();
            $this->Error = mysql_error();
        }
        /* Si hemos tenConexion_IDo ?ito en la consulta devuelve
          el Conexion_IDentificador de la conexi?, sino devuelve 0 */
        return $this->Consulta_ID;
    }

    function mover_anterior() {
        if ($this->row >= 0) {
            $this->row--;
            return true;
        }
        return false;
    }

    function mover_siguiente() {
        if ($this->Consulta_ID + 1 < $this->num_registros()) {
            $this->Consulta_ID++;
            return true;
        }
        return false;
    }

    /* Devuelve el nmero de campos de una consulta */

    function num_campos() {

        return mysql_num_fields($this->Consulta_ID);
    }

    /* function num_campos($res) 
      {
      return mysql_num_fields($res);
      } */

    //AQUI GASTON
    /* Devuelve el nmero de registros de una consulta */
    function num_registros() {
        return @mysql_num_rows($this->Consulta_ID);
    }

    function num_registros_afectados() {
        return mysql_affected_rows();
    }

    function valores_fila() {
        return mysql_fetch_row($this->Consulta_ID);
    }

    function valores_row() {
        return mysql_fetch_array($this->Consulta_ID);
    }

    /* Devuelve el nombre de un campo de una consulta */

    function nombre_campo($numcampo) {
        return mysql_field_name($this->Consulta_ID, $numcampo);
    }

    /* Muestra los datos de una consulta */

    function ver_consulta() {
        // mostrarmos los registros
        while ($row = mysql_fetch_row($this->Consulta_ID)) {
            echo "<tr> \n";
            for ($i = 0; $i < $this->num_campos(); $i++) {
                echo "<td>" . $row[$i] . "</td>\n";
            }
            echo "</tr>\n";
        }
    }

    function LogSQL($sql, $force = true) {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "Unknown";
        }
        //if(isset($_SERVER['REMOTE_HOST']))
        if (isset($_SERVER['REMOTE_ADDR'])) {
            //$cliente=$_SERVER['REMOTE_HOST'];
            $cliente = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
        } else {
            $cliente = "Unknown";
        }
        if (isset($_SESSION['usuario'])) {
            $usuario = $_SESSION['usuario'];
        } else {
            $usuario = "Unknown";
        }
        
        /**
         * Changed by @Juan
         * 
         * To solve date warningn in the login screen
         * 
         * Before: ''
         * Now: date_default_timezone_set('America/La_Paz');
         */
        date_default_timezone_set('America/La_Paz');
        
        $cmd = "^\*\*\*|" .
                "^ *INSERT|^ *DELETE|^ *UPDATE|^ *ALTER|^ *CREATE|" .
                "^ *BEGIN|^ *COMMIT|^ *ROLLBACK|^ *GRANT|^ *REVOKE";
        $sql = str_replace("'", "/", $sql);
        $sql = str_replace(".", "-", $sql);
        $consulta = "INSERT INTO `ad_logs` (`log_accion`,`log_usuario`,`log_equipo`,`log_ip_equipo`,`log_fecha`,`log_hora`)
					  VALUES ('$sql', '$usuario', '$cliente', '$ip', '" . date('Y-m-d') . "', '" . date('H:i:s') . "');";

        if (@eregi($cmd, $sql)) { //echo '-->'.$consulta;
            mysql_query($consulta, $this->Conexion_ID);
        }
    }

}

;
?>
