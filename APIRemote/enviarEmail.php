<?
//error_reporting(E_ALL);
session_start();
include("../include/connection.php");
$API_folder="../API/";
include_once($API_folder."est.php");
include_once($API_folder."enviarNotificacion.php");

$nombre["emailcliente"]="imagen@imagencentral.com";
$nombre["nombrecliente"]="Juan Pérez";
$nombre["celularcliente"]="Celular";
$idest=30;
$idencuesta=120;
$encuestamincalest=6;
$calificaTotal=5;
$_SESSION["logged"]->master=18;

$est=est_lee(array("campos"=>"encuestamincalest","sql_extra"=>"id=".$idest)); // no importa si esta activo o no
$encuestamincalest=$est[0]->encuestamincalest;

if($calificaTotal<=$encuestamincalest)
	enviaAlertas($encuestamincalest,$idencuesta,$nombre["nombrecliente"],$nombre["emailcliente"],$nombre["celularcliente"],$idest,$_SESSION["logged"]->master,"Anastasia Polanco");
?>