<?php
/**
 * @class Image
 * @brief Clase que define métodos principales para el tratamiendo de imágenes en servidor.
 */
final class IC_Image
{
	public static function makeDirectory($folder){
		if(!file_exists($folder)){
    		mkdir($folder, 0777, true);
		}
		if(!file_exists($folder . '/fotos')){
    		mkdir($folder . '/fotos', 0777, true);
		}
		if(!file_exists($folder . '/fotos/stock')){
    		mkdir($folder . '/fotos/stock', 0777, true);
		}
	}

	public static function formatLink($url){
		$url = strtr($url,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ$','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUYs');
		$url = str_replace(' ', '_', $url);
		$url = str_replace(',', '_', $url);
		$url = str_replace('.', '_', $url);
		$url = str_replace('-', '_', $url);
		//$stripAccents=str_replace(array('.', ',', '-', '?', '¿', '!', '¡', '', '`', "'"), '' , $stripAccents);
		$url = preg_replace('/[^\w]/', '', $url);
		//$stripAccents = preg_replace('/[0-9]+/', '', $stripAccents);
		$url = strtolower($url);

		return $url;
	}

	public static function resizeImageWithImagick($imgObject, $savePath, $imgName, $imgMaxWidth, $imgMaxHeight, $imgQuality){
		$image = new Imagick($imgObject['tmp_name']);

		$image->thumbnailImage($imgMaxWidth, $imgMaxHeight, true);
		$image->writeImage($savePath . $imgName);
	}

	public static function resizeImage($imgObject, $savePath, $imgName, $imgMaxWidth, $imgMaxHeight, $imgQuality){
		list($imgWidth, $imgHeight, $imgType) = getimagesize($imgObject['tmp_name']);  //atrapar los datos de la imagen

		//separar las dimensiones nuevas de la foto
		//$tamano=explode('x', $maxSize);

		//crear la fuente de acuerdo al tipo de imagen
		if($imgType==IMAGETYPE_JPEG)
			$source = imagecreatefromjpeg($imgObject['tmp_name']);
		if($imgType==IMAGETYPE_PNG)
			$source = imagecreatefrompng($imgObject['tmp_name']);
		if($imgType==IMAGETYPE_GIF)
			$source = imagecreatefromgif($imgObject['tmp_name']);

		//checar las proporciones de la imagen
		if($imgWidth>$imgHeight) //si es mas ancha que alta
			//$imgMaxWidth=$tamano[0];
			$imgMaxHeight=$imgMaxWidth*$imgHeight/$imgWidth;
		else //si es mas alta que ancha
			//$imgMaxHeight=$tamano[1];
			$imgMaxWidth=$imgMaxHeight*$imgWidth/$imgHeight;

	    $image_p = imagecreatetruecolor($imgMaxWidth, $imgMaxHeight);

		//crear la imagen de acuerdo al tipo de imagen
		if($imgType==IMAGETYPE_JPEG)
			$image = imagecreatefromjpeg($imgObject['tmp_name']);
		if($imgType==IMAGETYPE_PNG)
			$image = imagecreatefrompng($imgObject['tmp_name']);
		if($imgType==IMAGETYPE_GIF)
			$image = imagecreatefromgif($imgObject['tmp_name']);

		if($imgType==IMAGETYPE_PNG){
			//crear la transparencia de los png
			imagealphablending($image_p, false);
			$color=imagecolorallocatealpha($image_p, 0, 0, 0, 127);
			imagefill($image_p, 0, 0, $color);
			imagesavealpha($image_p, true);
		}

	    imagecopyresampled($image_p, $source, 0, 0, 0, 0, $imgMaxWidth, $imgMaxHeight, $imgWidth, $imgHeight);

		//salvar la imagen
		if($imgType==IMAGETYPE_JPEG)
			imagejpeg($image_p, $savePath . $imgName, $imgQuality);
		if($imgType==IMAGETYPE_PNG)
			imagepng($image_p, $savePath . $imgName);
		if($imgType==IMAGETYPE_GIF)
			imagegif($image_p, $savePath . $imgName, $imgQuality);

		//eliminar los archivos temporales
	    unset($imgObject);
	    unset($source);
	    unset($image_p);
	    unset($image);
	}

	public static function sufixImage($string, $type){
		if(strpos($string, $type)===FALSE){
			$string = str_ireplace(".png", $type . ".png", $string);
			$string = str_ireplace(".jpg", $type . ".jpg", $string);
			$string = str_ireplace(".gif", $type . ".gif", $string);
		}
		return $string;
	}
}
?>