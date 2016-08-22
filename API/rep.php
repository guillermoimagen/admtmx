<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");

function rep_lee($args)
{
	if($args["grafico"]=="detalle")
	{
		$sql="select iretrep,nombreret,nombreusuario,iusuarioreportadorep,fecharep,imotrep,textorep,statusrep from rep left join ret on rep.iretrep=ret.id left join usuarios on rep.iusuarioreportadorep=usuarios.id where  iretrep=".$args["iretrep"]." and iusuarioreportadorep=".$args["iusuarioreportadorep"];
	}
	else
	{
		$row_final_array = array();
		if($args["campos"] == "")
			$args["campos"] = "iretrep,iusuarioreportadorep,iusuariorep,fecharep,imotrep,textorep,statusrep";
	
		
		if($args["sincroniza"]=="si")
		{
			$args["campos"].=",rep.activo";
			$sql_activo="";
		}
		else $sql_activo=" where activo=1";
		$sql = "SELECT id as idreal,".$args["campos"]." FROM rep".$sql_activo;
		
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
	}
    $result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		foreach( $row_final as $key => $value )
			 $row_final -> $key = htmlentitiesMemo($value); 

         if($args["sincroniza"]=="si") 
           foreach( $row_final as $key => $value )
             $row_final -> $key = utf8_encode($value);   
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}


function mot_formulario_lee()
{
	global $idioma;
    $row_final_array = array();
	$sql="select id as valor,nombremot,i_nombremot from mot where activo=1";
	if($idioma==0) $sql.=" order by nombremot";
	else $sql.=" order by i_nombremot";
	
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
	{	 
		if($idioma==1) 
		{   
			$row_final->nombremot=lee_ingles($row_final->nombremot,$row_final->i_nombremot);
		}
		$row_final->label=utf8_encode($row_final->nombremot); 
		$row_final->nombremot=utf8_encode($row_final->nombremot); 
		$row_final->i_nombremot=utf8_encode($row_final->i_nombremot); 
		
		 $row_final_array [] = $row_final;
    }
    return $row_final_array;
}
?>