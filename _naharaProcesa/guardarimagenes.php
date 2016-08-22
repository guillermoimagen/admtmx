<?php
session_start();
include("recursos/entrada.php"); 
include("recursos/xss_var.php");

include_once '../API/funciones_API.php';
include_once '../include/connection.php';
include_once '../APIRemote/subirFotoFunciones.php';

if(!empty($_FILES)) { //para guardar las fotos
subeFotoMaster((int)$_GET['cfoto'],(int)$_GET['itabla'],(int)$_GET['registro'],0,true);
}
else{ //para traer las fotos que ya estan en el servidor                                              
    
	$sqlActivo=@mysqli_query($GLOBALS["enlaceDB"] ,'SELECT activo, archivofoto,ordenfoto FROM fotos WHERE icfotofoto=' . (int)$_GET['cfoto'].' and itablafoto=' . (int)$_GET['itabla'] . ' AND registrofoto=' . (int)$_GET['registro'] ." order by ordenfoto asc");
	while($row=mysqli_fetch_array($sqlActivo))
	{
		$obj['activo']=$row['activo'];
		$obj['orden']=$row['ordenfoto']; 
		$obj['name']=$row['archivofoto']; 
		$obj['size']=0;
		$result[]=$obj;
	}
				
    header('Content-type: text/json');
    header('Content-type: application/json');
    echo json_encode($result);
}
?>