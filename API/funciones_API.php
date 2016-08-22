<?
include_once($API_folder."idiomas.php");

function lee_idiomas_API($row_final,$tabla,$registro,$campos_idioma)
{
	if($_SESSION["idioma_actual"] <> 0)
	{
		$result_idioma = mysqli_query($GLOBALS["enlaceDB"] ,"select ".$campos_idioma." from ".$tabla."_i where iregistro=".$registro." and iidioma=".$_SESSION["idioma_actual"]);
		while( $row_idioma = mysqli_fetch_object( $result_idioma ))
			foreach($row_idioma as $key => $value) 
				$row_final -> $key = $value;
	}
	
	return $row_final;
}

function convierte_url_API($titulo,$complemento,$registro)
{
	global $idioma;
	
	if($complemento=="" && $registro==0)
	{
		$titulo =mb_strtolower($titulo);
		$titulo=html_entity_decode($titulo,ENT_COMPAT,"ISO-8859-1");
		$titulo=preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$titulo);
		$titulo = preg_replace("/[^a-z0-9_\s-]/", "", $titulo);
		$titulo = preg_replace("/[\s-]+/", " ", $titulo);
		$titulo = preg_replace("/[\s_]/", "-", $titulo);
		return $titulo;
	}
	
    else return $complemento."/".$idioma."/".$registro."/".$titulo.".html";
	
}

function convierte_url_API2015($url,$complemento,$id,$modoSin)
{
		
		// Tranformamos todo a minusculas
	$url =mb_strtolower($url);
	
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);
	
	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+');
	$url = str_replace ($find, '-', $url);
	
	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	
	if($complemento<>"")
		$url=$complemento."/".$id."/".$url;
	return $url; 
}

function str_replace_last( $search , $replace , $str ) {
	if( ( $pos = strrpos( $str , $search ) ) !== false ) {
		$search_length  = strlen( $search );
		$str    = substr_replace( $str , $replace , $pos , $search_length );
	}
	return $str;
}

function genera_imagen_API($cadena,$imagen_modo)
{
	global $esWeb;
	if(stripos($cadena,"http")===FALSE)
	{
		if($esWeb<>1 || $imagen_modo=="") $imagen_modo="C";
		
		$cadena = str_ireplace(".png","_".$imagen_modo.".png",$cadena);
		$cadena = str_ireplace(".jpg","_".$imagen_modo.".jpg",$cadena);
		$cadena = str_ireplace(".gif","_".$imagen_modo.".gif",$cadena);
		
		//esta línea se la añadí para dirigirlas a la ruta correcta
		if($esWeb==1)
			$cadena=str_replace_last('/', '/stock/', $cadena);
		
		$cadena="recursos/".$cadena;
	}
	return $cadena;
}


function lee_ingles($cadena,$i_cadena)
{
	global $idioma;
	if($cadena && $i_cadena && $i_cadena<>"") 
		$cadena=$i_cadena;
	return $cadena;
}

//anadi esta funcion para guardar los nombres de las imagenes
function genera_imagen_API2($cadena,$imagen_modo)
{
	//if(strpos($cadena,$imagen_modo)===FALSE)
	//{
		$cadena = str_ireplace(".png",$imagen_modo.".png",$cadena);
		$cadena = str_ireplace(".jpg",$imagen_modo.".jpg",$cadena);
		$cadena = str_ireplace(".gif",$imagen_modo.".gif",$cadena);
	//}
	return $cadena;
}


function generaBotonDirecto($archivo,$modo,$operacion,$texto,$id,$color,$tipoBoton)
{
	$elemento->tipotimeline="boton";
	if($tipoBoton && $tipoBoton<>"")
		$elemento->tipoBoton=$tipoBoton;
	else
		$elemento->tipoBoton="directo";
	$colorReal="#59A2EA";
	if($color==0) $colorReal="#999999";
	else if($color==2) $colorReal="#777777";
	else if($color==3) $colorReal="#5EAA8B";
	$elemento->color=$colorReal;
	$elemento->archivo=$archivo;
	$elemento->modo=$modo;
	$elemento->id=$id;
	$elemento->operacion=$operacion;
	$elemento->texto=$texto;
	return $elemento;
}

function mensajeIdioma($cual)
{
	global $idioma;
	$devolver="";
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select * from men where idmen='".$cual."'");
	if(mysqli_num_rows($res)>0)
	{
		while($row=mysqli_fetch_object($res))
		{
			if($idioma=="1" && $row->i_textomen<>"") // es ingles
				$devolver=$row->i_textomen;
			else $devolver=$row->textomen;
		}
	}
	else $devolver=$cual;
	return utf8_encode($devolver);
}

function hacebit($itbitbit,$tablabit,$registrobit)
{
	@mysqli_query($GLOBALS["enlaceDB"] ,"insert into bit set itbitbit=".$itbitbit.",tablabit=".$tablabit.",registrobit=".$registrobit.",iusuariobit=".(int)$_SESSION["logged"]->id.",iusuariocmsbit=".(int)$_SESSION["sesionid"]);
}
?>