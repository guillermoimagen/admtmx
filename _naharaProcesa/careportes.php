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

$numerodetabla=105;
$archivoactual="careportes.php";

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
<?if($step=="busqueda2" || $step=="busqueda3") { if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }  if($nivelusuario==1)   {     if($idusuarioreportel1=="on" || $idtablareportel1=="on" || $idregistroreportel1=="on" || $idaccesoreportel1=="on" || $fechareportel1=="on" || $horareportel1=="on" || $operacionreportel1=="on" || $operacionreportel1=="on") $error=9;     if(isset($idusuarioreporteb2) || isset($idtablareporteb2) || isset($idregistroreporteb2) || isset($idaccesoreporteb2) || isset($fechareporteb2) || isset($horareporteb2) || isset($operacionreporteb2) || isset($operacionreporteb2)) $error=9;   }  if($nivelusuario==2)   {     if($idusuarioreportel1=="on" || $idtablareportel1=="on" || $idregistroreportel1=="on" || $idaccesoreportel1=="on" || $fechareportel1=="on" || $horareportel1=="on" || $operacionreportel1=="on" || $operacionreportel1=="on") $error=9;     if(isset($idusuarioreporteb2) || isset($idtablareporteb2) || isset($idregistroreporteb2) || isset($idaccesoreporteb2) || isset($fechareporteb2) || isset($horareporteb2) || isset($operacionreporteb2) || isset($operacionreporteb2)) $error=9;   }  if($nivelusuario==3)   {     if($idusuarioreportel1=="on" || $idtablareportel1=="on" || $idregistroreportel1=="on" || $idaccesoreportel1=="on" || $fechareportel1=="on" || $horareportel1=="on" || $operacionreportel1=="on" || $operacionreportel1=="on") $error=9;     if(isset($idusuarioreporteb2) || isset($idtablareporteb2) || isset($idregistroreporteb2) || isset($idaccesoreporteb2) || isset($fechareporteb2) || isset($horareporteb2) || isset($operacionreporteb2) || isset($operacionreporteb2)) $error=9;   }  if($nivelusuario==4)   {     if($idusuarioreportel1=="on" || $idtablareportel1=="on" || $idregistroreportel1=="on" || $idaccesoreportel1=="on" || $fechareportel1=="on" || $horareportel1=="on" || $operacionreportel1=="on" || $operacionreportel1=="on") $error=9;     if(isset($idusuarioreporteb2) || isset($idtablareporteb2) || isset($idregistroreporteb2) || isset($idaccesoreporteb2) || isset($fechareporteb2) || isset($horareporteb2) || isset($operacionreporteb2) || isset($operacionreporteb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=8;   if($nivelusuario==1) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=8;   if($nivelusuario==2) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=8;   if($nivelusuario==3) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=8;   if($nivelusuario==4) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=7;   if($nivelusuario==1) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=7;   if($nivelusuario==2) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=7;   if($nivelusuario==3) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=7;   if($nivelusuario==4) if(isset($_POST["idusuarioreporte"]) || isset($_POST["idtablareporte"]) || isset($_POST["idregistroreporte"]) || isset($_POST["idaccesoreporte"]) || isset($_POST["fechareporte"]) || isset($_POST["horareporte"]) || isset($_POST["operacionreporte"]) || isset($_POST["operacionreporte"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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

<title><? echo("Reporte de accesos irregulares"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<script>
function funcionload()
{
<? if($step=="busqueda") { ?> <? } else if($step=="modify" || $step=="add") { ?> <? } ?> 
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
      $sqltemporal.=construyesqltemporal("idusuarioreporte","",0);$sqltemporal.=construyesqltemporal("idtablareporte","",0);$sqltemporal.=construyesqltemporal("idregistroreporte","",0);$sqltemporal.=construyesqltemporal("idaccesoreporte","",0);$sqltemporal.=construyesqltemporal("fechareporte","'",0);$sqltemporal.=construyesqltemporal("horareporte","'",0);$sqltemporal.=construyesqltemporal("operacionreporte","'",0);$sqltemporal.=construyesqltemporal("operacionreporte","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
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
		  $sql = "INSERT INTO careportes SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.="Se guardó correctamente el registro";
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=105,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			
		  } 
		  else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="Ya existe un registro con esos datos. (".mysqli_error($GLOBALS["enlaceDB"] ).")<br>No se ha guardado el registro.";
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
		  $sql = "UPDATE careportes SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.="Se actualizó correctamente el registro";
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=105,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			  
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
			  $mensaje.="Ya existe un registro con esos datos. (".mysqli_error($GLOBALS["enlaceDB"] ).")<br>No se ha guardado el registro";
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
      if($confirmadelete<>"confirmado") {$mensajedelete="";if($mensajedelete<>"") { $step="modify"; $operacion=""; $mensaje.="No se puede eliminar el registro, debido a lo siguiente:".$mensajedelete;}}
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
		$sql = "DELETE FROM careportes WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.="Se eliminó correctamente el registro <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">Regresar</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=105,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
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
    <td height="30" valign="middle"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,fechareporte FROM careportes where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["fechareporte"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=careportes.php?sortfield=fechareporte&step=busqueda><span class=titulo>Reportes</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? echo("Reporte de accesos irregulares"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?><? } ?></td>
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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on"; $comparadorsearch="AND"; $sortfield="careportes.activo DESC,fechareporte DESC"; $ordenamiento="";$activob1="="; $activob2="1";$idusuarioreportel1="on"; $idtablareportel1="on"; $idregistroreportel1="on"; $idaccesoreportel1="on"; $fechareportel1="on"; $horareportel1="on"; $operacionreportel1="on"; $operacionreportel1="on"; } $camposbuscadoslistadosearch="careportes.id";cbusqueda1($activol1,"careportes","activo");cbusqueda1($idusuarioreportel1,"causuarios","nombreusuario","0","","");cbusqueda1($idtablareportel1,"catablas","nombretabla","0","","");cbusqueda1($idregistroreportel1,"careportes","idregistroreporte");cbusqueda1($idaccesoreportel1,"caaccesos","ipaddressacceso","0","","");cbusqueda1($fechareportel1,"careportes","fechareporte");cbusqueda1($horareportel1,"careportes","horareporte");cbusqueda1($operacionreportel1,"careportes","operacionreporte");cbusqueda1($operacionreportel1,"careportes","operacionreporte");cbusqueda2($idusuarioreportel1,"causuarios","careportes","idusuarioreporte","",0,"id");cbusqueda2($idtablareportel1,"catablas","careportes","idtablareporte","",0,"id");cbusqueda2($idaccesoreportel1,"caaccesos","careportes","idaccesoreporte","",0,"id");cbusqueda3($idusuarioreporteb1,$idusuarioreporteb2,"careportes","idusuarioreporte","","0","","");cbusqueda3($idtablareporteb1,$idtablareporteb2,"careportes","idtablareporte","","0","","");cbusqueda3($idregistroreporteb1,$idregistroreporteb2,"careportes","idregistroreporte","","0","","");cbusqueda3($idaccesoreporteb1,$idaccesoreporteb2,"careportes","idaccesoreporte","","0","","");cbusqueda3($fechareporteb1,$fechareporteb2,"careportes","fechareporte","'","0","","");cbusqueda3($horareporteb1,$horareporteb2,"careportes","horareporte","'","0","","");cbusqueda3($operacionreporteb1,$operacionreporteb2,"careportes","operacionreporte","'","0","","");cbusqueda3($operacionreporteb1,$operacionreporteb2,"careportes","operacionreporte","'","0","","");cbusqueda3($activob1,$activob2,"careportes","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from careportes ";
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
          <td valign=middle class="titulointerior"><? echo("Reporte de accesos irregulares"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?> <span class=textogeneral>(<?=$num_rows?> registros<?=$mensajelimite?>) <?=$sqltemporal?> </span></td>
         
        
        </tr>
      </table>
    </td> </tr>

  <tr> 
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($idusuarioreportel1,"Usuario",": STR");cbusqueda5($idtablareportel1,"Tabla",": STR");cbusqueda5($idregistroreportel1,"Registro"," : NUM");cbusqueda5($idaccesoreportel1,"Acceso",": STR");cbusqueda5($fechareportel1,"Fecha",": STR");cbusqueda5($horareportel1,"Hora",": STR");cbusqueda5($operacionreportel1,"Operación del reporte",": STR");cbusqueda5($operacionreportel1,"Operación del reporte",": STR"); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra="<br>";$botonestigra="<a href=careportes.php?step=modify&id=".$row["id"]." class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra;$linktigra="<a href=careportes.php?step=modify&id=".$row["id"]." class=textogeneral>"; $listadodecampossearchtigra=$row["id"];cbusqueda4($idusuarioreportel1,"causuarios","nombreusuario","0","","");cbusqueda4($idtablareportel1,"catablas","nombretabla","0","","");cbusqueda4($idregistroreportel1,"careportes","idregistroreporte","0","","");cbusqueda4($idaccesoreportel1,"caaccesos","ipaddressacceso","0","","");cbusqueda4($fechareportel1,"careportes","fechareporte","0","","");cbusqueda4($horareportel1,"careportes","horareporte","0","",""); if($operacionreportel1=="on")  {  if($row["operacionreporte"]=="1") $tempooperacionreporte="Alta no permitida";if($row["operacionreporte"]=="2") $tempooperacionreporte="Modificar no permitida";if($row["operacionreporte"]=="3") $tempooperacionreporte="Borrar no permitido";if($row["operacionreporte"]=="4") $tempooperacionreporte="Búsqueda no permitida";if($row["operacionreporte"]=="5") $tempooperacionreporte="Consulta a registro no permitido";if($row["operacionreporte"]=="6") $tempooperacionreporte="Violación a IDCONTROL";if($row["operacionreporte"]=="7") $tempooperacionreporte="Alta violatoria (nivel campo)";if($row["operacionreporte"]=="8") $tempooperacionreporte="Modificar violatoria (nivel campo)";if($row["operacionreporte"]=="9") $tempooperacionreporte="Búsqueda violatoria (nivel campo)";if($row["operacionreporte"]=="10") $tempooperacionreporte="Operación directa violatoria (nivel campo)";if($row["operacionreporte"]=="11") $tempooperacionreporte="Otro";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempooperacionreporte.$tempotigra."\""; $tempotigra="";  }  if($operacionreportel1=="on")  {  if($row["operacionreporte"]=="1") $tempooperacionreporte="Alta no permitida";if($row["operacionreporte"]=="2") $tempooperacionreporte="Modificar no permitida";if($row["operacionreporte"]=="3") $tempooperacionreporte="Borrar no permitido";if($row["operacionreporte"]=="4") $tempooperacionreporte="Búsqueda no permitida";if($row["operacionreporte"]=="5") $tempooperacionreporte="Consulta a registro no permitido";if($row["operacionreporte"]=="6") $tempooperacionreporte="Violación a IDCONTROL";if($row["operacionreporte"]=="7") $tempooperacionreporte="Alta violatoria (nivel campo)";if($row["operacionreporte"]=="8") $tempooperacionreporte="Modificar violatoria (nivel campo)";if($row["operacionreporte"]=="9") $tempooperacionreporte="Búsqueda violatoria (nivel campo)";if($row["operacionreporte"]=="10") $tempooperacionreporte="Operación directa violatoria (nivel campo)";if($row["operacionreporte"]=="11") $tempooperacionreporte="Otro";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempooperacionreporte.$tempotigra."\""; $tempotigra="";  }  if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($idusuarioreportel1,$sumatoriaidusuarioreporte);cbusqueda6($idtablareportel1,$sumatoriaidtablareporte);cbusqueda6($idregistroreportel1,$sumatoriaidregistroreporte);cbusqueda6($idaccesoreportel1,$sumatoriaidaccesoreporte);cbusqueda6($fechareportel1,$sumatoriafechareporte);cbusqueda6($horareportel1,$sumatoriahorareporte);cbusqueda6($operacionreportel1,$sumatoriaoperacionreporte);cbusqueda6($operacionreportel1,$sumatoriaoperacionreporte);$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" method="post" action="excel/excelcareportes.php?step=busqueda2" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=idusuarioreportel1 type="hidden" value="<?=$idusuarioreportel1?>" ><input name=idusuarioreporteb1 type="hidden" value="<?=$idusuarioreporteb1?>" ><input name=idusuarioreporteb2 type="hidden" value="<?=$idusuarioreporteb2?>" ><input name=idtablareportel1 type="hidden" value="<?=$idtablareportel1?>" ><input name=idtablareporteb1 type="hidden" value="<?=$idtablareporteb1?>" ><input name=idtablareporteb2 type="hidden" value="<?=$idtablareporteb2?>" ><input name=idregistroreportel1 type="hidden" value="<?=$idregistroreportel1?>" ><input name=idregistroreporteb1 type="hidden" value="<?=$idregistroreporteb1?>" ><input name=idregistroreporteb2 type="hidden" value="<?=$idregistroreporteb2?>" ><input name=idaccesoreportel1 type="hidden" value="<?=$idaccesoreportel1?>" ><input name=idaccesoreporteb1 type="hidden" value="<?=$idaccesoreporteb1?>" ><input name=idaccesoreporteb2 type="hidden" value="<?=$idaccesoreporteb2?>" ><input name=fechareportel1 type="hidden" value="<?=$fechareportel1?>" ><input name=fechareporteb1 type="hidden" value="<?=$fechareporteb1?>" ><input name=fechareporteb2 type="hidden" value="<?=$fechareporteb2?>" ><input name=horareportel1 type="hidden" value="<?=$horareportel1?>" ><input name=horareporteb1 type="hidden" value="<?=$horareporteb1?>" ><input name=horareporteb2 type="hidden" value="<?=$horareporteb2?>" ><input name=operacionreportel1 type="hidden" value="<?=$operacionreportel1?>" ><input name=operacionreporteb1 type="hidden" value="<?=$operacionreporteb1?>" ><input name=operacionreporteb2 type="hidden" value="<?=$operacionreporteb2?>" ><input name=operacionreportel1 type="hidden" value="<?=$operacionreportel1?>" ><input name=operacionreporteb1 type="hidden" value="<?=$operacionreporteb1?>" ><input name=operacionreporteb2 type="hidden" value="<?=$operacionreporteb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcareportes.php?step=busqueda2');"><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
</table>
 </td><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=105 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");if(mysqli_num_rows($resultx)>0){  $tempoayuda="";  while($rowx = mysqli_fetch_array($resultx))  {    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";  }  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");  ?><script language="javascript" src="../include/scroll/scroll.js"></script><script language="javascript">var Tscr_LOOK0 = {'size' : [190, 100],'s_i':'textogeneralaviso','s_b':'textogeneralaviso','pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],'re' : [150,80, 16, 16,,'../include/scroll/mres.gif'],'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']},Tscr_BEHAVE0 = {'auto'  : true,'vertical' : true,'speed' : 1,'interval' : 50,'hide_buttons' : true,'zindex':5};</script><TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr><? } ?><tr><td  class="titulomenulateral"><b>Reporte de accesos irregulares</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; if($nivelusuario==0) $botones.="<td><a href=careportes.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>"; if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones); ?></tr></table></td></tr><? $menugeneraloprelacionbuscar=""; if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_105_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?><a href="#top" onClick="return abreocierracabeza('loprelacionbus_105_0')" class="textogeneralnegrita"><img id="collapseimg_loprelacionbus_105_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> <b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_105_0" style="<?=$tempo?>"><tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?></table></td> <td class="spacerlateral"></td></tr>
</table>

<? } ?>


<?php 
  if($step=="add" || $step=="modify") 
  {
  ?>
  <script type="text/javascript" src="../include/validator.js"></script>
   <script language="JavaScript" src="../include/hints.js"></script>
 
<script language="JavaScript">
var HINTS_ITEMS = {'fechareporte':wrap("aaaa-mm-dd, 2008-11-18"),'activo':wrap("Seleccion SI para que el registro esté activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  <script>var directorio='../include';</script><script language="JavaScript" src="../include/calendar/calendar.js"></script><link rel="stylesheet" href="../include/calendar/calendar.css">
	<?
	
if($error_unique==0)
{
$idusuarioreporte=0;$idtablareporte=0;$idregistroreporte=0;$idaccesoreporte=0;$fecha=date("Y-m-d"); $fechareporte=substr($fecha, 0, 4)."-".substr($fecha, 5, 2)."-".substr($fecha, 8, 2);$horareporte='';$operacionreporte='0';$operacionreporte='0';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["idusuarioreporte"])) $idusuarioreporte=$_POST["idusuarioreporte"];if(isset($_POST["idtablareporte"])) $idtablareporte=$_POST["idtablareporte"];if(isset($_POST["idregistroreporte"])) $idregistroreporte=$_POST["idregistroreporte"];if(isset($_POST["idaccesoreporte"])) $idaccesoreporte=$_POST["idaccesoreporte"];if(isset($_POST["fechareporte"])) $fechareporte=$_POST["fechareporte"];if(isset($_POST["horareporte"])) $horareporte=$_POST["horareporte"];if(isset($_POST["operacionreporte"])) $operacionreporte=$_POST["operacionreporte"];if(isset($_POST["operacionreporte"])) $operacionreporte=$_POST["operacionreporte"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM careportes where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM careportes where id=". $id);
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
$idusuarioreporte=$row["idusuarioreporte"];$idtablareporte=$row["idtablareporte"];$idregistroreporte=$row["idregistroreporte"];$idaccesoreporte=$row["idaccesoreporte"];$fechareporte=$row["fechareporte"];if($fechareporte=="0000-00-00") $fechareporte="";$horareporte=$row["horareporte"];$operacionreporte=$row["operacionreporte"];$operacionreporte=$row["operacionreporte"];
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
	  <form name="form1" onSubmit="return v.exec()" method="post" action="careportes.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?>" enctype="multipart/form-data">
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo("Agregar "); else echo("Modificar "); ?><? echo("Reporte de accesos irregulares"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></span></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>  
				       
				          <? } ?>
<? if($nivelusuario=="10") {?>
<? $yabotonguardar="ya"; ?>
<input class=textogeneral type="submit" name="Submit" value="Guardar">
<?} ?>
<? if($step=="add" && $yabotonguardar<>"ya") { ?>
<input class=textogeneral type="submit" name="Submit" value="Guardar">
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
      <table class="textogeneraltablaform" width="100%" cellpadding="0" cellspacing="0">
      <tr bgcolor="#<?=$vsitioscolor6?>" >
        <td width="9%"></td>
	    <td width="91%"></td>
      </tr>
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idusuarioreporte">Usuario * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idusuarioreporte" class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","nombreusuario","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idusuarioreporte==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT nombreusuario from causuarios where id=".$idusuarioreporte);if(mysqli_num_rows($resultempo)>0){ $rowtempo = mysqli_fetch_array($resultempo);echo($rowtempo["nombreusuario"]." ".$rowtempo[""]." ".$rowtempo[""]); } else echo("No se encontró o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idtablareporte">Tabla * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idtablareporte" class=textogeneralform><option value="0" selected></option><?  leecampos("catablas","id","nombretabla","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idtablareporte==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT nombretabla from catablas where id=".$idtablareporte);if(mysqli_num_rows($resultempo)>0){ $rowtempo = mysqli_fetch_array($resultempo);echo($rowtempo["nombretabla"]." ".$rowtempo[""]." ".$rowtempo[""]); } else echo("No se encontró o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idregistroreporte">Registro * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="idregistroreporte" value="<?=$idregistroreporte?>" size="10" maxlength="15" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$idregistroreporte?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idaccesoreporte">Acceso * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idaccesoreporte" class=textogeneralform><option value="0" selected></option><?  leecampos("caaccesos","id","ipaddressacceso","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idaccesoreporte==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ipaddressacceso from caaccesos where id=".$idaccesoreporte);if(mysqli_num_rows($resultempo)>0){ $rowtempo = mysqli_fetch_array($resultempo);echo($rowtempo["ipaddressacceso"]." ".$rowtempo[""]." ".$rowtempo[""]); } else echo("No se encontró o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fechareporte">Fecha * <a onMouseOver="myHint.show('fechareporte')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="fechareporte" value="<?=$fechareporte?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT1 = {	'formname' : 'form1','controlname': 'fechareporte','dataformat' : 'Y-m-d','today' : '<?=$fechareporte?>','positionname':'fechareporte','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT1, CAL_TPL1);</script><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$fechareporte?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_horareporte">Hora * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="horareporte" value="<? echo(htmlspecialchars($horareporte)); ?>" size="10" maxlength="5" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$horareporte?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_operacionreporte">Operación del reporte * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="operacionreporte" class=textogeneralform><OPTION VALUE="1" <? if($operacionreporte=="1") echo("selected");?> >Alta no permitida</option><OPTION VALUE="2" <? if($operacionreporte=="2") echo("selected");?> >Modificar no permitida</option><OPTION VALUE="3" <? if($operacionreporte=="3") echo("selected");?> >Borrar no permitido</option><OPTION VALUE="4" <? if($operacionreporte=="4") echo("selected");?> >Búsqueda no permitida</option><OPTION VALUE="5" <? if($operacionreporte=="5") echo("selected");?> >Consulta a registro no permitido</option><OPTION VALUE="6" <? if($operacionreporte=="6") echo("selected");?> >Violación a IDCONTROL</option><OPTION VALUE="7" <? if($operacionreporte=="7") echo("selected");?> >Alta violatoria (nivel campo)</option><OPTION VALUE="8" <? if($operacionreporte=="8") echo("selected");?> >Modificar violatoria (nivel campo)</option><OPTION VALUE="9" <? if($operacionreporte=="9") echo("selected");?> >Búsqueda violatoria (nivel campo)</option><OPTION VALUE="10" <? if($operacionreporte=="10") echo("selected");?> >Operación directa violatoria (nivel campo)</option><OPTION VALUE="11" <? if($operacionreporte=="11") echo("selected");?> >Otro</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($operacionreporte=="1") echo("Alta no permitida");if($operacionreporte=="2") echo("Modificar no permitida");if($operacionreporte=="3") echo("Borrar no permitido");if($operacionreporte=="4") echo("Búsqueda no permitida");if($operacionreporte=="5") echo("Consulta a registro no permitido");if($operacionreporte=="6") echo("Violación a IDCONTROL");if($operacionreporte=="7") echo("Alta violatoria (nivel campo)");if($operacionreporte=="8") echo("Modificar violatoria (nivel campo)");if($operacionreporte=="9") echo("Búsqueda violatoria (nivel campo)");if($operacionreporte=="10") echo("Operación directa violatoria (nivel campo)");if($operacionreporte=="11") echo("Otro"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_operacionreporte">Operación del reporte * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="operacionreporte" class=textogeneralform><OPTION VALUE="1" <? if($operacionreporte=="1") echo("selected");?> >Alta no permitida</option><OPTION VALUE="2" <? if($operacionreporte=="2") echo("selected");?> >Modificar no permitida</option><OPTION VALUE="3" <? if($operacionreporte=="3") echo("selected");?> >Borrar no permitido</option><OPTION VALUE="4" <? if($operacionreporte=="4") echo("selected");?> >Búsqueda no permitida</option><OPTION VALUE="5" <? if($operacionreporte=="5") echo("selected");?> >Consulta a registro no permitido</option><OPTION VALUE="6" <? if($operacionreporte=="6") echo("selected");?> >Violación a IDCONTROL</option><OPTION VALUE="7" <? if($operacionreporte=="7") echo("selected");?> >Alta violatoria (nivel campo)</option><OPTION VALUE="8" <? if($operacionreporte=="8") echo("selected");?> >Modificar violatoria (nivel campo)</option><OPTION VALUE="9" <? if($operacionreporte=="9") echo("selected");?> >Búsqueda violatoria (nivel campo)</option><OPTION VALUE="10" <? if($operacionreporte=="10") echo("selected");?> >Operación directa violatoria (nivel campo)</option><OPTION VALUE="11" <? if($operacionreporte=="11") echo("selected");?> >Otro</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($operacionreporte=="1") echo("Alta no permitida");if($operacionreporte=="2") echo("Modificar no permitida");if($operacionreporte=="3") echo("Borrar no permitido");if($operacionreporte=="4") echo("Búsqueda no permitida");if($operacionreporte=="5") echo("Consulta a registro no permitido");if($operacionreporte=="6") echo("Violación a IDCONTROL");if($operacionreporte=="7") echo("Alta violatoria (nivel campo)");if($operacionreporte=="8") echo("Modificar violatoria (nivel campo)");if($operacionreporte=="9") echo("Búsqueda violatoria (nivel campo)");if($operacionreporte=="10") echo("Operación directa violatoria (nivel campo)");if($operacionreporte=="11") echo("Otro"); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idusuarioreporte':{'l':'Usuario','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_idusuarioreporte'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idtablareporte':{'l':'Tabla','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_idtablareporte'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idregistroreporte':{'l':'Registro','r': true,'f':'integer','t':'t_idregistroreporte'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idaccesoreporte':{'l':'Acceso','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_idaccesoreporte'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fechareporte':{'l':'Fecha','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_fechareporte'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'horareporte':{'l':'Hora','r': true,'t':'t_horareporte'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'operacionreporte':{'l':'Operación del reporte','r': true,'t':'t_operacionreporte'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'operacionreporte':{'l':'Operación del reporte','r': true,'t':'t_operacionreporte'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} var v = new validator('form1', a_fields, o_config)</script>  
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
                <input class=textogeneral type="submit" name="Submit" value="Guardar"><?} ?>
				<? if($step=="add" && $yabotonguardar<>"ya") { ?><input class=textogeneral type="submit" name="Submit" value="Guardar"><? } ?><? } ?>
              </div>
            </td>
    </tr>
	
	
	
  </table></form></td>
     <? if($ocultabotones<>1) { ?> <? if($step=="modify") { ?><? } ?><td width="10" rowspan="2"><img width="10" height="0"></td><td width="100%" valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=105 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='1'");if(mysqli_num_rows($resultx)>0){  $tempoayuda="";  while($rowx = mysqli_fetch_array($resultx))  {    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";  }  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");  ?><script language="javascript" src="../include/scroll/scroll.js"></script><script language="javascript">var Tscr_LOOK0 = {'size' : [190, 100],'s_i':'textogeneralaviso','s_b':'textogeneralaviso','pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],'re' : [150,80, 16, 16,,'../include/scroll/mres.gif'],'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']},Tscr_BEHAVE0 = {'auto'  : true,'vertical' : true,'speed' : 1,'interval' : 50,'hide_buttons' : true,'zindex':5};</script><TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr><? } ?><tr><td  class="titulomenulateral"><b>Reporte de accesos irregulares</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; if($nivelusuario==0) $botones.="<td><a href=careportes.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>"; if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones); ?></tr></table></td></tr><? $menugeneraladicionalbuscar=""; if($nivelusuario==0) { if($menugeneraladicionaleditar<>"") $menugeneraladicionaleditar.="<br />";$menugeneraladicionaleditar.=generaboton("causuarios.php?step=modify&id=".$idusuarioreporte."","Ver usuario","","textogeneral");} if($nivelusuario==0) { if($menugeneraladicionaleditar<>"") $menugeneraladicionaleditar.="<br />";$menugeneraladicionaleditar.=generaboton("caaccesos.php?step=busqueda2&idusuarioaccesob1==&idusuarioaccesob2=".$idusuarioreporte."&idusuarioaccesol1=on&ipaddressaccesol1=on&fechaaccesol1=on&horaaccesol1=on&fechasalidaaccesol1=on&horasalidaaccesol1=on&hitsaccesol1=on&sortfield=fechaacceso&ordenamiento=DESC&comparadorsearch=AND","Ver accesos del usuario","","textogeneral");} if($menugeneraladicionaleditar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"ladicionaledi_105_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?><a href="#top" onClick="return abreocierracabeza('ladicionaledi_105_0')" class="textogeneralnegrita"><img id="collapseimg_ladicionaledi_105_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> <b>Funciones adicionales de este registro</a>></td></tr><tbody id="collapseobj_ladicionaledi_105_0" style="<?=$tempo?>"><tr><td class="textogeneralmenulateral"><?=$menugeneraladicionaleditar?></td></tr></tbody><? } ?><? if($nivelusuario==0) { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"avanzadas_105_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?><a href="#top" onClick="return abreocierracabeza('avanzadas_105_0')" class="textogeneralnegrita"><img id="collapseimg_avanzadas_105_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> <b>Avanzadas</b></a></td></tr><tbody id="collapseobj_avanzadas_105_0" style="<?=$tempo?>"><tr><td class="textogeneralmenulateral"><a href="careportes.php?step=busqueda2&idtablareporteb1==&idtablareporteb2=<?=$numerodetabla?>&idregistroreporteb1==&idregistroreporteb2=<?=$id?>&idusuarioreportel1=on&idtablareportel1=on&idregistroreportel1=on&idaccesoreportel1=on&fechareportel1=on&horareportel1=on&operacionreportel1=on&sortfield=fechareporte&ordenamiento=DESC&comparadorsearch=AND&titulobusqueda=Reportes de registro" class=textogeneral>Ver reportes de este registro</a><br><a href="caseguimiento.php?step=busqueda2&tablaseguimientob1==&tablaseguimientob2=<?=$numerodetabla?>&registroseguimientob1==&registroseguimientob2=<?=$id?>&idusuarioseguimientol1=on&idaccesoseguimientol1=on&tablaseguimientol1=on&registroseguimientol1=on&horaseguimientol1=on&operacionseguimientol1=on&sortfield=idaccesoseguimiento&ordenamiento=DESC&comparadorsearch=AND&titulobusqueda=Seguimiento de registro" class=textogeneral>Ver seguimiento de este registro</a></td></tr></tbody><? } ?></table></td><? } ?>
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
      <td width=100%  valign=top><form name="form2" method="post" action="careportes.php?step=busqueda2&mensajemm=<?=$mensajemm?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior">B&uacute;squeda de <? echo("Reporte de accesos irregulares"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> Comparador
                <select name="comparadorsearch" class="textogeneral">
                  <option value="AND" selected>Y</option>
                  <option value="OR">O</option>
                </select>
Ordenar<select class="textogeneralform" name=sortfield><option value="idusuarioreporte">Usuario</option><option value="idtablareporte">Tabla</option><option value="idregistroreporte">Registro</option><option value="idaccesoreporte">Acceso</option><option value="fechareporte" selected>Fecha</option><option value="horareporte">Hora</option><option value="operacionreporte">Operación del reporte</option><option value="operacionreporte">Operación del reporte</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC selected>DESC</OPTION><option value=ASC>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('careportes.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');"><? } ?></td>
</tr>
          </table>
	  
            </td>
    </tr>
	
	<tr>
    <td>
      <table class="textogeneraltablaform" width="100%" cellpadding="0" cellspacing="0">
      <tr bgcolor="#<?=$vsitioscolor6?>" >
        <td width="9%"></td>
	    <td width="91%"></td>
      </tr>
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idusuarioreportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="idusuarioreporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idusuarioreporteb2" onChange="if(idusuarioreporteb1.selectedIndex==0) idusuarioreporteb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","nombreusuario","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idusuarioreporte==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Tabla</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idtablareportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="idtablareporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idtablareporteb2" onChange="if(idtablareporteb1.selectedIndex==0) idtablareporteb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("catablas","id","nombretabla","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idtablareporte==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Registro</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idregistroreportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="idregistroreporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="idregistroreporteb2" value="" size="10" onKeyUp="revisainput('idregistroreporteb1','idregistroreporteb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Acceso</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idaccesoreportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="idaccesoreporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idaccesoreporteb2" onChange="if(idaccesoreporteb1.selectedIndex==0) idaccesoreporteb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("caaccesos","id","ipaddressacceso","",""," ");  echo($registros); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idaccesoreporte==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="fechareportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="fechareporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechareporteb2" value="" size="15" onKeyUp="revisainput('fechareporteb1','fechareporteb2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Hora</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="horareportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="horareporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="horareporteb2" value="" size="10" onKeyUp="revisainput('horareporteb1','horareporteb2');" maxlength="5" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Operación del reporte</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="operacionreportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="operacionreporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="operacionreporteb2" onChange="if(operacionreporteb1.selectedIndex==0) operacionreporteb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="1" <? if($operacionreporte=="1") { ?>selected<? } ?> >Alta no permitida</option><OPTION VALUE="2" <? if($operacionreporte=="2") { ?>selected<? } ?> >Modificar no permitida</option><OPTION VALUE="3" <? if($operacionreporte=="3") { ?>selected<? } ?> >Borrar no permitido</option><OPTION VALUE="4" <? if($operacionreporte=="4") { ?>selected<? } ?> >Búsqueda no permitida</option><OPTION VALUE="5" <? if($operacionreporte=="5") { ?>selected<? } ?> >Consulta a registro no permitido</option><OPTION VALUE="6" <? if($operacionreporte=="6") { ?>selected<? } ?> >Violación a IDCONTROL</option><OPTION VALUE="7" <? if($operacionreporte=="7") { ?>selected<? } ?> >Alta violatoria (nivel campo)</option><OPTION VALUE="8" <? if($operacionreporte=="8") { ?>selected<? } ?> >Modificar violatoria (nivel campo)</option><OPTION VALUE="9" <? if($operacionreporte=="9") { ?>selected<? } ?> >Búsqueda violatoria (nivel campo)</option><OPTION VALUE="10" <? if($operacionreporte=="10") { ?>selected<? } ?> >Operación directa violatoria (nivel campo)</option><OPTION VALUE="11" <? if($operacionreporte=="11") { ?>selected<? } ?> >Otro</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Operación del reporte</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="operacionreportel1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="operacionreporteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="operacionreporteb2" onChange="if(operacionreporteb1.selectedIndex==0) operacionreporteb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="1" <? if($operacionreporte=="1") { ?>selected<? } ?> >Alta no permitida</option><OPTION VALUE="2" <? if($operacionreporte=="2") { ?>selected<? } ?> >Modificar no permitida</option><OPTION VALUE="3" <? if($operacionreporte=="3") { ?>selected<? } ?> >Borrar no permitido</option><OPTION VALUE="4" <? if($operacionreporte=="4") { ?>selected<? } ?> >Búsqueda no permitida</option><OPTION VALUE="5" <? if($operacionreporte=="5") { ?>selected<? } ?> >Consulta a registro no permitido</option><OPTION VALUE="6" <? if($operacionreporte=="6") { ?>selected<? } ?> >Violación a IDCONTROL</option><OPTION VALUE="7" <? if($operacionreporte=="7") { ?>selected<? } ?> >Alta violatoria (nivel campo)</option><OPTION VALUE="8" <? if($operacionreporte=="8") { ?>selected<? } ?> >Modificar violatoria (nivel campo)</option><OPTION VALUE="9" <? if($operacionreporte=="9") { ?>selected<? } ?> >Búsqueda violatoria (nivel campo)</option><OPTION VALUE="10" <? if($operacionreporte=="10") { ?>selected<? } ?> >Operación directa violatoria (nivel campo)</option><OPTION VALUE="11" <? if($operacionreporte=="11") { ?>selected<? } ?> >Otro</option></select> <? } ?></td></tr><? } ?> 
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('careportes.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcareportes.php?step=busqueda2');">
<?} ?><? } ?></div>
      </td>
    </tr>
  </table></form></td><? if($ocultabotones<>1) { ?><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=105 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");if(mysqli_num_rows($resultx)>0){  $tempoayuda="";  while($rowx = mysqli_fetch_array($resultx))  {    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";  }  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");  ?><script language="javascript" src="../include/scroll/scroll.js"></script><script language="javascript">var Tscr_LOOK0 = {'size' : [190, 100],'s_i':'textogeneralaviso','s_b':'textogeneralaviso','pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],'re' : [150,80, 16, 16,,'../include/scroll/mres.gif'],'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']},Tscr_BEHAVE0 = {'auto'  : true,'vertical' : true,'speed' : 1,'interval' : 50,'hide_buttons' : true,'zindex':5};</script><TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr><? } ?><tr><td  class="titulomenulateral"><b>Reporte de accesos irregulares</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; if($nivelusuario==0) $botones.="<td><a href=careportes.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>"; if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones); ?></tr></table></td></tr><? $menugeneraloprelacionbuscar=""; if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_105_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?><a href="#top" onClick="return abreocierracabeza('loprelacionbus_105_0')" class="textogeneralnegrita"><img id="collapseimg_loprelacionbus_105_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> <b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_105_0" style="<?=$tempo?>"><tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?></table></td><? } ?>
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

