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
include_once($API_folder."API_formularios.php");

$respuesta["timeline"]=array();
include_once($API_folder."usuarios.php");
include_once($API_folder."generales.php");
function formUsuario($registro,$operacion,$modo)
{
	global $tipopreTemporal;
	global $idioma;
	global $idiomas;
	$formulario=array();
	
	$formulario[]=array("tipotimeline"=>"titulo","titulo"=>$registro[0]->nombreusuario,"botonVerMas"=>"","abrirSeccion"=>"");
	
	// general
	$formulario[]=formCampoTextoMemo("texto","nombreusuario",$registro,$operacion,"Nombre",5,50,true,"");	
	$formulario[]=formCampoTextoMemo("texto","nickusuario",$registro,$operacion,"Nick",4,40,true,"",false,"");	
	$formulario[]=formCampoTextoMemo("texto","emailusuario",$registro,$operacion,"Email",5,50,true,"",false,"email");	
	$formulario[]=formCampoFecha("nacimientousuario",$registro,$operacion,"Cumpleaños","1900-01-01","2018-12-31","");

	$formulario[]=array("tipotimeline"=>"break");	
	
	$formulario[]=formCampoImagef("imagenusuario",$registro,$operacion,"Imagen","",1,"usuarios",0,1);
	$formulario[]=array("tipotimeline"=>"break");

	// ubicacion
	$paises=pais_lee(array("order"=>"ordenpais,nombrepais asc","campos"=>"nombrepais as label,id as valor","sincroniza"=>"si"));
	array_unshift($paises,array("label"=>"...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","ipaisusuario",$registro,$operacion,"País","0",$paises,false,"estados.php?operacion=estados&idreal=","tab_iestadousuario_as");
	if($registro[0]->ipaisusuario>0)
	{
		$estados=estados_lee(array("sql_extra"=>"ipaisestado=".$registro[0]->ipaisusuario,"order"=>"nombreestado asc","campos"=>"nombreestado as label,id as valor","sincroniza"=>"si"));
	}
	else $estados=array();
	array_unshift($estados,array("label"=>"...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","iestadousuario",$registro,$operacion,"Estado","0",$estados,false);
		
	$formulario[]=array("tipotimeline"=>"break");
	$formulario[]=formCampoTextoMemo("texto","tel1usuario",$registro,$operacion,"Teléfono1",0,30,false,"");	
	$formulario[]=formCampoTextoMemo("texto","tel2usuario",$registro,$operacion,"Teléfono2",0,30,false,"");	

	$formulario[]=array("tipotimeline"=>"break");	
	$opciones=array();
	$opciones[]=array("label"=>"No","valor"=>"0");
	$opciones[]=array("label"=>"Si","valor"=>"1");
	$formulario[]=formCampoSelector("segmented","familiarteletonusuario",$registro,$operacion,"¿Es familiar de paciente teletón?","0",$opciones,true);			
	$crits=crits_lee(array("order"=>"nombrecrit asc","campos"=>"nombrecrit as label,id as valor","sincroniza"=>"si"));
	array_unshift($crits,array("label"=>"...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","icritusuario",$registro,$operacion,"¿En qué CRIT?","0",$crits,false);		
		
	$formulario[]=array("tipotimeline"=>"break");		
	$ent=ent_lee(array("order"=>"ordenent,comoent asc","campos"=>"i_comoent,comoent as label,id as valor","sincroniza"=>"si"));
	array_unshift($ent,array("label"=>"...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","ientusuario",$registro,$operacion,"¿Cómo se enteró de nosotros?","0",$ent,false);
	
	$formulario[]=array("tipotimeline"=>"break");	
	$por=por_lee(array("order"=>"porquepor asc","campos"=>"i_porquepor,porquepor as label,id as valor","sincroniza"=>"si"));
	array_unshift($por,array("label"=>"...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","ipor1usuario",$registro,$operacion,"¿Porqué nos apoya?","0",$por,false);
	$formulario[]=formCampoSelector("picker","ipor2usuario",$registro,$operacion,"¿Alguna otra razón?","0",$por,false);
	
	if($_SESSION["logged"]->cms==1 && $operacion=="editar")
		$formulario[]=formCampoTextoMemo("texto","urlusuario",$registro,$operacion,"URL",5,100,true,"");	
	
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

if($_SESSION["firmado"])
{
	if(!checaUsuarioActivo()) exit();
	if($_SESSION["logged"]->cms==1) $sql_extra_restriccion=" id=".(int)$_GET["idreal"];
	else $sql_extra_restriccion=" usuarios.activo=1 and id=".(int)$_SESSION["logged"]->id;
	
	if($_GET["accion"]=="guardar") // vamos a guardar
	{	
		$formGuardar->error=tokRevisa($_POST["toks"]);
		
		if($formGuardar->error=="")
			$formGuardar=evaluaFormulario(formUsuario(NULL,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));	
		
		if($formGuardar->error=="")
		{
			$sql="";
			if($_GET["operacion"]=="editar")  // vamos a editar
				$sql="update usuarios set ".$formGuardar->cadena." where ".$sql_extra_restriccion." limit 1";
				
			if($sql<>"") // tengo sql, procesar
			{
				if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
				{
					tokBorra($_POST["toks"]); // borra el tok
					$respuesta["mensaje"]=mensajeIdioma("usuarioGuardado");
					$respuesta["operacionVentana"]="refrescarVentana";
				}
				else // ocurrio un error al guardar
				{
					if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
					{
						if(strpos(mysqli_error($GLOBALS["enlaceDB"] ),"llaveusuarios")!==FALSE)
							$formGuardar->error=mensajeIdioma("04001");
						else if(strpos(mysqli_error($GLOBALS["enlaceDB"] ),"nickindice")!==FALSE)
							$formGuardar->error=mensajeIdioma("04043");
					
						
					}
					else $formGuardar->error=mensajeIdioma("02002");
				}
			}
			else $formGuardar->error=mensajeIdioma("02001");
		}
	}
	else
	{
		if($_GET["operacion"]=="editar") // buscamos el registro
			$registro=usuarios_lee(array("sincroniza"=>"si","sql_extra"=>$sql_extra_restriccion));
		if($_GET["operacion"]=="editar" && sizeof($registro)>0) // si estoy editando muestro solo si lo encontré
		{
			$respuesta["timeline"]=array_merge($respuesta["timeline"],formUsuario($registro,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));
			if($_GET["accion"]<>"guardar")
				$respuesta["timeline"][]=tokGenera("usuarios",1,$registro);
		}
	}
	
}
else
	$formGuardar->error=mensajeIdioma("permisoFormulario");
	
if($formGuardar->error<>"")
		$meta=array("code"=>"200","mensaje"=>$formGuardar->error,"mensajeMostrar"=>"alert");
		
header( 'Content-type: application/json' );
$tmp["meta"]=$meta;
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

