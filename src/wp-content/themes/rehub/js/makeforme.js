/* global wcPagarmeParams, PagarMe */
(function( $ ) {
	'use strict';
	$( function() {

		//Hide dashboardmenu page setting
		var classActive = $('#dashboard-menu-item-settings').attr('class');
		if( classActive != "active" ){
			$('.wcv-navigation').show();
			$('.title').show();
		}	

		//show save button settings
		$('.tabs-tab').on( 'click', function(){
			$('#save_button').show();
		});

		//hide save button settings adress
		$('.tabs-tab.adress').on( 'click', function(){
			$('#save_button').hide();
		});

		//Redirect btn tab-nav gerenciarloja
		$('.gerenciar-loja-js').on( 'click', function(){
			var page = $(this).attr('href');
			$(location).attr('href', page );
		});


		//Avancar Form Sign-up maker
		$('.js-avancar').on( 'click', function( e ){
			var page = $(this).attr('href').replace("#" , "");
			var cpf = $('#_wcv_custom_settings_cpf_cnpj_maker').val();
			var residencia = $('#_wcv_custom_settings_comprovante_residencia_maker').val();

			if ( page == "branding" ) {
				if ( cpf == "" ){
					alert("Por favor, anexe o documento de CPF ou CNPJ do Maker");
					return;
				} 
				if ( residencia == "" ){
					alert("Por favor, anexe o Comprovante de Residência do Maker");
					return;
				} 
			}
			
			page = "a."+page;
			$('.tabs-nav li').removeClass();
			var aba = $( page );
			aba.addClass('teste');
			aba[0].click();
		});

		


	});
}( jQuery ));