<?
$API_folder="API/";
if($esWeb<>1)
{
	include("include/connection.php");
	include("include/funciones.php");
}
include_once($API_folder."fotos.php");
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
$cfoto=cfoto_lee(array("sql_extra"=>"id=".(int)$_GET["cfoto"]));
$ancho=1024;
$alto=768;
if(sizeof($cfoto)>0)
{
	$partes=explode(",",$cfoto[0]->dimensionescfotos);
	if(sizeof($partes)>0)
	{
		$partes2=explode("x",$partes[0]);
		if(sizeof($partes2)==2)
		{
			$ancho=$partes2[0];
			$alto=$partes2[1];	
		}
	}
}

$respuesta["timeline"]=array();
$validarActividad=checaUsuarioActividad();

if($validarActividad<>"")
{
	if($validarActividad=="actividadNoTiempo") $validarActividad.="Fotos";
	echo(mensajeIdioma($validarActividad));
}
else if($_SESSION["firmado"]) // es webmaster
{
	
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
	<script
      src="https://code.jquery.com/jquery-1.12.4.min.js"
      integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
      crossorigin="anonymous"></script>
    <script src="include/jquery/bootstrap/js/bootstrap.min.js"></script>
    <link href="recursos/formularios/upload/css/demo.html5imageupload.css?v1.3" rel="stylesheet">
    <link href="include/jquery/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="recursos/formularios/upload/js/html5imageupload.js?v1.4.3"></script>
<title>Subir imagen</title>
<script>
$(document).ready(function(){


    $('.dropzone').html5imageupload({
    	onAfterProcessImage: function() {
			parent.regresarSubirFoto($(this.element).data('imagen'));
			/*
			alert($(this.element).data);
			alert($(this.element).data('name'));
    		$('#filename').val($(this.element).data('name'));*/
    	},
    	onAfterCancel: function() {
			
    	}
    });
	 
	
});
</script>
</head>

<body style="margin:0px">
	
    <div class="dropzone" data-width="<?=$ancho?>" data-height="<?=$alto?>" data-url="APIRemote/subirFoto.php?modohtml=si&stringToPass=<?=(int)$_GET["cfoto"]?>&stringToPass1=<?=(int)$_GET["tablafoto"]?>&stringToPass2=<?=(int)$_GET["idregistrofoto"]?>" data-resize="true" style="width:<?=(int)$_GET["ancho"]?>px; height:<?=(int)$_GET["alto"]?>px">
        <input type="file" name="imagen" id="imagen" />
    </div>
</body>
</html>
<? } ?>