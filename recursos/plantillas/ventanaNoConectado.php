<div name="ventanaConectarse" class="ventanaEmergentePrincipal">
<div name="segmentoConectarse">
<div class="fm_lg">
<div class="fm_lb"><tuemail>:</div><input name="email" placeholder="<phtuemail>" type="email"/><br />
<div class="fm_lb"><tucontrasena>:</div><input name="password" type="password" placeholder="<phtucontrasena>" /><br />
<div class="fm_ch"><div id="RecaptchaLogin1"></div></div>
<button name="botonConectarse" class="btn_up btn_sm"><botonconectarse></button>
<div class="fm_op"><span name="botonAbrirOlvidar"><botonolvidar></span> | <span name="botonRegistrarse"><botonregistrarse></span></div>
</div>
<hr />
<div style="text-align: center;"><fb:login-button scope="public_profile,email" onlogin="$.checkLoginState();"></fb:login-button></div>
<hr />
<div style="text-align: center;"><a href="APIRemote/redirect.twitter.php"><img src="https://g.twimg.com/dev/sites/default/files/images_documentation/sign-in-with-twitter-gray.png" /></a></div>
<hr />
<div class="messageResponse"></div>
</div>
</div>

<div name="ventanaRegistrarse" class="ventanaEmergentePrincipal">
<div name="segmentoRegistrarse">
<div class="fm_lg">
<div class="fm_lb"><tuemail>:</div><input name="email" placeholder="<phtuemail>" type="email"/><br />
<div class="fm_lb"><tunombre>:</div><input name="name" placeholder="<phtunombre>" /><br />
<div class="fm_lb"><tuapodo>:</div><input name="nick" placeholder="<phtuapodo>" /><br />
<div class="fm_lb"><tucontrasena>:</div><input name="password" type="password" placeholder="<phtucontrasena>" /><br />
<div class="fm_lb"><repitecontrasena>:</div><input name="password_c" type="password" placeholder="<phrepitecontrasena>" /><br />
<div class="fm_ch"><div id="RecaptchaLogin2"></div></div>
<center><button name="botonRegistrarse" class="btn_up btn_sm"><botonregistrarse></button></center>
<div class="messageResponse"></div>
</div>
<hr />
<div style="text-align: center;"><fb:login-button scope="public_profile,email" onlogin="$.checkLoginState();"></fb:login-button></div>
<hr />
<div style="text-align: center;"><a href="APIRemote/redirect.twitter.php"><img src="https://g.twimg.com/dev/sites/default/files/images_documentation/sign-in-with-twitter-gray.png" /></a></div>
<hr />

</div>
</div>

<div name="ventanaOlvidarContrasena" class="ventanaEmergentePrincipal">
<div name="segmentoOlvidarContrasena">
<p><infoventanaolvidar></p>
<div class="fm_lg">
<div class="fm_lb"><tuemail>:</div><input name="email" placeholder="<phtuemail>" type="email" /><br />
<div class="fm_ch"><div id="RecaptchaLogin3"></div></div>
<center><button name="botonOlvidar" class="btn_up btn_sm"><botoncontinuar></button></center><br clear="all">
</div>
<div class="messageResponse"></div>
</div>
</div>

<div name="ventanaRestaurar" class="ventanaEmergentePrincipal">
<div name="segmentoRestaurar">
<p><infoventanarestaurar></p>
<div class="fm_lg">
<div class="fm_lb"><tucontrasena>:</div><input name="password" type="password" placeholder="<phtucontrasena>" /><br />
<div class="fm_lb"><repitecontrasena>:</div><input name="password_c" type="password" placeholder="<phrepitecontrasena>" /><br />
<button name="botonRestaurar" class="btn_up btn_sm"><botonguardar></button>
</div>
<div class="messageResponse"></div>
</div>
</div>