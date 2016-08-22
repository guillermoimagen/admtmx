<?


class sensaciones {
	private $DeveloperPayu;
	private $DeveloperPaypal;
	private $DeveloperPayuCreditCard;	
	
	public $PAYU_ServiceUrl;
	public $PAYU_apiKey;
	public $PAYU_apiLogin;
	public $PAYU_accountId;
	public $PAYU_merchanId;
	public $PAYU_testmode;
	
	
	public $PAYU_apiKeyN;
	public $PAYU_apiLoginN;
	public $PAYU_accountIdN;
	public $PAYU_merchanIdN;
	public $PAYU_testmodeN;

	
	public $PAYU_PaymentsCustomUrl;
	public $PAYU_ReportsCustomUrl;
	public $PAYU_SubscriptionsCustomUrl;
	
	public $PAYPAL_tokenUrl;
	public $PAYPAL_paymentUrlPay;	
	public $PAYPAL_client;
	public $PAYPAL_secret;
	
	public $PAYPAL_payaltest;
	
	 public function __construct()
	 {
	 	//solo bastaria con mover los tres atribbutos a false para produccion
		//para lo que es pago en efectivo OXXO, SEVEn OTHER CASH
		$this->DeveloperPayu=false;
		
		//PARA LA CUENTA DE PAYPAL
		$this->DeveloperPaypal=false;
		
		//PARA PAYU EN TARJETA DE CREDITO
		$this->DeveloperPayuCreditCard=false;
		
		//**************************************************************************************
		//PAyu pago en efectivo ***********************************************************************************
			if($this->DeveloperPayu){
				//en pruebas
				$this->PAYU_ServiceUrl="https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
				$this->PAYU_apiKeyN="4Vj8eK4rloUd272L48hsrarnUA";
				$this->PAYU_apiLoginN="pRRXKOl8ikMmt9u";
				$this->PAYU_accountIdN="512324";
				$this->PAYU_merchanIdN="508029";
				$this->PAYU_testmodeN="0";
			}else{
				//en produccion
				$this->PAYU_ServiceUrl="https://api.payulatam.com/payments-api/4.0/service.cgi";
				$this->PAYU_apiKeyN="etOYxKmrGBI6mlSOGyVlS1iQ0y";
				$this->PAYU_apiLoginN="8Hh73US1BAMidCx";
				$this->PAYU_accountIdN="579683";
				$this->PAYU_merchanIdN="576852";
				$this->PAYU_testmodeN="false"; //aqui es false
			}
			
			
			//tarjeta de credito payu **************************************************************************************
			if($this->DeveloperPayuCreditCard){
				
				//en pruebas sandbox
				$this->PAYU_PaymentsCustomUrl="https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
				$this->PAYU_ReportsCustomUrl="https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
				$this->PAYU_SubscriptionsCustomUrl="https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
				
				$this->PAYU_apiKey="4Vj8eK4rloUd272L48hsrarnUA";
				$this->PAYU_apiLogin="pRRXKOl8ikMmt9u";
				$this->PAYU_accountId="512324";
				$this->PAYU_merchanId="508029";
				$this->PAYU_testmode="true";
				
							
			}else{
				
				//en produccion
				$this->PAYU_PaymentsCustomUrl="https://api.payulatam.com/payments-api/4.0/service.cgi";
				$this->PAYU_ReportsCustomUrl="https://api.payulatam.com/payments-api/4.0/service.cgi";
				$this->PAYU_SubscriptionsCustomUrl="https://api.payulatam.com/payments-api/4.0/service.cgi";
			
				$this->PAYU_apiKey="etOYxKmrGBI6mlSOGyVlS1iQ0y";
				$this->PAYU_apiLogin="8Hh73US1BAMidCx";
				$this->PAYU_accountId="579683";
				$this->PAYU_merchanId="576852";
				$this->PAYU_testmode="false";//aqui es false

				
			}
			
			
			//tarjeta de credito payu **************************************************************************************
			if($this->DeveloperPaypal){
				//sandbox
				$this->PAYPAL_tokenUrl = 'https://api.sandbox.paypal.com/v1/oauth2/token';
				$this->PAYPAL_paymentUrlPay = 'https://api.sandbox.paypal.com/v1/payments/payment';	
			
				$this->PAYPAL_client = 'AfZSwhABkmh5e0kQRijcR_NKbnE73SX0hNnxylj2Sb2TMurg5qSI0zNLpOJf';
				$this->PAYPAL_secret = 'EC2FYBBlB8M4nwmb4_CjrtYpSc8TtJfVfbOvGy4Z19UUh9BqhbAz5dJ49C0S';
				
				$this->PAYPAL_payaltest=true;
					
			}else{
			
				//producción
				$this->PAYPAL_tokenUrl = 'https://api.paypal.com/v1/oauth2/token';
				$this->PAYPAL_paymentUrlPay = 'https://api.paypal.com/v1/payments/payment';	
				
				$this->PAYPAL_client = 'AcRp4RD3bK9iqkOI7JF3aI0QOTreJYgFZWIAO-8T3KNpaNm-ZmBc3BBjTC6-';
				$this->PAYPAL_secret = 'EOYfohCZECAYZ_X546fzHsTsaTsMdOoLjR8AnyY1t6TN6rRfwfmAbSOvo316';
				$this->PAYPAL_payaltest=false;
			}
		//**************************************************************************************
		
		
		//echo $this->PAYU_ServiceUrl;
		
		
	 }
	
} 

//solo seria necesario moverle estas variables a true para produccion






?>