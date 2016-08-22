<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=ban.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if($nombrebanb1<>"" || $iniciobanb1<>"" || $finbanb1<>"" || $tipobanb1<>"" || $imagenbanb1<>"" || $i_imagenbanb1<>"" || $textobanb1<>"" || $i_textobanb1<>"" || $urlbanb1<>"" || $i_urlbanb1<>"" || $targetbanb1<>"" || $ordenbanb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if($nombrebanb1<>"" || $iniciobanb1<>"" || $finbanb1<>"" || $tipobanb1<>"" || $imagenbanb1<>"" || $i_imagenbanb1<>"" || $textobanb1<>"" || $i_textobanb1<>"" || $urlbanb1<>"" || $i_urlbanb1<>"" || $targetbanb1<>"" || $ordenbanb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if($nombrebanb1<>"" || $iniciobanb1<>"" || $finbanb1<>"" || $tipobanb1<>"" || $imagenbanb1<>"" || $i_imagenbanb1<>"" || $textobanb1<>"" || $i_textobanb1<>"" || $urlbanb1<>"" || $i_urlbanb1<>"" || $targetbanb1<>"" || $ordenbanb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if($nombrebanb1<>"" || $iniciobanb1<>"" || $finbanb1<>"" || $tipobanb1<>"" || $imagenbanb1<>"" || $i_imagenbanb1<>"" || $textobanb1<>"" || $i_textobanb1<>"" || $urlbanb1<>"" || $i_urlbanb1<>"" || $targetbanb1<>"" || $ordenbanb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="ban.activo DESC,nombreban ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombrebanl1="on"; $iniciobanl1="on"; $finbanl1="on"; $tipobanl1="on"; $imagenbanl1="on"; } $camposbuscadoslistadosearch="ban.id";cbusqueda1($activol1,"ban","activo");cbusqueda1($nombrebanl1,"ban","nombreban");cbusqueda1($iniciobanl1,"ban","inicioban");cbusqueda1($finbanl1,"ban","finban");cbusqueda1($tipobanl1,"ban","tipoban");cbusqueda1($imagenbanl1,"ban","imagenban");cbusqueda1($i_imagenbanl1,"ban","i_imagenban");cbusqueda1($textobanl1,"ban","textoban");cbusqueda1($i_textobanl1,"ban","i_textoban");cbusqueda1($urlbanl1,"ban","urlban");cbusqueda1($i_urlbanl1,"ban","i_urlban");cbusqueda1($targetbanl1,"ban","targetban");cbusqueda1($ordenbanl1,"ban","ordenban");cbusqueda3($nombrebanb1,$nombrebanb2,"ban","nombreban","'","0","","");cbusqueda3($iniciobanb1,$iniciobanb2,"ban","inicioban","'","0","","");cbusqueda3($finbanb1,$finbanb2,"ban","finban","'","0","","");cbusqueda3($tipobanb1,$tipobanb2,"ban","tipoban","'","0","","");cbusqueda3($imagenbanb1,$imagenbanb2,"ban","imagenban","'","0","","");cbusqueda3($i_imagenbanb1,$i_imagenbanb2,"ban","i_imagenban","'","0","","");cbusqueda3($textobanb1,$textobanb2,"ban","textoban","'","0","","");cbusqueda3($i_textobanb1,$i_textobanb2,"ban","i_textoban","'","0","","");cbusqueda3($urlbanb1,$urlbanb2,"ban","urlban","'","0","","");cbusqueda3($i_urlbanb1,$i_urlbanb2,"ban","i_urlban","'","0","","");cbusqueda3($targetbanb1,$targetbanb2,"ban","targetban","'","0","","");cbusqueda3($ordenbanb1,$ordenbanb2,"ban","ordenban","","0","","");cbusqueda3($activob1,$activob2,"ban","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from ban ";
	
	$antesbusqueda="";
	
	
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
echo("<td>id</td>");$totalcolumnas=1;if($nombrebanl1=="on") { echo("<td>Nombre</td>"); $totalcolumnas=$totalcolumnas+1;}if($iniciobanl1=="on") { echo("<td>Inicio</td>"); $totalcolumnas=$totalcolumnas+1;}if($finbanl1=="on") { echo("<td>Fin</td>"); $totalcolumnas=$totalcolumnas+1;}if($tipobanl1=="on") { echo("<td>Tipo</td>"); $totalcolumnas=$totalcolumnas+1;}if($imagenbanl1=="on") { echo("<td>Imagen</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_imagenbanl1=="on") { echo("<td>Imagen inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($textobanl1=="on") { echo("<td>Texto</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_textobanl1=="on") { echo("<td>Texto inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($urlbanl1=="on") { echo("<td>URL</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_urlbanl1=="on") { echo("<td>URL inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($targetbanl1=="on") { echo("<td>Target</td>"); $totalcolumnas=$totalcolumnas+1;}if($ordenbanl1=="on") { echo("<td>Orden</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($nombrebanl1=="on") { echo("<td>".$row["nombreban"].$tempoexcel."</td>"); $tempoexcel="";}if($iniciobanl1=="on") { echo("<td>".$row["inicioban"].$tempoexcel."</td>"); $tempoexcel="";}if($finbanl1=="on") { echo("<td>".$row["finban"].$tempoexcel."</td>"); $tempoexcel="";}if($tipobanl1=="on")  { if($row["tipoban"]=="0") $tempotipoban="Normal";if($row["tipoban"]=="1") $tempotipoban="Derecho";if($row["tipoban"]=="2") $tempotipoban="Abajo";echo("<td>".$tempotipoban.$tempoexcel."</td>"); $tempoexcel="";}if($imagenbanl1=="on") { echo("<td>".$row["imagenban"].$tempoexcel."</td>"); $tempoexcel="";}if($i_imagenbanl1=="on") { echo("<td>".$row["i_imagenban"].$tempoexcel."</td>"); $tempoexcel="";}if($textobanl1=="on") { echo("<td>".$row["textoban"].$tempoexcel."</td>"); $tempoexcel="";}if($i_textobanl1=="on") { echo("<td>".$row["i_textoban"].$tempoexcel."</td>"); $tempoexcel="";}if($urlbanl1=="on") { echo("<td>".$row["urlban"].$tempoexcel."</td>"); $tempoexcel="";}if($i_urlbanl1=="on") { echo("<td>".$row["i_urlban"].$tempoexcel."</td>"); $tempoexcel="";}if($targetbanl1=="on")  { if($row["targetban"]=="_self") $tempotargetban="_self";if($row["targetban"]=="_blank") $tempotargetban="_blank";echo("<td>".$tempotargetban.$tempoexcel."</td>"); $tempoexcel="";}if($ordenbanl1=="on") { echo("<td>".$row["ordenban"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($nombrebanl1=="on") echo("<td>".$sumatorianombreban."</td>");if($iniciobanl1=="on") echo("<td>".$sumatoriainicioban."</td>");if($finbanl1=="on") echo("<td>".$sumatoriafinban."</td>");if($tipobanl1=="on") echo("<td>".$sumatoriatipoban."</td>");if($imagenbanl1=="on") echo("<td>".$sumatoriaimagenban."</td>");if($i_imagenbanl1=="on") echo("<td>".$sumatoriai_imagenban."</td>");if($textobanl1=="on") echo("<td>".$sumatoriatextoban."</td>");if($i_textobanl1=="on") echo("<td>".$sumatoriai_textoban."</td>");if($urlbanl1=="on") echo("<td>".$sumatoriaurlban."</td>");if($i_urlbanl1=="on") echo("<td>".$sumatoriai_urlban."</td>");if($targetbanl1=="on") echo("<td>".$sumatoriatargetban."</td>");if($ordenbanl1=="on") echo("<td>".$sumatoriaordenban."</td>"); 
}

?>





