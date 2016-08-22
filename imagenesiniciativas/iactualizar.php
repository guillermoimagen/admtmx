<?
if($_SESSION["firmado"]) // solo si estas firmado
{
	if($_POST["tuemail"]=="")
	{
		if($idioma==0) $mensajeError="Proporciona un email";
		else  $mensajeError="Please provide an email";
	}
	else if(!filter_var($_POST["tuemail"], FILTER_VALIDATE_EMAIL))
	{
		if($idioma==0) $mensajeError="Proporciona un email v&aacute;lido";
		else  $mensajeError="Please provide a valid email";
	}
	else {
		// busquemos si ya existe el email
		$mensajeError="select emailusuario,nombreusuario,nickusuario,id from usuarios where emailusuario='".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["tuemail"])."' and id<>".$_SESSION["logged"]->id;
		
		$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario,nickusuario,id from usuarios where emailusuario='".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["tuemail"])."' and id<>".$_SESSION["logged"]->id);
		if(mysqli_num_rows($res)>0) // ya existe, vamos a iniciar parcial
		{
			while($row=mysqli_fetch_object($res))
			{
				if($idioma==0) $mensajeError="El email proporcionado ya est&aacute; en uso. Proporciona otro";
				else  $mensajeError="The email name provided is already in use. Provide a new one";
			}
		}
		else // no existe
		{
			if($_POST["tunombre"]=="" || $_POST["tuapodo"]=="")
			{
				if($idioma==0) $mensajeError="Debes proporcionar tu nombre y nombre de usuario";
				else $mensajeError="Please provide your name and nickname";
			}
			else
			{			
				$res2=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreusuario from usuarios where nickusuario='".mysqli_real_escape_stringMemo($_POST["tuapodo"])."' and id<>".$_SESSION["logged"]->id);
				if(mysqli_num_rows($res2)>0) // ya existe el nick
				{
					if($idioma==0) $mensajeError="El nombre de usuario proporcionado ya est&aacute; en uso. Proporciona otro";
					else  $mensajeError="The nick name provided is already in use. Provide a new one";
				}
				else // vamos a crearlo
				{
					if(@mysqli_query($GLOBALS["enlaceDB"] ,"update usuarios set emailusuario='".mysqli_real_escape_stringMemo($_POST["tuemail"])."',nombreusuario='".mysqli_real_escape_stringMemo($_POST["tunombre"])."',nickusuario='".mysqli_real_escape_stringMemo($_POST["tuapodo"])."' where id=".$_SESSION["logged"]->id))
					{
						
					}
					else 
					{
						if($idioma==0) $mensajeError="Ocurri&oacute; un error desconocido.";
						else  $mensajeError="An unknown error ocurred.";
					}
				}
			}
			
		}
	}
}
?>