/**
 * S&F Filter Accordion.
 *
 * @package
 * @since 1.0.0
 */

export const sfAccordions = () => {
	// SF Accordions Container.
	const sfFilterAccordions = document.querySelector(
		'.wst-listing-search-results'
	);

	// Set S&F Form filters to closed by default.
	const searchAndFilterForms = document.querySelectorAll( [
		'[id^="search-filter-form-"]',
	] );

	[ ...searchAndFilterForms ].forEach( ( searchAndFilterForm ) => {
		const filters = searchAndFilterForm.querySelectorAll(
			'[data-sf-field-input-type="checkbox"]'
		);

		[ ...filters ].forEach( ( filter ) => closeAccordion( filter ) );
	} );

	if ( sfFilterAccordions ) {
		// Get all Checkbox & Radio Filters.
		const sfFilters = sfFilterAccordions.querySelectorAll(
			'[data-sf-field-input-type="checkbox"], [data-sf-field-input-type="radio"]'
		);
		const sfFiltersForm =
			sfFilterAccordions.querySelector( '.searchandfilter' );

		if ( sfFilters.length > 0 ) {
			for ( let i = 0; i < sfFilters.length; i++ ) {
				// Set aria-hidden attribute to false for the filter content that is not closed.
				if ( ! sfFilters[ i ].classList.contains( 'closed' ) ) {
					const filterContent = sfFilters[ i ].querySelector( 'ul' );
					if ( filterContent ) {
						filterContent.setAttribute( 'aria-hidden', 'false' );
					}
				}

				// Set tabindex to 0 for the filter heading.
				sfFilters[ i ]
					.querySelector( 'h4, .sf-field-heading' )
					.setAttribute( 'tabindex', '0' );

				// Toggle class 'closed' and aria-hidden attribute on click for the filter.
				sfFilters[ i ].addEventListener( 'click', toggleAccordion );

				// Add keypress event listener for the filter heading.
				sfFilters[ i ].addEventListener( 'keypress', function ( e ) {
					if (
						e.target ===
							sfFilters[ i ].querySelector(
								'h4, .sf-field-heading'
							) &&
						e.key === 'Enter'
					) {
						toggleAccordion( e );
					}
				} );
			}
		}

		// Mobile Functionality.
		if ( sfFiltersForm ) {
			const doesFiltersButtonExist =
				sfFiltersForm.querySelectorAll( '.js-filters-button' );

			if ( doesFiltersButtonExist.length === 0 ) {
				let filtersButton =
					'<button class="sf-filters-button button js-filters-button" aria-expanded="false"><span>Filters</span></button>';
				sfFiltersForm.insertAdjacentHTML( 'afterbegin', filtersButton );
				filtersButton = document.querySelector( '.js-filters-button' );

				// Add click event listener for the filters button to show/hide the filters.
				filtersButton.addEventListener(
					'click',
					function ( event ) {
						event.preventDefault();
						const form = event.target.closest( '.searchandfilter' );
						const list = form.querySelector( 'ul' );
						// Toggle the mobile search accordion.
						form.classList.toggle( 'toggled' );
						list.setAttribute(
							'aria-hidden',
							list.getAttribute( 'aria-hidden' ) === 'false'
								? 'true'
								: 'false'
						);
						filtersButton.setAttribute(
							'aria-expanded',
							filtersButton.getAttribute( 'aria-expanded' ) ===
								'false'
								? 'true'
								: 'false'
						);
					},
					false
				);
			}
		}
	}
};

// Close Accordion.
export const closeAccordion = ( accordion ) => {
	accordion.classList.add( 'closed' );
	accordion.querySelector( 'ul' ).setAttribute( 'aria-hidden', 'true' );
};

// Open/Close Accordion.
export const toggleAccordion = ( e ) => {
	e.target.parentNode.classList.toggle( 'closed' );
	const clickedFilterContent = e.target.parentNode.querySelector( 'ul' );
	if ( clickedFilterContent ) {
		clickedFilterContent.setAttribute(
			'aria-hidden',
			clickedFilterContent.getAttribute( 'aria-hidden' ) === 'false'
				? 'true'
				: 'false'
		);
	}
};
