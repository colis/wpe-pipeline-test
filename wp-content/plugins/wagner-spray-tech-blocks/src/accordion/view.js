/**
 * Accordion block init functionality
 */

'use strict';

const AeBlocksAccordion = require( './accordion.js' );

// Find all accordions.
export const aeBlocksFindAccordions = () => {
	const accordions = document.querySelectorAll(
		'.js-wp-block-wst-blocks-accordion'
	);

	return accordions;
};

// Init accordions.
export const aeBlocksInitAccordions = ( accordions ) => {
	accordions.forEach( ( accordionEl ) => {
		new AeBlocksAccordion( accordionEl );
	} );
};

/**
 * Handles the carousel functionality.
 */
if ( document.readyState === 'loading' ) {
	// The DOM has not yet been loaded.
	document.addEventListener(
		'DOMContentLoaded',
		aeBlocksInitAccordions( aeBlocksFindAccordions() )
	);
} else {
	// The DOM has already been loaded.
	aeBlocksInitAccordions( aeBlocksFindAccordions() );
}
