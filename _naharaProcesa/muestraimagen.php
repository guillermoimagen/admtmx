<? 
$valor=$_GET["imagen"];
$valor=str_replace("&","",$valor);
$valor=str_replace("<","",$valor);
$valor=str_replace(">","",$valor);
$valor=str_replace("\"","",$valor);
$valor=str_replace("'","",$valor);
$valor=str_replace("\\","",$valor);
?>
<html>
<head>
<title>Imagen: <?=$valor?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000" topmargin=0 leftmargin=0>
<img src="../recursos/<?=$valor?>">
</body>
</html>
