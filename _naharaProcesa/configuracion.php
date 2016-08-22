<? 
include("recursos/entrada.php"); 
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

$numerodetabla=108;
$archivoactual="configuracion.php";

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
  $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select count(cagruposprivilegios.id) from caprivilegiosusuarios,cagruposprivilegios where caprivilegiosusuarios.idusuarioprivilegiousuario=".$sesionid." AND caprivilegiosusuarios.idgrupoprivilegiousuario=cagruposprivilegios.id AND cagruposprivilegios.activo=1 AND cagruposprivilegios.nombregrupoprivilegio='configuracion'");
  while($rowx = mysqli_fetch_array($resultx))
  {
     if($rowx[0]<=0) { $mensaje=guardareporte(11); $step=""; $operacion=""; }
  }
}


?>
<?if($step=="busqueda2" || $step=="busqueda3") { if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }  if($nivelusuario==1)   {     if($textobotonconfiguracionl1=="on" || $linkconfiguracionl1=="on" || $explicacionconfiguracionl1=="on" || $modoconfiguracionl1=="on") $error=9;     if(isset($textobotonconfiguracionb2) || isset($linkconfiguracionb2) || isset($explicacionconfiguracionb2) || isset($modoconfiguracionb2)) $error=9;   }  if($nivelusuario==2)   {     if($textobotonconfiguracionl1=="on" || $linkconfiguracionl1=="on" || $explicacionconfiguracionl1=="on" || $modoconfiguracionl1=="on") $error=9;     if(isset($textobotonconfiguracionb2) || isset($linkconfiguracionb2) || isset($explicacionconfiguracionb2) || isset($modoconfiguracionb2)) $error=9;   }  if($nivelusuario==3)   {     if($textobotonconfiguracionl1=="on" || $linkconfiguracionl1=="on" || $explicacionconfiguracionl1=="on" || $modoconfiguracionl1=="on") $error=9;     if(isset($textobotonconfiguracionb2) || isset($linkconfiguracionb2) || isset($explicacionconfiguracionb2) || isset($modoconfiguracionb2)) $error=9;   }  if($nivelusuario==4)   {     if($textobotonconfiguracionl1=="on" || $linkconfiguracionl1=="on" || $explicacionconfiguracionl1=="on" || $modoconfiguracionl1=="on") $error=9;     if(isset($textobotonconfiguracionb2) || isset($linkconfiguracionb2) || isset($explicacionconfiguracionb2) || isset($modoconfiguracionb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==1) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=8;   if($nivelusuario==2) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=8;   if($nivelusuario==3) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=8;   if($nivelusuario==4) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=8; }if($operacion=="add") {   if($nivelusuario==1) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=7;   if($nivelusuario==2) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=7;   if($nivelusuario==3) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=7;   if($nivelusuario==4) if(isset($_POST["textobotonconfiguracion"]) || isset($_POST["linkconfiguracion"]) || isset($_POST["explicacionconfiguracion"]) || isset($_POST["modoconfiguracion"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
<script language="JavaScript" src="../include/funcionescolapsos.js"></script>  
<script>function muestracabezaseditar() { } </script>
<?
  if($step=="add") // ESTE ES NECESARIO POR SI ESTA PROHIBIDO AGREGAR PARA QUE NO SE MUESTRE NI SIQUIERA EL FORMULARIO
  {
	 if($nivelusuario==0 || $nivelusuario==2) {    
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
	<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3 || $nivelusuario==10) {?> 
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

<title><? echo("Configuración"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>
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
	   if($nivelusuario==0 || $nivelusuario==2) {
      	
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
       if($nivelusuario==0 || $nivelusuario==2 || $nivelusuario==10) {
	   
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
      $sqltemporal.=construyesqltemporal("textobotonconfiguracion","'",0);$sqltemporal.=construyesqltemporal("linkconfiguracion","'",0);$sqltemporal.=construyesqltemporal("modoconfiguracion","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
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
	   if($nivelusuario==0 || $nivelusuario==2) {		
		  $sql = "INSERT INTO configuracion SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.="Se guardó correctamente el registro";
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=108,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			
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
	   if($nivelusuario==0 || $nivelusuario==2 || $nivelusuario==10) {	      
		  $sql = "UPDATE configuracion SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.="Se actualizó correctamente el registro";
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=108,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			  
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
		$sql = "DELETE FROM configuracion WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.="Se eliminó correctamente el registro <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">Regresar</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=108,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
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
    <td height="30" valign="middle"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,textobotonconfiguracion FROM configuracion where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["textobotonconfiguracion"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=><span class=titulo>Configuración</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? echo("Configuración"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?><? } ?></td>
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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on"; $comparadorsearch="AND"; $sortfield="configuracion.activo DESC,textobotonconfiguracion ASC"; $ordenamiento="";$activob1="="; $activob2="1";$textobotonconfiguracionl1="on"; $linkconfiguracionl1="on"; $modoconfiguracionl1="on"; } $camposbuscadoslistadosearch="configuracion.id";cbusqueda1($activol1,"configuracion","activo");cbusqueda1($textobotonconfiguracionl1,"configuracion","textobotonconfiguracion");cbusqueda1($linkconfiguracionl1,"configuracion","linkconfiguracion");cbusqueda1($explicacionconfiguracionl1,"configuracion","explicacionconfiguracion");cbusqueda1($modoconfiguracionl1,"configuracion","modoconfiguracion");cbusqueda3($textobotonconfiguracionb1,$textobotonconfiguracionb2,"configuracion","textobotonconfiguracion","'","0","","");cbusqueda3($linkconfiguracionb1,$linkconfiguracionb2,"configuracion","linkconfiguracion","'","0","","");cbusqueda3($explicacionconfiguracionb1,$explicacionconfiguracionb2,"configuracion","explicacionconfiguracion","'","0","","");cbusqueda3($modoconfiguracionb1,$modoconfiguracionb2,"configuracion","modoconfiguracion","'","0","","");cbusqueda3($activob1,$activob2,"configuracion","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from configuracion ";
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
          <td valign=middle class="titulointerior"><? echo("Configuración"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?> <span class=textogeneral>(<?=$num_rows?> registros<?=$mensajelimite?>) <?=$sqltemporal?> </span></td>
         
        
        </tr>
      </table>
    </td> </tr>

  <tr> 
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($textobotonconfiguracionl1,"Botón",": STR");cbusqueda5($linkconfiguracionl1,"Link",": STR");cbusqueda5($explicacionconfiguracionl1,"Explicación",": STR");cbusqueda5($modoconfiguracionl1,"Modo",": STR"); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra="<br>";$botonestigra="<a href=configuracion.php?step=modify&id=".$row["id"]." class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra;$linktigra="<a href=configuracion.php?step=modify&id=".$row["id"]." class=textogeneral>"; $listadodecampossearchtigra=$row["id"];cbusqueda4($textobotonconfiguracionl1,"configuracion","textobotonconfiguracion","0","","");cbusqueda4($linkconfiguracionl1,"configuracion","linkconfiguracion","0","","");cbusqueda4($explicacionconfiguracionl1,"configuracion","explicacionconfiguracion","0","",""); if($modoconfiguracionl1=="on")  {  if($row["modoconfiguracion"]=="0") $tempomodoconfiguracion="Catálogos de datos";if($row["modoconfiguracion"]=="1") $tempomodoconfiguracion="Sistema";if($row["modoconfiguracion"]=="2") $tempomodoconfiguracion="Contenido del sitio";if($row["modoconfiguracion"]=="3") $tempomodoconfiguracion="Otros";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempomodoconfiguracion.$tempotigra."\""; $tempotigra="";  }  if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($textobotonconfiguracionl1,$sumatoriatextobotonconfiguracion);cbusqueda6($linkconfiguracionl1,$sumatorialinkconfiguracion);cbusqueda6($explicacionconfiguracionl1,$sumatoriaexplicacionconfiguracion);cbusqueda6($modoconfiguracionl1,$sumatoriamodoconfiguracion);$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" method="post" action="excel/excelconfiguracion.php?step=busqueda2" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=textobotonconfiguracionl1 type="hidden" value="<?=$textobotonconfiguracionl1?>" ><input name=textobotonconfiguracionb1 type="hidden" value="<?=$textobotonconfiguracionb1?>" ><input name=textobotonconfiguracionb2 type="hidden" value="<?=$textobotonconfiguracionb2?>" ><input name=linkconfiguracionl1 type="hidden" value="<?=$linkconfiguracionl1?>" ><input name=linkconfiguracionb1 type="hidden" value="<?=$linkconfiguracionb1?>" ><input name=linkconfiguracionb2 type="hidden" value="<?=$linkconfiguracionb2?>" ><input name=explicacionconfiguracionl1 type="hidden" value="<?=$explicacionconfiguracionl1?>" ><input name=explicacionconfiguracionb1 type="hidden" value="<?=$explicacionconfiguracionb1?>" ><input name=explicacionconfiguracionb2 type="hidden" value="<?=$explicacionconfiguracionb2?>" ><input name=modoconfiguracionl1 type="hidden" value="<?=$modoconfiguracionl1?>" ><input name=modoconfiguracionb1 type="hidden" value="<?=$modoconfiguracionb1?>" ><input name=modoconfiguracionb2 type="hidden" value="<?=$modoconfiguracionb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1) {?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelconfiguracion.php?step=busqueda2');"><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
</table>
 </td><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=108 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");if(mysqli_num_rows($resultx)>0){  $tempoayuda="";  while($rowx = mysqli_fetch_array($resultx))  {    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";  }  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");  ?><script language="javascript" src="../include/scroll/scroll.js"></script><script language="javascript">var Tscr_LOOK0 = {'size' : [190, 100],'s_i':'textogeneralaviso','s_b':'textogeneralaviso','pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],'re' : [150,80, 16, 16,,'../include/scroll/mres.gif'],'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']},Tscr_BEHAVE0 = {'auto'  : true,'vertical' : true,'speed' : 1,'interval' : 50,'hide_buttons' : true,'zindex':5};</script><TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr><? } ?><tr><td  class="titulomenulateral"><b>Configuración</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) $botones.="<td><a href=configuracion.php?step=busqueda3><img src=recursos/botonlistar.gif border=\"0\" alt=Listar></a></td>";if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=configuracion.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";if($nivelusuario==0) $botones.="<td><a href=configuracion.php?step=add><img src=recursos/botonagregar.gif border=\"0\" alt=Agregar></a></td>"; if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones); ?></tr></table></td></tr><? $menugeneraloprelacionbuscar=""; if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_108_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?><a href="#top" onClick="return abreocierracabeza('loprelacionbus_108_0')" class="textogeneralnegrita"><img id="collapseimg_loprelacionbus_108_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> <b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_108_0" style="<?=$tempo?>"><tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?></table></td> <td class="spacerlateral"></td></tr>
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
$textobotonconfiguracion='';$linkconfiguracion='';$explicacionconfiguracion='';$modoconfiguracion='0';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["textobotonconfiguracion"])) $textobotonconfiguracion=$_POST["textobotonconfiguracion"];if(isset($_POST["linkconfiguracion"])) $linkconfiguracion=$_POST["linkconfiguracion"];if(isset($_POST["explicacionconfiguracion"])) $explicacionconfiguracion=$_POST["explicacionconfiguracion"];if(isset($_POST["modoconfiguracion"])) $modoconfiguracion=$_POST["modoconfiguracion"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM configuracion where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM configuracion where id=". $id);
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
$textobotonconfiguracion=$row["textobotonconfiguracion"];$linkconfiguracion=$row["linkconfiguracion"];$explicacionconfiguracion=$row["explicacionconfiguracion"];$modoconfiguracion=$row["modoconfiguracion"];
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
	  <form name="form1" onSubmit="return v.exec()" method="post" action="configuracion.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?>" enctype="multipart/form-data">
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo("Agregar "); else echo("Modificar "); ?><? echo("Configuración"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></span></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>  
				       
				          <? } ?>
<? if($nivelusuario==0 || $nivelusuario==2 || $nivelusuario==10) {?>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_textobotonconfiguracion">Botón * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="textobotonconfiguracion" value="<? echo(htmlspecialchars($textobotonconfiguracion)); ?>" size="55" maxlength="50" class=textogeneralform><? } ?><? if(($nivelusuario==10)) { ?><?=$textobotonconfiguracion?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_linkconfiguracion">Link * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="linkconfiguracion" value="<? echo(htmlspecialchars($linkconfiguracion));?>" size="50" maxlength="100"  class=textogeneralform><? } ?><? if(($nivelusuario==10)) { ?><?=$linkconfiguracion?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_explicacionconfiguracion">Explicación </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?if($step=="add") echo("Para editar este campo, es necesario guardar el registro."); if($step=="modify") echo("<a href=javascript:editarmf('explicacionconfiguracion','configuracion',".$id.",'".urlencode("Explicación")."','".urlencode("Configuración")."',108) class=textoboton>&nbsp;Editar texto&nbsp;</a>"); ?><? } ?><? if(($nivelusuario==10)) { ?><?=$explicacionconfiguracion?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_modoconfiguracion">Modo * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><select name="modoconfiguracion" class=textogeneralform><OPTION VALUE="0" <? if($modoconfiguracion=="0") echo("selected");?> >Catálogos de datos</option><OPTION VALUE="1" <? if($modoconfiguracion=="1") echo("selected");?> >Sistema</option><OPTION VALUE="2" <? if($modoconfiguracion=="2") echo("selected");?> >Contenido del sitio</option><OPTION VALUE="3" <? if($modoconfiguracion=="3") echo("selected");?> >Otros</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($modoconfiguracion=="0") echo("Catálogos de datos");if($modoconfiguracion=="1") echo("Sistema");if($modoconfiguracion=="2") echo("Contenido del sitio");if($modoconfiguracion=="3") echo("Otros"); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'textobotonconfiguracion':{'l':'Botón','r': true,'t':'t_textobotonconfiguracion'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'linkconfiguracion':{'l':'Link','r': true,'t':'t_linkconfiguracion'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'modoconfiguracion':{'l':'Modo','r': true,'t':'t_modoconfiguracion'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} var v = new validator('form1', a_fields, o_config)</script>  
    <? if($nivelusuario==0) {?>
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
                <? if($ocultabotones<>1) { ?>	<? if($nivelusuario==0 || $nivelusuario==2 || $nivelusuario==10) {?> <? $yabotonguardar="ya"; ?>
                <input class=textogeneral type="submit" name="Submit" value="Guardar"><?} ?>
				<? if($step=="add" && $yabotonguardar<>"ya") { ?><input class=textogeneral type="submit" name="Submit" value="Guardar"><? } ?><? } ?>
              </div>
            </td>
    </tr>
	
	
	
  </table></form></td>
     <? if($ocultabotones<>1) { ?> <? if($step=="modify") { ?><? } ?><td width="10" rowspan="2"><img width="10" height="0"></td><td width="100%" valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=108 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='1'");if(mysqli_num_rows($resultx)>0){  $tempoayuda="";  while($rowx = mysqli_fetch_array($resultx))  {    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";  }  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");  ?><script language="javascript" src="../include/scroll/scroll.js"></script><script language="javascript">var Tscr_LOOK0 = {'size' : [190, 100],'s_i':'textogeneralaviso','s_b':'textogeneralaviso','pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],'re' : [150,80, 16, 16,,'../include/scroll/mres.gif'],'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']},Tscr_BEHAVE0 = {'auto'  : true,'vertical' : true,'speed' : 1,'interval' : 50,'hide_buttons' : true,'zindex':5};</script><TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr><? } ?><tr><td  class="titulomenulateral"><b>Configuración</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) $botones.="<td><a href=configuracion.php?step=busqueda3><img src=recursos/botonlistar.gif border=\"0\" alt=Listar></a></td>";if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=configuracion.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";if($nivelusuario==0) $botones.="<td><a href=configuracion.php?step=add><img src=recursos/botonagregar.gif border=\"0\" alt=Agregar></a></td>"; if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones); ?></tr></table></td></tr><? if($nivelusuario==0) { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"avanzadas_108_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?><a href="#top" onClick="return abreocierracabeza('avanzadas_108_0')" class="textogeneralnegrita"><img id="collapseimg_avanzadas_108_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> <b>Avanzadas</b></a></td></tr><tbody id="collapseobj_avanzadas_108_0" style="<?=$tempo?>"><tr><td class="textogeneralmenulateral"><a href="careportes.php?step=busqueda2&idtablareporteb1==&idtablareporteb2=<?=$numerodetabla?>&idregistroreporteb1==&idregistroreporteb2=<?=$id?>&idusuarioreportel1=on&idtablareportel1=on&idregistroreportel1=on&idaccesoreportel1=on&fechareportel1=on&horareportel1=on&operacionreportel1=on&sortfield=fechareporte&ordenamiento=DESC&comparadorsearch=AND&titulobusqueda=Reportes de registro" class=textogeneral>Ver reportes de este registro</a><br><a href="caseguimiento.php?step=busqueda2&tablaseguimientob1==&tablaseguimientob2=<?=$numerodetabla?>&registroseguimientob1==&registroseguimientob2=<?=$id?>&idusuarioseguimientol1=on&idaccesoseguimientol1=on&tablaseguimientol1=on&registroseguimientol1=on&horaseguimientol1=on&operacionseguimientol1=on&sortfield=idaccesoseguimiento&ordenamiento=DESC&comparadorsearch=AND&titulobusqueda=Seguimiento de registro" class=textogeneral>Ver seguimiento de este registro</a></td></tr></tbody><? } ?></table></td><? } ?>
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
  <? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="configuracion.php?step=busqueda2&mensajemm=<?=$mensajemm?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior">B&uacute;squeda de <? echo("Configuración"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> Comparador
                <select name="comparadorsearch" class="textogeneral">
                  <option value="AND" selected>Y</option>
                  <option value="OR">O</option>
                </select>
Ordenar<select class="textogeneralform" name=sortfield><option value="textobotonconfiguracion" selected>Botón</option><option value="linkconfiguracion">Link</option><option value="explicacionconfiguracion">Explicación</option><option value="modoconfiguracion">Modo</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('configuracion.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Botón</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="textobotonconfiguracionl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="textobotonconfiguracionb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="textobotonconfiguracionb2" value="" size="55" onKeyUp="revisainput('textobotonconfiguracionb1','textobotonconfiguracionb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Link</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="linkconfiguracionl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="linkconfiguracionb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="linkconfiguracionb2" value="" size="50" onKeyUp="revisainput('linkconfiguracionb1','linkconfiguracionb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Explicación</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="explicacionconfiguracionl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="explicacionconfiguracionb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="explicacionconfiguracionb2" value="" size="50" onKeyUp="revisainput('explicacionconfiguracionb1','explicacionconfiguracionb2');" maxlength="50" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Modo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="modoconfiguracionl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="modoconfiguracionb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="modoconfiguracionb2" onChange="if(modoconfiguracionb1.selectedIndex==0) modoconfiguracionb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($modoconfiguracion=="0") { ?>selected<? } ?> >Catálogos de datos</option><OPTION VALUE="1" <? if($modoconfiguracion=="1") { ?>selected<? } ?> >Sistema</option><OPTION VALUE="2" <? if($modoconfiguracion=="2") { ?>selected<? } ?> >Contenido del sitio</option><OPTION VALUE="3" <? if($modoconfiguracion=="3") { ?>selected<? } ?> >Otros</option></select> <? } ?></td></tr><? } ?> 
	<? if($nivelusuario==0) {?>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('configuracion.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?>');">
<? if($nivelusuario==0 || $nivelusuario==1) {?>
<input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelconfiguracion.php?step=busqueda2');">
<?} ?><? } ?></div>
      </td>
    </tr>
  </table></form></td><? if($ocultabotones<>1) { ?><td width="10" rowspan="2"><img width="10" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=108 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");if(mysqli_num_rows($resultx)>0){  $tempoayuda="";  while($rowx = mysqli_fetch_array($resultx))  {    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";  }  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");  ?><script language="javascript" src="../include/scroll/scroll.js"></script><script language="javascript">var Tscr_LOOK0 = {'size' : [190, 100],'s_i':'textogeneralaviso','s_b':'textogeneralaviso','pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],'re' : [150,80, 16, 16,,'../include/scroll/mres.gif'],'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']},Tscr_BEHAVE0 = {'auto'  : true,'vertical' : true,'speed' : 1,'interval' : 50,'hide_buttons' : true,'zindex':5};</script><TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr><? } ?><tr><td  class="titulomenulateral"><b>Configuración</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) $botones.="<td><a href=configuracion.php?step=busqueda3><img src=recursos/botonlistar.gif border=\"0\" alt=Listar></a></td>";if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=configuracion.php?step=busqueda><img src=recursos/botonbuscar.gif border=\"0\" alt=Buscar></a></td>";if($nivelusuario==0) $botones.="<td><a href=configuracion.php?step=add><img src=recursos/botonagregar.gif border=\"0\" alt=Agregar></a></td>"; if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones); ?></tr></table></td></tr><? $menugeneraloprelacionbuscar=""; if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_108_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?><a href="#top" onClick="return abreocierracabeza('loprelacionbus_108_0')" class="textogeneralnegrita"><img id="collapseimg_loprelacionbus_108_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> <b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_108_0" style="<?=$tempo?>"><tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?></table></td><? } ?>
     <td class="spacerlateral"></td>
    </tr>
  </table>
  

<?} ?>
<?php  } ?>
<? if($step=="add" || $step=="modify")  { ?>

<? } ?>
</body>
</html>

