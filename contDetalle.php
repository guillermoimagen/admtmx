<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."ret.php");
include_once($API_folder."noti.php");
include_once($API_folder."cont.php");

$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);
$cabeza=abre_plantilla_API("cabeza",true);
	
// para los cuadritos
$ret_cuadros=ret_lista_lee(array("modo"=>"disponible","grafico"=>"corto","destacada"=>true,"order"=>"rand()","numero_pagina"=>1,"items_por_pagina"=>8));
if(sizeof($ret_cuadros)>0)
{
	$cuadros=abre_plantilla_API("cuadros",false);
	$vista_cuadros=extrae_vista_API("cuadros",$cuadros);
	$vista_cuadrosA=extrae_vista_API("cuadrosA",$vista_cuadros[1]);
	$vista_cuadrosB=extrae_vista_API("cuadrosB",$vista_cuadros[1]);
	$vista_cuadrosT=generaVistaRecursivaAlternada($vista_cuadrosA[1],$vista_cuadrosB[1],$ret_cuadros);
	$cuadros=str_replace($vista_cuadros[0],$vista_cuadrosT,$cuadros);
}
else $cuadros="";


// leamos el contenido
$sql_extra="";
if(isset($_GET["urlamigable"]))
	$sql_extra=" urlamigablecont='".mysqli_real_escape_stringMemo($_GET["urlamigable"])."'";
$contDetalleArreglo=cont_lee(array("id"=>(int)$_GET["idregistro"],"sql_extra"=>$sql_extra));

if(sizeof($contDetalleArreglo)>0)
{
	$contenido=abre_plantilla_API("contDetalle",false);
	
	$contDetalleArreglo[0]->video=""; // vamos a ver si tenemos video
	if($contDetalleArreglo[0]->videocont<>"")
	{
		$video=abre_plantilla_API("video",false);
		$contDetalleArreglo[0]->video=str_replace("<video>",$contDetalleArreglo[0]->videocont,$video);
	}
	
	// noticias complementarios
	$noticiasArreglo=noti_lee(array("order"=>"fechanoti desc","numero_pagina"=>1,"items_por_pagina"=>3));
	if(sizeof($noticiasArreglo)>0)
	{
		$noticiarenglon=abre_plantilla_API("noticiarenglon",false);
		$noticias2=generaVistaRecursiva($noticiarenglon,$noticiasArreglo);
	}
	else $noticias=abre_plantilla_API("nohay",false);
	$contDetalleArreglo[0]->noticias=$noticias2;

	if($idioma==1)
	{
		$contDetalleArreglo[0]->compartir="Share";
		$contDetalleArreglo[0]->noticiasTitulo="News";	
	}
	else
	{
		$contDetalleArreglo[0]->compartir="Compartir";
		$contDetalleArreglo[0]->noticiasTitulo="Noticias";
	}
	$contDetalleArreglo[0]->share=generaShareButtons($contDetalleArreglo[0]->urlAmigablecont);
	$contenido=generaVistaRecursiva($contenido,$contDetalleArreglo);
	
	$redes=generaRedes($contDetalleArreglo[0]->nombrecont,
						$contDetalleArreglo[0]->imagencont,
						"",
						$contDetalleArreglo[0]->urlAmigablecont);
}
else 
{
	$e404=true;
	$contenido=abre_plantilla_API("noencontrado",false);
	$contenido=str_replace("<aviso>",$idiomas["Informacion no encontrada"],$contenido);
}
$pie=abre_plantilla_API("pie",true);

$cabeza=str_replace("<titulopagina>",$contDetalleArreglo[0]->nombrecont." | ".$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
$cabeza=str_replace("<redes>",$redes,$cabeza);

$contenido=$cabezaPrincipal.$cabeza.$contenido.$cuadros.$pie;
if($e404)
	http_response_code(404);
echo $contenido;


?>