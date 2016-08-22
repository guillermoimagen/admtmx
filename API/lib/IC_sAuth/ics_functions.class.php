<?
/**
 * @class ICS_Functions
 * @brief Clase para las funciones estáticas de la autentificación con Imagen Central.
 */
class ICS_Functions
{
	const DEFAULT_API_KEY = 'apikeyhumano';
	const DEFAULT_SECRET_KEY = 'secrethumano';
	const USER_TABLE = 'usuarios';
	const TOKEN_TABLE = 'sauth_tokens';

	/**
     * Obtiene la llave secreta a partir de la llave.
     *
     * @param key 			Llave del ciente de sAuth.
     *
     * @return              Arreglo de respuesta, si el login se hizo con éxito, vendrá acompañado de los tokens sAuth.
     */
	function getKeys($key){
		$db = new DB();

        if($key == "") $key = self::DEFAULT_API_KEY;
        if($key == "")
        	return false;

		$sql = "SELECT secret_sauth_clients FROM sauth_clients WHERE apikey_sauth_clients='" . $key . "' AND activo = '1'";
		$query = $db->conn->query($sql);
		if($query->num_rows == 0) return false;
		$data = $query->fetch_object();

		$keys = new stdClass();
		$keys->api = $key;
		$keys->secret = $data->secret_sauth_clients;

		return $keys;
	}

	/**
     * Revisa si el token enviado a caducado.
     *
     * @param token 		Token de sAuth.
     *
     * @return              Booleano, true/false.
     */
	function checkValidToken($token){
		$db = new DB();

        if($token == "")
        	return false;

		$sql = "
			SELECT
				IF(expiration_sauth_token <= DATE_SUB(NOW(), INTERVAL 10 HOUR), 0, 1) AS validated
			FROM " . self::TOKEN_TABLE . "
			WHERE token_sauth_token = '" . $token . "'
		";
		$query = $db->conn->query($sql);
		if($query->num_rows == 0) return false;
		$data = $query->fetch_object();

		return $data->validated == '1';
	}

	/**
     * Verifica que el digest sea correcto.
     *
     * @param args 			Objeto de argumentos para verificar.
     * @param keys 			Objeto de llaves de sAuth.
     *
     * @return              Arreglo de respuesta, si el login se hizo con éxito, vendrá acompañado de los tokens sAuth.
     */
	function checkDigest($digest, $args = null, $keys = null){
		if(!is_object($args)) $args = new stdClass();
		if(!isset($args->token)) $args->token = "";
		if(!isset($args->date)) $args->date = "";
		if(!is_object($keys)) $keys = new stdClass();
		if(!isset($keys->api)) $keys->api = "";
		if(!isset($keys->secret)) $keys->secret = "";

		$server = $_SERVER['SERVER_NAME'];
		if(strpos($_SERVER['SERVER_NAME'], "www") === FALSE)
			$server = "www." . $_SERVER['SERVER_NAME'];
		$file = "http://" . $server . $_SERVER['REQUEST_URI'];
		$temp = explode("&api_key", $file);
		$url = $temp[0];

		$digest_t = hash('sha256', $keys->secret . "/" . $url . "/" . $keys->api . "/" . $args->token . "/" . $args->date);

		return $digest == $digest_t;
	}



	/**
     * Verificación con sAuth de la conexión y establecimiento de las sesiones para la misma.
     *
     * @param args          Argumentos que serán usados para la verificación con sAuth.
     * @param key 			Objeto con las llaves de sAuth.
     *
     * @return              Arreglo de respuesta, si el login se hizo con éxito, vendrá acompañado de los tokens sAuth.
     */
    function logIn($args, $key = null){
        if(!is_object($args))
            $args = new stdClass();
        if(!is_object($key))
        	$key = new stdClass();
        if(!isset($key->api) || $key->api == "") $key->api = self::DEFAULT_API_KEY;
        if(!isset($key->secret) || $key->secret == "") $key->secret = self::DEFAULT_SECRET_KEY;
		
        if($key->api == "" || $key->secret == "")
        	return false;

        $args->apiKey = $key->api;
        $args->secret = $key->secret;
        $args->table = self::USER_TABLE;
        $args->tableToken = self::TOKEN_TABLE;

        $sauth = new ICS_sAuth($args);
        $response = json_decode($sauth->getToken());
        if($response->code == 1){
            $time = 3600;
            session_set_cookie_params($time);
            $_SESSION['token'] = $response->token;
            $_SESSION['refresh_token'] = $response->refreshToken;

            $data = new stdClass();
            $data->response = true;
            $data->token = $response->token;
            $data->tokenID = $response->tokenID;
            $data->refreshToken = $response->refreshToken;

            return $data;
        }else{
            $data = new stdClass();
            $data->response = false;
            $data->data = $response;
            return $data;
        }
    }

	/**
     * Verificación con sAuth de la conexión y establecimiento de las sesiones para la misma.
     *
     * @param args          Argumentos que serán usados para la verificación con sAuth.
     * @param key 			Objeto con las llaves de sAuth.
     *
     * @return              Arreglo de respuesta, si el login se hizo con éxito, vendrá acompañado de los tokens sAuth.
     */
    function logInByToken($args, $key = null){
        if(!is_object($args))
            $args = new stdClass();

        if(!is_object($key))
        	$key = new stdClass();
        if(!isset($key->api) || $key->api == "") $key->api = self::DEFAULT_API_KEY;
        if(!isset($key->secret) || $key->secret == "") $key->secret = self::DEFAULT_SECRET_KEY;

        if($key->api == "" || $key->secret == "")
        	return false;

        $args->apiKey = $key->api;
        $args->secret = $key->secret;
        $args->table = self::USER_TABLE;
        $args->tableToken = self::TOKEN_TABLE;

        $sauth = new ICS_sAuth($args);
        $response = json_decode($sauth->loginToken());
        if($response->code == 1){
            $time = 3600;
            session_set_cookie_params($time);
            $_SESSION['token'] = $response->token;
            $_SESSION['refresh_token'] = $response->refreshToken;

            $data = new stdClass();
            $data->response = true;
            $data->token = $response->token;
            $data->tokenID = $response->tokenID;
            $data->refreshToken = $response->refreshToken;
            $data->tokenCMS = $response->tokenCMS;

            return $data;
        }else{
            $data = new stdClass();
            $data->response = false;
            $data->data = $response;
            return $data;
        }
    }

    /**
     * Actualiza un token de sAuth.
     *
     * @param args          Argumentos que serán usados para la verificación con sAuth.
     * @param key 			Objeto con las llaves de sAuth.
     *
     * @return              Arreglo de respuesta, si el login se hizo con éxito, vendrá acompañado de los tokens sAuth.
     */
    function refreshToken($token, $refresh, $keys = null){
        if(!is_object($keys))
        	$keys = new stdClass();
        if(!isset($keys->api) || $keys->api == "") $keys->api = self::DEFAULT_API_KEY;
        if(!isset($keys->secret) || $keys->secret == "") $keys->secret = self::DEFAULT_SECRET_KEY;

        if($keys->api == "" || $keys->secret == "")
        	return false;

        $args = new stdClass();
        $args->apiKey = $key->api;
		$args->secret = $key->secret;
		$args->table = self::USER_TABLE;
		$args->tableToken = self::TOKEN_TABLE;

		$sauth = new ICS_sAuth($args);
		$data = new stdClass();
		$data->token = $token;
		$data->refreshToken = $refresh;

		$response = json_decode($sauth->refreshToken($data));
        if($response->code == 1){
            $data = new stdClass();
            $data->response = true;
            $data->token = $response->token;
            $data->refreshToken = $response->refreshToken;

            return $data;
        }else{
            $data = new stdClass();
            $data->response = false;
            $data->data = $response;

            return $data;
        }
    }

    /**
     * Elimina tokens no vigentes
     *
     * @return              Arreglo de respuesta, si el login se hizo con éxito, vendrá acompañado de los tokens sAuth.
     */
    function deleteExpiredTokens(){
    	$db = new DB();

    	$sql = "DELETE FROM sauth_tokens WHERE delete_sauth_token < DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    	if(!$db->conn->query($sql))
    		return false;

    	return $db->conn->affected_rows;
    }
}
?>