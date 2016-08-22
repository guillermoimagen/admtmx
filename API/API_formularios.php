<?
function formLeeAyuda($campo)
{
	global $idioma;
	
	$ayu->texto="";
	$ayu->place="";
	$ayu->label="";
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select labelayu,textoayu,placeholderayu,i_labelayu,i_textoayu,i_placeholderayu from ayu where campoayu='".$campo."'");
	while($row=mysqli_fetch_object($res))
	{
		if($idioma==1 && $row->i_labelayu<>"") $ayu->label=utf8_encode($row->i_labelayu);
		else $ayu->label=utf8_encode($row->labelayu);
		
		if($idioma==1 && $row->i_textoayu<>"") $ayu->ayuda=utf8_encode($row->i_textoayu);
		else $ayu->ayuda=utf8_encode($row->textoayu);
		
		if($idioma==1 && $row->i_placeholderayu<>"") $ayu->place=utf8_encode($row->i_placeholderayu);
		else $ayu->place=utf8_encode($row->placeholderayu);
	}
	return $ayu;
}

function formCampoTextoMemo($modo,$nombre,$registro,$operacion,$label,$minimo,$maximo,$requerido,$default,$password,$validaciones)
{
	if($modo=="memo") $elemento->tipotimeline="memo";
	else $elemento->tipotimeline="textfield";
	$elemento->subtipotimeline=$modo;
	$elemento->base="form";
	$elemento->campo="tab_".$nombre."_as";
	
	$ayuda=formLeeAyuda($nombre);
	if($ayuda->label<>"") $label=$ayuda->label;
	$elemento->label=$label;
	$elemento->ayuda=$ayuda->ayuda;
	$elemento->place=$ayuda->place;
	
	$elemento->password=$password;
	$elemento->validaciones=$validaciones;
	if($minimo<>"")
		$elemento->minimo=$minimo;
	if($maximo<>"")	
		$elemento->maximo=$maximo;
	if($operacion=="editar" && sizeof($registro)>0) 
		$elemento->valor=$registro[0]->$nombre; 
	else $elemento->valor=$default;
	if($requerido)
		$elemento->requerido=true;
	return $elemento;
}

function formCampoColor($nombre,$registro,$operacion,$label,$default)
{
	$elemento->tipotimeline="color";
	$elemento->base="form";
	$elemento->campo="tab_".$nombre."_as";
	$ayuda=formLeeAyuda($nombre);
	if($ayuda->label<>"") $label=$ayuda->label;
	$elemento->label=$label;
	$elemento->ayuda=$ayuda->ayuda;
	$elemento->place=$ayuda->place;
	if($operacion=="editar" && sizeof($registro)>0) 
		$elemento->valor=$registro[0]->$nombre; 
	else $elemento->valor=$default;
	return $elemento;
}

function formCampoImagef($nombre,$registro,$operacion,$label,$default,$requerido,$tablafoto,$idregistrofoto,$cfoto)
{
	$elemento->tipotimeline="imagef";
	$elemento->base="form";
	$elemento->archivo="imagenes";
	$elemento->campo="tab_".$nombre."_as";
	$ayuda=formLeeAyuda($nombre);
	if($ayuda->label<>"") $label=$ayuda->label;
	$elemento->label=$label;
	$elemento->ayuda=$ayuda->ayuda;
	$elemento->place=$ayuda->place;
	
	$elemento->tablafoto=$tablafoto;
	$elemento->cfoto=$cfoto;
	
	$editar=true;
	if($_SESSION["logged"]->est<>0) //hay establecimiento
	{
		if($nombre=="fotoemp") // si es empleado
			$editar=true;
		else $editar=false;	
	}
	$elemento->editar=$editar;
	
	if($operacion=="editar" && sizeof($registro)>0) 
		$elemento->idregistrofoto=$registro[0]->idreal; 
	else $elemento->idregistrofoto=$idregistrofoto;
	
	if($operacion=="editar" && sizeof($registro)>0) 
		$elemento->valor=$registro[0]->$nombre; 
	else $elemento->valor=$default;
	if($requerido)
		$elemento->requerido=true;
	return $elemento;
}

// cadenaURL y cadenaCampo son para pickers encadenados
function formCampoSelector($modo,$nombre,$registro,$operacion,$label,$default,$opciones,$requerido,$cadenaURL,$cadenaCampo)
{
	if($modo=="sino" || $modo=="activo" || $modo=="segmented")
		$elemento->tipotimeline="segmented";
	else if($modo=="picker")
	 	$elemento->tipotimeline="picker";
	else $elemento->tipotimeline="radio";
	 
	$elemento->base="form";
	$elemento->campo="tab_".$nombre."_as";
	$elemento->cadenaURL=$cadenaURL;
	$elemento->cadenaCampo=$cadenaCampo;
	$ayuda=formLeeAyuda($nombre);
	if($ayuda->label<>"") $label=$ayuda->label;
	$elemento->label=$label;
	$elemento->ayuda=$ayuda->ayuda;
	$elemento->place=$ayuda->place;
	
	if($modo=="sino")
	{
		unset($opcion);
		$opcion->label="No";
		$opcion->valor="0";
		$elemento->opciones[]=$opcion;
		unset($opcion);
		$opcion->label="Si";
		$opcion->valor="1";
		$elemento->opciones[]=$opcion;
	}
	else if($modo=="activo")
	{
		unset($opcion);
		$opcion->label="Inactivo";
		$opcion->valor="0";
		$elemento->opciones[]=$opcion;
		unset($opcion);
		$opcion->label="Activo";
		$opcion->valor="1";
		$elemento->opciones[]=$opcion;
	}
	else
		$elemento->opciones=$opciones;
	if($operacion=="editar" && sizeof($registro)>0 && isset($registro[0]->$nombre)) 
		$elemento->valor=$registro[0]->$nombre; 
	else $elemento->valor=$default;
	if($requerido)
		$elemento->requerido=true;
	return $elemento;
	/*
	ENCADENADOS
	$opcionesX=estados_lee(array("campos"=>"nombreestado as label,id as valor"));
	array_unshift($opcionesX,array("label"=>"Selecciona...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","iestadousuario",$registro,$operacion,"Estado asignado","0",$opcionesX,false,"estados.php?operacion=municipios&idreal=","imunicipiousuario");
	
	$opcionesX2=array();
	array_unshift($opcionesX2,array("label"=>"Selecciona...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","imunicipiousuario",$registro,$operacion,"Municipio asignado","0",$opcionesX2,false,"estados.php?operacion=colonias&idreal=","icoloniausuario");
	
	$opcionesX3=array();
	array_unshift($opcionesX3,array("label"=>"Selecciona...","valor"=>"0"));
	$formulario[]=formCampoSelector("picker","icoloniausuario",$registro,$operacion,"Colonia asignado","0",$opcionesX3,false);
	*/
}

function formCampoFecha($nombre,$registro,$operacion,$label,$minimo,$maximo,$default)
{
	unset($elemento);
	if($nombre=="fechaRango")
		$elemento->tipotimeline="fechaRango";
	else $elemento->tipotimeline="fecha";
	$elemento->base="form";
	$elemento->campo="tab_".$nombre."_as";

	$ayuda=formLeeAyuda($nombre);
	if($ayuda->label<>"") $label=$ayuda->label;
	$elemento->label=$label;
	$elemento->ayuda=$ayuda->ayuda;
	$elemento->place=$ayuda->place;
	
	if($minimo<>"")
		$elemento->minimo=$minimo;
	if($maximo<>"")	
		$elemento->maximo=$maximo;
		
	if($operacion=="editar" && sizeof($registro)>0 && $registro[0]->$nombre<>"" && $registro[0]->$nombre<>"0000-00-00") 
		$elemento->valor=$registro[0]->$nombre; 
	else if($default=="") $elemento->valor="";
	else $elemento->valor=$default;
	
	if($nombre=="fechaRango")
		$elemento->valor2=$elemento->valor;
	return $elemento;
}

function formSubtitulo($nombre)
{
	unset($elemento);
	$elemento->tipotimeline="subtitulo";

	$label="";
	$ayuda=formLeeAyuda($nombre);
	if($ayuda->label<>"") $label=$ayuda->label;
	
	if($nombre=="headerret")
	{
		$elemento->label=$ayuda->ayuda;
	}
	else
	{
		$elemento->label=$label;
		$elemento->ayuda=$ayuda->ayuda;
	}
	return $elemento;
}

function evaluaFormulario($arreglo)
{
	global $idioma;
	global $camposIdiomas;
	global $textoIngles;
	$esRequerido=" es requerido";
	$debeTenerAlMenos=" debe tener al menos ";
	$debeTenerComoMaximo=" debe tener como máximo ";
	$letras=" letra(s)";
	$debeSerAlMenos=" debe ser al menos ";
	$debeSerMaximo=" debe ser máximo ";
	if($idioma==1) 
	{
		$esRequerido=" is required";
		$debeTenerAlMenos=" should be at least ";
		$debeTenerComoMaximo=" should be maximum ";
		$letras=" letter(s)";
		$debeSerAlMenos=" should be bigger than ";
		$debeSerMaximo=" should be smaller than ";
	}
	$error="";
	$cadena="";
	for($i=0; $i<=sizeof($arreglo)-1; $i++)
	{
		if($arreglo[$i]->base=="form")
		{
			$campo=$arreglo[$i]->campo;
			$label=$arreglo[$i]->label;
			$tipotimeline=$arreglo[$i]->tipotimeline;
			$subtipotimeline=$arreglo[$i]->subtipotimeline;
			$minimo=$arreglo[$i]->minimo;
			$maximo=$arreglo[$i]->maximo;
			$requerido=$arreglo[$i]->requerido;
			$valorNuevo=utf8_decode(mysqli_real_escape_stringMemoPost($_POST[$campo]));
			
			// lo quitamos el extra al campo
			$campo=substr($campo,4,strlen($campo)-7);
			
			if($tipotimeline=="textfield" || $tipotimeline=="memo")
			{
				if($subtipotimeline=="texto" || $tipotimeline=="memo")
				{
					if($minimo)
					{
						if(strlen($valorNuevo)<$minimo)
							$error=$label.$debeTenerAlMenos.$minimo.$letras;
					}
					if($maximo && $error=="")
					{
						if(strlen($valorNuevo)>$maximo)
							$error=$label.$debeTenerComoMaximo.$maximo.$letras;
					}
					
					if($requerido && $error=="")
					{
						if(strlen($valorNuevo)==0)
							$error=$label.$esRequerido;
					}
				}
				else if($subtipotimeline=="int" || $subtipotimeline=="float")
				{
					if($subtipotimeline=="int")
						$valorNuevo=(int)$valorNuevo;
					else if($subtipotimeline=="int")
						$valorNuevo=(double)$valorNuevo;
						
					if($minimo)
					{
						if($valorNuevo<$minimo)
							$error=$label.$debeSerAlMenos.$minimo;
					}
					if($maximo && $error=="")
					{
						if($valorNuevo>$maximo)
							$error=$label.$debeSerMaximo.$maximo;
					}
					if($requerido && $error=="")
					{
						if(strlen($valorNuevo)==0)
							$error=$label.$esRequerido;
					}
				}
			}
			else if($tipotimeline=="fecha")
			{
				if($minimo)
				{
					if($valorNuevo<$minimo)
						$error=$label.$debeSerAlMenos.$minimo;
				}
				if($maximo && $error=="")
				{
					if($valorNuevo>$maximo)
						$error=$label.$debeSerMaximo.$maximo;
				}
				if($requerido && $error=="")
				{
					if(strlen($valorNuevo)==0)
						$error=$label.$esRequerido;
				}				
			}
			else if($tipotimeline=="color" && strlen($valorNuevo)==0)
			{
				$error=$label.$esRequerido;				
			}
			else if($tipotimeline=="picker" && $requerido && $error=="" && $valorNuevo==0)
			{
				$error=$label.$esRequerido;			
			}
			else if($tipotimeline=="segmented" && $requerido && $error=="" && strlen($valorNuevo)==0)
			{
				$error=$label.$esRequerido;			
			}
			else if($tipotimeline=="imagef" && $requerido && $error=="" && strlen($valorNuevo)==0)
			{
				$error=$label.$esRequerido;			
			}
			
			if($arreglo[$i]->password=="password")
			{
				if($valorNuevo<>"")  // trae contrasena, encriptemosla
				{
					if($cadena<>"") $cadena.=",";
					$cadena.=$campo."='".md5($valorNuevo)."'";
				}
			}
			else
			{
				if($cadena<>"") $cadena.=",";
				$campoUsar=$campo;
				
				// estamos guardando ingles, entonces vamos a guardar en los i_ si es que el campo esta en camposIdiomas
				if($textoIngles=="si")
				{
					if(in_array($campo,$camposIdiomas))
						$campoUsar="i_".$campo;
				}
				$cadena.=$campoUsar."='".$valorNuevo."'";
			}
		}
		
		if($error<>"") break;
	}
	$respuesta->error=$error;
	$respuesta->cadena=$cadena;
	return $respuesta;
}

function revisaGets()
{
	if((isset($_GET["operacion"]) && $_GET["operacion"]<>"agregar" && $_GET["operacion"]<>"editar") || (isset($_GET["accion"]) && $_GET["accion"]<>"guardar") || (isset($_GET["modo"]) && strlen($_GET["modo"])>25) || (isset($_GET["modoIdioma"]) && $_GET["modoIdioma"]<>"otro" && $_GET["modoIdioma"]<>"actual"))
	{
		exit();
	}
}


?>