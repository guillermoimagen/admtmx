<?
/**
 * @class ICV_View
 * @brief Clase que define las funciones para generar vistas.
 */
final class ICV_View
{
	/**
      * Genera un vista a partir de una plantilla.
      *
      * @param template		Contenido de la plantilla.
      * @param data 		Elementos que serán sustituidos en la plantilla.
      *
      * @return 			Vista interpretada, o boolean false en caso de error.
      */
	public static function fromTemplate($template, $data){
		if($template == "") return false;
		$view = $template;

		foreach($data as $key => $val)
			$view = str_replace("<".$key.">", $val, $view);

		$view = ICV_Functions::replaceImages($view);

		return $view;
	}
}
?>