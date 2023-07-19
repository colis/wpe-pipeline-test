/**
 * Buy now Button Events.
 *
 */

export const buyNowButtonEvents = () => {
	document
		.querySelectorAll( '.product-buy-btn .wp-element-button' )
		.forEach( ( button ) => {
			button.addEventListener( 'click', ( event ) => {
				if ( event.target.classList.contains( 'is-price-spider' ) ) {
					doPriceSpider( event.target );
				}
			} );
		} );
};

const doPriceSpider = () => {
	// eslint-disable-next-line no-alert,no-undef
	alert( 'Open Price Spider Popup' );
};
