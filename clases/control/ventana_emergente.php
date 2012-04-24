<?php

class VENTANA_EMERGENTE extends CONTROL {

    var $arreglo_valores;
    var $tabla;
    var $formulario;
    var $mod_id;

    function cargar_parametros($mensaje, $nombre, $cant_caracteres, $tamano, $permiso, $exp_regular, $clase_css, $defecto, $arreglo_valores, $modulo, $formulario, $tip) {
        $this->nombre = $nombre;
        $this->cant_caracteres = $cant_caracteres;
        $this->tamano = $tamano;
        $this->valor = (isset($_POST[$nombre])) ? $_POST[$nombre] : '';
        $this->permiso = $permiso;
        $this->exp_regular = $exp_regular;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        $this->mensaje = $mensaje;
        $this->arreglo_valores = $arreglo_valores;
        $this->tabla = (isset($arreglo_valores[count($arreglo_valores) - 1])) ? $arreglo_valores[count($arreglo_valores) - 1] : '';
        $this->mod_id = $modulo;
        $this->formulario = $formulario;
        $this->tip = $tip;
    }

    function get_valor() {
        if ((empty($_POST[$this->nombre]))) {
            if (trim($this->defecto) <> '') {
                $this->valor = $this->defecto;
            }
        }
        if ($this->verificar() <> 1) {
            $this->valor = '';
        }
        return $this->valor;
    }

    function dibujar() {
        $mensaje = ($this->permiso == 2) ? 'readonly="readonly"' : '';
        $this->valor = $this->get_valor();
        echo $this->mensaje;
        echo '<input type="text" ' . $mensaje . ' class="' .
        $this->clase_css . '" name="' .
        $this->nombre . '" size="15"
		   maxlength="15" value="' .
        $this->get_valor() . '">';
        echo '&nbsp;&nbsp;<input type="text" ' . $mensaje . ' class="' .
        $this->clase_css . '" name="' .
        $this->nombre . '_texto" size="' .
        $this->tamano . '" maxlength="' .
        $this->cant_caracteres . '" value="' .
        $this->extraer_valor($this->valor) . '">';
        echo '&nbsp;';
        echo "<input
			  type=" . '"button"' . "
			  class=" . '"boton_fecha"' . "
			  value=" . '""' . "
			  onClick=\"emergente_busca('" . $this->mod_id . "','" . $this->formulario . "','" . $this->nombre . "','1')" . '">';
        if ($this->tip != '') {
            echo '&nbsp;';
            echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '" . $this->tip . ".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> ";
        }
    }

    function extraer_valor($id) {
        $cadena = '';
        $sql = 'SELECT ';
        if (trim($this->valor) <> '') {
            for ($k = 0; $k < count($this->arreglo_valores) - 1; $k++) {
                $sql.=$this->arreglo_valores[$k] . ' ,';
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $sql.='FROM ' . $this->tabla;
            if ($this->tabla == "ac_materia") {
                $cpt = $this->nombre;
                $sql.=" WHERE mat_id='" . $this->valor . "'";
            } else {
                $cpt = substr($this->nombre, strpos($this->nombre, '_') + 1, strlen($this->nombre));
                if (!ctype_digit($this->valor)) {
                    $sql.=' WHERE ' . $cpt . '=' . "'" . $this->valor . "'";
                } else {
                    $sql.=' WHERE ' . $cpt . '=' . $this->valor;
                }
            }
            $query = new QUERY;
            //echo $sql;
            $query->consulta($sql);
            if ($query->num_registros() > 0) {
                $columnas = $query->valores_fila();
                for ($i = 0; $i < count($columnas); $i++) {
                    $cadena.=$columnas[$i] . ' ';
                }
            }
            $query->cerrar();
        }
        return $cadena;
    }

    function ver_prioridad() {
        if ($this->permiso == 2) {
            return true;
        } else {
            if (($this->permiso == 1) and (trim($this->valor) <> "")) {
                return true;
            } else {
                if ($this->permiso == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function verificar() {
        if ($this->ver_prioridad()) {
            if ($this->valido()) {
                return 1;
            } else {
                $this->valor = '';
                return 2;
            }
        } else {
            $this->valor = '';
            return 0;
        }
    }

    function valido() {
        return $this->validar();
    }
}
?>
