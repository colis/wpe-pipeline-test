/**
 * Site accessibility fixes
 *
 * @package
 * @since 1.0.0
 */

/* Gutenberg Button Blocks */

// Task: Add [tabindex] attribute to Gutenberg Button blocks.
// Reason: Resolves issue with button focus being skipped by the keyboard.

export const buttonBlocks = () => {
	const gutenbergButtons = document.querySelectorAll(
		'.wp-block-button__link'
	);

	if ( gutenbergButtons ) {
		gutenbergButtons.forEach( function ( gutenbergButton ) {
			gutenbergButton.setAttribute( 'tabindex', '0' );
		} );
	}
};

/* Gutenberg Table Block */

// Task: Add `scope="col"` and `scope="row"` attributes to Gutenberg Table blocks.
// Reason: Resolves issue with table headings not being read by screen readers.

export const tableBlocks = () => {
	const gutenbergTable = document.querySelector( '.wp-block-table' );

	if ( gutenbergTable ) {
		const gutenbergTableHeadings = document.querySelectorAll(
			'.wp-block-table thead th'
		);
		gutenbergTableHeadings.forEach( function ( gutenbergTableHeading ) {
			gutenbergTableHeading.setAttribute( 'scope', 'col' );
		} );
		const gutenbergTableRows = document.querySelectorAll(
			'.wp-block-table tbody tr'
		);
		gutenbergTableRows.forEach( function ( gutenbergTableRow ) {
			gutenbergTableRow.setAttribute( 'scope', 'row' );
		} );
	}
};

/* Search & Filter Pro */

// Task: Convert filter field headings from <h4> to <p> elements, and add class.
// Reason: Resolves issue with heading levels being skipped.

export const sfHeadings = () => {
	const sfFilterHeadings = document.querySelectorAll( '.searchandfilter h4' );

	if ( sfFilterHeadings ) {
		sfFilterHeadings.forEach( function ( sfFilterHeading ) {
			const newItem = document.createElement( 'p' );
			newItem.classList.add( 'sf-field-heading' );
			newItem.innerHTML = sfFilterHeading.innerHTML;
			sfFilterHeading.parentNode.replaceChild( newItem, sfFilterHeading );
			sfFilterHeading.remove();
		} );
	}
};
