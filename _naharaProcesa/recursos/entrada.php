<? 
session_start();
if (!isset($_SESSION["sesionusername"])) 
{
  header("Location: manejador_redirecciona.php?modo=manejadorlogin&urlOrigen=".urlencode($_SERVER['REQUEST_URI']));
  exit;
}
else if($_SESSION["sitioactual"]<>"UEXPLORE_CITY")
{
  header("Location: manejador_redirecciona.php?modo=manejadorlogout");
  exit;
}
else 
{
 $colorencabezado="cccccc";  
  $_SESSION["sesionhits"]=$_SESSION["sesionhits"]+1;
$encabezadousuario2="<a href='cambiousuarios.php?step=modify' title='cambiar contraseña' class='botoncontrasena'></a>";

  if($_SESSION["nivelusuario"]==0)
{
	$encabezadousuario2.="<a href='configuraciones.php' title='configuración' class='botonconfiguracion'></a>";
}	  
  
   $encabezadousuario2.="<a href='manejadorlogout.php' title='salir' class='botonsalir'></a><br>
  <b>Usuario:</b> ".$_SESSION["sesionnombre"]."&nbsp;<b>".$_SESSION["nombreciudad"]."</b><br>".$_SESSION["sesiondireccionip"]."&nbsp;&nbsp;<b>Consultas: </b>".$_SESSION["sesionhits"]."";
	 $encabezadousuario="";	

}
?>
