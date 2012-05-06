<?
require_once('../define/config.php');

//if($_GET['eme'] or $_FILES['file'])
//{

//define('_fotos','../fotos');
$storage_dir = "../"._fotos; // storage directory (chmod 777)
$max_filesize = 15 * pow(1024,2); // maximum filesize (x MiB)
$allowed_fileext = array("gif","jpg","jpeg","png");
if (isset($_FILES['file']))
uploadfile($_FILES['file']);

function uploadfile($file) {
	global $storage_dir, $max_filesize, $allowed_fileext, $errormsg;

	if ($file['error']!=0) {
		switch ($file['error']) {
			case 1: $errormsg = "El archivo exede el tama�o maximo permitido por php.ini"; break;
			case 2: $errormsg = "El archivo exede el tama�o maximo permitido por el formulario."; break;
			case 3: $errormsg = "El archivo se subio de forma parcial."; break;
			case 4: $errormsg = "No se subio ning�n archivo."; break;
			case 6: $errormsg = "No se encuentra el directorio temporal."; break;
		}
		return;
	}
	
	//nombre del archivo con el que se subira la cuestion
	$filesource=$file['tmp_name'];
	//$filename="vladito.jpg";
	
	//$filename=$file['name'];
	if (isset($_POST['rename']) && $_POST['rename']!="") $filename=$_POST['rename'];
	//if (!in_array(strtolower($filename), $allowed_fileext)) $filename .= ".badext";
	
	
	$filesize=$file['size'];
	if ($filesize > $max_filesize) {
		$errormsg = "File size is greater than the file size limit.";
		return;
	}
	$filedest="$storage_dir/$filename";
	/*
	if (file_exists($filedest)) {
		$errormsg = "$filename exists already in the storage directory.";
		return;
	}
	*/
	if (!copy($filesource,$filedest)) {
		$errormsg = "No se puede guardar la imagen en la carpeta.";
	}
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
						
  <script type="text/javascript">
<!--//<![CDATA[
  var row = null;


  function renameSync() {
  	var fn = document.getElementById("file").value;
  	if (fn == ""){
  		document.getElementById("filename").value = '';
  	} else {
		var b = fn.match(/[\/|\\]([^\\\/]+)$/);
  		document.getElementById("filename").value = b[1];
  	}

  	filetypeCheck();
  }
  function filetypeCheck() {
  	var allowedtypes = '.<? echo join(".",$allowed_fileext); ?>.';

  	var fn = document.getElementById("filename").value;
  	if (fn == ""){
  		document.getElementById("allowed").className ='';
  		document.getElementById("upload").disabled = true;
  	} else {
  		var ext = fn.split(".");
  		if (ext.length==1)
  		ext = '.noext.';
  		else
  		ext = '.' + ext[ext.length-1].toLowerCase() + '.';

  		if (allowedtypes.indexOf(ext) == -1) {
  			document.getElementById("allowed").className ='red';
  			document.getElementById("upload").disabled = true;
  		} else {
  			document.getElementById("allowed").className ='';
  			document.getElementById("upload").disabled = false;
  		}
  	}

  }
 
//]]>-->
</script>
</head>
<body >


<?

$dire = "../"._fotos;
$id=$_GET['id'];
$rename=$id.".jpg";
$filedest=$dire."/".$rename;

// los datos pal reload
$mod_id=$_GET['mod_id'];
$tarea=$_GET['tarea'];
$cpt=$_GET['cpt'];
$lid=$_GET['lid'];
if($lid)
{ $id=$lid; }

if (file_exists($filedest) && isset($_FILES['file'])) 
{
		echo '<script language="JavaScript">
				window.opener.location.href ="../index.php?mod_id='.$mod_id.'&tarea='.$tarea.'&id='.$id.'&cpt='.$cpt.'";
				window.close(); 
				</script> ';
}
else
{
?>
	<table style="width: 95%; background-color:white;" align="center">
		<tr>
			<td>
		<form method="post" enctype="multipart/form-data" action="">
		<p><input type="file" id="file" name="file" size="30"  onchange="renameSync();" style="border: thin solid #008000" /><input class=boton id="upload" type="submit" value="Upload" disabled="disabled" /></p>
		<p><input type="hidden" id="filename" name="filename" onkeyup="filetypeCheck();" size="30" /></p>
		<p><input type="hidden" id="rename" name="rename" size="46" value="<? echo $rename ?>" /></p>
		<p class="small" style="text-transform: uppercase; font-size: 9px"><span id="allowed"><? echo "Tipos de archivo permitidos: "; echo join(",",$allowed_fileext); ?></span><br />Maximo tama�o permitido: 8 Mb</p>
		</form>
			
			</td>
		</tr>
	</table>


<? } ?>

</body>
</html>
<?
// }

?>