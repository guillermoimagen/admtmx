<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=por.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($porqueporl1=="on" || $i_porqueporl1=="on") $error=9;     if($porqueporb1<>"" || $i_porqueporb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($porqueporl1=="on" || $i_porqueporl1=="on") $error=9;     if($porqueporb1<>"" || $i_porqueporb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($porqueporl1=="on" || $i_porqueporl1=="on") $error=9;     if($porqueporb1<>"" || $i_porqueporb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($porqueporl1=="on" || $i_porqueporl1=="on") $error=9;     if($porqueporb1<>"" || $i_porqueporb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="por.activo DESC,porquepor ASC"; $ordenamiento="";$activob1="="; $activob2="1";$porqueporl1="on"; $i_porqueporl1="on"; } $camposbuscadoslistadosearch="por.id";cbusqueda1($activol1,"por","activo");cbusqueda1($porqueporl1,"por","porquepor");cbusqueda1($i_porqueporl1,"por","i_porquepor");cbusqueda3($porqueporb1,$porqueporb2,"por","porquepor","'","0","","");cbusqueda3($i_porqueporb1,$i_porqueporb2,"por","i_porquepor","'","0","","");cbusqueda3($activob1,$activob2,"por","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from por ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($porqueporl1=="on") { echo("<td>¿Porqué nos apoya?</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_porqueporl1=="on") { echo("<td>¿Porqué nos apoya? (inglés)</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($porqueporl1=="on") { echo("<td>".$row["porquepor"].$tempoexcel."</td>"); $tempoexcel="";}if($i_porqueporl1=="on") { echo("<td>".$row["i_porquepor"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($porqueporl1=="on") echo("<td>".$sumatoriaporquepor."</td>");if($i_porqueporl1=="on") echo("<td>".$sumatoriai_porquepor."</td>"); 
}

?>





