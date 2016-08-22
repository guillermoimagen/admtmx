<?
include("../include/connection.php");


include("../imagenesiniciativas/sensaciones.php");

$esWeb=1;
$API_folder = "../API/";
include_once($API_folder."actualizacionFunciones.php");

global $idioma;

 $SensacionesKey=new sensaciones();

$payaltest= $SensacionesKey->PAYPAL_payaltest;

$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value)
{
    $encodedvalue = urlencode(stripslashes($value));
    $req .= "&$key=$encodedvalue";
}




if (!$payaltest)
{
    $url ='https://www.paypal.com/cgi-bin/webscr';
}else{
    $url ='https://www.sandbox.paypal.com/cgi-bin/webscr';
}

		$pasofirma=false;
		$finalStatus="";

        $ch = curl_init($url);   // Esta URL debe variar dependiendo si usamos SandBox o no. Si lo usamos, se queda así.
        //$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');         // Si no usamos SandBox, debemos usar esta otra linea en su lugar.
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if( !($res = curl_exec($ch)) ) {
            
            //en este caso el pago pues no se pudo hacer la comprobacion si la peticion era legitima, metere de caulquier forma los datos a la bd
            //por si existe una aclaracion
            $finalStatus="PCHECK";
            curl_close($ch);
            exit;
        }
        curl_close($ch);


		if (strcmp ($res, "VERIFIED") == 0) {
           //la peticion si es de paypal aqui hago el proceso de checar si se pago corracto y actualizar estatus
           $pasofirma=true;
           //*******************************************************

           	//checamos el status
           	if(strcmp ($_POST["payment_status"], "Completed") == 0){
           		
				$finalStatus="APPROVED";
				
				//sacamos id de don 
	      $referencia_id=str_replace("ID", "", mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["item_number1"]));
	      
          $referencia_id=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$referencia_id);

        //sacamos el idioma
        $sqlidioma="select idioma from don where id=".$referencia_id;
        $resultidioma=mysqli_query($GLOBALS["enlaceDB"] ,$sqlidioma);
        if(mysqli_num_rows($resultidioma)>0){
            $idiomasrow=mysqli_fetch_object($resultidioma);
            $idioma=$idiomasrow->idioma;
        }else{
            $idioma=0; //si pasa algo extraño lo pongo  por defaul 0 osea español
        }

			$sqldon="update don set importedon='".$_POST["mc_gross"]."' where id='".$referencia_id."'";
			mysqli_query($GLOBALS["enlaceDB"] ,$sqldon);

	        include_once($API_folder."idiomas.php");
			registrarPagoDon($referencia_id,2);
				

				

			}else{
				$finalStatus=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["payment_status"]); //el status que venga en la tarnsaccion
				$referencia_idx=str_replace("ID", "", mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["item_number1"]));
				 
				$sqldon="update don set statusdon=4 where id='".$referencia_idx."' limit 1";
				mysqli_query($GLOBALS["enlaceDB"] ,$sqldon);
			}
           //*******************************************************
           
        } 
        else if (strcmp ($res, "INVALID") == 0) {
            // El estado que devuelve es INVALIDO, la información no ha sido enviada por PayPal. Deberías guardarla en un log para comprobarlo después
            $finalStatus="PFRAUDE"; //paypal dijo que esta peticion no viene de el (Posible fraude)
            
        }else{
        	//en este caso el pago pues no se pudo hacer la comprobacion si la peticion era legitima, metere de caulquier forma los datos a la bd
            //por si existe una aclaracion
            $finalStatus="PCHECK"; //talves paypal no regrese nada entonce deberiamso revisar manual 
        } 
  
  //sea lo que sea inserto un nuevo registro en transaccione
  if($pasofirma){
	  	$ider = str_replace("ID", "", mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["item_number1"]));
	  	if(strlen($ider)>0){
			$vari=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$req);
			//insertaremos fila de la transaccion para historial, sin impostar si status
	    $ider=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$ider);
	
	    //$fecha1="20:27:54 Aug 11,2016";
	    //$fecha2=date("Y-m-d H:i:s",strtotime($fecha1));
	    $fecha2=date("Y-m-d H:i:s");
	    //El nuevo valor de la variable: $fecha2="20-10-2008"
	
	        $_POST["txn_id"]=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,strip_tags($_POST["txn_id"]));
	        $_POST["payer_id"]=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,strip_tags($_POST["payer_id"]));
	
	
	
			$sql_existe="select id from transacciones where idon='".$ider."' and state='APPROVED' limit 1";
	
			$result=mysqli_query($GLOBALS["enlaceDB"] ,$sql_existe);
			if(mysqli_num_rows($result)==0){
				$sql="insert into transacciones set idon='".$ider."',state='".$finalStatus."',respuesta='".$vari."',tipo='2',idtransaccionfinal='".$_POST["txn_id"]."',fechafinal='".$fecha2."',payerid='".$_POST["payer_id"]."'";
	
	      mysqli_query($GLOBALS["enlaceDB"] ,$sql);
			}else{
				$resu=mysqli_fetch_object($result);
				$sql="update transacciones set respuestaipn='".$vari."', state='".$finalStatus."',idtransaccionfinal='".$_POST["txn_id"]."',fechafinal='".$fecha2."',payerid='".$_POST["payer_id"]."' where id='".$resu->id."' limit 1";
				mysqli_query($GLOBALS["enlaceDB"] ,$sql);
			}
	
		}
	}

?>

