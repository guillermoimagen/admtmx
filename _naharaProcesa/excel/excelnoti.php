<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=noti.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($titulonotil1=="on" || $i_titulonotil1=="on" || $textonotil1=="on" || $i_textonotil1=="on" || $intronotil1=="on" || $i_intronotil1=="on" || $imagennotil1=="on" || $videonotil1=="on" || $fechanotil1=="on") $error=9;     if($titulonotib1<>"" || $i_titulonotib1<>"" || $textonotib1<>"" || $i_textonotib1<>"" || $intronotib1<>"" || $i_intronotib1<>"" || $imagennotib1<>"" || $videonotib1<>"" || $fechanotib1<>"") $error=9;   }  if($nivelusuario==2)   {     if($titulonotil1=="on" || $i_titulonotil1=="on" || $textonotil1=="on" || $i_textonotil1=="on" || $intronotil1=="on" || $i_intronotil1=="on" || $imagennotil1=="on" || $videonotil1=="on" || $fechanotil1=="on") $error=9;     if($titulonotib1<>"" || $i_titulonotib1<>"" || $textonotib1<>"" || $i_textonotib1<>"" || $intronotib1<>"" || $i_intronotib1<>"" || $imagennotib1<>"" || $videonotib1<>"" || $fechanotib1<>"") $error=9;   }  if($nivelusuario==3)   {     if($titulonotil1=="on" || $i_titulonotil1=="on" || $textonotil1=="on" || $i_textonotil1=="on" || $intronotil1=="on" || $i_intronotil1=="on" || $imagennotil1=="on" || $videonotil1=="on" || $fechanotil1=="on") $error=9;     if($titulonotib1<>"" || $i_titulonotib1<>"" || $textonotib1<>"" || $i_textonotib1<>"" || $intronotib1<>"" || $i_intronotib1<>"" || $imagennotib1<>"" || $videonotib1<>"" || $fechanotib1<>"") $error=9;   }  if($nivelusuario==4)   {     if($titulonotil1=="on" || $i_titulonotil1=="on" || $textonotil1=="on" || $i_textonotil1=="on" || $intronotil1=="on" || $i_intronotil1=="on" || $imagennotil1=="on" || $videonotil1=="on" || $fechanotil1=="on") $error=9;     if($titulonotib1<>"" || $i_titulonotib1<>"" || $textonotib1<>"" || $i_textonotib1<>"" || $intronotib1<>"" || $i_intronotib1<>"" || $imagennotib1<>"" || $videonotib1<>"" || $fechanotib1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="noti.activo DESC,titulonoti ASC"; $ordenamiento="";$activob1="="; $activob2="1";$titulonotil1="on"; $i_titulonotil1="on"; $imagennotil1="on"; $videonotil1="on"; } $camposbuscadoslistadosearch="noti.id";cbusqueda1($activol1,"noti","activo");cbusqueda1($titulonotil1,"noti","titulonoti");cbusqueda1($i_titulonotil1,"noti","i_titulonoti");cbusqueda1($textonotil1,"noti","textonoti");cbusqueda1($i_textonotil1,"noti","i_textonoti");cbusqueda1($intronotil1,"noti","intronoti");cbusqueda1($i_intronotil1,"noti","i_intronoti");cbusqueda1($imagennotil1,"noti","imagennoti");cbusqueda1($videonotil1,"noti","videonoti");cbusqueda1($fechanotil1,"noti","fechanoti");cbusqueda3($titulonotib1,$titulonotib2,"noti","titulonoti","'","0","","");cbusqueda3($i_titulonotib1,$i_titulonotib2,"noti","i_titulonoti","'","0","","");cbusqueda3($textonotib1,$textonotib2,"noti","textonoti","'","0","","");cbusqueda3($i_textonotib1,$i_textonotib2,"noti","i_textonoti","'","0","","");cbusqueda3($intronotib1,$intronotib2,"noti","intronoti","'","0","","");cbusqueda3($i_intronotib1,$i_intronotib2,"noti","i_intronoti","'","0","","");cbusqueda3($imagennotib1,$imagennotib2,"noti","imagennoti","'","0","","");cbusqueda3($videonotib1,$videonotib2,"noti","videonoti","'","0","","");cbusqueda3($fechanotib1,$fechanotib2,"noti","fechanoti","'","0","","");cbusqueda3($activob1,$activob2,"noti","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from noti ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($titulonotil1=="on") { echo("<td>Nombre</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_titulonotil1=="on") { echo("<td>Nombre en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($textonotil1=="on") { echo("<td>Texto</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_textonotil1=="on") { echo("<td>Texto en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($intronotil1=="on") { echo("<td>Intro</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_intronotil1=="on") { echo("<td>Intro en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($imagennotil1=="on") { echo("<td>Imagen</td>"); $totalcolumnas=$totalcolumnas+1;}if($videonotil1=="on") { echo("<td>Video</td>"); $totalcolumnas=$totalcolumnas+1;}if($fechanotil1=="on") { echo("<td>Fecha</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($titulonotil1=="on") { echo("<td>".$row["titulonoti"].$tempoexcel."</td>"); $tempoexcel="";}if($i_titulonotil1=="on") { echo("<td>".$row["i_titulonoti"].$tempoexcel."</td>"); $tempoexcel="";}if($textonotil1=="on") { echo("<td>".$row["textonoti"].$tempoexcel."</td>"); $tempoexcel="";}if($i_textonotil1=="on") { echo("<td>".$row["i_textonoti"].$tempoexcel."</td>"); $tempoexcel="";}if($intronotil1=="on") { echo("<td>".$row["intronoti"].$tempoexcel."</td>"); $tempoexcel="";}if($i_intronotil1=="on") { echo("<td>".$row["i_intronoti"].$tempoexcel."</td>"); $tempoexcel="";}if($imagennotil1=="on") { echo("<td>".$row["imagennoti"].$tempoexcel."</td>"); $tempoexcel="";}if($videonotil1=="on") { echo("<td>".$row["videonoti"].$tempoexcel."</td>"); $tempoexcel="";}if($fechanotil1=="on") { echo("<td>".$row["fechanoti"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($titulonotil1=="on") echo("<td>".$sumatoriatitulonoti."</td>");if($i_titulonotil1=="on") echo("<td>".$sumatoriai_titulonoti."</td>");if($textonotil1=="on") echo("<td>".$sumatoriatextonoti."</td>");if($i_textonotil1=="on") echo("<td>".$sumatoriai_textonoti."</td>");if($intronotil1=="on") echo("<td>".$sumatoriaintronoti."</td>");if($i_intronotil1=="on") echo("<td>".$sumatoriai_intronoti."</td>");if($imagennotil1=="on") echo("<td>".$sumatoriaimagennoti."</td>");if($videonotil1=="on") echo("<td>".$sumatoriavideonoti."</td>");if($fechanotil1=="on") echo("<td>".$sumatoriafechanoti."</td>"); 
}

?>





