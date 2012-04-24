<?PHP

class HORA_COMBO extends CONTROL {

    function cargar_parametros($mensaje, $nombre, $cant_caracteres, $tamano, $permiso, $exp_regular, $clase_css, $defecto, $tip = '') {
        $this->nombre = $nombre;
        $this->cant_caracteres = $cant_caracteres;
        $this->tamano = $tamano;
        $this->valor = $_POST[$nombre];
        $this->permiso = $permiso;
        $this->exp_regular = $exp_regular;
        $this->clase_css = $clase_css;
        $this->defecto = $defecto;
        $this->mensaje = $mensaje;
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
        if ($this->permiso == 2) {
            $mensaje = 'readonly';
        }

        echo $this->mensaje;

        if (trim($this->get_valor()) <> "") {
            /* valor de la hora */
            $valorhora = substr($valor, 0, 2);
            /* valor del minuto */
            $valormin = substr($valor, 3, 2);
        }
        echo "<select name='{$this->nombre}hora' onclick=" . '"' . "{$this->nombre}.value={$this->nombre}hora.value + ':' + {$this->nombre}min.value+ ':' +'00'" . '"' . ">";
        for ($hora = 0; $hora <= 23; $hora++) {
            $horatemp = $hora;
            if ($hora < 10)
                $horatemp = "0" . $hora;
            if ($horatemp == $valorhora) {
                echo "<option value='" . $horatemp . "' selected>" . $horatemp . "</option>";
            } else {
                if ($this->permiso != 2) {
                    echo "<option value='" . $horatemp . "'>" . $horatemp . "</option>";
                }
            }
        }
        echo "</select>";
        echo "&nbsp;&nbsp;
				<select name='{$this->nombre}min' onclick=" . '"' . "{$this->nombre}.value={$this->nombre}hora.value + ':' + {$this->nombre}min.value+ ':' +'00'" . '"' . ">";
        for ($min = 0; $min <= 55; $min+=5) {
            $mintemp = $min;
            if ($min < 10)
                $mintemp = "0" . $min;
            if ($mintemp == $valormin) {
                echo "<option value='" . $mintemp . "' selected>" . $mintemp . "</option>";
            } else {
                if ($this->permiso != 2) {
                    echo "<option value='" . $mintemp . "'>" . $mintemp . "</option>";
                }
            }
        }
        echo "</select>";
        echo '&nbsp;&nbsp;';
        echo '<input class="' .
        $this->clase_css . '" type="text" readonly size ="' .
        $this->tamano . '" maxlength="' .
        $this->cant_caracteres . '" name="' .
        $this->nombre . '" value="' . $this->get_valor() . '">';
        if ($this->tip != '') {
            echo '&nbsp;';
            echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '" . $this->tip . ".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> ";
        }
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
