<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_vret"]=1;
	$_SESSION["esframe_vret_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_vret_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_vret"]=0;
	$_SESSION["esframe_vret_id"]=0;
	$_SESSION["esframe_vret_archivo"]="";
}

$titulo_pagina="Valores extras";
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

$numerodetabla=8;
include("recursos/funciones_tabla.php"); 
$archivoactual="vret.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_vret"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==2)   {     if($valorvretl1=="on" || $statusvretl1=="on" || $ganvretl1=="on") $error=9;     if(isset($valorvretb2) || isset($statusvretb2) || isset($ganvretb2)) $error=9;   }  if($nivelusuario==3)   {     if($valorvretl1=="on" || $statusvretl1=="on" || $ganvretl1=="on") $error=9;     if(isset($valorvretb2) || isset($statusvretb2) || isset($ganvretb2)) $error=9;   }  if($nivelusuario==4)   {     if($valorvretl1=="on" || $statusvretl1=="on" || $ganvretl1=="on") $error=9;     if(isset($valorvretb2) || isset($statusvretb2) || isset($ganvretb2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"])) $error=8;   if($nivelusuario==1) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"])) $error=8;   if($nivelusuario==2) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"]) || isset($_POST["valorvret"]) || isset($_POST["statusvret"]) || isset($_POST["ganvret"])) $error=8;   if($nivelusuario==3) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"]) || isset($_POST["valorvret"]) || isset($_POST["statusvret"]) || isset($_POST["ganvret"])) $error=8;   if($nivelusuario==4) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"]) || isset($_POST["valorvret"]) || isset($_POST["statusvret"]) || isset($_POST["ganvret"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"])) $error=7;   if($nivelusuario==1) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"])) $error=7;   if($nivelusuario==2) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"]) || isset($_POST["valorvret"]) || isset($_POST["statusvret"]) || isset($_POST["ganvret"])) $error=7;   if($nivelusuario==3) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"]) || isset($_POST["valorvret"]) || isset($_POST["statusvret"]) || isset($_POST["ganvret"])) $error=7;   if($nivelusuario==4) if(isset($_POST["idonvret"]) || isset($_POST["icretvret"]) || isset($_POST["valorvret"]) || isset($_POST["statusvret"]) || isset($_POST["ganvret"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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


<?if($_SESSION["esframe_vret"]==1){  if($_SESSION["esframe_vret_archivo"]=="don")  {    if($step=="add")    {      $idonvret=$_SESSION["id_don"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $idonvretb1="=";      $idonvretb2=$_SESSION["id_don"];    }  }  else   if($_SESSION["esframe_vret_archivo"]=="cret")  {    if($step=="add")    {      $icretvret=$_SESSION["id_cret"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $icretvretb1="=";      $icretvretb2=$_SESSION["id_cret"];    }  }}?>


<head>

<title><? echo("Valores extras"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


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
    if($_SESSION["esframe_vret"]<>1)
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
  if(isset($_POST["ganvret"])) $_POST["ganvret"]=limpia_numero($_POST["ganvret"]);
  
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
       if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM vret where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("idonvret","",0);$sqltemporal.=construyesqltemporal("icretvret","",0);$sqltemporal.=construyesqltemporal("valorvret","'",0);$sqltemporal.=construyesqltemporal("statusvret","'",0);$sqltemporal.=construyesqltemporal("ganvret","",2);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
      	
		  $sql = "INSERT INTO vret SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=8,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_vret"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_vret"]="OK";
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
	   if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {	      
		  $sql = "UPDATE vret SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=8,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM vret where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["idonvret"]<>$rown["idonvret"]) $cadena_historico.="Donativo:\r\n O:".$rowh["idonvret"]."\r\nN: ".$rown["idonvret"]."\r\n\r\n";               if($rowh["icretvret"]<>$rown["icretvret"]) $cadena_historico.="Extra:\r\n O:".$rowh["icretvret"]."\r\nN: ".$rown["icretvret"]."\r\n\r\n";               if($rowh["valorvret"]<>$rown["valorvret"]) $cadena_historico.="Valor:\r\n O:".$rowh["valorvret"]."\r\nN: ".$rown["valorvret"]."\r\n\r\n";               if($rowh["statusvret"]<>$rown["statusvret"]) $cadena_historico.="Status:\r\n O:".$rowh["statusvret"]."\r\nN: ".$rown["statusvret"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_vret"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_vret"]="NADA";
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
		$sql = "DELETE FROM vret WHERE id=".$id;
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
          	$_SESSION["frame_interior_vret"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,ganvret FROM vret where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["ganvret"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=vret.php?step=1".$url_extra."><span class=titulo>Valores extras</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=vret.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Valores extras\"></a></td>";if($nivelusuario==0 || $nivelusuario==1) $botones.="<td><a href=vret.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Valores extras\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_vret"]=="OK")
  {
  	$mensaje="Se guard� correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_vret"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_vret"]=="BORRADO")
  {
  	$mensaje="Se elimin� correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_vret"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="vret.activo DESC,ganvret ASC"; $ordenamiento="";$activob1="="; $activob2="1";$idonvretl1="on"; $icretvretl1="on"; $valorvretl1="on"; $statusvretl1="on"; $ganvretl1="on"; } $camposbuscadoslistadosearch="vret.id";cbusqueda1($activol1,"vret","activo");cbusqueda1($idonvretl1,"don","fechadon","0","","");cbusqueda1($icretvretl1,"cret","labelcret","0","","");cbusqueda1($valorvretl1,"vret","valorvret");cbusqueda1($statusvretl1,"vret","statusvret");cbusqueda1($ganvretl1,"vret","ganvret");cbusqueda2($idonvretl1,"don","vret","idonvret","",0,"id");cbusqueda2($icretvretl1,"cret","vret","icretvret","",0,"id");cbusqueda3($idonvretb1,$idonvretb2,"vret","idonvret","","0","","");cbusqueda3($icretvretb1,$icretvretb2,"vret","icretvret","","0","","");cbusqueda3($valorvretb1,$valorvretb2,"vret","valorvret","'","0","","");cbusqueda3($statusvretb1,$statusvretb2,"vret","statusvret","'","0","","");cbusqueda3($ganvretb1,$ganvretb2,"vret","ganvret","","0","","");cbusqueda3($activob1,$activob2,"vret","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from vret ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($idonvretl1,"Donativo",": STR","");cbusqueda5($icretvretl1,"Extra",": STR","");cbusqueda5($valorvretl1,"Valor",": STR","");cbusqueda5($statusvretl1,"Status",": STR","");cbusqueda5($ganvretl1,"Ganador"," : NUM",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='vret.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;P�gina %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurri� un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($idonvretl1,"don","fechadon","0","","");cbusqueda4($icretvretl1,"cret","labelcret","0","","");cbusqueda4($valorvretl1,"vret","valorvret","0","",""); if($statusvretl1=="on")  {  if($row["statusvret"]=="1") $tempostatusvret="V�lido";if($row["statusvret"]=="2") $tempostatusvret="Cancelado por insuficiencia";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempostatusvret.$tempotigra."\""; $tempotigra="";  } cbusqueda4($ganvretl1,"vret","ganvret","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($idonvretl1,$sumatoriaidonvret,'');cbusqueda6($icretvretl1,$sumatoriaicretvret,'');cbusqueda6($valorvretl1,$sumatoriavalorvret,'');cbusqueda6($statusvretl1,$sumatoriastatusvret,'');cbusqueda6($ganvretl1,$sumatoriaganvret,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelvret.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=idonvretl1 type="hidden" value="<?=$idonvretl1?>" ><input name=idonvretb1 type="hidden" value="<?=$idonvretb1?>" ><input name=idonvretb2 type="hidden" value="<?=$idonvretb2?>" ><input name=icretvretl1 type="hidden" value="<?=$icretvretl1?>" ><input name=icretvretb1 type="hidden" value="<?=$icretvretb1?>" ><input name=icretvretb2 type="hidden" value="<?=$icretvretb2?>" ><input name=valorvretl1 type="hidden" value="<?=$valorvretl1?>" ><input name=valorvretb1 type="hidden" value="<?=$valorvretb1?>" ><input name=valorvretb2 type="hidden" value="<?=$valorvretb2?>" ><input name=statusvretl1 type="hidden" value="<?=$statusvretl1?>" ><input name=statusvretb1 type="hidden" value="<?=$statusvretb1?>" ><input name=statusvretb2 type="hidden" value="<?=$statusvretb2?>" ><input name=ganvretl1 type="hidden" value="<?=$ganvretl1?>" ><input name=ganvretb1 type="hidden" value="<?=$ganvretb1?>" ><input name=ganvretb2 type="hidden" value="<?=$ganvretb2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelvret.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
var HINTS_ITEMS = {'activo':wrap("Seleccion SI para que el registro est� activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  
	<?
	
if($error_unique==0)
{
$idonvret=0;$icretvret=0;$valorvret='';$statusvret='1';$ganvret=0;$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["idonvret"])) $idonvret=$_POST["idonvret"];if(isset($_POST["icretvret"])) $icretvret=$_POST["icretvret"];if(isset($_POST["valorvret"])) $valorvret=$_POST["valorvret"];if(isset($_POST["statusvret"])) $statusvret=$_POST["statusvret"];if(isset($_POST["ganvret"])) $ganvret=$_POST["ganvret"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM vret where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM vret where id=". $id);
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
$idonvret=$row["idonvret"];$icretvret=$row["icretvret"];$valorvret=$row["valorvret"];$statusvret=$row["statusvret"];$ganvret=$row["ganvret"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="vret.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('vret.php?sortfield=ganvret&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
     	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idonvret" name="t_idonvret">Donativo * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idonvret" id="idonvret"  class=textogeneralform><option value="0" selected></option><?  leecampos("don","id","fechadon","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idonvret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? $valor_mostrar=lee_registro("don","fechadon","","",$idonvret,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_icretvret" name="t_icretvret">Extra * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="icretvret" id="icretvret"  class=textogeneralform><option value="0" selected></option><?  leecampos("cret","id","labelcret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($icretvret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? $valor_mostrar=lee_registro("cret","labelcret","","",$icretvret,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_valorvret" name="t_valorvret">Valor * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="valorvret" id="valorvret" value="<? echo(htmlspecialchars($valorvret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$valorvret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_statusvret" name="t_statusvret">Status * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="statusvret" id="statusvret" class=textogeneralform><OPTION VALUE="1" <? if($statusvret=="1") echo("selected");?> >V�lido</option><OPTION VALUE="2" <? if($statusvret=="2") echo("selected");?> >Cancelado por insuficiencia</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($statusvret=="1") echo("V�lido");if($statusvret=="2") echo("Cancelado por insuficiencia"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ganvret" name="t_ganvret">Ganador * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="ganvret" id="ganvret" value="<? echo(formato_numero($ganvret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('ganvret')" onBlur="pone_pesos('ganvret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($ganvret,'')); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idonvret':{'l':'Donativo','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_idonvret'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'icretvret':{'l':'Extra','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_icretvret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'valorvret':{'l':'Valor','r': true,'t':'t_valorvret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'statusvret':{'l':'Status','r': true,'t':'t_statusvret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ganvret':{'l':'Ganador','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_ganvret'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
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
     <td colspan="2"  class="titulointerior" valign="middle"><? if($nivelusuario==0 && $step=="modify") { ?><span id="historico" name="historico" style="float:left;"><table><tr><td><a href="#top" onClick="return abreocierracabeza('avanzadas_span')" class="textogeneralnegrita"><b>&rArr;</b></a></td><td id="collapseobj_avanzadas_span"  name="collapseobj_avanzadas_span" style="display:none;" class="textogeneral"><a href="careportes.php?step=busqueda2&idtablareporteb1==&idtablareporteb2=<?=$numerodetabla?>&idregistroreporteb1==&idregistroreporteb2=<?=$id?>&moditobusqueda=especial&&titulobusqueda=Reportes de registro" class=textogeneral target=_blank>Accesos irregulares</a>&nbsp;|&nbsp;<a href="caseguimiento.php?step=busqueda2&tablaseguimientob1==&tablaseguimientob2=<?=$numerodetabla?>&registroseguimientob1==&registroseguimientob2=<?=$id?>&moditobusqueda=especial&titulobusqueda=Seguimiento de registro" class=textogeneral target=_blank>Seguimiento</a>&nbsp;|&nbsp;<a href="cahistorico.php?step=busqueda2&tablabusqueda=<?=$numerodetabla?>&registrobusqueda=<?=$id?>&modo=busqueda&moditobusqueda=especial&titulobusqueda=Hist�rico de registro" class=textogeneral target=_blank>Hist�rico</a></td></tr></table></span><? } ?>              
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
else echo($entradamensaje."El registro buscado no ha sido encontrado.<br>&nbsp;&nbsp;&nbsp;Es probable que haya sido eliminado, o bien que nunca haya existido.<BR>&nbsp;&nbsp;&nbsp;Si crees que es un error, rep�rtalo al administrador del sistema".$salidamensaje);
}

else if($step=="busqueda") 
  {
  ?>
  <? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="vret.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="idonvret">Donativo</option><option value="icretvret">Extra</option><option value="valorvret">Valor</option><option value="statusvret">Status</option><option value="ganvret" selected>Ganador</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('vret.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Donativo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="idonvretl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="idonvretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idonvretb2" onChange="if(idonvretb1.selectedIndex==0) idonvretb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("don","id","fechadon","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($idonvret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Extra</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="icretvretl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="icretvretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="icretvretb2" onChange="if(icretvretb1.selectedIndex==0) icretvretb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("cret","id","labelcret","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($icretvret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Valor</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="valorvretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="valorvretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="valorvretb2" id="valorvret" value="" size="50" onKeyUp="revisainput('valorvretb1','valorvretb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Status</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="statusvretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="statusvretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="statusvretb2" onChange="if(statusvretb1.selectedIndex==0) statusvretb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="1" <? if($statusvret=="1") { ?>selected<? } ?> >V�lido</option><OPTION VALUE="2" <? if($statusvret=="2") { ?>selected<? } ?> >Cancelado por insuficiencia</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Ganador</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><input type="checkbox" name="ganvretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="ganvretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ganvretb2" value="" size="10" onKeyUp="revisainput('ganvretb1','ganvretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario=="meminpinguin") {?>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('vret.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0 || $nivelusuario==1) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelvret.php?step=busqueda2<?=$url_extra?>');">
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

