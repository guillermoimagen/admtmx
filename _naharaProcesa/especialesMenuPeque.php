<?
if($archivoactual=="acu.php" && $_GET["campoEspecial"]=="si")
{
	if($_SESSION["esframe_acu"]==1)
	{  
		if($_SESSION["esframe_acu_archivo"]=="usuarios")  
		{    
			if($step=="add") 
			{ 
				$iusuario2acu=$_SESSION["id_usuarios"]; 
				$iusuario1acu=0; 
			}
			if($step=="busqueda2" || $step=="busqueda3" || $step=="1")   
			{      
				$iusuario2acub1="=";      
				$iusuario2acub2=$_SESSION["id_usuarios"];    
				$iusuario1acub1="";      
				$iusuario1acub2=0;    
			}  
		}
	}
}
else if($archivoactual=="don.php" && $_GET["campoEspecial"]=="si")
{
	if($_SESSION["esframe_don"]==1)
	{  
		if($_SESSION["esframe_don_archivo"]=="usuarios")  
		{    
			if($step=="add") 
			{ 
				$iusuariodon=$_SESSION["id_usuarios"]; 
				$iusuariodonodon=0; 
			}
			if($step=="busqueda2" || $step=="busqueda3" || $step=="1")   
			{      
				$iusuariodonb1="=";      
				$iusuariodonb2=$_SESSION["id_usuarios"];    
				$iusuariodonodonb1="";      
				$iusuariodonodonb2=0;    
			}  
		}
	}
}
?>