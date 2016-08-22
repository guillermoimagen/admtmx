<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=causuarios.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($nombreusuariol1=="on" || $usernameusuariol1=="on" || $passwordusuariol1=="on" || $nivelusuarioreall1=="on" || $emailusuariol1=="on") $error=9;     if($nombreusuariob1<>"" || $usernameusuariob1<>"" || $passwordusuariob1<>"" || $nivelusuariorealb1<>"" || $emailusuariob1<>"") $error=9;   }  if($nivelusuario==2)   {     if($nombreusuariol1=="on" || $usernameusuariol1=="on" || $passwordusuariol1=="on" || $nivelusuarioreall1=="on" || $emailusuariol1=="on") $error=9;     if($nombreusuariob1<>"" || $usernameusuariob1<>"" || $passwordusuariob1<>"" || $nivelusuariorealb1<>"" || $emailusuariob1<>"") $error=9;   }  if($nivelusuario==3)   {     if($nombreusuariol1=="on" || $usernameusuariol1=="on" || $passwordusuariol1=="on" || $nivelusuarioreall1=="on" || $emailusuariol1=="on") $error=9;     if($nombreusuariob1<>"" || $usernameusuariob1<>"" || $passwordusuariob1<>"" || $nivelusuariorealb1<>"" || $emailusuariob1<>"") $error=9;   }  if($nivelusuario==4)   {     if($nombreusuariol1=="on" || $usernameusuariol1=="on" || $passwordusuariol1=="on" || $nivelusuarioreall1=="on" || $emailusuariol1=="on") $error=9;     if($nombreusuariob1<>"" || $usernameusuariob1<>"" || $passwordusuariob1<>"" || $nivelusuariorealb1<>"" || $emailusuariob1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="causuarios.activo DESC,nombreusuario ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombreusuariol1="on"; $usernameusuariol1="on"; $nivelusuarioreall1="on"; $emailusuariol1="on"; } $camposbuscadoslistadosearch="causuarios.id";cbusqueda1($activol1,"causuarios","activo");cbusqueda1($nombreusuariol1,"causuarios","nombreusuario");cbusqueda1($usernameusuariol1,"causuarios","usernameusuario");cbusqueda1($passwordusuariol1,"causuarios","passwordusuario");cbusqueda1($nivelusuarioreall1,"causuarios","nivelusuarioreal");cbusqueda1($emailusuariol1,"causuarios","emailusuario");cbusqueda3($nombreusuariob1,$nombreusuariob2,"causuarios","nombreusuario","'","0","","");cbusqueda3($usernameusuariob1,$usernameusuariob2,"causuarios","usernameusuario","'","0","","");cbusqueda3($passwordusuariob1,$passwordusuariob2,"causuarios","passwordusuario","'","0","","");cbusqueda3($nivelusuariorealb1,$nivelusuariorealb2,"causuarios","nivelusuarioreal","'","0","","");cbusqueda3($emailusuariob1,$emailusuariob2,"causuarios","emailusuario","'","0","","");cbusqueda3($activob1,$activob2,"causuarios","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from causuarios ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($nombreusuariol1=="on") { echo("<td>Nombre</td>"); $totalcolumnas=$totalcolumnas+1;}if($usernameusuariol1=="on") { echo("<td>Username</td>"); $totalcolumnas=$totalcolumnas+1;}if($passwordusuariol1=="on") { echo("<td>Password</td>"); $totalcolumnas=$totalcolumnas+1;}if($nivelusuarioreall1=="on") { echo("<td>Nivel</td>"); $totalcolumnas=$totalcolumnas+1;}if($emailusuariol1=="on") { echo("<td>Email</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
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
if($nombreusuariol1=="on") { echo("<td>".$row["nombreusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($usernameusuariol1=="on") { echo("<td>".$row["usernameusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($passwordusuariol1=="on") { echo("<td>".$row["passwordusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($nivelusuarioreall1=="on")  { if($row["nivelusuarioreal"]=="0") $temponivelusuarioreal="Webmaster";if($row["nivelusuarioreal"]=="1") $temponivelusuarioreal="Administrador";if($row["nivelusuarioreal"]=="2") $temponivelusuarioreal="Consultas";echo("<td>".$temponivelusuarioreal.$tempoexcel."</td>"); $tempoexcel="";}if($emailusuariol1=="on") { echo("<td>".$row["emailusuario"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($nombreusuariol1=="on") echo("<td>".$sumatorianombreusuario."</td>");if($usernameusuariol1=="on") echo("<td>".$sumatoriausernameusuario."</td>");if($passwordusuariol1=="on") echo("<td>".$sumatoriapasswordusuario."</td>");if($nivelusuarioreall1=="on") echo("<td>".$sumatorianivelusuarioreal."</td>");if($emailusuariol1=="on") echo("<td>".$sumatoriaemailusuario."</td>"); 
}

?>





