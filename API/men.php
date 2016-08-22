<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");
function men_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "idmen,textomen,i_textomen";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",men.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM men".$sql_activo;
   	if($args["sql_extra"]<>"")
   	{
   		if($sql_activo=="") $sql.=" where (".$args["sql_extra"].")";
   		else $sql.=" and (".$args["sql_extra"].")";
   	}
    if($args["order"]<>"") $sql.=" order by ".$args["order"];
    if($args["numero_pagina"]<>"" && $args["numero_pagina"]<>"0")
    {
        if($args["items_por_pagina"]=="" || $args["items_por_pagina"]=="0") $args["items_por_pagina"] = 20;
        $sql.= " limit ".round(($args["numero_pagina"]-1)*$args["items_por_pagina"]).",".$args["items_por_pagina"];
    }

    $result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
        if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
           foreach( $row_final as $key => $value )
             $row_final -> $key = utf8_encode($value);   
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

?>