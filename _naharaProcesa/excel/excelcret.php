<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=cret.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==2)   {     if($tipocretl1=="on" || $labelcretl1=="on" || $i_labelcretl1=="on" || $mincretl1=="on" || $maxcretl1=="on" || $reqcretl1=="on" || $opcionescretl1=="on" || $i_opcionescretl1=="on") $error=9;     if($tipocretb1<>"" || $labelcretb1<>"" || $i_labelcretb1<>"" || $mincretb1<>"" || $maxcretb1<>"" || $reqcretb1<>"" || $opcionescretb1<>"" || $i_opcionescretb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($tipocretl1=="on" || $labelcretl1=="on" || $i_labelcretl1=="on" || $mincretl1=="on" || $maxcretl1=="on" || $reqcretl1=="on" || $opcionescretl1=="on" || $i_opcionescretl1=="on") $error=9;     if($tipocretb1<>"" || $labelcretb1<>"" || $i_labelcretb1<>"" || $mincretb1<>"" || $maxcretb1<>"" || $reqcretb1<>"" || $opcionescretb1<>"" || $i_opcionescretb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($tipocretl1=="on" || $labelcretl1=="on" || $i_labelcretl1=="on" || $mincretl1=="on" || $maxcretl1=="on" || $reqcretl1=="on" || $opcionescretl1=="on" || $i_opcionescretl1=="on") $error=9;     if($tipocretb1<>"" || $labelcretb1<>"" || $i_labelcretb1<>"" || $mincretb1<>"" || $maxcretb1<>"" || $reqcretb1<>"" || $opcionescretb1<>"" || $i_opcionescretb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="cret.activo DESC,iretcret ASC"; $ordenamiento="";$activob1="="; $activob2="1";$iretcretl1="on"; $tipocretl1="on"; $labelcretl1="on"; $i_labelcretl1="on"; } $camposbuscadoslistadosearch="cret.id";cbusqueda1($activol1,"cret","activo");cbusqueda1($iretcretl1,"ret","nombreret","0","","");cbusqueda1($tipocretl1,"cret","tipocret");cbusqueda1($labelcretl1,"cret","labelcret");cbusqueda1($i_labelcretl1,"cret","i_labelcret");cbusqueda1($mincretl1,"cret","mincret");cbusqueda1($maxcretl1,"cret","maxcret");cbusqueda1($reqcretl1,"cret","reqcret");cbusqueda1($opcionescretl1,"cret","opcionescret");cbusqueda1($i_opcionescretl1,"cret","i_opcionescret");cbusqueda2($iretcretl1,"ret","cret","iretcret","",0,"id");cbusqueda3($iretcretb1,$iretcretb2,"cret","iretcret","","0","","");cbusqueda3($tipocretb1,$tipocretb2,"cret","tipocret","'","0","","");cbusqueda3($labelcretb1,$labelcretb2,"cret","labelcret","'","0","","");cbusqueda3($i_labelcretb1,$i_labelcretb2,"cret","i_labelcret","'","0","","");cbusqueda3($mincretb1,$mincretb2,"cret","mincret","","0","","");cbusqueda3($maxcretb1,$maxcretb2,"cret","maxcret","","0","","");cbusqueda3($reqcretb1,$reqcretb2,"cret","reqcret","'","0","","");cbusqueda3($opcionescretb1,$opcionescretb2,"cret","opcionescret","'","0","","");cbusqueda3($i_opcionescretb1,$i_opcionescretb2,"cret","i_opcionescret","'","0","","");cbusqueda3($activob1,$activob2,"cret","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from cret ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($iretcretl1=="on") { echo("<td>Iniciativa</td>"); $totalcolumnas=$totalcolumnas+1;}if($tipocretl1=="on") { echo("<td>Tipo</td>"); $totalcolumnas=$totalcolumnas+1;}if($labelcretl1=="on") { echo("<td>Etiqueta</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_labelcretl1=="on") { echo("<td>Etiqueta en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($mincretl1=="on") { echo("<td>Valor mínimo</td>"); $totalcolumnas=$totalcolumnas+1;}if($maxcretl1=="on") { echo("<td>Valor máximo</td>"); $totalcolumnas=$totalcolumnas+1;}if($reqcretl1=="on") { echo("<td>Requerido</td>"); $totalcolumnas=$totalcolumnas+1;}if($opcionescretl1=="on") { echo("<td>Opciones (una por línea)</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_opcionescretl1=="on") { echo("<td>Opciones en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($iretcretl1=="on") { echo("<td>".$row["nombreret"]."</td>"); } if($tipocretl1=="on")  { if($row["tipocret"]=="1") $tempotipocret="Entero";if($row["tipocret"]=="2") $tempotipocret="Flotante";if($row["tipocret"]=="3") $tempotipocret="Texto (max 100 letras)";if($row["tipocret"]=="4") $tempotipocret="Opciones";echo("<td>".$tempotipocret.$tempoexcel."</td>"); $tempoexcel="";}if($labelcretl1=="on") { echo("<td>".$row["labelcret"].$tempoexcel."</td>"); $tempoexcel="";}if($i_labelcretl1=="on") { echo("<td>".$row["i_labelcret"].$tempoexcel."</td>"); $tempoexcel="";}if($mincretl1=="on") { echo("<td>".$row["mincret"].$tempoexcel."</td>"); $tempoexcel="";}if($maxcretl1=="on") { echo("<td>".$row["maxcret"].$tempoexcel."</td>"); $tempoexcel="";}if($reqcretl1=="on")  { if($row["reqcret"]=="0") $temporeqcret="NO";if($row["reqcret"]=="1") $temporeqcret="SI";echo("<td>".$temporeqcret.$tempoexcel."</td>"); $tempoexcel="";}if($opcionescretl1=="on") { echo("<td>".$row["opcionescret"].$tempoexcel."</td>"); $tempoexcel="";}if($i_opcionescretl1=="on") { echo("<td>".$row["i_opcionescret"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($iretcretl1=="on") echo("<td>".$sumatoriairetcret."</td>");if($tipocretl1=="on") echo("<td>".$sumatoriatipocret."</td>");if($labelcretl1=="on") echo("<td>".$sumatorialabelcret."</td>");if($i_labelcretl1=="on") echo("<td>".$sumatoriai_labelcret."</td>");if($mincretl1=="on") echo("<td>".$sumatoriamincret."</td>");if($maxcretl1=="on") echo("<td>".$sumatoriamaxcret."</td>");if($reqcretl1=="on") echo("<td>".$sumatoriareqcret."</td>");if($opcionescretl1=="on") echo("<td>".$sumatoriaopcionescret."</td>");if($i_opcionescretl1=="on") echo("<td>".$sumatoriai_opcionescret."</td>"); 
}

?>





