<?
/**
 * @class ICV_Functions
 * @brief Clase de funciones para los métodos de vistas de Imagen Central.
 */
final class ICV_Functions
{
	public static function replaceImages($string, $replace = null){
		if(is_string($replace) && $replace != "")
			$string = preg_replace("/(<IMG [^>]*src=('|\"[^>]*)recursos\/)(('|\")[^>]*>)/i","$1".$replace."$2",$string);
		else
			$string = preg_replace("/<IMG [^>]*src=('|\"[^>]*)recursos\/('|\")[^>]*>/i","",$string);

		return $string;
	}
}
?>