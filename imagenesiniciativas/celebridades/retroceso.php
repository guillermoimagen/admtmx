<?
	class retrocesos {
		
	    private $tokenUrl = 'https://api.sandbox.paypal.com/v1/oauth2/token';
		private $paymentUrlPay = 'https://api.sandbox.paypal.com/v1/payments/payment';
	    
	
		
	    //sandbox
	    private $client = 'ATwSnl9DrSFd02h8__LLmlD2bV0M9sq_ewE0PL6ZZ5Ex6bwtTwZrBBQehHc9cU0euAqjPkGXYA8shetp';
	    private $secret = 'EPI-zRHMiTic9Do58OCexTvn86I6vlixWDWUA_3BdyOZ37phsv_F64W1TLlU0sli4DpbDGIJmxPeyxZy';
	    
	    //ARcHdw2OWCJD92Heatg8qzmmDBhpxlWTsWF7RQbFmN8tRYSSMk0yqcUwUwwJI8LV69SVkqy3mDBgYZl-
	    //EDTB6zngZl_tQk-Hyd4t-WGVq1iE3k3yjYLtFvMC2n0x6g4RNMW0o1VtL881aeULI3GSr2ht5lDs1h0S
	    
	    public $token;
	   	public $status;
	    private $tokenHandle;
	    private $paymentHandle;
	
	    public function __construct($url)
	    {
			$this->URL_refund=$url;

			$this->Init();
	    }
		
		public function ExecuteRefund(){
			$this->paymentHandle = curl_init($this->URL_refund);
			
			$header = array(
	            'Content-Type: application/json',
	            'Authorization: Bearer ' . $this->token
	        );
			
			
			$data='{}';
	
		    curl_setopt($this->paymentHandle, CURLOPT_HTTPHEADER, $header);
			curl_setopt($this->paymentHandle, CURLOPT_POSTFIELDS, $data);
			curl_setopt($this->paymentHandle, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($this->paymentHandle, CURLOPT_SSLVERSION , 1);
	
	        $response = curl_exec($this->paymentHandle);	
			$obj = json_decode($response);			
			$array = (array) $obj;
			
			/*
			echo "<pre>";
			print_r($array["state"]);
			echo "</pre>";
			*/

			$this->status=$array["state"];
		

	        curl_close($this->paymentHandle);
	
			$retorno=false;
	        if(strcmp ($array["state"], "completed") == 0){
				$retorno=true;
	        }

			return $retorno;
		}
		

		public function getstate(){
			return $this->status;
		}
		


		public function Init(){
			$this->paymentUrlPay=$this->paymentUrlPay;
	        $this->tokenHandle = curl_init($this->tokenUrl);
	        $this->buildTokenRequest();
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
	        echo $this->token;
	        curl_close($this->tokenHandle);
	    }

	    private function saveData(){

	    }
}




?>

