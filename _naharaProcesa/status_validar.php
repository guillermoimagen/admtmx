<?php
$modo=$_POST["modo"];
$nombrecampostatus="istatuspagopfactura";
 header('Content-Type:text/html; charset=ISO-8859-1');
if($modo=="ajax")
{
	include("recursos/entrada.php"); 
	include("recursos/xss_var.php");
    include("recursos/inicializasesion.php");
	include("../include/connection.php"); 
	
	$numero_campos=$_POST["longitudFormulario"];
	
	$numerodetabla=$_POST["tabla"];
	$id=$_POST["id"];
	$perfil_usuario=",".$_SESSION["nivelusuario"].",";
	$statusnuevo=$_POST[$_POST["nombrecampostatus"]];
}
if($modo=="")
{
	$modo="vacio";
	$id=$_GET["id"];
	$perfil_usuario=",".$_SESSION["nivelusuario"].",";
	$statusnuevo=$_POST[$nombrecampostatus];
}
$mensaje="";
$campos_mensaje="";
$i=0;$j=0;
$campos="";

// lee nombre de la tabla
$resulty=mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$numerodetabla."");
$rowy=mysqli_fetch_array($resulty);

// lee el campo del status de la tabla original
$resultx=mysqli_query($GLOBALS["enlaceDB"] ,"select ".$nombrecampostatus." from ".$rowy["ayudatabla"]." where id=".$id."");
$rowx=mysqli_fetch_array($resultx);
$statusoriginal=",".$rowx[$nombrecampostatus].",";

// consulta las reglas del nuevo status
$resultz=mysqli_query($GLOBALS["enlaceDB"] ,"select nombrestatus,statusorigenstatus,reglaslocalesstatus,perfilesstatus,reglasforaneasstatus,requeridosstatus,norequeridosstatus from status where id=".$statusnuevo."");
$rowz=mysqli_fetch_array($resultz);

if($rowx[$nombrecampostatus]<>$statusnuevo and $rowz["perfilesstatus"]<>"")
{
	if((strpos($rowz["perfilesstatus"],$perfil_usuario))===false) 
		$mensaje.="<li>Lo sentimos pero no tiene permisos para modificar el status del registro.";
	
	if($mensaje=="")
	{
		if($rowz["statusorigenstatus"]<>"")
			if((strpos($rowz["statusorigenstatus"],$statusoriginal))===false)
				$mensaje.="<li>Lo sentimos pero no puede cambiar a ".$nombrestatus." porque debe pasar por otros status previamente.";
				
		if($rowz["reglasforaneasstatus"]<>"")
			eval($rowz["reglasforaneasstatus"]);
		
		if($rowz["requeridosstatus"]<>"")
		{
			$j=0;
			$array_campos=explode(",",$rowz["requeridosstatus"]);
			for($i=0;$i<=count($array_campos);$i++)
			{
				$campo=$array_campos[$i];
				if(!empty($campo))
				{	
					if($_POST[$campo]=="")
					{
						$campos_mensaje.="t_".$campo.",";
						$j++;
					}
				}
			}
			if($j>0) 
				$mensaje.="<li>Falta información en ciertos campos";			
		}
		
		
		if($rowz["norequeridosstatus"]<>"")
		{
			$j=0;
			$array_campos=explode(",",$rowz["norequeridosstatus"]);
			for($i=0;$i<=count($array_campos);$i++)
			{
				$campo=$array_campos[$i];
				if(!empty($campo))
				{	
					if($_POST[$campo]<>"")
					{
						$campos_mensaje.="t_".$campo.",";
						$j++;
					}
				}
			}
			if($j>0) 
				$mensaje.="<li>Sobra información en ciertos campos";			
		}
						
		if($rowz["reglaslocalesstatus"]<>"")
			eval($rowz["reglaslocalesstatus"]);
	}
}



if($mensaje<>"")
{
	if($modo=="ajax")
	{	
		if($mensaje<>"")
		{
			echo($mensaje);
			if($campos_mensaje<>"") echo("ERRORSINES ".$campos_mensaje);
		}	
	}
		$modomensaje="ERROR";
		$step="modify";  
		$operacion="";
}
?>