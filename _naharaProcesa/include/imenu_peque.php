<?
$botones_peque="";
$archivo_inferior="";

  if($numerodetabla<1000) // solo tablas de no idioma
  {
	  // Genera el menu de info y redes
		//if($numerodetabla<>50)
		//	$botones_peque.=haceboton_menu_peque("Info y redes","infored.php?modo=ver&pagina=1&esframe=1&itabla=".$numerodetabla."&registro=".$id."&idcontrol=".$idcontrolinterno."&","frame_bajo",380,"boton",50001); 
			
  		 // LEE LOS MENUS QUE APLICAN A LA PAGINA
	  $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select id,botonmenupeque,urlmenupeque,condicionalmenupeque,modomenupeque from camenupeque where activo=1 and itablamenupeque=".$numerodetabla." order by ordenmenupeque asc, id asc");
	  
	  
	  while($rowx = mysqli_fetch_array($resultx))
	  {
		$botonmenupeque=$rowx["botonmenupeque"];
		$urlmenupeque=$rowx["urlmenupeque"];
		$condicionalmenupeque=$rowx["condicionalmenupeque"];
		
		eval("\$urlmenupeque=\"".$urlmenupeque."\";");		
		if($condicionalmenupeque<>"")
		{
			//comerntar para que funcione el imenupeque si no no funciona
			//$condicionalmenupeque=str_replace("\$", "\\\$", $condicionalmenupeque);
			//$condicionalmenupeque=str_replace("\"", "\\\"", $condicionalmenupeque);
			$condicionalmenupeque=str_replace("$", "\$", $condicionalmenupeque);
			$tempi=0;
			$condicionalmenupeque="if(".$condicionalmenupeque.") \$tempi=1;";
			eval($condicionalmenupeque);
		}
		else $tempi=1;	
		if($tempi==1) 
		{
		  if($rowx["modomenupeque"]==0)
			  $botones_peque.=haceboton_menu_peque($botonmenupeque,$urlmenupeque."&esframe=1","frame_bajo",0,"boton",$rowx["id"]);
		  else if($rowx["modomenupeque"]==1)	 
		  	$archivo_inferior=$urlmenupeque."&esframe=1&itabla=".$numerodetabla."&registro=".$id."&idcontrol=".$idcontrolinterno."&";
		 else if($rowx["modomenupeque"]==2)
			  $botones_peque.=haceboton_menu_peque($botonmenupeque,$urlmenupeque."&esframe=1","_blank",0,"boton",$rowx["id"]); //,."&esframe=1","frame_bajo",0,"boton",$rowx["id"]);
	     else if($rowx["modomenupeque"]==3)
			  $botones_peque.="<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>"; 
		}  
	  }
	  
	  
	/*  if($archivoactual=="spersonal.php")
	      $botones_peque.="<td><a href=tiendas/personallugares_principal.php?idsolicitud=$id>Asignar tiendas</a></td>";
		*/  	
		
	  if($boton_imprimibles==1 and $numerodetabla<>63) 
	  {
		
		$botones_peque.=haceboton_menu_peque("Imprimir documentos","imprimibles_frame.php?","frame_bajo",380,"boton",50003); 	
		$botones_peque.=haceboton_menu_peque("Ver documentos","imprimiblesh.php?step=busqueda2&moditobusqueda=especial&esframe=1&","frame_bajo",380,"boton",50004); 	
	  }	
	  //codigo agregado por marco 01/11/2010 
	  else if($archivoactual=="proveedores.php" and $numerodetabla==63 and $tipocliente==0 and $boton_imprimibles==1)
		{
		$botones_peque.=haceboton_menu_peque("Imprimir documentos","imprimibles_frame.php?","frame_bajo",380,"boton",50003); 	
		$botones_peque.=haceboton_menu_peque("Ver documentos","imprimiblesh.php?step=busqueda2&moditobusqueda=especial&esframe=1&","frame_bajo",380,"boton",50004); 	
		}
		
		
		
		
	  if($boton_notas==1) 
		$botones_peque.=haceboton_menu_peque("Notas","notas_frame.php?modo=externo&pagina=1","frame_bajo",250,"boton",50000);
	  if($boton_fotos==1) 
		$botones_peque.=haceboton_menu_peque("Subir archivos","subirimagenes.php?","frame_bajo",380,"boton",50001); 
		//$botones_peque.=haceboton_menu_peque("Subir archivos","include/guardarimagenes/subirimagenes.php?","frame_bajo",380,"boton",50001);
	
	  if($boton_idiomas==1)
	  {
	      $botones_peque.="<td style=\"width:50px\"></td>";
	  	 $resultx = @mysqli_query($GLOBALS["enlaceDB"] ,"select id,nombreidioma from idiomas where activo=1 order by id");
 		 while($rowx = mysqli_fetch_array($resultx))
		 {
		 	$urlidioma="step=add&idioma=".$rowx["id"]."&registro=".$id;
		    $resultx1 = @mysqli_query($GLOBALS["enlaceDB"] ,"select id from ".$tablaidiomas." where iidioma=".$rowx["id"]." and iregistro=".$id);
  			while($rowx1 = mysqli_fetch_array($resultx1)) 
				$urlidioma="step=modify&&idioma=".$rowx["id"]."&id=".$rowx1["id"];
			
		   $botones_peque.=haceboton_menu_peque($rowx["nombreidioma"],$tablaidiomas.".php?esframe=1&".$urlidioma,"frame_bajo",380,"boton",60000+$rowx["id"]); 		   
		 }  
	  }  
  } 
  
  $tarchivo_inferior="include/imenu_peque_espere.html";
  
	if($menupeque==1) 
	{
		$complemento="";
		if($botones_peque<>"") 
		{ 
			$botones_peque.="<td></td>";
			$botones_peque=haceboton_menu_peque("General","","frame_bajo",$alturamenupeque,"boton",0).$botones_peque;
			$tbotones_peque=$botones_peque;
		}
		$mostrar="none";
		
		
	}
	else if($menupeque==3)
	{
		$tarchivo_inferior=$archivo_inferior;
		$tbotones_peque="";
		$complemento=$menupeque;
		$mostrar="block";
	}		
	else 
	{ 
		$complemento=$menupeque; 
		$tbotones_peque=""; 
		$mostrar="none";
	}
	
	if($archivoactual=="ebrigadas_prueba.php") $scroll="auto";
	else $scroll="no";
	
	/*if($menupeque==2 && $_SESSION["frame_interior_".$archivoactual]=="add") // agregar despues de agregar
	{
		$tarchivo_inferior=$archivoactual."?step=add&".$url_extra;
		$_SESSION["frame_interior_".$archivoactual]="";
		$tbotones_peque="";
		$mostrar="block";
		
	}*/
	
	/*
	if(($menupeque==1 && $tbotones_peque<>"" && $step=="modify") || $menupeque==2 || ($menupeque==3 && $archivo_inferior<>"") )  
	{
		
		if($tarchivo_inferior<>"" && ($menupeque==2 ||$menupeque==3)) echo("<table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td id=\"celdina".$menupeque."\" name=\"celdina".$menupeque."\" style=\"display:".$mostrar."; background-image:url(recursos/indicador.png); background-repeat:no-repeat; height:100px;\"><br>&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br></td><td width=100%>");
		echo("<a name=\"FRAMESITO".$menupeque."\"></a>");
		echo("<table class=textogeneral border=0 cellpadding=0 cellspacing=0>");
		if($tbotones_peque<>"") echo("<tr height=16>".$tbotones_peque."<td></td></tr>");
		else echo("<tr height=5><td></td></tr>");
		echo("</table>");
		
		if($menupeque==1) { $left=""; $clase=" class=\"bordeprincipal\" "; $right="padding-left:5px;";}
		else if($menupeque==3) { $left="style=\"padding-left:-10px;\""; $clase=" class=\"bordeprincipal\" "; $right="padding-left:5px;";}
		else {  $left="style=\"padding-left:-10px;\""; $clase==""; $right="padding-left:1px;";}
		
		if($mostrar=="block" && $step=="add") $mostrar="none";
echo("<div align=\"right\"".$left."><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"".$clase."name=\"frame_bajo_tabla".$complemento."\" id=\"frame_bajo_tabla".$complemento."\" style=\"display:".$mostrar."; width:100%; padding-top:5px; padding-left:5px;\"> <tr>
<td style=\" width:100%\">
<iframe id=\"frame_bajo".$complemento."\" name=\"frame_bajo".$complemento."\" src=\"".$tarchivo_inferior."\" style=\"width:100%; border:none; display:".$mostrar.";\" scrolling=\"".$scroll."\" frameborder=\"0\"></iframe>
</td><td valign=top style=\"".$right."\"></td></tr></table></div>");
		if($tarchivo_inferior<>"" && ($menupeque==2 ||$menupeque==3)) echo("</td></tr></table>");
	}*/
	
	if(($menupeque==1 && $tbotones_peque<>"" && $step=="modify") || $menupeque==2 || ($menupeque==3 && $archivo_inferior<>"") )  
	{
		
		if($tarchivo_inferior<>"" && ($menupeque==2 ||$menupeque==3)) echo("<br clear=all><table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td id=\"celdina".$menupeque."\" name=\"celdina".$menupeque."\" style=\"display:".$mostrar."; background-image:url(recursos/indicador.png); background-repeat:no-repeat; height:100px;\"><br>&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br></td><td width=100%>");
		echo("<a name=\"FRAMESITO".$menupeque."\"></a>");
		echo("<table class=textogeneral border=0 cellpadding=0 cellspacing=0>");
		if($tbotones_peque<>"") echo("<tr height=16>".$tbotones_peque."<td></td></tr>");
		else echo("<tr height=5><td></td></tr>");
		echo("</table>");
		
		if($menupeque==1) { $left=""; $clase=" class=\"bordeprincipalframe\" "; $right="padding-left:5px;";}
		else if($menupeque==3) { $left="style=\"padding-left:-10px;\""; $clase=" class=\"bordeprincipalframebajo\" "; $right="padding-left:5px;";}
		else {  $left="style=\"padding-left:-10px;\""; $clase==""; $right="padding-left:1px;";}
		if($menupeque==3) echo("<br>");
echo("<div align=\"left\"".$left."><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"".$clase."name=\"frame_bajo_tabla".$complemento."\" id=\"frame_bajo_tabla".$complemento."\" style=\"display:".$mostrar."; width:100%; padding-top:5px; padding-left:5px;\"> <tr>
<td style=\"width:100%\">
<iframe id=\"frame_bajo".$complemento."\" name=\"frame_bajo".$complemento."\" src=\"".$tarchivo_inferior."\" style=\"width:100%; border:none; display:".$mostrar.";\" scrolling=\"".$scroll."\" frameborder=\"5\"></iframe>
</td><td valign=top style=\"".$right."\"></td></tr></table></div>");
		if($tarchivo_inferior<>"" && ($menupeque==2 ||$menupeque==3)) echo("</td></tr></table>");
	}


?>

