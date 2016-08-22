<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=crits.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($nombrecritl1=="on") $error=9;     if($nombrecritb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($nombrecritl1=="on") $error=9;     if($nombrecritb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($nombrecritl1=="on") $error=9;     if($nombrecritb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($nombrecritl1=="on") $error=9;     if($nombrecritb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="crits.activo DESC,nombrecrit ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombrecritl1="on"; } $camposbuscadoslistadosearch="crits.id";cbusqueda1($activol1,"crits","activo");cbusqueda1($nombrecritl1,"crits","nombrecrit");cbusqueda3($nombrecritb1,$nombrecritb2,"crits","nombrecrit","'","0","","");cbusqueda3($activob1,$activob2,"crits","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from crits ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($nombrecritl1=="on") { echo("<td>Nombre</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($nombrecritl1=="on") { echo("<td>".$row["nombrecrit"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($nombrecritl1=="on") echo("<td>".$sumatorianombrecrit."</td>"); 
}

?>





