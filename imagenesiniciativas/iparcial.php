<?
if(!$_SESSION["firmado"]) // esto solo funciona cuando no estás firmado
{
		require_once 'include/recaptcha/src/autoload.php';
		$secret="6LfiKyYTAAAAAMdeWIEb66T45feJkxTN_A6CMRGU";
		$recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());
		$result2 = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		if (!$result2->isSuccess())
		{ 
			if($idioma==0) $mensajeError="Por favor verifica que no eres un robot";
			else  $mensajeError="Please verify that you are not a robot";
		}
		else
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
				$res=@mysqli_query($GLOBALS["enlaceDB"] ,"select emailusuario,nombreusuario,nickusuario,id from usuarios where emailusuario='".mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$_POST["tuemail"])."'");
				if(mysqli_num_rows($res)>0) // ya existe, vamos a iniciar parcial
				{
					while($row=mysqli_fetch_object($res))
					{
						$_SESSION["loggedParcial"]->nombreusuario=htmlentitiesMemoStrong($row->nombreusuario);
						$_SESSION["loggedParcial"]->nickusuario=htmlentitiesMemoStrong($row->nickusuario);
						$_SESSION["loggedParcial"]->emailusuario=htmlentitiesMemoStrong($row->emailusuario);
						$_SESSION["loggedParcial"]->id=$row->id;
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
						$res2=@mysqli_query($GLOBALS["enlaceDB"] ,"select nombreusuario from usuarios where nickusuario='".mysqli_real_escape_stringMemo($_POST["tuapodo"])."'");
						if(mysqli_num_rows($res2)>0) // ya existe el nick
						{
							if($idioma==0) $mensajeError="El nombre de usuario proporcionado ya est&aacute; en uso. Proporciona otro";
							else  $mensajeError="The nick name provided is already in use. Provide a new one";
						}
						else // vamos a crearlo
						{
							if(@mysqli_query($GLOBALS["enlaceDB"] ,"insert into usuarios set emailusuario='".mysqli_real_escape_stringMemo($_POST["tuemail"])."',nombreusuario='".mysqli_real_escape_stringMemo($_POST["tunombre"])."',nickusuario='".mysqli_real_escape_stringMemo($_POST["tuapodo"])."',validadousuario='2'"))
							{
								$_SESSION["loggedParcial"]->nombreusuario=htmlentitiesMemoStrong($_POST["tunombre"]);
								$_SESSION["loggedParcial"]->nickusuario=htmlentitiesMemoStrong($_POST["tuapodo"]);
								$_SESSION["loggedParcial"]->emailusuario=htmlentitiesMemoStrong($_POST["tuemail"]);
								$_SESSION["loggedParcial"]->id=mysqli_insert_id($GLOBALS["enlaceDB"] );
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
}
?>