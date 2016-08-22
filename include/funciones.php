<? 
   
//Obtiene ruta actual
if($_SERVER['QUERY_STRING']=="") $completaurl="";
else $completaurl="?".$_SERVER['QUERY_STRING'];
$rutaarch=$_SERVER['PHP_SELF'].$completaurl;
$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$archivoActual = basename($_SERVER["SCRIPT_FILENAME"], '.php');

$fechahoy=date("Y-m-d");      // lee la fecha y hora
$horaactual=date("H:i");
//Para encuestas
$meshoy=date("m");
$fechahoy=date("Y-m-d");      // lee la fecha
$anohoy=date("Y");
$diahoy=round(date("d"));
$anoinicial=1990;
$anofinal=$anohoy;
$diahoy_letra=date("N");

$resolucionActual = ""; // __mr o vacio 
// leamos la plataforma	
if(isset($_GET["plataforma"])) 
	$_SESSION["plataforma"]=$_GET["plataforma"];
if(!isset($_SESSION["plataforma"])) 
	$_SESSION["plataforma"]="mobile";

if($_SESSION["plataforma"]<>"mobile" && $_SESSION["plataforma"]<>"wap") $_SESSION["plataforma"] = "mobile";
if($_SESSION["plataforma"]=="mobile") $resolucionActual ="";
else if($_SESSION["plataforma"]=="wap") $resolucionActual ="__m";
else if($_SESSION["plataforma"]=="mobileretina") $resolucionActual ="@2x";




// FUNCIONES DE SEGURIDAD
function valores_numericos ($valor, $num)	
{
	global $urlabsoluta,$modoConsulta;
	if($valor <> NULL)
	{
		if (! preg_match("/^[0-9]{0,$num}$/i",$valor))	
		{
			
			exit ();
		}
	}
}
function valores_texto ($valor,$num)
{
	global $urlabsoluta,$modoConsulta;
	if (! preg_match("/^[a-zA-Z0-9\-_]{0,$num}$/i",$valor))	
	{
		if($modoConsulta<>"API") header('Location: '.$urlabsoluta);
		exit ();
	}	
}
function no_none($campo)
{
	global $urlabsoluta,$modoConsulta;
	if(isset($_GET[$campo])) 
	{
		if($modoConsulta<>"API") header('Location: '.$urlabsoluta);
		exit ();
	}
	else if(isset($_POST[$campo])) 
	{
		if($modoConsulta<>"API") header('Location: '.$urlabsoluta);
		exit ();
	}
}

// para xss injection
foreach ($_GET as $check_url) 
{
	if (( preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/\"/i", $check_url)) || ( preg_match("/\'/i", $check_url))) 
	{
		if($modoConsulta<>"API") header('Location: '.$urlabsoluta);
		exit ();
	}
}
foreach ($_POST as $check_url) 
{
	if (( preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || ( preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
	( preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) )
	{		
		if($modoConsulta<>"API") header('Location: '.$urlabsoluta);
		exit ();
	}
}

// definir aqui las variables que tenemos que restringir
valores_texto($_POST["step"],8);
no_none("idparticipante");	


function convierte_url($titulo,$complemento)
{
	$inaceptables=array(":", ".", "/", "?", "¿", "¡", "!", "%", "&", "(", ")", "{", "}", "\'", "\"");
	$titulo=str_replace($inaceptables,"",$titulo);
	return str_replace(" ","-",$titulo)."-".$complemento.".html";
}

// 0 Alta, 1 Cambio, 2 Baja
function bitacora($tabla,$usuario,$registro,$operacion,$tablaNombre)
{
	if($tabla==0)
	{
		$resultx=@mysqli_query($GLOBALS["enlaceDB"] ,"select * from catablas where ayudatabla='".$tablaNombre."'");
		while($rowx=mysqli_fetch_array($resultx))
			$tabla=$rowx["idtabla"];	
	}
	if($tabla<>0)	
		@mysqli_query($GLOBALS["enlaceDB"] ,"insert into bit set itablabit=".$tabla.",iusuariobit=".$usuario.",registrobit=".$registro.",operacionbit='".$operacion."'");	
}


function sumarFecha($fecha,$diaSuma)
{
	$nuevafecha = strtotime ("+".$diaSuma." day" , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	return $nuevafecha;
}

function diaSemana($fecha)  
{
	$fecha_real=explode("-",$fecha);
	$dia=$fecha_real[0];
	$mes=$fecha_real[1];
	$ano=$fecha_real[2];
	
	$diaEnvio= date("w",mktime(0, 0, 0, $mes, $dia, $ano));#Obtenemos el numero del dia de la semana de la notificacion
	$diaActual=date("w",mktime(0, 0, 0,date("m"),date("d"),date("Y")));#Obtenemos el numero del dia de la semana del dia Actual
	$fecha_envio=$ano."-".$mes."-".$dia;#Fecha en que se envia
	$fecha_hoy=date("Y-m-d");#Fecha en que se envia
	$hora_minima="700";#Hora Minima Permitida para enviar notificaciones Globales y Normales, en formato de 24 hrs
	$hora_maxima="2000";#Hora Maxima Permitida para enviar notificaciones Globales y Normales, en formato de 24 hrs
	$horaActual=date("H:i");#Hora en que se envia 
	$horaActualMilitar=str_replace(":","",$horaActual);
	
	#Sabado
	if($diaActual==6){
		
		
		for($dia=1;$dia<=2;$dia++){
			$rango[]=sumarFecha($fecha_hoy,$dia);
		}
		if(in_array($fecha_envio,$rango)){
			
			$error["fecha"]="Le recordamos que las notificaciones para los días Sabado, Domingo y Lunes, deben ser enviadas a mas tardar los días Viernes para su validación.";
		}else{
			$error["fecha"]="";
		}
	}else if($diaActual==7){#Domingo
		$rango[]=sumarFecha($fecha_hoy,1);
		if(in_array($fecha_envio,$rango)){
			$error["fecha"]="Le recordamos que las notificaciones para los días Sabado, Domingo y Lunes, deben ser enviadas a mas tardar los días Viernes para su validación.";
		}else{
			$error["fecha"]="";
		}
	}
	#Si el dia que se quiere enviar es el día de hoy 
	if($fecha_envio==date("Y-m-d")){
		$error["fecha"]="La fecha que ha selecciondado corresponde a la del día de hoy, recuerde que el tiempo de validación es de un día.";
		if($horaActualMilitar>=$hora_minima && $horaActualMilitar<=$hora_maxima){
					$error["hora"]="";
				}else{
					$error["hora"]="Le recordamos que el horario para el envio de notificaciones es de  7:00 a 20:00.";
		}
	}else{
		if($diaActual>=1 && $diaActual<=5){
			$error["fecha"]="";
			$suma_fecha=sumarFecha($fecha_hoy,1);
			if($suma_fecha==$fecha_envio){
				if($horaActualMilitar>=$hora_minima && $horaActualMilitar<=$hora_maxima){
					$error["hora"]="";
				}else{
					$error["hora"]="Le recordamos que el horario para el envio de notificaciones es de  7:00 a 20:00.";
				}
			}else{
				$error["hora"]="";
			}
		}else{
			$error["hora"]="";
		}
	}
	
	
	return $error;
}

function leecampos($tabla,$campo1,$campo2,$campo3,$campo4,$separador,$campocondicional,$valorcampocondicional, $indicador)
{
	global $campos1;
	global $campos2;
	global $idcampo;
	global $archivoactual,$step;
	global $id,$isitio;
  
	global $registros;
  
	$campos1 = array();
	$campos2 = array();
	$idcampo = array();
	$registros=0;
 
	$cadena="";
	if($campo1<>"") $cadena=$cadena.$campo1;
	if($campo2<>"") $cadena=$cadena.",".$campo2;
	if($campo3<>"") $cadena=$cadena.",".$campo3;
	if($campo4<>"") $cadena=$cadena.",".$campo4;
	$cadena2=$campo2;
	if($campo3<>"") $cadena2=$cadena2.",".$campo3;
	if($campo4<>"") $cadena2=$cadena2.",".$campo4;
	
	if($tabla=="dcontacto")
	{
		$campocondicional="isitiodcontacto";
		$valorcampocondicional=$isitio;	
	}

	if($indicador==1){
		if($campocondicional<>"" && isset($campocondicional) )
			$result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where ".$campocondicional."=".$valorcampocondicional." order by ".$cadena2);
		else   
			$result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." order by ".$cadena2);
	}else{
		if($campocondicional<>"" && isset($campocondicional) )
			$result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where ".$campocondicional."=".$valorcampocondicional." and activo='1' order by ".$cadena2);
		else   
			$result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where activo='1' order by ".$cadena2);	
	}	
	while ( $row2 = mysqli_fetch_array($result2) )
	{	
		$campos1[$registros] = $row2[$campo1];
		$campos2[$registros] = htmlspecialchars($row2[$campo2].$separador.$row2[$campo3].$separador.$row2[$campo4]);
		$registros=$registros+1;
	}  
}

function formatoFecha($fecha){
	$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
	$meses = array("","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
	$diaT = date("w", strtotime($fecha));
	$dia = date("j", strtotime($fecha));
	$mesT = date("n", strtotime($fecha));
	$anio = date("Y", strtotime($fecha));

	return $dias[$diaT]." ".$dia." de ".$meses[$mesT]." del ".$anio;
}
?>