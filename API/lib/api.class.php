<?php
/**
 * @class API
 * @brief Clase que define funciones generales de uso y devolución de la información.
 */
class API
{
	const MAIN_FOLDER = 'http://www.alcanciadigitalteleton.mx/';
	const IMAGES_FOLDER = ''; //!< Carpeta desde donde se obtendrán las imágenes.

	const FACEBOOK_APP_ID = '896161833843485'; //!< ID de la aplicación de Facebook.
	const FACEBOOK_APP_SECRET = '4de4ca63446b5d9901ab63ac4ac98ef2'; //!< ID secreto de la aplicación de Facebook.

	const TWITTER_CONSUMER_KEY = 'LZecylUldrGjpuCzJiLTv21xG'; //!< ID de la aplicación de Twitter.
	const TWITTER_CONSUMER_SECRET = 'VQyd759B2nRKJBIAvzTqIlkwyZp9VjRk7BoaxGEBKKzhV2NOSl'; //!< ID secreto de la aplicación de Twitter
	const TWITTER_CALLBACK = 'http://www.alcanciadigitalteleton.mx/APIRemote/callback.twitter.php';

	const FB_SHARE_PAGE = '';

	const GOOGLE_RECAPTCHA_KEY = '6LfiKyYTAAAAAASsTslFRmj5vGNEZd5bhSCEif0x';
	const GOOGLE_RECAPTCHA_SECRET = '6LfiKyYTAAAAAMdeWIEb66T45feJkxTN_A6CMRGU';

    protected $method = ''; //!< El método de HTTP con el que la petición fue hecha, pudiendo ser GET o POST.
    protected $db = null; //!< La instancia de la base de datos para tipo mysqli.
	protected $utf8 = null;
	protected $json = null;
	protected $lang = null;

/*! @publicsection */

	/**
	  * Constructor de la clase API.
	  *
	  * @param args 		Argumentos de configuración, pudiendo ser:
	  *						utf8 	=> TRUE		Determina si los textos de respuesta serán enviados en en UTF8.
	  *						json 	=> TRUE 	Determina si la respuesta será enviada como un objeto de php o como un texto de json.
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
	  * 					status => Código de respuesta numerico. Valor predeterminado: 200.
	  * 					code => Código de mensaje de error.
	  * 					flat => Determina si se requieren los datos planos sin información de respuesta o de error.
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
      * @param code 		Código de respuesta HTTP.
      *
      * @return 			Descripción del código de respuesta.
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
      * Devuelve el mensaje de respuesta dependiendo de la operación.
      *
      * @param code 		Código de respuesta.
      *
      * @return 			Descripción del código de respuesta.
      */
	private function _responseCode($code) {
		$status = array(
			/* Errores de autentificación, de ausencia de datos y inexistencia de datos */
			"01001" => "No existe ningún administrador conectado sistema",
			"01002" => "No se proporcionó el identificador del administrador",
			"01003" => "No fue encontrado el administrador solicitado en la base de datos",
			"01004" => "No se proporcionó el identificador del usuario",
			"01005" => "No fue encontrado el usuario solicitado en la base de datos",
			"01006" => "No se encuentra conectado ningún usuario",

			"01011" => "No existe ningún token para este usuario",
			"01012" => "No se pudo autentificar a Facebook con el token existente",
			"01013" => "No se proporcionó configuración de Facebook",
			"01014" => "No se proporcionó token de Twitter",
			"01015" => "No se proporcionó Auth Token",
			"01016" => "No se pudo autentificar en sAuth",
			"01017" => "No se pudo autentificar a Twitter con el token existente",
			"01018" => "No se pudo autentificar con sAuth",
			"01019" => "No se pudo conectar a Twitter",

			"01021" => "No se proporcionó un correo electrónico válido",
			"01022" => "No se proporcionó una contraseña válida",
			"01023" => "No se proporcionó un token válido",
			"01024" => "No se proporcionó oAuth token",
			"01025" => "No se proporcionó identificador válido",
			"01026" => "No se proporcionó identificador del usuario válido",
			"01027" => "No se proporcionó token de autentificación",
			"01028" => "No se proporcionó token secreto de autentificación",

			"01031" => "No se proporcionó identificador del país válido",

			"01041" => "No se proporiconó un correo electrónico válido",
			"01042" => "No se proporiconó un teléfono válido",
			"01043" => "No se proporiconó un país válido",
			"01044" => "No se proporiconó un estado válido",

			/* Errores de inserción o actuaización de datos */
			"02001" => "Ocurrió un error al insertar el registro",
			"02002" => "Ocurrió un error al actualizar el registro",
			"02003" => "Ocurrió un error al insertar: Registro ya existente",
			"02004" => "Ocurrió un error al eliminar el registro",
			"02005" => "No existe ninguna conexión a la base de datos",

			/* Errores de existencia o inexistencia de registros necesarios */
			"03001" => "No se encontró la noticia solicitada",

			/* Errores de ejecución de proceso */
			"04001" => "Ya existe un usuario con este correo electrónico",
			"04002" => "No se pudo enviar el correo electrónico",
			"04003" => "Ya existe un usuario conectado en este momento",
			"04004" => "El token de validación no es válido",
			"04005" => "No existe ningún usuario con este correo electrónico",
			"04006" => "La contraseña no es válida para este usuario",
			"04007" => "No existe ningún usuario conectado al sistema",
			"04008" => "Existe un usuario con su correo electrónico que no corresponde al existente con Facebook",
			"04009" => "El usuario ya ha sido validado",
			"04010" => "No existe ningún código de validación a pesar de que el usuario no está validado. Por favor, consulte con soporte",
			"04011" => "No se pudo publicar en Facebook",
			"04012" => "El mensaje proporcionado es mayor a 140 caracteres",
			"04013" => "Ya fue enviado correo de validación a este usuario",
			"04014" => "Ya existe una cuenta de Facebook conectada a este usuario",
			"04015" => "Ya está enlazada esta cuenta de Facebook a otra existente",
			"04016" => "Ya está enlazada esta cuenta de usuario a un jugador",
			"04017" => "No se proporcionó fecha de nacimiento válida.",
			"04018" => "No se encontró un jugador registrado con estos datos.",
			"04019" => "El jugador con estos datos no ha sido validado o no existe.",
			"04020" => "El jugador con estos datos ya ha sido registrado.",
			"04021" => "No se subió ninguna imagen válida",
			"04022" => "No se ha validado el usuario.",
			"04041" => "El correo electrónico perteneciente a esta cuenta de Facebook ya se encuentra asignado a otro usuario",
			"04042" => "La cuenta de Facebook ya se encuentra enlazada a otro usuario",

			"05001" => "Recibirás un mensaje de correo electrónico para concluir tu registro.",
			"05002" => "Se han actualizado con éxito tus datos, ahora puede cerrar esta ventana."

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