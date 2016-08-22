<?php
//incluir la API para hacer los nombres de los archivos a borrar

include("recursos/entrada.php"); 
include("recursos/xss_var.php");
include_once '../API/funciones_API.php';
include_once '../include/connection.php';

//checar que pedido es
if($_POST['pedido']=='borraimagen') { //para borrar un archivo
	
	//borar la miniatura
	unlink($_POST['folder'] . '/' . $_POST['file']);
	//borrar las imagenes de la carpeta superior
	unlink($_POST['folder'] . '/stock/' . genera_imagen_api($_POST['file'], '_movLNormal'));
	unlink($_POST['folder'] . '/stock/' . genera_imagen_api($_POST['file'], '_movLM'));
	unlink($_POST['folder'] . '/stock/' . genera_imagen_api($_POST['file'], '_movHNormal'));
	unlink($_POST['folder'] . '/stock/' . genera_imagen_api($_POST['file'], '_movHMini'));
	//taer la id de la foto
	$sql=@mysqli_query($GLOBALS["enlaceDB"] ,'SELECT id FROM fotos WHERE archivofoto="' . str_replace('../recursos/', '', $_POST['folder']) . '/' . $_POST['file'] . '" AND itablafoto=' . $_POST['tabla'] . ' AND registrofoto=' . $_POST['registro']);
	$foto=mysqli_fetch_array($sql, MYSQLI_ASSOC);
	//borrar la referencia
	@mysqli_query($GLOBALS["enlaceDB"] ,'DELETE FROM fotos WHERE id=' . $foto['id']);
	//borrar en otros idiomas
	@mysqli_query($GLOBALS["enlaceDB"] ,'DELETE FROM fotos_i WHERE iregistro=' . $foto['id']);
	
}

if($_POST['pedido']=='borraarchivo') {
	//borar el archivo
	unlink($_POST['folder'] . '/' . $_POST['file']);
}

if($_POST['pedido']=='actualiza') { //para actualizar la informacion de una foto

	//decodificar los datos del jason
	$datos=json_decode($_POST['datosjson']);
	
	//actualizar en espanol
	$sql=mysqli_query($GLOBALS["enlaceDB"] ,'UPDATE fotos SET titulofoto="' . utf8_decode($_POST['titulo']) . '", descripcionfoto="' . utf8_decode($_POST['comentarios']) . '", ordenfoto=' . $_POST['orden'] . ', activo=' . $_POST['activo'] . ' WHERE id=' . $_POST['id']);
	
	
}

?>