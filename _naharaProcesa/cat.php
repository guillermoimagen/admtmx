<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_cat"]=1;
	$_SESSION["esframe_cat_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_cat_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_cat"]=0;
	$_SESSION["esframe_cat_id"]=0;
	$_SESSION["esframe_cat_archivo"]="";
}

$titulo_pagina="Categor�as";
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
    $ib_delete_mal="Registro no eliminado. Ocurri� un error. Intente m�s tarde";
    $ib_regresar="Regresar";
}

$numerodetabla=80;
include("recursos/funciones_tabla.php"); 
$archivoactual="cat.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_cat"]=$id;
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
    $mensaje="No se puede realizar la b�squeda directa porque el valor ingresado no es v�lido.";
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==1)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on" || $imagencatl1=="on" || $descripcioncatl1=="on" || $i_descripcioncatl1=="on") $error=9;     if(isset($nombrecatb2) || isset($i_nombrecatb2) || isset($destacadacatb2) || isset($colorcatb2) || isset($imagencatb2) || isset($descripcioncatb2) || isset($i_descripcioncatb2)) $error=9;   }  if($nivelusuario==2)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on" || $imagencatl1=="on" || $descripcioncatl1=="on" || $i_descripcioncatl1=="on") $error=9;     if(isset($nombrecatb2) || isset($i_nombrecatb2) || isset($destacadacatb2) || isset($colorcatb2) || isset($imagencatb2) || isset($descripcioncatb2) || isset($i_descripcioncatb2)) $error=9;   }  if($nivelusuario==3)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on" || $imagencatl1=="on" || $descripcioncatl1=="on" || $i_descripcioncatl1=="on") $error=9;     if(isset($nombrecatb2) || isset($i_nombrecatb2) || isset($destacadacatb2) || isset($colorcatb2) || isset($imagencatb2) || isset($descripcioncatb2) || isset($i_descripcioncatb2)) $error=9;   }  if($nivelusuario==4)   {     if($nombrecatl1=="on" || $i_nombrecatl1=="on" || $destacadacatl1=="on" || $colorcatl1=="on" || $imagencatl1=="on" || $descripcioncatl1=="on" || $i_descripcioncatl1=="on") $error=9;     if(isset($nombrecatb2) || isset($i_nombrecatb2) || isset($destacadacatb2) || isset($colorcatb2) || isset($imagencatb2) || isset($descripcioncatb2) || isset($i_descripcioncatb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==1) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=8;   if($nivelusuario==2) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=8;   if($nivelusuario==3) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=8;   if($nivelusuario==4) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=8; }if($operacion=="add") {   if($nivelusuario==1) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=7;   if($nivelusuario==2) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=7;   if($nivelusuario==3) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=7;   if($nivelusuario==4) if(isset($_POST["nombrecat"]) || isset($_POST["i_nombrecat"]) || isset($_POST["destacadacat"]) || isset($_POST["colorcat"]) || isset($_POST["imagencat"]) || isset($_POST["descripcioncat"]) || isset($_POST["i_descripcioncat"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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

<title><? echo("Categor�as"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


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
    if($_SESSION["esframe_cat"]<>1)
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
      $sqltemporal.=construyesqltemporal("nombrecat","'",0);$sqltemporal.=construyesqltemporal("i_nombrecat","'",0);$sqltemporal.=construyesqltemporal("destacadacat","'",0);$sqltemporal.=construyesqltemporal("colorcat","'",0);$sqltemporal.=construyesqltemporal("imagencat","'",0);$sqltemporal.=construyesqltemporal("descripcioncat","'",0);$sqltemporal.=construyesqltemporal("i_descripcioncat","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
      	
		  $sql = "INSERT INTO cat SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=80,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_cat"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_cat"]="OK";
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
			  $mensaje.="Ocurri� un error al guardar el registro: " . mysqli_error($GLOBALS["enlaceDB"] );
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
		  $sql = "UPDATE cat SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=80,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			  
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_cat"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_cat"]="NADA";
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
			  $mensaje.="Ocurri� un error al guardar el registro: " . mysqli_error($GLOBALS["enlaceDB"] );
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
		$sql = "DELETE FROM cat WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=80,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_cat"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,tipocat FROM cat where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["tipocat"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=cat.php?step=1".$url_extra."><span class=titulo>Categor�as</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0) $botones.="<td><a href=cat.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Categor�as\"></a></td>";if($nivelusuario==0) $botones.="<td><a href=cat.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Categor�as\"></a></td>";if(($nivelusuario==0)) $botones.="<td><a href=\"cat.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Categor�as\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_cat"]=="OK")
  {
  	$mensaje="Se guard� correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_cat"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_cat"]=="BORRADO")
  {
  	$mensaje="Se elimin� correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_cat"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="cat.activo DESC,tipocat ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombrecatl1="on"; $i_nombrecatl1="on"; $destacadacatl1="on"; } $camposbuscadoslistadosearch="cat.id";cbusqueda1($activol1,"cat","activo");cbusqueda1($nombrecatl1,"cat","nombrecat");cbusqueda1($i_nombrecatl1,"cat","i_nombrecat");cbusqueda1($destacadacatl1,"cat","destacadacat");cbusqueda1($colorcatl1,"cat","colorcat");cbusqueda1($imagencatl1,"cat","imagencat");cbusqueda1($descripcioncatl1,"cat","descripcioncat");cbusqueda1($i_descripcioncatl1,"cat","i_descripcioncat");cbusqueda3($nombrecatb1,$nombrecatb2,"cat","nombrecat","'","0","","");cbusqueda3($i_nombrecatb1,$i_nombrecatb2,"cat","i_nombrecat","'","0","","");cbusqueda3($destacadacatb1,$destacadacatb2,"cat","destacadacat","'","0","","");cbusqueda3($colorcatb1,$colorcatb2,"cat","colorcat","'","0","","");cbusqueda3($imagencatb1,$imagencatb2,"cat","imagencat","'","0","","");cbusqueda3($descripcioncatb1,$descripcioncatb2,"cat","descripcioncat","'","0","","");cbusqueda3($i_descripcioncatb1,$i_descripcioncatb2,"cat","i_descripcioncat","'","0","","");cbusqueda3($activob1,$activob2,"cat","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from cat ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($nombrecatl1,"Nombre",": STR","");cbusqueda5($i_nombrecatl1,"Nombre (ingl�s)",": STR","");cbusqueda5($destacadacatl1,"Destacada",": STR","");cbusqueda5($colorcatl1,"Color",": STR","");cbusqueda5($imagencatl1,"Imagen",": STR","");cbusqueda5($descripcioncatl1,"Descripci�n",": STR","");cbusqueda5($i_descripcioncatl1,"Descripci�n en ingl�s",": STR",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='cat.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;P�gina %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurri� un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($nombrecatl1,"cat","nombrecat","0","","");cbusqueda4($i_nombrecatl1,"cat","i_nombrecat","0","",""); if($destacadacatl1=="on")  {  if($row["destacadacat"]=="0") $tempodestacadacat="NO";if($row["destacadacat"]=="1") $tempodestacadacat="SI";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempodestacadacat.$tempotigra."\""; $tempotigra="";  } cbusqueda4($colorcatl1,"cat","colorcat","0","","");cbusqueda4($imagencatl1,"cat","imagencat","0","","");cbusqueda4($descripcioncatl1,"cat","descripcioncat","0","","");cbusqueda4($i_descripcioncatl1,"cat","i_descripcioncat","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($nombrecatl1,$sumatorianombrecat,'');cbusqueda6($i_nombrecatl1,$sumatoriai_nombrecat,'');cbusqueda6($destacadacatl1,$sumatoriadestacadacat,'');cbusqueda6($colorcatl1,$sumatoriacolorcat,'');cbusqueda6($imagencatl1,$sumatoriaimagencat,'');cbusqueda6($descripcioncatl1,$sumatoriadescripcioncat,'');cbusqueda6($i_descripcioncatl1,$sumatoriai_descripcioncat,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelcat.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=nombrecatl1 type="hidden" value="<?=$nombrecatl1?>" ><input name=nombrecatb1 type="hidden" value="<?=$nombrecatb1?>" ><input name=nombrecatb2 type="hidden" value="<?=$nombrecatb2?>" ><input name=i_nombrecatl1 type="hidden" value="<?=$i_nombrecatl1?>" ><input name=i_nombrecatb1 type="hidden" value="<?=$i_nombrecatb1?>" ><input name=i_nombrecatb2 type="hidden" value="<?=$i_nombrecatb2?>" ><input name=destacadacatl1 type="hidden" value="<?=$destacadacatl1?>" ><input name=destacadacatb1 type="hidden" value="<?=$destacadacatb1?>" ><input name=destacadacatb2 type="hidden" value="<?=$destacadacatb2?>" ><input name=colorcatl1 type="hidden" value="<?=$colorcatl1?>" ><input name=colorcatb1 type="hidden" value="<?=$colorcatb1?>" ><input name=colorcatb2 type="hidden" value="<?=$colorcatb2?>" ><input name=imagencatl1 type="hidden" value="<?=$imagencatl1?>" ><input name=imagencatb1 type="hidden" value="<?=$imagencatb1?>" ><input name=imagencatb2 type="hidden" value="<?=$imagencatb2?>" ><input name=descripcioncatl1 type="hidden" value="<?=$descripcioncatl1?>" ><input name=descripcioncatb1 type="hidden" value="<?=$descripcioncatb1?>" ><input name=descripcioncatb2 type="hidden" value="<?=$descripcioncatb2?>" ><input name=i_descripcioncatl1 type="hidden" value="<?=$i_descripcioncatl1?>" ><input name=i_descripcioncatb1 type="hidden" value="<?=$i_descripcioncatb1?>" ><input name=i_descripcioncatb2 type="hidden" value="<?=$i_descripcioncatb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcat.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
var HINTS_ITEMS = {'activo':wrap("Seleccion SI para que el registro est� activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  
	<?
	
if($error_unique==0)
{
$nombrecat='';$i_nombrecat='';$destacadacat='0';$colorcat='#19AD90';$imagencat='';$descripcioncat='';$i_descripcioncat='';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["nombrecat"])) $nombrecat=$_POST["nombrecat"];if(isset($_POST["i_nombrecat"])) $i_nombrecat=$_POST["i_nombrecat"];if(isset($_POST["destacadacat"])) $destacadacat=$_POST["destacadacat"];if(isset($_POST["colorcat"])) $colorcat=$_POST["colorcat"];if(isset($_POST["imagencat"])) $imagencat=$_POST["imagencat"];if(isset($_POST["descripcioncat"])) $descripcioncat=$_POST["descripcioncat"];if(isset($_POST["i_descripcioncat"])) $i_descripcioncat=$_POST["i_descripcioncat"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM cat where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM cat where id=". $id);
      if (!$result) 
	  {
        echo("<p>Ocurri� un error al buscar el registro: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
        exit();
      }  
	$registrosencontrados = mysqli_num_rows($result);
       while ( $row = mysqli_fetch_array($result) ) 
	   {
$id=$row["id"];
$activo=$row["activo"];
$nombrecat=$row["nombrecat"];$i_nombrecat=$row["i_nombrecat"];$destacadacat=$row["destacadacat"];$colorcat=$row["colorcat"];$imagencat=$row["imagencat"];$descripcioncat=$row["descripcioncat"];$i_descripcioncat=$row["i_descripcioncat"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="cat.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('cat.php?sortfield=tipocat&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nombrecat" name="t_nombrecat">Nombre * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="nombrecat" id="nombrecat" value="<? echo(htmlspecialchars($nombrecat,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$nombrecat?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_nombrecat" name="t_i_nombrecat">Nombre (ingl�s) * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="i_nombrecat" id="i_nombrecat" value="<? echo(htmlspecialchars($i_nombrecat,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$i_nombrecat?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_destacadacat" name="t_destacadacat">Destacada * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><select name="destacadacat" id="destacadacat" class=textogeneralform><OPTION VALUE="0" <? if($destacadacat=="0") echo("selected");?> >NO</option><OPTION VALUE="1" <? if($destacadacat=="1") echo("selected");?> >SI</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($destacadacat=="0") echo("NO");if($destacadacat=="1") echo("SI"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_colorcat" name="t_colorcat">Color * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="colorcat" id="colorcat" value="<? echo(htmlspecialchars($colorcat,ENT_COMPAT,'ISO-8859-1')); ?>" size="12" maxlength="7" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$colorcat?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_imagencat" name="t_imagencat">Imagen </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="imagencat" id="imagencat" value="<? echo(htmlspecialchars($imagencat,ENT_COMPAT,'ISO-8859-1'));?>" size="60" maxlength="100" readonly class=textogeneralform><a href=javascript:seleccionaimagen('imagencat')><img src=recursos/cambiarimagen.gif border="0" alt=Cambiar></a><a href=javascript:muestraimagen('imagencat')><img src=recursos/verimagen.gif border="0" alt=Ver></a><a href="javascript:limpiarimagen('imagencat')" style="margin-right:20px"><img src=recursos/limpiarimagen.gif border="0" alt=Limpiar></a><? } ?><? if(($nivelusuario==10)) { ?><?=$imagencat?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_descripcioncat" name="t_descripcioncat">Descripci�n </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="descripcioncat" id="descripcioncat" value="<? echo(htmlspecialchars($descripcioncat,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="150"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$descripcioncat?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_descripcioncat" name="t_i_descripcioncat">Descripci�n en ingl�s </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="i_descripcioncat" id="i_descripcioncat" value="<? echo(htmlspecialchars($i_descripcioncat,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="150"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$i_descripcioncat?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'nombrecat':{'l':'Nombre','r': true,'t':'t_nombrecat'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'i_nombrecat':{'l':'Nombre (ingl�s)','r': true,'t':'t_i_nombrecat'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'destacadacat':{'l':'Destacada','r': true,'t':'t_destacadacat'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'colorcat':{'l':'Color','r': true,'t':'t_colorcat'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
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
     <td colspan="2"  class="titulointerior" valign="middle"><? if($nivelusuario==0 && $step=="modify") { ?><span id="historico" name="historico" style="float:left;"><table><tr><td><a href="#top" onClick="return abreocierracabeza('avanzadas_span')" class="textogeneralnegrita"><b>&rArr;</b></a></td><td id="collapseobj_avanzadas_span"  name="collapseobj_avanzadas_span" style="display:none;" class="textogeneral"><a href="careportes.php?step=busqueda2&idtablareporteb1==&idtablareporteb2=<?=$numerodetabla?>&idregistroreporteb1==&idregistroreporteb2=<?=$id?>&moditobusqueda=especial&&titulobusqueda=Reportes de registro" class=textogeneral target=_blank>Accesos irregulares</a>&nbsp;|&nbsp;<a href="caseguimiento.php?step=busqueda2&tablaseguimientob1==&tablaseguimientob2=<?=$numerodetabla?>&registroseguimientob1==&registroseguimientob2=<?=$id?>&moditobusqueda=especial&titulobusqueda=Seguimiento de registro" class=textogeneral target=_blank>Seguimiento</a>&nbsp;|&nbsp;<a href="cahistorico.php?step=busqueda2&tablabusqueda=<?=$numerodetabla?>&registrobusqueda=<?=$id?>&modo=busqueda&moditobusqueda=especial&titulobusqueda=Hist�rico de registro" class=textogeneral target=_blank>Hist�rico</a></td></tr></table></span><? } ?>              
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
else echo($entradamensaje."El registro buscado no ha sido encontrado.<br>&nbsp;&nbsp;&nbsp;Es probable que haya sido eliminado, o bien que nunca haya existido.<BR>&nbsp;&nbsp;&nbsp;Si crees que es un error, rep�rtalo al administrador del sistema".$salidamensaje);
}

else if($step=="busqueda") 
  {
  ?>
  <? if($nivelusuario==0 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="cat.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="nombrecat">Nombre</option><option value="i_nombrecat">Nombre (ingl�s)</option><option value="destacadacat">Destacada</option><option value="colorcat">Color</option><option value="imagencat">Imagen</option><option value="descripcioncat">Descripci�n</option><option value="i_descripcioncat">Descripci�n en ingl�s</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('cat.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="nombrecatl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="nombrecatb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nombrecatb2" value="" size="55" onKeyUp="revisainput('nombrecatb1','nombrecatb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre (ingl�s)</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="i_nombrecatl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="i_nombrecatb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_nombrecatb2" value="" size="55" onKeyUp="revisainput('i_nombrecatb1','i_nombrecatb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Destacada</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="destacadacatl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="destacadacatb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="destacadacatb2" onChange="if(destacadacatb1.selectedIndex==0) destacadacatb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($destacadacat=="0") { ?>selected<? } ?> >NO</option><OPTION VALUE="1" <? if($destacadacat=="1") { ?>selected<? } ?> >SI</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Color</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="colorcatl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="colorcatb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="colorcatb2" value="" size="12" onKeyUp="revisainput('colorcatb1','colorcatb2');" maxlength="7" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Imagen</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="imagencatl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="imagencatb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="imagencatb2" value="" size="105" onKeyUp="revisainput('imagencatb1','imagencatb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Descripci�n</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="descripcioncatl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="descripcioncatb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="descripcioncatb2" id="descripcioncat" value="" size="50" onKeyUp="revisainput('descripcioncatb1','descripcioncatb2');" maxlength="150" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Descripci�n en ingl�s</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0) { ?><input type="checkbox" name="i_descripcioncatl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0) { ?><select name="i_descripcioncatb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_descripcioncatb2" id="i_descripcioncat" value="" size="50" onKeyUp="revisainput('i_descripcioncatb1','i_descripcioncatb2');" maxlength="150" class=textogeneralform><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario==0) {?>
	<tr>
      <td valign="middle" bgcolor="#<?=$vsitioscolor3?>"><?=$ib_activo?> <a href="javascript:muestraayuda('Activo. Seleccione SI para que el registro est� activo en el sitio web, de lo contrario seleccione NO');">(?)</a></td>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('cat.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelcat.php?step=busqueda2<?=$url_extra?>');">
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

