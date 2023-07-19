/**
 * Mobile Navigation.
 *
 * Required to open and close the mobile navigation.
 */
export const mobileNav = () => {
	/**
	 * Menu Toggle Behaviors
	 *
	 * @param {string} id Navigation ID
	 */
	const navMenu = ( id ) => {
		const html = document.documentElement;
		const body = document.body;
		const openButton = document.getElementById( id + '-open-menu' );
		const closeButton = document.getElementById( id + '-close-menu' );

		if ( openButton && closeButton ) {
			openButton.onclick = () => {
				body.classList.remove( 'header-search-open' );
				body.classList.add( id + '-navigation-open' );
				html.classList.add( 'lock-scrolling' );
				body.classList.add( 'lock-scrolling' );
				closeButton.focus();
			};

			closeButton.onclick = () => {
				body.classList.remove( id + '-navigation-open' );
				html.classList.remove( 'lock-scrolling' );
				body.classList.remove( 'lock-scrolling' );
				openButton.focus();
			};
		}
		/**
		 * Trap keyboard navigation in the menu modal.
		 * Adapted from TwentyTwenty
		 */
		document.addEventListener( 'keydown', ( event ) => {
			if ( ! body.classList.contains( id + '-navigation-open' ) ) {
				return;
			}

			const modal = document.querySelector( '.' + id + '-navigation' );
			const selectors = 'input, a, button';

			let elements = modal.querySelectorAll( selectors );
			elements = Array.prototype.slice.call( elements );

			const tabKey = event.keyCode === 9;
			const shiftKey = event.shiftKey;
			const escKey = event.keyCode === 27;
			const activeEl = document.activeElement; /* eslint-disable-line */
			const lastEl = elements[ elements.length - 1 ];
			const firstEl = elements[ 0 ];

			if ( escKey ) {
				event.preventDefault();
				body.classList.remove(
					id + '-navigation-open',
					'lock-scrolling'
				);
				openButton.focus();
			}

			if ( ! shiftKey && tabKey && lastEl === activeEl ) {
				event.preventDefault();
				firstEl.focus();
			}

			if ( shiftKey && tabKey && firstEl === activeEl ) {
				event.preventDefault();
				lastEl.focus();
			}

			// If there are no elements in the menu, don't move the focus
			if ( tabKey && firstEl === lastEl ) {
				event.preventDefault();
			}
		} );
	};

	window.addEventListener( 'load', () => {
		navMenu( 'primary' );
	} );
};
