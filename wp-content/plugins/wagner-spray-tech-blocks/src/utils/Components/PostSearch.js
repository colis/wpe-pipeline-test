import { useState, useEffect } from '@wordpress/element';
import { FormTokenField } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import {
	convertEntityToToken,
	getEntityIdFromToken,
	getEntityNameFromToken,
} from '../tokens';

export default function ( { postType, handleResultSelect, initialResult } ) {
	const [ searchTerm, setSearchTerm ] = useState( '' );
	const [ searchResults, setSearchResults ] = useState( [] );
	const [ suggestions, setSuggestions ] = useState( [] );
	const [ selectedResult, setSelectedResult ] = useState( {} );

	// If initialResult is passed, set it as the selected result.
	useEffect( () => {
		if ( ! initialResult?.id ) {
			return;
		}

		setSelectedResult( {
			id: initialResult?.id,
			name: initialResult?.name,
			type: initialResult?.type,
		} );
	}, [ initialResult ] );

	// If search term changes, retrieve results from search endpoint.
	const results = useSelect(
		( select ) => {
			if ( searchTerm.length < 3 ) {
				return [];
			}

			return select( 'core' ).getEntityRecords( 'postType', postType, {
				search: searchTerm,
			} );
		},
		[ searchTerm ]
	);

	useEffect( () => {
		setSearchResults( results );
	}, [ results ] );

	// If search results change, convert them to tokens and set as suggestions.
	useEffect( () => {
		if ( ! searchResults?.length ) {
			setSuggestions( [] );
			return;
		}

		const resultEntities = searchResults.map( ( result ) => ( {
			name: result.title.rendered,
			id: result.id,
		} ) );

		setSuggestions(
			resultEntities.map( ( entity ) => convertEntityToToken( entity ) )
		);
	}, [ searchResults ] );

	// If user selects a result, pass result to parent.
	useEffect( () => {
		handleResultSelect( selectedResult );
	}, [ selectedResult ] );

	// If user makes a new post type selection, clear the selected result.
	useEffect( () => {
		if ( ! selectedResult?.type ) {
			return;
		}

		if ( postType !== selectedResult?.type ) {
			setSelectedResult( {} );
			setSearchTerm( '' );
		}
	}, [ postType ] );

	// User selects result from token field.
	const handleChange = ( selection ) => {
		setSelectedResult( {
			id: selection[ 0 ] ? getEntityIdFromToken( selection[ 0 ] ) : 0,
			name: selection[ 0 ]
				? getEntityNameFromToken( selection[ 0 ] )
				: '',
			type: postType,
		} );
	};

	return (
		<>
			<FormTokenField
				label={ `Find a post` }
				maxLength={ 1 }
				maxSuggestions={ 100 }
				onChange={ handleChange }
				onInputChange={ setSearchTerm }
				suggestions={ suggestions }
				value={ selectedResult?.name ? [ selectedResult.name ] : [] }
			/>
		</>
	);
}
