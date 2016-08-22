<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=tra.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==2)   {     if($fechatral1=="on" || $importetral1=="on" || $minimodonativotral1=="on" || $ganadorestral1=="on" || $statustral1=="on") $error=9;     if($fechatrab1<>"" || $importetrab1<>"" || $minimodonativotrab1<>"" || $ganadorestrab1<>"" || $statustrab1<>"") $error=9;   }  if($nivelusuario==3)   {     if($fechatral1=="on" || $importetral1=="on" || $minimodonativotral1=="on" || $ganadorestral1=="on" || $statustral1=="on") $error=9;     if($fechatrab1<>"" || $importetrab1<>"" || $minimodonativotrab1<>"" || $ganadorestrab1<>"" || $statustrab1<>"") $error=9;   }  if($nivelusuario==4)   {     if($fechatral1=="on" || $importetral1=="on" || $minimodonativotral1=="on" || $ganadorestral1=="on" || $statustral1=="on") $error=9;     if($fechatrab1<>"" || $importetrab1<>"" || $minimodonativotrab1<>"" || $ganadorestrab1<>"" || $statustrab1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="tra.activo DESC,irettra ASC"; $ordenamiento="";$activob1="="; $activob2="1";$irettral1="on"; $iusuariotral1="on"; $fechatral1="on"; $importetral1="on"; $minimodonativotral1="on"; $ganadorestral1="on"; } $camposbuscadoslistadosearch="tra.id";cbusqueda1($activol1,"tra","activo");cbusqueda1($irettral1,"ret","nombreret","0","","");cbusqueda1($iusuariotral1,"usuarios","nombreusuario","0","","");cbusqueda1($fechatral1,"tra","fechatra");cbusqueda1($importetral1,"tra","importetra");cbusqueda1($minimodonativotral1,"tra","minimodonativotra");cbusqueda1($ganadorestral1,"tra","ganadorestra");cbusqueda1($statustral1,"tra","statustra");cbusqueda2($irettral1,"ret","tra","irettra","",0,"id");cbusqueda2($iusuariotral1,"usuarios","tra","iusuariotra","",0,"id");cbusqueda3($irettrab1,$irettrab2,"tra","irettra","","0","","");cbusqueda3($iusuariotrab1,$iusuariotrab2,"tra","iusuariotra","","0","","");cbusqueda3($fechatrab1,$fechatrab2,"tra","fechatra","'","0","","");cbusqueda3($importetrab1,$importetrab2,"tra","importetra","","0","","");cbusqueda3($minimodonativotrab1,$minimodonativotrab2,"tra","minimodonativotra","","0","","");cbusqueda3($ganadorestrab1,$ganadorestrab2,"tra","ganadorestra","","0","","");cbusqueda3($statustrab1,$statustrab2,"tra","statustra","'","0","","");cbusqueda3($activob1,$activob2,"tra","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from tra ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($irettral1=="on") { echo("<td>Iniciativa</td>"); $totalcolumnas=$totalcolumnas+1;}if($iusuariotral1=="on") { echo("<td>Usuario</td>"); $totalcolumnas=$totalcolumnas+1;}if($fechatral1=="on") { echo("<td>Fecha de alta</td>"); $totalcolumnas=$totalcolumnas+1;}if($importetral1=="on") { echo("<td>Importe</td>"); $totalcolumnas=$totalcolumnas+1;}if($minimodonativotral1=="on") { echo("<td>Mínimo donativo</td>"); $totalcolumnas=$totalcolumnas+1;}if($ganadorestral1=="on") { echo("<td>Ganadores</td>"); $totalcolumnas=$totalcolumnas+1;}if($statustral1=="on") { echo("<td>Status de pago</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($irettral1=="on") { echo("<td>".$row["nombreret"]."</td>"); } if($iusuariotral1=="on") { echo("<td>".$row["nombreusuario"]."</td>"); } if($fechatral1=="on") { echo("<td>".$row["fechatra"].$tempoexcel."</td>"); $tempoexcel="";}if($importetral1=="on") { echo("<td>".$row["importetra"].$tempoexcel."</td>"); $tempoexcel="";}if($minimodonativotral1=="on") { echo("<td>".$row["minimodonativotra"].$tempoexcel."</td>"); $tempoexcel="";}if($ganadorestral1=="on") { echo("<td>".$row["ganadorestra"].$tempoexcel."</td>"); $tempoexcel="";}if($statustral1=="on")  { if($row["statustra"]=="0") $tempostatustra="Pendiente de pago";if($row["statustra"]=="1") $tempostatustra="Pagado";if($row["statustra"]=="2") $tempostatustra="Cancelado";echo("<td>".$tempostatustra.$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($irettral1=="on") echo("<td>".$sumatoriairettra."</td>");if($iusuariotral1=="on") echo("<td>".$sumatoriaiusuariotra."</td>");if($fechatral1=="on") echo("<td>".$sumatoriafechatra."</td>");if($importetral1=="on") echo("<td>".$sumatoriaimportetra."</td>");if($minimodonativotral1=="on") echo("<td>".$sumatoriaminimodonativotra."</td>");if($ganadorestral1=="on") echo("<td>".$sumatoriaganadorestra."</td>");if($statustral1=="on") echo("<td>".$sumatoriastatustra."</td>"); 
}

?>





