<?PHP
	require_once('componentes/contenido_emergente.php');
	require_once ('define/config.php');
    	require_once ('define/config_db.php');
	    require_once(_rutaraiz.'/clases/bd/'._lib_conexion);
	    require_once ('componentes/pantalla_inicial.php');
	    require_once ('lenguaje/'._lenguaje);
	    require_once ('clases/ventana.php');
	    require_once ('clases/sesion_handle.php');
	    require_once ('clases/controles.php');
	    require_once('clases/persona.php');
	    require_once('clases/bd/sql.php');

class PAGINA
{
	var $modulo;
	var $usuario;
	var $cabecera;
	var $pie_pagina;
	var $contenido;
	var $datos_generales;
	var $menu;
	var $barra;
	var $servicios;

	function PAGINA()
	{
		echo "PAGINA";
		$this->contenido=new CONTENIDO;
		$this->usuario=new PERSONA;
		$this->tipo=$_GET['tipo'];
		
		if(!empty($_GET['mod_id']))
		{
			$this->modulo=$_GET['mod_id'];
		}
		else
		{
			$this->modulo='login';
		}
	}

	function cargar_modulo()
	{
		$this->dibujar();
	}

	function get_estilo()
	{
		echo '<link rel="stylesheet" type="text/css" href="css/'._hoja_estilo.'">';
	}

	function get_cabecera()
	{
		$this->get_componente($this->cabecera);
	}

	function get_pie_pagina()
	{
		if(trim($this->modulo)<>'login')
		{
			$this->get_componente($this->datos_generales);
		}
		$this->get_componente($this->pie_pagina);
	}

	function get_origen($descripcion)
	{
		if(trim($descripcion)<>'')
		{
			$query=new QUERY;
			/*reemplazar por el modulo sql*/
			$sql="SELECT ele_origen
			       FROM ad_elemento
			       WHERE ele_descripcion like '".$descripcion."'";
			$query->consulta($sql);

			list($origen)=$query->valores_fila();

			$query->cerrar();

			/**verificamos que la cadena '/' exista en la cadena central */

			if(strpos($origen, '/')>0)
			{
				$descripcion = substr($origen,0,strpos($origen,'/'));
			}
			else
			{
				$descripcion ='';
			}

			return $this->get_origen($descripcion).$origen;

		}
		else
		{

			return '';

		}

	}

	function get_contenido()
	{

		if ($this->get_origen($this->modulo)=='') 
		{
			$path=_rutaraiz.'/modulo/clasesesextra/'.$this->modulo.'/'.$this->modulo.'.php';
		}
		else 
		{
			$path=_rutaraiz.'/modulo'.$this->get_origen($this->modulo).$this->modulo.'/'.$this->modulo.'.php';
		}

		$this->contenido->set_path($path);

		$this->get_componente($this->contenido);
	}

	function get_menu()
	{
		if(trim($this->modulo)<>'login')
		{
			$this->get_componente($this->menu);
		}
	}

	function get_servicios()
	{
		if(trim($this->modulo)<>'login')
		{
			$this->get_componente($this->servicios);
		}
	}


	function get_barra_configuracion()
	{
		if(trim($this->modulo)<>'login')
		{
			$this->get_componente($this->barra);
		}
	}

	function cargar_libs()
	{
		echo '<script type="text/javascript" src="js/calendario.js"></script>
		    <script type="text/javascript" src="js/valida.js"></script>
			<script type="text/javascript" src="js/eventos.js"></script>
			<!-- librería para cargar el lenguaje deseado -->
			<script type="text/javascript" src="js/calendario2.js"></script>
			<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
			<script type="text/javascript" src="js/calendariosetup.js"></script>
			<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
			<!-- librería para jalar valores de una ventana emergente -->
			<script type="text/javascript" src="js/emergentebusqueda.js"></script>
			<link rel="stylesheet" type="text/css" media="all" href="css/estilo.css" title="win2k-cold-1" />
			<script language="JavaScript" src="js/JSCookMenu.js"></script>
			<link rel="stylesheet" href="css/theme.css" type="text/css">
			<script language="JavaScript" src="js/theme.js"></script>';
	}

	function dibujar()
	{
		if(!($this->usuario->registrado()))
		{
			$this->modulo='login';
		}
		 $nombreform=$_GET["nombreform"];		 
		 $campo=$_GET["campo"];
 		if (isset($this->tipo))
		{
			$campo1=$campo.'_texto1';	
		}		
		 $campo2=$campo.'_texto';
		echo '<html>';
		echo '<head>';
		echo '<title>';
		echo '</title>';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
			$this->cargar_libs();
			$this->get_estilo();
			echo "<script>
					function refresh()
					{
						var sURL=window.opener.location.href;
						window.opener.location.href=sURL;
						window.close();
					}
			</script>";
			//para recargar datos de la ventana emergente3
			if ($this->tipo==2)
			{
			echo " <script>
						function ponPrefijo(id,valor1,valor2)
					{
						opener.document.{$nombreform}.{$campo}.value=id
						opener.document.{$nombreform}.{$campo1}.value=valor1
						opener.document.{$nombreform}.{$campo2}.value=valor2
						window.close()
					}
					</script>";
			}
			else
			{
			echo " <script>
						function ponPrefijo(id,valor)
					{
						opener.document.{$nombreform}.{$campo}.value=id						
						opener.document.{$nombreform}.{$campo2}.value=valor
						
						window.close()
					}
					</script>";
			}
		echo '</head>';
		echo '<body>';

			/**Cabecera de la Pagina*/

			//$this->get_cabecera();

			/**Panel Central*/

			$this->get_contenido();

			/**Barra Menu*/

			//$this->get_menu();

			/**Barra panel superior derecho*/

			//$this->get_barra_configuracion();

			/**Barra panel inferior derecho*/

			//$this->get_servicios();

			/**Pie de Pagina*/

			//$this->get_pie_pagina();
		echo '</body>';
		echo '</html>';

	}

	function get_componente($obj)
	{
		$obj->dibujar();
	}

}
?>
