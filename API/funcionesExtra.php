<?php

function stripAccents($stripAccents){
	$stripAccents=strtr($stripAccents,'ΰαβγδηθικλμνξορςστυφωϊϋόύÿΐΑΒΓΔΗΘΙΚΛΜΝΞΟΡÒΣΤΥΦΩΪΫάέ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	$stripAccents=str_replace(array('.', ',', '-', '/', '‘', '!', '?', 'Ώ', ':'), '' , $stripAccents);
	$stripAccents = preg_replace('/[0-9]+/', '', $stripAccents);
	return $stripAccents;
}

function haceLinks($stripAccents){
	$stripAccents=strtr($stripAccents,'ΰαβγδηθικλμνξορςστυφωϊϋόύÿΐΑΒΓΔΗΘΙΚΛΜΝΞΟΡÒΣΤΥΦΩΪΫάέ$','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUYs');
	$stripAccents=str_replace(' ', '_', $stripAccents);
	//$stripAccents=str_replace(array('.', ',', '-', '?', 'Ώ', '!', '‘', '', '`', "'"), '' , $stripAccents);
	$stripAccents=preg_replace('/[^\w]/', '', $stripAccents);
	//$stripAccents = preg_replace('/[0-9]+/', '', $stripAccents);
	$stripAccents=strtolower($stripAccents);
		$stripAccents=substr($stripAccents,0,20);

	return $stripAccents;
}

function haceCarpeta($stripAccents){
	$stripAccents=strtr($stripAccents,'ΰαβγδηθικλμνξορςστυφωϊϋόύÿΐΑΒΓΔΗΘΙΚΛΜΝΞΟΡÒΣΤΥΦΩΪΫάέ$','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUYs');
	$stripAccents=str_replace(' ', '_', $stripAccents);
	$stripAccents=preg_replace('/[^\w]/', '', $stripAccents);
	$stripAccents=strtolower($stripAccents);
	return substr($stripAccents, 0, 30);
}

function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
{
	//create the URL
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;	
	//get the url
	//could also use cURL here
	$response = file_get_contents($bitly);
	
	//parse depending on desired format
	if(strtolower($format) == 'json')
	{
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	}
	else //xml
	{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}
?>