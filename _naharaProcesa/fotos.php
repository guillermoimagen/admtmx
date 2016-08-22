<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_fotos"]=1;
	$_SESSION["esframe_fotos_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_fotos_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_fotos"]=0;
	$_SESSION["esframe_fotos_id"]=0;
	$_SESSION["esframe_fotos_archivo"]="";
}

$titulo_pagina="Fotos";
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

$numerodetabla=20;
include("recursos/funciones_tabla.php"); 
$archivoactual="fotos.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_fotos"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==2)   {     if($itablafotol1=="on" || $registrofotol1=="on" || $icfotofotol1=="on" || $fechafotol1=="on" || $archivofotol1=="on" || $ordenfotol1=="on" || $titulofotol1=="on" || $descripcionfotol1=="on" || $iusuariofotol1=="on" || $iusuariopublicofotol1=="on" || $statuspublicacionfotol1=="on" || $reportesfotol1=="on" || $destacadafotol1=="on" || $tgustal1=="on" || $tcomentariol1=="on") $error=9;     if(isset($itablafotob2) || isset($registrofotob2) || isset($icfotofotob2) || isset($fechafotob2) || isset($archivofotob2) || isset($ordenfotob2) || isset($titulofotob2) || isset($descripcionfotob2) || isset($iusuariofotob2) || isset($iusuariopublicofotob2) || isset($statuspublicacionfotob2) || isset($reportesfotob2) || isset($destacadafotob2) || isset($tgustab2) || isset($tcomentariob2)) $error=9;   }  if($nivelusuario==3)   {     if($itablafotol1=="on" || $registrofotol1=="on" || $icfotofotol1=="on" || $fechafotol1=="on" || $archivofotol1=="on" || $ordenfotol1=="on" || $titulofotol1=="on" || $descripcionfotol1=="on" || $iusuariofotol1=="on" || $iusuariopublicofotol1=="on" || $statuspublicacionfotol1=="on" || $reportesfotol1=="on" || $destacadafotol1=="on" || $tgustal1=="on" || $tcomentariol1=="on") $error=9;     if(isset($itablafotob2) || isset($registrofotob2) || isset($icfotofotob2) || isset($fechafotob2) || isset($archivofotob2) || isset($ordenfotob2) || isset($titulofotob2) || isset($descripcionfotob2) || isset($iusuariofotob2) || isset($iusuariopublicofotob2) || isset($statuspublicacionfotob2) || isset($reportesfotob2) || isset($destacadafotob2) || isset($tgustab2) || isset($tcomentariob2)) $error=9;   }  if($nivelusuario==4)   {     if($itablafotol1=="on" || $registrofotol1=="on" || $icfotofotol1=="on" || $fechafotol1=="on" || $archivofotol1=="on" || $ordenfotol1=="on" || $titulofotol1=="on" || $descripcionfotol1=="on" || $iusuariofotol1=="on" || $iusuariopublicofotol1=="on" || $statuspublicacionfotol1=="on" || $reportesfotol1=="on" || $destacadafotol1=="on" || $tgustal1=="on" || $tcomentariol1=="on") $error=9;     if(isset($itablafotob2) || isset($registrofotob2) || isset($icfotofotob2) || isset($fechafotob2) || isset($archivofotob2) || isset($ordenfotob2) || isset($titulofotob2) || isset($descripcionfotob2) || isset($iusuariofotob2) || isset($iusuariopublicofotob2) || isset($statuspublicacionfotob2) || isset($reportesfotob2) || isset($destacadafotob2) || isset($tgustab2) || isset($tcomentariob2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=8;   if($nivelusuario==1) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=8;   if($nivelusuario==2) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["titulofoto"]) || isset($_POST["descripcionfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["statuspublicacionfoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["destacadafoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=8;   if($nivelusuario==3) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["titulofoto"]) || isset($_POST["descripcionfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["statuspublicacionfoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["destacadafoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=8;   if($nivelusuario==4) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["titulofoto"]) || isset($_POST["descripcionfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["statuspublicacionfoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["destacadafoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=7;   if($nivelusuario==1) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=7;   if($nivelusuario==2) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["titulofoto"]) || isset($_POST["descripcionfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["statuspublicacionfoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["destacadafoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=7;   if($nivelusuario==3) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["titulofoto"]) || isset($_POST["descripcionfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["statuspublicacionfoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["destacadafoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=7;   if($nivelusuario==4) if(isset($_POST["itablafoto"]) || isset($_POST["registrofoto"]) || isset($_POST["icfotofoto"]) || isset($_POST["fechafoto"]) || isset($_POST["archivofoto"]) || isset($_POST["ordenfoto"]) || isset($_POST["titulofoto"]) || isset($_POST["descripcionfoto"]) || isset($_POST["iusuariofoto"]) || isset($_POST["iusuariopublicofoto"]) || isset($_POST["statuspublicacionfoto"]) || isset($_POST["reportesfoto"]) || isset($_POST["destacadafoto"]) || isset($_POST["tgusta"]) || isset($_POST["tcomentario"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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





<head>

<title><? echo("Fotos"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


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
    if($_SESSION["esframe_fotos"]<>1)
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
  if(isset($_POST["registrofoto"])) $_POST["registrofoto"]=limpia_numero($_POST["registrofoto"]);if(isset($_POST["icfotofoto"])) $_POST["icfotofoto"]=limpia_numero($_POST["icfotofoto"]);if(isset($_POST["ordenfoto"])) $_POST["ordenfoto"]=limpia_numero($_POST["ordenfoto"]);if(isset($_POST["reportesfoto"])) $_POST["reportesfoto"]=limpia_numero($_POST["reportesfoto"]);if(isset($_POST["tgusta"])) $_POST["tgusta"]=limpia_numero($_POST["tgusta"]);if(isset($_POST["tcomentario"])) $_POST["tcomentario"]=limpia_numero($_POST["tcomentario"]);
  
  if($operacion=="modify" || $operacion=="add") 
  {
	if($operacion=="add") 
	{
	   if($nivelusuario=="meminpinguin") {
      $_POST["iusuariofoto"]=$_SESSION["sesionid"];	
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
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM fotos where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("itablafoto","",0);$sqltemporal.=construyesqltemporal("registrofoto","",2);$sqltemporal.=construyesqltemporal("icfotofoto","",2);$sqltemporal.=construyesqltemporal("fechafoto","'",0);$sqltemporal.=construyesqltemporal("archivofoto","'",0);$sqltemporal.=construyesqltemporal("ordenfoto","",2);$sqltemporal.=construyesqltemporal("titulofoto","'",0);$sqltemporal.=construyesqltemporal("descripcionfoto","'",0);$sqltemporal.=construyesqltemporal("iusuariofoto","",0);$sqltemporal.=construyesqltemporal("iusuariopublicofoto","",0);$sqltemporal.=construyesqltemporal("statuspublicacionfoto","'",0);$sqltemporal.=construyesqltemporal("reportesfoto","",2);$sqltemporal.=construyesqltemporal("destacadafoto","'",0);$sqltemporal.=construyesqltemporal("tgusta","",2);$sqltemporal.=construyesqltemporal("tcomentario","",2);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
      	
		  $sql = "INSERT INTO fotos SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=20,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_fotos"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_fotos"]="OK";
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
		  $sql = "UPDATE fotos SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=20,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM fotos where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["itablafoto"]<>$rown["itablafoto"]) $cadena_historico.="Tabla:\r\n O:".$rowh["itablafoto"]."\r\nN: ".$rown["itablafoto"]."\r\n\r\n";               if($rowh["registrofoto"]<>$rown["registrofoto"]) $cadena_historico.="Registro:\r\n O:".$rowh["registrofoto"]."\r\nN: ".$rown["registrofoto"]."\r\n\r\n";               if($rowh["icfotofoto"]<>$rown["icfotofoto"]) $cadena_historico.="Categoría:\r\n O:".$rowh["icfotofoto"]."\r\nN: ".$rown["icfotofoto"]."\r\n\r\n";               if($rowh["fechafoto"]<>$rown["fechafoto"]) $cadena_historico.="Fecha:\r\n O:".$rowh["fechafoto"]."\r\nN: ".$rown["fechafoto"]."\r\n\r\n";               if($rowh["archivofoto"]<>$rown["archivofoto"]) $cadena_historico.="Archivo:\r\n O:".$rowh["archivofoto"]."\r\nN: ".$rown["archivofoto"]."\r\n\r\n";               if($rowh["ordenfoto"]<>$rown["ordenfoto"]) $cadena_historico.="Orden:\r\n O:".$rowh["ordenfoto"]."\r\nN: ".$rown["ordenfoto"]."\r\n\r\n";               if($rowh["titulofoto"]<>$rown["titulofoto"]) $cadena_historico.="Título:\r\n O:".$rowh["titulofoto"]."\r\nN: ".$rown["titulofoto"]."\r\n\r\n";               if($rowh["descripcionfoto"]<>$rown["descripcionfoto"]) $cadena_historico.="Descripción:\r\n O:".$rowh["descripcionfoto"]."\r\nN: ".$rown["descripcionfoto"]."\r\n\r\n";               if($rowh["iusuariofoto"]<>$rown["iusuariofoto"]) $cadena_historico.="Usuario:\r\n O:".$rowh["iusuariofoto"]."\r\nN: ".$rown["iusuariofoto"]."\r\n\r\n";               if($rowh["iusuariopublicofoto"]<>$rown["iusuariopublicofoto"]) $cadena_historico.="Usuario público:\r\n O:".$rowh["iusuariopublicofoto"]."\r\nN: ".$rown["iusuariopublicofoto"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_fotos"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_fotos"]="NADA";
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
		$sql = "DELETE FROM fotos WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=20,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_fotos"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,itablafoto FROM fotos where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["itablafoto"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=fotos.php?step=1".$url_extra."><span class=titulo>Fotos</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=fotos.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Fotos\"></a></td>";if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=fotos.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Fotos\"></a></td>";if( ($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) && $_SESSION["esframe_fotos"]) $botones.="<td><a href=fotos.php?step=1&esframe=2 target=_top><img src=recursos/botonmaximizar.gif border=\"0\" alt=Maximizar></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_fotos"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_fotos"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_fotos"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_fotos"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="fotos.activo DESC,itablafoto ASC"; $ordenamiento="";$activob1="="; $activob2="1";$fechafotol1="on"; $archivofotol1="on"; $ordenfotol1="on"; $titulofotol1="on"; $iusuariofotol1="on"; $iusuariopublicofotol1="on"; $statuspublicacionfotol1="on"; $reportesfotol1="on"; $destacadafotol1="on"; } $camposbuscadoslistadosearch="fotos.id";cbusqueda1($activol1,"fotos","activo");cbusqueda1($itablafotol1,"catablas","nombretabla","0","","");cbusqueda1($registrofotol1,"fotos","registrofoto");cbusqueda1($icfotofotol1,"fotos","icfotofoto");cbusqueda1($fechafotol1,"fotos","fechafoto");cbusqueda1($archivofotol1,"fotos","archivofoto");cbusqueda1($ordenfotol1,"fotos","ordenfoto");cbusqueda1($titulofotol1,"fotos","titulofoto");cbusqueda1($descripcionfotol1,"fotos","descripcionfoto");cbusqueda1($iusuariofotol1,"causuarios","usernameusuario","0","","");cbusqueda1($iusuariopublicofotol1,"usuarios","nombreusuario","0","","");cbusqueda1($statuspublicacionfotol1,"fotos","statuspublicacionfoto");cbusqueda1($reportesfotol1,"fotos","reportesfoto");cbusqueda1($destacadafotol1,"fotos","destacadafoto");cbusqueda1($tgustal1,"fotos","tgusta");cbusqueda1($tcomentariol1,"fotos","tcomentario");cbusqueda2($itablafotol1,"catablas","fotos","itablafoto","",0,"idtabla");cbusqueda2($iusuariofotol1,"causuarios","fotos","iusuariofoto","",0,"id");cbusqueda2($iusuariopublicofotol1,"usuarios","fotos","iusuariopublicofoto","",0,"id");cbusqueda3($itablafotob1,$itablafotob2,"fotos","itablafoto","","0","","");cbusqueda3($registrofotob1,$registrofotob2,"fotos","registrofoto","","0","","");cbusqueda3($icfotofotob1,$icfotofotob2,"fotos","icfotofoto","","0","","");cbusqueda3($fechafotob1,$fechafotob2,"fotos","fechafoto","'","0","","");cbusqueda3($archivofotob1,$archivofotob2,"fotos","archivofoto","'","0","","");cbusqueda3($ordenfotob1,$ordenfotob2,"fotos","ordenfoto","","0","","");cbusqueda3($titulofotob1,$titulofotob2,"fotos","titulofoto","'","0","","");cbusqueda3($descripcionfotob1,$descripcionfotob2,"fotos","descripcionfoto","'","0","","");cbusqueda3($iusuariofotob1,$iusuariofotob2,"fotos","iusuariofoto","","0","","");cbusqueda3($iusuariopublicofotob1,$iusuariopublicofotob2,"fotos","iusuariopublicofoto","","0","","");cbusqueda3($statuspublicacionfotob1,$statuspublicacionfotob2,"fotos","statuspublicacionfoto","'","0","","");cbusqueda3($reportesfotob1,$reportesfotob2,"fotos","reportesfoto","","0","","");cbusqueda3($destacadafotob1,$destacadafotob2,"fotos","destacadafoto","'","0","","");cbusqueda3($tgustab1,$tgustab2,"fotos","tgusta","","0","","");cbusqueda3($tcomentariob1,$tcomentariob2,"fotos","tcomentario","","0","","");cbusqueda3($activob1,$activob2,"fotos","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from fotos ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($itablafotol1,"Tabla",": STR","");cbusqueda5($registrofotol1,"Registro"," : NUM","");cbusqueda5($icfotofotol1,"Categoría"," : NUM","");cbusqueda5($fechafotol1,"Fecha"," : DATE","");cbusqueda5($archivofotol1,"Archivo",": STR","");cbusqueda5($ordenfotol1,"Orden"," : NUM","");cbusqueda5($titulofotol1,"Título",": STR","");cbusqueda5($descripcionfotol1,"Descripción",": STR","");cbusqueda5($iusuariofotol1,"Usuario",": STR","");cbusqueda5($iusuariopublicofotol1,"Usuario público",": STR","");cbusqueda5($statuspublicacionfotol1,"Status",": STR","");cbusqueda5($reportesfotol1,"Total reportes foto"," : NUM","");cbusqueda5($destacadafotol1,"Es destacada",": STR","");cbusqueda5($tgustal1,"Gusta"," : NUM","");cbusqueda5($tcomentariol1,"Comentarios"," : NUM",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='fotos.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($itablafotol1,"catablas","nombretabla","0","","");cbusqueda4($registrofotol1,"fotos","registrofoto","0","","");cbusqueda4($icfotofotol1,"fotos","icfotofoto","0","","");cbusqueda4($fechafotol1,"fotos","fechafoto","0","","");cbusqueda4($archivofotol1,"fotos","archivofoto","0","","");cbusqueda4($ordenfotol1,"fotos","ordenfoto","0","","");cbusqueda4($titulofotol1,"fotos","titulofoto","0","","");cbusqueda4($descripcionfotol1,"fotos","descripcionfoto","0","","");cbusqueda4($iusuariofotol1,"causuarios","usernameusuario","0","","");cbusqueda4($iusuariopublicofotol1,"usuarios","nombreusuario","0","",""); if($statuspublicacionfotol1=="on")  {  if($row["statuspublicacionfoto"]=="0") $tempostatuspublicacionfoto="Normal";if($row["statuspublicacionfoto"]=="1") $tempostatuspublicacionfoto="Reportado pero aprobado";if($row["statuspublicacionfoto"]=="2") $tempostatuspublicacionfoto="Reportado";if($row["statuspublicacionfoto"]=="3") $tempostatuspublicacionfoto="Censurado";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempostatuspublicacionfoto.$tempotigra."\""; $tempotigra="";  } cbusqueda4($reportesfotol1,"fotos","reportesfoto","0","",""); if($destacadafotol1=="on")  {  if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempodestacadafoto.$tempotigra."\""; $tempotigra="";  } cbusqueda4($tgustal1,"fotos","tgusta","0","","");cbusqueda4($tcomentariol1,"fotos","tcomentario","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($itablafotol1,$sumatoriaitablafoto,'');cbusqueda6($registrofotol1,$sumatoriaregistrofoto,'');cbusqueda6($icfotofotol1,$sumatoriaicfotofoto,'');cbusqueda6($fechafotol1,$sumatoriafechafoto,'');cbusqueda6($archivofotol1,$sumatoriaarchivofoto,'');cbusqueda6($ordenfotol1,$sumatoriaordenfoto,'');cbusqueda6($titulofotol1,$sumatoriatitulofoto,'');cbusqueda6($descripcionfotol1,$sumatoriadescripcionfoto,'');cbusqueda6($iusuariofotol1,$sumatoriaiusuariofoto,'');cbusqueda6($iusuariopublicofotol1,$sumatoriaiusuariopublicofoto,'');cbusqueda6($statuspublicacionfotol1,$sumatoriastatuspublicacionfoto,'');cbusqueda6($reportesfotol1,$sumatoriareportesfoto,'');cbusqueda6($destacadafotol1,$sumatoriadestacadafoto,'');cbusqueda6($tgustal1,$sumatoriatgusta,'');cbusqueda6($tcomentariol1,$sumatoriatcomentario,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelfotos.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=itablafotol1 type="hidden" value="<?=$itablafotol1?>" ><input name=itablafotob1 type="hidden" value="<?=$itablafotob1?>" ><input name=itablafotob2 type="hidden" value="<?=$itablafotob2?>" ><input name=registrofotol1 type="hidden" value="<?=$registrofotol1?>" ><input name=registrofotob1 type="hidden" value="<?=$registrofotob1?>" ><input name=registrofotob2 type="hidden" value="<?=$registrofotob2?>" ><input name=icfotofotol1 type="hidden" value="<?=$icfotofotol1?>" ><input name=icfotofotob1 type="hidden" value="<?=$icfotofotob1?>" ><input name=icfotofotob2 type="hidden" value="<?=$icfotofotob2?>" ><input name=fechafotol1 type="hidden" value="<?=$fechafotol1?>" ><input name=fechafotob1 type="hidden" value="<?=$fechafotob1?>" ><input name=fechafotob2 type="hidden" value="<?=$fechafotob2?>" ><input name=archivofotol1 type="hidden" value="<?=$archivofotol1?>" ><input name=archivofotob1 type="hidden" value="<?=$archivofotob1?>" ><input name=archivofotob2 type="hidden" value="<?=$archivofotob2?>" ><input name=ordenfotol1 type="hidden" value="<?=$ordenfotol1?>" ><input name=ordenfotob1 type="hidden" value="<?=$ordenfotob1?>" ><input name=ordenfotob2 type="hidden" value="<?=$ordenfotob2?>" ><input name=titulofotol1 type="hidden" value="<?=$titulofotol1?>" ><input name=titulofotob1 type="hidden" value="<?=$titulofotob1?>" ><input name=titulofotob2 type="hidden" value="<?=$titulofotob2?>" ><input name=descripcionfotol1 type="hidden" value="<?=$descripcionfotol1?>" ><input name=descripcionfotob1 type="hidden" value="<?=$descripcionfotob1?>" ><input name=descripcionfotob2 type="hidden" value="<?=$descripcionfotob2?>" ><input name=iusuariofotol1 type="hidden" value="<?=$iusuariofotol1?>" ><input name=iusuariofotob1 type="hidden" value="<?=$iusuariofotob1?>" ><input name=iusuariofotob2 type="hidden" value="<?=$iusuariofotob2?>" ><input name=iusuariopublicofotol1 type="hidden" value="<?=$iusuariopublicofotol1?>" ><input name=iusuariopublicofotob1 type="hidden" value="<?=$iusuariopublicofotob1?>" ><input name=iusuariopublicofotob2 type="hidden" value="<?=$iusuariopublicofotob2?>" ><input name=statuspublicacionfotol1 type="hidden" value="<?=$statuspublicacionfotol1?>" ><input name=statuspublicacionfotob1 type="hidden" value="<?=$statuspublicacionfotob1?>" ><input name=statuspublicacionfotob2 type="hidden" value="<?=$statuspublicacionfotob2?>" ><input name=reportesfotol1 type="hidden" value="<?=$reportesfotol1?>" ><input name=reportesfotob1 type="hidden" value="<?=$reportesfotob1?>" ><input name=reportesfotob2 type="hidden" value="<?=$reportesfotob2?>" ><input name=destacadafotol1 type="hidden" value="<?=$destacadafotol1?>" ><input name=destacadafotob1 type="hidden" value="<?=$destacadafotob1?>" ><input name=destacadafotob2 type="hidden" value="<?=$destacadafotob2?>" ><input name=tgustal1 type="hidden" value="<?=$tgustal1?>" ><input name=tgustab1 type="hidden" value="<?=$tgustab1?>" ><input name=tgustab2 type="hidden" value="<?=$tgustab2?>" ><input name=tcomentariol1 type="hidden" value="<?=$tcomentariol1?>" ><input name=tcomentariob1 type="hidden" value="<?=$tcomentariob1?>" ><input name=tcomentariob2 type="hidden" value="<?=$tcomentariob2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelfotos.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
var HINTS_ITEMS = {'fechafoto':wrap("aaaa-mm-dd, 2008-11-18"),'activo':wrap("Seleccion SI para que el registro esté activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  <script>var directorio='../include';</script><script language="JavaScript" src="../include/calendar/calendar.js"></script><link rel="stylesheet" href="../include/calendar/calendar.css">
	<?
	
if($error_unique==0)
{
$itablafoto=0;$registrofoto=0;$icfotofoto=0;$fecha=date("Y-m-d"); $fechafoto=substr($fecha, 0, 4)."-".substr($fecha, 5, 2)."-".substr($fecha, 8, 2);$archivofoto='';$ordenfoto=0;$titulofoto='';$descripcionfoto='';$iusuariofoto=0;$iusuariopublicofoto=0;$statuspublicacionfoto='0';$reportesfoto=0;$destacadafoto='0';$tgusta=0;$tcomentario=0;$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["itablafoto"])) $itablafoto=$_POST["itablafoto"];if(isset($_POST["registrofoto"])) $registrofoto=$_POST["registrofoto"];if(isset($_POST["icfotofoto"])) $icfotofoto=$_POST["icfotofoto"];if(isset($_POST["fechafoto"])) $fechafoto=$_POST["fechafoto"];if(isset($_POST["archivofoto"])) $archivofoto=$_POST["archivofoto"];if(isset($_POST["ordenfoto"])) $ordenfoto=$_POST["ordenfoto"];if(isset($_POST["titulofoto"])) $titulofoto=$_POST["titulofoto"];if(isset($_POST["descripcionfoto"])) $descripcionfoto=$_POST["descripcionfoto"];if(isset($_POST["iusuariofoto"])) $iusuariofoto=$_POST["iusuariofoto"];if(isset($_POST["iusuariopublicofoto"])) $iusuariopublicofoto=$_POST["iusuariopublicofoto"];if(isset($_POST["statuspublicacionfoto"])) $statuspublicacionfoto=$_POST["statuspublicacionfoto"];if(isset($_POST["reportesfoto"])) $reportesfoto=$_POST["reportesfoto"];if(isset($_POST["destacadafoto"])) $destacadafoto=$_POST["destacadafoto"];if(isset($_POST["tgusta"])) $tgusta=$_POST["tgusta"];if(isset($_POST["tcomentario"])) $tcomentario=$_POST["tcomentario"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM fotos where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM fotos where id=". $id);
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
$itablafoto=$row["itablafoto"];$registrofoto=$row["registrofoto"];$icfotofoto=$row["icfotofoto"];$fechafoto=$row["fechafoto"];if($fechafoto=="0000-00-00") $fechafoto="";$archivofoto=$row["archivofoto"];$ordenfoto=$row["ordenfoto"];$titulofoto=$row["titulofoto"];$descripcionfoto=$row["descripcionfoto"];$iusuariofoto=$row["iusuariofoto"];$iusuariopublicofoto=$row["iusuariopublicofoto"];$statuspublicacionfoto=$row["statuspublicacionfoto"];$reportesfoto=$row["reportesfoto"];$destacadafoto=$row["destacadafoto"];$tgusta=$row["tgusta"];$tcomentario=$row["tcomentario"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="fotos.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('fotos.php?sortfield=itablafoto&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_itablafoto" name="t_itablafoto">Tabla * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="itablafoto" id="itablafoto"  class=textogeneralform><option value="0" selected></option><?  leecampos("catablas","idtabla","nombretabla","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($itablafoto==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? $valor_mostrar=lee_registro("catablas","nombretabla","","",$itablafoto,"idtabla");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_registrofoto" name="t_registrofoto">Registro * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="registrofoto" id="registrofoto" value="<? echo(formato_numero($registrofoto,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('registrofoto')" onBlur="pone_pesos('registrofoto','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? echo(formato_numero($registrofoto,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_icfotofoto" name="t_icfotofoto">Categoría * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="icfotofoto" id="icfotofoto" value="<? echo(formato_numero($icfotofoto,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('icfotofoto')" onBlur="pone_pesos('icfotofoto','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? echo(formato_numero($icfotofoto,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fechafoto" name="t_fechafoto">Fecha * <a onMouseOver="myHint.show('fechafoto')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="fechafoto" id="fechafoto" value="<?=$fechafoto?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT1 = {	'formname' : 'form1','controlname': 'fechafoto','dataformat' : 'Y-m-d','today' : '<?=$fechafoto?>','positionname':'fechafoto','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT1, CAL_TPL1);</script><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><?=$fechafoto?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_archivofoto" name="t_archivofoto">Archivo * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="archivofoto" id="archivofoto" value="<? echo(htmlspecialchars($archivofoto,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><?=$archivofoto?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ordenfoto" name="t_ordenfoto">Orden * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="ordenfoto" id="ordenfoto" value="<? echo(formato_numero($ordenfoto,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('ordenfoto')" onBlur="pone_pesos('ordenfoto','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? echo(formato_numero($ordenfoto,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_titulofoto" name="t_titulofoto">Título </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="titulofoto" id="titulofoto" value="<? echo(htmlspecialchars($titulofoto,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$titulofoto?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_descripcionfoto" name="t_descripcionfoto">Descripción </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="descripcionfoto" id="descripcionfoto" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($descripcionfoto,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10)) { ?><?=$descripcionfoto?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuariofoto" name="t_iusuariofoto">Usuario </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="iusuariofoto" id="iusuariofoto"  class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","usernameusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariofoto==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? $valor_mostrar=lee_registro("causuarios","usernameusuario","","",$iusuariofoto,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuariopublicofoto" name="t_iusuariopublicofoto">Usuario público </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="iusuariopublicofoto" id="iusuariopublicofoto"  class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariopublicofoto==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? $valor_mostrar=lee_registro("usuarios","nombreusuario","","",$iusuariopublicofoto,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_statuspublicacionfoto" name="t_statuspublicacionfoto">Status </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="statuspublicacionfoto" id="statuspublicacionfoto" class=textogeneralform><OPTION VALUE="0" <? if($statuspublicacionfoto=="0") echo("selected");?> >Normal</option><OPTION VALUE="1" <? if($statuspublicacionfoto=="1") echo("selected");?> >Reportado pero aprobado</option><OPTION VALUE="2" <? if($statuspublicacionfoto=="2") echo("selected");?> >Reportado</option><OPTION VALUE="3" <? if($statuspublicacionfoto=="3") echo("selected");?> >Censurado</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($statuspublicacionfoto=="0") echo("Normal");if($statuspublicacionfoto=="1") echo("Reportado pero aprobado");if($statuspublicacionfoto=="2") echo("Reportado");if($statuspublicacionfoto=="3") echo("Censurado"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_reportesfoto" name="t_reportesfoto">Total reportes foto </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="reportesfoto" id="reportesfoto" value="<? echo(formato_numero($reportesfoto,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('reportesfoto')" onBlur="pone_pesos('reportesfoto','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? echo(formato_numero($reportesfoto,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_destacadafoto" name="t_destacadafoto">Es destacada </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="destacadafoto" id="destacadafoto" class=textogeneralform></select><? } ?><? if(($nivelusuario==10)) { ?><?  ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $step<>"add"  && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tgusta" name="t_tgusta">Gusta </td><td valign="middle"><? if(($nivelusuario==10) && $step<>"add") { ?><input type="text" name="tgusta" id="tgusta" value="<? echo(formato_numero($tgusta,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tgusta')" onBlur="pone_pesos('tgusta','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 ) ) { ?><? echo(formato_numero($tgusta,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $step<>"add"  && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tcomentario" name="t_tcomentario">Comentarios </td><td valign="middle"><? if(($nivelusuario==10) && $step<>"add") { ?><input type="text" name="tcomentario" id="tcomentario" value="<? echo(formato_numero($tcomentario,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tcomentario')" onBlur="pone_pesos('tcomentario','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 ) ) { ?><? echo(formato_numero($tcomentario,'')); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'itablafoto':{'l':'Tabla','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_itablafoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'registrofoto':{'l':'Registro','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_registrofoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'icfotofoto':{'l':'Categoría','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_icfotofoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fechafoto':{'l':'Fecha','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_fechafoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'archivofoto':{'l':'Archivo','r': true,'t':'t_archivofoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ordenfoto':{'l':'Orden','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_ordenfoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuariofoto':{'l':'Usuario','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_iusuariofoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuariopublicofoto':{'l':'Usuario público','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_iusuariopublicofoto'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'reportesfoto':{'l':'Total reportes foto','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_reportesfoto'}";?><? } ?><? if(($nivelusuario==10) && $step<>"add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tgusta':{'l':'Gusta','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tgusta'}";?><? } ?><? if(($nivelusuario==10) && $step<>"add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tcomentario':{'l':'Comentarios','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tcomentario'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
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
      <td width=100%  valign=top><form name="form2" method="post" action="fotos.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="itablafoto" selected>Tabla</option><option value="registrofoto">Registro</option><option value="icfotofoto">Categoría</option><option value="fechafoto">Fecha</option><option value="archivofoto">Archivo</option><option value="ordenfoto">Orden</option><option value="titulofoto">Título</option><option value="descripcionfoto">Descripción</option><option value="iusuariofoto">Usuario</option><option value="iusuariopublicofoto">Usuario público</option><option value="statuspublicacionfoto">Status</option><option value="reportesfoto">Total reportes foto</option><option value="destacadafoto">Es destacada</option><option value="tgusta">Gusta</option><option value="tcomentario">Comentarios</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('fotos.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Tabla</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="itablafotol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="itablafotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="itablafotob2" onChange="if(itablafotob1.selectedIndex==0) itablafotob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("catablas","idtabla","nombretabla","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($itablafoto==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Registro</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="registrofotol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="registrofotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="registrofotob2" value="" size="10" onKeyUp="revisainput('registrofotob1','registrofotob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Categoría</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="icfotofotol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="icfotofotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="icfotofotob2" value="" size="10" onKeyUp="revisainput('icfotofotob1','icfotofotob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="fechafotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="fechafotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechafotob2" value="" size="15" onKeyUp="revisainput('fechafotob1','fechafotob2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Archivo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="archivofotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="archivofotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="archivofotob2" id="archivofoto" value="" size="50" onKeyUp="revisainput('archivofotob1','archivofotob2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Orden</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="ordenfotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="ordenfotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ordenfotob2" value="" size="10" onKeyUp="revisainput('ordenfotob1','ordenfotob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Título</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="titulofotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="titulofotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="titulofotob2" value="" size="55" onKeyUp="revisainput('titulofotob1','titulofotob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Descripción</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="descripcionfotol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="descripcionfotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="descripcionfotob2" value="" size="50" onKeyUp="revisainput('descripcionfotob1','descripcionfotob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="iusuariofotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="iusuariofotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuariofotob2" onChange="if(iusuariofotob1.selectedIndex==0) iusuariofotob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("causuarios","id","usernameusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariofoto==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario público</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="iusuariopublicofotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="iusuariopublicofotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuariopublicofotob2" onChange="if(iusuariopublicofotob1.selectedIndex==0) iusuariopublicofotob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariopublicofoto==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Status</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="statuspublicacionfotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="statuspublicacionfotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="statuspublicacionfotob2" onChange="if(statuspublicacionfotob1.selectedIndex==0) statuspublicacionfotob1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($statuspublicacionfoto=="0") { ?>selected<? } ?> >Normal</option><OPTION VALUE="1" <? if($statuspublicacionfoto=="1") { ?>selected<? } ?> >Reportado pero aprobado</option><OPTION VALUE="2" <? if($statuspublicacionfoto=="2") { ?>selected<? } ?> >Reportado</option><OPTION VALUE="3" <? if($statuspublicacionfoto=="3") { ?>selected<? } ?> >Censurado</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Total reportes foto</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="reportesfotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="reportesfotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="reportesfotob2" value="" size="10" onKeyUp="revisainput('reportesfotob1','reportesfotob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Es destacada</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="destacadafotol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="destacadafotob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="destacadafotob2" onChange="if(destacadafotob1.selectedIndex==0) destacadafotob1.selectedIndex=1" class=textogeneralform></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $step<>"add"  && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Gusta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="tgustal1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="tgustab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tgustab2" value="" size="10" onKeyUp="revisainput('tgustab1','tgustab2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $step<>"add"  && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Comentarios</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="tcomentariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="tcomentariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tcomentariob2" value="" size="10" onKeyUp="revisainput('tcomentariob1','tcomentariob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?> 
	
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('fotos.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0 || $nivelusuario==1) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelfotos.php?step=busqueda2<?=$url_extra?>');">
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

