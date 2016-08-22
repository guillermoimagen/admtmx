<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_rep"]=1;
	$_SESSION["esframe_rep_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_rep_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_rep"]=0;
	$_SESSION["esframe_rep_id"]=0;
	$_SESSION["esframe_rep_archivo"]="";
}

$titulo_pagina="Reportes";
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

$numerodetabla=34;
include("recursos/funciones_tabla.php"); 
$archivoactual="rep.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_rep"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==0)   {     if(isset($fecharepb2) || isset($textorepb2) || isset($statusrepb2)) $error=9;   }  if($nivelusuario==1)   {     if($fecharepl1=="on" || $textorepl1=="on" || $statusrepl1=="on") $error=9;     if(isset($fecharepb2) || isset($textorepb2) || isset($statusrepb2)) $error=9;   }  if($nivelusuario==2)   {     if($fecharepl1=="on" || $textorepl1=="on" || $statusrepl1=="on") $error=9;     if(isset($fecharepb2) || isset($textorepb2) || isset($statusrepb2)) $error=9;   }  if($nivelusuario==3)   {     if($fecharepl1=="on" || $textorepl1=="on" || $statusrepl1=="on") $error=9;     if(isset($fecharepb2) || isset($textorepb2) || isset($statusrepb2)) $error=9;   }  if($nivelusuario==4)   {     if($fecharepl1=="on" || $textorepl1=="on" || $statusrepl1=="on") $error=9;     if(isset($fecharepb2) || isset($textorepb2) || isset($statusrepb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=8;   if($nivelusuario==1) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=8;   if($nivelusuario==2) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=8;   if($nivelusuario==3) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=8;   if($nivelusuario==4) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=7;   if($nivelusuario==1) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=7;   if($nivelusuario==2) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=7;   if($nivelusuario==3) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=7;   if($nivelusuario==4) if(isset($_POST["iretrep"]) || isset($_POST["iusuarioreportadorep"]) || isset($_POST["iusuariorep"]) || isset($_POST["fecharep"]) || isset($_POST["imotrep"]) || isset($_POST["textorep"]) || isset($_POST["statusrep"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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


<?if($_SESSION["esframe_rep"]==1){  if($_SESSION["esframe_rep_archivo"]=="ret")  {    if($step=="add")    {      $iretrep=$_SESSION["id_ret"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $iretrepb1="=";      $iretrepb2=$_SESSION["id_ret"];    }  }  else   if($_SESSION["esframe_rep_archivo"]=="usuarios")  {    if($step=="add")    {      $iusuarioreportadorep=$_SESSION["id_usuarios"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $iusuarioreportadorepb1="=";      $iusuarioreportadorepb2=$_SESSION["id_usuarios"];    }  }}?>


<head>

<title><? echo("Reportes"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


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
    if($_SESSION["esframe_rep"]<>1)
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
      $sqltemporal.=construyesqltemporal("iretrep","",0);$sqltemporal.=construyesqltemporal("iusuarioreportadorep","",0);$sqltemporal.=construyesqltemporal("iusuariorep","",0);$sqltemporal.=construyesqltemporal("fecharep","'",0);$sqltemporal.=construyesqltemporal("imotrep","",0);$sqltemporal.=construyesqltemporal("textorep","'",0);$sqltemporal.=construyesqltemporal("statusrep","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
      	
		  $sql = "INSERT INTO rep SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=34,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_rep"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_rep"]="OK";
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
		  $sql = "UPDATE rep SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=34,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			  
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_rep"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_rep"]="NADA";
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
		$sql = "DELETE FROM rep WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=34,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_rep"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,iretrep FROM rep where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["iretrep"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=rep.php?step=1".$url_extra."><span class=titulo>Reportes</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0) $botones.="<td><a href=rep.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Reportes\"></a></td>";if($nivelusuario==0) $botones.="<td><a href=rep.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Reportes\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_rep"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_rep"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_rep"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_rep"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="rep.activo DESC,fecharep DESC"; $ordenamiento="";$activob1="="; $activob2="1";$iretrepl1="on"; $iusuarioreportadorepl1="on"; $iusuariorepl1="on"; $fecharepl1="on"; $imotrepl1="on"; $textorepl1="on"; $statusrepl1="on"; } $camposbuscadoslistadosearch="rep.id";cbusqueda1($activol1,"rep","activo");cbusqueda1($iretrepl1,"ret","nombreret","0","","");cbusqueda1($iusuarioreportadorepl1,"usuarios","nombreusuario","2","","");cbusqueda1($iusuariorepl1,"usuarios","nombreusuario","1","","");cbusqueda1($fecharepl1,"rep","fecharep");cbusqueda1($imotrepl1,"mot","nombremot","0","","");cbusqueda1($textorepl1,"rep","textorep");cbusqueda1($statusrepl1,"rep","statusrep");cbusqueda2($iretrepl1,"ret","rep","iretrep","",0,"id");cbusqueda2($iusuarioreportadorepl1,"usuarios","rep","iusuarioreportadorep","",2,"id");cbusqueda2($iusuariorepl1,"usuarios","rep","iusuariorep","",1,"id");cbusqueda2($imotrepl1,"mot","rep","imotrep","",0,"id");cbusqueda3($iretrepb1,$iretrepb2,"rep","iretrep","","0","","");cbusqueda3($iusuarioreportadorepb1,$iusuarioreportadorepb2,"rep","iusuarioreportadorep","","2","","");cbusqueda3($iusuariorepb1,$iusuariorepb2,"rep","iusuariorep","","1","","");cbusqueda3($fecharepb1,$fecharepb2,"rep","fecharep","'","0","","");cbusqueda3($imotrepb1,$imotrepb2,"rep","imotrep","","0","","");cbusqueda3($textorepb1,$textorepb2,"rep","textorep","'","0","","");cbusqueda3($statusrepb1,$statusrepb2,"rep","statusrep","'","0","","");cbusqueda3($activob1,$activob2,"rep","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from rep ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($iretrepl1,"Iniciativa reportada",": STR","");cbusqueda5($iusuarioreportadorepl1,"Usuario reportado",": STR","");cbusqueda5($iusuariorepl1,"Usuario que reporta",": STR","");cbusqueda5($fecharepl1,"Fecha"," : DATE","");cbusqueda5($imotrepl1,"Motivo",": STR","");cbusqueda5($textorepl1,"Texto",": STR","");cbusqueda5($statusrepl1,"Status",": STR",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='rep.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($iretrepl1,"ret","nombreret","0","","");cbusqueda4($iusuarioreportadorepl1,"usuarios","nombreusuario","2","","");cbusqueda4($iusuariorepl1,"usuarios","nombreusuario","1","","");cbusqueda4($fecharepl1,"rep","fecharep","0","","");cbusqueda4($imotrepl1,"mot","nombremot","0","","");cbusqueda4($textorepl1,"rep","textorep","0","",""); if($statusrepl1=="on")  {  if($row["statusrep"]=="0") $tempostatusrep="Pendiente";if($row["statusrep"]=="1") $tempostatusrep="Con seguimiento";if($row["statusrep"]=="2") $tempostatusrep="Con seguimiento, registro eliminado o rechazado";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempostatusrep.$tempotigra."\""; $tempotigra="";  }  if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($iretrepl1,$sumatoriairetrep,'');cbusqueda6($iusuarioreportadorepl1,$sumatoriaiusuarioreportadorep,'');cbusqueda6($iusuariorepl1,$sumatoriaiusuariorep,'');cbusqueda6($fecharepl1,$sumatoriafecharep,'');cbusqueda6($imotrepl1,$sumatoriaimotrep,'');cbusqueda6($textorepl1,$sumatoriatextorep,'');cbusqueda6($statusrepl1,$sumatoriastatusrep,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelrep.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=iretrepl1 type="hidden" value="<?=$iretrepl1?>" ><input name=iretrepb1 type="hidden" value="<?=$iretrepb1?>" ><input name=iretrepb2 type="hidden" value="<?=$iretrepb2?>" ><input name=iusuarioreportadorepl1 type="hidden" value="<?=$iusuarioreportadorepl1?>" ><input name=iusuarioreportadorepb1 type="hidden" value="<?=$iusuarioreportadorepb1?>" ><input name=iusuarioreportadorepb2 type="hidden" value="<?=$iusuarioreportadorepb2?>" ><input name=iusuariorepl1 type="hidden" value="<?=$iusuariorepl1?>" ><input name=iusuariorepb1 type="hidden" value="<?=$iusuariorepb1?>" ><input name=iusuariorepb2 type="hidden" value="<?=$iusuariorepb2?>" ><input name=fecharepl1 type="hidden" value="<?=$fecharepl1?>" ><input name=fecharepb1 type="hidden" value="<?=$fecharepb1?>" ><input name=fecharepb2 type="hidden" value="<?=$fecharepb2?>" ><input name=imotrepl1 type="hidden" value="<?=$imotrepl1?>" ><input name=imotrepb1 type="hidden" value="<?=$imotrepb1?>" ><input name=imotrepb2 type="hidden" value="<?=$imotrepb2?>" ><input name=textorepl1 type="hidden" value="<?=$textorepl1?>" ><input name=textorepb1 type="hidden" value="<?=$textorepb1?>" ><input name=textorepb2 type="hidden" value="<?=$textorepb2?>" ><input name=statusrepl1 type="hidden" value="<?=$statusrepl1?>" ><input name=statusrepb1 type="hidden" value="<?=$statusrepb1?>" ><input name=statusrepb2 type="hidden" value="<?=$statusrepb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelrep.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
$iretrep=0;$iusuarioreportadorep=0;$iusuariorep=0;$fecharep='';$imotrep=0;$textorep='';$statusrep='0';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["iretrep"])) $iretrep=$_POST["iretrep"];if(isset($_POST["iusuarioreportadorep"])) $iusuarioreportadorep=$_POST["iusuarioreportadorep"];if(isset($_POST["iusuariorep"])) $iusuariorep=$_POST["iusuariorep"];if(isset($_POST["fecharep"])) $fecharep=$_POST["fecharep"];if(isset($_POST["imotrep"])) $imotrep=$_POST["imotrep"];if(isset($_POST["textorep"])) $textorep=$_POST["textorep"];if(isset($_POST["statusrep"])) $statusrep=$_POST["statusrep"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM rep where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM rep where id=". $id);
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
$iretrep=$row["iretrep"];$iusuarioreportadorep=$row["iusuarioreportadorep"];$iusuariorep=$row["iusuariorep"];$fecharep=$row["fecharep"];$imotrep=$row["imotrep"];$textorep=$row["textorep"];$statusrep=$row["statusrep"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="rep.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <?
if($iretrep<>0) echo("<a href='../iniciativaDetalle.php?idioma=0&idregistro=".$iretrep."' target='_blank' class='textoboton' style='padding:5px'>Ver iniciativa</a>");
if($iusuarioreportadorep<>0) echo("<a href='../usuarioDetalle.php?idioma=0&idregistro=".$iusuarioreportadorep."' target='_blank' class='textoboton' style='padding:5px'>Ver usuario</a>");

?><? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('rep.php?sortfield=fecharep&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iretrep" name="t_iretrep">Iniciativa reportada * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="iretrep" id="iretrep"  class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iretrep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $valor_mostrar=lee_registro("ret","nombreret","","",$iretrep,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuarioreportadorep" name="t_iusuarioreportadorep">Usuario reportado * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="iusuarioreportadorep" id="iusuarioreportadorep"  class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuarioreportadorep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $valor_mostrar=lee_registro("usuarios","nombreusuario","","",$iusuarioreportadorep,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuariorep" name="t_iusuariorep">Usuario que reporta * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="iusuariorep" id="iusuariorep"  class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariorep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $valor_mostrar=lee_registro("usuarios","nombreusuario","","",$iusuariorep,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fecharep" name="t_fecharep">Fecha * </td><td valign="middle"><?=$fecharep?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_imotrep" name="t_imotrep">Motivo * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="imotrep" id="imotrep"  class=textogeneralform><option value="0" selected></option><?  leecampos("mot","id","nombremot","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($imotrep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? $valor_mostrar=lee_registro("mot","nombremot","","",$imotrep,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_textorep" name="t_textorep">Texto </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="textorep" id="textorep" value="<? echo(htmlspecialchars($textorep,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><?=$textorep?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_statusrep" name="t_statusrep">Status * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="statusrep" id="statusrep" class=textogeneralform><OPTION VALUE="0" <? if($statusrep=="0") echo("selected");?> >Pendiente</option><OPTION VALUE="1" <? if($statusrep=="1") echo("selected");?> >Con seguimiento</option><OPTION VALUE="2" <? if($statusrep=="2") echo("selected");?> >Con seguimiento, registro eliminado o rechazado</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($statusrep=="0") echo("Pendiente");if($statusrep=="1") echo("Con seguimiento");if($statusrep=="2") echo("Con seguimiento, registro eliminado o rechazado"); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iretrep':{'l':'Iniciativa reportada','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iretrep'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuarioreportadorep':{'l':'Usuario reportado','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iusuarioreportadorep'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuariorep':{'l':'Usuario que reporta','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iusuariorep'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fecharep':{'l':'Fecha','r': true,'t':'t_fecharep'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'imotrep':{'l':'Motivo','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_imotrep'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'statusrep':{'l':'Status','r': true,'t':'t_statusrep'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
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
  <? if($nivelusuario==0 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="rep.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="iretrep">Iniciativa reportada</option><option value="iusuarioreportadorep">Usuario reportado</option><option value="iusuariorep">Usuario que reporta</option><option value="fecharep" selected>Fecha</option><option value="imotrep">Motivo</option><option value="textorep">Texto</option><option value="statusrep">Status</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC selected>DESC</OPTION><option value=ASC>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('rep.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Iniciativa reportada</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="iretrepl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iretrepb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iretrepb2" onChange="if(iretrepb1.selectedIndex==0) iretrepb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("ret","id","nombreret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iretrep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario reportado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="iusuarioreportadorepl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iusuarioreportadorepb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuarioreportadorepb2" onChange="if(iusuarioreportadorepb1.selectedIndex==0) iusuarioreportadorepb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuarioreportadorep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario que reporta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="iusuariorepl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="iusuariorepb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuariorepb2" onChange="if(iusuariorepb1.selectedIndex==0) iusuariorepb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuariorep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="fecharepl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="fecharepb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fecharepb2" value="" size="50" onKeyUp="revisainput('fecharepb1','fecharepb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Motivo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="imotrepl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="imotrepb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="imotrepb2" onChange="if(imotrepb1.selectedIndex==0) imotrepb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("mot","id","nombremot","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($imotrep==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Texto</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="textorepl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="textorepb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="textorepb2" id="textorep" value="" size="50" onKeyUp="revisainput('textorepb1','textorepb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Status</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="statusrepl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="statusrepb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="statusrepb2" onChange="if(statusrepb1.selectedIndex==0) statusrepb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($statusrep=="0") { ?>selected<? } ?> >Pendiente</option><OPTION VALUE="1" <? if($statusrep=="1") { ?>selected<? } ?> >Con seguimiento</option><OPTION VALUE="2" <? if($statusrep=="2") { ?>selected<? } ?> >Con seguimiento, registro eliminado o rechazado</option></select> <? } ?></td></tr><? } ?> 
	
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('rep.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelrep.php?step=busqueda2<?=$url_extra?>');">
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

