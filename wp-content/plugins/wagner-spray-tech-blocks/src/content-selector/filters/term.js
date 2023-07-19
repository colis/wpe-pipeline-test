import { FormTokenField } from '@wordpress/components';
import { useDebounce } from '@wordpress/compose';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { useMemo, useState } from '@wordpress/element';
import { convertEntityToToken, getEntityIdFromToken } from '../../utils/tokens';

const MAX_TERM_SUGGESTIONS = 20;
const MAX_TOKENS = 1;

export default function ( {
	setAttributes,
	taxonomyName,
	taxonomyLabel,
	taxonomyFilters,
} ) {
	const [ searchString, setSearchString ] = useState( '' );
	const debouncedSearch = useDebounce( setSearchString, 300 );

	// Retrieve terms from the DB when searchString changes.
	const { terms, hasResolved } = useSelect(
		( select ) => {
			const query = {
				context: 'view',
				per_page: 100,
				search: searchString,
				_fields: 'id,name',
			};

			const selectorArgs = [ 'taxonomy', taxonomyName, query ];

			return {
				terms: select( coreDataStore ).getEntityRecords(
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

	// Update the suggestion strings when the terms change.
	const suggestions = useMemo( () => {
		return ( terms ?? [] ).map( ( term ) => convertEntityToToken( term ) );
	}, [ terms ] );

	// Get the relevant term value for this taxonomy.
	const termValue = useMemo( () => {
		return taxonomyFilters.find(
			( filter ) => filter.termTaxonomy === taxonomyName
		)?.termName;
	}, [ taxonomyFilters ] );

	const handleTermChange = ( newTerm ) => {
		// Delete term.
		if ( ! newTerm.length ) {
			setAttributes( {
				taxonomyFilters: taxonomyFilters.filter(
					( filter ) => filter.termTaxonomy !== taxonomyName
				),
			} );
			return;
		}

		// Add term.
		setAttributes( {
			taxonomyFilters: [
				...taxonomyFilters,
				{
					termTaxonomy: taxonomyName,
					termId: newTerm[ 0 ]
						? getEntityIdFromToken( newTerm[ 0 ] )
						: 0,
					termName: newTerm[ 0 ] || '',
				},
			],
		} );
	};

	return (
		<>
			<FormTokenField
				label={ `Filter by ${ taxonomyLabel }` }
				maxLength={ MAX_TOKENS }
				maxSuggestions={ MAX_TERM_SUGGESTIONS }
				onChange={ handleTermChange }
				onInputChange={ debouncedSearch }
				suggestions={ hasResolved ? suggestions : [] }
				value={ termValue ? [ termValue ] : [] }
			/>
		</>
	);
}
