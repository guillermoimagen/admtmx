<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");

function pais_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "nombrepais,ordenpais";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",pais.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM pais".$sql_activo;
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

function estados_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "ipaisestado,nombreestado";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",estados.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM estados".$sql_activo;
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
				 
        if(strpos($args["campos"],"ipaisestado")!==FALSE && $row_final -> ipaisestado != 0 && $args["sincroniza"]<>"si")
        {
			
			 
            $row_final_leido = pais_lee(array( 
                                              'campos' => 'nombrepais',
                                              'sql_extra' => 'id='.$row_final -> ipaisestado ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

           
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

?>