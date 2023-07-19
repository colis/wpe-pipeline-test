/**
 * Mobile Navigation.
 *
 * Required to open and close the mobile navigation.
 */
export const mobileFooterNav = () => {
	/**
	 * Footer Menu Toggle Behaviors
	 *
	 * @param {string} id Navigation ID
	 */

	// Open and close the footer navigation.
	const footerNavTriggerLink = document.querySelectorAll(
		'.footer-navigation .menu-item-has-children > a'
	);

	// Add button to footerNavTriggerLink.
	footerNavTriggerLink.forEach( ( item ) => {
		item.innerHTML += '<button class="menu-item-expand-toggle"></button>';
	} );

	const footerNavTrigger = document.querySelectorAll(
		'.footer-navigation .menu-item-expand-toggle'
	);

	// Loop through each footer navigation item.
	footerNavTrigger.forEach( ( item ) => {
		// Add click event to each footer navigation item.
		item.addEventListener( 'click', ( e ) => {
			// Prevent default click behavior.
			e.preventDefault();

			// Toggle the class "menu-item-expanded" on the list item.
			item.parentElement.parentElement.classList.toggle(
				'menu-item-expanded'
			);

			// Toggle aria-expanded true/false to the parent footerNavTriggerLink element.
			item.parentElement.parentElement.querySelector( 'a' ).ariaExpanded =
				item.parentElement.parentElement.querySelector( 'a' )
					.ariaExpanded === 'true'
					? 'false'
					: 'true';

			// Toggle all other footer navigation items to close.
			footerNavTrigger.forEach( ( trigger ) => {
				if (
					trigger.parentElement.parentElement.classList.contains(
						'menu-item-expanded'
					)
				) {
					if ( trigger !== e.target ) {
						trigger.parentElement.parentElement.classList.toggle(
							'menu-item-expanded'
						);

						trigger.parentElement.parentElement.querySelector(
							'a'
						).ariaExpanded =
							trigger.parentElement.parentElement.querySelector(
								'a'
							).ariaExpanded === 'true'
								? 'false'
								: 'true';
					}
				}
			} );
		} );
	} );
};
