<div class="sect_comentarios">
                	
    <div class="recu_come">
    
        <textarea placeholder="Deja tu comentario" id="comentario" maxlength="255" onkeypress="limitaComentario(255)" onkeyup="limitaComentario(255)"></textarea> 
        
        <div class="recu_boton">
            <div class="btn_comentar" onClick="enviarComentario(<idiniciativa>);">Comentar</div>
            <div class="miniinfo" id="charsActual"></div>
        </div>
    
    </div>
    
    <div class="overff">
   		 <VISTA_comentarios>
        <div class="comentario_lista" id="comentario<idreal>">
            <div class="datos_come">
                <a href="<urlAmigableusuario>"><strong><nickusuario></strong> </a>
                <small><fechacom></small>
            </div>
            <span id="textocom_<idreal>"><textocom></span>
            <br clear="all">
            <div class="btn_vercompleta" style="display:<displayeditar>" onclick="editarComentario(<idreal>);">Editar</div>
            <div class="btn_vercompleta" style="display:<displayeditar>" onclick="validarComentario(<idreal>,'eliminar');">Eliminar</div>             
        </div>
        <br clear="all">
        </VISTA_comentarios>
    </div> 
    
    
</div>