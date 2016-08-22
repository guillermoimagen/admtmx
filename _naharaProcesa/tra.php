<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_tra"]=1;
	$_SESSION["esframe_tra_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_tra_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_tra"]=0;
	$_SESSION["esframe_tra_id"]=0;
	$_SESSION["esframe_tra_archivo"]="";
}

$titulo_pagina="Transacciones";
$status_campo="";

include("recursos/funciones.php"); 
if($idiomas_admin=="ingles")
{
    $ib_registros="records";
    $ib_guardar="Save";
    $ib_activo="Active";
    $ib_busqueda="Search";
    $ib_ordenar="Order";
    $ib_exportar="Export to Excel";
    $ib_general="Main";
    
    $ib_editando="Editing";
    $ib_agregando="Adding";
  	$ib_add_modify="Record saved";
    $ib_add_modify_duplicate="Record not saved";
    $ib_modify_nada="No changes on the record";
    $ib_delete_bien="Record deleted";
    $ib_delete_mal="Record not deleted. There was an error. Please try again later";
    $ib_regresar="Back";
}
else
{    
	$ib_registros="registros";
    $ib_guardar="Guardar";
    $ib_activo="Activo";
    $ib_busqueda="Buscar";
    $ib_ordenar="Ordenar";
    $ib_exportar="Exportar a Excel";
    $ib_general="General";
    
    $ib_editando="Editando";
    $ib_agregando="Guardando";
    $ib_add_modify="Registro guardado";
    $ib_add_modify_duplicate="Registro no guardado";
    $ib_modify_nada="No hubo cambios al registro";
    $ib_delete_bien="Registro eliminado";
    $ib_delete_mal="Registro no eliminado. Ocurrió un error. Intente más tarde";
    $ib_regresar="Regresar";
}

$numerodetabla=8;
include("recursos/funciones_tabla.php"); 
$archivoactual="tra.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_tra"]=$id;
include("recursos/iconosybotones.php");
$controlmatch="NO";

?>



<html>

<link rel="stylesheet" href="recursos/estilos.css" type="text/css">
<? 
if($step==1) $step="busqueda3";


$valordisabled="";


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
  $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select count(cagruposprivilegios.id) from caprivilegiosusuarios,cagruposprivilegios where caprivilegiosusuarios.idusuarioprivilegiousuario=".$sesionid." AND caprivilegiosusuarios.idgrupoprivilegiousuario=cagruposprivilegios.id AND cagruposprivilegios.activo=1 AND cagruposprivilegios.nombregrupoprivilegio=''");
  while($rowx = mysqli_fetch_array($resultx))
  {
     if($rowx[0]<=0) { $mensaje=guardareporte(11); $step=""; $operacion=""; }
  }
}


?>
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==2)   {     if($fechatral1=="on" || $importetral1=="on" || $minimodonativotral1=="on" || $ganadorestral1=="on" || $statustral1=="on") $error=9;     if(isset($fechatrab2) || isset($importetrab2) || isset($minimodonativotrab2) || isset($ganadorestrab2) || isset($statustrab2)) $error=9;   }  if($nivelusuario==3)   {     if($fechatral1=="on" || $importetral1=="on" || $minimodonativotral1=="on" || $ganadorestral1=="on" || $statustral1=="on") $error=9;     if(isset($fechatrab2) || isset($importetrab2) || isset($minimodonativotrab2) || isset($ganadorestrab2) || isset($statustrab2)) $error=9;   }  if($nivelusuario==4)   {     if($fechatral1=="on" || $importetral1=="on" || $minimodonativotral1=="on" || $ganadorestral1=="on" || $statustral1=="on") $error=9;     if(isset($fechatrab2) || isset($importetrab2) || isset($minimodonativotrab2) || isset($ganadorestrab2) || isset($statustrab2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"])) $error=8;   if($nivelusuario==1) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"])) $error=8;   if($nivelusuario==2) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"]) || isset($_POST["fechatra"]) || isset($_POST["importetra"]) || isset($_POST["minimodonativotra"]) || isset($_POST["ganadorestra"]) || isset($_POST["statustra"])) $error=8;   if($nivelusuario==3) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"]) || isset($_POST["fechatra"]) || isset($_POST["importetra"]) || isset($_POST["minimodonativotra"]) || isset($_POST["ganadorestra"]) || isset($_POST["statustra"])) $error=8;   if($nivelusuario==4) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"]) || isset($_POST["fechatra"]) || isset($_POST["importetra"]) || isset($_POST["minimodonativotra"]) || isset($_POST["ganadorestra"]) || isset($_POST["statustra"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"])) $error=7;   if($nivelusuario==1) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"])) $error=7;   if($nivelusuario==2) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"]) || isset($_POST["fechatra"]) || isset($_POST["importetra"]) || isset($_POST["minimodonativotra"]) || isset($_POST["ganadorestra"]) || isset($_POST["statustra"])) $error=7;   if($nivelusuario==3) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"]) || isset($_POST["fechatra"]) || isset($_POST["importetra"]) || isset($_POST["minimodonativotra"]) || isset($_POST["ganadorestra"]) || isset($_POST["statustra"])) $error=7;   if($nivelusuario==4) if(isset($_POST["irettra"]) || isset($_POST["iusuariotra"]) || isset($_POST["fechatra"]) || isset($_POST["importetra"]) || isset($_POST["minimodonativotra"]) || isset($_POST["ganadorestra"]) || isset($_POST["statustra"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
<script language="JavaScript" src="../include/funcionescolapsos.js"></script>  
<script>function muestracabezaseditar() { } </script>
<?
  if($step=="add") // ESTE ES NECESARIO POR SI ESTA PROHIBIDO AGREGAR PARA QUE NO SE MUESTRE NI SIQUIERA EL FORMULARIO
  {
	 if($nivelusuario==0 || $nivelusuario==1) {    
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
	<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {?> 
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


<?if($_SESSION["esframe_tra"]==1){  if($_SESSION["esframe_tra_archivo"]=="ret")  {    if($step=="add")    {      $irettra=$_SESSION["id_ret"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $irettrab1="=";      $irettrab2=$_SESSION["id_ret"];    }  }  else   if($_SESSION["esframe_tra_archivo"]=="usuarios")  {    if($step=="add")    {      $iusuariotra=$_SESSION["id_usuarios"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $iusuariotrab1="=";      $iusuariotrab2=$_SESSION["id_usuarios"];    }  }}?>


<head>

<title><? echo("Transacciones"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<script>
function funcionload()
{
<? if($step=="busqueda") { ?> <? } else if($step=="modify" || $step=="add") { ?> <? } ?> 
}
</script>
<? include("recursos/funcionesjs.php"); ?>
<script language="JavaScript" src="include/imenu_peque.js"></script>

<script language="javascript" type="text/javascript" src="include/autocompleta/ajax.js"></script><script language="javascript" type="text/javascript" src="include/autocompleta/ajax-dynamic-list.js"></script><link href="include/autocompleta/estilos.css" rel="stylesheet" type="text/css"/>
</head>
<BODY style="margin-right:0px;" onLoad="funcionload();">

<?
  if($ocultabotones<>1) {   
    if($_SESSION["esframe_tra"]<>1)
    {
        echo($encabezadousuario);
        include("recursos/cabeza.inc"); 
        if($ventanabotoneditar<>1)
        {
          include("menu.php"); 
          include("menu2.php"); 
        }	
    }    
  }	
?>
<?php 
  if(isset($_POST["importetra"])) $_POST["importetra"]=limpia_numero($_POST["importetra"]);if(isset($_POST["minimodonativotra"])) $_POST["minimodonativotra"]=limpia_numero($_POST["minimodonativotra"]);if(isset($_POST["ganadorestra"])) $_POST["ganadorestra"]=limpia_numero($_POST["ganadorestra"]);
  
  if($operacion=="modify" || $operacion=="add") 
  {
	if($operacion=="add") 
	{
	   if($nivelusuario==0 || $nivelusuario==1) {
      	
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
       if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM tra where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("irettra","",0);$sqltemporal.=construyesqltemporal("iusuariotra","",0);$sqltemporal.=construyesqltemporal("fechatra","'",0);$sqltemporal.=construyesqltemporal("importetra","",2);$sqltemporal.=construyesqltemporal("minimodonativotra","",2);$sqltemporal.=construyesqltemporal("ganadorestra","",2);$sqltemporal.=construyesqltemporal("statustra","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
    }
    
	
	if($sqltemporal=="" && ($operacion=="add" || $operacion=="modify")) 
	{
	  $mensaje=$ib_modify_nada;
	  $modomensaje="NADA";
	  $operacion="";
	}  
	
	
	
	if($operacion=="add") 
	{	
	  $controlmatch="SI";  
	   if($nivelusuario==0 || $nivelusuario==1) {	
      	
		  $sql = "INSERT INTO tra SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=8,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_tra"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_tra"]="OK";
	            $_SESSION["frame_interior_".$archivoactual]="add";
	            /*echo("<script>parent.location.reload()</script>");
	            exit();*/
            }    
		  } 
		  else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="Ya existe un registro con esos datos<br".$ib_add_modify_duplicate;
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
	   if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {	      
		  $sql = "UPDATE tra SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=8,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM tra where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["irettra"]<>$rown["irettra"]) $cadena_historico.="Iniciativa:\r\n O:".$rowh["irettra"]."\r\nN: ".$rown["irettra"]."\r\n\r\n";               if($rowh["iusuariotra"]<>$rown["iusuariotra"]) $cadena_historico.="Usuario:\r\n O:".$rowh["iusuariotra"]."\r\nN: ".$rown["iusuariotra"]."\r\n\r\n";               if($rowh["fechatra"]<>$rown["fechatra"]) $cadena_historico.="Fecha de alta:\r\n O:".$rowh["fechatra"]."\r\nN: ".$rown["fechatra"]."\r\n\r\n";               if($rowh["importetra"]<>$rown["importetra"]) $cadena_historico.="Importe:\r\n O:".$rowh["importetra"]."\r\nN: ".$rown["importetra"]."\r\n\r\n";               if($rowh["minimodonativotra"]<>$rown["minimodonativotra"]) $cadena_historico.="Mínimo donativo:\r\n O:".$rowh["minimodonativotra"]."\r\nN: ".$rown["minimodonativotra"]."\r\n\r\n";               if($rowh["ganadorestra"]<>$rown["ganadorestra"]) $cadena_historico.="Ganadores:\r\n O:".$rowh["ganadorestra"]."\r\nN: ".$rown["ganadorestra"]."\r\n\r\n";               if($rowh["statustra"]<>$rown["statustra"]) $cadena_historico.="Status de pago:\r\n O:".$rowh["statustra"]."\r\nN: ".$rown["statustra"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_tra"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_tra"]="NADA";
			}  
        	if($_GET["edicioninterior"]==1)
            {
				/* echo("<script>parent.location.reload()</script>");
    	        exit(); */
			}
			  
		  } else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="Ya existe un registro con esos datos<br>".$ib_add_modify_duplicate;
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
      if($confirmadelete<>"confirmado") {$mensajedelete="";if($mensajedelete<>"") { $step="modify"; $operacion=""; $modomensaje="ERROR"; $mensaje.="No se puede eliminar el registro, debido a lo siguiente:".$mensajedelete;}}
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
		$sql = "DELETE FROM tra WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=8,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_tra"]="BORRADO";
          	echo("<script>parent.location.reload()</script>");
          	exit();
          }     
		} 
		else 
		{
		 $mensaje.=$ib_delete_mal.": " . mysqli_error($GLOBALS["enlaceDB"] ) ;
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
  	
if($_GET["edicioninterior"]<>1) { 
?>

  <table border="0" cellspacing="0" cellpadding="0" class="titulopagina">
  <tr>    
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,irettra FROM tra where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["irettra"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=tra.php?step=1".$url_extra."><span class=titulo>Transacciones</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=tra.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Transacciones\"></a></td>";if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=tra.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Transacciones\"></a></td>";if(($nivelusuario==0 || $nivelusuario==1)) $botones.="<td><a href=\"tra.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Transacciones\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_tra"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_tra"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_tra"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_tra"]="";


  echo("<div name=\"label_mensaje\" id=\"label_mensaje\">");
  if($mensaje<>"") 
  {  
    if($modomensaje=="ERROR") echo($entradamensajeerror.$mensaje.$salidamensaje); 
	else if($modomensaje=="NADA") echo($entradamensajenada.$mensaje.$salidamensaje); 
	else echo($entradamensaje.$mensaje.$salidamensaje);
     echo("<span class=textogeneral><br></span>");    
  }	
  echo("</div>");  
  
?>

<? if($step=="busqueda" || $step=="busqueda2" || $step=="busqueda3") { ?>

<? } else if($step=="modify" || $step=="add") { ?>

<? } ?>

   
<? if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($_GET["edicioninterior"]<>1 && $mensaje=="") 
	echo("<span class=textogeneral><br></span>"); ?>

<table width=100% border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="spacerlateral"></td>
<td valign=top width=100%>
<table border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="left">
  <tr> 
    <td width=100%><?
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="tra.activo DESC,irettra ASC"; $ordenamiento="";$activob1="="; $activob2="1";$irettral1="on"; $iusuariotral1="on"; $fechatral1="on"; $importetral1="on"; $minimodonativotral1="on"; $ganadorestral1="on"; } $camposbuscadoslistadosearch="tra.id";cbusqueda1($activol1,"tra","activo");cbusqueda1($irettral1,"ret","nombreret","0","","");cbusqueda1($iusuariotral1,"usuarios","nombreusuario","0","","");cbusqueda1($fechatral1,"tra","fechatra");cbusqueda1($importetral1,"tra","importetra");cbusqueda1($minimodonativotral1,"tra","minimodonativotra");cbusqueda1($ganadorestral1,"tra","ganadorestra");cbusqueda1($statustral1,"tra","statustra");cbusqueda2($irettral1,"ret","tra","irettra","",0,"id");cbusqueda2($iusuariotral1,"usuarios","tra","iusuariotra","",0,"id");cbusqueda3($irettrab1,$irettrab2,"tra","irettra","","0","","");cbusqueda3($iusuariotrab1,$iusuariotrab2,"tra","iusuariotra","","0","","");cbusqueda3($fechatrab1,$fechatrab2,"tra","fechatra","'","0","","");cbusqueda3($importetrab1,$importetrab2,"tra","importetra","","0","","");cbusqueda3($minimodonativotrab1,$minimodonativotrab2,"tra","minimodonativotra","","0","","");cbusqueda3($ganadorestrab1,$ganadorestrab2,"tra","ganadorestra","","0","","");cbusqueda3($statustrab1,$statustrab2,"tra","statustra","'","0","","");cbusqueda3($activob1,$activob2,"tra","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from tra ";
	$antesbusqueda="";
	
	if($camposcomunessearch<>"") $rutinabusqueda=$rutinabusqueda.$camposcomunessearch;
	
	if($sqltemporal<>"" && $antesbusqueda<>"") $sqltemporal=$sqltemporal." and ".$antesbusqueda;
	else if($sqltemporal=="" && $antesbusqueda<>"") $sqltemporal=$antesbusqueda;
	
    
    
    if($codigoadicional_bandera<>"yapaso")
    {
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
          <td valign=middle class="titulointerior"><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><span class=textogeneral>(<?=$num_rows?> <?=$ib_registros?><?=$mensajelimite?>) <?=$sqltemporal?> </span></td>
         
        
        </tr>
      </table>
    </td> </tr>

  <tr> 
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($irettral1,"Iniciativa",": STR","");cbusqueda5($iusuariotral1,"Usuario",": STR","");cbusqueda5($fechatral1,"Fecha de alta"," : DATE","");cbusqueda5($importetral1,"Importe"," : NUM","");cbusqueda5($minimodonativotral1,"Mínimo donativo"," : NUM","");cbusqueda5($ganadorestral1,"Ganadores"," : NUM","");cbusqueda5($statustral1,"Status de pago",": STR",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='tra.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($irettral1,"ret","nombreret","0","","");cbusqueda4($iusuariotral1,"usuarios","nombreusuario","0","","");cbusqueda4($fechatral1,"tra","fechatra","0","","");cbusqueda4($importetral1,"tra","importetra","0","","");cbusqueda4($minimodonativotral1,"tra","minimodonativotra","0","","");cbusqueda4($ganadorestral1,"tra","ganadorestra","0","",""); if($statustral1=="on")  {  if($row["statustra"]=="0") $tempostatustra="Pendiente de pago";if($row["statustra"]=="1") $tempostatustra="Pagado";if($row["statustra"]=="2") $tempostatustra="Cancelado";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempostatustra.$tempotigra."\""; $tempotigra="";  }  if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($irettral1,$sumatoriairettra,'');cbusqueda6($iusuariotral1,$sumatoriaiusuariotra,'');cbusqueda6($fechatral1,$sumatoriafechatra,'');cbusqueda6($importetral1,$sumatoriaimportetra,'');cbusqueda6($minimodonativotral1,$sumatoriaminimodonativotra,'');cbusqueda6($ganadorestral1,$sumatoriaganadorestra,'');cbusqueda6($statustral1,$sumatoriastatustra,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/exceltra.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=irettral1 type="hidden" value="<?=$irettral1?>" ><input name=irettrab1 type="hidden" value="<?=$irettrab1?>" ><input name=irettrab2 type="hidden" value="<?=$irettrab2?>" ><input name=iusuariotral1 type="hidden" value="<?=$iusuariotral1?>" ><input name=iusuariotrab1 type="hidden" value="<?=$iusuariotrab1?>" ><input name=iusuariotrab2 type="hidden" value="<?=$iusuariotrab2?>" ><input name=fechatral1 type="hidden" value="<?=$fechatral1?>" ><input name=fechatrab1 type="hidden" value="<?=$fechatrab1?>" ><input name=fechatrab2 type="hidden" value="<?=$fechatrab2?>" ><input name=importetral1 type="hidden" value="<?=$importetral1?>" ><input name=importetrab1 type="hidden" value="<?=$importetrab1?>" ><input name=importetrab2 type="hidden" value="<?=$importetrab2?>" ><input name=minimodonativotral1 type="hidden" value="<?=$minimodonativotral1?>" ><input name=minimodonativotrab1 type="hidden" value="<?=$minimodonativotrab1?>" ><input name=minimodonativotrab2 type="hidden" value="<?=$minimodonativotrab2?>" ><input name=ganadorestral1 type="hidden" value="<?=$ganadorestral1?>" ><input name=ganadorestrab1 type="hidden" value="<?=$ganadorestrab1?>" ><input name=ganadorestrab2 type="hidden" value="<?=$ganadorestrab2?>" ><input name=statustral1 type="hidden" value="<?=$statustral1?>" ><input name=statustrab1 type="hidden" value="<?=$statustrab1?>" ><input name=statustrab2 type="hidden" value="<?=$statustrab2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/exceltra.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
   <? } ?>
</table>
 </td> <td class="spacerlateral"></td></tr>
</table>
<?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; ?>
<? 

$menupeque=2;
include("include/imenu_peque.php");
} ?>
<?php 
if($step=="add" || $step=="modify") 
{
?>
<? include("status_validarjs.php"); ?>
<? 
} 
?>
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
if(isset($_GET["irettra"])) $irettra=$_GET["irettra"];if(isset($_GET["iusuariotra"])) $iusuariotra=$_GET["iusuariotra"];	
if($error_unique==0)
{
$fechatra='';$importetra=0;$minimodonativotra=0;$ganadorestra=0;$statustra='0';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["irettra"])) $irettra=$_POST["irettra"];if(isset($_POST["iusuariotra"])) $iusuariotra=$_POST["iusuariotra"];if(isset($_POST["fechatra"])) $fechatra=$_POST["fechatra"];if(isset($_POST["importetra"])) $importetra=$_POST["importetra"];if(isset($_POST["minimodonativotra"])) $minimodonativotra=$_POST["minimodonativotra"];if(isset($_POST["ganadorestra"])) $ganadorestra=$_POST["ganadorestra"];if(isset($_POST["statustra"])) $statustra=$_POST["statustra"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM tra where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM tra where id=". $id);
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
$irettra=$row["irettra"];$iusuariotra=$row["iusuariotra"];$fechatra=$row["fechatra"];$importetra=$row["importetra"];$minimodonativotra=$row["minimodonativotra"];$ganadorestra=$row["ganadorestra"];$statustra=$row["statustra"];
       }
	 }	 
	 
  ?>

<? if($_GET["edicioninterior"]<>1 && $mensaje=="") { ?>
<span class=textogeneral><br></span>
<? } ?>

<? if($registrosencontrados>0) {?>

<? if($step=="modify") { ?>




<? } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100% valign=top>
       <?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; ?>
      <?
     
       $menupeque=1;
		include("include/imenu_peque.php");
      
      ?>
      <div id="formulario" name="formulario">
	  
	  <table border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="left">
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="tra.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('tra.php?sortfield=irettra&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
				          <? } ?>

<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {?>
<? $yabotonguardar="ya"; ?>
<input class=textogeneral type="submit" name="Submit" value="<?=$ib_guardar?>" <?=$valordisabled?>>
<?} ?>
<? if($step=="add" && $yabotonguardar<>"ya") { ?>
<input class=textogeneral type="submit" name="Submit" value="<?=$ib_guardar?>" <?=$valordisabled?>>
<? } ?></div><? } ?>
</td>
                  </tr>
                </table>
                
              </div>
          </td>
    </tr>
	
	 <tr>
       <td bgcolor="#<?=$vsitioscolor5?>">
       <table align="center" width="100%">
       <tr>
       <td  width="90%" id="error_form1"  style="display:none; width:inherit; padding:10px; height:auto;" name="error_form1"></td>
       </tr>
       </table>
       </td>
     </tr> 
	 
	
    <input name="idcontrol" type="hidden" value="<?=$idcontrolinterno?>">
	<input name="controlmatch" type="hidden" value="<?=$controlmatch?>">
	<input name="match_posts2" type="hidden" value="<?=$match_posts?>">	
	
	
	
	<tr>
    <td>
      <table class="textogeneraltablaform" width="100%" cellpadding="3" cellspacing="0">
     	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_irettra" name="t_irettra">Iniciativa * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="irettra" id="irettra"  class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($irettra==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? $valor_mostrar=lee_registro("ret","nombreret","","",$irettra,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuariotra" name="t_iusuariotra">Usuario * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="iusuariotra" id="iusuariotra"  class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariotra==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? $valor_mostrar=lee_registro("usuarios","nombreusuario","","",$iusuariotra,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fechatra" name="t_fechatra">Fecha de alta * </td><td valign="middle"><?=$fechatra?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_importetra" name="t_importetra">Importe * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="importetra" id="importetra" value="<? echo(formato_numero($importetra,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('importetra')" onBlur="pone_pesos('importetra','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($importetra,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_minimodonativotra" name="t_minimodonativotra">Mínimo donativo * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="minimodonativotra" id="minimodonativotra" value="<? echo(formato_numero($minimodonativotra,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('minimodonativotra')" onBlur="pone_pesos('minimodonativotra','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($minimodonativotra,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ganadorestra" name="t_ganadorestra">Ganadores * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="ganadorestra" id="ganadorestra" value="<? echo(formato_numero($ganadorestra,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('ganadorestra')" onBlur="pone_pesos('ganadorestra','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($ganadorestra,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_statustra" name="t_statustra">Status de pago * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="statustra" id="statustra" class=textogeneralform><OPTION VALUE="0" <? if($statustra=="0") echo("selected");?> >Pendiente de pago</option><OPTION VALUE="1" <? if($statustra=="1") echo("selected");?> >Pagado</option><OPTION VALUE="2" <? if($statustra=="2") echo("selected");?> >Cancelado</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($statustra=="0") echo("Pendiente de pago");if($statustra=="1") echo("Pagado");if($statustra=="2") echo("Cancelado"); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'irettra':{'l':'Iniciativa','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_irettra'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuariotra':{'l':'Usuario','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iusuariotra'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fechatra':{'l':'Fecha de alta','r': true,'t':'t_fechatra'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'importetra':{'l':'Importe','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_importetra'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'minimodonativotra':{'l':'Mínimo donativo','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_minimodonativotra'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ganadorestra':{'l':'Ganadores','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_ganadorestra'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'statustra':{'l':'Status de pago','r': true,'t':'t_statustra'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
	var v = new validator('form1', a_fields, o_config);</script>  
    <? if($nivelusuario==0 || $nivelusuario==1) {?>
	<tr>
      <td valign="middle"  bgcolor="#<?=$vsitioscolor3?>"><?=$ib_activo?> <a onMouseOver="myHint.show('activo')" onMouseOut="myHint.hide()">(?)</a></td>
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
     <td colspan="2"  class="titulointerior" valign="middle"><? if($nivelusuario==0 && $step=="modify") { ?><span id="historico" name="historico" style="float:left;"><table><tr><td><a href="#top" onClick="return abreocierracabeza('avanzadas_span')" class="textogeneralnegrita"><b>&rArr;</b></a></td><td id="collapseobj_avanzadas_span"  name="collapseobj_avanzadas_span" style="display:none;" class="textogeneral"><a href="careportes.php?step=busqueda2&idtablareporteb1==&idtablareporteb2=<?=$numerodetabla?>&idregistroreporteb1==&idregistroreporteb2=<?=$id?>&moditobusqueda=especial&&titulobusqueda=Reportes de registro" class=textogeneral target=_blank>Accesos irregulares</a>&nbsp;|&nbsp;<a href="caseguimiento.php?step=busqueda2&tablaseguimientob1==&tablaseguimientob2=<?=$numerodetabla?>&registroseguimientob1==&registroseguimientob2=<?=$id?>&moditobusqueda=especial&titulobusqueda=Seguimiento de registro" class=textogeneral target=_blank>Seguimiento</a>&nbsp;|&nbsp;<a href="cahistorico.php?step=busqueda2&tablabusqueda=<?=$numerodetabla?>&registrobusqueda=<?=$id?>&modo=busqueda&moditobusqueda=especial&titulobusqueda=Histórico de registro" class=textogeneral target=_blank>Histórico</a></td></tr></table></span><? } ?>              
      <div align="right">
                <? if($ocultabotones<>1) { ?>	<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {?> <? $yabotonguardar="ya"; ?>
                <input class=textogeneral type="submit" name="Submit" value="<?=$ib_guardar?>" <?=$valordisabled?>><?} ?>
				<? if($step=="add" && $yabotonguardar<>"ya") { ?><input class=textogeneral type="submit" name="Submit" value="<?=$ib_guardar?>" <?=$valordisabled?>><? } ?><? } ?>
              </div>
            </td>
    </tr>
<? if($campopredeterminadotabla<>"" && isset($campopredeterminadotabla)) echo("<script>document.getElementById('".$campopredeterminadotabla."').focus();</script>"); ?>
	
    
	
	</form>
    
  </table>
  </div>
   <?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; ?>
  <?
 
  $menupeque=3;
include("include/imenu_peque.php");
?>
  
  </td>
     <? if($ocultabotones<>1) { ?> <? if($step=="modify") { ?><? } ?><? } ?>
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
 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="tra.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="irettra" selected>Iniciativa</option><option value="iusuariotra">Usuario</option><option value="fechatra">Fecha de alta</option><option value="importetra">Importe</option><option value="minimodonativotra">Mínimo donativo</option><option value="ganadorestra">Ganadores</option><option value="statustra">Status de pago</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('tra.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Iniciativa</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="irettral1" checked><? } ?><? if($nivelusuario==10) { ?><select name="irettrab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="irettrab2" onChange="if(irettrab1.selectedIndex==0) irettrab1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($irettra==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="iusuariotral1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iusuariotrab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuariotrab2" onChange="if(iusuariotrab1.selectedIndex==0) iusuariotrab1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariotra==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha de alta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="fechatral1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="fechatrab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechatrab2" value="" size="50" onKeyUp="revisainput('fechatrab1','fechatrab2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Importe</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="importetral1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="importetrab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="importetrab2" value="" size="15" onKeyUp="revisainput('importetrab1','importetrab2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Mínimo donativo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="minimodonativotral1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="minimodonativotrab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="minimodonativotrab2" value="" size="10" onKeyUp="revisainput('minimodonativotrab1','minimodonativotrab2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Ganadores</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="ganadorestral1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="ganadorestrab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ganadorestrab2" value="" size="10" onKeyUp="revisainput('ganadorestrab1','ganadorestrab2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Status de pago</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="statustral1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="statustrab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="statustrab2" onChange="if(statustrab1.selectedIndex==0) statustrab1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($statustra=="0") { ?>selected<? } ?> >Pendiente de pago</option><OPTION VALUE="1" <? if($statustra=="1") { ?>selected<? } ?> >Pagado</option><OPTION VALUE="2" <? if($statustra=="2") { ?>selected<? } ?> >Cancelado</option></select> <? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario==0 || $nivelusuario==1) {?>
	<tr>
      <td valign="middle" bgcolor="#<?=$vsitioscolor3?>"><?=$ib_activo?> <a href="javascript:muestraayuda('Activo. Seleccione SI para que el registro esté activo en el sitio web, de lo contrario seleccione NO');">(?)</a></td>
      <td valign="middle" bgcolor="#<?=$vsitioscolor3?>"> 
        <input name="activol1" type="checkbox">
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('tra.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0 || $nivelusuario==1) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/exceltra.php?step=busqueda2<?=$url_extra?>');">
<?} ?><? } ?></div>
      </td>
    </tr>
  </table></form></td><? if($ocultabotones<>1) { ?><? } ?>
     <td class="spacerlateral"></td>
    </tr>
  </table>
  

<?} ?>


<?php 
$menupeque=2;
include("include/imenu_peque.php");
 } ?>
<? if($step=="add" || $step=="modify")  { ?>

<script>
if (document.getElementsByTagName) {
var inputElements = document.getElementsByTagName("input");
for (i=0; inputElements[i]; i++) {

inputElements[i].setAttribute("autocomplete","off");

}//loop thru input elements
}//basic DOM-happiness-check
</script>

<? } ?>

<? if($step=="busqueda" || $step=="busqueda2" || $step=="busqueda3") { ?>

<? } ?>



</body>
</html>

