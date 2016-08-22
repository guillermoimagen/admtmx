<?
  $icotache="recursos/ico_tache.gif";
  $icoflecha="recursos/ico_flecha.gif";
  $icoadmiracion="recursos/ico_admiracion.gif";
  $icopregunta="recursos/ico_pregunta.gif";
  $icopaloma="recursos/ico_paloma.gif";
  $icopersona="recursos/ico_persona.gif";
  $icotelefono="recursos/ico_telefono.gif";
  $botonver="recursos/botonver.gif";

  $i_icotache="<img src=".$ico_tache." border=0>";
  $i_icoflecha="<img src=".$icoflecha." border=0>";
  $i_icoadmiracion="<img src=".$ico_admiracion." border=0>";
  $i_icopregunta="<img src=".$ico_pregunta." border=0>";
  $i_icopaloma="<img src=".$ico_paloma." border=0>";
  $i_icopersona="<img src=".$ico_persona." border=0>";
  $i_icotelefono="<img src=".$ico_telefono." border=0>";
  $i_botonver="<img src=".$botonver." border=0>";  
  
// revisamos si es tu ciudad
if($numerodetabla<=1000) // no es de idiomas
{
	if($operacion=="delete" || $operacion=="modify" || ($step=="modify" && $operacion<>"add"))
	{	
	
		$tablaActual=substr($archivoactual,0,strlen($archivoactual)-4);
		if (in_array($tablaActual, $tablasFiltradas))
		{
			$cuantos=0;
			$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select count(id) from ".$tablaActual." where iciudad=".$_SESSION["ciudadactual"]." and id=".$id);
			while($rowx = mysqli_fetch_array($resultx))
				$cuantos=$rowx[0];
			if($cuantos==0)
			{
				$mensaje=guardareporte(20); 
				$step=""; 
				$operacion=""; 
			}
		}
	}
}

else // es de idiomas
{
	$tablaActual=substr($archivoactual,0,strlen($archivoactual)-6);
	if (in_array($tablaActual, $tablasFiltradas))
	{
		if($step=="modify" || $operacion=="modify" || $operacion=="add" || $step=="add")
		{
			$cuantos=0;
			$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select count(id) from ".$tablaActual." where iciudad=".$_SESSION["ciudadactual"]." and id=".$_GET["registro"]);
			while($rowx = mysqli_fetch_array($resultx))
				$cuantos=$rowx[0];
			if($cuantos==0) // no encontre el registro
			{
				$mensaje=guardareporte(21); 
				$step=""; 
				$operacion=""; 
			}
		}
		else // operacion no permitida
		{
			$mensaje=guardareporte(22); 
			$step=""; 
			$operacion=""; 
		}
	}
}



?>