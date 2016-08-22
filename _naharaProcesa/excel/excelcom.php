<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=com.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==0)   {     if($fechacomb1<>"" || $textocomb1<>"" || $statuscomb1<>"") $error=9;   }  if($nivelusuario==1)   {     if($fechacomb1<>"" || $textocomb1<>"" || $statuscomb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($fechacomb1<>"" || $textocomb1<>"" || $statuscomb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($fechacoml1=="on" || $textocoml1=="on" || $statuscoml1=="on") $error=9;     if($fechacomb1<>"" || $textocomb1<>"" || $statuscomb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($fechacoml1=="on" || $textocoml1=="on" || $statuscoml1=="on") $error=9;     if($fechacomb1<>"" || $textocomb1<>"" || $statuscomb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="com.activo DESC,iusuariocom ASC"; $ordenamiento="";$activob1="="; $activob2="1";$iusuariocoml1="on"; $iretcoml1="on"; $fechacoml1="on"; $textocoml1="on"; $statuscoml1="on"; } $camposbuscadoslistadosearch="com.id";cbusqueda1($activol1,"com","activo");cbusqueda1($iusuariocoml1,"usuarios","nombreusuario","0","","");cbusqueda1($iretcoml1,"ret","nombreret","0","","");cbusqueda1($fechacoml1,"com","fechacom");cbusqueda1($textocoml1,"com","textocom");cbusqueda1($statuscoml1,"com","statuscom");cbusqueda2($iusuariocoml1,"usuarios","com","iusuariocom","",0,"id");cbusqueda2($iretcoml1,"ret","com","iretcom","",0,"id");cbusqueda3($iusuariocomb1,$iusuariocomb2,"com","iusuariocom","","0","","");cbusqueda3($iretcomb1,$iretcomb2,"com","iretcom","","0","","");cbusqueda3($fechacomb1,$fechacomb2,"com","fechacom","'","0","","");cbusqueda3($textocomb1,$textocomb2,"com","textocom","'","0","","");cbusqueda3($statuscomb1,$statuscomb2,"com","statuscom","'","0","","");cbusqueda3($activob1,$activob2,"com","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from com ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($iusuariocoml1=="on") { echo("<td>Usuario</td>"); $totalcolumnas=$totalcolumnas+1;}if($iretcoml1=="on") { echo("<td>Reto</td>"); $totalcolumnas=$totalcolumnas+1;}if($fechacoml1=="on") { echo("<td>Fecha</td>"); $totalcolumnas=$totalcolumnas+1;}if($textocoml1=="on") { echo("<td>Texto</td>"); $totalcolumnas=$totalcolumnas+1;}if($statuscoml1=="on") { echo("<td>Status</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($iusuariocoml1=="on") { echo("<td>".$row["nombreusuario"]."</td>"); } if($iretcoml1=="on") { echo("<td>".$row["nombreret"]."</td>"); } if($fechacoml1=="on") { echo("<td>".$row["fechacom"].$tempoexcel."</td>"); $tempoexcel="";}if($textocoml1=="on") { echo("<td>".$row["textocom"].$tempoexcel."</td>"); $tempoexcel="";}if($statuscoml1=="on")  { if($row["statuscom"]=="0") $tempostatuscom="En espera";if($row["statuscom"]=="1") $tempostatuscom="Validado";if($row["statuscom"]=="2") $tempostatuscom="Rechazado";echo("<td>".$tempostatuscom.$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($iusuariocoml1=="on") echo("<td>".$sumatoriaiusuariocom."</td>");if($iretcoml1=="on") echo("<td>".$sumatoriairetcom."</td>");if($fechacoml1=="on") echo("<td>".$sumatoriafechacom."</td>");if($textocoml1=="on") echo("<td>".$sumatoriatextocom."</td>");if($statuscoml1=="on") echo("<td>".$sumatoriastatuscom."</td>"); 
}

?>





