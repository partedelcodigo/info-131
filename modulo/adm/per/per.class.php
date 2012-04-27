<?PHP

class PER
{
	var $valores;
	
	function PER()
	{
	  	$this->valores[0]= array(_per_gru_id,_per_mod_id,_per_permiso);
  	  	$this->valores[1]= array("ad_permiso_mod.elp_gru_id","ad_permiso_mod.elp_ele_id","ad_permiso_mod.elp_permiso");
	  	$this->valores[2]= array("25","40","10");
	  	$this->valores[3]= array("5","9","1");
	  	$this->valores[4]= array("1","1","1");
//	  $sql2="select mod_id,mod_descripcion from ad_modulo";
	  	$sql1="select gru_id,gru_id from ad_grupo";
		//	  $valores[5]= array("",$sql1,$sql2,"");
	  	$this->valores[5]= array($sql1,"","");
	  	$this->valores[6]= array("","modu","");
		$this->valores[9]= array("index.php?mod_id=per");
	}
	
	function ingresar()
	{ // echo "aqui"; exit;
		require_once("clases/formulario.php");
	  	$f=new FORMULARIO();
	  	$f->inicializa("per",_per_titulo, array("ad_permiso_mod"), "form", _msg_comp, "100%");
	  	$f->cargar_valores($this->valores);
	  	$f->mostrar_formulario();
	}

	function modificar()
	{
		require_once("clases/formulario.php");
	  	$f=new FORMULARIO();
	  	$f->inicializa("per",_per_titulo, array("ad_permiso_mod"), "form", _msg_comp, "100%");
	  	$valores[0]= array(_per_gru_id,_per_mod_id,_per_permiso);
  	  	$valores[1]= array("ad_permiso_mod.elp_gru_id","ad_permiso_mod.elp_ele_id","ad_permiso_mod.elp_permiso");
	  	$valores[2]= array("25","25","10");
	  	$valores[3]= array("5","5","1");
	  	$valores[4]= array("1","1","1");
	  	$sql1="select gru_id,gru_id from ad_grupo";
		$sql2="select ele_id,ele_descripcion from ad_elemento";
		//$sql2="select ele_id,ele_origen,ele_descripcion from ad_elemento";
//	  	$ventana_conf=array("ele_id","ele_descripcion","ad_elemento");
	  	$valores[5]= array($sql1,$sql2,"");
//	  	$valores[6]= array("","modu","");
		$valores[9]= array("index.php?mod_id=per");
		$f->cargar_valores($valores);
	  	$f->mostrar_formulario(1);
	}

	function ver()
	{
	  require_once("clases/formulario.php");
	  $formu=new FORMULARIO();
	  //formulario vista
	  $formu->inicializa("per",_per_titulo, array("ad_permiso_mod"), "form", _msg_comp, "100%");
  	  $valores[0]= array(_per_id,_per_gru_id,_per_mod_id,_per_permiso);
  	  $valores[1]= array("ad_permiso_mod.elp_id","ad_permiso_mod.elp_gru_id","ad_permiso_mod.elp_ele_id","ad_permiso_mod.elp_permiso");
	  $valores[2]= array("3","15","15","10");
	  $valores[3]= array("11","5","5","1");
	  	$sql1="select gru_id,gru_id from ad_grupo";
		$sql2="select ele_id,ele_descripcion from ad_elemento";
	  $valores[5]= array("",$sql1,$sql2,"");
//	  $valores['order']=array("0","0","1","0");
	  $formu->cargar_valores($valores);
	  $formu->ver_formulario();
	}

	function busqueda()
	{
		require_once("clases/busqueda.php");
		$busq=new BUSQUEDA();
		$busq->inicializa("per",_per_titulo_busqueda, "ad_permiso_mod", "form", "100%", "elp_id");
		$valores[0]= array(_per_gru_id,_per_mod_id,_per_permiso);
		$valores[1]= array("elp_gru_id","elp_ele_id","elp_permiso");
		$valores[2]= array("10","20","10");
		$valores[3]= array("17","17","1");
		$sql2="select gru_id,gru_id from ad_grupo";
		if ((isset($_POST['elp_gru_id'])) && ($_POST['elp_gru_id']<>null))
		{
			$sql3="select ele_id,ele_descripcion from ad_elemento inner join ad_permiso_mod on elp_ele_id=ele_id where elp_gru_id='".$_POST['elp_gru_id']."' order by ele_descripcion";
		}
		else
		{
			$sql3="select ele_id,ele_descripcion from ad_elemento where ele_id = ele_id	 order by ele_descripcion";			
		}
		$valores[5]= array($sql2,$sql3,"");
		$valores['order']=array("1","","");
		$busq->cargar_parametros($valores);
		$busq->mostrar_busqueda();
	}

	function busquedae()
	{
		require_once("clases/busquedae.php");
		$busq=new BUSQUEDAE();
		$busq->inicializa("per","Busqueda de Modulo", "ad_elemento", "form", "100%", "ele_id",1);
		$valores[0]= array(_ele_id,_ele_descripcion);
		$valores[1]= array("ele_id","ele_descripcion");
		$valores[2]= array("4","18","14");
		$valores[3]= array("1","1","1");
		$valores['order']=array("","1");
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
	  	$formu->inicializa("per",_per_titulo, array("ad_permiso_mod"), "form", _msg_comp, "100%");
	  	$formu->eliminar_formulario();
	}
};
?>