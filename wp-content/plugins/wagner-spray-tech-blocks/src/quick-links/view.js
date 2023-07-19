/**
 * Change the classname of the quick links element when the user scrolls past - only on desktop browsers.
 *
 */

import { scrollPositionEventHandler } from '../utils/scrollEventHandler';
const quickLinks = document.querySelector( '.wp-block-wst-blocks-quick-links' );
const header = document.querySelector( '.c-site-header' );
const fixedClassName = 'fixed';

const addElementFixed = () => {
	quickLinks.classList.add( fixedClassName );
	quickLinks.style.top = `${ header.offsetHeight }px`;
};

const removeElementFixed = () => {
	quickLinks.classList.remove( fixedClassName );
	quickLinks.style.top = '0';
};

const activate = () => {
	if ( ! quickLinks ) return;

	if ( window.matchMedia( '(max-width: 1024px)' ).matches ) return;

	const quickLinksBottom =
		quickLinks.offsetTop + quickLinks.offsetHeight - 100;

	scrollPositionEventHandler(
		quickLinksBottom,
		addElementFixed,
		removeElementFixed
	);
};

activate();
