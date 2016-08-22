<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=estados.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($ipaisestadol1=="on" || $nombreestadol1=="on") $error=9;     if($ipaisestadob1<>"" || $nombreestadob1<>"") $error=9;   }  if($nivelusuario==2)   {     if($ipaisestadol1=="on" || $nombreestadol1=="on") $error=9;     if($ipaisestadob1<>"" || $nombreestadob1<>"") $error=9;   }  if($nivelusuario==3)   {     if($ipaisestadol1=="on" || $nombreestadol1=="on") $error=9;     if($ipaisestadob1<>"" || $nombreestadob1<>"") $error=9;   }  if($nivelusuario==4)   {     if($ipaisestadol1=="on" || $nombreestadol1=="on") $error=9;     if($ipaisestadob1<>"" || $nombreestadob1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="estados.activo DESC,ipaisestado ASC"; $ordenamiento="";$activob1="="; $activob2="1";$ipaisestadol1="on"; $nombreestadol1="on"; } $camposbuscadoslistadosearch="estados.id";cbusqueda1($activol1,"estados","activo");cbusqueda1($ipaisestadol1,"pais","nombrepais","0","","");cbusqueda1($nombreestadol1,"estados","nombreestado");cbusqueda2($ipaisestadol1,"pais","estados","ipaisestado","",0,"id");cbusqueda3($ipaisestadob1,$ipaisestadob2,"estados","ipaisestado","","0","","");cbusqueda3($nombreestadob1,$nombreestadob2,"estados","nombreestado","'","0","","");cbusqueda3($activob1,$activob2,"estados","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from estados ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($ipaisestadol1=="on") { echo("<td>País</td>"); $totalcolumnas=$totalcolumnas+1;}if($nombreestadol1=="on") { echo("<td>Estado</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($ipaisestadol1=="on") { echo("<td>".$row["nombrepais"]."</td>"); } if($nombreestadol1=="on") { echo("<td>".$row["nombreestado"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($ipaisestadol1=="on") echo("<td>".$sumatoriaipaisestado."</td>");if($nombreestadol1=="on") echo("<td>".$sumatorianombreestado."</td>"); 
}

?>





