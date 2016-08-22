<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=acu.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==0)   {     if($acumuladoacub1<>"") $error=9;   }  if($nivelusuario==1)   {     if($acumuladoacub1<>"") $error=9;   }  if($nivelusuario==2)   {     if($acumuladoacub1<>"") $error=9;   }  if($nivelusuario==3)   {     if($acumuladoacul1=="on") $error=9;     if($acumuladoacub1<>"") $error=9;   }  if($nivelusuario==4)   {     if($acumuladoacul1=="on") $error=9;     if($acumuladoacub1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>

<? include("especialesMenuPeque.php"); ?>

<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="acu.activo DESC,iusuario1acu ASC"; $ordenamiento="";$activob1="="; $activob2="1";$iusuario1acul1="on"; $iusuario2acul1="on"; $acumuladoacul1="on"; } $camposbuscadoslistadosearch="acu.id";cbusqueda1($activol1,"acu","activo");cbusqueda1($iusuario1acul1,"usuarios","nombreusuario","0","","");cbusqueda1($iusuario2acul1,"usuarios","nombreusuario","1","","");cbusqueda1($acumuladoacul1,"acu","acumuladoacu");cbusqueda2($iusuario1acul1,"usuarios","acu","iusuario1acu","",0,"id");cbusqueda2($iusuario2acul1,"usuarios","acu","iusuario2acu","",1,"id");cbusqueda3($iusuario1acub1,$iusuario1acub2,"acu","iusuario1acu","","0","","");cbusqueda3($iusuario2acub1,$iusuario2acub2,"acu","iusuario2acu","","1","","");cbusqueda3($acumuladoacub1,$acumuladoacub2,"acu","acumuladoacu","","0","","");cbusqueda3($activob1,$activob2,"acu","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from acu ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($iusuario1acul1=="on") { echo("<td>Usuario</td>"); $totalcolumnas=$totalcolumnas+1;}if($iusuario2acul1=="on") { echo("<td>Usuario donador</td>"); $totalcolumnas=$totalcolumnas+1;}if($acumuladoacul1=="on") { echo("<td>Acumulado</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
echo("</tr>");   
if (!$result) 
{
  echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
  exit();
}	 
	 
while ( $row = mysqli_fetch_array($result) )
{	   
if($acumuladoacul1=="on") $sumatoriaacumuladoacu=$sumatoriaacumuladoacu+$row["acumuladoacu"];$tempoexcel=" ";
echo("<tr>");   
echo("<td>".$row["id"]."</td>");
if($iusuario1acul1=="on") { echo("<td>".$row["nombreusuario"]."</td>"); } if($iusuario2acul1=="on") { echo("<td>".$row["nombreusuario1"]."</td>"); } if($acumuladoacul1=="on") { echo("<td>".$row["acumuladoacu"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($iusuario1acul1=="on") echo("<td>".$sumatoriaiusuario1acu."</td>");if($iusuario2acul1=="on") echo("<td>".$sumatoriaiusuario2acu."</td>");if($acumuladoacul1=="on") echo("<td>".$sumatoriaacumuladoacu."</td>"); 
}

?>





