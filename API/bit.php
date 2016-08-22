<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");

function tbit_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "tipotbit";

    if($args["sincroniza"]=="si")
    {
    	$args["campos"].=",tbit.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM tbit".$sql_activo;
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
        if($args["url"] <> "")
           $row_final -> urlAmigabletbit = convierte_url_API($row_final -> $args["url"],"tbi".$row_final -> idreal);

         if($args["sincroniza"]=="si") 
           foreach( $row_final as $key => $value )
             $row_final -> $key = utf8_encode($value);   
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}


function bit_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "itbitbit,tablabit,registrobit,iusuariobit,fechabit";

    if($args["sincroniza"]=="si")
    {
    	$args["campos"].=",bit.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM bit".$sql_activo;
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
        if($args["url"] <> "")
           $row_final -> urlAmigablebit = convierte_url_API($row_final -> $args["url"],"bit".$row_final -> idreal);

        if(strpos($args["campos"],"itbitbit")!==FALSE && $row_final -> itbitbit != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = tbit_lee(array( 
                                              'campos' => 'tipotbit',
                                              'campos_idioma' => 'tipotbit',
                                              'sql_extra' => 'id='.$row_final -> itbitbit ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"iusuariobit")!==FALSE && $row_final -> iusuariobit != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = usuarios_lee(array( 
                                              'campos' => 'nombreusuario',
                                              'campos_idioma' => 'nombreusuario',
                                              'sql_extra' => 'id='.$row_final -> iusuariobit ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

         if($args["sincroniza"]=="si") 
           foreach( $row_final as $key => $value )
             $row_final -> $key = utf8_encode($value);   
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

?>