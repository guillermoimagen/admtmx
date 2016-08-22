<?
include("recursos/entrada.php");
$revisarStrong="no"; 
include("recursos/xss_var.php");
include("recursos/inicializasesion.php");
include("../include/connection.php");
include("recursos/funciones.php");
$nombrecampo=htmlentitiesMemo2Strong($_GET["nombrecampo"]);
$nombretabla=htmlentitiesMemo2Strong($_GET["nombretabla"]);
$tablaseguimiento=htmlentitiesMemo2Strong($_GET["tablaseguimiento"]);
$id=htmlentitiesMemo2Strong($_GET["id"]);
$step=htmlentitiesMemo2Strong($_GET["step"]);
$nombrecamporeal=htmlentitiesMemo2Strong($_GET["nombrecamporeal"]);
$nombretablareal=htmlentitiesMemo2Strong($_GET["nombretablareal"]);
include("seguridadeditor.php");

$mensaje="Edita el contenido del campo ".$nombrecamporeal." de la tabla ".$nombretablareal.".";
$mensaje2="";
$clase="";
if($step==2)
{
	$campo=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["contenido"]);
	$sqltemporal=$nombrecampo."='".$campo."'";	
	$sql = "UPDATE ".$nombretabla." SET " .$sqltemporal. " WHERE ID=".$id;
	if ( @mysqli_query($GLOBALS["enlaceDB"] ,$sql) ) 
	{
		$mensaje="Se actualiz&oacute; correctamente el registro. Puedes cerrar la ventana.";
		$clase="class=\"textomensaje\"";
		$sqltemporal= "idusuarioseguimiento=".$sesionid.",idaccesoseguimiento=".$sesionidregistro.",horaseguimiento='".$ultimahoraentrada."',registroseguimiento=".$id.",tablaseguimiento=".$tablaseguimiento.",operacionseguimiento='1'"; 
		@mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO caseguimiento SET " .$sqltemporal);
	}	 
	else 
	{
		$mensaje="Ocurri&oacute; un error al guardar el registro.";    
		$clase="class=\"textomensajeerror\"";
	}	
}

$rutinabusqueda="id,".$nombrecampo." from ".$nombretabla." where id=".$id;
$result = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$rutinabusqueda);  
if (mysqli_num_rows($result)<=0) 
{
	$mensaje2="Ocurri&oacute; un error al abrir la base de datos.";
	exit();
}
while ( $row = mysqli_fetch_array($result) )
{
	$contenido=$row[$nombrecampo];
	$step=1;
}	


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Imagen Central. (<?=$nombretablareal?>-<?=$nombrecamporeal?>)</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link rel="stylesheet" href="recursos/estilos.css" type="text/css">
        <script src="ckeditor/ckeditor.js"></script>
    </head>
    <body>
		<? 
        if($mensaje2<>"") // hay un error antes de arrancar
        {
        ?>  
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina">  
            <tr>
            <td class="textomensajeerror"><?=$mensaje2?></td>
            </tr>
            </table>
        <? } ?>
        
        <? 
		if($step==1) // se va a mostrar el registro
		{ 
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <form name="form1" method="post" action="manejadoreditor.php?nombretabla=<?=$nombretabla?>&nombrecampo=<?=$nombrecampo?>&nombrecamporeal=<?=$nombrecamporeal?>&nombretablareal=<?=$nombretablareal?>&id=<?=$id?>&step=2&tablaseguimiento=<?=$tablaseguimiento?>&">
             
            <tr  class="titulopagina">
            <td <?=$clase?> align="center"> 
            	<?=$mensaje?>
            </td>
            <td align=right>
                <input class=textogeneral type="button" name="cerrar" value="Cerrar" onClick="window.close();">
                <input class=textogeneral type="submit" name="Submit" value="Guardar">
            </td>
            </tr>
            <tr><td valign="top" style="height:100%" colspan="2">
  
                <textarea name="contenido" id="contenido" rows="10" cols="80" style="width:100%; height:100%">
                    <?=$contenido?>
                </textarea>
                <script>
                    CKEDITOR.replace( 'contenido', {
						width: '100%',
						height: 500
					} );
					
                </script>
        </td></tr>

</form>  
</table>

        <? } ?>
    </body>
</html>