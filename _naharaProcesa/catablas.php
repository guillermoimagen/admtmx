<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 

$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_catablas"]=1;
	$_SESSION["esframe_catablas_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_catablas_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_catablas"]=0;
	$_SESSION["esframe_catablas_id"]=0;
	$_SESSION["esframe_catablas_archivo"]="";
}

$titulo_pagina="Tablas de sistema";
include("recursos/funciones.php"); 

$numerodetabla=103;
$archivoactual="catablas.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_catablas"]=$id;

include("recursos/iconosybotones.php");
$controlmatch="NO";
?>

<?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; 
include("include/imenu_peque.php");
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
  $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select count(cagruposprivilegios.id) from caprivilegiosusuarios,cagruposprivilegios where caprivilegiosusuarios.idusuarioprivilegiousuario=".$sesionid." AND caprivilegiosusuarios.idgrupoprivilegiousuario=cagruposprivilegios.id AND cagruposprivilegios.activo=1 AND cagruposprivilegios.nombregrupoprivilegio='tablas'");
  while($rowx = mysqli_fetch_array($resultx))
  {
     if($rowx[0]<=0) { $mensaje=guardareporte(11); $step=""; $operacion=""; }
  }
}


?>
<?
if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }
else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }
if($step=="busqueda2" || $step=="busqueda3") 
{ 
  if($nivelusuario==0) 
  { 
    if(isset($nombretablab2) || isset($idtablab2) || isset($ayudatablab2)) $error=9; 
  }
  if($nivelusuario==1) 
  { 
    if(isset($nombretablab2) || isset($idtablab2) || isset($ayudatablab2)) $error=9; 
  }
  if($nivelusuario==2) 
  { 
    if(isset($nombretablab2) || isset($idtablab2) || isset($ayudatablab2)) $error=9; 
  }
  if($nivelusuario==3) 
  { 
    if(isset($nombretablab2) || isset($idtablab2) || isset($ayudatablab2)) $error=9; 
  }
  if($nivelusuario==4) 
  { 
    if(isset($nombretablab2) || isset($idtablab2) || isset($ayudatablab2)) $error=9; 
  }
}
if($operacion=="modify") 
{ 
  if($nivelusuario==0) if(isset($_POST["nombretabla"]) || isset($_POST["idtabla"]) || isset($_POST["ayudatabla"])) $error=8; 
  if($nivelusuario==1) if(isset($_POST["nombretabla"]) || isset($_POST["idtabla"]) || isset($_POST["ayudatabla"])) $error=8; 
  if($nivelusuario==2) if(isset($_POST["nombretabla"]) || isset($_POST["idtabla"]) || isset($_POST["ayudatabla"])) $error=8; 
  if($nivelusuario==3) if(isset($_POST["nombretabla"]) || isset($_POST["idtabla"]) || isset($_POST["ayudatabla"])) $error=8; 
  if($nivelusuario==4) if(isset($_POST["nombretabla"]) || isset($_POST["idtabla"]) || isset($_POST["ayudatabla"])) $error=8; 
}

if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } 
?>

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





<head>

<title><? echo("Tablas de sistema"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<script>
function funcionload()
{

<? if($step=="busqueda") { ?> 
<? } else if($step=="modify" || $step=="add") { ?> 
<? } ?> 
}
</script>
<? include("recursos/funcionesjs.php"); ?>
<script language="JavaScript" src="include/imenu_peque.js"></script>

</head>
<BODY style="margin-right:0px;" onLoad="funcionload();">

<?
  if($ocultabotones<>1) {   
    if($_SESSION["esframe_catablas"]<>1)
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
      $sqltemporal.=construyesqltemporal("nombretabla","'",0);
$sqltemporal.=construyesqltemporal("idtabla","",2);

$sqltemporal.=construyesqltemporal("activo","",0);

    
      
      
    }
    
	
	if($sqltemporal=="" && ($operacion=="add" || $operacion=="modify")) 
	{
	  $mensaje="Nada que guardar";
	  $modomensaje="NADA";
	  $operacion="";
	}  
	
	


	
	if($operacion=="add") 
	{	
	  $controlmatch="SI";  
	   if($nivelusuario=="meminpinguin") {	
      	
		  $sql = "INSERT INTO catablas SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.="Se guardó correctamente el registro";
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=103,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_catablas"]=$id;

		  } 
		  else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="ESE ID DE TABLA YA EXISTE<br>No se ha guardado el registro.";
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
		  $sql = "UPDATE catablas SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.="Se actualizó correctamente el registro";
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=103,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			  
			}
			else
			{
			  $mensaje.="No hubo cambios en el registro";
			  $modomensaje="NADA";
			}  
			  
		  } else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="ESE ID DE TABLA YA EXISTE<br>No se ha guardado el registro";
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
      if($confirmadelete<>"confirmado") {
$mensajedelete="";if($mensajedelete<>"") { $step="modify"; $operacion=""; $mensaje.="No se puede eliminar el registro, debido a lo siguiente:".$mensajedelete;

}
}

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
		$sql = "DELETE FROM catablas WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.="Se eliminó correctamente el registro <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">Regresar</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=103,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
		} 
		else 
		{
		 $mensaje.="Ocurrió un error al eliminar el registro: " . mysqli_error($GLOBALS["enlaceDB"] ) ;
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
  	
  
?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina">
  <tr>    
    <td height="30" valign="middle"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";
$idx3=0;$idx2=0;$idx1 =0;$idx=0;
if($step=="modify"){
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,nombretabla FROM catablas where id=". $id);
$rowx = mysqli_fetch_array($resultx);
$linkx=" >> ".$rowx["nombretabla"]." ".$rowx[""];
$idx=$rowx[""];
}
echo("<a href=catablas.php?sortfield=nombretabla&step=1".$url_extra."><span class=titulo>Tablas de sistema</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="right"><? if($ocultabotones<>1) { ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>

<? 
  if($mensaje<>"") 
  {
    if($modomensaje=="ERROR") echo($entradamensajeerror.$mensaje.$salidamensaje); 
	else if($modomensaje=="NADA") echo($entradamensajenada.$mensaje.$salidamensaje); 
	else echo($entradamensaje.$mensaje.$salidamensaje); 
  }	  
?>
   
<? if($step=="busqueda2" || $step=="busqueda3") { ?> <span class=textogeneral><br>
</span> 

<table width=100% border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="spacerlateral"></td>
<td valign=top width=100%>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
  <tr> 
    <td width=100%><?
       if($step=="busqueda3" || $moditobusqueda=="especial") { 
$activol1="on"; $comparadorsearch="AND"; $sortfield="catablas.activo DESC,nombretabla ASC"; $ordenamiento="";
$activob1="="; $activob2="1";
$nombretablal1="on"; 
$idtablal1="on"; 
$ayudatablal1="on"; 
} 

$camposbuscadoslistadosearch="catablas.id";
cbusqueda1($activol1,"catablas","activo");
cbusqueda1($nombretablal1,"catablas","nombretabla");
cbusqueda1($idtablal1,"catablas","idtabla");
cbusqueda1($ayudatablal1,"catablas","ayudatabla");
cbusqueda3($nombretablab1,$nombretablab2,"catablas","nombretabla","'","0","","");
cbusqueda3($idtablab1,$idtablab2,"catablas","idtabla","","0","","");
cbusqueda3($ayudatablab1,$ayudatablab2,"catablas","ayudatabla","'","0","","");
cbusqueda3($activob1,$activob2,"catablas","activo","'","0","","");

	
	$rutinabusqueda=$camposbuscadoslistadosearch." from catablas ";
	$antesbusqueda="";
	
	if($camposcomunessearch<>"") $rutinabusqueda=$rutinabusqueda.$camposcomunessearch;
	
	if($sqltemporal<>"" && $antesbusqueda<>"") $sqltemporal=$sqltemporal." and ".$antesbusqueda;
	else if($sqltemporal=="" && $antesbusqueda<>"") $sqltemporal=$antesbusqueda;
	
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
          <td valign=middle class="titulointerior"><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><span class=textogeneral>(<?=$num_rows?> registros<?=$mensajelimite?>) <?=$sqltemporal?> </span></td>
         
        
        </tr>
      </table>
    </td> </tr>

  <tr> 
    <td class=titulointerno valign=top height=100%><script>var path_to_files='../include/table/';</script><script language="JavaScript" src="../include/table/table.js"></script><? $totalcolumnas=1; $tigracabeza="{'name':'id','type' : NUM	}";
cbusqueda5($nombretablal1,"Nombre de la tabla",": STR");
cbusqueda5($idtablal1,"Id interno de la tabla"," : NUM");
cbusqueda5($ayudatablal1,"Ayuda de la tabla",": STR");
 if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  
?>
<script language="JavaScript">
function tigra_row_clck(marked_all, marked_one)
{
  if(marked_one!='')
  {
	    window.location.href='catablas.php?step=modify&id='+marked_one+'&;'
  }
}
var TABLE_CAPT = [<?=$tigracabeza?>];
var TABLE_LOOK = {
'onclick' : tigra_row_clck,'structure' : [0, 1, 2, 3, 4, 5],
'params' : [3, 0],
'colors' : {
'even'    : '#<?=$vsitioscolor3?>',
'odd'     : '#<?=$vsitioscolor4?>',
'hovered' : '#ffffff',
'marked'  : '#ffff66'
},
'freeze' : [0, 1],
'paging' : {
'by' : 0,
'tt' : '&nbsp;Página %ind de %pgs&nbsp;',
'pp' : '&nbsp;<',
'pf' : '<< ',
'pn' : '>',
'pl' : '&nbsp;>>'
},
'sorting' : {
'as' : '<img src=../include/table/table_asc.gif border="0" height=4 width="8" alt="sort descending">',
'ds' : '<img src=../include/table/table_desc.gif border="0" height=4 width="8" alt="sort ascending">',
'no' : ''
},
'filter' :{
'type':0,
'btn_ok' : '&nbsp;<img src=../include/table/yes.gif width="16" height="16" border="0" alt="Filtrar" align="absmiddle">',
'btn_no' : '&nbsp;<img src=../include/table/no.gif width="16" height="16" border="0" alt="Mostrar todos" align="absmiddle">'
},
'css' : {
'main'     : 'textogeneral',
'body'     : ['textogeneral','textogeneral','textogeneral','textogeneral'],
'captCell' : 'cabezastabla',
'captText' : 'textogeneralnegrita',
'head'     : 'cabezastabla',
'foot'     : 'pietabla',
'pagnCell' : 'cabezastabla',
'pagnText' : 'titulointerno',
'pagnPict' : 'titulointerno',
'filtCell' : 'textogeneral',
'filtPatt' : 'textogeneral',
'filtSelc' : 'textogeneral'
}
};
<?php 
if (!$result)
{
echo("<p>Ocurrió un error al abrir la base de datos: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
exit();
} $listadodecampossearchtigra2="";
while ( $row = mysqli_fetch_array($result) )
{
$menudetalletigra="";

$tempotigra=" ";
$botonestigra="<a href='#' class=textoboton>&nbsp;Editar&nbsp;</a>".$menudetalletigra;

 $listadodecampossearchtigra=$row["id"];
cbusqueda4($nombretablal1,"catablas","nombretabla","0","","");
cbusqueda4($idtablal1,"catablas","idtabla","0","","");
cbusqueda4($ayudatablal1,"catablas","ayudatabla","0","","");
 if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }
if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\"";
 if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";
$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";
}
$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);
$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);
$pietablasearchtigra="\"\"";
cbusqueda6($nombretablal1,$sumatorianombretabla,'');
cbusqueda6($idtablal1,$sumatoriaidtabla,'');
cbusqueda6($ayudatablal1,$sumatoriaayudatabla,'');
$pietablasearchtigra.=",\"\"";

?>
<?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?></script>
<? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" method="post" action="excel/excelcatablas.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> >
<input name=nombretablal1 type="hidden" value="<?=$nombretablal1?>" ><input name=nombretablab1 type="hidden" value="<?=$nombretablab1?>" ><input name=nombretablab2 type="hidden" value="<?=$nombretablab2?>" >
<input name=idtablal1 type="hidden" value="<?=$idtablal1?>" ><input name=idtablab1 type="hidden" value="<?=$idtablab1?>" ><input name=idtablab2 type="hidden" value="<?=$idtablab2?>" >
<input name=ayudatablal1 type="hidden" value="<?=$ayudatablal1?>" ><input name=ayudatablab1 type="hidden" value="<?=$ayudatablab1?>" ><input name=ayudatablab2 type="hidden" value="<?=$ayudatablab2?>" >
<input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcatablas.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onclick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
</table>
 </td><td width="5" rowspan="2"><img src="recursos/spacer.png" width="5" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=103 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
if(mysqli_num_rows($resultx)>0)
{
  $tempoayuda="";
  while($rowx = mysqli_fetch_array($resultx))
  {
    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
  }
  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");
  ?>
<script language="javascript" src="../include/scroll/scroll.js"></script>
<script language="javascript">var Tscr_LOOK0 = {
'size' : [190, 100],
's_i':'textogeneralaviso',
's_b':'textogeneralaviso',
'pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],
're' : [150,80, 16, 16,,'../include/scroll/mres.gif'],
'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],
'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']
},
Tscr_BEHAVE0 = {
'auto'  : true,
'vertical' : true,
'speed' : 1,
'interval' : 50,
'hide_buttons' : true,
'zindex':5
};</script>
<TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr>
<? } ?>
<tr><td  class="titulomenulateral"><b>Tablas de sistema</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=catablas.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Tablas de sistema\"></a></td>";
if($nivelusuario==0) $botones.="<td><a href=catablas.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Tablas de sistema\"></a></td>";
if($_SESSION["esframe_catablas_id"]<>0) $botones.="<td><a href=".$_SESSION["esframe_catablas_archivo"].".php?step=modify&id=".$_SESSION["esframe_catablas_id"]." target=_parent><img src=recursos/botonregresar.gif border=\"0\" alt=Regresar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar="";
 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_103_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_103_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_103_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_103_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?>

</table></td>
 <td class="spacerlateral"></td></tr>
</table>

<? 
echo($framesitos[2]);
} ?>


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
$nombretabla='';
$idtabla=0;
$ayudatabla='';

$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["nombretabla"])) $nombretabla=$_POST["nombretabla"];
if(isset($_POST["idtabla"])) $idtabla=$_POST["idtabla"];
if(isset($_POST["ayudatabla"])) $ayudatabla=$_POST["ayudatabla"];

}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM catablas where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM catablas where id=". $id);
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
$nombretabla=$row["nombretabla"];
$idtabla=$row["idtabla"];
$ayudatabla=$row["ayudatabla"];

       }
	 }	 
	 
  ?>


<span class=textogeneral><br></span>

<? if($registrosencontrados>0) {?>

<? if($step=="modify") { ?>

<?$sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=103,operacionseguimiento='0'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);?>

<? } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100% valign=top>
      
      <?=$framesitos[1]?>
      <div id="formulario" name="formulario">
	  
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
      <form name="form1" onSubmit="return v.exec()" method="post" action="catablas.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo("Agregar "); else echo("Modificar "); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>  
				       
				          <? } ?>
<? if($nivelusuario==0 || $nivelusuario==10) {?>
<? $yabotonguardar="ya"; ?>
<input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>>
<?} ?>
<? if($step=="add" && $yabotonguardar<>"ya") { ?>
<input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>>
<? } ?></div><? } ?>
</td>
                  </tr>
                </table>
                
              </div>
          </td>
    </tr>
	
	 <tr>
       <td bgcolor="#<?=$vsitioscolor5?>"><div align="center" id="error_form1" style="display: block;"></div></td>
     </tr> 
	 
	
    <input name="idcontrol" type="hidden" value="<?=$idcontrolinterno?>">
	<input name="controlmatch" type="hidden" value="<?=$controlmatch?>">
	<input name="match_posts2" type="hidden" value="<?=$match_posts?>">	
	
	
	
	<tr>
    <td>
      <table class="textogeneraltablaform" width="100%" cellpadding="3" cellspacing="0">
      <tr bgcolor="#<?=$vsitioscolor5?>" >
        <td width="9%"></td>
	    <td width="91%"></td>
      </tr>
	
	
<? if($nivelusuario<>11) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nombretabla">Nombre de la tabla * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><input type="text" name="nombretabla" value="<? echo(htmlspecialchars($nombretabla)); ?>" size="45" maxlength="40" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3 || $nivelusuario==4 ) && $step<>"add") { ?><?=$nombretabla?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_idtabla">Id interno de la tabla * </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><input type="text" name="idtabla" value="<? echo(formato_numero($idtabla,'')); ?>" size="10" maxlength="15" class=textogeneralform onkeypress="s_n('int')"  onFocus="quita_pesos('idtabla')" onBlur="pone_pesos('idtabla','')"  style="text-align:right"><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3 || $nivelusuario==4 ) && $step<>"add") { ?><? echo(formato_numero($idtabla,'')); ?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ayudatabla">Ayuda de la tabla </td><td valign="middle"><? if(($nivelusuario==10) || $step=="add") { ?><?if($step=="add") echo("No disponible."); if($step=="modify") echo("<a href=javascript:editarmf('ayudatabla','catablas',".$id.",'".urlencode("Ayuda de la tabla")."','".urlencode("Tablas de sistema")."',103) class=textoboton>&nbsp;Editar texto&nbsp;</a>"); ?><? } ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3 || $nivelusuario==4 ) && $step<>"add") { ?><?=$ayudatabla?><? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'nombretabla':{'l':'Nombre de la tabla','r': true,'t':'t_nombretabla'}";?><? } ?>
<? if(($nivelusuario==10) || $step=="add") { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'idtabla':{'l':'Id interno de la tabla','r': true,'f':function(n) { ene=valida_sinpesos(n); return ene; },'t':'t_idtabla'}";?><? } ?>
<script>
function ValidDate(y, m, d) { with (new Date(y, m, d)) return (getMonth()==m && getDate()==d) }
var a_fields = { <? echo($datostigra); ?>
 }
,o_config = {
'to_disable' : ['Submit','Reset'],
'alert' : 2 + 8 + 4,
'alert_class' : ['textogeneralerror', 'textogeneral']
}
 var v = new validator('form1', a_fields, o_config)
</script>  
    <? if($nivelusuario=="meminpinguin") {?>
	<tr>
      <td valign="middle"  bgcolor="#<?=$vsitioscolor3?>">Activo <a onMouseOver="myHint.show('activo')" onMouseOut="myHint.hide()">(?)</a></td>
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
     <td colspan="2"  class="titulointerior" valign="middle">              
      <div align="right">
                <? if($ocultabotones<>1) { ?>	<? if($nivelusuario==0 || $nivelusuario==10) {?> <? $yabotonguardar="ya"; ?>
                <input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>><?} ?>
				<? if($step=="add" && $yabotonguardar<>"ya") { ?><input class=textogeneral type="submit" name="Submit" value="Guardar" <?=$valordisabled?>><? } ?><? } ?>
              </div>
            </td>
    </tr>
	
    
	
	</form>
  </table>
  </div>
  
  <?=$framesitos[3]?>
  
  </td>
     <? if($ocultabotones<>1) { ?> <? if($step=="modify") { ?><? } ?><td width="5" rowspan="2"><img src="recursos/spacer.png" width="5" height="0"></td><td width="100%" valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=103 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='1'");
if(mysqli_num_rows($resultx)>0)
{
  $tempoayuda="";
  while($rowx = mysqli_fetch_array($resultx))
  {
    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
  }
  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");
  ?>
<script language="javascript" src="../include/scroll/scroll.js"></script>
<script language="javascript">var Tscr_LOOK0 = {
'size' : [190, 100],
's_i':'textogeneralaviso',
's_b':'textogeneralaviso',
'pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],
're' : [150,80, 16, 16,,'../include/scroll/mres.gif'],
'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],
'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']
},
Tscr_BEHAVE0 = {
'auto'  : true,
'vertical' : true,
'speed' : 1,
'interval' : 50,
'hide_buttons' : true,
'zindex':5
};</script>
<TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr>
<? } ?>
<tr><td  class="titulomenulateral"><b>Tablas de sistema</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=catablas.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Tablas de sistema\"></a></td>";
if($nivelusuario==0) $botones.="<td><a href=catablas.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Tablas de sistema\"></a></td>";
if($_SESSION["esframe_catablas_id"]<>0) $botones.="<td><a href=".$_SESSION["esframe_catablas_archivo"].".php?step=modify&id=".$_SESSION["esframe_catablas_id"]." target=_parent><img src=recursos/botonregresar.gif border=\"0\" alt=Regresar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"ubicacion_103_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('ubicacion_103_0')" class="textogeneralnegrita">
<img id="collapseimg_ubicacion_103_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Ubicación</b></a></td></tr><tbody id="collapseobj_ubicacion_103_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><table class=textogeneral cellpadding="0" cellspacing="0"><? 
        $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,nombretabla,activo FROM catablas order by nombretabla ASC");
        while ( $rowx = mysqli_fetch_array($resultx) )
        {
          $boldi=""; if($rowx["id"]==$id) $boldi=" bgcolor=#".$vsitioscolor1."";
          $clase=" class=textogeneral"; if($rowx[activo]==0) $clase=" class=textogeneralinactivo";
          echo("<tr".$boldi."><td colspan=\"2\"><a href=catablas.php?step=modify&id=".$rowx["id"].$url_extra.$clase.">".$rowx["nombretabla"]."</a></td></tr>");
              if($rowx["id"]==$id)
              {
                $resultx0 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,descripcionayudatabla,activo FROM caayudatablas where idtablaayudatabla=". $rowx["id"]." order by descripcionayudatabla ASC");
                while ( $rowx0 = mysqli_fetch_array($resultx0) )
                {
                  $clase=" class=textogeneral"; if($rowx0["activo"]==0) $clase=" class=textogeneralinactivo";
                  echo("<tr><td><img src=recursos/spacer.gif width=\"20\" height=1></td><td width=\"100%\"><a href=caayudatablas.php?step=modify&id=".$rowx0["id"].$url_extra.$clase.">".$rowx0["descripcionayudatabla"]."</a></td></tr>");
                } 
                  echo("<tr><td><img src=recursos/spacer.gif width=\"20\" height=1></td><td width=\"100%\"><a href=caayudatablas.php?step=add&idtablaayudatabla=".$id.$url_extra." class=textogeneralboton>Agregar ayuda a esta tabla</a></td></tr>");
              } 
        } 
?>
</table></td></tr></tbody>
<? if($nivelusuario==0) { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"ubicacion_103_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('ubicacion_103_0')" class="textogeneralnegrita">
<img id="collapseimg_ubicacion_103_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Avanzadas</b></a></td></tr>
<tbody id="collapseobj_ubicacion_103_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><a href="careportes.php?step=busqueda2&idtablareporteb1==&idtablareporteb2=<?=$numerodetabla?>&idregistroreporteb1==&idregistroreporteb2=<?=$id?>&moditobusqueda=especial&&titulobusqueda=Reportes de registro" class=textogeneral target=_blank>Ver reportes de este registro</a><br><a href="caseguimiento.php?step=busqueda2&tablaseguimientob1==&tablaseguimientob2=<?=$numerodetabla?>&registroseguimientob1==&registroseguimientob2=<?=$id?>&moditobusqueda=especial&titulobusqueda=Seguimiento de registro" class=textogeneral target=_blank>Ver seguimiento de este registro</a><br><a href="cahistorico.php?step=busqueda2&tablabusqueda=<?=$numerodetabla?>&registrobusqueda=<?=$id?>&modo=busqueda&moditobusqueda=especial&titulobusqueda=Histórico de registro" class=textogeneral target=_blank>Ver histórico completo</a></td></tr></tbody><? } ?>
</table></td>
<? } ?>
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
 

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100%  valign=top><form name="form2" method="post" action="catablas.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior">B&uacute;squeda</td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> Comparador
                <select name="comparadorsearch" class="textogeneral">
                  <option value="AND" selected>Y</option>
                  <option value="OR">O</option>
                </select>
Ordenar<select class="textogeneralform" name=sortfield><option value="nombretabla" selected>Nombre de la tabla</option><option value="idtabla">Id interno de la tabla</option><option value="ayudatabla">Ayuda de la tabla</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('catablas.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	
<? if($nivelusuario<>11) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre de la tabla</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3 || $nivelusuario==4) { ?><input type="checkbox" name="nombretablal1" checked><? } ?><? if($nivelusuario==10) { ?><select name="nombretablab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nombretablab2" value="" size="45" onKeyUp="revisainput('nombretablab1','nombretablab2');" maxlength="40" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Id interno de la tabla</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3 || $nivelusuario==4) { ?><input type="checkbox" name="idtablal1" checked><? } ?><? if($nivelusuario==10) { ?><select name="idtablab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="idtablab2" value="" size="10" onKeyUp="revisainput('idtablab1','idtablab2');" maxlength="15" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Ayuda de la tabla</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3 || $nivelusuario==4) { ?><input type="checkbox" name="ayudatablal1" checked><? } ?><? if($nivelusuario==10) { ?><select name="ayudatablab1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="ayudatablab2" value="" size="50" onKeyUp="revisainput('ayudatablab1','ayudatablab2');" maxlength="50" class=textogeneral><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario=="meminpinguin") {?>
	<tr>
      <td valign="middle" bgcolor="#<?=$vsitioscolor3?>">Activo <a href="javascript:muestraayuda('Activo. Seleccione SI para que el registro esté activo en el sitio web, de lo contrario seleccione NO');">(?)</a></td>
      <td valign="middle" bgcolor="#<?=$vsitioscolor3?>"> 
        <input name="activol1" type="checkbox" checked>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('catablas.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcatablas.php?step=busqueda2<?=$url_extra?>');">
<?} ?><? } ?></div>
      </td>
    </tr>
  </table></form></td><? if($ocultabotones<>1) { ?><td width="5" rowspan="2"><img src="recursos/spacer.png" width="5" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=103 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
if(mysqli_num_rows($resultx)>0)
{
  $tempoayuda="";
  while($rowx = mysqli_fetch_array($resultx))
  {
    $tempoayuda.="{'content': '".$rowx["texto1ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto2ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto2ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto3ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto3ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto4ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto4ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
    if($rowx["texto5ayudatabla"]<>"") $tempoayuda.=",{'content': '".$rowx["texto5ayudatabla"]."','pause_b': 2,'pause_a' : 0}";
  }
  echo("<script language=\"javascript\">Tscr_BUSCAR = [".$tempoayuda."];</script>");
  ?>
<script language="javascript" src="../include/scroll/scroll.js"></script>
<script language="javascript">var Tscr_LOOK0 = {
'size' : [190, 100],
's_i':'textogeneralaviso',
's_b':'textogeneralaviso',
'pa' : [150,80, 16, 16,,'../include/scroll/mpau.gif'],
're' : [150,80, 16, 16,,'../include/scroll/mres.gif'],
'nx' : [170,80, 16, 16,,'../include/scroll/mnxt.gif'],
'pr' : [130,80, 16, 16,,'../include/scroll/mprv.gif']
},
Tscr_BEHAVE0 = {
'auto'  : true,
'vertical' : true,
'speed' : 1,
'interval' : 50,
'hide_buttons' : true,
'zindex':5
};</script>
<TR><TD BGCOLOR=FF9933><SCRIPT LANGUAGE="JavaScript">new TScroll_init (Tscr_LOOK0, Tscr_BEHAVE0, Tscr_BUSCAR);</SCRIPT></td></tr>
<? } ?>
<tr><td  class="titulomenulateral"><b>Tablas de sistema</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=catablas.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Tablas de sistema\"></a></td>";
if($nivelusuario==0) $botones.="<td><a href=catablas.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Tablas de sistema\"></a></td>";
if($_SESSION["esframe_catablas_id"]<>0) $botones.="<td><a href=".$_SESSION["esframe_catablas_archivo"].".php?step=modify&id=".$_SESSION["esframe_catablas_id"]." target=_parent><img src=recursos/botonregresar.gif border=\"0\" alt=Regresar></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar="";
 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_103_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_103_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_103_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_103_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?>

</table></td>
<? } ?>
     <td class="spacerlateral"></td>
    </tr>
  </table>
  

<?} ?>
<?php  } ?>
<? if($step=="add" || $step=="modify")  { ?>

<? } ?>
</body>
</html>

