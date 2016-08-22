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
}
include_once($API_folder."pais.php");

$numero_pagina=1;
if(isset($_GET["pagina"])) $numero_pagina=(int)$_GET["pagina"];

$mensajeError="";
if($_GET["operacion"]=="estados")
{
	$idreal=(int)$_GET["idreal"];
	$devolver=estados_lee(array("sql_extra"=>"ipaisestado=".$idreal,"sincroniza"=>"si","campos"=>"nombreestado as texto"));
	$respuesta["arreglo"]=$devolver;
}
else if($_GET["operacion"]=="municipios")
{
	$idreal=(int)$_GET["idreal"];
	$devolver=municipios_lee(array("sincroniza"=>"si","sql_extra"=>"iestadomunicipio=".$idreal,"campos"=>"nombremunicipio as texto","order"=>"nombremunicipio asc","items_por_pagina"=>5000,"numero_pagina"=>$numero_pagina));
	$respuesta["arreglo"]=$devolver;
}
else if($_GET["operacion"]=="colonias")
{
	$idreal=(int)$_GET["idreal"];
	$devolver=colonias_lee(array("sincroniza"=>"si","sql_extra"=>"imunicipiocolonia=".$idreal,"campos"=>"nombrecolonia as texto","order"=>"nombrecolonia asc","items_por_pagina"=>5000,"numero_pagina"=>$numero_pagina));
	$respuesta["arreglo"]=$devolver;
}
if($mensajeError<>"")
	$meta=array("code"=>"200","mensaje"=>$mensajeError,"mensajeMostrar"=>"alert");
else 
	$meta=array("code"=>"200");

header( 'Content-type: application/json' );
$tmp["meta"]=$meta;
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

