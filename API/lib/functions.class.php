<?
/**
 * @class Functions
 * @brief Clase de funciones principales para llamada estática.
 */
final class Functions
{

	/**
     * Limpia un array de caracteres especiales y de tags HTML.
     *
     * @param data      Array de parametros recibidos.
     *
     * @return          Array limpio de caracteres y código.
     */
	public static function cleanInputs($data){
		$clean_input = Array();
		if(is_array($data)){
			foreach ($data as $k => $v){
				$clean_input[$k] = $this->cleanInputs($v);
			}
		}else{
			$data = utf8_decode($data);
			$clean_input = @mysqli_real_escape_string($GLOBALS["enlaceDB"] ,trim(strip_tags($data)));
		}
		return $clean_input;
	}

	/**
	 * Elimina caracteres especiales de una cadena de texto.
	 * @param string		Cadena de texto.
	 * @param tolower		Convertir cadena a minusculas.
	 * @param all 			Determina si también elimina [.] y [_].
	 *
	 * @return				Cadena de texto limpia de caracteres especiales.
	 */
	public static function cleanSpecialChars($string, $tolower = true, $all = false, $spacesToDash = false){
		$string = trim($string);

		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);

		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);

		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);

		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);

		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);

		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);

		//Esta parte se encarga de eliminar cualquier caracter extraño
		$string = str_replace(
			array("\\", "¨", "º", "-", "~",
				"#", "@", "|", "!", "\"",
				"·", "$", "%", "&", "/",
				"(", ")", "?", "'", "¡",
				"¿", "[", "^", "`", "]",
				"+", "}", "{", "¨", "´",
				">", "< ", ";", ",", ":",
				'‘', '’', '\'', '“', '”', '"'),
			'',
			$string
		);

		if($all == true)
			$string = str_replace(
				array(".", ""),
				array("_", ""),
				$string
			);
		else
			$string = str_replace(
				array(".", " "),
				array("_", "_"),
				$string
			);

		if($spacesToDash == true)
			$string = str_replace(
				array("_", " "),
				array("-", "-"),
				$string
			);

		if($tolower) $string = strtolower($string);

		return $string;
	}

	public static function strip_tags_content($text, $tags = '', $invert = FALSE) { 
		/*preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags); 
		$tags = array_unique($tags[1]); 

		if(is_array($tags) AND count($tags) > 0){ 
			if($invert == FALSE) 
				return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text); 
			else
				return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text); 
		}else if($invert == FALSE)
			return preg_replace('@(<|&#60;?|&#x3c;|&lt;)(\S+).*?(>|&#62;?|&#x3e;|&gt;).*?(<|&#60;?|&#x3c;|&lt;)(/|&#47;?|&#x2f;)\2(>|&#62;?|&#x3e;|&gt;)@si', '', $text);*/
		/*return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text); */
		return preg_replace('@(<|&#60;?|&#x3c;|&lt;|>|&#62;?|&#x3e;|&gt;)@si', '', $text);
		return $text; 
	}

	/**
     * Obtiene información usando Curl.
     *
     * @param url 		Dirección del sitio a obtener.
	 *
	 * @return 			Respuesta del Curl en una variable de texto.
     */
	public static function fileGetContentsCurl($url) {
		if(strpos($url,'http://') !== FALSE || strpos($url,'https://') !== FALSE){
			$fc = curl_init();
			curl_setopt($fc, CURLOPT_URL,$url);
			curl_setopt($fc, CURLOPT_RETURNTRANSFER,TRUE);
			curl_setopt($fc, CURLOPT_HEADER,0);
			curl_setopt($fc, CURLOPT_VERBOSE,0);
			curl_setopt($fc, CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($fc, CURLOPT_TIMEOUT,30);
			$res = curl_exec($fc);
			curl_close($fc);
		}
		else $res = file_get_contents($url);
		return $res;
	}

	/**
	 * Obtiene la localización de un lugar a partir de la geolocalización.
	 * @param geo			Geolocalización a buscar.
	 * @return				Boolean false en caso de fallar y arreglo con la localización en caso de éxito.
	 */
	public static function getLocationByGeo($geo){
		if($geo == "")
			return false;

		$data = false;
		$request = new HttpRequest('http://maps.googleapis.com', "GET");
		$request->complement =  '/maps/api/geocode/json?sensor=false&language=ES&latlng=' . $geo;
		$request->host = "maps.googleapis.com";
		$request->send();
		$response = $request->getResponseBody();
		$json = json_decode($response);
		foreach($json->results[0]->address_components as $val){
			$v = false;
			foreach($val->types as $val2)
				if($val2 == "postal_code") $v = true;

			if($v) $data["postalCode"] = $val->short_name;
		}
		if($v){
			$temp = explode(",", $json->results[0]->formatted_address);
			$data["shortAddress"] = $temp[0];
			$data["address"] = $temp[0] . ", " . $temp[1] . ", " . $temp[2];
		}
		$data["city"] = $json->results[count($json->results) - 2]->formatted_address;
		return $data;
	}
}
?>