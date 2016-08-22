<?php
session_start();
include("recursos/entrada.php"); 
include("recursos/xss_var.php");

include_once '../include/connection.php';
include_once '../API/funcionesExtra.php';

//atrapar los parametros
$folder=str_replace("'","",$_GET['folder']);
$file=str_replace("'","",$_GET['file']);
$tabla=(int)$_GET['itabla'];
$registro=(int)$_GET['registro'];
//$tipo=$_GET['tipo'];

valores_texto($_GET["ruta"],15);
$ruta=$_GET['ruta'];

//echo "folder:$folder file:$file tabla:$tabla registro:$registro tipo:$tipo ruta:$ruta";

//crear el arreglo de datos para borrar
if($ruta=='fotos') {
	$data='pedido:"borraimagen", folder:"' . $folder . '", file:"' . $file . '", tabla:' . $tabla . ', registro:' . $registro;
} else if($ruta=='archivos') {
	$data='pedido:"borraarchivo", folder:"' . $folder . '", file:"' . $file . '"';
}

//traer los datos en espanol
$sql=@mysqli_query($GLOBALS["enlaceDB"] ,'SELECT id, titulofoto, descripcionfoto, ordenfoto, activo FROM fotos WHERE archivofoto="' . mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$file) . '" AND itablafoto=' . $tabla . ' AND registrofoto=' . $registro);
while($row=mysqli_fetch_object($sql)) {
	
	if($row->activo==0) {
		$row->claseactivo='inactiva';
	} else {
		$row->claseactivo='';
	}
	$foto[]=$row;
}
//echo 'SELECT id, titulofoto, comentariosfoto, ordenfoto, activo FROM fotos WHERE archivofoto="' . str_replace('../recursos/', '', $folder) . '/' . $file . '" AND itablafoto=' . $tabla . ' AND registrofoto=' . $registro;
//print_r($foto);


?>

<!--<script src="../include/jquery/jquery-1.7.1.min.js"></script>
<script src="../include/fancyBox/source/jquery.fancybox.pack.js"></script>-->
<script src="../include/jquery/jquery-1.7.1.min.js"></script>
<script src="include/guardarimagenes/fancyBox/source/jquery.fancybox.pack.js"></script>
<link href="include/guardarimagenes/guardarimagenes.css" rel="stylesheet" type="text/css" />

<div id="main" style="min-height:200px">

    <div id="left">
        <div id="imagecontainer">
            <img class="imagenedicion <?php echo $foto[0]->claseactivo; ?>" src="<?php echo  '../recursos/' . $file; ?>" />
        </div>
        <?php if($_SESSION['superusuario']==1) { ?>
        <input type="submit" id="deletebutton" class="botonGI" value="Eliminar Archivo" />
        <?php } ?>
	</div>
    
    <?php if($ruta=='fotos') { ?>
    <div id="right"><br />
    	<label for="fototitulo" class="etiqueta">T&iacute;tulo:</label>
        <input type="text" id="fototitulo" class="entrada" value="<?php echo $foto[0]->titulofoto; ?>" /><br />
        <label for="fotocomentarios" class="etiqueta">Comentarios:</label>
        <textarea id="fotocomentarios" class="entrada" cols="50"><?php echo $foto[0]->descripcionfoto; ?> </textarea><br />
        <label for="fotoorden" class="etiqueta">Orden:</label>
        <input type="text" id="fotoorden" class="entrada" value="<?php echo $foto[0]->ordenfoto; ?>" /><br />
        <label for="fotoactivo" class="etiqueta">Activa:</label>
        <input type="checkbox" id="fotoactivo" <?php if($foto[0]->claseactivo!='inactiva') echo 'checked'; ?> /><br />
        <input id="updatebutton" class="botonGI" type="submit" style="margin-left:80px" value="Guardar" />
        
    </div>
    <? } ?>
    
     
    
</div>

<script>
$(document).ready(function() {
	
	$('#deletebutton').on('click', function() {
		var answer=confirm('desea borrar este archivo?');
		if(answer) {
			$.ajax({
				url:'borrarimagenes.php',
				type:'POST',
				data:{<?php echo $data; ?>},
				success:function() {
					parent.$.fancybox.close();
					self.parent.location.reload();
				}
			});
		} else {
			parent.$.fancybox.close();
		}
		
	});
	
	//-----para actualizar los datos---------------------------------------------------------------------
	$('#updatebutton').on('click', function() {
		//obtener los datos para la consulta ajax
		var arreglo=[];
		$.each($('.idioma'), function() {
			var id=$(this).attr('id')
			var titulo=$(this).children('#fototitulo'+id).val();
			var comentarios=$(this).children('#fotocomentarios'+id).val();
			var hijo=[id, titulo, comentarios]
			arreglo.push(hijo);
		})
		var datosjson=JSON.stringify(arreglo);
		//obtener los datos del registro
		var id=<?php echo $ruta=='fotos' ? $foto[0]->id : 0; ?>;
		var titulo=$('#fototitulo').val();
		var comentarios=$('#fotocomentarios').val();
		var orden=$('#fotoorden').val();
		if($('#fotoactivo').prop('checked')) {
			var activo=1;
		} else {
			var activo=0;
		}
		//hacer llamada ajax
		$.ajax({
			url:'borrarimagenes.php',
			type:'POST',
			data:{pedido:'actualiza', titulo:titulo, comentarios:comentarios, orden:orden, activo:activo, id:id, datosjson:datosjson},
			success: function() {
				parent.$.fancybox.close();
				self.parent.location.reload();
			}
		});
	});
});
</script>