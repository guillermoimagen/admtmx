<div class="error"><error></div>

<div class="form_reg">
	
    <form method="post" onsubmit="return registroParcial()">
        <strong>Para poder seguir adelante debes completar la siguiente informaci&oacute;n:<br><br></strong>
        <strong>Tu email:</strong><br> <input type="text" id="tuemail" name="tuemail" value="<emaildonador>"  style="font-size:20px; width:220px"><br>
        <strong>Tu nombre:</strong><br> <input type="text" id="tunombre" name="tunombre" value="<valuetunombre>" style="font-size:20px; width:220px"><br>
        <strong>Tu nombre de usuario:</strong><br><input type="text" id="tuapodo" name="tuapodo" value="<valuetuapodo>" style="font-size:20px; width:220px; margin: 8px 0 20px;"><br>
        <input type="hidden" id="operacion" name="operacion" value="registroactualizar">
        <input type="submit" value="Guardar" style="float:right" class="btn_sigV">
    </form>
</div>