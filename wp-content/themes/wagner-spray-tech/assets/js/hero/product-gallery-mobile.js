/**
 * Product Gallery Mobile Navigation.
 */
import Glide from '@glidejs/glide';
import { changeElementTag } from '../helper/element';

export const productGalleryMobile = () => {
	let productGallery = document.querySelector(
		'.c-post-hero__details .c-post-hero__thumbnails'
	);

	if ( ! productGallery ) {
		return;
	}

	productGallery = changeElementTag( productGallery, 'div' );
	productGallery.setAttribute( 'class', 'glide__track' );
	productGallery.setAttribute( 'data-glide-el', 'track' );
	productGallery
		.querySelectorAll( '.thumbnails-nav' )
		.forEach( ( button ) => {
			button.remove();
		} );

	productGallery
		.querySelector( 'ul' )
		.setAttribute( 'class', 'glide__slides' );

	const slides = productGallery.querySelectorAll( 'li' );

	slides.forEach( ( li ) => {
		li.classList.add( 'glide__slide' );
		li.querySelector( 'img' ).setAttribute( 'height', '300px' );
		li.querySelector( 'img' ).setAttribute( 'width', '300px' );
	} );

	const productGalleryWrapper = document.createElement( 'div' );
	productGalleryWrapper.setAttribute( 'class', 'glide' );

	productGallery.parentNode.insertBefore(
		productGalleryWrapper,
		productGallery
	);

	productGalleryWrapper.appendChild( productGallery );

	const bullets = document.createElement( 'div' );
	bullets.setAttribute( 'class', 'glide__bullets' );
	bullets.setAttribute( 'data-glide-el', 'controls[nav]' );

	slides.forEach( ( li, index ) => {
		const bullet = document.createElement( 'button' );
		bullet.setAttribute( 'class', 'glide__bullet' );
		bullet.setAttribute( 'data-glide-dir', `=${ index }` );
		bullets.appendChild( bullet );
	} );

	productGalleryWrapper.appendChild( bullets );

	new Glide( productGalleryWrapper ).mount();
};
