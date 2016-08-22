var nivelActual=-1;
var spinner;
var timelinesRefrescar="";
var idcfoto=0;
var campofoto="";
var wWidth=800;
var wHeight=600;
var movilVersion=false;
var operacionVentana="";
var operacionValor1="";
var operacionValor2="";
function veAlHome()
{
	swal({
	  title: "Confirmar",
	  text: "¿Desea ir al home?",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#59a2ea",
	  confirmButtonText: "Ir al home",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
	  for(var i=0; i<=nivelActual; i++)
		$( "#timeline"+i.toString() ).remove(); 
		nivelActual=-1;
		cargaArchivoDirecto("home.php?","Principal",-1,"");
	});

}

function limpiaCadena(replacestr,tipo,campo)
{
	replacestr=	$ESAPI.encoder().normalize(replacestr);
	replacestr=replacestr.replace(/&lt;/g, "");
	replacestr=replacestr.replace(/&gt/g, "");
	replacestr=replacestr.replace(/&#60;/g, "");
	replacestr=replacestr.replace(/&#62;/g, "");
	replacestr=replacestr.replace(/</g, "");
	replacestr=replacestr.replace(/>/g, "");
	replacestr=replacestr.replace(/\"/g, "");
	replacestr=replacestr.replace(/&#34;/g, "");

	if(tipo!="imagef" && campo!="tab_urlret_as")
	{
		replacestr=replacestr.replace(/&#47;/g, "");
		replacestr=replacestr.replace(/\//g, "");
	}
	return replacestr;
}
function replaceAllValor(str, find, replace,tipo,campo) { 
	var replacestr="";
	if(replace!="")
	{
		replacestr=limpiaCadena(replace,tipo,campo);
	}
	else replacestr="";
	return str.replace(new RegExp(find, 'g'), replacestr);
}

function replaceAll(str, find, replace) { // contenido seguro
  return str.replace(new RegExp(find, 'g'), replace);
}

function generaAyuda(ayuda)
{
	if(ayuda!="")
		return '<div class="textoAyuda">'+ayuda+'</div>';
	else return ''; 	
}
function timelineTitulo(objeto)
{
	var plantilla=$("#tituloTimeline").html();
	plantilla=replaceAll(plantilla,"#titulo#",reemplazoSeguro(objeto.titulo));
	return plantilla;
}

function timelineRegresar()
{
	if(!movilVersion)
	{
		var plantilla=$("#regresarTimeline").html();
		return plantilla;
	}
	else
	{
		var plantilla=$("#regresarTimelineMovil").html();
		return plantilla;
		
	}
}

function timelineBoton(objeto,cual)
{
	var plantilla=$("#botonTimeline").html();
	var color="#59A2EA";
	if(objeto.color) color=objeto.color;
	plantilla=replaceAll(plantilla,"#campo#","boton"+cual.toString()+"_"+nivelActual.toString());
	plantilla=replaceAll(plantilla,"#texto#",reemplazoSeguro(objeto.texto));
	plantilla=replaceAll(plantilla,"#tipoBoton#",reemplazoSeguroLimpia(objeto.tipoBoton));
	plantilla=replaceAll(plantilla,"#modoBoton#",reemplazoSeguroLimpia(objeto.modo));
	plantilla=replaceAll(plantilla,"#nivelBoton#",nivelActual.toString());
	
	plantilla=replaceAll(plantilla,"#color#",color);
	var url="";
	var confirmar=reemplazoSeguroLimpia(objeto.confirmar);
	var operacionExtra=reemplazoSeguroLimpia(objeto.operacionExtra);
	
	var extras="";
	if(objeto.tipoBoton)
	{
		if(objeto.tipoBoton=="directo")
		{
			url=reemplazoSeguroLimpia(objeto.archivo)+".php?modo="+reemplazoSeguroLimpia(objeto.modo)+"&id="+reemplazoSeguroLimpia(objeto.id)+"&operacion="+reemplazoSeguroLimpia(objeto.operacion)+"&";
		}
	}
	if(reemplazoSeguro(objeto.tipoBoton)=="accionConfirmar")
	{
		extras+=" url='"+reemplazoSeguro(objeto.url)+"'";
		extras+=" confirmar='"+reemplazoSeguroLimpia(objeto.mensaje)+"'";
	}
	else
	{
		extras+=" url='"+url+"'";
		extras+=" confirmar='"+confirmar+"'";
	}
	extras+=" operacionExtra='"+operacionExtra+"'";
	
	if(objeto.id)
		extras+=" idinterno='"+objeto.id+"'";
	if(objeto.establecimiento)
		extras+=" idinterno='"+objeto.establecimiento+"'";
	
	//extras+=" titulo='"+reemplazoSeguro(objeto.texto)+"'";
		
	plantilla=replaceAll(plantilla,"extras=\"\"",extras);
	plantilla=replaceAll(plantilla,"extras=''",extras);
	
	return plantilla;
}

function reemplazoSeguroLimpia(objeto)
{
	var devolver="";
	try {
	   devolver=limpiaCadena(objeto.toString(),"","");
	} catch(error) {
	  
	}
	return devolver;		
}

function reemplazoSeguro(objeto)
{
	var devolver="";
	try {
	   devolver=objeto.toString(),"","";
	} catch(error) {
	  
	}
	return devolver;		
}

function timelineSeparador(altura)
{
	if(!altura) altura="10";
	if(altura=="") altura="10";
	var plantilla="";
	plantilla=$("#separadorTimeline").html();
	plantilla=replaceAll(plantilla,"#altura#",altura);
	return plantilla;
}

function timelineToks(objeto,cual)
{
	var plantilla="";
	plantilla=$("#toksTimeline").html();
	plantilla=replaceAllValor(plantilla,"#valor#",reemplazoSeguro(objeto.valor));
	return plantilla;
}

function timelineColor(objeto,tipotimeline)
{
	var plantilla="";
	plantilla=$("#colorTimeline").html();
		
	plantilla=replaceAll(plantilla,"#label#",reemplazoSeguro(objeto.label));
	plantilla=replaceAll(plantilla,"#campo#",reemplazoSeguroLimpia(objeto.campo)+"_"+nivelActual.toString());
	plantilla=replaceAllValor(plantilla,"#valor#",reemplazoSeguro(objeto.valor));
	plantilla=replaceAll(plantilla,"#placeholder#",reemplazoSeguro(objeto.place));
	plantilla=replaceAll(plantilla,"#ayuda#",generaAyuda(reemplazoSeguro(objeto.ayuda)));
	
	// extras de validacion
	var extras="";
	var validation="";
	
	if(objeto.requerido)
		if(objeto.requerido.toString()=="true")	
			validation+=" required";
		
	if(validation!="") 
		extras+="  data-validation='"+validation+"'";
	
	plantilla=replaceAll(plantilla,"extras=\"\"",extras);
	plantilla=replaceAll(plantilla,"extras=''",extras);

	return plantilla;
}



function timelineTextfieldMemo(objeto,tipotimeline)
{
	var plantilla="";
	if(tipotimeline=="textfield")
		plantilla=$("#textfieldTimeline").html();
	else if(tipotimeline=="memo")
		plantilla=$("#memoTimeline").html();
	else if(tipotimeline=="fecha")
		plantilla=$("#fechaTimeline").html();
	else if(tipotimeline=="fechaRango")
		plantilla=$("#fechaRangoTimeline").html();
	else if(tipotimeline=="imagef")
		plantilla=$("#imagefTimeline").html();	
		
	plantilla=replaceAll(plantilla,"#label#",reemplazoSeguro(objeto.label));
	plantilla=replaceAll(plantilla,"#campo#",reemplazoSeguro(objeto.campo)+"_"+nivelActual.toString());
	plantilla=replaceAllValor(plantilla,"#valor#",reemplazoSeguro(objeto.valor),tipotimeline,reemplazoSeguro(objeto.campo));
	plantilla=replaceAll(plantilla,"#placeholder#",reemplazoSeguro(objeto.place));
	plantilla=replaceAll(plantilla,"#ayuda#",generaAyuda(reemplazoSeguro(objeto.ayuda)));

	var extras="";
	var validation="";
	var type="text";
	
	var campoVal=reemplazoSeguroLimpia(objeto.campo);
	if(campoVal.indexOf("email")>-1)
	{
		validation=" email";
		type="email";
	}
	
	if(objeto.password)	
	{
		if(objeto.password.toString()=="password")	
			type="password";
	}
	plantilla=replaceAll(plantilla,"#type#",type);
	
	// extras de validacion
	
	
	if(objeto.subtipotimeline)
	{
		if(objeto.subtipotimeline=="texto" || objeto.subtipotimeline=="memo") 
		{
			
			var minimo="0";
			var maximo="255";
			if(objeto.minimo)
				if(objeto.minimo.toString()!="") minimo=objeto.minimo.toString();
			if(objeto.maximo)
				if(objeto.maximo.toString()!="") maximo=objeto.maximo.toString();
			extras+=" data-validation-length='"+minimo+"-"+maximo+"'";
			validation+=" length";
			
			if(objeto.subtipotimeline=="texto")
			{
				var ancho="200";
				if(objeto.maximo)
				{
					var anchoNuevo=objeto.maximo*10;
					if(anchoNuevo>400) anchoNuevo=400;
					if(parent.wWidthExterno<500) anchoNuevo=parent.wWidthExterno-50;
					ancho=anchoNuevo.toString();
				}
				plantilla=replaceAll(plantilla,"#ancho#",ancho);
			}
			else if(objeto.subtipotimeline=="memo")
			{
				var anchoNuevo=397;
				if(parent.wWidthExterno<500) anchoNuevo=parent.wWidthExterno-50;
				var ancho=anchoNuevo.toString();
				plantilla=replaceAll(plantilla,"#ancho#",ancho);
			}

		}
		else if(objeto.subtipotimeline=="int" || objeto.subtipotimeline=="float") 
		{
			var minimo="0";
			var maximo="1000000";
			if(objeto.minimo)
				if(objeto.minimo.toString()!="") minimo=objeto.minimo.toString();
			if(objeto.maximo)
				if(objeto.maximo.toString()!="") maximo=objeto.maximo.toString();
			
			if(minimo!=maximo)
			{
				if(objeto.subtipotimeline=="float")
					extras+=" data-validation-allowing='range["+minimo+";"+maximo+"],float'";
				else extras+=" data-validation-allowing='range["+minimo+";"+maximo+"]'";
			}
			validation+=" number";
		}
	}
	else if(tipotimeline=="fecha" || tipotimeline=="fechaRango")
	{
		validation+=" date";
		//extras+=" data-validation-format='yyyy-mm-dd'";
	}
	else if(tipotimeline=="imagef")
	{
		
		var cadena=reemplazoSeguro(objeto.valor);
		if(cadena.indexOf("http:") !== -1 || cadena.indexOf("https:") !== -1) // si existe
			plantilla=replaceAllValor(plantilla,"#valorurl#",reemplazoSeguro(objeto.valor),tipotimeline,reemplazoSeguro(objeto.campo));
		else
			plantilla=replaceAllValor(plantilla,"#valorurl#","recursos/"+reemplazoSeguro(objeto.valor),tipotimeline,reemplazoSeguro(objeto.campo),tipotimeline,reemplazoSeguro(objeto.campo));
		extras+=" archivo='"+reemplazoSeguroLimpia(objeto.archivo)+"'";
		extras+=" tablafoto='"+reemplazoSeguroLimpia(objeto.tablafoto)+"'";
		extras+=" cfoto='"+reemplazoSeguroLimpia(objeto.cfoto)+"'";
		extras+=" idregistrofoto='"+reemplazoSeguroLimpia(objeto.idregistrofoto)+"'";
		if(reemplazoSeguro(objeto.valor)=="")
			plantilla=replaceAll(plantilla,"#display#","none");
		else plantilla=replaceAll(plantilla,"#display#","block");
		
		var anchoNuevo=320;
		if(parent.wWidthExterno<500) anchoNuevo=parent.wWidthExterno-60;
		var ancho=anchoNuevo.toString();
		plantilla=replaceAll(plantilla,"#ancho#",ancho);
	}

	if(objeto.requerido)
		if(objeto.requerido.toString()=="true")	
			validation+=" required";
			
	if(objeto.validaciones)
		if(objeto.validaciones.toString()!="")	
			validation+=' '+objeto.validaciones;
		
	if(validation!="") 
		extras+="  data-validation='"+validation+"'";
	
	plantilla=replaceAll(plantilla,"extras=\"\"",extras);
	plantilla=replaceAll(plantilla,"extras=''",extras);

	return plantilla;
}

function timelineSubtitulo(objeto,tipotimeline)
{
	var plantilla="";
	plantilla=$("#subtituloTimeline").html();
		
	plantilla=replaceAll(plantilla,"#label#",reemplazoSeguro(objeto.label));
	plantilla=replaceAll(plantilla,"#campo#",reemplazoSeguro(objeto.campo)+"_"+nivelActual.toString());
	plantilla=replaceAll(plantilla,"#ayuda#",generaAyuda(reemplazoSeguro(objeto.ayuda)));

	return plantilla;
}

// para valores encadenados
function cambioSelect(valor,url,campo)
{
	if(url!="") // tenemos url, es encadenado
	{
		$("#"+campo).empty(); // limpiamos el siguiente select
		$("#"+campo).append('<option selected="selected" value="0">...</option>');
			
		// vemos si hay otro hijo
		var cadenaNivel1=reemplazoSeguro($("#"+campo).attr("cadenaurl"));
		var campoNivel1=reemplazoSeguro($("#"+campo).attr("cadenacampo"));
		
		if(campoNivel1!="") // hay otro hijo
		{
			$("#"+campoNivel1).empty(); // limpiamos el siguiente select
			$("#"+campoNivel1).append('<option selected="selected" value="0">...</option>');
			
			// vemos si hay otro hijo
			var cadenaNivel2=reemplazoSeguro($("#"+campoNivel1).attr("cadenaurl"));
			var campoNivel2=reemplazoSeguro($("#"+campoNivel1).attr("cadenacampo"));
	
			if(campoNivel2!="") // hay otro hijo
			{
				$("#"+campoNivel2).empty(); // limpiamos el siguiente select
				$("#"+campoNivel2).append('<option selected="selected" value="0">...</option>');
				
				// vemos si hay otro hijo
				var cadenaNivel3=reemplazoSeguro($("#"+campoNivel2).attr("cadenaurl"));
				var campoNivel3=reemplazoSeguro($("#"+campoNivel2).attr("cadenacampo"));
	
				if(campoNivel3!="") // hay otro hijo
				{
					$("#"+campoNivel3).empty(); // limpiamos el siguiente select
					$("#"+campoNivel3).append('<option selected="selected" value="0">...</option>');
				}
			}
		}
		
		if(valor!=0) // es diferente de 0, entonces hay carga dinamica
		{
			//seguro
			url=encodeURI(url);
			$.getJSON("APIRemote/"+url+valor, function(result){ // es la url concatenada con el valor
				
				for ( var x = 0; x < result.response.arreglo.length; x++)  // poblamos el select correspondiente
					$("#"+campo).append('<option value="'+result.response.arreglo[x].idreal+'">'+result.response.arreglo[x].texto+'</option>');
			  }).fail(function() {
				  sweetAlert("Oops...", "Ocurrió un error con la consulta", "error");
			  });
		}
	}
}



function timelineSelector(objeto,tipotimeline)
{
	var plantilla="";
	if(tipotimeline=="segmented")
		plantilla=$("#segmentedTimeline").html();
	else if(tipotimeline=="picker")
		plantilla=$("#pickerTimeline").html();
	else if(tipotimeline=="radio")
		plantilla=$("#radioTimeline").html();
	plantilla=replaceAll(plantilla,"#label#",reemplazoSeguro(objeto.label));
	var campoUsar=reemplazoSeguro(objeto.campo)+"_"+nivelActual.toString();
	plantilla=replaceAll(plantilla,"#campo#",campoUsar);
	plantilla=replaceAll(plantilla,"#idinterno#",reemplazoSeguroLimpia(objeto.campo));
	plantilla=replaceAll(plantilla,"#valor#",reemplazoSeguro(objeto.valor));
	plantilla=replaceAll(plantilla,"#placeholder#",reemplazoSeguro(objeto.place));
	plantilla=replaceAll(plantilla,"#ayuda#",generaAyuda(reemplazoSeguro(objeto.ayuda)));

	var validation="";
	var extras="";
	if(tipotimeline=="picker")
	{
		if(objeto.opciones)
		{
			var opciones="";
			for ( var x = 0; x < objeto.opciones.length; x++) 
			{
				var selected="";
				if(objeto.opciones[x].valor==objeto.valor) selected=" selected";
				opciones+="<option value='"+objeto.opciones[x].valor+"'"+selected+">"+objeto.opciones[x].label+"</option>";
			}
			plantilla=replaceAll(plantilla,"#opciones#",opciones);
		}
	
		if(objeto.requerido)
		{
			if(objeto.requerido.toString()=="true")	
			{
				extras+=' data-validation="number" data-validation-allowing="range[1;10000000]" data-validation-error-msg="Requerido/Required"';
			}
		}
		if(validation!="") 
			extras+="  data-validation='"+validation+"'";
		
		// es encadenado	
		if(reemplazoSeguro(objeto.cadenaURL)!="")
		{
			extras+=" cadenaurl='"+objeto.cadenaURL+"'";
			extras+=" cadenacampo='"+objeto.cadenaCampo+"_"+nivelActual.toString()+"'";
			extras+=" onchange=\"cambioSelect(this.value,$(this).attr('cadenaurl'),$(this).attr('cadenacampo'))\"";
		}
	}
	else if(tipotimeline=="radio")
	{
		if(objeto.opciones)
		{
			var opciones="";
			for ( var x = 0; x < objeto.opciones.length; x++) 
			{
				var selected="";
				if(x==0) selected=" checked='checked'";
				if(objeto.opciones[x].valor==objeto.valor) selected=" checked='checked'";
				var imagen="recursos/"+arreglaImagen(objeto.opciones[x].imagen,"D");
				var descripcion=replaceAll(objeto.opciones[x].descripcion,"\"","");
				descripcion=replaceAll(descripcion,"'","");
				// seguro
				opciones+="<div style='float:left; margin:5px; text-align:center; width:130px;' onclick='$(\"#descripcionRadio\").html(\""+descripcion+"\");'><label ><img src='"+imagen+"' style='width:100px; height:100px'><br><input type='radio' id='"+campoUsar+"' name='"+campoUsar+"' value='"+objeto.opciones[x].valor+"'"+selected+">"+objeto.opciones[x].label+"</label></div>";
			}
			plantilla=replaceAll(plantilla,"#opciones#",opciones);
		}
	
		if(objeto.requerido)
		{
			if(objeto.requerido.toString()=="true")	
			{
				extras+=' data-validation="number" data-validation-allowing="range[1;10000000]" data-validation-error-msg="Requerido/Required"';
			}
		}
		if(validation!="") 
			extras+="  data-validation='"+validation+"'";
		
		// es encadenado	
		if(reemplazoSeguro(objeto.cadenaURL)!="")
		{
			extras+=" cadenaurl='"+objeto.cadenaURL+"'";
			extras+=" cadenacampo='"+objeto.cadenaCampo+"_"+nivelActual.toString()+"'";
			extras+=" onchange=\"cambioSelect(this.value,$(this).attr('cadenaurl'),$(this).attr('cadenacampo'))\"";
		}
	}
	else if(tipotimeline=="segmented")
	{
		if(objeto.opciones)
		{
			var opciones="";
			for ( var x = 0; x < objeto.opciones.length; x++) 
			{
				var checked="";
				if(objeto.opciones[x].valor==objeto.valor) checked=" checked='checked'";
				opciones+="<input type='radio' id='"+objeto.campo+objeto.opciones[x].valor+"_"+nivelActual.toString()+"' name='"+objeto.campo+"_"+nivelActual.toString()+"' value='"+objeto.opciones[x].valor+"'"+checked+"><label for='"+objeto.campo+objeto.opciones[x].valor+"_"+nivelActual.toString()+"'>"+objeto.opciones[x].label+"</label>";
			}
			plantilla=replaceAll(plantilla,"#opciones#",opciones);
		}
	}
	
	plantilla=replaceAll(plantilla,"extras=\"\"",extras);
	plantilla=replaceAll(plantilla,"extras=''",extras);

	return plantilla;
}


function timelineMas()
{
	var plantilla="";
	plantilla=$("#masTimeline").html();
	
	plantilla=replaceAll(plantilla,"#creado#","real");
	
	return plantilla;
}

function procesaAccionBoton(boton,confirmado)
{
	if(boton.attr("tipoBoton"))
	{
		if(boton.attr("tipoBoton")=="accionConfirmar")
		{
			var url=boton.attr("url");
			var confirmar=boton.attr("confirmar");
			if(boton.attr("confirmar") && boton.attr("confirmar")!="" && !confirmado)
			{
				var txt;
				
				swal({
				  title: "Confirmar",
				  text: boton.attr("confirmar"),
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonColor: "#59a2ea",
				  confirmButtonText: "Si",
				  cancelButtonText: "No",
				  closeOnConfirm: true
				},
				function(){
				  procesaAccionBoton(boton,true);
				});
	
				
			}
			else
			{
				spinnerMuestra();
				url=encodeURI(url);
				$.getJSON("APIRemote/"+url, function(result){
		
					if(evaluaMensajeRespuesta(result.meta)) // todo bien
					{
						var nivelNuevo=nivelActual-1;
						var obj=$("#v_"+nivelNuevo.toString()+"_"+boton.attr("idinterno"));
						var obj2=$("#v_"+nivelActual.toString()+"_"+boton.attr("idinterno"));
						if(obj2.attr("src")=="recursos/formularios/generales/validado0.png")
						{
							obj2.attr("src","recursos/formularios/generales/validado1.png");
							obj.attr("src","recursos/formularios/generales/validado1.png");
						}
						else 
						{
							obj2.attr("src","recursos/formularios/generales/validado0.png"); 
							obj.attr("src","recursos/formularios/generales/validado0.png"); 
						}
						if(nivelActual==0)
							boton.hide();
						regresarFuncion();
					}
					
				  }).fail(function() {
					  sweetAlert("Oops...", "Ocurrió un error con la consulta", "error");
				  })
				  .always(function() {
					  spinnerOculta();
				  });	
			}
		}
		else if(boton.attr("tipoBoton")=="directo")	// es boton directo
		{
			
			cargaArchivoDirecto(boton.attr("url"),boton.html(),-1,"normal");	
		}
		
		else if(boton.attr("tipoBoton")=="coleccion")	// es boton directo
		{
			idcfoto=boton.attr("idinterno");
			cargaArchivoDirecto("imagenes.php?modo=&id="+boton.attr("idinterno")+"&operacion=&pagina=0",boton.html(),-1,"normal");	
		}
		else if(boton.attr("tipoBoton")=="guardarForm" || boton.attr("tipoBoton")=="guardarFormExtra")	// es form, vamos a validar
		{
			// hay confirmacion y no ha sido confirmado
			if(boton.attr("confirmar") && boton.attr("confirmar")!="" && !confirmado)
			{
				swal({
				  title: "Confirmar",
				  text: boton.attr("confirmar"),
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonColor: "#59a2ea",
				  confirmButtonText: "Si",
				  cancelButtonText: "No",
				  closeOnConfirm: true
				},
				function(){
				  procesaAccionBoton(boton,true);
				});
				
			}
			else
			{
				sigue=true;
				var operacionextra="";
				var values="";
				if(boton.attr("tipoBoton")=="guardarForm") // vamos a guardar
				{
					var primerError=false;
					var errors = [];
					var conf = {
					onElementValidate : function(valid, $el, $form, errorMess) {
						 if( !valid ) {
							 if(!primerError) $el.focus();
							 primerError=true;
						  	 errors.push({el: $el, error: errorMess});
						 }
						}
					};
					var lang;
					if( ! $("#formulario"+boton.attr("nivelBoton")).isValid(lang, conf, true) )
						sigue=false;
					else 
					{
						values =$('#formulario'+boton.attr("nivelBoton")).serialize();
						//limpiamos los nombres de las variables porque tenemos _nivel en todos los nombres de los campos
						values=replaceAll(values,"_"+nivelActual.toString()+"=","=");
						operacionextra="&"+reemplazoSeguro(boton.attr("operacionextra"));
					}
				}
				else if(boton.attr("tipoBoton")=="guardarFormExtra") // es una variable extra qe guardaremos sin form
					operacionextra="&"+reemplazoSeguro(boton.attr("operacionextra"));
				
				if(sigue) 
				{
					spinnerMuestra();	
					var urlTemp=$("#timeline"+boton.attr("nivelBoton")).attr("url");				
					// vamos a guadar, que nervios
					urlTemp=encodeURI(urlTemp);
					$.post("APIRemote/"+urlTemp+
					"&accion=guardar"+operacionextra, values, function(result, textStatus) {
						if(evaluaMensajeRespuesta(result.meta)) // dodo bien
						{
							window.parent.formularioGuardado=true;
							var mensaje=reemplazoSeguro(result.response.mensaje);
							
							operacionVentana=reemplazoSeguroLimpia(result.response.operacionVentana);
							operacionValor1=reemplazoSeguro(result.response.operacionValor1);
							operacionValor2=reemplazoSeguro(result.response.operacionValor2);
							var actualizarElemento=reemplazoSeguroLimpia(result.response.actualizarElemento);
							
							if(actualizarElemento!='')
							{
								var actualizarValor=reemplazoSeguro(result.response.actualizarValor);
								$('#'+actualizarElemento, window.parent.document).html(limpiaCadena(actualizarValor,"",""));
								
							}
							
							if(mensaje!='') // hay mensaje, lo mostramos
								muestraMensaje(mensaje,"bien");
							
								
							var modo="";
							if(result && result.response && result.response.diccionario) // traemos diccionario, vamos a ver que hacer
							{
								if(operacionextra=="")
								{
									var operacion=reemplazoSeguroLimpia(result.response.diccionario.operacion);
									var modo=reemplazoSeguroLimpia(result.response.diccionario.modo);
									var operacionActual=limpiaCadena(getUrlParameter(urlTemp,"operacion"),"","");
									if(operacionActual=="editar")
									{
										spinnerOculta();
										var nivelRefrescar=nivelActual-1;
										if(nivelRefrescar>=0)
											timelinesRefrescar+=","+nivelRefrescar.toString();
										spinnerOculta();
										regresarFuncion();
									}
									else
									{
										var nivelRefrescar=nivelActual-1;
										if(nivelRefrescar>=0)
											timelinesRefrescar+=","+nivelRefrescar.toString();
										if(modo!="refrescar")
										{
											var url=reemplazoSeguroLimpia(result.response.diccionario.archivo)+".php?modo="+modo+"&id="+reemplazoSeguroLimpia(result.response.diccionario.id)+"&operacion="+operacion+"&";
											cargaArchivoDirecto(url,reemplazoSeguro(result.response.diccionario.texto),nivelActual,"normal")
										}
										else
										{
											spinnerOculta();
											regresarFuncion();
										}
									}
								}
								else
								{
									if(modo=="refrescar")
									{
										var url=reemplazoSeguroLimpia(result.response.diccionario.archivo)+".php?modo="+modo+"&id="+reemplazoSeguroLimpia(result.response.diccionario.id)+"&operacion="+operacion+"&";
										cargaArchivoDirecto(url,reemplazoSeguro(result.response.diccionario.texto),nivelActual,"normal")
									}
									else
									{
										var nivelRefrescar=nivelActual-1;
										if(nivelRefrescar>=0)
											timelinesRefrescar+=","+nivelRefrescar.toString();
										regresarFuncion();	
									}
								}
					
							}
							else 
							{
								
								var n = urlTemp.indexOf("formularioFoto"); 
								if(n>-1) // si es de foto
								{
									idImagen=limpiaCadena(getUrlParameter(urlTemp,"id"));
									
									if($("#activo_"+nivelActual+" :radio:checked").val()==1)
										$("#inactivo_"+idImagen).hide();
									else
										$("#inactivo_"+idImagen).show();
								}
								
								spinnerOculta();
								regresarFuncion(); // regreso normal
							}							
						}	
						else // hubo error, ocultamos el spinner
							spinnerOculta();				
					}).fail(function() {
						spinnerOculta();
						sweetAlert("Oops...", "Ocurrió un error con la consulta", "error");
					})
					.always(function() {
						
					});
				}
			}
		}
	}
}

function getUrlParameter(url,sParam) {
    var sPageURL = url,
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

function regresarFuncion()
{
	if(nivelActual>0)
	{
		var nivelAnterior=nivelActual-1;
		var nivelRemover=nivelActual;
		$("#timeline"+nivelRemover.toString()).css("display", 'none');
		$("span.ui-dialog-title").text($("#timeline"+nivelAnterior.toString()).attr("titulo")); 
			$( "#timeline"+nivelRemover.toString() ).remove(); 
		$("#timeline"+nivelAnterior.toString()).css("display", 'block');
		/*
		$("#timeline"+nivelRemover.toString()).hide("slide", { direction: 'right' }, function() 
		{ 
			$("span.ui-dialog-title").text($("#timeline"+nivelAnterior.toString()).attr("titulo")); 
			$( "#timeline"+nivelRemover.toString() ).remove(); 
			
		});
		$("#timeline"+nivelAnterior.toString()).show("slide", { direction: 'left' });
		*/
		nivelActual=nivelActual-1;
		
		// tendremos que refrescar
		if(timelinesRefrescar.indexOf(nivelActual.toString())>-1) // vemos si el nivel esta en la cadena
		{
			cargaArchivoDirecto($("#timeline"+nivelActual).attr("url"),$("#timeline"+nivelActual).attr("titulo"),nivelActual,"normal");
			timelinesRefrescar=replaceAll(timelinesRefrescar,","+nivelActual.toString(),"");
		}
	}
}


function spinnerGenera()
{
	var opts = {
	  lines: 13 // The number of lines to draw
	, length: 14 // The length of each line
	, width: 14 // The line thickness
	, radius: 5 // The radius of the inner circle
	, scale: 1 // Scales overall size of the spinner
	, corners: 1 // Corner roundness (0..1)
	, color: '#333' // #rgb or #rrggbb or array of colors
	, opacity: 0.25 // Opacity of the lines
	, rotate: 0 // The rotation offset
	, direction: 1 // 1: clockwise, -1: counterclockwise
	, speed: 1 // Rounds per second
	, trail: 60 // Afterglow percentage
	, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
	, zIndex: 2e9 // The z-index (defaults to 2000000000)
	, className: 'spinner' // The CSS class to assign to the spinner
	, top: '50%' // Top position relative to parent
	, left: '50%' // Left position relative to parent
	, shadow: false // Whether to render a shadow
	, hwaccel: false // Whether to use hardware acceleration
	, position: 'fixed' // Element positioning
	}
	spinner = new Spinner(opts).spin(document.getElementById('timeline'));
	spinner.stop();
}

function spinnerMuestra()
{
	spinner.spin(document.getElementById('timeline'));
	document.getElementById('timeline').style.pointerEvents = 'none';
}

function spinnerOculta()
{
	spinner.stop();	 
	document.getElementById('timeline').style.pointerEvents = 'auto';
}

function evaluaMensajeRespuesta(meta)
{
	var devolver=false;
	var mensaje="";
	if(meta)
		mensaje=reemplazoSeguro(meta.mensaje);
	if(mensaje=="")
		devolver = true;
	else
	{
		muestraMensaje(mensaje,"mal");
		devolver=false;	
	}
	return devolver;
}

function muestraMensaje(mensaje,modo)
{
	if(modo=="mal")
	{
		swal({
		  title: "Error",
		  text: mensaje,
		  type: "error",
		  showConfirmButton: true
		});
	}
	else
	{
		if(operacionVentana!="")
		{
			swal({
			  title: "Aviso",
			  text: mensaje,
			  timer: 2000,
			  type: "success",
			  showConfirmButton: false
			},
			function(){
			  parent.operacionVentanaFormulario(operacionVentana,operacionValor1,operacionValor2);
			});
		}
		else
		{
			swal({
			  title: "Aviso",
			  text: mensaje,
			  timer: 2000,
			  type: "success",
			  showConfirmButton: false
			});
		}
		
		
		
		
	}
}



function cargaArchivoDirecto(url,titulo,divCargar,modo)
{
	var permitidos = ["formularioComentario","formularioContacto","formularioCret","formularioRep","formularioRet","formularioUsuario","subirfotohtml","imagenes"];
	var partesURL = url.split(".php");	
	var sigue=true;
	if(partesURL.length>0)
	{
		var esta = permitidos.indexOf(partesURL[0]); 
		if(esta==-1) 
			sigue=false;
	}
	else sigue=false;
	if(!sigue)
	{
		alert("NO DISPONIBLE");
		return 0;
	}
	wWidth = $(window).width()*0.8;
	wHeight = $(window).height()*0.9;
	// recarga el contenido de un nivel
	//cargaArchivoDirecto($("#timeline"+nivelActual).attr("url"),$("#timeline"+nivelActual).attr("titulo"),0)

	var nivelCargar;
	if(divCargar==-1) // cargaremos un div nuevo
	{
		
		nivelCargar=nivelActual+1;
	}
	else // recargaremos un div especifico
	{
		nivelCargar=divCargar;
	}
	
	var display="none";
	if(nivelCargar==0)
	{
		wWidth = $(window).width()*0.8;
		wHeight = $(window).height()*0.9;
		if(wWidth>1024) wWidth=1024;
		display="block";
		var myIcon="";
		if($(window).width()>640 && 1==2)
		{
			movilVersion=false;
			$(function() {
			$( "#timeline" ).dialog({
					width: wWidth,
					height: wHeight,
					autosize:false,
					resizable: false,
					modal: true,
					open: function(event, ui) {
						$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
						$(this).parent().children(".ui-dialog-titlebar").append(myIcon);
					},
					beforeClose: function(){
					 return false;
				   }});
			  });
		}
		else 
		{
			$("#movilSalir").hide();
			$("#movilHome").hide();
			movilVersion=false;
		}
		  
	}

	spinnerMuestra();
	url=encodeURI(url);
	$.getJSON("APIRemote/"+url, function(result){
			if(evaluaMensajeRespuesta(result.meta)) // todo bien
			{
				
				if(divCargar==-1)
				{
					nivelActual++;
					var alturaTimeline=$("#timeline").height();
					$("#timeline").append('<div id="timeline'+nivelCargar.toString()+'" name="timeline'+nivelCargar.toString()+'" class="timeline" style="display:'+display+'" titulo="'+titulo+'" url="'+url+'" pagina="1"><div id="timelineInterno'+nivelCargar.toString()+'" name="timelineInterno'+nivelCargar.toString()+'" class="timelineInterno"></div></div>');
				}
				else // estamos recargando, entonces pues pongamos el titulo
				{
					$("#timeline"+nivelCargar.toString()).attr("url",url);
					$("#timeline"+nivelCargar.toString()).attr("titulo",titulo);
				}
				if(result.response && !result.response.fotos) //  && result.response.timeline
				{
					var formulario=true;
					if(url.indexOf("reporte") > -1) formulario = false;
					pintaTimeline(nivelCargar,result,true,formulario,modo);
				}
				else if(result.response && result.response.fotos)
					pintaFotos(nivelCargar,result);

				if(divCargar==-1)
				{
					if(nivelActual>0)
					{
					  	var nivelAnterior=nivelActual-1;
						/*$("#timeline"+nivelAnterior.toString()).hide("slide", { direction: 'left' });
						$("#timeline"+nivelCargar.toString()).show("slide", { direction: 'right' });
						*/
						$("#timeline"+nivelAnterior.toString()).css("display", 'none');
						$("#timeline"+nivelCargar.toString()).css("display", 'block');
						
					}
				}
				$("span.ui-dialog-title").text(titulo); 
			}
          }).fail(function() {
			  sweetAlert("Oops...", "Ocurrió un error con la consulta", "error");
		  })
		  .always(function() {
			  spinnerOculta();
		  });
}



function timelineTextoPeque(objeto)
{
	var plantilla="";
	plantilla=$("#textoPequeTimeline").html();
	plantilla=replaceAll(plantilla,"#texto#",reemplazoSeguro(objeto.texto));
	return plantilla;
}

function timelineTexto(objeto)
{
	var plantilla="";
	plantilla=$("#textoTimeline").html();
	plantilla=replaceAll(plantilla,"#texto#",reemplazoSeguro(objeto.texto));
	return plantilla;
}
function pintaTimeline(nivelCargar,result,nuevo,formulario,modo)
{
	var htmlCompleto="";
	if(nuevo)
	{
		$("#timelineInterno"+nivelCargar.toString()).html("");
		if(nivelActual>0)
			htmlCompleto+=timelineRegresar();
	}
	
	if(result.response.timeline)
	{
		for ( var x = 0; x < result.response.timeline.length; x++) 
		{
			var tipotimeline=result.response.timeline[x].tipotimeline;
			if(tipotimeline=="titulo")
				htmlCompleto+=timelineTitulo(result.response.timeline[x]);
			else if(tipotimeline=="textfield" || tipotimeline=="memo" || tipotimeline=="fecha" || tipotimeline=="fechaRango" || tipotimeline=="imagef")
				htmlCompleto+=timelineTextfieldMemo(result.response.timeline[x],tipotimeline);	
			else if(tipotimeline=="segmented" || tipotimeline=="picker" || tipotimeline=="radio")
				htmlCompleto+=timelineSelector(result.response.timeline[x],tipotimeline);
			else if(tipotimeline=="color")
				htmlCompleto+=timelineColor(result.response.timeline[x],tipotimeline);	
			else if(tipotimeline=="subtitulo")
				htmlCompleto+=timelineSubtitulo(result.response.timeline[x],tipotimeline);
			else if(tipotimeline=="generalSeparador")
				htmlCompleto+=timelineSeparador(result.response.timeline[x].altura);	
			else if(tipotimeline=="boton")
				htmlCompleto+=timelineBoton(result.response.timeline[x],x);
			else if(tipotimeline=="subirFoto")
				htmlCompleto+=timelineSubirFoto(result.response.timeline[x]);
			else if(tipotimeline=="textoPeque")
				htmlCompleto+=timelineTextoPeque(result.response.timeline[x]);
			else if(tipotimeline=="texto")
				htmlCompleto+=timelineTexto(result.response.timeline[x]);	
			else if(tipotimeline=="html")
				htmlCompleto+=result.response.timeline[x].html;
			else if(tipotimeline=="break")
				htmlCompleto+="<br clear='all'>";
			else if(tipotimeline=="toks")
				htmlCompleto+=timelineToks(result.response.timeline[x],tipotimeline);	
		}
	}
	
	if(modo=="reporte" && result.response.timeline)
		if(result.response.timeline.length>0)
			htmlCompleto+=timelineMas();
		
	if(nuevo && formulario)
		htmlCompleto="<form id='formulario"+nivelCargar.toString()+"' name='formulario"+nivelCargar.toString()+"'>"+htmlCompleto+"</form>";
	
	$("#timelineInterno"+nivelCargar.toString()).append(htmlCompleto);
	
	if(nuevo && formulario)
	{
	  $.validate({
		form : '#formulario'+nivelCargar.toString(),
		lang: idiomaMensajes,
		modules : 'location, date, security, file'
	  });
	}
	$( document ).tooltip();
	  
	if(result.response.timeline)
	{
	  // generaremos todas las fechas, segments y selectmenus jquery
	  for ( var x = 0; x < result.response.timeline.length; x++) 
	  {
		  var tipotimeline=result.response.timeline[x].tipotimeline;
		  if(tipotimeline=="fecha" || tipotimeline=="fechaRango")
		  {
			  $(function() {
				  var minimo="1900-01-01";
				  var maximo="3000-01-01";
				  if(result.response.timeline[x].minimo)
					if(result.response.timeline[x].minimo.toString()!="") 
						minimo=result.response.timeline[x].minimo.toString();
				  if(result.response.timeline[x].maximo)
					if(result.response.timeline[x].maximo.toString()!="") 
						maximo=result.response.timeline[x].maximo.toString();
				 if(tipotimeline=="fecha")					
					 $( "#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()).datepicker({"dateFormat":"yy-mm-dd", changeMonth: true,changeYear: true,minDate:minimo,maxDate:maximo});
				 else
				 {
					 $( "#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()+"_1").datepicker({"dateFormat":"yy-mm-dd", changeMonth: true,changeYear: true,minDate:minimo,maxDate:maximo});
					 $( "#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()+"_2").datepicker({"dateFormat":"yy-mm-dd", changeMonth: true,changeYear: true,minDate:minimo,maxDate:maximo});
				 }

			  });
		  }
		  else if(tipotimeline=="segmented")
		  {
			$(function() { $( "#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()).buttonset(); });
			$("#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()+' input[type=radio]').change(function() {
				condicionalesSegmentos($("#"+this.name).attr("idinterno"),this.value);
			});
			// ponemos valor predeterminado
			condicionalesSegmentos($("#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()).attr("idinterno"),$("#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()).attr("valor"));
		  }
		 
		  else if(tipotimeline=="boton")
		  {
			$("#boton"+x.toString()+"_"+nivelCargar.toString()).click(function() {  procesaAccionBoton($(this),false); });
		  }
		  else if(tipotimeline=="color")
		  {
			   $("#"+result.response.timeline[x].campo+"_"+nivelCargar.toString()).colorpicker({colorFormat :'#HEX'});
		  }		 
	  }
	}
}

function editarImagen(idreal)
{
	cargaArchivoDirecto("formularioFoto.php?modo=&id="+idreal+"&operacion=editar","Editar imagen","-1","normal");
}

function cambiarImagen(campo)
{
	campofoto=campo;
	// mandamos 0 para indicar que es web y que traiga todas las imagenes
	idcfoto=$("#"+campo).attr('cfoto');
	cargaArchivoDirecto("imagenes.php?modo=&id="+idcfoto+"&operacion=&pagina=0","Imágenes","-1","normal");
}

function refrescaImagenes(idcfotoNuevo)
{
	idcfoto=idcfotoNuevo;
	cargaArchivoDirecto("imagenes.php?modo=&id="+idcfotoNuevo+"&operacion=&pagina=0","Imágenes",nivelActual,"normal");
}

function actualizaFoto(archivo)
{
	$("#"+campofoto).val(archivo);
	$("#"+campofoto+"_i").attr("src","recursos/"+archivo);
	regresarFuncion();
}

function arreglaImagen(imagen,letra) 
{
    var charpos = imagen.lastIndexOf("/");
    ptone = imagen.substring(0,charpos);
	pttwo = imagen.substring(charpos+1);
	var final = ptone + "/stock/"+pttwo;
	
    final=final.replace(".jpg","_"+letra+".jpg");
	final=final.replace(".JPG","_"+letra+".JPG");
	final=final.replace(".png","_"+letra+".png");
	final=final.replace(".PNG","_"+letra+".PNG");
    return final;
}

function pintaFotos(nivelCargar,result)
{
	$("#timelineInterno"+nivelCargar.toString()).html("");
	var htmlCompleto="";
	var htmlCompletoRegresar="";
	if(nivelActual>0)
		htmlCompletoRegresar+=timelineRegresar();
	
	if(result.response && result.response.fotos)
	{	
		for ( var x = 0; x < result.response.fotos.length; x++) 
		{
			var archivofoto=result.response.fotos[x].archivofoto;
			var archivofotoasignar=archivofoto;
			archivofoto=arreglaImagen(archivofoto,"C");
			var idreal=result.response.fotos[x].idreal;
			var activo=result.response.fotos[x].activo;
			var plantilla=$("#imagenTimeline").html();
			plantilla=replaceAll(plantilla,"#archivofoto#",archivofoto);
			plantilla=replaceAll(plantilla,"#archivofotoasignar#",archivofotoasignar);
			plantilla=replaceAll(plantilla,"#idreal#",idreal);
			var display="none";
			if(activo=="0") display="block";
			plantilla=replaceAll(plantilla,"#display#",display);
			htmlCompleto+=plantilla;
		}
	}
	if(result.response && result.response.cfotos)
	{
		var plantillaC=$("#cfotosTimeline").html();
		plantillaC=replaceAll(plantillaC,"#nivel#","");
		var opciones;
		for ( var x = 0; x < result.response.cfotos.length; x++) 
		{
			var selected="";
			if(result.response.cfotos[x].idreal==idcfoto) selected=" selected";
			opciones+="<option value='"+result.response.cfotos[x].idreal+"'"+selected+">"+result.response.cfotos[x].nombrecfoto+"</option>";
		}
		plantillaC=replaceAll(plantillaC,"#opciones#",opciones);
		htmlCompleto=htmlCompletoRegresar+plantillaC+htmlCompleto;
	}
	$("#timelineInterno"+nivelCargar.toString()).append(htmlCompleto);						
}

function condicionalesSegmentos(cual,valor)
{
	if(cual == "periodo")
	{
		$("#t_fecha_"+nivelActual.toString()).hide();
		$("#t_fechaRango_"+nivelActual.toString()).hide();
		$("#t_ano_"+nivelActual.toString()).hide();
		$("#t_mes_"+nivelActual.toString()).hide();
		if(valor=="0") $("#t_fecha_"+nivelActual.toString()).show();
		else if(valor=="4") $("#t_fechaRango_"+nivelActual.toString()).show();
		else if(valor=="2") $("#t_ano_"+nivelActual.toString()).show();
		else if(valor=="1") $("#t_mes_"+nivelActual.toString()).show();
	}
					
}

function subirTimelineMostrar()
{
	if($("#cfotos").val()!=-1 && $("#cfotos").val()!=0)
		cargaArchivoDirecto("subirfotohtml.php?tablafoto="+$("#"+campofoto).attr('tablafoto')+"&idregistrofoto="+$("#"+campofoto).attr('idregistrofoto')+"&cfoto="+$("#cfotos").val(),"Subir imagen","-1","normal"); // $("#"+campofoto).attr('cfoto')
	else
		sweetAlert("Aviso...", "No puedes subir imágenes en esta categoría. Cambia de categoría e intenta otra vez.", "warning");
}

function timelineSubirFoto(objeto)
{
	var ancho=wWidth*.98;
	var alto=3*ancho/4;
	if(alto>wHeight-120) // está muy grande, vamos a reducirlo
	{
		alto=wHeight-120;
		ancho=alto*4/3;
	}
	var plantilla=$("#subirFotoTimeline").html();
	plantilla=replaceAll(plantilla,"#tablafoto#",reemplazoSeguroLimpia(objeto.tablafoto));
	plantilla=replaceAll(plantilla,"#idregistrofoto#",reemplazoSeguroLimpia(objeto.idregistrofoto));
	plantilla=replaceAll(plantilla,"#cfoto#",reemplazoSeguroLimpia(objeto.cfoto));
	plantilla=replaceAll(plantilla,"#ancho#",ancho.toString());
	plantilla=replaceAll(plantilla,"#alto#",alto.toString());
	return plantilla;
}

function regresarSubirFoto(objeto)
{
	
	regresarFuncion();
	var archivofoto=objeto.archivofoto;
	var archivofotoasignar=archivofoto;
	archivofoto=arreglaImagen(archivofoto,"C");
	var idreal=objeto.idreal;
	var activo=objeto.activo;
	var plantilla=$("#imagenTimeline").html();
	plantilla=replaceAll(plantilla,"#archivofoto#",archivofoto);
	plantilla=replaceAll(plantilla,"#archivofotoasignar#",archivofotoasignar);
	plantilla=replaceAll(plantilla,"#idreal#",idreal);
	var display="none";
	if(activo=="0") display="block";
	plantilla=replaceAll(plantilla,"#display#",display);
	
	$(".t_cfotos").after(plantilla);
	

}
