<?
$sql_extra="";
$sql_extra=ifAndInt($sql_extra,"ipais","ipaisret","=");
$titulo.=leeElementoInt("pais","ipais","nombrepais"," Pa&iacute;s: ");

$sql_extra=ifAndInt($sql_extra,"iestado","iestadoret","=");
$titulo.=leeElementoInt("estados","iestado","nombreestado"," Estado: ");

$sql_extra=ifAndInt($sql_extra,"icat","icatret","=");
$titulo.=leeElementoInt("cat","icat","nombrecat"," Categor&iacute;a: ");

$sql_extra=ifAndInt($sql_extra,"minimo","importedonativosret",">=");
$titulo.=leeElementoValor("minimo"," Importe>=");

$sql_extra=ifAndInt($sql_extra,"maximo","importedonativosret","<=");
$titulo.=leeElementoValor("maximo"," Importe<=");

$sql_extras="";
$titulo.=" <strong>";
switch ($_GET["statusret"])
{
	case "pendiente":
		$titulo.="Pendiente";
		$sql_extras="statusret='0'";
		break;
	case "rechazada":
		$titulo.="Rechazada";
		$sql_extras="statusret='2'";
		break;
	case "validada":
		$titulo.="Validada";
		$sql_extras="statusret='1'";
		break;
	case "vigente":
		$titulo.="Vigente";
		$sql_extras="statusret='1' and finicioret<='".$fechahorahoy."' and ffinret>='".$fechahorahoy."'";
		break;
	case "disponible":
		$titulo.="Disponible";
		$sql_extras="statusret='1' and finicioret<='".$fechahorahoy."' and ffinret>='".$fechahorahoy."' and (maximoganadoresret > tganadoresret or maximoganadoresret=0) ";
		break;
	case "noiniciada":
		$titulo.="No iniciada";
		$sql_extras="statusret='1' and finicioret>='".$fechahorahoy."'";
		break;
}
$titulo.="</strong>";

if($sql_extras<>"")
{
	if($sql_extra<>"") $sql_extra.=" and ".$sql_extras;
	else $sql_extra=$sql_extras;	
}

if($sql_extra<>"") $sql_extra=" where ".$sql_extra;

$limite="";
$cuenta=0;
$total=0;
if($exportar<>1)
{
	$sql_cuenta="select count(ret.id) as cuenta, sum(importedonativosret) as total from ret ".$sql_extra;
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
			"&statusret=".htmlentitiesMemo2Strong($_GET["statusret"]).
			"&minimo=".(int)$_GET["minimo"].
			"&maximo=".(int)$_GET["maximo"].
			"&pagina=";
		
	$urlExcel=$urlComplemento."&exportar=1";

	$columnasTabla=15;
	$paginador=pintaPaginador($cuenta,(int)$_GET["pagina"],$tamanopagina,$urlComplemento,$total,$columnasTabla,$urlExcel);
	$totales='Total: '.number_format($cuenta, 0, '', ',');
	if($total>0)
		$totales.=' Importe: $'.number_format($total, 2, '.', ',');
}


$sql="select ret.id as idreal,nombreret,importedonativosret,nombreusuario,finicioret,ffinret,statusret,nombrecat,
maximoganadoresret,tganadoresret,tdonativosret,minimodonativoret,metaret,metaret-importedonativosret as diferencia from ret left join usuarios on ret.iusuarioret=usuarios.id left join cat on ret.icatret=cat.id ".$sql_extra." order by nombreret asc ".$limite;
$cad="";

$statuses=array("Pendiente","Aprobada","Rechazada","No enviada");
$res=@mysqli_query($GLOBALS["enlaceDB"] ,$sql);
if($exportar<>1)
{
	$cad.=abreTabla();
	$cad.=$paginador;
	$cad.=pintaTitulo($titulo,$columnasTabla);
	$cad.=pintaHeader($totales,$columnasTabla);
	
	$cad.=abreRenglonTitulo();
	$cad.=pintaColumnaString("id");
	$cad.=pintaColumnaString("Nombre");
	$cad.=pintaColumnaString("Usuario");
	$cad.=pintaColumnaString("Categor&iacute;a");
	$cad.=pintaColumnaString("Importe");
	$cad.=pintaColumnaString("Meta");
	$cad.=pintaColumnaString("Diferencia");
	$cad.=pintaColumnaString("Inicio");
	$cad.=pintaColumnaString("Fin");
	$cad.=pintaColumnaString("Status");
	$cad.=pintaColumnaString("# donativos");
	$cad.=pintaColumnaString("Max ganadores");
	$cad.=pintaColumnaString("# ganadores");
	$cad.=pintaVacioColumnas(2);
	$cad.=cierraRenglon();
	
	while($row=mysqli_fetch_object($res)) // aqui hacemos la cadena no importa cual sea y luego imprimimos
	{
		$cad.=abreRenglon();
		$cad.=pintaColumnaString($row->idreal);
		$cad.=pintaColumnaString(htmlentitiesMemo2Strong($row->nombreret));
		$cad.=pintaColumnaString(htmlentitiesMemo2Strong($row->nombreusuario));				
		$cad.=pintaColumnaString($row->nombrecat);				
		$cad.=pintaColumnaDinero($row->importedonativosret);
		$cad.=pintaColumnaDinero($row->metaret);
		$cad.=pintaColumnaDinero($row->diferencia);
		$cad.=pintaColumnaString($row->finicioret);
		$cad.=pintaColumnaString($row->ffinret);
		$cad.=pintaColumnaString($statuses[$row->statusret]);
		$cad.=pintaColumnaVal($row->tdonativosret);
		$cad.=pintaColumnaVal($row->maximoganadoresret);
		$cad.=pintaColumnaVal($row->tganadoresret);		
		$cad.=haceBoton("CMS","ret.php?step=modify&id=".$row->idreal);
		$cad.=haceBoton("Front","../iniciativaDetalle.php?idregistro=".$row->idreal);
		$cad.=cierraRenglon();
	}
	
	$cad.=$paginador;
	$cad.=cierraTabla();
}
else
{
	$filename = "reporte_" . date('YmdHi') . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	echo(pintaColumnaStringX("id"));
	echo(pintaColumnaStringX("Nombre"));
	echo(pintaColumnaStringX("Usuario"));
	echo(pintaColumnaStringX("Categoria"));
	echo(pintaColumnaStringX("Importe"));
	echo(pintaColumnaStringX("Meta"));
	echo(pintaColumnaStringX("Diferencia"));
	echo(pintaColumnaStringX("Inicio"));
	echo(pintaColumnaStringX("Fin"));
	echo(pintaColumnaStringX("Status"));
	echo(pintaColumnaStringX("# Donadores"));
	echo(pintaColumnaStringX("Max ganadores"));
	echo(pintaColumnaStringX("# ganadores"));
	echo(pintaSaltoX());
	while($row=mysqli_fetch_object($res)) // aqui hacemos la cadena no importa cual sea y luego imprimimos
	{
		echo(pintaColumnaStringX($row->idreal));
		echo(pintaColumnaStringX(htmlentitiesMemo2Strong($row->nombreret)));
		echo(pintaColumnaStringX(htmlentitiesMemo2Strong($row->nombreusuario)));
		echo(pintaColumnaStringX($row->nombrecat));
		echo(pintaColumnaDineroX($row->importedonativosret));
		echo(pintaColumnaDineroX($row->metaret));
		echo(pintaColumnaDineroX($row->diferencia));
		echo(pintaColumnaStringX($row->finicioret));
		echo(pintaColumnaStringX($row->ffinret));
		echo(pintaColumnaStringX($statuses[$row->statusret]));
		echo(pintaColumnaValX($row->tdonativosret));
		echo(pintaColumnaValX($row->maximoganadoresret));
		echo(pintaColumnaValX($row->tganadoresret));

		echo(pintaSaltoX());
	}
	  exit;
}
?>