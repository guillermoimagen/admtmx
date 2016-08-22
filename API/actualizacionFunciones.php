<?
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."ret.php");

function actualizaUsuario($idusuario,$modo)
{
	
	if($modo=="donador")
	{
		// actualizaremos el donador
		$ndonusuario=0;
		$idonusuario=0;
		$donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as idonusuario,count(id) as ndonusuario from don where statusdon='2' and iusuariodonodon=".$idusuario);
		while($donativosRow=mysqli_fetch_object($donativos))
		{
			if($donativosRow->idonusuario)
				$idonusuario=$donativosRow->idonusuario;
			if($donativosRow->ndonusuario)
				$ndonusuario=$donativosRow->ndonusuario;
		}
		@mysqli_query($GLOBALS["enlaceDB"] ,"update usuarios set idonusuario=".$idonusuario.",ndonusuario=".$ndonusuario." where id=".$idusuario." limit 1");
	}
	else if($modo=="receptor")
	{
		// actualizaremos el receptor del donativo
		$nrdonusuario=0;
		$irdonusuario=0;
		$donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as irdonusuario,count(id) as nrdonusuario from don where statusdon='2' and iusuariodon=".$idusuario);
		while($donativosRow=mysqli_fetch_object($donativos))
		{
			if($donativosRow->irdonusuario)
				$irdonusuario=$donativosRow->irdonusuario;
			if($donativosRow->nrdonusuario)
				$nrdonusuario=$donativosRow->nrdonusuario;
		}
		@mysqli_query($GLOBALS["enlaceDB"] ,"update usuarios set irdonusuario=".$irdonusuario.",nrdonusuario=".$nrdonusuario." where id=".$idusuario." limit 1");
	}
	return true;
}
function actualizaRet($reto)
{
	// actualizaremos el reto
	$importedonativosret=0;
	$tdonativosret=0;
	$donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as importedonativosret,count(id) as tdonativosret from don where statusdon='2' and iretdon=".$reto->idreal);
	while($donativosRow=mysqli_fetch_object($donativos))
	{
		if($donativosRow->importedonativosret)
			$importedonativosret=$donativosRow->importedonativosret;
		if($donativosRow->tdonativosret)
			$tdonativosret=$donativosRow->tdonativosret;
	}
	
	$tganadoresret=0;
	$donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(ganadordon) as tganadoresret from don where ganadordon>=1 and statusdon='2' and iretdon=".$reto->idreal);
	while($donativosRow=mysqli_fetch_object($donativos))
	{
		if($donativosRow->tganadoresret)
			$tganadoresret=$donativosRow->tganadoresret;
	}
	@mysqli_query($GLOBALS["enlaceDB"] ,"update ret set importedonativosret=".$importedonativosret.",tdonativosret=".$tdonativosret.",tganadoresret=".$tganadoresret." where id=".$reto->idreal." limit 1");
	return true;
}

// si temporalStatus=="" no reseteamos nada
function registrarPagoDon($idDon,$nuevoStatus)
{
	global $archivoactual;
	$enviarMail=true;
	if($archivoactual=="integridad.php")
		$enviarMail=false;
	
	$error="";
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select * from don where id=".$idDon);
	while($don=mysqli_fetch_object($res))
	{
		$statusActual=10;
		if($archivoactual<>"don.php" && $archivoactual<>"integridad.php") 
			$statusActual=$don->statusdon; // no es de admin
			
		if($statusActual<>$nuevoStatus) // solo ejecutamos si hay cambio de status
		{
		
			if($don->iretdon<>0)
			{
				$ret=ret_lista_lee(array("grafico"=>"detalle","sql_extra"=>" and ret.id=".$don->iretdon,"excepcionActivos"=>"si"));
				
				if(sizeof($ret)==1)
				{
					$reto=$ret[0];
					
					// actualizamos el reto para arrancar
					if($nuevoStatus==2) // reseteamos para que se limpie el reto y calculemos todo en desde el principio
					{
						@mysqli_query($GLOBALS["enlaceDB"] ,"update don set statusdon='0' where id=".$idDon." limit 1");
						actualizaRet($reto); 
						// volvemos a leer el reto para poder calcular
						$ret=ret_lista_lee(array("grafico"=>"detalle","sql_extra"=>" and ret.id=".$don->iretdon,"excepcionActivos"=>"si"));
						$reto=$ret[0];
					}
					
					// actualiza el donativo con el nuevo status
					if(@mysqli_query($GLOBALS["enlaceDB"] ,"update don set statusdon='".$nuevoStatus."' where id=".$idDon." limit 1"))
					{
						if($nuevoStatus==3) // cancelado
							hacebit(14,3,$idDon);
						else if($nuevoStatus==2) // pagado
							hacebit(12,3,$idDon);
	
						
						
						$acumulado=0; // ya incluyendo esta
						$acumulados=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as total from don where statusdon='2' and iusuariodonodon=".$don->iusuariodonodon." and iusuariodon=".$don->iusuariodon);
						while($acumuladosRow=mysqli_fetch_object($acumulados))
						{
							if($acumuladosRow->total)
								$acumulado=$acumuladosRow->total;
						}
						// vemos si seras ganador
						$extra="";
						$ganadorTotal=0;
						
						if($nuevoStatus<>2) // es cacnelacione, el maximo no importa
							$reto->ganadoresdisponiblesreal=4;
							
						// if($reto->maximoganadoresret>$reto->tganadoresret && $don->importedon>=$reto->minimodonativoret) // aun seras ganador
						if($reto->ganadoresdisponiblesreal>0) // aun hay disponibilidad
						{
							// veremos cuanto ganaste
							if($reto->minimodonativoret==0) $ganadorTotal=1; // si el donatibo minimo es cero, entonces hay un ganado maximo
							else $ganadorTotal=floor($don->importedon/$reto->minimodonativoret); // calculamos cuantos gano
							
							if($ganadorTotal>$reto->ganadoresdisponiblesreal) // ya nos pasamos de los disponibles, entonces los que gano son los disponibles
								$ganadorTotal=$reto->ganadoresdisponiblesreal;
								
							/*
							if($don->ganadordon<$ganadorTotal && $don->ganadordon<>0) // tenemos menos ganadores registrados (que raro), los que gano son los registrados
								$ganadorTotal=$don->ganadordon;*/
								
						}
						$extra=",ganadordon='".$ganadorTotal."'";
						
						// guardamos si eres ganador y el acumulado calculado
						@mysqli_query($GLOBALS["enlaceDB"] ,"update don set acumuladodon=".$acumulado.$extra." where id=".$don->id." limit 1");
					
						// actualizamos el acumulado
						@mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO acu (acumuladoacu, iusuario1acu, iusuario2acu) VALUES(".$acumulado.",". $don->iusuariodon.",". $don->iusuariodonodon.") ON DUPLICATE KEY UPDATE acumuladoacu=".$acumulado);	
						
						// actualizamos los vret fuera de campo
						if($nuevoStatus==2)
						{
							@mysqli_query($GLOBALS["enlaceDB"] ,"update vret set statusvret='2' where idonvret=".$don->id." and ganvret>".$ganadorTotal);
							@mysqli_query($GLOBALS["enlaceDB"] ,"update vret set statusvret='1' where idonvret=".$don->id." and ganvret<=".$ganadorTotal);
						}
						else @mysqli_query($GLOBALS["enlaceDB"] ,"update vret set statusvret='1' where idonvret=".$don->id);
						
						actualizaRet($reto);
						actualizaUsuario($don->iusuariodonodon,"donador");
						actualizaUsuario($don->iusuariodon,"receptor");
					
						if($enviarMail && ($nuevoStatus==2 || $nuevoStatus==3)) //  && $statusActual<>$nuevoStatus
							enviarConfirmacionPago($don->id,false);
					}
				}
			}
			else if($don->iusuariodon<>0)
			{
				@mysqli_query($GLOBALS["enlaceDB"] ,"update don set statusdon='".$nuevoStatus."' where id=".$idDon." limit 1");
				$acumulado=0; // ya incluyendo esta
				$acumulados=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as total from don where statusdon='2' and iusuariodonodon=".$don->iusuariodonodon." and iusuariodon=".$don->iusuariodon);
				while($acumuladosRow=mysqli_fetch_object($acumulados))
				{
					if($acumuladosRow->total)
						$acumulado=$acumuladosRow->total;
				}
				@mysqli_query($GLOBALS["enlaceDB"] ,"update don set acumuladodon=".$acumulado." where id=".$don->id." limit 1");
				actualizaUsuario($don->iusuariodonodon,"donador");
				actualizaUsuario($don->iusuariodon,"receptor");
				
				if($enviarMail && ($nuevoStatus==2 || $nuevoStatus==3))
					enviarConfirmacionPago($don->id,false);
			}
			else // directo al corazón
			{
				@mysqli_query($GLOBALS["enlaceDB"] ,"update don set statusdon='".$nuevoStatus."' where id=".$idDon." limit 1");
				actualizaUsuario($don->iusuariodonodon,"donador");
				
				if($enviarMail && ($nuevoStatus==2 || $nuevoStatus==3))
					enviarConfirmacionPago($don->id,false);	
			}
		}
	}
}

function enviarConfirmacionPago($iddon,$validar)
{
	//echo "enviar";
	global $idioma;
	global $idiomas;
	global $dominioSistema;
	global $moneda;
	global $API_folder;
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select don.*,nickusuario,emailusuario from don left join usuarios on don.iusuariodonodon=usuarios.id where don.id=".$iddon." and (statusdon='2' or statusdon='3')");
	if(mysqli_num_rows($res)>0)
	{
		$don=mysqli_fetch_object($res);
		
		if($validar)
		{
			if($_SESSION["logged"]->id==$don->iusuariodonodon || $_SESSION["logged"]->cms==1)
			{
				
			}
			else
			{
				if($idioma==0) echo("No tienes privilegios para esto");
				else echo("You don't have privileges to perform this operation");
				exit;
			}
		}
		
		if($idioma==0)
		{
			$idiomasB["Condiciones"]="Condiciones: ";	
			$idiomasB["Descripcion"]="Descripci&oacute;n: ";	
			$idiomasB["Lugar"]="Lugar: ";	
			$idiomasB["Iniciativa"]="Iniciativa ";
			$idiomasB["Alcancia"]="Alcanc&iacute;a de ";
			$idiomasB["Ver iniciativa"]="Ver iniciativa";
			$idiomasB["Ver alcancia"]="Ver alcanc&iacute;a";
			$idiomasB["ADT Donativo recibido"]="Donativo recibido";
			$idiomasB["ADT Donativo cancelado"]="Donativo rechazado/cancelado";
			$idiomasB["urlPagos"]="pagos.html";
			$idiomasB["Ver"]="Ver";
			$idiomasB["Esta causa"]="Fundaci&oacute;n Telet&oacute;n";
		}
		else 
		{
			$idiomasB["Condiciones"]="Terms and contitions: ";	
			$idiomasB["Descripcion"]="Description: ";	
			$idiomasB["Lugar"]="Place: ";	
			$idiomasB["Iniciativa"]="Initiative ";
			$idiomasB["Alcancia"]="User";
			$idiomasB["Ver iniciativa"]="View initiative";
			$idiomasB["Ver alcancia"]="View user";
			$idiomasB["ADT Donativo recibido"]="Donation registered";
			$idiomasB["ADT Donativo cancelado"]="Donation rejected/canceled";

			$idiomasB["urlPagos"]="payments.html";
			$idiomasB["Ver"]="View";	
			$idiomasB["Esta causa"]="Fundacion Teleton";

		}
		
		if($API_folder=="") 
		{
			$API_folder="API/";
			
		}
		$APIPlantillas=str_replace("API/","APIPlantillas/",$API_folder);
		require_once($API_folder."lib/common.inc.php");
		$args = new stdClass();
		
		if($don->statusdon==2)
		{
			$subject=$idiomasB["ADT Donativo recibido"];
			$args->template = $APIPlantillas."mailing/pagoRecibido.php";
		}
		else 
		{
			$subject=$idiomasB["ADT Donativo cancelado"];
			$args->template = $APIPlantillas."mailing/pagoCancelado.php";
		}
		$args->data = new stdClass();
			
		$args->data->importedon="$".number_format($don->importedon,0,".",",")." ".$moneda;
		$args->data->statusdon=$don->statusdon;
		$args->data->numero=sprintf("%09s",$don->id);
		$args->data->nombreusuario=utf8_encode(htmlentitiesMemo($don->nickusuario));
		$args->data->idioma=round($idioma);
		
		$args->data->nombredestino="";
		$args->data->descripcion="";
		$args->data->condiciones="";
		$args->data->lugar="";
		$args->data->url="";
		$args->data->extras="";			
		$args->data->host=$dominioSistema;				
		if($don->iretdon<>0)
		{	
			$res2=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreret,i_nombreret,descripcionret,i_descripcionret,condicionesret,i_condicionesret,domicilio1ret,urlamigableret from ret where id=".$don->iretdon);
			$ret=mysqli_fetch_object($res2);
			
			$complemento="iniciativa";
		
			if($idioma==1)  // textoIngles viene del formulario
			{   
				$ret->nombreret=lee_ingles($ret->nombreret,$ret->i_nombreret);
				$ret->descripcionret=lee_ingles($ret->descripcionret,$ret->i_descripcionret);
				$ret->condicionesret=lee_ingles($ret->condicionesret,$ret->i_condicionesret);
				$complemento="initiative";
			}  
			$ret -> urlAmigableret	= convierte_url_API($ret ->urlamigableret,$complemento,$don->iretdon);
		
			$args->data->nombredestino=utf8_encode($idiomasB["Iniciativa"].htmlentitiesMemo($ret->nombreret));
			
			if($ret->descripcionret<>"")
				$args->data->descripcion=utf8_encode($idiomasB["Descripcion"].htmlentitiesMemo($ret->descripcionret))."<br><br>";
			if($ret->condicionesret<>"")
				$args->data->condiciones=utf8_encode($idiomasB["Condiciones"].htmlentitiesMemo($ret->condicionesret))."<br><br>";
			
			$args->data->lugar="";
			if($ret->domicilio1ret<>"")
				$args->data->lugar=htmlentitiesMemo($ret->domicilio1ret).". ";
			
			if($args->data->lugar<>"")
				$args->data->lugar=utf8_encode($idiomasB["Lugar"].$args->data->lugar)."<br><br>";
			
			$args->data->url="<a href='".$dominioSistema.$ret -> urlAmigableret."'>".utf8_encode($idiomasB["Ver iniciativa"])."</a><br><br>";	
			
			if($don->ganadordon>0)
			{
				$cadena="<strong>".$idiomas["Ganadores"]."</strong>: ".$don->ganadordon."<br>";
				$campo="labelcret";
				if($idioma==1) $campo="i_labelcret";
				for($i=1; $i<=$don->ganadordon; $i++)
				{
					$vret=@mysqli_query($GLOBALS["enlaceDB"] ,"select ".$campo." as labelcret,valorvret from cret left join vret on cret.id=vret.icretvret where ganvret=".$i." and iretcret=".$don->iretdon." and idonvret=".$don->id." order by cret.id asc");
					if(mysqli_num_rows($vret)>0)
					{
						$cadena.="<strong>".$idiomas["Ganador"]." ".$i."</strong> ";
						while($rowVret=mysqli_fetch_object($vret))					
							$cadena.=htmlentitiesMemo($rowVret->labelcret).": ".htmlentitiesMemo($rowVret->valorvret)."&nbsp;&nbsp;";
						$cadena.="<br>";
					}
					
				}
				if($cadena<>"")
					$args->data->acreedores=utf8_encode($cadena)."<br>";
			}
		}
		else if($don->iusuariodon<>0)
		{
			$usuarios=@mysqli_query($GLOBALS["enlaceDB"] ,"select nickusuario,urlusuario from usuarios where id=".$don->iusuariodon);
			$usuario=mysqli_fetch_object($usuarios);
			
			$complemento="usuario";
			if($idioma==1)  $complemento="user";

			$args->data->nombredestino=utf8_encode($idiomasB["Alcancia"].htmlentitiesMemo($usuario->nickusuario));
			$args->data->url="<a href='".$dominioSistema.convierte_url_API($usuario ->urlusuario,$complemento,$don->iusuariodon)."'>".utf8_encode($idiomasB["Ver alcancia"])."</a><br><br>";	
						

		}
		else
		{
			$args->data->nombredestino=utf8_encode($idiomasB["Esta causa"]);
			$args->data->url="<a href='".$dominioSistema.$idiomasB["urlPagos"]."'>".utf8_encode($idiomasB["Ver"])."</a><br><br>";
		}
		if($don->emailusuario<>"")
		{
			Mailer::sendEmail($don->emailusuario, $subject, $args);
			if($validar)
			{
				if($idioma==0) echo("Comprobante enviado a ".$don->emailusuario.". Si deseas enviarlo a otra actualiza tu perfil.");
				else echo ("Sent to ".$don->emailusuario.". If you you want to receive it in another email address, update your profile");
			}
		}
		else 
		{
			if($validar)
			{
				if($idioma==0) echo("Debes proporcionar tu dirección de email");	
				else echo("You should provide your email address");
			}
		}
	}
	
}


?>