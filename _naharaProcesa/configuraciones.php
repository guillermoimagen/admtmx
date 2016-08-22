<?php include("recursos/entrada.php"); 
include("recursos/xss_var.php");
 ?>
<?php include("../include/connection.php"); ?>
<?php include("recursos/funciones.php"); ?>
<? if($nivelusuario==0 or $nivelusuario==1 or $nivelusuario==2 or $nivelusuario==3 or  $nivelusuario==4 ) { ?>
<html>
<link rel="stylesheet" href="recursos/estilos.css" type="text/css">

<head>
<title><? echo("Configuraci&oacute;n"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<? include("recursos/funcionesjs.php"); ?>
</head>
<BODY topmargin=0 LEFTMARGIN=0>
<?=$encabezadousuario?>

<?php include("recursos/cabeza.inc"); ?>
<? 
  if($ventanabotoneditar<>1)
  {
    include("menu.php"); 
    include("menu2.php"); 

  }	
?>
<span class="error"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina" >
  <tr>
    <td height="30" valign="middle"><span class="titulo">Configuraci&oacute;n</span></td>

  </tr>
</table>
</span>
<br>

<table width=100% cellspacing="0" cellpadding="0" class="bordeprincipal">
<tr>
<td width=100%  valign=top>


<TABLE CLASS=textogeneral cellspacing=0 cellpadding=5 width=100%>
<?php    

 //if($sesionid<>1 && $sesionid<>2  && $sesionid<>12 && $sesionid<>34) 
	if($nivelusuarioreal!=0) 
  {
      $step="";
      $operacion="";
      $mensaje="No tienes privilegios para accesar a esta secciï¿½n.";
	  
   } 
	
else
	{




}
?>


<?
  $botones_peque2="";  
  $numerodetabla=1;
for($i=1; $i<=9; $i++)
{
  $botones_peque="";  
  $carga_default="";
  // LEE LOS MENUS QUE APLICAN A LA PAGINA
  $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select id,textobotonconfiguracion,linkconfiguracion,explicacionconfiguracion from configuracion where modoconfiguracion='".$i."' and activo='1' order by ordenconfiguracion");
  
  ///echo "select id,textobotonconfiguracion,linkconfiguracion,explicacionconfiguracion from configuracion where modoconfiguracion='".$i."' and activo='1' order by ordenconfiguracion";
  while($rowx = mysqli_fetch_array($resultx))
  {
    $botonmenupeque=$rowx["textobotonconfiguracion"];
    $urlmenupeque=$rowx["linkconfiguracion"];
	$alturamenupeque=500;	
	
	eval("\$urlmenupeque=\"".$urlmenupeque."\";");		
	
    $botones_peque.=haceboton_menu_peque($botonmenupeque,$urlmenupeque."&esframe=1","frame_bajo",$alturamenupeque,"boton",$rowx["id"]);
	
	$titulo="";  
	if($i==1) $titulo="General: ";
	else if($i==2) $titulo="Cat&aacute;logos: ";
	else if($i==4) $titulo="Estadística y Reportes: ";
	//else if($i==5) $titulo="Lugares: ";
	//else if($i==4) $titulo="Juegos Imagen: ";
	//else if($i==6) $titulo="Conceptos Facturas: ";
	//else if($i==9) $titulo="Importar desde Excel: ";
	
	if($titulo<>"") $titulo="<td class=textogeneralnegrita style=\"width:110px; text-align:right; padding-right:5px; \">".$titulo."</td>";

  }
  if($botones_peque<>"") 
	$botones_peque2.="<table cellpadding=0 cellspacing=0 height=20><tr>".$titulo.$botones_peque."<td></td></tr><tr height=2><td colspan=20 height=2></td></tr></table>";
}

?>




<table class=textogeneral border=0 cellpadding=0 cellspacing=0><tr height=16>
<?=$botones_peque2?>
<td></td></tr></table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bordeprincipal" align="center" name="frame_bajo_tabla" id="frame_bajo_tabla" style="display:none; width:100%">       

<tr>
<td style="padding-top:10px; padding-left:10px; width:100%">
<iframe id="frame_bajo" name="frame_bajo" src="" style="width:100%; border:none; display:none;" scrolling="no" frameborder="0"></iframe>
</td>
<td style="width:1%">&nbsp;
</td>
</tr>
</table>

</body>
</html>
<? } ?>

<script language="JavaScript" src="include/imenu_peque.js"></script>  