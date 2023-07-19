import { RichText, InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function ( { attributes } ) {
	const { className, title } = attributes;
	const classNames = [ className || '' ];

	const blockProps = useBlockProps.save( {
		className: classNames,
	} );

	return (
		<div { ...blockProps }>
			<RichText.Content tagName="h3" value={ title } />
			<InnerBlocks.Content />
		</div>
	);
}
