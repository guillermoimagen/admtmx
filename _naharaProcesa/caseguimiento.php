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

$numerodetabla=102;
$archivoactual="caseguimiento.php";
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
    if($idusuarioseguimientol1=="on" || $idaccesoseguimientol1=="on" || $tablaseguimientol1=="on" || $registroseguimientol1=="on" || $horaseguimientol1=="on" || $operacionseguimientol1=="on") $error=9; 
    if(isset($idusuarioseguimientob2) || isset($idaccesoseguimientob2) || isset($tablaseguimientob2) || isset($registroseguimientob2) || isset($horaseguimientob2) || isset($operacionseguimientob2)) $error=9; 
  }
  if($nivelusuario==2) 
  { 
    if($idusuarioseguimientol1=="on" || $idaccesoseguimientol1=="on" || $tablaseguimientol1=="on" || $registroseguimientol1=="on" || $horaseguimientol1=="on" || $operacionseguimientol1=="on") $error=9; 
    if(isset($idusuarioseguimientob2) || isset($idaccesoseguimientob2) || isset($tablaseguimientob2) || isset($registroseguimientob2) || isset($horaseguimientob2) || isset($operacionseguimientob2)) $error=9; 
  }
  if($nivelusuario==3) 
  { 
    if($idusuarioseguimientol1=="on" || $idaccesoseguimientol1=="on" || $tablaseguimientol1=="on" || $registroseguimientol1=="on" || $horaseguimientol1=="on" || $operacionseguimientol1=="on") $error=9; 
    if(isset($idusuarioseguimientob2) || isset($idaccesoseguimientob2) || isset($tablaseguimientob2) || isset($registroseguimientob2) || isset($horaseguimientob2) || isset($operacionseguimientob2)) $error=9; 
  }
  if($nivelusuario==4) 
  { 
    if($idusuarioseguimientol1=="on" || $idaccesoseguimientol1=="on" || $tablaseguimientol1=="on" || $registroseguimientol1=="on" || $horaseguimientol1=="on" || $operacionseguimientol1=="on") $error=9; 
    if(isset($idusuarioseguimientob2) || isset($idaccesoseguimientob2) || isset($tablaseguimientob2) || isset($registroseguimientob2) || isset($horaseguimientob2) || isset($operacionseguimientob2)) $error=9; 
  }
}
if($operacion=="modify") 
{ 
  if($nivelusuario==0) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=8; 
  if($nivelusuario==1) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=8; 
  if($nivelusuario==2) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=8; 
  if($nivelusuario==3) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=8; 
  if($nivelusuario==4) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=8; 
}
if($operacion=="add") 
{ 
  if($nivelusuario==0) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=7; 
  if($nivelusuario==1) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=7; 
  if($nivelusuario==2) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=7; 
  if($nivelusuario==3) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=7; 
  if($nivelusuario==4) if(isset($_POST["idusuarioseguimiento"]) || isset($_POST["idaccesoseguimiento"]) || isset($_POST["tablaseguimiento"]) || isset($_POST["registroseguimiento"]) || isset($_POST["horaseguimiento"]) || isset($_POST["operacionseguimiento"])) $error=7; 
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
	<? if($nivelusuario=="10") {?> 
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

<title><? echo("Operaciones"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>
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
      $sqltemporal.=construyesqltemporal("idusuarioseguimiento","",0);
$sqltemporal.=construyesqltemporal("idaccesoseguimiento","",0);
$sqltemporal.=construyesqltemporal("tablaseguimiento","",0);
$sqltemporal.=construyesqltemporal("registroseguimiento","",0);
$sqltemporal.=construyesqltemporal("horaseguimiento","'",0);
$sqltemporal.=construyesqltemporal("operacionseguimiento","'",0);
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
		  $sql = "INSERT INTO caseguimiento SET " .$sqltemporal;
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
		  $sql = "UPDATE caseguimiento SET " .$sqltemporal. " WHERE ID=".$id;
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
		$sql = "DELETE FROM caseguimiento WHERE id=".$id;
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
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,horaseguimiento FROM caseguimiento where id=". $id);
$rowx = mysqli_fetch_array($resultx);
$linkx=" >> ".$rowx["horaseguimiento"]." ".$rowx[""];
$idx=$rowx[""];
}
echo("<a href=caseguimiento.php?sortfield=horaseguimiento&step=1><span class=titulo>Operaciones</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? echo("Operaciones"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?><? } ?></td>
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
$activol1="on"; $comparadorsearch="AND"; $sortfield="caseguimiento.activo DESC,horaseguimiento ASC"; $ordenamiento="";
$activob1="="; $activob2="1";
$idusuarioseguimientol1="on"; 
$idaccesoseguimientol1="on"; 
$tablaseguimientol1="on"; 
$registroseguimientol1="on"; 
$horaseguimientol1="on"; 
$operacionseguimientol1="on"; 
} 

$camposbuscadoslistadosearch="caseguimiento.id";
cbusqueda1($activol1,"caseguimiento","activo");
cbusqueda1($idusuarioseguimientol1,"causuarios","nombreusuario","0","","");
cbusqueda1($idaccesoseguimientol1,"caaccesos","fechaacceso","0","horaacceso","ipaddressacceso");
cbusqueda1($tablaseguimientol1,"catablas","nombretabla","0","","");
cbusqueda1($registroseguimientol1,"caseguimiento","registroseguimiento");
cbusqueda1($horaseguimientol1,"caseguimiento","horaseguimiento");
cbusqueda1($operacionseguimientol1,"caseguimiento","operacionseguimiento");
cbusqueda2($idusuarioseguimientol1,"causuarios","caseguimiento","idusuarioseguimiento","",0,"id");
cbusqueda2($idaccesoseguimientol1,"caaccesos","caseguimiento","idaccesoseguimiento","",0,"id");
cbusqueda2($tablaseguimientol1,"catablas","caseguimiento","tablaseguimiento","",0,"idtabla");
cbusqueda3($idusuarioseguimientob1,$idusuarioseguimientob2,"caseguimiento","idusuarioseguimiento","","0","","");
cbusqueda3($idaccesoseguimientob1,$idaccesoseguimientob2,"caseguimiento","idaccesoseguimiento","","0","","");
cbusqueda3($tablaseguimientob1,$tablaseguimientob2,"caseguimiento","tablaseguimiento","","0","","");
cbusqueda3($registroseguimientob1,$registroseguimientob2,"caseguimiento","registroseguimiento","","0","","");
cbusqueda3($horaseguimientob1,$horaseguimientob2,"caseguimiento","horaseguimiento","'","0","","");
cbusqueda3($operacionseguimientob1,$operacionseguimientob2,"caseguimiento","operacionseguimiento","'","0","","");
cbusqueda3($activob1,$activob2,"caseguimiento","activo","'","0","","");

	
	$rutinabusqueda=$camposbuscadoslistadosearch." from caseguimiento ";
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
          <td valign=middle class="titulointerior"><? echo("Operaciones"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?> <span class=textogeneral>(<?=$num_rows?> registros<?=$mensajelimite?>) <?=$sqltemporal?> </span></td>
         
        
        </tr>
      </table>
    </td> </tr>

  <tr> 
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";
cbusqueda5($idusuarioseguimientol1,"Usuario",": STR");
cbusqueda5($idaccesoseguimientol1,"Acceso",": STR");
cbusqueda5($tablaseguimientol1,"Tabla afectada",": STR");
cbusqueda5($registroseguimientol1,"Registro afectado"," : NUM");
cbusqueda5($horaseguimientol1,"Hora de la operación",": STR");
cbusqueda5($operacionseguimientol1,"Operación realizada",": STR");
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
$botonestigra="<a href=caseguimiento.php?step=modify&id=".$row["id"]." class=textoboton>&nbsp;Ver&nbsp;</a>".$menudetalletigra;

$linktigra="<a href=caseguimiento.php?step=modify&id=".$row["id"]." class=textogeneral>";
 $listadodecampossearchtigra=$row["id"];
cbusqueda4($idusuarioseguimientol1,"causuarios","nombreusuario","0","","");
cbusqueda4($idaccesoseguimientol1,"caaccesos","fechaacceso","0","horaacceso","ipaddressacceso");
cbusqueda4($tablaseguimientol1,"catablas","nombretabla","0","","");
cbusqueda4($registroseguimientol1,"caseguimiento","registroseguimiento","0","","");
cbusqueda4($horaseguimientol1,"caseguimiento","horaseguimiento","0","","");
 if($operacionseguimientol1=="on")  {  if($row["operacionseguimiento"]=="0") $tempooperacionseguimiento="Consulta";if($row["operacionseguimiento"]=="1") $tempooperacionseguimiento="Modificación";if($row["operacionseguimiento"]=="2") $tempooperacionseguimiento="Alta";if($row["operacionseguimiento"]=="3") $tempooperacionseguimiento="Borrado";if($row["operacionseguimiento"]=="4") $tempooperacionseguimiento="Otra operación";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempooperacionseguimiento.$tempotigra."\"";
 $tempotigra="";  }  if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }
if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\"";
 if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";
$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";
}
$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);
$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);
$pietablasearchtigra="\"\"";
cbusqueda6($idusuarioseguimientol1,$sumatoriaidusuarioseguimiento,'');
cbusqueda6($idaccesoseguimientol1,$sumatoriaidaccesoseguimiento,'ipaddressacceso');
cbusqueda6($tablaseguimientol1,$sumatoriatablaseguimiento,'');
cbusqueda6($registroseguimientol1,$sumatoriaregistroseguimiento,'');
cbusqueda6($horaseguimientol1,$sumatoriahoraseguimiento,'');
cbusqueda6($operacionseguimientol1,$sumatoriaoperacionseguimiento,'');
$pietablasearchtigra.=",\"\"";

?>
<?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?></script>
<? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" method="post" action="excel/excelcaseguimiento.php?step=busqueda2" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> >
<input name=idusuarioseguimientol1 type="hidden" value="<?=$idusuarioseguimientol1?>" ><input name=idusuarioseguimientob1 type="hidden" value="<?=$idusuarioseguimientob1?>" ><input name=idusuarioseguimientob2 type="hidden" value="<?=$idusuarioseguimientob2?>" >
<input name=idaccesoseguimientol1 type="hidden" value="<?=$idaccesoseguimientol1?>" ><input name=idaccesoseguimientob1 type="hidden" value="<?=$idaccesoseguimientob1?>" ><input name=idaccesoseguimientob2 type="hidden" value="<?=$idaccesoseguimientob2?>" >
<input name=tablaseguimientol1 type="hidden" value="<?=$tablaseguimientol1?>" ><input name=tablaseguimientob1 type="hidden" value="<?=$tablaseguimientob1?>" ><input name=tablaseguimientob2 type="hidden" value="<?=$tablaseguimientob2?>" >
<input name=registroseguimientol1 type="hidden" value="<?=$registroseguimientol1?>" ><input name=registroseguimientob1 type="hidden" value="<?=$registroseguimientob1?>" ><input name=registroseguimientob2 type="hidden" value="<?=$registroseguimientob2?>" >
<input name=horaseguimientol1 type="hidden" value="<?=$horaseguimientol1?>" ><input name=horaseguimientob1 type="hidden" value="<?=$horaseguimientob1?>" ><input name=horaseguimientob2 type="hidden" value="<?=$horaseguimientob2?>" >
<input name=operacionseguimientol1 type="hidden" value="<?=$operacionseguimientol1?>" ><input name=operacionseguimientob1 type="hidden" value="<?=$operacionseguimientob1?>" ><input name=operacionseguimientob2 type="hidden" value="<?=$operacionseguimientob2?>" >
<input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcaseguimiento.php?step=busqueda2');"><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
</table>
 </td><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=102 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
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
<tr><td  class="titulomenulateral"><b>Operaciones</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=caseguimiento.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar="";
 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_102_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_102_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_102_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_102_0" style="<?=$tempo?>">
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
var HINTS_ITEMS = {'activo':wrap("Seleccion SI para que el registro esté activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  
	<?
	
if($error_unique==0)
{
$idusuarioseguimiento=0;
$idaccesoseguimiento=0;
$tablaseguimiento=0;
$registroseguimiento=0;
$horaseguimiento='';
$operacionseguimiento='0';

$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["idusuarioseguimiento"])) $idusuarioseguimiento=$_POST["idusuarioseguimiento"];
if(isset($_POST["idaccesoseguimiento"])) $idaccesoseguimiento=$_POST["idaccesoseguimiento"];
if(isset($_POST["tablaseguimiento"])) $tablaseguimiento=$_POST["tablaseguimiento"];
if(isset($_POST["registroseguimiento"])) $registroseguimiento=$_POST["registroseguimiento"];
if(isset($_POST["horaseguimiento"])) $horaseguimiento=$_POST["horaseguimiento"];
if(isset($_POST["operacionseguimiento"])) $operacionseguimiento=$_POST["operacionseguimiento"];

}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM caseguimiento where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM caseguimiento where id=". $id);
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
$idusuarioseguimiento=$row["idusuarioseguimiento"];
$idaccesoseguimiento=$row["idaccesoseguimiento"];
$tablaseguimiento=$row["tablaseguimiento"];
$registroseguimiento=$row["registroseguimiento"];
$horaseguimiento=$row["horaseguimiento"];
$operacionseguimiento=$row["operacionseguimiento"];

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
	  <form name="form1" onSubmit="return v.exec()" method="post" action="caseguimiento.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?>" enctype="multipart/form-data">
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo("Agregar "); else echo("Modificar "); ?><? echo("Operaciones"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></span></td>
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
	
	
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idusuarioseguimiento">Usuario * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idusuarioseguimiento" class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","nombreusuario","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idusuarioseguimiento==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT nombreusuario from causuarios where id=".$idusuarioseguimiento);if(mysqli_num_rows($resultempo)>0){ $rowtempo = mysqli_fetch_array($resultempo);echo($rowtempo["nombreusuario"]." ".$rowtempo[""]." ".$rowtempo[""]); } else echo("No se encontró o no aplica");?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idaccesoseguimiento">Acceso * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idaccesoseguimiento" class=textogeneralform><option value="0" selected></option><?  leecampos("caaccesos","id","fechaacceso","horaacceso","ipaddressacceso"," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idaccesoseguimiento==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT fechaacceso,horaacceso,ipaddressacceso from caaccesos where id=".$idaccesoseguimiento);if(mysqli_num_rows($resultempo)>0){ $rowtempo = mysqli_fetch_array($resultempo);echo($rowtempo["fechaacceso"]." ".$rowtempo["horaacceso"]." ".$rowtempo["ipaddressacceso"]); } else echo("No se encontró o no aplica");?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_tablaseguimiento">Tabla afectada * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="tablaseguimiento" class=textogeneralform><option value="0" selected></option><?  leecampos("catablas","idtabla","nombretabla","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($tablaseguimiento==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT nombretabla from catablas where idtabla=".$tablaseguimiento);if(mysqli_num_rows($resultempo)>0){ $rowtempo = mysqli_fetch_array($resultempo);echo($rowtempo["nombretabla"]." ".$rowtempo[""]." ".$rowtempo[""]); } else echo("No se encontró o no aplica");?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_registroseguimiento">Registro afectado * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="registroseguimiento" value="<?=$registroseguimiento?>" size="10" maxlength="15" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$registroseguimiento?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_horaseguimiento">Hora de la operación * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="horaseguimiento" value="<? echo(htmlspecialchars($horaseguimiento)); ?>" size="10" maxlength="5" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$horaseguimiento?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle" id="t_operacionseguimiento">Operación realizada * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="operacionseguimiento" class=textogeneralform><OPTION VALUE="0" <? if($operacionseguimiento=="0") echo("selected");?> >Consulta</option>
<OPTION VALUE="1" <? if($operacionseguimiento=="1") echo("selected");?> >Modificación</option>
<OPTION VALUE="2" <? if($operacionseguimiento=="2") echo("selected");?> >Alta</option>
<OPTION VALUE="3" <? if($operacionseguimiento=="3") echo("selected");?> >Borrado</option>
<OPTION VALUE="4" <? if($operacionseguimiento=="4") echo("selected");?> >Otra operación</option>
</select>
<? } ?>
<? if(($nivelusuario==10 || $nivelusuario==0)) { ?>

<? if($operacionseguimiento=="0") echo("Consulta");
if($operacionseguimiento=="1") echo("Modificación");
if($operacionseguimiento=="2") echo("Alta");
if($operacionseguimiento=="3") echo("Borrado");
if($operacionseguimiento=="4") echo("Otra operación");
 ?>
<? } ?>

</td></tr>
<? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idusuarioseguimiento':{'l':'Usuario','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_idusuarioseguimiento'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idaccesoseguimiento':{'l':'Acceso','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_idaccesoseguimiento'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tablaseguimiento':{'l':'Tabla afectada','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_tablaseguimiento'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'registroseguimiento':{'l':'Registro afectado','r': true,'f':'integer','t':'t_registroseguimiento'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'horaseguimiento':{'l':'Hora de la operación','r': true,'t':'t_horaseguimiento'}";?><? } ?>
<? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'operacionseguimiento':{'l':'Operación realizada','r': true,'t':'t_operacionseguimiento'}";?><? } ?>
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
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=102 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='1'");
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
<tr><td  class="titulomenulateral"><b>Operaciones</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=caseguimiento.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<?  if($nivelusuario==0) { if($step=="modify") { ?>
<tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"lopcionesedi_102_1234")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('lopcionesedi_102_1234')" class="textogeneralnegrita">
<img id="collapseimg_lopcionesedi_102_1234" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Operaciones</b></a></td></tr><tbody id="collapseobj_lopcionesedi_102_1234" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?
hace_boton_busquedav3("cahistorico","Ver histórico de esta operación",$id,"ioperacionhistoricob1==&ioperacionhistoricob2=$id");
hace_boton_v3("cahistorico.php?step=busqueda2&tablabusqueda=$tablaseguimiento&registrobusqueda=$registroseguimiento&modo=busqueda&moditobusqueda=especial&titulobusqueda=Histórico de registro&","Ver todo el histórico del mismo registro");
hace_boton_edicionv3("caaccesos",$idaccesoseguimiento,"Ver Acceso");
hace_boton_edicionv3("causuarios",$idusuarioseguimiento,"Ver Usuario");

hace_boton_busquedav3("caseguimiento","Ver todas las operaciones del mismo acceso",$fechaacceso,"idaccesoseguimientob1==&idaccesoseguimientob2=$idaccesoseguimiento");

hace_boton_busquedav3("cahistorico","Ver todo el histórico del mismo acceso",$idaccesoseguimiento,"iaccesohistoricob1==&iaccesohistoricob2=$idaccesoseguimiento");
?></td></tr></tbody>
<? }} ?>
<? if($nivelusuario==0) { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"avanzadas_102_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('avanzadas_102_0')" class="textogeneralnegrita">
<img id="collapseimg_avanzadas_102_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Avanzadas</b></a></td></tr>
<tbody id="collapseobj_avanzadas_102_0" style="<?=$tempo?>">
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
      <td width=100%  valign=top><form name="form2" method="post" action="caseguimiento.php?step=busqueda2&mensajemm=<?=$mensajemm?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior">B&uacute;squeda de <? echo("Operaciones"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> Comparador
                <select name="comparadorsearch" class="textogeneral">
                  <option value="AND" selected>Y</option>
                  <option value="OR">O</option>
                </select>
Ordenar<select class="textogeneralform" name=sortfield><option value="idusuarioseguimiento">Usuario</option><option value="idaccesoseguimiento">Acceso</option><option value="tablaseguimiento">Tabla afectada</option><option value="registroseguimiento">Registro afectado</option><option value="horaseguimiento" selected>Hora de la operación</option><option value="operacionseguimiento">Operación realizada</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('caseguimiento.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');"><? } ?></td>
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
	
	
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idusuarioseguimientol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="idusuarioseguimientob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idusuarioseguimientob2" onChange="if(idusuarioseguimientob1.selectedIndex==0) idusuarioseguimientob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","nombreusuario","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idusuarioseguimiento==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Acceso</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idaccesoseguimientol1" checked><? } ?><? if($nivelusuario==10) { ?><select name="idaccesoseguimientob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idaccesoseguimientob2" onChange="if(idaccesoseguimientob1.selectedIndex==0) idaccesoseguimientob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("caaccesos","id","fechaacceso","horaacceso","ipaddressacceso"," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idaccesoseguimiento==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Tabla afectada</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="tablaseguimientol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="tablaseguimientob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="tablaseguimientob2" onChange="if(tablaseguimientob1.selectedIndex==0) tablaseguimientob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("catablas","idtabla","nombretabla","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($tablaseguimiento==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Registro afectado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="registroseguimientol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="registroseguimientob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="registroseguimientob2" value="" size="10" onKeyUp="revisainput('registroseguimientob1','registroseguimientob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Hora de la operación</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="horaseguimientol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="horaseguimientob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="horaseguimientob2" value="" size="10" onKeyUp="revisainput('horaseguimientob1','horaseguimientob2');" maxlength="5" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor6?>" ><td valign="middle">Operación realizada</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="operacionseguimientol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="operacionseguimientob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="operacionseguimientob2" onChange="if(operacionseguimientob1.selectedIndex==0) operacionseguimientob1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($operacionseguimiento=="0") { ?>selected<? } ?> >Consulta</option><OPTION VALUE="1" <? if($operacionseguimiento=="1") { ?>selected<? } ?> >Modificación</option><OPTION VALUE="2" <? if($operacionseguimiento=="2") { ?>selected<? } ?> >Alta</option><OPTION VALUE="3" <? if($operacionseguimiento=="3") { ?>selected<? } ?> >Borrado</option><OPTION VALUE="4" <? if($operacionseguimiento=="4") { ?>selected<? } ?> >Otra operación</option></select> <? } ?></td></tr><? } ?> 
	
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('caseguimiento.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcaseguimiento.php?step=busqueda2');">
<?} ?><? } ?></div>
      </td>
    </tr>
  </table></form></td><? if($ocultabotones<>1) { ?><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=102 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
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
<tr><td  class="titulomenulateral"><b>Operaciones</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=caseguimiento.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar="";
 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_102_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_102_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_102_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_102_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?>

</table></td>
<? } ?>
     <td class="spacerlateral"></td>
    </tr>
  </table>
  

<?} ?>
<?php  } ?>
<? if($step=="add" || $step=="modify")  { ?>

<? } ?>
</body>
</html>

