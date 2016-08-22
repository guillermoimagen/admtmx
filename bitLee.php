<?
$API_folder="API/";
include("include/connection.php");
include("include/funciones.php");
include($API_folder."funciones_API.php");
include($API_folder."funcionesWeb_API.php");

if($_SESSION["firmado"] && $_SESSION["logged"]->cms==1)
{
	$idregistro=(int)$_GET["idregistro"];
	
	
	// directos
	$sqlBase=" as texto,fechabit,nombretabla,ayudatabla,tipotbit,registrobit,usuarios.nombreusuario,usuarios.id as idusuario,itbitbit,iusuariocmsbit from bit left join catablas on bit.tablabit=catablas.idtabla left join tbit on bit.itbitbit=tbit.id left join usuarios on bit.iusuariobit=usuarios.id";
	if($_GET["modo"]=="iniciativa")
	{
		$sqlIniciativa="select nombreret ".$sqlBase." left join ret on bit.registrobit=ret.id where tablabit=2 and registrobit=".$idregistro;
		$sqlComentarios="select textocom ".$sqlBase." left join com on bit.registrobit=com.id where tablabit=5 and com.iretcom=".$idregistro;
		$sqlReportes="select concat(nombremot,' ',textorep) ".$sqlBase." left join rep on bit.registrobit=rep.id left join mot on rep.imotrep=mot.id where tablabit=34 and rep.iretrep=".$idregistro;
		$sqlDonativos="select importedon ".$sqlBase." left join don on bit.registrobit=don.id where tablabit=3 and don.iretdon=".$idregistro;
	
		$sqlFinal="(".$sqlIniciativa.") UNION (".$sqlComentarios.") UNION (".$sqlReportes.") UNION (".$sqlDonativos.") order by fechabit desc";
	}
	else if($_GET["modo"]=="usuario")
	{
		$sqlIniciativa="select nombreret ".$sqlBase." left join ret on bit.registrobit=ret.id where tablabit=2 and bit.iusuariobit=".$idregistro;
		$sqlUsuarios="select usuarios1.nombreusuario ".$sqlBase." left join usuarios as usuarios1 on bit.registrobit=usuarios1.id where tablabit=1 and registrobit=".$idregistro;
		$sqlComentarios="select textocom ".$sqlBase." left join com on bit.registrobit=com.id where tablabit=5 and com.iusuariocom=".$idregistro;
		$sqlReportes="select concat(nombremot,' ',textorep) ".$sqlBase." left join rep on bit.registrobit=rep.id left join mot on rep.imotrep=mot.id where tablabit=34 and rep.iusuariorep=".$idregistro;
		
		$sqlDonativos="select importedon ".$sqlBase." left join don on bit.registrobit=don.id where tablabit=3 and don.iusuariodonodon=".$idregistro;
		$sqlFinal="(".$sqlIniciativa.") UNION (".$sqlUsuarios.") UNION (".$sqlComentarios.") UNION (".$sqlReportes.") UNION (".$sqlDonativos.") order by fechabit desc";
	}
	
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,$sqlFinal);
	while($row=mysqli_fetch_object($res))
	{
		if($row->itbitbit==11 || $row->itbitbit==12)
			$row->texto="$".number_format($row->texto,0,".",",")." ".$moneda;
		$row->ayudatabla="_naharaProcesa/".$row->ayudatabla;
		$arreglo[]=$row;
	}
	$vista="";
	if(sizeof($arreglo)>0)
	{
		$vista=abre_plantilla_API("vistaBit",false);
		
		$vistaBit=extrae_vista_API("bit",$vista);
		$vistaBitT=generaVistaRecursiva($vistaBit[1],$arreglo);
		$vista=str_replace($vistaBit[0],$vistaBitT,$vista);
	}		
	echo $vista;
}
?>