<?PHP


class CALENDARIO_COMBO extends CONTROL
{
	function cargar_parametros($mensaje,$nombre,$cant_caracteres,$tamano,$permiso,$exp_regular,$clase_css,$defecto,$tip='')
	{
		$this->nombre=$nombre;
		$this->cant_caracteres=$cant_caracteres;
		$this->tamano=$tamano;
		$this->valor=$_POST[$nombre];
		$this->permiso=$permiso;
		$this->exp_regular=$exp_regular;
		$this->clase_css=$clase_css;
		$this->defecto=$defecto;
		$this->mensaje=$mensaje;
		$this->tip=$tip;
	}
	
	function get_valor()
	{
		if((empty($_POST[$this->nombre])))
		{
			if(trim($this->defecto)<>'')
			{
				$this->valor=$this->defecto;
			}
		}
		if($this->verificar()<>1)
		{
		  $this->valor='';
		}
		return $this->valor;
	}
	
	function dibujar()
	{
		if($this->permiso==2)
		{
			$mensaje='readonly';
		}
		echo $this->mensaje;
		if(trim($this->get_valor())<>"")
		{
			/*valor del año*/
			$valorano=substr($this->valor,0,4);
			/*valor del mes*/
			$valormes=substr($this->valor,5,strrpos($this->valor,"-"));
			/*valor del dia*/
			$valordia=substr($valormes,strrpos($valormes,"-")+1,2);
			$valormes=substr($valormes,0,strrpos($valormes,"-"));
		}
		echo '<select name="'.
			$this->nombre.'dia" onclick="'.$this->nombre.'.value='.
			$this->nombre.'ano.value + '."'-'".' + '.$this->nombre.'mes.value + '.
			"'-'".' + '.$this->nombre.'dia.value'.'"'.'>';
		for ($dia=1;$dia<=31;$dia++)
		{
			if($dia==$valordia)
			{
				echo '<option value='.$dia.' selected>'.$dia.'</option>';
			}
			else
			{
				echo '<option value='.$dia.'>'.$dia.'</option>';
			}
		}
		echo '</select>';
		echo '<select name="'.
			$this->nombre.'mes" onclick="'.$this->nombre.'.value='.
			$this->nombre.'ano.value + '."'-'".' + '.$this->nombre.'mes.value + '.
			"'-'".' + '.$this->nombre.'dia.value'.'"'.'>';
		for ($dia=1;$dia<=12;$dia++)
		{
			if($dia==$valormes)
			{
				echo '<option value='.$dia.' selected>'.$dia.'</option>';
			}
			else
			{
			echo '<option value='.$dia.'>'.$dia.'</option>';
			}
		}
		echo '</select>';					
		echo '<select name="'.
			$this->nombre.'ano" onclick="'.$this->nombre.'.value='.
			$this->nombre.'ano.value + '."'-'".' + '.$this->nombre.'mes.value + '.
			"'-'".' + '.$this->nombre.'dia.value'.'"'.'>';
						
		for ($dia=_ano_inicio;$dia<=_ano_fin;$dia++)
		{
			if($dia==$valorano)
			{
				echo '<option value='.$dia.' selected>'.$dia.'</option>';
			}
			else
			{
				echo '<option value='.$dia.'>'.$dia.'</option>';
			}
		}
		echo '</select>';
		echo '<input class="'.
			$this->clase_css.'" readonly type="text" size ="'.
			$this->tamano.'" maxlength="'.
			$this->cant_caracteres.'" name="'.
			$this->nombre.'" value="'.$this->get_valor().'">';
		if ($this->tip!='')
		{
			echo '&nbsp;';			
			echo "<span onmouseover=\" this.T_TITLE='Aclaraciones!'; return escape( '".$this->tip.".' );\"><img src=\"graficos/con_info.png\" align=\"middle\" border=\"0\">&nbsp;</span> " ;
		}			
	}
	
	function ver_prioridad()
	{
		if($this->permiso==2)
		{
			return true;
		}
		else
		{
			if(($this->permiso==1) and (trim($this->valor)<>""))
			{
				return true;
			}
			else
			{
				if($this->permiso==0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
	}
	
	function verificar()
	{
		if($this->ver_prioridad())
		{
			if($this->valido())
			{
				return 1;
			}
			else
			{
				$this->valor='';
				return 2;
			}
		}
		else
		{
			$this->valor='';
			return 0;
		}
	}
	
	function valido()
	{
		return $this->validar();
	}
};
?>
