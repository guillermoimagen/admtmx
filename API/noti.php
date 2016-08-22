<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");

function noti_lee($args)
{
	global $idioma;
	global $idiomas;
    $row_final_array = array();
	
	if($_SESSION["mobile"]) $tipoimagen="C";	
	else $tipoimagen="B";
	
	if(isset($args["id"]))
		$sql="select noti.id as idreal,noti.* from noti where id=".$args["id"]." and activo=1";
	else 
	{
		$tipoimagen="C";
		$sql="select noti.id as idreal,titulonoti,i_titulonoti,imagennoti,fechanoti,intronoti,i_intronoti,urlamigablenoti from noti where activo=1";	
	}
	
	if($args["sql_extra"]<>"" && $args["sql_extra"])
		$sql.=" and ".$args["sql_extra"];

    if($args["order"]<>"") $sql.=" order by ".$args["order"];
    if($args["numero_pagina"]<>"" && $args["numero_pagina"]<>"0")
    {
        if($args["items_por_pagina"]=="" || $args["items_por_pagina"]=="0") $args["items_por_pagina"] = 20;
        $sql.= " limit ".round(($args["numero_pagina"]-1)*$args["items_por_pagina"]).",".$args["items_por_pagina"];
    }
    $result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
        $row_final->vercompleto=$idiomas["Ver completo"];
		if($idioma==1) 
		{   
			$row_final->titulonoti=lee_ingles($row_final->titulonoti,$row_final->i_titulonoti);
			$row_final->intronoti=lee_ingles($row_final->intronoti,$row_final->i_intronoti);
			if(isset($args["id"]))
				$row_final->textonoti=lee_ingles($row_final->textonoti,$row_final->i_textonoti);
		}  

		$row_final -> fechanoti = strftime("%A, %d %B, %Y ", strtotime($row_final -> fechanoti)); //%H:%M


		if($row_final -> imagennoti) $row_final -> imagennoti = genera_imagen_API ($row_final -> imagennoti,$tipoimagen); 
		if( $row_final -> imagennoti=="")  $row_final -> imagennoti= genera_imagen_API ("elementos/generales/noencontrado.jpg",$tipoimagen); 

		if($idioma==0) $complemento="noticias";
		else $complemento="news";
        $row_final -> urlAmigablenoti = convierte_url_API($row_final ->urlamigablenoti,$complemento,$row_final -> idreal);
		
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

?>