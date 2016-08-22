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
include_once($API_folder."rep.php");
function formRep($registro,$operacion,$modo)
{
	global $idioma;
	global $idiomas;
	
	$formulario=array();
	if($operacion=="agregar") $titulo=$idiomas["Reporte"];
	else $titulo="Editar reporte";
	$formulario[]=array("tipotimeline"=>"titulo","titulo"=>$titulo,"botonVerMas"=>"","abrirSeccion"=>"");
	
	
	// general
	$formulario[]=array("tipotimeline"=>"break");
	$mot=mot_formulario_lee();
	array_unshift($mot,array("label"=>"...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","imotrep",$registro,$operacion,"Motivo","0",$mot,true);

	$formulario[]=formCampoTextoMemo("memo","textorep",$registro,$operacion,"Más información",0,100,false,"");	
	
	
	if($_SESSION["logged"]->cms==1)
	{
		$formulario[]=array("tipotimeline"=>"break");
		$opciones=array();
		$opciones[]=array("label"=>"Pendiente","valor"=>"0");
		$opciones[]=array("label"=>"Validado","valor"=>"1");
		$opciones[]=array("label"=>"Eliminar o inactivar","valor"=>"2");
		$formulario[]=formCampoSelector("segmented","statusrep",$registro,$operacion,"Status ¿Qúe debo hacer con el registro reportado?","0",$opciones,true);
			
		$formulario[]=array("tipotimeline"=>"html","html"=>"<br clear='all'><div style='clear=both'>".$registro[0]->fecharep."</div>","botonVerMas"=>"","abrirSeccion"=>"");
	}
	
	$formulario[]=array("tipotimeline"=>"break");
	$elemento->tipotimeline="boton";
	$elemento->tipoBoton="guardarForm";
	$elemento->texto=utf8_encode($idiomas["Guardar"]);
	$formulario[]=$elemento;
			
	return $formulario;	
}
$meta=array("code"=>"200");
revisaGets();
$validarActividad=checaUsuarioActividad();

if($validarActividad<>"")
	$formGuardar->error=mensajeIdioma($validarActividad);
else if($_SESSION["firmado"])
{	
	

	if($_GET["accion"]=="guardar") // vamos a guardar
	{	
		$formGuardar->error=tokRevisa($_POST["toks"]);
		
		if($formGuardar->error=="")
			$formGuardar=evaluaFormulario(formRep(NULL,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));		
		
		if($formGuardar->error=="")
		{
			if($_SESSION["firmado"]) $iusuariorep=$_SESSION["logged"]->id;
			else $iusuariorep=0;
			
			$iretrep=0;
			$iusuarioreportadorep=0;
			if(isset($_GET["idiniciativa"])) $iretrep=(int)$_GET["idiniciativa"];
			else if(isset($_GET["idusuario"])) $iusuarioreportadorep=(int)$_GET["idusuario"];
				
			$sql="";
			if($_GET["operacion"]=="editar" && $_SESSION["logged"]->cms==1)  // vamos a editar
			{
				$nuevoStatus=(int)$_POST["tab_statusrep_as"];
				$sql="update rep set ".$formGuardar->cadena." where id=".(int)$_GET["idreal"]." limit 1";				
			}
			else if($_GET["operacion"]=="agregar") // vamos a agregar
			{		
				$sql="insert into rep set ".$formGuardar->cadena.",iusuariorep=".$iusuariorep.",iretrep=".$iretrep.",iusuarioreportadorep=".$iusuarioreportadorep;
			}
			
			// echo $sql;
			$todobien=false;
			$enviarmail=false;
			if($sql<>"") // tengo sql, procesar
			{
				if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
				{
					
					actualizaUsuarioActividad();
					$idnueva=mysqli_insert_id($GLOBALS["enlaceDB"] );
					$todobien=true;
					if($_GET["operacion"]=="editar")
					{
						if($nuevoStatus==2) // se ha rechazado, entonces vamos a cambiar las cosas
						{
							hacebit(8,34,(int)$_GET["idreal"]);
							$r=@mysqli_query($GLOBALS["enlaceDB"] ,"select iretrep,iusuarioreportadorep from rep where id=".(int)$_GET["idreal"]);
							while($rr=mysqli_fetch_object($r))
							{
								if($rr->iretrep<>0)
								{
									@mysqli_query($GLOBALS["enlaceDB"] ,"update ret set statusret=2 where id=".$rr->iretrep." limit 1");	
								}
								else
								{
									@mysqli_query($GLOBALS["enlaceDB"] ,"update usuarios set activo=0 where id=".$rr->iusuarioreportadorep." limit 1");	
								}
							}
							
						}
						else hacebit(7,34,(int)$_GET["idreal"]);
						// aca vamos a modificar la iniciativa o el usuario	
					}
					else if($_GET["operacion"]=="agregar") 
					{
						hacebit(1,34,$idnueva);
						$enviarmail=true;
					}
					tokBorra($_POST["toks"]); // borra el tok
				}
				else
				{
					if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
					{
						 $todobien=true; 
						 // actualizaremos solo si el status es ya validado (1) o (2)
					 	 $resi=@mysqli_query($GLOBALS["enlaceDB"] ,"update rep set statusrep=0,textorep='".utf8_decode(mysqli_real_escape_stringMemo($_POST["tab_textorep_as"]))."' where (statusrep=1 or statusrep=2) and iretrep=".$iretrep." and iusuarioreportadorep=".$iusuarioreportadorep." limit 1");
						 if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
						 {
							 $enviarmail=true;
							 actualizaUsuarioActividad();
							
						 }
					}
					else
					{
					  	$formGuardar->error=mensajeIdioma("02001");
					}
					tokBorra($_POST["toks"]); // borra el tok
				}
				
				if($todobien)
				{
					if($enviarmail && $_SESSION["logged"]->cms<>1) // es cms ye nviaremos mail
					{
						$repLeido=rep_lee(array("grafico"=>"detalle","iretrep"=>$iretrep,"iusuarioreportadorep"=>$iusuarioreportadorep));
						// mandemos aqui el email
						require_once($API_folder."lib/common.inc.php");
						$args = new stdClass();
						$args->template = "../APIPlantillas/mailing/reporte.php";
						$args->data = new stdClass();
						$args->data->host=$dominioSistema;
						if($iretrep<>0)
						{
							$args->data->idregistro=$iretrep;
							$args->data->tipo="Iniciativa";
							$args->data->archivo="iniciativaDetalle";
							$args->data->nombre=utf8_encode($repLeido[0]->nombreret);
						}
						else
						{
							$args->data->idregistro=$iusuarioreportadorep;
							$args->data->tipo="Usuario";
							$args->data->archivo="usuarioDetalle";
							$args->data->nombre=utf8_encode($repLeido[0]->nombreusuario);
						}

						$envios=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailenvio from envios where activo=1");
						while($rowEnvios=mysqli_fetch_object($envios))
							Mailer::sendEmail($rowEnvios->emailenvio, "ADT Reporte", $args);
					}
					
					if($_GET["operacion"]=="agregar")
					{
						$respuesta["mensaje"]=mensajeIdioma("reporteGuardado");
						$respuesta["operacionVentana"]="cerrarVentana";
					}
					else 
					{
						$respuesta["mensaje"]=mensajeIdioma("reporteActualizado");
						$respuesta["operacionVentana"]="refrescarVentana";
					}	 
				}
			}
			else $formGuardar->error=mensajeIdioma("02001");
		}
	}
	else
	{
		if($_GET["operacion"]=="editar" && $_SESSION["logged"]->cms==1) // buscamos el registro
			$registro=rep_lee(array("sincroniza"=>"si","sql_extra"=>"  id=".(int)$_GET["idreal"]));
		if($_GET["operacion"]=="agregar" || ($_GET["operacion"]=="editar" && sizeof($registro)>0)) // si estoy editando muestro solo si lo encontré
		{
			$respuesta["timeline"]=array_merge($respuesta["timeline"],formRep($registro,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));
			if($_GET["accion"]<>"guardar")
				$respuesta["timeline"][]=tokGenera("rep",34,$registro);

		}
		
	}
	
}
else
{
	$formGuardar->error=mensajeIdioma("permisoFormulario");
}

if($formGuardar->error<>"")
		$meta=array("code"=>"200","mensaje"=>$formGuardar->error,"mensajeMostrar"=>"alert");
		
header( 'Content-type: application/json' );
$tmp["meta"]=$meta;
$tmp['response'] = $respuesta;
print_r(json_encode($tmp));
?>

