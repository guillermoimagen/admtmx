<?
$API_folder="API/";
include("include/connection.php");
include("include/funciones.php");
include($API_folder."funciones_API.php");
include($API_folder."funcionesWeb_API.php");
include_once($API_folder."don.php");
if($_SESSION["firmado"])
{
	$esWeb=1;
	$idregistro=(int)$_GET["idregistro"];
	$modo=(int)$_GET["modo"];
	
	if($_SESSION["logged"]->cms==1) $usuario=$modo; // es admin, entonces el usuario es el de la peticion
	else $usuario=$_SESSION["logged"]->id; // no es admin, el usuario es el firmado
	
	$donativo=don_lee_especial(array("grafico"=>"usuario","idusuario"=>$usuario,"statusdon"=>"no","leerDetalle"=>1,"sql_extra"=>" and don.id=".$idregistro));

	if(sizeof($donativo)>0)
	{
		$vista=abre_plantilla_API("donativoDetalle",false);
		if($donativo[0]->iformadon>=3 &&($donativo[0]->statusdon==0 || $donativo[0]->statusdon==1)) // no pagado
		{
			$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select link1,link2,fechaexpira from payu where idon=".$donativo[0]->idreal);
			$donativo[0]->botonpayu="";
			while($row=mysqli_fetch_object($res))
			{
				$donativo[0]->botonpayu='<a href="'.$row->link1.'" target="_blank"><div class="btn_vercompleta" style="float:left !important;");">Descargar formato de pago</div></a> <a href="'.$row->link2.'" target="_blank"><div class="btn_vercompleta" style="float:left !important;");">Ver formato de pago</div></a><br><span style="font-size:9px"> Vigencia al '.$row->fechaexpira.'</span>';

			}
		}
		
		if($donativo[0]->statusdon==2) // pagado
		{
			$res2=@mysqli_query($GLOBALS["enlaceDB"] ,"select idtransaccionfinal,fechafinal from transacciones where idon=".$donativo[0]->idreal." and state='APPROVED' and (idtransaccionfinal<>'' or fechafinal<>'') limit 1");
			$donativo[0]->datostransaccion="";
			if(mysqli_num_rows($res2)>0)
			{
				while($row2=mysqli_fetch_object($res2))
					$donativo[0]->datostransaccion="<br clear='all'>".mensajeIdioma("datosPago").$row2->idtransaccionfinal." ".$row2->fechafinal;
			}
		}
		
		$vistaT=generaVista($vista,$donativo[0]);
		echo $vistaT;
	}
	else
	{
		$vista=abre_plantilla_API("nohay",true);
		echo $vista;
	}				

	
	
	/*
	if(sizeof($arreglo)>0)
	{
		
		
		$vistaBit=extrae_vista_API("bit",$vista);
		$vistaBitT=generaVistaRecursiva($vistaBit[1],$arreglo);
		$vista=str_replace($vistaBit[0],$vistaBitT,$vista);
	}		
	echo $vista;*/
}
?>