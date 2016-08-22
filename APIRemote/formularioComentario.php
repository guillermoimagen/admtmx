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
include_once($API_folder."API_formularios.php");
include_once($API_folder."funcionesWeb_API.php");

$respuesta["timeline"]=array();
include_once($API_folder."social.php");

function formComentario($registro,$operacion,$modo)
{
	global $tipopreTemporal;
	global $idiomas;
	$formulario=array();
	
	$formulario[]=array("tipotimeline"=>"titulo","titulo"=>"Editar comentario","botonVerMas"=>"","abrirSeccion"=>"");

	$formulario[]=formCampoTextoMemo("memo","textocom",$registro,$operacion,"Texto",1,255,false,"");

	$formulario[]=array("tipotimeline"=>"break");
	$elemento->tipotimeline="boton";
	$elemento->tipoBoton="guardarForm";
	$elemento->texto=utf8_encode($idiomas["Guardar"]);
	$formulario[]=$elemento;
	
	unset($elemento);
	$elemento->tipotimeline="generalSeparador";
	$elemento->altura="200";
	$formulario[]=$elemento;	
			
	return $formulario;	
}
$meta=array("code"=>"200");

revisaGets();

if($_SESSION["logged"]->cms==1)
{
	if(!checaUsuarioActivo()) exit();
	$sql_extra_restriccion="id=".(int)$_GET["idreal"];
	
	if($_GET["accion"]=="guardar") // vamos a guardar
	{	
		$formGuardar->error=tokRevisa($_POST["toks"]);
		
		if($formGuardar->error=="")
			$formGuardar=evaluaFormulario(formComentario(NULL,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));	
		
		if($formGuardar->error=="")
		{
			$sql="";
			if($_GET["operacion"]=="editar")  // vamos a editar
				$sql="update com set ".$formGuardar->cadena." where ".$sql_extra_restriccion." limit 1";

			if($sql<>"") // tengo sql, procesar
			{
				if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
				{
					tokBorra($_POST["toks"]); // borra el tok
					$respuesta["mensaje"]="Comentario guardado correctamente";
					$respuesta["operacionVentana"]="cerrarVentana";
					$respuesta["actualizarElemento"]="textocom_".(int)$_GET["idreal"];
					$respuesta["actualizarValor"]=htmlentitiesMemoStrong($_POST["tab_textocom_as"]);
				}
				else // ocurrio un error al guardar
				{
					$formGuardar->error="Ocurrió un error al guardar el registro ";
				}
			}
			else $formGuardar->error="Ocurrió un error al crear el registro ".$sql;
		}
	}
	else
	{
		if($_GET["operacion"]=="editar") // buscamos el registro
			$registro=com_lee_especial(array("sincroniza"=>"si","grafico"=>"detalle","idreal"=>(int)$_GET["idreal"]));

		if($_GET["operacion"]=="editar" && sizeof($registro)>0) // si estoy editando muestro solo si lo encontré
		{
			$respuesta["timeline"]=array_merge($respuesta["timeline"],formComentario($registro,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));
			if($_GET["accion"]<>"guardar")
				$respuesta["timeline"][]=tokGenera("com",5,$registro);
		}
	}
	
}
else
	$formGuardar->error="No tienes permiso para ver esto";
	
if($formGuardar->error<>"")
		$meta=array("code"=>"200","mensaje"=>$formGuardar->error,"mensajeMostrar"=>"alert");
		
header( 'Content-type: application/json' );
$tmp["meta"]=$meta;
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

