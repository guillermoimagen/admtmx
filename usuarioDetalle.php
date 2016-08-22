<?
include("include/connection.php");
$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."usuarios.php");
include_once($API_folder."ret.php");
include_once($API_folder."don.php");

$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);
$cabeza=abre_plantilla_API("cabeza",true);


$sepudo=false;
$sql_extra_url="";
if(isset($_GET["urlamigable"]))
	$sql_extra_url=" and urlusuario='".mysqli_real_escape_stringMemo($_GET["urlamigable"])."'";
	
$usuarios=usuarios_lee(array("sql_extra"=>"activo=1 and (validadousuario='1' or validadousuario='2') and id=".(int)$_GET["idregistro"].$sql_extra_url));
if(sizeof($usuarios)>0)
{
	$sepudo=true;
	$contenido=abre_plantilla_API("usuarioDetalle",false);
	$vista_iniciativas=extrae_vista_API("iniciativas",$contenido);
		
	$usuarios[0]->donarenalcancia=$idiomas["Donar en alcancia"].$usuarios[0]->nickusuario;
	$usuarios[0]->editar=$idiomas["Editar"];
	$usuarios[0]->importe=$idiomas["Importe"];
	$usuarios[0]->donaciones=$idiomas["Donaciones"];
	$usuarios[0]->donacionesrecibidas=$idiomas["Donaciones recibidas"];
	$usuarios[0]->share=generaShareButtons($usuarios[0]->urlAmigableusuario);	
	$usuarios[0]->colorcat="#9B539C";
	$usuarios[0]->reportar=$idiomas["Reportar"];
	$usuarios[0]->displayeditar="none";
	$usuarios[0]->displayeditarreportar="none";
	if($_SESSION["logged"]->id==$usuarios[0]->idreal || $_SESSION["logged"]->cms==1)
		$usuarios[0]->displayeditar="block";
	if($_SESSION["logged"]->id<>$usuarios[0]->idreal && $_SESSION["logged"]->cms<>1)
		$usuarios[0]->displayeditarreportar="block";

	
	$usuarios[0]->botonverreporte="";
	$iniciativaDetalleArreglo[0]->botonverbit="";
	if($_SESSION["logged"]->cms==1) //  && 
	{
		$usuarios[0]->botonesExtras.='<div class="btn_donar" style="background-color:#19AD90; display:block" onclick="subeTuIniciativa('.(int)$_GET["idregistro"].');">Subir iniciativa</div>';

		if($_SESSION["logged"]->id==$usuarios[0]->idreal)
		{
			$usuarios[0]->botonesExtras.='<a href="iniciativasListado.php?&modo=pendiente&estado=0&cat=0&palabra="><div class="btn_donar" style="background-color:#19AD90; display:block">Iniciativas pendientes</div></a><a href="comentarios.php"><div class="btn_donar" style="background-color:#19AD90; display:block">Comentarios pendientes</div></a>';

		}
		
		$r=@mysqli_query($GLOBALS["enlaceDB"] ,"select id from rep where iusuarioreportadorep=".(int)$_GET["idregistro"]." and statusrep='0'");
		while($rr=mysqli_fetch_object($r))
			$usuarios[0]->botonverreporte='<div class="btn_vercompleta" style="float:left !important;" onclick="verReporte('.$rr->id.');">Ver reporte</div>';
		$usuarios[0]->botonverbit='<div class="btn_vercompleta" style="float:left;" onclick="verBits('.$usuarios[0]->idreal.',\'usuario\');">Ver hist&oacute;rico</div>';
		
	}
	
	if($_SESSION["firmado"])
	{	
	
		$otrasIniciativasArreglo=ret_lista_lee(array("modo"=>"disponible","grafico"=>"corto","order"=>"destacadoret desc,statusret desc","numero_pagina"=>1,"items_por_pagina"=>5,"recomendados"=>"cerca"));
		if(sizeof($otrasIniciativasArreglo)>0)
			$otrasiniciativas=generaVistaRecursiva($vista_iniciativas[1],$otrasIniciativasArreglo);
		$usuarios[0]->destacadas=$idiomas["Puede interesarte"];
		
		/*
		$sql_quitar="";
		for($i=0; $i<=sizeof($otrasIniciativasArreglo)-1; $i++)
			$sql_quitar.=" and ret.id<>".$otrasIniciativasArreglo[$i]->idreal;	

		$otrasIniciativasArreglo=ret_lista_lee(array("modo"=>"disponible","grafico"=>"corto","order"=>"destacadoret desc,statusret desc","numero_pagina"=>1,"items_por_pagina"=>5,"sql_extra"=>$sql_quitar,"recomendados"=>"categoria"));
		if(sizeof($otrasIniciativasArreglo)>0)
		{
			$otrasiniciativas.='<br><div class="bar_ini">'.$idiomas["Puede interesarte"].'</div><div style="background-color:#F9F9F9; padding:5px;">';
			$otrasiniciativas.=generaVistaRecursiva($vista_iniciativas[1],$otrasIniciativasArreglo)."</div>";
		}
*/
		$contenido=str_replace($vista_iniciativas[0],$otrasiniciativas,$contenido);
	}
	else
	{
		$nuevasIniciativasArreglo=array();
		$nuevasIniciativasArreglo=ret_lista_lee(array("modo"=>"vigente","destacada"=>true,"grafico"=>"corto","order"=>"destacadoret desc,statusret desc","numero_pagina"=>1,"items_por_pagina"=>3));	
		if(sizeof($nuevasIniciativasArreglo)>0)
			$vista_iniciativasT=generaVistaRecursiva($vista_iniciativas[1],$nuevasIniciativasArreglo);
		$usuarios[0]->destacadas=$idiomas["Destacadas"];
		$contenido=str_replace($vista_iniciativas[0],$vista_iniciativasT,$contenido);
	}
	
	// leamos los donadores
	$vistasExtras="";
	$vistaBase=abre_plantilla_API("vistaIniciativasPerfil",false);
	if($_SESSION["logged"]->cms || $_SESSION["logged"]->id==$usuarios[0]->idreal)
		$vistaBaseDetalle=abre_plantilla_API("vistaDetalleIniciativasPerfil",false);
	else $vistaBaseDetalle=$vistaBase;
	
	$vistaDona=extrae_vista_API("dona",$vistaBase);
	$vistaDonaDetalle=extrae_vista_API("dona",$vistaBaseDetalle);
	
	$misdonaciones=don_lee_especial(array("grafico"=>"usuario","idusuario"=>$usuarios[0]->idreal,"leerDetalle"=>1,"sql_extra"=>" and ganadordon=0"));
	if(sizeof($misdonaciones)>0)
	{
		$vistaDonaT=generaVistaRecursiva($vistaDonaDetalle[1],$misdonaciones);
		$vistaMisDonaciones=str_replace($vistaDonaDetalle[0],$vistaDonaT,$vistaBaseDetalle);
		$vistaMisDonaciones=str_replace("<titulo>",$idiomas["Donaciones"],$vistaMisDonaciones);
	}
	else $vistaMisDonaciones="";
	
	$misganadores=don_lee_especial(array("grafico"=>"usuario","sql_extra"=>" and ganadordon>=1 and itusuusuario=1","idusuario"=>$usuarios[0]->idreal,"leerDetalle"=>1));
	if(sizeof($misganadores)>0)
	{
		$vistaDonaT=generaVistaRecursiva($vistaDonaDetalle[1],$misganadores);
		$vistaMisGanadores=str_replace($vistaDonaDetalle[0],$vistaDonaT,$vistaBaseDetalle);
		$vistaMisGanadores=str_replace("<titulo>",$idiomas["Ganador Iniciativas"],$vistaMisGanadores);
	}
	else $vistaMisGanadores="";
	
	$misganadoresArtistas=don_lee_especial(array("grafico"=>"usuario","sql_extra"=>" and ganadordon>=1 and itusuusuario=2","idusuario"=>$usuarios[0]->idreal,"leerDetalle"=>1));
	if(sizeof($misganadoresArtistas)>0)
	{
		$vistaDonaT=generaVistaRecursiva($vistaDonaDetalle[1],$misganadoresArtistas);
		$vistaMisGanadoresArtistas=str_replace($vistaDonaDetalle[0],$vistaDonaT,$vistaBaseDetalle);
		$vistaMisGanadoresArtistas=str_replace("<titulo>",$idiomas["Ganador Artistas"],$vistaMisGanadoresArtistas);
	}
	else $vistaMisGanadoresArtistas="";
	
	$misganadoresEmpresas=don_lee_especial(array("grafico"=>"usuario","sql_extra"=>" and ganadordon>=1 and itusuusuario=3","idusuario"=>$usuarios[0]->idreal,"leerDetalle"=>1));
	if(sizeof($misganadoresEmpresas)>0)
	{
		$vistaDonaT=generaVistaRecursiva($vistaDonaDetalle[1],$misganadoresEmpresas);
		$vistaMisGanadoresEmpresas=str_replace($vistaDonaDetalle[0],$vistaDonaT,$vistaBaseDetalle);
		$vistaMisGanadoresEmpresas=str_replace("<titulo>",$idiomas["Ganador Empresas"],$vistaMisGanadoresEmpresas);
	}
	else $vistaMisGanadoresEmpresas="";
	
	if($_SESSION["firmado"] && ($_SESSION["logged"]->cms==1 || $_SESSION["logged"]->id==$usuarios[0]->idreal))
	{
		$mispendientes=don_lee_especial(array("grafico"=>"usuario","idusuario"=>$usuarios[0]->idreal,"statusdon"=>"0","leerDetalle"=>1));
		if(sizeof($mispendientes)>0)
		{
			$vistaDonaT=generaVistaRecursiva($vistaDonaDetalle[1],$mispendientes);
			$vistaMisPendientes=str_replace($vistaDonaDetalle[0],$vistaDonaT,$vistaBaseDetalle);
			$vistaMisPendientes=str_replace("<titulo>",$idiomas["Pendientes de pago"],$vistaMisPendientes);
		}
		else $vistaMisPendientes="";
	}
	else $vistaMisPendientes="";
	
	$vistasExtras=$vistaMisGanadoresArtistas.$vistaMisGanadoresEmpresas.$vistaMisGanadores.$vistaMisDonaciones.$vistaMisPendientes; // $
	
	if($_SESSION["logged"]->id==$usuarios[0]->idreal || $_SESSION["logged"]->cms==1)
	{
		$sqls=array("gusta"," and statusret=1"," and statusret=3"," and statusret=0"," and statusret=2");
		$titulos=array($idiomas["Me gusta"],$idiomas["Iniciativas"],$modos_idiomas["noenviadas"],$modos_idiomas["pendiente"],$modos_idiomas["rechazada"]);
	}
	else
	{
		$sqls=array("gusta"," and statusret=1");
		$titulos=array($idiomas["Me gusta"],$idiomas["Iniciativas"]);
	}
	for($i=0; $i<=sizeof($sqls)-1; $i++)
	{
		$misiniciativas=ret_lee_especial(array("grafico"=>"iniciativas","idusuario"=>$usuarios[0]->idreal,"sql_extra"=>$sqls[$i]));
		if(sizeof($misiniciativas)>0)
		{
			$vistaDonaT=generaVistaRecursiva($vistaDona[1],$misiniciativas);
			$vista=str_replace($vistaDona[0],$vistaDonaT,$vistaBase);
			$vista=str_replace("<titulo>",$titulos[$i],$vista);
			$vistasExtras.=$vista;
		}
		
	}
	
	$usuarios[0]->vistasExtras=$vistasExtras;
	
    $contenido=generaVistaRecursiva($contenido,$usuarios);                   	
								
	$redes=generaRedes($usuarios[0]->nickusuario,
							$usuarios[0]->imagenusuario,
							"",
							$usuarios[0]->urlAmigableusuario);
							

}	

if(!$sepudo) 
{
	$e404=true;
	$contenido=abre_plantilla_API("noencontrado",false);
	$contenido=str_replace("<aviso>",$idiomas["Informacion no encontrada"],$contenido);
}
$pie=abre_plantilla_API("pie",true);

$cabeza=str_replace("<titulopagina>",$usuarios[0]->nickusuario." | ".$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
$cabeza=str_replace("<redes>",$redes,$cabeza);

$contenido=$cabezaPrincipal.$cabeza.$contenido.$pie;
if($e404)
	http_response_code(404);
echo $contenido;




?>