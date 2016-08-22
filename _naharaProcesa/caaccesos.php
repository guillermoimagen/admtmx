<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

include("recursos/funciones.php"); 
include("recursos/iconosybotones.php");
$controlmatch="NO";
?>

<html>

<link rel="stylesheet" href="recursos/estilos.css" type="text/css">
<? 
if($step==1) $step="busqueda3";

$numerodetabla=101;
$archivoactual="caaccesos.php";
$valordisabled="";
$idcontrolinterno=generaidcontrol();

if($step=="busqueda2" ) 
{
  if(round($idbuscado)>0)
  {
    $id=$idbuscado;	
    $step="modify";
	$idcontrolinterno=generaidcontrol();
  }
  else if($idbuscado<>"")
  {
    $mensaje="No se puede realizar la búsqueda directa porque el valor ingresado no es válido.";
	$step="busqueda";
  }	
}
if($sesionprivilegiosespecialesusuario=="1")
{
  $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select count(cagruposprivilegios.id) from caprivilegiosusuarios,cagruposprivilegios where caprivilegiosusuarios.idusuarioprivilegiousuario=".$sesionid." AND caprivilegiosusuarios.idgrupoprivilegiousuario=cagruposprivilegios.id AND cagruposprivilegios.activo=1 AND cagruposprivilegios.nombregrupoprivilegio='usuarios'");
  while($rowx = mysqli_fetch_array($resultx))
  {
     if($rowx[0]<=0) { $mensaje=guardareporte(11); $step=""; $operacion=""; }
  }
}


?>
<?
if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }
else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }
if($step=="busqueda2" || $step=="busqueda3") 
{ 
  if($nivelusuario==1) 
  { 
    if($idusuarioaccesol1=="on" || $ipaddressaccesol1=="on" || $fechaaccesol1=="on" || $horaaccesol1=="on" || $fechasalidaaccesol1=="on" || $horasalidaaccesol1=="on" || $hitsaccesol1=="on") $error=9; 
    if(isset($idusuarioaccesob2) || isset($ipaddressaccesob2) || isset($fechaaccesob2) || isset($horaaccesob2) || isset($fechasalidaaccesob2) || isset($horasalidaaccesob2) || isset($hitsaccesob2)) $error=9; 
  }
  if($nivelusuario==2) 
  { 
    if($idusuarioaccesol1=="on" || $ipaddressaccesol1=="on" || $fechaaccesol1=="on" || $horaaccesol1=="on" || $fechasalidaaccesol1=="on" || $horasalidaaccesol1=="on" || $hitsaccesol1=="on") $error=9; 
    if(isset($idusuarioaccesob2) || isset($ipaddressaccesob2) || isset($fechaaccesob2) || isset($horaaccesob2) || isset($fechasalidaaccesob2) || isset($horasalidaaccesob2) || isset($hitsaccesob2)) $error=9; 
  }
  if($nivelusuario==3) 
  { 
    if($idusuarioaccesol1=="on" || $ipaddressaccesol1=="on" || $fechaaccesol1=="on" || $horaaccesol1=="on" || $fechasalidaaccesol1=="on" || $horasalidaaccesol1=="on" || $hitsaccesol1=="on") $error=9; 
    if(isset($idusuarioaccesob2) || isset($ipaddressaccesob2) || isset($fechaaccesob2) || isset($horaaccesob2) || isset($fechasalidaaccesob2) || isset($horasalidaaccesob2) || isset($hitsaccesob2)) $error=9; 
  }
  if($nivelusuario==4) 
  { 
    if($idusuarioaccesol1=="on" || $ipaddressaccesol1=="on" || $fechaaccesol1=="on" || $horaaccesol1=="on" || $fechasalidaaccesol1=="on" || $horasalidaaccesol1=="on" || $hitsaccesol1=="on") $error=9; 
    if(isset($idusuarioaccesob2) || isset($ipaddressaccesob2) || isset($fechaaccesob2) || isset($horaaccesob2) || isset($fechasalidaaccesob2) || isset($horasalidaaccesob2) || isset($hitsaccesob2)) $error=9; 
  }
}
if($operacion=="modify") 
{ 
  if($nivelusuario==0) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=8; 
  if($nivelusuario==1) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=8; 
  if($nivelusuario==2) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=8; 
  if($nivelusuario==3) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=8; 
  if($nivelusuario==4) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=8; 
}
if($operacion=="add") 
{ 
  if($nivelusuario==0) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=7; 
  if($nivelusuario==1) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=7; 
  if($nivelusuario==2) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=7; 
  if($nivelusuario==3) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=7; 
  if($nivelusuario==4) if(isset($_POST["idusuarioacceso"]) || isset($_POST["ipaddressacceso"]) || isset($_POST["fechaacceso"]) || isset($_POST["horaacceso"]) || isset($_POST["fechasalidaacceso"]) || isset($_POST["horasalidaacceso"]) || isset($_POST["hitsacceso"])) $error=7; 
}

if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } 
?>

<script language="JavaScript" src="../include/funcionescolapsos.js"></script>  

<script>function muestracabezaseditar() { } </script>
<?
  if($step=="add") // ESTE ES NECESARIO POR SI ESTA PROHIBIDO AGREGAR PARA QUE NO SE MUESTRE NI SIQUIERA EL FORMULARIO
  {
	 if($nivelusuario=="meminpinguin") {    
	}
	else
	{
	  $mensaje=guardareporte(1); 
	  $operacion="";
	  $step="";
	}
  }
  
  if($step==1 || $step=="busqueda3") 
  {
	?>
	<? if($nivelusuario=="0") {?> 
	<?
	}
	else
	{
	  $mensaje=guardareporte(4); 
	  $operacion="";
	  $step="";
	}
  }
  	
  
?>





<head>

<title><? echo("Accesos"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<script>
function funcionload()
{

<? if($step=="busqueda") { ?> 
<? } else if($step=="modify" || $step=="add") { ?> 
<? } ?> 
}
</script>

</head>
<BODY topmargin=0 LEFTMARGIN=0 onLoad="funcionload();">

<?
  if($ocultabotones<>1) {   
    echo($encabezadousuario);
    include("recursos/cabeza.inc"); 
    if($ventanabotoneditar<>1)
    {
      include("menu.php"); 
      include("menu2.php"); 
    }	
  }	
?>

<?php 
  
  
  if($operacion=="modify" || $operacion=="add") 
  {
	if($operacion=="add") 
	{
	   if($nivelusuario=="meminpinguin") {
      	
	  }
	  else
	  {
	    $mensaje=guardareporte(10); 
	    $step="";
		$operacion="";
	  }
	}  
	
	if($operacion=="modify")
	{
	  if($idcontrolinterno<>$idcontrol)
	  {
	    $mensaje=guardareporte(6); 
		$operacion="";
	    $step="";
	  }
       if($nivelusuario=="10") {
	   
	  }
	  else
	  {
	    $mensaje=guardareporte(2); 
		$operacion="";
	    $step="";
	  }
	}   
	
	if($operacion=="modify" || $operacion=="add") 
	{   
      $sqltemporal.=construyesqltemporal("idusuarioacceso","",0);
$sqltemporal.=construyesqltemporal("ipaddressacceso","'",0);
$sqltemporal.=construyesqltemporal("fechaacceso","'",0);
$sqltemporal.=construyesqltemporal("horaacceso","'",0);
$sqltemporal.=construyesqltemporal("fechasalidaacceso","'",0);
$sqltemporal.=construyesqltemporal("horasalidaacceso","'",0);
$sqltemporal.=construyesqltemporal("hitsacceso","",0);
$sqltemporal.=construyesqltemporal("activo","",0);

    
	}
	
	if($sqltemporal=="" && ($operacion=="add" || $operacion=="modify")) 
	{
	  $mensaje="Nada que guardar";
	  $modomensaje="NADA";
	  $operacion="";
	}  
	
	


	
	if($operacion=="add") 
	{	
	  $controlmatch="SI";  
	   if($nivelusuario=="meminpinguin") {		
		  $sql = "INSERT INTO caaccesos SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.="Se guardó correctamente el registro";
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
					
			
		  } 
		  else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="Ya existe un registro con esos datos<br>No se ha guardado el registro.";
			  $modomensaje="ERROR";
			  $error_unique=1;
			  $step="add";		 
			}
			else
			{
			  $mensaje.="Ocurrió un error al guardar el registro: " . mysqli_error($GLOBALS["enlaceDB"] );
			  $modomensaje="ERROR";
			}
		  }	  
	  }
	  else
	  {
	    $mensaje=guardareporte(10); 
	    $step="";
		$operacion="";
	  }
	}
	    
	if($operacion=="modify")
	{	  
	  $controlmatch="SI";	
	   if($nivelusuario=="10") {	      
		  $sql = "UPDATE caaccesos SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.="Se actualizó correctamente el registro";
			  
			  
			}
			else
			{
			  $mensaje.="No hubo cambios en el registro";
			  $modomensaje="NADA";
			}  
			  
		  } else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="Ya existe un registro con esos datos<br>No se ha guardado el registro";
			  $modomensaje="ERROR";
			  $error_unique=1;
			  $step="modify";		 
			}
			else
			{
			  $mensaje.="Ocurrió un error al guardar el registro: " . mysqli_error($GLOBALS["enlaceDB"] );
			  $modomensaje="ERROR";
			}
		  }  
	  }  
	  else
	  {
	    $mensaje=guardareporte(2); 
		$operacion="";
	    $step="";
	  }
	}	
  }
  
  if($operacion=="delete")
  {
	  if($idcontrolinterno<>$idcontrol)
	  {
	    $mensaje=guardareporte(6); 
		$operacion="";
	    $step="";
	  }
      else  if($nivelusuario=="10") {
      if($confirmadelete<>"confirmado") {
$mensajedelete="";if($mensajedelete<>"") { $step="modify"; $operacion=""; $mensaje.="No se puede eliminar el registro, debido a lo siguiente:".$mensajedelete;

}
}

	  }
	  else
	  {
	    $mensaje=guardareporte(3); 
		$operacion="";
	    $step="";
	  }
	}
	  
    if($operacion=="delete") 
    {
       if($nivelusuario=="10") {
		$sql = "DELETE FROM caaccesos WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.="Se eliminó correctamente el registro <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">Regresar</a>";
		  
		  
		  $step="busqueda";
		  $operacion="";
		} 
		else 
		{
		 $mensaje.="Ocurrió un error al eliminar el registro: " . mysqli_error($GLOBALS["enlaceDB"] ) ;
		 $modomensaje="ERROR";
		} 	
	  }
	  else
	  {
	    $mensaje.=guardareporte(3); 
	    $step="";
	    $operacion="";
	  }   
    }
  	
  
?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina">
  <tr>    
    <td height="30" valign="middle"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";
$idx3=0;$idx2=0;$idx1 =0;$idx=0;
if($step=="modify"){
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,fechaacceso FROM caaccesos where id=". $id);
$rowx = mysqli_fetch_array($resultx);
$linkx=" >> ".$rowx["fechaacceso"]." ".$rowx[""];
$idx=$rowx[""];
}
echo("<a href=caaccesos.php?sortfield=fechaacceso&step=1><span class=titulo>Accesos</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? echo("Accesos"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?><? } ?></td>
	<td align="right"><? if($ocultabotones<>1) { ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>

<? 
  if($mensaje<>"") 
  {
    if($modomensaje=="ERROR") echo($entradamensajeerror.$mensaje.$salidamensaje); 
	else if($modomensaje=="NADA") echo($entradamensajenada.$mensaje.$salidamensaje); 
	else echo($entradamensaje.$mensaje.$salidamensaje); 
  }	  
?>
   
<? if($step=="busqueda2" || $step=="busqueda3") { ?> <span class=textogeneral><br>
</span> 

<table width=100% border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="spacerlateral"></td>
<td valign=top width=100%>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
  <tr> 
    <td width=100%><?
       if($step=="busqueda3" || $moditobusqueda=="especial") { 
$activol1="on"; $comparadorsearch="AND"; $sortfield="caaccesos.activo DESC,fechaacceso ASC"; $ordenamiento="";
$activob1="="; $activob2="1";
$idusuarioaccesol1="on"; 
$ipaddressaccesol1="on"; 
$fechaaccesol1="on"; 
$horaaccesol1="on"; 
$fechasalidaaccesol1="on"; 
$horasalidaaccesol1="on"; 
$hitsaccesol1="on"; 
} 

$camposbuscadoslistadosearch="caaccesos.id";
cbusqueda1($activol1,"caaccesos","activo");
cbusqueda1($idusuarioaccesol1,"causuarios","nombreusuario","0","","");
cbusqueda1($ipaddressaccesol1,"caaccesos","ipaddressacceso");
cbusqueda1($fechaaccesol1,"caaccesos","fechaacceso");
cbusqueda1($horaaccesol1,"caaccesos","horaacceso");
cbusqueda1($fechasalidaaccesol1,"caaccesos","fechasalidaacceso");
cbusqueda1($horasalidaaccesol1,"caaccesos","horasalidaacceso");
cbusqueda1($hitsaccesol1,"caaccesos","hitsacceso");
cbusqueda2($idusuarioaccesol1,"causuarios","caaccesos","idusuarioacceso","",0,"id");
cbusqueda3($idusuarioaccesob1,$idusuarioaccesob2,"caaccesos","idusuarioacceso","","0","","");
cbusqueda3($ipaddressaccesob1,$ipaddressaccesob2,"caaccesos","ipaddressacceso","'","0","","");
cbusqueda3($fechaaccesob1,$fechaaccesob2,"caaccesos","fechaacceso","'","0","","");
cbusqueda3($horaaccesob1,$horaaccesob2,"caaccesos","horaacceso","'","0","","");
cbusqueda3($fechasalidaaccesob1,$fechasalidaaccesob2,"caaccesos","fechasalidaacceso","'","0","","");
cbusqueda3($horasalidaaccesob1,$horasalidaaccesob2,"caaccesos","horasalidaacceso","'","0","","");
cbusqueda3($hitsaccesob1,$hitsaccesob2,"caaccesos","hitsacceso","","0","","");
cbusqueda3($activob1,$activob2,"caaccesos","activo","'","0","","");

	
	$rutinabusqueda=$camposbuscadoslistadosearch." from caaccesos ";
	$antesbusqueda="";
	
	if($camposcomunessearch<>"") $rutinabusqueda=$rutinabusqueda.$camposcomunessearch;
	
	if($sqltemporal<>"" && $antesbusqueda<>"") $sqltemporal=$sqltemporal." and ".$antesbusqueda;
	else if($sqltemporal=="" && $antesbusqueda<>"") $sqltemporal=$antesbusqueda;
	
	if($sqltemporal<>"") 
	{	  
	  $rutinabusqueda=$rutinabusqueda." where ".$sqltemporal;	  
	}
	$rutinabusqueda=$rutinabusqueda." order by ".$sortfield." ".$ordenamiento;
	
	
	
	if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT ".$rutinabusqueda);
    $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$rutinabusqueda);
	  $num_rows = mysqli_num_rows($result);
	?>
      <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? echo("Accesos"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?> <span class=textogeneral>(<?=$num_rows?> registros<?=$mensajelimite?>) <?=$sqltemporal?> </span></td>
         
        
        </tr>
      </table>
    </td> </tr>

  <tr> 
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";
cbusqueda5($idusuarioaccesol1,"Usuario",": STR");
cbusqueda5($ipaddressaccesol1,"Dirección IP del acceso",": STR");
cbusqueda5($fechaaccesol1,"Fecha de entrada"," : DATE");
cbusqueda5($horaaccesol1,"Hora de entrada",": STR");
cbusqueda5($fechasalidaaccesol1,"Fecha de salida"," : DATE");
cbusqueda5($horasalidaaccesol1,"Hora de salida",": STR");
cbusqueda5($hitsaccesol1,"Cliks durante el acceso"," : NUM");
 if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  
?>
<script language="JavaScript">
var TABLE_CAPT = [<?=$tigracabeza?>];
var TABLE_LOOK = {
'structure' : [0, 1, 2, 3, 4, 5],
'params' : [3, 0],
'colors' : {
'even'    : '#<?=$vsitioscolor3?>',
'odd'     : '#<?=$vsitioscolor4?>',
'hovered' : '#ffffff',
'marked'  : '#ffff66'
},
'freeze' : [0, 1],
'paging' : {
'by' : 15,
'tt' : '&nbsp;Página %ind de %pgs&nbsp;',
'pp' : '&nbsp;<',
'pf' : '<< ',
'pn' : '>',
'pl' : '&nbsp;>>'
},
'sorting' : {
'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">',
'ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">',
'no' : ''
},
'filter' :{
'type':11,
'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">',
'btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'
},
'css' : {
'main'     : 'textogeneral',
'body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],
'captCell' : 'cabezastabla',
'captText' : 'textogeneralnegrita',
'head'     : 'cabezastabla',
'foot'     : 'pietabla',
'pagnCell' : 'cabezastabla',
'pagnText' : 'titulointerno',
'pagnPict' : 'titulointerno',
'filtCell' : 'textogeneral',
'filtPatt' : 'textogeneral',
'filtSelc' : 'textogeneral'
}
};
<?php 
if (!$result)
{
echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
exit();
} $listadodecampossearchtigra2="";
while ( $row = mysqli_fetch_array($result) )
{
$menudetalletigra="";

$tempotigra=" ";
$botonestigra="<a href=caaccesos.php?step=modify&id=".$row["id"]." class=textoboton>&nbsp;Ver&nbsp;</a>".$menudetalletigra;

$linktigra="<a href=caaccesos.php?step=modify&id=".$row["id"]." class=textogeneral>";
 $listadodecampossearchtigra=$row["id"];
cbusqueda4($idusuarioaccesol1,"causuarios","nombreusuario","0","","");
cbusqueda4($ipaddressaccesol1,"caaccesos","ipaddressacceso","0","","");
cbusqueda4($fechaaccesol1,"caaccesos","fechaacceso","0","","");
cbusqueda4($horaaccesol1,"caaccesos","horaacceso","0","","");
cbusqueda4($fechasalidaaccesol1,"caaccesos","fechasalidaacceso","0","","");
cbusqueda4($horasalidaaccesol1,"caaccesos","horasalidaacceso","0","","");
cbusqueda4($hitsaccesol1,"caaccesos","hitsacceso","0","","");
 if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }
if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\"";
 if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";
$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";
}
$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);
$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);
$pietablasearchtigra="\"\"";
cbusqueda6($idusuarioaccesol1,$sumatoriaidusuarioacceso,'');
cbusqueda6($ipaddressaccesol1,$sumatoriaipaddressacceso,'');
cbusqueda6($fechaaccesol1,$sumatoriafechaacceso,'');
cbusqueda6($horaaccesol1,$sumatoriahoraacceso,'');
cbusqueda6($fechasalidaaccesol1,$sumatoriafechasalidaacceso,'');
cbusqueda6($horasalidaaccesol1,$sumatoriahorasalidaacceso,'');
cbusqueda6($hitsaccesol1,$sumatoriahitsacceso,'');
$pietablasearchtigra.=",\"\"";

?>
<?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?></script>
<? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" method="post" action="excel/excelcaaccesos.php?step=busqueda2" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> >
<input name=idusuarioaccesol1 type="hidden" value="<?=$idusuarioaccesol1?>" ><input name=idusuarioaccesob1 type="hidden" value="<?=$idusuarioaccesob1?>" ><input name=idusuarioaccesob2 type="hidden" value="<?=$idusuarioaccesob2?>" >
<input name=ipaddressaccesol1 type="hidden" value="<?=$ipaddressaccesol1?>" ><input name=ipaddressaccesob1 type="hidden" value="<?=$ipaddressaccesob1?>" ><input name=ipaddressaccesob2 type="hidden" value="<?=$ipaddressaccesob2?>" >
<input name=fechaaccesol1 type="hidden" value="<?=$fechaaccesol1?>" ><input name=fechaaccesob1 type="hidden" value="<?=$fechaaccesob1?>" ><input name=fechaaccesob2 type="hidden" value="<?=$fechaaccesob2?>" >
<input name=horaaccesol1 type="hidden" value="<?=$horaaccesol1?>" ><input name=horaaccesob1 type="hidden" value="<?=$horaaccesob1?>" ><input name=horaaccesob2 type="hidden" value="<?=$horaaccesob2?>" >
<input name=fechasalidaaccesol1 type="hidden" value="<?=$fechasalidaaccesol1?>" ><input name=fechasalidaaccesob1 type="hidden" value="<?=$fechasalidaaccesob1?>" ><input name=fechasalidaaccesob2 type="hidden" value="<?=$fechasalidaaccesob2?>" >
<input name=horasalidaaccesol1 type="hidden" value="<?=$horasalidaaccesol1?>" ><input name=horasalidaaccesob1 type="hidden" value="<?=$horasalidaaccesob1?>" ><input name=horasalidaaccesob2 type="hidden" value="<?=$horasalidaaccesob2?>" >
<input name=hitsaccesol1 type="hidden" value="<?=$hitsaccesol1?>" ><input name=hitsaccesob1 type="hidden" value="<?=$hitsaccesob1?>" ><input name=hitsaccesob2 type="hidden" value="<?=$hitsaccesob2?>" >
<input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcaaccesos.php?step=busqueda2');"><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onClick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
</table>
 </td><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=101 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
if(mysqli_num_rows($resultx)>0)
{
  $tempoayuda="";
  while($rowx = mysqli_fetch_array($resultx))
  {
    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
  }
  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");
  ?>
<script language="javascript" src="../include/scroll/scroll.js"></script>
<script language="javascript">var Tscr_LOOK0 = {
'size' : [190, 100],
's_i':'textogeneralaviso',
's_b':'textogeneralaviso',
'pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],
're' : [150,80, 16, 16,,'../include/scroll/mres.gif'],
'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],
'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']
},
Tscr_BEHAVE0 = {
'auto'  : true,
'vertical' : true,
'speed' : 1,
'interval' : 50,
'hide_buttons' : true,
'zindex':5
};</script>
<TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr>
<? } ?>
<tr><td  class="titulomenulateral"><b>Accesos</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=caaccesos.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar=""; if($nivelusuario==0) { 
if($menugeneraloprelacionbuscar<>"") $menugeneraloprelacionbuscar.="<br />";$menugeneraloprelacionbuscar.=generaboton("caaccesos.php?step=busqueda2&fechaaccesob1==&fechaaccesob2=".$fechahoy."&idusuarioaccesol1=on&ipaddressaccesol1=on&fechaaccesol1=on&horaaccesol1=on&fechasalidaaccesol1=on&horasalidaaccesol1=on&hitsaccesol1=on&sortfield=horaacceso&ordenamiento=DESC&comparadorsearch=AND &titulobusqueda=Accesos del día ".conviertedia($fechahoy)."","Ver accesos del día","","textogeneral");
}
 if($nivelusuario==0) { 
if($menugeneraloprelacionbuscar<>"") $menugeneraloprelacionbuscar.="<br />";$menugeneraloprelacionbuscar.=generaboton("respaldos.php?modo=1","Mantenimiento de la base de datos","","textogeneral");
}

 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_101_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_101_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_101_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Operaciones relacionadas</b></a></td></tr><tbody id="collapseobj_loprelacionbus_101_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?>

</table></td>
 <td class="spacerlateral"></td></tr>
</table>

<? } ?>


<?php 
  if($step=="add" || $step=="modify") 
  {
  ?>
  <script type="text/javascript" src="../include/validator.js"></script>
   <script language="JavaScript" src="../include/hints.js"></script>
 
<script language="JavaScript">
var HINTS_ITEMS = {'fechaacceso':wrap("aaaa-mm-dd, 2008-11-18"),'fechasalidaacceso':wrap("aaaa-mm-dd, 2008-11-18"),'activo':wrap("Seleccion SI para que el registro esté activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  <script>var directorio='../include';</script><script language="JavaScript" src="../include/calendar/calendar.js"></script><link rel="stylesheet" href="../include/calendar/calendar.css">
	<?
	
if($error_unique==0)
{
$idusuarioacceso=0;
$ipaddressacceso='';
$fechaacceso='';
$horaacceso='';
$fechasalidaacceso='';
$horasalidaacceso='';
$hitsacceso=0;

$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["idusuarioacceso"])) $idusuarioacceso=$_POST["idusuarioacceso"];
if(isset($_POST["ipaddressacceso"])) $ipaddressacceso=$_POST["ipaddressacceso"];
if(isset($_POST["fechaacceso"])) $fechaacceso=$_POST["fechaacceso"];
if(isset($_POST["horaacceso"])) $horaacceso=$_POST["horaacceso"];
if(isset($_POST["fechasalidaacceso"])) $fechasalidaacceso=$_POST["fechasalidaacceso"];
if(isset($_POST["horasalidaacceso"])) $horasalidaacceso=$_POST["horasalidaacceso"];
if(isset($_POST["hitsacceso"])) $hitsacceso=$_POST["hitsacceso"];

}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM caaccesos where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM caaccesos where id=". $id);
      if (!$result) 
	  {
        echo("<p>Ocurrió un error al buscar el registro: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
        exit();
      }  
	$registrosencontrados = mysqli_num_rows($result);
       while ( $row = mysqli_fetch_array($result) ) 
	   {
$id=$row["id"];
$activo=$row["activo"];
$idusuarioacceso=$row["idusuarioacceso"];
$ipaddressacceso=$row["ipaddressacceso"];
$fechaacceso=$row["fechaacceso"];
if($fechaacceso=="0000-00-00") $fechaacceso="";
$horaacceso=$row["horaacceso"];
$fechasalidaacceso=$row["fechasalidaacceso"];
if($fechasalidaacceso=="0000-00-00") $fechasalidaacceso="";
$horasalidaacceso=$row["horasalidaacceso"];
$hitsacceso=$row["hitsacceso"];

       }
	 }	 
	 
  ?>


<span class=textogeneral><br></span>

<? if($registrosencontrados>0) {?>

<? if($step=="modify") { ?>



<? } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100% valign=top>
	  <form name="form1" onSubmit="return v.exec()" method="post" action="caaccesos.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?>" enctype="multipart/form-data">
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo("Agregar "); else echo("Modificar "); ?><? echo("Accesos"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></span></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>  
				       
				          <? } ?>
<? if($nivelusuario=="10") {?>
<? $yabotonguardar="ya"; ?>
<input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>>
<?} ?>
<? if($step=="add" && $yabotonguardar<>"ya") { ?>
<input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>>
<? } ?></div><? } ?>
</td>
                  </tr>
                </table>
                
              </div>
          </td>
    </tr>
	
	 <tr>
       <td bgcolor="#<?=$vsitioscolor6?>"><div align="center" id="error_form1" style="display: block;"></div></td>
     </tr> 
	 
	
    <input name="idcontrol" type="hidden" value="<?=$idcontrolinterno?>">
	<input name="controlmatch" type="hidden" value="<?=$controlmatch?>">
	<input name="match_posts2" type="hidden" value="<?=$match_posts?>">	
	
	
	
	<tr>
    <td>
      <table class="textogeneraltablaform" width="100%" cellpadding="3" cellspacing="0">
      <tr bgcolor="#<?=$vsitioscolor6?>" >
        <td width="9%"></td>
	    <td width="91%"></td>
      </tr>
	
	
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idusuarioacceso">Usuario * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idusuarioacceso" class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","nombreusuario","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idusuarioacceso==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT nombreusuario from causuarios where id=".$idusuarioacceso);if(mysqli_num_rows($resultempo)>0){ $rowtempo = mysqli_fetch_array($resultempo);echo($rowtempo["nombreusuario"]." ".$rowtempo[""]." ".$rowtempo[""]); } else echo("No se encontró o no aplica");?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ipaddressacceso">Dirección IP del acceso </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="ipaddressacceso" value="<? echo(htmlspecialchars($ipaddressacceso)); ?>" size="20" maxlength="15" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$ipaddressacceso?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_fechaacceso">Fecha de entrada * <a onMouseOver="myHint.show('fechaacceso')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10)) { ?>
<input type="text" name="fechaacceso" value="<?=$fechaacceso?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT1 = {	'formname' : 'form1','controlname': 'fechaacceso','dataformat' : 'Y-m-d','today' : '<?=$fechaacceso?>','positionname':'fechaacceso','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT1, CAL_TPL1);</script>
<? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$fechaacceso?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_horaacceso">Hora de entrada * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="horaacceso" value="<? echo(htmlspecialchars($horaacceso)); ?>" size="10" maxlength="5" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$horaacceso?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_fechasalidaacceso">Fecha de salida <a onMouseOver="myHint.show('fechasalidaacceso')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10)) { ?>
<input type="text" name="fechasalidaacceso" value="<?=$fechasalidaacceso?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT2 = {	'formname' : 'form1','controlname': 'fechasalidaacceso','dataformat' : 'Y-m-d','today' : '<?=$fechasalidaacceso?>','positionname':'fechasalidaacceso','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT2, CAL_TPL1);</script>
<? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$fechasalidaacceso?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_horasalidaacceso">Hora de salida </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="horasalidaacceso" value="<? echo(htmlspecialchars($horasalidaacceso)); ?>" size="10" maxlength="5" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$horasalidaacceso?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_hitsacceso">Cliks durante el acceso </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="hitsacceso" value="<?=$hitsacceso?>" size="10" maxlength="15" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$hitsacceso?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idusuarioacceso':{'l':'Usuario','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_idusuarioacceso'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fechaacceso':{'l':'Fecha de entrada','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_fechaacceso'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'horaacceso':{'l':'Hora de entrada','r': true,'t':'t_horaacceso'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fechasalidaacceso':{'l':'Fecha de salida','r': false,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_fechasalidaacceso'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'hitsacceso':{'l':'Cliks durante el acceso','r': false,'f':'integer','t':'t_hitsacceso'}";?><? } ?>
<script>
function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }
var a_fields = { <? echo($datostigra); ?>
 }
,o_config = {
'to_disable' : ['Submit','Reset'],
'alert' : 2 + 8 + 4,
'alert_class' : ['textogeneralerror', 'textogeneral']
}
 var v = new validator('form1', a_fields, o_config)
</script>  
    <? if($nivelusuario=="meminpinguin") {?>
	<tr>
      <td valign="middle"  bgcolor="#<?=$vsitioscolor3?>">Activo <a onMouseOver="myHint.show('activo')" onMouseOut="myHint.hide()">(?)</a></td>
      <td valign="middle"  bgcolor="#<?=$vsitioscolor3?>"> 
        <select name="activo" class="textogeneralform">
          <option value="1" <? if($activo==1) { ?>selected<? }?>>SI</option>
          <option value="0" <? if($activo==0) { ?>selected<? }?>>NO</option>
        </select>
      </td>
    </tr>
    <?} ?>	
	</table>
	</td>
	</tr>

    <tr> 
     <td colspan="2"  class="titulointerior" valign="middle">              
      <div align="right">
                <? if($ocultabotones<>1) { ?>	<? if($nivelusuario=="10") {?> <? $yabotonguardar="ya"; ?>
                <input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>><?} ?>
				<? if($step=="add" && $yabotonguardar<>"ya") { ?><input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>><? } ?><? } ?>
              </div>
            </td>
    </tr>
	
    
	
	
  </table></form></td>
     <? if($ocultabotones<>1) { ?> <? if($step=="modify") { ?><? } ?><td width="10" rowspan="2"><img width="10" height="0"></td><td width="100%" valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=101 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='1'");
if(mysqli_num_rows($resultx)>0)
{
  $tempoayuda="";
  while($rowx = mysqli_fetch_array($resultx))
  {
    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
  }
  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");
  ?>
<script language="javascript" src="../include/scroll/scroll.js"></script>
<script language="javascript">var Tscr_LOOK0 = {
'size' : [190, 100],
's_i':'textogeneralaviso',
's_b':'textogeneralaviso',
'pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],
're' : [150,80, 16, 16,,'../include/scroll/mres.gif'],
'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],
'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']
},
Tscr_BEHAVE0 = {
'auto'  : true,
'vertical' : true,
'speed' : 1,
'interval' : 50,
'hide_buttons' : true,
'zindex':5
};</script>
<TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr>
<? } ?>
<tr><td  class="titulomenulateral"><b>Accesos</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=caaccesos.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<?  if($nivelusuario==0) { {if($step=="modify") { ?>
<tr><td class="textogeneralaviso" bgcolor="#FF9933">IMPORTANTE<li>La dirección IP es MUY importante en caso de seguimiento de alguna irregularidad del personal.<li>En caso de que no se cuente con fecha y hora de salida, significa que el usuario no firmó su salida.</td></tr>
<? }}} ?>
<? $menugeneraladicionalbuscar=""; if($nivelusuario==0) { if($step=="modify") {
if($menugeneraladicionaleditar<>"") $menugeneraladicionaleditar.="<br />";$menugeneraladicionaleditar.=generaboton("caseguimiento.php?step=busqueda2&idaccesoseguimientob1==&idaccesoseguimientob2=".$id."&idusuarioseguimientol1=on&idaccesoseguimientol1=on&tablaseguimientol1=on&registroseguimientol1=on&horaseguimientol1=on&operacionseguimientol1=on&sortfield=horaseguimiento&ordenamiento=DESC&comparadorsearch=AND &titulobusqueda=Operaciones de un acceso","Ver operaciones de este acceso","","textogeneral");
}}
 if($nivelusuario==0) { if($step=="modify") {
if($menugeneraladicionaleditar<>"") $menugeneraladicionaleditar.="<br />";$menugeneraladicionaleditar.=generaboton("causuarios.php?step=modify&id=".$idusuarioacceso."","Ver usuario","","textogeneral");
}}

 if($menugeneraladicionaleditar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"ladicionaledi_101_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('ladicionaledi_101_0')" class="textogeneralnegrita">
<img id="collapseimg_ladicionaledi_101_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Funciones adicionales de este registro</a>></td></tr><tbody id="collapseobj_ladicionaledi_101_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraladicionaleditar?></td></tr></tbody><? } ?>
<? $menugeneraloprelacioneditar=""; if($nivelusuario==0) { 
if($menugeneraloprelacioneditar<>"") $menugeneraloprelacioneditar.="<br />";$menugeneraloprelacioneditar.=generaboton("caaccesos.php?step=busqueda2&fechaaccesob1==&fechaaccesob2=".$fechahoy."&idusuarioaccesol1=on&ipaddressaccesol1=on&fechaaccesol1=on&horaaccesol1=on&fechasalidaaccesol1=on&horasalidaaccesol1=on&hitsaccesol1=on&sortfield=horaacceso&ordenamiento=DESC&comparadorsearch=AND &titulobusqueda=Accesos del día ".conviertedia($fechahoy)."","Ver accesos del día","","textogeneral");
}
 if($nivelusuario==0) { 
if($menugeneraloprelacioneditar<>"") $menugeneraloprelacioneditar.="<br />";$menugeneraloprelacioneditar.=generaboton("respaldos.php?modo=1","Mantenimiento de la base de datos","","textogeneral");
}

 if($menugeneraloprelacioneditar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionedi_101_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionedi_101_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionedi_101_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Operaciones relacionadas</b></a></td></tr><tbody id="collapseobj_loprelacionedi_101_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacioneditar?></td></tr></tbody><? } ?>
<? if($step=="modify") { ?>
<tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"lopcionesedi_101_1233")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('lopcionesedi_101_1233')" class="textogeneralnegrita">
<img id="collapseimg_lopcionesedi_101_1233" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Adicional</b></a></td></tr><tbody id="collapseobj_lopcionesedi_101_1233" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?
hace_boton_busquedav3("cahistorico","Histórico del acceso",$id,"iaccesohistoricob1==&iaccesohistoricob2=$id");
?></td></tr></tbody>
<? } ?>
<? if($nivelusuario==0) { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"avanzadas_101_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('avanzadas_101_0')" class="textogeneralnegrita">
<img id="collapseimg_avanzadas_101_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Avanzadas</b></a></td></tr>
<tbody id="collapseobj_avanzadas_101_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><a href="careportes.php?step=busqueda2&idtablareporteb1==&idtablareporteb2=<?=$numerodetabla?>&idregistroreporteb1==&idregistroreporteb2=<?=$id?>&moditobusqueda=especial&&titulobusqueda=Reportes de registro" class=textogeneral>Ver reportes de este registro</a><br><a href="caseguimiento.php?step=busqueda2&tablaseguimientob1==&tablaseguimientob2=<?=$numerodetabla?>&registroseguimientob1==&registroseguimientob2=<?=$id?>&moditobusqueda=especial&titulobusqueda=Seguimiento de registro" class=textogeneral>Ver seguimiento de este registro</a><br><a href="cahistorico.php?step=busqueda2&tablabusqueda=<?=$numerodetabla?>&registrobusqueda=<?=$id?>&modo=busqueda&moditobusqueda=especial&titulobusqueda=Histórico de registro" class=textogeneral target=_blank>Ver histórico completo</a></td></tr></tbody><? } ?>
</table></td>
<? } ?>
	  <td class="spacerlateral"></td>
    </tr>
</table>

 <? if($step=="modify") { ?> 

<? } ?>

<?php 
} 
else echo($entradamensaje."El registro buscado no ha sido encontrado.<br>&nbsp;&nbsp;&nbsp;Es probable que haya sido eliminado, o bien que nunca haya existido.<BR>&nbsp;&nbsp;&nbsp;Si crees que es un error, repórtalo al administrador del sistema".$salidamensaje);
}

else if($step=="busqueda") 
  {
  ?>
  <? if($nivelusuario==0 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="caaccesos.php?step=busqueda2&mensajemm=<?=$mensajemm?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior">B&uacute;squeda de <? echo("Accesos"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> Comparador
                <select name="comparadorsearch" class="textogeneral">
                  <option value="AND" selected>Y</option>
                  <option value="OR">O</option>
                </select>
Ordenar<select class="textogeneralform" name=sortfield><option value="idusuarioacceso">Usuario</option><option value="ipaddressacceso">Dirección IP del acceso</option><option value="fechaacceso" selected>Fecha de entrada</option><option value="horaacceso">Hora de entrada</option><option value="fechasalidaacceso">Fecha de salida</option><option value="horasalidaacceso">Hora de salida</option><option value="hitsacceso">Cliks durante el acceso</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('caaccesos.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');"><? } ?></td>
</tr>
          </table>
	  
            </td>
    </tr>
	
	<tr>
    <td>
      <table class="textogeneraltablaform" width="100%" cellpadding="3" cellspacing="0">
      <tr bgcolor="#<?=$vsitioscolor6?>" >
        <td width="9%"></td>
	    <td width="91%"></td>
      </tr>
	
	
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idusuarioaccesol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="idusuarioaccesob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idusuarioaccesob2" onChange="if(idusuarioaccesob1.selectedIndex==0) idusuarioaccesob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","nombreusuario","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idusuarioacceso==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Dirección IP del acceso</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="ipaddressaccesol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="ipaddressaccesob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ipaddressaccesob2" value="" size="20" onKeyUp="revisainput('ipaddressaccesob1','ipaddressaccesob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Fecha de entrada</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="fechaaccesol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="fechaaccesob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechaaccesob2" value="" size="15" onKeyUp="revisainput('fechaaccesob1','fechaaccesob2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Hora de entrada</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="horaaccesol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="horaaccesob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="horaaccesob2" value="" size="10" onKeyUp="revisainput('horaaccesob1','horaaccesob2');" maxlength="5" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Fecha de salida</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="fechasalidaaccesol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="fechasalidaaccesob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechasalidaaccesob2" value="" size="15" onKeyUp="revisainput('fechasalidaaccesob1','fechasalidaaccesob2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Hora de salida</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="horasalidaaccesol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="horasalidaaccesob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="horasalidaaccesob2" value="" size="10" onKeyUp="revisainput('horasalidaaccesob1','horasalidaaccesob2');" maxlength="5" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Cliks durante el acceso</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="hitsaccesol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="hitsaccesob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="hitsaccesob2" value="" size="10" onKeyUp="revisainput('hitsaccesob1','hitsaccesob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario=="meminpinguin") {?>
	<tr>
      <td valign="middle" bgcolor="#<?=$vsitioscolor3?>">Activo <a href="javascript:muestraayuda('Activo. Seleccione SI para que el registro esté activo en el sitio web, de lo contrario seleccione NO');">(?)</a></td>
      <td valign="middle" bgcolor="#<?=$vsitioscolor3?>"> 
        <input name="activol1" type="checkbox" checked>
        <select name="activob1" class=textogeneral>
		  <option value=""></option><option value="=" selected>igual</option>
          
          <option value="&lt;&gt;">diferente</option>
          <option value="LIKE">parecido</option>
        </select>
        <select name="activob2" onChange="if(activob1.selectedIndex==0) activob1.selectedIndex=1" class=textogeneral>
		
		  <option value="-1"></option><option value="1" selected>SI</option><option value="0">NO</option>
        </select>
      </td>
    </tr>
    <?} ?>
	</table>
	</td>
	</tr>
    <tr> 
      <td colspan="2" class="titulointerior" valign="middle">              
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('caaccesos.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcaaccesos.php?step=busqueda2');">
<?} ?><? } ?></div>
      </td>
    </tr>
  </table></form></td><? if($ocultabotones<>1) { ?><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=101 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
if(mysqli_num_rows($resultx)>0)
{
  $tempoayuda="";
  while($rowx = mysqli_fetch_array($resultx))
  {
    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
  }
  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");
  ?>
<script language="javascript" src="../include/scroll/scroll.js"></script>
<script language="javascript">var Tscr_LOOK0 = {
'size' : [190, 100],
's_i':'textogeneralaviso',
's_b':'textogeneralaviso',
'pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],
're' : [150,80, 16, 16,,'../include/scroll/mres.gif'],
'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],
'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']
},
Tscr_BEHAVE0 = {
'auto'  : true,
'vertical' : true,
'speed' : 1,
'interval' : 50,
'hide_buttons' : true,
'zindex':5
};</script>
<TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr>
<? } ?>
<tr><td  class="titulomenulateral"><b>Accesos</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=caaccesos.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar=""; if($nivelusuario==0) { 
if($menugeneraloprelacionbuscar<>"") $menugeneraloprelacionbuscar.="<br />";$menugeneraloprelacionbuscar.=generaboton("caaccesos.php?step=busqueda2&fechaaccesob1==&fechaaccesob2=".$fechahoy."&idusuarioaccesol1=on&ipaddressaccesol1=on&fechaaccesol1=on&horaaccesol1=on&fechasalidaaccesol1=on&horasalidaaccesol1=on&hitsaccesol1=on&sortfield=horaacceso&ordenamiento=DESC&comparadorsearch=AND &titulobusqueda=Accesos del día ".conviertedia($fechahoy)."","Ver accesos del día","","textogeneral");
}
 if($nivelusuario==0) { 
if($menugeneraloprelacionbuscar<>"") $menugeneraloprelacionbuscar.="<br />";$menugeneraloprelacionbuscar.=generaboton("respaldos.php?modo=1","Mantenimiento de la base de datos","","textogeneral");
}

 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_101_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_101_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_101_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Operaciones relacionadas</b></a></td></tr><tbody id="collapseobj_loprelacionbus_101_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?>

</table></td>
<? } ?>
     <td class="spacerlateral"></td>
    </tr>
  </table>
  

<?} ?>
<?php  } ?>
<? if($step=="add" || $step=="modify")  { ?>
<script language="JavaScript"> for (var n = 0; n < A_CALENDARS.length; n++) {	A_CALENDARS[n].create(); } </script>
<? } ?>
</body>
</html>

