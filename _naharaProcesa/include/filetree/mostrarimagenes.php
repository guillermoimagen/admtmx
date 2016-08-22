<?php
session_start();
include_once '../../recursos/entrada.php';
include_once '../../recursos/xss_var.php';
//atrapar el directorio
if($_GET['subdir']!='') {
	$subdirectorio=$_GET['subdir'];
	$subdirectorio=str_replace("'","",$subdirectorio);
	$subdirectorio=str_replace("\"","",$subdirectorio);
	$subdirectorio=str_replace("<","",$subdirectorio);
	$subdirectorio=str_replace(">","",$subdirectorio);
} else {
	$subdirectorio=$_SESSION['carpetaciudad'];
}
$expanded='../../../recursos/' . $subdirectorio . '/';

$objeto=trim($_GET['objeto'], '#');
$objeto=str_replace("'","",$objeto);
$objeto=str_replace("\"","",$objeto);
$objeto=str_replace("<","",$objeto);
$objeto=str_replace(">","",$objeto);

//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Seleccionar imagen</title>
<script src="jquery.js"></script>
<script src="jqueryeasing.js"></script>
<script src="jqueryFileTree.js"></script>
<link href="jqueryFileTree.css" rel="stylesheet" />
<script>
$(document).ready( function() {
				
	$('#fileTreeDemo_1').fileTree(
		{
			root: '../../../recursos/<?php echo $_SESSION['carpetaciudad']; ?>/', 
			//root:'../../../recursos/coahuila/',
			script: 'jqueryFileTree.php',
			multiFolder:false,
			expanded:'<?php echo $expanded; ?>'
		},
		function(file) {
			var archivo=file.replace('../../../recursos/', '');
			//window.opener.$('#<?php echo $objeto; ?>').val(archivo);
			window.opener.document.getElementById('<?php echo $objeto; ?>').value=archivo;
			self.close();
		}
	);
				
});
</script>
</head>

<body>

<div id="fileTreeDemo_1"></div>

</body>
</html>