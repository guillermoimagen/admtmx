<?
/**
 * @class Mailer
 * @brief Clase que define las funciones para el envío de correos.
 */
final class Mailer
{
	const MAILGUN_KEY = 'key-f78e2f95e9983135a6e73121b284f3ae';
	const MAILGUN_HOST = 'emailer.123probando.com.mx';
	const MAILGUN_EMAIL = 'contacto@123probando.com.mx';

	/**
      * Verifica una clave de Webhook
      *
      * @param timestamp	Timestamp enviado.
      * @param token 		Token enviado.
      * @param signature	Llave enviada.
      *
      * @return 			Boolean.
      */
	public static function checkSignature($timestamp, $token, $signature){
		$key = hash_hmac("sha256", $timestamp . $token, self::MAILGUN_KEY);

		return $key == $signature;
	}

	/**
      * Registra un usuario.
      *
      * @param to  			Correo electrónico al que se enviará.
      * @param subject 		Asunto del correo.
      * @param args 		Objeto de datos, pudiendo contener lo siguiente:
      *						"message" => Mensaje a enviar.
      *						"template" => Plantilla del correo electrónico.
      *						"data" => Objeto de información para la plantilla del correo electrónico.
      *
      * @return 			Arreglo de información, o mensaje de error en caso de ocurrir.
      */
	public static function sendEmail($to, $subject, $args = null){
		/* VERIFICO QUE EMAIL SEA VÁLIDO */
		$ex_email = '/^([a-zA-Z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';
		if(preg_match($ex_email, $to) != 1) return false;

		/* CONSTRUYO CABECERAS */
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		if(!is_null($args) && is_object($args) && isset($args->template)){
			if(!isset($args->data)) $args->data = new stdClass();
			if(isset($args->message)) $args->data->message = $args->message;

			$template="";
			if($args->data->idioma==1) 
			{
				$plantilla=str_replace(".php","_i.php",$args->template);
				$template = file_get_contents($plantilla);
			}
			if(round($args->data->idioma)==0 || $template=="")
				$template = file_get_contents($args->template);
			$body = ICV_View::fromTemplate($template, $args->data);
		}else if(!is_null($args) && is_object($args) && isset($args->message))
			$body = $args->message;
		else
			$body = "";

		$api_key = self::MAILGUN_KEY;
		$api_version = 'api.mailgun.net/v2/';
		$api_dominio = self::MAILGUN_HOST;
		$api_url = "https://".$api_version.$api_dominio."/messages";

		$connection = curl_init();
		curl_setopt($connection, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		curl_setopt ($connection, CURLOPT_MAXREDIRS, 3);
		curl_setopt ($connection, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt ($connection, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($connection, CURLOPT_VERBOSE, 0);
		curl_setopt ($connection, CURLOPT_HEADER, 1);
		curl_setopt ($connection, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt ($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($connection, CURLOPT_SSL_VERIFYHOST, 0);

		curl_setopt($connection, CURLOPT_USERPWD, 'api:' . $api_key);
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($connection, CURLOPT_POST, true);
		curl_setopt($connection, CURLOPT_HEADER, false);
		curl_setopt($connection, CURLOPT_URL, $api_url);

		$data = array();
		$data["from"] = self::MAILGUN_EMAIL;
		$data["to"]=$to;
		$data["subject"] = $subject;
		$data["html"] = $body;
		if(isset($args->replyTo)) $data["h:Reply-To"] = $args->replyTo;

		curl_setopt($connection, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($connection);
		curl_close($connection);

		$response = json_decode($result, TRUE);
		if((!is_null($response["id"]) && $response["id"] != "") == false)
			return false;

		return true;
	}
}
?>