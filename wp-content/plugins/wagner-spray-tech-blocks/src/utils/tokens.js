// Retrieve the ID value from the Token string.
export const getEntityIdFromToken = ( token ) =>
	Number( token.match( /\(ID:\s(\d+)\)/ )[ 1 ] );

// Retrieve the name value from the Token string.
export const getEntityNameFromToken = ( token ) =>
	token?.split( '(' )?.[ 0 ]?.trim();

// Create a token string from an object with id and name properties.
export const convertEntityToToken = ( entity ) => {
	return `${ entity.name } (ID: ${ entity.id })`;
};
