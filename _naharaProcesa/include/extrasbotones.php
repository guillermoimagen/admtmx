<?
if($archivoactual=="ret.php")
{
?>
Ver en sitio: 
<a href="../iniciativaDetalle.php?idregistro=<?=$id?>" class="textoboton" target="_blank">&nbsp;Iniciativa&nbsp;</a>
<a href="../usuarioDetalle.php?idregistro=<?=$iusuarioret?>" class="textoboton" target="_blank">&nbsp;Usuario&nbsp;</a>&nbsp;&nbsp;&nbsp;
<?	
}
else if($archivoactual=="usuarios.php")
{
?>
Ver en sitio: 
<a href="../usuarioDetalle.php?idregistro=<?=$id?>" class="textoboton" target="_blank">&nbsp;Usuario&nbsp;</a>&nbsp;&nbsp;&nbsp;
<?	
}
?>