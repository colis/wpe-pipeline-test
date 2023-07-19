/**
 * Move the Product Buy Now button to bottom of screen when a user reaches a scroll point.
 */

import { scrollPositionEventHander } from '../helper/scrolling';

export const productBuyButtonMobile = () => {
	const productBuyButton = document.querySelector(
		'.c-page-hero__product .product-buy-btn'
	);

	if ( ! productBuyButton ) return;

	const moveBtnToBottom = () => {
		productBuyButton.classList.add( 'is-fixed' );
	};

	const restoreBtn = () => {
		productBuyButton.classList.remove( 'is-fixed' );
	};

	scrollPositionEventHander( 300, moveBtnToBottom, restoreBtn );
};
