<?php 
ini_set("session.use_only_cookies",1); 
session_start();/*para regenerar un session php id versiones < a php version 5.1	*/        
session_regenerate_id(true);	
include("../include/connection.php");
include("recursos/funciones.php"); 


if(isset($_GET["urlOrigen"]))
{
	if(strpos($_GET["urlOrigen"],"http")!==FALSE) exit();	
	else $urlOrigen=$_GET["urlOrigen"];
}
if(isset($_POST["urlOrigen"]))
{
	if(strpos($_POST["urlOrigen"],"http")!==FALSE) exit();
	else $urlOrigen=$_POST["urlOrigen"];	
}
?>
<html>
<head>
<title>SITIO ADMINISTRATIVO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="recursos/estilos.css" type="text/css">
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="recursos/md5.js"></script><!--funciones para encriptar--> 
</head>
<BODY topmargin=0 LEFTMARGIN=0 TOMPARGIN=0 >

<? 
$mensaje="";
if($step=="entra" ) 
{
	$allowed = array();
	switch ($_POST['form'])// este switch es para verificar que lo que se mande por el form  se solo lo permitido
	{
		case 'login':
		
		$allowed[] = 'form';
		$allowed[] = 'urlOrigen';
		$allowed[] = 'username';
		$allowed[] = 'password';
		$allowed[] = 'g-recaptcha-response';
		$allowed[] = 'Submit';
		$sent = array_keys($_POST);
	}//seguridad */

	if (isset($_POST["g-recaptcha-response"]) && $allowed == $sent)//condicional de seguridad ayuda a verificar que los campos enviados en el form sean los permitidos
	{	 
		require_once '../include/recaptcha/src/autoload.php';
		$secret="6LfiKyYTAAAAAMdeWIEb66T45feJkxTN_A6CMRGU";
		$recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());
		$result2 = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		if (!$result2->isSuccess())
		{ 
			$mensaje=$entradamensajeerror."Error de robots".$salidamensaje;
			$step=1;
		}
		else
		{
			
			$arregloform=array();	
			$arregloform['username']=$_POST['username'];//se igualan los valores que vienen del post para trabajar con variables limpias(nunca se debe confiar en las variables globales POST y GET)
		
			$arregloform['password']=mysqli_real_escape_string2Memo($_POST['password']);	
		   	if(!isset($_SESSION['sesionusername']))// si la variable de session no esta declarada
		   	{
				$arregloform['username']=addslashes($arregloform['username']); //escapa caracteres del campo que viene del form 
				$result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * from causuarios where usernameusuario='".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$arregloform['username'])."' and activo=1");
	
				while ( $row = mysqli_fetch_array($result) )
				{
		
					if($arregloform['password']==$row["passwordusuario"]) 
					{
					
						$num_rows=1;
						$tnombreusuario=$row["nombreusuario"];
						$tusernameusuario=$row["usernameusuario"];
						$tnombreusuario=$row["nombreusuario"];
						$tsuperusuario=$row["superusuario"];
						$tnivelusuario=$row["nivelusuarioreal"];
						$tid=$row["id"];
					}	
				}
		 
				if($num_rows>=1)
				{     
					if (getenv(HTTP_X_FORWARDED_FOR)) { 
						$ipaddress = getenv('HTTP_X_FORWARD_FOR');      
					} else { 
						$ipaddress = getenv('REMOTE_ADDR');     
					} 
	
					$_SESSION["sitioactual"]="UEXPLORE_CITY";	
					$_SESSION["sesionusername"] = $tusernameusuario;  
					
					$_SESSION["sesionnombre"] = $tnombreusuario; 
					
					$_SESSION["nivelusuario"] = $tnivelusuario;
					
					if($tusernameusuario=="guisil") $_SESSION["nivelusuario"]=10;
					$_SESSION["sesionprivilegiosespecialesusuario"]=$tprivilegiosespecialesusuario;
					$_SESSION["sesionid"] = $tid;    
					$_SESSION["admin"] = "si"; 
					$_SESSION["sesionhits"]=0;
					$_SESSION["sesionfechaentrada"]=date("Y-m-d"); 
					$_SESSION["sesionhoraentrada"]=date("H:i");
					$_SESSION["sesiondireccionip"]=$ipaddress;
					
					$sqltemporal= "idusuarioacceso=".$_SESSION["sesionid"].",
								 ipaddressacceso='".$_SESSION["sesiondireccionip"]."',
								 fechaacceso='".$_SESSION["sesionfechaentrada"]."',
								 horaacceso='".$_SESSION["sesionhoraentrada"]."',
								 fechasalidaacceso='',horasalidaacceso=''";
								 
					@mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caaccesos SET " .$sqltemporal); 
					$_SESSION["sesionidregistro"] = mysqli_insert_id($GLOBALS["enlaceDB"] ); 	
					
					$ultimafechaentrada=date("Y-m-d"); 
					$ultimahoraentrada=date("H:i");
		  			$encabezadousuario2="<a href='cambiousuarios.php?step=modify' title='cambiar contrase�a' class='botoncontrasena'></a>";
					$encabezadousuario2.="<a href='manejadorlogout.php' title='salir' class='botonsalir'></a><br>
	  <b>Usuario:</b> ".$_SESSION["sesionnombre"]."&nbsp;<b>".$_SESSION["nombreciudad"]."</b><br>".$_SESSION["sesiondireccionip"]."&nbsp;&nbsp;<b>Consultas: </b>".$_SESSION["sesionhits"]."";
					 $encabezadousuario="";	
					 
					 if(isset($urlOrigen) && $urlOrigen<>"")
					 {
						?>
                        <script>window.location="<?=$urlOrigen?>";</script>
                        <? 
					 }
					 else
					 {
						include("recursos/cabeza.inc");
						include("menu.php");include("menu2.php");
						if($_SESSION["nivelusuario"]==0){ include("reporte.php");
					}
				}
		 
	
			}
			else
			{	
		  		$mensaje=$entradamensajeerror."No encontramos tu registro, intenta otra vez".$salidamensaje;
		  		$step=1;
			}
	   	}
	}
	 
}
else if(isset($_SESSION['sesionusername']))
{
	include("recursos/inicializasesion.php");
	$ultimafechaentrada=date("Y-m-d"); 
	$ultimahoraentrada=date("H:i");
	$colorencabezado="EAEDF4";
	$encabezadousuario2="<a href='cambiousuarios.php?step=modify' title='cambiar contrase�a' class='botoncontrasena'></a>";  
	 $encabezadousuario2.="<a href='manejadorlogout.php' title='salir' class='botonsalir'></a><br>
	<b>Usuario:</b> ".$_SESSION["sesionnombre"]."&nbsp;<b>".$_SESSION["nombreciudad"]."</b><br>".$_SESSION["sesiondireccionip"]."&nbsp;&nbsp;<b>Consultas: </b>".$_SESSION["sesionhits"]."";
	 $encabezadousuario="";	
	include("recursos/cabeza.inc");
	include("menu.php");
	include("menu2.php");
	
	 
	session_write_close();  
}
   else
  {
    $mensaje=$entradamensajeerror."No encontramos tu registro, intenta otra vez".$salidamensaje;
	$step=1;	
  }	


}  //termina if de step=entra 
?>
<?
if($step==1) 
{ 
  echo("<br>");

  include("recursos/cabeza.inc");
?>
<?=$mensaje?>
<div style="margin-top:30px;  display: table; margin: 0 auto;width:400px; padding:20px; background-color:#<?=$vsitioscolor6?>;" class="textogeneral">
<form name="form1" method="post" action="manejadorlogin.php?step=entra">
<input type="hidden" name="form" value="login" /><!-- seguridad-->
<input type="hidden" name="urlOrigen" value="<?=$urlOrigen?>" /><!-- seguridad-->
Nombre de usuario:<br><br><input type="text" name="username" class="textogeneral" value=""><br><br>
Password:<br><br><input type="password" name="password" class="textogeneral" value=""><br><br>
<div class="g-recaptcha" data-sitekey="6LfiKyYTAAAAAASsTslFRmj5vGNEZd5bhSCEif0x"></div><br>
<input type="submit" name="Submit" value="Entrar" onClick="password.value = hex_md5(password.value)" class=textogeneral>
</form>
</div>         

<? } ?>
</body>
