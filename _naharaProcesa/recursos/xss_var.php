<?


// checa todas la variables que vengan por url... que no contenca las palabras <script><object><ifram>, 
// para xss injection
foreach ($_GET as $check_url) 
{
	if (( preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/\"/i", $check_url)) || ( preg_match("/\'/i", $check_url))) 
	{
		echo "no valido g";
		//if($modoConsulta<>"API") header('Location: '.$urlabsoluta);
		exit ();
	}
}
foreach ($_POST as $check_url) 
{
	if($revisarStrong=="no")
	{
		if (( preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
		( preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
		( preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) ||
		( preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) )
		{		
			echo "no valido p";
			//if($modoConsulta<>"API") header('Location: '.$urlabsoluta);
			exit ();
		}
	}
	else
	{
		
	}
}
unset($check_url);

function valores_numericos ($valor, $num)
{
	if($valor<>"" && $valor<>"0")
	{
		if (!preg_match("/^[1-9][0-9]{0,".$num."}$/",$valor))	
		{
			echo "VALOR NO VALIDO";	
			exit ();
		}
	}
}

function valores_texto ($valor,$num)
{
	if (!preg_match("/^[a-zA-Z0-9\-_]{0,".$num."}$/",$valor))	
	{
		
		echo "VALOR NO VALIDO";	
		exit ();
	}	
}

function no_get($campo)
{
	if(isset($_GET[$campo])) 
	{
		echo "VALOR NO VALIDO";	
		exit ();
	}
}

function no_post($campo)
{
	if(isset($_POST[$campo])) 
	{
		echo "VALOR NO VALIDO";	
		exit ();
	}
}

function no_none($campo)
{
	if(isset($_GET[$campo])) 
	{
		echo "VALOR NO VALIDO";	
		exit ();
	}
	else if(isset($_POST[$campo])) 
	{
		echo "VALOR NO VALIDO";	
		exit ();
	}
}
if(isset($_GET["id"])) valores_numericos($_GET["id"],6);
if(isset($_POST["id"])) valores_numericos($_POST["id"],6);
if(isset($_GET["idbuscado"])) valores_numericos($_GET["idbuscado"],6);
if(isset($_POST["idbuscado"])) valores_numericos($_POST["idbuscado"],6);
if(isset($_GET["idcontrol"])) valores_numericos($_GET["idcontrol"],25);
if(isset($_POST["idcontrol"])) valores_numericos($_POST["idcontrol"],25);

// nuevos
if(isset($_GET["esframe"])) valores_numericos($_GET["esframe"],2);
if(isset($_GET["edicioninterior"])) valores_numericos($_GET["edicioninterior"],2);
if(isset($_GET["itabla"])) valores_numericos($_GET["itabla"],3);
if(isset($_GET["registro"])) valores_numericos($_GET["registro"],10);
if(isset($_GET["tablabusqueda"])) valores_numericos($_GET["tablabusqueda"],5);
if(isset($_GET["registrobusqueda"])) valores_numericos($_GET["registrobusqueda"],12);
if(isset($_GET["iusuariocom"])) valores_numericos($_GET["iusuariocom"],12);
if(isset($_GET["iretcom"])) valores_numericos($_GET["iretcom"],12);
if(isset($_GET["iretcret"])) valores_numericos($_GET["iretcret"],12);
if(isset($_GET["icatcru"])) valores_numericos($_GET["icatcru"],12);
if(isset($_GET["iusuariocru"])) valores_numericos($_GET["iusuariocru"],12);
if(isset($_GET["iretocru"])) valores_numericos($_GET["iretocru"],12);
if(isset($_GET["ipaisestado"])) valores_numericos($_GET["ipaisestado"],12);
if(isset($_GET["iusuariogus"])) valores_numericos($_GET["iusuariogus"],12);
if(isset($_GET["iretgus"])) valores_numericos($_GET["iretgus"],12);
if(isset($_GET["iusuarioret"])) valores_numericos($_GET["iusuarioret"],12);
if(isset($_GET["irettra"])) valores_numericos($_GET["irettra"],12);
if(isset($_GET["iusuariotra"])) valores_numericos($_GET["iusuariotra"],12);
if(isset($_GET["sel1"])) valores_numericos($_GET["sel1"],12);
if(isset($_GET["sel2"])) valores_numericos($_GET["sel2"],12);
if(isset($_GET["sel3"])) valores_numericos($_GET["sel3"],12);
if(isset($_GET["sel4"])) valores_numericos($_GET["sel4"],12);
if(isset($_GET["campoEspecial"])) valores_texto($_GET["campoEspecial"],5);
if(isset($_GET["urlOrigen"])) valores_texto($_GET["urlOrigen"],5);

// hubo dudas
if(isset($_GET["idioma"])) valores_numericos($_GET["idioma"],10);
if(isset($_GET["modo"])) valores_texto($_GET["modo"],20); // seguro es string. checar otras posbilidades
if(isset($_GET["arbol"])) valores_numericos($_GET["arbol"],12);


if(isset($_POST["step"])) valores_texto($_POST["step"],17);
if(isset($_GET["step"])) valores_texto($_GET["step"],17);
if(isset($_POST["operacion"])) valores_texto($_POST["operacion"],12);
if(isset($_GET["operacion"])) valores_texto($_GET["operacion"],12);
if(isset($_POST["moditobusqueda"])) valores_texto($_POST["moditobusqueda"],8);
if(isset($_GET["moditobusqueda"])) valores_texto($_GET["moditobusqueda"],8);
if(isset($_POST["password"])) valores_texto($_POST["password"],32);
if(isset($_POST["username"])) valores_texto($_POST["username"],32);

// las que de plano no pueden llegar
no_get("password");
no_get("logged");
no_get("username");
no_none("sesionusername");
no_none("sesionnombre");
no_none("nivelusuario");
no_none("sesionid");
no_none("sesionhits");
no_none("sitioactual");
no_none("sesionidregistro");
no_none("nivelusuario_sitio");
no_none("nivelusuario_reservas");
no_none("sitioactual_directo");
no_none("sitioactual_real");




?>