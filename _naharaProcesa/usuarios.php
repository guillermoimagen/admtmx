<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

// IMAGENIO MR. IMAGEN CENTRAL MF SA DE CV. www.imagencentral .com 
$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_usuarios"]=1;
	$_SESSION["esframe_usuarios_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_usuarios_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&idioma=".$_GET["idioma"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_usuarios"]=0;
	$_SESSION["esframe_usuarios_id"]=0;
	$_SESSION["esframe_usuarios_archivo"]="";
}

$titulo_pagina="Usuarios";
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

$numerodetabla=1;
include("recursos/funciones_tabla.php"); 
$archivoactual="usuarios.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_usuarios"]=$id;
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
<?if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }if($step=="busqueda2" || $step=="busqueda3") {   if($nivelusuario==0)   {     if($destacadousuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on" || $fbusuariol1=="on" || $tokenfbusuariol1=="on" || $codigousuariol1=="on") $error=9;     if(isset($destacadousuariob2) || isset($videousuariob2) || isset($imagenfondousuariob2) || isset($descripcionusuariob2) || isset($i_descripcionusuariob2) || isset($urlusuariob2) || isset($enviarnotificacionesusuariob2) || isset($tgustausuariob2) || isset($tcomentariosusuariob2) || isset($fbusuariob2) || isset($tokenfbusuariob2) || isset($codigousuariob2)) $error=9;   }  if($nivelusuario==1)   {     if($destacadousuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on" || $fbusuariol1=="on" || $tokenfbusuariol1=="on" || $codigousuariol1=="on") $error=9;     if(isset($destacadousuariob2) || isset($videousuariob2) || isset($imagenfondousuariob2) || isset($descripcionusuariob2) || isset($i_descripcionusuariob2) || isset($urlusuariob2) || isset($enviarnotificacionesusuariob2) || isset($tgustausuariob2) || isset($tcomentariosusuariob2) || isset($fbusuariob2) || isset($tokenfbusuariob2) || isset($codigousuariob2)) $error=9;   }  if($nivelusuario==2)   {     if($destacadousuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on" || $fbusuariol1=="on" || $tokenfbusuariol1=="on" || $codigousuariol1=="on") $error=9;     if(isset($destacadousuariob2) || isset($videousuariob2) || isset($imagenfondousuariob2) || isset($descripcionusuariob2) || isset($i_descripcionusuariob2) || isset($urlusuariob2) || isset($enviarnotificacionesusuariob2) || isset($tgustausuariob2) || isset($tcomentariosusuariob2) || isset($fbusuariob2) || isset($tokenfbusuariob2) || isset($codigousuariob2)) $error=9;   }  if($nivelusuario==3)   {     if($itusuusuariol1=="on" || $destacadousuariol1=="on" || $emailusuariol1=="on" || $contrasenausuariol1=="on" || $nickusuariol1=="on" || $nombreusuariol1=="on" || $imagenusuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $validadousuariol1=="on" || $cmsusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $ipaisusuariol1=="on" || $iestadousuariol1=="on" || $tel1usuariol1=="on" || $tel2usuariol1=="on" || $ttusuariol1=="on" || $familiarteletonusuariol1=="on" || $icritusuariol1=="on" || $ientusuariol1=="on" || $ipor1usuariol1=="on" || $ipor2usuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on" || $ndonusuariol1=="on" || $idonusuariol1=="on" || $nrdonusuariol1=="on" || $irdonusuariol1=="on" || $fbusuariol1=="on" || $tokenfbusuariol1=="on" || $codigousuariol1=="on") $error=9;     if(isset($itusuusuariob2) || isset($destacadousuariob2) || isset($emailusuariob2) || isset($contrasenausuariob2) || isset($nickusuariob2) || isset($nombreusuariob2) || isset($imagenusuariob2) || isset($videousuariob2) || isset($imagenfondousuariob2) || isset($descripcionusuariob2) || isset($i_descripcionusuariob2) || isset($urlusuariob2) || isset($validadousuariob2) || isset($cmsusuariob2) || isset($enviarnotificacionesusuariob2) || isset($ipaisusuariob2) || isset($iestadousuariob2) || isset($tel1usuariob2) || isset($tel2usuariob2) || isset($ttusuariob2) || isset($familiarteletonusuariob2) || isset($icritusuariob2) || isset($ientusuariob2) || isset($ipor1usuariob2) || isset($ipor2usuariob2) || isset($tgustausuariob2) || isset($tcomentariosusuariob2) || isset($ndonusuariob2) || isset($idonusuariob2) || isset($nrdonusuariob2) || isset($irdonusuariob2) || isset($fbusuariob2) || isset($tokenfbusuariob2) || isset($codigousuariob2)) $error=9;   }  if($nivelusuario==4)   {     if($itusuusuariol1=="on" || $destacadousuariol1=="on" || $emailusuariol1=="on" || $contrasenausuariol1=="on" || $nickusuariol1=="on" || $nombreusuariol1=="on" || $imagenusuariol1=="on" || $videousuariol1=="on" || $imagenfondousuariol1=="on" || $descripcionusuariol1=="on" || $i_descripcionusuariol1=="on" || $urlusuariol1=="on" || $validadousuariol1=="on" || $cmsusuariol1=="on" || $enviarnotificacionesusuariol1=="on" || $ipaisusuariol1=="on" || $iestadousuariol1=="on" || $tel1usuariol1=="on" || $tel2usuariol1=="on" || $ttusuariol1=="on" || $familiarteletonusuariol1=="on" || $icritusuariol1=="on" || $ientusuariol1=="on" || $ipor1usuariol1=="on" || $ipor2usuariol1=="on" || $tgustausuariol1=="on" || $tcomentariosusuariol1=="on" || $ndonusuariol1=="on" || $idonusuariol1=="on" || $nrdonusuariol1=="on" || $irdonusuariol1=="on" || $fbusuariol1=="on" || $tokenfbusuariol1=="on" || $codigousuariol1=="on") $error=9;     if(isset($itusuusuariob2) || isset($destacadousuariob2) || isset($emailusuariob2) || isset($contrasenausuariob2) || isset($nickusuariob2) || isset($nombreusuariob2) || isset($imagenusuariob2) || isset($videousuariob2) || isset($imagenfondousuariob2) || isset($descripcionusuariob2) || isset($i_descripcionusuariob2) || isset($urlusuariob2) || isset($validadousuariob2) || isset($cmsusuariob2) || isset($enviarnotificacionesusuariob2) || isset($ipaisusuariob2) || isset($iestadousuariob2) || isset($tel1usuariob2) || isset($tel2usuariob2) || isset($ttusuariob2) || isset($familiarteletonusuariob2) || isset($icritusuariob2) || isset($ientusuariob2) || isset($ipor1usuariob2) || isset($ipor2usuariob2) || isset($tgustausuariob2) || isset($tcomentariosusuariob2) || isset($ndonusuariob2) || isset($idonusuariob2) || isset($nrdonusuariob2) || isset($irdonusuariob2) || isset($fbusuariob2) || isset($tokenfbusuariob2) || isset($codigousuariob2)) $error=9;   }}if($operacion=="modify") {   if($nivelusuario==0) if(isset($_POST["destacadousuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=8;   if($nivelusuario==1) if(isset($_POST["destacadousuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=8;   if($nivelusuario==2) if(isset($_POST["itusuusuario"]) || isset($_POST["destacadousuario"]) || isset($_POST["emailusuario"]) || isset($_POST["contrasenausuario"]) || isset($_POST["nickusuario"]) || isset($_POST["nombreusuario"]) || isset($_POST["imagenusuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["validadousuario"]) || isset($_POST["cmsusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["ipaisusuario"]) || isset($_POST["iestadousuario"]) || isset($_POST["tel1usuario"]) || isset($_POST["tel2usuario"]) || isset($_POST["ttusuario"]) || isset($_POST["familiarteletonusuario"]) || isset($_POST["icritusuario"]) || isset($_POST["ientusuario"]) || isset($_POST["ipor1usuario"]) || isset($_POST["ipor2usuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=8;   if($nivelusuario==3) if(isset($_POST["itusuusuario"]) || isset($_POST["destacadousuario"]) || isset($_POST["emailusuario"]) || isset($_POST["contrasenausuario"]) || isset($_POST["nickusuario"]) || isset($_POST["nombreusuario"]) || isset($_POST["imagenusuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["validadousuario"]) || isset($_POST["cmsusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["ipaisusuario"]) || isset($_POST["iestadousuario"]) || isset($_POST["tel1usuario"]) || isset($_POST["tel2usuario"]) || isset($_POST["ttusuario"]) || isset($_POST["familiarteletonusuario"]) || isset($_POST["icritusuario"]) || isset($_POST["ientusuario"]) || isset($_POST["ipor1usuario"]) || isset($_POST["ipor2usuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=8;   if($nivelusuario==4) if(isset($_POST["itusuusuario"]) || isset($_POST["destacadousuario"]) || isset($_POST["emailusuario"]) || isset($_POST["contrasenausuario"]) || isset($_POST["nickusuario"]) || isset($_POST["nombreusuario"]) || isset($_POST["imagenusuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) ||  isset($_POST["validadousuario"]) || isset($_POST["cmsusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["ipaisusuario"]) || isset($_POST["iestadousuario"]) || isset($_POST["tel1usuario"]) || isset($_POST["tel2usuario"]) || isset($_POST["ttusuario"]) || isset($_POST["familiarteletonusuario"]) || isset($_POST["icritusuario"]) || isset($_POST["ientusuario"]) || isset($_POST["ipor1usuario"]) || isset($_POST["ipor2usuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=8; }if($operacion=="add") {   if($nivelusuario==0) if(isset($_POST["destacadousuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) ||isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=7;   if($nivelusuario==1) if(isset($_POST["destacadousuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=7;   if($nivelusuario==2) if(isset($_POST["itusuusuario"]) || isset($_POST["destacadousuario"]) || isset($_POST["emailusuario"]) || isset($_POST["contrasenausuario"]) || isset($_POST["nickusuario"]) || isset($_POST["nombreusuario"]) || isset($_POST["imagenusuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["validadousuario"]) || isset($_POST["cmsusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["ipaisusuario"]) || isset($_POST["iestadousuario"]) || isset($_POST["tel1usuario"]) || isset($_POST["tel2usuario"]) || isset($_POST["ttusuario"]) || isset($_POST["familiarteletonusuario"]) || isset($_POST["icritusuario"]) || isset($_POST["ientusuario"]) || isset($_POST["ipor1usuario"]) || isset($_POST["ipor2usuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=7;   if($nivelusuario==3) if(isset($_POST["itusuusuario"]) || isset($_POST["destacadousuario"]) || isset($_POST["emailusuario"]) || isset($_POST["contrasenausuario"]) || isset($_POST["nickusuario"]) || isset($_POST["nombreusuario"]) || isset($_POST["imagenusuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["validadousuario"]) || isset($_POST["cmsusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["ipaisusuario"]) || isset($_POST["iestadousuario"]) || isset($_POST["tel1usuario"]) || isset($_POST["tel2usuario"]) || isset($_POST["ttusuario"]) || isset($_POST["familiarteletonusuario"]) || isset($_POST["icritusuario"]) || isset($_POST["ientusuario"]) || isset($_POST["ipor1usuario"]) || isset($_POST["ipor2usuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=7;   if($nivelusuario==4) if(isset($_POST["itusuusuario"]) || isset($_POST["destacadousuario"]) || isset($_POST["emailusuario"]) || isset($_POST["contrasenausuario"]) || isset($_POST["nickusuario"]) || isset($_POST["nombreusuario"]) || isset($_POST["imagenusuario"]) || isset($_POST["videousuario"]) || isset($_POST["imagenfondousuario"]) || isset($_POST["descripcionusuario"]) || isset($_POST["i_descripcionusuario"]) || isset($_POST["validadousuario"]) || isset($_POST["cmsusuario"]) || isset($_POST["enviarnotificacionesusuario"]) || isset($_POST["ipaisusuario"]) || isset($_POST["iestadousuario"]) || isset($_POST["tel1usuario"]) || isset($_POST["tel2usuario"]) || isset($_POST["ttusuario"]) || isset($_POST["familiarteletonusuario"]) || isset($_POST["icritusuario"]) || isset($_POST["ientusuario"]) || isset($_POST["ipor1usuario"]) || isset($_POST["ipor2usuario"]) || isset($_POST["tgustausuario"]) || isset($_POST["tcomentariosusuario"]) || isset($_POST["ndonusuario"]) || isset($_POST["idonusuario"]) || isset($_POST["nrdonusuario"]) || isset($_POST["irdonusuario"]) || isset($_POST["fbusuario"]) || isset($_POST["tokenfbusuario"]) || isset($_POST["codigousuario"])) $error=7; }if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } ?>
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





<head>

<title><? echo("Usuarios"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>


<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<script>
function funcionload()
{
<? if($step=="busqueda") { ?> initListGroup('arbol1', document.forms['form2'].ipaisusuariob2, document.forms['form2'].iestadousuariob2);<? } else if($step=="modify" || $step=="add") { ?> initListGroup('arbol1', document.forms['form1'].ipaisusuario, document.forms['form1'].iestadousuario);<? } ?> 
}
</script>
<? include("recursos/funcionesjs.php"); ?>
<script language="JavaScript" src="include/imenu_peque.js"></script>

<script language="javascript" type="text/javascript" src="include/autocompleta/ajax.js"></script><script language="javascript" type="text/javascript" src="include/autocompleta/ajax-dynamic-list.js"></script><link href="include/autocompleta/estilos.css" rel="stylesheet" type="text/css"/>
</head>
<BODY style="margin-right:0px;" onLoad="funcionload();">

<?
  if($ocultabotones<>1) {   
    if($_SESSION["esframe_usuarios"]<>1)
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
  if(isset($_POST["tgustausuario"])) $_POST["tgustausuario"]=limpia_numero($_POST["tgustausuario"]);if(isset($_POST["tcomentariosusuario"])) $_POST["tcomentariosusuario"]=limpia_numero($_POST["tcomentariosusuario"]);if(isset($_POST["ndonusuario"])) $_POST["ndonusuario"]=limpia_numero($_POST["ndonusuario"]);if(isset($_POST["idonusuario"])) $_POST["idonusuario"]=limpia_numero($_POST["idonusuario"]);if(isset($_POST["nrdonusuario"])) $_POST["nrdonusuario"]=limpia_numero($_POST["nrdonusuario"]);if(isset($_POST["irdonusuario"])) $_POST["irdonusuario"]=limpia_numero($_POST["irdonusuario"]);
  
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
	                 $resulth = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM usuarios where id=". $id);               $rowh = mysqli_fetch_array($resulth); 
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
      $sqltemporal.=construyesqltemporal("itusuusuario","",0);$sqltemporal.=construyesqltemporal("destacadousuario","'",0);$sqltemporal.=construyesqltemporal("emailusuario","'",0);if($_POST["contrasenausuario"]<>"") { $_POST["contrasenausuario"]=md5($_POST["contrasenausuario"]); $sqltemporal.=construyesqltemporal("contrasenausuario","'",0); } $sqltemporal.=construyesqltemporal("nickusuario","'",0);$sqltemporal.=construyesqltemporal("nombreusuario","'",0);$sqltemporal.=construyesqltemporal("imagenusuario","'",0);$sqltemporal.=construyesqltemporal("videousuario","'",0);$sqltemporal.=construyesqltemporal("imagenfondousuario","'",0);$sqltemporal.=construyesqltemporal("descripcionusuario","'",0);$sqltemporal.=construyesqltemporal("i_descripcionusuario","'",0);$sqltemporal.=construyesqltemporal("urlusuario","'",0);$sqltemporal.=construyesqltemporal("validadousuario","'",0);$sqltemporal.=construyesqltemporal("cmsusuario","'",0);$sqltemporal.=construyesqltemporal("enviarnotificacionesusuario","'",0);$sqltemporal.=construyesqltemporal("ipaisusuario","",0);$sqltemporal.=construyesqltemporal("iestadousuario","",0);$sqltemporal.=construyesqltemporal("tel1usuario","'",0);$sqltemporal.=construyesqltemporal("tel2usuario","'",0);$sqltemporal.=construyesqltemporal("ttusuario","'",0);$sqltemporal.=construyesqltemporal("familiarteletonusuario","'",0);$sqltemporal.=construyesqltemporal("icritusuario","",0);$sqltemporal.=construyesqltemporal("ientusuario","",0);$sqltemporal.=construyesqltemporal("ipor1usuario","",0);$sqltemporal.=construyesqltemporal("ipor2usuario","",0);$sqltemporal.=construyesqltemporal("tgustausuario","",2);$sqltemporal.=construyesqltemporal("tcomentariosusuario","",2);$sqltemporal.=construyesqltemporal("ndonusuario","",2);$sqltemporal.=construyesqltemporal("idonusuario","",2);$sqltemporal.=construyesqltemporal("nrdonusuario","",2);$sqltemporal.=construyesqltemporal("irdonusuario","",2);$sqltemporal.=construyesqltemporal("fbusuario","'",0);$sqltemporal.=construyesqltemporal("tokenfbusuario","'",0);$sqltemporal.=construyesqltemporal("codigousuario","'",0);$sqltemporal.=construyesqltemporal("activo","",0);    
      
      
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
      	
		  $sql = "INSERT INTO usuarios SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.=$ib_add_modify;
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=1,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_usuarios"]=$id;
            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_usuarios"]="OK";
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
		  $sql = "UPDATE usuarios SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.=$ib_add_modify;
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=1,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			                 $resultn = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM usuarios where id=". $id);               $rown = mysqli_fetch_array($resultn);               $cadena_historico="";               if($rowh["itusuusuario"]<>$rown["itusuusuario"]) $cadena_historico.="Tipo:\r\n O:".$rowh["itusuusuario"]."\r\nN: ".$rown["itusuusuario"]."\r\n\r\n";               if($rowh["destacadousuario"]<>$rown["destacadousuario"]) $cadena_historico.="Destacado:\r\n O:".$rowh["destacadousuario"]."\r\nN: ".$rown["destacadousuario"]."\r\n\r\n";               if($rowh["emailusuario"]<>$rown["emailusuario"]) $cadena_historico.="Email:\r\n O:".$rowh["emailusuario"]."\r\nN: ".$rown["emailusuario"]."\r\n\r\n";               if($rowh["contrasenausuario"]<>$rown["contrasenausuario"]) $cadena_historico.="Contraseña:\r\n O:".$rowh["contrasenausuario"]."\r\nN: ".$rown["contrasenausuario"]."\r\n\r\n";               if($rowh["nombreusuario"]<>$rown["nombreusuario"]) $cadena_historico.="Nombre:\r\n O:".$rowh["nombreusuario"]."\r\nN: ".$rown["nombreusuario"]."\r\n\r\n";               if($rowh["imagenusuario"]<>$rown["imagenusuario"]) $cadena_historico.="Imagen:\r\n O:".$rowh["imagenusuario"]."\r\nN: ".$rown["imagenusuario"]."\r\n\r\n";               if($rowh["videousuario"]<>$rown["videousuario"]) $cadena_historico.="URL youtube:\r\n O:".$rowh["videousuario"]."\r\nN: ".$rown["videousuario"]."\r\n\r\n";               if($rowh["validadousuario"]<>$rown["validadousuario"]) $cadena_historico.="Validado:\r\n O:".$rowh["validadousuario"]."\r\nN: ".$rown["validadousuario"]."\r\n\r\n";               if($rowh["cmsusuario"]<>$rown["cmsusuario"]) $cadena_historico.="Es administrador:\r\n O:".$rowh["cmsusuario"]."\r\nN: ".$rown["cmsusuario"]."\r\n\r\n";               if($rowh["enviarnotificacionesusuario"]<>$rown["enviarnotificacionesusuario"]) $cadena_historico.="Enviar notificaciones:\r\n O:".$rowh["enviarnotificacionesusuario"]."\r\nN: ".$rown["enviarnotificacionesusuario"]."\r\n\r\n";               if($rowh["ipaisusuario"]<>$rown["ipaisusuario"]) $cadena_historico.="País:\r\n O:".$rowh["ipaisusuario"]."\r\nN: ".$rown["ipaisusuario"]."\r\n\r\n";               if($rowh["iestadousuario"]<>$rown["iestadousuario"]) $cadena_historico.="Estado:\r\n O:".$rowh["iestadousuario"]."\r\nN: ".$rown["iestadousuario"]."\r\n\r\n";               if($rowh["tel1usuario"]<>$rown["tel1usuario"]) $cadena_historico.="Teléfono 1:\r\n O:".$rowh["tel1usuario"]."\r\nN: ".$rown["tel1usuario"]."\r\n\r\n";               if($rowh["tel2usuario"]<>$rown["tel2usuario"]) $cadena_historico.="Teléfono 2:\r\n O:".$rowh["tel2usuario"]."\r\nN: ".$rown["tel2usuario"]."\r\n\r\n";               if($rowh["ttusuario"]<>$rown["ttusuario"]) $cadena_historico.="Twitter:\r\n O:".$rowh["ttusuario"]."\r\nN: ".$rown["ttusuario"]."\r\n\r\n";               if($rowh["familiarteletonusuario"]<>$rown["familiarteletonusuario"]) $cadena_historico.="¿Algún familiar es o fue paciente de un Centro Teletón?:\r\n O:".$rowh["familiarteletonusuario"]."\r\nN: ".$rown["familiarteletonusuario"]."\r\n\r\n";               if($rowh["icritusuario"]<>$rown["icritusuario"]) $cadena_historico.="¿Cuál?:\r\n O:".$rowh["icritusuario"]."\r\nN: ".$rown["icritusuario"]."\r\n\r\n";               if($rowh["ientusuario"]<>$rown["ientusuario"]) $cadena_historico.="¿Cómo se enteró?:\r\n O:".$rowh["ientusuario"]."\r\nN: ".$rown["ientusuario"]."\r\n\r\n";               if($rowh["ipor1usuario"]<>$rown["ipor1usuario"]) $cadena_historico.="¿Porqué nos apoya? (1):\r\n O:".$rowh["ipor1usuario"]."\r\nN: ".$rown["ipor1usuario"]."\r\n\r\n";               if($rowh["ipor2usuario"]<>$rown["ipor2usuario"]) $cadena_historico.="¿Porqué nos apoya? (2):\r\n O:".$rowh["ipor2usuario"]."\r\nN: ".$rown["ipor2usuario"]."\r\n\r\n";               if($rowh["tgustausuario"]<>$rown["tgustausuario"]) $cadena_historico.="Total de gusta:\r\n O:".$rowh["tgustausuario"]."\r\nN: ".$rown["tgustausuario"]."\r\n\r\n";               if($rowh["tcomentariosusuario"]<>$rown["tcomentariosusuario"]) $cadena_historico.="Total de comentarios:\r\n O:".$rowh["tcomentariosusuario"]."\r\nN: ".$rown["tcomentariosusuario"]."\r\n\r\n";               if($rowh["ndonusuario"]<>$rown["ndonusuario"]) $cadena_historico.="Número de donaciones realizadas:\r\n O:".$rowh["ndonusuario"]."\r\nN: ".$rown["ndonusuario"]."\r\n\r\n";               if($rowh["idonusuario"]<>$rown["idonusuario"]) $cadena_historico.="Importe de donaciones realizadas:\r\n O:".$rowh["idonusuario"]."\r\nN: ".$rown["idonusuario"]."\r\n\r\n";               if($rowh["nrdonusuario"]<>$rown["nrdonusuario"]) $cadena_historico.="Número de donaciones recibidas:\r\n O:".$rowh["nrdonusuario"]."\r\nN: ".$rown["nrdonusuario"]."\r\n\r\n";               if($rowh["irdonusuario"]<>$rown["irdonusuario"]) $cadena_historico.="Impórte de donaciones recibidas:\r\n O:".$rowh["irdonusuario"]."\r\nN: ".$rown["irdonusuario"]."\r\n\r\n";               if($rowh["fbusuario"]<>$rown["fbusuario"]) $cadena_historico.="FB:\r\n O:".$rowh["fbusuario"]."\r\nN: ".$rown["fbusuario"]."\r\n\r\n";               if($rowh["tokenfbusuario"]<>$rown["tokenfbusuario"]) $cadena_historico.="Token FB:\r\n O:".$rowh["tokenfbusuario"]."\r\nN: ".$rown["tokenfbusuario"]."\r\n\r\n";               if($rowh["codigousuario"]<>$rown["codigousuario"]) $cadena_historico.="Código:\r\n O:".$rowh["codigousuario"]."\r\nN: ".$rown["codigousuario"]."\r\n\r\n";               if($cadena_historico<>"")                 @mysqli_query($GLOBALS["enlaceDB"] ,"insert into cahistorico set iusuariohistorico=".$sesionid.",iaccesohistorico=".$sesionidregistro.",ioperacionhistorico=".mysqli_insert_id($GLOBALS["enlaceDB"] ).",cambiohistorico='$cadena_historico'");if($_POST["activo"]==0)
{
  @mysqli_query($GLOBALS["enlaceDB"] ,"delete from sauth_tokens where iusuario=".$id);
}
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_usuarios"]="OK";
			}
			else
			{
			  $mensaje.=$ib_modify_nada;
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_usuarios"]="NADA";
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
	$res=@mysqli_query($GLOBALS["enlaceDB"],"select nickusuario,urlusuario from usuarios where id=".$id);
	while($row=mysqli_fetch_object($res))
		if($row->urlusuario=="")
			@mysqli_query($GLOBALS["enlaceDB"],"update usuarios set urlusuario='".convierte_url_APIAdmin($row->nickusuario)."' where id=".$id);	
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
		$sql = "DELETE FROM usuarios WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.=$ib_delete_bien." <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">".$ib_regresar."</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=1,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_usuarios"]="BORRADO";
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
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";$idx3=0;$idx2=0;$idx1 =0;$idx=0;if($step=="modify"){$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,itusuusuario FROM usuarios where id=". $id);$rowx = mysqli_fetch_array($resultx);$linkx=" >> ".$rowx["itusuusuario"]." ".$rowx[""];$idx=$rowx[""];}echo("<a href=usuarios.php?step=1".$url_extra."><span class=titulo>Usuarios</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" ><? if($ocultabotones<>1) { ?><? $botones=""; if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) $botones.="<td><a href=usuarios.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Usuarios\"></a></td>";if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) $botones.="<td><a href=usuarios.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Usuarios\"></a></td>";if(($nivelusuario==0 || $nivelusuario==1)) $botones.="<td><a href=\"usuarios.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Usuarios\"></a></td>"; if($_GET["edicioninterior"]<>1) echo("<table class=\"textogeneral\"><tr><td class=\"textogeneral\" align=\"right\">".$botones);echo("</tr></table>"); ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_usuarios"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_usuarios"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_usuarios"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_usuarios"]="";


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
       if($step=="busqueda3" || $moditobusqueda=="especial") { $activol1="on";  $comparadorsearch="AND"; $sortfield="usuarios.activo DESC,itusuusuario ASC"; $ordenamiento="";$activob1="="; $activob2="1";$itusuusuariol1="on"; $destacadousuariol1="on"; $emailusuariol1="on"; $nombreusuariol1="on"; $validadousuariol1="on"; $cmsusuariol1="on"; $tgustausuariol1="on"; $tcomentariosusuariol1="on"; $ndonusuariol1="on"; $idonusuariol1="on"; $nrdonusuariol1="on"; $irdonusuariol1="on"; $codigousuariol1="on"; } $camposbuscadoslistadosearch="usuarios.id";cbusqueda1($activol1,"usuarios","activo");cbusqueda1($itusuusuariol1,"tusu","tipotusu","0","","");cbusqueda1($destacadousuariol1,"usuarios","destacadousuario");cbusqueda1($emailusuariol1,"usuarios","emailusuario");cbusqueda1($contrasenausuariol1,"usuarios","contrasenausuario");cbusqueda1($nickusuariol1,"usuarios","nickusuario");cbusqueda1($nombreusuariol1,"usuarios","nombreusuario");cbusqueda1($imagenusuariol1,"usuarios","imagenusuario");cbusqueda1($videousuariol1,"usuarios","videousuario");cbusqueda1($imagenfondousuariol1,"usuarios","imagenfondousuario");cbusqueda1($descripcionusuariol1,"usuarios","descripcionusuario");cbusqueda1($i_descripcionusuariol1,"usuarios","i_descripcionusuario");cbusqueda1($urlusuariol1,"usuarios","urlusuario");cbusqueda1($validadousuariol1,"usuarios","validadousuario");cbusqueda1($cmsusuariol1,"usuarios","cmsusuario");cbusqueda1($enviarnotificacionesusuariol1,"usuarios","enviarnotificacionesusuario");cbusqueda1($ipaisusuariol1,"pais","nombrepais","0","","");cbusqueda1($iestadousuariol1,"estados","nombreestado","0","","");cbusqueda1($tel1usuariol1,"usuarios","tel1usuario");cbusqueda1($tel2usuariol1,"usuarios","tel2usuario");cbusqueda1($ttusuariol1,"usuarios","ttusuario");cbusqueda1($familiarteletonusuariol1,"usuarios","familiarteletonusuario");cbusqueda1($icritusuariol1,"crits","nombrecrit","0","","");cbusqueda1($ientusuariol1,"ent","comoent","0","","");cbusqueda1($ipor1usuariol1,"por","porquepor","0","","");cbusqueda1($ipor2usuariol1,"por","porquepor","0","","");cbusqueda1($tgustausuariol1,"usuarios","tgustausuario");cbusqueda1($tcomentariosusuariol1,"usuarios","tcomentariosusuario");cbusqueda1($ndonusuariol1,"usuarios","ndonusuario");cbusqueda1($idonusuariol1,"usuarios","idonusuario");cbusqueda1($nrdonusuariol1,"usuarios","nrdonusuario");cbusqueda1($irdonusuariol1,"usuarios","irdonusuario");cbusqueda1($fbusuariol1,"usuarios","fbusuario");cbusqueda1($tokenfbusuariol1,"usuarios","tokenfbusuario");cbusqueda1($codigousuariol1,"usuarios","codigousuario");cbusqueda2($itusuusuariol1,"tusu","usuarios","itusuusuario","",0,"id");cbusqueda2($ipaisusuariol1,"pais","usuarios","ipaisusuario","",0,"id");cbusqueda2($iestadousuariol1,"estados","usuarios","iestadousuario","",0,"id");cbusqueda2($icritusuariol1,"crits","usuarios","icritusuario","",0,"id");cbusqueda2($ientusuariol1,"ent","usuarios","ientusuario","",0,"id");cbusqueda2($ipor1usuariol1,"por","usuarios","ipor1usuario","",0,"id");cbusqueda2($ipor2usuariol1,"por","usuarios","ipor2usuario","",0,"id");cbusqueda3($itusuusuariob1,$itusuusuariob2,"usuarios","itusuusuario","","0","","");cbusqueda3($destacadousuariob1,$destacadousuariob2,"usuarios","destacadousuario","'","0","","");cbusqueda3($emailusuariob1,$emailusuariob2,"usuarios","emailusuario","'","0","","");cbusqueda3($contrasenausuariob1,$contrasenausuariob2,"usuarios","contrasenausuario","'","0","","");cbusqueda3($nickusuariob1,$nickusuariob2,"usuarios","nickusuario","'","0","","");cbusqueda3($nombreusuariob1,$nombreusuariob2,"usuarios","nombreusuario","'","0","","");cbusqueda3($imagenusuariob1,$imagenusuariob2,"usuarios","imagenusuario","'","0","","");cbusqueda3($videousuariob1,$videousuariob2,"usuarios","videousuario","'","0","","");cbusqueda3($imagenfondousuariob1,$imagenfondousuariob2,"usuarios","imagenfondousuario","'","0","","");cbusqueda3($descripcionusuariob1,$descripcionusuariob2,"usuarios","descripcionusuario","'","0","","");cbusqueda3($i_descripcionusuariob1,$i_descripcionusuariob2,"usuarios","i_descripcionusuario","'","0","","");cbusqueda3($urlusuariob1,$urlusuariob2,"usuarios","urlusuario","'","0","","");cbusqueda3($validadousuariob1,$validadousuariob2,"usuarios","validadousuario","'","0","","");cbusqueda3($cmsusuariob1,$cmsusuariob2,"usuarios","cmsusuario","'","0","","");cbusqueda3($enviarnotificacionesusuariob1,$enviarnotificacionesusuariob2,"usuarios","enviarnotificacionesusuario","'","0","","");cbusqueda3($ipaisusuariob1,$ipaisusuariob2,"usuarios","ipaisusuario","","0","","");cbusqueda3($iestadousuariob1,$iestadousuariob2,"usuarios","iestadousuario","","0","","");cbusqueda3($tel1usuariob1,$tel1usuariob2,"usuarios","tel1usuario","'","0","","");cbusqueda3($tel2usuariob1,$tel2usuariob2,"usuarios","tel2usuario","'","0","","");cbusqueda3($ttusuariob1,$ttusuariob2,"usuarios","ttusuario","'","0","","");cbusqueda3($familiarteletonusuariob1,$familiarteletonusuariob2,"usuarios","familiarteletonusuario","'","0","","");cbusqueda3($icritusuariob1,$icritusuariob2,"usuarios","icritusuario","","0","","");cbusqueda3($ientusuariob1,$ientusuariob2,"usuarios","ientusuario","","0","","");cbusqueda3($ipor1usuariob1,$ipor1usuariob2,"usuarios","ipor1usuario","","0","","");cbusqueda3($ipor2usuariob1,$ipor2usuariob2,"usuarios","ipor2usuario","","0","","");cbusqueda3($tgustausuariob1,$tgustausuariob2,"usuarios","tgustausuario","","0","","");cbusqueda3($tcomentariosusuariob1,$tcomentariosusuariob2,"usuarios","tcomentariosusuario","","0","","");cbusqueda3($ndonusuariob1,$ndonusuariob2,"usuarios","ndonusuario","","0","","");cbusqueda3($idonusuariob1,$idonusuariob2,"usuarios","idonusuario","","0","","");cbusqueda3($nrdonusuariob1,$nrdonusuariob2,"usuarios","nrdonusuario","","0","","");cbusqueda3($irdonusuariob1,$irdonusuariob2,"usuarios","irdonusuario","","0","","");cbusqueda3($fbusuariob1,$fbusuariob2,"usuarios","fbusuario","'","0","","");cbusqueda3($tokenfbusuariob1,$tokenfbusuariob2,"usuarios","tokenfbusuario","'","0","","");cbusqueda3($codigousuariob1,$codigousuariob2,"usuarios","codigousuario","'","0","","");cbusqueda3($activob1,$activob2,"usuarios","activo","'","0","","");
	
	$rutinabusqueda=$camposbuscadoslistadosearch." from usuarios ";
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
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";cbusqueda5($itusuusuariol1,"Tipo",": STR","");cbusqueda5($destacadousuariol1,"Destacado",": STR","");cbusqueda5($emailusuariol1,"Email",": STR","");cbusqueda5($contrasenausuariol1,"Contraseña",": STR","");cbusqueda5($nickusuariol1,"Nick",": STR","");cbusqueda5($nombreusuariol1,"Nombre",": STR","");cbusqueda5($imagenusuariol1,"Imagen",": STR","");cbusqueda5($videousuariol1,"URL youtube",": STR","");cbusqueda5($imagenfondousuariol1,"Imagen de fondo",": STR","");cbusqueda5($descripcionusuariol1,"Descripción",": STR","");cbusqueda5($i_descripcionusuariol1,"Descripción en inglés",": STR","");cbusqueda5($urlusuariol1,"URL",": STR","");cbusqueda5($validadousuariol1,"Validado",": STR","");cbusqueda5($cmsusuariol1,"Es administrador",": STR","");cbusqueda5($enviarnotificacionesusuariol1,"Enviar notificaciones",": STR","");cbusqueda5($ipaisusuariol1,"País",": STR","");cbusqueda5($iestadousuariol1,"Estado",": STR","");cbusqueda5($tel1usuariol1,"Teléfono 1",": STR","");cbusqueda5($tel2usuariol1,"Teléfono 2",": STR","");cbusqueda5($ttusuariol1,"Twitter",": STR","");cbusqueda5($familiarteletonusuariol1,"¿Algún familiar es o fue paciente de un Centro Teletón?",": STR","");cbusqueda5($icritusuariol1,"¿Cuál?",": STR","");cbusqueda5($ientusuariol1,"¿Cómo se enteró?",": STR","");cbusqueda5($ipor1usuariol1,"¿Porqué nos apoya? (1)",": STR","");cbusqueda5($ipor2usuariol1,"¿Porqué nos apoya? (2)",": STR","");cbusqueda5($tgustausuariol1,"Total de gusta"," : NUM","");cbusqueda5($tcomentariosusuariol1,"Total de comentarios"," : NUM","");cbusqueda5($ndonusuariol1,"Número de donaciones realizadas"," : NUM","");cbusqueda5($idonusuariol1,"Importe de donaciones realizadas"," : NUM","");cbusqueda5($nrdonusuariol1,"Número de donaciones recibidas"," : NUM","");cbusqueda5($irdonusuariol1,"Impórte de donaciones recibidas"," : NUM","");cbusqueda5($fbusuariol1,"FB",": STR","");cbusqueda5($tokenfbusuariol1,"Token FB",": STR","");cbusqueda5($codigousuariol1,"Código",": STR",""); if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  ?><script language="JavaScript">function tigra_row_clck(marked_all, marked_one){  if(marked_one!='')  {	    window.location.href='usuarios.php?step=modify&id='+marked_one+'&'  }}var TABLE_CAPT = [<?=$tigracabeza?>];var TABLE_LOOK = {'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],'params' : [3, 0],'colors' : {'even'    : '#<?=$vsitioscolor3?>','odd'     : '#<?=$vsitioscolor4?>','hovered' : '#ffffff','marked'  : '#ffff66'},'freeze' : [0, 1],'paging' : {'by' : 0,'tt' : '&nbsp;Página %ind de %pgs&nbsp;','pp' : '&nbsp;<','pf' : '<< ','pn' : '>','pl' : '&nbsp;>>'},'sorting' : {'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">','ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">','no' : ''},'filter' :{'type':0,'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">','btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'},'css' : {'main'     : 'textogeneral','body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],'captCell' : 'cabezastabla','captText' : 'textogeneralnegrita','head'     : 'cabezastabla','foot'     : 'pietabla','pagnCell' : 'cabezastabla','pagnText' : 'titulointerno','pagnPict' : 'titulointerno','filtCell' : 'textogeneral','filtPatt' : 'textogeneral','filtSelc' : 'textogeneral'}};<?php if (!$result){echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");exit();} $listadodecampossearchtigra2="";while ( $row = mysqli_fetch_array($result) ){$menudetalletigra="";if($tgustausuariol1=="on") $sumatoriatgustausuario=$sumatoriatgustausuario+$row["tgustausuario"];if($tcomentariosusuariol1=="on") $sumatoriatcomentariosusuario=$sumatoriatcomentariosusuario+$row["tcomentariosusuario"];if($ndonusuariol1=="on") $sumatoriandonusuario=$sumatoriandonusuario+$row["ndonusuario"];if($idonusuariol1=="on") $sumatoriaidonusuario=$sumatoriaidonusuario+$row["idonusuario"];if($nrdonusuariol1=="on") $sumatorianrdonusuario=$sumatorianrdonusuario+$row["nrdonusuario"];if($irdonusuariol1=="on") $sumatoriairdonusuario=$sumatoriairdonusuario+$row["irdonusuario"];$tempotigra=" ";$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra; $listadodecampossearchtigra=$row["id"];cbusqueda4($itusuusuariol1,"tusu","tipotusu","0","",""); if($destacadousuariol1=="on")  {  if($row["destacadousuario"]=="0") $tempodestacadousuario="NO";if($row["destacadousuario"]=="1") $tempodestacadousuario="SI";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempodestacadousuario.$tempotigra."\""; $tempotigra="";  } cbusqueda4($emailusuariol1,"usuarios","emailusuario","0","","");cbusqueda4($contrasenausuariol1,"usuarios","contrasenausuario","0","","");cbusqueda4($nickusuariol1,"usuarios","nickusuario","0","","");cbusqueda4($nombreusuariol1,"usuarios","nombreusuario","0","","");cbusqueda4($imagenusuariol1,"usuarios","imagenusuario","0","","");cbusqueda4($videousuariol1,"usuarios","videousuario","0","","");cbusqueda4($imagenfondousuariol1,"usuarios","imagenfondousuario","0","","");cbusqueda4($descripcionusuariol1,"usuarios","descripcionusuario","0","","");cbusqueda4($i_descripcionusuariol1,"usuarios","i_descripcionusuario","0","","");cbusqueda4($urlusuariol1,"usuarios","urlusuario","0","",""); if($validadousuariol1=="on")  {  if($row["validadousuario"]=="0") $tempovalidadousuario="Pendiente";if($row["validadousuario"]=="1") $tempovalidadousuario="Validado";if($row["validadousuario"]=="2") $tempovalidadousuario="Registro parcial";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempovalidadousuario.$tempotigra."\""; $tempotigra="";  }  if($cmsusuariol1=="on")  {  if($row["cmsusuario"]=="0") $tempocmsusuario="NO";if($row["cmsusuario"]=="1") $tempocmsusuario="SI";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempocmsusuario.$tempotigra."\""; $tempotigra="";  }  if($enviarnotificacionesusuariol1=="on")  {  if($row["enviarnotificacionesusuario"]=="0") $tempoenviarnotificacionesusuario="NO";if($row["enviarnotificacionesusuario"]=="1") $tempoenviarnotificacionesusuario="SI";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempoenviarnotificacionesusuario.$tempotigra."\""; $tempotigra="";  } cbusqueda4($ipaisusuariol1,"pais","nombrepais","0","","");cbusqueda4($iestadousuariol1,"estados","nombreestado","0","","");cbusqueda4($tel1usuariol1,"usuarios","tel1usuario","0","","");cbusqueda4($tel2usuariol1,"usuarios","tel2usuario","0","","");cbusqueda4($ttusuariol1,"usuarios","ttusuario","0","",""); if($familiarteletonusuariol1=="on")  {  if($row["familiarteletonusuario"]=="0") $tempofamiliarteletonusuario="NO";if($row["familiarteletonusuario"]=="1") $tempofamiliarteletonusuario="SI";if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$linktigra.$tempofamiliarteletonusuario.$tempotigra."\""; $tempotigra="";  } cbusqueda4($icritusuariol1,"crits","nombrecrit","0","","");cbusqueda4($ientusuariol1,"ent","comoent","0","","");cbusqueda4($ipor1usuariol1,"por","porquepor","0","","");cbusqueda4($ipor2usuariol1,"por","porquepor","0","","");cbusqueda4($tgustausuariol1,"usuarios","tgustausuario","0","","");cbusqueda4($tcomentariosusuariol1,"usuarios","tcomentariosusuario","0","","");cbusqueda4($ndonusuariol1,"usuarios","ndonusuario","0","","");cbusqueda4($idonusuariol1,"usuarios","idonusuario","0","","");cbusqueda4($nrdonusuariol1,"usuarios","nrdonusuario","0","","");cbusqueda4($irdonusuariol1,"usuarios","irdonusuario","0","","");cbusqueda4($fbusuariol1,"usuarios","fbusuario","0","","");cbusqueda4($tokenfbusuariol1,"usuarios","tokenfbusuario","0","","");cbusqueda4($codigousuariol1,"usuarios","codigousuario","0","",""); if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\""; if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";}$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);$pietablasearchtigra="\"\"";cbusqueda6($itusuusuariol1,$sumatoriaitusuusuario,'');cbusqueda6($destacadousuariol1,$sumatoriadestacadousuario,'');cbusqueda6($emailusuariol1,$sumatoriaemailusuario,'');cbusqueda6($contrasenausuariol1,$sumatoriacontrasenausuario,'');cbusqueda6($nickusuariol1,$sumatorianickusuario,'');cbusqueda6($nombreusuariol1,$sumatorianombreusuario,'');cbusqueda6($imagenusuariol1,$sumatoriaimagenusuario,'');cbusqueda6($videousuariol1,$sumatoriavideousuario,'');cbusqueda6($imagenfondousuariol1,$sumatoriaimagenfondousuario,'');cbusqueda6($descripcionusuariol1,$sumatoriadescripcionusuario,'');cbusqueda6($i_descripcionusuariol1,$sumatoriai_descripcionusuario,'');cbusqueda6($urlusuariol1,$sumatoriaurlusuario,'');cbusqueda6($validadousuariol1,$sumatoriavalidadousuario,'');cbusqueda6($cmsusuariol1,$sumatoriacmsusuario,'');cbusqueda6($enviarnotificacionesusuariol1,$sumatoriaenviarnotificacionesusuario,'');cbusqueda6($ipaisusuariol1,$sumatoriaipaisusuario,'');cbusqueda6($iestadousuariol1,$sumatoriaiestadousuario,'');cbusqueda6($tel1usuariol1,$sumatoriatel1usuario,'');cbusqueda6($tel2usuariol1,$sumatoriatel2usuario,'');cbusqueda6($ttusuariol1,$sumatoriattusuario,'');cbusqueda6($familiarteletonusuariol1,$sumatoriafamiliarteletonusuario,'');cbusqueda6($icritusuariol1,$sumatoriaicritusuario,'');cbusqueda6($ientusuariol1,$sumatoriaientusuario,'');cbusqueda6($ipor1usuariol1,$sumatoriaipor1usuario,'');cbusqueda6($ipor2usuariol1,$sumatoriaipor2usuario,'');cbusqueda6($tgustausuariol1,$sumatoriatgustausuario,'');cbusqueda6($tcomentariosusuariol1,$sumatoriatcomentariosusuario,'');cbusqueda6($ndonusuariol1,$sumatoriandonusuario,'');cbusqueda6($idonusuariol1,$sumatoriaidonusuario,'');cbusqueda6($nrdonusuariol1,$sumatorianrdonusuario,'');cbusqueda6($irdonusuariol1,$sumatoriairdonusuario,'');cbusqueda6($fbusuariol1,$sumatoriafbusuario,'');cbusqueda6($tokenfbusuariol1,$sumatoriatokenfbusuario,'');cbusqueda6($codigousuariol1,$sumatoriacodigousuario,'');$pietablasearchtigra.=",\"\"";?><?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?><?=$arreglo_ids?></script><? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelusuarios.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> ><input name=itusuusuariol1 type="hidden" value="<?=$itusuusuariol1?>" ><input name=itusuusuariob1 type="hidden" value="<?=$itusuusuariob1?>" ><input name=itusuusuariob2 type="hidden" value="<?=$itusuusuariob2?>" ><input name=destacadousuariol1 type="hidden" value="<?=$destacadousuariol1?>" ><input name=destacadousuariob1 type="hidden" value="<?=$destacadousuariob1?>" ><input name=destacadousuariob2 type="hidden" value="<?=$destacadousuariob2?>" ><input name=emailusuariol1 type="hidden" value="<?=$emailusuariol1?>" ><input name=emailusuariob1 type="hidden" value="<?=$emailusuariob1?>" ><input name=emailusuariob2 type="hidden" value="<?=$emailusuariob2?>" ><input name=contrasenausuariol1 type="hidden" value="<?=$contrasenausuariol1?>" ><input name=contrasenausuariob1 type="hidden" value="<?=$contrasenausuariob1?>" ><input name=contrasenausuariob2 type="hidden" value="<?=$contrasenausuariob2?>" ><input name=nickusuariol1 type="hidden" value="<?=$nickusuariol1?>" ><input name=nickusuariob1 type="hidden" value="<?=$nickusuariob1?>" ><input name=nickusuariob2 type="hidden" value="<?=$nickusuariob2?>" ><input name=nombreusuariol1 type="hidden" value="<?=$nombreusuariol1?>" ><input name=nombreusuariob1 type="hidden" value="<?=$nombreusuariob1?>" ><input name=nombreusuariob2 type="hidden" value="<?=$nombreusuariob2?>" ><input name=imagenusuariol1 type="hidden" value="<?=$imagenusuariol1?>" ><input name=imagenusuariob1 type="hidden" value="<?=$imagenusuariob1?>" ><input name=imagenusuariob2 type="hidden" value="<?=$imagenusuariob2?>" ><input name=videousuariol1 type="hidden" value="<?=$videousuariol1?>" ><input name=videousuariob1 type="hidden" value="<?=$videousuariob1?>" ><input name=videousuariob2 type="hidden" value="<?=$videousuariob2?>" ><input name=imagenfondousuariol1 type="hidden" value="<?=$imagenfondousuariol1?>" ><input name=imagenfondousuariob1 type="hidden" value="<?=$imagenfondousuariob1?>" ><input name=imagenfondousuariob2 type="hidden" value="<?=$imagenfondousuariob2?>" ><input name=descripcionusuariol1 type="hidden" value="<?=$descripcionusuariol1?>" ><input name=descripcionusuariob1 type="hidden" value="<?=$descripcionusuariob1?>" ><input name=descripcionusuariob2 type="hidden" value="<?=$descripcionusuariob2?>" ><input name=i_descripcionusuariol1 type="hidden" value="<?=$i_descripcionusuariol1?>" ><input name=i_descripcionusuariob1 type="hidden" value="<?=$i_descripcionusuariob1?>" ><input name=i_descripcionusuariob2 type="hidden" value="<?=$i_descripcionusuariob2?>" ><input name=urlusuariol1 type="hidden" value="<?=$urlusuariol1?>" ><input name=urlusuariob1 type="hidden" value="<?=$urlusuariob1?>" ><input name=urlusuariob2 type="hidden" value="<?=$urlusuariob2?>" ><input name=validadousuariol1 type="hidden" value="<?=$validadousuariol1?>" ><input name=validadousuariob1 type="hidden" value="<?=$validadousuariob1?>" ><input name=validadousuariob2 type="hidden" value="<?=$validadousuariob2?>" ><input name=cmsusuariol1 type="hidden" value="<?=$cmsusuariol1?>" ><input name=cmsusuariob1 type="hidden" value="<?=$cmsusuariob1?>" ><input name=cmsusuariob2 type="hidden" value="<?=$cmsusuariob2?>" ><input name=enviarnotificacionesusuariol1 type="hidden" value="<?=$enviarnotificacionesusuariol1?>" ><input name=enviarnotificacionesusuariob1 type="hidden" value="<?=$enviarnotificacionesusuariob1?>" ><input name=enviarnotificacionesusuariob2 type="hidden" value="<?=$enviarnotificacionesusuariob2?>" ><input name=ipaisusuariol1 type="hidden" value="<?=$ipaisusuariol1?>" ><input name=ipaisusuariob1 type="hidden" value="<?=$ipaisusuariob1?>" ><input name=ipaisusuariob2 type="hidden" value="<?=$ipaisusuariob2?>" ><input name=iestadousuariol1 type="hidden" value="<?=$iestadousuariol1?>" ><input name=iestadousuariob1 type="hidden" value="<?=$iestadousuariob1?>" ><input name=iestadousuariob2 type="hidden" value="<?=$iestadousuariob2?>" ><input name=tel1usuariol1 type="hidden" value="<?=$tel1usuariol1?>" ><input name=tel1usuariob1 type="hidden" value="<?=$tel1usuariob1?>" ><input name=tel1usuariob2 type="hidden" value="<?=$tel1usuariob2?>" ><input name=tel2usuariol1 type="hidden" value="<?=$tel2usuariol1?>" ><input name=tel2usuariob1 type="hidden" value="<?=$tel2usuariob1?>" ><input name=tel2usuariob2 type="hidden" value="<?=$tel2usuariob2?>" ><input name=ttusuariol1 type="hidden" value="<?=$ttusuariol1?>" ><input name=ttusuariob1 type="hidden" value="<?=$ttusuariob1?>" ><input name=ttusuariob2 type="hidden" value="<?=$ttusuariob2?>" ><input name=familiarteletonusuariol1 type="hidden" value="<?=$familiarteletonusuariol1?>" ><input name=familiarteletonusuariob1 type="hidden" value="<?=$familiarteletonusuariob1?>" ><input name=familiarteletonusuariob2 type="hidden" value="<?=$familiarteletonusuariob2?>" ><input name=icritusuariol1 type="hidden" value="<?=$icritusuariol1?>" ><input name=icritusuariob1 type="hidden" value="<?=$icritusuariob1?>" ><input name=icritusuariob2 type="hidden" value="<?=$icritusuariob2?>" ><input name=ientusuariol1 type="hidden" value="<?=$ientusuariol1?>" ><input name=ientusuariob1 type="hidden" value="<?=$ientusuariob1?>" ><input name=ientusuariob2 type="hidden" value="<?=$ientusuariob2?>" ><input name=ipor1usuariol1 type="hidden" value="<?=$ipor1usuariol1?>" ><input name=ipor1usuariob1 type="hidden" value="<?=$ipor1usuariob1?>" ><input name=ipor1usuariob2 type="hidden" value="<?=$ipor1usuariob2?>" ><input name=ipor2usuariol1 type="hidden" value="<?=$ipor2usuariol1?>" ><input name=ipor2usuariob1 type="hidden" value="<?=$ipor2usuariob1?>" ><input name=ipor2usuariob2 type="hidden" value="<?=$ipor2usuariob2?>" ><input name=tgustausuariol1 type="hidden" value="<?=$tgustausuariol1?>" ><input name=tgustausuariob1 type="hidden" value="<?=$tgustausuariob1?>" ><input name=tgustausuariob2 type="hidden" value="<?=$tgustausuariob2?>" ><input name=tcomentariosusuariol1 type="hidden" value="<?=$tcomentariosusuariol1?>" ><input name=tcomentariosusuariob1 type="hidden" value="<?=$tcomentariosusuariob1?>" ><input name=tcomentariosusuariob2 type="hidden" value="<?=$tcomentariosusuariob2?>" ><input name=ndonusuariol1 type="hidden" value="<?=$ndonusuariol1?>" ><input name=ndonusuariob1 type="hidden" value="<?=$ndonusuariob1?>" ><input name=ndonusuariob2 type="hidden" value="<?=$ndonusuariob2?>" ><input name=idonusuariol1 type="hidden" value="<?=$idonusuariol1?>" ><input name=idonusuariob1 type="hidden" value="<?=$idonusuariob1?>" ><input name=idonusuariob2 type="hidden" value="<?=$idonusuariob2?>" ><input name=nrdonusuariol1 type="hidden" value="<?=$nrdonusuariol1?>" ><input name=nrdonusuariob1 type="hidden" value="<?=$nrdonusuariob1?>" ><input name=nrdonusuariob2 type="hidden" value="<?=$nrdonusuariob2?>" ><input name=irdonusuariol1 type="hidden" value="<?=$irdonusuariol1?>" ><input name=irdonusuariob1 type="hidden" value="<?=$irdonusuariob1?>" ><input name=irdonusuariob2 type="hidden" value="<?=$irdonusuariob2?>" ><input name=fbusuariol1 type="hidden" value="<?=$fbusuariol1?>" ><input name=fbusuariob1 type="hidden" value="<?=$fbusuariob1?>" ><input name=fbusuariob2 type="hidden" value="<?=$fbusuariob2?>" ><input name=tokenfbusuariol1 type="hidden" value="<?=$tokenfbusuariol1?>" ><input name=tokenfbusuariob1 type="hidden" value="<?=$tokenfbusuariob1?>" ><input name=tokenfbusuariob2 type="hidden" value="<?=$tokenfbusuariob2?>" ><input name=codigousuariol1 type="hidden" value="<?=$codigousuariol1?>" ><input name=codigousuariob1 type="hidden" value="<?=$codigousuariob1?>" ><input name=codigousuariob2 type="hidden" value="<?=$codigousuariob2?>" ><input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelusuarios.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
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
var HINTS_ITEMS = {'activo':wrap("Seleccion SI para que el registro esté activo, de lo contrario seleccione NO")}
	

var myHint = new THints (HINTS_CFG, HINTS_ITEMS);
function wrap (s_, b_ques) {
	return "<table width=200 bgcolor=ff6600 cellpadding=5 cellspacing=0><tr><td class=textogeneral><font color=ffffff><b>"+s_+"</td></tr></table>"
}
</script>
  
  
	<?
	
if($error_unique==0)
{
$itusuusuario=1;$destacadousuario='0';$emailusuario='';$contrasenausuario='';$nickusuario='';$nombreusuario='';$imagenusuario='';$videousuario='';$imagenfondousuario='';$descripcionusuario='';$i_descripcionusuario='';$urlusuario='';$validadousuario='0';$cmsusuario='0';$enviarnotificacionesusuario='0';$ipaisusuario=0;$iestadousuario=0;$tel1usuario='';$tel2usuario='';$ttusuario='';$familiarteletonusuario='0';$icritusuario=0;$ientusuario=0;$ipor1usuario=0;$ipor2usuario=0;$tgustausuario=0;$tcomentariosusuario=0;$ndonusuario=0;$idonusuario=0;$nrdonusuario=0;$irdonusuario=0;$fbusuario='';$tokenfbusuario='';$codigousuario='';$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["itusuusuario"])) $itusuusuario=$_POST["itusuusuario"];if(isset($_POST["destacadousuario"])) $destacadousuario=$_POST["destacadousuario"];if(isset($_POST["emailusuario"])) $emailusuario=$_POST["emailusuario"];if(isset($_POST["contrasenausuario"])) $contrasenausuario=$_POST["contrasenausuario"];if(isset($_POST["nickusuario"])) $nickusuario=$_POST["nickusuario"];if(isset($_POST["nombreusuario"])) $nombreusuario=$_POST["nombreusuario"];if(isset($_POST["imagenusuario"])) $imagenusuario=$_POST["imagenusuario"];if(isset($_POST["videousuario"])) $videousuario=$_POST["videousuario"];if(isset($_POST["imagenfondousuario"])) $imagenfondousuario=$_POST["imagenfondousuario"];if(isset($_POST["descripcionusuario"])) $descripcionusuario=$_POST["descripcionusuario"];if(isset($_POST["i_descripcionusuario"])) $i_descripcionusuario=$_POST["i_descripcionusuario"];if(isset($_POST["urlusuario"])) $urlusuario=$_POST["urlusuario"];if(isset($_POST["validadousuario"])) $validadousuario=$_POST["validadousuario"];if(isset($_POST["cmsusuario"])) $cmsusuario=$_POST["cmsusuario"];if(isset($_POST["enviarnotificacionesusuario"])) $enviarnotificacionesusuario=$_POST["enviarnotificacionesusuario"];if(isset($_POST["ipaisusuario"])) $ipaisusuario=$_POST["ipaisusuario"];if(isset($_POST["iestadousuario"])) $iestadousuario=$_POST["iestadousuario"];if(isset($_POST["tel1usuario"])) $tel1usuario=$_POST["tel1usuario"];if(isset($_POST["tel2usuario"])) $tel2usuario=$_POST["tel2usuario"];if(isset($_POST["ttusuario"])) $ttusuario=$_POST["ttusuario"];if(isset($_POST["familiarteletonusuario"])) $familiarteletonusuario=$_POST["familiarteletonusuario"];if(isset($_POST["icritusuario"])) $icritusuario=$_POST["icritusuario"];if(isset($_POST["ientusuario"])) $ientusuario=$_POST["ientusuario"];if(isset($_POST["ipor1usuario"])) $ipor1usuario=$_POST["ipor1usuario"];if(isset($_POST["ipor2usuario"])) $ipor2usuario=$_POST["ipor2usuario"];if(isset($_POST["tgustausuario"])) $tgustausuario=$_POST["tgustausuario"];if(isset($_POST["tcomentariosusuario"])) $tcomentariosusuario=$_POST["tcomentariosusuario"];if(isset($_POST["ndonusuario"])) $ndonusuario=$_POST["ndonusuario"];if(isset($_POST["idonusuario"])) $idonusuario=$_POST["idonusuario"];if(isset($_POST["nrdonusuario"])) $nrdonusuario=$_POST["nrdonusuario"];if(isset($_POST["irdonusuario"])) $irdonusuario=$_POST["irdonusuario"];if(isset($_POST["fbusuario"])) $fbusuario=$_POST["fbusuario"];if(isset($_POST["tokenfbusuario"])) $tokenfbusuario=$_POST["tokenfbusuario"];if(isset($_POST["codigousuario"])) $codigousuario=$_POST["codigousuario"];
}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM usuarios where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM usuarios where id=". $id);
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
$itusuusuario=$row["itusuusuario"];$destacadousuario=$row["destacadousuario"];$emailusuario=$row["emailusuario"];$contrasenausuario='';$nickusuario=$row["nickusuario"];$nombreusuario=$row["nombreusuario"];$imagenusuario=$row["imagenusuario"];$videousuario=$row["videousuario"];$imagenfondousuario=$row["imagenfondousuario"];$descripcionusuario=$row["descripcionusuario"];$i_descripcionusuario=$row["i_descripcionusuario"];$urlusuario=$row["urlusuario"];$validadousuario=$row["validadousuario"];$cmsusuario=$row["cmsusuario"];$enviarnotificacionesusuario=$row["enviarnotificacionesusuario"];$ipaisusuario=$row["ipaisusuario"];$iestadousuario=$row["iestadousuario"];$tel1usuario=$row["tel1usuario"];$tel2usuario=$row["tel2usuario"];$ttusuario=$row["ttusuario"];$familiarteletonusuario=$row["familiarteletonusuario"];$icritusuario=$row["icritusuario"];$ientusuario=$row["ientusuario"];$ipor1usuario=$row["ipor1usuario"];$ipor2usuario=$row["ipor2usuario"];$tgustausuario=$row["tgustausuario"];$tcomentariosusuario=$row["tcomentariosusuario"];$ndonusuario=$row["ndonusuario"];$idonusuario=$row["idonusuario"];$nrdonusuario=$row["nrdonusuario"];$irdonusuario=$row["irdonusuario"];$fbusuario=$row["fbusuario"];$tokenfbusuario=$row["tokenfbusuario"];$codigousuario=$row["codigousuario"];
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
      
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="usuarios.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo($ib_agregando); else echo($ib_editando); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <?
include("include/extrasbotones.php");
?><? if($_GET["edicioninterior"]==1) {  if($nivelusuario=="10") {?><a href="javascript:deleteRecord('usuarios.php?sortfield=itusuusuario&step=2&operacion=delete&id=<?=$id?>&idcontrol=<?=$idcontrolinterno?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
	<script language="javascript" src="../include/dynamicpulldown/chainedselects.js"></script><script language="javascript"><?$sel1=$ipaisusuario;$sel2=$iestadousuario; leecamposcascada("pais","id","nombrepais","",""," ","","","",$id,$sel1,2,1,"usuarios","ipaisusuario");?></script> 
	
    <input name="idcontrol" type="hidden" value="<?=$idcontrolinterno?>">
	<input name="controlmatch" type="hidden" value="<?=$controlmatch?>">
	<input name="match_posts2" type="hidden" value="<?=$match_posts?>">	
	
	
	
	<tr>
    <td>
      <table class="textogeneraltablaform" width="100%" cellpadding="3" cellspacing="0">
     	
	<? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_itusuusuario" name="t_itusuusuario">Tipo * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="itusuusuario" id="itusuusuario"  class=textogeneralform><option value="0" selected></option><?  leecampos("tusu","id","tipotusu","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($itusuusuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("tusu","tipotusu","","",$itusuusuario,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_destacadousuario" name="t_destacadousuario">Destacado * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="destacadousuario" id="destacadousuario" class=textogeneralform><OPTION VALUE="0" <? if($destacadousuario=="0") echo("selected");?> >NO</option><OPTION VALUE="1" <? if($destacadousuario=="1") echo("selected");?> >SI</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($destacadousuario=="0") echo("NO");if($destacadousuario=="1") echo("SI"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_emailusuario" name="t_emailusuario">Email * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="emailusuario" id="emailusuario" value="<? echo(htmlspecialchars($emailusuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$emailusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_contrasenausuario" name="t_contrasenausuario">Contraseña * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="password" name="contrasenausuario" id="contrasenausuario" value="<?=$contrasenausuario?>" size="37" maxlength="32" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?>*****<? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nickusuario" name="t_nickusuario">Nick * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="nickusuario" id="nickusuario" value="<? echo(htmlspecialchars($nickusuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="45" maxlength="40" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$nickusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nombreusuario" name="t_nombreusuario">Nombre * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="nombreusuario" id="nombreusuario" value="<? echo(htmlspecialchars($nombreusuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="80"  class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$nombreusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_imagenusuario" name="t_imagenusuario">Imagen </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="imagenusuario" id="imagenusuario" value="<? echo(htmlspecialchars($imagenusuario,ENT_COMPAT,'ISO-8859-1'));?>" size="60" maxlength="100" readonly class=textogeneralform><a href=javascript:seleccionaimagen('imagenusuario')><img src=recursos/cambiarimagen.gif border="0" alt=Cambiar></a><a href=javascript:muestraimagen('imagenusuario')><img src=recursos/verimagen.gif border="0" alt=Ver></a><a href="javascript:limpiarimagen('imagenusuario')" style="margin-right:20px"><img src=recursos/limpiarimagen.gif border="0" alt=Limpiar></a><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$imagenusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_videousuario" name="t_videousuario">URL youtube </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="videousuario" id="videousuario" value="<? echo(htmlspecialchars($videousuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$videousuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_imagenfondousuario" name="t_imagenfondousuario">Imagen de fondo </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="imagenfondousuario" id="imagenfondousuario" value="<? echo(htmlspecialchars($imagenfondousuario,ENT_COMPAT,'ISO-8859-1'));?>" size="60" maxlength="100" readonly class=textogeneralform><a href=javascript:seleccionaimagen('imagenfondousuario')><img src=recursos/cambiarimagen.gif border="0" alt=Cambiar></a><a href=javascript:muestraimagen('imagenfondousuario')><img src=recursos/verimagen.gif border="0" alt=Ver></a><a href="javascript:limpiarimagen('imagenfondousuario')" style="margin-right:20px"><img src=recursos/limpiarimagen.gif border="0" alt=Limpiar></a><? } ?><? if(($nivelusuario==10)) { ?><?=$imagenfondousuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_descripcionusuario" name="t_descripcionusuario">Descripción </td><td valign="middle"><? if(($nivelusuario==10)) { ?><textarea name="descripcionusuario" id="descripcionusuario" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($descripcionusuario,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10)) { ?><?=$descripcionusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_i_descripcionusuario" name="t_i_descripcionusuario">Descripción en inglés </td><td valign="middle"><? if(($nivelusuario==10)) { ?><textarea name="i_descripcionusuario" id="i_descripcionusuario" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($i_descripcionusuario,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10)) { ?><?=$i_descripcionusuario?><? } ?></td></tr><? } ?><? if($nivelusuario==0) { ?><tr bgcolor="#<?=$vsitioscolor5?>" >
	  <td valign="middle" id="t_urlusuario" name="t_urlusuario">URL Amigable. No Cambiar</td><td valign="middle"><? if(($nivelusuario==0)) { ?><input type="text" name="urlusuario" id="urlusuario" value="<? echo(htmlspecialchars($urlusuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="50" maxlength="100"  class="textogeneralform"><? } ?><? if(($nivelusuario==5)) { ?><?=$urlusuario?><? } ?></td></tr><? } ?>
	  
	  <? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_validadousuario" name="t_validadousuario">Validado * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="validadousuario" id="validadousuario" class=textogeneralform><OPTION VALUE="0" <? if($validadousuario=="0") echo("selected");?> >Pendiente</option><OPTION VALUE="1" <? if($validadousuario=="1") echo("selected");?> >Validado</option><OPTION VALUE="2" <? if($validadousuario=="2") echo("selected");?> >Registro parcial</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? if($validadousuario=="0") echo("Pendiente");if($validadousuario=="1") echo("Validado");if($validadousuario=="2") echo("Registro parcial"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_cmsusuario" name="t_cmsusuario">Es administrador * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="cmsusuario" id="cmsusuario" class=textogeneralform><OPTION VALUE="0" <? if($cmsusuario=="0") echo("selected");?> >NO</option><OPTION VALUE="1" <? if($cmsusuario=="1") echo("selected");?> >SI</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? if($cmsusuario=="0") echo("NO");if($cmsusuario=="1") echo("SI"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_enviarnotificacionesusuario" name="t_enviarnotificacionesusuario">Enviar notificaciones * </td><td valign="middle"><? if(($nivelusuario==10)) { ?><select name="enviarnotificacionesusuario" id="enviarnotificacionesusuario" class=textogeneralform><OPTION VALUE="0" <? if($enviarnotificacionesusuario=="0") echo("selected");?> >NO</option><OPTION VALUE="1" <? if($enviarnotificacionesusuario=="1") echo("selected");?> >SI</option></select><? } ?><? if(($nivelusuario==10)) { ?><? if($enviarnotificacionesusuario=="0") echo("NO");if($enviarnotificacionesusuario=="1") echo("SI"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ipaisusuario" name="t_ipaisusuario">País * </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="ipaisusuario" id="ipaisusuario"  style="width:380px" class=textogeneralform></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("pais","nombrepais","","",$ipaisusuario,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_iestadousuario" name="t_iestadousuario">Estado </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="iestadousuario" id="iestadousuario"  style="width:380px" class=textogeneralform></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("estados","nombreestado","","",$iestadousuario,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tel1usuario" name="t_tel1usuario">Teléfono 1 </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="tel1usuario" id="tel1usuario" value="<? echo(htmlspecialchars($tel1usuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="35" maxlength="30" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$tel1usuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tel2usuario" name="t_tel2usuario">Teléfono 2 </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="tel2usuario" id="tel2usuario" value="<? echo(htmlspecialchars($tel2usuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="35" maxlength="30" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$tel2usuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ttusuario" name="t_ttusuario">Twitter </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><input type="text" name="ttusuario" id="ttusuario" value="<? echo(htmlspecialchars($ttusuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><?=$ttusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_familiarteletonusuario" name="t_familiarteletonusuario">¿Algún familiar es o fue paciente de un Centro Teletón? </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="familiarteletonusuario" id="familiarteletonusuario" class=textogeneralform><OPTION VALUE="0" <? if($familiarteletonusuario=="0") echo("selected");?> >NO</option><OPTION VALUE="1" <? if($familiarteletonusuario=="1") echo("selected");?> >SI</option></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? if($familiarteletonusuario=="0") echo("NO");if($familiarteletonusuario=="1") echo("SI"); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_icritusuario" name="t_icritusuario">¿Cuál? </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="icritusuario" id="icritusuario"  class=textogeneralform><option value="0" selected></option><?  leecampos("crits","id","nombrecrit","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($icritusuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("crits","nombrecrit","","",$icritusuario,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ientusuario" name="t_ientusuario">¿Cómo se enteró? </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="ientusuario" id="ientusuario"  class=textogeneralform><option value="0" selected></option><?  leecampos("ent","id","comoent","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ientusuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("ent","comoent","","",$ientusuario,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ipor1usuario" name="t_ipor1usuario">¿Porqué nos apoya? (1) </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="ipor1usuario" id="ipor1usuario"  class=textogeneralform><option value="0" selected></option><?  leecampos("por","id","porquepor","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ipor1usuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("por","porquepor","","",$ipor1usuario,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ipor2usuario" name="t_ipor2usuario">¿Porqué nos apoya? (2) </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><select name="ipor2usuario" id="ipor2usuario"  class=textogeneralform><option value="0" selected></option><?  leecampos("por","id","porquepor","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ipor2usuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==2)) { ?><? $valor_mostrar=lee_registro("por","porquepor","","",$ipor2usuario,"id");if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tgustausuario" name="t_tgustausuario">Total de gusta </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="tgustausuario" id="tgustausuario" value="<? echo(formato_numero($tgustausuario,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tgustausuario')" onBlur="pone_pesos('tgustausuario','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($tgustausuario,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_tcomentariosusuario" name="t_tcomentariosusuario">Total de comentarios </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="tcomentariosusuario" id="tcomentariosusuario" value="<? echo(formato_numero($tcomentariosusuario,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('tcomentariosusuario')" onBlur="pone_pesos('tcomentariosusuario','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10)) { ?><? echo(formato_numero($tcomentariosusuario,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ndonusuario" name="t_ndonusuario">Número de donaciones realizadas </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="ndonusuario" id="ndonusuario" value="<? echo(formato_numero($ndonusuario,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('ndonusuario')" onBlur="pone_pesos('ndonusuario','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($ndonusuario,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idonusuario" name="t_idonusuario">Importe de donaciones realizadas </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="idonusuario" id="idonusuario" value="<? echo(formato_numero($idonusuario,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('idonusuario')" onBlur="pone_pesos('idonusuario','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($idonusuario,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nrdonusuario" name="t_nrdonusuario">Número de donaciones recibidas </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="nrdonusuario" id="nrdonusuario" value="<? echo(formato_numero($nrdonusuario,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('nrdonusuario')" onBlur="pone_pesos('nrdonusuario','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($nrdonusuario,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_irdonusuario" name="t_irdonusuario">Impórte de donaciones recibidas </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="irdonusuario" id="irdonusuario" value="<? echo(formato_numero($irdonusuario,'')); ?>" size="10" maxlength="10" class=textogeneral onkeypress="s_n('float')"  onFocus="quita_pesos('irdonusuario')" onBlur="pone_pesos('irdonusuario','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2)) { ?><? echo(formato_numero($irdonusuario,'')); ?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_fbusuario" name="t_fbusuario">FB </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="fbusuario" id="fbusuario" value="<? echo(htmlspecialchars($fbusuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="55" maxlength="50" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$fbusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="top" id="t_tokenfbusuario" name="t_tokenfbusuario">Token FB </td><td valign="middle"><? if(($nivelusuario==10)) { ?><textarea name="tokenfbusuario" id="tokenfbusuario" rows="10" cols="50" class=textogeneralform><? echo(htmlspecialchars($tokenfbusuario,ENT_COMPAT,'ISO-8859-1'));?></textarea><? } ?><? if(($nivelusuario==10)) { ?><?=$tokenfbusuario?><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_codigousuario" name="t_codigousuario">Código </td><td valign="middle"><? if(($nivelusuario==10)) { ?><input type="text" name="codigousuario" id="codigousuario" value="<? echo(htmlspecialchars($codigousuario,ENT_COMPAT,'ISO-8859-1')); ?>" size="37" maxlength="32" class="textogeneralform"><? } ?><? if(($nivelusuario==10)) { ?><?=$codigousuario?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'itusuusuario':{'l':'Tipo','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_itusuusuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'destacadousuario':{'l':'Destacado','r': true,'t':'t_destacadousuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'emailusuario':{'l':'Email','r': true,'t':'t_emailusuario'}";?><? } ?><? if($step=="add") { ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'contrasenausuario':{'l':'Contraseña','r': true,'t':'t_contrasenausuario'}";?><? } ?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'nickusuario':{'l':'Nick','r': true,'t':'t_nickusuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'nombreusuario':{'l':'Nombre','r': true,'t':'t_nombreusuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'validadousuario':{'l':'Validado','r': true,'t':'t_validadousuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'cmsusuario':{'l':'Es administrador','r': true,'t':'t_cmsusuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'enviarnotificacionesusuario':{'l':'Enviar notificaciones','r': true,'t':'t_enviarnotificacionesusuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ipaisusuario':{'l':'País','r': true,'f':function(n) {return n > 0 && n < 1000000},'t':'t_ipaisusuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'iestadousuario':{'l':'Estado','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_iestadousuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'icritusuario':{'l':'¿Cuál?','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_icritusuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ientusuario':{'l':'¿Cómo se enteró?','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_ientusuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ipor1usuario':{'l':'¿Porqué nos apoya? (1)','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_ipor1usuario'}";?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ipor2usuario':{'l':'¿Porqué nos apoya? (2)','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_ipor2usuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tgustausuario':{'l':'Total de gusta','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tgustausuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'tcomentariosusuario':{'l':'Total de comentarios','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_tcomentariosusuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ndonusuario':{'l':'Número de donaciones realizadas','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_ndonusuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idonusuario':{'l':'Importe de donaciones realizadas','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_idonusuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'nrdonusuario':{'l':'Número de donaciones recibidas','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_nrdonusuario'}";?><? } ?><? if(($nivelusuario==10)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'irdonusuario':{'l':'Impórte de donaciones recibidas','r': false,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_irdonusuario'}";?><? } ?><script>function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }var a_fields = { <? echo($datostigra); ?> },o_config = {'to_disable' : ['Submit','Reset'],'alert' : 2 + 8 + 4,'alert_class' : ['textogeneralerror', 'textogeneral']} 
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
<script language="javascript" src="../include/dynamicpulldown/chainedselects.js"></script><script language="javascript"><?$sel1=$ipaisusuariob2;$sel2=$iestadousuariob2; leecamposcascada("pais","id","nombrepais","",""," ","","","",$id,$sel1,2,1,"usuarios","ipaisusuario");?></script> 

  <table  border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="usuarios.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><?=$ib_busqueda?></td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> <?=$ib_ordenar?><select class="textogeneralform" name=sortfield><option value="itusuusuario" selected>Tipo</option><option value="destacadousuario">Destacado</option><option value="emailusuario">Email</option><option value="contrasenausuario">Contraseña</option><option value="nickusuario">Nick</option><option value="nombreusuario">Nombre</option><option value="imagenusuario">Imagen</option><option value="videousuario">URL youtube</option><option value="imagenfondousuario">Imagen de fondo</option><option value="descripcionusuario">Descripción</option><option value="i_descripcionusuario">Descripción en inglés</option><option value="urlusuario">URL</option><option value="validadousuario">Validado</option><option value="cmsusuario">Es administrador</option><option value="enviarnotificacionesusuario">Enviar notificaciones</option><option value="ipaisusuario">País</option><option value="iestadousuario">Estado</option><option value="tel1usuario">Teléfono 1</option><option value="tel2usuario">Teléfono 2</option><option value="ttusuario">Twitter</option><option value="familiarteletonusuario">¿Algún familiar es o fue paciente de un </option><option value="icritusuario">¿Cuál?</option><option value="ientusuario">¿Cómo se enteró?</option><option value="ipor1usuario">¿Porqué nos apoya? (1)</option><option value="ipor2usuario">¿Porqué nos apoya? (2)</option><option value="tgustausuario">Total de gusta</option><option value="tcomentariosusuario">Total de comentarios</option><option value="ndonusuario">Número de donaciones realizadas</option><option value="idonusuario">Importe de donaciones realizadas</option><option value="nrdonusuario">Número de donaciones recibidas</option><option value="irdonusuario">Impórte de donaciones recibidas</option><option value="fbusuario">FB</option><option value="tokenfbusuario">Token FB</option><option value="codigousuario">Código</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('usuarios.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	<? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Tipo</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="itusuusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="itusuusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="itusuusuariob2" onChange="if(itusuusuariob1.selectedIndex==0) itusuusuariob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("tusu","id","tipotusu","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($itusuusuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Destacado</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="destacadousuariol1" checked><? } ?><? if($nivelusuario==10) { ?><select name="destacadousuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="destacadousuariob2" onChange="if(destacadousuariob1.selectedIndex==0) destacadousuariob1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($destacadousuario=="0") { ?>selected<? } ?> >NO</option><OPTION VALUE="1" <? if($destacadousuario=="1") { ?>selected<? } ?> >SI</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Email</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="emailusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="emailusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="emailusuariob2" value="" size="55" onKeyUp="revisainput('emailusuariob1','emailusuariob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Contraseña</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="contrasenausuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="contrasenausuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="contrasenausuariob2" value="" size="37" onKeyUp="revisainput('contrasenausuariob1','contrasenausuariob2');" maxlength="32" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nick</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="nickusuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="nickusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nickusuariob2" value="" size="45" onKeyUp="revisainput('nickusuariob1','nickusuariob2');" maxlength="40" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="nombreusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="nombreusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nombreusuariob2" id="nombreusuario" value="" size="50" onKeyUp="revisainput('nombreusuariob1','nombreusuariob2');" maxlength="80" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Imagen</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="imagenusuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="imagenusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="imagenusuariob2" value="" size="105" onKeyUp="revisainput('imagenusuariob1','imagenusuariob2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL youtube</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="videousuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="videousuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="videousuariob2" id="videousuario" value="" size="50" onKeyUp="revisainput('videousuariob1','videousuariob2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Imagen de fondo</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="imagenfondousuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="imagenfondousuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="imagenfondousuariob2" value="" size="105" onKeyUp="revisainput('imagenfondousuariob1','imagenfondousuariob2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Descripción</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="descripcionusuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="descripcionusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="descripcionusuariob2" value="" size="50" onKeyUp="revisainput('descripcionusuariob1','descripcionusuariob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Descripción en inglés</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="i_descripcionusuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="i_descripcionusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="i_descripcionusuariob2" value="" size="50" onKeyUp="revisainput('i_descripcionusuariob1','i_descripcionusuariob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">URL</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="urlusuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="urlusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="urlusuariob2" id="urlusuario" value="" size="50" onKeyUp="revisainput('urlusuariob1','urlusuariob2');" maxlength="100" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Validado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="validadousuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="validadousuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="validadousuariob2" onChange="if(validadousuariob1.selectedIndex==0) validadousuariob1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($validadousuario=="0") { ?>selected<? } ?> >Pendiente</option><OPTION VALUE="1" <? if($validadousuario=="1") { ?>selected<? } ?> >Validado</option><OPTION VALUE="2" <? if($validadousuario=="2") { ?>selected<? } ?> >Registro parcial</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Es administrador</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="cmsusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="cmsusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="cmsusuariob2" onChange="if(cmsusuariob1.selectedIndex==0) cmsusuariob1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($cmsusuario=="0") { ?>selected<? } ?> >NO</option><OPTION VALUE="1" <? if($cmsusuario=="1") { ?>selected<? } ?> >SI</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Enviar notificaciones</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="enviarnotificacionesusuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="enviarnotificacionesusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="enviarnotificacionesusuariob2" onChange="if(enviarnotificacionesusuariob1.selectedIndex==0) enviarnotificacionesusuariob1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($enviarnotificacionesusuario=="0") { ?>selected<? } ?> >NO</option><OPTION VALUE="1" <? if($enviarnotificacionesusuario=="1") { ?>selected<? } ?> >SI</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">País</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ipaisusuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ipaisusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="ipaisusuariob2" onChange="if(ipaisusuariob1.selectedIndex==0) ipaisusuariob1.selectedIndex=1" style="width:380px" class=textogeneralform></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Estado</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="iestadousuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="iestadousuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="iestadousuariob2" onChange="if(iestadousuariob1.selectedIndex==0) iestadousuariob1.selectedIndex=1" style="width:380px" class=textogeneralform></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Teléfono 1</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="tel1usuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="tel1usuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tel1usuariob2" value="" size="35" onKeyUp="revisainput('tel1usuariob1','tel1usuariob2');" maxlength="30" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Teléfono 2</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="tel2usuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="tel2usuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tel2usuariob2" value="" size="35" onKeyUp="revisainput('tel2usuariob1','tel2usuariob2');" maxlength="30" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Twitter</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ttusuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ttusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ttusuariob2" value="" size="55" onKeyUp="revisainput('ttusuariob1','ttusuariob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">¿Algún familiar es o fue paciente de un Centro Teletón?</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="familiarteletonusuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="familiarteletonusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="familiarteletonusuariob2" onChange="if(familiarteletonusuariob1.selectedIndex==0) familiarteletonusuariob1.selectedIndex=1" class=textogeneralform><OPTION VALUE="0" <? if($familiarteletonusuario=="0") { ?>selected<? } ?> >NO</option><OPTION VALUE="1" <? if($familiarteletonusuario=="1") { ?>selected<? } ?> >SI</option></select> <? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">¿Cuál?</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="icritusuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="icritusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="icritusuariob2" onChange="if(icritusuariob1.selectedIndex==0) icritusuariob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("crits","id","nombrecrit","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($icritusuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">¿Cómo se enteró?</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ientusuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ientusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="ientusuariob2" onChange="if(ientusuariob1.selectedIndex==0) ientusuariob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("ent","id","comoent","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ientusuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">¿Porqué nos apoya? (1)</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ipor1usuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ipor1usuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="ipor1usuariob2" onChange="if(ipor1usuariob1.selectedIndex==0) ipor1usuariob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("por","id","porquepor","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ipor1usuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">¿Porqué nos apoya? (2)</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ipor2usuariol1"><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ipor2usuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="ipor2usuariob2" onChange="if(ipor2usuariob1.selectedIndex==0) ipor2usuariob1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("por","id","porquepor","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ipor2usuario==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Total de gusta</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="tgustausuariol1" checked><? } ?><? if($nivelusuario==10) { ?><select name="tgustausuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tgustausuariob2" value="" size="10" onKeyUp="revisainput('tgustausuariob1','tgustausuariob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Total de comentarios</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="tcomentariosusuariol1" checked><? } ?><? if($nivelusuario==10) { ?><select name="tcomentariosusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tcomentariosusuariob2" value="" size="10" onKeyUp="revisainput('tcomentariosusuariob1','tcomentariosusuariob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Número de donaciones realizadas</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="ndonusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="ndonusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ndonusuariob2" value="" size="10" onKeyUp="revisainput('ndonusuariob1','ndonusuariob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Importe de donaciones realizadas</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="idonusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="idonusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="idonusuariob2" value="" size="15" onKeyUp="revisainput('idonusuariob1','idonusuariob2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Número de donaciones recibidas</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="nrdonusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="nrdonusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nrdonusuariob2" value="" size="10" onKeyUp="revisainput('nrdonusuariob1','nrdonusuariob2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Impórte de donaciones recibidas</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><input type="checkbox" name="irdonusuariol1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) { ?><select name="irdonusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="irdonusuariob2" value="" size="15" onKeyUp="revisainput('irdonusuariob1','irdonusuariob2');" maxlength="10" class=textogeneral><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">FB</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="fbusuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="fbusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="fbusuariob2" value="" size="55" onKeyUp="revisainput('fbusuariob1','fbusuariob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Token FB</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="tokenfbusuariol1"><? } ?><? if($nivelusuario==10) { ?><select name="tokenfbusuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="tokenfbusuariob2" value="" size="50" onKeyUp="revisainput('tokenfbusuariob1','tokenfbusuariob2');" maxlength="50" class=textogeneralform><? } ?></td></tr><? } ?><? if($nivelusuario<>11 && $nivelusuario<>0 && $nivelusuario<>1 && $nivelusuario<>2 && $nivelusuario<>3 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Código</td><td valign="middle"><? if($nivelusuario==10) { ?><input type="checkbox" name="codigousuariol1" checked><? } ?><? if($nivelusuario==10) { ?><select name="codigousuariob1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="codigousuariob2" value="" size="37" onKeyUp="revisainput('codigousuariob1','codigousuariob2');" maxlength="32" class=textogeneralform><? } ?></td></tr><? } ?> 
	
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="<?=$ib_busqueda?>" name=button1 onClick="return BusquedaNormal('usuarios.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2) {?>
<input class="textogeneral" type="button" value="<?=$ib_exportar?>" name=button2 onClick="return BusquedaExcel('excel/excelusuarios.php?step=busqueda2<?=$url_extra?>');">
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

