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
include_once($API_folder."ret.php");
include_once($API_folder."pais.php");
include_once($API_folder."cat.php");
function formRet($registro,$operacion,$modo)
{
	global $tipopreTemporal;
	global $paisSistema;
	global $idioma;
	global $idiomas;
	global $nuevoUsuarioRet;
	$formulario=array();
	if($operacion=="agregar")  // construyamos el titulo
	{
		$tituloUsar=$idiomas["Subir iniciativa"];		
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreusuario from usuarios where id=".$nuevoUsuarioRet);
		while($row=mysqli_fetch_object($res))	
			$tituloUsar.=utf8_encode(" ".htmlentitiesMemo($row->nombreusuario));
	}
	else $tituloUsar=$idiomas["Editar iniciativa"];
	
	if($_GET["modoIdioma"]=="otro")
		$tituloUsar.=" ".$idiomas["Otro idioma"];
	$formulario[]=array("tipotimeline"=>"titulo","titulo"=>$tituloUsar,"botonVerMas"=>"","abrirSeccion"=>"");
	
	if($registro[0]->razonesret<>"")
		$formulario[]=array("tipotimeline"=>"html","html"=>"<div style='color:#FF0000; clear:both; font-size:20px; margin-bottom:10px'><strong>".$registro[0]->statusEtiqueta.".</strong> ".$registro[0]->razonesret."</div>");
		
	if($registro[0]->statusret==3 && $_GET["modoIdioma"]<>"otro")
	{
		if($_SESSION["logged"]->cms==1)
			$formulario[]=formSubtitulo("noenviadaCMSret");
		else $formulario[]=formSubtitulo("noenviadaret");	
		
		$formulario[]=array("tipotimeline"=>"break");
	}
	if($operacion=="agregar")
	{
		$formulario[]=formSubtitulo("headerret");
		$formulario[]=array("tipotimeline"=>"html","html"=>"<br clear='all'><div style='background-color:#cccccc; float:none; height:2px; margin-right:40px'></div><br clear='all'>");
	}
	if($_GET["modoIdioma"]<>"otro")
	{
		$cat1=cat_formulario_lee("radio");
		$formulario[]=formCampoSelector("radio","icatret",$registro,$operacion,"Categoría","0",$cat1,true);
		$formulario[]=array("tipotimeline"=>"html","html"=>"<br clear='all'><div style='background-color:#cccccc; float:none; height:2px; margin-right:40px'></div><br clear='all'>");
		
	}
	
	// general
	$formulario[]=formCampoTextoMemo("memo","descripcionret",$registro,$operacion,"Descripción",10,255,true,"");
	$formulario[]=formCampoTextoMemo("memo","condicionesret",$registro,$operacion,"Condiciones",0,255,false,"");
	
	if($_GET["modoIdioma"]<>"otro")
	{
		// cuando
		$formulario[]=array("tipotimeline"=>"break");
		$formulario[]=array("tipotimeline"=>"break");
		$formulario[]=formSubtitulo("cuandoret");
		if($_SESSION["logged"]->cms==1) $maximo="2030-12-31";
		else $maximo=date("Y-m-d");
		$formulario[]=formCampoFecha("finicioret",$registro,$operacion,"Fecha",date("Y")."-01-01",$maximo,date("Y-m-d"));
		$formulario[]=formCampoFecha("ffinret",$registro,$operacion,"Fecha",date("Y")."-01-01","2030-12-31",date("Y-m-d"));
		$formulario[]=array("tipotimeline"=>"break");
		
		// ubicacion
		$formulario[]=array("tipotimeline"=>"break");
		$formulario[]=formSubtitulo("donderet");
		$formulario[]=formCampoTextoMemo("texto","domicilio1ret",$registro,$operacion,"Domicilio",0,100,false,"");
		$formulario[]=array("tipotimeline"=>"break");
		$paises=pais_lee(array("order"=>"ordenpais,nombrepais asc","campos"=>"nombrepais as label,id as valor","sincroniza"=>"si"));
		array_unshift($paises,array("label"=>"...","valor"=>"0"));
		$formulario[]=formCampoSelector("picker","ipaisret",$registro,$operacion,"País","0",$paises,false,"estados.php?operacion=estados&idreal=","tab_iestadoret_as");
		if($registro[0]->ipaisret>0)
		{
			$estados=estados_lee(array("sql_extra"=>"ipaisestado=".$registro[0]->ipaisret,"order"=>"nombreestado asc","campos"=>"nombreestado as label,id as valor","sincroniza"=>"si"));
		}
		else $estados=array();
		array_unshift($estados,array("label"=>"...","valor"=>"0"));
		$formulario[]=formCampoSelector("picker","iestadoret",$registro,$operacion,"Estado","0",$estados,false);
		$formulario[]=array("tipotimeline"=>"break");
	}
		
	$formulario[]=array("tipotimeline"=>"html","html"=>"<br clear='all'><div style='background-color:#cccccc; float:none; height:2px; margin-right:40px'></div><br clear='all'>");
		
	$formulario[]=formSubtitulo("nombreretbloque");
	$formulario[]=formCampoTextoMemo("texto","nombreret",$registro,$operacion,"Nombre de la iniciativa",5,100,true,"");	
	$formulario[]=formCampoTextoMemo("texto","nombrecortoret",$registro,$operacion,"Nombre corto",0,30,false,"");	
	$formulario[]=array("tipotimeline"=>"break");		
	$formulario[]=formCampoImagef("imagenret",$registro,$operacion,"Imagen","",1,"ret",0,1);
	$formulario[]=array("tipotimeline"=>"break");	
	
	if($_SESSION["logged"]->cms==1)
	{
		$formulario[]=formCampoTextoMemo("texto","urlret",$registro,$operacion,"URL",0,100,false,"");	
		if($_GET["modoIdioma"]<>"otro")
			$formulario[]=formCampoTextoMemo("texto","videoret",$registro,$operacion,"Video",0,100,false,"");	
	}
	$formulario[]=array("tipotimeline"=>"html","html"=>"<br clear='all'><div style='background-color:#cccccc; float:none; height:2px; margin-right:40px'></div><br clear='all'>");
	
	if($_GET["modoIdioma"]<>"otro")
	{
		$formulario[]=formSubtitulo("adicionalret");
		$formulario[]=formCampoTextoMemo("int","metaret",$registro,$operacion,"Meta",0,100000,true,10000);
		$formulario[]=array("tipotimeline"=>"break");	
		$formulario[]=formCampoTextoMemo("int","minimodonativoret",$registro,$operacion,"Donativo mínimo",0,10000,true,60);	
		$formulario[]=array("tipotimeline"=>"break");
		$formulario[]=formCampoTextoMemo("int","maximoganadoresret",$registro,$operacion,"Máximo número de ganadores",0,10000,true,0);	
		$formulario[]=array("tipotimeline"=>"html","html"=>"<br clear='all'><div style='background-color:#cccccc; float:none; height:2px; margin-right:40px'></div><br clear='all'>");
		
		// status y destacado
		if($_SESSION["logged"]->cms==1)
		{		
			$formulario[]=formSubtitulo("adminret");
			$opciones2=array();
			$opciones2[]=array("label"=>"No","valor"=>"0");
			$opciones2[]=array("label"=>"Destacado","valor"=>"1");
			$formulario[]=formCampoSelector("segmented","destacadoret",$registro,$operacion,"Destacado","0",$opciones2,true);
			
			$formulario[]=array("tipotimeline"=>"break");
			$opciones=array();
			$opciones[]=array("label"=>"No enviado","valor"=>"3");
			$opciones[]=array("label"=>"Pendiente de validación","valor"=>"0");
			$opciones[]=array("label"=>"Validado","valor"=>"1");
			$opciones[]=array("label"=>"Rechazado","valor"=>"2");
			$formulario[]=formCampoSelector("segmented","statusret",$registro,$operacion,"Status","0",$opciones,true);
			$formulario[]=array("tipotimeline"=>"break");
			$formulario[]=formCampoTextoMemo("memo","razonesret",$registro,$operacion,"Razones de rechazo",0,255,false,"");
			
			if($operacion=="editar")
				$formulario[]=formCampoTextoMemo("texto","urlamigableret",$registro,$operacion,"URL amigable",5,100,true,"");	
		
		}
	
		/*
		$formulario[]=array("tipotimeline"=>"break");
		$cat=cat_formulario_lee();
		array_unshift($cat,array("label"=>"...","valor"=>"0"));
		$formulario[]=formCampoSelector("picker","icatret",$registro,$operacion,"Categoría","0",$cat,true);
		*/
	}
	
	$formulario[]=array("tipotimeline"=>"break");
	if($_SESSION["logged"]->cms<>1)
		$formulario[]=formSubtitulo("importanteret");
	
	if($_SESSION["logged"]->cms<>1 && ($operacion=="agregar" || $registro[0]->statusret==3))
	{
		$formulario[]=formSubtitulo("mensajeenviarret");
	}
	
	if($_SESSION["logged"]->cms==1 || $registro[0]->statusret==3 || $operacion=="agregar") // es admin o no ha sido enviada a validacion
	{ 
		$elemento->tipotimeline="boton";
		$elemento->tipoBoton="guardarForm";
		if($operacion=="editar")
			$elemento->texto=utf8_encode($idiomas["Editar iniciativa"]);
		else $elemento->texto=utf8_encode($idiomas["Subir iniciativa"]);
		$formulario[]=$elemento;
		
		if($_SESSION["logged"]->cms<>1 && ($operacion=="agregar" || $registro[0]->statusret==3))
		{
			unset($elemento);
			$elemento->tipotimeline="boton";
			$elemento->tipoBoton="guardarForm";
			$elemento->operacionExtra="&enviarvalidacion=si";
			$elemento->confirmar="¿".utf8_encode($idiomas["Enviar a validacion"]."?");
			$elemento->texto=utf8_encode($idiomas["Enviar a validacion"]);
			$formulario[]=$elemento;
		}
	}
	$formulario[]=array("tipotimeline"=>"break");
	$formulario[]=array("tipotimeline"=>"break");
	

	if($operacion=="editar" && $_SESSION["logged"]->cms==1 && $_GET["modoIdioma"]<>"otro")
	{
		
		if($idioma==0)
		{
			$titulin="Información extra requerida a ganadores";
			$bots=array("Solicitar número entero","Solicitar número con punto decimal","Solicitar texto","Solicitar opciones");
		}
		else
		{
			$titulin="Information requested to winners";
			$bots=array("Request INT number","Request float number","Request text","Request options");
		}
		$idret=(int)$_GET["idreal"];
		$formulario[]=array("tipotimeline"=>"titulo","titulo"=>$titulin,"botonVerMas"=>"","abrirSeccion"=>"");
		
		$cret=cret_lee(array("leerIdiomas"=>"si","sql_extra"=>"iretcret=".$idret,"sincroniza"=>"si"));
		for($i=0; $i<=sizeof($cret)-1; $i++)
		{
			$formulario[]=generaBotonDirecto("formularioCret","","editar",$cret[$i]->labelcret,$cret[$i]->idreal,"1");
		}
		$formulario[]=array("tipotimeline"=>"break");
		
		$formulario[]=generaBotonDirecto("formularioCret","1","agregar",$bots[0],$idret,"2");
		$formulario[]=generaBotonDirecto("formularioCret","2","agregar",$bots[1],$idret,"2");
		$formulario[]=generaBotonDirecto("formularioCret","3","agregar",$bots[2],$idret,"2");
		$formulario[]=generaBotonDirecto("formularioCret","4","agregar",$bots[3],$idret,"2");			
	}
	
	
	
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
	if($_GET["operacion"]=="agregar")
	{
		if($_SESSION["logged"]->cms==1) // es administrador
		{
			if($_GET["idreal"]==0) $nuevoUsuarioRet=(int)$_SESSION["logged"]->id; // es suyo
			else $nuevoUsuarioRet=(int)$_GET["idreal"]; // es de otro usuario
		}
		else $nuevoUsuarioRet=$_SESSION["logged"]->id; // es un usuario normal
	}
	if($_SESSION["logged"]->cms==1) $sql_extra_restriccion="";
	else $sql_extra_restriccion=" iusuarioret=".(int)$_SESSION["logged"]->id." and statusret=3";
	
	if($sql_extra_restriccion<>"") $sql_extra_restriccion.=" and ";
	$sql_extra_restriccion.="ret.id=".(int)$_GET["idreal"];
	$camposIdiomas=array("nombreret","descripcionret","condicionesret","imagenret","nombrecortoret");
	// veamos si los textos estarán en inglés o español
	if(($idioma==0 && $_GET["modoIdioma"]=="otro") || ($idioma==1 && $_GET["modoIdioma"]=="actual"))
		$textoIngles="si";
	else $textoIngles="no";
	
	if($_GET["accion"]=="guardar") // vamos a guardar
	{	
			
		$formGuardar->error=tokRevisa($_POST["toks"]);
		
		if($formGuardar->error=="")
			$formGuardar=evaluaFormulario(formRet(NULL,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));
			
		if($formGuardar->error=="")
		{
			if($_POST["tab_finicioret_as"]>$_POST["tab_ffinret_as"])
			{
				$formGuardar->error=mensajeIdioma("fechasMalError");
			}
		}
		
		if($formGuardar->error=="")
		{
			if($_SESSION["logged"]->cms==1 && $_POST["tab_destacadoret_as"]=="1" && $_POST["tab_nombrecortoret_as"]=="")
			{
				$formGuardar->error=mensajeIdioma("destacarIniciativaError");
			}
		}
		
		if($formGuardar->error=="")
		{
			if($_SESSION["logged"]->cms==1)
			{
				if($_POST["tab_statusret_as"]=="2" && $_POST["tab_razonesret_as"]=="")
				{
					$formGuardar->error=mensajeIdioma("razonesRechazoFaltan");
				}
				else if($_POST["tab_statusret_as"]<>"2"  && $_POST["tab_razonesret_as"]<>"")
				{
					$formGuardar->error=mensajeIdioma("razonesDestacarSobran");
				}
			}
		}
		
		if($formGuardar->error=="" && $_GET["operacion"]=="editar")
		{
			$statusActual="";
			$resTempo=@mysqli_query($GLOBALS["enlaceDB"] ,"select statusret,iusuarioret,idioma from ret where id=".(int)$_GET["idreal"]);
			while($rowTempo=mysqli_fetch_object($resTempo))
			{
				$statusActual=$rowTempo->statusret;
				$emailusuario="";	
				$idiomaret=$rowTempo->idioma;
				$resTempoUsuario=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario from usuarios where id=".$rowTempo->iusuarioret);
				while($rowTempoUsuario=mysqli_fetch_object($resTempoUsuario))
				{
					$emailusuario=$rowTempoUsuario->emailusuario;
					$nombreusuario=utf8_encode(htmlentitiesMemo($rowTempoUsuario->nombreusuario));

				}
			}
			if($_GET["operacion"]=="agregar" || ($statusActual<>3 && $_SESSION["logged"]->cms<>1))
				$formGuardar->error=mensajeIdioma("permisoFormulario");
		}
		
		
		if($formGuardar->error=="")
		{
			$sql="";
			if($_SESSION["logged"]->cms<>1 && $_GET["enviarvalidacion"]=="si")
				$formGuardar->cadena.=",statusret='0'";
				
			if($_GET["operacion"]=="editar")  // vamos a editar
				$sql="update ret set ".$formGuardar->cadena." where ".$sql_extra_restriccion." limit 1";
			else if($_GET["operacion"]=="agregar") // vamos a agregar
				$sql="insert into ret set ".$formGuardar->cadena.",fechaaltaret='".date("Y-m-d")."',iusuarioret=".$nuevoUsuarioRet.",idioma='".$idioma."'";
			
			if($sql<>"") // tengo sql, procesar
			{
				$idguardado=0;
				if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
				{
					
					if($_GET["operacion"]=="agregar") // copiamos todos los campos de idioma sobre si mismos en el segundo idioma
					{
						$idnueva=mysqli_insert_id($GLOBALS["enlaceDB"] );
						$idguardado=$idnueva;
						hacebit(1,2,$idnueva);
						$sqlIdioma="update ret set ";
						for($x=0; $x<=sizeof($camposIdiomas)-1; $x++)
						{
							if($x>0) $sqlIdioma.=",";
							$sqlIdioma.="i_".$camposIdiomas[$x]."=".$camposIdiomas[$x];	
						}
						@mysqli_query($GLOBALS["enlaceDB"] ,$sqlIdioma." where id=".$idnueva." limit 1");
						
					}
					else // se modifico
					{
						$idguardado=(int)$_GET["idreal"];
						hacebit(2,2,(int)$_GET["idreal"]);
					}
					
					if($idguardado<>0) // en efecto guardo y traigo el idguardado
					{
						$retEnviar=ret_lista_lee(array("grafico"=>"detalle","sql_extra"=>" and ret.id=".$idguardado));
						if($_GET["operacion"]=="agregar")
						{
							$retEnviar[0]->urlamigableret=convierte_url_API($retEnviar[0]->nombreret,"",0);
							@mysqli_query($GLOBALS["enlaceDB"] ,"update ret set urlamigableret='".$retEnviar[0]->urlamigableret."' where id=".$idguardado);	
						}
						// se envio a validacion
						if($_GET["enviarvalidacion"]=="si")// no es cms
						{
							

							hacebit(13,2,$idguardado);
							require_once($API_folder."lib/common.inc.php");
							
							if($_SESSION["logged"]->cms<>1)
							{
								$args = new stdClass();
								$args->template = "../APIPlantillas/mailing/validarIniciativa.php";
								$args->data = new stdClass();
								$args->data->idregistro=$idguardado;
								$args->data->idioma=$idioma;
								$args->data->nombreret=utf8_encode($retEnviar[0]->nombreret);
								$args->data->host=$dominioSistema;
								$envios=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailenvio from envios where activo=1");
								while($rowEnvios=mysqli_fetch_object($envios))
									Mailer::sendEmail($rowEnvios->emailenvio, "Validar iniciativa ADT", $args);
							}
							$args2 = new stdClass();
							$args2->template = "../APIPlantillas/mailing/validarIniciativaUsuario.php";
							$args2->data = new stdClass();
							$args2->data->idregistro=$idguardado;
							$args2->data->idioma=$idioma;
							$args2->data->nombreret=utf8_encode($retEnviar[0]->nombreret);
							$args2->data->host=$dominioSistema;
							$resTempoUsuario=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario from usuarios where id=".(int)$_SESSION["logged"]->id);
							while($rowTempoUsuario=mysqli_fetch_object($resTempoUsuario))
							{
								$args2->data->nombreusuario=utf8_encode(htmlentitiesMemo($rowTempoUsuario->nombreusuario));
								$emailusuario=$rowTempoUsuario->emailusuario;
							}
							if($emailusuario<>"")
								Mailer::sendEmail($emailusuario, mensajeIdioma("iniciativaPendienteValidacion"), $args2);
						}
						else if($_SESSION["logged"]->cms==1 && $_POST["tab_statusret_as"]<>$statusActual) // cambiamos de status
						{
							require_once($API_folder."lib/common.inc.php");
							$args = new stdClass();
							if($_POST["tab_statusret_as"]==1)
							{
								$subject=mensajeIdioma("iniciativaValidada");
								$args->template = "../APIPlantillas/mailing/cambioStatusIniciativa.php";
								hacebit(3,2,$idguardado);
							}
							else if($_POST["tab_statusret_as"]==2)
							{
								$subject=mensajeIdioma("iniciativaRechazada");
								$args->template = "../APIPlantillas/mailing/cambioStatusIniciativaRechazar.php";
								hacebit(4,2,$idguardado);	
							}
							
							$args->data = new stdClass();
							$args->data->idregistro=(int)$_GET["idreal"];
							$args->data->idioma=round($idiomaret);
							$args->data->nombreret=utf8_encode($retEnviar[0]->nombreret);
							$args->data->nombreusuario=$nombreusuario;
							$args->data->host=$dominioSistema;
							Mailer::sendEmail($emailusuario, $subject, $args);
							
						}
						
						if($_GET["operacion"]=="agregar")
						{
							if($idioma==0) 
								$complemento="iniciativa";
							else 
								$complemento="initiative";
	
							$respuesta["mensaje"]=mensajeIdioma("iniciativaAgregada");
							$respuesta["operacionValor1"] = convierte_url_API($retEnviar[0]->urlamigableret,$complemento,$idnueva);
							$respuesta["operacionVentana"]="redireccionarVentana";
						}
						else 
						{
							$respuesta["mensaje"]=mensajeIdioma("iniciativaGuardada");
							$respuesta["operacionVentana"]="refrescarVentana";
						}
					}
					
					tokBorra($_POST["toks"]); // borra el tok
					
				}
				else // ocurrio un error al guardar
				{
					$formGuardar->error=mensajeIdioma("02002");
				}
			}
			else $formGuardar->error=mensajeIdioma("02001");
		}
	}
	else
	{
		if($_GET["operacion"]=="editar") // buscamos el registro
			$registro=ret_lista_lee(array("textoIngles"=>$textoIngles,"sincroniza"=>"si","grafico"=>"detalle","sql_extra"=>" and ".$sql_extra_restriccion));
		if($_GET["operacion"]=="agregar" || ($_GET["operacion"]=="editar" && sizeof($registro)>0)) // si estoy editando muestro solo si lo encontré
		{
			$respuesta["timeline"]=array_merge($respuesta["timeline"],formRet($registro,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["operacion"]),""));
			if($_GET["accion"]<>"guardar")
				$respuesta["timeline"][]=tokGenera("ret",2,$registro);
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

