<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."generales.php");
include_once($API_folder."pais.php");

function usuarios_especial_lee($args)
{
	global $cuentaUsuarios;
	$sql="select id as idreal,nombreusuario,nickusuario,imagenusuario,urlusuario from usuarios where activo=1 ".$args["sql_extra"];
	
	$sqlCuenta="select count(usuarios.id) as cuenta from usuarios where activo=1 ".$args["sql_extra"];	

	$cuentaUsuarios=0;
	$contador=@mysqli_query($GLOBALS["enlaceDB"] ,$sqlCuenta);
	while($contadorRow=mysqli_fetch_object($contador))
		$cuentaUsuarios=$contadorRow->cuenta;
	if($args["order"]<>"") $sql.=" order by ".$args["order"];
    if($args["numero_pagina"]<>"" && $args["numero_pagina"]<>"0")
    {
        if($args["items_por_pagina"]=="" || $args["items_por_pagina"]=="0") $args["items_por_pagina"] = 20;
        $sql.= " limit ".round(($args["numero_pagina"]-1)*$args["items_por_pagina"]).",".$args["items_por_pagina"];
    }
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		 foreach( $row_final as $key => $value )
			 $row_final -> $key = htmlentitiesMemo($value); 
		if($idioma==0) 
		{
			$complementodousuario="usuario";
			$complementodousuariopagos="pagosUsuario";
		}
		else 
		{
			$complementodousuario="user";
			$complementodousuariopagos="paymentsUser";
		}
        $row_final -> urlAmigableusuario = convierte_url_API($row_final ->urlusuario,$complementodousuario,$row_final -> idreal);	
		if($_SESSION["mobile"]) $tipoimagen="B";	
		else $tipoimagen="C";
		if($row_final -> imagenusuario=="") 
			$row_final -> imagenusuario="elementos/generales/noprofile.png";
		
         $row_final -> imagenusuario = genera_imagen_API ($row_final -> imagenusuario,$tipoimagen); 
   
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}


function usuarios_lee($args)
{
	global $idioma;
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "itusuusuario,destacadousuario,emailusuario,contrasenausuario,nombreusuario,imagenusuario,imagenfondousuario,videousuario,validadousuario,cmsusuario,enviarnotificacionesusuario,ipaisusuario,iestadousuario,tel1usuario,tel2usuario,ttusuario,familiarteletonusuario,icritusuario,ientusuario,ipor1usuario,ipor2usuario,tgustausuario,tcomentariosusuario,ndonusuario,idonusuario,nrdonusuario,irdonusuario,fbusuario,tokenfbusuario,codigousuario,descripcionusuario,i_descripcionusuario,urlusuario,nickusuario,urlusuario,nacimientousuario";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",usuarios.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM usuarios".$sql_activo;
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
//	echo $sql;
    $result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		 foreach( $row_final as $key => $value )
			 $row_final -> $key = htmlentitiesMemo($value); 
		if($idioma==0) 
		{
			$complementodousuario="usuario";
			$complementodousuariopagos="pagosUsuario";
		}
		else 
		{
			$complementodousuario="user";
			$complementodousuariopagos="paymentsUser";
		}
        $row_final -> urlAmigableusuario = convierte_url_API($row_final ->urlusuario,$complementodousuario,$row_final -> idreal);	
        $row_final -> urlAmigabledonarusuario = convierte_url_API($row_final ->urlusuario,$complementodousuariopagos,$row_final -> idreal);	
		$row_final->idonusuario="$".number_format($row_final->idonusuario,0,".",",")." ".$moneda;
		$row_final->irdonusuario="$".number_format($row_final->irdonusuario,0,".",",")." ".$moneda;
		if($args["sincroniza"]=="si" || $_SESSION["remote"]==1) 
           foreach( $row_final as $key => $value )
             $row_final -> $key = utf8_encode($value); 
			 
        if(strpos($args["campos"],"itusuusuario")!==FALSE && $row_final -> itusuusuario != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = tusu_lee(array( 
                                              'campos' => 'tipotusu',
                                              'sql_extra' => 'id='.$row_final -> itusuusuario ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"ipaisusuario")!==FALSE && $row_final -> ipaisusuario != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = pais_lee(array( 
                                              'campos' => 'nombrepais',
                                              'sql_extra' => 'id='.$row_final -> ipaisusuario ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"iestadousuario")!==FALSE && $row_final -> iestadousuario != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = estados_lee(array( 
                                              'campos' => 'nombreestado',
                                              'sql_extra' => 'id='.$row_final -> iestadousuario ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }
		$row_final->lugar="";
		if($row_final->nombrepais<>"") $row_final->lugar=$row_final->nombrepais;
		if($row_final->nombreestado<>"") 
			$row_final->lugar.=", ".$row_final->nombreestado;
		if($row_final->lugar=="")
			$row_final->lugar="ND";
        if(strpos($args["campos"],"icritusuario")!==FALSE && $row_final -> icritusuario != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = crits_lee(array( 
                                              'campos' => 'nombrecrit',
                                              'sql_extra' => 'id='.$row_final -> icritusuario ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"ientusuario")!==FALSE && $row_final -> ientusuario != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = ent_lee(array( 
                                              'campos' => 'comoent,i_comoent',
                                              'sql_extra' => 'id='.$row_final -> ientusuario ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"ipor1usuario")!==FALSE && $row_final -> ipor1usuario != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = por_lee(array( 
                                              'campos' => 'porquepor,i_porquepor',
                                              'sql_extra' => 'id='.$row_final -> ipor1usuario ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }

        if(strpos($args["campos"],"ipor2usuario")!==FALSE && $row_final -> ipor2usuario != 0 && $args["sincroniza"]<>"si")
        {
            $row_final_leido = por_lee(array( 
                                              'campos' => 'porquepor',
                                              'sql_extra' => 'id='.$row_final -> ipor2usuario ));
            foreach($row_final_leido[0] as $key => $value) 
            {
                if($key <> 'idreal') $row_final -> $key = $value; 
            }
        }
		if($_SESSION["mobile"]) $tipoimagen="B";	
		else $tipoimagen="C";
		if($row_final -> imagenusuario=="") 
				$row_final -> imagenusuario="elementos/generales/noprofile.png";
		
		if($args["sincroniza"]<>"si")
	        if($row_final -> imagenusuario) $row_final -> imagenusuario = genera_imagen_API ($row_final -> imagenusuario,$tipoimagen); 
   
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

function tusu_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "tipotusu,i_tipotusu";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",tusu.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM tusu".$sql_activo;
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