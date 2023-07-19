/**
 * Iterates through all Media Content Selector carousel
 * blocks found on the current page and initialises them.
 */
function initialiseCarousel() {
	const items = document.querySelectorAll( '.wst-blocks-glide' );

	// If there are no carousels, bail early.
	if ( ! items.length ) {
		return;
	}

	// Loop through carousels and initialise each.
	items.forEach( function ( item ) {
		// Get the number of slides to show on desktop.
		const desktopSlides =
			Number( item.getAttribute( 'data-desktop-slides' ) ) || 4;
		// Define the carousel settings.
		const settings = {
			config: {
				type: 'slider',
				bound: true,
				perView: desktopSlides,
				gap: 20,
				breakpoints: {
					1200: {
						perView: 4,
					},
					1024: {
						perView: 3,
					},
					850: {
						perView: 2,
					},
					600: {
						perView: 2,
					},
					340: {
						perView: 1,
					},
				},
			},
		};

		new window.Glide( item, settings.config ).mount();
	} );
}

/**
 * Handles the carousel functionality.
 */
if ( document.readyState === 'loading' ) {
	// The DOM has not yet been loaded.
	document.addEventListener( 'DOMContentLoaded', initialiseCarousel );
} else {
	// The DOM has already been loaded.
	initialiseCarousel();
}
