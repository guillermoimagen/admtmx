<?
  include("../recursos/entrada.php"); include("../recursos/xss_var.php");
  include("../recursos/inicializasesion.php"); 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=usuarios.xls");
  include("../../include/connection.php");
  include("../recursos/funciones.php"); 
  foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); }
?>
<?if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==0)   {     if($destacadousuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on") $error=9;     if($destacadousuariob1<>"" || $videousuariob1<>"" || $imagenfondousuariob1<>"" || $descripcionusuariob1<>"" || $i_descripcionusuariob1<>"" || $urlusuariob1<>"" || $enviarnotificacionesusuariob1<>"" || $tgustausuariob1<>"" || $tcomentariosusuariob1<>"") $error=9;   }  if($nivelusuario==1)   {     if($destacadousuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on") $error=9;     if($destacadousuariob1<>"" || $videousuariob1<>"" || $imagenfondousuariob1<>"" || $descripcionusuariob1<>"" || $i_descripcionusuariob1<>"" || $urlusuariob1<>"" || $enviarnotificacionesusuariob1<>"" || $tgustausuariob1<>"" || $tcomentariosusuariob1<>"") $error=9;   }  if($nivelusuario==2)   {     if($destacadousuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on") $error=9;     if($destacadousuariob1<>"" || $videousuariob1<>"" || $imagenfondousuariob1<>"" || $descripcionusuariob1<>"" || $i_descripcionusuariob1<>"" || $urlusuariob1<>"" || $enviarnotificacionesusuariob1<>"" || $tgustausuariob1<>"" || $tcomentariosusuariob1<>"") $error=9;   }  if($nivelusuario==3)   {     if($itusuusuariol1=="on" || $destacadousuariol1=="on" || $emailusuariol1=="on" || $contrasenausuariol1=="on" || $nickusuariol1=="on" || $nombreusuariol1=="on" || $imagenusuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $validadousuariol1=="on" || $cmsusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $ipaisusuariol1=="on" || $iestadousuariol1=="on" || $tel1usuariol1=="on" || $tel2usuariol1=="on" || $ttusuariol1=="on" || $familiarteletonusuariol1=="on" || $icritusuariol1=="on" || $ientusuariol1=="on" || $ipor1usuariol1=="on" || $ipor2usuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on" || $ndonusuariol1=="on" || $idonusuariol1=="on" || $nrdonusuariol1=="on" || $irdonusuariol1=="on" || $fbusuariol1=="on" || $tokenfbusuariol1=="on" || $codigousuariol1=="on") $error=9;     if($itusuusuariob1<>"" || $destacadousuariob1<>"" || $emailusuariob1<>"" || $contrasenausuariob1<>"" || $nickusuariob1<>"" || $nombreusuariob1<>"" || $imagenusuariob1<>"" || $videousuariob1<>"" || $imagenfondousuariob1<>"" || $descripcionusuariob1<>"" || $i_descripcionusuariob1<>"" || $urlusuariob1<>"" || $validadousuariob1<>"" || $cmsusuariob1<>"" || $enviarnotificacionesusuariob1<>"" || $ipaisusuariob1<>"" || $iestadousuariob1<>"" || $tel1usuariob1<>"" || $tel2usuariob1<>"" || $ttusuariob1<>"" || $familiarteletonusuariob1<>"" || $icritusuariob1<>"" || $ientusuariob1<>"" || $ipor1usuariob1<>"" || $ipor2usuariob1<>"" || $tgustausuariob1<>"" || $tcomentariosusuariob1<>"" || $ndonusuariob1<>"" || $idonusuariob1<>"" || $nrdonusuariob1<>"" || $irdonusuariob1<>"" || $fbusuariob1<>"" || $tokenfbusuariob1<>"" || $codigousuariob1<>"") $error=9;   }  if($nivelusuario==4)   {     if($itusuusuariol1=="on" || $destacadousuariol1=="on" || $emailusuariol1=="on" || $contrasenausuariol1=="on" || $nickusuariol1=="on" || $nombreusuariol1=="on" || $imagenusuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $validadousuariol1=="on" || $cmsusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $ipaisusuariol1=="on" || $iestadousuariol1=="on" || $tel1usuariol1=="on" || $tel2usuariol1=="on" || $ttusuariol1=="on" || $familiarteletonusuariol1=="on" || $icritusuariol1=="on" || $ientusuariol1=="on" || $ipor1usuariol1=="on" || $ipor2usuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on" || $ndonusuariol1=="on" || $idonusuariol1=="on" || $nrdonusuariol1=="on" || $irdonusuariol1=="on" || $fbusuariol1=="on" || $tokenfbusuariol1=="on" || $codigousuariol1=="on") $error=9;     if($itusuusuariob1<>"" || $destacadousuariob1<>"" || $emailusuariob1<>"" || $contrasenausuariob1<>"" || $nickusuariob1<>"" || $nombreusuariob1<>"" || $imagenusuariob1<>"" || $videousuariob1<>"" || $imagenfondousuariob1<>"" || $descripcionusuariob1<>"" || $i_descripcionusuariob1<>"" || $urlusuariob1<>"" || $validadousuariob1<>"" || $cmsusuariob1<>"" || $enviarnotificacionesusuariob1<>"" || $ipaisusuariob1<>"" || $iestadousuariob1<>"" || $tel1usuariob1<>"" || $tel2usuariob1<>"" || $ttusuariob1<>"" || $familiarteletonusuariob1<>"" || $icritusuariob1<>"" || $ientusuariob1<>"" || $ipor1usuariob1<>"" || $ipor2usuariob1<>"" || $tgustausuariob1<>"" || $tcomentariosusuariob1<>"" || $ndonusuariob1<>"" || $idonusuariob1<>"" || $nrdonusuariob1<>"" || $irdonusuariob1<>"" || $fbusuariob1<>"" || $tokenfbusuariob1<>"" || $codigousuariob1<>"") $error=9;   }}if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>



<? 
if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="usuarios.activo DESC,itusuusuario ASC"; $ordenamiento="";$activob1="="; $activob2="1";$itusuusuariol1="on"; $destacadousuariol1="on"; $emailusuariol1="on"; $nombreusuariol1="on"; $validadousuariol1="on"; $cmsusuariol1="on"; $tgustausuariol1="on"; $tcomentariosusuariol1="on"; $ndonusuariol1="on"; $idonusuariol1="on"; $nrdonusuariol1="on"; $irdonusuariol1="on"; $codigousuariol1="on"; } $camposbuscadoslistadosearch="usuarios.id";cbusqueda1($activol1,"usuarios","activo");cbusqueda1($itusuusuariol1,"tusu","tipotusu","0","","");cbusqueda1($destacadousuariol1,"usuarios","destacadousuario");cbusqueda1($emailusuariol1,"usuarios","emailusuario");cbusqueda1($contrasenausuariol1,"usuarios","contrasenausuario");cbusqueda1($nickusuariol1,"usuarios","nickusuario");cbusqueda1($nombreusuariol1,"usuarios","nombreusuario");cbusqueda1($imagenusuariol1,"usuarios","imagenusuario");cbusqueda1($videousuariol1,"usuarios","videousuario");cbusqueda1($imagenfondousuariol1,"usuarios","imagenfondousuario");cbusqueda1($descripcionusuariol1,"usuarios","descripcionusuario");cbusqueda1($i_descripcionusuariol1,"usuarios","i_descripcionusuario");cbusqueda1($urlusuariol1,"usuarios","urlusuario");cbusqueda1($validadousuariol1,"usuarios","validadousuario");cbusqueda1($cmsusuariol1,"usuarios","cmsusuario");cbusqueda1($enviarnotificacionesusuariol1,"usuarios","enviarnotificacionesusuario");cbusqueda1($ipaisusuariol1,"pais","nombrepais","0","","");cbusqueda1($iestadousuariol1,"estados","nombreestado","0","","");cbusqueda1($tel1usuariol1,"usuarios","tel1usuario");cbusqueda1($tel2usuariol1,"usuarios","tel2usuario");cbusqueda1($ttusuariol1,"usuarios","ttusuario");cbusqueda1($familiarteletonusuariol1,"usuarios","familiarteletonusuario");cbusqueda1($icritusuariol1,"crits","nombrecrit","0","","");cbusqueda1($ientusuariol1,"ent","comoent","0","","");cbusqueda1($ipor1usuariol1,"por","porquepor","0","","");cbusqueda1($ipor2usuariol1,"por","porquepor","0","","");cbusqueda1($tgustausuariol1,"usuarios","tgustausuario");cbusqueda1($tcomentariosusuariol1,"usuarios","tcomentariosusuario");cbusqueda1($ndonusuariol1,"usuarios","ndonusuario");cbusqueda1($idonusuariol1,"usuarios","idonusuario");cbusqueda1($nrdonusuariol1,"usuarios","nrdonusuario");cbusqueda1($irdonusuariol1,"usuarios","irdonusuario");cbusqueda1($fbusuariol1,"usuarios","fbusuario");cbusqueda1($tokenfbusuariol1,"usuarios","tokenfbusuario");cbusqueda1($codigousuariol1,"usuarios","codigousuario");cbusqueda2($itusuusuariol1,"tusu","usuarios","itusuusuario","",0,"id");cbusqueda2($ipaisusuariol1,"pais","usuarios","ipaisusuario","",0,"id");cbusqueda2($iestadousuariol1,"estados","usuarios","iestadousuario","",0,"id");cbusqueda2($icritusuariol1,"crits","usuarios","icritusuario","",0,"id");cbusqueda2($ientusuariol1,"ent","usuarios","ientusuario","",0,"id");cbusqueda2($ipor1usuariol1,"por","usuarios","ipor1usuario","",0,"id");cbusqueda2($ipor2usuariol1,"por","usuarios","ipor2usuario","",0,"id");cbusqueda3($itusuusuariob1,$itusuusuariob2,"usuarios","itusuusuario","","0","","");cbusqueda3($destacadousuariob1,$destacadousuariob2,"usuarios","destacadousuario","'","0","","");cbusqueda3($emailusuariob1,$emailusuariob2,"usuarios","emailusuario","'","0","","");cbusqueda3($contrasenausuariob1,$contrasenausuariob2,"usuarios","contrasenausuario","'","0","","");cbusqueda3($nickusuariob1,$nickusuariob2,"usuarios","nickusuario","'","0","","");cbusqueda3($nombreusuariob1,$nombreusuariob2,"usuarios","nombreusuario","'","0","","");cbusqueda3($imagenusuariob1,$imagenusuariob2,"usuarios","imagenusuario","'","0","","");cbusqueda3($videousuariob1,$videousuariob2,"usuarios","videousuario","'","0","","");cbusqueda3($imagenfondousuariob1,$imagenfondousuariob2,"usuarios","imagenfondousuario","'","0","","");cbusqueda3($descripcionusuariob1,$descripcionusuariob2,"usuarios","descripcionusuario","'","0","","");cbusqueda3($i_descripcionusuariob1,$i_descripcionusuariob2,"usuarios","i_descripcionusuario","'","0","","");cbusqueda3($urlusuariob1,$urlusuariob2,"usuarios","urlusuario","'","0","","");cbusqueda3($validadousuariob1,$validadousuariob2,"usuarios","validadousuario","'","0","","");cbusqueda3($cmsusuariob1,$cmsusuariob2,"usuarios","cmsusuario","'","0","","");cbusqueda3($enviarnotificacionesusuariob1,$enviarnotificacionesusuariob2,"usuarios","enviarnotificacionesusuario","'","0","","");cbusqueda3($ipaisusuariob1,$ipaisusuariob2,"usuarios","ipaisusuario","","0","","");cbusqueda3($iestadousuariob1,$iestadousuariob2,"usuarios","iestadousuario","","0","","");cbusqueda3($tel1usuariob1,$tel1usuariob2,"usuarios","tel1usuario","'","0","","");cbusqueda3($tel2usuariob1,$tel2usuariob2,"usuarios","tel2usuario","'","0","","");cbusqueda3($ttusuariob1,$ttusuariob2,"usuarios","ttusuario","'","0","","");cbusqueda3($familiarteletonusuariob1,$familiarteletonusuariob2,"usuarios","familiarteletonusuario","'","0","","");cbusqueda3($icritusuariob1,$icritusuariob2,"usuarios","icritusuario","","0","","");cbusqueda3($ientusuariob1,$ientusuariob2,"usuarios","ientusuario","","0","","");cbusqueda3($ipor1usuariob1,$ipor1usuariob2,"usuarios","ipor1usuario","","0","","");cbusqueda3($ipor2usuariob1,$ipor2usuariob2,"usuarios","ipor2usuario","","0","","");cbusqueda3($tgustausuariob1,$tgustausuariob2,"usuarios","tgustausuario","","0","","");cbusqueda3($tcomentariosusuariob1,$tcomentariosusuariob2,"usuarios","tcomentariosusuario","","0","","");cbusqueda3($ndonusuariob1,$ndonusuariob2,"usuarios","ndonusuario","","0","","");cbusqueda3($idonusuariob1,$idonusuariob2,"usuarios","idonusuario","","0","","");cbusqueda3($nrdonusuariob1,$nrdonusuariob2,"usuarios","nrdonusuario","","0","","");cbusqueda3($irdonusuariob1,$irdonusuariob2,"usuarios","irdonusuario","","0","","");cbusqueda3($fbusuariob1,$fbusuariob2,"usuarios","fbusuario","'","0","","");cbusqueda3($tokenfbusuariob1,$tokenfbusuariob2,"usuarios","tokenfbusuario","'","0","","");cbusqueda3($codigousuariob1,$codigousuariob2,"usuarios","codigousuario","'","0","","");cbusqueda3($activob1,$activob2,"usuarios","activo","'","0","","");
    
    $rutinabusqueda=$camposbuscadoslistadosearch." from usuarios ";
	
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
echo("<td>id</td>");$totalcolumnas=1;if($itusuusuariol1=="on") { echo("<td>Tipo</td>"); $totalcolumnas=$totalcolumnas+1;}if($destacadousuariol1=="on") { echo("<td>Destacado</td>"); $totalcolumnas=$totalcolumnas+1;}if($emailusuariol1=="on") { echo("<td>Email</td>"); $totalcolumnas=$totalcolumnas+1;}if($contrasenausuariol1=="on") { echo("<td>Contrase�a</td>"); $totalcolumnas=$totalcolumnas+1;}if($nickusuariol1=="on") { echo("<td>Nick</td>"); $totalcolumnas=$totalcolumnas+1;}if($nombreusuariol1=="on") { echo("<td>Nombre</td>"); $totalcolumnas=$totalcolumnas+1;}if($imagenusuariol1=="on") { echo("<td>Imagen</td>"); $totalcolumnas=$totalcolumnas+1;}if($videousuariol1=="on") { echo("<td>URL youtube</td>"); $totalcolumnas=$totalcolumnas+1;}if($imagenfondousuariol1=="on") { echo("<td>Imagen de fondo</td>"); $totalcolumnas=$totalcolumnas+1;}if($descripcionusuariol1=="on") { echo("<td>Descripci�n</td>"); $totalcolumnas=$totalcolumnas+1;}if($i_descripcionusuariol1=="on") { echo("<td>Descripci�n en ingl�s</td>"); $totalcolumnas=$totalcolumnas+1;}if($urlusuariol1=="on") { echo("<td>URL</td>"); $totalcolumnas=$totalcolumnas+1;}if($validadousuariol1=="on") { echo("<td>Validado</td>"); $totalcolumnas=$totalcolumnas+1;}if($cmsusuariol1=="on") { echo("<td>Es administrador</td>"); $totalcolumnas=$totalcolumnas+1;}if($enviarnotificacionesusuariol1=="on") { echo("<td>Enviar notificaciones</td>"); $totalcolumnas=$totalcolumnas+1;}if($ipaisusuariol1=="on") { echo("<td>Pa�s</td>"); $totalcolumnas=$totalcolumnas+1;}if($iestadousuariol1=="on") { echo("<td>Estado</td>"); $totalcolumnas=$totalcolumnas+1;}if($tel1usuariol1=="on") { echo("<td>Tel�fono 1</td>"); $totalcolumnas=$totalcolumnas+1;}if($tel2usuariol1=="on") { echo("<td>Tel�fono 2</td>"); $totalcolumnas=$totalcolumnas+1;}if($ttusuariol1=="on") { echo("<td>Twitter</td>"); $totalcolumnas=$totalcolumnas+1;}if($familiarteletonusuariol1=="on") { echo("<td>�Alg�n familiar es o fue paciente de un Centro Telet�n?</td>"); $totalcolumnas=$totalcolumnas+1;}if($icritusuariol1=="on") { echo("<td>�Cu�l?</td>"); $totalcolumnas=$totalcolumnas+1;}if($ientusuariol1=="on") { echo("<td>�C�mo se enter�?</td>"); $totalcolumnas=$totalcolumnas+1;}if($ipor1usuariol1=="on") { echo("<td>�Porqu� nos apoya? (1)</td>"); $totalcolumnas=$totalcolumnas+1;}if($ipor2usuariol1=="on") { echo("<td>�Porqu� nos apoya? (2)</td>"); $totalcolumnas=$totalcolumnas+1;}if($tgustausuariol1=="on") { echo("<td>Total de gusta</td>"); $totalcolumnas=$totalcolumnas+1;}if($tcomentariosusuariol1=="on") { echo("<td>Total de comentarios</td>"); $totalcolumnas=$totalcolumnas+1;}if($ndonusuariol1=="on") { echo("<td>N�mero de donaciones realizadas</td>"); $totalcolumnas=$totalcolumnas+1;}if($idonusuariol1=="on") { echo("<td>Importe de donaciones realizadas</td>"); $totalcolumnas=$totalcolumnas+1;}if($nrdonusuariol1=="on") { echo("<td>N�mero de donaciones recibidas</td>"); $totalcolumnas=$totalcolumnas+1;}if($irdonusuariol1=="on") { echo("<td>Imp�rte de donaciones recibidas</td>"); $totalcolumnas=$totalcolumnas+1;}if($fbusuariol1=="on") { echo("<td>FB</td>"); $totalcolumnas=$totalcolumnas+1;}if($tokenfbusuariol1=="on") { echo("<td>Token FB</td>"); $totalcolumnas=$totalcolumnas+1;}if($codigousuariol1=="on") { echo("<td>C�digo</td>"); $totalcolumnas=$totalcolumnas+1;}if($activol1=="on") { echo("<td>Activo</td>"); $totalcolumnas=$totalcolumnas+1;}echo("\n"); 
echo("</tr>");   
if (!$result) 
{
  echo("<p>Ocurri� un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
  exit();
}	 
	 
while ( $row = mysqli_fetch_array($result) )
{	   
if($tgustausuariol1=="on") $sumatoriatgustausuario=$sumatoriatgustausuario+$row["tgustausuario"];if($tcomentariosusuariol1=="on") $sumatoriatcomentariosusuario=$sumatoriatcomentariosusuario+$row["tcomentariosusuario"];if($ndonusuariol1=="on") $sumatoriandonusuario=$sumatoriandonusuario+$row["ndonusuario"];if($idonusuariol1=="on") $sumatoriaidonusuario=$sumatoriaidonusuario+$row["idonusuario"];if($nrdonusuariol1=="on") $sumatorianrdonusuario=$sumatorianrdonusuario+$row["nrdonusuario"];if($irdonusuariol1=="on") $sumatoriairdonusuario=$sumatoriairdonusuario+$row["irdonusuario"];$tempoexcel=" ";
echo("<tr>");   
echo("<td>".$row["id"]."</td>");
if($itusuusuariol1=="on") { echo("<td>".$row["tipotusu"]."</td>"); } if($destacadousuariol1=="on")  { if($row["destacadousuario"]=="0") $tempodestacadousuario="NO";if($row["destacadousuario"]=="1") $tempodestacadousuario="SI";echo("<td>".$tempodestacadousuario.$tempoexcel."</td>"); $tempoexcel="";}if($emailusuariol1=="on") { echo("<td>".$row["emailusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($contrasenausuariol1=="on") { echo("<td>".$row["contrasenausuario"].$tempoexcel."</td>"); $tempoexcel="";}if($nickusuariol1=="on") { echo("<td>".$row["nickusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($nombreusuariol1=="on") { echo("<td>".$row["nombreusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($imagenusuariol1=="on") { echo("<td>".$row["imagenusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($videousuariol1=="on") { echo("<td>".$row["videousuario"].$tempoexcel."</td>"); $tempoexcel="";}if($imagenfondousuariol1=="on") { echo("<td>".$row["imagenfondousuario"].$tempoexcel."</td>"); $tempoexcel="";}if($descripcionusuariol1=="on") { echo("<td>".$row["descripcionusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($i_descripcionusuariol1=="on") { echo("<td>".$row["i_descripcionusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($urlusuariol1=="on") { echo("<td>".$row["urlusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($validadousuariol1=="on")  { if($row["validadousuario"]=="0") $tempovalidadousuario="Pendiente";if($row["validadousuario"]=="1") $tempovalidadousuario="Validado";if($row["validadousuario"]=="2") $tempovalidadousuario="Registro parcial";echo("<td>".$tempovalidadousuario.$tempoexcel."</td>"); $tempoexcel="";}if($cmsusuariol1=="on")  { if($row["cmsusuario"]=="0") $tempocmsusuario="NO";if($row["cmsusuario"]=="1") $tempocmsusuario="SI";echo("<td>".$tempocmsusuario.$tempoexcel."</td>"); $tempoexcel="";}if($enviarnotificacionesusuariol1=="on")  { if($row["enviarnotificacionesusuario"]=="0") $tempoenviarnotificacionesusuario="NO";if($row["enviarnotificacionesusuario"]=="1") $tempoenviarnotificacionesusuario="SI";echo("<td>".$tempoenviarnotificacionesusuario.$tempoexcel."</td>"); $tempoexcel="";}if($ipaisusuariol1=="on") { echo("<td>".$row["nombrepais"]."</td>"); } if($iestadousuariol1=="on") { echo("<td>".$row["nombreestado"]."</td>"); } if($tel1usuariol1=="on") { echo("<td>".$row["tel1usuario"].$tempoexcel."</td>"); $tempoexcel="";}if($tel2usuariol1=="on") { echo("<td>".$row["tel2usuario"].$tempoexcel."</td>"); $tempoexcel="";}if($ttusuariol1=="on") { echo("<td>".$row["ttusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($familiarteletonusuariol1=="on")  { if($row["familiarteletonusuario"]=="0") $tempofamiliarteletonusuario="NO";if($row["familiarteletonusuario"]=="1") $tempofamiliarteletonusuario="SI";echo("<td>".$tempofamiliarteletonusuario.$tempoexcel."</td>"); $tempoexcel="";}if($icritusuariol1=="on") { echo("<td>".$row["nombrecrit"]."</td>"); } if($ientusuariol1=="on") { echo("<td>".$row["comoent"]."</td>"); } if($ipor1usuariol1=="on") { echo("<td>".$row["porquepor"]."</td>"); } if($ipor2usuariol1=="on") { echo("<td>".$row["porquepor"]."</td>"); } if($tgustausuariol1=="on") { echo("<td>".$row["tgustausuario"].$tempoexcel."</td>"); $tempoexcel="";}if($tcomentariosusuariol1=="on") { echo("<td>".$row["tcomentariosusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($ndonusuariol1=="on") { echo("<td>".$row["ndonusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($idonusuariol1=="on") { echo("<td>".$row["idonusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($nrdonusuariol1=="on") { echo("<td>".$row["nrdonusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($irdonusuariol1=="on") { echo("<td>".$row["irdonusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($fbusuariol1=="on") { echo("<td>".$row["fbusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($tokenfbusuariol1=="on") { echo("<td>".$row["tokenfbusuario"].$tempoexcel."</td>"); $tempoexcel="";}if($codigousuariol1=="on") { echo("<td>".$row["codigousuario"].$tempoexcel."</td>"); $tempoexcel="";} if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>"; echo("<td>".$tempoactivo.$tempoexcel."</td>"); $tempoexcel="";} 
echo("</tr>");   
}
		
echo("<td>");if($itusuusuariol1=="on") echo("<td>".$sumatoriaitusuusuario."</td>");if($destacadousuariol1=="on") echo("<td>".$sumatoriadestacadousuario."</td>");if($emailusuariol1=="on") echo("<td>".$sumatoriaemailusuario."</td>");if($contrasenausuariol1=="on") echo("<td>".$sumatoriacontrasenausuario."</td>");if($nickusuariol1=="on") echo("<td>".$sumatorianickusuario."</td>");if($nombreusuariol1=="on") echo("<td>".$sumatorianombreusuario."</td>");if($imagenusuariol1=="on") echo("<td>".$sumatoriaimagenusuario."</td>");if($videousuariol1=="on") echo("<td>".$sumatoriavideousuario."</td>");if($imagenfondousuariol1=="on") echo("<td>".$sumatoriaimagenfondousuario."</td>");if($descripcionusuariol1=="on") echo("<td>".$sumatoriadescripcionusuario."</td>");if($i_descripcionusuariol1=="on") echo("<td>".$sumatoriai_descripcionusuario."</td>");if($urlusuariol1=="on") echo("<td>".$sumatoriaurlusuario."</td>");if($validadousuariol1=="on") echo("<td>".$sumatoriavalidadousuario."</td>");if($cmsusuariol1=="on") echo("<td>".$sumatoriacmsusuario."</td>");if($enviarnotificacionesusuariol1=="on") echo("<td>".$sumatoriaenviarnotificacionesusuario."</td>");if($ipaisusuariol1=="on") echo("<td>".$sumatoriaipaisusuario."</td>");if($iestadousuariol1=="on") echo("<td>".$sumatoriaiestadousuario."</td>");if($tel1usuariol1=="on") echo("<td>".$sumatoriatel1usuario."</td>");if($tel2usuariol1=="on") echo("<td>".$sumatoriatel2usuario."</td>");if($ttusuariol1=="on") echo("<td>".$sumatoriattusuario."</td>");if($familiarteletonusuariol1=="on") echo("<td>".$sumatoriafamiliarteletonusuario."</td>");if($icritusuariol1=="on") echo("<td>".$sumatoriaicritusuario."</td>");if($ientusuariol1=="on") echo("<td>".$sumatoriaientusuario."</td>");if($ipor1usuariol1=="on") echo("<td>".$sumatoriaipor1usuario."</td>");if($ipor2usuariol1=="on") echo("<td>".$sumatoriaipor2usuario."</td>");if($tgustausuariol1=="on") echo("<td>".$sumatoriatgustausuario."</td>");if($tcomentariosusuariol1=="on") echo("<td>".$sumatoriatcomentariosusuario."</td>");if($ndonusuariol1=="on") echo("<td>".$sumatoriandonusuario."</td>");if($idonusuariol1=="on") echo("<td>".$sumatoriaidonusuario."</td>");if($nrdonusuariol1=="on") echo("<td>".$sumatorianrdonusuario."</td>");if($irdonusuariol1=="on") echo("<td>".$sumatoriairdonusuario."</td>");if($fbusuariol1=="on") echo("<td>".$sumatoriafbusuario."</td>");if($tokenfbusuariol1=="on") echo("<td>".$sumatoriatokenfbusuario."</td>");if($codigousuariol1=="on") echo("<td>".$sumatoriacodigousuario."</td>"); 
}

?>





