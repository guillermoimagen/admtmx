<?

// cambiamos la zona horaria


$idioma=0;
if(isset($_SESSION["cambioIdioma"]))
{
	if($_SESSION["idiomaTemp"]==0) $idioma=1;
	else $idioma=0;
	unset($_SESSION["cambioIdioma"]);
}
else if($dosIdiomas)
{
	if($_GET["idioma"]=="0") $idioma=0;
	else if($_GET["idioma"]=="1") $idioma=1;
	else if($_SESSION["idiomaTemp"]=="0") $idioma=0;
	else if($_SESSION["idiomaTemp"]=="1") $idioma=1;
}
$_SESSION["idiomaTemp"]=$idioma;
$idiomaPrefijo="";
if($_SESSION["idiomaTemp"]==1) $idiomaPrefijo="_i";

if($idioma==1)  setlocale ( LC_TIME ,'US');
else setlocale (LC_TIME, "es_MX.utf8");

if($_SESSION["logged"]->id<>0 && isset($_SESSION["logged"]->id))
	$_SESSION["firmado"]=true;
else $_SESSION["firmado"]=false;

// veremos si es movil
if(!isset($_SESSION["mobile"]))
{
	if( preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
		$_SESSION["mobile"]=true;
	else $_SESSION["mobile"]=false;	
}


// VARIABLES PARA WEB
$esAjax=false;
$fechahoy=date("Y-m-d");
$fechahorahoy=date("Y-m-d h:i");
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
	$esAjax=true;
	
function limpia_imagenes_API($cadena,$imagen_reemplazo)
{
	if($imagen_reemplazo == "") 
		$cadena = preg_replace("/<IMG [^>]*src=('|\"[^>]*)recursos\/('|\")[^>]*>/i","",$cadena);
	else  
		$cadena = preg_replace("/(<IMG [^>]*src=('|\"[^>]*)recursos\/)(('|\")[^>]*>)/i","$1".$imagen_reemplazo."$2",$cadena);
	return $cadena;
}

function abre_plantilla_API($archivo,$considerarIdioma)
{
	global $idiomaPrefijo, $idiomas, $idioma, $_GET;
	$usarPrefijo="";
	if($considerarIdioma) $usarPrefijo=$idiomaPrefijo; // vamos a considerar idioma
	$result = file_get_contents("recursos/plantillas/".$archivo.$usarPrefijo.".php");
	
	// no la encontro en infles
	if($result=="" && $considerarIdioma)
		$result = file_get_contents("recursos/plantillas/".$archivo.".php");
	
	// si es cabezaPrincipal o Pie le ponemos cosas especiales
	if($archivo=="cabezaPrincipal")
	{
		$result .= '
			<script>
				var lang = "' . ((intval($idioma) == 1) ? "EN" : "ES") . '";
				' . ((isset($_GET["tokenrecuperar"]) && $_GET["tokenrecuperar"] != "") ? 'var tokenrecuperar = "' . $_GET["tokenrecuperar"] . '";' : '') . '
			</script>
		';
		$result .= ($_SESSION["firmado"]) ? utf8_decode(abre_plantilla_API("cabezaConectado",false)) : utf8_decode(abre_plantilla_API("cabezaNoConectado",false));
	}
	else  if($archivo=="pie")
	{
		
		$resultX = ($_SESSION["firmado"]) ? utf8_decode(abre_plantilla_API("ventanaConectado",false)) : utf8_decode(abre_plantilla_API("ventanaNoConectado",false));
		foreach($idiomas as $index => $val) $resultX = preg_replace('/<' . $index . '>/', $val, $resultX);
		$result=$resultX.$result;
	}
    return $result; 
}

function extrae_vista_API($nombre_vista,$vistaTexto)
{
	$arreglo = array();
	$arreglo2 = array();
	preg_match("/<VISTA_".$nombre_vista.">(.*?)<\/VISTA_".$nombre_vista.">/s",$vistaTexto,$arreglo);
	preg_match("/<CONDICIONAL_".$nombre_vista.">(.*?)<\/CONDICIONAL_".$nombre_vista.">/s",$vistaTexto,$arreglo2);
	if(sizeof($arreglo2)>0)
	{
		$arreglo[]=$arreglo2[0];
	$arreglo[]=$arreglo2[1];
	}
	return $arreglo;
}

function generaVista($vista, $arreglo)
{
	foreach($arreglo as $key => $value) 
		$vista=str_replace("<".$key.">",$value,$vista);
	$vista = limpia_imagenes_API($vista,"");
	return $vista;
}

function generaVistaRecursiva($vista, $arreglo)
{
	$vistaFinal = "";
	foreach($arreglo as $arregloItem) 
		$vistaFinal .= generaVista($vista, $arregloItem);
	return $vistaFinal;
}

function generaVistaRecursivaAlternada($vista1,$vista2,$arreglo)
{
	$vistaFinal = "";
	$cuenta=0;
	foreach($arreglo as $arregloItem) 
	{
		if($cuenta==0)
		{
			$vistaFinal .= generaVista($vista1, $arregloItem);
			$cuenta=1;
		}
		else
		{
			$vistaFinal .= generaVista($vista2, $arregloItem);
			$cuenta=0;
		}
	}
	if($cuenta==1) $vistaFinal.="</div>"; // cerramos si se quedo abierto
	return $vistaFinal;
}

// evalua si una vista debe desaparecer, pasamos el string de la $vista, el $tag a sustituir y el $valor de sustitucion
function evalua_vista_API($vista,$tag,$valor)
{
	if($valor <> "" && $valor <> NULL) $devolver = str_replace("<#".$tag.">",$valor,$vista);
	else $devolver = "";
	return $devolver;
}

function construye_galeria_API($tabla,$registro,$vistaFotosGeneral)
{
	$fotos = fotos_lee(array(
					'sql_extra' => 'itablafoto = '.$tabla.' and registrofoto='.$registro,
					'order' => ' ordenfoto ASC, id ASC',
					'url' => 'titulofoto' ));
	$vistaFotos = extrae_vista_API("FOTOS",$vistaFotosGeneral[1]);
	$vistaFotosCompleta = generaVistaRecursiva($vistaFotos[1],$fotos); 
	if($vistaFotosCompleta <>"") $vistaFotosGeneral[1] = str_replace($vistaFotos[0],$vistaFotosCompleta,$vistaFotosGeneral[1]);
	else $vistaFotosGeneral[1] ="";
	
	return $vistaFotosGeneral;
}


function extrae_contador_API2015($nombre_vista,$vistaTexto)
{
	$arreglo = array();
	preg_match("/<CONTADOR_".$nombre_vista.">(.*?)<\/CONTADOR_".$nombre_vista.">/s",$vistaTexto,$arreglo);
	return $arreglo;
}

function extrae_contadoronoff_API2015($nombre_vista,$vistaTexto)
{
	$arreglo = array();
	preg_match("/<CONTADORONOFF_".$nombre_vista.">(.*?)<\/CONTADORONOFF_".$nombre_vista.">/s",$vistaTexto,$arreglo);
	if(sizeof($arreglo)>0)
	{
		$arregloOn=array();
		$arregloOff=array();
		$max=array();
		
		preg_match("/<ON>(.*?)<\/ON>/s",$arreglo[1],$arregloOn);
		preg_match("/<OFF>(.*?)<\/OFF>/s",$arreglo[1],$arregloOff);
		preg_match("/<MAX>(.*?)<\/MAX>/s",$arreglo[1],$max);
		
		$arreglo[]=$arregloOn[1];
		$arreglo[]=$arregloOff[1];
		$arreglo[]=$max[1];
	}
	return $arreglo;
}


function extrae_onoff_API2015($nombre_vista,$vistaTexto)
{
	$arreglo = array();
	preg_match("/<ONOFF_".$nombre_vista.">(.*?)<\/ONOFF_".$nombre_vista.">/s",$vistaTexto,$arreglo);
	if(sizeof($arreglo)>0)
	{
		$arregloOn=array();
		$arregloOff=array();
		
		preg_match("/<ON>(.*?)<\/ON>/s",$arreglo[1],$arregloOn);
		preg_match("/<OFF>(.*?)<\/OFF>/s",$arreglo[1],$arregloOff);
		
		$arreglo[]=$arregloOn[1];
		$arreglo[]=$arregloOff[1];
	}
	return $arreglo;
}

function extrae_cond_API2015($nombre_vista,$vistaTexto)
{
	$arreglo = array();
	preg_match("/<COND_".$nombre_vista.">(.*?)<\/COND_".$nombre_vista.">/s",$vistaTexto,$arreglo);
	return $arreglo;
}

function extrae_ifelse_API2015($nombre_vista,$vistaTexto)
{
	$arreglo = array();
	preg_match("/<IFELSE_".$nombre_vista.">(.*?)<\/IFELSE_".$nombre_vista.">/s",$vistaTexto,$arreglo);
	return $arreglo;
}

function extrae_if_API2015($vistaTexto)
{
	$arreglo = array();
	preg_match("/<IF>(.*?)<\/IF>/s",$vistaTexto,$arreglo);
	return $arreglo;
}

function extrae_else_API2015($vistaTexto)
{
	$arreglo = array();
	preg_match("/<ELSE>(.*?)<\/ELSE>/s",$vistaTexto,$arreglo);
	return $arreglo;
}

function extrae_cond0_API2015($nombre_vista,$vistaTexto)
{
	$arreglo = array();
	preg_match("/<COND0_".$nombre_vista.">(.*?)<\/COND0_".$nombre_vista.">/s",$vistaTexto,$arreglo);
	return $arreglo;
}

function generaVista2015($vista, $arreglo,$modosVista,$vistasInternas)
{
	foreach($vistasInternas as $control => $valueVista) 
	{
		$value=$arreglo->{$control};
		
		$vistaTemporal="";
		if($modosVista[$control]=="contador")
		{			
			for($i=1; $i<=$value; $i++)
				$vistaTemporal.=$valueVista[1];
			$vista=str_replace($valueVista[0],$vistaTemporal,$vista);
		}
		else if($modosVista[$control]=="contadoronoff")
		{
			for($i=1; $i<=$valueVista[4]; $i++) // en el nodo 4 de la vista está el valor máximo
			{
				if($i<=$value)
					$vistaTemporal.=$valueVista[2]; // está prendido
				else $vistaTemporal.=$valueVista[3]; // está apagado
				$vistaTemporal=str_replace("<valori>",$i,$vistaTemporal);
			}
			$vista=str_replace($valueVista[0],$vistaTemporal,$vista);
		}
		else if($modosVista[$control]=="onoff")
		{
			if($value==0) // es valor 1
				$vistaTemporal=$valueVista[3]; // está prendido
			else $vistaTemporal=$valueVista[2]; // está apagado
			$vista=str_replace($valueVista[0],$vistaTemporal,$vista);
		}
		else if($modosVista[$control]=="cond")
		{
			if($value<>"" && isset($value)) // tiene un valor
				$vistaTemporal=str_replace("<".$control.">",$value,$valueVista[1]); // sustituyamos el valor en el nodo 
			else
				$vistaTemporal=""; // viene vacío	
			$vista=str_replace($valueVista[0],$vistaTemporal,$vista);
		}
		else if($modosVista[$control]=="ifelse")
		{
			$vistaif=extrae_if_API2015($valueVista[1]);
			$vistaelse=extrae_else_API2015($valueVista[1]);
			
			if($value<>"" && isset($value)) // tiene un valor
				$vistaTemporal=str_replace("<".$control.">",$value,$vistaif[1]); // sustituyamos el valor en el nodo 				
			else
				$vistaTemporal=str_replace("<".$control.">",$value,$vistaelse[1]);	
			$vista=str_replace($valueVista[0],$vistaTemporal,$vista);
		}
		else if($modosVista[$control]=="cond0")
		{
			if($value<>"0") // tiene un valor diferente de 0
				$vistaTemporal=str_replace("<".$control.">",$value,$valueVista[1]); // sustituyamos el valor en el nodo 
			else
				$vistaTemporal=""; // viene vacío		
			$vista=str_replace($valueVista[0],$vistaTemporal,$vista);
		}
	}
	
	foreach($arreglo as $key => $value) 
		$vista=str_replace("<".$key.">",$value,$vista);
		
	$vista = limpia_imagenes_API($vista,"");

	return $vista;
}

function generaVistaRecursiva2015($vista, $arreglo)
{
	$vistaFinal = "";
	$modosVista=array();
	$vistasInternas=array(); // generamos las vistas internas en caso de ser necesario, para no generarla en cada recursividad
	
	if(sizeof($arreglo)>0) // consultamos el tipo de vista que usará el campo de la vista misma
	{
		foreach($arreglo[0] as $key => $value)
		{
			// vemos si es contador
			$vistaLeida=extrae_contador_API2015($key,$vista);
			if(sizeof($vistaLeida)>0) // fue contador
			{
				$modosVista[$key]="contador";
				$vistasInternas[$key]=$vistaLeida;
			}
			else
			{
				$vistaLeida=extrae_contadoronoff_API2015($key,$vista);
				if(sizeof($vistaLeida)>0) // fue onoff
				{
					$modosVista[$key]="contadoronoff";
					$vistasInternas[$key]=$vistaLeida;
				}
				else 
				{
					$vistaLeida=extrae_onoff_API2015($key,$vista);
					if(sizeof($vistaLeida)>0) // fue onoff
					{
						$modosVista[$key]="onoff";
						$vistasInternas[$key]=$vistaLeida;
					}
					else
					{
						$vistaLeida=extrae_cond_API2015($key,$vista);
						if(sizeof($vistaLeida)>0) // fue onoff
						{
							$modosVista[$key]="cond";
							$vistasInternas[$key]=$vistaLeida;
						}
						else
						{
							$vistaLeida=extrae_ifelse_API2015($key,$vista);
							if(sizeof($vistaLeida)>0) // fue onoff
							{
								$modosVista[$key]="ifelse";
								$vistasInternas[$key]=$vistaLeida;
							}
							else
							{
								$vistaLeida=extrae_cond0_API2015($key,$vista);
								if(sizeof($vistaLeida)>0) // fue onoff
								{
									$modosVista[$key]="cond0";
									$vistasInternas[$key]=$vistaLeida;
								}
								
								/*else
								{
									$modosVista[$key]="normal"; // finalmente fue normal
									$vistasInternas[$key]="";
								}*/
							}
						}
					}
				}
			}
			
		}
	}
	foreach($arreglo as $arregloItem) 
		$vistaFinal .= generaVista2015($vista, $arregloItem,$modosVista,$vistasInternas);
	
	return $vistaFinal;
}

function generaVistaRecursivaCondicional2015($vistaLeer, $vistaOriginal, $arreglo)
{
	$vistaUsar=extrae_vista_API($vistaLeer,$vistaOriginal);
	
	if(sizeof($vistaUsar)<=2) // no hay condicional
	{
		$contenidoUsar=generaVistaRecursiva2015($vistaUsar[1],$arreglo);
		$vistaOriginal=str_replace($vistaUsar[0],$contenidoUsar,$vistaOriginal);
	}
	else // si hay condicional
	{
		if(sizeof($arreglo)>0) // si hay elementos
		{
			$contenidoUsar=generaVistaRecursiva2015($vistaUsar[1],$arreglo); // construimos con la vista original
			$contenidoUsar=str_replace($vistaUsar[1],$contenidoUsar,$vistaUsar[3]); // sustituimos el texto obtenido en la vista de condicional
			$vistaOriginal=str_replace($vistaUsar[2],$contenidoUsar,$vistaOriginal); // susitiomos la vista completa (condicional) con el texto obtenido
		}
		else // no hay elementos, sustituimos la vista condicoinal por vacío
		{
			$vistaOriginal=str_replace($vistaUsar[2],"",$vistaOriginal);
		}
	}
	
	return $vistaOriginal;
}

function generaVistaRecursivaIntercalada2015($arregloContenido,$arregloIntercalado,$vistaContenido,$vistaIntercalado,$intervalo,$numero_pagina,$items_por_pagina)
{
	$arreglo=array();
	$contenidoGenerado="";
	if(sizeof($arregloContenido)>0)
	{
		$contador=($numero_pagina-1)*$items_por_pagina;
		for($i=0; $i<=sizeof($arregloContenido)-1; $i++)
		{
			if($i<>0 && $contador % $intervalo ==0 ) // inservamos el intercalado
			{
				$controlIntercalado=$contador/$intervalo-1;
				$controlIntercalado=$controlIntercalado % sizeof($arregloIntercalado);
				$arreglo[0]=$arregloIntercalado[$controlIntercalado];
				$contenidoGenerado.=generaVistaRecursiva2015($vistaIntercalado,$arreglo);	
				
					
				
				
			}
			$arreglo[0]=$arregloContenido[$i];
			$contenidoGenerado.=generaVistaRecursiva2015($vistaContenido,$arreglo);
			$contador++;
			
		}
	}
	
	
	return $contenidoGenerado;
}


function generaShareButtons($urlAmigable)
{
	$contenido=abre_plantilla_API("share");
	$urlAmigable="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$contenido=str_replace("<url>",$urlAmigable,$contenido);
	return $contenido;
}

function generaRedes($title,$image,$description)
{
	$title=str_replace("'","",$title);
	$description=str_replace("'","",$description);
	$redes=abre_plantilla_API("redes",false);
	$url="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$redes=str_replace("<title>",$title,$redes);
	if($image<>"") $image="https://".$_SERVER[HTTP_HOST]."/".$image;
	$redes=str_replace("<image>",$image,$redes);
	$redes=str_replace("<description>",$description,$redes);
	$redes=str_replace("<url>",$url,$redes);
	return $redes;
}

function haceFirma()
{
	global $idioma;
	global $idiomas;
	
	$cadena="";
	if($_SESSION["logged"]->id<>0 && isset($_SESSION["logged"]->id))
	{
		$cadena='<a href="usuarioDetalle.php?idregistro='.(int)$_SESSION["logged"]->id.'"><strong>'.$idiomas["Mi perfil"].'</strong></a>|';
		$cadena.='<span onclick="salirme();"><strong>'.$idiomas["Salir"].' ('.$_SESSION["logged"]->name.')</strong></span>';
	}
	else
	{
		$cadena='<span onclick="revisaFirma();"><strong>'.$idiomas["Ingresar"].'</strong>|</span>
                 <span onclick="registrarme();"><strong>'.$idiomas["Registrarme"].'</strong></span>';
	}	
	return $cadena;
}

function generaRenglonCret($registro,$numeropost)
{
	$cadena="";
	global $idioma;
	
	$datareq="";
	$nombrereq="";
	if($registro->reqcret==1)
	{
		$datareq=' data-req="1"';
		$nombrereq='*';
	}
	
						
	$cadena='<div class="div_imput"><p>'.$registro->labelcret.$nombrereq.'</p>';
	$nombrecampo='vcre_'.$registro->idreal.'_'.$numeropost;
	$nombrecampoerror='error_vcre_'.$registro->idreal.'_'.$numeropost;
	$data="";
	if($registro->tipocret<=3)
	{
		if($registro->tipocret<3) 
		{
			$ancho=120;
			if($registro->mincret>0 && $registro->maxcret>0)
				$data='data-min="'.$registro->mincret.'" data-max="'.$registro->maxcret.'"';
		}
		else
		{
			$ancho=200;
			$data=' maxlength="100"';
		}
		
		if($registro->tipocret==1) $dataTipo='data-tipo="int"';
		else if($registro->tipocret==2) $dataTipo='data-tipo="float"';
		else if($registro->tipocret==3) $dataTipo='data-tipo="text"';
		
		$cadena.='<input type="text" value="'.htmlentitiesMemoStrong($_POST[$nombrecampo]).'" id="'.$nombrecampo.'" name="'.$nombrecampo.'" class="cret ui-widget ui-corner-all" style="width:'.$ancho.'px" '.$data.$datareq.$dataTipo.' onblur="validarCretEspecifico($(this))">';	
	}
	else // select
	{
		$cadena.='<select class="cret ui-widget ui-corner-all" '.$data.$datareq.' id="'.$nombrecampo.'" name="'.$nombrecampo.'" data-tipo="select" style="width:200px"  onblur="validarCretEspecifico($(this))"><option value=""></option>';
		$arreglo = explode("\r\n", $registro->opcionescret);
		for($i=0; $i<=sizeof($arreglo)-1; $i++)
		{
			$val=$arreglo[$i];
			//$val=preg_replace( "/\r|\n/", "", $arreglo[$i] );
			$cadena.='<option value="'.$val.'">'.$val.'</option>';
		}
		$cadena.='</select>';
	}
	$cadena.="<br><span id='".$nombrecampoerror."' class='errorCretLabel'></span></div>";
	return $cadena;
}


function htmlentitiesMemo($valor)
{
	$valor=str_replace("&","",$valor);
	$valor=str_replace("<","",$valor);
	$valor=str_replace(">","",$valor);
	$valor=str_replace("\\","",$valor);
	return htmlentities($valor,ENT_QUOTES,'ISO-8859-1');	
}

// imprimir en html
function htmlentitiesMemoStrong($valor)
{
	$valor=str_replace("&","",$valor);
	$valor=str_replace("<","",$valor);
	$valor=str_replace(">","",$valor);
	$valor=str_replace("\"","",$valor);
	$valor=str_replace("'","",$valor);
	$valor=str_replace("/","",$valor);
	$valor=str_replace("\\","",$valor);
	return htmlentities($valor,ENT_QUOTES,'ISO-8859-1');	
	
}

// entrar a base de datos
function mysqli_real_escape_stringMemo($valor)
{	
	$valor=trim(strip_tags($valor));
	$valor=str_replace("&","",$valor);
	$valor=str_replace("<","",$valor);
	$valor=str_replace(">","",$valor);
	$valor=str_replace("\"","",$valor);
	$valor=str_replace("'","",$valor);
	$valor=str_replace("\\","",$valor);
	return mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$valor);
}

// entrar a base de datos
function mysqli_real_escape_stringMemoPost($valor)
{	
	$valor=trim(strip_tags($valor));
	$valor=str_replace("&","",$valor);
	$valor=str_replace("<","",$valor);
	$valor=str_replace(">","",$valor);
	$valor=str_replace("\"","",$valor);
	$valor=str_replace("\\","",$valor);
	return mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$valor);
}

function tokGenera($tablaid,$tablaregistro,$registro)
{
	$cadena1=md5($tablaid.$tablaregistro.$registro.rand(0,100000));
	$cadena2=md5(date("Y-m-d H:i").$tablaid.$tablaregistro.rand(0,10000));
	@mysqli_query($GLOBALS["enlaceDB"] ,"insert into toks set valor='".$cadena1.$cadena2."'");
	
	$elemento->tipotimeline="toks";
	$elemento->valor=$cadena1.$cadena2."-".mysqli_insert_id($GLOBALS["enlaceDB"] );
	
	if($registro==-1) return	 $elemento->valor;
	else return $elemento;
}

function tokRevisa($tok)
{
	$error="Error 1325";
	$partes=explode("-",$tok);

	if(sizeof($partes)==2)
	{
		$tokID=$partes[1];
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select valor,fecha from toks where id=".$tokID);
		while($row=mysqli_fetch_object($res))
		{
			if($row->valor==$partes[0])
			{
				$datetime1 = strtotime($row->fecha);			
				$ahora=date("Y-m-d H:i:s");
				$datetime2 = strtotime($ahora);
				$interval  = abs($datetime2 - $datetime1);
				$minutes   = round($interval / 60);
				if($minutes<=60)  // solo si tiene menos de 60 minutos el token
					$error="";
				else // solo borramos si no es valido
					@mysqli_query($GLOBALS["enlaceDB"] ,"delete from toks  where id=".$tokID." limit 1");
			}
		}
	}
	return $error;
}

function tokBorra($tok)
{
	$partes=explode("-",$tok);

	if(sizeof($partes)==2)
	{
		$tokID=$partes[1];
		@mysqli_query($GLOBALS["enlaceDB"] ,"delete from toks where id=".$tokID." limit 1");
	}
}

function checaUsuarioActivo()
{
	if($_SESSION["firmado"]==true)
	{
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select id from usuarios where id=".(int)$_SESSION["logged"]->id." and activo=1");
		if(mysqli_num_rows($res)>0) return true;
		else 
		{
			unset($_SESSION["logged"]);
			$_SESSION["firmado"]=false;
			unset($_SESSION["firmado"]);
			return false;	
		}
	}
	else return true;
}

function checaUsuarioActividad()
{
	if($_SESSION["firmado"]==true)
	{
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select id,ultimaoperacionusuario,cmsusuario from usuarios where id=".(int)$_SESSION["logged"]->id." and activo=1");
		if(mysqli_num_rows($res)==0)  // ya no esta activo
		{
			unset($_SESSION["logged"]);
			$_SESSION["firmado"]=false;
			unset($_SESSION["firmado"]);
			return "actividadNoActivo";	
		}
		else  // si esta activo
		{
			while($rowUsuario=mysqli_fetch_object($res))
			{
				$ahora=date("Y-m-d h:i:s");
				
				if($rowUsuario->cmsusuario==1) return ""; // es admin, puede publicar
				else
				{
					
					$limite = date("Y-m-d h:i:s", strtotime($rowUsuario->ultimaoperacionusuario.' + 1 minutes') );
					
					if($ahora<$limite) 
						return "actividadNoTiempo";
					else 
						return "";
				}
				
			}
		}
	}
	else return "actividadNoFirmado";
}

function actualizaUsuarioActividad()
{
	@mysqli_query($GLOBALS["enlaceDB"] ,"update usuarios set ultimaoperacionusuario='".date("Y-m-d h:i:s")."' where id=".(int)$_SESSION["logged"]->id." limit 1");
}



?>