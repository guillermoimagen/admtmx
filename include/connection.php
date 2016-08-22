<?php
header('Content-Type: text/html; charset=iso-8859-1');
session_start();
				

date_default_timezone_set("Mexico/General");
$GLOBALS["enlaceDB"] = mysqli_connect("dev-mysql.alcanciadigitalteleton.mx", "teletondev", "KSue2Ue8gK", "adtmx");

if (!$GLOBALS["enlaceDB"] ) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// cambiamos la zona horaria de NMysql 
$res=mysqli_query($GLOBALS["enlaceDB"] ,"SET time_zone = '".date('P')."';");
$dominioSistema="http://www.alcanciadigitalteleton.mx/";
$dosIdiomas=false;
$titleBase="Alcanc&iacute;a Digital Telet&oacute;n";
$moneda="MXN";
$paisSistema="1";

// AJUSTAR ESTAS VRAIBLES A MANO
$tienesitios="si";
$tieneidiomas="si";

$_SESSION["sesionmododepuracion"]=$_GET["mododepuracion"];
$vsitioscolor1="ffffff";
$vsitioscolor2="aaaaaa";
$vsitioscolor3="D4E6F6";
$vsitioscolor4="DCEFFF";
$vsitioscolor5="D4E6F6";
$vsitioscolor6="DCEFFF";
$vsitioscolor7="ff0000";
$colorencabezado="cccccc";

$colores["error"]="FFA6A6";
$colores["warning"]="FFEA93";
$colores["ok"]="BAE4BA";
$colores["5"]="cccccc";
$colores["6"]="dddddd";

$vsitioscolor2b="3B0B0B";
$vsitioscolor5b="8A0808";
$vsitioscolor6b="9D1C22";

$vsitioscolor7b="0E470F";
?>