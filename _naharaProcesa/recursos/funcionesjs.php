<SCRIPT LANGUAGE="JavaScript">

ie4 = ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4 ));
document.oncontextmenu=new Function("alert(message);return false")

function deleteRecord(LINK2)
{
  if ( confirm("¿ESTAS SEGURO DE QUE DESEAS BORRAR ESTE REGISTRO?") )
  {
    document.location.href = LINK2;
  }
}

function confirmacionoperacion(LINK2,mensaje,ventana)
{

   if ( confirm(mensaje) )
  {
    if(ventana!=1)
      document.location.href = LINK2;
	else
	  tempo=window.open(LINK2,"temporal","screenX=20,screenY=20,height=350,width=450,hotkeys=no,directories=no,menubar=no,location=no,personalbar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no");;

  }

}



function muestraayuda( texto)
{
  alert(texto);
}

//-----nueva funcion para seleccionar imagenes----------
//-----la funcion original aparece comentada debajo-----
//-----14/04/2014---------------------------------------

function seleccionaimagen(objeto) {
	cadena=window.document.form1.elements[objeto].value;
	subdir=cadena;
	var encontrado=0;
	var encontrado2=0;
	while(encontrado!=-1)
	{
		encontrado=cadena.lastIndexOf("/");
		if(encontrado!=-1)
		{
			cadena=cadena.substr(encontrado+1,1000);
			encontrado2=encontrado;
		}
	}
	subdir=subdir.substr(0,encontrado2);
	if(subdir!='') subdir='subdir='+subdir;
	else subdir='';
	//alert('include/filetree/mostrarimagenes.php?'+subdir)

	//abrir la ventana
	window.open('include/filetree/mostrarimagenes.php?'+subdir+'&objeto='+objeto, 'Seleccionar','screenX=20,screenY=20,height=550,width=550,hotkeys=no,directories=no,menubar=no,location=no,personalbar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,toolbar=no');
}

/*function seleccionaimagen(objeto)
{
  cadena=window.document.form1.elements[objeto].value;
  subdir=cadena;
  var encontrado=0;
  var encontrado2=0;
  while(encontrado!=-1)
  {
  	encontrado=cadena.lastIndexOf("/");
	if(encontrado!=-1)
	{
		cadena=cadena.substr(encontrado+1,1000);
		encontrado2=encontrado;
	}
  }
  subdir=subdir.substr(0,encontrado2);
  if(subdir!='') subdir='&subdir='+subdir+'&';
  else subdir='';
  window.open("manejadorarchivos.php?modo_archivo=todos&origen=imagen&"+subdir+"&campo="+objeto+"&",'Seleccionar','screenX=20,screenY=20,height=550,width=550,hotkeys=no,directories=no,menubar=no,location=no,personalbar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,toolbar=no');
}*/

function limpiarimagen(objeto){
   window.document.form1.elements[objeto].value="";

}

function editarmf(campo,tabla,id,camporeal,tablareal,numerotabla){
  tempo=window.open("manejadoreditor.php?nombrecampo="+campo+"&nombretabla="+tabla+"&tablaseguimiento="+numerotabla+"&id="+id+"&step=1&nombrecamporeal="+camporeal+"&nombretablareal="+tablareal,"ventanaeditor","screenX=20,screenY=20,height=650,width=850,hotkeys=no,directories=no,menubar=no,location=no,personalbar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no");
}

function editarmb(campo,tabla,id,camporeal,tablareal,numerotabla){
  tempo=window.open("manejadoreditorbbcode.php?nombrecampo="+campo+"&nombretabla="+tabla+"&tablaseguimiento="+numerotabla+"&id="+id+"&step=1&nombrecamporeal="+camporeal+"&nombretablareal="+tablareal,"ventanaeditor","screenX=20,screenY=20,height=550,width=750,hotkeys=no,directories=no,menubar=no,location=no,personalbar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no");
}
function seleccionafecha(objeto){
  tempo=window.showModalDialog("manejadorfecha.php?fecha="+window.document.form1.elements[objeto].value,'','dialogHeight:100px;dialogWidth:400px');
  if(tempo!=undefined && tempo!="vacio")
  {
    window.document.form1.elements[objeto].value=tempo;
  }
}

function muestraimagen(objeto){
  window.showModalDialog("muestraimagen.php?imagen="+window.document.form1.elements[objeto].value)
}




function open_window(target_html_page)
{
  window.open(target_html_page, "tempo");
  return(false);
}

function open_window_foto()
{
  windowReference = window.open('fotos/fotografia.php','tempo','screenX=20,screenY=20,height=540,width=360,hotkeys=no,directories=no,menubar=no,location=no,personalbar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no');
  if (!windowReference.opener)
  	windowReference.opener = self;
  //return 0;
}


//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com



if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

function BusquedaNormal(fuente)
{
	document.form2.action = fuente;
	document.form2.target = "_self";	// Open in a new window
	document.form2.submit();			// Submit the page
	return true;
}

function BusquedaExcel(fuente)
{
	document.form2.action = fuente;
	document.form2.target = "_self";	// Open in a new window
	document.form2.submit();			// Submit the page
	return true;
}

function BusquedaMM(fuente)
{
	document.form2.action = fuente;
	document.form2.target = "_blank";	// Open in a new window
	document.form2.submit();			// Submit the page
	return true;
}

function toggle(myId){
   if (ie4){
      thisId=document.all(myId);
      if (thisId.style.display == "none"){
         thisId.style.display = "";
         }
      else {
         thisId.style.display = "none";
         thisId.style.zindex = "1";
      }
   }
}




function actualizaemail(destino,dato,origen)
{
   tempo=document.form1[destino].value;
   if(dato!='0')
   {
     if(tempo=='')
	 {
       document.form1[origen].value='0';
	 }
     else
     {
       pedazos=tempo.split('@');
       document.form1[destino].value=pedazos[0]+'@'+dato;
     }
   }
   else
   {
     pedazos=tempo.split('@');
     document.form1[destino].value=pedazos[0];
   }
}

function revisarextension(texto,archivo)
{
  if(texto==null) texto='';
  if(archivo==1) tipomedioreal=form1.tipomedio.value;
  else if(archivo==2) tipomedioreal=form2.tipomedio.value;

  if(tipomedioreal==0 && (texto.indexOf(".flv") == -1 || texto=='') )
  {
    alert('La extensión del VIDEO que deseas registrar debe ser flv');
    return 0;
  }
  else if(tipomedioreal==1 && (texto.indexOf(".mp3") == -1 || texto=='') )
  {
    alert('La extensión del AUDIO que deseas registrar debe ser mp3');
    return 0;
  }
  else if(tipomedioreal==2 && (texto.indexOf(".swf") == -1 || texto=='') )
  {
    alert('La extensión del FLASH MOVIE que deseas registrar debe ser swf');
    return 0;
  }
  else if(tipomedioreal==3 && texto!='')
  {
    alert('Para registrar una GALERIA no debes proporcionar el nombre del archivo');
    return 0;
  }
  else if(tipomedioreal==4 && (texto.indexOf(".jpg") == -1 || texto=='') )
  {
    alert('La extensión de la FOTO VIRTUAL que deseas registrar debe ser jpg');
    return 0;
  }
  else return 1;
}

function revisarjpg(texto)
{
  if(texto==null) texto='';

  if(texto.indexOf(".jpg") == -1 || texto=='' )
  {
    alert('La extensión de la IMAGEN que deseas registrar debe ser jpg');
    return 0;
  }
  else return 1;
}

function revisarpdf(texto)
{
  if(texto==null) texto='';

  if(texto.indexOf(".pdf") == -1 || texto=='' )
  {
    alert('La extensión del documento que deseas registrar debe ser pdf');
    return 0;
  }
  else return 1;
}

// V3
function revisarintranet(texto)
{
  if(texto==null) texto='';

  if(texto.indexOf("intranet/") !=0 && texto!='' )
  {
    alert('El archivo proporcionado debe estar en la carpeta intranet');
    return 0;
  }
  else return 1;
}

function revisarpdf(texto)
{
  if(texto==null) texto='';

  if(texto.indexOf(".pdf") == -1 && texto!='' )
  {
    alert('La extensión del documento que deseas registrar debe ser pdf');
    return 0;
  }
  else return 1;
}

function revisardoc(texto)
{

  if(texto==null) texto='';
 if(texto.indexOf(".doc") == -1 && texto!='' )

  {
    alert('La extensión  que deseas registrar debe ser DOC');
    return 0;
  }
  else return 1;
}

// V3
function revisainput(compara,fuente)
{

  temporal=form2[fuente].value;
  if(temporal!='')
  {
   	if(temporal.indexOf('%')==-1)
	{
		if(form2[compara].selectedIndex==0)
			form2[compara].selectedIndex=1;
	}
	else
		form2[compara].selectedIndex=3;

  }
}
function revisarimagen(texto)
{
  if(texto==null) texto='';

  if( (texto.indexOf(".jpg")  == -1 && texto.indexOf(".pbg")  == -1 && texto.indexOf(".gif")  == -1 && texto.indexOf(".JPG")  == -1 && texto.indexOf(".GIF")  == -1 && texto.indexOf(".PNG")  == -1) && texto!='' )
  {
    alert('La extensión de la IMAGEN que deseas registrar debe ser jpg');
    return 0;
  }
  else return 1;
}

function revisartelefono(texto)
{
 var phone2 =/\((\d{3}|\d{2}|\d{1})\)(\d{3}|\d{4})-\d{4}/;

 if(texto==null) texto='';

 if(texto!='')
 {
  if (texto.match(phone2)) {
   		return 1;
 	} else {
 		return 0;
 	}
 }
 else return 1;
}

function isInteger(s) {
  return (s.toString().search(/^-?[0-9]+$/) == 0);
}


function IsReal(YourNumber)
{
var Template = /^(([+|-]?d+(.d*)?)|([+|-]?(d*.)?d+))$/ //Formato de numero real congno
return (Template.test(YourNumber)) ? 1 : 0 //Compara "YourNumber" con el formato "Template" y si coincidevuelve verdadero si no devuelve falso
}


// V4 DEL GENERADOR
var boton_peque_seleccionado=0;
function carga_sub_bajo(url,cual)
{
	var fr = document.getElementById ("frame_bajo_tabla"+cual);
	fr.style.display="block";

	var fr = document.getElementById ("frame_bajo"+cual);
	fr.style.display="block";

	var fr = document.getElementById ("celdina"+cual);
	fr.style.display="block";

	frames['frame_bajo'+cual].location.href=url;
}
function carga_sub(url,altura,boton,titulo)
{
	if(boton==0)
	{
		var fr = document.getElementById ("formulario");
		fr.style.display="block";

		var fr = document.getElementById ("frame_bajo_tabla");
		fr.style.display="none";

		var fr = document.getElementById ("frame_bajo");
		fr.style.display="none";

		frames['frame_bajo'].location.href='include/imenu_peque_espere.html';
	}
	else
	{
		if (document.getElementById("formulario") != null)
		{
			var fr1 = document.getElementById ("formulario");
			fr1.style.display="none";
		}

		if (document.getElementById("frame_bajo_tabla") != null)
		{
			var fr = document.getElementById ("frame_bajo_tabla");
			fr.style.display="block";
		}
		var fr = document.getElementById ("frame_bajo");
		fr.style.display="block";

		frames['frame_bajo'].location.href=url;
	}

	if(boton_peque_seleccionado!=-1)
	{
		var fr = document.getElementById ("boton_peque_"+boton_peque_seleccionado);
		fr.className="boton_peque_normal";
	}

	boton_peque_seleccionado=boton;
	var fr = document.getElementById ("boton_peque_"+boton);
	fr.className="boton_peque_seleccionado";
}

// cosas del mouse V4
function encuentraPosicion(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curleft,curtop];
}


// RUTINAS PARA SOLO NUMEROS V4
function s_n(modo,objeto)
{
	var key=window.event.keyCode;

	tempo='mal';
	if(key!=13 && key!=27)
	{
		if(modo=='float')
		{
			if ((key >= 48 && key <= 57) || key==45 || key==46)
				tempo='';
			else
				window.event.keyCode=0;
		}
		else if(modo=='int')
		{
			if ((key >= 48 && key <= 57) || key==45)
				tempo='';
			else
				window.event.keyCode=0;
		}
	}
}

function valida_sinpesos(valor)// valida sin signo de pesos y comas
{
	var cadena=valor;
	cadena=cadena.replace("$", "");
	cadena=cadena.replace("%", "");
	cadena=cadena.replace(/,/gi, "");
	if(isNaN(cadena)) return 0;
	else return 1;
}

function quita_pesos(objeto)// quita pesos on focus
{
	var Numero=document.getElementById(objeto).value;
	document.getElementById(objeto).value=unformatNumber(Numero);
	document.getElementById(objeto).select();
}

function unformatNumber(num) {
   return num.replace(/([^0-9\.\-])/g,'')*1;
}

function pone_pesos(objeto,modo) // pone los pesos on blur
{
	var Numero=document.getElementById(objeto).value;
	if(Numero!='' && !isNaN(Numero))
	{
		Numero=parseFloat(Numero);

		if(modo=='dinero') valor=formatNumber(Numero.toFixed(2),'$');
		else if(modo=='porcentaje') valor=formatNumber(Numero.toFixed(2),'')+'%';
		else valor=formatNumber(Numero,'');
		document.getElementById(objeto).value=valor;
	}
	else document.getElementById(objeto).value='';
}

function formatNumber(num,prefix)
{
   prefix = prefix || '';
   num += '';
   var splitStr = num.split('.');
   var splitLeft = splitStr[0];
   var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '';
   var regx = /(\d+)(\d{3})/;
   while (regx.test(splitLeft)) {
      splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
   }
   return prefix + splitLeft + splitRight;
}
function regresa_imagen(control,cadena)
{
	if(control=='SUBIR')
	{

		window.location='<?=$url_admin?>subir.php?carpeta_subir='+cadena+'&url_origen='+escape(window.location.href);
	}
	else
		window.document.form1.elements[control].value=cadena;
}
function muestraSubmenuTop(id) {
	document.getElementById("submenu_"+id).style.display='block';
}

function ocultaSubmenuTop(id) {
	document.getElementById("submenu_"+id).style.display='none';
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
.ui-dialog{font-size:10px;}
iframe{border:none;}
</style>

<script>


$(document).ready(function(){
	$(document).on("click", ".openMap", function(){
		$("#carga_mapa").remove();
		var coordenadas = $(this).closest("td").find("input").val();

		$('<div id="carga_mapa"><iframe src="../include/map.php?coordenadas='+coordenadas+'" height="370px" width="650px" id="map"></iframe></div>').appendTo("body");
		var obj = this;
		$("#carga_mapa").dialog({
			title: "Buscar",
			width: 680,
			heigth: 300,
			modal:true,
			buttons:{
				"OK":{
					text:'Obtener Coordenadas',
					click: function(){
						var p = String($("#map").get(0).contentWindow.coordenadas());
						$(obj).closest("td").find("input").val(p);
						$("#map").remove();
						$(this).dialog("destroy");
					}
				},
				"Cancelar":{
					text:'Cancelar',
					click: function(){
						$("#map").remove();
						$(this).dialog("destroy");
					}
				}
			}
		});
	});

	if($("#geoest").length > 0)
		$("#geoest").parent().append('<img src="recursos/map.png" class="openMap" style="cursor: pointer;" />');

	if($("#icatjue").length > 0){
		$("#icatjue").change(function(){
			var cid = $(this).val();

			var team1 = $("#iequ1jue").val();
			var team2 = $("#iequ2jue").val();

			$("#iequ1jue").html('');
			$("#iequ2jue").html('');
			$.ajax({
				url: "include/seleccionarEquiposCategoria.php",
				contentType: "application/x-www-form-urlencoded",
				dataType: "json",
				async: false,
				data: {"step": "listTeamsFromCategory", "cid": cid},
				type: "GET",
				statusCode: {
					400: function(){
						alert("Bad request");
					},
					401: function(){
						alert("Unauthorized");
					}
				},
				success: function(data){
					if(data.response.length < 1){
						$("#iequ1jue").append('<option value="0">Sin resultados...</option>');
						$("#iequ2jue").append('<option value="0">Sin resultados...</option>');
					}else{
						$("#iequ1jue").append('<option value="0">Seleccione...</option>');
						$("#iequ2jue").append('<option value="0">Seleccione...</option>');
						$.each(data.response, function(index, val){
							$("#iequ1jue").append('<option value="' + val.tid + '">' + val.name + '</option>');
							$("#iequ2jue").append('<option value="' + val.tid + '">' + val.name + '</option>');
						});
						$("#iequ1jue").val(team1);
						$("#iequ2jue").val(team2);
					}
				}
			});
		});

		var team1 = $("#iequ1jue").val();
		var team2 = $("#iequ2jue").val();

		$("#iequ1jue").html('');
		$("#iequ2jue").html('');

		$("#icatjue").change();
	}

	/*if($("#statusvalidacionjug").length > 0 && $("#statusvalidacionjug").val() == '1'){
		$("#statusvalidacionjug").parent().append('<img src="recursos/email.png" class="sendEmailToValidatedPlayer" style="cursor: pointer; width: 24px;" />');

    	var sPageURL = window.location.search.substring(1);
    	var sURLVariables = sPageURL.split('&');
    	var uid = 0;
    	for(var i = 0; i < sURLVariables.length; i++){
        	var sParameterName = sURLVariables[i].split('=');
        	if(sParameterName[0] == 'id') uid = sParameterName[1];
    	}

		$(".sendEmailToValidatedPlayer").click(function(){
			$.ajax({
				url: "../APIRemote/players.handler.php",
				contentType: "application/x-www-form-urlencoded",
				dataType: "json",
				async: false,
				data: {"action": "sendEmailToValidatedPlayer", "pid": uid},
				type: "GET",
				statusCode: {
					400: function(){
						alert("Bad request");
					},
					401: function(){
						alert("Unauthorized");
					}
				},
				success: function(data){
					alert('Mensaje enviado con &eacute;xito.');
				}
			});
		});
	}*/
});
</script>