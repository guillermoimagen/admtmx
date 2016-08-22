if(lang == null) var lang = "ES";

var ICFunciones_lang = {
	"ES": {
		"cerrarVentana": "\u00BFCerrar ventana?",
		"minimopayuefectivo":"En caso de haber elegido donativo en efectivo, tu aportaci\u00F3n debe ser mayor a $55. Gracias",
		"seleccionatipodepago":"Seleciona un tipo de pago",
		"minimotarjetacredito":"El donativo m\u00EDnimo para con tarjeta de cr\u00E9dito es de 55 pesos",
		"tarjetayaexpiro":"La tarjeta de cr\u00E9dito ya expir\u00F3",		
		"numerotarjetainvalido":"El n\u00FAmero de tarjeta de cr\u00E9dito es inv\u00E1lido",		
		"ccvincorrecto":"C\u00F3digo de seguridad incorrecto",	
		"fechanacimientoinvalida":"Fecha de nacimiento no v\u00E1lida",	
		"rfcCurpInvalidos":"RFC o CURP no v\u00E1lidos",	
	},
	"EN": {
		"cerrarVentana": "Close this window?",
		"minimopayuefectivo":"",
		"seleccionatipodepago":"Select payment method",
		"minimotarjetacredito":"Credit card donation miniumum $55 pesos",
		"tarjetayaexpiro":"Credit card expired",		
		"numerotarjetainvalido":"Invalid credit card number",		
		"ccvincorrecto":"Invalid CCV",	
		"fechanacimientoinvalida":"Incorrect birth date format",	
		"rfcCurpInvalidos":"Invalid RFC or CURP",	
	}
};

// JavaScript Document
var paginaContenido=1;

$( document ).ready(function() {
		
	$('#formpag input').on('change', function() {
	   var valor=$('input[name=pagos]:checked', '#formpag').val();
	   if(valor==1){
	   		$("#creditCar").show(500);
	   }else{
	   		$("#creditCar").hide(500);
	   		//$("#ntarjeta").val("");
	   		//$("#vencimiento").val("");
	   		//$("#cseg").val("");
	   }
	});
	});



function registrarme()
{
	$.showSignUpWindow();
}

function revisaFirma()
{
	$.showLoginWindow();
}

function salirme()
{
	$.logout();
}


function revisaFirmaOperacion()
{
	if(usuarioFirmado=='' || usuarioFirmado=='0')
	{
		revisaFirma();
		return false;
	}
	else
	{
		return true;
	}	
}

function cambioIdioma()
{
	$.ajax( "cambioIdioma.php" )
	  .done(function(data) {
	  })
	  .fail(function() {
	  })
	  .always(function() {
		  /*var url=window.location.href;
		  var newurl=url.replace("/0/","/1/");
		  if(newurl==url) newurl=url.replace("/1/","/0/");
		  window.location.href=newurl;*/
		  location.reload();
	  });
}

function cargaMasNoticias()
{
	$("#cargarmas_loader").show();
	$("#cargarmas").hide();
	
	var paginaContenidoTemporal=paginaContenido+1;
	$.ajax( "noticias.php?pagina="+paginaContenidoTemporal )
	  .done(function(data) {
		  if(data!='')
		  {
			  var $content = $( data );
			  $("#contenido").append( $content ).masonry( 'appended', $content ); 
			  $("#cargarmas").show(); 
		  }	  
	  })
	  .fail(function() {
		
	  })
	  .always(function() {
		paginaContenido++;
		$("#cargarmas_loader").hide();
	  });
}



function editarIniciativa(idreal,modoIdioma)
{
	if(revisaFirmaOperacion())
	{
		abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioRet.php?idreal="+idreal+"&operacion=editar&modoIdioma="+modoIdioma),"iniciativa");
	}
}

function agregarReporte(idreal,modo)
{
	if(revisaFirmaOperacion())
	{
		if(modo=='iniciativa')
			abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioRep.php?idiniciativa="+idreal+"&operacion=agregar"),"reporte");
		else if(modo=='usuario')
			abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioRep.php?idusuario="+idreal+"&operacion=agregar"),"reporte");
	}
}

function verReporte(idreal)
{
	abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioRep.php?idreal="+idreal+"&operacion=editar"),"reporteEditar");
}

function editarUsuario(idreal)
{
	if(revisaFirmaOperacion())
	{
		abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioUsuario.php?idreal="+idreal+"&operacion=editar"),"usuario");
	}
}

var wWidthExterno=0;
function abreFormulario(url,modo)
{
	formularioGuardado=false
	if($(window).width()>500)
		wWidth = $(window).width()*0.8;
	else  wWidth = $(window).width()*0.9;
	
	if(wWidth>1024) wWidth=1024;
	
	wHeight = $(window).height()*0.9;
	
	if(modo=="comentario" && $(window).height()>500 && wHeight>300)
		wHeight=350;
	else if(modo=="reporte" && $(window).height()>500 && wHeight>300)
		wHeight=350;
	wWidthExterno=wWidth;
	$.fancybox.open({
		width: wWidth,
        height: wHeight,
		padding : 0,
		href:url,
		type: 'iframe',
	    fitToView : false,
	    autoSize : false,
		closeClick	: false,
		beforeShow: function(){
			document.ontouchmove = function(e){ e.preventDefault(); }
		},
		afterClose: function(){
 			document.ontouchmove = function(e){ return true; }
		},
		beforeClose : function() {  if(formularioGuardado)  return true; else return window.confirm(ICFunciones_lang[lang].cerrarVentana); }
	});	  
}
var formularioGuardado=false;
// funcion que manda a llamar el formulario
function operacionVentanaFormulario(operacionVentana,operacionValor1,operacionValor2)
{
	if(operacionVentana=="cerrarVentana")
		$.fancybox.close();	
	else if(operacionVentana=="refrescarVentana")
		window.location.reload();
	else if(operacionVentana=="redireccionarVentana")
			window.location.href=operacionValor1;
}

function editarComentario(idreal)
{
	if(revisaFirmaOperacion())
	{
		abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioComentario.php?idreal="+idreal+"&operacion=editar"),"comentario");
	}
}

function enviarComentario(cual)
{
	if(revisaFirmaOperacion())
	{
		if($("#comentario").val()!='')
		{
			$(".btn_comentar").hide();
			var textoEnviar = $("#comentario").val().substring(0,255); 
			$.post( "APIRemote/operacionesIniciativas.php?operacion=comentario", { texto: textoEnviar	, idregistro: cual })
			  .done(function( data ) {
				  $(".btn_comentar").show();
				  if(data.response.mensaje) 
				  {
					  if(data.response.ok=="1")
					  	$("#comentario").val("");
					  alert(data.response.mensaje);
				  }
			  });
		}
	}
		
}

function limitaComentario(maximo) 
{    
	var resta=maximo-parseInt($("#comentario").val().length);
	$("#charsActual").html(resta);
    if ($("#comentario").val().length >= maximo) 
		return false;
}

function megusta(cual,objeto)
{
	if(revisaFirmaOperacion())
	{
		var nuevo=pintagusta(objeto);
		$.getJSON("APIRemote/operacionesIniciativas.php?operacion=gusta&valor="+nuevo+"&idregistro="+cual, function(result){
			
          }).fail(function() {
			  pintagusta(objeto);
		  })
		  .always(function() {

		  });
	}
}

function pintagusta(objeto)
{
	var actual=0;
	if($(objeto).hasClass("like_cora1")) // seleccionad
	{
		actual=0;
		$(objeto).removeClass("like_cora1");
		$(objeto).addClass("like_cora0");
		var valor=parseInt($(objeto).html())-1;
		if(valor>=0)
			$(objeto).html(valor);
	}
	else
	{
		actual=1;
		$(objeto).removeClass("like_cora0");
		$(objeto).addClass("like_cora1");
		var valor=parseInt($(objeto).html())+1;
		$(objeto).html(valor);
	}
	return actual;
}

function subeTuIniciativa(idusuario)
{
	if(revisaFirmaOperacion())
	{
		abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioRet.php?idreal="+idusuario+"&operacion=agregar"),"iniciativa");
	}
}

function todosDonadores(cual,titulo)
{
	/*wWidth = $(window).width()*0.8;
	wHeight = $(window).height()*0.9;
	if(wWidth>1024) wWidth=1024;
	$.fancybox.open({
		padding : 0,
		href:"donadoresTodos.php?idiniciativa="+cual,
	    fitToView : false,
	    autoSize : true
		
	});	
	$("#todosDonadores").fancybox.open({padding : 0,
		href:"donadoresTodos.php?idiniciativa="+cual,
	    fitToView : false,
	    autoSize : true});
	*/
	$.fancybox("#todosDonadores");
	wHeight = $(window).height()*0.9;
	$("#todosDonadores").html("<div style='height:"+wHeight+"px'><center><img src='recursos/elementos/ajax-loader.gif'></center></div>");
	$.ajax({
		url: "donadoresTodos.php?idiniciativa="+cual,
		success: function(data){		
			data=$ESAPI.encoder().normalize(data);		
			$("#todosDonadores").html($.parseHTML( data ));

		}   
	});
	
	
}

function abreBuscador()
{
		if ( $( ".buscador_bloques" ).is( ":hidden" ) ) {
			$( ".buscador_bloques" ).slideDown();
		} else {
			$( ".buscador_bloques" ).slideUp();
		}
}

function abreBuscadorAvanzado()
{
	if ( $( ".avanzado_div" ).is( ":hidden" ) ) {
		$( ".avanzado_div" ).slideDown();
	} else {
		$( ".avanzado_div" ).slideUp();
	}
	
	if($("#avanzado_div_contenido").css('display') == 'none' ) // vamos a cargar
	{
		$.getJSON( "APIRemote/buscadorContenido.php", function(result) {
		  if(result.response) // contenido seguro
			{
				var estados=result.response.estados;
				for (var i=0; i<estados.length; i++)
				{
					$('#bestado').append($('<option>', { 
						value: estados[i].valor,
						text : estados[i].label 
					}));
				}
				var categorias=result.response.categorias;
				for (var i=0; i<categorias.length; i++)
				{
					$('#bcategoria').append($('<option>', { 
						value: categorias[i].valor,
						text : categorias[i].label 
					}));
				}
				var statuses=result.response.status;
				for (var i=0; i<statuses.length; i++)
				{
					$('#bmodo').append($('<option>', { 
						value: statuses[i].valor,
						text : statuses[i].label 
					}));
				}
				$("#avanzado_div_contenido").show();
				$("#avanzado_div_loader").hide();
				
			}
		})
		  .done(function(data) {
			  
			
		  })
		  .fail(function() {
			console.log( "error" );
		  });
	}
}

function realizaBusqueda()
{
	var url="";
	if($("#bmodo").val()=="destacada") url="&destacada=1";
	else url="&modo="+$("#bmodo").val();
	
	
	if($("input[name='btipo']:checked").val())
		url+="&tipo="+$("input[name='btipo']:checked").val();
	url+="&estado="+$("#bestado").val();
	url+="&cat="+$("#bcategoria").val();
	url+="&palabra="+$("#bpalabra").val();
	
	if($("#busuarios").is(':checked'))
		window.location.href="usuariosListado.php?"+url;
	else 
		window.location.href="iniciativasListado.php?"+url;
}

function validarComentario(cual,operacion)
{
	var r = confirm("Deseas "+operacion+"?");
	if (r == true) {
		$.getJSON( "APIRemote/operacionesIniciativas.php?operacion=validarComentario&operacionReal="+operacion+"&idregistro="+cual, function(result) {
		  if(result.response)
			{
				
				var mensaje=result.response.mensaje; // seguro
				$("#comentario"+cual).hide();
				
			}
		})
		  .done(function(data) {
			  
			
		  })
		  .fail(function() {
			console.log( "error" );
		  });
	} 

	
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function registroParcial()
{
	var email=$("#tuemail").val();
	if(email=="")
	{
		$("#tuemail").css("background-color","#E6BFC0");
		$("#tuemail").focus();
		return false;
	}
	else if(!validateEmail(email))
	{
		$("#tuemail").css("background-color","#E6BFC0");
		$("#tuemail").focus();	
		return false;
	}
	else 
	{
		$("#tuemail").css("background-color","#FFFFFF");
		return true;
	}
	
}

function cambiardonador()
{
	$.ajax( "registroParcialSalir.php" )
	  .done(function(data) {
	  })
	  .fail(function() {
	  })
	  .always(function() {
		window.location.href = document.location.href.match(/(^[^#]*)/)[0];
	  });
}




var errorRequerido="Req.";
var errorInt="Num";
var errorFloat="Num";
var errorMinimo="Min ";
var errorMaximo="Max ";
var errorMaximoText="100 max ";

function alertaCret(mensaje,objeto)
{
	//objeto.focus();
	objeto.addClass("errorCret");
	$("#error_"+objeto.attr('id')).html(data=$ESAPI.encoder().encodeForHTML(mensaje));
}

function validarCretEspecifico(objeto)
{
	if ($(objeto).is(":visible") == true) 
	{ 
		$("#error_"+objeto.attr('id')).html("");
		objeto.removeClass("errorCret");
		var tipo=objeto.data("tipo");
		var minimo=objeto.data("min");
		var maximo=objeto.data("max");
		var req=objeto.data("req");
		
		var valor=objeto.val();
	
		if(req=="1" && valor=="")
		{
			alertaCret(errorRequerido,objeto);
			 return false;
		}
		else if(tipo=="int" || tipo=="float")
		{
			if(tipo=="int" && (Math.floor(valor) != valor || !$.isNumeric(valor))) 
			{
				alertaCret(errorInt,objeto);
				 return false;
			} 
			else if(tipo=="float" && !$.isNumeric(valor)) 
			{
				alertaCret(errorFloat,objeto);
				 return false;
			} 
			else if(minimo && valor<minimo)
			{
				alertaCret(errorMinimo+' '+minimo,objeto);
				return false;
			}
			else if(maximo && valor>maximo)
			{
				alertaCret(errorMaximo+' '+maximo,objeto);
				return false;
			}				
		}
		else if(tipo=='text' && valor.length>100)
		{
			alertaCret(errorMaximoText,objeto);
			return false;
		}
		return true;
	}
	else return true;
}





function validarCret()
{
	var cadena="";
	var sigue=true;
	$('.cret').each(function(){
		if(validarCretEspecifico($(this))) // validamos todos los elementos
		{}	
		else sigue=false;
 	});
	if(sigue) // validaremos el importe del donativo
	{
		var importeReal=Math.round($("#donativo").val());
		if(isNaN(importeReal) || importeReal==0) 
		{
			$("#donativo").focus();
			$("#donativo").addClass("errorCret");
			sigue=false;
		}
		else
			$("#donativo").removeClass("errorCret");
		
	}



	if(sigue){

  		var dato=$('input:radio[name=pagos]:checked').val();


		if( $("#formpag input[name=pagos]:radio").is(':checked')) {  

			var numero= parseInt($("#donativo").val());
			if((dato==3 || dato==4 || dato==5) && numero<55){
				alert(ICFunciones_lang[lang].minimopayuefectivo);
				sigue=false;
			}

			
		}else{
			
			
			alert(ICFunciones_lang[lang].seleccionatipodepago);
		    sigue=false;
		}

		if(dato==1){

			$(".frm_input").removeClass("errorCret");
			$(".frm_input").each(function () 
	        { 
	            var elemento=$(this).val();
	            var compara=$(this).attr("maxe");
            	if(elemento.length<compara){
					$(this).addClass("errorCret");
					sigue=false;
				}
	        }) 
	        
	        var importeReal2=Math.round($("#donativo").val());
	        if(importeReal2<55){
	        	$("#donativo").addClass("errorCret");
			
	        	alert(ICFunciones_lang[lang].minimotarjetacredito);
	        	sigue=false;
	        }
	        
	       
	        
			var hoy = new Date();
	     	var mm = hoy.getMonth()+1; //hoy es 0!
			var yyyy = hoy.getFullYear();
			
			
			var yyyyuser=$("#TDC_ano").val();
			var mes=parseInt($("#TDC_mes").val());
			
			var text_alert="";
			
			
			
			if(yyyyuser==yyyy){
				if(mes<mm){
			
					text_alert=ICFunciones_lang[lang].tarjetayaexpiro;
					$("#TDC_ano").addClass("errorCret");
					$("#TDC_mes").addClass("errorCret");
					sigue=false;
				}
			}
			
			if(checkCreditCard($("#TDC_tarjeta").val(),$("#TDC_tipo").val())==false){
					if(text_alert=="")
				
						text_alert=ICFunciones_lang[lang].numerotarjetainvalido;
					
					$("#TDC_tarjeta").addClass("errorCret");
					$("#TDC_tipo").addClass("errorCret");
					sigue=false;
			}
			
			if($("#TDC_tipo").val()=="AMEX")
			{
				if($("#TDC_cst").val().length!=4)
				{
					$("#TDC_cst").addClass("errorCret");
					if(text_alert=="")
						text_alert=ICFunciones_lang[lang].ccvincorrecto;
					sigue=false;
				}
			}
			else if($("#TDC_cst").val().length!=3)
			{
				$("#TDC_cst").addClass("errorCret");
				if(text_alert=="")
					text_alert=ICFunciones_lang[lang].ccvincorrecto;
				sigue=false;
			}
			
			//if($("#TDC_nacimiento").val().length!="")
			//{
				var respuestaFecha=isValidDate( $("#TDC_nacimiento").val());
				if(!respuestaFecha)
				{
					$("#TDC_nacimiento").addClass("errorCret");
					if(text_alert=="")
						text_alert=ICFunciones_lang[lang].fechanacimientoinvalida;
					sigue=false;
				}
			//}
			
			// 
			if($("#TDC_identificacion").val().length>0 && $("#TDC_identificacion").val().length!=18 &&  $("#TDC_identificacion").val().length!=13 )
			{
				$("#TDC_identificacion").addClass("errorCret");
				if(text_alert=="")
					text_alert=ICFunciones_lang[lang].rfcCurpInvalidos;
				sigue=false;
			}
			
			if(text_alert!=""){
				alert(text_alert);
			}
			
	        
		}

	}

	if(sigue){
		$('#subpag').hide();
		$("#loader").show();
	}

	return sigue;
}

function isValidDate(dateString) {
	var regEx = /^\d{4}-\d{2}-\d{2}$/;
	if(!dateString.match(regEx))
	return false;  // Invalid format
	var d;
	if(!((d = new Date(dateString))|0))
	return false; // Invalid date (or this could be epoch)
    return d.toISOString().slice(0,10) == dateString;
}

function checkCreditCard (cardnumber, cardname) {
	 
  var cards = new Array();
  
  cards [0] = {name: "VISA", 
               length: "13,16", 
               prefixes: "4",
               checkdigit: true};
  cards [1] = {name: "MASTERCARD", 
               length: "16", 
               prefixes: "51,52,53,54,55",
               checkdigit: true};
  cards [2] = {name: "DinersClub", 
               length: "14,16", 
               prefixes: "36,38,54,55",
               checkdigit: true};
  cards [3] = {name: "CarteBlanche", 
               length: "14", 
               prefixes: "300,301,302,303,304,305",
               checkdigit: true};
  cards [4] = {name: "AMEX", 
               length: "15", 
               prefixes: "34,37",
               checkdigit: true};
  cards [5] = {name: "Discover", 
               length: "16", 
               prefixes: "6011,622,64,65",
               checkdigit: true};
  cards [6] = {name: "JCB", 
               length: "16", 
               prefixes: "35",
               checkdigit: true};
  cards [7] = {name: "enRoute", 
               length: "15", 
               prefixes: "2014,2149",
               checkdigit: true};
  cards [8] = {name: "Solo", 
               length: "16,18,19", 
               prefixes: "6334,6767",
               checkdigit: true};
  cards [9] = {name: "Switch", 
               length: "16,18,19", 
               prefixes: "4903,4905,4911,4936,564182,633110,6333,6759",
               checkdigit: true};
  cards [10] = {name: "Maestro", 
               length: "12,13,14,15,16,18,19", 
               prefixes: "5018,5020,5038,6304,6759,6761,6762,6763",
               checkdigit: true};
  cards [11] = {name: "VisaElectron", 
               length: "16", 
               prefixes: "4026,417500,4508,4844,4913,4917",
               checkdigit: true};
  cards [12] = {name: "LaserCard", 
               length: "16,17,18,19", 
               prefixes: "6304,6706,6771,6709",
               checkdigit: true};
               
  // Establish card type
  var cardType = -1;
  for (var i=0; i<cards.length; i++) {

    // See if it is this card (ignoring the case of the string)
    if (cardname.toLowerCase () == cards[i].name.toLowerCase()) {
      cardType = i;
      break;
    }
  }
  
  // If card type not found, report an error
  if (cardType == -1) {
     ccErrorNo = 0;
     return false; 
  }
   
  // Ensure that the user has provided a credit card number
  if (cardnumber.length == 0)  {
     ccErrorNo = 1;
     return false; 
  }
    
  // Now remove any spaces from the credit card number
  cardnumber = cardnumber.replace (/\s/g, "");
  
  // Check that the number is numeric
  var cardNo = cardnumber
  var cardexp = /^[0-9]{13,19}$/;
  if (!cardexp.exec(cardNo))  {
     ccErrorNo = 2;
     return false; 
  }
       
  // Now check the modulus 10 check digit - if required
  if (cards[cardType].checkdigit) {
    var checksum = 0;                                  // running checksum total
    var mychar = "";                                   // next char to process
    var j = 1;                                         // takes value of 1 or 2
  
    // Process each digit one by one starting at the right
    var calc;
    for (i = cardNo.length - 1; i >= 0; i--) {
    
      // Extract the next digit and multiply by 1 or 2 on alternative digits.
      calc = Number(cardNo.charAt(i)) * j;
    
      // If the result is in two digits add 1 to the checksum total
      if (calc > 9) {
        checksum = checksum + 1;
        calc = calc - 10;
      }
    
      // Add the units element to the checksum total
      checksum = checksum + calc;
    
      // Switch the value of j
      if (j ==1) {j = 2} else {j = 1};
    } 
  
    // All done - if checksum is divisible by 10, it is a valid modulus 10.
    // If not, report an error.
    if (checksum % 10 != 0)  {
     ccErrorNo = 3;
     return false; 
    }
  }  
  
  // Check it's not a spam number
  if (cardNo == '5490997771092064') { 
    ccErrorNo = 5;
    return false; 
  }

  // The following are the card-specific checks we undertake.
  var LengthValid = false;
  var PrefixValid = false; 
  var undefined; 

  // We use these for holding the valid lengths and prefixes of a card type
  var prefix = new Array ();
  var lengths = new Array ();
    
  // Load an array with the valid prefixes for this card
  prefix = cards[cardType].prefixes.split(",");
      
  // Now see if any of them match what we have in the card number
  for (i=0; i<prefix.length; i++) {
    var exp = new RegExp ("^" + prefix[i]);
    if (exp.test (cardNo)) PrefixValid = true;
  }
      
  // If it isn't a valid prefix there's no point at looking at the length
  if (!PrefixValid) {
     ccErrorNo = 3;
     return false; 
  }
    
  // See if the length is valid for this card
  lengths = cards[cardType].length.split(",");
  for (j=0; j<lengths.length; j++) {
    if (cardNo.length == lengths[j]) LengthValid = true;
  }
  
  // See if all is OK by seeing if the length was valid. We only check the length if all else was 
  // hunky dory.
  if (!LengthValid) {
     ccErrorNo = 4;
     return false; 
  };   
  
  // The credit card is in the required format.
  return true;
}

var obtendras="";
// reffescamos los cuadros extras en funcion del importe del donativo
function refrescaCret(maximos,mindonativo,importe)
{
	var importeReal=Math.round(importe);
	if(isNaN(importeReal)) $("#donativo").val("");
	else $("#donativo").val(importeReal);
	
	var cuantosPuedes=0;
	if(mindonativo>0) // hay minimo
	{
		cuantosPuedes=Math.floor(importeReal/mindonativo);
	}
	else // no hay minimo, entonces solo puede haber un ganador en el donativo
	{
		cuantosPuedes=1;
	}
	if(cuantosPuedes>maximos) cuantosPuedes=maximos;
	
	for(i=1; i<=cuantosPuedes; i++)
	{
		$("#cret"+i).show();
	}
	// estos son los diez máximos que puedes tener
	for(i=cuantosPuedes+1; i<=maximos; i++)
	{
		$("#cret"+i).hide();
	}
	$("#renglonesextras").val(cuantosPuedes);
	if(cuantosPuedes>0)
	{
		var tempo=obtendrasjs;
		tempo=tempo.replace('%d',cuantosPuedes);	
		tempo=$ESAPI.encoder().normalize(tempo);		
		$("#indicadorEstrellas").html($.parseHTML( tempo ));
	}
	else $("#indicadorEstrellas").html("");


	i


}

function detalleDonativo(cual,modo)
{
	$("#bitListado").html("");
	$.fancybox("#bitListado");
	wWidth=600;
	wHeight=300;
	if(wWidth>$(window).width())
		wWidth= $(window).width()*0.9;
	else if(wHeight>$(window).height())
		wHeight = $(window).height()*0.9;
	
	$("#bitListado").html("<div style='width:"+wWidth+"px; height:"+wHeight+"px'><center><img src='recursos/elementos/ajax-loader.gif'></center></div>");
	$.ajax({
		url: "donativoDetalle.php?idregistro="+cual+"&modo="+modo,
		success: function(data){
			data=$ESAPI.encoder().normalize(data);		
			$("#bitListado").html($.parseHTML( data ));
		}   
	});
}

function verBits(cual,modo)
{
	$("#bitListado").html("");
	$.fancybox("#bitListado");
	wHeight = $(window).height()*0.9;
	wWidth= $(window).width()*0.9;
	$("#bitListado").html("<div style='width:"+wWidth+"px; height:"+wHeight+"px'><center><img src='recursos/elementos/ajax-loader.gif'></center></div>");
	$.ajax({
		url: "bitLee.php?modo="+modo+"&idregistro="+cual,
		success: function(data){
			data=$ESAPI.encoder().normalize(data);		
			$("#bitListado").html($.parseHTML( data ));
		}   
	});
	
	
}

function contactoAbrir()
{
	abreFormulario("formulario.php?archivo="+encodeURIComponent("formularioContacto.php?operacion=agregar&"),"contacto");

}

function reenviarDonativo(idreal)
{
	$.ajax({
		url: "reenviarDonativo.php?idreal="+idreal+"&",
		success: function(data){
			data=$ESAPI.encoder().normalize(data);		
			alert(data);
		}   
	});
}

function cargaIniciativas(url)
{
	window.location.href=url;
}

function validateQty(event) {
    var key = window.event ? event.keyCode : event.which;

	if (event.keyCode == 8 || event.keyCode == 46
	 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 9) {
		return true;
	}
	else if ( key < 48 || key > 57 ) {
		return false;
	}
	else return true;
};

var RecaptchaLogin1;
var RecaptchaLogin2;
var RecaptchaLogin3;
var RecaptchaPagos1;

var CaptchaCallback = function() {
	if($("#RecaptchaLogin1").length > 0) RecaptchaLogin1 = grecaptcha.render('RecaptchaLogin1', {'sitekey' : '6LfiKyYTAAAAAASsTslFRmj5vGNEZd5bhSCEif0x'});
	if($("#RecaptchaLogin2").length > 0) RecaptchaLogin2 = grecaptcha.render('RecaptchaLogin2', {'sitekey' : '6LfiKyYTAAAAAASsTslFRmj5vGNEZd5bhSCEif0x'});
	if($("#RecaptchaLogin3").length > 0) RecaptchaLogin3 = grecaptcha.render('RecaptchaLogin3', {'sitekey' : '6LfiKyYTAAAAAASsTslFRmj5vGNEZd5bhSCEif0x'});
	if($("#RecaptchaPagos1").length > 0) RecaptchaPagos1 = grecaptcha.render('RecaptchaPagos1', {'sitekey' : '6LfiKyYTAAAAAASsTslFRmj5vGNEZd5bhSCEif0x'});
};

