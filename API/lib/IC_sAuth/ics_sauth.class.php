<?
/**
 * @class ICS_sAuth
 * @brief Clase para autentificación con Imagen Central.
 */
class ICS_sAuth
{
	public $uid;
	public $user;
	public $password;

	public $idClient;
	public $idUser;

	public $apiKey;
	public $secret;
	public $token = null;
	public $refreshToken;

	public $table;
	public $tableToken;

	public $logInFacebook;
	public $idFacebook;

	public $logInTwitter;
	public $idTwitter;

	public $db = null;

	/**
	 * Constructor de la clase API.
	 *
	 * @param config	Argumentos de configuración.
	 *
	 */
	public function __construct($config = null){
		if(!is_object($config)) return false;
		$this->apiKey = $config->apiKey;
		$this->secret = $config->secret;
		$this->uid = isset($config->uid) ? $config->uid : false;
		$this->user = isset($config->user) ? $config->user : false;
		$this->password = isset($config->password) ? md5($config->password) : false;

		$this->token = isset($config->token) ? $config->token : null;

		$this->table = $config->table;
		$this->tableToken = $config->tableToken;
		$this->logInFacebook = isset($config->logInFacebook) ? $config->logInFacebook : false;
		$this->idFacebook = isset($config->idFacebook) ? $config->idFacebook : null;
		$this->logInTwitter = isset($config->logInTwitter) ? $config->logInTwitter : false;
		$this->idTwitter = isset($config->idTwitter) ? $config->idTwitter : null;

		$this->db = new DB();
	}

	/**
	 * Obtiene el token válido para el usuario conectado.
	 *
	 * @return 			Arreglo de información, o de error en caso de ocurrir.
	 */
	public function getToken(){
		$user = $this->validateUser();
		if($user != true)
			return $user;
		$this->token = $this->genToken();
		$this->refreshToken = $this->genRefreshToken();

		$sql = "
			INSERT INTO " . $this->tableToken . " SET
				token_sauth_token = '" . $this->token . "',
				refresh_sauth_token = '" . $this->refreshToken . "',
				isauth_client = " . $this->idClient . ",
				iusuario = " . $this->uid . ",
				expiration_sauth_token = '" . date('Y-m-d H:i:s', strtotime("+72 hour")) . "',
				delete_sauth_token = '" . date('Y-m-d H:i:s', strtotime("+12 month")) . "'
		";
				if(!$this->db->conn->query($sql)){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "Error al general el token.";
			return json_encode($error);
		}

		$data = new stdClass();
		$data->code = 1;
		$data->token = $this->token;
		$data->refreshToken = $this->refreshToken;
		$data->tokenID = $this->db->conn->insert_id;
		$data->randomValue = $this->idUser;

		return json_encode($data);
	}

	/**
	 * Verifica si el token es válido y en caso de serlo conecta al usuario
	 *
	 * @return 			Arreglo de información, o de error en caso de ocurrir.
	 */
	public function loginToken(){

		if(is_null($this->token)){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "No se proporcionó token.";

			return json_encode($error);
		}

		$sql = "
			SELECT id, refresh_sauth_token, expiration_sauth_token, iusuario
			FROM " . $this->tableToken . "
			WHERE token_sauth_token = '" . $this->token . "'
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "El token envíado no corresponde con ninguno válido.";
			return json_encode($error);
		}

		$data = $query->fetch_object();

		$date = date("Y-m-d H:i:s", strtotime("-10 hour"));
		if($data->expiration_sauth_token <= $date){
			$error = new stdClass();
			$error->code = -2;
			$error->message = "El token envíado ha caducado.";
			return json_encode($error);
		}

		$this->uid = intval($data->iusuario);

		$user = $this->validateUser();
		if($user != true)
			return $user;

		$response = new stdClass();
		$response->code = 1;
		$response->token = $this->token;
		$response->refreshToken = $data->refresh_sauth_token;
		$response->tokenID = $data->id;
		$response->randomValue = $this->idUser;

		return json_encode($response);
	}

	/**
	 * Valida el usuario conectado a través de sAuth.
	 *
	 * @return 			Boolean true, o arreglo de error en caso de ocurrir.
	 */
	public function validateUser(){
		$sql = "
			SELECT Id, secret_sauth_clients, firmadirecto
			FROM sauth_clients
			WHERE apikey_sauth_clients = '".$this->apiKey."' AND activo = '1'
		";
		$query = $this->db->conn->query($sql);

		if($query->num_rows == 0){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "No se encontró la aplicación.";
			return json_encode($error);
		}

		$client = $query->fetch_object();

		if($client->secret_sauth_clients != $this->secret){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "El identificador secreto de la aplicación es incorrecto.";
			return json_encode($error);
		}

		$this->idClient = $client->Id;

		if($client->firmadirecto == '1')
			return true;

		if($this->logInFacebook == true)
			$sql = "SELECT id, nombreusuario, emailusuario, fbusuario, imagenusuario FROM " . $this->table . " WHERE fbusuario ='" . $this->idFacebook . "' AND activo = '1'";
		else if($this->logInTwitter == true)
			$sql = "SELECT id, nombreusuario, emailusuario, ttusuario, imagenusuario FROM " . $this->table . " WHERE ttusuario ='" . $this->idTwitter . "' AND activo = '1'";
		else if($this->uid != false && is_integer($this->uid) && $this->uid > 0)
			$sql = "SELECT id, nombreusuario, emailusuario,imagenusuario FROM " . $this->table . " WHERE id = '" . $this->uid . "' AND activo = '1'";
		else
			$sql = "SELECT id, nombreusuario, emailusuario, contrasenausuario,imagenusuario FROM " . $this->table . " WHERE emailusuario='" . $this->user . "' AND activo = '1'";

		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "No se encontró el usuario solicitado.";
			return json_encode($error);
		}

		$user = $query->fetch_object();

		if(
			(($this->logInFacebook == true && $user->fbusuario == $this->idFacebook) ||
			($this->logInTwitter == true && $user->ttusuario == $this->idTwitter) ||
			($this->logInFacebook == false && $this->logInTwitter == false && $user->contrasenausuario == $this->password) ||
			($this->logInFacebook == false && $this->logInTwitter == false && $user->id == $this->uid)) == false
		){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "La autentificación del usuario no fue correcta.";
			return json_encode($error);
		}

		$sql = "
			SELECT
				usuarios.imagenusuario AS image, 
				usuarios.cmsusuario AS cms 
			FROM usuarios
			WHERE usuarios.id = " . $user->id . "
		";
		$queryx = $this->db->conn->query($sql);
		$extra = $queryx->fetch_object();

		$_SESSION["logged"] = new stdClass();
		$_SESSION["logged"]->id = $user->id;
		$_SESSION["logged"]->name = $user->nombreusuario;
		$_SESSION["logged"]->email = $user->emailusuario;
		$_SESSION["logged"]->image = $extra->image;
		$_SESSION["logged"]->cms = round($extra->cms);
		$this->tokenCMS = round($extra->cms);
		$this->idUser = $user->id;

		return true;
	}

	/**
	 * Valida un token sAuth solicitado.
	 *
	 * @return 			Arreglo de información, o de error en caso de ocurrir.
	 */
	public function validateToken(){
		global $_GET, $_POST;

		if(!is_null($this->token))
			$this->token = $this->token;
		else if(isset($_GET['token']))
			$this->token = $_GET['token'];
		else if(isset($_POST['token']))
			$this->token = $_POST['token'];
		else if(isset($_SESSION['token']))
			$this->token = $_SESSION['token'];
		else{
			$error = new stdClass();
			$error->code = -1;
			$error->message = "No se proporcionó token.";
			return json_encode($error);
		}

		$sql = "
			SELECT expiration_sauth_token, iusuario
			FROM " . $this->tableToken . "
			WHERE token_sauth_token = '" . $this->token . "'
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "El token envíado no corresponde con ninguno válido.";
			return json_encode($error);
		}

		$data = $query->fetch_object();

		$date = date("Y-m-d H:i:s", strtotime("-10 hour"));
		if($data->expiration_sauth_token <= $date){
			$error = new stdClass();
			$error->code = -2;
			$error->message = "El token envíado ha caducado.";
			return json_encode($error);
		}

		$response = new stdClass();
		$response->code = 1;
		$response->user = $data->iusuario;

		return json_encode($response);
	}

	/**
	 * Actualiza el token de un usuario.
	 *
	 * @param data 		Objeto de información para actualizar, compuesto de:
	 *					token 		 	=>	Token.
	 *					refreshToken 	=>	Token para actualizar.
	 *
	 * @return 			Objeto de información, o de error en caso de ocurrir.
	 */
	public function refreshToken($data){
		$sql = "
			SELECT isauth_client, expiration_sauth_token, delete_sauth_token, iusuario
			FROM " . $this->tableToken . "
			WHERE token_sauth_token = '" . $data->token . "' AND refresh_sauth_token='" . $data->refreshToken . "'
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "El token envíado no corresponde con ninguno válido.";
			return json_encode($error);
		}

		$user = $query->fetch_object();

		$this->idClient = $user->isauth_client;
		$this->idUser = $user->iusuario;

		$sql = "
			SELECT apikey_sauth_clients, secret_sauth_clients
			FROM sauth_clients
			WHERE Id = '" . $user->isauth_client . "' AND activo = '1'
		";
		$query = $this->db->conn->query($sql);

		if($query->num_rows == 0){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "No se encontró la aplicación.";
			return json_encode($error);
		}
		$client = $query->fetch_object();

		$this->apikey = $client->apikey_sauth_clients;
		$this->secret = $client->secret_sauth_clients;

		$this->token = $this->genToken();
		$this->refreshToken = $this->genRefreshToken();


		if(date("Y-m-d H:i:s") > $user->delete_sauth_token){
			return $this->deleteToken($data);
		}

		$sql = "
			UPDATE " . $this->tableToken . " SET
				token_sauth_token = '" . $this->token . "',
				refresh_sauth_token = '" . $this->refreshToken . "',
				expiration_sauth_token = '" . date('Y-m-d H:i:s') . "',
				delete_sauth_token = '" . date('Y-m-d H:i:s', strtotime('+1 month')) . "'
			WHERE token_sauth_token = '" . $data->token . "' AND refresh_sauth_token = '" . $data->refreshToken . "'
			LIMIT 1
		";
		if(!$this->db->conn->query($sql)){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "Ocurrió un error al actualizar el token.";
			return json_encode($error);
		}

		$response = new stdClass();
		$response->code = 1;
		$response->token = $this->token;
		$response->refreshToken = $this->refreshToken;
		$response->user = $this->idUser;

		return json_encode($response);
	}

	/**
	 * Borra el token de un usuario.
	 *
	 * @param data 		Objeto de información para actualizar, compuesto de:
	 *					token 		 	=>	Token.
	 *					refreshToken 	=>	Token para actualizar.
	 *
	 * @return 			Objeto de información, o de error en caso de ocurrir.
	 */
	public function deleteToken($data){
		$sql = "DELETE FROM " . $this->tableToken . " WHERE token_sauth_token = '" . $data->token . "' AND refresh_sauth_token='" . $data->refreshToken . "'";
		if(!$this->db->conn->query($sql)){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "Ocurrió un error al eliminar el token.";
			return json_encode($error);
		}

		$error = new stdClass();
		$error->code = 1;
		$error->message = "Token eliminado con éxito.";
		return json_encode($error);
	}

	/**
	 * Borra el token de un usuario a partir de la variable $_GET
	 *
	 * @return 			Objeto de información, o de error en caso de ocurrir.
	 */
	public function deleteTokenFromGet(){
		$sql = "DELETE FROM " . $this->tableToken . " WHERE token_sauth_token = '" . $_GET['token'] . "'";
		if(!$this->db->conn->query($sql)){
			$error = new stdClass();
			$error->code = -1;
			$error->message = "Ocurrió un error al eliminar el token.";
			return json_encode($error);
		}

		$error = new stdClass();
		$error->code = 1;
		$error->message = "Token eliminado con éxito.";
		return json_encode($error);
	}

	/**
	 * General un token para el usuario.
	 *
	 * @return 			Token generado.
	 */
	private function genToken(){
		return md5($this->apiKey . $this->secret . date('Y-m-d H:i:s') . rand(1001,2000));
	}

	/**
	 * General un token de renovación para el usuario.
	 *
	 * @return 			Token generado.
	 */
	private function genRefreshToken(){
		return md5($this->apiKey . $this->secret . date('Y-m-d H:i:s') . rand(2001,3000));
	}
}
?>