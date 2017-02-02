/* global wcPagarmeParams, PagarMe */
(function( $ ) {
	'use strict';
	$( function() {	

		$('.tabs-tab').on( 'click', function(){
			$('#save_button').show();
		});

		$('.tabs-tab.adress').on( 'click', function(){
			$('#save_button').hide();
		});

		$('.gerenciar-loja-js').on( 'click', function(){
			var page = $(this).attr('href');
			$(location).attr('href', page );
		});

	});
}( jQuery ));