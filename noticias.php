<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."noti.php");



if(!isset($_GET["pagina"]) || $_GET["pagina"]==1)
{
	$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);
	$cabeza=abre_plantilla_API("cabeza",true);
	
	$contenido=abre_plantilla_API("noticias",false);
	if($idioma==1) $titulo="News";
	else $titulo="Noticias";
	$contenido=str_replace("<titulo>",$titulo,$contenido);
	
	$vista_noticias=extrae_vista_API("noticias",$contenido);
	$noticiasArreglo=noti_lee(array("order"=>"fechanoti desc","numero_pagina"=>1,"items_por_pagina"=>10));
	$vista_noticiasT=generaVistaRecursiva2015($vista_noticias[1],$noticiasArreglo);
	$contenido=str_replace($vista_noticias[0],$vista_noticiasT,$contenido);
	
	if(sizeof($noticiasArreglo)>=1) $displayvermas="block"; // aqui
	else $displayvermas="none";
	$contenido=str_replace("<displayvermas>",$displayvermas,$contenido);
	
	$pie=abre_plantilla_API("pie",true);
	
	$title="<title>".$titulo." | ".$titleBase."</title>";
	
	$cabeza=str_replace("<titulopagina>",$titulo." | ".$titleBase,$cabeza);
	$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
	$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
	//$cabeza=str_replace("<redes>",$redes,$cabeza);
	
	$contenido=$cabezaPrincipal.$cabeza.$contenido.$cuadros.$pie;
}
else
{
	header('Content-Type: text/html; charset=iso-8859-1');
	$contenido=abre_plantilla_API("noticias",false);
	$vista_noticias=extrae_vista_API("noticias",$contenido);
	if((int)$_GET["pagina"]==0) $_GET["pagina"]=1;

	$noticiasArreglo=noti_lee(array("order"=>"fechanoti desc","numero_pagina"=>(int)$_GET["pagina"],"items_por_pagina"=>10));
	$contenido=generaVistaRecursiva2015($vista_noticias[1],$noticiasArreglo);
}
echo $contenido;


?>