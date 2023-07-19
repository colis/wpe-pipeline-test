import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function ( { attributes } ) {
	const { className, key, title, open } = attributes;
	const classNames = [
		className || '',
		'wp-block-wst-blocks-accordion-item',
	];

	const blockProps = useBlockProps.save( {
		className: classNames.join( ' ' ),
	} );

	const expanded = open ? 'true' : 'false';

	return (
		<div { ...blockProps }>
			<h4 className="wp-block-wst-blocks-accordion-item__title js-wp-block-wst-blocks-accordion">
				<button
					type="button"
					aria-expanded={ expanded }
					className="wp-block-wst-blocks-accordion-item__trigger"
					aria-controls={ `${ key }-accordion` }
					id={ `${ key }-accordion-button` }
				>
					{ title }
					<span className="accordion-marker">
						<span className="svg-icon icon-plus-minus"></span>
					</span>
				</button>
			</h4>
			<div
				id={ `${ key }-accordion` }
				role="region"
				aria-labelledby={ `${ key }-accordion-button` }
				className="wp-block-wst-blocks-accordion-item__content"
				hidden
			>
				<InnerBlocks.Content />
			</div>
		</div>
	);
}
