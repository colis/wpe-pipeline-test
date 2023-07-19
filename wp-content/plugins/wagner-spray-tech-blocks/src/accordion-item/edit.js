import { InnerBlocks, useBlockProps, RichText } from '@wordpress/block-editor';
import { useEffect } from '@wordpress/element';
import Inspector from './inspector';

const ALLOWED_BLOCKS = [
	'core/buttons',
	'core/column',
	'core/columns',
	'core/cover',
	'core/file',
	'core/group',
	'core/heading',
	'core/image',
	'core/list',
	'core/paragraph',
	'core/separator',
	'core/spacer',
	'core/table',
];
const TEMPLATE = [ [ 'core/paragraph', { placeholder: 'Add content...' } ] ];

export default function ( props ) {
	const { attributes, setAttributes, clientId } = props;
	const { className, title } = attributes;
	const classNames = [
		className || '',
		'wp-block-wst-blocks-accordion-item',
	];

	const blockProps = useBlockProps( {
		className: classNames.join( ' ' ),
	} );

	useEffect( () => {
		setAttributes( { key: clientId } );
	}, [] );

	return (
		<>
			<Inspector { ...props } />
			<div { ...blockProps }>
				<RichText
					tagName="h4"
					placeholder="Add accordion title..."
					className="wp-block-wst-blocks-accordion-item__heading"
					allowedFormats={ [] }
					value={ title }
					onChange={ ( newTitle ) =>
						setAttributes( { title: newTitle } )
					}
				/>
				<div className="wp-block-wst-blocks-accordion-item__content">
					<InnerBlocks
						allowedBlocks={ ALLOWED_BLOCKS }
						template={ TEMPLATE }
					/>
				</div>
			</div>
		</>
	);
}
