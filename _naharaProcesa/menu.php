<center>
	<?php $nivelusuario = $_SESSION["nivelusuario"]; ?>
    
		<table width=100% class=textogeneral border=0 cellpadding=0 cellspacing=0>
        	<tr>
            	<td>
					<table width=100% class=textogeneral border=0 cellpadding=0 cellspacing=0>
                    	<tr height=24>
							<td style="text-align:center;">
                            
                            <div class="menu">
<?php
  
	
	if($nivelusuario==0 || $nivelusuario==1)
	{	
		$btnUsuarios = "normal";
		if($archivoactual=="usuarios.php") $btnUsuarios = "activo";
		haceboton_menu("Usuarios","usuarios.php?sortfield=id&step=busqueda&esframe=2&", $btnUsuarios);
		
		$btnRet = "normal";
		if($archivoactual=="ret.php") $btnRet = "activo";
		haceboton_menu("Iniciativas","ret.php?sortfield=id&step=busqueda&esframe=2&", $btnRet);
		
		$btnDon = "normal";
		if($archivoactual=="don.php") $btnDon = "activo";
		haceboton_menu("Donativos","don.php?sortfield=id&step=busqueda&esframe=2&", $btnDon);
		
		if($nivelusuario==0)
		{
			$btnCat = "normal";
			if($archivoactual=="cat.php") $btnCat = "activo";
			haceboton_menu("Categor&iacute;as","cat.php?sortfield=id&step=1&esframe=2&", $btnCat);
			
			$btnCont = "normal";
			if($archivoactual=="cont.php") $btnCont = "activo";
			haceboton_menu("Contenidos","cont.php?sortfield=id&step=1&esframe=2&", $btnCont);
			
			$btnNoti = "normal";
			if($archivoactual=="noti.php") $btnNoti = "activo";
			haceboton_menu("Noticias","noti.php?sortfield=id&step=1&esframe=2&", $btnNoti);
			
			$btnBan = "normal";
			if($archivoactual=="ban.php") $btnBan = "activo";
			haceboton_menu("Banners","ban.php?sortfield=id&step=1&esframe=2&", $btnBan);
			
			$btnContacto = "normal";
			if($archivoactual=="contacto.php") $btnContacto = "activo";
			haceboton_menu("Contacto","contacto.php?sortfield=id&step=1&esframe=2&", $btnContacto);
			
			$btnRep = "normal";
			if($archivoactual=="rep.php") $btnRep = "activo";
			haceboton_menu("Reportes","rep.php?sortfield=id&step=1&esframe=2&", $btnRep);
			
			$btnTransacciones = "normal";
			if($archivoactual=="transacciones.php") $btnTransacciones = "activo";
			haceboton_menu("Transacciones","transacciones.php?sortfield=id&step=busqueda&esframe=2&", $btnTransacciones);
		}
		
		
		
		
		$btnReportesI = "normal";
		if($archivoactual=="reportesI.php") $btnReportesI = "activo";
		haceboton_menu("Reportes iniciativas","reportes.php?step=1&modoR=iniciativas&esframe=2", $btnReportesI);
		
		$btnReportesD = "normal";
		if($archivoactual=="reportesD.php") $btnReportesD = "activo";
		haceboton_menu("Reportes usuarios y donativos","reportes.php?step=1&modoR=donativos&esframe=2", $btnReportesD);
		
		$btnReportesU = "normal";
		if($archivoactual=="reportesU.php") $btnReportesU = "activo";
		haceboton_menu("Reportes Usuarios","reportes.php?step=1&modoR=usuarios&esframe=2", $btnReportesU);
	}
	else if($nivelusuario==2)
	{
		
		$btnReportesI = "normal";
		if($archivoactual=="reportesI.php") $btnReportesI = "activo";
		haceboton_menu("Reportes iniciativas","reportes.php?step=1&modoR=iniciativas&esframe=2", $btnReportesI);
		
		$btnReportesD = "normal";
		if($archivoactual=="reportesD.php") $btnReportesD = "activo";
		haceboton_menu("Reportes usuarios y donativos","reportes.php?step=1&modoR=donativos&esframe=2", $btnReportesD);
		
		$btnReportesU = "normal";
		if($archivoactual=="reportesU.php") $btnReportesU = "activo";
		haceboton_menu("Reportes Usuarios","reportes.php?step=1&modoR=usuarios&esframe=2", $btnReportesU);
	}
	
	
	

	

		
?>
<br><br>
<!--
<div class="contMenu" style="float:left; margin-top: 4px; margin-left:4px;"><?php include("buscadorHome.php");?></div>
							</td>
<td></td></tr></table>
-->