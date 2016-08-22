<?
include("include/connection.php");
$API_folder="API/";
include("API/actualizacionFunciones.php");
enviarConfirmacionPago((int)$_GET["idreal"],true);
?>