<?
	class psPayPal {
		private $PAYID;
		private $IDUSER;
	    private $tokenUrl;
		private $paymentUrlPay;
	    
		private $URL_PAYMENT="";
		private $URL_refund="";
		private $montofinal;
		private $monedafinal;
		private $idtransaction;
		private $tokenpayment;
		
		private $elmonto;
		private $iditem;
		private $nombreitem;
		private $identificador;
		
		private $redirectCancelURL;
		private $urlexecute;
		
		private $alldata;
	    private $falloMensaje="";
		
		private $transaction;
		private $fecha;
		
	    //sandbox
	    private $client;
	    private $secret;
	    
	    //ARcHdw2OWCJD92Heatg8qzmmDBhpxlWTsWF7RQbFmN8tRYSSMk0yqcUwUwwJI8LV69SVkqy3mDBgYZl-
	    //EDTB6zngZl_tQk-Hyd4t-WGVq1iE3k3yjYLtFvMC2n0x6g4RNMW0o1VtL881aeULI3GSr2ht5lDs1h0S
	    
	    public $token;
	    private $tokenHandle;
	    private $paymentHandle;
	
	    public function __construct($monto,$idElemento,$nombreLemento,$identificador)
	    {
	    
			$SensacionesKey=new sensaciones();

			$this->client=$SensacionesKey->PAYPAL_client;
			$this->secret=$SensacionesKey->PAYPAL_secret;
			
			$this->tokenUrl = $SensacionesKey->PAYPAL_tokenUrl;
			$this->paymentUrlPay = $SensacionesKey->PAYPAL_paymentUrlPay;
			
			$this->elmonto=$monto;
			$this->iditem=$idElemento;
			$this->nombreitem=$nombreLemento;
			$this->identificador=$identificador;
			
	    }
		
		public function ExecutePay($urlt,$tokene,$payerid){
			$this->paymentHandle = curl_init($urlt);
			
			$header = array(
	            'Content-Type: application/json',
	            'Authorization: Bearer ' . $tokene
	        );
			
			
			$data='{ "payer_id" : "'.$payerid.'" }';
	
		    curl_setopt($this->paymentHandle, CURLOPT_HTTPHEADER, $header);
			curl_setopt($this->paymentHandle, CURLOPT_POSTFIELDS, $data);
			curl_setopt($this->paymentHandle, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($this->paymentHandle, CURLOPT_SSLVERSION , 1);
	
	        $response = curl_exec($this->paymentHandle);	
			$obj = json_decode($response);			
			$array = (array) $obj;
			
			/*
			echo "<pre>";
			print_r($array);
			echo "</pre>";
*/
			$this->idtransaction=$array["transactions"][0]->related_resources[0]->sale->id;
			$this->URL_refund=$array["transactions"][0]->related_resources[0]->sale->links[1]->href;

			$this->montofinal=$array["transactions"][0]->amount->total;
			$this->monedafinal=$array["transactions"][0]->amount->currency;
			

			$this->alldata=$response;

	        curl_close($this->paymentHandle);
	
			return $array["state"];
		}
		
		

		public function getmontofinal(){
			return $this->montofinal;
		}

		public function getmonedafinal(){
			return $this->monedafinal;
		}		


		public function getidtransactionfinal(){
			return $this->idtransaction;
		}

		public function getURL_refund(){
			return $this->URL_refund;
		}


		public function Init(){
			$this->paymentUrlPay=$this->paymentUrlPay;
	        $this->tokenHandle = curl_init($this->tokenUrl);
	        $this->buildTokenRequest();
		}
		
		public function set_redirectCancelURL($url){
			$this->redirectCancelURL=$url;
		}
	
	    public function buildTokenRequest()
	    {
	        $header = array(
	            'Accept: application/json',
	            'Accept-Language: en_US'
	        ); 
	
	        $user = $this->client . ':' . $this->secret;
	
	        $data = 'grant_type=client_credentials';
	
	        curl_setopt($this->tokenHandle, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($this->tokenHandle, CURLOPT_USERPWD, $user);
	        curl_setopt($this->tokenHandle, CURLOPT_POSTFIELDS, $data);
			curl_setopt($this->tokenHandle, CURLOPT_SSLVERSION , 1);
	        curl_setopt($this->tokenHandle, CURLOPT_RETURNTRANSFER, true);
	
	        $this->commitTokenRequest();
	    }
	
	    public function commitTokenRequest()
	    {
	        $response = json_decode(curl_exec($this->tokenHandle));
	        $this->token = $response->access_token;
	        curl_close($this->tokenHandle);
	    }
		
		
		
		

		public function processData(){
			$this->paymentHandle = curl_init($this->paymentUrlPay);
			
			$header = array(
	            'Content-Type: application/json',
	            'Authorization: Bearer ' . $this->token
	        );
			
			
			$data='{
			  "intent":"sale",
			  "redirect_urls":{
			    "return_url":"http://www.alcanciadigitalteleton.mx/pagos.php",
			    "cancel_url":"'.$this->redirectCancelURL.'"
			  },
			  "payer":{
			    "payment_method":"paypal"
			  },
			  "transactions":[
			    {
			      "amount":{
				    "total":"'.$this->elmonto.'",
				    "currency":"MXN",
				    "details":{
				      "subtotal":"'.$this->elmonto.'",
				      "tax":"0",
				      "shipping":"0"
				    }
				    },
				    "description":"'.$this->nombreitem.'",
				    "item_list": {
			        "items": [
			          {
			            "name": "'.$this->nombreitem.'",
			            "sku": "'.$this->identificador.'",
			            "price": "'.$this->elmonto.'",
			            "currency": "MXN",
			            "quantity": "1",
			            "description": "'.$this->nombreitem.'",
			            "tax": "0"
			          }
			          
			        ]
					}
				    
			    }





			  ]
			  
			}';
	
		    curl_setopt($this->paymentHandle, CURLOPT_HTTPHEADER, $header);
			curl_setopt($this->paymentHandle, CURLOPT_POSTFIELDS, $data);
			curl_setopt($this->paymentHandle, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($this->paymentHandle, CURLOPT_SSLVERSION , 1);
	
	        $response = curl_exec($this->paymentHandle);	
			$obj = json_decode($response);			
			$array = (array) $obj;
			
			//print_r($array);
	

	/*
	 * Array ( [name] => MALFORMED_REQUEST [message] => The request JSON is not well formed. [information_link] => https://developer.paypal.com/webapps/developer/docs/api/#MALFORMED_REQUEST [debug_id] => 9c27c6e756925 )
	 * /
	
	/*
	 * Array ( [id] => PAY-2EU64918NJ094302MK6RC3LA [intent] => sale [state] => created [payer] => stdClass Object ( [payment_method] => paypal ) 
	 * [transactions] => Array ( [0] => stdClass Object ( [amount] => stdClass Object ( [total] => 100.00 [currency] => MXN ) [related_resources] => Array ( ) ) ) 
	 * [create_time] => 2016-08-03T17:45:16Z 
	 * [links] => Array ( [0] => stdClass Object ( [href] => https://api.sandbox.paypal.com/v1/payments/payment/PAY-2EU64918NJ094302MK6RC3LA 
	 * [rel] => self [method] => GET ) [1] => stdClass Object ( [href] => https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-2HS36421AL494281P 
	 * [rel] => approval_url [method] => REDIRECT ) [2] => stdClass Object ( [href] => https://api.sandbox.paypal.com/v1/payments/payment/PAY-2EU64918NJ094302MK6RC3LA/execute 
	 * [rel] => execute [method] => POST ) ) ) Array ( [id] => PAY-6FM12516903911141K6RC3LA [intent] => sale [state] => created [payer] => stdClass Object ( [payment_method] => paypal ) 
	 * [transactions] => Array ( [0] => stdClass Object ( [amount] => stdClass Object ( [total] => 100.00 [currency] => MXN ) [related_resources] => Array ( ) ) ) 
	 * [create_time] => 2016-08-03T17:45:16Z [links] => Array ( [0] => stdClass Object ( [href] => https://api.sandbox.paypal.com/v1/payments/payment/PAY-6FM12516903911141K6RC3LA [rel] => self [method] => GET ) 
	 * [1] => stdClass Object ( [href] => https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-5Y497461WH945693F [rel] => approval_url [method] => REDIRECT ) 
	 * [2] => stdClass Object ( [href] => https://api.sandbox.paypal.com/v1/payments/payment/PAY-6FM12516903911141K6RC3LA/execute [rel] => execute [method] => POST ) ) )
	 * 
	 */
	
            curl_close($this->paymentHandle);
			 
			 //checamos que se genero la peticion de pago 
			 if($array["state"]=="created"){
				$this->URL_PAYMENT=$array["links"][1]->href;
				$this->idtransaction=$array["id"];
      			$this->tokenpayment="";
				$this->urlexecute= $array["links"][2]->href; 
		
			 	return true;
			 }else{
			 	
				//talves hay un fallo
				//$falloMensaje
				if(strlen($array["name"])>0){
					$this->falloMensaje="No se puede generar el pago, intenta otra vez";
				}
			 	return false;
			 }
		}

		function GetFail(){
			return $this->falloMensaje;
		}

		function GetURLPAYMENT(){
			return $this->URL_PAYMENT;
		}
		
		
		function Getidtransaction(){
			return $this->idtransaction;
		}
		
		function Gettoken(){
			return $this->token;
		}
				
		function Geturlexecute(){
			return $this->urlexecute;
		}
		
		function Get_ALLRESPONSEEXECUTE(){
			return $this->alldata;
		}
}
?>