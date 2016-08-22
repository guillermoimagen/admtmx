<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=cont.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($nombrecontl1=="on" || $i_nombrecontl1=="on" || $textocontl1=="on" || $i_textocontl1=="on" || $imagencontl1=="on" || $videocontl1=="on") $error=9;     if($nombrecontb1<>"" || $i_nombrecontb1<>"" || $textocontb1<>"" || $i_textocontb1<>"" || $imagencontb1<>"" || $videocontb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($nombrecontl1=="on" || $i_nombrecontl1=="on" || $textocontl1=="on" || $i_textocontl1=="on" || $imagencontl1=="on" || $videocontl1=="on") $error=9;     if($nombrecontb1<>"" || $i_nombrecontb1<>"" || $textocontb1<>"" || $i_textocontb1<>"" || $imagencontb1<>"" || $videocontb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($nombrecontl1=="on" || $i_nombrecontl1=="on" || $textocontl1=="on" || $i_textocontl1=="on" || $imagencontl1=="on" || $videocontl1=="on") $error=9;     if($nombrecontb1<>"" || $i_nombrecontb1<>"" || $textocontb1<>"" || $i_textocontb1<>"" || $imagencontb1<>"" || $videocontb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($nombrecontl1=="on" || $i_nombrecontl1=="on" || $textocontl1=="on" || $i_textocontl1=="on" || $imagencontl1=="on" || $videocontl1=="on") $error=9;     if($nombrecontb1<>"" || $i_nombrecontb1<>"" || $textocontb1<>"" || $i_textocontb1<>"" || $imagencontb1<>"" || $videocontb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="cont.activo DESC,nombrecont ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombrecontl1="on"; $i_nombrecontl1="on"; $imagencontl1="on"; $videocontl1="on"; } $camposbuscadoslistadosearch="cont.id";cbusqueda1($activol1,"cont","activo");cbusqueda1($nombrecontl1,"cont","nombrecont");cbusqueda1($i_nombrecontl1,"cont","i_nombrecont");cbusqueda1($textocontl1,"cont","textocont");cbusqueda1($i_textocontl1,"cont","i_textocont");cbusqueda1($imagencontl1,"cont","imagencont");cbusqueda1($videocontl1,"cont","videocont");cbusqueda3($nombrecontb1,$nombrecontb2,"cont","nombrecont","'","0","","");cbusqueda3($i_nombrecontb1,$i_nombrecontb2,"cont","i_nombrecont","'","0","","");cbusqueda3($textocontb1,$textocontb2,"cont","textocont","'","0","","");cbusqueda3($i_textocontb1,$i_textocontb2,"cont","i_textocont","'","0","","");cbusqueda3($imagencontb1,$imagencontb2,"cont","imagencont","'","0","","");cbusqueda3($videocontb1,$videocontb2,"cont","videocont","'","0","","");cbusqueda3($activob1,$activob2,"cont","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from cont ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($nombrecontl1=="on") { echo("<td>Nombre</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_nombrecontl1=="on") { echo("<td>Nombre en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($textocontl1=="on") { echo("<td>Texto</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_textocontl1=="on") { echo("<td>Texto en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($imagencontl1=="on") { echo("<td>Imagen</td>"); $totalcolumnas=$totalcolumnas+1;}if($videocontl1=="on") { echo("<td>Video</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($nombrecontl1=="on") { echo("<td>".$row["nombrecont"].$tempoexcel."</td>"); $tempoexcel="";}if($i_nombrecontl1=="on") { echo("<td>".$row["i_nombrecont"].$tempoexcel."</td>"); $tempoexcel="";}if($textocontl1=="on") { echo("<td>".$row["textocont"].$tempoexcel."</td>"); $tempoexcel="";}if($i_textocontl1=="on") { echo("<td>".$row["i_textocont"].$tempoexcel."</td>"); $tempoexcel="";}if($imagencontl1=="on") { echo("<td>".$row["imagencont"].$tempoexcel."</td>"); $tempoexcel="";}if($videocontl1=="on") { echo("<td>".$row["videocont"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($nombrecontl1=="on") echo("<td>".$sumatorianombrecont."</td>");if($i_nombrecontl1=="on") echo("<td>".$sumatoriai_nombrecont."</td>");if($textocontl1=="on") echo("<td>".$sumatoriatextocont."</td>");if($i_textocontl1=="on") echo("<td>".$sumatoriai_textocont."</td>");if($imagencontl1=="on") echo("<td>".$sumatoriaimagencont."</td>");if($videocontl1=="on") echo("<td>".$sumatoriavideocont."</td>"); 
}

?>





