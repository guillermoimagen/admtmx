<script>
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function enviardatos(modo)
{
	
	var Formulario = document.getElementById("form1");
	var longitudFormulario = Formulario.elements.length;
	var cadena_enviar='';
	
	document.getElementById("error_form1").style.display='none';
	document.getElementById("label_mensaje").innerHTML='<span class=textogeneral><br></span>';
	
	if(v.exec())
	{
		document.getElementById('error_form1').className="";
		if(modo=='S')
		{		
			for (var i=0;i<=Formulario.elements.length-1;i++)
			{
				res=encodeURI(Formulario.elements[i].value);
				res2=Formulario.elements[i].type;
				if(res2!="hidden" && res2!="button"  && res2!="submit") 
				cadena_enviar= cadena_enviar+'&'+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
			}
			
			var tabla=<?=$numerodetabla?>;
			<? if($step=="modify") { ?>
			var id=<?=$id?>;		
			<? } ?>
			var modo='ajax';
			ajax=objetoAjax();
			ajax.open("POST","status_validar.php",true);
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("tabla="+tabla+"&id="+id+"&modo="+modo+"&nombrecampostatus=<?=$status_campo?>&longitudFormulario="+longitudFormulario+cadena_enviar);
			ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4)
				{
					var respuesta=ajax.responseText;
					if(respuesta=='')
					{
						document.getElementById("error_form1").className=""; 
						Formulario.submit();
					}
					if(respuesta!='')
					{
						valor=respuesta.search('ERRORSINES');
						if(valor!=-1)
						{
							errorsines=respuesta.substr(valor+11,10000);
							var pedazos=errorsines.split(",");
							for(i=0; i<=pedazos.length-2; i++)
								document.getElementById(pedazos[i]).className ='';
							respuesta=respuesta.substr(0,valor);
						}					
						document.getElementById("error_form1").className="";
						document.getElementById("error_form1").style.display='block';
						constructor=document.getElementById("error_form1");					
						constructor.innerHTML=respuesta;					
					}
				}
				resizeCaller();
				return false;
			}
		}
		else return true;
	}
	document.getElementById('error_form1').className="";
	resizeCaller();
	return false;
}
</script>