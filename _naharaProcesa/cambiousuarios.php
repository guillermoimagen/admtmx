<? 
include("recursos/entrada.php"); 
include("recursos/xss_var.php");
  include("recursos/inicializasesion.php");
  include("../include/connection.php"); 
  include("recursos/funciones.php"); 
?>

<html>
<link rel="stylesheet" href="recursos/estilos.css" type="text/css">
<script type="text/javascript" src="../include/validator.js"></script>

<? 
	$error=0;
	$numerodetabla=100;
	$mensaje=""; 
	$fechahoy=date("Y-m-d");      // lee la fecha
	$horaactual=date("H:i");
	$diahoy=date("d");
	$meshoy=date("m");
	$anohoy=date("Y");
	$idcontrolinterno=generaidcontrol();
	$registrosencontrados=1;
?>
<head>
<title>Cambiar información personal</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">

</head>
<BODY topmargin="0" leftmargin="0">
<? 
  echo($encabezadousuario);
  include("recursos/cabeza.inc"); 
  include("menu.php"); 
  include("menu2.php"); 
 
  if($operacion=="modify")  
  {
    if(strlen($_POST["passwordusuario"])<5)
	{
	  $operacion="";
	  $step="modify";    
      $mensaje.="La longitud mínima del password debe ser 5 caracteres.<br>No hubo cambios en tu información personal";		  
      $mensajecompleto=$entradamensajeerror.$mensaje.$salidamensaje;
	}  
	else if($_POST["passwordusuario"]<>$_POST["passwordusuario2"])
	{
      $operacion="";
	  $step="modify";    
      $mensaje.="La confirmación del password no coincide con el propuesto.<br>No hubo cambios en tu información personal";		  
      $mensajecompleto=$entradamensajeerror.$mensaje.$salidamensaje;
	}
  }
  if($operacion=="modify") 
  {   
    if($_POST["passwordusuario"]<>"") $sqltemporal.="passwordusuario='".md5($_POST["passwordusuario"])."'"; 
    
		  
	$sql = "UPDATE causuarios SET " .$sqltemporal. " WHERE ID=".$sesionid;
    if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
	{
	  if(mysqli_affected_rows($GLOBALS["enlaceDB"] )>0)
	  {	
          $mensaje.="Se actualizó correctamente tu información personal.";
		  $mensajecompleto=$entradamensaje.$mensaje.$salidamensaje;
		  $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$sesionid.",tablaseguimiento=100,operacionseguimiento='1'"; 
		  @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
   	  }
  	  else
	  {	    
		$mensaje.="No hubo cambios en tu información personal";		  
		$mensajecompleto=$entradamensajenada.$mensaje.$salidamensaje;
	  }	
    } 
	else 
	{
      $mensaje.="Ocurrió un error al guardar el registro: " . mysqli_error($GLOBALS["enlaceDB"] );	    
	  $mensajecompleto=$entradamensajeerror.$mensaje.$salidamensaje;
    }  
  }  
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina">
  <tr>
   <td>Actualiza tu información personal.</td>	
  </tr>
</table>
<? 
  if($mensajecompleto<>"") echo($mensajecompleto); 
  if($step=="modify")
  {
    $result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT * FROM causuarios where id=". $sesionid);
    if (!$result) 
    {
      echo("<p>Ocurrió un error al buscar el registro: " . mysqli_error($GLOBALS["enlaceDB"] ) . "</p>");
      exit();
    }  
	$registrosencontrados = mysqli_num_rows($result);
    while ( $row = mysqli_fetch_array($result) ) 
	{
      
      $email1usuario=$row["emailusuario"];
      $telefono1usaurio=$row["telefonousuario"];
	  
	  $sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$sesionid.",tablaseguimiento=100,operacionseguimiento='0'"; 
	  
	  @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
    }
	
	 
  ?>


<span class="textogeneral"><br></span>

<? 
if($registrosencontrados>0) 
{
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="spacerlateral"></td>
      <td width="100%" valign="top">
	  <form name="form1" onSubmit="return v.exec()" method="post" action="cambiousuarios.php?step=modify&operacion=<?=$step?>&id=<?=$id?>&sortfield=<?=$sortfield?>" enctype="multipart/form-data">
	    <table width="100%" cellspacing="4" cellpadding="0" class="bordeprincipal">
          <tr>
            <td valign="middle" width="100%"><table width="100%" class="titulointerior" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="titulointerior">Usuario:
                    <?=$sesionnombre?></td>
                  <td align="right"><input class=textogeneral type="submit" name="Submit" value="Guardar">                  </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#<?=$vsitioscolor5?>"><div align="center" id="error_form1" style="display: block;"></div></td>
          </tr>
          <input name="idcontrol" type="hidden" value="<?=$idcontrolinterno?>">
  <tr>
  <td>
    <table class="textogeneraltablaform"  cellpadding="4" cellspacing="2">
      <tr bgcolor="#<?=$vsitioscolor5?>" >
      <td valign="middle" id="t_passwordusuario">Password</td>
      <td valign="middle"><input type="password" name="passwordusuario" value="" size="25" maxlength="20" class=textogeneralform></td>
    
      <td valign="middle" id="t_passwordusuario">Confirma Password</td>
      <td valign="middle"><input type="password" name="passwordusuario2" value="" size="25" maxlength="20" class=textogeneralform></td>
       </tr>
    

  </table></td>
  
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
  <tr>
    <td valign="middle" bgcolor="#<?=$vsitioscolor2?>" class="titulointerior" ><table width="100%"  cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><input class=textogeneral type="submit" name="Submit2" value="Guardar">        </td>
      </tr>
    </table></td>
  </tr>
        </table>
	  </form></td>
    <td width=10 rowspan=2><img width=10 height=0></td><td width=100% valign=top rowspan=2><TABLE CLASS="bordelateral" cellspacing=1 cellpadding=5>

<tr>
  <td class="titulomenulateral">Instrucciones</td>
</tr><tr>
  <td class=textogeneral bgcolor=#<?=$vsitioscolor4?>>Actualiza tu informaci&oacute;n personal. Se actualizar&aacute; tu informaci&oacute;n en la base de datos y se crear&aacute; un registro de las modificaciones con fecha y hora. </td>
</tr>
</table></td>

	  <td  class="spacerlateral"></td>
    </tr>
</table>
<?php 
} 

  else echo($entradamensaje."El registro buscado no ha sido encontrado.<br>&nbsp;&nbsp;&nbsp;Es probable que haya sido eliminado, o bien que nunca haya existido.<BR>&nbsp;&nbsp;&nbsp;Si crees que es un error, repórtalo al administrador del sistema".$salidamensaje);
}

  ?>
</body>
</html>

