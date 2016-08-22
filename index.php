<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."ban.php");
include_once($API_folder."ret.php");
include_once($API_folder."noti.php");

$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);
$cabeza=abre_plantilla_API("cabeza",true);

$home=abre_plantilla_API("home",false);
$derechaBan=ban_base_lee(1);
$home=str_replace("<urlbanDerecha>",$derechaBan[0]->urlban,$home);
$home=str_replace("<targetbanDerecha>",$derechaBan[0]->targetban,$home);
$home=str_replace("<imagenbanDerecha>",$derechaBan[0]->imagenban,$home);

$vista_destacadas=extrae_vista_API("destacadas",$home);
$ban=ban_base_lee(0);
$vista_destacadasT=generaVistaRecursiva2015($vista_destacadas[1],$ban);
$home=str_replace($vista_destacadas[0],$vista_destacadasT,$home);
	
// para los cuadritos
$ret_cuadros=ret_lista_lee(array("modo"=>"disponible","grafico"=>"corto","destacada"=>true,"order"=>"rand()","numero_pagina"=>1,"items_por_pagina"=>8));
if(sizeof($ret_cuadros)>0)
{
	$cuadros=abre_plantilla_API("cuadros",false);
	$vista_cuadros=extrae_vista_API("cuadros",$cuadros);
	$vista_cuadrosA=extrae_vista_API("cuadrosA",$vista_cuadros[1]);
	$vista_cuadrosB=extrae_vista_API("cuadrosB",$vista_cuadros[1]);
	$vista_cuadrosT=generaVistaRecursivaAlternada($vista_cuadrosA[1],$vista_cuadrosB[1],$ret_cuadros);
	$cuadros=str_replace($vista_cuadros[0],$vista_cuadrosT,$cuadros);
}
else $cuadros="";

$homeAbajo=abre_plantilla_API("homeAbajo",true);
$abajoBan=ban_base_lee(2);
$homeAbajo=str_replace("<urlbanAbajo>",$abajoBan[0]->urlban,$homeAbajo);
$homeAbajo=str_replace("<targetbanAbajo>",$abajoBan[0]->targetban,$homeAbajo);
$homeAbajo=str_replace("<imagenbanAbajo>",$abajoBan[0]->imagenban,$homeAbajo);

$iniciativarenglon=abre_plantilla_API("iniciativarenglon",false);
$nuevasIniciativasArreglo=ret_lista_lee(array("modo"=>"disponible","grafico"=>"corto","order"=>"finicioret desc","numero_pagina"=>1,"items_por_pagina"=>10));
if(sizeof($nuevasIniciativasArreglo)>0)
	$nuevasIniciativas=generaVistaRecursiva($iniciativarenglon,$nuevasIniciativasArreglo);
else $nuevasIniciativas=abre_plantilla_API("nohay",false);
$homeAbajo=str_replace("<nuevasIniciativas>",$nuevasIniciativas,$homeAbajo);

$embajadoresArreglo=ret_lista_lee(array("tipo"=>"embajadores","modo"=>"disponible","grafico"=>"corto","order"=>"finicioret desc","numero_pagina"=>1,"items_por_pagina"=>10));
if(sizeof($embajadoresArreglo)>0)
	$embajadores=generaVistaRecursiva($iniciativarenglon,$embajadoresArreglo);
else $embajadores=abre_plantilla_API("nohay",true);
$homeAbajo=str_replace("<embajadores>",$embajadores,$homeAbajo);

$artistasArreglo=ret_lista_lee(array("tipo"=>"artistas","modo"=>"disponible","grafico"=>"corto","order"=>"finicioret desc","numero_pagina"=>1,"items_por_pagina"=>10));
if(sizeof($artistasArreglo)>0)
	$artistas=generaVistaRecursiva($iniciativarenglon,$artistasArreglo);
else $artistas=abre_plantilla_API("nohay",true);
$homeAbajo=str_replace("<artistas>",$artistas,$homeAbajo);

$empresasArreglo=ret_lista_lee(array("tipo"=>"empresas","modo"=>"disponible","grafico"=>"corto","order"=>"finicioret desc","numero_pagina"=>1,"items_por_pagina"=>10));
if(sizeof($empresasArreglo)>0)
	$empresas=generaVistaRecursiva($iniciativarenglon,$empresasArreglo);
else $empresas=abre_plantilla_API("nohay",true);
$homeAbajo=str_replace("<empresas>",$empresas,$homeAbajo);

$homeAbajo=str_replace("<vertodos>",$idiomas["Ver todos"],$homeAbajo);


$noticiarenglon=abre_plantilla_API("noticiarenglon",false);
$noticiasArreglo=noti_lee(array("order"=>"fechanoti desc","numero_pagina"=>1,"items_por_pagina"=>3));
if(sizeof($noticiasArreglo)>0)
	$noticias=generaVistaRecursiva($noticiarenglon,$noticiasArreglo);
else $noticias=abre_plantilla_API("nohay",false);
$homeAbajo=str_replace("<noticias>",$noticias,$homeAbajo);

$pie=abre_plantilla_API("pie",true);

$cabeza=str_replace("<titulopagina>",$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
//$cabeza=str_replace("<redes>",$redes,$cabeza);



$contenido=$cabezaPrincipal.$title.$cabeza.$home.$cuadros.$homeAbajo.$extra.$pie;
echo $contenido;


?>