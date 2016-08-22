<?
include("../include/connection.php");
include("../API/funciones_API.php");
include("../API/funcionesWeb_API.php");

if($_GET["operacion"]=="validar") $status='1';
else $status='2';

if($_GET["cadena"]<>"")
{
	$sql="update com set statuscom='".$status."',cadenacom='' where id=".(int)$_GET["id"]." and cadenacom='".mysqli_real_escape_stringMemo($_GET["cadena"])."' limit 1";
	if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
	{
		if($_GET["operacion"]=="validar") 
		{
			$status=' validado';
			hacebit(5,5,(int)$_GET["id"]);
		}
		else 
		{
			$status=' eliminado';
			hacebit(6,5,(int)$_GET["id"]);
		}
		echo "Comentario ".$status;
	}
	else echo "Ocurrio un error";
}
else echo "Ocurrio un error";
?>