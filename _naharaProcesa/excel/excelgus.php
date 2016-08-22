<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=gus.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>




<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="gus.activo DESC,iusuariogus ASC"; $ordenamiento="";$activob1="="; $activob2="1";$iusuariogusl1="on"; $iretgusl1="on"; } $camposbuscadoslistadosearch="gus.id";cbusqueda1($activol1,"gus","activo");cbusqueda1($iusuariogusl1,"usuarios","nombreusuario","0","","");cbusqueda1($iretgusl1,"ret","nombreret","0","","");cbusqueda1($fechagusl1,"gus","fechagus");cbusqueda2($iusuariogusl1,"usuarios","gus","iusuariogus","",0,"id");cbusqueda2($iretgusl1,"ret","gus","iretgus","",0,"id");cbusqueda3($iusuariogusb1,$iusuariogusb2,"gus","iusuariogus","","0","","");cbusqueda3($iretgusb1,$iretgusb2,"gus","iretgus","","0","","");cbusqueda3($fechagusb1,$fechagusb2,"gus","fechagus","'","0","","");cbusqueda3($activob1,$activob2,"gus","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from gus ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($iusuariogusl1=="on") { echo("<td>Usuario</td>"); $totalcolumnas=$totalcolumnas+1;}if($iretgusl1=="on") { echo("<td>Reto</td>"); $totalcolumnas=$totalcolumnas+1;}if($fechagusl1=="on") { echo("<td>Fecha</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($iusuariogusl1=="on") { echo("<td>".$row["nombreusuario"]."</td>"); } if($iretgusl1=="on") { echo("<td>".$row["nombreret"]."</td>"); } if($fechagusl1=="on") { echo("<td>".$row["fechagus"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($iusuariogusl1=="on") echo("<td>".$sumatoriaiusuariogus."</td>");if($iretgusl1=="on") echo("<td>".$sumatoriairetgus."</td>");if($fechagusl1=="on") echo("<td>".$sumatoriafechagus."</td>"); 
}

?>





