<?
session_start();
error_reporting(0);
require_once("../API/lib/common.inc.php");
if($_GET["modo"]=="validaUsuario"){
		$users = new Users();
		$response = $users->validateUser($_GET["token"]);
		if(is_object($response))
			$response = $users->logInUserById(intval($response->id));

		header("Location: ../../");
}
?>