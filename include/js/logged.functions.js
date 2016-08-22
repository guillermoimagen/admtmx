if(lang == null) var lang = "ES";

$(document).ready(function(){
	jQuery.extend({
		logout: function(){
			var buttons = {};
			buttons[IC_lang[lang].cancel] = function() {
				$(this).dialog("close");
				$(this).dialog("destroy");
			};
			buttons[IC_lang[lang].accept] = function(){
				$.ajax({
					url: 'remote/users/logOutUser/',
					type: 'POST',
					dataType: 'json',
					statusCode:{
						400: function(response){
							Cookies.remove('revisar_datos');
							window.location.reload();
						}
					},
					success: function(data){
						Cookies.remove('revisar_datos');
						window.location.reload();
					}
				});
			};
			$('<div></div>').dialog({
				modal: true,
				title: "",
				open: function(){
					$(this).html(IC_lang[lang].confirmLogOut);
				},
				buttons: buttons
          	});
		},
		showDataWindow: function(){
			$.ajax({
				url: 'remote/users/checkValidInfo/',
				type: 'GET',
				dataType: 'json',
				statusCode:{
					400: function(response){
						console.log(response);
					}
				},
				success: function(data){
					if((data.response.email == false || data.response.telephone == false || data.response.country == false || data.response.state == false || data.response.updated == false) == false){
						Cookies.set('revisar_datos', '0', { expires: 31 });
						return false;
					}
					if(data.response.email != false){
						$("[name=segmentoDatos] [name=email]").val(data.response.email);
						$("[name=segmentoDatos] [name=email]").closest("div").hide();
					}
					$("[name=segmentoDatos] [name=nick]").val(data.response.nick);
					if(data.response.updated != false)
						$("[name=segmentoDatos] [name=nick]").closest("div").hide();
					
					if(data.response.telephone != false){
						$("[name=segmentoDatos] [name=tel]").val(data.response.telephone);
						$("[name=segmentoDatos] [name=tel]").closest("div").hide();
					}
					
					$("[name=segmentoDatos] [name=pais]").empty();
					$.ajax({
						url: 'remote/content/listCountries/',
						type: 'GET',
						dataType: 'json',
						statusCode:{
							400: function(response){
								console.log(response);
							}
						},
						success: function(data_a){
							$("[name=segmentoDatos] [name=pais]").append('<option value="">' + IC_lang[lang].select + '</option>');
							$("[name=segmentoDatos] [name=estado]").append('<option value="">' + IC_lang[lang].selectCountry + '</option>');
							$.each(data_a.response, function(index, val){
								$("[name=segmentoDatos] [name=pais]").append('<option value="' + val.pid + '">' + val.name + '</option>');
							});
							if(data.response.country != false){
								$("[name=segmentoDatos] [name=pais]").val(data.response.country);
								$("[name=segmentoDatos] [name=pais]").closest("div").hide();
								$.listStates(data.response.country, ((data.response.state != false) ? data.response.state : null));
							}
							if((data.response.country == 1 || data.response.country == 2) == false)
								$("[name=segmentoDatos] [name=estado]").closest("div").hide();
						}
					});
					$.fancybox($("[name=ventanaDatos]")); 
				}
			});
		},
		listStates: function(country, state){
			if(typeof state === "undefined") state = null;
			$("[name=segmentoDatos] [name=estado]").empty();
			$.ajax({
				url: 'remote/content/listStates/',
				type: 'GET',
				data: {pid: country},
				dataType: 'json',
				statusCode:{
					400: function(response){
						console.log(response);
					}
				},
				success: function(data){
					$("[name=segmentoDatos] [name=estado]").append('<option value="">' + IC_lang[lang].select + '</option>');
					$.each(data.response, function(index, val){
						$("[name=segmentoDatos] [name=estado]").append('<option value="' + val.sid + '">' + val.name + '</option>');
					});
					if(state != null){
						$("[name=segmentoDatos] [name=estado]").val(state);
						$("[name=segmentoDatos] [name=estado]").closest("div").hide();
					}
				}
			});
		},
		saveData: function(){
			var email = $("[name=segmentoDatos] [name=email]").val();
			var nick = $("[name=segmentoDatos] [name=nick]").val();
			var telephone = $("[name=segmentoDatos] [name=tel]").val();
			var country = $("[name=segmentoDatos] [name=pais]").val();
			var state = $("[name=segmentoDatos] [name=estado]").val();

			$.ajax({
				url: 'remote/users/updateValidInfo/',
				type: 'POST',
				dataType: 'json',
				data: {email: email, nick: nick, telephone: telephone, country: country, state: state, idioma: ((lang == "EN") ? 1 : 0)},
				statusCode:{
					400: function(data){
						$("[name=ventanaDatos] .messageResponse").html(((data.responseJSON.meta.detail)));
						$("[name=ventanaDatos] .messageResponse").show();
						$("[name=ventanaDatos]").animate({top:'+=30px'},200).animate({top:'-=30px'},200).animate({top:'+=30px'},200).animate({top:'-=30px'},200);
					}
				},
				success: function(data){
					Cookies.set('revisar_datos', '0', { expires: 31 });
					$("[name=ventanaDatos] .messageResponse").html(((data.meta.detail)));
					$("[name=ventanaDatos] .messageResponse").show();
					$("[name=ventanaDatos]").animate({top:'+=30px'},200).animate({top:'-=30px'},200).animate({top:'+=30px'},200).animate({top:'-=30px'},200);
					$.fancybox.close();
				}
			});
		},
		checkPublishPermissions: function(){
			$.ajax({
				url: 'remote/users/checkPublishPermissions(',
				type: 'GET',
				dataType: 'json',
				statusCode:{
					400: function(data){
						console.log(data.responseJSON.meta.detail);
					}
				},
				success: function(data){
					/*
					 *  EDITAR CÓDIGO PARA LO QUE SE REQUIERA HACER CUANDO SE REVISAN LOS PERMISOS.
					 *  EL OBJETO QUE DEBE DE RESPONDER ES EL SIGUIENTE:
					 *  {meta: {code: 200}, response: {granted: false, asked: false}}
					 *  DONDE GRANTED INDICIA SI SE TIENEN LOS PERMISOS DE PUBLICACIÓN Y ASKED SI YA SE PREGUNTÓ POR ELLOS ANTERIORMENTE.
					 *  UNA DE LAS BUENAS PRÁCTICAS QUE SUGIERE FACEBOOK ES QUE SI EL USUARIO RECHAZÓ DAR LOS PERMISOS, NO SE PREGUNTE FRECUENTEMENTE.
					 *  A PARTIR DE ESTO SE PODRÁ DECIDIR SI VOLVER A PREGUNTAR O NO, PODRÍA SER CON EL USO DE COOKIES O ALGO ASÍ.
					 *  AUNQUE SI SÓLO SE REVISARÁ AL ENTRAR A UNA FUNCIÓN EN ESPECÍFICO DE LA PÁGINA, NO VERÍA TANTO PROBLEMA QUE SE PREGUNTE DE NUEVO.
					 */
					console.log(data);
				}
			});
		},
		getPublishPermissions: function(){
			FB.login(function(response){
				if(response.status === 'connected'){
					$.ajax({
						url: 'remote/users/setPublishPermissions/',
						type: 'POST',
						dataType: 'json',
						data: {oAuthToken: response.authResponse.accessToken},
						statusCode:{
							400: function(data){
								console.log(data.responseJSON.meta.detail);
							}
						},
						success: function(data){
							console.log(data);
							if(data.response.granted){
								/*
								 *  EDITAR CÓDIGO PARA CUANDO FUERON CONCEDIDOS LOS PERMISOS.
								 *  SE PUEDE TAMBIÉN IMPRIMIER EL MENSAJE EN data.meta.detail
								 */
							}else{
								/*
								 *  EDITAR CÓDIGO PARA CUANDO NO FUERON CONCEDIDOS LOS PERMISOS.
								 *  SE PUEDE TAMBIÉN IMPRIMIER EL MENSAJE EN data.meta.detail
								 */
							}
						}
					});
				}else if (response.status === 'not_authorized'){
					console.log('Please log into this app.');
				}else{
					console.log('Please log into Facebook.');
				}
			},{scope: 'publish_actions'});
		}
	});
});

$(document).ready(function(){
	$("[name=logout]").click(function(){
		$.logout();
	});
	$("[name=checkPublishPermissions]").click(function(){
		$.checkPublishPermissions();
	});
	$("[name=publishPermissions]").click(function(){
		$.getPublishPermissions();
	});
	$("[name=segmentoDatos] [name=pais]").change(function(){
		var country = $("[name=segmentoDatos] [name=pais]").val();
		$.listStates(country);
		if(country == 1 || country == 2)
			$("[name=segmentoDatos] [name=estado]").closest("div").show();
		else
			$("[name=segmentoDatos] [name=estado]").closest("div").hide();
	});
	$("[name=segmentoDatos] [name=botonGuardar]").click(function(){
		$.saveData();
	});
	var checkData = Cookies.get('revisar_datos');

	if(checkData == undefined){
		Cookies.set('revisar_datos', '1', { expires: .5 });
		$.showDataWindow();
	}
});