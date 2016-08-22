<?php
error_reporting(0);
session_start();
require_once("../API/lib/common.inc.php");
require_once('../API/lib/twitteroauth/twitteroauth.php');

$users = new Users();

$response = $users->loginTwitter($_SESSION['oauth_token'], $_SESSION['oauth_token_secret'], $_GET["oauth_verifier"]);
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);
header('Location: ../'); 
?>