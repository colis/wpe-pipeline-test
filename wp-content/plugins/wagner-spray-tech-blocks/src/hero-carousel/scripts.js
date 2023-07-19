/* global Glide */
/**
 * Initialize the Hero Carousel block.
 */

const windowWidth = window.innerWidth;
const heroCarousel = document.querySelector( '.js-hero-carousel' );
const glideCarousel = new Glide( heroCarousel, {
	type: 'carousel',
	animationDuration: 600,
	animationTimingFunc: 'ease',
	bound: true,
	gap: 32,
	perView: 1,
	peek: ( windowWidth - 1544 ) / 2,
	breakpoints: {
		1750: {
			peek: ( windowWidth / 100 ) * 8,
		},
		1024: {
			peek: 0,
			gap: 24,
		},
		781: {
			peek: 0,
			gap: 16,
		},
	},
} );

function heroCarouselActiveSlide( focusState ) {
	const activeSlide = heroCarousel.querySelector( '.glide__slide--active' );
	const activeSlideButton = activeSlide.querySelector(
		'.wp-block-button__link'
	);
	const allButtons = heroCarousel.querySelectorAll(
		'.wp-block-button__link'
	);

	allButtons.forEach( ( button ) => {
		button.setAttribute( 'tabindex', '-1' );
	} );

	activeSlideButton.setAttribute( 'tabindex', '0' );

	if ( focusState === true ) {
		activeSlideButton.focus();
	}
}

glideCarousel.on( 'mount.after', function () {
	heroCarouselActiveSlide( false );
} );

glideCarousel.on( 'run.after', function () {
	heroCarouselActiveSlide( true );
} );

glideCarousel.mount();
