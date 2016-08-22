<?
//iformadon    esta en pagos.php
//1= TDC
//2= Pay pal
//3= Oxxo
//4= seven Eleven



class Cobrador { 
    private $Monto;
    private $tipopago; 
    private $idArticulo;
	private $nombreArticulo;
	private $error;
	private $response;
	
	//payu atributos de payu que serian los links del voucher y el link del pdf ****
	private $linkPdf;
	private $linkvoucher;
	private $espiravoucher;
	private $ipnurlPAYU;
	private $emailpayer;
	//******************************************************************************
	
	//para el meodo sin api, almacena un formulario para ir a apypal
	private $formPaypal;
	
	//atributos para paypal
	private $redirectPaypal;
    private $idpayment;
	private $urlcancel;
	private $tokenpaypal;
	private $executeurl;	
	private $identificadorcompra;

	//*******************para banamex
	private $tarjetaCredito;
	private $tarjetaccv;
	private $tarjetaexpira;
	private $terminalbanamex;
	
	//para tarjeta de crdito payu
	private $ResponseTDCPAYU;
	private $OpcionesTDCPAYU;
	public  $moredataRet;	
	
	function Cobrador($monto,$eltipopago,$idarticulo,$nombrearticulo,$identificador){
		$this->Monto=$monto;
		$this->tipopago=$eltipopago;
		$this->idArticulo=$idarticulo;
		$this->nombreArticulo=utf8_encode($nombrearticulo);
		
		$this->identificadorcompra=sprintf("ID%09s",$identificador);
		
	}
	

	function setPayerPAYU($payer){
		$this->emailpayer=$payer;
	}

	function setUrlcancel($url){
		//echo $url;
		$this->urlcancel=$url;
	}
	
	/*
	 * este metodo cobrara segun el atributo $tipopago
	 */
	function Cobra(){ 
		$retorno="";
		
		if($this->tipopago=="2"){
			//$retorno=$this->PayPal();

			if($this->PaypalAPI($this->Monto,$this->idArticulo,$this->nombreArticulo)){
				$retorno="SUCCESS";
				
			}else{
				//aqui tomariamos el errer que paso
			}
		}
		else if($this->tipopago=="3" or $this->tipopago=="4" or $this->tipopago=="5"){	
			$retorno=$this->Payu();
		}
		else if($this->tipopago=="1"){
			
			//$retorno=$this->Banamex();
			$retorno=$this->PayuCreditCar();
		}
		else{
			$retorno="no hay forma de pago";
		}
		
		return $retorno;
	}
	
	function GetResponse(){
		return $this->response;
	}
	
	
	function GetLinkPdfPAYU(){
		return $this->linkPdf;
	}
	
	function GetLinkHtmlPAYU(){
		return $this->linkvoucher;
	}

	function GetExpiraPAYU(){
		return $this->espiravoucher;
	}
	
	function GetFormPaypal(){
		return $this->formPaypal;
	}

	function Set_PayuIPN($url){
		$this->ipnurlPAYU=$url;
	}
	
	function Set_sesioniddevice($id){
		$this->sesioniddevice=$id;
	}
	
	
	function setDataPayuCreditCar($options){
		$this->OpcionesTDCPAYU=$options;

	}
	
	//*********************************************
	//con taljeta de credito
	
	
	function valida_TDCPAYU(){
		$retorno=true;
		if(strlen($this->OpcionesTDCPAYU->nombre)==0){
			$this->error="Dato requerido: Nombre";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->telefono)==0){
			$this->error="Dato requerido: Telefono";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->cst)==0){
			$this->error="Dato requerido: C&oacute;digo de seguridad de tu tarjeta";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->calle)==0){
			$this->error="Dato requerido: Calle";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->ciudad)==0){
			$this->error="Dato requerido: Ciudad";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->numero)==0){
			$this->error="Dato requerido: N&uacte;mero exterior";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->cp)==0){
			$this->error="Dato requerido: Codigo postal";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->tarjeta)<14){
			$this->error="Dato requerido: N&uacute;mero de tarjeta incorrecto";
			$retorno=false;
		}
		
		if(strlen($this->OpcionesTDCPAYU->estado)==1){
			$this->error="Dato requerido: Estado";
			$retorno=false;
		}
	} 
	
	
	function PayuCreditCar() {
	

    $SensacionesKey=new sensaciones();

	$retorno="DECLINED";
	
	$referencia=$this->identificadorcompra."_".rand(10, 90);
			
	PayU::$apiKey = $SensacionesKey->PAYU_apiKey; //apiKey de prueba.
	PayU::$apiLogin = $SensacionesKey->PAYU_apiLogin; //apiLogin de prueba.
	PayU::$merchantId = $SensacionesKey->PAYU_merchanId; //Id de Comercio de prueba.
	PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
	PayU::$isTest = $SensacionesKey->PAYU_testmode; //Dejarlo True cuando sean pruebas.
		
	Environment::setPaymentsCustomUrl($SensacionesKey->PAYU_PaymentsCustomUrl);
	Environment::setReportsCustomUrl($SensacionesKey->PAYU_ReportsCustomUrl); 
	Environment::setSubscriptionsCustomUrl($SensacionesKey->PAYU_SubscriptionsCustomUrl);


	$value = $this->OpcionesTDCPAYU->amount;
	
	$parameters = array(
		PayUParameters::ACCOUNT_ID => $SensacionesKey->PAYU_accountId,
		PayUParameters::REFERENCE_CODE => $referencia,
		PayUParameters::DESCRIPTION => $this->OpcionesTDCPAYU->descr,
		
		// -- Valores --
		PayUParameters::VALUE => $value,
		PayUParameters::CURRENCY => "MXN",
		
		// -- Comprador 

		PayUParameters::BUYER_NAME => $this->OpcionesTDCPAYU->nombre,
		PayUParameters::BUYER_EMAIL => $this->emailpayer,
		PayUParameters::BUYER_CONTACT_PHONE => $this->OpcionesTDCPAYU->telefono,
		PayUParameters::BUYER_DNI => $this->OpcionesTDCPAYU->dni,

		PayUParameters::BUYER_STREET => $this->OpcionesTDCPAYU->calle,
		PayUParameters::BUYER_STREET_2 => $this->OpcionesTDCPAYU->numero,
		PayUParameters::BUYER_CITY => $this->OpcionesTDCPAYU->ciudad,
		PayUParameters::BUYER_STATE => $this->OpcionesTDCPAYU->estado,
		PayUParameters::BUYER_COUNTRY => "MX",
		PayUParameters::BUYER_POSTAL_CODE => $this->OpcionesTDCPAYU->cp,
		PayUParameters::BUYER_PHONE => $this->OpcionesTDCPAYU->telefono,
		
		// -- pagador --
		PayUParameters::PAYER_NAME => $this->OpcionesTDCPAYU->nombre,
		PayUParameters::PAYER_EMAIL => $this->emailpayer,
		PayUParameters::PAYER_CONTACT_PHONE => $this->OpcionesTDCPAYU->telefono,
		PayUParameters::PAYER_DNI => $this->OpcionesTDCPAYU->dni,
		PayUParameters::PAYER_STREET => $this->OpcionesTDCPAYU->calle,
		PayUParameters::PAYER_STREET_2 => $this->OpcionesTDCPAYU->numero,
		PayUParameters::PAYER_CITY => $this->OpcionesTDCPAYU->ciudad,
		PayUParameters::PAYER_STATE => $this->OpcionesTDCPAYU->estado,
		PayUParameters::PAYER_COUNTRY => "MX",
		PayUParameters::PAYER_POSTAL_CODE => $this->OpcionesTDCPAYU->cp,
		PayUParameters::PAYER_PHONE => $this->OpcionesTDCPAYU->telefono,
		PayUParameters::PAYER_BIRTHDATE => $this->OpcionesTDCPAYU->nacimiento,
		

		PayUParameters::CREDIT_CARD_NUMBER => $this->OpcionesTDCPAYU->tarjeta,
		PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $this->OpcionesTDCPAYU->expiracion,

		PayUParameters::CREDIT_CARD_SECURITY_CODE=> $this->OpcionesTDCPAYU->cst,
		//Ingrese aquí el nombre de la tarjeta de crédito
		// "MASTERCARD" || "AMEX" || "ARGENCARD" || "CABAL" || "NARANJA" || "CENCOSUD" || "SHOPPING"
		PayUParameters::PAYMENT_METHOD => $this->OpcionesTDCPAYU->tipotarjeta, 
		
		//Ingrese aquí el número de cuotas.
		PayUParameters::INSTALLMENTS_NUMBER => "1",
		//Ingrese aquí el nombre del pais.
		PayUParameters::COUNTRY => PayUCountries::MX,
		
		//Session id del device.
		PayUParameters::DEVICE_SESSION_ID => $this->OpcionesTDCPAYU->sse,
		//IP del pagadador
		PayUParameters::IP_ADDRESS => $this->get_client_ip_server(),
		//Cookie de la sesión actual.
		PayUParameters::PAYER_COOKIE=>session_id(),
		//Cookie de la sesión actual.        
		PayUParameters::USER_AGENT=>$_SERVER['HTTP_USER_AGENT']
		);
		
		$response = PayUPayments::doAuthorizationAndCapture($parameters);
		
		//print_r($response);
 
		if ($response) {
			
			if($response->code=="SUCCESS"){
				$response->transactionResponse->orderId;

				
				$response->transactionResponse->transactionId;
				$this->idpayment=$response->transactionResponse->transactionId;
								
				$response->transactionResponse->state;
				if ($response->transactionResponse->state=="APPROVED"){
					$retorno="SUCCESS";
					$this->moredataRet="<br><br> Referencia: ".$referencia."<br>";
					$this->moredataRet="Id de transacción: ".$response->transactionResponse->transactionId."<br><br>";
					$this->moredataRet="Fecha: ".date("Y-m-d H:i:s")."<br><br>";
						
					 //referencia, valor, moneda y fecha
					 
				}else if($response->transactionResponse->state=="PENDING"){
					$response->transactionResponse->pendingReason;
					$this->error=$response->transactionResponse->pendingReason;
					
					$this->moredataRet="<br><br>Referencia: ".$referencia."<br>";
					$this->moredataRet="Donativo: $".$value." MXN<br>";
					$this->moredataRet="Id de transacción: ".$response->transactionResponse->transactionId."<br>";
					$this->moredataRet="Fecha: ".date("Y-m-d H:i:s")."<br><br>";
					
					$retorno="PENDING";
				}else{
					
					$retorno=$response->transactionResponse->state;
					$this->error="<br>Transacción Rechazada (".$response->transactionResponse->responseCode.")<br>
					Donativo: $".$value." MXN<br>
					Id de transacción:".$response->transactionResponse->transactionId."<br>Fecha: ".date("Y-m-d H:i:s")."<br><br>";	
					//echo "el error";
				}
				
				
				$response->transactionResponse->paymentNetworkResponseCode;
				$response->transactionResponse->paymentNetworkResponseErrorMessage;
				$response->transactionResponse->trazabilityCode;
				$response->transactionResponse->responseCode;
				$response->transactionResponse->responseMessage;
				 
			}else{
				$retorno="ERROR";
				$this->error=$response->error;
			}
		}else{
			$retorno="ERROR";
				$this->error="Error de transacción";
		}

		$this->error=utf8_decode($this->error);

		$this->ResponseTDCPAYU=$response;
		
		return $retorno;
    } 
	//**********************************************
	
	
	public function getResponseTDCPAYU(){
		return $this->ResponseTDCPAYU;
	}
	
	
	
	function get_client_ip_server() {
	    $ipaddress = '';
	    if ($_SERVER['HTTP_CLIENT_IP'])
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_X_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if($_SERVER['HTTP_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if($_SERVER['REMOTE_ADDR'])
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	 
	    return $ipaddress;
	}
	
    function Payu() {
    		
    	$SensacionesKey=new sensaciones();
    		
    	
 		
		$metodo[3]="OXXO";
		$metodo[4]="SEVEN_ELEVEN";
		$metodo[5]="OTHERS_CASH_MX";
		
		$lugar=$metodo[$this->tipopago];
		
 		$referencia=$this->identificadorcompra."_".rand(10, 90);
		$generadorfirma=md5($SensacionesKey->PAYU_apiKeyN."~".$SensacionesKey->PAYU_merchanIdN."~".$referencia."~".$this->Monto."~MXN");
		
		$expiracion=$this->sumaFechas()."T00:00:00";
		
		$data_string='{
		   "language": "es",
		   "command": "SUBMIT_TRANSACTION",
		   "merchant": {
		      "apiKey": "'.$SensacionesKey->PAYU_apiKeyN.'",
		      "apiLogin": "'.$SensacionesKey->PAYU_apiLoginN.'"
		   },
		   "transaction": {
		      "order": {
		         "accountId": "'.$SensacionesKey->PAYU_accountIdN.'",
		         "referenceCode": "'.$referencia.'",
		         "description": "'.$this->nombreArticulo.'",
		         "language": "es",
		         "signature": "'.$generadorfirma.'",
		         "notifyUrl": "'.$this->ipnurlPAYU.'",
		         "additionalValues": {
		            "TX_VALUE": {
		               "value": '.$this->Monto.',
		               "currency": "MXN"
		            }
		         },
		         "buyer": {
		            "emailAddress": "'.$this->emailpayer.'"
		         }
		      },
		      "type": "AUTHORIZATION_AND_CAPTURE",
		      "paymentMethod": "'.$lugar.'",
		      "expirationDate": "'.$expiracion.'",
		      "paymentCountry": "MX",
		      "ipAddress": "'.$this->get_client_ip_server().'" 
		   },
		   "test":'.$SensacionesKey->PAYU_testmodeN.'
		}'; 
		


		                                                                                                                     
		$ch = curl_init($SensacionesKey->PAYU_ServiceUrl);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json; charset=utf-8','Accept: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		                                                                                                                     
		$result = curl_exec($ch);
		


		//procedemos a ver la respuesta
		$obj_php = json_decode($result);
		
	//	echo "<bR><bR>";
	//	print_r($obj_php); 

		$respuesta=$obj_php->transactionResponse->state;



		
		if($respuesta=="PENDING"){
			
			$respuesta="SUCCESS";

			$milliseconds =  $obj_php->transactionResponse->extraParameters->EXPIRATION_DATE;
			$timestamp = $milliseconds/1000;
			$miexpiracion=date("Y-m-d H:i:s", $timestamp);

			$this->espiravoucher=$miexpiracion;
			$this->linkPdf=$obj_php->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_PDF;
			$this->linkvoucher=$obj_php->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML;	
		}else{
			
			if($this->Monto<55){
				$this->error="Para donativos en OXXO y 7-ELEVEN la cantidad minima es de 55 pesos";
			}
			else if($this->Monto>90000 && $lugar="OXXO"){
				$this->error="Para donativos en OXXO la cantidad maxima es de 90000 pesos";	
			}
			
			else if($this->Monto>90000 && $lugar="SEVEN_ELEVEN"){
				$this->error="Para donativos en 7-ELEVEN la cantidad maxima es de 90000 pesos";	
			}else{
				$this->error="Por el momento no se puede generar el formato de pago, intentalo mas tarde";	
			}
			
		}	
		
		 
		return $respuesta;
    } 
	
	
	function sumaFechas(){
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( '+3 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}
	
	function GetredirectPaypal(){
		return $this->redirectPaypal;
	}
	
	function Getidpayment(){
		return $this->idpayment;
	}
	
	function Gettokenpaypal(){
		return $this->tokenpaypal;
	}
	
	
	function Getexecuteurl(){
		return $this->executeurl;
	}
	
	function GetError(){
		return $this->error;
	}
	
	//accedemos a paypal usando su API
	function PaypalAPI($monto,$idElemento,$nombreLemento){
		///************************************************
		$pp=new psPayPal($monto,$idElemento,$nombreLemento,$this->identificadorcompra);
				
		$pp->set_redirectCancelURL($this->urlcancel);
		$pp->Init();
		$responser=$pp->processData();
		
		if($responser){
			$this->idpayment=$pp->Getidtransaction();

			$this->tokenpaypal=$pp->Gettoken();
			$this->executeurl=$pp->Geturlexecute();	
			
			$this->redirectPaypal="<a href='".$pp->GetURLPAYMENT()."'>click para ir a paypal</a>
	

			
			<div id='overlay' class='PPoverlay'>
			  <img src='recursos/elementos/ajax-loader.gif'><br>
			    Conectando con PayPal . . .
			</div>

			<script>
			$( document ).ready(function() {
				//location.href='".$pp->GetURLPAYMENT()."';

				window.setTimeout(function(){
        			window.location.href = '".$pp->GetURLPAYMENT()."';
        			//$('#overlay').hide();
    			}, 3000);
	
			});
			</script>
			";
		}else{
			$this->redirectPaypal="No se puede geneara el formato de pago, intente de nuevo";
		}

		
		return $responser;
	}
	
	
	
	
	
	//#######################################################################
	function SetBanamex($Ntarjeta,$ccv,$fechaExpira,$terminal){
		$this->tarjetaCredito=$Ntarjeta;
		$this->tarjetaccv=$ccv;
		$this->tarjetaexpira=$fechaExpira;
		$this->terminalbanamex=$terminal;
	}

	function Banamex(){
		//en espera de buenas noticias
		//iniciamos la clase de banamex
		$Mibanamex = &new conector($this->Monto,$this->tarjetaccv,$this->terminalbanamex,$this->tarjetaCredito,$this->tarjetaexpira);

		$respuestaB=$Mibanamex->ExecuteFakePay(true); //ejecotamos una transaccion que siempre me regresara aprovada


 		$this->response=$Mibanamex->Getallresponse();

		if($respuestaB){
			return "SUCCESS";			
		}else{
			return "FALSE";
		}
 
	}
	
}















?>