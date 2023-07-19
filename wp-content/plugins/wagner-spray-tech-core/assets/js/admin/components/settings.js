/* global jQuery */

( function ( $ ) {
	$( '#wagnerspraytech_core_plugin_test_mode' )
		.on( 'change', function () {
			const $testModeCB = $( this );
			const $testModeRow = $testModeCB.closest( 'tr' );

			if ( $testModeCB.is( ':checked' ) ) {
				$testModeRow.siblings( '.test' ).show();
				$testModeRow.siblings().not( '.test' ).not( '.global' ).hide();
			} else {
				$testModeRow.siblings().not( '.test' ).show();
				$testModeRow.siblings( '.test' ).hide();
			}
		} )
		.trigger( 'change' );
} )( jQuery );
