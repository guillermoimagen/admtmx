<?php

function haceCarpetas($folder)
{
	if (!file_exists($folder)) {
		mkdir($folder, 0777, true);
	}
}		

function cleanString($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.
}

function subeFotoMaster($cfoto,$tablaorigen,$registroorigen,$master,$admin)
{
	global $htmlImagen,$htmlName;
	$ds=DIRECTORY_SEPARATOR;
	$carpetacfoto="";
	if($cfoto>0)
	{
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select identificadorcfoto,dimensionescfotos,compresioncfotos,nombrescfotos,typescfotos,archivospermitidoscfoto from cfotos where id=".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$cfoto));
		while($row=mysqli_fetch_object($res))
		{
			$typescfotos=explode(",",$row->typescfotos);
			$types2cfotos=explode(",",$row->archivospermitidoscfoto);
			$carpetacfoto=$ds.$row->	identificadorcfoto;
			$dimensionescfotosArreglo=explode(',', $row->dimensionescfotos);
			$compresioncfotosArreglo=explode(',', $row->compresioncfotos);
			$nombrescfotosArreglo=explode(',', $row->nombrescfotos);
		}
	}
	$ext=" ".sizeof($dimensionescfotosArreglo)." ".sizeof($compresioncfotosArreglo)." ".sizeof($nombrescfotosArreglo)."/".$cfoto;
	if(sizeof($dimensionescfotosArreglo)>0 && sizeof($dimensionescfotosArreglo)==sizeof($compresioncfotosArreglo) && sizeof($compresioncfotosArreglo)==sizeof($nombrescfotosArreglo))
	{
		$itablaorigen=0;
		$carpetatablaorigen="";
		$campotabla="";
		$ayudatabla="";
		if($admin) // es de admin
		{
			$itablaorigen=$tablaorigen;
			$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select idtabla,ayudatabla,campotabla from catablas where idtabla=".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$tablaorigen));
			while($row=mysqli_fetch_object($res))
			{
				$carpetatablaorigen=$ds.$row->ayudatabla;
				$tablaorigen=$row->ayudatabla;
				$campotabla=$row->campotabla;
				$ayudatabla=$row->ayudatabla;
			}
		}
		else if($tablaorigen<>"") 
		{
			$carpetatablaorigen=$ds.$tablaorigen;
			$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select idtabla,ayudatabla,campotabla from catablas where ayudatabla='".$tablaorigen."'");
			while($row=mysqli_fetch_object($res))
			{
				$itablaorigen=$row->	idtabla;
				$campotabla=$row->campotabla;
				$ayudatabla=$row->ayudatabla;
			}
		}
		
		$extraNombreFolder="";
		if($ayudatabla<>"" && $campotabla<>"")
		{
			$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select ".$campotabla." from ".$ayudatabla." where id=".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$registroorigen));
			while($row=mysqli_fetch_array($res))
			{
				if($row[$campotabla]<>"")
					$extraNombreFolder=$ds.substr(cleanString($row[$campotabla]),0,10);
			}
		}
		
		$storeFolder="u".$ds.$master.$carpetatablaorigen.$extraNombreFolder;
		if(!empty($_FILES) || (isset($htmlName) && $htmlName<>"")) 
		{ 	
			if(isset($htmlName) && $htmlName<>"")
			{
				$nombreArchivo=$htmlName;
				$estructuraArchivo=$htmlImagen;
			}
			else
			{
				$fileCampo="imagen";
				if($admin) $fileCampo="file";
				$nombreArchivo=$_FILES[$fileCampo]['name'];
				$estructuraArchivo=$_FILES[$fileCampo];
				
				if (!in_array($_FILES[$fileCampo]['type'], $typescfotos)) 
					exit();
			}
			// $nombreArchivo=htmlentitiesMemoStrong($nombreArchivo);
			$partesArchivo=explode(".",$nombreArchivo);
			$extension=$partesArchivo[sizeof($partesArchivo)-1];
			if (!in_array($extension, $types2cfotos)) 
					exit();
			$nombreArchivoFinal=substr($nombreArchivo,0,strlen($nombreArchivo)-strlen($extension)-1);
			$nombreArchivoFinal=substr($nombreArchivoFinal,0,20).".".$extension;		
			$targetPath=dirname( __FILE__ ) . $ds. $storeFolder . $ds;
			$targetPath=str_replace("APIRemote/","recursos/",$targetPath);
			haceCarpetas($targetPath."stock/");		
			$name = rand(0,100000)."_".preg_replace("/[^A-Z0-9._-]/i", "_", $nombreArchivoFinal); 
			$targetFile=$targetPath. $nombreArchivo;	
			//
			ini_set('memory_limit', '64M');
			// miniatura
			resizeImage($estructuraArchivo, $targetPath, $name, 100, 100, 60); 
			
			for($i=0; $i<=sizeof($dimensionescfotosArreglo)-1; $i++)
			{
				$dimensiones=explode('x', $dimensionescfotosArreglo[$i]);
				resizeImage($estructuraArchivo, $targetPath . 'stock' . $ds, genera_imagen_api2($name, $nombrescfotosArreglo[$i]), $dimensiones[0], $dimensiones[1], $compresioncfotosArreglo[$i]); 
			}
			
			// aqui validaremos si tengo todas las imagenes
			if($itablaorigen=="" or !isset($itablaorigen))
				$itablaorigen=0;
			if($registroorigen=="" or !isset($registroorigen))
				$registroorigen=0;
			
			$iusuariofoto=0;
			if($master==0) // es admin
			{
				$iusuariofoto=$_SESSION["sesionid"];	
			}
			$sql="insert into fotos set itablafoto=".$itablaorigen.",registrofoto=".$registroorigen.",icfotofoto=".$cfoto.", fechafoto='".date("Y-m-d")."', archivofoto='".$storeFolder.$ds.$name."', ordenfoto=0, titulofoto='', descripcionfoto='', iusuariofoto=".$iusuariofoto.", iusuariopublicofoto=".$master;
			
			@mysqli_query($GLOBALS["enlaceDB"] ,$sql);	
			$respuesta->error="";		
			$respuesta->archivofoto=$storeFolder.$ds.$name;		
			$respuesta->idreal=mysqli_insert_id($GLOBALS["enlaceDB"] );		
			$respuesta->activo=1;
			@mysqli_query($GLOBALS["enlaceDB"] ,"update usuarios set ultimaoperacionusuario='".date("Y-m-d h:i:s")."' where id=".(int)$_SESSION["logged"]->id." limit 1");

			unlink($_FILES[$fileCampo]['name']);	
			return $respuesta;
		} 
		else
		{
			$respuesta->error="No hay imágenes";
			return $respuesta;
		}
	}
	else
	{
		$respuesta->error="Debes subir la foto a una categoría ".$ext;
		return $respuesta;
	}
}

function resizeImage($imgObject, $savePath, $imgName, $imgMaxWidth, $imgMaxHeight, $imgQuality)
{
	global $htmlName;
	
	if(isset($htmlName) && $htmlName<>"")
	{
		list($imgWidth, $imgHeight, $imgType) = getimagesizefromstring($imgObject);  //atrapar los datos de la imagen
	}
	else
	{
		$estructuraArchivo=$imgObject['tmp_name'];
	    list($imgWidth, $imgHeight, $imgType) = getimagesize($imgObject['tmp_name']);  //atrapar los datos de la imagen
	}
	if($imgWidth==0 || $imgHeight==0) { exit(); die(); }
	//separar las dimensiones nuevas de la foto
	$tamano=explode('x', $maxSize);
	
	//crear la fuente de acuerdo al tipo de imagen
	if(isset($htmlName) && $htmlName<>"")
	{
		$source = imagecreatefromstring($imgObject);
		//$image = imagecreatefromstring($imgObject);
	}
	else
	{
		if($imgType==IMAGETYPE_JPEG) {
			$source = imagecreatefromjpeg($estructuraArchivo);
		}
		if($imgType==IMAGETYPE_PNG) {
			$source = imagecreatefrompng($estructuraArchivo);
		}
		if($imgType==IMAGETYPE_GIF) {
			$source = imagecreatefromgif($estructuraArchivo);
		}
		
	}
	
	if($imgWidth>$imgHeight) { //si es mas ancha que alta
		$imgMaxHeight=$imgMaxWidth*$imgHeight/$imgWidth;
	} else { //si es mas alta que ancha
		$imgMaxWidth=$imgMaxHeight*$imgWidth/$imgHeight;
	}
	
    $image_p = imagecreatetruecolor($imgMaxWidth, $imgMaxHeight);
	
	//crear la imagen de acuerdo al tipo de imagen
	if(isset($htmlName) && $htmlName<>"")
	{
	
		/*if($imgType==IMAGETYPE_JPEG) {
			$image = imagecreatefromjpeg($estructuraArchivo);
		}
		if($imgType==IMAGETYPE_PNG) {
			$image = imagecreatefrompng($estructuraArchivo);
		}
		if($imgType==IMAGETYPE_GIF) {
			$image = imagecreatefromgif($estructuraArchivo);
		}*/
	
		
	}
	if($imgType==IMAGETYPE_PNG) {
			//crear la transparencia de los png
			imagealphablending($image_p, false);
			$color=imagecolorallocatealpha($image_p, 0, 0, 0, 127);
			imagefill($image_p, 0, 0, $color);
			imagesavealpha($image_p, true);
		}
    imagecopyresampled($image_p, $source, 0, 0, 0, 0, $imgMaxWidth, $imgMaxHeight, $imgWidth, $imgHeight);
	
	//salvar la imagen
	if($imgType==IMAGETYPE_JPEG) {
		imagejpeg($image_p, $savePath . $imgName, $imgQuality);
	}
	if($imgType==IMAGETYPE_PNG) {
		imagepng($image_p, $savePath . $imgName);
	}
	if($imgType==IMAGETYPE_GIF) {
		imagegif($image_p, $savePath . $imgName, $imgQuality);
	}
	
	//eliminar los archivos temporales
    unset($imgObject);
    unset($source);
    unset($image_p);
    unset($image);
	
} //termina funcion resizeImage
?>