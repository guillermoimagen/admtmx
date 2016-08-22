if(lang == null) var lang = "ES";

var ex_email = /^([a-zA-Z0-9_\.\-]+)@([\da-z\.\-]+)\.([a-z\.]{2,6})$/;
var ex_nick = /^([a-zA-Z0-9\.\-_]{4,})$/;
var ex_md5 = /^[a-f0-9]{32}$/i;

$(document).ready(function(){
	jQuery.extend({
		showLoginWindow: function(){
			$.fancybox($("[name=ventanaConectarse]"));
		},
		showSignUpWindow: function(){
			$.fancybox($("[name=ventanaRegistrarse]")); 
		},
		showForgotWindow: function(){
			$.fancybox.close();
			$.fancybox($("[name=ventanaOlvidarContrasena]")); 
		},
		showResetWindow: function(){
			$.fancybox($("[name=ventanaRestaurar]")); 
		},
		loginByEmail: function(email, pass, recaptcha){
			$("[name=ventanaConectarse] .messageResponse").html('<img src="recursos/elementos/ajax-loader.gif" />');
			$.ajax({
				url: 'remote/users/logInUser/',
				type: 'POST',
				dataType: 'json',
				data: {email: email, pass: pass, "g-recaptcha-response": recaptcha, idioma: ((lang == "EN") ? 1 : 0)},
				beforeSend: function(){
					$("[name=ventanaConectarse] .messageResponse").html('<img src="recursos/elementos/ajax-loader.gif" />');
				},
				statusCode:{
					400: function(data){
						grecaptcha.reset(RecaptchaLogin1);
						$("[name=ventanaConectarse] .messageResponse").html(((data.responseJSON.meta.detail)));
						$("[name=ventanaConectarse] .messageResponse").show();
					}
				},
				success: function(data){
					window.location.reload();
				}
			});
		},
		signUpEmail: function(email, pass, name, nick, recaptcha){
			$.ajax({
				url: 'remote/users/signUpUser/',
				type: 'POST',
				dataType: 'json',
				data: {email: email, pass: pass, name: name, nick: nick, "g-recaptcha-response": recaptcha, idioma: ((lang == "EN") ? 1 : 0)},
				beforeSend: function(){
					$("[name=ventanaRegistrarse] .messageResponse").html('<img src="recursos/elementos/ajax-loader.gif" />');
				},
				statusCode:{
					400: function(data){
						grecaptcha.reset(RecaptchaLogin2);
						$("[name=ventanaRegistrarse] .messageResponse").html(((data.responseJSON.meta.detail)));
						$("[name=ventanaRegistrarse] .messageResponse").show();
					}
				},
				success: function(data){
					$("[name=ventanaRegistrarse]").show();
					$("[name=ventanaRegistrarse] .messageResponse").html(((data.meta.detail)));
					$("[name=ventanaRegistrarse] .messageResponse").show();
				}
			});
		},
		checkLoginState: function(){
			$("[name=ventanaConectarse] .messageResponse").html('<img src="recursos/elementos/ajax-loader.gif" /><br />' + IC_lang[lang].logInFacebook);
			$("[name=ventanaConectarse] .messageResponse").show();
			$("[name=ventanaRegistrarse] .messageResponse").html('<img src="recursos/elementos/ajax-loader.gif" /><br />' + IC_lang[lang].logInFacebook);
			$("[name=ventanaRegistrarse] .messageResponse").show();

			FB.getLoginStatus(function(response){
				$.statusChangeCallback(response);
			});
		},
		statusChangeCallback: function(response){
			if(response.status === 'connected'){
				var param = {"oAuthToken": response.authResponse.accessToken, idioma: ((lang == "EN") ? 1 : 0)};

				FB.api('/me', function(me){
					$.ajax({
						type: "POST",
						url: "remote/users/logInFacebook/",
						data: param,
						dataType: 'json',
						statusCode: {
							400: function(data){
								$("[name=ventanaConectarse] .messageResponse").html(((data.responseJSON.meta.detail)));
								$("[name=ventanaConectarse] .messageResponse").show();
								$("[name=ventanaRegistrarse] .messageResponse").html(((data.responseJSON.meta.detail)));
								$("[name=ventanaRegistrarse] .messageResponse").show();
							},
							401: function(data){
								$("[name=ventanaConectarse] .messageResponse").html(((data.responseJSON.meta.detail)));
								$("[name=ventanaConectarse] .messageResponse").show();
							}
						},
						success: function(data){
							window.location.reload();
						}
					});
				});
			}else if (response.status === 'not_authorized'){
				console.log('Please log into this app.');
			}else{
				console.log('Please log into Facebook.');
			}
		},
		sendForgottenPassword: function(email, recaptcha){
			$.ajax({
				url: 'remote/users/sendForgotPassEmail/',
				type: 'POST',
				dataType: 'json',
				data: {email: email, "g-recaptcha-response": recaptcha, idioma: ((lang == "EN") ? 1 : 0)},
				beforeSend: function(){
					$("[name=ventanaOlvidarContrasena] .messageResponse").html('<img src="recursos/elementos/ajax-loader.gif" />');
				},
				statusCode:{
					400: function(data){
						grecaptcha.reset(RecaptchaLogin3);
						$("[name=ventanaOlvidarContrasena] .messageResponse").html(((data.responseJSON.meta.detail)));
						$("[name=ventanaOlvidarContrasena] .messageResponse").show();
					}
				},
				success: function(data){
					grecaptcha.reset(RecaptchaLogin3);
					$("[name=ventanaOlvidarContrasena] .messageResponse").html(data.meta.detail);
					$("[name=ventanaOlvidarContrasena] .messageResponse").show();
				}
			});
		},
		saveNewPassword: function(token, pass){
			$.ajax({
				url: 'remote/users/updateForgotedPass/',
				type: 'POST',
				dataType: 'json',
				data: {tokenTemporal: token, pass: pass, idioma: ((lang == "EN") ? 1 : 0)},
				beforeSend: function(){
					$("[name=ventanaRestaurar] .messageResponse").html('<img src="recursos/elementos/ajax-loader.gif" />');
				},
				statusCode:{
					400: function(data){
						$("[name=ventanaRestaurar] .messageResponse").html(((data.responseJSON.meta.detail)));
						$("[name=ventanaRestaurar] .messageResponse").show();
					}
				},
				success: function(data){
					$("[name=ventanaRestaurar] .messageResponse").html(data.meta.detail);
					$("[name=ventanaRestaurar] .messageResponse").show();
					$("[name=segmentoRestaurar] input").prop('disabled', true);
					$("[name=botonRestaurar]").remove();
					window.setTimeout(function(){window.location.href = "index.php"; }, 3000);

				}
			});
		},
		validateForm: function(obj){
			var v = true;
			var msg = "";
			if(obj.find("[name=email]").length > 0){
				var t = obj.find("[name=email]");
				if(t.val() == ""){
					msg += IC_lang[lang].emailRequired + '<br />';
					v = false;
				}else if(t.val().match(ex_email) == null){
					msg += IC_lang[lang].emailFormat + '<br />';
					v = false;
				}
			}
			if(obj.find("[name=name]").length > 0){
				var t = obj.find("[name=name]");
				if(t.val() == ""){
					msg += IC_lang[lang].nameRequired + '<br />';
					v = false;
				}
			}
			if(obj.find("[name=nick]").length > 0){
				var t = obj.find("[name=nick]");
				console.log(t.val().match(ex_nick));
				if(t.val() == ""){
					msg += IC_lang[lang].nickRequired + '<br />';
					v = false;
				}else if(t.val().match(ex_nick) == null){
					msg += IC_lang[lang].nickFormat + '<br />';
					v = false;
				}
			}
			if(obj.find("[name=password]").length > 0){
				var t = obj.find("[name=password]");
				if(t.val() == ""){
					msg += IC_lang[lang].passRequired + '<br />';
					v = false;
				}
				if(obj.find("[name=password_c]").length > 0){
					var t2 = obj.find("[name=password_c]");
					if(t.val() != t2.val()){
						msg += IC_lang[lang].passNotEquals + '<br />';
						v = false;
					}	
				}
			}
			if(obj.find("[name=g-recaptcha-response]").length > 0){
				if(obj.find("[name=g-recaptcha-response]").val() == "")
					v = false;
			}
			obj.closest(".ventanaEmergentePrincipal").find(".messageResponse").html(msg);
			obj.closest(".ventanaEmergentePrincipal").find(".messageResponse").show();

			return v;
		}
	});
});

$(document).ready(function(){
	$("[name=showLogin]").click(function(){
		$.showLoginWindow();
	});
	$("[name=botonAbrirOlvidar]").click(function(){
		$.showForgotWindow();
	});
	$("[name=botonRegistrarse]").click(function(){
		$.showSignUpWindow();
	});
	$("[name=botonOlvidar]").click(function(e){
		e.preventDefault();
		var v = $.validateForm($("[name=segmentoOlvidarContrasena]"));
		if(v == true)
			$.sendForgottenPassword($("[name=segmentoOlvidarContrasena] [name=email]").val(), $("[name=segmentoOlvidarContrasena] [name=g-recaptcha-response]").val());
	});
	$("[name=botonConectarse]").click(function(e){
		e.preventDefault();
		var v = $.validateForm($("[name=segmentoConectarse]"));
		if(v == true)
			$.loginByEmail($("[name=segmentoConectarse] [name=email]").val(), $("[name=segmentoConectarse] [name=password]").val(), $("[name=segmentoConectarse] [name=g-recaptcha-response]").val());
	});
	$("[name=botonRegistrarse]").click(function(e){
		e.preventDefault();
		var v = $.validateForm($("[name=segmentoRegistrarse]"));
		if(v == true)
			$.signUpEmail($("[name=segmentoRegistrarse] [name=email]").val(), $("[name=segmentoRegistrarse] [name=password]").val(), $("[name=segmentoRegistrarse] [name=name]").val(), $("[name=segmentoRegistrarse] [name=nick]").val(), $("[name=segmentoRegistrarse] [name=g-recaptcha-response]").val());
	});

	if(typeof tokenrecuperar !== "undefined" && tokenrecuperar != null && tokenrecuperar != "" && tokenrecuperar.match(ex_md5) != null){
		$("[name=botonRestaurar]").click(function(e){
			e.preventDefault();
			var v = $.validateForm($("[name=segmentoRestaurar]"));
			if(v == true)
				$.saveNewPassword(tokenrecuperar, $("[name=segmentoRestaurar] [name=password]").val());
		});

		$.showResetWindow();
	}
});