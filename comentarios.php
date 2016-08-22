<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."ret.php");
include_once($API_folder."don.php");
include_once($API_folder."social.php");

if(!isset($_GET["pagina"])) $_GET["pagina"]=1;
$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);
$cabeza=abre_plantilla_API("cabeza",true);

$sepudo=false;
if($_SESSION["logged"]->cms==1)
{
	$sepudo=true;
	$contenido=abre_plantilla_API("comentarios",false);
	
	$comentariosArreglo=com_lee_especial(array("grafico"=>"pendientes"));
	$vistaComentarios=abre_plantilla_API("vistaComentariosPendientes",false);
	if(sizeof($comentariosArreglo)>0)		
		$vistaComentarios=generaVistaRecursiva($vistaComentarios,$comentariosArreglo);
	else $vistaComentarios="";
	
	$iniciativaDetalleArreglo[0]->vistaComentarios=$vistaComentarios;
	$contenido=generaVistaRecursiva($contenido,$iniciativaDetalleArreglo);
	 
}	

if(!$sepudo) 
{
	$contenido=abre_plantilla_API("noencontrado",false);
	$contenido=str_replace("<aviso>",$idiomas["Informacion no encontrada"],$contenido);
}
$pie=abre_plantilla_API("pie",true);

$cabeza=str_replace("<titulopagina>","Comentarios | ".$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
$cabeza=str_replace("<redes>","",$cabeza);

$contenido=$cabezaPrincipal.$cabeza.$contenido.$pie;


echo $contenido;




?>