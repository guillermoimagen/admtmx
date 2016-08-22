<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."usuarios.php");

$condiciones=array();
$condiciones["order"]="nickusuario asc";
$urlComplemento="";

$titulo=$idiomas["Usuarios"];
	
if(isset($_GET["tipo"]))
{
	$urlComplemento.="&tipo=".htmlentitiesMemoStrong($_GET["tipo"]);
	if($_GET["tipo"]=="embajadores") $tip=1;
	else if($_GET["tipo"]=="artistas") $tip=2;
	else if($_GET["tipo"]=="empresas") $tip=3;
	
	$condiciones["sql_extra"].=" and itusuusuario=".$tip;
	$titulo=$idiomas[htmlentitiesMemoStrong($_GET["tipo"])];
}

if(isset($_GET["palabra"]) && $_GET["palabra"]<>"")
{
	$urlComplemento.="&palabra=".htmlentitiesMemoStrong($_GET["palabra"]);
	$condiciones["sql_extra"].=" and nickusuario like '%".mysqli_real_escape_stringMemo($_GET["palabra"])."%'";
	$titulo.=" | ".$idiomas["Palabra buscada"].": ".htmlentitiesMemoStrong($_GET["palabra"]);
}

$condiciones["sql_extra"].=" and validadousuario='1'";

$urlComplemento.="&idioma=".$idioma;

if(!isset($_GET["pagina"])) $_GET["pagina"]=1;

$condiciones["items_por_pagina"]=20;
if((int)$_GET["pagina"]==0) $_GET["pagina"]=1;
$condiciones["numero_pagina"]=(int)$_GET["pagina"];

$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);

$cabeza=abre_plantilla_API("cabeza",true);

$contenido=abre_plantilla_API("usuarios",false);
$vista_usuarios=extrae_vista_API("usuarios",$contenido);

$condiciones["cuenta"]=true;
$usuariosArreglo=usuarios_especial_lee($condiciones);
$titulo.=" (".$cuentaUsuarios.")";
$contenido=str_replace("<titulo>",$titulo,$contenido);

if(sizeof($usuariosArreglo)>0)	
$vista_usuariosT=generaVistaRecursiva2015($vista_usuarios[1],$usuariosArreglo);
$contenido=str_replace($vista_usuarios[0],$vista_usuariosT,$contenido);

$contenido=str_replace("<paginador>",pintaPaginador($cuentaUsuarios,(int)$_GET["pagina"],20,$urlComplemento),$contenido);

$noencontrado="";
if(sizeof($usuariosArreglo)==0) 
{
	$noencontrado=abre_plantilla_API("noencontrado",false);
	$noencontrado=str_replace("<aviso>",$idiomas["Informacion no encontrada"],$noencontrado);
}
$contenido=str_replace("<noencontrado>",$noencontrado,$contenido);

$pie=abre_plantilla_API("pie",true);

$cabeza=str_replace("<titulopagina>",$titulo." | ".$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);

$contenido=$cabezaPrincipal.$cabeza.$contenido.$cuadros.$extra.$pie;

echo $contenido;


function pintaOrdenador($actual,$urlComplemento)
{
	global $idioma;
	global $idiomas;
	global $ordenadores;
	
	
	$cadena1="";
	$cadena2="";
	for($i=0; $i<=3; $i++)
	{
		$b="";
		$bc="";
		$sel="";
		if($actual==$i)
		{
			$b="<b>";
			$bc="</b>";
			$sel=" selected";
		}
		$urlNuevo=str_replace("&orden=".$actual,"&orden=".$i,$urlComplemento);
		$cadena1.="<strong onClick='cargaIniciativas(\"order\",".$i.");'>".$b.$ordenadores[$i].$bc."</strong>";
		$cadena2.="<option value='".$i."'".$sel.">".$ordenadores[$i]."</option>";
	}

	$cadena=$idiomas["Ordenar por"].'<div class="ordensitio">'.$cadena1.'</div><div class="selectipad"><select onchange="cargaIniciativas(\'order\',this.value);">'.$cadena2.'</select></div>';
	return $cadena;
}

function pintaPaginador($cuenta,$actual,$pp,$url)
{
	$totalPaginas=round($cuenta/$pp);
	
	if($cuenta>$pp)
	{
		if($pp*$totalPaginas<$cuenta) $totalPaginas++;
		$url="usuariosListado.php?".$url."&pagina=";
		
		$cadena='<div class="pagina_div">';
		if($actual>1) $cadena.='<a href="'.$url.round($actual-1).'"><div class="num_pag"><strong class="sii"><</strong><strong class="noo">&lt;</strong></div></a>';
		
		$pintardespues=0;
		for($i=$actual-2; $i<=$actual+2; $i++)
		{
			if($i>0 && $i<=$totalPaginas)
			{
				$pintarActual="";
				if($i==$actual)
					$pintarActual=" pag_actual";
				$cadena.='<a href="'.$url.$i.'"><div class="num_pag '.$pintarActual.'">'.$i.'</div>';
			}
			else if($i<=0)
				$pintardespues++;
		}
		for($i=1; $i<=$pintardespues; $i++)
		{
			if($i+$actual+2<=$totalPaginas)
				$cadena.='<a href="'.$url.round($i+$actual+2).'"><div class="num_pag">'.round($i+$actual+2).'</div>';
		}
			
			
		if($actual<$totalPaginas) $cadena.='<a href="'.$url.round($actual+1).'"><div class="num_pag")"><strong class="sii">></strong><strong class="noo">&gt;</strong></div></a>';
		$cadena.='</div>';
	}
	else $cadena="";
	return $cadena;
}
?>