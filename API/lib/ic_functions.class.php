<?
/**
 * @class Functions
 * @brief Clase de funciones principales para llamada estática.
 */
final class IC_Functions
{

	/**
     * Limpia un array de caracteres especiales y de tags HTML.
     *
     * @param data      Array de parametros recibidos.
     *
     * @return          Array limpio de caracteres y código.
     */
	public static function sendEmail($to, $subject, $template, $data, $lang = 0){
		if(!is_array($to)){
			if($to != ""){
				$t = array();
				$t[] = $to;
				$to = $t;
				unset($t);
			}else
				return false;
		}
		if($template == "")
			return false;

		if(intval($lang) == 1){
			$t = preg_replace("/(.*\/)+([a-zA-Z0-9\._-]+)\.(php|html|xml)/", "$1i_$2.$3", $template);
			if(file_exists(FOLDER_URL . "APIPlantillas/" . $t))
				$template = $t;
		}

		$args = new stdClass();
		$args->template = FOLDER_URL . "APIPlantillas/" . $template;
		$args->data = (object) $data;
		foreach($to as $val)
			Mailer::sendEmail($val, $subject, $args);

		return true;
	}

	public static function sendSMS($to, $text){
		$clickatell = new ClickatellRest("");
		$response = $clickatell->sendMessage($to, $text);

		/*foreach ($response as $message){
		    echo $message->id;
		}*/
	}
}