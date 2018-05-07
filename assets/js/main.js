(function($) {

	skel.breakpoints({
		wide: '(max-width: 1680px)',
		normal: '(max-width: 1280px)',
		narrow: '(max-width: 980px)',
		narrower: '(max-width: 840px)',
		mobile: '(max-width: 736px)',
		mobilep: '(max-width: 480px)'
	});

	$(document).ready(function(){
		var consulta;
		//hacemos focus al campo de búsqueda
		$("#busqueda").focus();
		//comprobamos si se pulsa una tecla
		$("#busqueda").keyup(function(e){
			//obtenemos el texto introducido en el campo de búsqueda
			consulta = $("#busqueda").val();
			//hace la búsqueda
			$.ajax({
				type: "POST",
				url: "buscar.php",
				data: "b="+consulta,
				dataType: "html",
				beforeSend: function(){
				      //imagen de carga
				      $("#resultado").html("<p align='center'>no hay</p>");
				},
				error: function(){
				      alert("error petición ajax");
				},
				success: function(data){                                                    
				      $("#resultado").empty();
				      $("#resultado").append(data);
				                                         
				}
			});
		});                                                  
	});

	$(document).ready(function(){
		var consulta;
		//comprobamos si se pulsa una tecla
		$("#servicio").change(function(){
			//obtenemos el texto introducido en el campo de búsqueda
			consulta = $("#servicio").val();

			if (consulta == 7 || consulta == 9){
				$('#dosis').removeAttr('disabled');
			}
			else{
				$('#dosis').attr('disabled', 'disabled');
			}
			//hace la búsqueda
			$.ajax({
				type: "POST",
				url: "informacion.php",
				data: "c="+consulta,
				dataType: "html",
				beforeSend: function(){
				      //imagen de carga
				      $("#resul").html("<p align='center'>seleccione</p>");
				},
				error: function(){
				      alert("error petición ajax");
				},
				success: function(data){                                                    
				      $("#resul").empty();
				      $("#resul").append(data);
				                                         
				}
			});
		});                                                 
	});

	$("#act").click(function(){
		$(this).toggleClass("btn-danger btn-success");
	});

	$('#categoria').change(function(){
		var valorCambiado =$(this).val();
		if((valorCambiado == 'universitario') || (valorCambiado == 'docente')){
			$('#selector').css('display','block');
		}
		else{
			$('#selector').css('display','none');
		}
	});

	$('#servicio').change(function(){
		var valorCambiado =$(this).val();
		if((valorCambiado == 'universitario') || (valorCambiado == 'docente')){
			$('#selector').css('display','block');
		}
		else{
			$('#selector').css('display','none');
		}
	});
	$('#tipo').change(function(){
		var valorCambiado =$(this).val();
		if((valorCambiado == 'vacuna')){
			$('#dosis').css('display','block');
		}
		else{
			$('#dosis').css('display','none');
		}
	});

	$(function() {

		var	$window = $(window),
			$body = $('body'),
			$header = $('#header'),
			$banner = $('#banner');

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on narrower.
			skel.on('+narrower -narrower', function() {
				$.prioritize(
					'.important\\28 narrower\\29',
					skel.breakpoint('narrower').active
				);
			});

		// Dropdowns.
			$('#nav > ul').dropotron({
				alignment: 'right'
			});

		// Off-Canvas Navigation.

			// Navigation Button.
				$(
					'<div id="navButton">' +
						'<a href="#navPanel" class="toggle"></a>' +
					'</div>'
				)
					.appendTo($body);

			// Navigation Panel.
				$(
					'<div id="navPanel">' +
						'<nav>' +
							$('#nav').navList() +
						'</nav>' +
					'</div>'
				)
					.appendTo($body)
					.panel({
						delay: 500,
						hideOnClick: true,
						hideOnSwipe: true,
						resetScroll: true,
						resetForms: true,
						side: 'left',
						target: $body,
						visibleClass: 'navPanel-visible'
					});

			// Fix: Remove navPanel transitions on WP<10 (poor/buggy performance).
				if (skel.vars.os == 'wp' && skel.vars.osVersion < 10)
					$('#navButton, #navPanel, #page-wrapper')
						.css('transition', 'none');

		// Header.
		// If the header is using "alt" styling and #banner is present, use scrollwatch
		// to revert it back to normal styling once the user scrolls past the banner.
		// Note: This is disabled on mobile devices.
			if (!skel.vars.mobile
			&&	$header.hasClass('alt')
			&&	$banner.length > 0) {

				$window.on('load', function() {

					$banner.scrollwatch({
						delay:		0,
						range:		0.5,
						anchor:		'top',
						on:			function() { $header.addClass('alt reveal'); },
						off:		function() { $header.removeClass('alt'); }
					});

				});

			}

	});

})(jQuery);