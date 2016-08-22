<?php
/**
 * @class IC_Validate
 * @brief Clase que define métodos principales para validaciones previas.
 */
final class IC_Validate
{
	public static function _checkHtppsConnection(){
		if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off")
            return true;
        if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            return true;
        return false;
	}

	/**
	 * Función que revisa si estEconectado un administrador.
	 *
	 * @return				Arreglo de respuesta, con error en caso de no existir, o con uid en caso de sEexistir.
	 */
	public static function _checkAdminLogged(){
		if(!isset($_SESSION["sesionid"]))
			return false;
		return $_SESSION['sesionid'];
	}

	/**
	 * Función que revisa si el level del usuario es de un administrador, pudiendo ser: "0" o "O".
	 *
	 * @return				Arreglo de respuesta, con error en caso de no existir, o con uid en caso de sEexistir.
	 */
	public static function _checkAdminLevel(){
		if(isset($_SESSION["nivelusuario"]) && ($_SESSION["nivelusuario"] == 0 || $_SESSION["nivelusuario"] == "O"))
			return true;
		return false;
	}

	/**
	 * Función que revisa si está conectado un usuarios.
	 *
	 * @return				Arreglo de respuesta, con error en caso de no existir, o con uid en caso de sEexistir.
	 */
	public static function _checkUserLogged(){
		if(!isset($_SESSION["logged"]))
			return false;
		return $_SESSION["logged"]->id;
	}

	public static function validateDigest($validate, $params){
		$params = (is_object($params)) ? $params : IC_Validate::cleanParams($params);

		if(isset($validate->{$params->action}) && $validate->{$params->action} == true){
			$keys = ICS_Functions::getKeys($params->api_key);
			$args = new stdClass();
			$args->token = $params->token;
			$args->date = $params->fechahoy;
			if(ICS_Functions::checkDigest($params->digest, $args, $keys) == false)
				return false;

			if($args->token != "")
				ICS_Functions::logInByToken($args, $keys);
		}

		return true;
	}

	public static function validateNotLogged($validate, $params){
		$params = (is_object($params)) ? $params : IC_Validate::cleanParams($params);

		if(isset($validate->{$params->action}) && $validate->{$params->action} == true){
			$uid = IC_Validate::_checkUserLogged();
			if($uid != false)
				return false;
			return $uid;
		}

		return true;
	}

	public static function validateLogged($validate, $params){
		$params = (is_object($params)) ? $params : IC_Validate::cleanParams($params);

		if(isset($validate->{$params->action}) && $validate->{$params->action} == true){
			$uid = IC_Validate::_checkUserLogged();
			if($uid == false)
				return false;
			return $uid;
		}

		return true;
	}

	public static function validateAdminLogged($validate, $params){
		$params = (is_object($params)) ? $params : IC_Validate::cleanParams($params);

		if(isset($validate->{$params->action}) && $validate->{$params->action} == true){
			$uid = IC_Validate::_checkAdminLogged();
			if($uid == false)
				return false;
			return $uid;
		}

		return true;
	}

	public static function cleanParams($params){
		foreach($params as $index => $val){
			if(
				(($index == "action") ||
				($index == "api_key") ||
				($index == "token") ||
				($index == "fechahoy") ||
				($index == "digest")) == false
			)
				unset($params[$index]);
		}

		return (object)$params;
	}
}
?>