<?


// include("retrocesos.php");

if(isset($_SESSION["sesionid"]) && $_SESSION["sesionid"]<>0 && $_GET["step"]=="cambioStatus")
{
	//error_reporting(E_ALL);
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select statusdon,iformadon from don where id=".(int)$_GET["id"]." and activo=1");	
	while($row=mysqli_fetch_object($res))
	{
		$mensaje="";
		$modomensaje="";
		if($row->statusdon==0 || $row->statusdon==1 || $row->statusdon==3)
		{
			if(@mysqli_query($GLOBALS["enlaceDB"] ,"update don set statusdon='2',comentariosdon='".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["cambioRazones"])."' where id=".(int)$_GET["id"])) // lo pondremos en pagado sin importar si ya está cancelado, no pasa nada
			{
				$API_folder="../API/";
				include($API_folder."actualizacionFunciones.php");
				registrarPagoDon((int)$_GET["id"],"2");
				$mensaje="Se cambi&oacute; correctamente el status del pago a PAGADO y se envi&oacute; un mail de confirmaci&oacute;n al donador";
				$modomensaje="";	
			}
			else
			{
				$mensaje="Ocurri&oacute; un error cambiando el status";
				$modomensaje="ERROR";	
			}
		}
		else if($row->statusdon==2)
		{
			$sigueCambio=false;
				
			if($row->iformadon==1) // tc
			{
				$sigueCambio=false;
			}
			else if($row->iformadon==3 || $row->iformadon==4 || $row->iformadon==5)
				$sigueCambio=true;
			else  if($row->iformadon==2) // es paypal
			{

	
				$retros=new retrocesos((int)$_GET["id"]);
				if(1==1) // $retros->ExecuteRefund())// aqui pondremos lode Jesus
				{				
					$sigueCambio=true;
				}
				else
				{
					$mensaje="No se ha podido cancelar el donativo. Paypal ha reportado un error";
				}
			}
			
			if(!$sigueCambio) 
			{
				if($mensaje=="") $mensaje="No se ha podido cancelar el donativo.";
				$modomensaje="ERROR";
			}
			else // si podremos cambiarlo
			{
				if(@mysqli_query($GLOBALS["enlaceDB"] ,"update don set statusdon='3',comentariosdon='".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET["cambioRazones"])."' where id=".(int)$_GET["id"])) // lo pondremos en pagado sin importar si ya está cancelado, no pasa nada
				{
					$API_folder="../API/";
					include($API_folder."actualizacionFunciones.php");
					registrarPagoDon((int)$_GET["id"],"3");
					$mensaje="Se cambi&oacute; correctamente el status del pago a CANCELADO y se envi&oacute; un mail de confirmaci&oacute;n al donador";
					$modomensaje="";	
				}
				else
				{
					$mensaje="Ocurri&oacute; un error cambiando el status";
					$modomensaje="ERROR";	
				}
			}
		}
	}
	$step="modify";
}
?>