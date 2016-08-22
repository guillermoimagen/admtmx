<?
// ganador=1&statusdon=1&minimo=&maximo=
$sql_extra="";
$titulo="";
$statuses=array("Pendiente","Pendiente","Pagado","Cancelado","Rechazado");

$sql_extra=ifAndInt($sql_extra,"ipais","ipaisusuario","=");
$titulo.=leeElementoInt("pais","ipais","nombrepais"," Pa&iacute;s: ");

$sql_extra=ifAndInt($sql_extra,"iestado","iestadousuario","=");
$titulo.=leeElementoInt("estados","iestado","nombreestado"," Estado: ");

$sql_extra=ifAndInt($sql_extra,"icat","icatret","=");
$titulo.=leeElementoInt("cat","icat","nombrecat"," Categor&iacute;a: ");

$sql_extra=ifAndInt($sql_extra,"iformadon","iformadon","=");
$titulo.=leeElementoInt("formas","iformadon","nombreforma"," Forma de pago: ");

$sql_extra=ifAndFecha($sql_extra,"inicio","fechadon",">=");
$titulo.=leeElementoValor("inicio"," Fecha>=");

$sql_extra=ifAndFecha($sql_extra,"fin","fechadon","<=");
$titulo.=leeElementoValor("fin"," Fecha<=");

$sql_extra=ifAndInt($sql_extra,"minimo","importedon",">=");
$titulo.=leeElementoValor("minimo"," Importe<=");

$sql_extra=ifAndInt($sql_extra,"maximo","importedon","<=");
$titulo.=leeElementoValor("maximo"," Importe<=");


if(isset($_GET["statusdon"]) && $_GET["statusdon"]<>-1)
{
	$titulo.="<strong> Status: </strong>".$statuses[(int)$_GET["statusdon"]]." ";

	if($sql_extra<>"") $sql_extra.=" and ";
	if($_GET["statusdon"]==0)
		$sql_extra.="(statusdon=0 or statusdon=1)";	
	else $sql_extra.="statusdon=".(int)$_GET["statusdon"];	
}
$sql_extra=ifAndInt($sql_extra,"ganador","ganadordon",">=");


$lefts=" left join formas on don.iformadon=formas.id ";
$campos="";

if((int)$_GET["icat"]<>0) // hay categoria
{
	$lefts.=" left join ret on don.iretdon=ret.id left join cat on ret.icatret=cat.id  ";
	$campos="nombrecat,";
}
if((int)$_GET["ipais"]<>0 || (int)$_GET["iestado"]<>0) // hay categoria
{
	$lefts.=" left join usuarios on don.iusuariodonodon=usuarios.id ";
}

if($_GET["buscadorI"]<>"")
{
	if(strpos($_GET["buscadorI"],"I")!==FALSE) // iniciativa
	{
		$partes=explode("-",$_GET["buscadorI"]);
		if(sizeof($partes)==2)
		{
			$_GET["iretdon"]=$partes[1];
			$sql_extra=ifAndInt($sql_extra,"iretdon","iretdon","=");
			$titulo.=leeElementoInt("ret","iretdon","nombreret"," Iniciativa: ");
			
			$cret=array();
			// vamos a buscar los extras
			if((int)$_GET["ganador"]==1 && (int)$_GET["mostrarextras"]==1)
			{
				$resCret=@mysqli_query($GLOBALS["enlaceDB"] ,"select * from cret where iretcret=".$_GET["iretdon"]." order by id");
				while($rowCret=mysqli_fetch_object($resCret))
					$cret[]=$rowCret;
				
			}
		}
		else
		{
			if($sql_extra<>"") $sql_extra.=" and ";
			$sql_extra.="iretdon<>0";	
			$titulo.=" <strong>Todas las iniciativas</strong>";
		}
		if((int)$_GET["icat"]==0) // no hay categoria
			$lefts.=" left join ret on don.iretdon=ret.id ";
		$campos.="nombreret,";
	}
	else if(strpos($_GET["buscadorI"],"U")!==FALSE) // usuario
	{
		$partes=explode("-",$_GET["buscadorI"]);
		
		$campousuario="iusuariodon";
		$tit="Receptor";
		if((int)$_GET["esdonador"]==1) 
		{
			$campousuario="iusuariodonodon";
			$tit="Donador";
		}
		
		if(sizeof($partes)==2)
		{
			$_GET[$campousuario]=$partes[1];
			$sql_extra=ifAndInt($sql_extra,$campousuario,$campousuario,"=");
			$titulo.=leeElementoInt("usuarios",$campousuario,"nombreusuario",$tit.": ");
			
			if((int)$_GET["incluiriniciativas"]!=1 && (int)$_GET["esdonador"]!=1) 
				$sql_extra.=" and iretdon=0";
			
		}	
		else
		{
			if($sql_extra<>"") $sql_extra.=" and ";
			$sql_extra.=$campousuario."<>0 and iretdon=0";	
			$titulo.=" <strong>Todos los usuarios</strong>";
		}
	}
	else if(strpos($_GET["buscadorI"],"D")!==FALSE) // Directo
	{
		if($sql_extra<>"") $sql_extra.=" and ";
		$sql_extra.="iretdon=0 and iusuariodon=0";
		$titulo.=" <strong>Donativos directos</strong>";
	}
}
$sql_extra=$lefts." where ".$sql_extra;

$limite="";
$cuenta=0;
$total=0;
if($exportar<>1)
{
	$sql_cuenta="select count(don.id) as cuenta, sum(importedon) as total from don ".$sql_extra;
	$resCuenta=@mysqli_query($GLOBALS["enlaceDB"] ,$sql_cuenta);
	while($rowCuenta=mysqli_fetch_object($resCuenta))
	{
		$total=$rowCuenta->total;
		$cuenta=$rowCuenta->cuenta;
	}
	
	$limite=" limit ".((int)$_GET["pagina"]-1)*$tamanopagina.",".$tamanopagina;
	$urlComplemento="reportes.php?step=2&modoR=".htmlentitiesMemo2Strong($_GET["modoR"]).
			"&ipais=".(int)$_GET["ipais"].
			"&iestado=".(int)$_GET["iestado"].
			"&icat=".(int)$_GET["icat"].
			"&icat=".(int)$_GET["icat"].
			"&buscadorI=".htmlentitiesMemo2Strong($_GET["buscadorI"]).
			"&ganador=".(int)$_GET["ganador"].
			"&mostrarextras=".(int)$_GET["mostrarextras"].
			"&statusdon=".htmlentitiesMemo2Strong($_GET["statusdon"]).
			"&minimo=".(int)$_GET["minimo"].
			"&maximo=".(int)$_GET["maximo"].
			"&esdonador=".(int)$_GET["esdonador"].
			"&iformadon=".(int)$_GET["iformadon"].
			"&inicio=".htmlentitiesMemo2Strong($_GET["inicio"]).
			"&fin=".htmlentitiesMemo2Strong($_GET["fin"]).
			"&pagina=";
	if((int)$_GET["icat"]<>0)
		$columnasTabla=15+sizeof($cret)*4;
	else $columnasTabla=14+sizeof($cret)*4;
	
	$urlExcel=$urlComplemento."&exportar=1";
	$paginador=pintaPaginador($cuenta,(int)$_GET["pagina"],$tamanopagina,$urlComplemento,$total,$columnasTabla,$urlExcel);
	$totales='Total: '.number_format($cuenta, 0, '', ',');
	if($total>0)
		$totales.=' Importe: $'.number_format($total, 2, '.', ',');
}

$sql="select don.id as idreal,".$campos."importedon,fechadon,statusdon,nombreforma,ganadordon,iusuariodon,iretdon,iusuariodonodon from don ".$sql_extra." order by fechadon,don.id asc ".$limite;
//echo $sql;
$cad="";
$res=@mysqli_query($GLOBALS["enlaceDB"] ,$sql);
if($exportar<>1)
{
	

	$cad.=pintaTitulo($titulo,$columnasTabla);

	$cad.=pintaHeader($totales,$columnasTabla);
	
	$cad.=abreRenglonTitulo();
	$cad.=pintaColumnaString("id");
	$cad.=pintaColumnaString("Donador");
	$cad.=pintaColumnaString("Email");
	$cad.=pintaColumnaString("Telefono");
	$cad.=pintaColumnaString("Receptor");
	$cad.=pintaColumnaString("Iniciativa");
	if((int)$_GET["icat"]<>0)
		$cad.=pintaColumnaString("Categoria");
	$cad.=pintaColumnaString("Importe");
	$cad.=pintaColumnaString("Status");
	$cad.=pintaColumnaString("Ganador");
	$cad.=pintaColumnaString("Forma de pago");
	$cad.=pintaColumnaString("Fecha");
	$cad.=pintaColumnaString("Pais");
	$cad.=pintaColumnaString("Estado");
	
	if(sizeof($cret)>0)
		for($i=1; $i<=4; $i++)
			for($j=0; $j<=sizeof($cret)-1; $j++)
				$cad.=pintaColumnaString($cret[$j]->labelcret);
	
	$cad.=pintaVacioColumnas(3);
	$cad.=cierraRenglon();
	
	while($row=mysqli_fetch_object($res)) // aqui hacemos la cadena no importa cual sea y luego imprimimos
	{
		$receptor=lee_usuario($row->iusuariodon);
		$donador=lee_usuarioPais($row->iusuariodonodon);
		if(!isset($row->nombreret))
			$row->nombreret=lee_reto($row->iretdon);
			
		$cad.=abreRenglon();
		$cad.=pintaColumnaString($row->idreal);
		$cad.=pintaColumnaStringLink(htmlentitiesMemo2Strong($donador->nombreusuario),"usuarios.php?esframe=2&step=modify&id=".$row->iusuariodonodon);
		$cad.=pintaColumnaString($donador->emailLink);
		$cad.=pintaColumnaString($donador->tel1usuario);
		
		$cad.=pintaColumnaStringLink(htmlentitiesMemo2Strong($receptor->nombreusuario),"usuarios.php?esframe=2&step=modify&id=".$row->iusuariodon);
		$cad.=pintaColumnaStringLink(htmlentitiesMemo2Strong($row->nombreret),"ret.php?esframe=2&step=modify&id=".$row->iretdon);
		if((int)$_GET["icat"]<>0)
			$cad.=pintaColumnaString($row->nombrecat);
		$cad.=pintaColumnaDinero($row->importedon);
		$cad.=pintaColumnaString($statuses[$row->statusdon]);
		$cad.=pintaColumnaString($row->ganadordon);
		$cad.=pintaColumnaString($row->nombreforma);
		$cad.=pintaColumnaString($row->fechadon);
		$cad.=pintaColumnaString($donador->pais);
		$cad.=pintaColumnaString($donador->estado);
		
		
		if(sizeof($cret)>0)
		{
			$vret = array("","","","");
			for($j=0; $j<=sizeof($cret)-1; $j++)
			{
				$valorvret="";
				$resVret=@mysqli_query($GLOBALS["enlaceDB"],"select valorvret from vret where statusvret=1 and idonvret=".$row->idreal." and icretvret=".$cret[$j]->id);
				$cuentaVret=0;
				while($rowVret=mysqli_fetch_object($resVret))
				{
					$valorvret=$rowVret->valorvret;
					$vret[$cuentaVret].=pintaColumnaString($valorvret);
					$cuentaVret++;
				}
				for($i=$cuentaVret; $i<=3; $i++)
					$vret[$cuentaVret].=pintaColumnaString("");
				
			}
			$cad.=$vret[0].$vret[1].$vret[2].$vret[3];	
		}
		
		
				
		$cad.=haceBoton("CMS","don.php?esframe=2&step=modify&id=".$row->idreal);
		$cad.=cierraRenglon();
	}
	$cad=abreTabla().$paginador.$cad.$paginador;
	$cad.=cierraTabla();
}
else
{
	$filename = "reporte_" . date('YmdHi') . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	
	echo(pintaColumnaStringX("id"));
	echo(pintaColumnaStringX("Donador"));
	echo(pintaColumnaStringX("Email"));
	echo(pintaColumnaStringX("Telefono"));
	echo(pintaColumnaStringX("Receptor"));
	echo(pintaColumnaStringX("Iniciativa"));
	if((int)$_GET["icat"]<>0) 
		echo(pintaColumnaStringX("Categoria"));
	echo(pintaColumnaStringX("Importe"));
	echo(pintaColumnaStringX("Status"));
	echo(pintaColumnaStringX("Ganador"));
	echo(pintaColumnaStringX("Forma de pago"));
	echo(pintaColumnaStringX("Fecha"));
	echo(pintaColumnaStringX("Pais"));
	echo(pintaColumnaStringX("Estado"));
	if(sizeof($cret)>0)
		for($i=1; $i<=4; $i++)
			for($j=0; $j<=sizeof($cret)-1; $j++)
				echo(pintaColumnaStringX($cret[$j]->labelcret));
	echo(pintaSaltoX());
	
	while($row=mysqli_fetch_object($res)) // aqui hacemos la cadena no importa cual sea y luego imprimimos
	{
		$receptor=lee_usuario($row->iusuariodon);
		$donador=lee_usuarioPais($row->iusuariodonodon);
		if(!isset($row->nombreret))
			$row->nombreret=lee_reto($row->iretdon);
		
		echo(pintaColumnaStringX($row->idreal));
		echo(pintaColumnaStringX($donador->nombreusuario));
		echo(pintaColumnaStringX($donador->emailusuario));
		echo(pintaColumnaStringX($donador->tel1usuario));
		echo(pintaColumnaStringX($receptor->nombreusuario));
		echo(pintaColumnaStringX($row->nombreret));
		if((int)$_GET["icat"]<>0)
			echo(pintaColumnaStringX($row->nombrecat));
		echo(pintaColumnaDineroX($row->importedon));
		echo(pintaColumnaStringX($statuses[$row->statusdon]));
		echo(pintaColumnaStringX($row->ganadordon));
		echo(pintaColumnaStringX($row->nombreforma));
		echo(pintaColumnaStringX($row->fechadon));
		echo(pintaColumnaStringX($donador->pais));
		echo(pintaColumnaStringX($donador->estado));
		
		if(sizeof($cret)>0)
		{
			$vret = array("","","","");
			for($j=0; $j<=sizeof($cret)-1; $j++)
			{
				$valorvret="";
				$resVret=@mysqli_query($GLOBALS["enlaceDB"],"select valorvret from vret where statusvret=1 and idonvret=".$row->idreal." and icretvret=".$cret[$j]->id);
				$cuentaVret=0;
				while($rowVret=mysqli_fetch_object($resVret))
				{
					$valorvret=$rowVret->valorvret;
					$vret[$cuentaVret].=pintaColumnaStringX($valorvret);
					$cuentaVret++;
				}
				for($i=$cuentaVret; $i<=3; $i++)
					$vret[$cuentaVret].=pintaColumnaStringX("");
				
			}
			echo($vret[0].$vret[1].$vret[2].$vret[3]);	
		}
		
		echo(pintaSaltoX());
	}
	  exit;
}
?>