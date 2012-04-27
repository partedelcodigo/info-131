	<SCRIPT LANGUAGE="JavaScript">
    <!--  Se oculta en navegadores antiguos
 // Variables globales de la calculadora
 var Acumulador = 0;     
 <!-- Valor acumulado hasta el momento -->
 var EsperaDato = false; 
 <!-- Indica si se espera un nuevo dato para realizar la operacion -->
 var OperacionP = "";
 <!-- Operacion pendiente a la espera de un argumento -->
 
 function Valor(num)
 {
    if (EsperaDato)
     { document.form1.CAJA.value = num;
       EsperaDato = false; }
     else { if (document.form1.CAJA.value == "0")
              { document.form1.CAJA.value = num; }
              else document.form1.CAJA.value += num; }
  
 }
 function Valor2()
 {
	var selectedItem = document.form1.available.selectedIndex;
	var selectedText = " "+document.form1.available.options[selectedItem].text+" ";
	var selectedValue = document.form1.available.options[selectedItem].value;
	num=selectedText;
	Valor(num);    
 }
 function Valor3()
 {
	var selectedItem = document.form1.available2.selectedIndex;
	var selectedText = " "+document.form1.available2.options[selectedItem].text+" ";
	var selectedValue = document.form1.available2.options[selectedItem].value;
	num=selectedText;
	Valor(num);    
 }
 function Valor4()
 {
	var selectedItem = document.form1.available3.selectedIndex;
	var selectedText = " "+document.form1.available3.options[selectedItem].text+" ";
	var selectedValue = document.form1.available3.options[selectedItem].value;
	num=selectedText;
	Valor(num);    
 }
 function Valor5()
 {
	var selectedItem = document.form1.TABLAS1.selectedIndex;
	var selectedText = " "+document.form1.TABLAS1.options[selectedItem].text+" ";
	var selectedValue = document.form1.TABLAS1.options[selectedItem].value;
	num=selectedText;	
	Valor(num);    
 }
 function Valor6()
 {
	var selectedItem = document.form1.CAMPOS.selectedIndex;
	var selectedText = " "+document.form1.CAMPOS.options[selectedItem].text+" ";
	var selectedValue = document.form1.CAMPOS.options[selectedItem].value;
	num=selectedText;	
	Valor(num);    
 }
 function BorradoCAJA()
 { document.form1.CAJA.value = "";
   EsperaDato = true; 
 }
    -->
    </SCRIPT>
<?
 
if ($_POST['GENERAR']!="") 
{
	$texto=$_POST['CAJA'];
	$texto_aux="S";//inserta un dato para que no se considere como array
	//echo $texto;
	$j=0;
	//para quitar los \ del texto
	for ($i=0;$i<=strlen($texto)-1;$i++)
		{	
			if ($texto[$i]!='\\')
			{	
				$texto_aux[$j]=$texto[$i];					
				$j++;
			}
		}			
	echo "<br>";
	$q=new query();
	$this->sql=$texto_aux;
	//echo $texto_aux;
	$cadena=strtolower($texto_aux);
	//		 echo "$cadena";

	//para no autorizar los permisos
	if(ereg("insert",$cadena) or ereg("update",$cadena) or ereg("delete",$cadena))//busca la palabra 
	{
		//CAMBIAR
		echo '<form method="post" name="form1" action="'._PAG_PRINCIPAL.'?mod_id=modu">
			<br>
			<center>
				<br>No tiene permiso para ejecutar esa consulta
				<br>
				<br>
				<input type="button" class="boton" name="regresar" value="Regresar" onclick="location=\''._rutaraiz.'/index.php?mod_id=modu\'">
			</center>
			</form>';
		exit;
	}
	echo "<center>$this->sql</center>";//exit;
	$q->consulta($this->sql) or die ('<br><br><center><div>NO se pudo ejecutar a Consulta compruebe su sintaxis</div></center>
	<form method="post" name="form1" action="'._PAG_PRINCIPAL.'?mod_id=modu">
		<br>
		<center>
			<input type="button" class="boton" name="regresar" value="Regresar" onclick="javascript:window.history.back()">
		</center>
	</form>');
	
	//caso de que la consulta se realice
	echo "<br><br><center><div>Consulta Realizada</div></center>";
		 
	/*
	 //con frame
	 $consu=$q->ver_consulta();
	 echo "$consu"; exit;
	*/
	##INI//alternativa de muestra con estilos
	if($q->num_registros()>0)
	{
		$fin=$q->num_campos(); //para saber el numero de campos
	
		//echo "<table width=100% border='0'>";
		echo "<table width={$this->anchoform} border=0 cellpadding=2 cellspacing=0>";
		//muestra el nombre de campos de consulta
		echo "<tr class=fila_verde>";
		for ($j=0;$j<$fin;$j++)
		{	
			echo '<td style="font-size: 11px;">';
			//echo '<th style="font-size: 11px;">';
			$prim=$q->nombre_campo($j);
			echo "$prim";
			echo "</td>";
			//echo "</th>";
		}
		echo "</tr>";
			//exit;
			//$row=$q->valores_row();
			
		$i=0;
		while($row=$q->valores_fila())
		{
			$clase='fila_blanca';
			if($i % 2==0)
			{	$clase='fila_gris';
			}
			echo "<tr class=$clase>";
			for ($j=0;$j<$fin;$j++)
			{
				if ($row[$j]=='')
				{ echo "<td>-</td>";}
				else
				{					
					echo "<td>$row[$j]</td>";
				}
			}
			echo "</tr>";
			$i++;
		}
		echo "</table>";		
	}
	##FIN
	
	echo '<form method="post" name="form1" action="'._PAG_PRINCIPAL.'?mod_id=modu">
		<br>
		<center>
			<input type="button" class="boton" name="regresar" value="Regresar" onclick="location=\''._rutaraiz.'/index.php?mod_id=modu\'">
		</center>
	</form>';
	//<input type="button" class="boton" name="regresar" value="Regresar" onclick="javascript:window.history.back()">	
}
else
{	$dato=$_POST['CAJA'];
	//echo "dato==$dato";
	echo '
	<form name="form1" method="post" action="">
		<table width=100% border="1">
			<th>Consultas</th>
			<tr bgcolor="#368a54">
				<td>
					<center><textarea cols="100" rows="10" name="CAJA" id="CAJA">'.$dato.'</textarea></center>
				</td>
			</tr>
		</table>
		<center>
		<table  border="0" border=0 cellpadding=0 cellspacing=0>
			<tr style="font-size: 11px;">
				<th>Tablas		</th>
				<th>Campos		</th>
				<th>Sentencias	</th>
				<th>Funciones	</th>
				<th>Operaciones	</th>
			</tr>';
	echo "<tr align=center>
				<td>";
	$q = NEW QUERY;
	$sql="SHOW TABLES";//esto para mostrar tablas en sql
	//$sql="select tablename from pg_tables where schemaname='public' order by tablename";//esto para mostrar tablas en postgres
	//$sql="select * from pg_tables where schemaname='public' order by tablename";
	$res = $q->consulta($sql);	
	echo '<select name="TABLAS1" size=10 onClick="Valor5();">';//lista de tablas
	while($row=$q->valores_fila())
	{	echo "<option value=$g>$row[0]";
	}
	echo '</select>';
	echo "</td>
	<td>";
	$sql_T=$sql;//"SHOW TABLES";
	$q1= NEW QUERY;
	$res = $q->consulta($sql_T);
	$res1 = $q1->consulta($sql_T);
	if($_POST['TABLAS']!="")
	{	$g=$_POST['TABLAS'];
	}
	else
	{	$row=$q1->valores_fila();
		$g=$row[0];
	}
	//echo "g==".$g;
	//combo de tablas
	if ($q->num_registros($res)>0)
	{
		echo '<select class="combo" name="TABLAS" onchange="submit();">';
		while($row=$q->valores_fila())
		{	if($g==$row[0]&&$g!='')
			{ 	echo '<option value="'.$row[0].'" selected="selected">'.$row[0].'</option>';
			}
			else
			{	 echo '<option value="'.$row[0].'">'.$row[0].'</option>';
			}
		}
		echo '</select><br>';
	}
	//esto muestra los campos de la consulta	
	$sql="select * from $g";
	$res = $q->consulta($sql);	

	echo '<select name="CAMPOS"  size=9 onClick="Valor6();">';	
	if($q->num_registros()>0)
	{	$fin=$q->num_campos(); //para saber el numero de campos
		for ($j=0;$j<$fin;$j++)
		{ 	$prim=$q->nombre_campo($j);
			echo "<option value=$g>$prim";
		}
	}
	echo '</select>';	
echo "</td>
<td>";
?>
	<select name="available" size=10 onClick="Valor2();">
		<option value=1>SELECT
		<option value=2>FROM
		<option value=3>WHERE
		<option value=4>HAVING
	</select>	
</td>
<td>	
	<select name="available2" size=10 onClick="Valor3();">
		<option value=1>ORDER BY
		<option value=2>GROUP BY
		<option value=3>COUNT (*)
		<option value=4>SUM
		<option value=5>MAX
		<option value=6>MIN
		<option value=7>AVG
		<option value=8>DISTINCT
		<option value=9>INNER JOIN
		<option value=10>OUTER JOIN
		<option value=11>JOIN
		<option value=12>LEFT JOIN
		<option value=13>RIGTH JOIN
		<option value=14>UNION
		<option value=15>CONCAT
		<option value=16>BETWEEN
		<option value=17>LIMIT
		<option value=18>OFSET
	</select>
</td>
<td>
	<select name="available3" size=10 onClick="Valor4();">
		<option value=1>AND
		<option value=2>OR
		<option value=3>ASC
		<option value=4>DESC
		<option value=5>AS
		<option value=6>ON
		<option value=7>IN
		<option value=8>NOT IN
		<option value=9>NOT
		<option value=10>LIKE
		<option value=12>NOT LIKE
		<option value=13>=
		<option value=14>!=
		<option value=15><
		<option value=16>>
		<option value=17><=
		<option value=18>>=
		<option value=19><>
		<option value=20>,
		<option value=21>%
		<option value=22>(
		<option value=23>)
		<option value=24>IS NULL
		<option value=25>IS NOT NULL
		<option value=26>'
		<option value=27>+
		<option value=28>-
		<option value=29>*
		<option value=30>/
		<option value=31>&
		<option value=32>|
		<option value=33>^
		<option value=34>~
	</select>	
</td>
</table>
	<br>
	<input type="submit" class="boton" name="GENERAR" value="GENERAR">
	<input type="button" class="boton" name="Limpiar" value="Limpiar" onClick="BorradoCAJA();">
	</center>
<?echo '</form>';
	/*<tr>
	<td><a onClick="Valor(' SELECT ');"><b>SELECT</b></a></td>
	<td><a onClick="Valor(' FROM ');"><b>FROM</b></a></td>
	<td><a onClick="Valor(' WHERE ');"><b>WHERE</b></a></td>
	<td><a onClick="BorradoCAJA();"><b>LIMPIAR</b></a></td>	
	</tr>*/
}	

	
	
?>