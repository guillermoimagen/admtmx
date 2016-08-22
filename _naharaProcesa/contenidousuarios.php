<?php session_start(); include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("../include/connection.php"); ?>

<?

$id=$_GET["id"];
$modo=$_GET["modo"];
$sel1=$_GET["sel1"];
$sel2=$_GET["sel2"];
$sel3=$_GET["sel3"];
$sel4=$_GET["sel4"];
$arbol=$_GET["arbol"];
$step=$_GET["step"];

function leecamposcascada($tabla,$campo1,$campo2,$campo3,$campo4,$separador,$campocondicional,$valorcampocondicional,$campocondicional2,$id,$sel,$modo,$arbol,$archivo,$campobase)
{
    global $sel1;
	global $sel2;
	global $sel3;
	global $sel4;	
	global $step;
    
	$campostep="";
	if($step=="busqueda") $campostep="b2";
	
    $modox=$modo-1;
    echo("addListGroup(\"contenido".$archivo.".php?id=".$id."&modo=".$modox."&sel1=".$sel1."&sel2=".$sel2."&sel3=".$sel3."&sel4=".$sel4."&arbol=".$arbol."&step=".$step."\", \"c_".$campobase.$campostep."\");\n");
    echo("addOption(\"c_".$campobase.$campostep."\", \"Selecciona...\", \"0\");\n");
    $registros=0;
	$cadena="";
	if($campo1<>"") $cadena=$cadena.$campo1;
	if($campo2<>"") $cadena=$cadena.",".$campo2;
	if($campo3<>"") $cadena=$cadena.",".$campo3;
	if($campo4<>"") $cadena=$cadena.",".$campo4;
	
	$cadena2=$campo2;
	if($campo3<>"") $cadena2=$cadena2.",".$campo3;
	if($campo4<>"") $cadena2=$cadena2.",".$campo4;
	
	if($campocondicional<>"" && isset($campocondicional) )
      $result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where ".$campocondicional."=".$valorcampocondicional." and ".$campocondicional2."=".$id." and activo=1 order by ".$cadena2);
	else   
      $result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where ".$campocondicional2."=".$id." and activo=1 order by ".$cadena2);	  
	  
    while ( $row2 = mysqli_fetch_array($result2) )
    {	
	  $tempo=""; if($sel==$row2["id"]) $tempo=",1";
      echo("addList(\"c_".$campobase.$campostep."\", \"".addslashes($row2[$campo2]).$separador.addslashes($row2[$campo3]).$separador.addslashes($row2[$campo4])."\", \"".$row2["id"]."\", \"contenido".$archivo.".php?id=".$row2["id"]."&modo=".$modo."&sel1=".$sel1."&sel2=".$sel2."&sel3=".$sel3."&sel4=".$sel4."&arbol=".$arbol."&step=".$step."\"".$tempo.");\n");   
	}  
	echo("updateSubList(\"arbol".$arbol."\",\"contenido".$archivo.".php?id=".$id."&modo=".$modox."&sel1=".$sel1."&sel2=".$sel2."&sel3=".$sel3."&sel4=".$sel4."&arbol=".$arbol."&step=".$step."\");\n");
}
echo("<script language=\"javascript\" src=\"../include/dynamicpulldown/cscontrol.js\"></script>\n");
echo("<script language=\"javascript\">\n");
if($arbol==1 && $modo==2) leecamposcascada("estados","id","nombreestado","",""," ","","","ipaisestado",$id,$sel2,3,1,"usuarios","iestadousuario");
echo("</script>");

?>
