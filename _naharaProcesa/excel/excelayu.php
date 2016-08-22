<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=ayu.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($campoayul1=="on" || $labelayul1=="on" || $i_labelayul1=="on" || $textoayul1=="on" || $i_textoayul1=="on" || $placeholderayul1=="on" || $i_placeholderayul1=="on") $error=9;     if($campoayub1<>"" || $labelayub1<>"" || $i_labelayub1<>"" || $textoayub1<>"" || $i_textoayub1<>"" || $placeholderayub1<>"" || $i_placeholderayub1<>"") $error=9;   }  if($nivelusuario==2)   {     if($campoayul1=="on" || $labelayul1=="on" || $i_labelayul1=="on" || $textoayul1=="on" || $i_textoayul1=="on" || $placeholderayul1=="on" || $i_placeholderayul1=="on") $error=9;     if($campoayub1<>"" || $labelayub1<>"" || $i_labelayub1<>"" || $textoayub1<>"" || $i_textoayub1<>"" || $placeholderayub1<>"" || $i_placeholderayub1<>"") $error=9;   }  if($nivelusuario==3)   {     if($campoayul1=="on" || $labelayul1=="on" || $i_labelayul1=="on" || $textoayul1=="on" || $i_textoayul1=="on" || $placeholderayul1=="on" || $i_placeholderayul1=="on") $error=9;     if($campoayub1<>"" || $labelayub1<>"" || $i_labelayub1<>"" || $textoayub1<>"" || $i_textoayub1<>"" || $placeholderayub1<>"" || $i_placeholderayub1<>"") $error=9;   }  if($nivelusuario==4)   {     if($campoayul1=="on" || $labelayul1=="on" || $i_labelayul1=="on" || $textoayul1=="on" || $i_textoayul1=="on" || $placeholderayul1=="on" || $i_placeholderayul1=="on") $error=9;     if($campoayub1<>"" || $labelayub1<>"" || $i_labelayub1<>"" || $textoayub1<>"" || $i_textoayub1<>"" || $placeholderayub1<>"" || $i_placeholderayub1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="ayu.activo DESC,campoayu ASC"; $ordenamiento="";$activob1="="; $activob2="1";$campoayul1="on"; $labelayul1="on"; $i_labelayul1="on"; } $camposbuscadoslistadosearch="ayu.id";cbusqueda1($activol1,"ayu","activo");cbusqueda1($campoayul1,"ayu","campoayu");cbusqueda1($labelayul1,"ayu","labelayu");cbusqueda1($i_labelayul1,"ayu","i_labelayu");cbusqueda1($textoayul1,"ayu","textoayu");cbusqueda1($i_textoayul1,"ayu","i_textoayu");cbusqueda1($placeholderayul1,"ayu","placeholderayu");cbusqueda1($i_placeholderayul1,"ayu","i_placeholderayu");cbusqueda3($campoayub1,$campoayub2,"ayu","campoayu","'","0","","");cbusqueda3($labelayub1,$labelayub2,"ayu","labelayu","'","0","","");cbusqueda3($i_labelayub1,$i_labelayub2,"ayu","i_labelayu","'","0","","");cbusqueda3($textoayub1,$textoayub2,"ayu","textoayu","'","0","","");cbusqueda3($i_textoayub1,$i_textoayub2,"ayu","i_textoayu","'","0","","");cbusqueda3($placeholderayub1,$placeholderayub2,"ayu","placeholderayu","'","0","","");cbusqueda3($i_placeholderayub1,$i_placeholderayub2,"ayu","i_placeholderayu","'","0","","");cbusqueda3($activob1,$activob2,"ayu","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from ayu ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($campoayul1=="on") { echo("<td>Campo</td>"); $totalcolumnas=$totalcolumnas+1;}if($labelayul1=="on") { echo("<td>Eiqueta</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_labelayul1=="on") { echo("<td>Etiqueta en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($textoayul1=="on") { echo("<td>Texto</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_textoayul1=="on") { echo("<td>Texto en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($placeholderayul1=="on") { echo("<td>Place holder</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_placeholderayul1=="on") { echo("<td>Place holder en inglés</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($campoayul1=="on") { echo("<td>".$row["campoayu"].$tempoexcel."</td>"); $tempoexcel="";}if($labelayul1=="on") { echo("<td>".$row["labelayu"].$tempoexcel."</td>"); $tempoexcel="";}if($i_labelayul1=="on") { echo("<td>".$row["i_labelayu"].$tempoexcel."</td>"); $tempoexcel="";}if($textoayul1=="on") { echo("<td>".$row["textoayu"].$tempoexcel."</td>"); $tempoexcel="";}if($i_textoayul1=="on") { echo("<td>".$row["i_textoayu"].$tempoexcel."</td>"); $tempoexcel="";}if($placeholderayul1=="on") { echo("<td>".$row["placeholderayu"].$tempoexcel."</td>"); $tempoexcel="";}if($i_placeholderayul1=="on") { echo("<td>".$row["i_placeholderayu"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($campoayul1=="on") echo("<td>".$sumatoriacampoayu."</td>");if($labelayul1=="on") echo("<td>".$sumatorialabelayu."</td>");if($i_labelayul1=="on") echo("<td>".$sumatoriai_labelayu."</td>");if($textoayul1=="on") echo("<td>".$sumatoriatextoayu."</td>");if($i_textoayul1=="on") echo("<td>".$sumatoriai_textoayu."</td>");if($placeholderayul1=="on") echo("<td>".$sumatoriaplaceholderayu."</td>");if($i_placeholderayul1=="on") echo("<td>".$sumatoriai_placeholderayu."</td>"); 
}

?>





