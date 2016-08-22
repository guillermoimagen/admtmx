<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."ret.php");
include_once($API_folder."cat.php");

$condiciones=array();
$condiciones["grafico"]="largo";
$urlComplemento="";

$titulo=$idiomas["Iniciativas"];
	
if(isset($_GET["tipo"]))
{
	$urlComplemento.="&tipo=".htmlentitiesMemoStrong($_GET["tipo"]);
	$condiciones["tipo"]=mysqli_real_escape_stringMemo($_GET["tipo"]);
	$titulo=$idiomas["tipo_".htmlentitiesMemoStrong($_GET["tipo"])];
}

if(!isset($_GET["modo"]) || $_GET["modo"]=="0")
	$_GET["modo"]="validada";
$urlComplemento.="&modo=".htmlentitiesMemoStrong($_GET["modo"]);
$condiciones["modo"]=mysqli_real_escape_stringMemo($_GET["modo"]);

if($_GET["modo"]<>"vigente")
	$titulo.=" | ".$modos_idiomas[htmlentitiesMemoStrong($_GET["modo"])];

if(!isset($_GET["order"])) $order="0";
else $order=(int)$_GET["order"];
$urlComplemento.="&order=".$order;
$condiciones["ordernum"]=(string)$order;

if(isset($_GET["destacada"]))
{
	$urlComplemento.="&destacada=".(int)$_GET["destacada"];
	$condiciones["destacada"]=(int)$_GET["destacada"];
	$titulo.=" | ".$idiomas["Destacadas"];
}

if(isset($_GET["mia"]))
{
	$urlComplemento.="&mia=".(int)$_GET["mia"];
	$condiciones["mia"]=(int)$_GET["mia"];
	$titulo.=" | ".$idiomas["Mias"];
}

if(isset($_GET["cat"]) && $_GET["cat"]<>"0")
{
	$urlComplemento.="&cat=".(int)$_GET["cat"];
	$condiciones["cat"]=(int)$_GET["cat"];
	$cat_leida=cat_lee((int)$_GET["cat"]);
	$titulo.=" | ".$cat_leida[0]->nombrecat;
}

if(isset($_GET["estado"]) && $_GET["estado"]<>"0")
{
	$urlComplemento.="&estado=".(int)$_GET["estado"];
	$condiciones["estado"]=(int)$_GET["estado"];
	$es=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreestado from estados where id=".(int)$_GET["estado"]);
	$ow=mysqli_fetch_object($es);
	$titulo.=" | ".$ow->nombreestado;
}

if(isset($_GET["palabra"]) && $_GET["palabra"]<>"")
{
	$urlComplemento.="&palabra=".htmlentitiesMemoStrong($_GET["palabra"]);
	$condiciones["palabra"]=mysqli_real_escape_stringMemo($_GET["palabra"]);
	$titulo.=" | ".$idiomas["Palabra buscada"].": ".htmlentitiesMemoStrong($_GET["palabra"]);
}


$urlComplemento.="&idioma=".$idioma;

if(!isset($_GET["pagina"])) $_GET["pagina"]=1;

$condiciones["items_por_pagina"]=20;

if((int)$_GET["pagina"]==0) $_GET["pagina"]=1;
$condiciones["numero_pagina"]=(int)$_GET["pagina"];

$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);

$cabeza=abre_plantilla_API("cabeza",true);

$contenido=abre_plantilla_API("iniciativas",false);
$vista_iniciativas=extrae_vista_API("iniciativas",$contenido);
$vista_cat=extrae_vista_API("cat",$contenido);


$condiciones["cuenta"]=true;
$iniciativasArreglo=ret_lista_lee($condiciones);
$titulo.=" (".$cuentaIniciativas.")";
$contenido=str_replace("<titulo>",$titulo,$contenido);

if(sizeof($iniciativasArreglo)>0)	
$vista_iniciativasT=generaVistaRecursiva2015($vista_iniciativas[1],$iniciativasArreglo);
$contenido=str_replace($vista_iniciativas[0],$vista_iniciativasT,$contenido);

$cat=cat_lee("destacadas",$urlComplemento,(int)$_GET["cat"]);
if(sizeof($cat)>0)
{
	$vista_catT=generaVistaRecursiva2015($vista_cat[1],$cat);
	$contenido=str_replace($vista_cat[0],$vista_catT,$contenido);
}



$contenido=str_replace("<urlComplemento>",$urlComplemento,$contenido);
$contenido=str_replace("<paginador>",pintaPaginador($cuentaIniciativas,(int)$_GET["pagina"],20,$urlComplemento),$contenido);


$noencontrado="";
if(sizeof($iniciativasArreglo)==0) 
{
	$noencontrado=abre_plantilla_API("noencontrado",false);
	$noencontrado=str_replace("<aviso>",$idiomas["Informacion no encontrada"],$noencontrado);
}
else $contenido=str_replace("<ordenador>",pintaOrdenador($order,$urlComplemento),$contenido);
$contenido=str_replace("<noencontrado>",$noencontrado,$contenido);

$pie=abre_plantilla_API("pie",true);




$cabeza=str_replace("<titulopagina>",$titulo." | ".$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
//$cabeza=str_replace("<redes>",$redes,$cabeza);

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
		$nuevaURL="iniciativasListado.php?pagina=1".str_replace("&order=".$actual,"&order=".$i,$urlComplemento);
		$cadena1.="<a href='".$nuevaURL."'><strong>".$b.$ordenadores[$i].$bc."</strong></a>";
		$cadena2.="<option value='".$nuevaURL."'".$sel.">".$ordenadores[$i]."</option>";
	}

	$cadena=$idiomas["Ordenar por"].'<div class="ordensitio">'.$cadena1.'</div><div class="selectipad"><select onchange="cargaIniciativas(this.value);">'.$cadena2.'</select></div>';
	return $cadena;
}

function pintaPaginador($cuenta,$actual,$pp,$url)
{
	$totalPaginas=round($cuenta/$pp);
	
	if($cuenta>$pp)
	{
		if($pp*$totalPaginas<$cuenta) $totalPaginas++;
		$url="iniciativasListado.php?".$url."&pagina=";
		
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