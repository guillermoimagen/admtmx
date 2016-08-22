<?
if(isset($_SESSION["sesionid"]) && $_SESSION["sesionid"]<>0)
{
if($statusdon==2) // pagado
{
	$colorBoton="FFdd00";	
	$textoBoton="Cancelar Pago";
}
else
{
	$colorBoton="55B856";	
	$textoBoton="Cambiar a Pagado";
}
?>
<div style="font-size:14px; width:300px; height:340px; position:absolute; background-color:<?=$vsitioscolor4?>; margin-top:20px; margin-left:10px; padding:10px; text-align:center;">
 CAMBIOS DE STATUS<BR>
 <hr>
 <div style="margin-bottom:6px; margin-top:8px;">Escribe los motivos</div>
 <input type="hidden" id="cambioid" name="cambioid" value="<?=$id?>">
 <textarea name="cambioRazones" id="cambioRazones" style="width:290px; height:150px; font-family:Arial"></textarea>
 <input type="button" style="background-color:#<?=$colorBoton?>; color:#FFFFFF; padding:5px; font-size:20px; width:290px;" value="<?=$textoBoton?>" onClick="cambioStatus();">

 <br><br>
<script>
function cambioStatus()
{
	if(document.getElementById("cambioRazones").value=="")
		alert('Debes proporcionar razones para el cambio de status');
	else
	{
		var r = confirm("Seguro de que deseas cambiar de status?");
		if (r == true)
			window.location.href='don.php?step=cambioStatus&cambioRazones='+document.getElementById("cambioRazones").value+'&id='+document.getElementById("cambioid").value;
	}
}
</script> 
 <hr>Ver en sitio:<br><br>
	<? if($iretdon<>0) { ?>
    <a href="../iniciativaDetalle.php?idregistro=<?=$iretdon?>" class="textoboton" target="_blank">&nbsp;Iniciativa&nbsp;</a>
    <? }  ?>
    <? if($iusuariodonodon<>0) { ?>
    <a href="../usuarioDetalle.php?idregistro=<?=$iusuariodonodon?>" class="textoboton" target="_blank">&nbsp;Acreedor&nbsp;</a>
    <? }  ?>
    <? if($iusuariodon<>0) { ?>
    <a href="../usuarioDetalle.php?idregistro=<?=$iusuariodon?>" class="textoboton" target="_blank">&nbsp;Beneficiario&nbsp;</a>
    <? }  ?>

</div>

<?
$res=@mysqli_query($GLOBALS["enlaceDB"],"select * from memo where idon=".$id);
if(mysqli_num_rows($res)>0)
{
?>
    <div style="font-size:14px; width:300px; height:340px; position:absolute;  background-color:<?=$vsitioscolor4?>; margin-top:20px; margin-left:340px; padding:10px; text-align:center;">
      DATOS DE TARJETA<BR>
     <hr>
     <?
	 while($row=mysqli_fetch_object($res))
	 {
		 echo("Tarjeta: ".$row->memotarjeta."<br>
		 	   Tipo tarjeta: ".$row->memotipotarjeta."<br>
			   Calle: ".$row->memocalle."<br>
			   N&uacute;mero: ".$row->memonumero."<br>
			   Colonia: ".$row->memocolonia."<br>
			   CP: ".$row->memocp."<br>
			   Ciudad: ".$row->memociudad."<br>
			   Estado: ".$row->memoestado."<br>
			   Tel&eacute;fono: ".$row->memotelefono."<br>
			   Nombre: ".$row->nombre."<br>");
	 }
	 ?>
	
    </div>
<? }
?>
<? } ?>