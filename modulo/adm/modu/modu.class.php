<?PHP
class MOD
{
	function ingresar()
	{
		$q = new QUERY;
		$sql = "select max(ele_orden) from ad_elemento";
		$q->consulta($sql);
		list($numero)=$q->valores_fila();
		if ($numero != "")
		{
		$numero = $numero + 1;
		}
		else
		{
		$numero = 1;
		}
		
		require_once("clases/formulario.php");
	  	$f=new FORMULARIO();
		$tablas=array('ad_elemento');
	  	$f->inicializa("modu",_mo_titulo, $tablas, "form", _msg_comp, "100%");
	  	$valores[0]= array(_ele_tipo,_ele_origen,_ele_descripcion,_ele_estado,_ele_icono,"pos");
  	  	$valores[1]= array("ad_elemento.ele_tipo","ad_elemento.ele_origen","ad_elemento.ele_descripcion","ad_elemento.ele_estado","ad_elemento.ele_icono","ad_elemento.ele_orden");
	  	$valores[2]= array("15","15","40","5","20","11");
	  	$valores[3]= array("5","5","14","7","14","5");
	  	$valores[4]= array("1","1","1","1","0","1");
	  	$cons_combo2=array();
	  	$cons_combo2['valorcombo']=array('app','mod');
	  	$cons_combo2['datocombo']=array('Aplicacion','Modulo');
	  	$cons_combo="select CONCAT(ele_descripcion,'/')as ele_descripcion,CONCAT(ele_descripcion,'/') as ele_descripcion from ad_elemento 
	  	UNION select '/','/' from ad_elemento order by 2";
		$radioval=array("valorradio"=>array("N","H"),"datoradio"=>array("No","Si"));	  	
		$ultimo=array("valorcombo"=>array($numero),"datocombo"=>array($numero));
		$ventana_conf=array('ele_icono','ele_origen','ad_elemento');
	  	$valores[5]= array($cons_combo2,$cons_combo,"",$radioval,$ventana_conf,$ultimo);
	  	$valores[6]=array("","","","ad_elemento");
	  	$valores[7]= array("","","","1","");
	  	$valores[9]= array("index.php?mod_id=modu");
	  	$f->cargar_valores($valores);
	  	$f->mostrar_formulario();
	}

	function modificar()
	{
		require_once("clases/formulario.php");
	  	$f=new FORMULARIO();
		$tablas=array('ad_elemento');
	  	$f->inicializa("modu",_mo_titulo, $tablas, "form", _msg_comp, "100%");
	  	$valores[0]= array(_ele_tipo,_ele_origen,_ele_descripcion,_ele_estado,_ele_icono);
  	  	$valores[1]= array("ad_elemento.ele_tipo","ad_elemento.ele_origen","ad_elemento.ele_descripcion","ad_elemento.ele_estado","ad_elemento.ele_icono");
	  	$valores[2]= array("15","15","40","5","20");
	  	$valores[3]= array("5","5","14","7","14");
	  	$valores[4]= array("1","1","1","1","0");
	  	$cons_combo2=array();
	  	$cons_combo2['valorcombo']=array('app','mod');
	  	$cons_combo2['datocombo']=array('Aplicacion','Modulo');
	  	$cons_combo="select CONCAT(ele_descripcion,'/')as ele_descripcion,CONCAT(ele_descripcion,'/') as ele_descripcion from ad_elemento 
	  	UNION select '/','/' from ad_elemento order by 2";
	  	$radioval=array("valorradio"=>array("N","H"),"datoradio"=>array("No","Si"));
	  	$ventana_conf=array('ele_icono','ele_origen','ad_elemento');
	  	$valores[5]= array($cons_combo2,$cons_combo,"",$radioval,$ventana_conf);
	  	$valores[6]=array("","","","ad_elemento");
	  	$valores[9]= array("index.php?mod_id=modu");
	  	$f->cargar_valores($valores);
	  	$f->mostrar_formulario(1);
	}

	function ver()
	{
		require_once("clases/formulario.php");
	  	$f=new FORMULARIO();
		$tablas=array('ad_elemento');
	  	$f->inicializa("modu",_mo_titulo, $tablas, "form", _msg_comp, "100%");
	  	$valores[0]= array(_ele_tipo,_ele_origen,_ele_descripcion,_ele_estado,_ele_icono);
  	  	$valores[1]= array("ad_elemento.ele_tipo","ad_elemento.ele_origen","ad_elemento.ele_descripcion","ad_elemento.ele_estado","ad_elemento.ele_icono");
	  	$valores[2]= array("15","15","40","5","20");
	  	$valores[3]= array("1","14","1","1","1");
	  	$f->cargar_valores($valores);
		$f->ver_formulario(1);
	  	//$f->mostrar_formulario(1);   Modificado por ronny		
	}

	function busqueda()
	{
  		require_once("clases/busqueda.php");
	  	$b=new BUSQUEDA();
  	  	$b->inicializa("modu",_mo_titulo_busqueda, "ad_elemento", "form", "100%", "ele_id");
  	  	$valores[0]= array(_ele_descripcion,_ele_origen,_ele_estado);
  	  	$valores[1]= array("ele_descripcion","ele_origen","ele_estado");
	  	$valores[2]= array("15","25","5");
	  	$valores[3]= array("1","1","1");
  	  	$b->cargar_parametros($valores);
  	  	$b->mostrar_busqueda();
	}

	function busquedae()
	{
	  	require_once("clases/busquedae.php");
	  	$busq=new BUSQUEDAE();
  	  	$busq->inicializa("modu","Busqueda de modulo", "ad_elemento", "form", "100%", "ele_id",1);
  	  	$valores[0]= array(_ele_descripcion,_ele_origen);
  	  	$valores[1]= array("ele_descripcion","ele_origen");
	  	$valores[2]= array("18","14");
	  	$valores[3]= array("1","1");
  	  	$busq->cargar_parametros($valores);
  	  	$busq->mostrar_busqueda();
	  	echo "<center>";
	  	echo "<input class=boton name=Ingresar type=button value='"._men_cerrar."' onclick=\"javascript:window.close()\"/><br><br>";
	  	echo "</center>";
	}
	function eliminar()
	{ 
	require_once("clases/formulario.php");
	$formu=new FORMULARIO();
	$tablas=array('ad_elemento');
	$formu->inicializa("modu",_usu_titulo, $tablas, "form", _msg_comp, "100%");
	
	$formu->eliminar_formulario();
	$valores[9]= array("index.php?mod_id=modu");

	
	}
};
?>
