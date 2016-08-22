<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php"); 


$url_extra="";
if($_GET["esframe"]==1) 
{
	$_SESSION["esframe_casupervisores"]=1;
	$_SESSION["esframe_casupervisores_id"]=$_GET["registro"];	
	$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select ayudatabla from catablas where idtabla=".$_GET["itabla"]);
    while($rowx = mysqli_fetch_array($resultx)) $_SESSION["esframe_casupervisores_archivo"]=$rowx["ayudatabla"];
    
    $url_extra="&registro=".$_GET["registro"]."&itabla=".$_GET["itabla"]."&esframe=1&idcontrol=".$_GET["idcontrol"]."&edicioninterior=".$_GET["edicioninterior"]."&";
}	
else if($_GET["esframe"]==2) 
{
	$_SESSION["esframe_casupervisores"]=0;
	$_SESSION["esframe_casupervisores_id"]=0;
	$_SESSION["esframe_casupervisores_archivo"]="";
}

$titulo_pagina="Supervisores";
$status_campo="";

include("recursos/funciones.php"); 

$numerodetabla=501;
include("recursos/funciones_tabla.php"); 
$archivoactual="casupervisores.php";
$idcontrolinterno=generaidcontrol();
if($step=="modify") $_SESSION["id_casupervisores"]=$id;

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
<?
if($moditobusqueda=="especial") { foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }
else { foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); } }
if($step=="busqueda2" || $step=="busqueda3") 
{ 
  if($nivelusuario==2) 
  { 
    if(isset($ipersonal_supervisorb2) || isset($nombre_supervisorb2) || isset($usuario_supervisorb2) || isset($password_supervisorb2)) $error=9; 
  }
  if($nivelusuario==3) 
  { 
    if(isset($ipersonal_supervisorb2) || isset($nombre_supervisorb2) || isset($usuario_supervisorb2) || isset($password_supervisorb2)) $error=9; 
  }
  if($nivelusuario==4) 
  { 
    if($ipersonal_supervisorl1=="on" || $nombre_supervisorl1=="on" || $usuario_supervisorl1=="on" || $password_supervisorl1=="on") $error=9; 
    if(isset($ipersonal_supervisorb2) || isset($nombre_supervisorb2) || isset($usuario_supervisorb2) || isset($password_supervisorb2)) $error=9; 
  }
}
if($operacion=="modify") 
{ 
  if($nivelusuario==1) if(isset($_POST["ipersonal_supervisor"]) || isset($_POST["nombre_supervisor"]) || isset($_POST["usuario_supervisor"]) || isset($_POST["password_supervisor"])) $error=8; 
  if($nivelusuario==3) if(isset($_POST["ipersonal_supervisor"]) || isset($_POST["nombre_supervisor"]) || isset($_POST["usuario_supervisor"]) || isset($_POST["password_supervisor"])) $error=8; 
  if($nivelusuario==4) if(isset($_POST["ipersonal_supervisor"]) || isset($_POST["nombre_supervisor"]) || isset($_POST["usuario_supervisor"]) || isset($_POST["password_supervisor"])) $error=8; 
}
if($operacion=="add") 
{ 
  if($nivelusuario==1) if(isset($_POST["ipersonal_supervisor"]) || isset($_POST["nombre_supervisor"]) || isset($_POST["usuario_supervisor"]) || isset($_POST["password_supervisor"])) $error=7; 
  if($nivelusuario==3) if(isset($_POST["ipersonal_supervisor"]) || isset($_POST["nombre_supervisor"]) || isset($_POST["usuario_supervisor"]) || isset($_POST["password_supervisor"])) $error=7; 
  if($nivelusuario==4) if(isset($_POST["ipersonal_supervisor"]) || isset($_POST["nombre_supervisor"]) || isset($_POST["usuario_supervisor"]) || isset($_POST["password_supervisor"])) $error=7; 
}

if($error<>0) { $mensaje=guardareporte($error); $step=""; $operacion=""; } 
?>

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


<?
if($_SESSION["esframe_casupervisores"]==1)
{
  if($_SESSION["esframe_casupervisores_archivo"]=="")
  {
    if($step=="add")
    {
      $ipersonal_supervisor=$_SESSION["id_"];
    }
    if($step=="busqueda2" || $step=="busqueda3" || $step=="1")
    {
      $ipersonal_supervisorb1="=";
      $ipersonal_supervisorb2=$_SESSION["id_"];
    }
  }

}
?>



<head>

<title><? echo("Supervisores"); if(isset($titulobusqueda)) echo(". ".$titulobusqueda);?></title>
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
    if($_SESSION["esframe_casupervisores"]<>1)
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
      $sqltemporal.=construyesqltemporal("ipersonal_supervisor","",);
$sqltemporal.=construyesqltemporal("nombre_supervisor","'",);
$sqltemporal.=construyesqltemporal("usuario_supervisor","'",);
if($_POST["password_supervisor"]<>"") { 
$_POST["password_supervisor"]=md5($_POST["password_supervisor"]); $sqltemporal.=construyesqltemporal("password_supervisor","'",0); } 
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
	   if($nivelusuario==0) {	
      	
		  $sql = "INSERT INTO casupervisores SET " .$sqltemporal;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			$mensaje.="Se guardó correctamente el registro";
			$id=mysqli_insert_id($GLOBALS["enlaceDB"] );
			$idcontrolinterno=generaidcontrol();
			 $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=501,operacionseguimiento='2'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);		
			$_SESSION["id_casupervisores"]=$id;

            if($_GET["edicioninterior"]==1)
            {
            	$_SESSION["frame_interior_casupervisores"]="OK";
	            $_SESSION["frame_interior_".$archivoactual]="add";
	            echo("<script>parent.location.reload()</script>");
	            exit();
            }    
		  } 
		  else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="Ya existe un registro con esos datos<br>No se ha guardado el registro.";
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
		  $sql = "UPDATE casupervisores SET " .$sqltemporal. " WHERE ID=".$id;
		  if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		  if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		  {
			if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
			{  
			  $mensaje.="Se actualizó correctamente el registro";
			   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=501,operacionseguimiento='1'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
			  
              if($_GET["edicioninterior"]==1)
			      $_SESSION["frame_interior_casupervisores"]="OK";
			}
			else
			{
			  $mensaje.="No hubo cambios en el registro";
			  $modomensaje="NADA";
              if($_GET["edicioninterior"]==1)
	              $_SESSION["frame_interior_casupervisores"]="NADA";
			}  
        	if($_GET["edicioninterior"]==1)
            {
				echo("<script>parent.location.reload()</script>");
    	        exit();
			}
			  
		  } else 
		  {
			if(mysqli_errno($GLOBALS["enlaceDB"] )==1062) 
			{
			  $mensaje.="Ya existe un registro con esos datos<br>No se ha guardado el registro";
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
      else  if($nivelusuario==0 || $nivelusuario==10) {
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
       if($nivelusuario==0 || $nivelusuario==10) {
		$sql = "DELETE FROM casupervisores WHERE id=".$id;
		if($_SESSION["sesionmododepuracion"]=="SI") echo($sql);
		if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
		{
		  $mensaje.="Se eliminó correctamente el registro <a href=\"javascript:window.history.go(-2)
	;\" class=\"boton80\">Regresar</a>";
		   $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=501,operacionseguimiento='3'"; @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
		  
		  $step="busqueda";
		  $operacion="";
          if($_GET["edicioninterior"]==1)
          {
          	$_SESSION["frame_interior_casupervisores"]="BORRADO";
          	echo("<script>parent.location.reload()</script>");
          	exit();
          }     
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
  	
if($_GET["edicioninterior"]<>1) { 
?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina">
  <tr>    
    
    <td height="30" valign="middle" align="left" style="white-space:nowrap"><? if($ocultabotones<>1) { ?><? $linkx3="";$linkx2="";$linkx1="";$linkx="";
$idx3=0;$idx2=0;$idx1 =0;$idx=0;
if($step=="modify"){
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,ipersonal_supervisor FROM casupervisores where id=". $id);
$rowx = mysqli_fetch_array($resultx);
$linkx=" >> ".$rowx["ipersonal_supervisor"]." ".$rowx[""];
$idx=$rowx[""];
}
echo("<a href=casupervisores.php?sortfield=ipersonal_supervisor&step=1".$url_extra."><span class=titulo>Supervisores</span></a>".$linkx3.$linkx2.$linkx1.$linkx);?><? } else { ?><? if(isset($titulobusqueda)) echo($titulobusqueda." ");?><? } ?></td>
	<td align="left" width="100%" ><? if($ocultabotones<>1) { ?><? } else echo("<a href=\"javascript:self.parent.tb_remove();\"><img src=\"recursos/botoncerrar.gif\" border=\"0\"></a>"); ?></td>	
  </tr>
</table>
<? } 

  if($_SESSION["frame_interior_casupervisores"]=="OK")
  {
  	$mensaje="Se guardó correctamente el registro";
    $modomensaje="";
  }
  else if($_SESSION["frame_interior_casupervisores"]=="NADA")
  {
  	$mensaje="No hubo cambios en el registro";
    $modomensaje="NADA";
  }
  else if($_SESSION["frame_interior_casupervisores"]=="BORRADO")
  {
  	$mensaje="Se eliminó correctamente el registro";
    $modomensaje="NADA";
  }
  $_SESSION["frame_interior_casupervisores"]="";


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
   
<? if($step=="busqueda2" || $step=="busqueda3") 
{ 
if($_GET["edicioninterior"]<>1 && $mensaje=="") 
	echo("<span class=textogeneral><br></span>"); ?>

<table width=100% border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="spacerlateral"></td>
<td valign=top width=100%>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
  <tr> 
    <td width=100%><?
       if($step=="busqueda3" || $moditobusqueda=="especial") { 
$activol1="on"; $comparadorsearch="AND"; $sortfield="casupervisores.activo DESC,ipersonal_supervisor ASC"; $ordenamiento="";
$activob1="="; $activob2="1";
$ipersonal_supervisorl1="on"; 
$nombre_supervisorl1="on"; 
$usuario_supervisorl1="on"; 
$password_supervisorl1="on"; 
} 

$camposbuscadoslistadosearch="casupervisores.id";
cbusqueda1($activol1,"casupervisores","activo");
cbusqueda1($ipersonal_supervisorl1,"casupervisores","ipersonal_supervisor");
cbusqueda1($nombre_supervisorl1,"casupervisores","nombre_supervisor");
cbusqueda1($usuario_supervisorl1,"casupervisores","usuario_supervisor");
cbusqueda1($password_supervisorl1,"casupervisores","password_supervisor");
cbusqueda3($ipersonal_supervisorb1,$ipersonal_supervisorb2,"casupervisores","ipersonal_supervisor","","0","","");
cbusqueda3($nombre_supervisorb1,$nombre_supervisorb2,"casupervisores","nombre_supervisor","'","0","","");
cbusqueda3($usuario_supervisorb1,$usuario_supervisorb2,"casupervisores","usuario_supervisor","'","0","","");
cbusqueda3($password_supervisorb1,$password_supervisorb2,"casupervisores","password_supervisor","'","0","","");
cbusqueda3($activob1,$activob2,"casupervisores","activo","'","0","","");

	
	$rutinabusqueda=$camposbuscadoslistadosearch." from casupervisores ";
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
cbusqueda5($ipersonal_supervisorl1,"Usuario",": STR");
cbusqueda5($nombre_supervisorl1,"Nombre Supervisor",": STR");
cbusqueda5($usuario_supervisorl1,"Usuario",": STR");
cbusqueda5($password_supervisorl1,"Password",": STR");
 if($activol1=="on") { if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Activo', 'type' : STR 	}"; $totalcolumnas=$totalcolumnas+1; } if($tigracabeza<>"") $tigracabeza.=","; $tigracabeza=$tigracabeza."{'name' : 'Opciones'}"; $totalcolumnas=$totalcolumnas+1;  
?>
<script language="JavaScript">
function tigra_row_clck(marked_all, marked_one)
{
  if(marked_one!='')
  {
	    window.location.href='casupervisores.php?step=modify&id='+marked_one+'&'
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
cbusqueda4($ipersonal_supervisorl1,"casupervisores","ipersonal_supervisor","0","","");
cbusqueda4($nombre_supervisorl1,"casupervisores","nombre_supervisor","0","","");
cbusqueda4($usuario_supervisorl1,"casupervisores","usuario_supervisor","0","","");
cbusqueda4($password_supervisorl1,"casupervisores","password_supervisor","0","","");
 if($activol1=="on"){if($row["activo"]=="0")$tempoactivo="<font color=#ff0000><b>NO</B></font>";else $tempoactivo="<B>SI</B>";if($listadodecampossearchtigra<>""){$listadodecampossearchtigra.=",";}$listadodecampossearchtigra.="\"".$tempoactivo."\""; }
if($listadodecampossearchtigra<>"")  $listadodecampossearchtigra.=","; $listadodecampossearchtigra.="\"".$botonestigra."\"";
 if($listadodecampossearchtigra2<>"") $listadodecampossearchtigra2.=",";
$listadodecampossearchtigra2.="[".$listadodecampossearchtigra."]";
}
$listadodecampossearchtigra2 = str_replace( "\n", "<br>",$listadodecampossearchtigra2);
$listadodecampossearchtigra2 = str_replace(chr(13), "<br>",$listadodecampossearchtigra2);
$pietablasearchtigra="\"\"";
cbusqueda6($ipersonal_supervisorl1,$sumatoriaipersonal_supervisor,'');
cbusqueda6($nombre_supervisorl1,$sumatorianombre_supervisor,'');
cbusqueda6($usuario_supervisorl1,$sumatoriausuario_supervisor,'');
cbusqueda6($password_supervisorl1,$sumatoriapassword_supervisor,'');
$pietablasearchtigra.=",\"\"";

?>
<?php echo("var TABLE_CONTENT = [".$listadodecampossearchtigra2.",[".$pietablasearchtigra."]];"); ?></script>
<? if($num_rows>0) { ?><SCRIPT LANGUAGE="JavaScript"> new TTable(TABLE_CAPT, TABLE_CONTENT, TABLE_LOOK);	</SCRIPT><? } ?></td>
  </tr> 
   
   <tr><form name="form2" id="form2" method="post" action="excel/excelcasupervisores.php?step=busqueda2<?=$url_extra?>" enctype="multipart/form-data"><input name=activol1 type="hidden" value=<?=$activol1?> ><input name=activob1 type="hidden" value=<?=$activob1?> ><input name=activob2 type="hidden" value=<?=$activob2?> >
<input name=ipersonal_supervisorl1 type="hidden" value="<?=$ipersonal_supervisorl1?>" ><input name=ipersonal_supervisorb1 type="hidden" value="<?=$ipersonal_supervisorb1?>" ><input name=ipersonal_supervisorb2 type="hidden" value="<?=$ipersonal_supervisorb2?>" >
<input name=nombre_supervisorl1 type="hidden" value="<?=$nombre_supervisorl1?>" ><input name=nombre_supervisorb1 type="hidden" value="<?=$nombre_supervisorb1?>" ><input name=nombre_supervisorb2 type="hidden" value="<?=$nombre_supervisorb2?>" >
<input name=usuario_supervisorl1 type="hidden" value="<?=$usuario_supervisorl1?>" ><input name=usuario_supervisorb1 type="hidden" value="<?=$usuario_supervisorb1?>" ><input name=usuario_supervisorb2 type="hidden" value="<?=$usuario_supervisorb2?>" >
<input name=password_supervisorl1 type="hidden" value="<?=$password_supervisorl1?>" ><input name=password_supervisorb1 type="hidden" value="<?=$password_supervisorb1?>" ><input name=password_supervisorb2 type="hidden" value="<?=$password_supervisorb2?>" >
<input name=mostrarhijas type="hidden" value=<?=$mostrarhijas?> ><input name=comparadorsearch type="hidden" value="<?=$comparadorsearch?>" ><input name=sortfield type="hidden" value="<?=$sortfield?>" ><input name=ordenamiento type="hidden" value="<?=$ordenamiento?>" ><td class=titulointerior bgcolor="#ffffff" align=right><div align=right><? if($nivelusuario==0) {?><? if($num_rows>0) { ?><input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcasupervisores.php?step=busqueda2');"><? } ?><?} ?><? if($nivelusuario=="meminpinguin") {?><input class="textogeneral" type="button" value="Mensaje masivo" name=button2 onClick="toggle('maquinamensajes')"><?} ?></div></td></form></tr>
</table>
 </td><td width="5" rowspan="2"><img src="recursos/spacer.png" width="5" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=501 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
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
<tr><td  class="titulomenulateral"><b>Supervisores</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=casupervisores.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Supervisores\"></a></td>";
if($nivelusuario==0) $botones.="<td><a href=casupervisores.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Supervisores\"></a></td>";
if(($nivelusuario==0)) $botones.="<td><a href=\"casupervisores.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Supervisores\"></a></td>";
if($nivelusuario==0) if($step=="modify") $botones.="<td><a href=\"javascript:deleteRecord('casupervisores.php?sortfield=ipersonal_supervisor&step=2&operacion=delete&id=".$id."&idcontrol=".$idcontrolinterno.$url_extra."');\"><img src=\"recursos/botonborrar.gif\" border=\"0\" alt=\"Borrar Supervisores\"></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar="";
 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_501_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_501_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_501_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_501_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?>

</table></td>
 <td class="spacerlateral"></td></tr>
</table>
<?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; 
?>
<? 

$menupeque=2;
include("include/imenu_peque.php");
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
$ipersonal_supervisor=0;
$nombre_supervisor='';
$usuario_supervisor='';
$password_supervisor='';

$activo=1;
}  
else if($error_unique==1)
{
if(isset($_POST["ipersonal_supervisor"])) $ipersonal_supervisor=$_POST["ipersonal_supervisor"];
if(isset($_POST["nombre_supervisor"])) $nombre_supervisor=$_POST["nombre_supervisor"];
if(isset($_POST["usuario_supervisor"])) $usuario_supervisor=$_POST["usuario_supervisor"];
if(isset($_POST["password_supervisor"])) $password_supervisor=$_POST["password_supervisor"];

}
    if($step=="modify" && $error_unique==0)
	{
	  if($_SESSION["sesionmododepuracion"]=="SI") echo("SELECT * FROM casupervisores where id=". $id);
      $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM casupervisores where id=". $id);
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
$ipersonal_supervisor=$row["ipersonal_supervisor"];
$nombre_supervisor=$row["nombre_supervisor"];
$usuario_supervisor=$row["usuario_supervisor"];
$password_supervisor='';

       }
	 }	 
	 
  ?>

<? if($_GET["edicioninterior"]<>1 && $mensaje=="") { ?>
<span class=textogeneral><br></span>
<? } ?>

<? if($registrosencontrados>0) {?>

<? if($step=="modify") { ?>



<? include("status_validarjs.php"); ?>
<? } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
    <tr>
      <td class="spacerlateral"></td>
      <td width=100% valign=top>
       <?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; 
?>
      <?
     
       $menupeque=1;
		include("include/imenu_peque.php");
      
      ?>
      <div id="formulario" name="formulario">
	  
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
      <form name="form1" id="form1" onSubmit="return enviardatos('N');" method="post" action="casupervisores.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?><?=$url_extra?>" enctype="multipart/form-data">

    <tr> 
      
      <td valign="middle" width="91%" colspan=2>
              <div align="right">
                <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior"><? if($step=="add") echo("Agregando"); else echo("Editando"); ?></td>
                    <td><? if($ocultabotones<>1) { ?>					 <div align="right"> <? if($step<>"add") { ?>
                      
				       <? if($_GET["edicioninterior"]==1) {  if($nivelusuario==0 || $nivelusuario==10) {?><a href="javascript:deleteRecord('casupervisores.php?sortfield=ipersonal_supervisor&step=2&operacion=delete&id=<?=$id?><?=$url_extra?>');" class=textoboton>&nbsp;Borrar&nbsp;</a>&nbsp;&nbsp;<?} ?><? } ?>
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
     	
	
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_ipersonal_supervisor" name="t_ipersonal_supervisor">Usuario </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==2)) { ?><select name="ipersonal_supervisor" class=textogeneralform><option value="0" selected></option><?  leecampos("","","","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ipersonal_supervisor==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?><? if(($nivelusuario==10 || $nivelusuario==1 || $nivelusuario==3)) { ?><? $valor_mostrar=lee_registro("","","","",$ipersonal_supervisor,"");
if($valor_mostrar<>"") echo($valor_mostrar); else echo("No encontrado o no aplica");?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_nombre_supervisor" name="t_nombre_supervisor">Nombre Supervisor </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==2)) { ?><input type="text" name="nombre_supervisor" id="nombre_supervisor" value="<? echo(htmlspecialchars($nombre_supervisor)); ?>" size="45" maxlength="40" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==1 || $nivelusuario==3)) { ?><?=$nombre_supervisor?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_usuario_supervisor" name="t_usuario_supervisor">Usuario </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==2)) { ?><input type="text" name="usuario_supervisor" id="usuario_supervisor" value="<? echo(htmlspecialchars($usuario_supervisor)); ?>" size="17" maxlength="12" class="textogeneralform"><? } ?><? if(($nivelusuario==10 || $nivelusuario==1 || $nivelusuario==3)) { ?><?=$usuario_supervisor?><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle" id="t_password_supervisor" name="t_password_supervisor">Password </td><td valign="middle"><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==2)) { ?><input type="password" name="password_supervisor" id="password_supervisor" value="<?=$password_supervisor?>" size="37" maxlength="32" class=textogeneralform><? } ?><? if(($nivelusuario==10 || $nivelusuario==1 || $nivelusuario==3)) { ?>*****<? } ?></td></tr><? } ?> 
	<? $datostigra=""; ?><? if(($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==2)) { ?><? if($datostigra<>"") $datostigra.=","; $datostigra.="'ipersonal_supervisor':{'l':'Usuario','r': false,'f':function(n) {return n >= 0 && n < 1000000},'t':'t_ipersonal_supervisor'}";?><? } ?>
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
    <? if($nivelusuario==0) {?>
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
<? if($campopredeterminadotabla<>"" && isset($campopredeterminadotabla)) echo("<script>document.getElementById('".$campopredeterminadotabla."').focus();</script>"); ?>
	
    
	
	</form>
  </table>
  </div>
   <?   $boton_imprimibles=0; $boton_notas=0;  $boton_fotos=0;  $boton_archivos=0; $boton_idiomas=0; 
?>
  <?
 
  $menupeque=3;
include("include/imenu_peque.php");
?>
  
  </td>
     <? if($ocultabotones<>1) { ?> <? if($step=="modify") { ?><? } ?><td width="5" rowspan="2"><img src="recursos/spacer.png" width="5" height="0"></td><td width="100%" valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=501 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='1'");
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
<tr><td  class="titulomenulateral"><b>Supervisores</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=casupervisores.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Supervisores\"></a></td>";
if($nivelusuario==0) $botones.="<td><a href=casupervisores.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Supervisores\"></a></td>";
if(($nivelusuario==0)) $botones.="<td><a href=\"casupervisores.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Supervisores\"></a></td>";
if($nivelusuario==0) if($step=="modify") $botones.="<td><a href=\"javascript:deleteRecord('casupervisores.php?sortfield=ipersonal_supervisor&step=2&operacion=delete&id=".$id."&idcontrol=".$idcontrolinterno.$url_extra."');\"><img src=\"recursos/botonborrar.gif\" border=\"0\" alt=\"Borrar Supervisores\"></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"ubicacion_501_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('ubicacion_501_0')" class="textogeneralnegrita">
<img id="collapseimg_ubicacion_501_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Ubicación</b></a></td></tr><tbody id="collapseobj_ubicacion_501_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><table class=textogeneral cellpadding="0" cellspacing="0"><? 
        $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT id,ipersonal_supervisor,activo FROM casupervisores order by ipersonal_supervisor ASC");
        while ( $rowx = mysqli_fetch_array($resultx) )
        {
          $boldi=""; if($rowx["id"]==$id) $boldi=" bgcolor=#".$vsitioscolor1."";
          $clase=" class=textogeneral"; if($rowx[activo]==0) $clase=" class=textogeneralinactivo";
          echo("<tr".$boldi."><td colspan=\"2\"><a href=casupervisores.php?step=modify&id=".$rowx["id"].$url_extra.$clase.">".$rowx["ipersonal_supervisor"]."</a></td></tr>");
        } 
?>
</table></td></tr></tbody>
<? if($nivelusuario==0) { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"ubicacion_501_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('ubicacion_501_0')" class="textogeneralnegrita">
<img id="collapseimg_ubicacion_501_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b>Avanzadas</b></a></td></tr>
<tbody id="collapseobj_ubicacion_501_0" style="<?=$tempo?>">
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
      <td width=100%  valign=top><form name="form2" method="post" action="casupervisores.php?step=busqueda2&mensajemm=<?=$mensajemm?><?=$url_extra?>" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="bordeprincipal" align="center">
    <tr> 
      
	 
      <td valign="middle" width="91%" colspan=2>
	  <table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
        <tr>
          <td valign=middle class="titulointerior">B&uacute;squeda</td>
              <td class=textogeneral align="right"><? if($ocultabotones<>1) { ?> Ordenar<select class="textogeneralform" name=sortfield><option value="ipersonal_supervisor" selected>Usuario</option><option value="nombre_supervisor">Nombre Supervisor</option><option value="usuario_supervisor">Usuario</option><option value="password_supervisor">Password</option></select><select class="textogeneralform" name=ordenamiento><option value=DESC>DESC</OPTION><option value=ASC selected>ASC</OPTION></SELECT>
<input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('casupervisores.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');"><? } ?></td>
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
	
	
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) { ?><input type="checkbox" name="ipersonal_supervisorl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="ipersonal_supervisorb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><select name="ipersonal_supervisorb2" onChange="if(ipersonal_supervisorb1.selectedIndex==0) ipersonal_supervisorb1.selectedIndex=1" class=textogeneralform><option value="0" selected></option><?  leecampos("","","","",""," "); for ( $i=0; $i<=$registros-1; $i++) { echo("<option value=".$campos1[$i]); if($ipersonal_supervisor==$campos1[$i]) { echo(" selected"); } echo(">".$campos2[$i]."</option>"); } ?></select><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Nombre Supervisor</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) { ?><input type="checkbox" name="nombre_supervisorl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="nombre_supervisorb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="nombre_supervisorb2" value="" size="45" onKeyUp="revisainput('nombre_supervisorb1','nombre_supervisorb2');" maxlength="40" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Usuario</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) { ?><input type="checkbox" name="usuario_supervisorl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="usuario_supervisorb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="usuario_supervisorb2" value="" size="17" onKeyUp="revisainput('usuario_supervisorb1','usuario_supervisorb2');" maxlength="12" class=textogeneralform><? } ?></td></tr><? } ?>
<? if($nivelusuario<>11 && $nivelusuario<>4) { ?><tr bgcolor="#<?=$vsitioscolor5?>" ><td valign="middle">Password</td><td valign="middle"><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) { ?><input type="checkbox" name="password_supervisorl1" checked><? } ?><? if($nivelusuario==10 || $nivelusuario==0 || $nivelusuario==1) { ?><select name="password_supervisorb1" class=textogeneralform><option value="" selected></option><option value="=">igual</option><option value="&lt;&gt;">diferente</option><option value="LIKE">parecido</option><option value="&lt;">menor que</option><option value="&gt;">mayor que</option><option value="&lt;=">menor o igual que</option><option value="&gt;=">mayor o igual que</option></select><input type="text" name="password_supervisorb2" value="" size="37" onKeyUp="revisainput('password_supervisorb1','password_supervisorb2');" maxlength="32" class=textogeneralform><? } ?></td></tr><? } ?> 
	
	<? if($nivelusuario==0) {?>
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
      <div align="right"><? if($ocultabotones<>1) { ?><input class="textogeneral" type="button" value="Buscar" name=button1 onClick="return BusquedaNormal('casupervisores.php?step=busqueda2&mensajemmx=<?=$mensajemmx?>&boletinelectronicommx=<?=$boletinelectronicommx?><?=$url_extra?>');">
<? if($nivelusuario==0) {?>
<input class="textogeneral" type="button" value="Exportar a Excel" name=button2 onClick="return BusquedaExcel('excel/excelcasupervisores.php?step=busqueda2<?=$url_extra?>');">
<?} ?><? } ?></div>
      </td>
    </tr>
  </table></form></td><? if($ocultabotones<>1) { ?><td width="5" rowspan="2"><img src="recursos/spacer.png" width="5" height="0"></td><td valign="top" rowspan="2"><table class="bordelateral" cellspacing="1" cellpadding="5" bgcolor="#ffffff"><?
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select texto1ayudatabla,texto2ayudatabla,texto3ayudatabla,texto4ayudatabla,texto5ayudatabla from caayudatablas,catablas where catablas.idtabla=501 AND catablas.id=caayudatablas.idtablaayudatabla and caayudatablas.texto1ayudatabla<>'' and caayudatablas.operacionayudatabla='0'");
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
<tr><td  class="titulomenulateral"><b>Supervisores</b></td></tr><tr><td class="textogeneralmenulateral"><table class="textogeneral"><tr><? $botones=""; 
if($nivelusuario==0) $botones.="<td><a href=casupervisores.php?step=busqueda3".$url_extra."><img src=recursos/botonlistar.gif border=\"0\" alt=\"Listar Supervisores\"></a></td>";
if($nivelusuario==0) $botones.="<td><a href=casupervisores.php?step=busqueda".$url_extra."><img src=recursos/botonbuscar.gif border=\"0\" alt=\"Buscar Supervisores\"></a></td>";
if(($nivelusuario==0)) $botones.="<td><a href=\"casupervisores.php?step=add".$url_extra."\"><img src=recursos/botonagregar.gif border=\"0\" alt=\"Agregar Supervisores\"></a></td>";
if($nivelusuario==0) if($step=="modify") $botones.="<td><a href=\"javascript:deleteRecord('casupervisores.php?sortfield=ipersonal_supervisor&step=2&operacion=delete&id=".$id."&idcontrol=".$idcontrolinterno.$url_extra."');\"><img src=\"recursos/botonborrar.gif\" border=\"0\" alt=\"Borrar Supervisores\"></a></td>";
 if($botones<>"") echo("<td class=textogeneral align=right><b></b></td>".$botones);

 ?></tr></table></td></tr>
<? $menugeneraloprelacionbuscar="";
 if($menugeneraloprelacionbuscar<>"") { ?><tr><td class="titulomenulateral"><?  $tempo="display:none;"; $tempo2="colapsar_no"; if(strpos($_COOKIE["sistemaimagencolapsa"],"loprelacionbus_501_0")===FALSE) { $tempo=";"; $tempo2="colapsar"; }?>
<a href="#top" onClick="return abreocierracabeza('loprelacionbus_501_0')" class="textogeneralnegrita">
<img id="collapseimg_loprelacionbus_501_0" src="recursos/<?=$tempo2?>.gif" alt="" border="0"/> 
<b></b></a></td></tr><tbody id="collapseobj_loprelacionbus_501_0" style="<?=$tempo?>">
<tr><td class="textogeneralmenulateral"><?=$menugeneraloprelacionbuscar?></td></tr></tbody><? } ?>

</table></td>
<? } ?>
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
</body>
</html>

