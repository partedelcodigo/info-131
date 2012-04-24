<?PHP

class TABLA {

    /**
     * Inicio de Celdas $table[1][1].
     */
    var $table;

    /**
     * Configuraciones por Defaut
     */
    var $default_settings;

    /**
     * Total Filas
     */
    var $row_count;

    /**
     * Fancy styles 
     */
    var $fstyles;

    /**
     * function Contructor
     */
    function TABLA() {
        $this->table = array();
        $this->default_settings = array();
        $this->row_count = 0;
        $this->default_settings = array();
        $this->fstyles = array();
    }

    /**
     * Adicionar 1 al contador de filas
     * @return    Numero de filas (despues de la adicion)
     */
    function AddRow() {
        return++$this->row_count;
    }

    /**
     * Adquiere el numero de filas 
     * @return    Numero de Filas
     */
    function GetCurrentRow() {
        return $this->row_count;
    }

    /**
     * Adquiere el numero de columnas 
     * @return   Numero de Columnas
     */
    function GetCurrentCols() {
        $high = 0;
        foreach ($this->table as $row => $array) {
            $cnt = count($array);
            if ($cnt > $high || $high == 0) {
                $high = $cnt;
            }
        }
        return $high;
    }

    /**
     * Colocar valor en alguna celda
     * @param    int        $row
     * @param    int        $col
     * @param    string    $content
     */
    function SetCellContent($row, $col, $content) {
        $this->table[$row][$col]["content"] = $content;
    }

    function SetRowContent($row, $content) {
        $count = count($content);
        $content_keys = array_keys($content);
        for ($x = 0; $x < $count; $x++) {
            $this->table[$row][( $x + 1 )]["content"] = $content[$content_keys[$x]];
        }
    }

    function SetColContent($col, $content) {
        $count = count($content);
        $content_keys = array_keys($content);
        for ($x = 0; $x < $count; $x++) {
            $this->table[( $x + 1 )][$col]["content"] = $content[$content_keys[$x]];
        }
    }

    /**
     * Default contenido en las celdas
     * @param    string $content
     */
    function SetDefaultCellContent($content) {
        $this->default_settings['td']['content'] = $content;
    }

    /**
     * Poner BGCOLOR a las celdas
     * @param    int        $row
     * @param    int        $col
     * @param    string    $bgcolor
     */
    function SetCellBGColor($row, $col, $bgcolor) {
        $this->table[$row][$col]["bgcolor"] = $bgcolor;
    }

    /**
     * Colocar default bgcolor a todas las celdas
     * @param    string    $bgcolor
     */
    function SetDefaultBGColor($bgcolor) {
        $this->default_settings['td']['bgcolor'] = $bgcolor;
    }

    /**
     * Permitir un estilo css en las celdas
     * @param    int        $row
     * @param    int        $col
     * @param    string    $style
     */
    function SetCellStyle($row, $col, $style) {
        $this->table[$row][$col]["style"] = $style;
    }

    /**
     * Colocar un css default a las celdas
     * @param    string    $style
     */
    function SetDefaultStyle($style) {
        $this->default_settings['td']['style'] = $style;
    }

    /**
     * Permitir "colspan" 
     * @param    int        $row
     * @param    int        $col
     * @param    int        $colspan
     */
    function SetCellColSpan($row, $col, $colspan) {
        $this->table[$row][$col]["colspan"] = $colspan;
    }

    /**
     * Permitir "rowspan" 
     * @param    int        $row
     * @param    int        $col
     * @param    int        $rowspan
     */
    function SetCellRowSpan($row, $col, $rowspan) {
        $this->table[$row][$col]["rowspan"] = $rowspan;
    }

    /**
     * Permitir agregar atributos a una celda (si necesitara)
     * @param    int        $row
     * @param    int        $col
     * @param    string    $attribute
     * @param    string    $value
     * @return    void
     */
    function SetCellAttribute($row, $col, $attribute, $value) {
        $this->table[$row][$col][$attribute] = $value;
    }

    /**
     * Atruçibutos por Default a todas las celdas
     * @param    string    $attribute
     * @param    string    $value
     * @return    void
     */
    function SetDefaultCellAttribute($attribute, $value) {
        $this->default_settings['td'][$attribute] = $value;
    }

    /**
     * Permitir atributos multiples de tabla. 
     * (p.e. $atrib = array ( "nomb_atrib" => "valor","nomb2_atrib" => "valor");
     * $table->SetCellAttributes( $row, $col, $attributes );
     * @param    int        $row
     * @param    int        $col
     * @param    array    $array
     * @return    void
     */
    function SetCellAttributes($row, $col, $array) {
        if (is_array($array)) {
            foreach ($array as $attribute => $value) {
                $this->table[$row][$col][$attribute] = $value;
            }
        }
    }

    /**
     * Default Atributos del "td"
     * Identico al SetCellAttributes, sin (row or col) parametros     
     * @param    array    $array
     */
    function SetDefaultCellAttributes($array) {
        foreach ($array as $key => $value) {
            $this->default_settings["td"][$key] = $value;
        }
    }

    /**
     * Default Atributos de tabla
     * Identico al SetCellAttributes, sin (row or col) parametros     
     * @param    array    $array
     */
    function SetDefaultTableAttribute($array) {
        foreach ($array as $key => $value) {
            $this->default_settings["table"][$key] = $value;
        }
    }

    /**
     * Colocar atributos de Tabla
     * La informacion de la tabla esta almacenada en la variable table como primer elemento
     * ($this->table[0]).
     * @param    array    $array
     * @return    void
     */
    function SetTableAttributes($array) {
        foreach ($array as $key => $value) {
            $this->table[0]["table_values"][$key] = $value;
        }
    }

    /**
     * Adicionar atributo a la tabla
     * @param    array    $array
     * @return    void
     */
    function SetTableAttribute($key, $value) {
        $this->table[0]["table_values"][$key] = $value;
    }

    /**
     * Colocar atributos a una fila en particuar.
     * @param    int or array        $row
     * @param    array                $attributes
     */
    function SetFancyRowStyle($row, $attributes) {
        if (is_array($row)) {
            foreach ($row as $num) {
                foreach ($attributes as $key => $value) {
                    $this->fstyles["row"][$num][$key] = $value;
                }
            }
        } else {
            foreach ($attributes as $key => $value) {
                $this->fstyles["row"][$row][$key] = $value;
            }
        }
    }

    /**
     * Colocar atributos a una columna en particular
     * @param    int || array        $row
     * @param    array                $attributes
     */
    function SetFancyColStyle($col, $attributes) {
        if (is_array($col)) {
            foreach ($col as $num) {
                foreach ($attributes as $key => $value) {
                    $this->fstyles["col"][$num][$key] = $value;
                }
            }
        } else {
            foreach ($attributes as $key => $value) {
                $this->fstyles["col"][$col][$key] = $value;
            }
        }
    }

    /**
     * Colocar colores alternando uno a uno a las filas
     * @param    string    $odd_colors        The odd numbered rows bgcolor value
     * @param    string    $even_colors    The even numbered rows bgcolor value
     * @param    int        $start            What row to start outputting the alternating colors on. Defaults to 1 (the first row).
     * @param    int        $end            What row to stop outputting the alternating colors on.  Defaults to the GetCurrentRow() value
     *
     */
    function Set2RowColors($odd_colors, $even_colors, $start = 1, $end = false) {
        if ($end === false) {
            $end = $this->GetCurrentRow();
        }
        for ($row = $start; $row <= $end; $row++) {
            if (( $row % 2 ) != 0) {
                $this->fstyles["row"][$row]["bgcolor"] = $odd_colors;
            } else {
                $this->fstyles["row"][$row]["bgcolor"] = $even_colors;
            }
        }
    }

    /**
     * Compilar table a HTML.
     * "table array" --> HTML table 
     * @return    string    Returns a string of the table in HTML Format
     */
    function CompileTable() {
        $content = "\n<table";
        if (isset($this->default_settings["table"])) {
            $t_array = $this->default_settings["table"];
            foreach ($t_array as $attribute => $value) {
                $this->table[0]["table_values"][$attribute] = $value;
            }
        }
        if (isset($this->table[0]["table_values"])) {
            $t_array = $this->table[0]["table_values"];
            foreach ($t_array as $attribute => $value) {
                $content .= ' ' . $attribute . '="' . $value . '"';
            }
        }
        $content .= ">\n";
        for ($row = 1; $row <= $this->row_count; $row++) {
            $content .= "\t<tr>\n";
            $row_array = $this->table[$row];
            /**
              $td_array = $this->default_settings["td"];
              $frowstyle = $this->fstyles["row"][$row];
              if ( is_array( $frowstyle ) )
              {
              foreach ( $frowstyle as $attribute => $value )
              {
              $td_array[$attribute] = $value;
              }
              }
             */
            $count = count($row_array);
            for ($col = 1; $col <= $count; $col++) {
                $colvalue = array();
                $colvalue = $row_array[$col];
                $content .= "\t\t<td";
                $fcolstyle = "";
                $td_array = $this->default_settings["td"];
                if (isset($this->fstyles["row"][$row])) {
                    $frowstyle = $this->fstyles["row"][$row];
                } else {
                    $frowstyle = "";
                }
                if (is_array($frowstyle)) {
                    foreach ($frowstyle as $attribute => $value) {
                        $td_array[$attribute] = $value;
                    }
                }
                if (isset($this->fstyles["col"][$col]) && !empty($this->fstyles["col"][$col])) {
                    $fcolstyle = $this->fstyles["col"][$col];
                    if (is_array($fcolstyle)) {
                        foreach ($fcolstyle as $attribute => $value) {
                            $td_array[$attribute] = $value;
                        }
                    }
                }
                if (is_array($td_array)) {
                    foreach ($td_array as $attribute => $value) {
                        if (empty($colvalue[$attribute]) || !isset($colvalue[$attribute])) {
                            $colvalue[$attribute] = $value;
                        }
                    }
                }
                foreach ($colvalue as $attribute => $value) {
                    if ($attribute == "content") {
                        $t_string = $value;
                    } else {
                        $content .= " $attribute=\"$value\"";
                    }
                }
                $content .= ">\n";
                $content .= "\t\t\t" . $t_string . "\n";
                $content .= "\t\t</td>\n";
            }
            $content .= "\t</tr>\n";
        }
        $content .= "</table>\n";
        return $content;
    }

    /**
     * Imprimir tabla (HTML)
     */
    function PrintTable() {
        echo $this->CompileTable();
    }

    /**
     * Imprimir "table array". (Usado para debug)
     */
    function printTableArray() {
        echo "<pre>";
        print_r($this);
        echo "</pre>";
    }

}
?>