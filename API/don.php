<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."ret.php");
include_once($API_folder."usuarios.php");
include_once($API_folder."generales.php");

function don_lee_especial($args)
{
	global $moneda;
	global $idiomas;
	global $idioma;
	// grafico=iniciativa (idiniciativa,limite), detalle
	
	if($args["grafico"]=="iniciativa")
	{
		$sql="select don.id as idreal,iusuariodonodon,nickusuario,urlusuario,imagenusuario,importedon,acumuladodon,ganadordon,statusdon from don left join usuarios on don.iusuariodonodon=usuarios.id where statusdon='2' and iretdon=".$args["idiniciativa"]." order by fechadon desc";
		if($args["limite"]) $sql.=" limit 0,".$args["limite"];
	}
	else if($args["grafico"]=="usuario")
	{
		$status="statusdon='2' and";
		if($args["statusdon"]=='0') 
			$status="(statusdon='0' or statusdon='1') and ";
		else if($args["statusdon"]=="no")
			$status="";
			
		$sql="select don.id as idreal, iretdon,nombreret,imagenret,importedon,acumuladodon,iusuariodon,ganadordon,nickusuario,urlusuario,imagenusuario,urlamigableret,statusdon,iusuariodonodon,iformadon from don left join ret on don.iretdon=ret.id left join usuarios on don.iusuariodon=usuarios.id where ".$status."  iusuariodonodon=".$args["idusuario"].$args["sql_extra"]." order by fechadon desc";
		if($args["limite"]) $sql.=" limit 0,".$args["limite"];
	}
	else if($args["grafico"]=="sql")
	{
		$sql="select don.id as idreal, iretdon,nombreret,imagenret,importedon,acumuladodon,iusuariodon,ganadordon,nickusuario,urlusuario,urlamigableret,imagenusuario,statusdon,iusuariodonodon from don left join ret on don.iretdon=ret.id left join usuarios on don.iusuariodon=usuarios.id where ".$args["sql_extra"];
	}
	//echo $sql;
	
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		foreach( $row_final as $key => $value )
			 $row_final -> $key = htmlentitiesMemo($value); 
			 
		$row_final->importedonnumero=$row_final->importedon;
		$row_final->vret="";
		if($args["leerDetalle"]==1)
		{
			$row_final->datospago=sprintf("ID%09s",$row_final->idreal);
			
			if($row_final->statusdon==2)							
				$row_final->status=$idiomas["Pagado"];
			else if($row_final->statusdon==3)	
				$row_final->status=$idiomas["Cancelado"];
			else if($row_final->statusdon==4)	
				$row_final->status=$idiomas["Rechazado"];
			else $row_final->status=$idiomas["Pendiente de pago"];
			
			$row_final->botoneditar="";
			if($_SESSION["logged"]->cms==1)
			{
				$row_final->botoneditar='<a href="_naharaProcesa/don.php?step=modify&id='.$row_final->idreal.'" target="_blank"><div class="btn_vercompleta" style="float:right !important;">Ver en CMS</div></a>';	
			}
			
			$row_final->botonenviarmail="";
			$row_final->botonvermas="";
			if(($_SESSION["logged"]->cms==1 || $_SESSION["logged"]->id==$row_final->iusuariodonodon))
			{
				if($row_final->statusdon==2)
					$row_final->botonenviarmail='<div class="btn_vercompleta" style="float:right !important;" onclick="reenviarDonativo('.$row_final->idreal.');">'.$idiomas["Reenviar comprobante"].'</div>';
				$row_final->botonvermas='<div class="btn_vercompleta" style="float:right !important;" onclick="detalleDonativo('.$row_final->idreal.','.$row_final->iusuariodonodon.');">'.$idiomas["Ver mas"].'</div>';
					
			}
			if(($_SESSION["logged"]->cms==1 || $_SESSION["logged"]->id==$row_final->iusuariodonodon) && $row_final->ganadordon>0)
			{
				$campo="labelcret";
				if($idioma==1) $campo="i_labelcret";
				$cadena="";
				for($i=1; $i<=$row_final->ganadordon; $i++)
				{
					$vret=@mysqli_query($GLOBALS["enlaceDB"] ,"select ".$campo." as labelcret,valorvret from cret left join vret on cret.id=vret.icretvret where ganvret=".$i." and iretcret=".$row_final->iretdon." and idonvret=".$row_final->idreal." order by cret.id asc");
					if(mysqli_num_rows($vret)>0)
					{
						$cadena.="<strong>".$idiomas["Ganador"]." ".$i."</strong> ";
						while($rowVret=mysqli_fetch_object($vret))					
							$cadena.=$rowVret->labelcret.": ".htmlentitiesMemoStrong($rowVret->valorvret)."&nbsp;&nbsp;";
						$cadena.="<br>";
					}
					
				}
				if($cadena<>"")
					$row_final->vret='<div class="dcanidad">'.$cadena.'</div>';
			}	
			
		}
		if($args["grafico"]=="iniciativa")
		{
			if($idioma==0) $complementodousuario="usuario";
			else $complementodousuario="user";
			$row_final -> urlAmigableusuario = convierte_url_API($row_final ->urlusuario,$complementodousuario,$row_final -> iusuariodonodon);
			$row_final->donativo=$idiomas["Donativo"];
			if($_SESSION["mobile"]) $tipoimagen="E";	
			else $tipoimagen="D";
			if($row_final -> imagenusuario=="") 
					$row_final -> imagenusuario="elementos/generales/noprofile.png";
					
			$row_final -> imagenusuario = genera_imagen_API ($row_final -> imagenusuario,$tipoimagen); 
		}
		else
		{
			if($_SESSION["mobile"]) $tipoimagen="E";	
			else $tipoimagen="D";
			if($row_final->iretdon<>0)
			{
				if($idioma==0) $complemento="iniciativa";
				else $complemento="initiative";
				$row_final -> urlAmigableret = convierte_url_API($row_final ->urlamigableret,$complemento,$row_final -> iretdon);
				if($row_final -> imagenret=="") 
					$row_final -> imagenret="elementos/generales/noprofile.png";
				$row_final -> imagenret = genera_imagen_API ($row_final -> imagenret,$tipoimagen); 
			}
			else if($row_final->iusuariodon<>0)
			{
				$row_final->nombreret=$row_final->nickusuario;
				if($idioma==0) $complemento="usuario";
				else $complemento="user";
				$row_final -> urlAmigableret = convierte_url_API($row_final ->urlusuario,$complemento,$row_final -> iusuariodon);
				if($row_final -> imagenusuario=="") 
					$row_final -> imagenusuario="elementos/generales/noprofile.png";
				
				$row_final -> imagenret = genera_imagen_API ($row_final -> imagenusuario,$tipoimagen);
			}
			else
			{
				$row_final -> urlAmigableret="";
				$row_final->nombreret=$idiomas["Donativo al corazon"];
				$row_final -> imagenret = genera_imagen_API ("elementos/generales/alcancia.jpg",$tipoimagen);
			}
		}
		; 
		if($row_final->ganadordon>=1 && $row_final->statusdon==2) // solo los pagados 
			$row_final->fueganador=$idiomas["Ganador"].($row_final->ganadordon > 1 ? " (".$row_final->ganadordon.")" : "");
			
		$row_final->importedon="$".number_format($row_final->importedon,0,".",",")." ".$moneda;
		$row_final->acumuladodon="$".number_format($row_final->acumuladodon,0,".",",")." ".$moneda;
		$row_final_array [] = $row_final;
    }
    return $row_final_array;
}


function acu_lee($args)
{
	$sql="select acumuladoacu from acu where iusuario1acu=".$args["receptor"]." and iusuario2acu=".$args["donador"];
    $result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		$row_final->acumuladoformateadoacu="$".number_format($row_final->acumuladoacu,0,".",",")." ".$moneda;
        $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

function formas_lee($args)
{
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "nombreforma";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",formas.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM formas".$sql_activo;
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