<HEAD>
<SCRIPT language="JavaScript"> 
<!--
 function getgoing()
  {
    top.location="<?=$_GET["modo"]?>.php?step=1&urlOrigen=<?=urlencode($_GET["urlOrigen"])?>";
   }
 
   if (top.frames.length > 0)
    {
     getgoing();
     }
	 else  window.location="<?=$_GET["modo"]?>.php?step=1&urlOrigen=<?=urlencode($_GET["urlOrigen"])?>";
//--> 
</SCRIPT> 
</HEAD>
