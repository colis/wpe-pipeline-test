import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function ( { attributes } ) {
	const { className } = attributes;
	const classNames = [ className || 'glide__slide' ];

	const blockProps = useBlockProps.save( {
		className: classNames.join( ' ' ),
	} );

	return (
		<div { ...blockProps }>
			<InnerBlocks.Content />
		</div>
	);
}
