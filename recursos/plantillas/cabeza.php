<redes>
<title><titulopagina></title>
<script>
var usuarioFirmado='<usuarioFirmado>';
</script>

</head>

<body>
<script>
	window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.6&appId=896161833843485";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<? //js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.7&appId=1725916974287142"; ?>
	
              
</div>
      <div class="father">
		<!-- HEAD -->
        
        	<div class="top_first">
            		<a href="index.php"><div class="logo"><img src="recursos/elementos/logo.png"></div></a>
                    <div class="rigth_co">
                    	<div class="menu_top">
                        	<a href="contenidos/0/3/fundacion.html"><strong>Fundaci&oacute;n</strong></a>|
                            <a href="contenidos/0/5/solicitarRecibo.html"><strong>Solicitar recibo</strong>|</a>
                           	<span onclick="contactoAbrir();"><strong>Contacto</strong></span>|
                            <botonesfirma>
                            <!--| <strong onClick="cambioIdioma();">English</strong>-->
                        </div>
                        <div class="btn_up" onclick="subeTuIniciativa(0);">
                        	Crea tu iniciativa
                        </div>
                    </div>
            </div>
        
        <!-- HEAD -->
        
        
        <!-- MENU -->
        <div class="super_menu">
        
        	<div class="menu_contenedor">
            	<a href="iniciativas-de-embajadores">
            	<div class="btn_menu btn_CORALCLARO">
                	<img src="recursos/elementos/icon_01.png">
        			<div class="ctd">Iniciativas</div>
                </div>
                </a>
                <a href="iniciativas-de-artistas">
                <div class="btn_menu btn_AMARILLO">
                	<img src="recursos/elementos/icon_02.png">
        			<div class="ctd">Celebridades</div>
                </div>
                </a>
                <a href="iniciativas-de-empresas">
                <div class="btn_menu btn_MORADO">
                	<img src="recursos/elementos/icon_03.png">
        			<div class="ctd">Empresas</div>
                </div>
                </a>
            </div>
            
            
           	<div class="search_contenedor" onClick="abreBuscador()"></div> 
        
        </div>
         <div class="buscador_bloques">
        	<div class="busdr_div">
            	
                <div class="radios_div">
                  <label><input type="radio"  id="btipo" name="btipo" value="embajadores"> Embajadores</label>
                  <label><input type="radio" id="btipo" name="btipo" value="artistas">Celebridades</label>
                  <label><input type="radio" id="btipo" name="btipo" value="empresas"> Empresas</label>
                </div>
                
            	<div class="porpalabra">
                    <div class="delimput"><input type="text" placeholder="Buscar..." id="bpalabra"></div>
                    <div class="bscr_action" onClick="realizaBusqueda();" style="">Buscar</div><br>
                    
                </div>
                <div class="avan_boton" onClick="abreBuscadorAvanzado();">Avanzado</div>
                <div class="avanzado_div" style="text-align:center">
                	
                    <div id="avanzado_div_contenido" style="display:none">
                        <div class="styled-select slate"  style="width:200px">
                              <select id="bestado">
                                  <option value="0">Estado</option>
                              </select>
                        </div>
                        
                        <div class="styled-select slate rigg">
                              <select id="bcategoria">
                                 <option value="0">Categor&iacute;a</option>
                              </select>
                        </div>
                        
                        <br><br>
                        <div class="styled-select slate">
                              <select id="bmodo">
                                 <option value="0">Status</option>
                              </select>
                        </div>
                        
                  <label style="float:right; margin-top:10px; color:#FFFFFF"><input type="checkbox" id="busuarios" value="usuarios">Buscar usuarios</label>
                    </div>
                    <div id="avanzado_div_loader" style="display:block">
                    	<img src="recursos/elementos/ajax-loader.gif">
                    </div>
                    
                </div>
                
            </div>
        </div>
       <!-- MENU -->