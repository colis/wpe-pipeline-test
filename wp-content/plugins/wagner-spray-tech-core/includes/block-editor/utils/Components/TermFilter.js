import { FormTokenField } from '@wordpress/components';
import { useDebounce } from '@wordpress/compose';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { useMemo, useState } from '@wordpress/element';
import { getIdFromToken } from '../getIdFromToken';

const MAX_TERM_SUGGESTIONS = 20;
const MAX_TOKENS = 1;

export default function ({
	attributes,
	label,
	setAttributes,
	termAttribute,
	taxonomyName,
}) {
	const { [termAttribute]: termAttr } = attributes;

	const [searchString, setSearchString] = useState('');
	const debouncedSearch = useDebounce(setSearchString, 1000);

	// Retrieve terms from the DB.
	const { terms, hasResolved } = useSelect(
		(select) => {
			if (!searchString) {
				return {
					terms: [],
					hasResolved: true,
				};
			}

			const query = {
				context: 'view',
				per_page: 100,
				search: searchString,
				_fields: 'id,name',
			};

			const selectorArgs = ['taxonomy', taxonomyName, query];

			return {
				terms: select(coreDataStore).getEntityRecords(...selectorArgs),
				hasResolved: select(coreDataStore).hasFinishedResolution(
					'getEntityRecords',
					selectorArgs
				),
			};
		},
		[searchString]
	);

	const suggestions = useMemo(() => {
		return (terms ?? []).map((term) => `${term.name} [${term.id}]`);
	}, [terms]);

	const onChange = (newTerm) => {
		setAttributes({
			[termAttribute]: {
				id: newTerm[0] ? getIdFromToken(newTerm[0]) : 0,
				name: newTerm[0] || '',
			},
		});
	};

	return (
		<>
			<FormTokenField
				label={label}
				maxLength={MAX_TOKENS}
				maxSuggestions={MAX_TERM_SUGGESTIONS}
				onChange={onChange}
				onInputChange={debouncedSearch}
				suggestions={hasResolved ? suggestions : []}
				value={termAttr?.name ? [termAttr.name] : []}
			/>
		</>
	);
}
