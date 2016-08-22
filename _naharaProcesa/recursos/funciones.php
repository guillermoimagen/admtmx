<?  

$meses= array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$dias_agenda= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sebado");
$dias= array("Sa","Do","Lu","Ma","Mi","Ju","Vi");


error_reporting(0);

// V3 VARIABLES GLOBALES 
if(isset($_GET["step"])) $step=htmlentitiesMemo2Strong($_GET["step"]);
else if(isset($_POST["step"])) $step=htmlentitiesMemo2Strong($_POST["step"]);

if(isset($_POST["operacion"])) $operacion=htmlentitiesMemo2Strong($_POST["operacion"]);
else if(isset($_GET["operacion"])) $operacion=htmlentitiesMemo2Strong($_GET["operacion"]);

if(isset($_POST["id"])) $id=(int)$_POST["id"];
else if(isset($_GET["id"])) $id=(int)$_GET["id"];

if(isset($_POST["idbuscado"])) $idbuscado=(int)$_POST["idbuscado"]; 

if(isset($_POST["idcontrol"])) $idcontrol=htmlentitiesMemo2Strong($_POST["idcontrol"]);
else if(isset($_GET["idcontrol"])) $idcontrol=htmlentitiesMemo2Strong($_GET["idcontrol"]);

if(isset($_POST["moditobusqueda"])) $moditobusqueda=htmlentitiesMemo2Strong($_POST["moditobusqueda"]);
else if(isset($_GET["moditobusqueda"])) $moditobusqueda=htmlentitiesMemo2Strong($_GET["moditobusqueda"]);

if(isset($_POST["ocultabotones"])) $ocultabotones=htmlentitiesMemo2Strong($_POST["ocultabotones"]);
else if(isset($_GET["ocultabotones"])) $ocultabotones=htmlentitiesMemo2Strong($_GET["ocultabotones"]);

foreach($_GET as $key => $value)
{
	if($value<>"<>" && $value<>"<" && $value<>">" && $value<>"<=" && $value<>"=>")
	  $_GET[$key]=mysqli_real_escape_string2Memo($value);
}

if($revisarStrong<>"no")
{
	foreach($_POST as $key => $value)
	{
		if($value<>"<>" && $value<>"<" && $value<>">" && $value<>"<=" && $value<>"=>")
  			$_POST[$key]=mysqli_real_escape_string2Memo($value);
	}
}

// tablas que filtraremos por ciudad
$tablasFiltradas=array(); // "cad","cat","scat",

if(isset($_GET["mododepuracion"]) && $sesionid==1) $_SESSION["sesionmododepuracion"]=$_GET["mododepuracion"];
// V3 variables generales, no cambiar
$error=0;
if(isset($_GET['nivelusuario']) || isset($_POST['nivelusuario'])) { die("El servidor no responde"); }
$mensaje=""; 
$fechahoy=date("Y-m-d");      // lee la fecha
$horaactual=date("H:i");
$diahoy=date("d");
$meshoy=date("m");
$anohoy=date("Y");
$error_unique=0;
$registrosencontrados=1;


// V4 DEL SISTEMA
function hace_boton_busquedav3($archivo,$texto1,$texto2,$link)
{
	global $url_extra;
	$extratitulo="";
	if($texto2<>"") $extratitulo=" de ".$texto2;
	echo("&nbsp;&nbsp;&bull;&nbsp;<a href=\"".$archivo.".php?".$url_extra."&step=busqueda2&moditobusqueda=especial&".$link."&titulobusqueda=Mostrando: ".urlencode($texto1.$extratitulo)."&\" class=textogeneral>".$texto1."</a><br>");	
}

function hace_boton_edicionv3($archivo,$id,$texto)
{
	echo("&nbsp;&nbsp;&bull;&nbsp;<a href=\"".$archivo.".php?step=modify&id=".$id."&\" class=textogeneral>".$texto."</a><br>");		
}
function hace_boton_v3($url,$texto)
{
	echo("&nbsp;&nbsp;&bull;&nbsp;<a href=\"".$url."&\" class=textogeneral>".$texto."</a><br>");		
}

function hace_boton_agregarv3($archivo,$link,$texto)
{
	echo("&nbsp;&nbsp;&bull;&nbsp;<a href=\"".$archivo.".php?step=add&".$link."&\" class=textogeneral>".$texto."</a><br>");		
}

function haceboton_menu($textoboton,$url,$estadoboton,$submenuuu)
{

       $variableid = "";
       if($submenuuu != "")
                         $variableid = " id='$textoboton' onmouseover='javascript:muestraSubmenuTop(id);' onmouseout='javascript:ocultaSubmenuTop(id);'";?>

	   <div <?=$variableid?> class="contMenu" style="float:left;"><a href="<?=$url?>" title="" class="nivel1"><div class="<?=$estadoboton?>Izq izqBoton">&nbsp;</div><div class="<?=$estadoboton?>Centro centroBoton"><?=$textoboton?></div><div class="<?=$estadoboton?>Der derBoton">&nbsp;</div></a><br clear="all" /><?=$submenuuu?></div><?
}

function haceboton_menu_peque($textoboton,$url,$target,$altura,$modo,$idboton)
{
	global $total_botones_peque,$id,$numerodetabla,$idcontrolinterno,$archivoactual,$url_extra;
	$total_botones_peque++;
	
	$url.="&itabla=".$numerodetabla."&registro=".$id."&idcontrol=".$idcontrolinterno."&";
	
	$valor_boton="";
	if($idboton==0) // es el boton General
	{
		$estilo="boton_peque_seleccionado";	
		$valor_boton="<td id=\"boton_peque_".$idboton."\" class=\"".$estilo."\"><a href=\"".$archivoactual."?step=modify&id=".$id."&".$url_extra."\" class=\"boton_peque_texto\"><b>".$textoboton."</b></a></td><td width=\"1\"></td>";
	}	
	else 
	{
		$estilo="boton_peque_normal";
		if($modo=="boton")
		{
			if($target=="_blank")
				$valor_boton="<td id=\"boton_peque_".$idboton."\" class=\"".$estilo."\"><a href=\"".$url."',".$altura.",".$idboton.",'".$textoboton."\" class=\"boton_peque_texto\" target='_blank'><b>".$textoboton."</b></a></td><td width=\"1\"></td>";
			else
				$valor_boton="<td id=\"boton_peque_".$idboton."\" class=\"".$estilo."\"><a href=\"javascript:carga_sub('".$url."',".$altura.",".$idboton.",'".$textoboton."');\" class=\"boton_peque_texto\"><b>".$textoboton."</b></a></td><td width=\"1\"></td>";
		}
		else
			$valor_boton="<script>window.onload=carga_sub('".$url."',".$altura.",".$idboton.",'".$textoboton."');</SCRIPT>";
	}		
	return $valor_boton;
}

//busca un solo valor de la tabla enviada
function devuelve_campo($tabla,$id,$campo)
{
	$resultt = @mysqli_query($GLOBALS["enlaceDB"] ,"select ".$campo." from ".$tabla." where id=".$id);
	while($rowt = mysqli_fetch_array($resultt))  return $rowt[$campo];
}
// V3 para definiri si todo el sistema guardara los datos en mayusculas, 0 es si 1 es no
// no es conveniente, porque tambi�n las im�genes se hacen may�sculas, es bueno para sistemas, no para sitios
$todoelsitioenmayusculas=0; 

// V3 variables para mensajes
$entradamensaje="<span class=\"textogeneral\"><br></span><table align=\"left\"><tr><td class=\"spacerlateral\"></td><td class=\"textomensaje\">";
$entradamensajeerror="<span class=\"textogeneral\"><br></span><table align=\"left\"><tr><td class=\"spacerlateral\"></td><td class=\"textomensajeerror\">";
$entradamensajenada="<span class=\"textogeneral\"><br></span><table align=\"left\"><tr><td class=\"spacerlateral\"></td><td class=\"textomensajenada\">";
$salidamensaje="</td><td class=\"spacerlateral\"></td></tr><tr><td style=\"height:10px;\"></td></tr></table><span class=\"textogeneral\"><br clear='all'></span>";

function muestra_mensaje($mensaje,$modomensaje)
{
	global $entradamensajeerror,$entradamensaje,$entradamensajenada,$salidamensaje;
	if($modomensaje=="ERROR") echo($entradamensajeerror.$mensaje.$salidamensaje); 
	else if($modomensaje=="NADA") echo($entradamensajenada.$mensaje.$salidamensaje); 
	else echo($entradamensaje.$mensaje.$salidamensaje); 
}

// V3
function limpia_numero($valorcadena)
{
	$valorcadena=str_replace("$","",$valorcadena);
	  $valorcadena=str_replace(",","",$valorcadena);
	  $valorcadena=str_replace("%","",$valorcadena);	
	  return $valorcadena;
}

function construyesqltemporal($campo,$comilla,$mayusculas)
{
  global $sqltemporal,$todoelsitioenmayusculas,$tablasFiltradas,$archivoactual;
  
  $cadenaentregada="";
  if(isset($_POST[$campo]))
  {    
    if($sqltemporal<>"") $cadenaentregada=",";
	$valorcadena=$_POST[$campo];
	if($mayusculas==2)
	{
	  $valorcadena=str_replace("$","",$valorcadena);
	  $valorcadena=str_replace(",","",$valorcadena);
	  $valorcadena=str_replace("%","",$valorcadena);
	}	
	if($todoelsitioenmayusculas==1 || $mayusculas==1) $valorcadena=strtoupper($valorcadena);
    $cadenaentregada.=$campo."=".$comilla.$valorcadena.$comilla; 
	
	
  }  

  if($campo=="activo" && ($archivoactual<>"causuarios.php" || ($archivoactual=="causuarios.php" && $_SESSION["superusuario"]<>1)))
	{
		$tablaActual=substr($archivoactual,0,strlen($archivoactual)-4);
		if (in_array($tablaActual, $tablasFiltradas))
			 $cadenaentregada.=",iciudad=".$_SESSION["ciudadactual"];
	}
  
  return $cadenaentregada;
}
// V3 construyecamposbuscadoslistadosearch
function cbusqueda1($campol1,$tabla,$campo1,$numero,$campo2,$campo3)
{
  global $camposbuscadoslistadosearch;
  
  if($campol1=="on") 
  {
    if($numero==0) 
	{
	  $camposbuscadoslistadosearch.=",".$tabla.".".$campo1;
	  if($campo2<>"") $camposbuscadoslistadosearch.=",".$tabla.".".$campo2;
	  if($campo3<>"") $camposbuscadoslistadosearch.=",".$tabla.".".$campo3;
	}
	else
	{
	  $camposbuscadoslistadosearch.=",".$tabla.$numero.".".$campo1." as ".$campo1.$numero;
	  if($campo2<>"") $camposbuscadoslistadosearch.=",".$tabla.$numero.".".$campo2." as ".$campo2.$numero;
	  if($campo3<>"") $camposbuscadoslistadosearch.=",".$tabla.$numero.".".$campo3." as ".$campo3.$numero;
	}
  }	
}	

// V3 camposcomunessearch
function cbusqueda2($campol1,$tabla1,$tabla2,$campo1,$campoextra,$numero,$camporelacion)
{
	global $camposcomunessearch;
	
	if(!isset($camporelacion) || $camporelacion=="") 
		$camporelacion="id";
		
	if($campol1=="on" || $campoextra<>"") 
	{
		if($numero==0) 
			$camposcomunessearch.=" LEFT JOIN ".$tabla1." ON ".$tabla2.".".$campo1."=".$tabla1.".".$camporelacion;	
		else if($numero<>0)
			$camposcomunessearch.=" LEFT JOIN ".$tabla1." as ".$tabla1.$numero." ON ".$tabla2.".".$campo1."=".$tabla1.$numero.".".$camporelacion;
	}	
}



// V3 sqltemporal
function cbusqueda3($campob1,$campob2,$tabla1,$campo1,$comilla,$numero,$extra,$campoextra)
{
	
	global $sqltemporal,$comparadorsearch,$archivoactual,$tablasFiltradas;
	$comparadorsearch="AND";
	
	if($numero==0) $numero="";
	
	if($campo1=="activo" && $archivoactual=="encuestas.php"){

		$campob1="";

	}else if($campo1=="activo" && $campob2=="")

	{

		$campob1="=";

		$campob2="1";

	}	
	
	if($campob1<>"") // si se va a buscar
	{
		if($campoextra=="") // es busqueda normal incluso sobre it
		{  
			if($sqltemporal<>"") 
			$sqltemporal.=" ".$comparadorsearch." ";
			$sqltemporal.=" ".$tabla1.".".$campo1." ".$campob1." ".$comilla.$campob2.$comilla;  // $numero
			
			if($campo1=="activo")
			{
				
					//Modifico Antonio
					
						if (in_array($tabla1, $tablasFiltradas)){
						  	$sqltemporal.=" and ".$tabla1.".iciudad=".$_SESSION["ciudadactual"];

						}
				
			}
		}
		else // hay busquedas abiertas en it
		{
			if($campob2<>"") // trae valor en el campo original
			{
				if($sqltemporal<>"") 
					$sqltemporal.=" ".$comparadorsearch." ";
				$sqltemporal.=" ".$campo1." ".$campob1." ".$campob2;  
			}
			if($campoextra<>"" && $campob1<>"" && $extra<>"") // trae valor en el campo abierto
			{
			
				if($sqltemporal<>"") 
					$sqltemporal.=" ".$comparadorsearch." ";
					
				if(strpos($campoextra,"concat(",0)===false)	
					$sqltemporal.=" ".$tabla1.".".$campoextra." ".$campob1." ".$comilla.$extra.$comilla;   // .$numero
				else
					$sqltemporal.=" ".$campoextra." ".$campob1." ".$comilla.$extra.$comilla;  	
			}
		}
	}  
	
			  
}	
// V3 construyecamposbuscadoslistadosearch
function cbusqueda4($campol1,$tabla,$campo1,$numero,$campo2,$campo3)
{
  global $listadodecampossearchtigra,$tempotigra,$linktigra,$row;
  
  $camporeal=$row[$campo1];
  $camporeal = str_replace("\r", "", $camporeal);
  $camporeal = str_replace("\n", "", $camporeal);
  
  if($campol1=="on") 
  {
    if($listadodecampossearchtigra<>"") $listadodecampossearchtigra.=",";
	
    if($campo3=="dinero") // vamos a ver si formateamos los numeros
	{
		$listadodecampossearchtigra.="\"<div align=right>".$linktigra."$".number_format($camporeal,2,".",","); 
		  $listadodecampossearchtigra.="</div>\"";
	}
	else if($campo3=="porcentaje") // vamos a ver si formateamos los numeros
	{
		$listadodecampossearchtigra.="\"<div align=right>".$linktigra.number_format($camporeal,2,".",",")."%"; 
		  $listadodecampossearchtigra.="</div>\"";
	}
	else  // es normal
	{
		if($numero==0) 
		{
		  $listadodecampossearchtigra.="\"".$linktigra.(str_replace("\"","",$camporeal))." "; 
		  if($campo2<>"") $listadodecampossearchtigra.=$tempotigra.(str_replace("\"","",$row[$campo2]))." "; 
		  if($campo3<>"") $listadodecampossearchtigra.=$tempotigra.(str_replace("\"","",$row[$campo3])); 
		  $listadodecampossearchtigra.="\"";
		}	
		else	
		{
		  $listadodecampossearchtigra.="\"".$linktigra.(str_replace("\"","",$row[$campo1.$numero])).$tempotigra." "; 
		  if($campo2<>"") $listadodecampossearchtigra.=$linktigra.(str_replace("\"","",$row[$campo2.$numero])).$tempotigra." "; 
		  if($campo3<>"") $listadodecampossearchtigra.=$linktigra.(str_replace("\"","",$row[$campo3.$numero])).$tempotigra; 
		  $listadodecampossearchtigra.="\"";
		}  
	}
	
    $tempotigra=""; 
	$linktigra="";
	
  }	
}
// V3 tigracabeza
function cbusqueda5($campol1,$titulo,$tipo)
{
  global $tigracabeza,$totalcolumnas;
  if($campol1=="on") 
  {
    if($tigracabeza<>"") $tigracabeza.=","; 
	$tigracabeza.="{'name': '".$titulo."', 'type' ".$tipo."}"; 
	$totalcolumnas=$totalcolumnas+1;
  }	
}	

// V3 pietablasearchtigra
function cbusqueda6($campol1,$camposumatoria,$dinero) // para ver si es dinero
{
  global $pietablasearchtigra;
  if($campol1=="on") 
  {
    if($pietablasearchtigra<>"") $pietablasearchtigra.=","; 
	if($dinero=="dinero")
	   $pietablasearchtigra.="\"$".number_format($camposumatoria,2,".",",")."\"";
	 else if($dinero=="porcentaje")
	   $pietablasearchtigra.="\"".number_format($camposumatoria,2,".",",")."%\"";  
	else
	  $pietablasearchtigra.="\"".$camposumatoria."\"";  
  }	
}	

// V3
function generaboton($url,$textoboton,$modo,$clase)
{
  $espaciador="";
  if($clase=="" || !isset($clase)) 
  {
    $clase="textoboton";
	$espaciador="&nbsp;";
  }	
  
  if($modo=="anidada")
    if(strpos($url,"?")===false) 
	  $url.="?";
  
  if($url<>"" && $textoboton<>"")
  {
    if($modo=="" || !isset($modo))
      return "<a href=\"".$url."\" class=\"".$clase."\" target='_blank'>".$espaciador.$textoboton.$espaciador."</a>";
	else if($modo=="anidada")
	  return "<a href=\"javascript:TB_special('".$url."&keepThis=true&TB_iframe=true&height=410&width=700','')\" class=\"".$clase."\">".$espaciador.$textoboton.$espaciador."</a>";  
	else if($modo=="anidadacierra")
      return "<a href=\"".$url."\" class=\"".$clase."\" target=\"_parent\">".$espaciador.$textoboton.$espaciador."</a>"; 
  }	  
}



function generaidcontrol()
{
  global $anohoy,$meshoy,$diahoy,$id,$numerodetabla;
  $lineadecapturab=sprintf("%04d%02d%02d%08d%03d",$anohoy,$meshoy,$diahoy,$id,$numerodetabla);					
  $valorlinea=0;
  
  $lineas=array(23,29,31,37,13,17,19,23,29,31,37,19,23,29,31,37,1,2,3);
		
  for($i=0; $i<=strlen($lineadecapturab)-1; $i++)
  {
	$valorlinea=$valorlinea+$lineadecapturab{$i}*$lineas[$i];
  }
  $residuo=99-($valorlinea % 97);
  $linea=$lineadecapturab.sprintf("%02d",$residuo);
  return $linea;
}

function guardareporte($error)
{
  global $fechahoy,$horaactual,$id,$sesionid,$sesionidregistro,$numerodetabla,$modomensaje;
  $errores=array("","Alta no permitida","Modificar no permitida","Borrar no permitido","B�squeda no permitida","Consulta a registro no permitido","Violaci�n a IDCONTROL","Alta violatoria (nivel campo)","Modificar violatoria (nivel campo)","B�squeda violatoria (nivel campo)","Operaci�n directa violatoria (nivel campo)","Otro");
  if(!isset($id)) $id=0;
  @mysqli_query($GLOBALS["enlaceDB"] ,"INSERT INTO careportes SET fechareporte='".$fechahoy."',horareporte='".$horaactual."',idtablareporte=".$numerodetabla.",idusuarioreporte=".$sesionid.",idregistroreporte=".$id.",idaccesoreporte=".$sesionidregistro.",operacionreporte='".$error."'");
  $mensaje="Est� intentando acceder al sistema en forma irregular. Se ha bloqueado el acceso y creado un reporte.";
  $mensaje=$mensaje."<br><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REPORTE GENERADO. ".$errores[$error]."</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  $mensaje=$mensaje.conviertedia($fechahoy).", ".$horaactual."<br>";
  $modomensaje="ERROR";
  return $mensaje;
}
function conviertedia($fechadia)
{
  list($ano1,$mes1,$dia1) = split("-", $fechadia);
  $meses=array('0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
  $texto=round($dia1)." de ".$meses[round($mes1)]." del ".$ano1;

  
  return $texto;
}
function GetFileList( $dirname="." ) {   // Finds all the JPEGs in a directory
   // First check to see if there's a file called $sortfile
   // that contains a sorted list of filenames, one per line
   // otherwise, will default to all files in alphabetical order
   global $sortfile;

   $files = array();

   if (file_exists($sortfile)) {
      $files = file($sortfile);
      array_walk($files, 'RemoveNewLines');
   } else {
      $dir = opendir( $dirname );
      while( $file = readdir( $dir ) ) {
         if (ereg("jpg$",$file) || ereg("JPG$",$file) ||             
			 ereg("gif$",$file) || ereg("GIF$",$file) ) {
             $files[] = $file;
         } //endif ereg
      } //do while
      sort($files);
   } // endif file_exists
   return $files;
} //end function

function GetFileListTodos( $dirname="." ) {   // Finds all the JPEGs in a directory
   // First check to see if there's a file called $sortfile
   // that contains a sorted list of filenames, one per line
   // otherwise, will default to all files in alphabetical order
   global $sortfile;

   $files = array();

   if (file_exists($sortfile)) {
      $files = file($sortfile);
      array_walk($files, 'RemoveNewLines');
   } else {
      $dir = opendir( $dirname );
      while( $file = readdir( $dir ) ) {       
             $files[] = $file;       
      } //do while
      sort($files);
   } // endif file_exists
   return $files;
} //end function

function leecampos($tabla,$campo1,$campo2,$campo3,$campo4,$separador,$campocondicional,$valorcampocondicional)
{	
      global $campos1;
      global $campos2;
	  global $archivoactual,$step;
	  global $id;
	  global $tablasFiltradas;
      global $registros;
	  
	  $campos1 = array();
	  $campos2 = array();
	  $registros=0;
	 
	$cadena="";
	if($campo1<>"") $cadena=$cadena.$campo1;
	if($campo2<>"") $cadena=$cadena.",".$campo2;
	if($campo3<>"") $cadena=$cadena.",".$campo3;
	//if($campo4<>"") $cadena=$cadena.",".$campo4;
	$cadena2=$campo2;
	if($campo3<>"") $cadena2=$cadena2.",".$campo3;
	//if($campo4<>"") $cadena2=$cadena2.",".$campo4;

	if (in_array($tabla, $tablasFiltradas))
	{
		$campocondicional="iciudad";
		$valorcampocondicional=$_SESSION["ciudadactual"];	
	}

	if($campo2=="fff")
	{
		$sqla="SELECT jue.id,concat('(',fechajue,') ',equ1.nombrecortoequ,' vs ',equ2.nombrecortoequ) as nombrejue from jue left join equ as equ1 on jue.iequ1jue=equ1.id left join equ as equ2 on jue.iequ2jue=equ2.id and jue.activo='1' order by jue.fechajue,jue.horajue";
		$result2 = @mysqli_query($GLOBALS["enlaceDB"] ,$sqla);
	}
	else
	{
	  if($campocondicional<>"" && isset($campocondicional) )
        $result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where ".$campocondicional."=".$valorcampocondicional." and activo='1' order by ".$cadena2);
		
	  else   
        $result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where activo='1' order by ".$cadena2);	  
	}
	while ( $row2 = mysqli_fetch_array($result2) )
    {	
	  $campos1[$registros] = $row2[$campo1];
	  $campos2[$registros] = ($row2[$campo2].$separador.$row2[$campo3]);     
	  $registros=$registros+1;
	}  
}

function leecampos2($tabla,$campo1,$campo2,$tablar,$campo1r,$campo2r,$campo3r,$campolistado,$camponombrer,$datocampolistado)
{
  $result3 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$campo2r.",".$camponombrer." FROM ".$tablar." where id=".$campo1r); 
  while ( $row3 = mysqli_fetch_array($result3) )
  {
    echo("<select name=".$campolistado.">");
    $result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$campo1.",".$campo2." FROM ".$tabla." where ".$campo3r."=".$row3[$campo2r]);
	echo("<option value=0 selected></option>");
    while ( $row2 = mysqli_fetch_array($result2) )
    {
	  echo("<option value=".$row2[$campo1]); 
	  if($datocampolistado==$row2[$campo1]) 
	  { 
	    echo(" selected"); 
	  } 
	  echo(">".$row2[$campo2]."</option>");
	  
	}  
	echo("</select> ".$row3[$camponombrer]);
  }
}

function leecamposcascada($tabla,$campo1,$campo2,$campo3,$campo4,$separador,$campocondicional,$valorcampocondicional,$campocondicional2,$id,$sel,$modo,$arbol,$archivo,$campobase)
{
	
    global $sel1;
	global $sel2;
	global $sel3;
	global $sel4;
	global $step;
	global $nivelusuario;
	global $archivoactual;
	global $tablasFiltradas;
	
	$campostep="";
	if($step=="busqueda") $campostep="b2";
	
    $modox=$modo-1;
    echo("addListGroup(\"arbol".$arbol."\", \"c_".$campobase.$campostep."\");\n");
    echo("addOption(\"c_".$campobase.$campostep."\", \"Selecciona...\", \"0\");\n");
	
    $registros=0;
	$cadena="";
	if($campo1<>"") $cadena=$cadena.$campo1;
	if($campo2<>"") $cadena=$cadena.",".$campo2;
	if($campo3<>"") $cadena=$cadena.",".$campo3;
	if($campo4<>"") $cadena=$cadena.",".$campo4;
	
	$cadena2=$campo2;
	if($campo3<>"") $cadena2=$cadena2.",".$campo3;
	if($campo4<>"") $cadena2=$cadena2.",".$campo4;
	
	
	if (in_array($tabla, $tablasFiltradas))
	{
		$campocondicional="iciudad";
		$valorcampocondicional=$_SESSION["ciudadactual"];	
	}
	

	if($campocondicional<>"" && isset($campocondicional) )
	{
		
		$result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where ".$campocondicional."=".$valorcampocondicional." and activo=1 order by ".$cadena2);
	}
	else   
		$result2 = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT ".$cadena." FROM ".$tabla." where activo=1 order by ".$cadena2);	  
	
	while ( $row2 = mysqli_fetch_array($result2) )
	{	
		$tempo=""; if($sel==$row2["id"]) $tempo=",1";
		echo("addList(\"c_".$campobase.$campostep."\", \"".($row2[$campo2].$separador.$row2[$campo3].$separador.$row2[$campo4])."\", \"".$row2["id"]."\", \"contenido".$archivo.".php?id=".$row2["id"]."&modo=".$modo."&sel1=".$sel1."&sel2=".$sel2."&sel3=".$sel3."&sel4=".$sel4."&arbol=".$arbol."&step=".$step."\"".$tempo.");\n");     
	}
}



//FUNCIONES PARA DINERO V4
function formato_numero($cantidad,$modo)
{
  $menos="";
  if($cantidad<0) 
  {
	$cantidad=-$cantidad;
	$menos="-";
  }	
  $cantidadx=explode(".","000".$cantidad);
	

  if($modo=="dinero") 
  	return $menos."$".number_format($cantidad,2,".",","); 
  else if($modo=="porcentaje") 
  	return $menos.number_format($cantidad,2,".",",")."%"; 	
  else 
  {

    if($cantidadx[0]=="000") return $menos."0.".$cantidadx[1];
    if($cantidadx[1]<>"") return $menos.number_format($cantidadx[0],0,".",",").".".$cantidadx[1];
  	else
		return $menos.number_format($cantidad,0,".",","); 
  }	

}

function porcentaje($monto)
{
	return number_format($monto,0,".",",");
}

// V4 lee un registro individual para un IT que se muestra solamente o tiene autocompletar 
function lee_registro($tabla,$campo1,$campo2,$campo3,$id,$campoid)
{
	$valor_mostrar="";
	
	if($campo1=="nombrejue")
	{
	
	}
	else
	{
		$campos=$campo1;
		if($campo2<>"") $campos.=",".$campo2;
		if($campo3<>"") $campos.=",".$campo3;
	
		$resultempo = @mysqli_query($GLOBALS["enlaceDB"] ,"SELECT $campos from $tabla where $campoid=$id"); 
		if(mysqli_num_rows($resultempo)>0)
		{
			$rowtempo = mysqli_fetch_array($resultempo); 
			$valor_mostrar=$rowtempo[$campo1];
			if($campo2<>"" && $rowtempo[$campo2]<>"") $valor_mostrar.=" ".$rowtempo[$campo2];
			if($campo3<>"" && $rowtempo[$campo3]<>"") $valor_mostrar.=" ".$rowtempo[$campo3];
		}
		return $valor_mostrar;
	}
}

/*
function htmlentitiesMemoCMS($valor)
{
	return htmlentities($valor,ENT_COMPAT,'ISO-8859-1');	
}

function htmlspecialcharsMemo($va,$valor1,$valor2)
{
	$valor=str_replace("&","",$valor);
	$valor=str_replace("<","",$valor);
	$valor=str_replace(">","",$valor);
	$valor=str_replace("\"","",$valor);
	$valor=str_replace("'","",$valor);
	$valor=str_replace("/","",$valor);
	$valor=str_replace("\\","",$valor);
	return htmlentities($valor,ENT_COMPAT,'ISO-8859-1');	
}
*/
// imprimir en html
function htmlentitiesMemo2Strong($valor)
{
	$valor=str_replace("&","",$valor);
	$valor=str_replace("<","",$valor);
	$valor=str_replace(">","",$valor);
	$valor=str_replace("\"","",$valor);
	$valor=str_replace("'","",$valor);
	$valor=str_replace("/","",$valor);
	$valor=str_replace("\\","",$valor);
	return htmlentities($valor,ENT_COMPAT,'ISO-8859-1');	
	
}

// entrar a base de datos
function mysqli_real_escape_string2Memo($valor)
{	
	$valor=trim(strip_tags($valor));
	//$valor=str_replace("&","",$valor);
	$valor=str_replace("<","",$valor);
	$valor=str_replace(">","",$valor);
	$valor=str_replace("\"","",$valor);
	//$valor=str_replace("'","",$valor);
	$valor=str_replace("\\","",$valor);
	return mysqli_real_escape_string($GLOBALS["enlaceDB"] ,$valor);
}

function convierte_url_APIAdmin($titulo)
{
	
	$titulo=utf8_encode($titulo);
	$titulo =mb_strtolower($titulo);
	$titulo=str_replace("á","a",$titulo);
	$titulo=str_replace("é","e",$titulo);
	$titulo=str_replace("í","i",$titulo);
	$titulo=str_replace("ó","o",$titulo);
	$titulo=str_replace("ú","u",$titulo);
	$titulo=str_replace("ñ","n",$titulo);
	
	$titulo = preg_replace("/[^a-z0-9_\s-]/", "", $titulo);
    $titulo = preg_replace("/[\s-]+/", " ", $titulo);
    $titulo = preg_replace("/[\s_]/", "-", $titulo);
	return $titulo;	
}
?>