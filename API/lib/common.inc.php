<?php
if(!isset($dir)) $dir = "../";
$dir = realpath(dirname(__FILE__));
$dir = preg_replace('/(.*)public_html(.*)/', '$1public_html/', $dir);
define("FOLDER_URL", $dir);
define("LOCAL_LIB", FOLDER_URL . "API/lib/");
function ic_autoload($class_name){
	$class_name = strtolower($class_name);
	if(file_exists(LOCAL_LIB . $class_name . '.class.php' )){
		require_once(LOCAL_LIB . $class_name . '.class.php');
	}else{
		$search_subdirs = array('IC_Views', 'IC_sAuth', 'Clickatell');
		foreach ($search_subdirs as $file){
			$file_full = LOCAL_LIB . $file . DIRECTORY_SEPARATOR . $class_name . '.class.php';
			if(file_exists($file_full)){
				require_once($file_full);
				return true;
			}
		}
		return false;
	}
}
spl_autoload_register("ic_autoload");
?>