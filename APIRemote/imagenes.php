<?
$API_folder="../API/";
if($esWeb<>1)
{
	include("../include/connection.php");
	include("../include/funciones.php");
	if($_SESSION["webInterno"]<>1)
	{
		include("sauth.digest.php");
		include 'Sauth.class.php';
		include 'sauth.validatoken.php';
	}
	//$_SESSION["remote"]=1;
}
include_once($API_folder."fotos.php");

if(!isset($_GET["pagina"]))
	$_GET["pagina"]=1;

if($_GET["pagina"]==1 || $_GET["pagina"]==0)
{
	$sql_extra="";
	$respuesta["cfotos"]=cfoto_lee(array("sql_extra"=>$sql_extra));
	/*if($_SESSION["logged"]->est==0 && $_GET["id"]<>6)
	{
		$respuesta["cfotos"][]=array("nombrecfoto"=>"Todas mis fotos","idreal"=>"0");	
		$respuesta["cfotos"][]=array("nombrecfoto"=>"Imágenes públicas","idreal"=>"-1");	
	}*/
}

$sql_extra="";
if($_GET["id"]>=0)
{
	$sql_extra="iusuariopublicofoto=".(int)$_SESSION["logged"]->id;
	if($_GET["id"]>0)
		$sql_extra.=" and icfotofoto=".(int)$_GET["id"];
}
else // las predeterminadas
{
	$sql_extra="iusuariopublicofoto=1";
}

$sql_mas="";

$items_por_pagina=20;
if($_GET["pagina"]==0) $items_por_pagina=2000;

$respuesta["fotos"]=fotos_lee(array("sql_extra"=>$sql_extra.$sql_mas,"campos"=>"archivofoto,activo","order"=>"activo desc,ordenfoto asc,fechafoto desc","numero_pagina"=>(int)$_GET["pagina"],"items_por_pagina"=>$items_por_pagina,"ajustaImagen"=>true));

header( 'Content-type: application/json' );
$tmp["meta"]=array("code"=>"200");
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

