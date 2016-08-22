<?
include_once($API_folder."funciones_API.php");
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."usuarios.php");
include_once($API_folder."pais.php");

function calculaStatus($row_final)
{
	global $idioma;
	global $fechahorahoy;
	global $statuses;
	$status = new stdClass();
	
	$statusActual=0;
	if($row_final->statusret=="0") $status->valor=3; // no validada
	else if($row_final->statusret=="2") $status->valor=4; // rechazada
	else if($row_final->statusret=="3") $status->valor=6; // no enviada
	else // fue validada 
	{
		if($row_final->finicioret <= $fechahorahoy && $row_final->ffinret >= $fechahorahoy) // aun esta vigente
		{
			if($row_final->maximoganadoresret > $row_final->tganadoresret || $row_final->maximoganadoresret==0) $status->valor=1; // aun hay disponibilidad
			else $status->valor=0; // sin disponibilidad
		}
		else 
		{
			if($row_final->finicioret > $fechahorahoy) // aun no empieza
				$status->valor=5;
			else $status->valor=2; // concluida
		}
	}
	
	$statuses=array("Sin disponibilidad","Disponible","Disponible","Pendiente de validaci&oacute;n","Rechazada","A&uacute;n no comienza","No enviada a validaci&oacute;n"); // el 2 es Concluida
	$i_statuses=array("No availability","Available","Available","Pending validation","Rejected","Not started","Not sent to review");
	
	if($idioma==0) $status->etiqueta=$statuses[$status->valor];
	else $status->etiqueta=$i_statuses[$status->valor];	
	
	
	if($status->valor==0 || $status->valor==1 || $status->valor==2) $status->color="activo";
	else $status->color="inactivo";
	
	return $status;
}

function ret_lista_lee($args)
{   
	// modo: validada, pendiente, rechazadas, vigente, disponible,
	// tipo: embajadores:1, artistas:2, empresas:3
	// grafico: corto, largo, detalle
	// mia, destacada (true/false)
	// recomendados: "pocos, todos"
	 
	global $fechahorahoy;
	global $idioma;
	global $idiomas;
	global $moneda;
	global $dosIdiomas;
	
	switch ($args["grafico"]) {
		case "largo":
			$campos.="nombreret,i_nombreret,nombrecortoret,i_nombrecortoret,descripcionret,i_descripcionret,ipaisret,iestadoret,tgustaret,tcomentariosret,maximoganadoresret,tganadoresret,minimodonativoret,metaret,finicioret,ffinret,iusuarioret,statusret,nickusuario,urlusuario,importedonativosret,tdonativosret,urlamigableret";
			if($_SESSION["mobile"]) $tipoimagen="C";	
			else $tipoimagen="B";
			break;
		case "detalle":
			$campos.="nombreret,i_nombreret,nombrecortoret,i_nombrecortoret,descripcionret,i_descripcionret,condicionesret,i_condicionesret,ipaisret,iestadoret,domicilio1ret,domicilio2ret,videoret,urlret,tgustaret,tcomentariosret,maximoganadoresret,tganadoresret,importedonativosret,tdonativosret,minimodonativoret,metaret,finicioret,ffinret,iusuarioret,statusret,nickusuario,urlusuario,emailusuario,icatret,destacadoret,razonesret,urlamigableret";
			if($_SESSION["mobile"]) $tipoimagen="B";	
			else $tipoimagen="C";
			break;
		default:
			$campos.="nombreret,i_nombreret,nombrecortoret,i_nombrecortoret,iusuarioret,nickusuario,urlusuario,importedonativosret,metaret,tgustaret,urlamigableret";
			if($_SESSION["mobile"]) $tipoimagen="E";	
			else $tipoimagen="D";
			break;
	}
	$sql="";
	
	
	if($_SESSION["logged"]->cms<>1 && ($args["modo"]=="pendiente" || $args["modo"]=="rechazada" || $args["modo"]=="noiniciada")) // puede seguir
	{
		return $row_final_array;	
	}
	
	switch ($args["modo"]) {
		case "pendiente":
			$sql.=" and 	statusret='0'";
			break;
		case "rechazada":
			$sql.=" and 	statusret='2'";
			break;
		case "validada":
			$sql.=" and 	statusret='1'";
			break;
		case "vigente":
			$sql.=" and 	statusret='1' and finicioret<='".$fechahorahoy."' and ffinret>='".$fechahorahoy."'";
			break;
		case "disponible":
			$sql.=" and 	statusret='1' and finicioret<='".$fechahorahoy."' and ffinret>='".$fechahorahoy."' and (maximoganadoresret > tganadoresret or maximoganadoresret=0) ";
			break;
		case "noiniciada":
			$sql.=" and 	statusret='1' and finicioret>='".$fechahorahoy."'";
			break;	
	}
	
	
	switch ($args["tipo"]) {
		case "embajadores":
			$sql.=" and 	itusuusuario='1'";
			break;
		case "artistas":
			$sql.=" and 	itusuusuario='2'";
			break;
		case "empresas":
			$sql.=" and 	itusuusuario='3'";
			break;
	}
	
	if($args["destacada"]==true)
		$sql.=" and destacadoret='1'";
	if($args["cat"])
		$sql.=" and icatret=".$args["cat"];
	if($args["estado"])
		$sql.=" and iestadoret=".$args["estado"];
	if($args["mia"]==true)
		$sql.=" and iusuarioret=".(int)$_SESSION["logged"]->id;
	if($args["palabra"])
		$sql.=" and (nombreret like '%".$args["palabra"]."%' or nickusuario like '%".$args["palabra"]."%')";
		
	if($args["recomendados"]=="pocos" || $args["recomendados"]=="categoria" || $args["recomendados"]=="cerca")
	{
		if($_SESSION["firmado"])
		{
			if($args["recomedados"]=="pocos") $limite=" limit 0,3";
			else $limite="";
			
			$don=@mysqli_query($GLOBALS["enlaceDB"] ,"select icatret,iusuarioret from don left join ret on don.iretdon=ret.id where iusuariodonodon=".(int)$_SESSION["logged"]->id." and statusdon=2 order by fechadon desc".$limite);
			while($rowDon=mysqli_fetch_object($don))
			{
				if($args["recomendados"]=="categoria" || $args["recomendados"]=="pocos")
				{
					if(strpos($sql_extra,"icatret=".$rowDon->icatret)===FALSE && $rowDon->icatret<>"")
					{
						if($sql_extra<>"") $sql_extra.=" or ";
						$sql_extra.=" icatret=".$rowDon->icatret;
					}
				}
				if($args["recomendados"]=="cerca" || $args["recomendados"]=="pocos")
				{
					if(strpos($sql_extra,"iusuarioret=".$rowDon->iusuarioret)===FALSE && $rowDon->iusuarioret<>"")
					{
						if($sql_extra<>"") $sql_extra.=" or ";
						$sql_extra.=" iusuarioret=".$rowDon->iusuarioret;
					}
				}
			}
		
			$gus=@mysqli_query($GLOBALS["enlaceDB"] ,"select icatret,iusuarioret from gus left join ret on gus.iretgus=ret.id where iusuariogus=".(int)$_SESSION["logged"]->id." order by fechagus desc ".$limite);
			while($rowGus=mysqli_fetch_object($gus))
			{
				if($args["recomendados"]=="categoria" || $args["recomendados"]=="pocos")
				{
					if(strpos($sql_extra,"icatret=".$rowGus->icatret)===FALSE)
					{
						if($sql_extra<>"") $sql_extra.=" or ";
						$sql_extra.=" icatret=".$rowGus->icatret;
					}
				}
				if($args["recomendados"]=="cerca" || $args["recomendados"]=="pocos")
				{
					if(strpos($sql_extra,"iusuarioret=".$rowGus->iusuarioret)===FALSE)
					{
						if($sql_extra<>"") $sql_extra.=" or ";
						$sql_extra.=" iusuarioret=".$rowGus->iusuarioret;
					}
				}
			}
			if($sql_extra<>"")
			{
				if($sql<>"") $sql.=" and ";
				$sql.="(".$sql_extra.")";
			}
			
		}
		else 
			return NULL;
	}
	
	if($args["sql_extra"]<>"")
		$sql.=$args["sql_extra"];
		
	$usuariosActivo="usuarios.activo=1 and";
	if($args["excepcionActivos"]=="si")
	{
		$usuariosActivo="";
	}
	
	$sqlCuenta="select count(ret.id) as cuenta from ret left join usuarios on ret.iusuarioret=usuarios.id where ".$usuariosActivo." ret.activo=1".$sql;	
	$sql="select ret.id as idreal,imagenret,i_imagenret,nombrecat,colorcat,".$campos." from ret left join cat on ret.icatret=cat.id left join usuarios on ret.iusuarioret=usuarios.id where ".$usuariosActivo." ret.activo=1".$sql;
	
	if($args["cuenta"])
	{
		global $cuentaIniciativas;
		$cuentaIniciativas=0;
		$contador=@mysqli_query($GLOBALS["enlaceDB"] ,$sqlCuenta);
		while($contadorRow=mysqli_fetch_object($contador))
			$cuentaIniciativas=$contadorRow->cuenta;
	}
	
	if($args["ordernum"]<>"") 
	{
		
		$ordenes=array("importedonativosret desc","finicioret desc","importedonativosret asc","finicioret asc");
		$sql.=" order by ".$ordenes[$args["ordernum"]];
	}
	if($args["order"]<>"") $sql.=" order by ".$args["order"];
    if($args["numero_pagina"]<>"" && $args["numero_pagina"]<>"0")
    {
        if($args["items_por_pagina"]=="" || $args["items_por_pagina"]=="0") $args["items_por_pagina"] = 20;
        $sql.= " limit ".round(($args["numero_pagina"]-1)*$args["items_por_pagina"]).",".$args["items_por_pagina"];
    }
	 //echo $sql."<br>";
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		 foreach( $row_final as $key => $value )
			 $row_final -> $key = htmlentitiesMemo($value); 
		if( $row_final -> imagenret=="")  $row_final -> imagenret= "elementos/generales/noencontrado.jpg"; 
		
		if($args["sincroniza"]<>"si")
		{
			if($row_final -> imagenret) $row_final -> imagenret = genera_imagen_API ($row_final -> imagenret,$tipoimagen); 
			if($row_final -> i_imagenret) $row_final -> i_imagenret = genera_imagen_API ($row_final -> i_imagenret,$tipoimagen); 
		}
		$row_final->ver=$idiomas["Ver"];
		$row_final->vercompleto=$idiomas["Ver completo"];
		$row_final->apoyar=$idiomas["Apoyar"];
		
		$row_final->acumulado=$idiomas["Acumulado"];
		if(($idioma==1 && !isset($args["textoIngles"])) || $args["textoIngles"]=="si")  // textoIngles viene del formulario
		{   
			$row_final->nombrecortoret=lee_ingles($row_final->nombrecortoret,$row_final->i_nombrecortoret);
			$row_final->imagenret=lee_ingles($row_final->imagenret,$row_final->i_imagenret);
			$row_final->nombreret=lee_ingles($row_final->nombreret,$row_final->i_nombreret);
			if($args["grafico"]=="largo" || $args["grafico"]=="detalle")
			{
				$row_final->descripcionret=lee_ingles($row_final->descripcionret,$row_final->i_descripcionret);
				$row_final->condicionesret=lee_ingles($row_final->condicionesret,$row_final->i_condicionesret);
			}
		}   
		
		if($row_final->metaret==0) $row_final->displaypig="none";
		else $row_final->displaypig="block";
		
		$row_final->porcentaje=round($row_final->importedonativosret*100/$row_final->metaret);
		if($row_final->porcentaje>100) $row_final->porcentaje=100;
		if($row_final->porcentaje>0 && $row_final->porcentaje<10)
			$row_final->cerdo=10;
		else $row_final->cerdo=floor($row_final->porcentaje/10)*10;
			
		$row_final->megusta=0;
		if($_SESSION["firmado"])
		{
			$rep=@mysqli_query($GLOBALS["enlaceDB"] ,"select id from gus where iusuariogus=".(int)$_SESSION["logged"]->id." and iretgus=".$row_final->idreal);
			if(mysqli_num_rows($rep)>0) $row_final->megusta=1;
		}
			
			
		if($args["grafico"]=="largo" || $args["grafico"]=="detalle")
		{
			
		
			$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombrepais from pais where id=".$row_final -> ipaisret);
			while($row=mysqli_fetch_object($res))
				$row_final->lugar=$row->nombrepais;
				
			$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreestado from estados where id=".$row_final -> iestadoret);
			while($row=mysqli_fetch_object($res))
				$row_final->lugar.=", ".$row->nombreestado;
			
			
			$row_final->importedonativosformatret="$".number_format($row_final->importedonativosret,0,".",",")." ".$moneda;
			// para pintar el status
			$status=calculaStatus($row_final);
			$row_final->statusEtiqueta=$status->etiqueta;
			$row_final->statusColor=$status->color;
			$row_final->statusValor=$status->valor;
			
			if($status->valor==0 || $status->valor==1 || $status->valor==2)
				$row_final->displayapoyar="block";
			else $row_final->displayapoyar="none";
			
			
			if($args["grafico"]=="detalle")
			{
				$row_final->editar=$idiomas["Editar"];
				$row_final->edit=$idiomas["Edit"];
			
				$row_final->ganadores=$idiomas["Ganadores"];				
				$row_final->minimodonativoformatret=haceRenglonDetalle("format",$row_final->minimodonativoret,"",$row_final->colorcat,$idiomas["Apoyo minimo"]);
				
				$maximosGanadoresPermitidos=4;
				$row_final->ganadoresdisponiblesreal=0;
				if($row_final->ffinret>=date("Y-m-d")) // no ha terminado
				{			
					if($row_final->maximoganadoresret==0) // no hay maximo de ganadores
					{
						if($row_final->minimodonativoret==0) // minimo donativo=0 entonces solo puede haber un ganador
							$row_final->ganadoresdisponiblesreal=1;
						else	
							$row_final->ganadoresdisponiblesreal=$maximosGanadoresPermitidos;
						$row_final->descGanadores=haceRenglonDetalle("normal",$idiomas["Todas"],"",$row_final->colorcat,$idiomas["Ganadores disponibles"]);
					}
					else  // hay maximo de ganadores
					{
						if($row_final->maximoganadoresret>$row_final->tganadoresret) // aun hay ganadores disponibles
						{
							if($row_final->minimodonativoret==0) // minimo donativo=0 entonces solo puede haber un ganador
								$row_final->ganadoresdisponiblesreal=1;
							else
								$row_final->ganadoresdisponiblesreal=$row_final->maximoganadoresret-$row_final->tganadoresret;
							
							if($row_final->ganadoresdisponiblesreal>$maximosGanadoresPermitidos) // nos pasamos de los permitidos en general
								$row_final->ganadoresdisponiblesreal=$maximosGanadoresPermitidos;
								
							$resta=$row_final->maximoganadoresret-$row_final->tganadoresret;
							$row_final->descGanadores=haceRenglonDetalle("normal",$resta." ".$idiomas["de"]." ".$row_final->maximoganadoresret,"",$row_final->colorcat,$idiomas["Ganadores disponibles"]);
						}
						else // ya ho nay disponibilidad, no mostramos
						{
							$row_final->ganadoresdisponiblesreal=0;
							$row_final->descGanadores="";
						}
							
						
						if($row_final->minimodonativoret==0) // minimo donativo=0 entonces solo puede haber un ganador
							$row_final->ganadoresdisponiblesreal=1;
					}
				}
				else $row_final->descGanadores="";
				if($row_final->metaret>0)
				{
					$row_final->descMeta=haceRenglonDetalle("normal","$".number_format($row_final->importedonativosret,0,".",",")." ".$moneda." ".$idiomas["de"]." "."$".number_format($row_final->metaret,0,".",",")." ".$moneda,"",$row_final->colorcat,$idiomas["Avance"]);
				}
				else $row_final->descMeta="";

				//$row_final->minimodonativoformatret="$".number_format($row_final->minimodonativoret,0,".",",")." ".$moneda;
				$row_final->condiciones=haceRenglonDetalle("normal",$row_final->condicionesret,"",$row_final->colorcat,$idiomas["Condiciones"]);
				$row_final->url=haceRenglonDetalle("url",$row_final->urlret,"",$row_final->colorcat,$idiomas["Mas informacion"]);
				$row_final->domicilio=haceRenglonDetalle("normal",$row_final->domicilio1ret,$row_final->domicilio2ret,$row_final->colorcat,$idiomas["Lugar"]);
				$row_final -> vigencia="";
				if($row_final->finicioret<>$row_final->ffinret)
					$row_final -> vigencia = strftime("%A, %d %B, %Y", strtotime($row_final -> finicioret)) ." / ".strftime("%A, %d %B, %Y", strtotime($row_final -> ffinret)); //  %H:%Mhrs
				else
					$row_final -> vigencia = strftime("%A, %d %B, %Y", strtotime($row_final -> finicioret));
				$row_final->vigencia=haceRenglonDetalle("normal",$row_final -> vigencia,"",$row_final->colorcat,$idiomas["Vigencia"]);

				$row_final->displayeditar="none";
				$row_final->displayeditarotro="none"; // el botón del segundo idioma
				if(($row_final->statusret==3 && $_SESSION["logged"]->id==$row_final->iusuarioret) || $_SESSION["logged"]->cms=="1") // es dueño o admin
				{
					$row_final->displayeditar="block";
					if($dosIdiomas) $row_final->displayeditarotro="block";
				}
			}
		}
		
		

		
		if($idioma==0) 
		{
			$complemento="iniciativa";
			$complementodonar="pagos";
			$complementodousuario="usuario";
		}
		else 
		{
			$complemento="initiative";
			$complementodonar="payments";
			$complementodousuario="user";

		}
		if($args["sincroniza"]=="si" || $_SESSION["remote"]==1) 
		{
		   foreach( $row_final as $key => $value )
			 $row_final -> $key = utf8_encode($value); 
		}
		
        $row_final -> urlAmigableret = convierte_url_API($row_final ->urlamigableret,$complemento,$row_final -> idreal);
		$row_final -> urlAmigabledonarret = convierte_url_API($row_final ->urlamigableret,$complementodonar,$row_final -> idreal);
		$row_final -> urlAmigabledonarusuario = convierte_url_API($row_final ->urlusuario,$complementodousuario,$row_final -> iusuarioret);
        $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

function haceRenglonDetalle($tipo,$valor1,$valor2,$color,$titulo)
{
	global $moneda;
	$cadena="";
	
	if($valor1<>"" && $valor2<>"")
		$valor1=$valor1." ".$valor2;
	if($valor1<>"" && $valor1<>"0")
	{
		if($tipo=="url")
			$valor1='<a href="'.$valor1.'" target="_blank">'.$valor1.'</a>';
		else if($tipo=="format")
			$valor1="$".number_format($valor1,0,".",",")." ".$moneda;
			
		$cadena='<div class="fila">
                                	<div class="punto_fil" style="background-color:'.$color.'"></div>
                                    <strong><b>'.$titulo.':</b> '.$valor1.' </strong>
                                </div>';
	}
	return $cadena;
}

function ret_lee_especial($args)
{
	global $moneda;
	
	if($args["sql_extra"]=="gusta")
		$sql="select ret.id as idreal,nombreret,imagenret,importedonativosret,urlamigableret from gus left join ret on gus.iretgus=ret.id where iusuariogus=".$args["idusuario"]."  order by finicioret desc";
	else
		$sql="select ret.id as idreal,nombreret,imagenret,importedonativosret,urlamigableret from ret left join usuarios on ret.iusuarioret=usuarios.id where iusuarioret=".$args["idusuario"].$args["sql_extra"]." order by finicioret desc";
	if($args["limite"]) $sql.=" limit 0,".$args["limite"];
	
	$result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		 foreach( $row_final as $key => $value )
			 $row_final -> $key = htmlentitiesMemo($value); 
			 
		if($idioma==0) $complemento="iniciativa";
		else $complemento="initiative";
		$row_final -> urlAmigableret = convierte_url_API($row_final ->urlamigableret,$complemento,$row_final -> idreal);

		if($_SESSION["mobile"]) $tipoimagen="E";	
		else $tipoimagen="D";
		if($row_final -> imagenret=="") 
				$row_final -> imagenret="elementos/generales/noprofile.png";
		$row_final -> imagenret = genera_imagen_API ($row_final -> imagenret,$tipoimagen); 
		
		$row_final->importedon="$".number_format($row_final->importedonativosret,0,".",",")." ".$moneda;
		$row_final_array [] = $row_final;
    }
    return $row_final_array;
}

function cret_lee($args)
{
	global $idioma;
    $row_final_array = array();
    if($args["campos"] == "")
        $args["campos"] = "iretcret,labelcret,i_labelcret,mincret,maxcret,reqcret,opcionescret,i_opcionescret,tipocret";

    if($args["sincroniza"]=="si" || $_SESSION["remote"]==1)
    {
    	$args["campos"].=",cret.activo";
    	$sql_activo="";
    }
    else $sql_activo=" where activo=1";
    $sql = "SELECT id as idreal,".$args["campos"]." FROM cret".$sql_activo;
   	if($args["sql_extra"]<>"")
   	{
   		if($sql_activo=="") $sql.=" where (".$args["sql_extra"].")";
   		else $sql.=" and (".$args["sql_extra"].")";
   	}
    if($args["order"]<>"") $sql.=" order by ".$args["order"];
	else $sql.="order by id asc";
    if($args["numero_pagina"]<>"" && $args["numero_pagina"]<>"0")
    {
        if($args["items_por_pagina"]=="" || $args["items_por_pagina"]=="0") $args["items_por_pagina"] = 20;
        $sql.= " limit ".round(($args["numero_pagina"]-1)*$args["items_por_pagina"]).",".$args["items_por_pagina"];
    }
	//echo $sql;
    $result_final = mysqli_query($GLOBALS["enlaceDB"] , $sql );
    while( $row_final = mysqli_fetch_object( $result_final ))
    {
		if($idioma==1 && $args["leerIdiomas"]=="si")  // textoIngles viene del formulario
		{   
			$row_final->labelcret=lee_ingles($row_final->labelcret,$row_final->i_labelcret);
			$row_final->opcionescret=lee_ingles($row_final->opcionescret,$row_final->i_opcionescret);
		} 
		
         if($args["sincroniza"]=="si" || $_SESSION["remote"]==1) 
           foreach( $row_final as $key => $value )
             $row_final -> $key = utf8_encode($value);   
         $row_final_array [] = $row_final;
    }
    return $row_final_array;
}

?>