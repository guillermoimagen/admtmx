<!doctype html>
<html>
<head>
<base href="//www.alcanciadigitalteleton.mx/" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="recursos/elementos/estilos.css"/>
<link rel="stylesheet" type="text/css" href="include/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="include/slick/slick-theme.css"/>
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
  integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
	crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/ui-lightness/jquery-ui.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="include/slick/slick.min.js"></script>

<script type='text/javascript' src='include/jquery/masonry.pkgd.min.js'></script>
<script type='text/javascript' src='include/jquery/imagesloaded.pkgd.min.js'></script>
<link rel="stylesheet" href="include/jquery/fancybox/jquery.fancybox.css">
<script src="include/jquery/fancybox/jquery.fancybox.pack.js"></script>
<script type='text/javascript' src="include/js/js.cookie.js"></script>
<link rel="stylesheet" href="include/css/login.style.css?v=1.0">
<script type='text/javascript' src='include/funciones.js?v=2.0'></script>
<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>

<script type="text/javascript" language="JavaScript" src="/esapi4js/resources/i18n/ESAPI_Standard_en_US.properties.js"></script>
<script type="text/javascript" language="JavaScript" src="/esapi4js/esapi-compressed.js"></script>
<script type="text/javascript" language="JavaScript" src="/esapi4js/resources/Base.esapi.properties.js"></script>
<script type="text/javascript">
  org.owasp.esapi.ESAPI.initialize();
</script>

<script>
$(document).ready(function(){
	$('.galeria_contenedor').slick({
	});
	
	
	var $grid = $('#contenido').masonry({
		  itemSelector: '.sec-item',
		  isFitWidth: true,
		  "gutter": 20
		});	
	// layout Masonry after each image loads
	$grid.imagesLoaded().progress( function() {
	  $grid.masonry('layout');
	});
/*
		$('#contenido').masonry({
		  itemSelector: '.sec-item',
		  isFitWidth: true,
		  "gutter": 20
		});	*/
	
});

$(window).load(function(){  

 });

</script>