<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");


function ban_base_lee($tipoban)
{
	global $idioma;
	global $fechahoy;
	global $idiomas;
    $row_final_array = array();
	$sql="select imagenban,i_imagenban,textoban,i_textoban,urlban,i_urlban,targetban from ban where activo=1 and imagenban<>'' ";
	
	$sql_fechas=" and inicioban<='".$fechahoy."' and finban>='".$fechahoy."' and tipoban=".$tipoban;
	if($tipoban=="0")
	{
		$sql_base=$sql.$sql_fechas." and id<>1 order by ordenban asc";
		$sql_opcion=$sql." and id=1";
	}
	else if($tipoban=="1")
	{
		$sql_base=$sql.$sql_fechas." and id<>2 order by rand() limit 0,1";
		$sql_opcion=$sql." and id=2";
	}
	else if($tipoban=="2")
	{
		$sql_base=$sql.$sql_fechas." and id<>3 order by rand() limit 0,1";
		$sql_opcion=$sql." and id=3";
	}

    $result_final = mysqli_query($GLOBALS["enlaceDB"], $sql_base );
	if(mysqli_num_rows($result_final)==0)
		 $result_final = mysqli_query($GLOBALS["enlaceDB"],$sql_opcion);
		 
    while( $row_final = mysqli_fetch_object( $result_final ))
    {	 
        if($row_final -> imagenban) $row_final -> imagenban = genera_imagen_API ($row_final -> imagenban,"B"); 
        if($row_final -> i_imagenban) $row_final -> i_imagenban = genera_imagen_API ($row_final -> i_imagenban,"B"); 
        
		$row_final->vermas=$idiomas["Ver mas"]; 
		if($idioma==1) 
		{   
			$row_final->textoban=lee_ingles($row_final->textoban,$row_final->i_textoban);
			$row_final->urlban=lee_ingles($row_final->urlban,$row_final->i_urlban);
			$row_final->imagenban=lee_ingles($row_final->imagenban,$row_final->i_imagenban);
		}
		 $row_final_array [] = $row_final;
    }
    return $row_final_array;
}
?>