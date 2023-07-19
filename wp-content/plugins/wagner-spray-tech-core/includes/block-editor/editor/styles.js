import { registerBlockStyle, unregisterBlockStyle } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';

/**
 * Block style settings.
 */
domReady( () => {
	unregisterBlockStyle( 'core/button', 'outline' );
	unregisterBlockStyle( 'core/quote', 'plain' );
	unregisterBlockStyle( 'core/separator', 'dots' );
	unregisterBlockStyle( 'core/separator', 'wide' );
	unregisterBlockStyle( 'core/table', 'stripes' );
	unregisterBlockStyle( 'core/table', 'stripes' );

	// Button.

	registerBlockStyle( 'core/button', {
		name: 'fill-icon',
		label: 'Fill - Icon',
	} );

	registerBlockStyle( 'core/button', {
		name: 'outline',
		label: 'Outline',
	} );

	registerBlockStyle( 'core/button', {
		name: 'outline-icon',
		label: 'Outline - Icon',
	} );

	registerBlockStyle( 'core/button', {
		name: 'text-icon',
		label: 'Text - Icon',
	} );

	// Quote.

	registerBlockStyle( 'core/quote', {
		name: 'border-yellow',
		label: 'Border - Yellow',
	} );

	registerBlockStyle( 'core/quote', {
		name: 'plain',
		label: 'Plain',
	} );
} );
