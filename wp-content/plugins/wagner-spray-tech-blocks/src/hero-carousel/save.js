import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function ( { attributes } ) {
	const { className, slideCount } = attributes;
	const classNames = [
		className || 'js-hero-carousel',
		'glide',
		'alignfull',
	];

	const blockProps = useBlockProps.save( {
		className: classNames.join( ' ' ),
	} );

	const bulletsMarkUp = [];
	for ( let i = 0; i < slideCount; i++ ) {
		bulletsMarkUp.push( i );
	}

	return (
		<div { ...blockProps } key={ 'block' }>
			<div className="wp-block-wst-hero-carousel__wrapper">
				<div className="glide__arrows" data-glide-el="controls">
					<button
						className="glide__arrow glide__arrow--left"
						data-glide-dir="<"
						aria-label="Previous slide"
					>
						<i className="icon icon-arrow-prev"></i>
					</button>
					<button
						className="glide__arrow glide__arrow--right"
						data-glide-dir=">"
						aria-label="Next slide"
					>
						<i className="icon icon-arrow-next"></i>
					</button>
				</div>
				<div className="glide__track" data-glide-el="track">
					<div className="glide__slides">
						<InnerBlocks.Content />
					</div>
				</div>
				<div className="glide__bullets" data-glide-el="controls[nav]">
					{ bulletsMarkUp.map( ( bullet ) => (
						<button
							key={ bullet }
							className="glide__bullet"
							data-glide-dir={ `=${ bullet }` }
							tabIndex="-1"
						></button>
					) ) }
				</div>
			</div>
		</div>
	);
}
