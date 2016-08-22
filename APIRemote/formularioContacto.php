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
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");

include_once($API_folder."API_formularios.php");

$respuesta["timeline"]=array();
function formContacto($registro,$operacion,$modo)
{
	global $idioma;
	global $idiomas;
	
	$formulario=array();
	$titulo=mensajeIdioma("contacto");
	$formulario[]=array("tipotimeline"=>"titulo","titulo"=>$titulo,"botonVerMas"=>"","abrirSeccion"=>"");
	
	$formulario[]=formSubtitulo("contacto");
	
	// general
	if($_SESSION["firmado"])
	{
		$resTempoUsuario=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario from usuarios where id=".(int)$_SESSION["logged"]->id);
		while($rowTempoUsuario=mysqli_fetch_object($resTempoUsuario))
		{
			$registro[0]->emailcontacto=$rowTempoUsuario->emailusuario;
			$registro[0]->nombrecontacto=utf8_encode(htmlentitiesMemo($rowTempoUsuario->nombreusuario));
	
		}
	}
	$formulario[]=array("tipotimeline"=>"break");
	$formulario[]=formCampoTextoMemo("texto","nombrecontacto",$registro,"editar","Nombre",1,50,true,"");	
	$formulario[]=formCampoTextoMemo("texto","emailcontacto",$registro,"editar","Email",0,100,true,"");	
	$formulario[]=formCampoTextoMemo("texto","telefonocontacto",$registro,$operacion,"Teléfono",0,30,false,"");	
	$formulario[]=formCampoTextoMemo("memo","mensajecontacto",$registro,$operacion,"Comentario",10,255,true,"");
	
	$formulario[]=array("tipotimeline"=>"break");
	$elemento->tipotimeline="boton";
	$elemento->tipoBoton="guardarForm";
	$elemento->texto=utf8_encode($idiomas["Guardar"]);
	$formulario[]=$elemento;
			
	return $formulario;	
}
$meta=array("code"=>"200");

revisaGets();

if($_GET["accion"]=="guardar") // vamos a guardar
{				
	$formGuardar->error=tokRevisa($_POST["toks"]);
		
	if($formGuardar->error=="")
		$formGuardar=evaluaFormulario(formContacto(NULL,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));		
	
	if($formGuardar->error=="")
	{
		if($_GET["operacion"]=="agregar") // vamos a agregar
		{		
			$sql="insert into contacto set ".$formGuardar->cadena;
		}
		
		if($sql<>"") // tengo sql, procesar
		{
			if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
			{
				$idnueva=mysqli_insert_id($GLOBALS["enlaceDB"] );
				$respuesta["mensaje"]=mensajeIdioma("contactoGuardado");
				$respuesta["operacionVentana"]="cerrarVentana";
				
					
				$contacto=@mysqli_query($GLOBALS["enlaceDB"] ,"select * from contacto where id=".$idnueva);
				while($rowContacto=mysqli_fetch_object($contacto))
				{
					foreach( $rowContacto as $key => $value )
			 			$rowContacto -> $key = htmlentitiesMemo($value); 
			 
					require_once($API_folder."lib/common.inc.php");
					$args = new stdClass();
					$args->template = "../APIPlantillas/mailing/contacto.php";
					$args->data = new stdClass();
					$args->data->nombrecontacto=utf8_encode($rowContacto->nombrecontacto);
					$args->data->emailcontacto=utf8_encode($rowContacto->emailcontacto);
					$args->replyTo=utf8_encode($rowContacto->emailcontacto);
					$args->data->telefonocontacto=utf8_encode($rowContacto->telefonocontacto);
					$args->data->mensajecontacto=utf8_encode($rowContacto->mensajecontacto);
					
					$envios=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailenvio from envios where activo=1");
					while($rowEnvios=mysqli_fetch_object($envios))
					{
						Mailer::sendEmail($rowEnvios->emailenvio, "Contacto ADT", $args);
					}
				}
				tokBorra($_POST["toks"]); // borra el tok
			}
			else $formGuardar->error=mensajeIdioma("02001");
			
		}
		else $formGuardar->error=mensajeIdioma("02001");
	}
}
else
{
	if($_GET["operacion"]=="agregar") // si estoy editando muestro solo si lo encontré
	{
		$respuesta["timeline"]=array_merge($respuesta["timeline"],formContacto($registro,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));
		if($_GET["accion"]<>"guardar")
				$respuesta["timeline"][]=tokGenera("contacto",37,$registro);
	}
}
	

if($formGuardar->error<>"")
		$meta=array("code"=>"200","mensaje"=>$formGuardar->error,"mensajeMostrar"=>"alert");
		
header( 'Content-type: application/json' );
$tmp["meta"]=$meta;
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

