<?
include("../recursos/entrada.php");
include("../recursos/xss_var.php");
include("../../include/connection.php");

if($_GET["modo"]=="pais")
{
	$estados=@mysqli_query($GLOBALS["enlaceDB"] ,"select id as valor,nombreestado as label from estados where ipaisestado=".(int)$_GET["idregistro"]." and activo=1 order by nombreestado asc");
	$estadosPasar=array();
	while($row=mysqli_fetch_object($estados))
	{
		$estadosPasar[]=array("valor"=>$row->valor,"label"=>utf8_encode($row->label));
	}
	$respuesta["estados"]=$estadosPasar;
	header( 'Content-type: application/json' );
	$tmp["meta"]=array("code"=>"200");
	$tmp['response'] = $respuesta;
	print_r(json_encode($tmp));
}
else if($_GET["modo"]=="buscar")
{
	$resultadosG=array();
	
	if($_GET["extra"]<>"usuarios")
	{
		$resultadosG[]=array("id"=>"I".$rowU->valor,"label"=>"Solo de iniciativas","label"=>"Solo de iniciativas");
		$resultadosG[]=array("id"=>"U".$rowU->valor,"label"=>"Solo de alcancías","label"=>"Solo de alcancías");
		$resultadosG[]=array("id"=>"D".$rowU->valor,"label"=>"Directos a FT","label"=>"Directos");
	}
	$resultados=array();
	$ret=@mysqli_query($GLOBALS["enlaceDB"] ,"select id as valor,nombreret as label from ret where nombreret like '%".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["term"])."%' limit 0,10");
	while($row=mysqli_fetch_object($ret))
	{
		$resultados[]=array("id"=>"I-".$row->valor,"label"=>"(I) ".utf8_encode($row->label),"label"=>"(I) ".utf8_encode($row->label));
	}
	
	$resultadosU=array();
	$usuarios=@mysqli_query($GLOBALS["enlaceDB"] ,"select id as valor,concat(nickusuario,' (',nombreusuario,')') as label from usuarios where nombreusuario like '%".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["term"])."%' or nickusuario like '%".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["term"])."%' limit 0,10");
	while($rowU=mysqli_fetch_object($usuarios))
	{
		$resultadosU[]=array("id"=>"U-".$rowU->valor,"label"=>"(A) ".utf8_encode($row->label),"label"=>"(A) ".utf8_encode($rowU->label));
	}
	$resultadosFinal=array_merge($resultadosG,$resultados,$resultadosU);
	header( 'Content-type: application/json' );
	print_r(json_encode($resultadosFinal));
}


?>