<?
include("include/connection.php");

error_reporting(E_ERROR);

include("imagenesiniciativas/sensaciones.php");

include("imagenesiniciativas/celebridades/celebridades.php");
include("imagenesiniciativas/empresas/conector.php");
include("imagenesiniciativas/empresas/terminales.php");

$esWeb=1;
$API_folder = "API/";
include_once($API_folder."funcionesWeb_API.php");
include_once($API_folder."funciones_API.php");
include_once($API_folder."ret.php");
include_once($API_folder."don.php");
include_once($API_folder."cont.php");
include_once($API_folder."actualizacionFunciones.php");


require_once 'imagenesiniciativas/embajadores/sdk/lib/PayU.php';

if(!checaUsuarioActivo()) exit();




$error_pago="";
$vistaregistro=false;
// traemos el id del pago en paypal
if(isset($_GET["paymentId"]))
{	
	$don=don_lee_especial(array("grafico"=>"sql","sql_extra"=>"clavedon='".mysqli_real_escape_stringMemo($_GET["paymentId"])."'","leerDetalle"=>1));
	if(sizeof($don)>0)
	{
	
		$donleido=$don[0];
		if($donleido->iretdon<>0) $_GET["idiniciativa"]=$donleido->iretdon;
		else if($donleido->iusuariodon<>0) $_GET["idusuario"]=$donleido->iusuariodon;
		
		
		//aqui tambien la podemos actualizar *************************************************************************************************
		//************** no tocar ************************************************************************************************************	
		$sqlquery="select * from transacciones where idon=".$donleido->idreal." and executado='0' order by id DESC limit 1";	

		//echo $sqlquery;

		$responsedb=mysqli_query($GLOBALS["enlaceDB"] ,$sqlquery);
		
		if(mysqli_num_rows($responsedb)==1){
			$rows=mysqli_fetch_object($responsedb);
			//ejecutamos el pago y checamos que responde
			
			$ppE=new psPayPal("","","");
			$execute=$ppE->ExecutePay($rows->urlexecute,$rows->token,mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["PayerID"]));
				
			if($execute=="approved"){
				//pago realizado actualizamos la base de gatos
				$allresponse=$ppE->Get_ALLRESPONSEEXECUTE();
				$allresponse=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$allresponse);
				$sqlupdate="update transacciones set state='APPROVED',executado='1',respuesta='".$allresponse."',urlrefund='".$ppE->getURL_refund()."',idtransaccionfinal='".$ppE->getidtransactionfinal()."',total='".$ppE->getmontofinal()."',moneda='".$ppE->getmonedafinal()."' where id=".$rows->id." limit 1";	

				//actualizamos el importe de pago por el que regreso el servicio por si paga menos
				$sqldon="update don set importedon='".$ppE->getmontofinal()."' where id='".$donleido->idreal."'";
				//echo $sqldon; 
				mysqli_query($GLOBALS["enlaceDB"] ,$sqldon);

				mysqli_query($GLOBALS["enlaceDB"] ,$sqlupdate);
				registrarPagoDon($donleido->idreal,2);
			}else{
				$error_pago="No se pudo generar el pago en paypal";
			}
			
			//actualizamos el estatus del donativo
			$don=don_lee_especial(array("grafico"=>"sql","sql_extra"=>"clavedon='".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["paymentId"])."'","leerDetalle"=>1));
			$donleido=$don[0];
			//
		}
		//************************************************************************************************************************************
		
	}
}



$cabezaPrincipal=abre_plantilla_API("cabezaPrincipal",false);
$cabeza=abre_plantilla_API("cabeza",true);

$contenido=abre_plantilla_API("pagos",false);

$sepudo=false;
	
$cont=cont_lee(array("id"=>4));
$plantilla->tituloformasdepago=$cont[0]->nombrecont;
$plantilla->formasdepago=$cont[0]->textocont;
$ganadoresdisponiblesreal=0;





// en todo este bloque leemos la iniciativa, usuario o corazon digital
if(isset($_GET["idiniciativa"]))
{
	$sql_extra_url="";
	if(isset($_GET["urlamigable"]))
		$sql_extra_url=" and urlamigableret='".mysqli_real_escape_stringMemo($_GET["urlamigable"])."'";
	$iniciativaDetalleArreglo=ret_lista_lee(array("grafico"=>"detalle","sql_extra"=>" and ret.id=".(int)$_GET["idiniciativa"].$sql_extra_url));
	
	if(sizeof($iniciativaDetalleArreglo)>0)
	{
		
		// tiene el status correcto
		if( $iniciativaDetalleArreglo[0]->statusValor<=2) 
		{
			$sepudo=true;
			$contenidoPrincipal=abre_plantilla_API("pagosIniciativa",false);
			$iniciativaDetalleArreglo[0]->share=generaShareButtons($iniciativaDetalleArreglo[0]->urlAmigabledonarret);	
			$iniciativaDetalleArreglo[0]->veriniciativa=$idiomas["Ver iniciativa"];	
			
			$iniciativaDetalleArreglo[0]->displayapoyar="none";
			if($_POST["operacion"]=="pagar")
			{
				$iniciativaDetalleArreglo[0]->displayapoyar="block";
				$iniciativaDetalleArreglo[0]->apoyar=$idiomas["Apoyar otra vez"];
			}
			$color=$iniciativaDetalleArreglo[0]->colorcat;
			$contenidoPrincipal=generaVistaRecursiva($contenidoPrincipal,$iniciativaDetalleArreglo);
			$plantilla->contenidoPrincipal=$contenidoPrincipal;
			$redes=generaRedes($iniciativaDetalleArreglo[0]->nombreret,
								$iniciativaDetalleArreglo[0]->imagenret,
								$iniciativaDetalleArreglo[0]->descripcionret,
								$iniciativaDetalleArreglo[0]->urlAmigabledonarret);
			$tituloPrincipal=$iniciativaDetalleArreglo[0]->nombreret;
			$montominimo=$iniciativaDetalleArreglo[0]->minimodonativoret;
			$ganadoresdisponiblesreal=$iniciativaDetalleArreglo[0]->ganadoresdisponiblesreal;
			$urlregreso=$iniciativaDetalleArreglo[0]->urlAmigabledonarret;
		}
		else
			$plantilla->contenidoPrincipal=$idiomas["iniciativa no vigente"];
	}	
}
else if(isset($_GET["idusuario"]))
{
	$sql_extra_url="";
	if(isset($_GET["urlamigable"]))
		$sql_extra_url=" and urlusuario='".mysqli_real_escape_stringMemo($_GET["urlamigable"])."'";
	$usuarios=usuarios_lee(array("sql_extra"=>"validadousuario='1' and id=".(int)$_GET["idusuario"].$sql_extra_url));
	if(sizeof($usuarios)>0)
	{
		$sepudo=true;
		$contenidoPrincipal=abre_plantilla_API("pagosUsuario",false);
		$usuarios[0]->share=generaShareButtons($usuarios[0]->urlAmigabledonarusuario);	
		$usuarios[0]->importe=$idiomas["Importe"];
		$usuarios[0]->donaciones=$idiomas["Donaciones"];
		$usuarios[0]->donacionesrecibidas=$idiomas["Donaciones recibidas"];
		$usuarios[0]->colorcat="#9B539C";
		$color="#9B539C";
		$contenidoPrincipal=generaVistaRecursiva($contenidoPrincipal,$usuarios);                   	
		$plantilla->contenidoPrincipal=$contenidoPrincipal;
		$redes=generaRedes($usuarios[0]->nickusuario,
								$usuarios[0]->imagenusuario,
								"",
								$usuarios[0]->urlAmigabledonarusuario);
		$tituloPrincipal=$usuarios[0]->nickusuario;
		$montominimo=1;
		$urlregreso=$usuarios[0]->urlAmigabledonarusuario;
	}				
}
else if(!isset($_GET["paymentId"]) || $donleido)
{
	$sepudo=true;
	$corazon=cont_lee(array("id"=>6));
	$contenidoPrincipal=abre_plantilla_API("pagosCorazon",false);
	if($idioma==0) $url="pagos.html";
	else $url="payments.html";
	$corazon[0]->share=generaShareButtons($url);	
	$corazon[0]->colorcat="#9B539C";
	$color="#9B539C";
	$montominimo=1;
	$contenidoPrincipal=generaVistaRecursiva($contenidoPrincipal,$corazon);                   	
	$plantilla->contenidoPrincipal=$contenidoPrincipal;
	$redes=generaRedes($corazon[0]->nombrecont,
							$corazon[0]->imagencont,
							"",
							$url);
	$tituloPrincipal=$corazon[0]->nombrecont;
	$urlregreso="pagos.php";
}

if(!$sepudo) 
{
	$e404=true;
	$contenido=abre_plantilla_API("noencontrado",false);
	$contenido=str_replace("<aviso>",$idiomas["Informacion no encontrada"],$contenido);
}
else // no hubo error
{	
	// procesamos cosas enviadas por form
	if($_POST["operacion"]=="registroparcial")
	{
		include("imagenesiniciativas/iparcial.php");
	}
	else if($_POST["operacion"]=="registroactualizar") // vamos a actualizar el mail de este cuate
	{
		include("imagenesiniciativas/iactualizar.php");
	}
	else if($_POST["operacion"]=="pagar")
	{
		$errorText=tokRevisa($_POST["toks"]);
		if((int)$_POST["pagos"]==0 || !isset($_POST["pagos"]))
			$errorText="Error 1320";
			
		if($errorText=="")
		{
			$iformadon=(int)$_POST["pagos"];  // jesus esta es la forma de pago, tienes que asignar el número correspondiente
			include("imagenesiniciativas/imostrariniciativa.php");
			
			if($iddonativo<>0)
			{
				$pagado=false;
				include("imagenesiniciativas/plataforma.php");
				$Cobrar=new Cobrador(mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["donativo"]),$iformadon,(int)$_POST["idiniciativa"],mysqli_real_escape_stringMemo($_POST["nombreret"]),$iddonativo);
				

				//**************************************************************************************************
				$iusuariodonodonenviar=0;
				if($_SESSION["firmado"]) // el firmado gana
					$iusuariodonodonenviar=$_SESSION["logged"]->id;
				else if(isset($_SESSION["loggedParcial"]->id) && $_SESSION["loggedParcial"]->id<>0)
					$iusuariodonodonenviar=$_SESSION["loggedParcial"]->id;
		
				$resTempoUsuario=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario from usuarios where id=".$iusuariodonodonenviar);
				while($rowTempoUsuario=mysqli_fetch_object($resTempoUsuario))
				{
					$emailusuario=$rowTempoUsuario->emailusuario;	
				}
				//**************************************************************************************************
				
				$Cobrar->setUrlcancel($dominioSistema.mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["urlregreso"]));
				$Cobrar->Set_PayuIPN($dominioSistema."imagenesiniciativas/embajadores/embajadores.php");
				$Cobrar->setPayerPAYU($emailusuario);
	
				//echo $dominioSistema."lospagos/payu/ipnresponse.php";
				//en caso de ser para panamex
				if($iformadon=="1"){
					////$Laterminal=new terminales($iddonativo);
					////$Laterminal->hayTerminal();
					////$Cobrar->SetBanamex($_POST["ntarjeta"],$_POST["cseg"],$_POST["vencimiento"],$Laterminal->GetTerminal());
					
					
					$tdcop->nombre=mysqli_real_escape_stringMemoPost($_POST["TDC_nombre"]);
					$tdcop->tipotarjeta=mysqli_real_escape_stringMemoPost($_POST["TDC_tipo"]);
					$tdcop->tarjeta=mysqli_real_escape_stringMemoPost($_POST["TDC_tarjeta"]);
					$tdcop->expiracion=mysqli_real_escape_stringMemoPost($_POST["TDC_ano"])."/".mysqli_real_escape_stringMemoPost($_POST["TDC_mes"]);
					$tdcop->cst=mysqli_real_escape_stringMemoPost($_POST["TDC_cst"]);
					
					$tdcop->calle=mysqli_real_escape_stringMemoPost($_POST["TDC_calle"]);
					$tdcop->numero=mysqli_real_escape_stringMemoPost($_POST["TDC_numero"]);
					$tdcop->colonia=mysqli_real_escape_stringMemoPost($_POST["TDC_colonia"]);
					$tdcop->cp=mysqli_real_escape_stringMemoPost($_POST["TDC_cp"]);
					$tdcop->ciudad=mysqli_real_escape_stringMemoPost($_POST["TDC_ciudad"]);
					$tdcop->estado=mysqli_real_escape_stringMemoPost($_POST["TDC_estado"]);
					$tdcop->telefono=mysqli_real_escape_stringMemoPost($_POST["TDC_etelefono"]);
					$tdcop->descr=htmlentitiesMemoStrong($_POST["nombreret"]);	
					$tdcop->amount=mysqli_real_escape_stringMemoPost($_POST["donativo"]);
					$tdcop->sse=mysqli_real_escape_stringMemoPost($_POST["sse"]);
					
					$tdcop->nacimiento=mysqli_real_escape_stringMemoPost($_POST["TDC_nacimiento"]);
					$tdcop->dni=mysqli_real_escape_stringMemoPost($_POST["TDC_identificacion"]);
										
					$Cobrar->setDataPayuCreditCar($tdcop);
				}
	
	
				 
				$RespuestaCobra=$Cobrar->Cobra();
				

				//no importa cual sea la respuesta la guardasmos siempre y cuando se de tarjeta de credito
				if($iformadon=="1"){
					
					
					$fecha=date("Y-m-d H:i:s");
					
					if($RespuestaCobra=="SUCCESS"){
						$RespuestaCobra="APPROVED";
					}
					
					$sqlt="insert into transacciones set 
					idon='".$iddonativo."',
					tipo=1, 
					total='".mysqli_real_escape_stringMemoPost($_POST["donativo"])."',
					moneda='MXN',
					state='".$RespuestaCobra."',
					respuesta='".mysqli_real_escape_stringMemoPost($Cobrar->getResponseTDCPAYU())."',
					activo=1,
					idtransaccionfinal='".$Cobrar->Getidpayment()."',
					fechafinal='".$fecha."'";
					
	
					mysqli_query($GLOBALS["enlaceDB"] ,$sqlt);
					
					$last4=substr($tdcop->tarjeta, -4); 
					
					$sqlt="insert into memo set
					idon='".$iddonativo."',
					memotarjeta='".$last4."',
					memotipotarjeta='".$tdcop->tipotarjeta."',
					memocalle='".$tdcop->calle."',
					memonumero='".$tdcop->numero."',
					memocolonia='".$tdcop->colonia."',
					memocp='".$tdcop->cp."',
					memociudad='".$tdcop->ciudad."',
					memoestado='".$tdcop->estado."',
					memotelefono='".$tdcop->telefono."',
					nombre='".$tdcop->nombre."'";
					
				
					mysqli_query($GLOBALS["enlaceDB"] ,$sqlt);
					
					
					
				}
					
				
				if($RespuestaCobra=="SUCCESS"){
					$pagado=true;
				}else{
					
					$error_pago=$Cobrar->GetError();
					
					
					if($RespuestaCobra=="PENDING" and $iformadon=="1"){
						$error_pago=mensajeIdioma("pagoPendientePayu").$Cobrar->moredataRet;
					}
					
					if($RespuestaCobra=="ERROR" and $iformadon=="1"){
						$sqldon="update don set statusdon=4 where id='".$iddonativo."' limit 1";
						mysqli_query($GLOBALS["enlaceDB"] ,$sqldon);
					}
					
					
				}
			}
		}
	}

	$plantilla->colorcat=$color;
	// estas firmado o hay un registro parcial enotnces puedes proceder
	
	if(isset($_GET["paymentId"]))
	{
		
		if($error_pago=="")
		{
			if($donleido->statusdon==2)
				$vistaContenido=abre_plantilla_API("pagosVistaRegresoPaypal",true);
			else $vistaContenido=abre_plantilla_API("pagosVistaRegresoPaypalPendiente",true);	
			$plantillaPago->importedon=$donleido->importedon;
			$plantillaPago->status=$donleido->status;
			$vistaContenido=generaVista($vistaContenido,$plantillaPago);	
			$plantilla->vistaContenido=$vistaContenido;
		}
		else
		{
			$vistaContenido=abre_plantilla_API("pagosVistaRegresoPaypalError",true);
			$plantillaPago->error=$error_pago;
			$vistaContenido=generaVista($vistaContenido,$plantillaPago);	
			$plantilla->vistaContenido=$vistaContenido;
		}
	}	
	else if($pagado) // se gestiono el pago
	{
		if($iformadon=="3" or $iformadon=="4" or $iformadon=="5"){
			$vistaContenido=abre_plantilla_API("pagosVistaPagadoPayu",true);
			
			$plantillaPago->pdflink=$Cobrar->GetLinkPdfPAYU();
			$plantillaPago->pdfonline=$Cobrar->GetLinkHtmlPAYU();

			//***************************************************************
				$sql="insert into payu set idon=".$iddonativo.", link1='".$plantillaPago->pdflink."',link2='".$plantillaPago->pdfonline."',fechaexpira='".$Cobrar->GetExpiraPAYU()."'";
				@mysqli_query($GLOBALS["enlaceDB"] ,$sql);
			//***************************************************************
			
			// enviemos mail
			require_once("API/lib/common.inc.php");							
			$args = new stdClass();
			$args->template = "APIPlantillas/mailing/pagoPayu.php";
			$args->data = new stdClass();
			$args->data->idioma=$idioma;
			$args->data->pdflink=$Cobrar->GetLinkPdfPAYU();
			$args->data->pdfonline=$Cobrar->GetLinkHtmlPAYU();
			$args->data->host=$dominioSistema;
			
			$iusuariodonodonenviar=0;
			if($_SESSION["firmado"]) // el firmado gana
				$iusuariodonodonenviar=$_SESSION["logged"]->id;
			else if(isset($_SESSION["loggedParcial"]->id) && $_SESSION["loggedParcial"]->id<>0)
				$iusuariodonodonenviar=$_SESSION["loggedParcial"]->id;
	
			$resTempoUsuario=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario from usuarios where id=".$iusuariodonodonenviar);
			while($rowTempoUsuario=mysqli_fetch_object($resTempoUsuario))
			{
				$args->data->nombreusuario=utf8_encode($rowTempoUsuario->nombreusuario);
				$emailusuario=$rowTempoUsuario->emailusuario;
				Mailer::sendEmail($emailusuario, mensajeIdioma("mailPagoPayu"), $args);
			}
			
						
			$vistaContenido=generaVista($vistaContenido,$plantillaPago);	
		}
		else if($iformadon=="2"){
			//primero actualizamos el idpayment sde payapal
			$sql="update don set clavedon='".$Cobrar->Getidpayment()."' where id=".$iddonativo." limit 1";
			mysqli_query($GLOBALS["enlaceDB"] ,$sql);
			//insertamos registro de transaccion 
			$sqlt="insert into transacciones set idon='".$iddonativo."',tipo=2, token='".$Cobrar->Gettokenpaypal()."',urlexecute='".$Cobrar->Getexecuteurl()."',state='preparado'";
			mysqli_query($GLOBALS["enlaceDB"] ,$sqlt);
			
			$vistaContenido=$Cobrar->GetredirectPaypal();
		}
		
		else if($iformadon=="1"){

			registrarPagoDon($iddonativo,2);
			//$Laterminal->FreeTerminal();

			$vistaContenido=abre_plantilla_API("pagosVistaRegresoPaypal",true);
			$plantillaPago->importedon="$".htmlentitiesMemoStrong($_POST["donativo"]). " MXN";
			$vistaContenido=generaVista($vistaContenido,$plantillaPago).$Cobrar->moredataRet;
			
		}
		
		$plantilla->vistaContenido=$vistaContenido;
	}
	// mostramos el formulario para pagar
	else if($_SESSION["firmado"] || (isset($_SESSION["loggedParcial"]->id) && $_SESSION["loggedParcial"]->id<>0))
	{
		if($_SESSION["firmado"])
		{
			$idbuscarusuario=$_SESSION["logged"]->id;
			$plantillaPago->cambiardonador="";
		}
		else
		{
			$idbuscarusuario=$_SESSION["loggedParcial"]->id;
			$plantillaPago->cambiardonador=$idiomas["Cambiar donador"];
		}
		
		// leamos el email
		$resTempoUsuario=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario,nickusuario from usuarios where id=".$idbuscarusuario);
		while($rowTempoUsuario=mysqli_fetch_object($resTempoUsuario))
		{
			$plantillaPago->emaildonador=htmlentitiesMemoStrong($rowTempoUsuario->emailusuario);
			$plantillaPago->valuetunombre=htmlentitiesMemoStrong($rowTempoUsuario->nombreusuario);
			$plantillaPago->valuetuapodo=htmlentitiesMemoStrong($rowTempoUsuario->nickusuario);
			  
		}
		
		if($plantillaPago->emaildonador=="" || !filter_var($plantillaPago->emaildonador, FILTER_VALIDATE_EMAIL)) // no hay email
		{
			if($_SESSION["firmado"]) // esta firmado, entonces lo pedimos
			{
				$vistaContenido=abre_plantilla_API("pagosVistaNoMail",true);
				if(isset($_POST["tuemail"]) && $_POST["tuemail"]<>"")
					$plantillaPago->emaildonador=htmlentitiesMemoStrong($_POST["tuemail"]);
				if(isset($_POST["tunombre"]) && $_POST["tunombre"]<>"")		
					$plantillaPago->valuetunombre=htmlentitiesMemoStrong($_POST["tunombre"]);
				if(isset($_POST["tuapodo"]) && $_POST["tuapodo"]<>"")
					$plantillaPago->valuetuapodo=htmlentitiesMemoStrong($_POST["tuapodo"]);
				$plantillaPago->error=$mensajeError;
				$vistaContenido=generaVista($vistaContenido,$plantillaPago);	
				
				$plantilla->vistaContenido=$vistaContenido;
			}
			else  // no esta firmado, solicitaremos registro
				$vistaregistro=true;
		}
		else
		{		
			$vistaContenido=abre_plantilla_API("pagosVistaPago",false);
			$plantillaPago->pagosForm=abre_plantilla_API("pagosForm",true);
			
			if(!isset($_GET["idiniciativa"])) $_GET["idiniciativa"]=0; 
			if(!isset($_GET["idusuario"])) $_GET["idusuario"]=0; 
			$plantillaPago->idiniciativa=(int)$_GET["idiniciativa"];
			$plantillaPago->idusuario=(int)$_GET["idusuario"];
			
			// acá van tus variables que metes a la plantilla		
			$plantillaPago->montominimo=$montominimo;
			$plantillaPago->nombrex=urlencode($iniciativaDetalleArreglo[0]->nombreret);
			$plantillaPago->colorcat=$color;
			$plantillaPago->moneda=$moneda;
			$plantillaPago->donarahora=$idiomas["Donar ahora"];
			
			$plantillaPago->deviceSessionId = md5(session_id().microtime());


			//**************************************************************
			if($RespuestaCobra=="ERROR"){
				$plantillaPago->TDC_nombre=htmlentitiesMemoStrong($_POST["TDC_nombre"]);
				$plantillaPago->TDC_tarjeta=htmlentitiesMemoStrong($_POST["TDC_tarjeta"]);
				$plantillaPago->TDC_calle=htmlentitiesMemoStrong($_POST["TDC_calle"]);
				$plantillaPago->TDC_numero=htmlentitiesMemoStrong($_POST["TDC_numero"]);
				$plantillaPago->TDC_colonia=htmlentitiesMemoStrong($_POST["TDC_colonia"]);
				
				$plantillaPago->TDC_cp=htmlentitiesMemoStrong($_POST["TDC_cp"]);
				$plantillaPago->TDC_ciudad=htmlentitiesMemoStrong($_POST["TDC_ciudad"]);
				$plantillaPago->TDC_etelefono=htmlentitiesMemoStrong($_POST["TDC_etelefono"]);

				$plantillaPago->TDC_nacimiento=htmlentitiesMemoStrong($_POST["TDC_nacimiento"]);
				$plantillaPago->TDC_identificacion=htmlentitiesMemoStrong($_POST["TDC_identificacion"]);
												
								
					
			}else{
				$plantillaPago->TDC_nombre="";
				$plantillaPago->TDC_tarjeta="";
				$plantillaPago->TDC_calle="";
				$plantillaPago->TDC_numero="";
				$plantillaPago->TDC_colonia="";
				
				$plantillaPago->TDC_cp="";
				$plantillaPago->TDC_ciudad="";
				$plantillaPago->TDC_etelefono="";
				
				$plantillaPago->TDC_nacimiento="";
				$plantillaPago->TDC_identificacion="";
			}
	
	
			//**************************************************************
			
			$plantillaPago->error=$errorText;
			
			// el titulo que va en el hidden para pagos
			$titulohidden=str_replace("'","",$tituloPrincipal);
			$titulohidden=str_replace("\"","",$titulohidden);
			if($_GET["idiniciativa"]<>0)
				$plantillaPago->nombreret=$idiomas["Donativo a la iniciativa"].$titulohidden;
			else if($_GET["idusuario"]<>0)
				$plantillaPago->nombreret=$idiomas["Donativo a la alcancia"].$titulohidden;
			else $plantillaPago->nombreret=$idiomas["Donativo al corazon"];
			
			$plantillaPago->urlregreso=$urlregreso;
			$plantillaPago->toks=tokGenera("don",3,-1);
			
			// este dato viene de la consulta inicial de la consulta de iniciativa
			$plantillaPago->maxganadores=$ganadoresdisponiblesreal;
			
			$obtendras=1;
			if(isset($_POST["donativo"]))
			{
				$obtendras=floor($_POST["donativo"]/$montominimo);
				if($obtendras>$ganadoresdisponiblesreal)
					$obtendras=$ganadoresdisponiblesreal;
				$plantillaPago->montopagar=htmlentitiesMemoStrong($_POST["donativo"]);
			}
			else
				$plantillaPago->montopagar=$montominimo;
			
			// pintamos cuantas estrellas obtendras
			if($plantillaPago->maxganadores>0) 
				$plantillaPago->obtendras=sprintf($idiomas["Obtendras"],$obtendras);	
			else $plantillaPago->obtendras="";
			$plantillaPago->obtendrasjs=$idiomas["Obtendras"];
			
			$extras="";
			$plantillaPago->renglonesextras=0;
			if(isset($_GET["idiniciativa"]) && $ganadoresdisponiblesreal>0) // aun puede haber ganadores
			{
				// leamos las extras
				$cret=cret_lee(array("sql_extra"=>"iretcret=".(int)$_GET["idiniciativa"],"leerIdiomas"=>"si"));
				if(sizeof($cret)>0) // hay extras vamos a generar los divs
				{
					$plantillaPago->renglonesextras=$obtendras;
					
					$extras='<div class="acre_div">';
					for($j=1; $j<=$plantillaPago->maxganadores; $j++)
					{
						if($j<=$obtendras) $display="block";
						else $display="none";
						 
						 $extras.='<div style="display:'.$display.'" id="cret'.$j.'" name="cret'.$j.'"><div class="tit_acre">'.$idiomas["Ganador"].' '.$j."</div>";
						for($i=0; $i<=sizeof($cret)-1; $i++)
							$extras.=generaRenglonCret($cret[$i],$j);
						$extras.="</div>";
						/*
						$extras.='<div style="clear:both; display:'.$display.'" id="cret'.$j.'" name="cret'.$j.'"><div style="clear:both;  font-weight:bold; float:left">'.$idiomas["Ganador"].' '.$j."</div><br>";
						for($i=0; $i<=sizeof($cret)-1; $i++)
							$extras.=generaRenglonCret($cret[$i],$j).generaRenglonCret($cret[$i],$j).generaRenglonCret($cret[$i],$j);
						$extras.="</div>";*/
					}
					
					if($extras<>"") $extras.="</div><br clear='all'>";
				}
			}
			$plantillaPago->extras=$extras;
			$vistaContenido=generaVista($vistaContenido,$plantillaPago);	
			$plantilla->vistaContenido="<div class='errorPay'>".$error_pago."</div>".$vistaContenido;
		}
	}
	else // formulario de registro o firma, ya que el usuario no está firmado
		$vistaregistro=true;
	
	if($vistaregistro)
	{	
		$vistaContenido=abre_plantilla_API("pagosVistaRegistro",false);
			
		$plantillaRegistro->identificate=$idiomas["Identificate"];
		$plantillaRegistro->ingresar=$idiomas["Ingresar"];
		$plantillaRegistro->proporcionaestainformacion=$idiomas["Proporciona esta informacion"];
		$plantillaRegistro->tuemail=$idiomas["tuemail"];
		$plantillaRegistro->tunombre=$idiomas["tunombre"];
		$plantillaRegistro->tuapodo=$idiomas["tuapodo"];
		$plantillaRegistro->obien=$idiomas["obien"];
		$plantillaRegistro->siguiente=$idiomas["siguiente"];
		$plantillaRegistro->valuetuemail=htmlentitiesMemoStrong($_POST["tuemail"]);
		$plantillaRegistro->valuetunombre=htmlentitiesMemoStrong($_POST["tunombre"]);
		$plantillaRegistro->valuetuapodo=htmlentitiesMemoStrong($_POST["tuapodo"]);
		
		$plantillaRegistro->error=$mensajeError;
		$vistaContenido=generaVista($vistaContenido,$plantillaRegistro);	
		$plantilla->vistaContenido=$vistaContenido;
	}

	$contenido=generaVista($contenido,$plantilla);	
}

$pie=abre_plantilla_API("pie",true);

$cabeza=str_replace("<titulopagina>",$tituloPrincipal." | ".$titleBase,$cabeza);
$cabeza=str_replace("<usuarioFirmado>",$_SESSION["logged"]->id,$cabeza);
$cabeza=str_replace("<botonesfirma>",haceFirma(),$cabeza);
$cabeza=str_replace("<redes>",$redes,$cabeza);

$contenido=$cabezaPrincipal.$cabeza.$contenido.$pie;

if($e404)
	http_response_code(404);
echo $contenido;




?>