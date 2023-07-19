/**
 * Site navigation functionality
 *
 * @package
 * @since 1.0.0
 */

export const Nav = () => {
	const nullMenuLinks = document.querySelectorAll( '.menu-item a[href="#"]' );
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Disable placeholder menu links.

	Array.from( nullMenuLinks ).forEach( ( nullLink ) => {
		nullLink.addEventListener( 'click', ( event ) => {
			event.preventDefault();
		} );
	} );

	// Expand navigation top level parent menu items on toggle click.

	if ( siteNavigation ) {
		siteNavigation.addEventListener(
			'click',
			function ( event ) {
				let menuToggleButton = event.target;

				while ( menuToggleButton ) {
					if (
						// The element clicked is a menu toggle button.
						menuToggleButton.nodeName === 'LI' &&
						( /menu-item-has-children/.test(
							menuToggleButton.className
						) ||
							/mega-menu-content/.test(
								menuToggleButton.className
							) )
					) {
						// Toggle the submenu with open class and update [aria-expanded] value.
						const menuToggleLink =
							menuToggleButton.querySelector( 'a' );

						menuToggleButton.classList.toggle( 'open' );

						if (
							menuToggleLink.getAttribute( 'aria-expanded' ) ===
							'true'
						) {
							menuToggleLink.setAttribute(
								'aria-expanded',
								'false'
							);
						} else {
							menuToggleLink.setAttribute(
								'aria-expanded',
								'true'
							);
						}
						break;
					}

					// Otherwise check the next parent node.
					menuToggleButton = menuToggleButton.parentNode;
				}
			},
			false
		);
	}
};
