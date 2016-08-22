<?
include("include/connection.php");

$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."ret.php");
include_once($API_folder."don.php");
include_once($API_folder."social.php");

$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);
$cabeza=abre_plantilla_API("cabeza",true);

// leamos la noticia
$sql_extra_url="";
if(isset($_GET["urlamigable"]))
	$sql_extra_url=" and urlamigableret='".mysqli_real_escape_stringMemo($_GET["urlamigable"])."'";
	
$iniciativaDetalleArreglo=ret_lista_lee(array("grafico"=>"detalle","sql_extra"=>" and ret.id=".(int)$_GET["idregistro"].$sql_extra_url));
$sepudo=false;
if(sizeof($iniciativaDetalleArreglo)>0)
{
	// es cms o tiene el status correcto
	if($_SESSION["logged"]->cms==1 || $iniciativaDetalleArreglo[0]->statusValor<=2 || $iniciativaDetalleArreglo[0]->iusuarioret==$_SESSION["logged"]->id) 
	{
		$sepudo=true;
		$contenido=abre_plantilla_API("iniciativaDetalle",false);
		$vista_iniciativas=extrae_vista_API("iniciativas",$contenido);
		
		$iniciativaDetalleArreglo[0]->video=""; // vamos a ver si tenemos video
		if($iniciativaDetalleArreglo[0]->videoret<>"")
		{
			$video=abre_plantilla_API("video",false);
			$iniciativaDetalleArreglo[0]->video=str_replace("<video>",$iniciativaDetalleArreglo[0]->videoret,$video);
		}
		
		if($iniciativaDetalleArreglo[0]->razonesret<>"") $iniciativaDetalleArreglo[0]->razonesret.="<br>";
		
		
		// aquie lo del acumulado
		$acumuladoformateadoacu="$0 ".$moneda;
		$acumuladoacu=0;
		if($_SESSION["firmado"])
		{
			// vemos si ya tiene un donativo
			$don=@mysqli_query($GLOBALS["enlaceDB"] ,"select id from don where statusdon='2' and iusuariodon=".$iniciativaDetalleArreglo[0]->iusuarioret." and iusuariodonodon=".(int)$_SESSION["logged"]->id);

			if(mysqli_num_rows($don)==0)
			{
				$acus=acu_lee(array("receptor"=>$iniciativaDetalleArreglo[0]->iusuarioret,"donador"=>$_SESSION["logged"]->id));
				if(sizeof($acus)>0)
				{
					$acumuladoformateadoacu=$acus[0]->acumuladoformateadoacu;	
					$acumuladoacu=$acus[0]->acumuladoacu;	
				}
			}
		}
		
		$iniciativaDetalleArreglo[0]->share=generaShareButtons($iniciativaDetalleArreglo[0]->urlAmigableret);
		
		$nuevasIniciativasArreglo=array();
		// construimos las iniciativas del lado derehco, relacionadas con la actual
		$busquedas=array(" and icatret=".$iniciativaDetalleArreglo[0]->icatret." and iestadoret=".$iniciativaDetalleArreglo[0]->iestadoret,
						 " and icatret=".$iniciativaDetalleArreglo[0]->icatret." and iestadoret<>".$iniciativaDetalleArreglo[0]->iestadoret,
						 " and destacadoret='1' and icatret<>".$iniciativaDetalleArreglo[0]->icatret." and iestadoret<>".$iniciativaDetalleArreglo[0]->iestadoret,
						 " and destacadoret='0' and icatret<>".$iniciativaDetalleArreglo[0]->icatret." and iestadoret<>".$iniciativaDetalleArreglo[0]->iestadoret);		
		
		for($x=0; $x<=3; $x++)
		{
			$nuevasIniciativasArregloTemp=ret_lista_lee(array("modo"=>"vigente","grafico"=>"corto","order"=>"destacadoret desc,statusret desc","numero_pagina"=>1,"items_por_pagina"=>3,"sql_extra"=>$busquedas[$x]." and ret.id<>".$iniciativaDetalleArreglo[0]->idreal));
			if(sizeof($nuevasIniciativasArregloTemp)>0)
			{
				$nuevasIniciativasArreglo=array_merge($nuevasIniciativasArreglo,$nuevasIniciativasArregloTemp);
			}
			if(sizeof($nuevasIniciativasArreglo)>=3)
				break;
		}		
		if(sizeof($nuevasIniciativasArreglo)>0)
			$vista_iniciativasT=generaVistaRecursiva($vista_iniciativas[1],$nuevasIniciativasArreglo);
		$iniciativaDetalleArreglo[0]->otrasIniciativas=$idiomas["Otras iniciativas"];
		$contenido=str_replace($vista_iniciativas[0],$vista_iniciativasT,$contenido);
		
		
		
		$otrasiniciativas="";
		if($_SESSION["firmado"])
		{	
			$sql_quitar="";
			for($i=0; $i<=sizeof($nuevasIniciativasArreglo)-1; $i++)
				$sql_quitar.=" and ret.id<>".$nuevasIniciativasArreglo[$i]->idreal;	

			$otrasIniciativasArreglo=ret_lista_lee(array("modo"=>"vigente","grafico"=>"corto","order"=>"destacadoret desc,statusret desc","numero_pagina"=>1,"items_por_pagina"=>3,"sql_extra"=>" and ret.id<>".$iniciativaDetalleArreglo[0]->idreal.$sql_quitar,"recomendados"=>"pocos"));
			if(sizeof($otrasIniciativasArreglo)>0)
			{
				$otrasiniciativas='<br><div class="bar_ini">'.$idiomas["Puede interesarte"].' '.$_SESSION["logged"]->name.'</div><div style="background-color:#F9F9F9; padding:5px;">';
				$otrasiniciativas.=generaVistaRecursiva($vista_iniciativas[1],$otrasIniciativasArreglo)."</div>";
			}
		}
		$contenido=str_replace("<otrasiniciativas>",$otrasiniciativas,$contenido);
		
		// leamos los donadores
		$donadoresArreglo=don_lee_especial(array("grafico"=>"iniciativa","idiniciativa"=>$iniciativaDetalleArreglo[0]->idreal,"limite"=>"6"));
		if(sizeof($donadoresArreglo)>0)
		{
			$vistaDonadores=abre_plantilla_API("vistaDonadores",$false);
			$vistaDonadores=generaVistaRecursiva($vistaDonadores,$donadoresArreglo);
			if(sizeof($donadoresArreglo)>=6) // hay mas de 6 donadores
				$vistaDonadores.='<div class="vermas_com" onClick="todosDonadores('.$iniciativaDetalleArreglo[0]->idreal.')">'.$idiomas["Ver mas"].'</div>';  
		}
		else // no hubo donadores
		{
			$vistaDonadores=abre_plantilla_API("vistaDonadores0",$false);
			$vistaDonadores=str_replace("<seelprimero>",$idiomas["Se el primero en apoyar"],$vistaDonadores);
			$vistaDonadores=str_replace("<urlAmigabledonarret>",$iniciativaDetalleArreglo[0]->urlAmigabledonarret,$vistaDonadores);
			$vistaDonadores=str_replace("<colorcat>",$iniciativaDetalleArreglo[0]->colorcat,$vistaDonadores);
		}
		$iniciativaDetalleArreglo[0]->donadores=$idiomas["Donadores"];
		$iniciativaDetalleArreglo[0]->vistaDonadores=$vistaDonadores;
		$iniciativaDetalleArreglo[0]->reportar=$idiomas["Reportar"];
		
		$iniciativaDetalleArreglo[0]->botonverreporte="";
		$iniciativaDetalleArreglo[0]->botonverbit="";
		$iniciativaDetalleArreglo[0]->displayreportar="block";
		
		if($_SESSION["logged"]->cms==1)
		{
			$iniciativaDetalleArreglo[0]->displayreportar="none";
			$r=@mysqli_query($GLOBALS["enlaceDB"] ,"select id from rep where iretrep=".(int)$_GET["idregistro"]." and statusrep='0'");
			while($rr=mysqli_fetch_object($r))
				$iniciativaDetalleArreglo[0]->botonverreporte='<div class="btn_vercompleta" style="float:right;" onclick="verReporte('.$rr->id.');">Ver reporte</div>';
			$iniciativaDetalleArreglo[0]->botonverbit='<div class="btn_vercompleta" style="float:right;" onclick="verBits('.$iniciativaDetalleArreglo[0]->idreal.',\'iniciativa\');">Ver hist&oacute;rico</div>';
		}
	
		$comentariosArreglo=com_lee_especial(array("grafico"=>"iniciativa","idiniciativa"=>$iniciativaDetalleArreglo[0]->idreal));
		$vistaComentariosFull=abre_plantilla_API("vistaComentarios",true);
		$vistaComentarios=extrae_vista_API("comentarios",$vistaComentariosFull);
		if(sizeof($comentariosArreglo)>0)		
			$vistaComentariosT=generaVistaRecursiva($vistaComentarios[1],$comentariosArreglo);
		else $vistaComentariosT="";
		$vistaComentariosFull=str_replace($vistaComentarios[0],$vistaComentariosT,$vistaComentariosFull);
		
		$vistaComentariosFull=str_replace("<idiniciativa>",$iniciativaDetalleArreglo[0]->idreal,$vistaComentariosFull);
		$iniciativaDetalleArreglo[0]->vistaComentarios=$vistaComentariosFull;
		
		$contenido=generaVistaRecursiva($contenido,$iniciativaDetalleArreglo);
		
		$redes=generaRedes($iniciativaDetalleArreglo[0]->nombreret,
							$iniciativaDetalleArreglo[0]->imagenret,
							$iniciativaDetalleArreglo[0]->descripcionret,
							$iniciativaDetalleArreglo[0]->urlAmigableret);
	}
}	

if(!$sepudo) 
{
	$e404=true;
	$contenido=abre_plantilla_API("noencontrado",false);
	$contenido=str_replace("<aviso>",$idiomas["Informacion no encontrada"],$contenido);
}
$pie=abre_plantilla_API("pie",true);

$cabeza=str_replace("<titulopagina>",$iniciativaDetalleArreglo[0]->nombreret." | ".$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
$cabeza=str_replace("<redes>",$redes,$cabeza);

$contenido=$cabezaPrincipal.$cabeza.$contenido.$pie;

if($e404)
	http_response_code(404);
echo $contenido;




?>