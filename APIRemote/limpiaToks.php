<?
include("../include/connection.php");
$newTime = strtotime('-60 minutes');
$fecha=date('Y-m-d H:i:s', $newTime);
$sql="delete from toks where fecha <= '".$fecha."'";
@mysqli_query($GLOBALS["enlaceDB"] ,$sql);
?>