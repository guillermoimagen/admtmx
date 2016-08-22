<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=vret.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==2)   {     if($valorvretl1=="on" || $statusvretl1=="on" || $ganvretl1=="on") $error=9;     if($valorvretb1<>"" || $statusvretb1<>"" || $ganvretb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($valorvretl1=="on" || $statusvretl1=="on" || $ganvretl1=="on") $error=9;     if($valorvretb1<>"" || $statusvretb1<>"" || $ganvretb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($valorvretl1=="on" || $statusvretl1=="on" || $ganvretl1=="on") $error=9;     if($valorvretb1<>"" || $statusvretb1<>"" || $ganvretb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="vret.activo DESC,ganvret ASC"; $ordenamiento="";$activob1="="; $activob2="1";$idonvretl1="on"; $icretvretl1="on"; $valorvretl1="on"; $statusvretl1="on"; $ganvretl1="on"; } $camposbuscadoslistadosearch="vret.id";cbusqueda1($activol1,"vret","activo");cbusqueda1($idonvretl1,"don","fechadon","0","","");cbusqueda1($icretvretl1,"cret","labelcret","0","","");cbusqueda1($valorvretl1,"vret","valorvret");cbusqueda1($statusvretl1,"vret","statusvret");cbusqueda1($ganvretl1,"vret","ganvret");cbusqueda2($idonvretl1,"don","vret","idonvret","",0,"id");cbusqueda2($icretvretl1,"cret","vret","icretvret","",0,"id");cbusqueda3($idonvretb1,$idonvretb2,"vret","idonvret","","0","","");cbusqueda3($icretvretb1,$icretvretb2,"vret","icretvret","","0","","");cbusqueda3($valorvretb1,$valorvretb2,"vret","valorvret","'","0","","");cbusqueda3($statusvretb1,$statusvretb2,"vret","statusvret","'","0","","");cbusqueda3($ganvretb1,$ganvretb2,"vret","ganvret","","0","","");cbusqueda3($activob1,$activob2,"vret","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from vret ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($idonvretl1=="on") { echo("<td>Donativo</td>"); $totalcolumnas=$totalcolumnas+1;}if($icretvretl1=="on") { echo("<td>Extra</td>"); $totalcolumnas=$totalcolumnas+1;}if($valorvretl1=="on") { echo("<td>Valor</td>"); $totalcolumnas=$totalcolumnas+1;}if($statusvretl1=="on") { echo("<td>Status</td>"); $totalcolumnas=$totalcolumnas+1;}if($ganvretl1=="on") { echo("<td>Ganador</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($idonvretl1=="on") { echo("<td>".$row["fechadon"]."</td>"); } if($icretvretl1=="on") { echo("<td>".$row["labelcret"]."</td>"); } if($valorvretl1=="on") { echo("<td>".$row["valorvret"].$tempoexcel."</td>"); $tempoexcel="";}if($statusvretl1=="on")  { if($row["statusvret"]=="1") $tempostatusvret="Válido";if($row["statusvret"]=="2") $tempostatusvret="Cancelado por insuficiencia";echo("<td>".$tempostatusvret.$tempoexcel."</td>"); $tempoexcel="";}if($ganvretl1=="on") { echo("<td>".$row["ganvret"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($idonvretl1=="on") echo("<td>".$sumatoriaidonvret."</td>");if($icretvretl1=="on") echo("<td>".$sumatoriaicretvret."</td>");if($valorvretl1=="on") echo("<td>".$sumatoriavalorvret."</td>");if($statusvretl1=="on") echo("<td>".$sumatoriastatusvret."</td>");if($ganvretl1=="on") echo("<td>".$sumatoriaganvret."</td>"); 
}

?>





