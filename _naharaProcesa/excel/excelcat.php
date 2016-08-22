<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=cat.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on") $error=9;     if($nombrecatb1<>"" || $i_nombrecatb1<>"" || $destacadacatb1<>"" || $colorcatb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on") $error=9;     if($nombrecatb1<>"" || $i_nombrecatb1<>"" || $destacadacatb1<>"" || $colorcatb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on") $error=9;     if($nombrecatb1<>"" || $i_nombrecatb1<>"" || $destacadacatb1<>"" || $colorcatb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on") $error=9;     if($nombrecatb1<>"" || $i_nombrecatb1<>"" || $destacadacatb1<>"" || $colorcatb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="cat.activo DESC,tipocat ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombrecatl1="on"; $i_nombrecatl1="on"; $destacadacatl1="on"; } $camposbuscadoslistadosearch="cat.id";cbusqueda1($activol1,"cat","activo");cbusqueda1($nombrecatl1,"cat","nombrecat");cbusqueda1($i_nombrecatl1,"cat","i_nombrecat");cbusqueda1($destacadacatl1,"cat","destacadacat");cbusqueda1($colorcatl1,"cat","colorcat");cbusqueda3($nombrecatb1,$nombrecatb2,"cat","nombrecat","'","0","","");cbusqueda3($i_nombrecatb1,$i_nombrecatb2,"cat","i_nombrecat","'","0","","");cbusqueda3($destacadacatb1,$destacadacatb2,"cat","destacadacat","'","0","","");cbusqueda3($colorcatb1,$colorcatb2,"cat","colorcat","'","0","","");cbusqueda3($activob1,$activob2,"cat","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from cat ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($nombrecatl1=="on") { echo("<td>Nombre</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_nombrecatl1=="on") { echo("<td>Nombre (inglés)</td>"); $totalcolumnas=$totalcolumnas+1;}if($destacadacatl1=="on") { echo("<td>Destacada</td>"); $totalcolumnas=$totalcolumnas+1;}if($colorcatl1=="on") { echo("<td>Color</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($nombrecatl1=="on") { echo("<td>".$row["nombrecat"].$tempoexcel."</td>"); $tempoexcel="";}if($i_nombrecatl1=="on") { echo("<td>".$row["i_nombrecat"].$tempoexcel."</td>"); $tempoexcel="";}if($destacadacatl1=="on")  { if($row["destacadacat"]=="0") $tempodestacadacat="NO";if($row["destacadacat"]=="1") $tempodestacadacat="SI";echo("<td>".$tempodestacadacat.$tempoexcel."</td>"); $tempoexcel="";}if($colorcatl1=="on") { echo("<td>".$row["colorcat"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($nombrecatl1=="on") echo("<td>".$sumatorianombrecat."</td>");if($i_nombrecatl1=="on") echo("<td>".$sumatoriai_nombrecat."</td>");if($destacadacatl1=="on") echo("<td>".$sumatoriadestacadacat."</td>");if($colorcatl1=="on") echo("<td>".$sumatoriacolorcat."</td>"); 
}

?>





