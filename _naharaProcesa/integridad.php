<?
include("recursos/entrada.php");
include("recursos/xss_var.php");
include("../include/connection.php");
set_time_limit(300000);
$archivoactual="integridad.php";

if($_SESSION["nivelusuario"]<>0) exit();

if((int)$_GET["step"]==1000)
{
	/*
	integridad.php?step=1000&idregistro=0 todos no recomendado
	integridad.php?step=1000&idregistro=1000  solo un registro
	integridad.php?step=1000&comienzo=0 5000 registros a partir de comienzo
	
	*/
	$API_folder="../API/";
	include($API_folder."actualizacionFunciones.php");
	
	if(isset($_GET["comienzo"])) $sql=" limit ".(int)$_GET["comienzo"].",5000";
	else if((int)$_GET["idregistro"]==0) $sql="";
	else $sql=" where id=".(int)$_GET["idregistro"];
	
	echo ("select id,statusdon from don".$sql."<br>");
	$cuenta=(int)$_GET["comienzo"];
	$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select id,statusdon from don".$sql);
	if(mysqli_num_rows($res)>0)
	{
		while($don=mysqli_fetch_object($res))
		{
			$cuenta++;
			echo "Procesando ".$cuenta."-".$don->id." ".registrarPagoDon($don->id,$don->statusdon)."<br>";
		}
	}
}
else if((int)$_GET["step"]==5 || (int)$_GET["step"]==6) // corrige iniciatia, 6 corrige usuario 
{
	$API_folder="../API/";
	include($API_folder."actualizacionFunciones.php");
	if((int)$_GET["step"]==5) // iniciativa
	{
		$mensaje="";
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select id as idreal,nombreret from ret where id=".(int)$_GET["idregistro"]);
		if(mysqli_num_rows($res)>0)
		{
			while($reto=mysqli_fetch_object($res))
			{	
				if(actualizaRet($reto))
					$mensaje=1;
				else 
					$mensaje=0;
			}
		}
		if($mensaje=="") $mensaje=0;
		echo($mensaje);
	}
	else if((int)$_GET["step"]==6) // usuario
	{
		$mensaje="";
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select id as idreal,nombreusuario from usuarios where id=".(int)$_GET["idregistro"]);
		if(mysqli_num_rows($res)>0)
		{
			while($usuario=mysqli_fetch_object($res))
			{	
				if(actualizaUsuario((int)$_GET["idregistro"],"donador") && actualizaUsuario((int)$_GET["idregistro"],"receptor"))
					$mensaje=1;
				else 
					$mensaje=0;
			}
		}
		if($mensaje=="") $mensaje=0;
		echo($mensaje);
		
	}
}
else
{
?>
<html>

<link rel="stylesheet" href="recursos/estilos.css" type="text/css">
<head>
<title>Analizador de integridad de informaci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
</head>
<BODY style="margin-right:20px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titulopagina">
  <tr>    
    <td height="30" valign="middle">Analizador de integridad de informaci&oacute;n</td></tr></table>
   
<? 
if((int)$_GET["step"]<>2 && (int)$_GET["step"]<>3) 
{ 
	$totalret=0;
	$totalusuarios=0;
	$totaldon=0;
	$ret=@mysqli_query($GLOBALS["enlaceDB"] ,"select count(id) as total from ret");
	while($rowRet=mysqli_fetch_object($ret)) $totalret=$rowRet->total;
	
	$usuario=@mysqli_query($GLOBALS["enlaceDB"] ,"select count(id) as total from usuarios");
	while($rowUsuario=mysqli_fetch_object($usuario)) $totalusuarios=$rowUsuario->total;
	
	$don=@mysqli_query($GLOBALS["enlaceDB"] ,"select count(id) as total from don");
	while($rowDon=mysqli_fetch_object($don)) $totaldon=$rowDon->total;

?>
	<div style="margin-left:30px; margin-top:10px; width:500px; background-color:<?=$vsitioscolor5?>; padding:20px" class="textogeneral">La siguiente rutina verificar&aacute; la integridad de los c&alculos del sistema en los apartados de usuarios e iniciativas. Es un proceso que puede resultar tardado e intenso, por lo que te recomendamos hacerlo a media noche cuando no hay tr&aacute;fico en el sitio de internet.<br><br>Se mostrar&aacute; un listado con aquellos registros de usuarios e iniciativas que muestren inconsistencias, desde el cual podr&aacute;s solicitar que se recalculen autom&aacute;ticmaente.<br><br>Puedes usar valor m&aacute;ximo para cambiar los 100
    
    <center>Se analizar&aacute;n <strong><?=$totalret?> iniciativas, <?=$totalusuarios?> usuarios y <?=$totaldon?> donativos<br><br>
    <input type="button" style="background-color:#112FA6; color:#FFFFFF" value="Iniciativas" onClick="document.location.href='integridad.php?step=2'">  
    <input type="button" style="background-color:#112FA6; color:#FFFFFF" value="Usuarios" onClick="document.location.href='integridad.php?step=3'">
    </center>
    </div>
<? 
} 
else
{
?>
<style>
.reporteTitulo
{
	text-align:center;
	font-weight:bold;	
}
.reporte
{
	text-align:center;
}
.reporteTabla
{
	padding:10px;	
}
.reporteTabla tr:nth-child(odd) td{
	background-color:#E9E9E9
}
.reporteTabla tr:nth-child(even) td{
	background-color:#D8D8D8;

}
.fondoLoader
{
	width:25px; background-color:#FFFFFF !important;
}
</style>
<script>
function encodeID(s) {
    if (s==='') return '_';
    return s.replace(/[^a-zA-Z0-9.-]/g, function(match) {
        return '_'+match[0].charCodeAt(0).toString(16)+'_';
    });
}
function cambioIdioma(step,idregistro)
{
	var cadena="<img src='../recursos/elementos/ajax-loader.gif' style='width:20px'>";
	$("#procesando"+idregistro).html(cadena);
	$.ajax( "integridad.php?step="+step+"&idregistro="+idregistro )
	  .done(function(data) {
		  $("#procesando"+idregistro).html("");
		 if(data=="1")
		 	$("#renglon_"+step+"_"+idregistro).hide();
	  })
	  .fail(function() {
	  })
	  .always(function() {
		 
	  });
}

</script>
<?
	$erroresIniciativas=0;
	$erroresUsuarios=0;
	$maximos=(int)$_GET["maximos"];
	if($maximos==0) $maximos=100;
	if((int)$_GET["step"]==2)
	{
?>
	<table class="textogeneral reporteTabla" cellpadding="6">
    <tr class="reporteTitulo">
    	<td colspan="2" style="font-size:20px">INICIATIVAS</td>
        <td colspan="2"># Ganadores </td>
        <td colspan="2">$ Donativos </td>
        <td colspan="2"># Donativos </td>
        <td colspan="3" rowspan="2"></td>
	</tr>
    <tr class="reporteTitulo">
    	<td>ID</td>
        <td>Iniciativa</td>
        <td>DB</td>
        <td>Count</td>
         <td>DB</td>
        <td>Count</td>
         <td>DB</td>
        <td>Count</td>	
	</tr>
<?
	
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select id as idreal,nombreret,tganadoresret, importedonativosret, tdonativosret from ret order by id asc");
		while($reto=mysqli_fetch_object($res))
		{
			$idreto=$reto->idreal;
			$importedonativosret=0;
			$tdonativosret=0;
			$donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as importedonativosret,count(id) as tdonativosret from don where statusdon='2' and iretdon=".$reto->idreal);
			while($donativosRow=mysqli_fetch_object($donativos))
			{
				if($donativosRow->importedonativosret)
					$importedonativosret=$donativosRow->importedonativosret;
				if($donativosRow->tdonativosret)
					$tdonativosret=$donativosRow->tdonativosret;
			}
			
			$tganadoresret=0;
			$donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(ganadordon) as tganadoresret from don where ganadordon>=1 and statusdon='2' and iretdon=".$reto->idreal);
			while($donativosRow=mysqli_fetch_object($donativos))
			{
				if($donativosRow->tganadoresret)
					$tganadoresret=$donativosRow->tganadoresret;
			}
			
			//echo "<br>".$reto->idreal." ";
		
			if($reto->tganadoresret<>$tganadoresret || $reto->importedonativosret<>$importedonativosret || $reto->tdonativosret<>$tdonativosret)
			{
				
					$erroresIniciativas++;
				?>
				<tr class="reporte" id="renglon_5_<?=$reto->idreal?>">
					<td><?=$reto->idreal?></td>
					<td><?=$reto->nombreret?></td>
					<td><?=$reto->tganadoresret?></td>
					<td><?=$tganadoresret?></td>
					<td>$<?=number_format($reto->importedonativosret, 2, '.', ',')?></td>
					<td>$<?=number_format($importedonativosret, 2, '.', ',')?></td>
					<td><?=$reto->tdonativosret?></td>
					<td><?=$tdonativosret?></td>
					<td><a href="ret.php?step=modify&id=<?=$reto->idreal?>" target="_blank" class="textoboton">Ver en CMS</a></td>
					<td><a href="../iniciativaDetalle.php?idregistro=<?=$reto->idreal?>" target="_blank" class="textoboton">Ver en sitio</a></td>
					<td><div onclick="cambioIdioma(5,<?=$reto->idreal?>);" class="textoboton" style="cursor:pointer">Corregir</div></td>
                    <td class="fondoLoader"><div id="procesando<?=$reto->idreal?>"></div></td>
				</tr>
				<?
				
			}
			if($erroresIniciativas==$maximos) break;
		}
		?>
		<tr class="reporteTitulo">
			<td colspan="8"></td>
			<td colspan="3">Total afectados: <?=$erroresIniciativas?></td>	
		</tr>
		</table>
        
	<? 
		
	} 
	
	else if((int)$_GET["step"]==3)
	{
	?>
    
    
        <table class="textogeneral reporteTabla" cellpadding="6">
        <tr class="reporteTitulo">
            <td colspan="2" style="font-size:20px">USUARIOS</td>
            <td colspan="2"># Donativos<br>realizados</td>
            <td colspan="2">$ Donativos<br>realizados</td>
            <td colspan="2"># Donativos<br>recibidos</td>
            <td colspan="2">$ Donativos<br>recibidos</td> 
            <td colspan="3" rowspan="2"></td>
        </tr>
        <tr class="reporteTitulo">
            <td>ID</td>
            <td>Iniciativa</td>
            <td>DB</td>
            <td>Count</td>
             <td>DB</td>
            <td>Count</td>
            <td>DB</td>
            <td>Count</td>	
            <td>DB</td>
            <td>Count</td>	
        </tr>
        <?	
        $res=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreusuario,id as idreal,ndonusuario,idonusuario,irdonusuario,nrdonusuario from usuarios order by id asc");
        while($usuario=mysqli_fetch_object($res))
        {
            $idusuario=$usuario->idreal;
            // actualizaremos el donador
            $ndonusuario=0;
            $idonusuario=0;
            $donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as idonusuario,count(id) as ndonusuario from don where statusdon='2' and iusuariodonodon=".$idusuario);
            while($donativosRow=mysqli_fetch_object($donativos))
            {
                if($donativosRow->idonusuario)
                    $idonusuario=$donativosRow->idonusuario;
                if($donativosRow->ndonusuario)
                    $ndonusuario=$donativosRow->ndonusuario;
            }
            
            // actualizaremos el receptor del donativo
            $nrdonusuario=0;
            $irdonusuario=0;
            $donativos=@mysqli_query($GLOBALS["enlaceDB"] ,"select sum(importedon) as irdonusuario,count(id) as nrdonusuario from don where statusdon='2' and iusuariodon=".$idusuario);
            while($donativosRow=mysqli_fetch_object($donativos))
            {
                if($donativosRow->irdonusuario)
                    $irdonusuario=$donativosRow->irdonusuario;
                if($donativosRow->nrdonusuario)
                    $nrdonusuario=$donativosRow->nrdonusuario;
            }
        
            // echo "<br>".$idusuario." ";
            if($usuario->ndonusuario<>$ndonusuario || $usuario->idonusuario<>$idonusuario || $usuario->irdonusuario<>$irdonusuario || $usuario->nrdonusuario<>$nrdonusuario)
            {
                $erroresUsuarios++;
                ?>
                <tr class="reporte" id="renglon_6_<?=$usuario->idreal?>">
                    <td><?=$usuario->idreal?></td>
                    <td><?=$usuario->nombreusuario?></td>
                    <td><?=$usuario->ndonusuario?></td>
                    <td><?=$ndonusuario?></td>
                    <td>$<?=number_format($usuario->idonusuario, 2, '.', ',')?></td>
                    <td>$<?=number_format($idonusuario, 2, '.', ',')?></td>
                    <td><?=$usuario->nrdonusuario?></td>
                    <td><?=$nrdonusuario?></td>
                    <td>$<?=number_format($usuario->irdonusuario, 2, '.', ',')?></td>
                    <td>$<?=number_format($irdonusuario, 2, '.', ',')?></td>
                    
                    <td><a href="usuarios.php?step=modify&id=<?=$usuario->idreal?>" target="_blank" class="textoboton">Ver en CMS</a></td>
                    <td><a href="../usuarioDetalle.php?idregistro=<?=$usuario->idreal?>" target="_blank" class="textoboton">Ver en sitio</a></td>
                    <td><div onclick="cambioIdioma(6,<?=$usuario->idreal?>);" class="textoboton" style="cursor:pointer">Corregir</div></td>
                    <td class="fondoLoader"><div id="procesando<?=$usuario->idreal?>"></div></td>
                </tr>
                <?
            }
			if($erroresUsuarios==$maximos) break;
        }
        ?>
        <tr class="reporteTitulo">
            <td colspan="10"></td>
            <td colspan="3">Total afectados: <?=$erroresUsuarios?></td>	
        </tr>
        </table>
    <?
		
	}
	if($erroresIniciativas==$maximos || $erroresUsuarios==$maximos)
	{
	?>
    	 <input type="button" style="background-color:#112FA6; color:#FFFFFF" value="Refrescar" onClick="document.location.href='integridad.php?step=<?=(int)$_GET["step"]?>'">
    <?
	}
	?>
    <input type="button" style="background-color:#112FA6; color:#FFFFFF" value="Regresar" onClick="document.location.href='integridad.php?step=1'">
    <?
}
}
?>