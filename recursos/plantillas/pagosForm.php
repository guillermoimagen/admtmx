
<div class="radios">
	<div><label><input type="radio" value="1" id="TDC" name="pagos" >Tarjeta de d&eacute;bito/<br class="bas"> cr&eacute;dito<img src="recursos/elementos/tss.png"></label>
<div id="creditCar" class="crdcr" style="display:none;">
			<table  border="0" align="left" cellpadding="1" cellspacing="0" style="font-size:14px">
                  <tbody>     
                  		<tr><td style="font-size:10px">Excepto D&eacute;bito Visa Electron</td></tr>                
                        <tr>
                            <td>
                            <div class="tituloTC">Nombre como aparece en tu tarjeta*</div>
                            <input id="TDC_nombre" type="text" maxe="4" name="TDC_nombre" class="frm_input" maxlength="50" size="30" value="<TDC_nombre>">
                               
                            </td>
                        </tr>
                        <tr>
                            <td><div class="tituloTC">Tipo de tarjeta*</div>
                            
                            <select id="TDC_tipo" name="TDC_tipo" class="frm_input" size="1" onchange="" maxe="3">	
                            	<option value="0" selected="selected">-Seleccionar-</option>
                            	<option value="MASTERCARD">MASTERCARD</option>
								<option value="VISA">VISA</option>
								<option value="AMEX">AMEX</option>
								</select>
                            </td>
                        </tr>

	                    <tr>
	                        <td><div class="tituloTC">N&uacute;mero de tarjeta*</div>
	                            <input id="TDC_tarjeta" type="text" name="TDC_tarjeta" maxe="13" maxlength="16" class="frm_input" size="30" value="<TDC_tarjeta>" onkeypress='return validateQty(event);' autocomplete="off">
	                        </td>
	                    </tr>
						<tr>
						    <td><div class="tituloTC">Fecha de expiraci&oacute;n*</div>
						    	<select id="TDC_mes" maxe="2" name="TDC_mes" class="frm_input" size="1">	
						    <option value="0" selected="selected">--</option>		
						    <option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							</select>
						    &nbsp;<select id="TDC_ano" name="TDC_ano" maxe="2" class="frm_input" size="1">	
						    <option value="0" selected="selected">--</option>
						    <option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
						</select>
						        
						    </td>
						</tr>
                                                                
                        <tr>
                            <td>
                            	<div class="tituloTC">C&oacute;digo de seguridad de tu tarjeta*</div>
                                <input id="TDC_cst" maxe="3" type="text" name="TDC_cst" class="frm_input" maxlength="4" size="10" value=""  onkeypress='return validateQty(event);' autocomplete="off">
                                <br>
                            </td>
                        </tr>

                        <tr>
                            <td class="txt_general_azul"><strong><b>Direcci&oacute;n donde recibes el estado de cuenta de tu tarjeta de cr&eacute;dito</b></strong></td>
                        </tr>
                        
                       
                        <tr>
                            <td><div class="tituloTC">Calle*</div>
                            <input id="TDC_calle" type="text" maxe="3" name="TDC_calle" class="frm_input" maxlength="40" size="30" value="<TDC_calle>">
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="tituloTC">N&uacute;mero*</div>
                            <input id="TDC_numero" type="text" maxe="1" name="TDC_numero" class="frm_input" maxlength="10" size="30" value="<TDC_numero>">
                               
                            </td>
                        </tr>
                        
                        <tr>
                            <td><div class="tituloTC">Colonia*</div>
                            <input id="TDC_colonia" type="text" maxe="4" name="TDC_colonia" class="frm_input" maxlength="40" size="30" value="<TDC_colonia>">
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="tituloTC">C&oacute;digo Postal*</div>
                            <input id="TDC_cp" type="text" maxe="5" name="TDC_cp" class="frm_input" maxlength="5" onkeypress='return validateQty(event);' size="30" value="<TDC_cp>" >
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="tituloTC">Ciudad*</div>
                            <input id="TDC_ciudad" type="text" maxe="4" name="TDC_ciudad" class="frm_input" maxlength="40" size="30" value="<TDC_ciudad>">
                                <br>
                            </td>
                        </tr>

						<tr>
						<td class="txt_general"><div class="tituloTC">Estado*</div>
						    <div id="cbxEntidad" style="display: inline;"><select id="TDC_estado" maxe="3" name="TDC_estado" class="frm_input" size="1">	<option value="0" selected="selected">-Seleccionar-</option>
							<option value="AGUASCALIENTES">AGUASCALIENTES</option>
							<option value="BAJA CALIFORNIA">BAJA CALIFORNIA</option>
							<option value="BAJA CALIFORNIA SUR">BAJA CALIFORNIA SUR</option>
							<option value="CAMPECHE">CAMPECHE</option>
							<option value="CHIAPAS">CHIAPAS</option>
							<option value="CHIHUAHUA">CHIHUAHUA</option>
							<option value="COAHUILA">COAHUILA</option>
							<option value="COLIMA">COLIMA</option>
							<option value="CIUDAD DE MEXICO">CIUDAD DE MEXICO</option>
							<option value="DURANGO">DURANGO</option>
							<option value="ESTADO DE MEXICO">ESTADO DE MEXICO</option>
							<option value="GUANAJUATO">GUANAJUATO</option>
							<option value="GUERRERO">GUERRERO</option>
							<option value="HIDALGO">HIDALGO</option>
							<option value="JALISCO">JALISCO</option>
							<option value="MICHOACAN">MICHOACAN</option>
							<option value="MORELOS">MORELOS</option>
							<option value="NAYARIT">NAYARIT</option>
							<option value="NUEVO LEON">NUEVO LEON</option>
							<option value="OAXACA">OAXACA</option>
							<option value="PUEBLA">PUEBLA</option>
							<option value="QUERETARO">QUERETARO</option>
							<option value="QUINTANA ROO">QUINTANA ROO</option>
							<option value="SAN LUIS POTOSI">SAN LUIS POTOSI</option>
							<option value="SINALOA">SINALOA</option>
							<option value="SONORA">SONORA</option>
							<option value="TABASCO">TABASCO</option>
							<option value="TAMAULIPAS">TAMAULIPAS</option>
							<option value="TLAXCALA">TLAXCALA</option>
							<option value="VERACRUZ">VERACRUZ</option>
							<option value="YUCATAN">YUCATAN</option>
							<option value="ZACATECAS">ZACATECAS</option>
							</select>
	                        </div>
		                    </td>
		                </tr>
                        <tr>
                            <td><div class="tituloTC">Tel&eacute;fono*</div><input id="TDC_etelefono" type="text" name="TDC_etelefono" maxe="10" class="frm_input" maxlength="10"  size="30" value="<TDC_etelefono>"  onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><div class="tituloTC">Fecha de nacimiento del titular de la tarjeta*<br>(aaaa-mm-dd)</div><input id="TDC_nacimiento" type="text" name="TDC_nacimiento" class="frm_input" maxlength="10"  size="15" value="<TDC_nacimiento>" readonly>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><div class="tituloTC">RFC o CURP*</div><input id="TDC_identificacion" type="text" name="TDC_identificacion" class="frm_input" maxlength="18"  size="22" value="<TDC_identificacion>">
                            </td>
                        </tr>
                                                                
                    </tbody>
               </table>
         </div>
	
	</div>
	
	<div><label><input type="radio" value="2" id="paypal" name="pagos">Pay Pal<img src="recursos/elementos/paypalla.png"></label></div>
	
	<div><label><input type="radio" value="3" id="oxxo" name="pagos">Oxxo<img src="recursos/elementos/oxxola.png"></label></div>
	
	<div><label><input type="radio" value="4" id="seveneleven" name="pagos">Seven Eleven<img src="recursos/elementos/7venla.png"></label></div>

	<div><label><input type="radio" value="5" id="otro" name="pagos">Extra, C&iacute;rculo K,<br> Farmacias del Ahorro y<br> Farmacias Benavides<img class="grai" src="recursos/elementos/otrosmasla.png"></label></div>
</div>


<input id="sse" type="hidden" name="sse"  value="<deviceSessionId>">

<p style="background:url(https://maf.pagosonline.net/ws/fp?id=<deviceSessionId>80200)"></p>

  <img src="https://maf.pagosonline.net/ws/fp/clear.png?id=<deviceSessionId>80200">

  <script src="https://maf.pagosonline.net/ws/fp/check.js?id=<deviceSessionId>80200"></script>

  <object type="application/x-shockwave-flash"

  data="https://maf.pagosonline.net/ws/fp/fp.swf?id=<deviceSessionId>80200" width="1" height="1"

  id="thm_fp">

  <param name="movie" value="https://maf.pagosonline.net/ws/fp/fp.swf?id=<deviceSessionId>80200" />

</object>
<script>
$( function() {
	
	$( "#TDC_nacimiento" ).datepicker(
				{ yearRange: "-100:+0",
				  changeMonth: true,
      			   changeYear: true,
				   dateFormat: "yy-mm-dd" }
				);
   
} );
</script>