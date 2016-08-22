<?
error_reporting(0);
session_start();
require_once("../API/lib/common.inc.php");
require_once("../API/lib/facebooksdk/facebook.php");
require_once('../API/lib/twitteroauth/twitteroauth.php');

$users = new Users((object)array("lang" => ((isset($_REQUEST["idioma"])) ? intval($_REQUEST["idioma"]) : 0) ));

/*if($_GET["action"] == "sessionPrint"){
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	die();
}*/

/*if(IC_Validate::_checkHtppsConnection() != true)
	$users->_response((object)array("status" => 400, "code" => "04034"));*/

$validate = new stdClass();
$validate->logged = new stdClass();
$validate->logged->uploadImage = true;
$validate->logged->connectFacebook = true;
$validate->logged->checkPublishPermissions = true;
$validate->logged->publishFacebook = true;
$validate->logged->publishTwitter = true;
$validate->logged->setTwitterKey = true;
$validate->logged->checkValidInfo = true;
$validate->logged->updateValidInfo = true;
$validate->logged->logOutUser = true;

$uid = IC_Validate::validateLogged($validate->logged, $_GET);
if($uid == false) $users->_response((object)array("status" => 400, "code" => "01006"));
else $uid = intval($uid);

switch($_REQUEST["action"]){
	case "signUpUser":
		require_once('../include/recaptcha/src/autoload.php');
		if(isset($_POST["g-recaptcha-response"]) && $_POST["g-recaptcha-response"] != ""){
			$response = $users->_checkReCaptcha($_POST["g-recaptcha-response"]);
			if($response == true){
				$response = $users->signUpUser($_POST["email"], $_POST["pass"], $_POST["name"], $_POST["nick"]);
				if(is_object($response))
					$users->_response((object)array("status" => 200, "code" => "05001"));
				else
					$users->_response((object)array("status" => 400, "code" => $response));
			}else
				$users->_response((object)array("status" => 400, "code" => "04033"));
		}else
			$users->_response((object)array("status" => 400, "code" => "04033"));
	break;
	case "logInUser":
		require_once('../include/recaptcha/src/autoload.php');
		if(isset($_POST["g-recaptcha-response"]) && $_POST["g-recaptcha-response"] != ""){
			$response = $users->_checkReCaptcha($_POST["g-recaptcha-response"]);
			$response = true;
			if($response == true){
				$response = $users->logInUser($_POST["email"], $_POST["pass"], $_POST["keep"] == '1');
				if(is_object($response))
					$users->_response((object)array("data" => $response, "status" => 200));
				else
					$users->_response((object)array("status" => 400, "code" => $response));
			}else
				$users->_response((object)array("status" => 400, "code" => "04033"));
		}else
			$users->_response((object)array("status" => 400, "code" => "04033"));
	break;
	case "logInFacebook":
		$response = $users->logInFacebook($_POST["oAuthToken"], ((isset($_POST["keep"])) ? $_POST["keep"] == '1' : false));
		if(is_object($response))
			$users->_response((object)array("data" => $response, "status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "connectFacebook":
		$response = $users->connectFacebook($uid, $_POST["oAuthToken"]);
		if(is_bool($response) && $response == true)
			$users->_response((object)array("status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "logOutUser":
		$response = $users->logOutUser();
		if(is_bool($response) && $response == true)
			$users->_response((object)array("status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "validateUser":
		$response = $users->validateUser($_POST["tokenTemporal"]);
		if(is_object($response)){
			$response = $users->logInUserById(intval($response->id));
			if(is_object($response))
				$users->_response((object)array("data" => $response, "status" => 200));
			else
				$users->_response((object)array("status" => 400, "code" => $response));
		}else
			$users->_response((object)array("status" => 400, "code" => $response));

	break;
	case "resendRegisterEmail":
		$response = $users->resendRegisterEmail($_POST["email"]);
		if(is_bool($response) && $response == true)
			$users->_response((object)array("status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "sendForgotPassEmail":
		$response = $users->sendForgotPassEmail($_POST["email"]);
		if(is_bool($response) && $response == true)
			$users->_response((object)array("status" => 200, "code" => "05003"));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "updateForgotedPass":
		$response = $users->updateForgotedPass($_POST["tokenTemporal"], $_POST["pass"]);
		if(is_bool($response) && $response == true)
			$users->_response((object)array("status" => 200, "code" => "05004"));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "uploadImage":
		$response = $users->uploadImage($uid, $_FILES["file"]);
		if(is_object($response))
			$users->_response((object)array("data" => $response, "status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "checkValidInfo":
		$response = $users->checkValidInfo($uid);
		if(is_object($response))
			$users->_response((object)array("data" => $response, "status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "updateValidInfo":
		$args = new stdClass();
		if(isset($_POST["nick"])) $args->nick = $_POST["nick"];
		if(isset($_POST["email"])) $args->email = $_POST["email"];
		if(isset($_POST["telephone"])) $args->telephone = $_POST["telephone"];
		if(isset($_POST["country"])) $args->country = $_POST["country"];
		if(isset($_POST["state"])) $args->state = $_POST["state"];
		$response = $users->updateValidInfo($uid, $args);
		if(is_bool($response) && $response == true)
			$users->_response((object)array("status" => 200, "code" => "05002"));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "checkPublishPermissions":
		$response = $users->checkPublishPermissions($uid, ((isset($_GET["oAuthToken"])) ? $_GET["oAuthToken"] : null));
		if(is_object($response))
			$users->_response((object)array("data" => $response, "status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "setPublishPermissions":
		$response = $users->setPublishPermissions($uid, ((isset($_POST["oAuthToken"])) ? $_POST["oAuthToken"] : null));
		if(is_object($response))
			$users->_response((object)array("data" => $response, "status" => 200, "code" => (($response->granted == true) ? "04031" : "04032")));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "publishFacebook":
		$response = $users->publishFacebook($uid, $_POST["message"]);
		if(is_bool($response))
			$users->_response((object)array("status" => 200));
		else if(is_object($response))
			$users->_response((object)array("data" => $response, "status" => 400));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "setTwitterKey":
		$response = $users->setTwitterKey($uid, $_POST["key"], $_POST["secret"]);
		if(is_bool($response))
			$users->_response((object)array("status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "publishTwitter":
		$response = $users->publishTwitter($uid, $_POST["message"]);
		if(is_bool($response))
			$users->_response((object)array("status" => 200));
		else if(is_object($response))
			$users->_response((object)array("data" => $response, "status" => 400));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;

	case "checkValidSauthToken":
		$response = ICS_Functions::checkValidToken($_GET["token"]);
		if($response == true)
			$users->_response((object)array("data" => $response, "status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "refreshSauthToken":
		$response = ICS_Functions::refreshToken($_GET["token"], $_GET["refresh_token"]);
		if($response->response == true)
			$users->_response((object)array("data" => $response, "status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;
	case "deleteSauthExpiredTokens":
		$response = ICS_Functions::deleteExpiredTokens();
		if(is_integer($response))
			$users->_response((object)array("data" => $response, "status" => 200));
		else
			$users->_response((object)array("status" => 400, "code" => $response));
	break;

	default:
		$users->_response((object)array("status" => 405));
	break;
}
?>