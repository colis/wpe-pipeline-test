import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

const ALLOWED_BLOCKS = [
	'core/buttons',
	'core/cover',
	'core/heading',
	'core/paragraph',
];
const TEMPLATE = [
	[
		'core/cover',
		{
			className: 'wp-block-wst-hero-carousel-item__cover',
			url: 'https://via.placeholder.com/1920x500',
			minHeight: 500,
			dimRatio: 0,
			isDark: false,
			lock: { move: true, remove: true },
			templateLock: true,
		},
		[
			[
				'core/heading',
				{
					className: 'wp-block-wst-hero-carousel-item__heading ',
					level: 2,
					placeholder: 'Enter title...',
					lock: { move: true, remove: true },
					textColor: 'green-200',
				},
			],
			[
				'core/paragraph',
				{
					placeholder: 'Enter content...',
				},
			],
			[
				'core/buttons',
				{
					className: 'wp-block-wst-hero-carousel-item__buttons',
				},
				[
					[
						'core/button',
						{
							className:
								'wp-block-wst-hero-carousel-item__button is-style-small',
							placeholder: 'Button text...',
						},
					],
				],
			],
		],
	],
];

export default function ( props ) {
	const { attributes } = props;
	const { className } = attributes;
	const classNames = [ className || '', 'wp-block-wst-hero-carousel-item' ];

	const blockProps = useBlockProps( {
		className: classNames.join( ' ' ),
	} );

	return (
		<div { ...blockProps }>
			<InnerBlocks
				allowedBlocks={ ALLOWED_BLOCKS }
				template={ TEMPLATE }
			/>
		</div>
	);
}
