<?PHP

class PERMISO {

    var $arreglo_modulos;

    function PERMISO() {
        $this->arreglo_modulos = array();
    }

    function cargar_permisos($usuario) {
        $query = new QUERY;
        /*         * Restructurar */
        $sql1 = new SQL;
        $sql1->setS(array("ele_descripcion", "elp_permiso"));
        $sql1->setF(array("ad_elemento", "ad_permiso_mod", "ad_usuario", "ad_grupo_usuario"));
        $sql1->setW(array("ele_id", "elp_gru_id", "gus_usu_id", "usu_id"), array("=", "=", "=", "="), array("elp_ele_id", "gus_gru_id", "usu_id", "'{$usuario}'"));

        $sql1->crearSQL();
        $query->consulta($sql1->cadena);
        for ($i = 0; $i < $query->num_registros(); $i++) {
            list($mod_id, $permiso) = $query->valores_fila();
            /* echo '<script>alert("'.$mod_id.'--'.$permiso.'")</script>'; */
            $this->arreglo_modulos[$mod_id][0] = $mod_id;
            /* echo $this->arreglo_modulos[$mod_id][0]; */
            $this->arreglo_modulos[$mod_id][1] = $permiso;
            /* echo $this->arreglo_modulos[$mod_id][1]; */
        }
        $query->cerrar();
    }

    function get_permiso($modulo) {
        if (isset($this->arreglo_modulos[$modulo][1])) {
            return $this->arreglo_modulos[$modulo][1];
        } else {
            return '';
        }
    }

}

;
?>
