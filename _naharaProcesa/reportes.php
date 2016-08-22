<?
include("recursos/entrada.php");
include("recursos/xss_var.php");
include("../include/connection.php");
include("recursos/funciones.php");
//error_reporting(E_ALL);
set_time_limit(300000);
$archivoactual="reportes.php";
$API_folder="../API/";
include($API_folder."pais.php");
	
if(!isset($_SESSION["nivelusuario"]) or $_SESSION["nivelusuario"]>2) exit();

include("include/reportesFunciones.php");

if((int)$_GET["step"]==2)
{
	if(!isset($_GET["pagina"])) $_GET["pagina"]=1;
	$fechahorahoy=date("Y-m-d H:m");
	$exportar=(int)$_GET["exportar"];
	$tamanopagina=100;
	
	if($_GET["modoR"]=="iniciativas")
		include("include/reportesIniciativas.php");
	else if($_GET["modoR"]=="donativos")
		include("include/reportesDonativos.php");
	else if($_GET["modoR"]=="usuarios")
		include("include/reportesUsuarios.php");		
}

if($_GET["modoR"]=="iniciativas") 
	$archivoactual="reportesI.php";
else if($_GET["modoR"]=="donativos") 
	$archivoactual="reportesD.php";
else $archivoactual="reportesU.php";

?>
<html>

<link rel="stylesheet" href="recursos/estilos.css" type="text/css">
<head>
<title>Reportes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
  integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
	crossorigin="anonymous"></script>
<script>
$( function() {
	$( "#buscador" ).autocomplete({
	  source: "include/reportes.php?modo=buscar",
	  minLength: 2,
	  select: function( event, ui ) {
		  $("#buscadorI").val(ui.item.id);
		  var cadena=$("#buscador").val();
			if(cadena.indexOf("(A)")==-1)
			{
				$("#esdonadorlabel").hide();
				$("#incluiriniciativaslabel").hide();
				
			}
			else 
			{
				$("#esdonadorlabel").show();
				$("#incluiriniciativaslabel").show();
			}

	  }
	});
	
	$( "#buscadorUsuarios" ).autocomplete({
	  source: "include/reportes.php?modo=buscar&extra=usuarios",
	  minLength: 2,
	  select: function( event, ui ) {
		  $("#buscadorI").val(ui.item.id);

	  }
	});
	
	$( "#inicio" ).datepicker({yearRange: "-100:+0",
				  changeMonth: true,
      			   changeYear: true,
				   dateFormat: "yy-mm-dd"});
    $( "#fin" ).datepicker({yearRange: "-100:+0",
				  changeMonth: true,
      			   changeYear: true,
				   dateFormat: "yy-mm-dd"});
} );
  
function buscaestados(idregistro)
{
	$.getJSON("include/reportes.php?modo=pais&idregistro="+$("#ipais").val(), function(result){ // es la url concatenada con el valor
		
		$('#iestado').empty();
		$('#iestado').append($('<option>', {
				value: 0,
				text: 'Estado:'
			}));
		for ( var x = 0; x < result.response.estados.length; x++) 
		{
			$('#iestado').append($('<option>', {
				value: result.response.estados[x].valor,
				text: result.response.estados[x].label
			}));
			//$("#iestado").append('<option value="'+result.response.estados[x].valor+'">'+result.response.estados[x].label+'</option>');
		}
	  }).fail(function() {
		  alert("alg esta mal");
	  });
}
function limpiaCampoIniciativa()
{
	if($("#buscador").val()=="")
		$("#buscadorI").val("");
		
	var cadena=$("#buscador").val();
	if(cadena.indexOf("(A)")==-1)
		$("#esdonadorlabel").hide();
	else $("#esdonadorlabel").show();
}
function limpiaCampoIniciativaUsuario()
{
	if($("#buscador").val()=="")
		$("#buscadorI").val("");

}
</script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/ui-lightness/jquery-ui.css">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<style>
.header
{
padding:5px;	
display:inline-block;
margin-top:5px;
vertical-align:top;
}
.reporteGranTitulo
{
	text-align:center;
	font-weight:bold;
	font-size:20px;	
}

.reporteTitulo
{
	text-align:center;
	font-weight:bold;	
}
.reporteTituloReal
{
	text-align:center;
	font-weight:normal;	
}
.reporte
{
	text-align:center;
}
.reporteTabla
{
	padding:10px;	
}
.reporteTabla tr:nth-child(odd) td{
	background-color:#E9E9E9
}
.reporteTabla tr:nth-child(even) td{
	background-color:#D8D8D8;

}
.pagina_div
{
	float:right;
}

.pagina_div div
{
	float:left;
	background-color:#F15D58;
	height:20px;
	color:#fff;
	text-align:center;
	font-weight:700;
	font-size:15px;
	margin: 0px 6px;
	cursor:pointer;
	padding:5px 5px 0px 5px;
}

.arrow_pag
{
	width:80px;
}

.num_pag
{
	width:30px;
	background-color:#F47676 !important;
}

.pag_actual
{
	background-color:#E55353 !important;
}

.sii
{
	display: block;
}

.noo
{
	display: none;
}
</style>

</head>
<BODY style="margin-right:20px;">
<?
if((int)$_GET["step"]<>2)
{
	echo($encabezadousuario);
	include("recursos/cabeza.inc"); 
	include("menu.php"); 
	include("menu2.php"); 
}
?>
<? 
if((int)$_GET["step"]==1) 
{ 
	if($_GET["modoR"]=="iniciativas") 
		$titulo="Iniciativas";
	else if($_GET["modoR"]=="donativos") 
		$titulo="Usuarios y Donativos";
	else if($_GET["modoR"]=="usuarios") 
		$titulo="Usuarios";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina">
  <tr>    
    <td height="30" valign="middle">Reporte de <?=$titulo?> </td></tr></table>
   
<div style="margin-left:5px; margin-top:5px; width:100%; background-color:<?=$vsitioscolor5?>; padding:3px" class="textogeneral">
<form target="_blank" method="get" action="reportes.php">
<input type="hidden" name="step" id="step" value="2">
<input type="hidden" name="modoR" id="modoR" value="<?=htmlentitiesMemo2Strong($_GET["modoR"])?>">
<input type="hidden" name="buscadorI" id="buscadorI" value="">
<? 

	$paises=@mysqli_query($GLOBALS["enlaceDB"] ,"select id,nombrepais from pais order by ordenpais,nombrepais asc");
	echo("<div class='header'>Pa&iacute;s:<br><select id='ipais' name='ipais' style='width:150px' class='textogeneral' onchange='buscaestados();'>");
	echo("<option value='0'>...</option>");
	while($row=mysqli_fetch_object($paises))
		echo("<option value='".$row->id."'>".$row->nombrepais."</option>");
	echo("</select></div>");
	
	echo("<div class='header'>Estado:<br><select id='iestado' name='iestado' style='width:150px' class='textogeneral'>");
	echo("<option value='0'>...</option>");
	echo("</select></div>");
	
	if($_GET["modoR"]<>"usuarios")
	{
		$cats=@mysqli_query($GLOBALS["enlaceDB"] ,"select id,nombrecat from cat order by nombrecat");
		echo("<div class='header'>Categor&iacute;a:<br><select id='icat' name='icat' style='width:150px' class='textogeneral'>");
		echo("<option value='0'>...</option>");
		while($row=mysqli_fetch_object($cats))
			echo("<option value='".$row->id."'".$sel.">".$row->nombrecat."</option>");
		echo("</select></div>");
	}
	
	if($_GET["modoR"]=="iniciativas")
	{		
		echo("<div class='header'>Status:<br><select id='statusret' name='statusret' style='width:150px' class='textogeneral'>");
		echo("<option value='todas' selected>Todas</option>");
		echo("<option value='pendiente'>Pendiente</option>");
		echo("<option value='validada'>Validada</option>");
		echo("<option value='vigente'>Vigente</option>");
		echo("<option value='disponible'>Disponible</option>");
		echo("<option value='rechazada'>Rechazada</option>");
		echo("<option value='noiniciada'>No iniciada</option>");
		echo("</select></div>");
	}
	
	if($_GET["modoR"]=="donativos")
	{
		echo("<div class='header'>Iniciativa/Receptor/Directo:<br><input type='text' id='buscador' name='buscador' value='' placeholder='Buscar' style='width:300px' onchange='limpiaCampoIniciativa()'><br>");
		echo("<label><input type='checkbox' id='ganador' name='ganador' value='1'>Ganador</label>");
		echo("<label><input type='checkbox' id='mostrarextras' name='mostrarextras' value='1'>Mostrar extras</label>");
		echo("<br><label id='esdonadorlabel' name='esdonadorlabel' style='display:none'><input type='checkbox' id='esdonador' name='esdonador' value='1'>Buscar donativos de</label>");
		echo("<label id='incluiriniciativaslabel' name='incluiriniciativaslabel' style='display:none'><input type='checkbox' id='incluiriniciativas' name='incluiriniciativas' value='1'>Incluir iniciativas</label>");
		echo("</div>");

		echo("<div class='header'>Status<br><select id='statusdon' name='statusdon' style='width:150px' class='textogeneral'>");
		echo("<option value='-1'>...</option>");
		echo("<option value='0'>Pendiente</option>");
		echo("<option value='2' selected>Pagado</option>");
		echo("<option value='3'>Cancelado</option>");
		echo("<option value='4'>Rechazado</option>");
		echo("</select></div>");
		
		$cats=@mysqli_query($GLOBALS["enlaceDB"] ,"select id,nombreforma from formas order by nombreforma");
		echo("<div class='header'>Forma de pago:<br><select id='iformadon' name='iformadon' style='width:150px' class='textogeneral'>");
		echo("<option value='0'>...</option>");
		while($row=mysqli_fetch_object($cats))
			echo("<option value='".$row->id."'".$sel.">".$row->nombreforma."</option>");
		echo("</select></div>");
		
		echo("<div class='header'>Fecha inicio:<br><input type='text' id='inicio' name='inicio' value='' placeholder='Inicio' style='width:100px'></div>");
		echo("<div class='header'>Fecha fin:<br><input type='text' id='fin' name='fin' value='' placeholder='Fin' style='width:100px'></div>");
	}
	else if($_GET["modoR"]=="usuarios")
	{
		echo("<div class='header'>Iniciativa/Usuario (Gusta):<br><input type='text' id='buscadorUsuarios' name='buscadorUsuarios' value='' placeholder='Buscar' style='width:300px' onchange='limpiaCampoIniciativaUsuario()'><br>");
		echo("</div>");
		
		echo("<div class='header'>Nacimiento (-mm-) (-mm-dd):<br><input type='text' id='nacimientousuario' name='nacimientousuario' value='' placeholder='' style='width:100px'></div>");
	}	
	
	if($_GET["modoR"]=="usuarios")
	{
		echo("<div class='header'>Donado:<br><input type='text' id='idonusuarioMin' name='idonusuarioMin' value='' placeholder='M&iacute;nimo' style='width:100px'>");
		echo("</div>");
		echo("<div class='header'><br><input type='text' id='idonusuarioMax' name='idonusuarioMax' value='' placeholder='M&aacute;ximo' style='width:100px'></div>");
		echo("<div class='header'>Recibido:<br><input type='text' id='irdonusuarioMin' name='irdonusuarioMin' value='' placeholder='M&iacute;nimo' style='width:100px'>");
		echo("</div>");
		echo("<div class='header'><br><input type='text' id='irdonusuarioMax' name='irdonusuarioMax' value='' placeholder='M&aacute;ximo' style='width:100px'></div>");
	}
	else
	{
		echo("<div class='header'>Recaudado:<br><input type='text' id='minimo' name='minimo' value='' placeholder='M&iacute;nimo' style='width:100px'>");
	echo("</div>");
	echo("<div class='header'><br><input type='text' id='maximo' name='maximo' value='' placeholder='M&aacute;ximo' style='width:100px'></div>");
		
	}
	

	
      
?>
<div style="display:inline-block"><label><input type='checkbox' id='exportar' name='exportar' value='1'>Exportar</label><br><input type="submit" style="background-color:#112FA6; color:#FFFFFF" value="Generar"></div> 
</div>
</form>
<div style='height:500px'></div>
<? 
} 
else if((int)$_GET["step"]==2)
{
	echo $cad;	
}
?>