/* global jQuery */

/**
 * Front end JS.
 */

// Accessibility.
import {
	buttonBlocks,
	tableBlocks,
	sfHeadings,
} from './accessibility/accessibility';

// Header.
import { mobileNav } from './header/mobile-nav';
import { headerSearch } from './header/search';
import { mobileFooterNav } from './footer/mobile-footer-nav';

// Hero.
import { productGalleryMobile } from './hero/product-gallery-mobile';
import { productGalleryDesktop } from './hero/product-gallery-desktop';
import { productBuyButtonMobile } from './hero/product-buy-button-mobile';

// Buttons.
import { buyNowButtonEvents } from './button/buy-now';

// Search & Filter.
import { sfAccordions } from './search-filter/search-filter';

// Product Pages.
import { mobileAccordion } from './product/mobile-accordion';

// General.
window.addEventListener( 'DOMContentLoaded', () => {
	// For all browsers.
	buttonBlocks();
	buyNowButtonEvents();
	headerSearch();
	sfAccordions();
	sfHeadings();
	tableBlocks();

	// Mobile Actions.
	if ( window.matchMedia( '(max-width: 1024px)' ).matches ) {
		mobileNav();
		mobileFooterNav();
		productBuyButtonMobile();
		productGalleryMobile();
		mobileAccordion();
	}

	// Desktop Actions.
	if ( window.matchMedia( '(min-width: 1024px)' ).matches ) {
		productGalleryDesktop();
	}
} );

// Search & Filter - on ajax finish.
jQuery( document ).on( 'sf:ajaxfinish', '.searchandfilter', function () {
	sfAccordions();
	sfHeadings();
} );
