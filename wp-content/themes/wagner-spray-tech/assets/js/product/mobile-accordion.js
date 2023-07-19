/**
 * Create a accordion wrapper replacing each content section.
 */

const className = `c-product-accordion-item`;
const AeBlocksAccordion = require( '../../../../../plugins/wagner-spray-tech-blocks/src/accordion/accordion.js' );

export const mobileAccordion = () => {
	if ( ! document.querySelector( 'body.single-product' ) ) {
		return;
	}

	const contentSections = document.querySelectorAll(
		'.entry-content > .wp-block-group'
	);

	if ( ! contentSections ) {
		return;
	}

	contentSections.forEach( createContentSection );
};

/**
 * Create each accordion item.
 *
 * @param {Element} element
 */
const createContentSection = ( element ) => {
	// Content.
	const titleElement = element.querySelector( '.wp-block-heading' );
	const title =
		titleElement.textContent ||
		element.id.replaceAll( '-', ' ' ).replaceAll( '_', ' ' );

	titleElement.remove();

	const content = element.innerHTML;
	const container = document.createElement( 'div' );

	container.classList.add( className );
	container.id = element.id;

	container.appendChild( createTitle( title, element.id ) );
	container.appendChild( createContainer( content, element.id ) );

	element.parentNode.replaceChild( container, element );

	new AeBlocksAccordion( container );
};

/**
 * Create accordion title element.
 *
 * @param {string} content
 * @param {string} contentId
 */
const createTitle = ( content, contentId ) => {
	const container = document.createElement( 'h4' );
	// Going to replicate the buttons from wp-content/plugins/wagner-spray-tech-blocks/src/accordion-item/save.js.
	const button = document.createElement( 'button' );
	const span = document.createElement( 'span' );

	container.classList.add( `${ className }__title` );

	button.type = 'button';
	button.setAttribute( 'aria-expanded', 'true' );
	button.setAttribute( 'aria-controls', `${ contentId }-content` );
	button.classList.add( `${ className }__trigger` );
	button.textContent = content;
	button.id = `${ className }-accordion-button`;

	span.classList.add( 'accordion-marker' );
	span.innerHTML = '<span class="svg-icon icon-plus-minus"></span>';

	button.appendChild( span );
	container.appendChild( button );

	return container;
};

/**
 * Create accordion content element.
 *
 * @param {string} content
 * @param {string} contentId
 */
const createContainer = ( content, contentId ) => {
	const container = document.createElement( 'div' );

	container.classList.add( `${ className }__content` );
	container.id = `${ contentId }-content`;
	container.innerHTML = content;

	return container;
};
