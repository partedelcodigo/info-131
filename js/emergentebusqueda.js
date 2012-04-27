function emergente_busca(modulo,nombreform,campo,tipo)
{
//  var url = "lista_productos.php" + "?snome=" + escape(document.nombreform.aluno_nome.value);
//  alert(modulo);
  var wnd = window.open("emergente.php?mod_id="+modulo+"&tarea=buscae&nombreform="+nombreform+"&campo="+campo+"&tipo="+tipo,'busca'+modulo,'toolbar=no,width=640,height=350,scrollbars=yes');  
  //toolbar=no,width=530,height=350,scrollbars=yes 
}

function emergente_busca_mascara(modulo,nombreform,campo,tipo,valores,formulario)
{
	  
	    var vector = valores.split(',');
	    var cad = "";
	    for (i = 0; i < vector.length; i++) 
        {       
            if (document.getElementById(vector[i])==null)  
			{
			   var val = "formulario."+vector[i]+".value";
			   cad+= eval(val)+",";			 
			}
            else			
	          cad+=document.getElementById(vector[i]).value+",";
	  }	  
	  var cad = cad.substr(0,(cad.length-1));
	  emergente_busca(modulo+cad,nombreform,campo,tipo);
}
function emergente_busqueda_tipo(modulo,nombreform,campo,tipo,atributos,valores,formulario)
{
	var vector_val = valores.split(',');
	var vector_atr=atributos.split(',');
	var atrb ="&atrib="+vector_atr[0]+','+vector_atr[1];
	var valor="&valor="+document.getElementById(vector_val[0]).value+','+document.getElementById(vector_val[1]).value;
	var tipo="&tipob=";	
	if (!(document.getElementById(vector_val[2])==null))
	{
		var sem = "formulario."+vector_val[3]+".value";
		sem= eval(sem);	
		var n=new Number(sem);
		if (isNaN(n)==false)		
		{
			valor+=','+document.getElementById(vector_val[2]).value;
			atrb+=','+vector_atr[2];
			valor+=','+n;
			atrb+=','+vector_atr[3];
			tipo+='3';	
		}
		else
		{
			var mat=document.getElementById(vector_val[4]).value;
			mat=eval(mat);
			var i=new Number(mat);
			if (isNaN(i)==false)
			{
				valor+=','+document.getElementById(vector_val[2]).value;
				atrb+=','+vector_atr[2];
				valor+=','+document.getElementById(vector_val[4]).value;
				atrb+=','+vector_atr[4];
				tipo+='2';	
			}
			else
			{
				valor+=','+document.getElementById(vector_val[2]).value;
				atrb+=','+vector_atr[2];
				tipo+='1';
			}
		}
	}
	else
	{
		tipo+='0';
	}
	var cad =atrb+valor+tipo;
	emergente_busca(modulo+cad,nombreform,campo,tipo);
}
 
