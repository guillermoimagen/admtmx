<?
function ifAndInt($valor,$variable,$campo,$signo)
{
	if(isset($_GET[$variable]) && $_GET[$variable]<>0 && $_GET[$variable]<>"")
	{
		if($valor<>"") $valor.=" and ";
		$valor.=$campo.$signo.(int)$_GET[$variable];
	}
	return $valor;
}

function ifAndFecha($valor,$variable,$campo,$signo)
{
	if(isset($_GET[$variable]) && $_GET[$variable]<>"")
	{
		if($valor<>"") $valor.=" and ";
		if($signo==">=") $extra=" 00:00:00";
		else $extra=" 23:59:59";
		$valor.=$campo.$signo."'".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_GET[$variable]).$extra."'";
	}
	return $valor;
}

function lee_usuario($id)
{
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreusuario,nickusuario,emailusuario,tel1usuario from usuarios where id=".$id);
	while($row=mysqli_fetch_object($res))
	{
		$devolver->nombreusuario=$row->nombreusuario." (".$row->nickusuario.")";
		$devolver->emailusuario=$row->emailusuario;
		$devolver->tel1usuario=$row->tel1usuario;
		if($row->emailusuario<>"")
			$devolver->emailLink="<a href='mailto:".$row->emailusuario."'>".$row->emailusuario."</a>";
		else $devolver->emailLink="";
	}
	return $devolver;
}

function lee_usuarioPais($id)
{
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreusuario,nickusuario,emailusuario,tel1usuario,nombrepais,nombreestado from usuarios left join pais on usuarios.ipaisusuario=pais.id left join estados on usuarios.iestadousuario=estados.id where usuarios.id=".$id);
	while($row=mysqli_fetch_object($res))
	{
		$devolver->nombreusuario=$row->nombreusuario." (".$row->nickusuario.")";
		$devolver->emailusuario=$row->emailusuario;
		$devolver->tel1usuario=$row->tel1usuario;
		$devolver->pais=$row->nombrepais;
		$devolver->estado=$row->nombreestado;
		if($row->emailusuario<>"")
			$devolver->emailLink="<a href='mailto:".$row->emailusuario."'>".$row->emailusuario."</a>";
		else $devolver->emailLink="";
	}
	return $devolver;
}

function lee_reto($id)
{
	$devolver="";
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreret from ret where id=".$id);
	while($row=mysqli_fetch_object($res))
	{
		$devolver=$row->nombreret;
	}
	return $devolver;
}

function leeElementoInt($tabla,$variable,$campo,$titulo)
{
	$devolver="";
	if(isset($_GET[$variable]) && $_GET[$variable]<>0 && $_GET[$variable]<>"")
	{		
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select ".$campo." from ".$tabla." where id=".(int)$_GET[$variable]);
		while($row=mysqli_fetch_array($res))
		{
			$devolver="<strong>".$titulo."</strong>".$row[$campo];
		}
		
	}
	return $devolver;
}

function leeElementoValor($variable,$titulo)
{
	$devolver="";
	if(isset($_GET[$variable]) && $_GET[$variable]<>"")
	{		
		$devolver="<strong>".$titulo."</strong>".htmlentitiesMemo2Strong($_GET[$variable]);
	}
	return $devolver;
}

function pintaPaginador($cuenta,$actual,$pp,$url,$total,$columnas,$exportarurl)
{
	$totalPaginas=round($cuenta/$pp);
	$cadena="";
	if($cuenta>0)
	{
		$cadena='<tr><td colspan="'.$columnas.'"><div class="pagina_div">';
		if($cuenta>$pp)
		{
			if($pp*$totalPaginas<$cuenta) $totalPaginas++;
			
			if($actual>1) $cadena.='<a href="'.$url.round($actual-1).'"><div class="num_pag"><strong class="sii"><</strong><strong class="noo">&lt;</strong></div></a>';
			
			$pintardespues=0;
			for($i=$actual-2; $i<=$actual+2; $i++)
			{
				if($i>0 && $i<=$totalPaginas)
				{
					$pintarActual="";
					if($i==$actual)
						$pintarActual=" pag_actual";
					$cadena.='<a href="'.$url.$i.'"><div class="num_pag '.$pintarActual.'">'.$i.'</div>';
				}
				else if($i<=0)
					$pintardespues++;
			}
			for($i=1; $i<=$pintardespues; $i++)
			{
				if($i+$actual+2<=$totalPaginas)
					$cadena.='<a href="'.$url.round($i+$actual+2).'"><div class="num_pag">'.round($i+$actual+2).'</div>';
			}
				
				
			if($actual<$totalPaginas) $cadena.='<a href="'.$url.round($actual+1).'"><div class="num_pag")"><strong class="sii">></strong><strong class="noo">&gt;</strong></div></a>';
		}
		
		$cadena.='<a href="'.$exportarurl.'" target="_blank"><div class="num_pag" style="width:100px"><strong class="sii">Exportar</strong></div></a>'
		;$cadena.="</div></td></tr>";
		
	}
	return $cadena;
}

function abreTabla() { return '<table class="textogeneral reporteTabla" cellpadding="6">'; }
function cierraTabla() {  return '</table>'; }
function abreRenglon(){ 	return '<tr class="reporte">';}
function abreRenglonTitulo() { return '<tr class="reporteTitulo">'; }
function cierraRenglon(){ return '</tr>'; }
function pintaColumnaString($valor){ return '<td>'.$valor.'</td>'; }
function pintaColumnaStringLink($valor,$link){ return '<td><a href="'.$link.'" target="_blank">'.$valor.'</a></td>'; }
function pintaColumnaVal($valor){ return '<td>'.number_format($valor, 0, '', ',').'</td>'; }
function pintaColumnaDinero($valor){ return '<td style="text-align:right">$'.number_format($valor, 2, '.', ',').'</td>'; }
function haceBoton($leyenda,$url) { return '<td><a href="'.$url.'" target="_blank" class="textoboton">'.$leyenda.'</a></td>'; }	
function pintaHeader($valor,$columnas){ 	return '<tr class="reporteGranTitulo"><td colspan="'.$columnas.'">'.$valor.'</td></tr>';}
function pintaTitulo($valor,$columnas){ 	return '<tr class="reporteTituloReal"><td colspan="'.$columnas.'">'.$valor.'</td></tr>';}
function pintaVacioColumnas($cuantas){ 	return '<td colspan="'.$cuantas.'">&nbsp;</td>';}

function pintaColumnaStringX($valor){ return (cleanData($valor))."\t"; }
function pintaColumnaValX($valor){ return $valor."\t"; }
function pintaColumnaDineroX($valor){ return ''.$valor."\t"; } 
function pintaSaltoX() { return "\r\n"; }
function cleanData($str)
{
	$str=str_replace("\r\n","",$str);
	$str=str_replace("\n\r","",$str);
	$str=str_replace("\r","",$str);
	$str=str_replace("\n","",$str);
	$str=str_replace("\t","",$str);
	$str=str_replace("<","",$str);
	$str=str_replace(">","",$str);
	$str=str_replace(", "," ",$str);
    $str = preg_replace("/\t/", "", $str);
    $str = preg_replace("/\r?\n/", "", $str);

    // force certain number/date formats to be imported as strings
/*    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
*/
    // escape fields that include double quotes
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	return $str;
}
?>