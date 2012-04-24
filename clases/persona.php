<?php

require_once('permiso.php');
require_once('sesion_handle.php');

class PERSONA {

    var $usuario;
    var $sede_actual;
    var $codigo;
    var $permiso;
    var $lenguaje;
    var $sesion;
    var $nombre_completo;

    function PERSONA() {
        $this->sesion = new SESION_HANDLE;
        $this->permiso = new permiso;
    }

    function cambiar_lenguaje() {
        if (isset($_GET["lenguaje"])) {
            $this->lenguaje = $_GET["lenguaje"];
        } else {
            $this->lenguaje = "es";
        }
    }

    function get_permisos($modulo) {
        $this->permiso = $this->sesion->get_variable_sesion('permiso');
        return $this->permiso->get_permiso($modulo);
    }

    function verificar() {
        $query = new QUERY;
        $ps = md5($this->codigo);
        /* echo $this->codigo."<br>";
          echo $ps;
          exit; */
        $sql1 = new SQL;
        $sql1->setS(array("usu_id,usu_per_id,usu_lan"));
        $sql1->setF(array("ad_usuario"));
        $sql1->setW(array("usu_id", "usu_password"), array("=", "="), array("'{$this->usuario}'", "'{$ps}'"));
        $sql1->crearSQL();
        $query->consulta($sql1->cadena);
        if ($query->num_registros() > 0) {
            list($this->usu_id, $per_id, $this->lenguaje) = $query->valores_fila();
            $grupo = $this->buscar_grupo($this->usuario);
            $this->nombre_completo = $this->buscar_nombre_completo($per_id);
            $this->carga_lenguaje();
            $this->sesion->set_sesion($this->usuario);
            $this->sesion->set_variable_sesion('nombre_completo', $this->nombre_completo);
            $this->sesion->set_variable_sesion('usuario', $this->usuario);
            $this->sesion->set_variable_sesion('grupo', $grupo);
            $this->sesion->set_variable_sesion('codigo', $this->codigo);
            $this->permiso->cargar_permisos($this->usuario);
            $this->sesion->set_variable_sesion('permiso', $this->permiso);
            $this->sesion->set_variable_sesion('per_id', $per_id);
        } else {
            $this->usuario = '';
            $this->codigo = '';
        }
        $query->cerrar();
    }

    function registrado() {
        if (trim($this->get_nombre_completo()) <> '') {
            return true;
        } else {
            return false;
        }
    }

    function get_nombre_completo() {
        return $this->sesion->get_variable_sesion('nombre_completo');
    }

    function get_grupo() {
        return $this->sesion->get_variable_sesion('grupo');
    }

    function get_usuario() {
        return $this->sesion->get_variable_sesion('usuario');
    }

    function get_per_id() {
        return $this->sesion->get_variable_sesion('per_id');
    }

    function get_gestion_id() {
        return $this->sesion->get_variable_sesion('ges_id');
    }

    function get_gestion() {
        return $this->sesion->get_variable_sesion('ges_desc');
    }

    function get_gestion_nombre() {
        return $this->sesion->get_variable_sesion('ges_nombre');
    }

    function set_datos($nombreusuario, $codigo) {
        $this->usuario = $nombreusuario;
        $this->codigo = md5($codigo);
        $this->codigo = $codigo;
    }

    function iniciar_session() {
        $this->sesion->iniciar_session();
    }

    function cerrar_session() {
        $this->sesion->cerrar();
    }

    function permiso_tarea($tarea, $permiso, $modulo) {
        $query = new QUERY;
        $sql1 = new SQL;
        $sql1->setS(array("opc_permiso"));
        $sql1->setF(array("ad_opcion", "ad_elemento", "ad_permiso_mod"));
        $sql1->setW(array("opc_tarea", "elp_permiso", "elp_ele_id", "ele_descripcion"), array(" = ", " like ", " = ", " = "), array("'{$tarea}'", "'%'||opc_permiso||'%'", "ele_id", "'{$modulo}'"));
        $sql1->crearSQL();
        //print $sql1->cadena;
        $query->consulta($sql1->cadena);
        if ($query->num_registros() > 0) {
            return true;
        } else {
            //return false;
        }
        return true;
        $query->cerrar();
    }

    function buscar_grupo($usu_id) {
        $query = new QUERY;
        $sql1 = new SQL;
        $sql1->setS(array("gru_id"));
        $sql1->setF(array("ad_grupo_usuario", "ad_grupo"));
        $sql1->setW(array("gus_gru_id", "gus_usu_id"), array(" = ", " = ", "=", "="), array("gru_id", "'{$usu_id}'"));
        $sql1->crearSQL();
        $query->consulta($sql1->cadena);
        if ($query->num_registros() > 0) {
            list($gru_id) = $query->valores_fila();
            return $gru_id;
        } else {
            return '';
        }

        $query->cerrar();
    }

    function buscar_gestion_actual() {
        
    }

    function carga_lenguaje() {
        $lan = array('spanish' => 'es', 'english' => 'en');
        echo "<br>------" . $lan[$this->lenguaje];
        $_SESSION['len'] = $lan[$this->lenguaje] . '.php';
        //define('_lenguaje1',$lan[$this->lenguaje].'.php');
        //echo "<br>------"._lenguaje1;
        //require_once ('lenguaje/'._lenguaje1);
        //exit;
    }

    function buscar_nombre_completo($per_id) {
        $query = new QUERY;
        $sql1 = new SQL;
        $sql1->setS(array("per_apellidopat,per_apellidomat,per_nombres"));
        $sql1->setF(array("gr_persona"));
        $sql1->setW(array("per_id"), array(" = "), array("{$per_id}"));
        $sql1->crearSQL();
        $query->consulta($sql1->cadena);
        if ($query->num_registros() > 0) {
            list($paterno, $materno, $nombre) = $query->valores_fila();
            $nombre = $paterno . ' ' . $materno . ' ' . $nombre;
            return $nombre;
        } else {
            return '';
        }

        $query->cerrar();
    }

}

;
?>
