<? 
  include("../include/connection.php"); 
  include("recursos/funciones.php"); 
?>

<head>
<title>SITIO ADMINISTRATIVO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="recursos/estilos.css" type="text/css">
<script type="text/javascript">
function isOpenFrame(nom){
   
       var pfc=top.frames[nom];
      if(!pfc) 
	  {	 	
	  location.href="index.php";       
	  }
  }

//isOpenFrame('topFrame');

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

document.onkeydown = function(){  
    if(window.event && window.event.keyCode == 116){ 
     window.event.keyCode = 505;  
    } 
    if(window.event && window.event.keyCode == 505){  
     return false;     
    }  
   }  
</script>

</head>
<BODY topmargin=0 LEFTMARGIN=0 TOMPARGIN=0 >
<br>

<?
  include("recursos/cabeza.inc");   
  session_start();
  include("recursos/inicializasesion.php");

  $ultimafechaentrada=date("Y-m-d"); 
  $ultimahoraentrada=date("H:i");
  if ( @mysqli_query($GLOBALS["enlaceDB"] ,"UPDATE caaccesos SET fechasalidaacceso='".$ultimafechaentrada."',horasalidaacceso='".$ultimahoraentrada."',hitsacceso=".$_SESSION["sesionhits"]. " WHERE ID=".$_SESSION["sesionidregistro"]) ) 
  {
    $mensaje="Se guardó un registro de la actividad realizada en esta sesión<br><b>Usuario:</b> ".$_SESSION['sesionnombre']."<br><b>Nivel:</b> ".$_SESSION['nivelusuario']."<br><b>Fecha entrada:</b> ".conviertedia($_SESSION['sesionfechaentrada'])." ".$_SESSION['sesionhoraentrada']."<br><b>Fecha salida:</b> ".conviertedia($ultimafechaentrada)." ".$ultimahoraentrada."<br><b>Desde IP:</b> ".$_SESSION['sesiondireccionip']."<br><b>Consultas: </b>".$_SESSION['sesionhits'];			
  } 
  else 
	$mensaje="Ocurrió un error al guardar el registro";

  $_SESSION = array();

  if (isset($_COOKIE[session_name()])) 
  {
    setcookie(session_name(), '', time()-42000, '/');
  }

  session_destroy();
?> <br>
  <table width="974" cellspacing="1" cellpadding="4" align="center"  bgcolor="#ffffff">
    <tr> 
      <td class="titulopagina">Logout 
        exitoso</td>  
  </tr>
  <tr> 
      
    <td class="textogeneral" height="23" bgcolor="#<?=$vsitioscolor6?>" > 
      <div align="left">Gracias por utilizar nuestro sistema<br>
        <br>
        <?=$mensaje?>
      </div>
    </td> 
      
  </tr>
  <tr> 
      <td class="textogeneral" bgcolor="#<?=$vsitioscolor6?>" > 
        
      <div align="center"><a href="manejadorlogin.php?step=1" class="boton120">Entrar otra vez</a></div>
      </td>
     
  </tr>

   
</table> 
  <br>
<?
   $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT catablas.nombretabla,caseguimiento.registroseguimiento,caseguimiento.horaseguimiento,caseguimiento.operacionseguimiento from caseguimiento LEFT JOIN causuarios ON caseguimiento.idusuarioseguimiento=causuarios.id LEFT JOIN caaccesos ON caseguimiento.idaccesoseguimiento=caaccesos.id LEFT JOIN catablas ON caseguimiento.tablaseguimiento=catablas.idtabla where caseguimiento.idaccesoseguimiento = ".$sesionidregistro." order by horaseguimiento DESC ");
   
  if(mysqli_num_rows($result)>0)
  {
?>  
  <table width="974" cellspacing="1" cellpadding="0" align="center"  bgcolor="#ffffff" >
    <tr>
      <td width="30"  class="titulopagina">Resumen</td>
    </tr>
    <tr>
      <td class=titulointerno><table border="0" cellspacing="0" cellpadding="0" width=100% bgcolor="#<?=$vsitioscolor2?>">
          <tr valign="middle">
            
            <? $totalcolumnas=1;
echo("<td valign=middle><b class=cabezas>Tabla afectada</b></td>"); $totalcolumnas=$totalcolumnas+1;
echo("<td valign=middle><b class=cabezas>Registro afectado</b></td>"); $totalcolumnas=$totalcolumnas+1;
echo("<td valign=middle><b class=cabezas>Hora de la operaci&oacute;n</b></td>"); $totalcolumnas=$totalcolumnas+1;
echo("<td valign=middle><b class=cabezas>Operaci&oacute;n realizada</b></td>"); $totalcolumnas=$totalcolumnas+1; 
?>
          </tr>
          <?php
   
    
	 $numregistros=4;
	 $color3=$vsitioscolor3;
 	 $color4=$vsitioscolor4;
     while ( $row = mysqli_fetch_array($result) )
	 {
	   if($numregistros==3) { $numregistros=4; $colorlinea=$color4; }
	   else { $numregistros=3;  $colorlinea=$color3; }
	    
	 ?>
          <tr valign="top" class="textogeneral" bgcolor=#<?=$colorlinea?>>
            
            <?
echo("<td>".$row["nombretabla"]."</td>"); 
 echo("<td>".$row["registroseguimiento"]."</td>");
 echo("<td>".$row["horaseguimiento"]."</td>");
 echo("<td>"); if($row["operacionseguimiento"]=="0") $tempooperacionseguimiento="Consulta";if($row["operacionseguimiento"]=="1") $tempooperacionseguimiento="Modificaci&oacute;n";if($row["operacionseguimiento"]=="2") $tempooperacionseguimiento="Alta";if($row["operacionseguimiento"]=="3") $tempooperacionseguimiento="Borrado"; echo($tempooperacionseguimiento);echo("</td>");?>

          </tr>
          <?php  }?>
          
      </table></td>
    </tr>
</table>
  <br>
  
<? } ?>
  

<br>

</body>
