<?php
class SQL {

    var $s;
    var $f;
    var $w;
    var $o;
    var $g;
    var $h;
    var $cadena;

    function sql() {
        $this->reset();
    }

    function setS($u) {
        if (count($u) <> 1) {
            for ($i = 0; $i < count($u) - 1; $i++) {
                $this->s.=$u[$i] . ',';
            }
            $this->s.=$u[$i];
        } else {
            $this->s.=$u[0];
        }
    }

    function setF($u) {
        if (count($u) <> 1) {
            for ($i = 0; $i < count($u) - 1; $i++) {
                $this->f.=$u[$i] . ',';
            }
            $this->f.=$u[$i];
        } else {
            $this->f.=$u[0];
        }
    }

    function setW($u, $t, $v) {
        if (count($u) <> 1) {
            for ($i = 0; $i < count($u) - 1; $i++) {
                $this->w.=$u[$i] . $t[$i] . $v[$i] . " AND ";
            }
            $this->w.=$u[$i] . $t[$i] . $v[$i];
        } else {
            $this->w.=$u[0] . $t[0] . $v[0];
        }
    }

    function setWOR($u, $t, $v) {
        if (count($u) <> 1) {
            for ($i = 0; $i < count($u) - 1; $i++) {
                $this->w.=$u[$i] . $t[$i] . $v[$i] . " OR ";
            }
            $this->w.=$u[$i] . $t[$i] . $v[$i];
        } else {
            $this->w.=$u[0] . $t[0] . $v[0];
        }
    }

    function setO($u) {
        if (count($u) <> 1) {
            for ($i = 0; $i < count($u) - 1; $i++) {
                $this->o.=$u[$i] . ',';
            }
            $this->o.=$u[$i];
        } else {
            $this->o.=$u[0];
        }
    }

    function setG($u) {
        $this->g = $u;
    }

    function setH($u) {
        $this->h = $u;
    }

    function crearSQL() {
        $this->cadena = $this->s . ' ' .
                $this->f;
        if ($this->w <> "WHERE ") {
            $this->cadena.=' ' . $this->w;
        }
        if ($this->o <> "ORDER BY ") {
            $this->cadena.=' ' . $this->o;
        }
        return $this->cadena;
    }

    function reset() {
        $this->s = "SELECT ";
        $this->f = "FROM ";
        $this->w = "WHERE ";
        $this->o = "ORDER BY ";
        $this->g = "GROUP BY ";
        $this->h = "HAVING ";
        $this->cadena = "";
    }

}
?>