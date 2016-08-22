<?
$permiso=0;
if(($nivelusuario==0 || $nivelusuario==1 || $nivelusuario==2 || $nivelusuario==3) &&
	 (
		 ($nombrecampo=="textocont" && $nombretabla=="cont") || 
		 ($nombrecampo=="i_textocont" && $nombretabla=="cont") || 
		 ($nombrecampo=="textonoti" && $nombretabla=="noti") || 
		 ($nombrecampo=="i_textonoti" && $nombretabla=="noti") 
	 )) 
	 {
	 	$permiso=1;
	 }
	 else exit();
?>
