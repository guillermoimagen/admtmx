<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";

include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."don.php");
$donadoresArreglo=don_lee_especial(array("grafico"=>"iniciativa","idiniciativa"=>(int)$_GET["idiniciativa"],"limite"=>"6000"));
$vistaDonadores="";
if(sizeof($donadoresArreglo)>0)
{
	$vistaDonadores=abre_plantilla_API("vistaDonadores",$false);
	$vistaDonadores=generaVistaRecursiva($vistaDonadores,$donadoresArreglo);
}		
echo $vistaDonadores;




?>