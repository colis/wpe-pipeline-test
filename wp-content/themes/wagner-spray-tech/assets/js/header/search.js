/**
 * Header Search functionality
 *
 * @package
 * @since 1.0.0
 */

export const headerSearch = () => {
	const headerSearchToggle = document.querySelector(
		'.js-header-search-toggle'
	);

	const headerSearchForm = document.querySelector( '.js-header-search-form' );

	headerSearchToggle.addEventListener(
		'click',
		function () {
			document.body.classList.remove( 'primary-navigation-open' );
			document.body.classList.toggle( 'header-search-open' );

			// If the search form is currently hidden.
			if ( headerSearchForm.getAttribute( 'aria-hidden' ) === 'true' ) {
				// Show the search form and set focus to the search input.
				headerSearchForm.setAttribute( 'aria-hidden', 'false' );
				headerSearchForm.querySelector( 'input' ).focus();
			} else {
				// Hide the search form and set focus to the search button.
				headerSearchForm.setAttribute( 'aria-hidden', 'true' );
				headerSearchToggle.focus();
			}
		},
		false
	);
};
