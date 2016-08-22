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

$respuesta["timeline"]=array();
if(isset($_SESSION["logged"]->id) && $_SESSION["logged"]->id<>0) // esta firmado
	$respuesta["timeline"][]=array("tipotimeline"=>"subirFoto","tablafoto"=>(int)$_GET["tablafoto"],"idregistrofoto"=>(int)$_GET["idregistrofoto"],"cfoto"=>(int)$_GET["cfoto"]);
header( 'Content-type: application/json' );
$tmp["meta"]=array("code"=>"200");
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

