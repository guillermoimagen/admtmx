<?
// ganador=1&statusdon=1&minimo=&maximo=
$sql_extra="";
$titulo="";

$sql_extra=ifAndInt($sql_extra,"ipais","ipaisusuario","=");
$titulo.=leeElementoInt("pais","ipais","nombrepais"," Pa&iacute;s: ");

$sql_extra=ifAndInt($sql_extra,"iestado","iestadousuario","=");
$titulo.=leeElementoInt("estados","iestado","nombreestado"," Estado: ");

if($_GET["nacimientousuario"]<>"")
{
	if($sql_extra<>"") $sql_extra.=" and ";
	$sql_extra.=" nacimientousuario like '%".htmlentitiesMemo2Strong($_GET["nacimientousuario"])."%'";
	$titulo.=" Fecha de nacimiento:". $_GET["nacimientousuario"];
}
$sql_extra=ifAndInt($sql_extra,"idonusuarioMin","idonusuario",">=");
$titulo.=leeElementoValor("idonusuarioMin"," Importe Donado>=");

$sql_extra=ifAndInt($sql_extra,"idonusuarioMax","idonusuario","<=");
$titulo.=leeElementoValor("idonusuarioMax"," Importe Donado<=");

$sql_extra=ifAndInt($sql_extra,"irdonusuarioMin","irdonusuario",">=");
$titulo.=leeElementoValor("irdonusuarioMin"," Importe Recibido>=");

$sql_extra=ifAndInt($sql_extra,"irdonusuarioMax","irdonusuario","<=");
$titulo.=leeElementoValor("irdonusuarioMax"," Importe Recibido<=");

if($_GET["buscadorI"]<>"")
{
	if(strpos($_GET["buscadorI"],"I")!==FALSE) // iniciativa
	{
		$partes=explode("-",$_GET["buscadorI"]);
		if(sizeof($partes)==2)
		{
			$_GET["iretgus"]=$partes[1];
			$sql_extra=ifAndInt($sql_extra,"iretgus","iretgus","=");
			$titulo.=leeElementoInt("ret","iretgus","nombreret"," Gusta: ");
			
			$lefts=" left join gus on usuarios.id=gus.iusuariogus";
		}
	}
	else if(strpos($_GET["buscadorI"],"U")!==FALSE) // usuario
	{
		$partes=explode("-",$_GET["buscadorI"]);
		if(sizeof($partes)==2)
		{
			$_GET["id"]=$partes[1];
			
			
			$titulo.=leeElementoInt("usuarios","id","nombreusuario","Gusta: ");
			$_GET["iusuarioret"]=$partes[1];
			$sql_extra=ifAndInt($sql_extra,"iusuarioret","iusuarioret","=");
			$lefts=" left join gus on usuarios.id=gus.iusuariogus left join ret on gus.iretgus=ret.id";
			
		}	
	}
}

$lefts.=" left join pais on usuarios.ipaisusuario=pais.id left join estados on usuarios.iestadousuario=estados.id ";
if($sql_extra=="")
	$sql_extra=$lefts.$sql_extra;
else
	$sql_extra=$lefts." where ".$sql_extra;

$limite="";
$cuenta=0;
$total=0;
if($exportar<>1)
{
	$sql_cuenta="select count(usuarios.id) as cuenta,sum(idonusuario) as donado, sum(irdonusuario) as recibido from usuarios ".$sql_extra;
	$resCuenta=@mysqli_query($GLOBALS["enlaceDB"] ,$sql_cuenta);
	while($rowCuenta=mysqli_fetch_object($resCuenta))
	{
		$donado=$rowCuenta->donado;
		$recibido=$rowCuenta->recibido;
		$cuenta=$rowCuenta->cuenta;
	}

	$limite=" limit ".((int)$_GET["pagina"]-1)*$tamanopagina.",".$tamanopagina;
	$urlComplemento="reportes.php?step=2&modoR=".htmlentitiesMemo2Strong($_GET["modoR"]).
			"&ipais=".(int)$_GET["ipais"].
			"&iestado=".(int)$_GET["iestado"].
			"&buscadorI=".htmlentitiesMemo2Strong($_GET["buscadorI"]).
			"&idonusuarioMin=".(int)$_GET["idonusuarioMin"].
			"&idonusuarioMax=".(int)$_GET["idonusuarioMax"].
			"&irdonusuarioMin=".(int)$_GET["irdonusuarioMin"].
			"&irdonusuarioMax=".(int)$_GET["irdonusuarioMax"].
			"&nacimientousuario=".htmlentitiesMemo2Strong($_GET["nacimientousuario"]).
			"&pagina=";
	$columnasTabla=12;
	
	$urlExcel=$urlComplemento."&exportar=1";
	$paginador=pintaPaginador($cuenta,(int)$_GET["pagina"],$tamanopagina,$urlComplemento,$total,$columnasTabla,$urlExcel);
	$totales='Total: '.number_format($cuenta, 0, '', ',');
	$totales.=' Donado: $'.number_format($donado, 2, '.', ',');
	$totales.=' Recibido: $'.number_format($recibido, 2, '.', ',');
}

$sql="select usuarios.id as idreal,".$campos."idonusuario,irdonusuario,nombreusuario,nickusuario,urlusuario,emailusuario,tel1usuario,nombrepais,nombreestado,nacimientousuario from usuarios ".$sql_extra." order by nombreusuario,usuarios.id asc ".$limite;
$cad="";
$res=@mysqli_query($GLOBALS["enlaceDB"] ,$sql);
if($exportar<>1)
{
	

	$cad.=pintaTitulo($titulo,$columnasTabla);

	$cad.=pintaHeader($totales,$columnasTabla);
	
	$cad.=abreRenglonTitulo();
	$cad.=pintaColumnaString("id");
	$cad.=pintaColumnaString("Nombre");
	$cad.=pintaColumnaString("Nick");
	$cad.=pintaColumnaString("Email");
	$cad.=pintaColumnaString("Telefono");
	$cad.=pintaColumnaString("Donado");
	$cad.=pintaColumnaString("Recibido");
	$cad.=pintaColumnaString("Nacimiento");
	$cad.=pintaColumnaString("Pais");
	$cad.=pintaColumnaString("Estado");
	$cad.=pintaVacioColumnas(3);
	$cad.=cierraRenglon();
	
	while($row=mysqli_fetch_object($res)) // aqui hacemos la cadena no importa cual sea y luego imprimimos
	{			
		$cad.=abreRenglon();
		$cad.=pintaColumnaString($row->idreal);
		$cad.=pintaColumnaString(htmlentitiesMemo2Strong($row->nombreusuario));
		$cad.=pintaColumnaString(htmlentitiesMemo2Strong($row->nickusuario));
		$cad.=pintaColumnaString("<a href='mailto:".$row->emailusuario."'>".$row->emailusuario."</a>");
		$cad.=pintaColumnaString($row->tel1usuario);
		$cad.=pintaColumnaDinero($row->idonusuario);
		$cad.=pintaColumnaDinero($row->irdonusuario);
		$cad.=pintaColumnaString($row->nacimientousuario);
		$cad.=pintaColumnaString($row->nombrepais);
		$cad.=pintaColumnaString($row->nombreestado);	
				
		$cad.=haceBoton("CMS","usuarios.php?esframe=2&step=modify&id=".$row->idreal);
		$cad.=haceBoton("Front","../usuarioDetalle.php?idregistro=".$row->idreal);
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
	echo(pintaColumnaStringX("Nombre"));
	echo(pintaColumnaStringX("Nick"));
	echo(pintaColumnaStringX("Email"));
	echo(pintaColumnaStringX("Telefono"));
	echo(pintaColumnaStringX("Donado"));
	echo(pintaColumnaStringX("Recibido"));
	echo(pintaColumnaStringX("Nacimiento"));
	echo(pintaColumnaStringX("Pais"));
	echo(pintaColumnaStringX("Estado"));
	echo(pintaSaltoX());
	
	while($row=mysqli_fetch_object($res)) // aqui hacemos la cadena no importa cual sea y luego imprimimos
	{
		echo(pintaColumnaStringX($row->idreal));
		echo(pintaColumnaStringX($row->nombreusuario));
		echo(pintaColumnaStringX($row->nickusuario));
		echo(pintaColumnaStringX($row->emailusuario));
		echo(pintaColumnaStringX($row->tel1usuario));
		echo(pintaColumnaDineroX($row->idonusuario));
		echo(pintaColumnaDineroX($row->irdonusuario));
		
		echo(pintaColumnaStringX($row->nacimientousuario));
		echo(pintaColumnaStringX($row->nombrepais));
		echo(pintaColumnaStringX($row->nombreestado));
	
		echo(pintaSaltoX());
	}
	  exit;
}
?>