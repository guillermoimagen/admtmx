<?
session_start();
include("API/funcionesWeb_API.php");
$archivoFinal=addslashes($_GET["archivo"]);
$archivoPartes=explode(".php",htmlentitiesMemoStrong($_GET["archivo"]));
$archivoLimpio=$archivoPartes[0];

// proteger el iframe del formulario, solo cargamos el que debe ser
if((isset($_SESSION["logged"]->id) && $_SESSION["logged"]->id<>0) && ($archivoLimpio=="formularioComentario" || $archivoLimpio=="formularioContacto" || $archivoLimpio=="formularioCret" || $archivoLimpio=="formularioRep" || $archivoLimpio=="formularioRet" || $archivoLimpio=="formularioUsuario"))
	$todobien=true;
else if($archivoLimpio=="formularioContacto")
	$todobien=true;
else 
{
	$archivoFinal="";
	exit();
}

if($todobien)
{	
$_SESSION["webInterno"]=1;
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Alcanc&iacute;a Digital Telet&oacute;n</title>
<style>
.form-error
{
	margin-top:-10px !important;
	margin-bottom:0px !important;	
}
</style>
<meta name="viewport" content="initial-scale=1, maximum-scale=1">

<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"
  integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw="
  crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="include/jquery/form-validator/jquery.form-validator.min.js"></script>
<link href="include/jquery/form-validator/theme-default.min.css" rel="stylesheet" type="text/css" />
<script id="loader" src="recursos/formularios/spin.min.js" type="text/javascript"></script>
<script id="loader" src="recursos/formularios/funciones.js" type="text/javascript"></script>
<link href="recursos/formularios/estilos.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<script src="recursos/formularios/colorpicker/jquery.colorpicker.js"></script>
<link href="recursos/formularios/colorpicker/jquery.colorpicker.css" rel="stylesheet" type="text/css"/>

<script src="recursos/formularios/alert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="recursos/formularios/alert/sweetalert.css">


<script type="text/javascript" language="JavaScript" src="/esapi4js/resources/i18n/ESAPI_Standard_en_US.properties.js"></script>
<script type="text/javascript" language="JavaScript" src="/esapi4js/esapi-compressed.js"></script>
<script type="text/javascript" language="JavaScript" src="/esapi4js/resources/Base.esapi.properties.js"></script>
<script type="text/javascript">
  org.owasp.esapi.ESAPI.initialize();
</script>


<style>
.ui-buttonset {
    margin-top: 10px;
}

.fancybox-close {
    top: 4px;
    right: 4px;
}
</style>

<script>

<? 
$idiomaMensajes="es";
if($_SESSION["idiomaTemp"]==1) 
	$idiomaMensajes="en";
?>

var idiomaMensajes="<?=$idiomaMensajes?>";
$(document).ready(function(){
	spinnerGenera();
<? 

if($archivoFinal<>"")
{
?>
    $(document).ready(function(){	
		nivelActual=-1;
        cargaArchivoDirecto("<?=$archivoFinal?>","",-1);
     });
<? 
} 

?>
});

</script>	

	    

</head>

<body style="margin:0px; border:none">

<? 
if($archivoFinal<>"")
{
?>	
<div id="timeline" name="timeline" class="timelinePrincipal  ui-dialog-content ui-widget-content ui-widget"> 
</div>

<div style="display:none">



<div id="tituloTimeline" name="tituloTimeline">
	<div class="titu_for">#titulo#</div>
</div>

<div id="subtituloTimeline" name="subtituloTimeline">
	<div style="clear:both; float:none;" class="nom_cam">
    	<div style="font-weight:bold;">#label#</div> #ayuda#<div style="height:5px"></div>
	</div>
</div>

<div id="textfieldTimeline" name="textfieldTimeline">
	<div id="t_#campo#" name="t_#campo#" class="nom_cam">
    	<div>#label#</div> #ayuda#
		<input type="#type#" value="#valor#" id="#campo#" name="#campo#" placeholder="#placeholder#" extras="" class="ui-widget ui-corner-all imput_for" style="width:#ancho#px">
        <div style="height:15px;"></div>
	</div>
</div>

<div id="memoTimeline" name="memoTimeline">
	<div id="t_#campo#" name="t_#campo#" class="nom_cam">
    	<div>#label#</div> #ayuda#
        <textarea id="#campo#" name="#campo#" placeholder="#placeholder#" extras="" class="ui-widget ui-corner-all textarea_for" style="width:#ancho#px">#valor#</textarea>
       	
	</div>
</div>

<div id="fechaTimeline" name="fechaTimeline">
	<div id="t_#campo#" name="t_#campo#" style="float:left; margin-right:20px;">
    	<div>#label#</div> #ayuda#
        <input class="fecha" type="#type#" value="#valor#" id="#campo#" name="#campo#" placeholder="#placeholder#" extras="" class="ui-widget ui-corner-all imput_for">
        <div style="height:15px;"></div>
	</div> 
</div>

<div id="fechaRangoTimeline" name="fechaRangoTimeline">
	<div id="t_#campo#" name="t_#campo#" style="float:left; margin-right:20px;">
    	<div>#label#</div> #ayuda#
        <input class="fecha" type="#type#" value="#valor#" id="#campo#_1" name="#campo#_1" placeholder="#placeholder#" extras="" class="ui-widget ui-corner-all imput_for">
        <input class="fecha" type="#type#" value="#valor#" id="#campo#_2" name="#campo#_2" placeholder="#placeholder#" extras="" class="ui-widget ui-corner-all imput_for">
        <div style="height:15px;"></div>
	</div>
</div>

<div id="pickerTimeline" name="pickerTimeline">
	<div id="t_#campo#" name="t_#campo#" style="float:left; margin: 0 20px 0 0;">
    	<div>#label#</div> #ayuda#
        <select id="#campo#" name="#campo#" idinterno="#idinterno#" extras="" class="select_for" style="width:300px; margin-top:2px">
        #opciones#
        </select>
        <div style="height:15px;"></div>
	</div> 
</div>

<div id="radioTimeline" name="radioTimeline">
	<div id="t_#campo#" name="t_#campo#" style="float:absolute; margin: 0 20px 0 0;">
    	<div>#label#</div> #ayuda#
        <div style="margin-top:6px">
        #opciones#
        <div style="clear:both; margin-top:4px" id="descripcionRadio" name="descripcionRadio"></div>
        </div>
	</div> 
</div>


<div id="colorTimeline" name="colorTimeline">
	<div id="t_#campo#" name="t_#campo#" style="float:left; margin-right:20px;">
    	<div>#label#</div> #ayuda#
		<input type="text" value="#valor#" id="#campo#" class="imput_for" name="#campo#" placeholder="#placeholder#" extras="" readonly>
        <div style="height:15px;"></div>
	</div>
</div>

<div id="segmentedTimeline" name="segmentedTimeline">
	<div id="t_#campo#" name="t_#campo#" style="float:left; margin-right:19px;">
    	<div>#label#</div> #ayuda#
          <div id="#campo#" name="#campo#" extras="" idinterno="#idinterno#"  valor="#valor#">
            #opciones#
          </div>
          <div style="height:15px;"></div>
	</div>    
</div>

<div id="separadorTimeline" name="separadorTimeline">
	<div style="height:#altura#px; clear:both"></div>
</div>

<div id="botonTimeline" name="botonTimeline">
	<div id="t_#campo#" name="t_#campo#" class="botonExterior">
		<div id="#campo#" name="#campo#" nivelBoton="#nivelBoton#" style="cursor:pointer; padding:10px; background-color:#color#; vertical-align:middle; color:#ffffff; text-align:center; " extras="" tipoBoton="#tipoBoton#" modoBoton="#modoBoton#" texto="#texto#">#texto#</div>
        <div style="height:5px;"></div>
    </div>
</div>

<div id="imagefTimeline" name="imagefTimeline">
	<div id="t_#campo#" name="t_#campo#" style="float:left; margin-right:18px;">
    	<div>#label#</div> #ayuda#
		<input type="#type#" value="#valor#" id="#campo#" name="#campo#" class="select_for" placeholder="#placeholder#" extras="" class="ui-widget ui-corner-all" style="width:#ancho#px; margin-right:5px;" readonly>
        <input type="button" value="Asignar" onClick="cambiarImagen('#campo#');">
        <!--<input type="button" value="Quitar" onClick="$('##campo#').val('');">-->
        <br><img src="#valorurl#" style="max-width:90px; max-height:60px; display:#display#" id="#campo#_i" name="#campo#_i">
        
        <div style="height:15px;"></div>
	</div>
</div>

<div id="imagenTimeline" name="imagenTimeline">
	<div id="t_#campo#" name="t_#campo#" class="imagenForm">
		<img src="recursos/#archivofoto#" style="width:100%">
        <!--<div class="inactivo" id="inactivo_#idreal#" name="inactivo_#idreal#" style="display:#display#"></div>-->
        <!--<div class="botonImagen" style="left:4px;" onClick="editarImagen(#idreal#);">Editar</div> -->
        <div class="botonImagen" style="right:4px;" onClick="actualizaFoto('#archivofotoasignar#');">Usar</div> 
    </div>
</div>

<div id="cfotosTimeline" name="cfotosTimeline">
	<div id="t_cfotos" name="t_cfotos" class="t_cfotos">
    	Category/Categoría<br>
        <select id="cfotos#nivel#" name="cfotos#nivel#" style="width:300px" onChange="refrescaImagenes(this.value);">
        #opciones#
        </select>
        <input type="button" style="display:#display#" value="Subir" onClick="subirTimelineMostrar();" >
        <div style="height:15px;"></div>
	</div>
</div>

<div id="subirFotoTimeline" name="subirFotoTimeline" style="z-index:102; display:none">
	<iframe src="formularioSubirFoto.php?modohtml=si&tablafoto=#tablafoto#&idregistrofoto=#idregistrofoto#&cfoto=#cfoto#&ancho=#ancho#&alto=#alto#" style="width:#ancho#px; height:#alto#px; overflow:hidden" scrolling="no" >
	</iframe>
</div>


<div id="masTimeline" name="masTimeline">
	<div id="masBoton#creado#" name="masBoton#creado#" class="masBoton" onClick="cargaMas();">
    	<img src="recursos/formularios/generales/mas.png" style="width:25px">
	</div>
</div>

<div id="noencontradoTimeline" name="noencontradoTimeline">
	<div style="color:#FF0000; padding:5px;">
       No encontramos información
    </div>
    <div style="height:5px; background-color:#eeeeee"></div>
</div>


<div id="regresarTimeline" name="regresarTimeline">
	<div class="regresar" onClick="regresarFuncion();">&nbsp;&nbsp;<<<< </div>
    <div style="height:26px;"></div>
</div>

<div id="toksTimeline" name="toksTimeline">
	<input type="hidden" id="toks" name="toks" value="#valor#">
</div>

<div id="regresarTimelineMovil" name="regresarTimelineMovil">
	
    <div style="height:26px; width:100%; background-color:#FFFFFF; position:fixed">
    	<div class="regresar" onClick="regresarFuncion();">&nbsp;&nbsp;<<<< </div></div>
    <div style="height:26px; "></div>
</div>


</div>

<? 
}
?>
</body>
</html>
<?
}
?>