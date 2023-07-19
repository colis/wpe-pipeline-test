/**
 * Product Gallery Desktop Navigation.
 */

export const productGalleryDesktop = () => {
	/**
	 * Scroll the thumbnails up and down.
	 */
	const scrollThumbnails = () => {
		const productGalleryThumbnails = document.querySelector(
			'.c-post-hero__gallery .c-post-hero__thumbnails'
		);

		if ( ! productGalleryThumbnails ) {
			return;
		}

		const navButtons =
			productGalleryThumbnails.querySelectorAll( '.thumbnails-nav' );
		const thumbnailList = productGalleryThumbnails.querySelector( 'ul' );
		const thumbnailHeight =
			thumbnailList.querySelector( 'img' ).offsetHeight * 2;

		navButtons.forEach( ( button ) => {
			button.addEventListener( 'click', ( e ) => {
				const direction = e.target.dataset.direction ?? 'next';

				switch ( direction ) {
					case 'prev':
						thumbnailList.scrollTo( {
							top: thumbnailList.scrollTop - thumbnailHeight,
							behavior: 'smooth',
						} );
						break;

					case 'next':
						thumbnailList.scrollTo( {
							top: thumbnailList.scrollTop + thumbnailHeight,
							behavior: 'smooth',
						} );
						break;
				}
			} );
		} );
	};

	/**
	 * Set the featured image when a thumbnail is clicked.
	 */
	const setFeaturedImage = () => {
		const productGalleryThumbnails = document.querySelectorAll(
			'.c-page-hero__product .c-post-hero__thumbnails img'
		);

		if ( ! productGalleryThumbnails ) {
			return;
		}

		const productGalleryFeaturedImage = document.querySelector(
			'.c-page-hero__product .featured-image img'
		);

		productGalleryThumbnails.forEach( ( btn ) => {
			btn.addEventListener( 'click', ( e ) => {
				const fullImage = e.target.dataset.full;

				if ( fullImage ) {
					productGalleryFeaturedImage.removeAttribute( 'srcset' );
					productGalleryFeaturedImage.src = fullImage;
				}
			} );
		} );
	};

	scrollThumbnails();
	setFeaturedImage();
};
