import {
	getBlockVariations,
	unregisterBlockVariation,
} from '@wordpress/blocks';
import domeReady from '@wordpress/dom-ready';

/**
 * Unregister block variations.
 */
domeReady( () => {
	const allowedEmbedVariants = [
		'soundcloud',
		'twitter',
		'vimeo',
		'youtube',
	];

	getBlockVariations( 'core/embed' ).forEach( ( variant ) => {
		if ( ! allowedEmbedVariants.includes( variant.name ) ) {
			unregisterBlockVariation( 'core/embed', variant.name );
		}
	} );
} );
