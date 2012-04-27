<?PHP
class PAGINACION {
    var $num_paginas;
    var $num_registros;
    var $reg_pagina;
    var $pag;
    var $pag_mostrar;
    var $inicio;
    var $fin;

    function PAGINACION($num_registros,$reg_pagina,$pag_mostrar=5) {        
        $this->pag=(isset($_POST['pag']))?$_POST['pag']:1;
        $this->pag_mostrar=$pag_mostrar;
        $this->num_registros = $num_registros;
        $this->reg_pagina = $reg_pagina;
        $this->num_paginas=($this->num_registros / $this->reg_pagina)-(($this->num_registros % $this->reg_pagina)/$this->reg_pagina);
    }

    function getnum_paginas() {
        if($this->num_registros%$this->reg_pagina<>0) {
            $this->num_paginas++;
        }
        return $this->num_paginas;
    }

    function getpag() {
        return $this->pag;
    }

    function paginar($num_columnas) {

        if($this->pag > $this->num_paginas) {
            $this->pag=1;
        }
        echo '<tr><th colspan='.$num_columnas.'><table  width="100%"><tr class="fila_blanca"><td>';
        echo $this->num_registros.' '._men_encontrados.' |';
        //echo 'PPAGINAR####=='.$this->pag;
        if($this->pag <> 1) {
            //Primera Pagina
            echo '<label class="etiqueta" onclick="javascript:pag.value=1;envio.click();" value="1" title="'._men_pag_inicio.'">&nbsp;<<&nbsp;</label>';
            //pagina anterior
            if($this->pag==1) {
                echo '<label class="etiqueta" onclick="javascript:pag.value=1;envio.click();" value="1" title="'._men_pag_anterior.'">&nbsp;<&nbsp;</label>';
            }
            else {
                $anterior=$this->pag-1;

                echo '<label class="etiqueta" onclick="javascript:pag.value='.$anterior.';envio.click();" value="'.$anterior.'" title="'._men_pag_anterior.'">&nbsp;<&nbsp;</label>';
            }
        }
        $this->inicio=(int)(($this->pag-1)/$this->pag_mostrar)*$this->pag_mostrar+1;
        $this->fin=$this->inicio+$this->pag_mostrar;
        if($this->fin > $this->num_paginas) {
            $this->fin=$this->num_paginas+1;
            //$this->inicio=$this->fin-$this->pag_mostrar;
        }

        for($i=$this->inicio;$i<$this->fin;$i++) {
            if($this->pag==$i) {
                echo '<label class="etiqueta_verde" value="'.$i.'">&nbsp;'.$i.'&nbsp;</label>';
            }
            else {
                echo '<label class="etiqueta"onclick="javascript:pag.value='.$i.';envio.click();" value="'.$i.'">&nbsp;'.$i.'&nbsp;</label>';
            }
        }

        if($this->pag <> $this->num_paginas) {
            //pagina siguiente
            if($this->pag==$this->num_paginas) {
                echo '<label class="etiqueta" onclick="javascript:pag.value='.$this->num_paginas.';envio.click();" value="'.$this->num_paginas.'" title="'._men_pag_siguiente.'">&nbsp;>&nbsp;</label>';
            }
            else {
                $siguiente=$this->pag+1;
                echo '<label class="etiqueta" onclick="javascript:pag.value='.$siguiente.';envio.click();" value="'.$siguiente.'" title="'._men_pag_siguiente.'">&nbsp;>&nbsp;</label>';
            }
            //Primera ultima
            echo '<label class="etiqueta" onclick="javascript:pag.value='.$this->num_paginas.';envio.click();" value="'.$this->num_paginas.'" title="'._men_pag_ultimo.'">&nbsp;>>&nbsp;</label>';
        }
        //echo '  <input type="hidden" name="pag" id="pag" readonly size=2 value="'.$this->pagina.'">';
        echo '  <input type="hidden" name="pag" id="pag" readonly size=2 value="">';
        echo '</td></tr></table></th></tr>';
    }
};
?>