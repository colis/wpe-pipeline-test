/**
 * Change the tag of an element.
 *
 * @param {element} element The element to change.
 * @param {string}  newTag  The new tag to use.
 * @return {*} The new element.
 */
export const changeElementTag = ( element, newTag ) => {
	const newElement = document.createElement( newTag );
	newElement.innerHTML = element.innerHTML;
	element.parentNode.replaceChild( newElement, element );
	return newElement;
};
