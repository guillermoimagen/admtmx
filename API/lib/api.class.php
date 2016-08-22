<?php
/**
 * @class API
 * @brief Clase que define funciones generales de uso y devoluci�n de la informaci�n.
 */
class API
{
	const MAIN_FOLDER = 'http://www.alcanciadigitalteleton.mx/';
	const IMAGES_FOLDER = ''; //!< Carpeta desde donde se obtendr�n las im�genes.

	const FACEBOOK_APP_ID = '896161833843485'; //!< ID de la aplicaci�n de Facebook.
	const FACEBOOK_APP_SECRET = '4de4ca63446b5d9901ab63ac4ac98ef2'; //!< ID secreto de la aplicaci�n de Facebook.

	const TWITTER_CONSUMER_KEY = 'LZecylUldrGjpuCzJiLTv21xG'; //!< ID de la aplicaci�n de Twitter.
	const TWITTER_CONSUMER_SECRET = 'VQyd759B2nRKJBIAvzTqIlkwyZp9VjRk7BoaxGEBKKzhV2NOSl'; //!< ID secreto de la aplicaci�n de Twitter
	const TWITTER_CALLBACK = 'http://www.alcanciadigitalteleton.mx/APIRemote/callback.twitter.php';

	const FB_SHARE_PAGE = '';

	const GOOGLE_RECAPTCHA_KEY = '6LfiKyYTAAAAAASsTslFRmj5vGNEZd5bhSCEif0x';
	const GOOGLE_RECAPTCHA_SECRET = '6LfiKyYTAAAAAMdeWIEb66T45feJkxTN_A6CMRGU';

    protected $method = ''; //!< El m�todo de HTTP con el que la petici�n fue hecha, pudiendo ser GET o POST.
    protected $db = null; //!< La instancia de la base de datos para tipo mysqli.
	protected $utf8 = null;
	protected $json = null;
	protected $lang = null;

/*! @publicsection */

	/**
	  * Constructor de la clase API.
	  *
	  * @param args 		Argumentos de configuraci�n, pudiendo ser:
	  *						utf8 	=> TRUE		Determina si los textos de respuesta ser�n enviados en en UTF8.
	  *						json 	=> TRUE 	Determina si la respuesta ser� enviada como un objeto de php o como un texto de json.
	  * 					db 		=> TRUE 	Determina si conecta una instancia de base de datos de la clase DB.
	  */
    public function __construct($args = null){
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
		global $_POST, $_GET;

		if(!is_object($args)) $args = new stdClass();
		if(!isset($args->utf8)) $args->utf8 = true;
		if(!isset($args->json)) $args->json = true;
		if(!isset($args->db)) $args->db = true;
		if(!isset($args->lang)) $args->lang = 0;

		$this->utf8 = $args->utf8;
		$this->json = $args->json;
		if($args->db) $this->db = new DB();
		$this->lang = intval($args->lang);

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
    }

	/**
	  * Devuelve respuesta.
	  *
	  * @param args 		Objeto de argumentos.
	  * 					data => Respuesta del recurso.
	  * 					status => C�digo de respuesta numerico. Valor predeterminado: 200.
	  * 					code => C�digo de mensaje de error.
	  * 					flat => Determina si se requieren los datos planos sin informaci�n de respuesta o de error.
	  */
    public function _response($args = null){
    	if(is_null($args) || !is_object($args)) $args = new stdClass();
    	if(!isset($args->status)) $args->status = 200;
        header("HTTP/1.1 " . $args->status . " " . self::_requestStatus($args->status));
		header('Content-type: application/json');

		$response = new stdClass();
		
		if((isset($args->flat) && $args->flat === true)){
			if(isset($args->data))
				$response = $args->data;
		}else{
			$response->meta = new stdClass();
			$response->meta->code = $args->status;

			if(isset($args->code)){
				$message = self::_responseCodeDB($args->code);
				if($message == false) $message = self::_responseCode($args->code);
				if($message !== false){
					$response->meta->detail = utf8_encode($message);
					$response->meta->number = $args->code;
				}
			}
			if(isset($args->data))
				$response->response = $args->data;
		}
		$this->db->_disconnectDatabase();
        if($this->json)
			echo json_encode($response);
		else
			return $response;
		die();
    }

	public function getFacebookApiId(){
		return self::FACEBOOK_APP_ID;
	}
	public function _checkReCaptcha($key){
		$recaptcha = new \ReCaptcha\ReCaptcha(self::GOOGLE_RECAPTCHA_SECRET, new \ReCaptcha\RequestMethod\SocketPost());
		$response = $recaptcha->verify($key, $_SERVER['REMOTE_ADDR']);
		//$coon = Functions::fileGetContentsCurl("https://www.google.com/recaptcha/api/siteverify?secret=" . self::GOOGLE_RECAPTCHA_SECRET . "&response=" . $key . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
		return $response->isSuccess();
	}

/*! @protectedsection */

/*! @privatesection */
	/**
      * Devuelve el mensaje de respuesta dependiendo de la respuesta HTTP.
      *
      * @param code 		C�digo de respuesta HTTP.
      *
      * @return 			Descripci�n del c�digo de respuesta.
      */
	private function _requestStatus($code) {
		$status = array(
			200 => 'OK',
			400 => 'Bad Request',
        	401 => 'Unauthorized',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			500 => 'Internal Server Error'
		);
		return ($status[$code]) ? $status[$code] : $status[500];
	}

	/**
      * Devuelve el mensaje de respuesta dependiendo de la operaci�n.
      *
      * @param code 		C�digo de respuesta.
      *
      * @return 			Descripci�n del c�digo de respuesta.
      */
	private function _responseCode($code) {
		$status = array(
			/* Errores de autentificaci�n, de ausencia de datos y inexistencia de datos */
			"01001" => "No existe ning�n administrador conectado sistema",
			"01002" => "No se proporcion� el identificador del administrador",
			"01003" => "No fue encontrado el administrador solicitado en la base de datos",
			"01004" => "No se proporcion� el identificador del usuario",
			"01005" => "No fue encontrado el usuario solicitado en la base de datos",
			"01006" => "No se encuentra conectado ning�n usuario",

			"01011" => "No existe ning�n token para este usuario",
			"01012" => "No se pudo autentificar a Facebook con el token existente",
			"01013" => "No se proporcion� configuraci�n de Facebook",
			"01014" => "No se proporcion� token de Twitter",
			"01015" => "No se proporcion� Auth Token",
			"01016" => "No se pudo autentificar en sAuth",
			"01017" => "No se pudo autentificar a Twitter con el token existente",
			"01018" => "No se pudo autentificar con sAuth",
			"01019" => "No se pudo conectar a Twitter",

			"01021" => "No se proporcion� un correo electr�nico v�lido",
			"01022" => "No se proporcion� una contrase�a v�lida",
			"01023" => "No se proporcion� un token v�lido",
			"01024" => "No se proporcion� oAuth token",
			"01025" => "No se proporcion� identificador v�lido",
			"01026" => "No se proporcion� identificador del usuario v�lido",
			"01027" => "No se proporcion� token de autentificaci�n",
			"01028" => "No se proporcion� token secreto de autentificaci�n",

			"01031" => "No se proporcion� identificador del pa�s v�lido",

			"01041" => "No se proporicon� un correo electr�nico v�lido",
			"01042" => "No se proporicon� un tel�fono v�lido",
			"01043" => "No se proporicon� un pa�s v�lido",
			"01044" => "No se proporicon� un estado v�lido",

			/* Errores de inserci�n o actuaizaci�n de datos */
			"02001" => "Ocurri� un error al insertar el registro",
			"02002" => "Ocurri� un error al actualizar el registro",
			"02003" => "Ocurri� un error al insertar: Registro ya existente",
			"02004" => "Ocurri� un error al eliminar el registro",
			"02005" => "No existe ninguna conexi�n a la base de datos",

			/* Errores de existencia o inexistencia de registros necesarios */
			"03001" => "No se encontr� la noticia solicitada",

			/* Errores de ejecuci�n de proceso */
			"04001" => "Ya existe un usuario con este correo electr�nico",
			"04002" => "No se pudo enviar el correo electr�nico",
			"04003" => "Ya existe un usuario conectado en este momento",
			"04004" => "El token de validaci�n no es v�lido",
			"04005" => "No existe ning�n usuario con este correo electr�nico",
			"04006" => "La contrase�a no es v�lida para este usuario",
			"04007" => "No existe ning�n usuario conectado al sistema",
			"04008" => "Existe un usuario con su correo electr�nico que no corresponde al existente con Facebook",
			"04009" => "El usuario ya ha sido validado",
			"04010" => "No existe ning�n c�digo de validaci�n a pesar de que el usuario no est� validado. Por favor, consulte con soporte",
			"04011" => "No se pudo publicar en Facebook",
			"04012" => "El mensaje proporcionado es mayor a 140 caracteres",
			"04013" => "Ya fue enviado correo de validaci�n a este usuario",
			"04014" => "Ya existe una cuenta de Facebook conectada a este usuario",
			"04015" => "Ya est� enlazada esta cuenta de Facebook a otra existente",
			"04016" => "Ya est� enlazada esta cuenta de usuario a un jugador",
			"04017" => "No se proporcion� fecha de nacimiento v�lida.",
			"04018" => "No se encontr� un jugador registrado con estos datos.",
			"04019" => "El jugador con estos datos no ha sido validado o no existe.",
			"04020" => "El jugador con estos datos ya ha sido registrado.",
			"04021" => "No se subi� ninguna imagen v�lida",
			"04022" => "No se ha validado el usuario.",
			"04041" => "El correo electr�nico perteneciente a esta cuenta de Facebook ya se encuentra asignado a otro usuario",
			"04042" => "La cuenta de Facebook ya se encuentra enlazada a otro usuario",

			"05001" => "Recibir�s un mensaje de correo electr�nico para concluir tu registro.",
			"05002" => "Se han actualizado con �xito tus datos, ahora puede cerrar esta ventana."

		);
		return ($status[$code]) ? $status[$code] : false;
	}

	public function _responseCodeDB($code){
		$sql = "SELECT " . (($this->lang == 0) ? 'textomen' : 'i_textomen') . " AS message FROM men WHERE idmen = '" . $code . "' LIMIT 1";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return false;

		$data = $query->fetch_object();
		return $data->message;
	}
}
?>