<?
/**
 * @class Users
 * @brief Clase que define las operaciones de manejo de usuarios.
 */
class Users extends API
{

/*! @publicsection */

	/**
	  * Constructor de la clase Usuarios, que invoca el constuctor de la clase API.
	  *
	  * @param args 		Argumentos de configuración, pudiendo ser:
	  *						utf8 	=> TRUE		Determina si los textos de respuesta serán enviados en en UTF8.
	  *						json 	=> TRUE 	Determina si la respuesta será enviada como un objeto de php o como un texto de json.
	  * 					db 		=> TRUE 	Determina si conecta una instancia de base de datos de la clase DB.
	  */
	public function __construct($args = null){
		parent::__construct($args);
	}

	/**
	  * Registra un usuario.
	  *
	  * @param email 		Correo electrónico del usuario.
	  * @param pass 		Contraseña del usuario.
	  * @param name 		Nombre del usuario
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
    public function signUpUser($email, $pass, $name, $nick){
		if(is_null($this->db->conn)) return "02005";

		$uid = null;
		$email = strtolower($this->db->conn->real_escape_string(Functions::strip_tags_content($email)));
		$name = $this->db->conn->real_escape_string(Functions::strip_tags_content($name));
		$nick = $this->db->conn->real_escape_string(Functions::strip_tags_content($nick));

		if($email == "") return "01021";
		if($pass == "") return "01022";
		if($nick == "") return "01029";

		$sql = "SELECT nickusuario FROM usuarios WHERE nickusuario = '" . $nick . "' AND emailusuario <> '" . $email . "'";
		$query = $this->db->conn->query($sql);
		if($query->num_rows > 0)
			return "04043";

		$sql = "SELECT id, validadousuario FROM usuarios WHERE emailusuario = '" . $email . "'";
		$query = $this->db->conn->query($sql);
		if($query->num_rows > 0){
			$response = $query->fetch_object();
			if($response->validadousuario == '2')
				$uid = $response->id;
			else if($response->validadousuario == "0"){
				$uid = $response->id;
				$this->resendRegisterEmail($email);
				return "04022";
			}else if($response->validadousuario == "1")
				return "04001";
		}
		$token = md5($email . date("YmdHiS") . rand(10, 99));
		$urlusuario = $this->convierte_url_API(utf8_decode($nick));

		if(is_null($uid)){
			$sql = "
				INSERT INTO usuarios SET
					nombreusuario = '" . utf8_decode($name) . "',
					urlusuario = '".$urlusuario. "',
					nickusuario = '" . utf8_decode($nick) . "',
					contrasenausuario = '" . md5($pass) . "',
					emailusuario = '" . $email . "',
					codigousuario = '" . $token . "',
					validadousuario = '0',
					actualizadousuario = '1'
			";
			if(!$this->db->conn->query($sql))
				return "02001";
		}else{
			$sql = "
				UPDATE usuarios SET
					nombreusuario = '" . utf8_decode($name) . "',
					nickusuario = '" . utf8_decode($nick) . "',
					contrasenausuario = '" . md5($pass) . "',
					emailusuario = '" . $email . "',
					codigousuario = '" . $token . "',
					validadousuario = '0',
					actualizadousuario = '1'
				WHERE id = " . $uid . " 
				LIMIT 1
			";
			if(!$this->db->conn->query($sql))
				return "02002";
		}

		$args = new stdClass();
		$args->template = "../APIPlantillas/mailing/signUp" . (($this->lang == 1 && file_exists("../APIPlantillas/mailing/signUp_i.php")) ? "_i" : "") . ".php";
		$args->data = new stdClass();
		$args->data->name = ($name);
		$args->data->pass = $pass;
		$args->data->token = $token;
		$args->data->host = self::MAIN_FOLDER;

		if(!Mailer::sendEmail($email, utf8_encode($this->_responseCodeDB("06001")), $args))
			return "04002";

		$response = new stdClass();
		$response->id = $this->db->conn->insert_id;

		return $response;
    }

	/**
	  * Reenvia el correo de validación.
	  *
	  * @param email 		Correo electrónico del usuario.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function resendRegisterEmail($email){
		if(is_null($this->db->conn)) return "02005";
		if($email == "") return "01021";

		$email = strtolower($this->db->conn->real_escape_string($email));

		$sql = "
			SELECT
				nombreusuario AS name,
				codigousuario AS token,
				validadousuario AS validate
			FROM usuarios
			WHERE emailusuario = '" . $email . "'
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04005";

		$data = $query->fetch_object();
		if($data->validate == '1') return "04009";
		if($data->token == "") return "04010";

		$args = new stdClass();
		$args->template = "../APIPlantillas/mailing/signUp" . (($this->lang == 1 && file_exists("../APIPlantillas/mailing/signUp_i.php")) ? "_i" : "") . ".php";
		$args->data = new stdClass();
		$args->data->name = $data->name;
		$args->data->token = $data->token;
		$args->data->host = self::MAIN_FOLDER;

		if(!Mailer::sendEmail($email, utf8_encode($this->_responseCodeDB("06001")), $args))
			return "04002";
		return true;
	}

	/**
	  * Conecta un usuario.
	  *
	  * @param email 		Correo electrónico del usuario.
	  * @param pass 		Contraseña del usuario.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	 */
	public function logInUser($email, $pass, $keep = false){
		if(is_null($this->db->conn)) return "02005";
		if($email == "") return "01021";
		if($pass == "") return "01022";

		$email = strtolower($this->db->conn->real_escape_string($email));
		$sql = "
			SELECT
				id,
				nombreusuario AS name,
				contrasenausuario AS pass,
				validadousuario AS validate,
				imagenusuario AS image,
				activo AS active  
			FROM usuarios
			WHERE emailusuario = '" . $email . "'
		";

		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04005";
		$data = $query->fetch_object();

		if($data->pass != md5($pass)) return "04006";
		if($data->validate == '0'){
			$this->resendRegisterEmail($email);
			return "04022";
		}else if($data->validate == '2')
			return "04005";
		if($data->active == '0') return "04023";

		$config = new stdClass();
		$config->user = $email;
		$config->password = $pass;
		$config->uid = $data->id;


		$sAuthResponse = ICS_Functions::logIn($config);

		if($sAuthResponse->response != true) return "01018";

		$sAuthResponse->uid = $data->id;
		$sAuthResponse->name = utf8_encode($data->name);
		$sAuthResponse->email = $email;
		$sAuthResponse->image = $data->image;
		$sAuthResponse->fullInfo = $this->checkValidInfo($data->id);

		if($keep == true)
			setcookie("alcancia_keeplogged", $sAuthResponse->token, time() + (86400 * 30), "/");

		$sql = "INSERT INTO bit SET itbitbit = 9, tablabit = 1, registrobit = " . $data->id . ", iusuariobit = " . $data->id . "";
		if(!$this->db->conn->query($sql))
			return "02001";

		return $sAuthResponse;
	}

	/**
	  * Conecta un usuario a través de su uid.
	  *
	  * @param uid 			Identificador del usuario.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function logInUserById($uid){
		if(is_null($this->db->conn)) return "02005";
		if((is_integer($uid) && $uid > 0) == false) return "01026";

		$sql = "
			SELECT
				nombreusuario AS name,
				emailusuario AS email,
				imagenusuario AS image 
			FROM usuarios
			WHERE id = '" . $uid . "'
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04005";
		$data = $query->fetch_object();
		$config = new stdClass();
		$config->uid = $uid;

		$sAuthResponse = ICS_Functions::logIn($config);

		if($sAuthResponse->response != true) return "01018";

		$sAuthResponse->uid = $uid;
		$sAuthResponse->name = utf8_encode($data->name);
		$sAuthResponse->email = $data->email;
		$sAuthResponse->image = $data->image;
		$sAuthResponse->fullInfo = $this->checkValidInfo($uid);

		$sql = "INSERT INTO bit SET itbitbit = 9, tablabit = 1, registrobit = " . $uid . ", iusuariobit = " . $uid . "";
		if(!$this->db->conn->query($sql))
			return "02001";
		
		return $sAuthResponse;
	}

	public function getAuthTwitter(){
		if(is_null($this->db->conn)) return "02005";

		$connection = new TwitterOAuth(self::TWITTER_CONSUMER_KEY, self::TWITTER_CONSUMER_SECRET);

		$request_token = $connection->getRequestToken(self::TWITTER_CALLBACK);

		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		//print_r($_SESSION);
		
		switch ($connection->http_code) {
			case 200:
				$url = $connection->getAuthorizeURL($token);
				header('Location: ' . $url); 
			break;
			default:
				return "01019";
		}
	}

	/**
	  * Conecta un usuario a través de Twitter
	  *
	  * @param authToken 	Token obtenido a través de oAuth.
	  * @param authSecret	Token obtenido a través de oAuth.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function loginTwitter($authToken, $authSecret, $authVerifier, $keep = false){
		if(is_null($this->db->conn)) return "02005";
		if($authToken == "") return "01027";
		if($authSecret == "") return "01028";
		$connection = new TwitterOAuth(self::TWITTER_CONSUMER_KEY, self::TWITTER_CONSUMER_SECRET, $authToken, $authSecret);
		$credentials = $connection->getAccessToken($authVerifier);
		$response = $connection->get("account/verify_credentials");
		if($connection->http_code != 200)
			return "01019";
		$twid = $response->id;
		$name = utf8_decode($response->name);
		$nick = utf8_decode($response->screen_name);
		$nick = $this->getValidUserName($nick);
		$image = $response->profile_image_url;

		$sql = "
			SELECT id, nombreusuario AS name, emailusuario AS email, ttusuario AS ttid, imagenusuario AS image, validadousuario AS validated, activo AS active
			FROM usuarios 
			WHERE ttusuario = '" . $twid . "'
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 1){
			$data = $query->fetch_object();

			if($data->active == '0') return "04023";

			$email = $data->email;
			$sql = "
				UPDATE usuarios SET
			";
			if((int)$data->validated == 2)
				$sql .= "
					nombreusuario = '" . $name . "',
					contrasenausuario = '" . md5("tw" . rand(1000, 9999)) . "',
					imagenusuario = '" . $image . "',
				";
			else if((int)$data->validated == 0)
				$sql .= "
					imagenusuario = '" . $image . "',
					codigousuario = '',
				";
			$sql .= "
					validadousuario = '1'
				WHERE id = " . $data->id . "
				LIMIT 1
			";
			if(!$this->db->conn->query($sql))
				return "02002";
		}else{
			$urlusuario = $this->convierte_url_API($nick);

			$sql = "
				INSERT INTO usuarios SET
					emailusuario = '" . $twid . "',
					urlusuario = '".$urlusuario. "',
					nombreusuario = '" . $name . "',
					nickusuario = '" . $nick . "',
					contrasenausuario = '" . md5("tw" . rand(1000, 9999)) . "',
					imagenusuario = '" . $image . "',
					ttusuario = '" . $twid . "',
					codigousuario = '',
					validadousuario = '1'
			";
			if(!$this->db->conn->query($sql))
				return "02001";
			$data = new stdClass();
			$data->id = $this->db->conn->insert_id;
			$data->name = $name;
			$data->image = $image;
		}

		$config = new stdClass();
		$config->user = '';
		$config->password = '';
		$config->logInTwitter = true;
		$config->idTwitter = $twid;
		$config->uid = $data->id;
		$sAuthResponse = ICS_Functions::logIn($config);

		if($sAuthResponse->response != true) return "01018";

		$sAuthResponse->uid = $data->id;
		$sAuthResponse->name = utf8_encode($data->name);
		$sAuthResponse->image = $data->image;
		$sAuthResponse->fullInfo = $this->checkValidInfo($data->id);

		if($keep == true)
			setcookie("alcancia_keeplogged", $sAuthResponse->token, time() + (86400 * 30), "/");

		$sql = "INSERT INTO bit SET itbitbit = 9, tablabit = 1, registrobit = " . $data->id . ", iusuariobit = " . $data->id . "";
		if(!$this->db->conn->query($sql))
			return "02001";

		return $sAuthResponse;
	}

	/**
	  * Conecta un usuario a través de Facebook
	  *
	  * @param oAuthToken 	Token obtenido a través de oAuth.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function logInFacebook($oAuthToken, $keep = false){
		if(is_null($this->db->conn)) return "02005";
		if($oAuthToken == "") return "01024";

		$facebook = $this->validAccessToken($oAuthToken);
		if(!is_object($facebook)) return $facebook;
		$me = $facebook->api('me?fields=email,id,name');

		$uid = $me["id"];
		$name = utf8_decode($me["name"]);
		$nick = utf8_decode($me["first_name"]);
		$nick = $this->getValidUserName($nick);
		$email = strtolower($me["email"]);
		if($email == "") $email = $uid;

		$sql = "
			SELECT id, nombreusuario AS name, emailusuario AS email, fbusuario, cmsusuario, imagenusuario AS image, validadousuario AS validated, activo AS active
			FROM usuarios 
			WHERE emailusuario = '" . $email . "' OR fbusuario = '" . $uid . "'
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 1){
			$data = $query->fetch_object();

			if($data->active == '0') return "04023";

			$email = $data->email;
			$url = 'https://graph.facebook.com/' . $data->id . '/picture?type=large';
			$sql = "
				UPDATE usuarios SET
			";
			if((int)$data->validated == 2)
				$sql .= "
					nombreusuario = '" . $name . "',
					contrasenausuario = '" . md5("fb" . rand(1000, 9999)) . "',
					imagenusuario = '" . ((isset($photo)) ? $photo : $url) . "',
				";
			else if((int)$data->validated == 0)
				$sql .= "
					imagenusuario = '" . ((isset($photo)) ? $photo : $url) . "',
					codigousuario = '',
				";
			$sql .= "
					fbusuario = '" . $uid . "',
					tokenfbusuario='" . $oAuthToken . "',
					validadousuario = '1'
				WHERE id = " . $data->id . "
				LIMIT 1
			";
			if(!$this->db->conn->query($sql))
				return "02002";
		}else if(@mysqli_num_rows($query) > 1){
			return "04008";
		}else{
			/*$headers = get_headers('https://graph.facebook.com/' . $uid . '/picture?type=large',1);
			$url = $headers['Location'];*/
			$url = 'https://graph.facebook.com/' . $uid . '/picture?type=large';
			$urlusuario = $this->convierte_url_API($nick);
										
			$sql = "
				INSERT INTO usuarios SET
					emailusuario = '" . $email . "',
					nombreusuario = '" . $name . "',
					urlusuario = '".$urlusuario. "',
					nickusuario = '" . $nick . "',
					contrasenausuario = '" . md5("fb" . rand(1000, 9999)) . "',
					imagenusuario = '" . ((isset($photo)) ? $photo : $url) . "',
					fbusuario = '" . $uid . "',
					tokenfbusuario = '" . $oAuthToken . "',
					codigousuario = '',
					validadousuario = '1'
			";
			if(!$this->db->conn->query($sql))
				return "02001";
			$data = new stdClass();
			$data->id = $this->db->conn->insert_id;
			$data->email = $email;
			$data->name = $name;
			$data->image = ((isset($photo)) ? $photo : $url);
		}

		$config = new stdClass();
		$config->user = $email;
		$config->password = '';
		$config->logInFacebook = true;
		$config->idFacebook = $uid;
		$config->uid = $data->id;
		$sAuthResponse = ICS_Functions::logIn($config);

		if($sAuthResponse->response != true) return "01018";

		$sAuthResponse->uid = $data->id;
		$sAuthResponse->name = utf8_encode($data->name);
		$sAuthResponse->email = $data->email;
		$sAuthResponse->image = $data->image;
		$sAuthResponse->fullInfo = $this->checkValidInfo($data->id);

		if($keep == true)
			setcookie("alcancia_keeplogged", $sAuthResponse->token, time() + (86400 * 30), "/");

		$sql = "INSERT INTO bit SET itbitbit = 9, tablabit = 1, registrobit = " . $data->id . ", iusuariobit = " . $data->id . "";
		if(!$this->db->conn->query($sql))
			return "02001";

		return $sAuthResponse;
	}

	/**
	  * Enlaza una cuenta de Facebook con un usuario.
	  *
	  * @param uid 			Identificador del jugador.
	  * @param oAuthToken 	Token obtenido a través de oAuth.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function connectFacebook($uid, $oAuthToken){
		if(is_null($this->db->conn)) return "02005";
		if($oAuthToken == "") return "01024";

		$facebook = $this->validAccessToken($oAuthToken);
		if(!is_object($facebook)) return $facebook;
		$me = $facebook->api('me?fields=email,id,name');

		$fid = $me["id"];
		$name = utf8_decode($me["name"]);
		$email = strtolower($me["email"]);
		if($email == "") $email = $uid;

		$sql = "SELECT id, fbusuario FROM usuarios WHERE id = " . $uid . "";
		$query = $this->db->conn->query($sql);
		$data = $query->fetch_object();
		if($data->fbusuario != "") return "04014";

		$sql = "SELECT id, nombreusuario AS name, emailusuario AS email, fbusuario FROM usuarios WHERE emailusuario = '" . $email . "' OR fbusuario = '" . $fid . "'";
		$query = $this->db->conn->query($sql);
		$data = $query->fetch_object();
		if($data->id != $uid && $data->email == $email) return "04041";
		if($data->id != $uid && $data->fbusuario == $fid) return "04042";

		$sql = "
			UPDATE usuarios SET
				fbusuario = '" . $uid . "',
				tokenfbusuario='" . $oAuthToken . "'
			WHERE id = " . $uid . "
			LIMIT 1
		";
		if(!$this->db->conn->query($sql))
			return "02002";
		return true;
    }

	/**
	  * Desconecta al usuario con sesión abierta.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function logOutUser(){
		$uid = $_SESSION["logged"]->id;
		unset($_SESSION["logged"]);
		$_SESSION["firmado"]=false;
		unset($_SESSION["firmado"]);

		if(isset($_COOKIE["alcancia_keeplogged"])){
			setcookie("alcancia_keeplogged", "", time() - 3600, "/");
		}

		$sql = "INSERT INTO bit SET itbitbit = 10, tablabit = 1, registrobit = " . $uid . ", iusuariobit = " . $uid . "";
		if(!$this->db->conn->query($sql))
			return "02001";

		return true;
	}

	/**
	  * Valida un usuario nuevo a través del token.
	  *
	  * @param token 		Token de validación.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function validateUser($token){
		if(is_null($this->db->conn)) return "02005";
		if($token == "") return "01023";

		$token = $this->db->conn->real_escape_string($token);

		$sql = "SELECT id, nombreusuario AS name, emailusuario AS email FROM usuarios WHERE codigousuario = '" . $token . "' AND (validadousuario = '0' or validadousuario='2')";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04004";

		$data = $query->fetch_object();

		$sql = "
			UPDATE usuarios SET
				codigousuario = '',
				validadousuario = '1'
			WHERE id = " . $data->id . "
			LIMIT 1
		";
		if(!$this->db->conn->query($sql))
			return "02002";

		$args = new stdClass();
		$args->template = "../APIPlantillas/mailing/validatedUser" . (($this->lang == 1 && file_exists("../APIPlantillas/mailing/validatedUser_i.php")) ? "_i" : "") . ".php";
		$args->data = new stdClass();
		$args->data->name = utf8_encode($data->name);
		$args->data->host = self::MAIN_FOLDER;

		if(!Mailer::sendEmail($data->email, utf8_encode($this->_responseCodeDB("06001")), $args))
			return "04002";

		return $data;
	}

	/**
	  * Envía el correo para recuperar contraseña.
	  *
	  * @param email 		Correo electrónico del usuario.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function sendForgotPassEmail($email){
		if(is_null($this->db->conn)) return "02005";
		if($email == "") return "01021";

		$email = strtolower($this->db->conn->real_escape_string($email));

		$sql = "SELECT id, nombreusuario AS name, validadousuario AS validated FROM usuarios WHERE emailusuario = '" . $email . "'";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04005";
		$data = $query->fetch_object();
		if($data->validated == '0'){
			$this->resendRegisterEmail($email);
			return "04022";
		}else if($data->validated == '2')
			return "04005";

		$token = md5($data->id . date("YmdHiS") . rand(10, 99));

		$sql = "
			UPDATE usuarios SET
				codigousuario = '" . $token . "'
			WHERE id = " . $data->id . "
			LIMIT 1
		";
		if(!$this->db->conn->query($sql)) return "02002";

		$args = new stdClass();
		$args->template = "../APIPlantillas/mailing/forgotPass" . (($this->lang == 1 && file_exists("../APIPlantillas/mailing/forgotPass_i.php")) ? "_i" : "") . ".php";
		$args->data = new stdClass();
		$args->data->name = utf8_encode($data->name);
		$args->data->token = $token;
		$args->data->host = self::MAIN_FOLDER;

		if(!Mailer::sendEmail($email, utf8_encode($this->_responseCodeDB("06003")), $args))
			return "04002";
		return true;
	}

	/**
	  * Reestablece la contraseña de un usuario.
	  *
	  * @param token 		Token para recuperar la contraseña.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function updateForgotedPass($token, $pass){
		if(is_null($this->db->conn)) return "02005";
		if($token == "") return "01023";
		if($pass == "") return "01022";

		$token = $this->db->conn->real_escape_string($token);

		$sql = "SELECT id FROM usuarios WHERE codigousuario = '" . $token . "' AND validadousuario = '1'";

		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04004";
		$data = $query->fetch_object();

		$sql = "
			UPDATE usuarios SET
				contrasenausuario = '" . md5($pass) . "',
				codigousuario = ''
			WHERE id = " . $data->id . "
			LIMIT 1
		";
		if(!$this->db->conn->query($sql))
			return "02002";
		return true;
	}

	/**
	  * Sube una imagen de un usuario.
	  *
	  * @param uid 			Identificador del usuario.
	  * @param file 		Archivo a subir.
	  *
	  * @return 			Objeto de datos, o código de error en caso de ocurrir.
	  */
	public function uploadImage($uid, $file){
		if(is_null($this->db->conn)) return "02005";
		if((is_integer($uid) && $uid > 0) == false) return "01026";


		$folder = "../recursos/usuarios/profile";
		IC_Image::makeDirectory($folder);

		if(empty($file))
			return "04021";

		$sizes = explode(',', '320,120,640,240');

		$targetPath = $folder . DIRECTORY_SEPARATOR . "fotos" . DIRECTORY_SEPARATOR;
		$temp = explode(".", $file['name']);
		$name = $uid . "_profile" . "." . $temp[count($temp) - 1];
		$targetFile = $targetPath . $name;

		$sql = "
			UPDATE usuarios SET
				imagenusuario = '" . str_replace('../recursos/', '', $targetFile) . "'
			WHERE id = " . $uid . "
			LIMIT 1
		";
		if(!$this->db->conn->query($sql)) return "02002";

		IC_Image::resizeImageWithImagick($file, $targetPath, $name, 100, 100, 60);
		IC_Image::resizeImageWithImagick($file, $targetPath . 'stock' . DIRECTORY_SEPARATOR, IC_Image::sufixImage($name, '_movLNormal'), $sizes[0], $sizes[0], 100);
		IC_Image::resizeImageWithImagick($file, $targetPath . 'stock' . DIRECTORY_SEPARATOR, IC_Image::sufixImage($name, '_movLM'), $sizes[1], $sizes[1], 100);
		IC_Image::resizeImageWithImagick($file, $targetPath . 'stock' . DIRECTORY_SEPARATOR, IC_Image::sufixImage($name, '_movHNormal'), $sizes[2], $sizes[2], 100);
		IC_Image::resizeImageWithImagick($file, $targetPath . 'stock' . DIRECTORY_SEPARATOR, IC_Image::sufixImage($name, '_movHMini'), $sizes[3], $sizes[3], 100);

		$response = new stdClass();
		$response->route = str_replace('../recursos/', '', $targetFile);
		$_SESSION["logged"]->image = $response->route;
		return $response;
	}

	/**
	  * Publica un mensaje en el Facebook del usuario
	  *
	  * @param uid 			Identificador del usuario.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function checkValidInfo($uid){
		if(is_null($this->db->conn)) return "02005";
		if((is_integer($uid) && $uid > 0) == false) return "01026";

		$sql = "
			SELECT 
				usuarios.emailusuario AS email,
				usuarios.ipaisusuario AS country,
				usuarios.iestadousuario AS state,
				usuarios.tel1usuario AS telephone,
				usuarios.nickusuario AS nick,
				usuarios.actualizadousuario AS updated  
			FROM usuarios 
			WHERE usuarios.id = " . $uid . "
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04007";
		$data = $query->fetch_object();

		$ex_email = '/^([a-zA-Z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';
		$ex_telephone = '/^\(?([0-9]{2,3})?\)?[0-9]{7,8}$/';

		$response = new stdClass();
		$response->email = preg_match($ex_email, $data->email) == 1 ? $data->email : false;
		$response->nick = $data->nick;
		$response->updated = $data->updated == '1';
		$response->country = intval($data->country) > 0 ? intval($data->country) : false;
		$response->state = intval($data->state) > 0 ? intval($data->state) : false;
		$response->telephone = preg_match($ex_telephone, $data->telephone) == 1 ? $data->telephone : false;

		return $response;
	}

	public function updateValidInfo($uid, $args = null){
		if(is_null($this->db->conn)) return "02005";
		if((is_integer($uid) && $uid > 0) == false) return "01026";
		if(!is_object($args)) $args = new stdClass();

		if(isset($args->email)){
			$args->email = strtolower($this->db->conn->real_escape_string(Functions::strip_tags_content($args->email)));
			$ex_email = '/^([a-zA-Z0-9_\.\-]+)@([\da-z\.\-]+)\.([a-z\.]{2,6})$/';
			if(preg_match($ex_email, $args->email)){
				$sql = "UPDATE usuarios SET emailusuario = '" . $args->email . "' WHERE id = " . $uid . " LIMIT 1";
				if(!$this->db->conn->query($sql)){
    				return ($this->db->conn->errno == "1022" || $this->db->conn->errno ==  "1062") ? "04001" : "02002";
				}
    			$_SESSION["logged"]->email = $args->email;
			}else
				return "01021";
		}else
			return "01021";

		if(isset($args->nick)){
			$args->nick = $this->db->conn->real_escape_string(Functions::strip_tags_content($args->nick));
			$ex_nick = '/^([a-zA-Z0-9\.\-_]{4,})$/';
			if(preg_match($ex_nick, $args->nick)){
				$urlusuario = $this->convierte_url_API($args->nick);
				$sql = "UPDATE usuarios SET nickusuario = '" . $args->nick . "',urlusuario='".$urlusuario."', actualizadousuario = '1' WHERE id = " . $uid . " LIMIT 1";
				if(!$this->db->conn->query($sql)){
    				return ($this->db->conn->errno == "1022" || $this->db->conn->errno ==  "1062") ? "04043" : "02002";
				}
			}else
				return "01029";
		}else
			return "01029";

		if(isset($args->country) && intval($args->country) > 0){
			$args->country = (int)Functions::strip_tags_content($args->country);
			$args->country = intval($args->country);
			$sql = "UPDATE usuarios SET ipaisusuario = " . (int)$args->country . " WHERE id = " . $uid . " LIMIT 1";
			if(!$this->db->conn->query($sql))
    			return "02002";
		}else
			return "01042";

		if(isset($args->country) && (intval($args->country) == 1 || intval($args->country) == 2)){
			if(isset($args->state) && intval($args->state) > 0){
				$args->state = (int)Functions::strip_tags_content($args->state);
				$args->state = intval($args->state);
				$sql = "UPDATE usuarios SET iestadousuario = " . (int)$args->state . " WHERE id = " . $uid . " LIMIT 1";
				if(!$this->db->conn->query($sql))
	    			return "02002";
			}else
				return "01043";
		}

		if(isset($args->telephone)){
			$args->telephone = $this->db->conn->real_escape_string(Functions::strip_tags_content($args->telephone));
			$ex_telephone = '/^\(?([0-9]{2,3})?\)?[0-9]{7,8}$/';
			if(preg_match($ex_telephone, $args->telephone)){
				$sql = "UPDATE usuarios SET tel1usuario = '" . $args->telephone . "' WHERE id = " . $uid . " LIMIT 1";
				if(!$this->db->conn->query($sql))
    				return "02002";
			}else
				return "01041";
		}else
			return "01041";

		return true;
	}
	public function convierte_url_API($titulo){
		$titulo =mb_strtolower($titulo);
		$titulo=html_entity_decode($titulo,ENT_COMPAT,"ISO-8859-1");
		$titulo=preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$titulo);
		$titulo = preg_replace("/[^a-z0-9_\s-]/", "", $titulo);
		$titulo = preg_replace("/[\s-]+/", " ", $titulo);
		$titulo = preg_replace("/[\s_]/", "-", $titulo);
		return $titulo;
	
	}
		

	/**
	  * Publica un mensaje en el Facebook del usuario
	  *
	  * @param uid 			Identificador del usuario.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function checkPublishPermissions($uid, $token = null){
		if(is_null($this->db->conn)) return "02005";
		if((is_integer($uid) && $uid > 0) == false) return "01026";

		if(!is_null($token))
			$facebook = $this->validAccessToken($token);
		else
			$facebook = $this->getAccessToken($uid);

		if(!is_object($facebook)) return $facebook;

		$config = new stdClass();
		$config->facebook = $facebook;

		$response = $this->getPermissionStatus($uid, $config);

		$data = new stdClass();
		$data->granted = $response->granted;
		if($data->granted == true)
			return $data;

		$sql = "SELECT usuarios.fbpublishusuario AS publicar FROM usuarios WHERE usuarios.id = " . $uid . "";
		$query = $this->db->conn->query($sql);
		$row = $query->fetch_object();
		$data->asked = $row->publicar == '1';

		return $data;
	}

	public function setPublishPermissions($uid, $token = null){
		if(is_null($this->db->conn)) return "02005";
		if((is_integer($uid) && $uid > 0) == false) return "01026";
		if(!is_null($token)) return "01023";

		$permission = $this->checkPublishPermissions($uid, $token);

		$sql = "
			UPDATE usuarios SET 
				fbpublishusuario = '1',
				" . (($permission->granted) ? "tokenfbusuario = '" . $token . "'," : "") . "
				activo = '1'
			WHERE id = " . $uid . "
			LIMIT 1
		";
		if(!$this->db->conn->query($sql))
			return "02002";

		if($permission->granted)
			if(isset($permission->asked)) unset($permission->asked);
		else
			$permission->asked = true;

		return $permission;
	}

	/**
	  * Publica un mensaje en el Facebook del usuario
	  *
	  * @param uid 			Identificador del usuario..
	  * @param message 		Mensaje a publicar.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
	public function publishFacebook($uid, $message){
		$facebook = $this->getAccessToken($uid);
		if(!is_object($facebook)) return $facebook;

		$config = new stdClass();
		$config->facebook = $facebook;

		$response = $this->getPermissionStatus($uid, $config);

		if($response->granted == false)
			return $response;

		$data = array(
			'message' => $message
		);
		$response = $facebook->api("/me/feed", "post", $data);

		if(!isset($response["id"]))
			return "04011";
		return true;
	}

	/**
	  * Actualiza las llaves del usuario para la aplicación.
	  *
	  * @param uid 			Identificador del usuario.
	  * @param key 			Llave del usuario.
	  * @param secret 		Llave secreta del usuario.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
    public function setTwitterKey($uid, $key, $secret){
    	if(is_null($this->db->conn)) return "02005";
    	if($key == "") return "01027";
    	if($secret == "") return "01028";

    	$key = $this->db->conn->real_escape_string(Functions::strip_tags_content($key));
    	$secret = $this->db->conn->real_escape_string(Functions::strip_tags_content($secret));

    	$sql = "
    		UPDATE usuarios SET
    			twitterkeyusuario = '" . $key . "',
    			twittersecretusuario = '" . $secret . "'
    		WHERE id = " . $data->id . "
    		LIMIT 1
    	";
    	if(!$this->db->conn->query($sql))
    		return "02002";
    	return true;
	}

	/**
	  * Publica un mensaje en el Twitter del usuario
	  *
	  * @param uid 			Identificador del usuario.
	  * @param message 		Mensaje a publicar.
	  *
	  * @return 			Booleano, o código de error en caso de ocurrir.
	  */
    public function publishTwitter($uid, $message){
		if(strlen($message) > 140)
			return "04012";

		$sql = "
			SELECT
				twitterkeyusuario AS 'key',
				twittersecretusuario AS secret
			FROM usuarios
			WHERE id = " . $uid . "
		";
		$query = $this->db->conn->query($sql);
		if($query->num_rows == 0) return "04007";
		$data = $query->fetch_object();

		$tweet = new TwitterOAuth(self::TWITTER_CONSUMER_KEY, self::TWITTER_CONSUMER_SECRET, $data->key, $data->secret);
		$response = $tweet->post('statuses/update', array('status' => $message));

		if(!isset($response->id))
			return $response;
		return true;
	}
/*! @protectedsection */

/*! @privatesection */
	/**
	 * Obtiene un nombre de usuario válido.
	 * @param name			Nombre de usuario.
	 *
	 * @return				Cadena de texto limpia de caracteres especiales.
	 */
	private function getValidUserName($name){
		if($name == "") $name = "usuario" . rand(0, 9);
		$sql = "SELECT nickusuario FROM usuarios WHERE nickusuario = '" . $name . "'";
		$query = $this->db->conn->query($sql);
		if($query->num_rows > 0)
			return $this->getValidUserName($name . rand(0, 9));
		else
			return $name;
	}

	/**
	 * Verifica la existencia de Facebook Token paraun usuario determinado.
	 *
	 * @param uid			Usuario del que se desea verificar token.
	 * @return				Devuelve arreglo de respuesta, con token en caso de seguir siendo válido.
	 */
	public function getAccessToken($uid){
		$sql = "SELECT fbusuario, tokenfbusuario FROM usuarios WHERE id = " . $uid . "";
		$query = $this->db->conn->query($sql);
		$data = $query->fetch_object();
		$token = $data->tokenfbusuario;

		if($token == "")
			return "01011";

		return self::validAccessToken($token);
	}


	/**
	  * Verifica la si un Token de Facebook es válido
	  *
	  * @param token 		Token de Facebook a verificar.
	  * @return 			Devuelve arreglo de respuesta, con objeto facebok en caso de ser válido.
	  */
	private function validAccessToken($token){
		$facebook = new Facebook(array(
			'appId'  => self::FACEBOOK_APP_ID,
			'secret' => self::FACEBOOK_APP_SECRET
		));
		$facebook->setAccessToken($token);
		$user = $facebook->getUser();
		if(!$user)
			return "01012";

		return $facebook;
	}

	/**
	  * Regresa el estado del permiso.
	  *
	  * @param uid			Identificador del usuario.
	  * @param $args		Alguno de los argumentos de configuracion, pudiendo ser:
	  *						"token" => Token de Facebook.
	  *						"facebook" => Objeto de Facebook.
	  *						"permission" => Permiso a buscar
	  * @return				Arreglo de datos de respuesta.
	  */
	private function getPermissionStatus($uid, $args = NULL){
		if((is_object($args) && (isset($args->token) || isset($args->facebook))) == false)
			$args["uid"] = $uid;

		if(is_object($args) && isset($args->permission)){
			$permission = $args->permission;
			unset($args->permission);
		}else
			$permission = "publish_actions";

		$response = $this->checkFacebookPermissions($args, $permission);
		$permission = new stdClass();
		if($response == false){
			$permission->granted = false;
			$permission->asked = false;
		}else if($response == "declined"){
			$permission->granted = false;
			$permission->asked = true;
		}else if($response == "granted"){
			$permission->granted = true;
		}

		return $permission;
	}

	/**
	  * Verifica los permisos de un usuario.
	  *
	  * @param $args		Alguno de los argumentos de configuración, pudiendo ser:
	  *						"token" => Token de Facebook.
	  *						"uid" => Usuarios conectado.
	  *						"facebook" => Objeto de Facebook.
	  * @param permission	Si existe, verifica que un permiso en especial exista, devolviendo TRUE o FALSE.
	  * @return				Devuelve arreglo de respuesta.
	 */
	private function checkFacebookPermissions($args, $permission = NULL){
		if(!is_object($args))
			return "01013";

		if(isset($args->token))
			$facebook = $this->validAccessToken($args->token);
		else if(isset($args->uid))
			$facebook = $this->getAccessToken($args->uid);
		else if(isset($args->facebook))
			$facebook = $args->facebook;
		else
			return "01013";

		if((!is_null($permission) & $permission != "") == false){
			$permissions = $facebook->api("v2.4/me/permissions", "get");
			return $permissions["data"];
		}else{
			$verify = false;
			$permissions = $facebook->api("v2.1/me/permissions?permission=" . $permission . "", "get");
			if(count($permissions["data"]) > 0)
				$verify = $permissions["data"][0]["status"];
			return $verify;
		}
		return false;
	}
}