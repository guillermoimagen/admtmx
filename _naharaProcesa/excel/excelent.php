<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=ent.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($comoentl1=="on" || $i_comoentl1=="on" || $ordenentl1=="on") $error=9;     if($comoentb1<>"" || $i_comoentb1<>"" || $ordenentb1<>"") $error=9;   }  if($nivelusuario==2)   {     if($comoentl1=="on" || $i_comoentl1=="on" || $ordenentl1=="on") $error=9;     if($comoentb1<>"" || $i_comoentb1<>"" || $ordenentb1<>"") $error=9;   }  if($nivelusuario==3)   {     if($comoentl1=="on" || $i_comoentl1=="on" || $ordenentl1=="on") $error=9;     if($comoentb1<>"" || $i_comoentb1<>"" || $ordenentb1<>"") $error=9;   }  if($nivelusuario==4)   {     if($comoentl1=="on" || $i_comoentl1=="on" || $ordenentl1=="on") $error=9;     if($comoentb1<>"" || $i_comoentb1<>"" || $ordenentb1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="ent.activo DESC,comoent ASC"; $ordenamiento="";$activob1="="; $activob2="1";$comoentl1="on"; $i_comoentl1="on"; $ordenentl1="on"; } $camposbuscadoslistadosearch="ent.id";cbusqueda1($activol1,"ent","activo");cbusqueda1($comoentl1,"ent","comoent");cbusqueda1($i_comoentl1,"ent","i_comoent");cbusqueda1($ordenentl1,"ent","ordenent");cbusqueda3($comoentb1,$comoentb2,"ent","comoent","'","0","","");cbusqueda3($i_comoentb1,$i_comoentb2,"ent","i_comoent","'","0","","");cbusqueda3($ordenentb1,$ordenentb2,"ent","ordenent","","0","","");cbusqueda3($activob1,$activob2,"ent","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from ent ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($comoentl1=="on") { echo("<td>¿Cómo se enteró?</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_comoentl1=="on") { echo("<td>¿Cómo se enteró?</td>"); $totalcolumnas=$totalcolumnas+1;}if($ordenentl1=="on") { echo("<td>Orden</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($comoentl1=="on") { echo("<td>".$row["comoent"].$tempoexcel."</td>"); $tempoexcel="";}if($i_comoentl1=="on") { echo("<td>".$row["i_comoent"].$tempoexcel."</td>"); $tempoexcel="";}if($ordenentl1=="on") { echo("<td>".$row["ordenent"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($comoentl1=="on") echo("<td>".$sumatoriacomoent."</td>");if($i_comoentl1=="on") echo("<td>".$sumatoriai_comoent."</td>");if($ordenentl1=="on") echo("<td>".$sumatoriaordenent."</td>"); 
}

?>





