<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=don.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==3)   {     if($fechadonl1=="on" || $importedonl1=="on" || $plataformadonl1=="on" || $statusdonl1=="on" || $clavedonl1=="on" || $comentariosdonl1=="on" || $ganadordonl1=="on" || $acumuladodonl1=="on" || $idiomal1=="on") $error=9;     if($fechadonb1<>"" || $importedonb1<>"" || $plataformadonb1<>"" || $statusdonb1<>"" || $clavedonb1<>"" || $comentariosdonb1<>"" || $ganadordonb1<>"" || $acumuladodonb1<>"" || $idiomab1<>"") $error=9;   }  if($nivelusuario==4)   {     if($fechadonl1=="on" || $importedonl1=="on" || $plataformadonl1=="on" || $statusdonl1=="on" || $clavedonl1=="on" || $comentariosdonl1=="on" || $ganadordonl1=="on" || $acumuladodonl1=="on" || $idiomal1=="on") $error=9;     if($fechadonb1<>"" || $importedonb1<>"" || $plataformadonb1<>"" || $statusdonb1<>"" || $clavedonb1<>"" || $comentariosdonb1<>"" || $ganadordonb1<>"" || $acumuladodonb1<>"" || $idiomab1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>

<? include("especialesMenuPeque.php"); ?>

<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="don.activo DESC,iusuariodon ASC"; $ordenamiento="";$activob1="="; $activob2="1";$iusuariodonl1="on"; $iretdonl1="on"; $iformadonl1="on"; $iusuariodonodonl1="on"; $fechadonl1="on"; } $camposbuscadoslistadosearch="don.id";cbusqueda1($activol1,"don","activo");cbusqueda1($iusuariodonl1,"usuarios","nombreusuario","0","","");cbusqueda1($iretdonl1,"ret","nombreret","0","","");cbusqueda1($iformadonl1,"formas","nombreforma","0","","");cbusqueda1($iusuariodonodonl1,"usuarios","nombreusuario","1","","");cbusqueda1($fechadonl1,"don","fechadon");cbusqueda1($importedonl1,"don","importedon");cbusqueda1($plataformadonl1,"don","plataformadon");cbusqueda1($statusdonl1,"don","statusdon");cbusqueda1($clavedonl1,"don","clavedon");cbusqueda1($comentariosdonl1,"don","comentariosdon");cbusqueda1($ganadordonl1,"don","ganadordon");cbusqueda1($acumuladodonl1,"don","acumuladodon");cbusqueda1($idiomal1,"don","idioma");cbusqueda2($iusuariodonl1,"usuarios","don","iusuariodon","",0,"id");cbusqueda2($iretdonl1,"ret","don","iretdon","",0,"id");cbusqueda2($iformadonl1,"formas","don","iformadon","",0,"id");cbusqueda2($iusuariodonodonl1,"usuarios","don","iusuariodonodon","",1,"id");cbusqueda3($iusuariodonb1,$iusuariodonb2,"don","iusuariodon","","0","","");cbusqueda3($iretdonb1,$iretdonb2,"don","iretdon","","0","","");cbusqueda3($iformadonb1,$iformadonb2,"don","iformadon","","0","","");cbusqueda3($iusuariodonodonb1,$iusuariodonodonb2,"don","iusuariodonodon","","1","","");cbusqueda3($fechadonb1,$fechadonb2,"don","fechadon","'","0","","");cbusqueda3($importedonb1,$importedonb2,"don","importedon","","0","","");cbusqueda3($plataformadonb1,$plataformadonb2,"don","plataformadon","'","0","","");cbusqueda3($statusdonb1,$statusdonb2,"don","statusdon","'","0","","");cbusqueda3($clavedonb1,$clavedonb2,"don","clavedon","'","0","","");cbusqueda3($comentariosdonb1,$comentariosdonb2,"don","comentariosdon","'","0","","");cbusqueda3($ganadordonb1,$ganadordonb2,"don","ganadordon","","0","","");cbusqueda3($acumuladodonb1,$acumuladodonb2,"don","acumuladodon","","0","","");cbusqueda3($idiomab1,$idiomab2,"don","idioma","'","0","","");cbusqueda3($activob1,$activob2,"don","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from don ";
	
	$antesbusqueda="";
	include("idon.php");
	
	if($camposcomunessearch<>"") $rutinabusqueda=$rutinabusqueda.$camposcomunessearch;
	
	if($sqltemporal<>"" && $antesbusqueda<>"") $sqltemporal=$sqltemporal." and ".$antesbusqueda;
	else if($sqltemporal=="" && $antesbusqueda<>"") $sqltemporal=$antesbusqueda;
	
	if($sqltemporal<>"") 
	{	  
	  $rutinabusqueda=$rutinabusqueda." where ".$sqltemporal;	  
	}
	$rutinabusqueda=$rutinabusqueda." order by ".$sortfield." ".$ordenamiento;




		
$result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$rutinabusqueda);
$num_rows = mysqli_num_rows($result);
echo("<table><tr>");	  
echo("<td>id</td>");$totalcolumnas=1;if($iusuariodonl1=="on") { echo("<td>Usuario dueño del reto o de la alcancía</td>"); $totalcolumnas=$totalcolumnas+1;}if($iretdonl1=="on") { echo("<td>Reto</td>"); $totalcolumnas=$totalcolumnas+1;}if($iformadonl1=="on") { echo("<td>Forma de pago</td>"); $totalcolumnas=$totalcolumnas+1;}if($iusuariodonodonl1=="on") { echo("<td>Usuario que donó</td>"); $totalcolumnas=$totalcolumnas+1;}if($fechadonl1=="on") { echo("<td>Fecha/hora</td>"); $totalcolumnas=$totalcolumnas+1;}if($importedonl1=="on") { echo("<td>Importe</td>"); $totalcolumnas=$totalcolumnas+1;}if($plataformadonl1=="on") { echo("<td>Plataforma</td>"); $totalcolumnas=$totalcolumnas+1;}if($statusdonl1=="on") { echo("<td>Status</td>"); $totalcolumnas=$totalcolumnas+1;}if($clavedonl1=="on") { echo("<td>Clave de pago</td>"); $totalcolumnas=$totalcolumnas+1;}if($comentariosdonl1=="on") { echo("<td>Comentarios</td>"); $totalcolumnas=$totalcolumnas+1;}if($ganadordonl1=="on") { echo("<td>Ganador</td>"); $totalcolumnas=$totalcolumnas+1;}if($acumuladodonl1=="on") { echo("<td>Acumulado</td>"); $totalcolumnas=$totalcolumnas+1;}if($idiomal1=="on") { echo("<td>Idioma</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
echo("</tr>");   
if (!$result) 
{
  echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
  exit();
}	 
	 
while ( $row = mysqli_fetch_array($result) )
{	   
$tempoexcel=" ";
echo("<tr>");   
echo("<td>".$row["id"]."</td>");
if($iusuariodonl1=="on") { echo("<td>".$row["nombreusuario"]."</td>"); } if($iretdonl1=="on") { echo("<td>".$row["nombreret"]."</td>"); } if($iformadonl1=="on") { echo("<td>".$row["nombreforma"]."</td>"); } if($iusuariodonodonl1=="on") { echo("<td>".$row["nombreusuario1"]."</td>"); } if($fechadonl1=="on") { echo("<td>".$row["fechadon"].$tempoexcel."</td>"); $tempoexcel="";}if($importedonl1=="on") { echo("<td>".$row["importedon"].$tempoexcel."</td>"); $tempoexcel="";}if($plataformadonl1=="on")  { if($row["plataformadon"]=="0") $tempoplataformadon="Desktop";if($row["plataformadon"]=="1") $tempoplataformadon="Mobile";echo("<td>".$tempoplataformadon.$tempoexcel."</td>"); $tempoexcel="";}if($statusdonl1=="on")  { if($row["statusdon"]=="0") $tempostatusdon="Pendiente de pago";if($row["statusdon"]=="1") $tempostatusdon="Pendiente de pago Paypal";if($row["statusdon"]=="2") $tempostatusdon="Pagado";if($row["statusdon"]=="3") $tempostatusdon="Cancelado";if($row["statusdon"]=="4") $tempostatusdon="Rechazado";echo("<td>".$tempostatusdon.$tempoexcel."</td>"); $tempoexcel="";}if($clavedonl1=="on") { echo("<td>".$row["clavedon"].$tempoexcel."</td>"); $tempoexcel="";}if($comentariosdonl1=="on") { echo("<td>".$row["comentariosdon"].$tempoexcel."</td>"); $tempoexcel="";}if($ganadordonl1=="on") { echo("<td>".$row["ganadordon"].$tempoexcel."</td>"); $tempoexcel="";}if($acumuladodonl1=="on") { echo("<td>".$row["acumuladodon"].$tempoexcel."</td>"); $tempoexcel="";}if($idiomal1=="on")  { if($row["idioma"]=="0") $tempoidioma="Español";if($row["idioma"]=="1") $tempoidioma="Inglés";echo("<td>".$tempoidioma.$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($iusuariodonl1=="on") echo("<td>".$sumatoriaiusuariodon."</td>");if($iretdonl1=="on") echo("<td>".$sumatoriairetdon."</td>");if($iformadonl1=="on") echo("<td>".$sumatoriaiformadon."</td>");if($iusuariodonodonl1=="on") echo("<td>".$sumatoriaiusuariodonodon."</td>");if($fechadonl1=="on") echo("<td>".$sumatoriafechadon."</td>");if($importedonl1=="on") echo("<td>".$sumatoriaimportedon."</td>");if($plataformadonl1=="on") echo("<td>".$sumatoriaplataformadon."</td>");if($statusdonl1=="on") echo("<td>".$sumatoriastatusdon."</td>");if($clavedonl1=="on") echo("<td>".$sumatoriaclavedon."</td>");if($comentariosdonl1=="on") echo("<td>".$sumatoriacomentariosdon."</td>");if($ganadordonl1=="on") echo("<td>".$sumatoriaganadordon."</td>");if($acumuladodonl1=="on") echo("<td>".$sumatoriaacumuladodon."</td>");if($idiomal1=="on") echo("<td>".$sumatoriaidioma."</td>"); 
}

?>





