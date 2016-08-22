<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_ret"]=1;
	$_SESSION["esframe_ret_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_ret_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_ret"]=0;
	$_SESSION["esframe_ret_id"]=0;
	$_SESSION["esframe_ret_archivo"]="";
}

$titulo_pagina="Iniciativas";
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

$numerodetabla=2;
include("recursos/funciones_tabla.php"); 
$archivoactual="ret.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_ret"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==0)   {     if($tcomentariosretl1=="on" || $domicilio2retl1=="on") $error=9;     if(isset($tcomentariosretb2) || isset($domicilio2retb2)) $error=9;   }  if($nivelusuario==1)   {     if($tcomentariosretl1=="on" || $domicilio2retl1=="on") $error=9;     if(isset($tcomentariosretb2) || isset($domicilio2retb2)) $error=9;   }  if($nivelusuario==2)   {     if($tcomentariosretl1=="on" || $domicilio2retl1=="on") $error=9;     if(isset($tcomentariosretb2) || isset($domicilio2retb2)) $error=9;   }  if($nivelusuario==3)   {     if($nombreretl1=="on" || $i_nombreretl1=="on" || $destacadoretl1=="on" || $nombrecortoretl1=="on" || $i_nombrecortoretl1=="on" || $icatretl1=="on" || $statusretl1=="on" || $razonesretl1=="on" || $fechaaltaretl1=="on" || $descripcionretl1=="on" || $i_descripcionretl1=="on" || $condicionesretl1=="on" || $i_condicionesretl1=="on" || $metaretl1=="on" || $minimodonativoretl1=="on" || $maximoganadoresretl1=="on" || $tganadoresretl1=="on" || $importedonativosretl1=="on" || $tdonativosretl1=="on" || $tgustaretl1=="on" || $tcomentariosretl1=="on" || $finicioretl1=="on" || $ffinretl1=="on" || $imagenretl1=="on" || $videoretl1=="on" || $urlretl1=="on" || $ipaisretl1=="on" || $iestadoretl1=="on" || $domicilio1retl1=="on" || $domicilio2retl1=="on" || $idiomal1=="on") $error=9;     if(isset($nombreretb2) || isset($i_nombreretb2) || isset($destacadoretb2) || isset($nombrecortoretb2) || isset($i_nombrecortoretb2) || isset($icatretb2) || isset($statusretb2) || isset($razonesretb2) || isset($fechaaltaretb2) || isset($descripcionretb2) || isset($i_descripcionretb2) || isset($condicionesretb2) || isset($i_condicionesretb2) || isset($metaretb2) || isset($minimodonativoretb2) || isset($maximoganadoresretb2) || isset($tganadoresretb2) || isset($importedonativosretb2) || isset($tdonativosretb2) || isset($tgustaretb2) || isset($tcomentariosretb2) || isset($finicioretb2) || isset($ffinretb2) || isset($imagenretb2) || isset($videoretb2) || isset($urlretb2) || isset($ipaisretb2) || isset($iestadoretb2) || isset($domicilio1retb2) || isset($domicilio2retb2) || isset($idiomab2)) $error=9;   }  if($nivelusuario==4)   {     if($nombreretl1=="on" || $i_nombreretl1=="on" || $destacadoretl1=="on" || $nombrecortoretl1=="on" || $i_nombrecortoretl1=="on" || $icatretl1=="on" || $statusretl1=="on" || $razonesretl1=="on" || $fechaaltaretl1=="on" || $descripcionretl1=="on" || $i_descripcionretl1=="on" || $condicionesretl1=="on" || $i_condicionesretl1=="on" || $metaretl1=="on" || $minimodonativoretl1=="on" || $maximoganadoresretl1=="on" || $tganadoresretl1=="on" || $importedonativosretl1=="on" || $tdonativosretl1=="on" || $tgustaretl1=="on" || $tcomentariosretl1=="on" || $finicioretl1=="on" || $ffinretl1=="on" || $imagenretl1=="on" || $videoretl1=="on" || $urlretl1=="on" || $ipaisretl1=="on" || $iestadoretl1=="on" || $domicilio1retl1=="on" || $domicilio2retl1=="on" || $idiomal1=="on") $error=9;     if(isset($nombreretb2) || isset($i_nombreretb2) || isset($destacadoretb2) || isset($nombrecortoretb2) || isset($i_nombrecortoretb2) || isset($icatretb2) || isset($statusretb2) || isset($razonesretb2) || isset($fechaaltaretb2) || isset($descripcionretb2) || isset($i_descripcionretb2) || isset($condicionesretb2) || isset($i_condicionesretb2) || isset($metaretb2) || isset($minimodonativoretb2) || isset($maximoganadoresretb2) || isset($tganadoresretb2) || isset($importedonativosretb2) || isset($tdonativosretb2) || isset($tgustaretb2) || isset($tcomentariosretb2) || isset($finicioretb2) || isset($ffinretb2) || isset($imagenretb2) || isset($videoretb2) || isset($urlretb2) || isset($ipaisretb2) || isset($iestadoretb2) || isset($domicilio1retb2) || isset($domicilio2retb2) || isset($idiomab2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=8;   if($nivelusuario==1) if(isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=8;   if($nivelusuario==2) if(isset($_POST["nombreret"]) || isset($_POST["i_nombreret"]) || isset($_POST["icatret"]) || isset($_POST["statusret"]) || isset($_POST["razonesret"]) || isset($_POST["fechaaltaret"]) || isset($_POST["descripcionret"]) || isset($_POST["i_descripcionret"]) || isset($_POST["condicionesret"]) || isset($_POST["i_condicionesret"]) || isset($_POST["metaret"]) || isset($_POST["minimodonativoret"]) || isset($_POST["maximoganadoresret"]) || isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["finicioret"]) || isset($_POST["ffinret"]) || isset($_POST["imagenret"]) || isset($_POST["videoret"]) || isset($_POST["urlret"]) || isset($_POST["ipaisret"]) || isset($_POST["iestadoret"]) || isset($_POST["domicilio1ret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=8;   if($nivelusuario==3) if(isset($_POST["nombreret"]) || isset($_POST["i_nombreret"]) || isset($_POST["destacadoret"]) || isset($_POST["nombrecortoret"]) || isset($_POST["i_nombrecortoret"]) || isset($_POST["icatret"]) || isset($_POST["statusret"]) || isset($_POST["razonesret"]) || isset($_POST["fechaaltaret"]) || isset($_POST["descripcionret"]) || isset($_POST["i_descripcionret"]) || isset($_POST["condicionesret"]) || isset($_POST["i_condicionesret"]) || isset($_POST["metaret"]) || isset($_POST["minimodonativoret"]) || isset($_POST["maximoganadoresret"]) || isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["finicioret"]) || isset($_POST["ffinret"]) || isset($_POST["imagenret"]) || isset($_POST["videoret"]) || isset($_POST["urlret"]) || isset($_POST["ipaisret"]) || isset($_POST["iestadoret"]) || isset($_POST["domicilio1ret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=8;   if($nivelusuario==4) if(isset($_POST["nombreret"]) || isset($_POST["i_nombreret"]) || isset($_POST["destacadoret"]) || isset($_POST["nombrecortoret"]) || isset($_POST["i_nombrecortoret"]) || isset($_POST["icatret"]) || isset($_POST["statusret"]) || isset($_POST["razonesret"]) || isset($_POST["fechaaltaret"]) || isset($_POST["descripcionret"]) || isset($_POST["i_descripcionret"]) || isset($_POST["condicionesret"]) || isset($_POST["i_condicionesret"]) || isset($_POST["metaret"]) || isset($_POST["minimodonativoret"]) || isset($_POST["maximoganadoresret"]) || isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["finicioret"]) || isset($_POST["ffinret"]) || isset($_POST["imagenret"]) || isset($_POST["videoret"]) || isset($_POST["urlret"]) || isset($_POST["ipaisret"]) || isset($_POST["iestadoret"]) || isset($_POST["domicilio1ret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=7;   if($nivelusuario==1) if(isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=7;   if($nivelusuario==2) if(isset($_POST["nombreret"]) || isset($_POST["i_nombreret"]) || isset($_POST["icatret"]) || isset($_POST["statusret"]) || isset($_POST["razonesret"]) || isset($_POST["fechaaltaret"]) || isset($_POST["descripcionret"]) || isset($_POST["i_descripcionret"]) || isset($_POST["condicionesret"]) || isset($_POST["i_condicionesret"]) || isset($_POST["metaret"]) || isset($_POST["minimodonativoret"]) || isset($_POST["maximoganadoresret"]) || isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["finicioret"]) || isset($_POST["ffinret"]) || isset($_POST["imagenret"]) || isset($_POST["videoret"]) || isset($_POST["urlret"]) || isset($_POST["ipaisret"]) || isset($_POST["iestadoret"]) || isset($_POST["domicilio1ret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=7;   if($nivelusuario==3) if(isset($_POST["nombreret"]) || isset($_POST["i_nombreret"]) || isset($_POST["destacadoret"]) || isset($_POST["nombrecortoret"]) || isset($_POST["i_nombrecortoret"]) || isset($_POST["icatret"]) || isset($_POST["statusret"]) || isset($_POST["razonesret"]) || isset($_POST["fechaaltaret"]) || isset($_POST["descripcionret"]) || isset($_POST["i_descripcionret"]) || isset($_POST["condicionesret"]) || isset($_POST["i_condicionesret"]) || isset($_POST["metaret"]) || isset($_POST["minimodonativoret"]) || isset($_POST["maximoganadoresret"]) || isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["finicioret"]) || isset($_POST["ffinret"]) || isset($_POST["imagenret"]) || isset($_POST["videoret"]) || isset($_POST["urlret"]) || isset($_POST["ipaisret"]) || isset($_POST["iestadoret"]) || isset($_POST["domicilio1ret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=7;   if($nivelusuario==4) if(isset($_POST["nombreret"]) || isset($_POST["i_nombreret"]) || isset($_POST["destacadoret"]) || isset($_POST["nombrecortoret"]) || isset($_POST["i_nombrecortoret"]) || isset($_POST["icatret"]) || isset($_POST["statusret"]) || isset($_POST["razonesret"]) || isset($_POST["fechaaltaret"]) || isset($_POST["descripcionret"]) || isset($_POST["i_descripcionret"]) || isset($_POST["condicionesret"]) || isset($_POST["i_condicionesret"]) || isset($_POST["metaret"]) || isset($_POST["minimodonativoret"]) || isset($_POST["maximoganadoresret"]) || isset($_POST["tganadoresret"]) || isset($_POST["importedonativosret"]) || isset($_POST["tdonativosret"]) || isset($_POST["tgustaret"]) || isset($_POST["tcomentariosret"]) || isset($_POST["finicioret"]) || isset($_POST["ffinret"]) || isset($_POST["imagenret"]) || isset($_POST["videoret"]) || isset($_POST["urlret"]) || isset($_POST["ipaisret"]) || isset($_POST["iestadoret"]) || isset($_POST["domicilio1ret"]) || isset($_POST["domicilio2ret"]) || isset($_POST["idioma"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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


<?if($_SESSION["esframe_ret"]==1){  if($_SESSION["esframe_ret_archivo"]=="usuarios")  {    if($step=="add")    {      $iusuarioret=$_SESSION["id_usuarios"];    }    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")    {      $iusuarioretb1="=";      $iusuarioretb2=$_SESSION["id_usuarios"];    }  }}?>


<head>

<title><? echo("Iniciativas"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<script>
function funcionload()
{
<? if($step=="busqueda") { ?> initListGroup('arbol1', document.forms['form2'].ipaisretb2, document.forms['form2'].iestadoretb2);<? } else if($step=="modify" || $step=="add") { ?> initListGroup('arbol1', document.forms['form1'].ipaisret, document.forms['form1'].iestadoret);<? } ?> 
}
</script>
<? include("recursos/funcionesjs.php"); ?>
<script language="JavaScript" src="include/imenu_peque.js"></script>

<script language="javascript" type="text/javascript" src="include/autocompleta/ajax.js"></script><script language="javascript" type="text/javascript" src="include/autocompleta/ajax-dynamic-list.js"></script><link href="include/autocompleta/estilos.css" rel="stylesheet" type="text/css"/>
</head>
<BODY style="margin-right:0px;" onLoad="funcionload();">

<?
  if($ocultabotones<>1) {   
    if($_SESSION["esframe_ret"]<>1)
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
  if(isset($_POST["metaret"])) $_POST["metaret"]=limpia_numero($_POST["metaret"]);if(isset($_POST["minimodonativoret"])) $_POST["minimodonativoret"]=limpia_numero($_POST["minimodonativoret"]);if(isset($_POST["maximoganadoresret"])) $_POST["maximoganadoresret"]=limpia_numero($_POST["maximoganadoresret"]);if(isset($_POST["tganadoresret"])) $_POST["tganadoresret"]=limpia_numero($_POST["tganadoresret"]);if(isset($_POST["importedonativosret"])) $_POST["importedonativosret"]=limpia_numero($_POST["importedonativosret"]);if(isset($_POST["tdonativosret"])) $_POST["tdonativosret"]=limpia_numero($_POST["tdonativosret"]);if(isset($_POST["tgustaret"])) $_POST["tgustaret"]=limpia_numero($_POST["tgustaret"]);if(isset($_POST["tcomentariosret"])) $_POST["tcomentariosret"]=limpia_numero($_POST["tcomentariosret"]);
  
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
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM ret where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("nombreret","'",0);$sqltemporal.=construyesqltemporal("i_nombreret","'",0);$sqltemporal.=construyesqltemporal("destacadoret","'",0);$sqltemporal.=construyesqltemporal("nombrecortoret","'",0);$sqltemporal.=construyesqltemporal("i_nombrecortoret","'",0);$sqltemporal.=construyesqltemporal("icatret","",0);$sqltemporal.=construyesqltemporal("statusret","'",0);$sqltemporal.=construyesqltemporal("razonesret","'",0);$sqltemporal.=construyesqltemporal("iusuarioret","",0);$sqltemporal.=construyesqltemporal("fechaaltaret","'",0);$sqltemporal.=construyesqltemporal("descripcionret","'",0);$sqltemporal.=construyesqltemporal("i_descripcionret","'",0);$sqltemporal.=construyesqltemporal("condicionesret","'",0);$sqltemporal.=construyesqltemporal("i_condicionesret","'",0);$sqltemporal.=construyesqltemporal("metaret","",2);$sqltemporal.=construyesqltemporal("minimodonativoret","",2);$sqltemporal.=construyesqltemporal("maximoganadoresret","",2);$sqltemporal.=construyesqltemporal("tganadoresret","",2);$sqltemporal.=construyesqltemporal("importedonativosret","",2);$sqltemporal.=construyesqltemporal("tdonativosret","",2);$sqltemporal.=construyesqltemporal("tgustaret","",2);$sqltemporal.=construyesqltemporal("tcomentariosret","",2);$sqltemporal.=construyesqltemporal("finicioret","'",0);$sqltemporal.=construyesqltemporal("ffinret","'",0);$sqltemporal.=construyesqltemporal("imagenret","'",0);$sqltemporal.=construyesqltemporal("videoret","'",0);$sqltemporal.=construyesqltemporal("urlret","'",0);$sqltemporal.=construyesqltemporal("ipaisret","",0);$sqltemporal.=construyesqltemporal("iestadoret","",0);$sqltemporal.=construyesqltemporal("domicilio1ret","'",0);$sqltemporal.=construyesqltemporal("domicilio2ret","'",0);$sqltemporal.=construyesqltemporal("idioma","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
      	
		  $sql = "INSERT INTO ret SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=2,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_ret"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_ret"]="OK";
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
		  $sql = "UPDATE ret SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=2,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM ret where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["nombreret"]<>$rown["nombreret"]) $cadena_historico.="Nombre:\r\n O:".$rowh["nombreret"]."\r\nN: ".$rown["nombreret"]."\r\n\r\n";               if($rowh["iusuarioret"]<>$rown["iusuarioret"]) $cadena_historico.="Usuario:\r\n O:".$rowh["iusuarioret"]."\r\nN: ".$rown["iusuarioret"]."\r\n\r\n";               if($rowh["fechaaltaret"]<>$rown["fechaaltaret"]) $cadena_historico.="Fecha de alta:\r\n O:".$rowh["fechaaltaret"]."\r\nN: ".$rown["fechaaltaret"]."\r\n\r\n";               if($rowh["descripcionret"]<>$rown["descripcionret"]) $cadena_historico.="Descripción:\r\n O:".$rowh["descripcionret"]."\r\nN: ".$rown["descripcionret"]."\r\n\r\n";               if($rowh["condicionesret"]<>$rown["condicionesret"]) $cadena_historico.="Condiciones:\r\n O:".$rowh["condicionesret"]."\r\nN: ".$rown["condicionesret"]."\r\n\r\n";               if($rowh["metaret"]<>$rown["metaret"]) $cadena_historico.="Meta:\r\n O:".$rowh["metaret"]."\r\nN: ".$rown["metaret"]."\r\n\r\n";               if($rowh["minimodonativoret"]<>$rown["minimodonativoret"]) $cadena_historico.="Mínimo donativo:\r\n O:".$rowh["minimodonativoret"]."\r\nN: ".$rown["minimodonativoret"]."\r\n\r\n";               if($rowh["maximoganadoresret"]<>$rown["maximoganadoresret"]) $cadena_historico.="Máximo ganadores:\r\n O:".$rowh["maximoganadoresret"]."\r\nN: ".$rown["maximoganadoresret"]."\r\n\r\n";               if($rowh["tganadoresret"]<>$rown["tganadoresret"]) $cadena_historico.="Número de ganadores:\r\n O:".$rowh["tganadoresret"]."\r\nN: ".$rown["tganadoresret"]."\r\n\r\n";               if($rowh["importedonativosret"]<>$rown["importedonativosret"]) $cadena_historico.="Importe donativos:\r\n O:".$rowh["importedonativosret"]."\r\nN: ".$rown["importedonativosret"]."\r\n\r\n";               if($rowh["tdonativosret"]<>$rown["tdonativosret"]) $cadena_historico.="Número de donativos:\r\n O:".$rowh["tdonativosret"]."\r\nN: ".$rown["tdonativosret"]."\r\n\r\n";               if($rowh["tgustaret"]<>$rown["tgustaret"]) $cadena_historico.="Total de gusta:\r\n O:".$rowh["tgustaret"]."\r\nN: ".$rown["tgustaret"]."\r\n\r\n";               if($rowh["tcomentariosret"]<>$rown["tcomentariosret"]) $cadena_historico.="Total de comentarios:\r\n O:".$rowh["tcomentariosret"]."\r\nN: ".$rown["tcomentariosret"]."\r\n\r\n";               if($rowh["finicioret"]<>$rown["finicioret"]) $cadena_historico.="Fecha de inicio:\r\n O:".$rowh["finicioret"]."\r\nN: ".$rown["finicioret"]."\r\n\r\n";               if($rowh["ffinret"]<>$rown["ffinret"]) $cadena_historico.="Fecha de fin:\r\n O:".$rowh["ffinret"]."\r\nN: ".$rown["ffinret"]."\r\n\r\n";               if($rowh["imagenret"]<>$rown["imagenret"]) $cadena_historico.="Imagen:\r\n O:".$rowh["imagenret"]."\r\nN: ".$rown["imagenret"]."\r\n\r\n";               if($rowh["videoret"]<>$rown["videoret"]) $cadena_historico.="Video:\r\n O:".$rowh["videoret"]."\r\nN: ".$rown["videoret"]."\r\n\r\n";               if($rowh["urlret"]<>$rown["urlret"]) $cadena_historico.="URL:\r\n O:".$rowh["urlret"]."\r\nN: ".$rown["urlret"]."\r\n\r\n";               if($rowh["ipaisret"]<>$rown["ipaisret"]) $cadena_historico.="País:\r\n O:".$rowh["ipaisret"]."\r\nN: ".$rown["ipaisret"]."\r\n\r\n";               if($rowh["iestadoret"]<>$rown["iestadoret"]) $cadena_historico.="Estado:\r\n O:".$rowh["iestadoret"]."\r\nN: ".$rown["iestadoret"]."\r\n\r\n";               if($rowh["domicilio1ret"]<>$rown["domicilio1ret"]) $cadena_historico.="Domicilio 1:\r\n O:".$rowh["domicilio1ret"]."\r\nN: ".$rown["domicilio1ret"]."\r\n\r\n";               if($rowh["domicilio2ret"]<>$rown["domicilio2ret"]) $cadena_historico.="Domicilio 2:\r\n O:".$rowh["domicilio2ret"]."\r\nN: ".$rown["domicilio2ret"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_ret"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_ret"]="NADA";
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
	$res=@mysqli_query($GLOBALS["enlaceDB"],"select nombreret,urlamigableret from ret where id=".$id);
	while($row=mysqli_fetch_object($res))
		if($row->urlamigableret=="")
			@mysqli_query($GLOBALS["enlaceDB"],"update ret set urlamigableret='".convierte_url_APIAdmin($row->nombreret)."' where id=".$id);
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
		$sql = "DELETE FROM ret WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=2,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_ret"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,nombreret FROM ret where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["nombreret"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=ret.php?step=1".$url_extra."><span class=titulo>Iniciativas</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) $botones.="<td><a href=ret.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Iniciativas\"></a></td>";if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) $botones.="<td><a href=ret.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Iniciativas\"></a></td>";if(($nivelusuario==0 || $nivelusuario==1)) $botones.="<td><a href=\"ret.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Iniciativas\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_ret"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_ret"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_ret"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_ret"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="ret.activo DESC,nombreret ASC"; $ordenamiento="";$activob1="="; $activob2="1";$nombreretl1="on"; $statusretl1="on"; $iusuarioretl1="on"; $fechaaltaretl1="on"; $metaretl1="on"; $minimodonativoretl1="on"; $maximoganadoresretl1="on"; $tganadoresretl1="on"; $importedonativosretl1="on"; $tdonativosretl1="on"; $tgustaretl1="on"; $tcomentariosretl1="on"; } $camposbuscadoslistadosearch="ret.id";cbusqueda1($activol1,"ret","activo");cbusqueda1($nombreretl1,"ret","nombreret");cbusqueda1($i_nombreretl1,"ret","i_nombreret");cbusqueda1($destacadoretl1,"ret","destacadoret");cbusqueda1($nombrecortoretl1,"ret","nombrecortoret");cbusqueda1($i_nombrecortoretl1,"ret","i_nombrecortoret");cbusqueda1($icatretl1,"cat","nombrecat","0","","");cbusqueda1($statusretl1,"ret","statusret");cbusqueda1($razonesretl1,"ret","razonesret");cbusqueda1($iusuarioretl1,"usuarios","nombreusuario","0","","");cbusqueda1($fechaaltaretl1,"ret","fechaaltaret");cbusqueda1($descripcionretl1,"ret","descripcionret");cbusqueda1($i_descripcionretl1,"ret","i_descripcionret");cbusqueda1($condicionesretl1,"ret","condicionesret");cbusqueda1($i_condicionesretl1,"ret","i_condicionesret");cbusqueda1($metaretl1,"ret","metaret");cbusqueda1($minimodonativoretl1,"ret","minimodonativoret");cbusqueda1($maximoganadoresretl1,"ret","maximoganadoresret");cbusqueda1($tganadoresretl1,"ret","tganadoresret");cbusqueda1($importedonativosretl1,"ret","importedonativosret");cbusqueda1($tdonativosretl1,"ret","tdonativosret");cbusqueda1($tgustaretl1,"ret","tgustaret");cbusqueda1($tcomentariosretl1,"ret","tcomentariosret");cbusqueda1($finicioretl1,"ret","finicioret");cbusqueda1($ffinretl1,"ret","ffinret");cbusqueda1($imagenretl1,"ret","imagenret");cbusqueda1($videoretl1,"ret","videoret");cbusqueda1($urlretl1,"ret","urlret");cbusqueda1($ipaisretl1,"pais","nombrepais","0","","");cbusqueda1($iestadoretl1,"estados","nombreestado","0","","");cbusqueda1($domicilio1retl1,"ret","domicilio1ret");cbusqueda1($domicilio2retl1,"ret","domicilio2ret");cbusqueda1($idiomal1,"ret","idioma");cbusqueda2($icatretl1,"cat","ret","icatret","",0,"id");cbusqueda2($iusuarioretl1,"usuarios","ret","iusuarioret","",0,"id");cbusqueda2($ipaisretl1,"pais","ret","ipaisret","",0,"id");cbusqueda2($iestadoretl1,"estados","ret","iestadoret","",0,"id");cbusqueda3($nombreretb1,$nombreretb2,"ret","nombreret","'","0","","");cbusqueda3($i_nombreretb1,$i_nombreretb2,"ret","i_nombreret","'","0","","");cbusqueda3($destacadoretb1,$destacadoretb2,"ret","destacadoret","'","0","","");cbusqueda3($nombrecortoretb1,$nombrecortoretb2,"ret","nombrecortoret","'","0","","");cbusqueda3($i_nombrecortoretb1,$i_nombrecortoretb2,"ret","i_nombrecortoret","'","0","","");cbusqueda3($icatretb1,$icatretb2,"ret","icatret","","0","","");cbusqueda3($statusretb1,$statusretb2,"ret","statusret","'","0","","");cbusqueda3($razonesretb1,$razonesretb2,"ret","razonesret","'","0","","");cbusqueda3($iusuarioretb1,$iusuarioretb2,"ret","iusuarioret","","0","","");cbusqueda3($fechaaltaretb1,$fechaaltaretb2,"ret","fechaaltaret","'","0","","");cbusqueda3($descripcionretb1,$descripcionretb2,"ret","descripcionret","'","0","","");cbusqueda3($i_descripcionretb1,$i_descripcionretb2,"ret","i_descripcionret","'","0","","");cbusqueda3($condicionesretb1,$condicionesretb2,"ret","condicionesret","'","0","","");cbusqueda3($i_condicionesretb1,$i_condicionesretb2,"ret","i_condicionesret","'","0","","");cbusqueda3($metaretb1,$metaretb2,"ret","metaret","","0","","");cbusqueda3($minimodonativoretb1,$minimodonativoretb2,"ret","minimodonativoret","","0","","");cbusqueda3($maximoganadoresretb1,$maximoganadoresretb2,"ret","maximoganadoresret","","0","","");cbusqueda3($tganadoresretb1,$tganadoresretb2,"ret","tganadoresret","","0","","");cbusqueda3($importedonativosretb1,$importedonativosretb2,"ret","importedonativosret","","0","","");cbusqueda3($tdonativosretb1,$tdonativosretb2,"ret","tdonativosret","","0","","");cbusqueda3($tgustaretb1,$tgustaretb2,"ret","tgustaret","","0","","");cbusqueda3($tcomentariosretb1,$tcomentariosretb2,"ret","tcomentariosret","","0","","");cbusqueda3($finicioretb1,$finicioretb2,"ret","finicioret","'","0","","");cbusqueda3($ffinretb1,$ffinretb2,"ret","ffinret","'","0","","");cbusqueda3($imagenretb1,$imagenretb2,"ret","imagenret","'","0","","");cbusqueda3($videoretb1,$videoretb2,"ret","videoret","'","0","","");cbusqueda3($urlretb1,$urlretb2,"ret","urlret","'","0","","");cbusqueda3($ipaisretb1,$ipaisretb2,"ret","ipaisret","","0","","");cbusqueda3($iestadoretb1,$iestadoretb2,"ret","iestadoret","","0","","");cbusqueda3($domicilio1retb1,$domicilio1retb2,"ret","domicilio1ret","'","0","","");cbusqueda3($domicilio2retb1,$domicilio2retb2,"ret","domicilio2ret","'","0","","");cbusqueda3($idiomab1,$idiomab2,"ret","idioma","'","0","","");cbusqueda3($activob1,$activob2,"ret","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from ret ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($nombreretl1,"Nombre",": STR","");cbusqueda5($i_nombreretl1,"Nombre en inglés",": STR","");cbusqueda5($destacadoretl1,"Destacado",": STR","");cbusqueda5($nombrecortoretl1,"Nombre corto",": STR","");cbusqueda5($i_nombrecortoretl1,"Nombre corto en inglés",": STR","");cbusqueda5($icatretl1,"Categoría principal",": STR","");cbusqueda5($statusretl1,"Status",": STR","");cbusqueda5($razonesretl1,"Razones de rechazo",": STR","");cbusqueda5($iusuarioretl1,"Usuario",": STR","");cbusqueda5($fechaaltaretl1,"Fecha de alta"," : DATE","");cbusqueda5($descripcionretl1,"Descripción",": STR","");cbusqueda5($i_descripcionretl1,"Descripción en inglés",": STR","");cbusqueda5($condicionesretl1,"Condiciones",": STR","");cbusqueda5($i_condicionesretl1,"Condiciones en inglés",": STR","");cbusqueda5($metaretl1,"Meta"," : NUM","");cbusqueda5($minimodonativoretl1,"Mínimo donativo"," : NUM","");cbusqueda5($maximoganadoresretl1,"Máximo ganadores"," : NUM","");cbusqueda5($tganadoresretl1,"Número de ganadores"," : NUM","");cbusqueda5($importedonativosretl1,"Importe donativos"," : NUM","");cbusqueda5($tdonativosretl1,"Número de donativos"," : NUM","");cbusqueda5($tgustaretl1,"Total de gusta"," : NUM","");cbusqueda5($tcomentariosretl1,"Total de comentarios"," : NUM","");cbusqueda5($finicioretl1,"Fecha de inicio"," : DATE","");cbusqueda5($ffinretl1,"Fecha de fin"," : DATE","");cbusqueda5($imagenretl1,"Imagen",": STR","");cbusqueda5($videoretl1,"Video",": STR","");cbusqueda5($urlretl1,"URL",": STR","");cbusqueda5($ipaisretl1,"País",": STR","");cbusqueda5($iestadoretl1,"Estado",": STR","");cbusqueda5($domicilio1retl1,"Domicilio 1",": STR","");cbusqueda5($domicilio2retl1,"Domicilio 2",": STR","");cbusqueda5($idiomal1,"Idioma",": STR",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='ret.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";if($tganadoresretl1=="on") $sumatoriatganadoresret=$sumatoriatganadoresret+$row["tganadoresret"];if($importedonativosretl1=="on") $sumatoriaimportedonativosret=$sumatoriaimportedonativosret+$row["importedonativosret"];if($tdonativosretl1=="on") $sumatoriatdonativosret=$sumatoriatdonativosret+$row["tdonativosret"];if($tgustaretl1=="on") $sumatoriatgustaret=$sumatoriatgustaret+$row["tgustaret"];$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($nombreretl1,"ret","nombreret","0","","");cbusqueda4($i_nombreretl1,"ret","i_nombreret","0","",""); if($destacadoretl1=="on")  {  if($row["destacadoret"]=="0") $tempodestacadoret="NO";if($row["destacadoret"]=="1") $tempodestacadoret="SI";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempodestacadoret.$tempotigra."\""; $tempotigra="";  } cbusqueda4($nombrecortoretl1,"ret","nombrecortoret","0","","");cbusqueda4($i_nombrecortoretl1,"ret","i_nombrecortoret","0","","");cbusqueda4($icatretl1,"cat","nombrecat","0","",""); if($statusretl1=="on")  {  if($row["statusret"]=="3") $tempostatusret="No enviado a validación";if($row["statusret"]=="0") $tempostatusret="Pendiente de validación";if($row["statusret"]=="1") $tempostatusret="Validado";if($row["statusret"]=="2") $tempostatusret="Rechazado";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempostatusret.$tempotigra."\""; $tempotigra="";  } cbusqueda4($razonesretl1,"ret","razonesret","0","","");cbusqueda4($iusuarioretl1,"usuarios","nombreusuario","0","","");cbusqueda4($fechaaltaretl1,"ret","fechaaltaret","0","","");cbusqueda4($descripcionretl1,"ret","descripcionret","0","","");cbusqueda4($i_descripcionretl1,"ret","i_descripcionret","0","","");cbusqueda4($condicionesretl1,"ret","condicionesret","0","","");cbusqueda4($i_condicionesretl1,"ret","i_condicionesret","0","","");cbusqueda4($metaretl1,"ret","metaret","0","","");cbusqueda4($minimodonativoretl1,"ret","minimodonativoret","0","","");cbusqueda4($maximoganadoresretl1,"ret","maximoganadoresret","0","","");cbusqueda4($tganadoresretl1,"ret","tganadoresret","0","","");cbusqueda4($importedonativosretl1,"ret","importedonativosret","0","","");cbusqueda4($tdonativosretl1,"ret","tdonativosret","0","","");cbusqueda4($tgustaretl1,"ret","tgustaret","0","","");cbusqueda4($tcomentariosretl1,"ret","tcomentariosret","0","","");cbusqueda4($finicioretl1,"ret","finicioret","0","","");cbusqueda4($ffinretl1,"ret","ffinret","0","","");cbusqueda4($imagenretl1,"ret","imagenret","0","","");cbusqueda4($videoretl1,"ret","videoret","0","","");cbusqueda4($urlretl1,"ret","urlret","0","","");cbusqueda4($ipaisretl1,"pais","nombrepais","0","","");cbusqueda4($iestadoretl1,"estados","nombreestado","0","","");cbusqueda4($domicilio1retl1,"ret","domicilio1ret","0","","");cbusqueda4($domicilio2retl1,"ret","domicilio2ret","0","",""); if($idiomal1=="on")  {  if($row["idioma"]=="0") $tempoidioma="Español";if($row["idioma"]=="1") $tempoidioma="Inglés";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempoidioma.$tempotigra."\""; $tempotigra="";  }  if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($nombreretl1,$sumatorianombreret,'');cbusqueda6($i_nombreretl1,$sumatoriai_nombreret,'');cbusqueda6($destacadoretl1,$sumatoriadestacadoret,'');cbusqueda6($nombrecortoretl1,$sumatorianombrecortoret,'');cbusqueda6($i_nombrecortoretl1,$sumatoriai_nombrecortoret,'');cbusqueda6($icatretl1,$sumatoriaicatret,'');cbusqueda6($statusretl1,$sumatoriastatusret,'');cbusqueda6($razonesretl1,$sumatoriarazonesret,'');cbusqueda6($iusuarioretl1,$sumatoriaiusuarioret,'');cbusqueda6($fechaaltaretl1,$sumatoriafechaaltaret,'');cbusqueda6($descripcionretl1,$sumatoriadescripcionret,'');cbusqueda6($i_descripcionretl1,$sumatoriai_descripcionret,'');cbusqueda6($condicionesretl1,$sumatoriacondicionesret,'');cbusqueda6($i_condicionesretl1,$sumatoriai_condicionesret,'');cbusqueda6($metaretl1,$sumatoriametaret,'');cbusqueda6($minimodonativoretl1,$sumatoriaminimodonativoret,'');cbusqueda6($maximoganadoresretl1,$sumatoriamaximoganadoresret,'');cbusqueda6($tganadoresretl1,$sumatoriatganadoresret,'');cbusqueda6($importedonativosretl1,$sumatoriaimportedonativosret,'');cbusqueda6($tdonativosretl1,$sumatoriatdonativosret,'');cbusqueda6($tgustaretl1,$sumatoriatgustaret,'');cbusqueda6($tcomentariosretl1,$sumatoriatcomentariosret,'');cbusqueda6($finicioretl1,$sumatoriafinicioret,'');cbusqueda6($ffinretl1,$sumatoriaffinret,'');cbusqueda6($imagenretl1,$sumatoriaimagenret,'');cbusqueda6($videoretl1,$sumatoriavideoret,'');cbusqueda6($urlretl1,$sumatoriaurlret,'');cbusqueda6($ipaisretl1,$sumatoriaipaisret,'');cbusqueda6($iestadoretl1,$sumatoriaiestadoret,'');cbusqueda6($domicilio1retl1,$sumatoriadomicilio1ret,'');cbusqueda6($domicilio2retl1,$sumatoriadomicilio2ret,'');cbusqueda6($idiomal1,$sumatoriaidioma,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelret.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=nombreretl1 type="hidden" value="<?=$nombreretl1?>" ><input name=nombreretb1 type="hidden" value="<?=$nombreretb1?>" ><input name=nombreretb2 type="hidden" value="<?=$nombreretb2?>" ><input name=i_nombreretl1 type="hidden" value="<?=$i_nombreretl1?>" ><input name=i_nombreretb1 type="hidden" value="<?=$i_nombreretb1?>" ><input name=i_nombreretb2 type="hidden" value="<?=$i_nombreretb2?>" ><input name=destacadoretl1 type="hidden" value="<?=$destacadoretl1?>" ><input name=destacadoretb1 type="hidden" value="<?=$destacadoretb1?>" ><input name=destacadoretb2 type="hidden" value="<?=$destacadoretb2?>" ><input name=nombrecortoretl1 type="hidden" value="<?=$nombrecortoretl1?>" ><input name=nombrecortoretb1 type="hidden" value="<?=$nombrecortoretb1?>" ><input name=nombrecortoretb2 type="hidden" value="<?=$nombrecortoretb2?>" ><input name=i_nombrecortoretl1 type="hidden" value="<?=$i_nombrecortoretl1?>" ><input name=i_nombrecortoretb1 type="hidden" value="<?=$i_nombrecortoretb1?>" ><input name=i_nombrecortoretb2 type="hidden" value="<?=$i_nombrecortoretb2?>" ><input name=icatretl1 type="hidden" value="<?=$icatretl1?>" ><input name=icatretb1 type="hidden" value="<?=$icatretb1?>" ><input name=icatretb2 type="hidden" value="<?=$icatretb2?>" ><input name=statusretl1 type="hidden" value="<?=$statusretl1?>" ><input name=statusretb1 type="hidden" value="<?=$statusretb1?>" ><input name=statusretb2 type="hidden" value="<?=$statusretb2?>" ><input name=razonesretl1 type="hidden" value="<?=$razonesretl1?>" ><input name=razonesretb1 type="hidden" value="<?=$razonesretb1?>" ><input name=razonesretb2 type="hidden" value="<?=$razonesretb2?>" ><input name=iusuarioretl1 type="hidden" value="<?=$iusuarioretl1?>" ><input name=iusuarioretb1 type="hidden" value="<?=$iusuarioretb1?>" ><input name=iusuarioretb2 type="hidden" value="<?=$iusuarioretb2?>" ><input name=fechaaltaretl1 type="hidden" value="<?=$fechaaltaretl1?>" ><input name=fechaaltaretb1 type="hidden" value="<?=$fechaaltaretb1?>" ><input name=fechaaltaretb2 type="hidden" value="<?=$fechaaltaretb2?>" ><input name=descripcionretl1 type="hidden" value="<?=$descripcionretl1?>" ><input name=descripcionretb1 type="hidden" value="<?=$descripcionretb1?>" ><input name=descripcionretb2 type="hidden" value="<?=$descripcionretb2?>" ><input name=i_descripcionretl1 type="hidden" value="<?=$i_descripcionretl1?>" ><input name=i_descripcionretb1 type="hidden" value="<?=$i_descripcionretb1?>" ><input name=i_descripcionretb2 type="hidden" value="<?=$i_descripcionretb2?>" ><input name=condicionesretl1 type="hidden" value="<?=$condicionesretl1?>" ><input name=condicionesretb1 type="hidden" value="<?=$condicionesretb1?>" ><input name=condicionesretb2 type="hidden" value="<?=$condicionesretb2?>" ><input name=i_condicionesretl1 type="hidden" value="<?=$i_condicionesretl1?>" ><input name=i_condicionesretb1 type="hidden" value="<?=$i_condicionesretb1?>" ><input name=i_condicionesretb2 type="hidden" value="<?=$i_condicionesretb2?>" ><input name=metaretl1 type="hidden" value="<?=$metaretl1?>" ><input name=metaretb1 type="hidden" value="<?=$metaretb1?>" ><input name=metaretb2 type="hidden" value="<?=$metaretb2?>" ><input name=minimodonativoretl1 type="hidden" value="<?=$minimodonativoretl1?>" ><input name=minimodonativoretb1 type="hidden" value="<?=$minimodonativoretb1?>" ><input name=minimodonativoretb2 type="hidden" value="<?=$minimodonativoretb2?>" ><input name=maximoganadoresretl1 type="hidden" value="<?=$maximoganadoresretl1?>" ><input name=maximoganadoresretb1 type="hidden" value="<?=$maximoganadoresretb1?>" ><input name=maximoganadoresretb2 type="hidden" value="<?=$maximoganadoresretb2?>" ><input name=tganadoresretl1 type="hidden" value="<?=$tganadoresretl1?>" ><input name=tganadoresretb1 type="hidden" value="<?=$tganadoresretb1?>" ><input name=tganadoresretb2 type="hidden" value="<?=$tganadoresretb2?>" ><input name=importedonativosretl1 type="hidden" value="<?=$importedonativosretl1?>" ><input name=importedonativosretb1 type="hidden" value="<?=$importedonativosretb1?>" ><input name=importedonativosretb2 type="hidden" value="<?=$importedonativosretb2?>" ><input name=tdonativosretl1 type="hidden" value="<?=$tdonativosretl1?>" ><input name=tdonativosretb1 type="hidden" value="<?=$tdonativosretb1?>" ><input name=tdonativosretb2 type="hidden" value="<?=$tdonativosretb2?>" ><input name=tgustaretl1 type="hidden" value="<?=$tgustaretl1?>" ><input name=tgustaretb1 type="hidden" value="<?=$tgustaretb1?>" ><input name=tgustaretb2 type="hidden" value="<?=$tgustaretb2?>" ><input name=tcomentariosretl1 type="hidden" value="<?=$tcomentariosretl1?>" ><input name=tcomentariosretb1 type="hidden" value="<?=$tcomentariosretb1?>" ><input name=tcomentariosretb2 type="hidden" value="<?=$tcomentariosretb2?>" ><input name=finicioretl1 type="hidden" value="<?=$finicioretl1?>" ><input name=finicioretb1 type="hidden" value="<?=$finicioretb1?>" ><input name=finicioretb2 type="hidden" value="<?=$finicioretb2?>" ><input name=ffinretl1 type="hidden" value="<?=$ffinretl1?>" ><input name=ffinretb1 type="hidden" value="<?=$ffinretb1?>" ><input name=ffinretb2 type="hidden" value="<?=$ffinretb2?>" ><input name=imagenretl1 type="hidden" value="<?=$imagenretl1?>" ><input name=imagenretb1 type="hidden" value="<?=$imagenretb1?>" ><input name=imagenretb2 type="hidden" value="<?=$imagenretb2?>" ><input name=videoretl1 type="hidden" value="<?=$videoretl1?>" ><input name=videoretb1 type="hidden" value="<?=$videoretb1?>" ><input name=videoretb2 type="hidden" value="<?=$videoretb2?>" ><input name=urlretl1 type="hidden" value="<?=$urlretl1?>" ><input name=urlretb1 type="hidden" value="<?=$urlretb1?>" ><input name=urlretb2 type="hidden" value="<?=$urlretb2?>" ><input name=ipaisretl1 type="hidden" value="<?=$ipaisretl1?>" ><input name=ipaisretb1 type="hidden" value="<?=$ipaisretb1?>" ><input name=ipaisretb2 type="hidden" value="<?=$ipaisretb2?>" ><input name=iestadoretl1 type="hidden" value="<?=$iestadoretl1?>" ><input name=iestadoretb1 type="hidden" value="<?=$iestadoretb1?>" ><input name=iestadoretb2 type="hidden" value="<?=$iestadoretb2?>" ><input name=domicilio1retl1 type="hidden" value="<?=$domicilio1retl1?>" ><input name=domicilio1retb1 type="hidden" value="<?=$domicilio1retb1?>" ><input name=domicilio1retb2 type="hidden" value="<?=$domicilio1retb2?>" ><input name=domicilio2retl1 type="hidden" value="<?=$domicilio2retl1?>" ><input name=domicilio2retb1 type="hidden" value="<?=$domicilio2retb1?>" ><input name=domicilio2retb2 type="hidden" value="<?=$domicilio2retb2?>" ><input name=idiomal1 type="hidden" value="<?=$idiomal1?>" ><input name=idiomab1 type="hidden" value="<?=$idiomab1?>" ><input name=idiomab2 type="hidden" value="<?=$idiomab2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelret.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
var HINTS_ITEMS = {'fechaaltaret':wrap("aaaa-mm-dd, 2008-11-18"),'finicioret':wrap("aaaa-mm-dd, 2008-11-18"),'ffinret':wrap("aaaa-mm-dd, 2008-11-18"),'activo':wrap("Seleccion SI para que el registro esté activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  <script>var directorio='../include';</script><script language="JavaScript" src="../include/calendar/calendar.js"></script><link rel="stylesheet" href="../include/calendar/calendar.css">
	<?
if(isset($_GET["iusuarioret"])) $iusuarioret=$_GET["iusuarioret"];	
if($error_unique==0)
{
$nombreret='';$i_nombreret='';$destacadoret='0';$nombrecortoret='';$i_nombrecortoret='';$icatret=0;$statusret='0';$razonesret='';$fecha=date("Y-m-d"); $fechaaltaret=substr($fecha, 0, 4)."-".substr($fecha, 5, 2)."-".substr($fecha, 8, 2);$descripcionret='';$i_descripcionret='';$condicionesret='';$i_condicionesret='';$metaret=0;$minimodonativoret=0;$maximoganadoresret=0;$tganadoresret=0;$importedonativosret=0;$tdonativosret=0;$tgustaret=0;$tcomentariosret=0;$finicioret='';$ffinret='';$imagenret='';$videoret='';$urlret='';$ipaisret=0;$iestadoret=0;$domicilio1ret='';$domicilio2ret='';$idioma='0';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["nombreret"])) $nombreret=$_POST["nombreret"];if(isset($_POST["i_nombreret"])) $i_nombreret=$_POST["i_nombreret"];if(isset($_POST["destacadoret"])) $destacadoret=$_POST["destacadoret"];if(isset($_POST["nombrecortoret"])) $nombrecortoret=$_POST["nombrecortoret"];if(isset($_POST["i_nombrecortoret"])) $i_nombrecortoret=$_POST["i_nombrecortoret"];if(isset($_POST["icatret"])) $icatret=$_POST["icatret"];if(isset($_POST["statusret"])) $statusret=$_POST["statusret"];if(isset($_POST["razonesret"])) $razonesret=$_POST["razonesret"];if(isset($_POST["iusuarioret"])) $iusuarioret=$_POST["iusuarioret"];if(isset($_POST["fechaaltaret"])) $fechaaltaret=$_POST["fechaaltaret"];if(isset($_POST["descripcionret"])) $descripcionret=$_POST["descripcionret"];if(isset($_POST["i_descripcionret"])) $i_descripcionret=$_POST["i_descripcionret"];if(isset($_POST["condicionesret"])) $condicionesret=$_POST["condicionesret"];if(isset($_POST["i_condicionesret"])) $i_condicionesret=$_POST["i_condicionesret"];if(isset($_POST["metaret"])) $metaret=$_POST["metaret"];if(isset($_POST["minimodonativoret"])) $minimodonativoret=$_POST["minimodonativoret"];if(isset($_POST["maximoganadoresret"])) $maximoganadoresret=$_POST["maximoganadoresret"];if(isset($_POST["tganadoresret"])) $tganadoresret=$_POST["tganadoresret"];if(isset($_POST["importedonativosret"])) $importedonativosret=$_POST["importedonativosret"];if(isset($_POST["tdonativosret"])) $tdonativosret=$_POST["tdonativosret"];if(isset($_POST["tgustaret"])) $tgustaret=$_POST["tgustaret"];if(isset($_POST["tcomentariosret"])) $tcomentariosret=$_POST["tcomentariosret"];if(isset($_POST["finicioret"])) $finicioret=$_POST["finicioret"];if(isset($_POST["ffinret"])) $ffinret=$_POST["ffinret"];if(isset($_POST["imagenret"])) $imagenret=$_POST["imagenret"];if(isset($_POST["videoret"])) $videoret=$_POST["videoret"];if(isset($_POST["urlret"])) $urlret=$_POST["urlret"];if(isset($_POST["ipaisret"])) $ipaisret=$_POST["ipaisret"];if(isset($_POST["iestadoret"])) $iestadoret=$_POST["iestadoret"];if(isset($_POST["domicilio1ret"])) $domicilio1ret=$_POST["domicilio1ret"];if(isset($_POST["domicilio2ret"])) $domicilio2ret=$_POST["domicilio2ret"];if(isset($_POST["idioma"])) $idioma=$_POST["idioma"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM ret where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM ret where id=". $id);
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
$nombreret=$row["nombreret"];$i_nombreret=$row["i_nombreret"];$destacadoret=$row["destacadoret"];$nombrecortoret=$row["nombrecortoret"];$i_nombrecortoret=$row["i_nombrecortoret"];$icatret=$row["icatret"];$statusret=$row["statusret"];$razonesret=$row["razonesret"];$iusuarioret=$row["iusuarioret"];$fechaaltaret=$row["fechaaltaret"];if($fechaaltaret=="0000-00-00") $fechaaltaret="";$descripcionret=$row["descripcionret"];$i_descripcionret=$row["i_descripcionret"];$condicionesret=$row["condicionesret"];$i_condicionesret=$row["i_condicionesret"];$metaret=$row["metaret"];$minimodonativoret=$row["minimodonativoret"];$maximoganadoresret=$row["maximoganadoresret"];$tganadoresret=$row["tganadoresret"];$importedonativosret=$row["importedonativosret"];$tdonativosret=$row["tdonativosret"];$tgustaret=$row["tgustaret"];$tcomentariosret=$row["tcomentariosret"];$finicioret=$row["finicioret"];if($finicioret=="0000-00-00") $finicioret="";$ffinret=$row["ffinret"];if($ffinret=="0000-00-00") $ffinret="";$imagenret=$row["imagenret"];$videoret=$row["videoret"];$urlret=$row["urlret"];$ipaisret=$row["ipaisret"];$iestadoret=$row["iestadoret"];$domicilio1ret=$row["domicilio1ret"];$domicilio2ret=$row["domicilio2ret"];$idioma=$row["idioma"];$urlamigableret=$row["urlamigableret"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="ret.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <?
include("include/extrasbotones.php");
?><? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('ret.php?sortfield=nombreret&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
	<script language="javascript" src="../include/dynamicpulldown/chainedselects.js"></script><script language="javascript"><?$sel1=$ipaisret;$sel2=$iestadoret; leecamposcascada("pais","id","nombrepais","",""," ","","","",$id,$sel1,2,1,"ret","ipaisret");?></script> 
	
    <input name="idcontrol" type="hidden" value="<?=$idcontrolinterno?>">
	<input name="controlmatch" type="hidden" value="<?=$controlmatch?>">
	<input name="match_posts2" type="hidden" value="<?=$match_posts?>">	
	
	
	
	<tr>
    <td>
      <table class="textogeneraltablaform" width="100%" cellpadding="3" cellspacing="0">
     	
	<? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nombreret" name="t_nombreret">Nombre * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="nombreret" id="nombreret" value="<? echo(htmlspecialchars($nombreret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$nombreret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_nombreret" name="t_i_nombreret">Nombre en inglés </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="i_nombreret" id="i_nombreret" value="<? echo(htmlspecialchars($i_nombreret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$i_nombreret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_destacadoret" name="t_destacadoret">Destacado * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><select name="destacadoret" id="destacadoret" class=textogeneralform><OPTION VALUE="0" <? if($destacadoret=="0") echo("selected");?> >NO</option><OPTION VALUE="1" <? if($destacadoret=="1") echo("selected");?> >SI</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($destacadoret=="0") echo("NO");if($destacadoret=="1") echo("SI"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nombrecortoret" name="t_nombrecortoret">Nombre corto </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><input type="text" name="nombrecortoret" id="nombrecortoret" value="<? echo(htmlspecialchars($nombrecortoret,ENT_COMPAT,'ISO-8859-1')); ?>" size="35" maxlength="30" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$nombrecortoret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_i_nombrecortoret" name="t_i_nombrecortoret">Nombre corto en inglés </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><input type="text" name="i_nombrecortoret" id="i_nombrecortoret" value="<? echo(htmlspecialchars($i_nombrecortoret,ENT_COMPAT,'ISO-8859-1')); ?>" size="35" maxlength="30" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$i_nombrecortoret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_icatret" name="t_icatret">Categoría principal * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="icatret" id="icatret"  class=textogeneralform><option value="0" selected></option><?  leecampos("cat","id","nombrecat","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($icatret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("cat","nombrecat","","",$icatret,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_statusret" name="t_statusret">Status * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="statusret" id="statusret" class=textogeneralform><OPTION VALUE="3" <? if($statusret=="3") echo("selected");?> >No enviado a validación</option><OPTION VALUE="0" <? if($statusret=="0") echo("selected");?> >Pendiente de validación</option><OPTION VALUE="1" <? if($statusret=="1") echo("selected");?> >Validado</option><OPTION VALUE="2" <? if($statusret=="2") echo("selected");?> >Rechazado</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? if($statusret=="3") echo("No enviado a validación");if($statusret=="0") echo("Pendiente de validación");if($statusret=="1") echo("Validado");if($statusret=="2") echo("Rechazado"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_razonesret" name="t_razonesret">Razones de rechazo </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="razonesret" id="razonesret" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($razonesret,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$razonesret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iusuarioret" name="t_iusuarioret">Usuario * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><select name="iusuarioret" id="iusuarioret"  class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuarioret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 ) && $step<>"add") { ?><? $valor_mostrar=lee_registro("usuarios","nombreusuario","","",$iusuarioret,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fechaaltaret" name="t_fechaaltaret">Fecha de alta * <a onMouseOver="myHint.show('fechaaltaret')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="fechaaltaret" id="fechaaltaret" value="<?=$fechaaltaret?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT1 = {	'formname' : 'form1','controlname': 'fechaaltaret','dataformat' : 'Y-m-d','today' : '<?=$fechaaltaret?>','positionname':'fechaaltaret','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT1, CAL_TPL1);</script><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$fechaaltaret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_descripcionret" name="t_descripcionret">Descripción </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="descripcionret" id="descripcionret" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($descripcionret,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$descripcionret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_i_descripcionret" name="t_i_descripcionret">Descripción en inglés </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="i_descripcionret" id="i_descripcionret" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($i_descripcionret,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$i_descripcionret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_condicionesret" name="t_condicionesret">Condiciones </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="condicionesret" id="condicionesret" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($condicionesret,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$condicionesret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_i_condicionesret" name="t_i_condicionesret">Condiciones en inglés </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><textarea name="i_condicionesret" id="i_condicionesret" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($i_condicionesret,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$i_condicionesret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_metaret" name="t_metaret">Meta </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="metaret" id="metaret" value="<? echo(formato_numero($metaret,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('metaret')" onBlur="pone_pesos('metaret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? echo(formato_numero($metaret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_minimodonativoret" name="t_minimodonativoret">Mínimo donativo </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="minimodonativoret" id="minimodonativoret" value="<? echo(formato_numero($minimodonativoret,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('minimodonativoret')" onBlur="pone_pesos('minimodonativoret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? echo(formato_numero($minimodonativoret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_maximoganadoresret" name="t_maximoganadoresret">Máximo ganadores </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="maximoganadoresret" id="maximoganadoresret" value="<? echo(formato_numero($maximoganadoresret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('maximoganadoresret')" onBlur="pone_pesos('maximoganadoresret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? echo(formato_numero($maximoganadoresret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tganadoresret" name="t_tganadoresret">Número de ganadores </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="tganadoresret" id="tganadoresret" value="<? echo(formato_numero($tganadoresret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tganadoresret')" onBlur="pone_pesos('tganadoresret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($tganadoresret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_importedonativosret" name="t_importedonativosret">Importe donativos </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="importedonativosret" id="importedonativosret" value="<? echo(formato_numero($importedonativosret,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('importedonativosret')" onBlur="pone_pesos('importedonativosret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($importedonativosret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tdonativosret" name="t_tdonativosret">Número de donativos </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="tdonativosret" id="tdonativosret" value="<? echo(formato_numero($tdonativosret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tdonativosret')" onBlur="pone_pesos('tdonativosret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($tdonativosret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tgustaret" name="t_tgustaret">Total de gusta </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="tgustaret" id="tgustaret" value="<? echo(formato_numero($tgustaret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tgustaret')" onBlur="pone_pesos('tgustaret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($tgustaret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tcomentariosret" name="t_tcomentariosret">Total de comentarios </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="tcomentariosret" id="tcomentariosret" value="<? echo(formato_numero($tcomentariosret,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tcomentariosret')" onBlur="pone_pesos('tcomentariosret','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($tcomentariosret,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_finicioret" name="t_finicioret">Fecha de inicio * <a onMouseOver="myHint.show('finicioret')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="finicioret" id="finicioret" value="<?=$finicioret?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT2 = {	'formname' : 'form1','controlname': 'finicioret','dataformat' : 'Y-m-d','today' : '<?=$finicioret?>','positionname':'finicioret','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT2, CAL_TPL1);</script><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$finicioret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ffinret" name="t_ffinret">Fecha de fin * <a onMouseOver="myHint.show('ffinret')" onMouseOut="myHint.hide()">(?)</a></td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="ffinret" id="ffinret" value="<?=$ffinret?>" size="12" maxlength="12" class=textogeneralform><script language="JavaScript">var CAL_INIT3 = {	'formname' : 'form1','controlname': 'ffinret','dataformat' : 'Y-m-d','today' : '<?=$ffinret?>','positionname':'ffinret','nocontrols' : {'nohour': true,'nominute' : true,'nosecond' : true,'noampm' : 'true','noothermonthday' : 'true'},'replace' : true,'watch' : true }; new calendar(CAL_INIT3, CAL_TPL1);</script><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$ffinret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_imagenret" name="t_imagenret">Imagen </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="imagenret" id="imagenret" value="<? echo(htmlspecialchars($imagenret,ENT_COMPAT,'ISO-8859-1'));?>" size="60" maxlength="100" readonly class=textogeneralform><a href=javascript:seleccionaimagen('imagenret')><img src=recursos/cambiarimagen.gif border="0" alt=Cambiar></a><a href=javascript:muestraimagen('imagenret')><img src=recursos/verimagen.gif border="0" alt=Ver></a><a href="javascript:limpiarimagen('imagenret')" style="margin-right:20px"><img src=recursos/limpiarimagen.gif border="0" alt=Limpiar></a><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$imagenret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_videoret" name="t_videoret">Video </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="videoret" id="videoret" value="<? echo(htmlspecialchars($videoret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$videoret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_urlret" name="t_urlret">URL </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="urlret" id="urlret" value="<? echo(htmlspecialchars($urlret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$urlret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ipaisret" name="t_ipaisret">País * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="ipaisret" id="ipaisret"  style="width:380px" class=textogeneralform></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("pais","nombrepais","","",$ipaisret,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iestadoret" name="t_iestadoret">Estado </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="iestadoret" id="iestadoret"  style="width:380px" class=textogeneralform></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("estados","nombreestado","","",$iestadoret,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_domicilio1ret" name="t_domicilio1ret">Domicilio 1 </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="domicilio1ret" id="domicilio1ret" value="<? echo(htmlspecialchars($domicilio1ret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$domicilio1ret?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_domicilio2ret" name="t_domicilio2ret">Domicilio 2 </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="domicilio2ret" id="domicilio2ret" value="<? echo(htmlspecialchars($domicilio2ret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$domicilio2ret?><? } ?></td></tr><? } ?>
	
	<? if($nivelusuario<>11 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_urlamigableret" name="t_urlamigableret">URL Amigable. NO CAMBIAR </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0)) { ?><input type="text" name="urlamigableret" id="urlamigableret" value="<? echo(htmlspecialchars($urlamigableret,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$urlamigableret?><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idioma" name="t_idioma">Idioma </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="idioma" id="idioma" class=textogeneralform><OPTION VALUE="0" <? if($idioma=="0") echo("selected");?> >Español</option><OPTION VALUE="1" <? if($idioma=="1") echo("selected");?> >Inglés</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? if($idioma=="0") echo("Español");if($idioma=="1") echo("Inglés"); ?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'nombreret':{'l':'Nombre','r': true,'t':'t_nombreret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'destacadoret':{'l':'Destacado','r': true,'t':'t_destacadoret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'icatret':{'l':'Categoría principal','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_icatret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'statusret':{'l':'Status','r': true,'t':'t_statusret'}";?><? } ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iusuarioret':{'l':'Usuario','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_iusuarioret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'fechaaltaret':{'l':'Fecha de alta','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_fechaaltaret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'metaret':{'l':'Meta','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_metaret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'minimodonativoret':{'l':'Mínimo donativo','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_minimodonativoret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'maximoganadoresret':{'l':'Máximo ganadores','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_maximoganadoresret'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tganadoresret':{'l':'Número de ganadores','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tganadoresret'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'importedonativosret':{'l':'Importe donativos','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_importedonativosret'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tdonativosret':{'l':'Número de donativos','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tdonativosret'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tgustaret':{'l':'Total de gusta','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tgustaret'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tcomentariosret':{'l':'Total de comentarios','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tcomentariosret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'finicioret':{'l':'Fecha de inicio','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_finicioret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ffinret':{'l':'Fecha de fin','r': true,'f':function (n) { if(n!=null) {  var T = n.split('-');  if (!ValidDate(T[0], T[1]-1, T[2])) { return false; }} return true; },'t':'t_ffinret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ipaisret':{'l':'País','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_ipaisret'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iestadoret':{'l':'Estado','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_iestadoret'}";?><? } ?>
	
	<script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }
	var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
	var v = new validator('form1', a_fields, o_config);</script>  
    <? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?>
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
  <? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==10) {?>

<span class=textogeneral><br></span>
<script language="javascript" src="../include/dynamicpulldown/chainedselects.js"></script><script language="javascript"><?$sel1=$ipaisretb2;$sel2=$iestadoretb2; leecamposcascada("pais","id","nombrepais","",""," ","","","",$id,$sel1,2,1,"ret","ipaisret");?></script> 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="ret.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="nombreret" selected>Nombre</option><option value="i_nombreret">Nombre en inglés</option><option value="destacadoret">Destacado</option><option value="nombrecortoret">Nombre corto</option><option value="i_nombrecortoret">Nombre corto en inglés</option><option value="icatret">Categoría principal</option><option value="statusret">Status</option><option value="razonesret">Razones de rechazo</option><option value="iusuarioret">Usuario</option><option value="fechaaltaret">Fecha de alta</option><option value="descripcionret">Descripción</option><option value="i_descripcionret">Descripción en inglés</option><option value="condicionesret">Condiciones</option><option value="i_condicionesret">Condiciones en inglés</option><option value="metaret">Meta</option><option value="minimodonativoret">Mínimo donativo</option><option value="maximoganadoresret">Máximo ganadores</option><option value="tganadoresret">Número de ganadores</option><option value="importedonativosret">Importe donativos</option><option value="tdonativosret">Número de donativos</option><option value="tgustaret">Total de gusta</option><option value="tcomentariosret">Total de comentarios</option><option value="finicioret">Fecha de inicio</option><option value="ffinret">Fecha de fin</option><option value="imagenret">Imagen</option><option value="videoret">Video</option><option value="urlret">URL</option><option value="ipaisret">País</option><option value="iestadoret">Estado</option><option value="domicilio1ret">Domicilio 1</option><option value="domicilio2ret">Domicilio 2</option><option value="idioma">Idioma</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('ret.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="nombreretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="nombreretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nombreretb2" id="nombreret" value="" size="50" onKeyUp="revisainput('nombreretb1','nombreretb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre en inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="i_nombreretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="i_nombreretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_nombreretb2" id="i_nombreret" value="" size="50" onKeyUp="revisainput('i_nombreretb1','i_nombreretb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Destacado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="destacadoretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="destacadoretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="destacadoretb2" onChange="if(destacadoretb1.selectedIndex==0) destacadoretb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($destacadoret=="0") { ?>selected<? } ?> >NO</option><OPTION VALUE="1" <? if($destacadoret=="1") { ?>selected<? } ?> >SI</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre corto</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="nombrecortoretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="nombrecortoretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nombrecortoretb2" value="" size="35" onKeyUp="revisainput('nombrecortoretb1','nombrecortoretb2');" maxlength="30" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre corto en inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="i_nombrecortoretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="i_nombrecortoretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_nombrecortoretb2" value="" size="35" onKeyUp="revisainput('i_nombrecortoretb1','i_nombrecortoretb2');" maxlength="30" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Categoría principal</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="icatretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="icatretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="icatretb2" onChange="if(icatretb1.selectedIndex==0) icatretb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("cat","id","nombrecat","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($icatret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Status</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="statusretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="statusretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="statusretb2" onChange="if(statusretb1.selectedIndex==0) statusretb1.selectedIndex=1" class=textogeneralform><OPTION VALUE="3" <? if($statusret=="3") { ?>selected<? } ?> >No enviado a validación</option><OPTION VALUE="0" <? if($statusret=="0") { ?>selected<? } ?> >Pendiente de validación</option><OPTION VALUE="1" <? if($statusret=="1") { ?>selected<? } ?> >Validado</option><OPTION VALUE="2" <? if($statusret=="2") { ?>selected<? } ?> >Rechazado</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Razones de rechazo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="razonesretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="razonesretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="razonesretb2" value="" size="50" onKeyUp="revisainput('razonesretb1','razonesretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="iusuarioretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==2) { ?><select name="iusuarioretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iusuarioretb2" onChange="if(iusuarioretb1.selectedIndex==0) iusuarioretb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("usuarios","id","nombreusuario","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($iusuarioret==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha de alta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="fechaaltaretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="fechaaltaretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fechaaltaretb2" value="" size="15" onKeyUp="revisainput('fechaaltaretb1','fechaaltaretb2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Descripción</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="descripcionretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="descripcionretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="descripcionretb2" value="" size="50" onKeyUp="revisainput('descripcionretb1','descripcionretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Descripción en inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="i_descripcionretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="i_descripcionretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_descripcionretb2" value="" size="50" onKeyUp="revisainput('i_descripcionretb1','i_descripcionretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Condiciones</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="condicionesretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="condicionesretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="condicionesretb2" value="" size="50" onKeyUp="revisainput('condicionesretb1','condicionesretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Condiciones en inglés</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="i_condicionesretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="i_condicionesretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_condicionesretb2" value="" size="50" onKeyUp="revisainput('i_condicionesretb1','i_condicionesretb2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Meta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="metaretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="metaretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="metaretb2" value="" size="15" onKeyUp="revisainput('metaretb1','metaretb2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Mínimo donativo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="minimodonativoretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="minimodonativoretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="minimodonativoretb2" value="" size="15" onKeyUp="revisainput('minimodonativoretb1','minimodonativoretb2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Máximo ganadores</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="maximoganadoresretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="maximoganadoresretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="maximoganadoresretb2" value="" size="10" onKeyUp="revisainput('maximoganadoresretb1','maximoganadoresretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Número de ganadores</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="tganadoresretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="tganadoresretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tganadoresretb2" value="" size="10" onKeyUp="revisainput('tganadoresretb1','tganadoresretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Importe donativos</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="importedonativosretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="importedonativosretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="importedonativosretb2" value="" size="15" onKeyUp="revisainput('importedonativosretb1','importedonativosretb2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Número de donativos</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="tdonativosretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="tdonativosretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tdonativosretb2" value="" size="10" onKeyUp="revisainput('tdonativosretb1','tdonativosretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Total de gusta</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="tgustaretl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="tgustaretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tgustaretb2" value="" size="10" onKeyUp="revisainput('tgustaretb1','tgustaretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Total de comentarios</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="tcomentariosretl1" checked><? } ?><? if($nivelusuario==10) { ?><select name="tcomentariosretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tcomentariosretb2" value="" size="10" onKeyUp="revisainput('tcomentariosretb1','tcomentariosretb2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha de inicio</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="finicioretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="finicioretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="finicioretb2" value="" size="15" onKeyUp="revisainput('finicioretb1','finicioretb2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Fecha de fin</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ffinretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ffinretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ffinretb2" value="" size="15" onKeyUp="revisainput('ffinretb1','ffinretb2');" maxlength="10" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Imagen</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="imagenretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="imagenretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="imagenretb2" value="" size="105" onKeyUp="revisainput('imagenretb1','imagenretb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Video</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="videoretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="videoretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="videoretb2" id="videoret" value="" size="50" onKeyUp="revisainput('videoretb1','videoretb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="urlretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="urlretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="urlretb2" id="urlret" value="" size="50" onKeyUp="revisainput('urlretb1','urlretb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">País</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ipaisretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ipaisretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="ipaisretb2" onChange="if(ipaisretb1.selectedIndex==0) ipaisretb1.selectedIndex=1" style="width:380px" class=textogeneralform></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Estado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="iestadoretl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="iestadoretb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iestadoretb2" onChange="if(iestadoretb1.selectedIndex==0) iestadoretb1.selectedIndex=1" style="width:380px" class=textogeneralform></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Domicilio 1</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="domicilio1retl1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="domicilio1retb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="domicilio1retb2" id="domicilio1ret" value="" size="50" onKeyUp="revisainput('domicilio1retb1','domicilio1retb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Domicilio 2</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="domicilio2retl1"><? } ?><? if($nivelusuario==10) { ?><select name="domicilio2retb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="domicilio2retb2" id="domicilio2ret" value="" size="50" onKeyUp="revisainput('domicilio2retb1','domicilio2retb2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Idioma</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="idiomal1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="idiomab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="idiomab2" onChange="if(idiomab1.selectedIndex==0) idiomab1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($idioma=="0") { ?>selected<? } ?> >Español</option><OPTION VALUE="1" <? if($idioma=="1") { ?>selected<? } ?> >Inglés</option></select> <? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('ret.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelret.php?step=busqueda2<?=$url_extra?>');">
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

