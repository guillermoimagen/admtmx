<?
$API_folder="../API/";
include("../include/connection.php");
include("../include/funciones.php");
include($API_folder."funciones_API.php");
include($API_folder."funcionesWeb_API.php");

$code=200;
$mensaje="";
if($_SESSION["firmado"])
{
	
	if($_GET["operacion"]=="gusta")
	{
		if(!checaUsuarioActivo()) exit();
		$idregistro=(int)$_GET["idregistro"];
		if($_GET["valor"]==0) // borraremos
		{
			@mysqli_query($GLOBALS["enlaceDB"] ,"delete from gus where iretgus=".$idregistro." and iusuariogus=".(int)$_SESSION["logged"]->id." limit 1");
		}
		else
		{
			@mysqli_query($GLOBALS["enlaceDB"] ,"insert into gus set iretgus=".$idregistro.", iusuariogus=".(int)$_SESSION["logged"]->id);
		}
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select count(id) from gus where iretgus=".$idregistro);
		while($row=mysqli_fetch_array($res))
			@mysqli_query($GLOBALS["enlaceDB"] ,"update ret set tgustaret=".$row[0]." where id=".$idregistro." limit 1");
	}
	else if($_GET["operacion"]=="validarComentario" && $_SESSION["logged"]->cms==1)
	{
		if($_GET["operacionReal"]=="validar") $status='1';
		else $status='2';
		
		$sql="update com set statuscom='".$status."',cadenacom='' where id=".(int)$_GET["idregistro"]." limit 1";
		if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
		{
			if($_GET["operacionReal"]=="validar") 
			{
				$status=' validado';
				hacebit(5,5,(int)$_GET["idregistro"]);
			}
			else 
			{
				$status=' eliminado';
				hacebit(6,5,(int)$_GET["idregistro"]);
			}
			$respuesta["mensaje"]="Comentario ".$status;
		}	
	}
	else if($_GET["operacion"]=="comentario")
	{
		$sigue=true;
		 // revisa si hay actividad y si puede tener más actividad
		 $validar=checaUsuarioActividad();
		 if($validar=="") $sigue=true;
		 else
		 {
			 $sigue=false;
			 $respuesta["mensaje"]=mensajeIdioma($validar);
			 $respuesta["ok"]="0";
		 }
		
		$idregistro=(int)$_POST["idregistro"];
		$texto=utf8_decode(substr(mysqli_real_escape_stringMemo($_POST["texto"]),0,255));
		if($texto<>"")
		{
			
			$ahora=date("Y-m-d h:i:s");
			if($_SESSION["logged"]->cms==1) 
			{
				$cadena="";
				$status="1";
			}
			else
			{
				$status="0";
			}
			if($sigue)
			{
				if(@mysqli_query($GLOBALS["enlaceDB"] ,"insert into com set iretcom=".$idregistro.",iusuariocom=".(int)$_SESSION["logged"]->id.",textocom='".$texto."',statuscom='".$status."'"))
				{
					$idactual=mysqli_insert_id($GLOBALS["enlaceDB"] );
					hacebit(1,5,$idactual);
					if($_SESSION["logged"]->cms<>"1") 
					{
						
						$cadena=md5($idregistro." ".$texto." ".date("Y-m-d").$idactual."memomoemo");
						@mysqli_query($GLOBALS["enlaceDB"] ,"update com set cadenacom='".$cadena."' where id=".$idactual." limit 1");
						
						$subject="Validar comentario ADT";
						$url=$dominioSistema."APIRemote/validarComentario.php?id=".$idactual."&cadena=".$cadena."&operacion=";
						include_once($API_folder."social.php");
						$comLeido=com_lee_especial(array("grafico"=>"detalle","idreal"=>$idactual));
						
						// enviar mail aqui
						require_once($API_folder."lib/common.inc.php");
						$args = new stdClass();
						$args->template = "../APIPlantillas/mailing/validarComentario.php";
						$args->data = new stdClass();
						$args->data->mensaje="Texto: ".utf8_encode($comLeido[0]->textocom)."<br> <a href='".$url."validar'>Validar</a> | <a href='".$url."eliminar'>Eliminar</a>";
						$envios=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailenvio from envios where activo=1");
						while($rowEnvios=mysqli_fetch_object($envios))
							Mailer::sendEmail($rowEnvios->emailenvio, $subject, $args);
						
						actualizaUsuarioActividad();
					
					}
					$respuesta["mensaje"]=mensajeIdioma("comentarioagregado");
					$respuesta["ok"]="1";
				}
				else
				{
					$respuesta["mensaje"]=mensajeIdioma("comentarioerror");
					$respuesta["ok"]="0";
				}
			}
			
		}
	}
}
else
{
	$code=401;
	$error="Debes estar autenticado";
}


if($code==200)
	$meta=array("code"=>$code,"mensaje"=>$mensaje);
else
	$meta=array("code"=>$code,"mensaje"=>$error,"mensajeMostrar"=>"alert");


header( 'Content-type: application/json' );
$tmp["meta"]=$meta;
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

