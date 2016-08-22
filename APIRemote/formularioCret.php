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
}
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."API_formularios.php");

$respuesta["timeline"]=array();
include_once($API_folder."ret.php");
function formCret($registro,$operacion,$modo)
{
	global $tipopreTemporal;
	global $idioma;
	global $idiomas;
	global $dosIdiomas;
	$formulario=array();
	if($idioma==0)
	{
		$bots=array("Solicitar número entero","Solicitar número con punto decimal","Solicitar texto (max 100 letras)","Solicitar opciones");
	}
	else
	{
		$bots=array("Request INT number","Request float number","Request text (max 100 letters)","Request options");
	}
	if($operacion=="agregar") $titulo=$bots[$modo-1];
	else $titulo=$bots[$registro[0]->tipocret-1];
	$formulario[]=array("tipotimeline"=>"titulo","titulo"=>$titulo,"botonVerMas"=>"","abrirSeccion"=>"");

	// general
	$formulario[]=formCampoTextoMemo("texto","labelcret",$registro,$operacion,"Etiqueta",3,50,true,"");	
	if($dosIdiomas)
		$formulario[]=formCampoTextoMemo("texto","i_labelcret",$registro,$operacion,"Etiqueta en inglés",0,50,false,"");	
	
	if($modo==1 || $modo==2 || $registro[0]->tipocret==1 || $registro[0]->tipocret==2)
	{
		$formulario[]=array("tipotimeline"=>"break");
		$formulario[]=formCampoTextoMemo("int","mincret",$registro,$operacion,"Mínimo",0,50000,true,0);	
		$formulario[]=formCampoTextoMemo("int","maxcret",$registro,$operacion,"Máximo",0,50000,true,0);
	}
	
	$formulario[]=array("tipotimeline"=>"break");	
	$opciones=array();
	$opciones[]=array("label"=>"No","valor"=>"0");
	$opciones[]=array("label"=>"Si","valor"=>"1");
	$formulario[]=formCampoSelector("segmented","reqcret",$registro,$operacion,"¿Es requerido?","0",$opciones,true);	
	
	if($modo==4 || $registro[0]->tipocret==4)
	{
		$formulario[]=array("tipotimeline"=>"break");	
		$formulario[]=formCampoTextoMemo("memo","opcionescret",$registro,$operacion,"Opciones",1,255,true,"");	
		if($dosIdiomas)
			$formulario[]=formCampoTextoMemo("memo","i_opcionescret",$registro,$operacion,"Opciones en inglés",1,255,true,"");	
	}
	
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

if($_SESSION["firmado"] && $_SESSION["logged"]->cms==1)
{
	if(!checaUsuarioActivo()) exit();
	$sql_extra_restriccion=" id=".(int)$_GET["id"];
	
	if($_GET["accion"]=="guardar") // vamos a guardar
	{	
		$formGuardar->error=tokRevisa($_POST["toks"]);
		
		if($formGuardar->error=="")
			$formGuardar=evaluaFormulario(formCret(NULL,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),mysqli_real_escape_stringMemo($_GET["modo"])));	
		
		if($formGuardar->error=="")
		{
			$sql="";
			if($_GET["operacion"]=="editar")  // vamos a editar
				$sql="update cret set ".$formGuardar->cadena." where ".$sql_extra_restriccion." limit 1";
			else if($_GET["operacion"]=="agregar")  // vamos a editar
			{
				$sql="insert into cret set ".$formGuardar->cadena.",iretcret=".(int)$_GET["id"].",tipocret='".mysqli_real_escape_stringMemo($_GET["modo"])."'";	
				//echo $sql;
			}
			if($sql<>"") // tengo sql, procesar
			{
				if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
				{
					tokBorra($_POST["toks"]); // borra el tok
					if($idioma==0) $respuesta["mensaje"]="Registro guardado.";
					else $respuesta["mensaje"]="Information saved";
					$respuesta["diccionario"]->modo="refrescar";
				}
				else // ocurrio un error al guardar
				{
					$formGuardar->error="ERROR. Ocurrió un error al guardar el registro ";
				}
			}
			else $formGuardar->error="ERROR Ocurrió un error al crear el registro ";
		}
	}
	else
	{
		if($_GET["operacion"]=="editar") // buscamos el registro
			$registro=cret_lee(array("sincroniza"=>"si","sql_extra"=>$sql_extra_restriccion));
			
		if($_GET["operacion"]=="agregar" || ($_GET["operacion"]=="editar" && sizeof($registro)>0)) // si estoy editando muestro solo si lo encontré
		{
			$respuesta["timeline"]=array_merge($respuesta["timeline"],formCret($registro,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),mysqli_real_escape_stringMemo($_GET["modo"])));
			if($_GET["accion"]<>"guardar")
				$respuesta["timeline"][]=tokGenera("cret",7,$registro);
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

