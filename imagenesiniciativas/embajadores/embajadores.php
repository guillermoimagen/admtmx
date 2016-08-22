<?

include("../../include/connection.php");
include("../sensaciones.php");



$esWeb=1;
$API_folder = "../../API/";
include_once($API_folder."actualizacionFunciones.php");


require_once("../../API/lib/common.inc.php");
$args = new stdClass();
$args->template = "../../APIPlantillas/mailing/payu.php";
$args->data = new stdClass();




global $idioma;


foreach ($_POST as $clave=>$valor)
{
	$vari.=$clave."->".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$valor)."=";
}
		
$SensacionesKey=new sensaciones();


$pasosign=false;



$referencia_id=explode("_", $_POST["reference_sale"]);
//checamso que la cadena no este vacia
$referencia_id[0]=str_replace("ID", "", $referencia_id[0]);


//generamos el md5 para comprobar si es de payu
$digito=substr($_POST["value"],strlen($_POST["value"])-1,1);

$new_monto=$_POST["value"];
if($digito=="0"){
	$new_monto=substr($_POST["value"],0,strlen($_POST["value"])-1);
}




$generadorfirma=md5($SensacionesKey->PAYU_apiKeyN."~".$SensacionesKey->PAYU_merchanIdN."~".$_POST["reference_sale"]."~".$new_monto."~MXN~".$_POST["state_pol"]);


//checamod si fue eprobada

	
	if(strcmp ($generadorfirma, $_POST["sign"]) == 0){
		
		$pasosign=true;
		if($_POST["state_pol"]=="4"){
			if(strlen($referencia_id[0])>0){
	
				$idioma=0;
				include_once($API_folder."idiomas.php");
					
				
				//pues debemos de actualizar la base de datos
				//echo "hola ".$referencia_id[0]."---- ".$digito."--- ".$new_monto;
				//agregamos un un row a la tabla de transacciones con todos los datos que regreso
				$_POST["value"]=strip_tags(mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["value"]));
				
				$sqldon="update don set importedon='".$_POST["value"]."' where id='".$referencia_id[0]."'";
				mysqli_query($GLOBALS["enlaceDB"] ,$sqldon);
				
				registrarPagoDon($referencia_id[0],2);
			}
		}
	
	}

if($pasosign){
	if($_POST["state_pol"]=="6" or $_POST["state_pol"]=="5" or $_POST["state_pol"]=="104"){
		if(strlen($referencia_id[0])>0){
				$sqldon="update don set statusdon=4 where id='".$referencia_id[0]."' limit 1";
				mysqli_query($GLOBALS["enlaceDB"] ,$sqldon);
		}
	}
}


	if(strlen($referencia_id[0])>0 and $pasosign){
		
		$ider = $referencia_id[0];
		$vari=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$vari);
		//insertaremos fila de la transaccion para historial, sin impostar si status
		$_POST["response_message_pol"]=mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["response_message_pol"]);
		
		$_POST["transaction_id"]=strip_tags(mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["transaction_id"]));
		$_POST["transaction_date"]=strip_tags(mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["transaction_date"]));
		$_POST["value"]=strip_tags(mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["value"]));
		
		
		$sql_existe="select id from transacciones where idon='".$ider."' and state='APPROVED' limit 1";
		$result=mysqli_query($GLOBALS["enlaceDB"] ,$sql_existe);
		
		if(mysqli_num_rows($result)==0){
			$sql="insert into transacciones set idon='".$ider."',total='".$_POST["value"]."',state='".$_POST["response_message_pol"]."',respuesta='".$vari."',tipo='1',idtransaccionfinal='".$_POST["transaction_id"]."',fechafinal='".$_POST["transaction_date"]."'";
			mysqli_query($GLOBALS["enlaceDB"] ,$sql);
		}
		else
		{
			$resu=mysqli_fetch_object($result);
			$sql="update transacciones set total='".$_POST["value"]."',state='".$_POST["response_message_pol"]."',respuesta='".$vari."',tipo='1',idtransaccionfinal='".$_POST["transaction_id"]."',fechafinal='".$_POST["transaction_date"]."'  where id='".$resu->id."' limit 1";
			mysqli_query($GLOBALS["enlaceDB"] ,$sql);
		}
		
		
	}
	
$args->data->texto=$vari."--- ".$generadorfirma."_____".$_POST["sign"]."____".$referencia_id[0];
Mailer::sendEmail("jesusrangel@imagencentral.com", "Callback", $args);


?>




 