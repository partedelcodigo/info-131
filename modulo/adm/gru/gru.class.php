<?PHP
class GRU
{
	function ingresar()
    {
		require_once("clases/formulario.php"); 
		$f = new FORMULARIO();
	  	//formulario de ingreso
	  	$f->inicializa("gru",_gru_titulo, array("ad_grupo"), "form", _msg_comp, "100%");
	  	$valores[0]= array(_gru_id,_gru_observaciones,_msg_estado);
	  	$valores[1]= array("ad_grupo.gru_id","ad_grupo.gru_obs","ad_grupo.gru_estado");
	  	$valores[2]= array("20","1","1");
	  	$valores[3]= array("1","3","4");
	  	$valores[4]= array("1","0","0");
		$valores[9]= array("index.php?mod_id=gru");
	  	$f->cargar_valores($valores);
	  	$f->mostrar_formulario();
	}

	function modificar()
    {
		require_once("clases/formulario.php");
	  	$f = new FORMULARIO();
 	  	//formulario de ingreso
	  	$f->inicializa("gru",_gru_titulo, array("ad_grupo"), "form", _msg_comp, "100%");
	  	$valores[0]= array(_gru_id,_gru_observaciones,_msg_estado);
	  	$valores[1]= array("ad_grupo.gru_id","ad_grupo.gru_obs","ad_grupo.gru_estado");
	  	$valores[2]= array("20","1","1");
	  	$valores[3]= array("1","3","4");
	  	$valores[4]= array("1","0","0");
		$valores[9]= array("index.php?mod_id=gru");
	  	$f->cargar_valores($valores);
	  	$f->mostrar_formulario(1);
	}

	function ver()
    {
		require_once("clases/formulario.php");
	  	$f=new FORMULARIO();
	  	//formulario vista
	  	$f->inicializa("gru",_gru_titulo, array("ad_grupo"), "form", _msg_comp, "100%");
	  	$valores[0]= array(_gru_id,_gru_observaciones,_msg_estado);
	  	$valores[1]= array("ad_grupo.gru_id","ad_grupo.gru_obs","ad_grupo.gru_estado");
	  	$valores[2]= array("20","1","1");
	  	$valores[3]= array("1","3","4");
	  	$valores[4]= array("1","0","0");
	  	$f->cargar_valores($valores);
	  	$f->ver_formulario(1);
	}

	function busqueda()
    {
  		require_once("clases/busqueda.php");
  	  	//objeto de busqueda
	  	$busq=new BUSQUEDA();
  	  	$busq->inicializa("gru",_gru_titulo_busqueda, "ad_grupo", "form", "100%","gru_id");
  	  	$valores[0]= array(_gru_id,_gru_observaciones,_msg_estado);
  	  	$valores[1]= array("gru_id","gru_obs","gru_estado");
	  	$valores[2]= array("20","50","5");
	  	$valores[3]= array("1","1","5");
		$array=array("valorcombo"=>array('1','0',''),"datocombo"=>array("SI","NO","TODOS"));
		$valores[5]= array("","",$array);
		$valores['order']=array("1","0","0");
		$valores['tipo_bit']= array("0","0","1");
  	  	$busq->cargar_parametros($valores);
  	  	$busq->mostrar_busqueda();
	}
	
	function busquedae()
	{  
  	  require_once("clases/busquedae.php");
  	  //objeto de busqueda
	  $busq=new BUSQUEDAE();
  	  $busq->inicializa("gru",_gru_titulo_busqueda, "ad_grupo", "form", "100%", "gru_id");
  	  $valores[0]= array(_gru_id,_gru_observaciones);
  	  $valores[1]= array("gru_id","gru_obs");
	  $valores[2]= array("18","50");
	  $valores[3]= array("1","1");
  	  $busq->cargar_parametros($valores);  	  
	  
  	  $busq->mostrar_busqueda();
	}

	function eliminar()
	{
		
		require_once("clases/formulario.php");
		//echo "hola"; exit;
		$formu=new FORMULARIO();
		$tabla = array('ad_grupo');
		$formu->inicializa("gru","eliminado",$tabla, "form","", "100%");
		
		
		$formu->eliminar_formulario();
		$valores[9]= array("index.php?mod_id=gru");					
	}	
};
?>
