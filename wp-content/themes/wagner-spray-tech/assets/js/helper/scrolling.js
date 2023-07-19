/**
 * Fire a function when a user reaches a specific scroll point.
 *
 * @param {number}   position
 * @param {Function} func
 * @param {Function} reverseFunc
 */
export const scrollPositionEventHander = (
	position,
	func,
	reverseFunc = null
) => {
	window.addEventListener( 'scroll', function () {
		const scrollPosition = document.documentElement.scrollTop;
		if ( scrollPosition >= position ) func();
		if ( reverseFunc === null ) return;
		if ( scrollPosition < position ) reverseFunc();
	} );
};
