<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=tusu.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($tipotusul1=="on" || $i_tipotusul1=="on") $error=9;     if($tipotusub1<>"" || $i_tipotusub1<>"") $error=9;   }  if($nivelusuario==2)   {     if($tipotusul1=="on" || $i_tipotusul1=="on") $error=9;     if($tipotusub1<>"" || $i_tipotusub1<>"") $error=9;   }  if($nivelusuario==3)   {     if($tipotusul1=="on") $error=9;     if($tipotusub1<>"" || $i_tipotusub1<>"") $error=9;   }  if($nivelusuario==4)   {     if($tipotusul1=="on" || $i_tipotusul1=="on") $error=9;     if($tipotusub1<>"" || $i_tipotusub1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="tusu.activo DESC,tipotusu ASC"; $ordenamiento="";$activob1="="; $activob2="1";$tipotusul1="on"; } $camposbuscadoslistadosearch="tusu.id";cbusqueda1($activol1,"tusu","activo");cbusqueda1($tipotusul1,"tusu","tipotusu");cbusqueda1($i_tipotusul1,"tusu","i_tipotusu");cbusqueda3($tipotusub1,$tipotusub2,"tusu","tipotusu","'","0","","");cbusqueda3($i_tipotusub1,$i_tipotusub2,"tusu","i_tipotusu","'","0","","");cbusqueda3($activob1,$activob2,"tusu","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from tusu ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($tipotusul1=="on") { echo("<td>Tipo de usuario</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_tipotusul1=="on") { echo("<td>Tipo en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($tipotusul1=="on") { echo("<td>".$row["tipotusu"].$tempoexcel."</td>"); $tempoexcel="";}if($i_tipotusul1=="on") { echo("<td>".$row["i_tipotusu"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($tipotusul1=="on") echo("<td>".$sumatoriatipotusu."</td>");if($i_tipotusul1=="on") echo("<td>".$sumatoriai_tipotusu."</td>"); 
}

?>





