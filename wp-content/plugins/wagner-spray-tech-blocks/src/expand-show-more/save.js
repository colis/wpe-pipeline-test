import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function ( { attributes } ) {
	const { className } = attributes;
	const classNames = [ className || '' ];

	const blockProps = useBlockProps.save( {
		className: classNames,
	} );

	return (
		<div { ...blockProps }>
			<InnerBlocks.Content />
		</div>
	);
}
