<?
include("../include/connection.php");
include("../API/funcionesWeb_API.php");
include("../API/cat.php");

$estados=@mysqli_query($GLOBALS["enlaceDB"] ,"select id as valor,nombreestado as label from estados where ipaisestado=1 and activo=1 order by nombreestado asc");
$estadosPasar=array();
while($row=mysqli_fetch_object($estados))
{
	$estadosPasar[]=array("valor"=>$row->valor,"label"=>utf8_encode($row->label));
}
$respuesta["estados"]=$estadosPasar;

$status=array();
if($idioma==0)
{
	$status[]=array("valor"=>"destacada","label"=>"Destacadas");
	$status[]=array("valor"=>"disponible","label"=>"Recompensas disponibles");
	$status[]=array("valor"=>"vigente","label"=>"Vigente");
	$status[]=array("valor"=>"validada","label"=>"Todas");
	if($_SESSION["logged"]->cms==1)
	{
		$status[]=array("valor"=>"pendiente","label"=>"Pendiente");
		$status[]=array("valor"=>"rechazada","label"=>"Rechazada");
		$status[]=array("valor"=>"noiniciada","label"=>"No iniciada");
	}
}
else 
{
	$status[]=array("valor"=>"destacada","label"=>"Recommended");
	$status[]=array("valor"=>"disponible","label"=>"Awards available");

	$status[]=array("valor"=>"vigente","label"=>"Active");
	$status[]=array("valor"=>"validada","label"=>"All");
	if($_SESSION["logged"]->cms==1)
	{
		$status[]=array("valor"=>"pendiente","label"=>"Pending");
		$status[]=array("valor"=>"rechazada","label"=>"Rejected");
		$status[]=array("valor"=>"noiniciada","label"=>"Not started");
	}
}	
$respuesta["status"]=$status;

$categorias=cat_lee("todas");
$categoriasPasar=array();
for($i=0; $i<=sizeof($categorias)-1; $i++)
{
	$categoriasPasar[]=array("valor"=>$categorias[$i]->idreal,"label"=>utf8_encode($categorias[$i]->nombrecat));	
}
$respuesta["categorias"]=$categoriasPasar;

header( 'Content-type: application/json' );
$tmp["meta"]=array("code"=>"200");
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>