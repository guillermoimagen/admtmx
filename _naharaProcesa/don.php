<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_don"]=1;
	$_SESSION["esframe_don_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_don_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_don"]=0;
	$_SESSION["esframe_don_id"]=0;
	$_SESSION["esframe_don_archivo"]="";
}

$titulo_pagina="Donativos";
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

$numerodetabla=3;
include("recursos/funciones_tabla.php"); 
$archivoactual="don.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_don"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==3)   {     if($fechadonl1=="on" || $importedonl1=="on" || $plataformadonl1=="on" || $statusdonl1=="on" || $clavedonl1=="on" || $comentariosdonl1=="on" || $ganadordonl1=="on" || $acumuladodonl1=="on" || $idiomal1=="on" || $importeprogramadodonl1=="on") $error=9;     if(isset($fechadonb2) || isset($importedonb2) || isset($plataformadonb2) || isset($statusdonb2) || isset($clavedonb2) || isset($comentariosdonb2) || isset($ganadordonb2) || isset($acumuladodonb2) || isset($idiomab2) || isset($importeprogramadodonb2)) $error=9;   }  if($nivelusuario==4)   {     if($fechadonl1=="on" || $importedonl1=="on" || $plataformadonl1=="on" || $statusdonl1=="on" || $clavedonl1=="on" || $comentariosdonl1=="on" || $ganadordonl1=="on" || $acumuladodonl1=="on" || $idiomal1=="on" || $importeprogramadodonl1=="on") $error=9;     if(isset($fechadonb2) || isset($importedonb2) || isset($plataformadonb2) || isset($statusdonb2) || isset($clavedonb2) || isset($comentariosdonb2) || isset($ganadordonb2) || isset($acumuladodonb2) || isset($idiomab2) || isset($importeprogramadodonb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["iusuariodon"]) || isset($_POST["iretdon"]) || isset($_POST["iformadon"]) || isset($_POST["iusuariodonodon"]) || isset($_POST["fechadon"]) || isset($_POST["importedon"]) || isset($_POST["plataformadon"]) || isset($_POST["statusdon"]) || isset($_POST["clavedon"]) || isset($_POST["comentariosdon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=8;   if($nivelusuario==1) if(isset($_POST["iusuariodon"]) || isset($_POST["iretdon"]) || isset($_POST["iformadon"]) || isset($_POST["iusuariodonodon"]) || isset($_POST["fechadon"]) || isset($_POST["importedon"]) || isset($_POST["plataformadon"]) || isset($_POST["statusdon"]) || isset($_POST["clavedon"]) || isset($_POST["comentariosdon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=8;   if($nivelusuario==2) if(isset($_POST["iusuariodon"]) || isset($_POST["iretdon"]) || isset($_POST["iformadon"]) || isset($_POST["iusuariodonodon"]) || isset($_POST["fechadon"]) || isset($_POST["importedon"]) || isset($_POST["plataformadon"]) || isset($_POST["statusdon"]) || isset($_POST["clavedon"]) || isset($_POST["comentariosdon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=8;   if($nivelusuario==3) if(isset($_POST["iusuariodon"]) || isset($_POST["iretdon"]) || isset($_POST["iformadon"]) || isset($_POST["iusuariodonodon"]) || isset($_POST["fechadon"]) || isset($_POST["importedon"]) || isset($_POST["plataformadon"]) || isset($_POST["statusdon"]) || isset($_POST["clavedon"]) || isset($_POST["comentariosdon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=8;   if($nivelusuario==4) if(isset($_POST["iusuariodon"]) || isset($_POST["iretdon"]) || isset($_POST["iformadon"]) || isset($_POST["iusuariodonodon"]) || isset($_POST["fechadon"]) || isset($_POST["importedon"]) || isset($_POST["plataformadon"]) || isset($_POST["statusdon"]) || isset($_POST["clavedon"]) || isset($_POST["comentariosdon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["fechadon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=7;   if($nivelusuario==1) if(isset($_POST["fechadon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=7;   if($nivelusuario==2) if(isset($_POST["fechadon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=7;   if($nivelusuario==3) if(isset($_POST["fechadon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=7;   if($nivelusuario==4) if(isset($_POST["fechadon"]) || isset($_POST["ganadordon"]) || isset($_POST["acumuladodon"]) || isset($_POST["idioma"]) || isset($_POST["importeprogramadodon"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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
	<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==10) {?> 
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


<?if($_SESSION["esframe_don"]==1){  if($_SESSION["esframe_don_archivo"]=="ret")  {    if($step=="add")    {      $iretdon=$_SESSION["id_ret"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $iretdonb1="=";      $iretdonb2=$_SESSION["id_ret"];    }  }  else   if($_SESSION["esframe_don_archivo"]=="usuarios")  {    if($step=="add")    {      $iusuariodonodon=$_SESSION["id_usuarios"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $iusuariodonodonb1="=";      $iusuariodonodonb2=$_SESSION["id_usuarios"];    }  }}?><? include("especialesMenuPeque.php"); ?>
<? include("include/acciondon.php"); ?>


<head>

<title><? echo("Donativos"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


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
    if($_SESSION["esframe_don"]<>1)
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
  if(isset($_POST["importedon"])) $_POST["importedon"]=limpia_numero($_POST["importedon"]);if(isset($_POST["ganadordon"])) $_POST["ganadordon"]=limpia_numero($_POST["ganadordon"]);if(isset($_POST["acumuladodon"])) $_POST["acumuladodon"]=limpia_numero($_POST["acumuladodon"]);if(isset($_POST["importeprogramadodon"])) $_POST["importeprogramadodon"]=limpia_numero($_POST["importeprogramadodon"]);
  
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
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM don where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("iusuariodon","",0);$sqltemporal.=construyesqltemporal("iretdon","",0);$sqltemporal.=construyesqltemporal("iformadon","",0);$sqltemporal.=construyesqltemporal("iusuariodonodon","",0);$sqltemporal.=construyesqltemporal("fechadon","'",0);$sqltemporal.=construyesqltemporal("importedon","",2);$sqltemporal.=construyesqltemporal("plataformadon","'",0);$sqltemporal.=construyesqltemporal("statusdon","'",0);$sqltemporal.=construyesqltemporal("clavedon","'",0);$sqltemporal.=construyesqltemporal("comentariosdon","'",0);$sqltemporal.=construyesqltemporal("ganadordon","",2);$sqltemporal.=construyesqltemporal("acumuladodon","",2);$sqltemporal.=construyesqltemporal("idioma","'",0);$sqltemporal.=construyesqltemporal("importeprogramadodon","",2);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
	   if($nivelusuario=="meminpinguin") {	
      	
		  $sql = "INSERT INTO don SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=3,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_don"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_don"]="OK";
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
	   if($nivelusuario=="10") {	      
		  $sql = "UPDATE don SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=3,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM don where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["iusuariodon"]<>$rown["iusuariodon"]) $cadena_historico.="Usuario dueño del reto o de la alcancía:\r\n O:".$rowh["iusuariodon"]."\r\nN: ".$rown["iusuariodon"]."\r\n\r\n";               if($rowh["iretdon"]<>$rown["iretdon"]) $cadena_historico.="Reto:\r\n O:".$rowh["iretdon"]."\r\nN: ".$rown["iretdon"]."\r\n\r\n";               if($rowh["iformadon"]<>$rown["iformadon"]) $cadena_historico.="Forma de pago:\r\n O:".$rowh["iformadon"]."\r\nN: ".$rown["iformadon"]."\r\n\r\n";               if($rowh["iusuariodonodon"]<>$rown["iusuariodonodon"]) $cadena_historico.="Usuario que donó:\r\n O:".$rowh["iusuariodonodon"]."\r\nN: ".$rown["iusuariodonodon"]."\r\n\r\n";               if($rowh["fechadon"]<>$rown["fechadon"]) $cadena_historico.="Fecha/hora:\r\n O:".$rowh["fechadon"]."\r\nN: ".$rown["fechadon"]."\r\n\r\n";               if($rowh["importedon"]<>$rown["importedon"]) $cadena_historico.="Importe:\r\n O:".$rowh["importedon"]."\r\nN: ".$rown["importedon"]."\r\n\r\n";               if($rowh["plataformadon"]<>$rown["plataformadon"]) $cadena_historico.="Plataforma:\r\n O:".$rowh["plataformadon"]."\r\nN: ".$rown["plataformadon"]."\r\n\r\n";               if($rowh["statusdon"]<>$rown["statusdon"]) $cadena_historico.="Status:\r\n O:".$rowh["statusdon"]."\r\nN: ".$rown["statusdon"]."\r\n\r\n";               if($rowh["clavedon"]<>$rown["clavedon"]) $cadena_historico.="Clave de pago:\r\n O:".$rowh["clavedon"]."\r\nN: ".$rown["clavedon"]."\r\n\r\n";               if($rowh["comentariosdon"]<>$rown["comentariosdon"]) $cadena_historico.="Comentarios:\r\n O:".$rowh["comentariosdon"]."\r\nN: ".$rown["comentariosdon"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_don"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_don"]="NADA";
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
		$sql = "DELETE FROM don WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=3,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_don"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,iusuariodon FROM don where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["iusuariodon"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=don.php?step=1".$url_extra."><span class=titulo>Donativos</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) $botones.="<td><a href=don.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Donativos\"></a></td>";if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) $botones.="<td><a href=don.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Donativos\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_don"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_don"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_don"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_don"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="don.activo DESC,iusuariodon ASC"; $ordenamiento="";$activob1="="; $activob2="1";$iusuariodonl1="on"; $iretdonl1="on"; $iformadonl1="on"; $iusuariodonodonl1="on"; $fechadonl1="on"; $importedonl1="on"; $plataformadonl1="on"; $statusdonl1="on"; $ganadordonl1="on"; $acumuladodonl1="on"; $idiomal1="on"; } $camposbuscadoslistadosearch="don.id";cbusqueda1($activol1,"don","activo");cbusqueda1($iusuariodonl1,"usuarios","nombreusuario","0","","");cbusqueda1($iretdonl1,"ret","nombreret","0","","");cbusqueda1($iformadonl1,"formas","nombreforma","0","","");cbusqueda1($iusuariodonodonl1,"usuarios","nombreusuario","1","","");cbusqueda1($fechadonl1,"don","fechadon");cbusqueda1($importedonl1,"don","importedon");cbusqueda1($plataformadonl1,"don","plataformadon");cbusqueda1($statusdonl1,"don","statusdon");cbusqueda1($clavedonl1,"don","clavedon");cbusqueda1($comentariosdonl1,"don","comentariosdon");cbusqueda1($ganadordonl1,"don","ganadordon");cbusqueda1($acumuladodonl1,"don","acumuladodon");cbusqueda1($idiomal1,"don","idioma");cbusqueda1($importeprogramadodonl1,"don","importeprogramadodon");cbusqueda2($iusuariodonl1,"usuarios","don","iusuariodon","",0,"id");cbusqueda2($iretdonl1,"ret","don","iretdon","",0,"id");cbusqueda2($iformadonl1,"formas","don","iformadon","",0,"id");cbusqueda2($iusuariodonodonl1,"usuarios","don","iusuariodonodon","",1,"id");cbusqueda3($iusuariodonb1,$iusuariodonb2,"don","iusuariodon","","0","","");cbusqueda3($iretdonb1,$iretdonb2,"don","iretdon","","0","","");cbusqueda3($iformadonb1,$iformadonb2,"don","iformadon","","0","","");cbusqueda3($iusuariodonodonb1,$iusuariodonodonb2,"don","iusuariodonodon","","1","","");cbusqueda3($fechadonb1,$fechadonb2,"don","fechadon","'","0","","");cbusqueda3($importedonb1,$importedonb2,"don","importedon","","0","","");cbusqueda3($plataformadonb1,$plataformadonb2,"don","plataformadon","'","0","","");cbusqueda3($statusdonb1,$statusdonb2,"don","statusdon","'","0","","");cbusqueda3($clavedonb1,$clavedonb2,"don","clavedon","'","0","","");cbusqueda3($comentariosdonb1,$comentariosdonb2,"don","comentariosdon","'","0","","");cbusqueda3($ganadordonb1,$ganadordonb2,"don","ganadordon","","0","","");cbusqueda3($acumuladodonb1,$acumuladodonb2,"don","acumuladodon","","0","","");cbusqueda3($idiomab1,$idiomab2,"don","idioma","'","0","","");cbusqueda3($importeprogramadodonb1,$importeprogramadodonb2,"don","importeprogramadodon","","0","","");cbusqueda3($activob1,$activob2,"don","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from don ";
	$antesbusqueda="";
	include("idon.php");
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($iusuariodonl1,"Usuario dueño del reto o de la alcancía",": STR","");cbusqueda5($iretdonl1,"Reto",": STR","");cbusqueda5($iformadonl1,"Forma de pago",": STR","");cbusqueda5($iusuariodonodonl1,"Usuario que donó",": STR","");cbusqueda5($fechadonl1,"Fecha/hora"," : DATE","");cbusqueda5($importedonl1,"Importe"," : NUM","");cbusqueda5($plataformadonl1,"Plataforma",": STR","");cbusqueda5($statusdonl1,"Status",": STR","");cbusqueda5($clavedonl1,"Clave de pago",": STR","");cbusqueda5($comentariosdonl1,"Comentarios",": STR","");cbusqueda5($ganadordonl1,"Ganador"," : NUM","");cbusqueda5($acumuladodonl1,"Acumulado"," : NUM","");cbusqueda5($idiomal1,"Idioma",": STR","");cbusqueda5($importeprogramadodonl1,"Importe programado"," : NUM",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='don.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";if($importedonl1=="on") $sumatoriaimportedon=$sumatoriaimportedon+$row["importedon"];$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($iusuariodonl1,"usuarios","nombreusuario","0","","");cbusqueda4($iretdonl1,"ret","nombreret","0","","");cbusqueda4($iformadonl1,"formas","nombreforma","0","","");cbusqueda4($iusuariodonodonl1,"usuarios","nombreusuario","1","","");cbusqueda4($fechadonl1,"don","fechadon","0","","");cbusqueda4($importedonl1,"don","importedon","0","",""); if($plataformadonl1=="on")  {  if($row["plataformadon"]=="0") $tempoplataformadon="Desktop";if($row["plataformadon"]=="1") $tempoplataformadon="Mobile";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempoplataformadon.$tempotigra."\""; $tempotigra="";  }  if($statusdonl1=="on")  {  if($row["statusdon"]=="0") $tempostatusdon="Pendiente de pago";if($row["statusdon"]=="2") $tempostatusdon="Pagado";if($row["statusdon"]=="3") $tempostatusdon="Cancelado";if($row["statusdon"]=="4") $tempostatusdon="Rechazado";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempostatusdon.$tempotigra."\""; $tempotigra="";  } cbusqueda4($clavedonl1,"don","clavedon","0","","");cbusqueda4($comentariosdonl1,"don","comentariosdon","0","","");cbusqueda4($ganadordonl1,"don","ganadordon","0","","");cbusqueda4($acumuladodonl1,"don","acumuladodon","0","",""); if($idiomal1=="on")  {  if($row["idioma"]=="0") $tempoidioma="Español";if($row["idioma"]=="1") $tempoidioma="Inglés";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempoidioma.$tempotigra."\""; $tempotigra="";  } cbusqueda4($importeprogramadodonl1,"don","importeprogramadodon","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($iusuariodonl1,$sumatoriaiusuariodon,'');cbusqueda6($iretdonl1,$sumatoriairetdon,'');cbusqueda6($iformadonl1,$sumatoriaiformadon,'');cbusqueda6($iusuariodonodonl1,$sumatoriaiusuariodonodon,'');cbusqueda6($fechadonl1,$sumatoriafechadon,'');cbusqueda6($importedonl1,$sumatoriaimportedon,'');cbusqueda6($plataformadonl1,$sumatoriaplataformadon,'');cbusqueda6($statusdonl1,$sumatoriastatusdon,'');cbusqueda6($clavedonl1,$sumatoriaclavedon,'');cbusqueda6($comentariosdonl1,$sumatoriacomentariosdon,'');cbusqueda6($ganadordonl1,$sumatoriaganadordon,'');cbusqueda6($acumuladodonl1,$sumatoriaacumuladodon,'');cbusqueda6($idiomal1,$sumatoriaidioma,'');cbusqueda6($importeprogramadodonl1,$sumatoriaimporteprogramadodon,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/exceldon.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=iusuariodonl1 type="hidden" value="<?=$iusuariodonl1?>" ><input name=iusuariodonb1 type="hidden" value="<?=$iusuariodonb1?>" ><input name=iusuariodonb2 type="hidden" value="<?=$iusuariodonb2?>" ><input name=iretdonl1 type="hidden" value="<?=$iretdonl1?>" ><input name=iretdonb1 type="hidden" value="<?=$iretdonb1?>" ><input name=iretdonb2 type="hidden" value="<?=$iretdonb2?>" ><input name=iformadonl1 type="hidden" value="<?=$iformadonl1?>" ><input name=iformadonb1 type="hidden" value="<?=$iformadonb1?>" ><input name=iformadonb2 type="hidden" value="<?=$iformadonb2?>" ><input name=iusuariodonodonl1 type="hidden" value="<?=$iusuariodonodonl1?>" ><input name=iusuariodonodonb1 type="hidden" value="<?=$iusuariodonodonb1?>" ><input name=iusuariodonodonb2 type="hidden" value="<?=$iusuariodonodonb2?>" ><input name=fechadonl1 type="hidden" value="<?=$fechadonl1?>" ><input name=fechadonb1 type="hidden" value="<?=$fechadonb1?>" ><input name=fechadonb2 type="hidden" value="<?=$fechadonb2?>" ><input name=importedonl1 type="hidden" value="<?=$importedonl1?>" ><input name=importedonb1 type="hidden" value="<?=$importedonb1?>" ><input name=importedonb2 type="hidden" value="<?=$importedonb2?>" ><input name=plataformadonl1 type="hidden" value="<?=$plataformadonl1?>" ><input name=plataformadonb1 type="hidden" value="<?=$plataformadonb1?>" ><input name=plataformadonb2 type="hidden" value="<?=$plataformadonb2?>" ><input name=statusdonl1 type="hidden" value="<?=$statusdonl1?>" ><input name=statusdonb1 type="hidden" value="<?=$statusdonb1?>" ><input name=statusdonb2 type="hidden" value="<?=$statusdonb2?>" ><input name=clavedonl1 type="hidden" value="<?=$clavedonl1?>" ><input name=clavedonb1 type="hidden" value="<?=$clavedonb1?>" ><input name=clavedonb2 type="hidden" value="<?=$clavedonb2?>" ><input name=comentariosdonl1 type="hidden" value="<?=$comentariosdonl1?>" ><input name=comentariosdonb1 type="hidden" value="<?=$comentariosdonb1?>" ><input name=comentariosdonb2 type="hidden" value="<?=$comentariosdonb2?>" ><input name=ganadordonl1 type="hidden" value="<?=$ganadordonl1?>" ><input name=ganadordonb1 type="hidden" value="<?=$ganadordonb1?>" ><input name=ganadordonb2 type="hidden" value="<?=$ganadordonb2?>" ><input name=acumuladodonl1 type="hidden" value="<?=$acumuladodonl1?>" ><input name=acumuladodonb1 type="hidden" value="<?=$acumuladodonb1?>" ><input name=acumuladodonb2 type="hidden" value="<?=$acumuladodonb2?>" ><input name=idiomal1 type="hidden" value="<?=$idiomal1?>" ><input name=idiomab1 type="hidden" value="<?=$idiomab1?>" ><input name=idiomab2 type="hidden" value="<?=$idiomab2?>" ><input name=importeprogramadodonl1 type="hidden" value="<?=$importeprogramadodonl1?>" ><input name=importeprogramadodonb1 type="hidden" value="<?=$importeprogramadodonb1?>" ><input name=importeprogramadodonb2 type="hidden" value="<?=$importeprogramadodonb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/exceldon.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
	
if($error_unique==0)
{
$iusuariodon=0;$iretdon=0;$iformadon=0;$iusuariodonodon=0;$fechadon='';$importedon=0;$plataformadon='0';$statusdon='0';$clavedon='';$comentariosdon='';$ganadordon=0;$acumuladodon=0;$idioma='0';$importeprogramadodon=0;$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["iusuariodon"])) $iusuariodon=$_POST["iusuariodon"];if(isset($_POST["iretdon"])) $iretdon=$_POST["iretdon"];if(isset($_POST["iformadon"])) $iformadon=$_POST["iformadon"];if(isset($_POST["iusuariodonodon"])) $iusuariodonodon=$_POST["iusuariodonodon"];if(isset($_POST["fechadon"])) $fechadon=$_POST["fechadon"];if(isset($_POST["importedon"])) $importedon=$_POST["importedon"];if(isset($_POST["plataformadon"])) $plataformadon=$_POST["plataformadon"];if(isset($_POST["statusdon"])) $statusdon=$_POST["statusdon"];if(isset($_POST["clavedon"])) $clavedon=$_POST["clavedon"];if(isset($_POST["comentariosdon"])) $comentariosdon=$_POST["comentariosdon"];if(isset($_POST["ganadordon"])) $ganadordon=$_POST["ganadordon"];if(isset($_POST["acumuladodon"])) $acumuladodon=$_POST["acumuladodon"];if(isset($_POST["idioma"])) $idioma=$_POST["idioma"];if(isset($_POST["importeprogramadodon"])) $importeprogramadodon=$_POST["importeprogramadodon"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM don where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM don where id=". $id);
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
$iusuariodon=$row["iusuariodon"];$iretdon=$row["iretdon"];$iformadon=$row["iformadon"];$iusuariodonodon=$row["iusuariodonodon"];$fechadon=$row["fechadon"];$importedon=$row["importedon"];$plataformadon=$row["plataformadon"];$statusdon=$row["statusdon"];$clavedon=$row["clavedon"];$comentariosdon=$row["comentariosdon"];$ganadordon=$row["ganadordon"];$acumuladodon=$row["acumuladodon"];$idioma=$row["idioma"];$importeprogramadodon=$row["importeprogramadodon"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="don.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <?
include("include/botonesdon.php");
?><? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('don.php?sortfield=iusuariodon&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
				          <? } ?>

<? if($nivelusuario=="10") {?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuariodon" name="t_iusuariodon">Usuario dueño del reto o de la alcancía * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><select name="iusuariodon" id="iusuariodon"  class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariodon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? $valor_mostrar=lee_registro("usuarios","nombreusuario","","",$iusuariodon,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iretdon" name="t_iretdon">Reto * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><select name="iretdon" id="iretdon"  class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iretdon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? $valor_mostrar=lee_registro("ret","nombreret","","",$iretdon,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iformadon" name="t_iformadon">Forma de pago * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><select name="iformadon" id="iformadon"  class=textogeneralform><option value="0" selected></option><?  leecampos("formas","id","nombreforma","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iformadon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? $valor_mostrar=lee_registro("formas","nombreforma","","",$iformadon,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuariodonodon" name="t_iusuariodonodon">Usuario que donó * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><select name="iusuariodonodon" id="iusuariodonodon"  class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariodonodon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? $valor_mostrar=lee_registro("usuarios","nombreusuario","","",$iusuariodonodon,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $step<>"add"  && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fechadon" name="t_fechadon">Fecha/hora * </td><td valign="middle"><?=$fechadon?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_importedon" name="t_importedon">Importe * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><input type="text" name="importedon" id="importedon" value="<? echo(formato_numero($importedon,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('importedon')" onBlur="pone_pesos('importedon','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? echo(formato_numero($importedon,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_plataformadon" name="t_plataformadon">Plataforma * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><select name="plataformadon" id="plataformadon" class=textogeneralform><OPTION VALUE="0" <? if($plataformadon=="0") echo("selected");?> >Desktop</option><OPTION VALUE="1" <? if($plataformadon=="1") echo("selected");?> >Mobile</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? if($plataformadon=="0") echo("Desktop");if($plataformadon=="1") echo("Mobile"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_statusdon" name="t_statusdon">Status * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><select name="statusdon" id="statusdon" class=textogeneralform><OPTION VALUE="0" <? if($statusdon=="0") echo("selected");?> >Pendiente de pago</option><OPTION VALUE="2" <? if($statusdon=="2") echo("selected");?> >Pagado</option><OPTION VALUE="3" <? if($statusdon=="3") echo("selected");?> >Cancelado</option><OPTION VALUE="4" <? if($statusdon=="4") echo("selected");?> >Rechazado</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? if($statusdon=="0") echo("Pendiente de pago");if($statusdon=="2") echo("Pagado");if($statusdon=="3") echo("Cancelado");if($statusdon=="4") echo("Rechazado"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_clavedon" name="t_clavedon">Clave de pago * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><input type="text" name="clavedon" id="clavedon" value="<? echo(htmlspecialchars($clavedon,ENT_COMPAT,'ISO-8859-1')); ?>" size="25" maxlength="20" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><?=$clavedon?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_comentariosdon" name="t_comentariosdon">Comentarios * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><textarea name="comentariosdon" id="comentariosdon" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($comentariosdon,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><?=$comentariosdon?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ganadordon" name="t_ganadordon">Ganador </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="ganadordon" id="ganadordon" value="<? echo(formato_numero($ganadordon,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('ganadordon')" onBlur="pone_pesos('ganadordon','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($ganadordon,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_acumuladodon" name="t_acumuladodon">Acumulado </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="acumuladodon" id="acumuladodon" value="<? echo(formato_numero($acumuladodon,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('acumuladodon')" onBlur="pone_pesos('acumuladodon','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($acumuladodon,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idioma" name="t_idioma">Idioma </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idioma" id="idioma" class=textogeneralform><OPTION VALUE="0" <? if($idioma=="0") echo("selected");?> >Español</option><OPTION VALUE="1" <? if($idioma=="1") echo("selected");?> >Inglés</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? if($idioma=="0") echo("Español");if($idioma=="1") echo("Inglés"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_importeprogramadodon" name="t_importeprogramadodon">Importe programado </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="importeprogramadodon" id="importeprogramadodon" value="<? echo(formato_numero($importeprogramadodon,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('importeprogramadodon')" onBlur="pone_pesos('importeprogramadodon','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($importeprogramadodon,'')); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuariodon':{'l':'Usuario dueño del reto o de la alcancía','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iusuariodon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iretdon':{'l':'Reto','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iretdon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iformadon':{'l':'Forma de pago','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iformadon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuariodonodon':{'l':'Usuario que donó','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iusuariodonodon'}";?><? } ?><? if(($nivelusuario==10) && $step<>"add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fechadon':{'l':'Fecha/hora','r': true,'t':'t_fechadon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'importedon':{'l':'Importe','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_importedon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'plataformadon':{'l':'Plataforma','r': true,'t':'t_plataformadon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'statusdon':{'l':'Status','r': true,'t':'t_statusdon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'clavedon':{'l':'Clave de pago','r': true,'t':'t_clavedon'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'comentariosdon':{'l':'Comentarios','r': true,'t':'t_comentariosdon'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ganadordon':{'l':'Ganador','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_ganadordon'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'acumuladodon':{'l':'Acumulado','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_acumuladodon'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'importeprogramadodon':{'l':'Importe programado','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_importeprogramadodon'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
	var v = new validator('form1', a_fields, o_config);</script>  
    <? if($nivelusuario=="meminpinguin") {?>
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
                <? if($ocultabotones<>1) { ?>	<? if($nivelusuario=="10") {?> <? $yabotonguardar="ya"; ?>
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
  <? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="don.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="iusuariodon" selected>Usuario dueño del reto o de la alcancía</option><option value="iretdon">Reto</option><option value="iformadon">Forma de pago</option><option value="iusuariodonodon">Usuario que donó</option><option value="fechadon">Fecha/hora</option><option value="importedon">Importe</option><option value="plataformadon">Plataforma</option><option value="statusdon">Status</option><option value="clavedon">Clave de pago</option><option value="comentariosdon">Comentarios</option><option value="ganadordon">Ganador</option><option value="acumuladodon">Acumulado</option><option value="idioma">Idioma</option><option value="importeprogramadodon">Importe programado</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('don.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario dueño del reto o de la alcancía</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="iusuariodonl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iusuariodonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuariodonb2" onChange="if(iusuariodonb1.selectedIndex==0) iusuariodonb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariodon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Reto</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="iretdonl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iretdonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iretdonb2" onChange="if(iretdonb1.selectedIndex==0) iretdonb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iretdon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Forma de pago</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="iformadonl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iformadonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iformadonb2" onChange="if(iformadonb1.selectedIndex==0) iformadonb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("formas","id","nombreforma","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iformadon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario que donó</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="iusuariodonodonl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iusuariodonodonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuariodonodonb2" onChange="if(iusuariodonodonb1.selectedIndex==0) iusuariodonodonb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariodonodon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $step<>"add"  && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha/hora</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="fechadonl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="fechadonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechadonb2" value="" size="50" onKeyUp="revisainput('fechadonb1','fechadonb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Importe</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="importedonl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="importedonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="importedonb2" value="" size="15" onKeyUp="revisainput('importedonb1','importedonb2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Plataforma</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="plataformadonl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="plataformadonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="plataformadonb2" onChange="if(plataformadonb1.selectedIndex==0) plataformadonb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($plataformadon=="0") { ?>selected<? } ?> >Desktop</option><OPTION VALUE="1" <? if($plataformadon=="1") { ?>selected<? } ?> >Mobile</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Status</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="statusdonl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="statusdonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="statusdonb2" onChange="if(statusdonb1.selectedIndex==0) statusdonb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($statusdon=="0") { ?>selected<? } ?> >Pendiente de pago</option><OPTION VALUE="2" <? if($statusdon=="2") { ?>selected<? } ?> >Pagado</option><OPTION VALUE="3" <? if($statusdon=="3") { ?>selected<? } ?> >Cancelado</option><OPTION VALUE="4" <? if($statusdon=="4") { ?>selected<? } ?> >Rechazado</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Clave de pago</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="clavedonl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="clavedonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="clavedonb2" value="" size="25" onKeyUp="revisainput('clavedonb1','clavedonb2');" maxlength="20" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Comentarios</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="comentariosdonl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="comentariosdonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="comentariosdonb2" value="" size="50" onKeyUp="revisainput('comentariosdonb1','comentariosdonb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Ganador</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ganadordonl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ganadordonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ganadordonb2" value="" size="10" onKeyUp="revisainput('ganadordonb1','ganadordonb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Acumulado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="acumuladodonl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="acumuladodonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="acumuladodonb2" value="" size="15" onKeyUp="revisainput('acumuladodonb1','acumuladodonb2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Idioma</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="idiomal1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="idiomab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idiomab2" onChange="if(idiomab1.selectedIndex==0) idiomab1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($idioma=="0") { ?>selected<? } ?> >Español</option><OPTION VALUE="1" <? if($idioma=="1") { ?>selected<? } ?> >Inglés</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Importe programado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="importeprogramadodonl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="importeprogramadodonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="importeprogramadodonb2" value="" size="15" onKeyUp="revisainput('importeprogramadodonb1','importeprogramadodonb2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario=="meminpinguin") {?>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('don.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/exceldon.php?step=busqueda2<?=$url_extra?>');">
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

