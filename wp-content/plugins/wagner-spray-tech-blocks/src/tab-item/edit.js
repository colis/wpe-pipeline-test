import { InnerBlocks, RichText, useBlockProps } from '@wordpress/block-editor';

const ALLOWED_BLOCKS = [
	'core/buttons',
	'core/column',
	'core/columns',
	'core/embed',
	'core/file',
	'core/group',
	'core/heading',
	'core/html',
	'core/image',
	'core/list',
	'core/paragraph',
	'core/separator',
	'core/spacer',
	'core/table',
	'mecum/auction-catalog',
	'mecum/lot-selector',
	'mecum/media',
];
const TEMPLATE = [ [ 'core/paragraph', { placeholder: 'Enter Content...' } ] ];

export default function ( { attributes, setAttributes } ) {
	const { className, title } = attributes;
	const classNames = [ className || '' ];

	const blockProps = useBlockProps( {
		className: classNames.join( ' ' ),
	} );

	return (
		<div { ...blockProps }>
			<RichText
				tagName="h3"
				value={ title }
				onChange={ ( newTitle ) =>
					setAttributes( { title: newTitle } )
				}
				placeholder="Enter Tab Title..."
				className="tab-title"
			/>
			<InnerBlocks
				allowedBlocks={ ALLOWED_BLOCKS }
				template={ TEMPLATE }
			/>
		</div>
	);
}
