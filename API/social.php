<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."usuarios.php");
include_once($API_folder."ret.php");

function com_lee_especial($args)
{
	global $moneda;
	// grafico=iniciativa (idiniciativa,limite), detalle
	
	if($args["grafico"]=="iniciativa")
	{
		$sql="select com.id as idreal,iusuariocom,fechacom,textocom,imagenusuario,nickusuario,urlusuario from com left join usuarios on com.iusuariocom=usuarios.id where statuscom='1' and iretcom=".$args["idiniciativa"]." order by fechacom desc";
	}
	else if($args["grafico"]=="pendientes")
	{
		$sql="select com.id as idreal,iusuariocom,fechacom,textocom,imagenusuario,nickusuario,urlusuario,nombreret,ret.id as idrealret from com left join usuarios  on com.iusuariocom=usuarios.id left join ret on com.iretcom=ret.id where statuscom='0' order by fechacom desc limit 0,100";
	}
	else if($args["grafico"]=="detalle")
	{
		$sql="select textocom,statuscom,activo from com where id=".$args["idreal"];
	}
	//echo $sql;
	
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		 foreach( $row_final as $key => $value )
			 $row_final -> $key = htmlentitiesMemo($value); 

		if($args["grafico"]<>"detalle")
		{
			if($idioma==0) $complementodousuario="usuario";
			else $complementodousuario="user";
	
			$row_final -> urlAmigableusuario = convierte_url_API($row_final ->urlusuario,$complementodousuario,$row_final -> iusuariocom);
	
			if($_SESSION["mobile"]) $tipoimagen="E";	
			else $tipoimagen="D";
	
			if($row_final -> imagenusuario=="") 
					$row_final -> imagenusuario="elementos/generales/noprofile.png";
			
			$row_final -> imagenusuario = genera_imagen_API ($row_final -> imagenusuario,$tipoimagen); 
			
			$row_final -> fechacom = strftime("%A, %d %B, %Y %H:%Mhrs", strtotime($row_final -> fechacom)); 
			
			if($_SESSION["logged"]->cms==1)
				$row_final->displayeditar="block";
			else $row_final->displayeditar="none";
		}
		
		if($args["sincroniza"]=="si" || $_SESSION["remote"]==1) 
		{
		   foreach( $row_final as $key => $value )
			 $row_final -> $key = utf8_encode($value); 
		}
			
		$row_final_array [] = $row_final;
    }
    return $row_final_array;
}


function gus_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "iusuariogus,iretgus,fechagus";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",gus.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM gus".$sql_activo;
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
			 
        if(strpos($args["campos"],"iusuariogus")!==FALSE && $row_final -> iusuariogus != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = usuarios_lee(array( 
                                              'campos' => 'nickusuario',
                                              'sql_extra' => 'id='.$row_final -> iusuariogus ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"iretgus")!==FALSE && $row_final -> iretgus != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = ret_lee(array( 
                                              'campos' => 'nombreret',
                                              'sql_extra' => 'id='.$row_final -> iretgus ));
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