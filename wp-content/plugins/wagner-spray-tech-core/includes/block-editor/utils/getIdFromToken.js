// Retrieve the ID value from the Token string.
export const getIdFromToken = (token) => Number(token.match(/\[(\d+)\]/)[1]);
