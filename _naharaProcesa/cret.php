<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_cret"]=1;
	$_SESSION["esframe_cret_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_cret_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_cret"]=0;
	$_SESSION["esframe_cret_id"]=0;
	$_SESSION["esframe_cret_archivo"]="";
}

$titulo_pagina="Extras de iniciativas";
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

$numerodetabla=7;
include("recursos/funciones_tabla.php"); 
$archivoactual="cret.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_cret"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==2)   {     if($tipocretl1=="on" || $labelcretl1=="on" || $i_labelcretl1=="on" || $mincretl1=="on" || $maxcretl1=="on" || $reqcretl1=="on" || $opcionescretl1=="on" || $i_opcionescretl1=="on") $error=9;     if(isset($tipocretb2) || isset($labelcretb2) || isset($i_labelcretb2) || isset($mincretb2) || isset($maxcretb2) || isset($reqcretb2) || isset($opcionescretb2) || isset($i_opcionescretb2)) $error=9;   }  if($nivelusuario==3)   {     if($tipocretl1=="on" || $labelcretl1=="on" || $i_labelcretl1=="on" || $mincretl1=="on" || $maxcretl1=="on" || $reqcretl1=="on" || $opcionescretl1=="on" || $i_opcionescretl1=="on") $error=9;     if(isset($tipocretb2) || isset($labelcretb2) || isset($i_labelcretb2) || isset($mincretb2) || isset($maxcretb2) || isset($reqcretb2) || isset($opcionescretb2) || isset($i_opcionescretb2)) $error=9;   }  if($nivelusuario==4)   {     if($tipocretl1=="on" || $labelcretl1=="on" || $i_labelcretl1=="on" || $mincretl1=="on" || $maxcretl1=="on" || $reqcretl1=="on" || $opcionescretl1=="on" || $i_opcionescretl1=="on") $error=9;     if(isset($tipocretb2) || isset($labelcretb2) || isset($i_labelcretb2) || isset($mincretb2) || isset($maxcretb2) || isset($reqcretb2) || isset($opcionescretb2) || isset($i_opcionescretb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["iretcret"])) $error=8;   if($nivelusuario==1) if(isset($_POST["iretcret"])) $error=8;   if($nivelusuario==2) if(isset($_POST["iretcret"]) || isset($_POST["tipocret"]) || isset($_POST["labelcret"]) || isset($_POST["i_labelcret"]) || isset($_POST["mincret"]) || isset($_POST["maxcret"]) || isset($_POST["reqcret"]) || isset($_POST["opcionescret"]) || isset($_POST["i_opcionescret"])) $error=8;   if($nivelusuario==3) if(isset($_POST["iretcret"]) || isset($_POST["tipocret"]) || isset($_POST["labelcret"]) || isset($_POST["i_labelcret"]) || isset($_POST["mincret"]) || isset($_POST["maxcret"]) || isset($_POST["reqcret"]) || isset($_POST["opcionescret"]) || isset($_POST["i_opcionescret"])) $error=8;   if($nivelusuario==4) if(isset($_POST["iretcret"]) || isset($_POST["tipocret"]) || isset($_POST["labelcret"]) || isset($_POST["i_labelcret"]) || isset($_POST["mincret"]) || isset($_POST["maxcret"]) || isset($_POST["reqcret"]) || isset($_POST["opcionescret"]) || isset($_POST["i_opcionescret"])) $error=8; }if($operacion=="add") {   if($nivelusuario==2) if(isset($_POST["tipocret"]) || isset($_POST["labelcret"]) || isset($_POST["i_labelcret"]) || isset($_POST["mincret"]) || isset($_POST["maxcret"]) || isset($_POST["reqcret"]) || isset($_POST["opcionescret"]) || isset($_POST["i_opcionescret"])) $error=7;   if($nivelusuario==3) if(isset($_POST["tipocret"]) || isset($_POST["labelcret"]) || isset($_POST["i_labelcret"]) || isset($_POST["mincret"]) || isset($_POST["maxcret"]) || isset($_POST["reqcret"]) || isset($_POST["opcionescret"]) || isset($_POST["i_opcionescret"])) $error=7;   if($nivelusuario==4) if(isset($_POST["tipocret"]) || isset($_POST["labelcret"]) || isset($_POST["i_labelcret"]) || isset($_POST["mincret"]) || isset($_POST["maxcret"]) || isset($_POST["reqcret"]) || isset($_POST["opcionescret"]) || isset($_POST["i_opcionescret"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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


<?if($_SESSION["esframe_cret"]==1){  if($_SESSION["esframe_cret_archivo"]=="ret")  {    if($step=="add")    {      $iretcret=$_SESSION["id_ret"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $iretcretb1="=";      $iretcretb2=$_SESSION["id_ret"];    }  }}?>


<head>

<title><? echo("Extras de iniciativas"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


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
    if($_SESSION["esframe_cret"]<>1)
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
  if(isset($_POST["mincret"])) $_POST["mincret"]=limpia_numero($_POST["mincret"]);if(isset($_POST["maxcret"])) $_POST["maxcret"]=limpia_numero($_POST["maxcret"]);
  
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
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM cret where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("iretcret","",0);$sqltemporal.=construyesqltemporal("tipocret","'",0);$sqltemporal.=construyesqltemporal("labelcret","'",0);$sqltemporal.=construyesqltemporal("i_labelcret","'",0);$sqltemporal.=construyesqltemporal("mincret","",2);$sqltemporal.=construyesqltemporal("maxcret","",2);$sqltemporal.=construyesqltemporal("reqcret","'",0);$sqltemporal.=construyesqltemporal("opcionescret","'",0);$sqltemporal.=construyesqltemporal("i_opcionescret","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
	   if($nivelusuario==0 || $nivelusuario==2) {	
      	
		  $sql = "INSERT INTO cret SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=7,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_cret"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_cret"]="OK";
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
	   if($nivelusuario==0 || $nivelusuario==2 || $nivelusuario==10) {	      
		  $sql = "UPDATE cret SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=7,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM cret where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["iretcret"]<>$rown["iretcret"]) $cadena_historico.="Iniciativa:\r\n O:".$rowh["iretcret"]."\r\nN: ".$rown["iretcret"]."\r\n\r\n";               if($rowh["tipocret"]<>$rown["tipocret"]) $cadena_historico.="Tipo:\r\n O:".$rowh["tipocret"]."\r\nN: ".$rown["tipocret"]."\r\n\r\n";               if($rowh["labelcret"]<>$rown["labelcret"]) $cadena_historico.="Etiqueta:\r\n O:".$rowh["labelcret"]."\r\nN: ".$rown["labelcret"]."\r\n\r\n";               if($rowh["i_labelcret"]<>$rown["i_labelcret"]) $cadena_historico.="Etiqueta en inglés:\r\n O:".$rowh["i_labelcret"]."\r\nN: ".$rown["i_labelcret"]."\r\n\r\n";               if($rowh["mincret"]<>$rown["mincret"]) $cadena_historico.="Valor mínimo:\r\n O:".$rowh["mincret"]."\r\nN: ".$rown["mincret"]."\r\n\r\n";               if($rowh["maxcret"]<>$rown["maxcret"]) $cadena_historico.="Valor máximo:\r\n O:".$rowh["maxcret"]."\r\nN: ".$rown["maxcret"]."\r\n\r\n";               if($rowh["reqcret"]<>$rown["reqcret"]) $cadena_historico.="Requerido:\r\n O:".$rowh["reqcret"]."\r\nN: ".$rown["reqcret"]."\r\n\r\n";               if($rowh["opcionescret"]<>$rown["opcionescret"]) $cadena_historico.="Opciones (una por línea):\r\n O:".$rowh["opcionescret"]."\r\nN: ".$rown["opcionescret"]."\r\n\r\n";               if($rowh["i_opcionescret"]<>$rown["i_opcionescret"]) $cadena_historico.="Opciones en inglés:\r\n O:".$rowh["i_opcionescret"]."\r\nN: ".$rown["i_opcionescret"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_cret"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_cret"]="NADA";
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
		$sql = "DELETE FROM cret WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=7,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_cret"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,iretcret FROM cret where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["iretcret"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=cret.php?step=1".$url_extra."><span class=titulo>Extras de iniciativas</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) $botones.="<td><a href=cret.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Extras de iniciativas\"></a></td>";if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=cret.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Extras de iniciativas\"></a></td>";if(($nivelusuario==0)) $botones.="<td><a href=\"cret.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Extras de iniciativas\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_cret"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_cret"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_cret"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_cret"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="cret.activo DESC,iretcret ASC"; $ordenamiento="";$activob1="="; $activob2="1";$iretcretl1="on"; $tipocretl1="on"; $labelcretl1="on"; $i_labelcretl1="on"; } $camposbuscadoslistadosearch="cret.id";cbusqueda1($activol1,"cret","activo");cbusqueda1($iretcretl1,"ret","nombreret","0","","");cbusqueda1($tipocretl1,"cret","tipocret");cbusqueda1($labelcretl1,"cret","labelcret");cbusqueda1($i_labelcretl1,"cret","i_labelcret");cbusqueda1($mincretl1,"cret","mincret");cbusqueda1($maxcretl1,"cret","maxcret");cbusqueda1($reqcretl1,"cret","reqcret");cbusqueda1($opcionescretl1,"cret","opcionescret");cbusqueda1($i_opcionescretl1,"cret","i_opcionescret");cbusqueda2($iretcretl1,"ret","cret","iretcret","",0,"id");cbusqueda3($iretcretb1,$iretcretb2,"cret","iretcret","","0","","");cbusqueda3($tipocretb1,$tipocretb2,"cret","tipocret","'","0","","");cbusqueda3($labelcretb1,$labelcretb2,"cret","labelcret","'","0","","");cbusqueda3($i_labelcretb1,$i_labelcretb2,"cret","i_labelcret","'","0","","");cbusqueda3($mincretb1,$mincretb2,"cret","mincret","","0","","");cbusqueda3($maxcretb1,$maxcretb2,"cret","maxcret","","0","","");cbusqueda3($reqcretb1,$reqcretb2,"cret","reqcret","'","0","","");cbusqueda3($opcionescretb1,$opcionescretb2,"cret","opcionescret","'","0","","");cbusqueda3($i_opcionescretb1,$i_opcionescretb2,"cret","i_opcionescret","'","0","","");cbusqueda3($activob1,$activob2,"cret","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from cret ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($iretcretl1,"Iniciativa",": STR","");cbusqueda5($tipocretl1,"Tipo",": STR","");cbusqueda5($labelcretl1,"Etiqueta",": STR","");cbusqueda5($i_labelcretl1,"Etiqueta en inglés",": STR","");cbusqueda5($mincretl1,"Valor mínimo"," : NUM","");cbusqueda5($maxcretl1,"Valor máximo"," : NUM","");cbusqueda5($reqcretl1,"Requerido",": STR","");cbusqueda5($opcionescretl1,"Opciones (una por línea)",": STR","");cbusqueda5($i_opcionescretl1,"Opciones en inglés",": STR",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='cret.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($iretcretl1,"ret","nombreret","0","",""); if($tipocretl1=="on")  {  if($row["tipocret"]=="1") $tempotipocret="Entero";if($row["tipocret"]=="2") $tempotipocret="Flotante";if($row["tipocret"]=="3") $tempotipocret="Texto (max 100 letras)";if($row["tipocret"]=="4") $tempotipocret="Opciones";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempotipocret.$tempotigra."\""; $tempotigra="";  } cbusqueda4($labelcretl1,"cret","labelcret","0","","");cbusqueda4($i_labelcretl1,"cret","i_labelcret","0","","");cbusqueda4($mincretl1,"cret","mincret","0","","");cbusqueda4($maxcretl1,"cret","maxcret","0","",""); if($reqcretl1=="on")  {  if($row["reqcret"]=="0") $temporeqcret="NO";if($row["reqcret"]=="1") $temporeqcret="SI";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$temporeqcret.$tempotigra."\""; $tempotigra="";  } cbusqueda4($opcionescretl1,"cret","opcionescret","0","","");cbusqueda4($i_opcionescretl1,"cret","i_opcionescret","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($iretcretl1,$sumatoriairetcret,'');cbusqueda6($tipocretl1,$sumatoriatipocret,'');cbusqueda6($labelcretl1,$sumatorialabelcret,'');cbusqueda6($i_labelcretl1,$sumatoriai_labelcret,'');cbusqueda6($mincretl1,$sumatoriamincret,'');cbusqueda6($maxcretl1,$sumatoriamaxcret,'');cbusqueda6($reqcretl1,$sumatoriareqcret,'');cbusqueda6($opcionescretl1,$sumatoriaopcionescret,'');cbusqueda6($i_opcionescretl1,$sumatoriai_opcionescret,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelcret.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=iretcretl1 type="hidden" value="<?=$iretcretl1?>" ><input name=iretcretb1 type="hidden" value="<?=$iretcretb1?>" ><input name=iretcretb2 type="hidden" value="<?=$iretcretb2?>" ><input name=tipocretl1 type="hidden" value="<?=$tipocretl1?>" ><input name=tipocretb1 type="hidden" value="<?=$tipocretb1?>" ><input name=tipocretb2 type="hidden" value="<?=$tipocretb2?>" ><input name=labelcretl1 type="hidden" value="<?=$labelcretl1?>" ><input name=labelcretb1 type="hidden" value="<?=$labelcretb1?>" ><input name=labelcretb2 type="hidden" value="<?=$labelcretb2?>" ><input name=i_labelcretl1 type="hidden" value="<?=$i_labelcretl1?>" ><input name=i_labelcretb1 type="hidden" value="<?=$i_labelcretb1?>" ><input name=i_labelcretb2 type="hidden" value="<?=$i_labelcretb2?>" ><input name=mincretl1 type="hidden" value="<?=$mincretl1?>" ><input name=mincretb1 type="hidden" value="<?=$mincretb1?>" ><input name=mincretb2 type="hidden" value="<?=$mincretb2?>" ><input name=maxcretl1 type="hidden" value="<?=$maxcretl1?>" ><input name=maxcretb1 type="hidden" value="<?=$maxcretb1?>" ><input name=maxcretb2 type="hidden" value="<?=$maxcretb2?>" ><input name=reqcretl1 type="hidden" value="<?=$reqcretl1?>" ><input name=reqcretb1 type="hidden" value="<?=$reqcretb1?>" ><input name=reqcretb2 type="hidden" value="<?=$reqcretb2?>" ><input name=opcionescretl1 type="hidden" value="<?=$opcionescretl1?>" ><input name=opcionescretb1 type="hidden" value="<?=$opcionescretb1?>" ><input name=opcionescretb2 type="hidden" value="<?=$opcionescretb2?>" ><input name=i_opcionescretl1 type="hidden" value="<?=$i_opcionescretl1?>" ><input name=i_opcionescretb1 type="hidden" value="<?=$i_opcionescretb1?>" ><input name=i_opcionescretb2 type="hidden" value="<?=$i_opcionescretb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcret.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
if(isset($_GET["iretcret"])) $iretcret=$_GET["iretcret"];	
if($error_unique==0)
{
$tipocret='1';$labelcret='';$i_labelcret='';$mincret=0;$maxcret=0;$reqcret='';$opcionescret='';$i_opcionescret='';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["iretcret"])) $iretcret=$_POST["iretcret"];if(isset($_POST["tipocret"])) $tipocret=$_POST["tipocret"];if(isset($_POST["labelcret"])) $labelcret=$_POST["labelcret"];if(isset($_POST["i_labelcret"])) $i_labelcret=$_POST["i_labelcret"];if(isset($_POST["mincret"])) $mincret=$_POST["mincret"];if(isset($_POST["maxcret"])) $maxcret=$_POST["maxcret"];if(isset($_POST["reqcret"])) $reqcret=$_POST["reqcret"];if(isset($_POST["opcionescret"])) $opcionescret=$_POST["opcionescret"];if(isset($_POST["i_opcionescret"])) $i_opcionescret=$_POST["i_opcionescret"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM cret where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM cret where id=". $id);
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
$iretcret=$row["iretcret"];$tipocret=$row["tipocret"];$labelcret=$row["labelcret"];$i_labelcret=$row["i_labelcret"];$mincret=$row["mincret"];$maxcret=$row["maxcret"];$reqcret=$row["reqcret"];$opcionescret=$row["opcionescret"];$i_opcionescret=$row["i_opcionescret"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="cret.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('cret.php?sortfield=iretcret&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
				          <? } ?>

<? if($nivelusuario==0 || $nivelusuario==2 || $nivelusuario==10) {?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iretcret" name="t_iretcret">Iniciativa * </td><td valign="middle"><? if(($nivelusuario==10) && $step<>"add") { ?><select name="iretcret" id="iretcret"  class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iretcret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 ) || $step=="add") { ?><? $valor_mostrar=lee_registro("ret","nombreret","","",$iretcret,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");if($step=="add") echo("<input type=hidden name=iretcret value=".$iretcret.">");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tipocret" name="t_tipocret">Tipo * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="tipocret" id="tipocret" class=textogeneralform><OPTION VALUE="1" <? if($tipocret=="1") echo("selected");?> >Entero</option><OPTION VALUE="2" <? if($tipocret=="2") echo("selected");?> >Flotante</option><OPTION VALUE="3" <? if($tipocret=="3") echo("selected");?> >Texto (max 100 letras)</option><OPTION VALUE="4" <? if($tipocret=="4") echo("selected");?> >Opciones</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($tipocret=="1") echo("Entero");if($tipocret=="2") echo("Flotante");if($tipocret=="3") echo("Texto (max 100 letras)");if($tipocret=="4") echo("Opciones"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_labelcret" name="t_labelcret">Etiqueta * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="labelcret" id="labelcret" value="<? echo(htmlspecialchars($labelcret,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$labelcret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_labelcret" name="t_i_labelcret">Etiqueta en inglés </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="i_labelcret" id="i_labelcret" value="<? echo(htmlspecialchars($i_labelcret,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$i_labelcret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_mincret" name="t_mincret">Valor mínimo </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="mincret" id="mincret" value="<? echo(formato_numero($mincret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('mincret')" onBlur="pone_pesos('mincret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($mincret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_maxcret" name="t_maxcret">Valor máximo </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="maxcret" id="maxcret" value="<? echo(formato_numero($maxcret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('maxcret')" onBlur="pone_pesos('maxcret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($maxcret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_reqcret" name="t_reqcret">Requerido </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="reqcret" id="reqcret" class=textogeneralform><OPTION VALUE="0" <? if($reqcret=="0") echo("selected");?> >NO</option><OPTION VALUE="1" <? if($reqcret=="1") echo("selected");?> >SI</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($reqcret=="0") echo("NO");if($reqcret=="1") echo("SI"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_opcionescret" name="t_opcionescret">Opciones (una por línea) </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="opcionescret" id="opcionescret" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($opcionescret,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10)) { ?><?=$opcionescret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_i_opcionescret" name="t_i_opcionescret">Opciones en inglés </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="i_opcionescret" id="i_opcionescret" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($i_opcionescret,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10)) { ?><?=$i_opcionescret?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10) && $step<>"add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iretcret':{'l':'Iniciativa','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iretcret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tipocret':{'l':'Tipo','r': true,'t':'t_tipocret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'labelcret':{'l':'Etiqueta','r': true,'t':'t_labelcret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'mincret':{'l':'Valor mínimo','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_mincret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'maxcret':{'l':'Valor máximo','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_maxcret'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
	var v = new validator('form1', a_fields, o_config);</script>  
    <? if($nivelusuario==0) {?>
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
                <? if($ocultabotones<>1) { ?>	<? if($nivelusuario==0 || $nivelusuario==2 || $nivelusuario==10) {?> <? $yabotonguardar="ya"; ?>
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
      <td width=100%  valign=top><form name="form2" method="post" action="cret.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="iretcret" selected>Iniciativa</option><option value="tipocret">Tipo</option><option value="labelcret">Etiqueta</option><option value="i_labelcret">Etiqueta en inglés</option><option value="mincret">Valor mínimo</option><option value="maxcret">Valor máximo</option><option value="reqcret">Requerido</option><option value="opcionescret">Opciones (una por línea)</option><option value="i_opcionescret">Opciones en inglés</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('cret.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Iniciativa</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="iretcretl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iretcretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iretcretb2" onChange="if(iretcretb1.selectedIndex==0) iretcretb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iretcret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Tipo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="tipocretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="tipocretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="tipocretb2" onChange="if(tipocretb1.selectedIndex==0) tipocretb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="1" <? if($tipocret=="1") { ?>selected<? } ?> >Entero</option><OPTION VALUE="2" <? if($tipocret=="2") { ?>selected<? } ?> >Flotante</option><OPTION VALUE="3" <? if($tipocret=="3") { ?>selected<? } ?> >Texto (max 100 letras)</option><OPTION VALUE="4" <? if($tipocret=="4") { ?>selected<? } ?> >Opciones</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Etiqueta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="labelcretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="labelcretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="labelcretb2" value="" size="55" onKeyUp="revisainput('labelcretb1','labelcretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Etiqueta en inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="i_labelcretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="i_labelcretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_labelcretb2" value="" size="55" onKeyUp="revisainput('i_labelcretb1','i_labelcretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Valor mínimo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="mincretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="mincretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="mincretb2" value="" size="10" onKeyUp="revisainput('mincretb1','mincretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Valor máximo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="maxcretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="maxcretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="maxcretb2" value="" size="10" onKeyUp="revisainput('maxcretb1','maxcretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Requerido</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="reqcretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="reqcretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="reqcretb2" onChange="if(reqcretb1.selectedIndex==0) reqcretb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($reqcret=="0") { ?>selected<? } ?> >NO</option><OPTION VALUE="1" <? if($reqcret=="1") { ?>selected<? } ?> >SI</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Opciones (una por línea)</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="opcionescretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="opcionescretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="opcionescretb2" value="" size="50" onKeyUp="revisainput('opcionescretb1','opcionescretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Opciones en inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="i_opcionescretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="i_opcionescretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_opcionescretb2" value="" size="50" onKeyUp="revisainput('i_opcionescretb1','i_opcionescretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario==0) {?>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('cret.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0 || $nivelusuario==1) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelcret.php?step=busqueda2<?=$url_extra?>');">
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

