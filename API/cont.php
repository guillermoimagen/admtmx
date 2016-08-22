<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");

function cont_lee($args)
{
	global $idioma;
    $row_final_array = array();
	
	if($_SESSION["mobile"]) $tipoimagen="C";	
	else $tipoimagen="B";
			
	if(isset($args["id"]))
		$sql="select cont.id as idreal,cont.* from cont where id=".$args["id"]." and activo=1";
	else 
	{
		if($_SESSION["mobile"]) $tipoimagen="D";	
		else $tipoimagen="C";
		$sql="select cont.id as idreal,nombrecont,i_nombrecont,textocont,i_textocont,imagencont,videocont,urlamigablecont from cont where activo=1";	
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
		if($idioma==1) 
		{   
			$row_final->nombrecont=lee_ingles($row_final->nombrecont,$row_final->i_nombrecont);
			if(isset($args["id"]))
				$row_final->textocont=lee_ingles($row_final->textocont,$row_final->i_textocont);
		}  

		if($row_final -> imagencont) $row_final -> imagencont = genera_imagen_API ($row_final -> imagencont,$tipoimagen); 
		if( $row_final -> imagencont=="")  $row_final -> imagencont= genera_imagen_API ("elementos/generales/noencontrado.jpg",$tipoimagen); 

		if($idioma==0) $complemento="contenidos";
		else $complemento="content";
        $row_final -> urlAmigablecont = convierte_url_API($row_final ->urlamigablecont,$complemento,$row_final -> idreal);
		
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}
?>