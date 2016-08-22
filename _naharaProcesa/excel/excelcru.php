<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=cru.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($icatcrul1=="on" || $iusuariocrul1=="on" || $iretocrul1=="on") $error=9;     if($icatcrub1<>"" || $iusuariocrub1<>"" || $iretocrub1<>"") $error=9;   }  if($nivelusuario==2)   {     if($icatcrul1=="on" || $iusuariocrul1=="on" || $iretocrul1=="on") $error=9;     if($icatcrub1<>"" || $iusuariocrub1<>"" || $iretocrub1<>"") $error=9;   }  if($nivelusuario==3)   {     if($icatcrul1=="on" || $iusuariocrul1=="on" || $iretocrul1=="on") $error=9;     if($icatcrub1<>"" || $iusuariocrub1<>"" || $iretocrub1<>"") $error=9;   }  if($nivelusuario==4)   {     if($icatcrul1=="on" || $iusuariocrul1=="on" || $iretocrul1=="on") $error=9;     if($icatcrub1<>"" || $iusuariocrub1<>"" || $iretocrub1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="cru.activo DESC,icatcru ASC"; $ordenamiento="";$activob1="="; $activob2="1";$icatcrul1="on"; $iusuariocrul1="on"; } $camposbuscadoslistadosearch="cru.id";cbusqueda1($activol1,"cru","activo");cbusqueda1($icatcrul1,"cat","nombrecat","0","","");cbusqueda1($iusuariocrul1,"usuarios","nombreusuario","0","","");cbusqueda1($iretocrul1,"ret","nombreret","0","","");cbusqueda2($icatcrul1,"cat","cru","icatcru","",0,"id");cbusqueda2($iusuariocrul1,"usuarios","cru","iusuariocru","",0,"id");cbusqueda2($iretocrul1,"ret","cru","iretocru","",0,"id");cbusqueda3($icatcrub1,$icatcrub2,"cru","icatcru","","0","","");cbusqueda3($iusuariocrub1,$iusuariocrub2,"cru","iusuariocru","","0","","");cbusqueda3($iretocrub1,$iretocrub2,"cru","iretocru","","0","","");cbusqueda3($activob1,$activob2,"cru","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from cru ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($icatcrul1=="on") { echo("<td>Categoría</td>"); $totalcolumnas=$totalcolumnas+1;}if($iusuariocrul1=="on") { echo("<td>Usuario</td>"); $totalcolumnas=$totalcolumnas+1;}if($iretocrul1=="on") { echo("<td>Reto</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($icatcrul1=="on") { echo("<td>".$row["nombrecat"]."</td>"); } if($iusuariocrul1=="on") { echo("<td>".$row["nombreusuario"]."</td>"); } if($iretocrul1=="on") { echo("<td>".$row["nombreret"]."</td>"); }  if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($icatcrul1=="on") echo("<td>".$sumatoriaicatcru."</td>");if($iusuariocrul1=="on") echo("<td>".$sumatoriaiusuariocru."</td>");if($iretocrul1=="on") echo("<td>".$sumatoriairetocru."</td>"); 
}

?>





