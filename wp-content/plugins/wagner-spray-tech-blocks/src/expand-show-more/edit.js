import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

const ALLOWED_BLOCKS = [ 'core/paragraph', 'core/read-more' ];

export default function ( props ) {
	const { attributes } = props;
	const { className } = attributes;
	const classNames = [ className || '' ];

	const blockProps = useBlockProps( {
		className: classNames.join( ' ' ),
	} );

	return (
		<div { ...blockProps }>
			<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } />
		</div>
	);
}
