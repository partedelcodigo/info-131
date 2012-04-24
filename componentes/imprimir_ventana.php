<?php

$extra1 =
        "'<html>
	<head><title>Vista Previa</title>
	<style type=text/css>
	@media print
	{
		#imprimir{
                    display:none;
                    visibility: hidden;
		}
	}
		#status
		{
		background-color: #C13536;
		border-bottom: 1px #000000 solid;
		border-top: 1px #000000 solid;
		border-right: 1px #000000 solid;
		border-left: 1px #000000 solid;
		text-align: right;
		padding-top: 5px;
		padding-bottom: 5px;
		padding-right: 10px;
		}

		#status p
		{
		display: inline;
		color: #ffffff;
		font-weight: bold;
		}

		#status p a:link, #status p a:visited
		{
		color: #ebebeb;
		}

		#status p a:hover
		{
		color: #000000;
		}

		h6
		{
		font-size: 0.5em;
		margin-bottom: 0.4em;
		font-style: normal;
		}

		#fecha p
		{
		text-align: right;
		font-size: 0.5em;
		}

		input.boton
		{
		display:none;
		}
		
		select.combo
		{
		display:none;
		}

		input.boton_fecha
		{
			display:none;
		}

		input.texto
		{
			border:none;
		}

		#submenu
		{
			display:none;
		}

		table
		{
			border: 1px outset #C13536;
		}

		table.cabecera
		{
			border: none;
		}

		table th
		{
			background: #C13536;
			border: 1px outset #C13536;
			color: #FFFFFF;
		}

		table tr.fila_blanca
		{
			font-size:0.8em;
			background:#FFFFFF;
			color: #000000;
		}

		table tr.fila_naranja
		{
			font-size:0.8em;
			background:#f8bc00;
			color: #000000;
		}

		table tr.fila_gris
		{
			font-size:0.8em;
			background:#DDDDDD;
			color: #000000;
		}

		table tr.fila_verde
		{
			font-size:0.9em;
			background:#75ab80;
			color: #FFFFFF;
		}
		font 
		{
			font-size:0.6em;
		}
		textarea.texto_area
		{
			border:dotted;
			border-color:#666666;
			border-width:2px;
		}
		</style>
		</head>
		<body>
			<div id=imprimir>
			<div id=status>";
$extra1.="<p>
				<a href=javascript:window.print();window.location.reload();>" . _men_imprimir . "</a>
				<a href=javascript:self.close();>" . _men_cerrar . "</a></td>
			</p>
			</div>
			</div>
		</body>
		</html>'";
//		$pagina="'main-text'";
$pagina = "'contenido'";
$page = "'about:blank'";
$extpage = "'c'";
$features = "'left=10,width=900,height=650,top=10,scrollbars=yes'";
?>