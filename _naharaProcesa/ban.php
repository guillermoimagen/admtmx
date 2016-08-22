<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_ban"]=1;
	$_SESSION["esframe_ban_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_ban_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_ban"]=0;
	$_SESSION["esframe_ban_id"]=0;
	$_SESSION["esframe_ban_archivo"]="";
}

$titulo_pagina="Banners";
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

$numerodetabla=12;
include("recursos/funciones_tabla.php"); 
$archivoactual="ban.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_ban"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if(isset($nombrebanb2) || isset($iniciobanb2) || isset($finbanb2) || isset($tipobanb2) || isset($imagenbanb2) || isset($i_imagenbanb2) || isset($textobanb2) || isset($i_textobanb2) || isset($urlbanb2) || isset($i_urlbanb2) || isset($targetbanb2) || isset($ordenbanb2)) $error=9;   }  if($nivelusuario==2)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if(isset($nombrebanb2) || isset($iniciobanb2) || isset($finbanb2) || isset($tipobanb2) || isset($imagenbanb2) || isset($i_imagenbanb2) || isset($textobanb2) || isset($i_textobanb2) || isset($urlbanb2) || isset($i_urlbanb2) || isset($targetbanb2) || isset($ordenbanb2)) $error=9;   }  if($nivelusuario==3)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if(isset($nombrebanb2) || isset($iniciobanb2) || isset($finbanb2) || isset($tipobanb2) || isset($imagenbanb2) || isset($i_imagenbanb2) || isset($textobanb2) || isset($i_textobanb2) || isset($urlbanb2) || isset($i_urlbanb2) || isset($targetbanb2) || isset($ordenbanb2)) $error=9;   }  if($nivelusuario==4)   {     if($nombrebanl1=="on" || $iniciobanl1=="on" || $finbanl1=="on" || $tipobanl1=="on" || $imagenbanl1=="on" || $i_imagenbanl1=="on" || $textobanl1=="on" || $i_textobanl1=="on" || $urlbanl1=="on" || $i_urlbanl1=="on" || $targetbanl1=="on" || $ordenbanl1=="on") $error=9;     if(isset($nombrebanb2) || isset($iniciobanb2) || isset($finbanb2) || isset($tipobanb2) || isset($imagenbanb2) || isset($i_imagenbanb2) || isset($textobanb2) || isset($i_textobanb2) || isset($urlbanb2) || isset($i_urlbanb2) || isset($targetbanb2) || isset($ordenbanb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==1) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=8;   if($nivelusuario==2) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=8;   if($nivelusuario==3) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=8;   if($nivelusuario==4) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=8; }if($operacion=="add") {   if($nivelusuario==1) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=7;   if($nivelusuario==2) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=7;   if($nivelusuario==3) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=7;   if($nivelusuario==4) if(isset($_POST["nombreban"]) || isset($_POST["inicioban"]) || isset($_POST["finban"]) || isset($_POST["tipoban"]) || isset($_POST["imagenban"]) || isset($_POST["i_imagenban"]) || isset($_POST["textoban"]) || isset($_POST["i_textoban"]) || isset($_POST["urlban"]) || isset($_POST["i_urlban"]) || isset($_POST["targetban"]) || isset($_POST["ordenban"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
<script language="JavaScript" src="../include/funcionescolapsos.js"></script>  
<script>function muestracabezaseditar() { } </script>
<?
  if($step=="add") // ESTE ES NECESARIO POR SI ESTA PROHIBIDO AGREGAR PARA QUE NO SE MUESTRE NI SIQUIERA EL FORMULARIO
  {
	 if($nivelusuario==0) {    
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
	<? if($nivelusuario==0 || $nivelusuario==10) {?> 
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

<title><? echo("Banners"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


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
    if($_SESSION["esframe_ban"]<>1)
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
  if(isset($_POST["ordenban"])) $_POST["ordenban"]=limpia_numero($_POST["ordenban"]);
  
  if($operacion=="modify" || $operacion=="add") 
  {
	if($operacion=="add") 
	{
	   if($nivelusuario==0) {
      	
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
       if($nivelusuario==0 || $nivelusuario==10) {
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM ban where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("nombreban","'",0);$sqltemporal.=construyesqltemporal("inicioban","'",0);$sqltemporal.=construyesqltemporal("finban","'",0);$sqltemporal.=construyesqltemporal("tipoban","'",0);$sqltemporal.=construyesqltemporal("imagenban","'",0);$sqltemporal.=construyesqltemporal("i_imagenban","'",0);$sqltemporal.=construyesqltemporal("textoban","'",0);$sqltemporal.=construyesqltemporal("i_textoban","'",0);$sqltemporal.=construyesqltemporal("urlban","'",0);$sqltemporal.=construyesqltemporal("i_urlban","'",0);$sqltemporal.=construyesqltemporal("targetban","'",0);$sqltemporal.=construyesqltemporal("ordenban","",2);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
	   if($nivelusuario==0) {	
      	
		  $sql = "INSERT INTO ban SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=12,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_ban"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_ban"]="OK";
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
	   if($nivelusuario==0 || $nivelusuario==10) {	      
		  $sql = "UPDATE ban SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=12,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM ban where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["nombreban"]<>$rown["nombreban"]) $cadena_historico.="Nombre:\r\n O:".$rowh["nombreban"]."\r\nN: ".$rown["nombreban"]."\r\n\r\n";               if($rowh["inicioban"]<>$rown["inicioban"]) $cadena_historico.="Inicio:\r\n O:".$rowh["inicioban"]."\r\nN: ".$rown["inicioban"]."\r\n\r\n";               if($rowh["finban"]<>$rown["finban"]) $cadena_historico.="Fin:\r\n O:".$rowh["finban"]."\r\nN: ".$rown["finban"]."\r\n\r\n";               if($rowh["imagenban"]<>$rown["imagenban"]) $cadena_historico.="Imagen:\r\n O:".$rowh["imagenban"]."\r\nN: ".$rown["imagenban"]."\r\n\r\n";               if($rowh["textoban"]<>$rown["textoban"]) $cadena_historico.="Texto:\r\n O:".$rowh["textoban"]."\r\nN: ".$rown["textoban"]."\r\n\r\n";               if($rowh["i_textoban"]<>$rown["i_textoban"]) $cadena_historico.="Texto inglés:\r\n O:".$rowh["i_textoban"]."\r\nN: ".$rown["i_textoban"]."\r\n\r\n";               if($rowh["urlban"]<>$rown["urlban"]) $cadena_historico.="URL:\r\n O:".$rowh["urlban"]."\r\nN: ".$rown["urlban"]."\r\n\r\n";               if($rowh["i_urlban"]<>$rown["i_urlban"]) $cadena_historico.="URL inglés:\r\n O:".$rowh["i_urlban"]."\r\nN: ".$rown["i_urlban"]."\r\n\r\n";               if($rowh["targetban"]<>$rown["targetban"]) $cadena_historico.="Target:\r\n O:".$rowh["targetban"]."\r\nN: ".$rown["targetban"]."\r\n\r\n";               if($rowh["ordenban"]<>$rown["ordenban"]) $cadena_historico.="Orden:\r\n O:".$rowh["ordenban"]."\r\nN: ".$rown["ordenban"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_ban"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_ban"]="NADA";
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
		$sql = "DELETE FROM ban WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=12,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_ban"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,nombreban FROM ban where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["nombreban"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=ban.php?step=1".$url_extra."><span class=titulo>Banners</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0) $botones.="<td><a href=ban.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Banners\"></a></td>";if($nivelusuario==0) $botones.="<td><a href=ban.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Banners\"></a></td>";if(($nivelusuario==0)) $botones.="<td><a href=\"ban.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Banners\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_ban"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_ban"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_ban"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_ban"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="ban.activo DESC,nombreban ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombrebanl1="on"; $iniciobanl1="on"; $finbanl1="on"; $tipobanl1="on"; $imagenbanl1="on"; } $camposbuscadoslistadosearch="ban.id";cbusqueda1($activol1,"ban","activo");cbusqueda1($nombrebanl1,"ban","nombreban");cbusqueda1($iniciobanl1,"ban","inicioban");cbusqueda1($finbanl1,"ban","finban");cbusqueda1($tipobanl1,"ban","tipoban");cbusqueda1($imagenbanl1,"ban","imagenban");cbusqueda1($i_imagenbanl1,"ban","i_imagenban");cbusqueda1($textobanl1,"ban","textoban");cbusqueda1($i_textobanl1,"ban","i_textoban");cbusqueda1($urlbanl1,"ban","urlban");cbusqueda1($i_urlbanl1,"ban","i_urlban");cbusqueda1($targetbanl1,"ban","targetban");cbusqueda1($ordenbanl1,"ban","ordenban");cbusqueda3($nombrebanb1,$nombrebanb2,"ban","nombreban","'","0","","");cbusqueda3($iniciobanb1,$iniciobanb2,"ban","inicioban","'","0","","");cbusqueda3($finbanb1,$finbanb2,"ban","finban","'","0","","");cbusqueda3($tipobanb1,$tipobanb2,"ban","tipoban","'","0","","");cbusqueda3($imagenbanb1,$imagenbanb2,"ban","imagenban","'","0","","");cbusqueda3($i_imagenbanb1,$i_imagenbanb2,"ban","i_imagenban","'","0","","");cbusqueda3($textobanb1,$textobanb2,"ban","textoban","'","0","","");cbusqueda3($i_textobanb1,$i_textobanb2,"ban","i_textoban","'","0","","");cbusqueda3($urlbanb1,$urlbanb2,"ban","urlban","'","0","","");cbusqueda3($i_urlbanb1,$i_urlbanb2,"ban","i_urlban","'","0","","");cbusqueda3($targetbanb1,$targetbanb2,"ban","targetban","'","0","","");cbusqueda3($ordenbanb1,$ordenbanb2,"ban","ordenban","","0","","");cbusqueda3($activob1,$activob2,"ban","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from ban ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($nombrebanl1,"Nombre",": STR","");cbusqueda5($iniciobanl1,"Inicio"," : DATE","");cbusqueda5($finbanl1,"Fin"," : DATE","");cbusqueda5($tipobanl1,"Tipo",": STR","");cbusqueda5($imagenbanl1,"Imagen",": STR","");cbusqueda5($i_imagenbanl1,"Imagen inglés",": STR","");cbusqueda5($textobanl1,"Texto",": STR","");cbusqueda5($i_textobanl1,"Texto inglés",": STR","");cbusqueda5($urlbanl1,"URL",": STR","");cbusqueda5($i_urlbanl1,"URL inglés",": STR","");cbusqueda5($targetbanl1,"Target",": STR","");cbusqueda5($ordenbanl1,"Orden"," : NUM",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='ban.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($nombrebanl1,"ban","nombreban","0","","");cbusqueda4($iniciobanl1,"ban","inicioban","0","","");cbusqueda4($finbanl1,"ban","finban","0","",""); if($tipobanl1=="on")  {  if($row["tipoban"]=="0") $tempotipoban="Normal";if($row["tipoban"]=="1") $tempotipoban="Derecho";if($row["tipoban"]=="2") $tempotipoban="Abajo";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempotipoban.$tempotigra."\""; $tempotigra="";  } cbusqueda4($imagenbanl1,"ban","imagenban","0","","");cbusqueda4($i_imagenbanl1,"ban","i_imagenban","0","","");cbusqueda4($textobanl1,"ban","textoban","0","","");cbusqueda4($i_textobanl1,"ban","i_textoban","0","","");cbusqueda4($urlbanl1,"ban","urlban","0","","");cbusqueda4($i_urlbanl1,"ban","i_urlban","0","",""); if($targetbanl1=="on")  {  if($row["targetban"]=="_self") $tempotargetban="_self";if($row["targetban"]=="_blank") $tempotargetban="_blank";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempotargetban.$tempotigra."\""; $tempotigra="";  } cbusqueda4($ordenbanl1,"ban","ordenban","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($nombrebanl1,$sumatorianombreban,'');cbusqueda6($iniciobanl1,$sumatoriainicioban,'');cbusqueda6($finbanl1,$sumatoriafinban,'');cbusqueda6($tipobanl1,$sumatoriatipoban,'');cbusqueda6($imagenbanl1,$sumatoriaimagenban,'');cbusqueda6($i_imagenbanl1,$sumatoriai_imagenban,'');cbusqueda6($textobanl1,$sumatoriatextoban,'');cbusqueda6($i_textobanl1,$sumatoriai_textoban,'');cbusqueda6($urlbanl1,$sumatoriaurlban,'');cbusqueda6($i_urlbanl1,$sumatoriai_urlban,'');cbusqueda6($targetbanl1,$sumatoriatargetban,'');cbusqueda6($ordenbanl1,$sumatoriaordenban,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelban.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=nombrebanl1 type="hidden" value="<?=$nombrebanl1?>" ><input name=nombrebanb1 type="hidden" value="<?=$nombrebanb1?>" ><input name=nombrebanb2 type="hidden" value="<?=$nombrebanb2?>" ><input name=iniciobanl1 type="hidden" value="<?=$iniciobanl1?>" ><input name=iniciobanb1 type="hidden" value="<?=$iniciobanb1?>" ><input name=iniciobanb2 type="hidden" value="<?=$iniciobanb2?>" ><input name=finbanl1 type="hidden" value="<?=$finbanl1?>" ><input name=finbanb1 type="hidden" value="<?=$finbanb1?>" ><input name=finbanb2 type="hidden" value="<?=$finbanb2?>" ><input name=tipobanl1 type="hidden" value="<?=$tipobanl1?>" ><input name=tipobanb1 type="hidden" value="<?=$tipobanb1?>" ><input name=tipobanb2 type="hidden" value="<?=$tipobanb2?>" ><input name=imagenbanl1 type="hidden" value="<?=$imagenbanl1?>" ><input name=imagenbanb1 type="hidden" value="<?=$imagenbanb1?>" ><input name=imagenbanb2 type="hidden" value="<?=$imagenbanb2?>" ><input name=i_imagenbanl1 type="hidden" value="<?=$i_imagenbanl1?>" ><input name=i_imagenbanb1 type="hidden" value="<?=$i_imagenbanb1?>" ><input name=i_imagenbanb2 type="hidden" value="<?=$i_imagenbanb2?>" ><input name=textobanl1 type="hidden" value="<?=$textobanl1?>" ><input name=textobanb1 type="hidden" value="<?=$textobanb1?>" ><input name=textobanb2 type="hidden" value="<?=$textobanb2?>" ><input name=i_textobanl1 type="hidden" value="<?=$i_textobanl1?>" ><input name=i_textobanb1 type="hidden" value="<?=$i_textobanb1?>" ><input name=i_textobanb2 type="hidden" value="<?=$i_textobanb2?>" ><input name=urlbanl1 type="hidden" value="<?=$urlbanl1?>" ><input name=urlbanb1 type="hidden" value="<?=$urlbanb1?>" ><input name=urlbanb2 type="hidden" value="<?=$urlbanb2?>" ><input name=i_urlbanl1 type="hidden" value="<?=$i_urlbanl1?>" ><input name=i_urlbanb1 type="hidden" value="<?=$i_urlbanb1?>" ><input name=i_urlbanb2 type="hidden" value="<?=$i_urlbanb2?>" ><input name=targetbanl1 type="hidden" value="<?=$targetbanl1?>" ><input name=targetbanb1 type="hidden" value="<?=$targetbanb1?>" ><input name=targetbanb2 type="hidden" value="<?=$targetbanb2?>" ><input name=ordenbanl1 type="hidden" value="<?=$ordenbanl1?>" ><input name=ordenbanb1 type="hidden" value="<?=$ordenbanb1?>" ><input name=ordenbanb2 type="hidden" value="<?=$ordenbanb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelban.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
   <? } ?>
</table>
 </td> <td class="spacerlateral"></td></tr>
</table>
<?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; $boton_fotos=1;?>
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
var HINTS_ITEMS = {'inicioban':wrap("aaaa-mm-dd, 2008-11-18"),'finban':wrap("aaaa-mm-dd, 2008-11-18"),'activo':wrap("Seleccion SI para que el registro esté activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  <script>var directorio='../include';</script><script language="JavaScript" src="../include/calendar/calendar.js"></script><link rel="stylesheet" href="../include/calendar/calendar.css">
	<?
	
if($error_unique==0)
{
$nombreban='';$fecha=date("Y-m-d"); $inicioban=substr($fecha, 0, 4)."-".substr($fecha, 5, 2)."-".substr($fecha, 8, 2);$fecha=date("Y-m-d"); $finban=substr($fecha, 0, 4)."-".substr($fecha, 5, 2)."-".substr($fecha, 8, 2);$tipoban='0';$imagenban='';$i_imagenban='';$textoban='';$i_textoban='';$urlban='';$i_urlban='';$targetban='_self';$ordenban=0;$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["nombreban"])) $nombreban=$_POST["nombreban"];if(isset($_POST["inicioban"])) $inicioban=$_POST["inicioban"];if(isset($_POST["finban"])) $finban=$_POST["finban"];if(isset($_POST["tipoban"])) $tipoban=$_POST["tipoban"];if(isset($_POST["imagenban"])) $imagenban=$_POST["imagenban"];if(isset($_POST["i_imagenban"])) $i_imagenban=$_POST["i_imagenban"];if(isset($_POST["textoban"])) $textoban=$_POST["textoban"];if(isset($_POST["i_textoban"])) $i_textoban=$_POST["i_textoban"];if(isset($_POST["urlban"])) $urlban=$_POST["urlban"];if(isset($_POST["i_urlban"])) $i_urlban=$_POST["i_urlban"];if(isset($_POST["targetban"])) $targetban=$_POST["targetban"];if(isset($_POST["ordenban"])) $ordenban=$_POST["ordenban"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM ban where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM ban where id=". $id);
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
$nombreban=$row["nombreban"];$inicioban=$row["inicioban"];if($inicioban=="0000-00-00") $inicioban="";$finban=$row["finban"];if($finban=="0000-00-00") $finban="";$tipoban=$row["tipoban"];$imagenban=$row["imagenban"];$i_imagenban=$row["i_imagenban"];$textoban=$row["textoban"];$i_textoban=$row["i_textoban"];$urlban=$row["urlban"];$i_urlban=$row["i_urlban"];$targetban=$row["targetban"];$ordenban=$row["ordenban"];
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
       <?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; $boton_fotos=1;?>
      <?
     
       $menupeque=1;
		include("include/imenu_peque.php");
      
      ?>
      <div id="formulario" name="formulario">
	  
	  <table border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="left">
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="ban.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('ban.php?sortfield=nombreban&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
				          <? } ?>

<? if($nivelusuario==0 || $nivelusuario==10) {?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nombreban" name="t_nombreban">Nombre * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="nombreban" id="nombreban" value="<? echo(htmlspecialchars($nombreban,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$nombreban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_inicioban" name="t_inicioban">Inicio * <a onMouseOver="myHint.show('inicioban')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="inicioban" id="inicioban" value="<?=$inicioban?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT1 = {	'formname' : 'form1','controlname': 'inicioban','dataformat' : 'Y-m-d','today' : '<?=$inicioban?>','positionname':'inicioban','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT1, CAL_TPL1);</script><? } ?><? if(($nivelusuario==10)) { ?><?=$inicioban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_finban" name="t_finban">Fin * <a onMouseOver="myHint.show('finban')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="finban" id="finban" value="<?=$finban?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT2 = {	'formname' : 'form1','controlname': 'finban','dataformat' : 'Y-m-d','today' : '<?=$finban?>','positionname':'finban','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT2, CAL_TPL1);</script><? } ?><? if(($nivelusuario==10)) { ?><?=$finban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tipoban" name="t_tipoban">Tipo * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><select name="tipoban" id="tipoban" class=textogeneralform><OPTION VALUE="0" <? if($tipoban=="0") echo("selected");?> >Normal</option><OPTION VALUE="1" <? if($tipoban=="1") echo("selected");?> >Derecho</option><OPTION VALUE="2" <? if($tipoban=="2") echo("selected");?> >Abajo</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($tipoban=="0") echo("Normal");if($tipoban=="1") echo("Derecho");if($tipoban=="2") echo("Abajo"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_imagenban" name="t_imagenban">Imagen * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="imagenban" id="imagenban" value="<? echo(htmlspecialchars($imagenban,ENT_COMPAT,'ISO-8859-1'));?>" size="60" maxlength="100" readonly class=textogeneralform><a href=javascript:seleccionaimagen('imagenban')><img src=recursos/cambiarimagen.gif border="0" alt=Cambiar></a><a href=javascript:muestraimagen('imagenban')><img src=recursos/verimagen.gif border="0" alt=Ver></a><a href="javascript:limpiarimagen('imagenban')" style="margin-right:20px"><img src=recursos/limpiarimagen.gif border="0" alt=Limpiar></a><? } ?><? if(($nivelusuario==10)) { ?><?=$imagenban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_imagenban" name="t_i_imagenban">Imagen inglés </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="i_imagenban" id="i_imagenban" value="<? echo(htmlspecialchars($i_imagenban,ENT_COMPAT,'ISO-8859-1'));?>" size="60" maxlength="100" readonly class=textogeneralform><a href=javascript:seleccionaimagen('i_imagenban')><img src=recursos/cambiarimagen.gif border="0" alt=Cambiar></a><a href=javascript:muestraimagen('i_imagenban')><img src=recursos/verimagen.gif border="0" alt=Ver></a><a href="javascript:limpiarimagen('i_imagenban')" style="margin-right:20px"><img src=recursos/limpiarimagen.gif border="0" alt=Limpiar></a><? } ?><? if(($nivelusuario==10)) { ?><?=$i_imagenban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_textoban" name="t_textoban">Texto * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="textoban" id="textoban" value="<? echo(htmlspecialchars($textoban,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="80"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$textoban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_textoban" name="t_i_textoban">Texto inglés * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="i_textoban" id="i_textoban" value="<? echo(htmlspecialchars($i_textoban,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="80"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$i_textoban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_urlban" name="t_urlban">URL * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="urlban" id="urlban" value="<? echo(htmlspecialchars($urlban,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$urlban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_urlban" name="t_i_urlban">URL inglés * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="i_urlban" id="i_urlban" value="<? echo(htmlspecialchars($i_urlban,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$i_urlban?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_targetban" name="t_targetban">Target * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><select name="targetban" id="targetban" class=textogeneralform><OPTION VALUE="_self" <? if($targetban=="_self") echo("selected");?> >_self</option><OPTION VALUE="_blank" <? if($targetban=="_blank") echo("selected");?> >_blank</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($targetban=="_self") echo("_self");if($targetban=="_blank") echo("_blank"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ordenban" name="t_ordenban">Orden * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="ordenban" id="ordenban" value="<? echo(formato_numero($ordenban,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('ordenban')" onBlur="pone_pesos('ordenban','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($ordenban,'')); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'nombreban':{'l':'Nombre','r': true,'t':'t_nombreban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'inicioban':{'l':'Inicio','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_inicioban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'finban':{'l':'Fin','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_finban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tipoban':{'l':'Tipo','r': true,'t':'t_tipoban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'imagenban':{'l':'Imagen','r': true,'t':'t_imagenban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'textoban':{'l':'Texto','r': true,'t':'t_textoban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'i_textoban':{'l':'Texto inglés','r': true,'t':'t_i_textoban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'urlban':{'l':'URL','r': true,'t':'t_urlban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'i_urlban':{'l':'URL inglés','r': true,'t':'t_i_urlban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'targetban':{'l':'Target','r': true,'t':'t_targetban'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ordenban':{'l':'Orden','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_ordenban'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
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
                <? if($ocultabotones<>1) { ?>	<? if($nivelusuario==0 || $nivelusuario==10) {?> <? $yabotonguardar="ya"; ?>
                <input class=textogeneral type="submit" name="Submit" value="<?=$ib_guardar?>" <?=$valordisabled?>><?} ?>
				<? if($step=="add" && $yabotonguardar<>"ya") { ?><input class=textogeneral type="submit" name="Submit" value="<?=$ib_guardar?>" <?=$valordisabled?>><? } ?><? } ?>
              </div>
            </td>
    </tr>
<? if($campopredeterminadotabla<>"" && isset($campopredeterminadotabla)) echo("<script>document.getElementById('".$campopredeterminadotabla."').focus();</script>"); ?>
	
    
	
	</form>
    
  </table>
  </div>
   <?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; $boton_fotos=1;?>
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
  <? if($nivelusuario==0 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="ban.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="nombreban" selected>Nombre</option><option value="inicioban">Inicio</option><option value="finban">Fin</option><option value="tipoban">Tipo</option><option value="imagenban">Imagen</option><option value="i_imagenban">Imagen inglés</option><option value="textoban">Texto</option><option value="i_textoban">Texto inglés</option><option value="urlban">URL</option><option value="i_urlban">URL inglés</option><option value="targetban">Target</option><option value="ordenban">Orden</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('ban.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="nombrebanl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="nombrebanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nombrebanb2" value="" size="55" onKeyUp="revisainput('nombrebanb1','nombrebanb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Inicio</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="iniciobanl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="iniciobanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="iniciobanb2" value="" size="15" onKeyUp="revisainput('iniciobanb1','iniciobanb2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fin</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="finbanl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="finbanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="finbanb2" value="" size="15" onKeyUp="revisainput('finbanb1','finbanb2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Tipo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="tipobanl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="tipobanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="tipobanb2" onChange="if(tipobanb1.selectedIndex==0) tipobanb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($tipoban=="0") { ?>selected<? } ?> >Normal</option><OPTION VALUE="1" <? if($tipoban=="1") { ?>selected<? } ?> >Derecho</option><OPTION VALUE="2" <? if($tipoban=="2") { ?>selected<? } ?> >Abajo</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Imagen</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="imagenbanl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="imagenbanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="imagenbanb2" value="" size="105" onKeyUp="revisainput('imagenbanb1','imagenbanb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Imagen inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="i_imagenbanl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="i_imagenbanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_imagenbanb2" value="" size="105" onKeyUp="revisainput('i_imagenbanb1','i_imagenbanb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Texto</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="textobanl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="textobanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="textobanb2" id="textoban" value="" size="50" onKeyUp="revisainput('textobanb1','textobanb2');" maxlength="80" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Texto inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="i_textobanl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="i_textobanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_textobanb2" id="i_textoban" value="" size="50" onKeyUp="revisainput('i_textobanb1','i_textobanb2');" maxlength="80" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="urlbanl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="urlbanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="urlbanb2" id="urlban" value="" size="50" onKeyUp="revisainput('urlbanb1','urlbanb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="i_urlbanl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="i_urlbanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_urlbanb2" id="i_urlban" value="" size="50" onKeyUp="revisainput('i_urlbanb1','i_urlbanb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Target</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="targetbanl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="targetbanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="targetbanb2" onChange="if(targetbanb1.selectedIndex==0) targetbanb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="_self" <? if($targetban=="_self") { ?>selected<? } ?> >_self</option><OPTION VALUE="_blank" <? if($targetban=="_blank") { ?>selected<? } ?> >_blank</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Orden</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="ordenbanl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="ordenbanb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ordenbanb2" value="" size="10" onKeyUp="revisainput('ordenbanb1','ordenbanb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?> 
	
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('ban.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelban.php?step=busqueda2<?=$url_extra?>');">
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
<script language="JavaScript"> for (var n = 0; n < A_CALENDARS.length; n++) {	A_CALENDARS[n].create(); } </script>
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

