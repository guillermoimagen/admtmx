<?
error_reporting(0);
session_start();
require_once("../API/lib/common.inc.php");

$content = new Content();

/*if($_GET["action"] == "sessionPrint"){
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	die();
}*/

/*if(IC_Validate::_checkHtppsConnection() != true)
	$content->_response((object)array("status" => 400, "code" => "04034"));*/


switch($_GET["action"]){
	case "listCountries":
		$response = $content->listCountries();
		if(is_array($response))
			$content->_response((object)array("status" => 200, "data" => $response, "flat" => false));
		else
			$content->_response((object)array("status" => 400, "code" => $response));
	break;
	case "listStates":
		$response = $content->listStates(intval($_GET["pid"]));
		if(is_array($response))
			$content->_response((object)array("status" => 200, "data" => $response, "flat" => false));
		else
			$content->_response((object)array("status" => 400, "code" => $response));
	break;
	default:
		$content->_response((object)array("status" => 405));
	break;
}
?>