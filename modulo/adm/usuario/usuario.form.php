<?PHP

include ('clases/formulario.php');
class FORM extends FORMULARIO
{
	var $nombreform;
    var $nombretablas;
    var $tituloform;
    var $detalleform;
    var $anchoform;
    var $mod_id;
    var $tarea;
    var $error;
    var $valores;
    var $titulos;
    var $controles;
    var $id;
    var $cpt;
    var $redireccion;
        
    function FORM()
    {
    	$this->controles=array();
        $this->error='';
	}
   
	function generar_sql($tipo)
  	{
		$query=new QUERY;
	  	/**Generamos la lista de campos*/
	  	$lista_de_campos=$this->get_lista_campos();
	  	/**Generamos la lista de tablas*/
	  	$lista_de_tablas=$this->get_lista_tablas();
	  	switch ($tipo)
	  	{
			case 'SEE':{
						/**Se genera el sql para la carga de datos*/
						if (!ctype_digit($this->id))
						{
							$aux="'".$this->id."'";
						}
						else
						{
							if (trim($lista_de_tablas)=='ad_usuario')
									$aux="'".$this->id."'";
							else
									$aux=$this->id;
						}
				 		$sql='SELECT '.$lista_de_campos.
								  ' FROM '.$lista_de_tablas.
								  ' WHERE '.$this->cpt.' = '.$aux;
						$query->consulta($sql); 
						if($query->num_registros()>0)
				 		{
					  		$arreglo=$query->valores_fila();
				 		}
						else
				 		{
							/* echo'<script>alert("'._men_no_existe__registro.'")</script>';*/
				 		}
						break;
						}
			case 'UPDATE':{
							/**Se subdivide la lista de campos a las tablas que pertenecen*/
							$sql=array();
							for($i=0;$i<count($this->nombretablas);$i++)
							{		
								$sql[$i]='UPDATE '.$this->nombretablas[$i].' ';
								$campos=$this->get_lista_campos_tabla($this->nombretablas[$i],$this->valores[_NOMBRES]);
								$sql[$i].='set ';
								for($j=0;$j<count($campos)-1;$j++)
								{		
									if(trim($campos[$j])==trim($this->cpt))
									{		
										$sql[$i].=$campos[$j]."='".$this->id."',";
									}
									else
									{		
										switch ($this->controles[$j]->tipo)
										{	 
											case 6: $sql[$i].=$campos[$j]."='".md5($this->controles[$j]->get_valor_control())."',";
													break;		  
											default: 
													$e = $this->controles[$j]->get_valor_control();
													if ($e == "")
													{
														$sql[$i].=$campos[$j]."=null,";
													}
													else
													{
														$sql[$i].=$campos[$j]."='".$e."',";
													}
													break;
										  }
									}
								}
								$sql[$i]=substr($sql[$i],0,strlen($sql[$i])-1);
								$sql[$i].=' where '.$this->cpt."='".$this->id."'";
								/**Proceso para jalar los valores*/
								/*echo'<script>alert("'.$sql[$i].'")</script>';*/
							  } 
							  $arreglo=$sql;
					  		  break;
							 }
	  }
	  $query->cerrar();
	  return $arreglo;
  }

  function redireccionar()
  {
	  echo '<script>';
			  echo "location.href='".$this->redireccion."'";
	  echo '</script>';
  }

  function dibujar_formulario($opcion)
  {
    echo '<form method="post" name="'.$this->nombreform.'" action="'._PAG_PRINCIPAL.'?mod_id='.$this->mod_id.'&tarea='.$this->tarea.'&id='.$this->id.'&cpt='.$this->cpt.'">';
    echo '<table width="100%" border=1 cellpadding=0 cellspacing=0>';
    echo '<tr>';
            echo '<th class=title>'.$muestra.'&nbsp;&nbsp;'.$this->tituloform.'</th>';
    echo '</tr>';
         echo '<tr>';
              echo '<td>';
                   echo '<table border="0" width="100%">';
                        echo '<tr>';
                                echo '<td colspan=3 class=mensaje><center>'.$this->mensajeform.'</center></td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td colspan=3 height=10 align=center><font align=center color=red size=-1 face=Arial, Helvetica, sans-serif>'.$this->error.'</font><hr class=linea>';
                        echo '</td>';
                        echo '</tr>';
                        /**Carga de controles*/
                        for ($i=0;$i<count($this->controles);$i++)
                        {
                             if($this->valores[_TIPO][$i]>0)
                             {
                                  echo '<tr class="evento">';
                                  echo '<td class="nombre">';
                                  echo '&nbsp;&nbsp;&nbsp;';
                                  if($this->valores[_PERMISO][$i]==1)
								  {
									  echo '&nbsp;(*)';
								  }
								  echo '&nbsp;&nbsp;';
									  echo $this->valores[_MENSAJES][$i];
                                  echo '</td>';
                                  echo '<td class="campo">';
                                  echo '&nbsp;&nbsp;&nbsp;';
                                      $this->controles[$i]->dibujar_control();
                                  echo '</td>';
                                  echo '</tr>';
                             }
                        }
                   echo '</table>';
              echo '</td>';
         echo '</tr>';
    echo '</table>';
    echo '<div align = center>';
    echo '<input name="id" type="hidden" value="'.$this->id.'">';
    echo '<input name="cpt" type="hidden" value="'.$this->cpt.'">';
    echo '<input name="tipo" type="hidden" value="1">';
    echo '<br><br>';
    if($opcion==1)
    {
            echo '<input class="boton" name="limpiar" type="reset" value="'._men_limpiar.'">&nbsp;&nbsp;&nbsp;';
		echo '<input class="boton" type="submit" name="enviar" value="'._men_enviar.'">&nbsp;&nbsp;&nbsp;';
    }
    echo "<input class=boton name=Continuar type=button value='"._men_volver."' onclick=\"location='"._PAG_PRINCIPAL."?mod_id={$this->mod_id}' \"/><br>";
    echo '</div>';
    echo '</form>';
    echo '<br>';
    echo '<br>';
  }

  function mostrar_formulario($opcion=0)
  {
 		$this->cpt=$_GET['cpt'];
        $this->id=$_GET['id'];
        $tipo=$_POST['tipo'];
		  $this->tarea='modificar_pass';
		  $this->error='';
		  if($tipo==1)
		  {
				  if(($this->verificar_valores())and($tipo==1))
				  {
					  $arreglo_sql=$this->generar_sql('UPDATE');
					  /**Se realiza la modificacion del Registro ejecutando 1 a 1 las consultas*/
					  $query=new QUERY;
					  for($i=0;$i<count($arreglo_sql);$i++)
					  {
						  $verificar=$query->consulta($arreglo_sql[$i]);
						  /*echo '<script>alert("'.$arreglo_sql[$i].'--'.$verificar.'");</script>';*/
					  }
					  $query->cerrar();
					  $this->redireccionar();
				  }
				  else
				  {
					  $arreglo_valores=$this->generar_sql('SEE');
					  for($i=0;$i<count($this->controles);$i++)
					  {
						  //asignamos un valor por defecto y recargamos el control
						  $this->controles[$i]->defecto=$arreglo_valores[$i];
						  $this->controles[$i]->cargar_control();
					  }
					  $this->dibujar_formulario(1);
				  }
		  }
		  else
		  {
					  $arreglo_valores=$this->generar_sql('SEE');
					  for($i=0;$i<count($this->controles);$i++)
					  {
						  //asignamos un valor por defecto y recargamos el control
						  $this->controles[$i]->defecto=$arreglo_valores[$i];
						  $this->controles[$i]->cargar_control();
					  }
					  $this->dibujar_formulario(1);
		  }
  }

  function verificar_valores()
  {
	  	$aux=0;
		$aux1=0;
		
	    $form_valido=false;
	    for ($i=0;$i<count($this->controles);$i++)
	    {
            if($this->controles[$i]->control_valido())
            {
                 /*echo '<script>alert("'.$this->controles[$i]->control_valido().'");</script>';*/				 
				 if ($this->controles[$i]->nombre=="usu_password")
				 {
				 	$aux=$i;
				 }
				 if ($this->controles[$i]->nombre=="usu_observaciones")				 
				 {
				 	$aux1=$i;
				 }
                 $form_valido=true;
            }
            else
            {
				 if ($this->controles[$i]->nombre=="usu_observaciones")				 
				 {
					  $this->error='El codigo debe ser el mismo';					
				 }
				else
				{
            		$men='_'.$this->get_nombre_campo($this->valores[_NOMBRES][$i]);
		            if (defined($men))
						{
						  $this->error.=_men_campo_invalido.' -> '.constant($men).'<br>';					
						}
						else
						{
							echo '<h2>'._def_no.'</h2>';
						}
        	      	 return false;
				 }
            }
	    }
		if ($form_valido==true)
		{
			if (($this->controles[$aux]->get_valor_control()<>null) && ($this->controles[$aux1]->get_valor_control()<>null))
			{
				if ($this->controles[$aux]->get_valor_control()==$this->controles[$aux1]->get_valor_control())
				{
					return $form_valido;
				}
				else
				{
					  $this->error='EL codigo debe ser el mismo';										
				}
			}
			else
			{
				  $this->error='EL codigo debe ser el mismo';													
			}
		}
		else
		{
            return false;		
		}
  }
};
?>
