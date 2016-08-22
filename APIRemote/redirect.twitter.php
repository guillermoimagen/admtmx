<?php
error_reporting(0);
session_start();
require_once("../API/lib/common.inc.php");
require_once('../API/lib/twitteroauth/twitteroauth.php');

$users = new Users();

$users->getAuthTwitter();
?>