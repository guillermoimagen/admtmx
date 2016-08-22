<?

// AQUI LEEMOS LA TABLA PARA VER TODA SU CONFIGURACION
$resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select * from catablas where idtabla=".$numerodetabla);
while($rowx = mysqli_fetch_array($resultx))
{
	$campopredeterminadotabla=$rowx["campopredeterminadotabla"];
}
?>