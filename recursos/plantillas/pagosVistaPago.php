<div>
    <div class="error"><error></div>
    <div class="form_reg" style="color:#757575">
        <form method="post" onsubmit="return validarCret()" id="formpag">
             <input type="hidden" id="operacion" name="operacion" value="pagar">
             <input type="hidden" id="idiniciativa" name="idiniciativa" value="<idiniciativa>">
             <input type="hidden" id="idusuario" name="idusuario" value="<idusuario>">
             <input type="hidden" id="renglonesextras" name="renglonesextras" value="<renglonesextras>">
             <input type="hidden" id="nombreret" name="nombreret" value="<nombreret>">
             <input type="hidden" id="urlregreso" name="urlregreso" value="<urlregreso>">
             <input type="hidden" id="toks" name="toks" value="<toks>">
            <p class="bgg"><donarahora></p><div class="cambiardonador" style="font-size:12px; font-weight:bold !important"><emaildonador></div><div class="cambiardonador" onclick="cambiardonador()"><cambiardonador></div><br>
            <big> $ <input type="text" id="donativo" name="donativo" value="<montopagar>" style="font-size:27px !important; width:110px; padding: 4px 6px;" onKeyUp="refrescaCret(<maxganadores>,<montominimo>,this.value);"><moneda> <span id="indicadorEstrellas"><obtendras></span></big>
            <script>
            var obtendrasjs='<obtendrasjs>';
            </script>
            <extras>

            <pagosForm>
            
            <input class="pag bver" type="submit" value='Donar' id="subpag" style="font-size:17px !important;">
            <div id="loader" style="display: none"><img src='recursos/elementos/ajax-loader.gif'></div>
            
        </form>
    </div>
</div>