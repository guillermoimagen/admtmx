<?php
session_start();
include_once 'recursos/entrada.php';
include_once 'recursos/xss_var.php';


include_once '../include/connection.php';
include_once '../API/funcionesExtra.php';

//atrapar los parametros
$tabla=(int)$_GET['itabla'];
$registro=(int)$_GET['registro'];
if(isset($_GET['ruta'])) {
	valores_texto($_GET["ruta"],15);

	$ruta=$_GET['ruta'];
} else {
	$ruta='fotos';
}

// armamos la dirección del folder
$tipo="";
$campo="";
$extraInfo="";
$sql=mysqli_query($GLOBALS["enlaceDB"] ,'SELECT ayudatabla,campotabla FROM catablas WHERE idtabla=' . $tabla);
$fila=mysqli_fetch_array($sql, MYSQLI_ASSOC);
$tipo=rtrim($fila['ayudatabla'], 's');
$campo=rtrim($fila['campotabla'], 's');

if($campo<>'' && $tipo<>'') {
	$extraInfoPre=mysqli_query($GLOBALS["enlaceDB"] ,'SELECT '.$campo.' AS titulo FROM ' . $fila['ayudatabla'] . ' WHERE id=' . $registro);
	$filaInfo=mysqli_fetch_array($extraInfoPre, MYSQLI_ASSOC);
	$extraInfo=haceLinks($filaInfo['titulo'])."/";
}

$folder='../recursos/' . $tipo . '/' . $extraInfo . '/' . $ruta;
$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select * from cfotos where identificadorcfoto='".$ruta."'");
while($row=mysqli_fetch_object($res))
{
	$cfoto=$row->id;
	$acceptedFiles=".".str_replace(",",",.",$row->archivospermitidoscfoto);
	$actionPath='guardarimagenes.php?folder=' . $folder . '&itabla=' . $tabla . '&registro=' . $registro . '&cfoto=' . $cfoto;
}


?>

<link href="include/guardarimagenes/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />
<link href="include/guardarimagenes/fancyBox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<link href="include/guardarimagenes/guardarimagenes.css" rel="stylesheet" type="text/css" />

<script src="../include/jquery/jquery-1.7.1.min.js"></script>
<script src="include/guardarimagenes/dropzone/dropzone.js"></script>
<script src="include/guardarimagenes/fancyBox/source/jquery.fancybox.pack.js"></script>
<script>
Dropzone.options.myDropzone={
	addRemoveLinks:true,
	dictRemoveFile:'Editar',
	acceptedFiles:'<?php echo $acceptedFiles; ?>',
	removedfile:function() {},
	init: function() {
        thisDropzone=this;
        $.get('guardarimagenes.php?registro=<?=(int)$_GET["registro"]?>&itabla=<?=(int)$_GET["itabla"]?>&cfoto=<?=(int)$cfoto?>', function(data) {
            $.each(data, function(key,value){
                //var mockFile={name:value.name, size:value.size};
                var mockFile={name:value.name, size:value.size, activo:value.activo}; //línea nueva
                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "../recursos/"+value.name);
            });
        });
		thisDropzone.on('removedfile', function(file) {
				var file=file.name;
				var folder='<?php echo $folder; ?>';
				var tabla='<?php echo $tabla; ?>';
				var registro='<?php echo $registro; ?>';
				var tipo='<?php echo $tipo; ?>';
				var ruta='<?php echo $ruta; ?>';
				var locacion='editarimagenes.php?folder='+folder+'&file='+file+'&itabla='+tabla+'&registro='+registro+'&tipo='+tipo+'&ruta='+ruta;
				//window.location=locacion;
				$.fancybox.open({
					padding:0,
					href:locacion,
					type: 'iframe',
					height:300,
					fitToView : false,
					autoSize : false
				});
		});
    },
};
</script>
<script>
	$(document).ready(function() {
		$('#cambiaruta').on('change', function() {
			
			window.location=$(this).val();
		});
	});
</script>

<body>

<select id="cambiaruta">
<? $res=@mysqli_query($GLOBALS["enlaceDB"] ,"select * from cfotos where activo=1");
	while($row=mysqli_fetch_object($res))
	{
		$sel="";
		if($ruta==$row->identificadorcfoto) $sel=" selected";
		?>
    <option value="subirimagenes.php?itabla=<?=$tabla?>&registro=<?=$registro?>&ruta=<?=$row->identificadorcfoto?>" <?=$sel?>><?=$row->nombrecfoto?></option>
    <? } ?>
</select>

<div id="main" style="min-height:480px;height:480px;overflow:scroll">
	<form action="<?php echo $actionPath; ?>" class="dropzone" id="my-dropzone"></form>
</div>

</body>
</html>