<?
$renglonesExtras=0;
$renglonesExtrasInsertar=0;
$error="";
$pagado=false;
$iddonativo=0;

if(isset($_POST["idiniciativa"]) && $_POST["idiniciativa"]<>0)
{
	$iusuariodon=$iniciativaDetalleArreglo[0]->iusuarioret;
	$iretdon=(int)$_POST["idiniciativa"];
	
	$cret=cret_lee(array("sql_extra"=>"iretcret=".(int)$_POST["idiniciativa"],"leerIdiomas"=>"si"));
	
	$error="";
	
	if(sizeof($cret)>0)
	{
		$renglonesExtrasInsertar=(int)$_POST["renglonesextras"];
		$renglonesExtras=(int)$_POST["renglonesextras"];
		if($renglonesExtras>$ganadoresdisponiblesreal)
			$renglonesExtras=$ganadoresdisponiblesreal;
		for($j=1; $j<=$renglonesExtrasInsertar; $j++)
		{		
			for($i=0; $i<=sizeof($cret)-1; $i++)
			{
				$nombrecampo='vcre_'.$cret[$i]->idreal.'_'.$j;
				$tipo=$cret[$i]->tipocret;
				$minimo=$cret[$i]->mincret;
				$maximo=$cret[$i]->maxcret;
				$req=$cret[$i]->reqcret;
				//echo $nombrecampo."/".$_POST[$nombrecampo]."/".$tipo."/".$minimo."/".$maximo."/".$req."<br>";
				//echo $nombrecampo."/".$_POST[$nombrecampo]."<br>";
				
				$valor=mysqli_real_escape_stringMemo($_POST[$nombrecampo]);
				if(!$valor) $valor="";
				
				
				if($req=="1" && $valor=="")
					$error="req";
				else if($tipo=="1" || $tipo=="2")
				{
					if($tipo=="1" && (floor($valor)<>$valor || !is_numeric($valor))) 
						$error="int";
					else if($tipo=="2" && !is_numeric($valor)) 
						$error="float";
					else if($minimo && $valor<$minimo)
						$error="minimo";
					else if($maximo && $valor>$maximo)
						$error="maximo";				
				}
				else if($tipo=='3' && strlen($valor)>100)
					$error="maslargo";
				else if($tipo=='4')
				{
					$arreglo = explode("\r\n", $cret[$i]->opcionescret);
					if(!in_array($valor,$arreglo)) 
						$error="valoropcion";
				}
				
				if($error<>"")
				{
					if($idioma==0)
						$errorText="Existen errores en la informaci&oacute;n adicional";
					else $errorText="There mistakes on the extra information";	
					//echo($error." ".$_POST[$nombrecampo]." ".$nombrecampo."<br>");
					break;
				}
			}
			if($error<>"") break;
		}
	}	
}
else if(isset($_GET["idusuario"]))
{
	$iusuariodon=(int)$_GET["idusuario"];
	$iretdon=0;
}
else
{
	$iusuariodon=0;
	$iretdon=0;
}

$iusuariodonodon=0;
if($_SESSION["firmado"]) // el firmado gana
	$iusuariodonodon=$_SESSION["logged"]->id;
else if(isset($_SESSION["loggedParcial"]->id) && $_SESSION["loggedParcial"]->id<>0)
	$iusuariodonodon=$_SESSION["loggedParcial"]->id;

$donativo=(int)$_POST["donativo"];
if($donativo==0)
{
	if($idioma==0)
		$errorText="Debes proporcionar un importe de donativo";
	else $errorText="you should provide your donation amount";	
}

if($iusuariodonodon==0)
{
	if($idioma==0)
		$errorText="No est&aacute;s firmado";
	else $errorText="You are not signed in";	
}



// jesus



if($error=="" && $errorText=="") 
{
	if($_SESSION["mobile"]) $plataformadon=1;
	else $plataformadon=0;
	
	if(!isset($iformadon)) $iformadon=1;
	$sql="insert into don set iusuariodon=".$iusuariodon.",
								iretdon=".$iretdon.",
								iformadon=".$iformadon.",
								iusuariodonodon=".$iusuariodonodon.",
								importedon=".$donativo.",
								importeprogramadodon=".$donativo.",
								plataformadon='".$plataformadon."',
								statusdon='0',
								ganadordon=".$renglonesExtras.",
								idioma='".$idioma."'";
	
	if(@mysqli_query($GLOBALS["enlaceDB"] ,$sql))
	{
		$iddonativo=mysqli_insert_id($GLOBALS["enlaceDB"] );
		hacebit(11,3,$iddonativo);
		for($j=1; $j<=$renglonesExtrasInsertar; $j++)
		{		
			for($i=0; $i<=sizeof($cret)-1; $i++)
			{
				$nombrecampo='vcre_'.$cret[$i]->idreal.'_'.$j;
				$valor=mysqli_real_escape_stringMemo($_POST[$nombrecampo]);
				if(!$valor) $valor="";
				@mysqli_query($GLOBALS["enlaceDB"] ,"insert into vret set ganvret=".$j.",idonvret=".$iddonativo.",icretvret=".$cret[$i]->idreal.",valorvret='".$valor."',statusvret='1'");
			}
		}
	}
	else
	{
		if($idioma==0)
			$errorText="Ocurri&oacute; un error al crear el donativo. Intenta m&aacute;s tarde";
		else $errorText="There was an error creating your donation. Please try again later.";	
	}
}
?>