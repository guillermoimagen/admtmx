<?php

if($esWeb<>1)
{
	session_start();
	$API_folder="../API/";
	include_once '../API/funciones_API.php';
	include_once '../include/connection.php';
	include_once '../include/funciones.php';
	if($_SESSION["webInterno"]<>1)
	{
		include("sauth.digest.php");
		include 'Sauth.class.php';
		include 'sauth.validatoken.php';
	}
	include_once 'subirFotoFunciones.php';
}
else include_once 'APIRemote/subirFotoFunciones.php';
// vamos a subir la foto
if($_SESSION["firmado"])
{
	if($_GET["modohtml"]=="si")
	{
		$stringToPass=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["stringToPass"]);
		$stringToPass1=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["stringToPass1"]);
		$stringToPass2=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["stringToPass2"]);
		$error					= false;

		$absolutedir			= dirname(__FILE__);
		$dir					= '/tmp/';
		$serverdir				= $absolutedir.$dir;
		
		$tmp2					= explode(',',$_POST['data']);
		$tmp2[1] = str_replace(' ', '+', $tmp2[1]);
		$htmlImagen 				= base64_decode($tmp2[1]);

		$nombre=$_POST['name'];
		$nombre = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $nombre);
		$nombre = mb_ereg_replace("([\.]{2,})", '', $nombre);
		$extension				= strtolower(end(explode('.',$nombre)));
		$htmlName				= substr($nombre,0,-(strlen($extension) + 1)).'.'.$extension;
		
		$master=$_SESSION["logged"]->id;
	}
	else 
	{
		$master=0;
		$stringToPass=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["stringToPass"]);
		$stringToPass1=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["stringToPass1"]);
		$stringToPass2=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["stringToPass2"]);
	}
	$resultado=subeFotoMaster((int)$stringToPass,(int)$stringToPass1,(int)$stringToPass2,$master,false);
	if($resultado->error=="")
	{
		$meta -> code = 400;
		$meta -> mensaje = "Imagen guardada";
		$respuesta["imagen"]=$resultado;
	}
	else
	{
		$meta -> code = 400;
		$meta -> mensaje = $resultado->error;
	}
}
else
{
	$meta -> code = 101;
	$meta -> mensaje = "Debes estar firmado para realizar esta operación"; 
}

if($esWeb<>1)
{
	$tmp["meta"]=$meta;
	$tmp['response'] = $respuesta;
	echo json_encode($tmp);
}
?>