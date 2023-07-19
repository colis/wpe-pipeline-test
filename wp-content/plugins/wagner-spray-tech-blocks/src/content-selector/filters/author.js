import { FormTokenField } from '@wordpress/components';
import { useDebounce } from '@wordpress/compose';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { useMemo, useState } from '@wordpress/element';
import {
	getEntityIdFromToken,
	convertEntityToToken,
	getEntityNameFromToken,
} from '../../utils/tokens';

const MAX_TERM_SUGGESTIONS = 20;
const MAX_TOKENS = 1;

export default function ( { attributes, setAttributes } ) {
	const { author } = attributes;
	const [ searchString, setSearchString ] = useState( '' );
	const debouncedSearch = useDebounce( setSearchString, 1000 );

	// Retrieve authors from the DB.
	const { users, hasResolved } = useSelect(
		( select ) => {
			const query = {
				context: 'view',
				per_page: 100,
				search: searchString,
				_fields: 'id,name',
			};

			const selectorArgs = [ 'root', 'user', query ];

			return {
				users: select( coreDataStore ).getEntityRecords(
					...selectorArgs
				),
				hasResolved: select( coreDataStore ).hasFinishedResolution(
					'getEntityRecords',
					selectorArgs
				),
			};
		},
		[ searchString ]
	);

	const suggestions = useMemo( () => {
		return ( users ?? [] ).map( ( user ) => convertEntityToToken( user ) );
	}, [ users ] );

	const onChange = ( newAuthor ) => {
		setAttributes( {
			author: {
				id: newAuthor[ 0 ] ? getEntityIdFromToken( newAuthor[ 0 ] ) : 0,
				name: newAuthor[ 0 ]
					? getEntityNameFromToken( newAuthor[ 0 ] )
					: '',
			},
		} );
	};

	return (
		<>
			<FormTokenField
				label="Filter by author"
				maxLength={ MAX_TOKENS }
				maxSuggestions={ MAX_TERM_SUGGESTIONS }
				onChange={ onChange }
				onInputChange={ debouncedSearch }
				suggestions={ hasResolved ? suggestions : [] }
				value={
					author?.name ? [ `${ author.name } [${ author.id }]` ] : []
				}
			/>
		</>
	);
}
