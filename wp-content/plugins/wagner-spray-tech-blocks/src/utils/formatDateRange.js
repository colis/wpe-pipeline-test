/**
 * Format the date range
 *
 * @param {string}  startDate The start date.
 * @param {string}  endDate   The end date.
 * @param {boolean} showYear  Whether to show the year.
 *
 * @return {string} The formatted date range.
 */
export const formatDateRange = ( startDate, endDate, showYear = false ) => {
	const parsedStartDate = new Date( startDate );
	const parsedEndDate = new Date( endDate );

	if ( ! isValidDate( parsedStartDate ) || ! isValidDate( parsedEndDate ) ) {
		return '';
	}

	const startDay = parsedStartDate.toLocaleString( 'en-US', {
		day: 'numeric',
	} );
	const endDay = parsedEndDate.toLocaleString( 'en-US', { day: 'numeric' } );
	const startMonth = parsedStartDate.toLocaleString( 'en-US', {
		month: 'long',
	} );
	const endMonth = parsedEndDate.toLocaleString( 'en-US', { month: 'long' } );
	const year = parsedStartDate.toLocaleString( 'en-US', { year: 'numeric' } );

	const yearString = showYear ? `, ${ year }` : '';

	if ( startMonth !== endMonth ) {
		return `${ startMonth } ${ startDay }-${ endMonth } ${ endDay }${ yearString }`;
	}

	return `${ startMonth } ${ startDay }-${ endDay }${ yearString }`;
};

/**
 * Check if a date is valid.
 *
 * @param {Date} date The date.
 *
 * @return {boolean} True if the date is valid, false otherwise.
 */
function isValidDate( date ) {
	return date instanceof Date && isFinite( date );
}
