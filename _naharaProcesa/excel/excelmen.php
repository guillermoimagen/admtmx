<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=men.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($idmenl1=="on" || $textomenl1=="on" || $i_textomenl1=="on") $error=9;     if($idmenb1<>"" || $textomenb1<>"" || $i_textomenb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($idmenl1=="on" || $textomenl1=="on" || $i_textomenl1=="on") $error=9;     if($idmenb1<>"" || $textomenb1<>"" || $i_textomenb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($idmenl1=="on" || $textomenl1=="on" || $i_textomenl1=="on") $error=9;     if($idmenb1<>"" || $textomenb1<>"" || $i_textomenb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($idmenl1=="on" || $textomenl1=="on" || $i_textomenl1=="on") $error=9;     if($idmenb1<>"" || $textomenb1<>"" || $i_textomenb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="men.activo DESC,idmen ASC"; $ordenamiento="";$activob1="="; $activob2="1";$idmenl1="on"; $textomenl1="on"; $i_textomenl1="on"; } $camposbuscadoslistadosearch="men.id";cbusqueda1($activol1,"men","activo");cbusqueda1($idmenl1,"men","idmen");cbusqueda1($textomenl1,"men","textomen");cbusqueda1($i_textomenl1,"men","i_textomen");cbusqueda3($idmenb1,$idmenb2,"men","idmen","'","0","","");cbusqueda3($textomenb1,$textomenb2,"men","textomen","'","0","","");cbusqueda3($i_textomenb1,$i_textomenb2,"men","i_textomen","'","0","","");cbusqueda3($activob1,$activob2,"men","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from men ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($idmenl1=="on") { echo("<td>ID</td>"); $totalcolumnas=$totalcolumnas+1;}if($textomenl1=="on") { echo("<td>Texto</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_textomenl1=="on") { echo("<td>Texto en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($idmenl1=="on") { echo("<td>".$row["idmen"].$tempoexcel."</td>"); $tempoexcel="";}if($textomenl1=="on") { echo("<td>".$row["textomen"].$tempoexcel."</td>"); $tempoexcel="";}if($i_textomenl1=="on") { echo("<td>".$row["i_textomen"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($idmenl1=="on") echo("<td>".$sumatoriaidmen."</td>");if($textomenl1=="on") echo("<td>".$sumatoriatextomen."</td>");if($i_textomenl1=="on") echo("<td>".$sumatoriai_textomen."</td>"); 
}

?>





