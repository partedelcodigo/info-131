
function reporteERROR(request)
{
	 alert('Hubo problemas con la peticion.');
}


function cargar_contenido(target, url)
{
         var ControladoresGlobales = {
		onCreate: function(){
			Element.show('cargando');
		},

		onComplete: function() {
			if(Ajax.activeRequestCount == 0){
				Element.hide('cargando');
			}
		}
	};
      //  document.getElementById(target).innerHTML = "<p class='load'><center><img src='graficos/cargando.gif' width='140'></center></p>";
	    Ajax.Responders.register(ControladoresGlobales);
        var myAjax = new Ajax.Updater( {success: target}, url, { method: 'get', parameters: "", onFailure: reporteERROR, evalScripts: true });
      
        
} 

function enviar(formulario,target)
{    
    /*var ControladoresGlobales = {
		onCreate: function(){
			Element.show('cargando');
		},

		onComplete: function() {
			if(Ajax.activeRequestCount == 0){
				Element.hide('cargando');
			}
		}
	};
        var variables = obtener_datos_form(formulario);		
        //alert (variables);
		Ajax.Responders.register(ControladoresGlobales);
	    var myAjax = new Ajax.Updater( {success: target}, formulario.action, { method: 'post', parameters: variables, onFailure: reporteERROR, evalScripts: true });*/
  
    formulario.action = "index.php?"+formulario.action.split("?")[1];  
	
	formulario.submit();
		
}


function cargar_menu(tar,url)
{
   // cargar_contenido(tar, url);
   window.location = "index"+url.substring(13,url.length);
  // alert(url.substring(13,url.length));
   
}



function obtener_datos_form(oForm) 
{
	var aParams = new Array();
	for (var i=0 ; i < oForm.elements.length; i++)
	{ 
		var sParam = encodeURIComponent(oForm.elements[i].name);
		var sParamtype = encodeURIComponent(oForm.elements[i].type);
		var sParamtagname = encodeURIComponent(oForm.elements[i].tagName);
		
		switch(sParamtagname) 
		{
		
				case 'INPUT': 	
					cargar_objeto_input(sParamtype,oForm.elements[i],sParam,aParams);							  
					break;
								
				case 'SELECT':				     
					//cargar_objeto_select(sParam,aParams,oForm.elements[i]);
					poner_valor(sParam,aParams,oForm.elements[i]);
					break;
								
				case 'TEXTAREA':
					poner_valor(sParam,aParams,oForm.elements[i]);
					break;
								
		}
			
	} 
	
	return aParams.join("&");        
}
	
	
function poner_valor(sParam,aParams,objeto)
{
	sParam += "=";     	 
	sParam += encodeURIComponent(objeto.value);
	//sParam += encodeURI(objeto.value);
	aParams.push(sParam);

}

/*function cargar_objeto_select(sParam,aParams,objeto)
{
    sParam += "=";     	 
	sParam += encodeURIComponent(objeto.options[objeto.selectedIndex].value);
	aParams.push(sParam);   
}*/


function cargar_objeto_input(tipo,objeto,sParam,aParams)
{
	switch(tipo) 
	{
		case 'text':
			poner_valor(sParam,aParams,objeto);
			break;
		case 'hidden':
			poner_valor(sParam,aParams,objeto);
			break;
		case 'password':
			poner_valor(sParam,aParams,objeto);
			break;
		case 'checkbox':
			if (objeto.checked)
			{
				poner_valor(sParam,aParams,objeto);
			}	

			break;
		case 'radio':
			if (objeto.checked)
			{
				poner_valor(sParam,aParams,objeto);
			}        		
			break;
	}	
}
