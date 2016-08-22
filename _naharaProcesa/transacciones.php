<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_transacciones"]=1;
	$_SESSION["esframe_transacciones_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_transacciones_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_transacciones"]=0;
	$_SESSION["esframe_transacciones_id"]=0;
	$_SESSION["esframe_transacciones_archivo"]="";
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

$numerodetabla=9;
include("recursos/funciones_tabla.php"); 
$archivoactual="transacciones.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_transacciones"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($fechal1=="on" || $tokenl1=="on" || $payeridl1=="on" || $totall1=="on" || $monedal1=="on" || $urlexecutel1=="on" || $urlverificl1=="on" || $urlrefundl1=="on" || $statel1=="on" || $respuestal1=="on" || $respuestaipnl1=="on" || $executadol1=="on" || $tipol1=="on") $error=9;     if(isset($fechab2) || isset($tokenb2) || isset($payeridb2) || isset($totalb2) || isset($monedab2) || isset($urlexecuteb2) || isset($urlverificb2) || isset($urlrefundb2) || isset($stateb2) || isset($respuestab2) || isset($respuestaipnb2) || isset($executadob2) || isset($tipob2)) $error=9;   }  if($nivelusuario==2)   {     if($fechal1=="on" || $tokenl1=="on" || $payeridl1=="on" || $totall1=="on" || $monedal1=="on" || $urlexecutel1=="on" || $urlverificl1=="on" || $urlrefundl1=="on" || $statel1=="on" || $respuestal1=="on" || $respuestaipnl1=="on" || $executadol1=="on" || $tipol1=="on") $error=9;     if(isset($fechab2) || isset($tokenb2) || isset($payeridb2) || isset($totalb2) || isset($monedab2) || isset($urlexecuteb2) || isset($urlverificb2) || isset($urlrefundb2) || isset($stateb2) || isset($respuestab2) || isset($respuestaipnb2) || isset($executadob2) || isset($tipob2)) $error=9;   }  if($nivelusuario==3)   {     if($fechal1=="on" || $tokenl1=="on" || $payeridl1=="on" || $totall1=="on" || $monedal1=="on" || $urlexecutel1=="on" || $urlverificl1=="on" || $urlrefundl1=="on" || $statel1=="on" || $respuestal1=="on" || $respuestaipnl1=="on" || $executadol1=="on" || $tipol1=="on") $error=9;     if(isset($fechab2) || isset($tokenb2) || isset($payeridb2) || isset($totalb2) || isset($monedab2) || isset($urlexecuteb2) || isset($urlverificb2) || isset($urlrefundb2) || isset($stateb2) || isset($respuestab2) || isset($respuestaipnb2) || isset($executadob2) || isset($tipob2)) $error=9;   }  if($nivelusuario==4)   {     if($fechal1=="on" || $tokenl1=="on" || $payeridl1=="on" || $totall1=="on" || $monedal1=="on" || $urlexecutel1=="on" || $urlverificl1=="on" || $urlrefundl1=="on" || $statel1=="on" || $respuestal1=="on" || $respuestaipnl1=="on" || $executadol1=="on" || $tipol1=="on") $error=9;     if(isset($fechab2) || isset($tokenb2) || isset($payeridb2) || isset($totalb2) || isset($monedab2) || isset($urlexecuteb2) || isset($urlverificb2) || isset($urlrefundb2) || isset($stateb2) || isset($respuestab2) || isset($respuestaipnb2) || isset($executadob2) || isset($tipob2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=8;   if($nivelusuario==1) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=8;   if($nivelusuario==2) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=8;   if($nivelusuario==3) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=8;   if($nivelusuario==4) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=7;   if($nivelusuario==1) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=7;   if($nivelusuario==2) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=7;   if($nivelusuario==3) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=7;   if($nivelusuario==4) if(isset($_POST["idon"]) || isset($_POST["fecha"]) || isset($_POST["token"]) || isset($_POST["payerid"]) || isset($_POST["total"]) || isset($_POST["moneda"]) || isset($_POST["urlexecute"]) || isset($_POST["urlverific"]) || isset($_POST["urlrefund"]) || isset($_POST["state"]) || isset($_POST["respuesta"]) || isset($_POST["respuestaipn"]) || isset($_POST["executado"]) || isset($_POST["tipo"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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


<?if($_SESSION["esframe_transacciones"]==1){  if($_SESSION["esframe_transacciones_archivo"]=="don")  {    if($step=="add")    {      $idon=$_SESSION["id_don"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $idonb1="=";      $idonb2=$_SESSION["id_don"];    }  }}?>


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
    if($_SESSION["esframe_transacciones"]<>1)
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
  if(isset($_POST["tipo"])) $_POST["tipo"]=limpia_numero($_POST["tipo"]);
  
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
      $sqltemporal.=construyesqltemporal("idon","",0);$sqltemporal.=construyesqltemporal("fecha","'",0);$sqltemporal.=construyesqltemporal("token","'",0);$sqltemporal.=construyesqltemporal("payerid","'",0);$sqltemporal.=construyesqltemporal("total","'",0);$sqltemporal.=construyesqltemporal("moneda","'",0);$sqltemporal.=construyesqltemporal("urlexecute","'",0);$sqltemporal.=construyesqltemporal("urlverific","'",0);$sqltemporal.=construyesqltemporal("urlrefund","'",0);$sqltemporal.=construyesqltemporal("state","'",0);$sqltemporal.=construyesqltemporal("respuesta","'",0);$sqltemporal.=construyesqltemporal("respuestaipn","'",0);$sqltemporal.=construyesqltemporal("executado","'",0);$sqltemporal.=construyesqltemporal("tipo","",2);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
      	
		  $sql = "INSERT INTO transacciones SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=9,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_transacciones"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_transacciones"]="OK";
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
		  $sql = "UPDATE transacciones SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=9,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			  
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_transacciones"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_transacciones"]="NADA";
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
		$sql = "DELETE FROM transacciones WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=9,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_transacciones"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,idon FROM transacciones where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["idon"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=transacciones.php?step=1".$url_extra."><span class=titulo>Transacciones</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0) $botones.="<td><a href=transacciones.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Transacciones\"></a></td>";if($nivelusuario==0) $botones.="<td><a href=transacciones.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Transacciones\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_transacciones"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_transacciones"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_transacciones"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_transacciones"]="";


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
	$statel1="on";
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="transacciones.activo DESC,idon ASC"; $ordenamiento="";$activob1="="; $activob2="1";$idonl1="on"; $fechal1="on"; $tokenl1="on"; $payeridl1="on"; } $camposbuscadoslistadosearch="transacciones.id";cbusqueda1($activol1,"transacciones","activo");cbusqueda1($idonl1,"don","fechadon","0","","");cbusqueda1($fechal1,"transacciones","fecha");cbusqueda1($tokenl1,"transacciones","token");cbusqueda1($payeridl1,"transacciones","payerid");cbusqueda1($totall1,"transacciones","total");cbusqueda1($monedal1,"transacciones","moneda");cbusqueda1($urlexecutel1,"transacciones","urlexecute");cbusqueda1($urlverificl1,"transacciones","urlverific");cbusqueda1($urlrefundl1,"transacciones","urlrefund");cbusqueda1($statel1,"transacciones","state");cbusqueda1($respuestal1,"transacciones","respuesta");cbusqueda1($respuestaipnl1,"transacciones","respuestaipn");cbusqueda1($executadol1,"transacciones","executado");cbusqueda1($tipol1,"transacciones","tipo");cbusqueda2($idonl1,"don","transacciones","idon","",0,"id");cbusqueda3($idonb1,$idonb2,"transacciones","idon","","0","","");cbusqueda3($fechab1,$fechab2,"transacciones","fecha","'","0","","");cbusqueda3($tokenb1,$tokenb2,"transacciones","token","'","0","","");cbusqueda3($payeridb1,$payeridb2,"transacciones","payerid","'","0","","");cbusqueda3($totalb1,$totalb2,"transacciones","total","'","0","","");cbusqueda3($monedab1,$monedab2,"transacciones","moneda","'","0","","");cbusqueda3($urlexecuteb1,$urlexecuteb2,"transacciones","urlexecute","'","0","","");cbusqueda3($urlverificb1,$urlverificb2,"transacciones","urlverific","'","0","","");cbusqueda3($urlrefundb1,$urlrefundb2,"transacciones","urlrefund","'","0","","");cbusqueda3($stateb1,$stateb2,"transacciones","state","'","0","","");cbusqueda3($respuestab1,$respuestab2,"transacciones","respuesta","'","0","","");cbusqueda3($respuestaipnb1,$respuestaipnb2,"transacciones","respuestaipn","'","0","","");cbusqueda3($executadob1,$executadob2,"transacciones","executado","'","0","","");cbusqueda3($tipob1,$tipob2,"transacciones","tipo","","0","","");cbusqueda3($activob1,$activob2,"transacciones","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from transacciones ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($idonl1,"Donativo",": STR","");cbusqueda5($fechal1,"Fecha"," : DATE","");cbusqueda5($tokenl1,"Token",": STR","");cbusqueda5($payeridl1,"Payerid",": STR","");cbusqueda5($totall1,"Total",": STR","");cbusqueda5($monedal1,"Moneda",": STR","");cbusqueda5($urlexecutel1,"URL execute",": STR","");cbusqueda5($urlverificl1,"URL verific",": STR","");cbusqueda5($urlrefundl1,"URL Refund",": STR","");cbusqueda5($statel1,"State",": STR","");cbusqueda5($respuestal1,"Respuesta",": STR","");cbusqueda5($respuestaipnl1,"Respuesta IPN",": STR","");cbusqueda5($executadol1,"Executado",": STR","");cbusqueda5($tipol1,"Tipo"," : NUM",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='transacciones.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($idonl1,"don","fechadon","0","","");cbusqueda4($fechal1,"transacciones","fecha","0","","");cbusqueda4($tokenl1,"transacciones","token","0","","");cbusqueda4($payeridl1,"transacciones","payerid","0","","");cbusqueda4($totall1,"transacciones","total","0","","");cbusqueda4($monedal1,"transacciones","moneda","0","","");cbusqueda4($urlexecutel1,"transacciones","urlexecute","0","","");cbusqueda4($urlverificl1,"transacciones","urlverific","0","","");cbusqueda4($urlrefundl1,"transacciones","urlrefund","0","","");cbusqueda4($statel1,"transacciones","state","0","","");cbusqueda4($respuestal1,"transacciones","respuesta","0","","");cbusqueda4($respuestaipnl1,"transacciones","respuestaipn","0","","");cbusqueda4($executadol1,"transacciones","executado","0","","");cbusqueda4($tipol1,"transacciones","tipo","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($idonl1,$sumatoriaidon,'');cbusqueda6($fechal1,$sumatoriafecha,'');cbusqueda6($tokenl1,$sumatoriatoken,'');cbusqueda6($payeridl1,$sumatoriapayerid,'');cbusqueda6($totall1,$sumatoriatotal,'');cbusqueda6($monedal1,$sumatoriamoneda,'');cbusqueda6($urlexecutel1,$sumatoriaurlexecute,'');cbusqueda6($urlverificl1,$sumatoriaurlverific,'');cbusqueda6($urlrefundl1,$sumatoriaurlrefund,'');cbusqueda6($statel1,$sumatoriastate,'');cbusqueda6($respuestal1,$sumatoriarespuesta,'');cbusqueda6($respuestaipnl1,$sumatoriarespuestaipn,'');cbusqueda6($executadol1,$sumatoriaexecutado,'');cbusqueda6($tipol1,$sumatoriatipo,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/exceltransacciones.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=idonl1 type="hidden" value="<?=$idonl1?>" ><input name=idonb1 type="hidden" value="<?=$idonb1?>" ><input name=idonb2 type="hidden" value="<?=$idonb2?>" ><input name=fechal1 type="hidden" value="<?=$fechal1?>" ><input name=fechab1 type="hidden" value="<?=$fechab1?>" ><input name=fechab2 type="hidden" value="<?=$fechab2?>" ><input name=tokenl1 type="hidden" value="<?=$tokenl1?>" ><input name=tokenb1 type="hidden" value="<?=$tokenb1?>" ><input name=tokenb2 type="hidden" value="<?=$tokenb2?>" ><input name=payeridl1 type="hidden" value="<?=$payeridl1?>" ><input name=payeridb1 type="hidden" value="<?=$payeridb1?>" ><input name=payeridb2 type="hidden" value="<?=$payeridb2?>" ><input name=totall1 type="hidden" value="<?=$totall1?>" ><input name=totalb1 type="hidden" value="<?=$totalb1?>" ><input name=totalb2 type="hidden" value="<?=$totalb2?>" ><input name=monedal1 type="hidden" value="<?=$monedal1?>" ><input name=monedab1 type="hidden" value="<?=$monedab1?>" ><input name=monedab2 type="hidden" value="<?=$monedab2?>" ><input name=urlexecutel1 type="hidden" value="<?=$urlexecutel1?>" ><input name=urlexecuteb1 type="hidden" value="<?=$urlexecuteb1?>" ><input name=urlexecuteb2 type="hidden" value="<?=$urlexecuteb2?>" ><input name=urlverificl1 type="hidden" value="<?=$urlverificl1?>" ><input name=urlverificb1 type="hidden" value="<?=$urlverificb1?>" ><input name=urlverificb2 type="hidden" value="<?=$urlverificb2?>" ><input name=urlrefundl1 type="hidden" value="<?=$urlrefundl1?>" ><input name=urlrefundb1 type="hidden" value="<?=$urlrefundb1?>" ><input name=urlrefundb2 type="hidden" value="<?=$urlrefundb2?>" ><input name=statel1 type="hidden" value="<?=$statel1?>" ><input name=stateb1 type="hidden" value="<?=$stateb1?>" ><input name=stateb2 type="hidden" value="<?=$stateb2?>" ><input name=respuestal1 type="hidden" value="<?=$respuestal1?>" ><input name=respuestab1 type="hidden" value="<?=$respuestab1?>" ><input name=respuestab2 type="hidden" value="<?=$respuestab2?>" ><input name=respuestaipnl1 type="hidden" value="<?=$respuestaipnl1?>" ><input name=respuestaipnb1 type="hidden" value="<?=$respuestaipnb1?>" ><input name=respuestaipnb2 type="hidden" value="<?=$respuestaipnb2?>" ><input name=executadol1 type="hidden" value="<?=$executadol1?>" ><input name=executadob1 type="hidden" value="<?=$executadob1?>" ><input name=executadob2 type="hidden" value="<?=$executadob2?>" ><input name=tipol1 type="hidden" value="<?=$tipol1?>" ><input name=tipob1 type="hidden" value="<?=$tipob1?>" ><input name=tipob2 type="hidden" value="<?=$tipob2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/exceltransacciones.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
$idon=0;$fecha='';$token='';$payerid='';$total='';$moneda='';$urlexecute='';$urlverific='';$urlrefund='';$state='';$respuesta='';$respuestaipn='';$executado='';$tipo=0;$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["idon"])) $idon=$_POST["idon"];if(isset($_POST["fecha"])) $fecha=$_POST["fecha"];if(isset($_POST["token"])) $token=$_POST["token"];if(isset($_POST["payerid"])) $payerid=$_POST["payerid"];if(isset($_POST["total"])) $total=$_POST["total"];if(isset($_POST["moneda"])) $moneda=$_POST["moneda"];if(isset($_POST["urlexecute"])) $urlexecute=$_POST["urlexecute"];if(isset($_POST["urlverific"])) $urlverific=$_POST["urlverific"];if(isset($_POST["urlrefund"])) $urlrefund=$_POST["urlrefund"];if(isset($_POST["state"])) $state=$_POST["state"];if(isset($_POST["respuesta"])) $respuesta=$_POST["respuesta"];if(isset($_POST["respuestaipn"])) $respuestaipn=$_POST["respuestaipn"];if(isset($_POST["executado"])) $executado=$_POST["executado"];if(isset($_POST["tipo"])) $tipo=$_POST["tipo"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM transacciones where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM transacciones where id=". $id);
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
$idon=$row["idon"];$fecha=$row["fecha"];$token=$row["token"];$payerid=$row["payerid"];$total=$row["total"];$moneda=$row["moneda"];$urlexecute=$row["urlexecute"];$urlverific=$row["urlverific"];$urlrefund=$row["urlrefund"];$state=$row["state"];$respuesta=$row["respuesta"];$respuestaipn=$row["respuestaipn"];$executado=$row["executado"];$tipo=$row["tipo"];$idtransaccionfinal=$row["idtransaccionfinal"];$fechafinal=$row["fechafinal"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="transacciones.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <a href="don.php?step=modify&id=<?=$idon?>" class="textoboton" style="padding:5px">Ver donativo</a><? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('transacciones.php?sortfield=idon&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" >
	  <td valign="middle" id="t_idon" name="t_idon">Fecha del Donativo </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idon" id="idon"  class=textogeneralform><option value="0" selected></option><?  leecampos("don","id","fechadon","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $valor_mostrar=lee_registro("don","fechadon","","",$idon,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fecha" name="t_fecha">Fecha </td><td valign="middle"><?=$fecha?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_token" name="t_token">Token </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="token" id="token" value="<? echo(htmlspecialchars($token,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="180"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$token?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_payerid" name="t_payerid">Payerid </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="payerid" id="payerid" value="<? echo(htmlspecialchars($payerid,ENT_COMPAT,'ISO-8859-1')); ?>" size="35" maxlength="30" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$payerid?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_total" name="t_total">Total </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="total" id="total" value="<? echo(htmlspecialchars($total,ENT_COMPAT,'ISO-8859-1')); ?>" size="15" maxlength="10" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$total?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_moneda" name="t_moneda">Moneda </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="moneda" id="moneda" value="<? echo(htmlspecialchars($moneda,ENT_COMPAT,'ISO-8859-1')); ?>" size="8" maxlength="3" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$moneda?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_urlexecute" name="t_urlexecute">URL execute </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="urlexecute" id="urlexecute" value="<? echo(htmlspecialchars($urlexecute,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="150"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$urlexecute?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_urlverific" name="t_urlverific">URL verific </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="urlverific" id="urlverific" value="<? echo(htmlspecialchars($urlverific,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$urlverific?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_urlrefund" name="t_urlrefund">URL Refund </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="urlrefund" id="urlrefund" value="<? echo(htmlspecialchars($urlrefund,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$urlrefund?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_state" name="t_state">State </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="state" id="state" value="<? echo(htmlspecialchars($state,ENT_COMPAT,'ISO-8859-1')); ?>" size="35" maxlength="30" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$state?><? } ?></td></tr><? } ?>
	  
	  <? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_respuesta" name="t_respuesta">Respuesta </td><td valign="middle"><? if(($nivelusuario==10)) { ?><textarea name="respuesta" id="respuesta" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($respuesta,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$respuesta?><? } ?></td></tr><? } ?>
	  
	  <? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_respuestaipn" name="t_respuestaipn">Respuesta IPN </td><td valign="middle"><? if(($nivelusuario==10)) { ?><textarea name="respuestaipn" id="respuestaipn" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($respuestaipn,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$respuestaipn?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_executado" name="t_executado">Executado </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="executado" id="executado" value="<? echo(htmlspecialchars($executado,ENT_COMPAT,'ISO-8859-1')); ?>" size="7" maxlength="2" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$executado?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tipo" name="t_tipo">Tipo </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="tipo" id="tipo" value="<? echo(formato_numero($tipo,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tipo')" onBlur="pone_pesos('tipo','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? echo(formato_numero($tipo,'')); ?><? } ?></td></tr><? } ?>
      
<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_idtransaccionfinal" name="t_idtransaccionfinal">ID Transacci&oacute;n final </td><td valign="middle"><? if(($nivelusuario==10)) { ?><textarea name="idtransaccionfinal" id="idtransaccionfinal" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($idtransaccionfinal,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$idtransaccionfinal?><? } ?></td></tr><? } ?>

<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_fechafinal" name="t_fechafinal">Fecha Final </td><td valign="middle"><? if(($nivelusuario==10)) { ?><textarea name="fechafinal" id="fechafinal" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($fechafinal,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$fechafinal?><? } ?></td></tr><? } ?>      
       
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idon':{'l':'Donativo','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_idon'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tipo':{'l':'Tipo','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tipo'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} var v = new validator('form1', a_fields, o_config)</script>  
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
  <? if($nivelusuario==0 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="transacciones.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="idon" selected>Donativo</option><option value="fecha">Fecha</option><option value="token">Token</option><option value="payerid">Payerid</option><option value="total">Total</option><option value="moneda">Moneda</option><option value="urlexecute">URL execute</option><option value="urlverific">URL verific</option><option value="urlrefund">URL Refund</option><option value="state">State</option><option value="respuesta">Respuesta</option><option value="respuestaipn">Respuesta IPN</option><option value="executado">Executado</option><option value="tipo">Tipo</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('transacciones.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Donativo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="idonl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="idonb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idonb2" onChange="if(idonb1.selectedIndex==0) idonb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("don","id","fechadon","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idon==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="fechal1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="fechab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechab2" value="" size="50" onKeyUp="revisainput('fechab1','fechab2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Token</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="tokenl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="tokenb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tokenb2" id="token" value="" size="50" onKeyUp="revisainput('tokenb1','tokenb2');" maxlength="180" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Payerid</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="payeridl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="payeridb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="payeridb2" value="" size="35" onKeyUp="revisainput('payeridb1','payeridb2');" maxlength="30" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Total</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="totall1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="totalb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="totalb2" value="" size="15" onKeyUp="revisainput('totalb1','totalb2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Moneda</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="monedal1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="monedab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="monedab2" value="" size="8" onKeyUp="revisainput('monedab1','monedab2');" maxlength="3" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL execute</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="urlexecutel1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="urlexecuteb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="urlexecuteb2" id="urlexecute" value="" size="50" onKeyUp="revisainput('urlexecuteb1','urlexecuteb2');" maxlength="150" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL verific</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="urlverificl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="urlverificb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="urlverificb2" id="urlverific" value="" size="50" onKeyUp="revisainput('urlverificb1','urlverificb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL Refund</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="urlrefundl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="urlrefundb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="urlrefundb2" id="urlrefund" value="" size="50" onKeyUp="revisainput('urlrefundb1','urlrefundb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">State</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="statel1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="stateb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="stateb2" value="" size="35" onKeyUp="revisainput('stateb1','stateb2');" maxlength="30" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Respuesta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="respuestal1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="respuestab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="respuestab2" value="" size="50" onKeyUp="revisainput('respuestab1','respuestab2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Respuesta IPN</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="respuestaipnl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="respuestaipnb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="respuestaipnb2" value="" size="50" onKeyUp="revisainput('respuestaipnb1','respuestaipnb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Executado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="executadol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="executadob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="executadob2" value="" size="7" onKeyUp="revisainput('executadob1','executadob2');" maxlength="2" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Tipo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="tipol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="tipob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tipob2" value="" size="10" onKeyUp="revisainput('tipob1','tipob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?> 
	
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('transacciones.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/exceltransacciones.php?step=busqueda2<?=$url_extra?>');">
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

