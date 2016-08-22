<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."ret.php");
include_once($API_folder."usuarios.php");


function cat_lee($modo,$urlComplemento,$actual)
{
	global $idioma;
    $row_final_array = array();
	
	$sql="select id as idreal,nombrecat,i_nombrecat,colorcat,descripcioncat,i_descripcioncat,imagencat from cat where activo=1";
	if($modo=="destacadas")
	{
		$sql.=" and destacadacat='1' order by nombrecat limit 0,5";
	}
	else if($modo=="todas")
	{
		if($idioma==0) $sql.=" order by nombrecat";
		else $sql.=" order by i_nombrecat";
	}
	else
	{
		$sql.=" and id=".$modo;
	}
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
	{	 
		if($modo=="destacadas")
		{
			if(strpos($urlComplemento,"&cat")===FALSE) $row_final->urlCat="iniciativasListado.php?pagina=1".$urlComplemento."&cat=".$row_final->idreal;
			else $row_final->urlCat="iniciativasListado.php?pagina=1".str_replace("&cat=".$actual,"&cat=".$row_final->idreal,$urlComplemento);
		}
		if($idioma==1) 
		{   
			$row_final->nombrecat=lee_ingles($row_final->nombrecat,$row_final->i_nombrecat);
			$row_final->descripcioncat=lee_ingles($row_final->descripcioncat,$row_final->i_descripcioncat);
		}
		if($_SESSION["mobile"]) $tipoimagen="C";	
		else $tipoimagen="D";
		
		if($row_final -> imagencat=="") 
			$row_final -> imagencat="elementos/generales/noprofile.png";
		
        $row_final -> imagencat = genera_imagen_API ($row_final -> imagencat,$tipoimagen); 
		 if($args["sincroniza"]=="si" || $_SESSION["remote"]==1) 
           foreach( $row_final as $key => $value )
             $row_final -> $key = utf8_encode($value); 
		$row_final_array [] = $row_final;
    }
    return $row_final_array;
}

function cat_formulario_lee($modo)
{
	global $idioma;
    $row_final_array = array();
	
	if($modo=="radio")
		$sql="select id as valor,nombrecat,i_nombrecat,descripcioncat,i_descripcioncat,imagencat from cat where activo=1";
	else 
		$sql="select id as valor,nombrecat,i_nombrecat from cat where activo=1";
	if($idioma==0) $sql.=" order by nombrecat";
	else $sql.=" order by i_nombrecat";
	
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
	{	 
		if($idioma==1) 
		{   
			$row_final->nombrecat=lee_ingles($row_final->nombrecat,$row_final->i_nombrecat);
			$row_final->descripcioncat=lee_ingles($row_final->descripcioncat,$row_final->i_descripcioncat);
		}
		$row_final->label=utf8_encode($row_final->nombrecat); 
		$row_final->nombrecat=utf8_encode($row_final->nombrecat); 
		$row_final->i_nombrecat=utf8_encode($row_final->i_nombrecat); 
		$row_final->descripcion=utf8_encode($row_final->descripcioncat); 
		$row_final->i_descripcioncat=utf8_encode($row_final->i_descripcioncat); 
		$row_final->descripcioncat=utf8_encode($row_final->descripcioncat); 
		
		if($_SESSION["mobile"]) $tipoimagen="C";	
		else $tipoimagen="D";
		
		if($row_final -> imagencat=="") 
			$row_final -> imagencat="elementos/generales/noprofile.png";
		
        $row_final -> imagen = $row_final -> imagencat; 
		
		
		
		 $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

function cru_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "icatcru,iusuariocru,iretocru";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",cru.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM cru".$sql_activo;
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
        if(strpos($args["campos"],"icatcru")!==FALSE && $row_final -> icatcru != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = cat_lee(array( 
                                              'campos' => 'nombrecat,i_nombrecat',
                                              'sql_extra' => 'id='.$row_final -> icatcru ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"iusuariocru")!==FALSE && $row_final -> iusuariocru != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = usuarios_lee(array( 
                                              'campos' => 'nombreusuario',
                                              'sql_extra' => 'id='.$row_final -> iusuariocru ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"iretocru")!==FALSE && $row_final -> iretocru != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = ret_lee(array( 
                                              'campos' => 'nombreret',
                                              'sql_extra' => 'id='.$row_final -> iretocru ));
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