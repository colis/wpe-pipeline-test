import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

const TEMPLATE = [
	[
		'core/cover',
		{ dimRatio: 0 },
		[
			[
				'core/heading',
				{
					level: 2,
					placeholder: 'Enter Title...',
					textAlign: 'center',
				},
			],
			[
				'core/paragraph',
				{ placeholder: 'Enter Content...', align: 'center' },
			],
			[
				'gravityforms/form',
				{ title: false, description: false, ajax: true },
			],
		],
	],
];

export default function ( { attributes } ) {
	const { className } = attributes;
	const classNames = [ className || '' ];

	const blockProps = useBlockProps( {
		className: classNames.join( ' ' ),
	} );

	return (
		<div { ...blockProps } key={ 'block' }>
			<InnerBlocks template={ TEMPLATE } templateLock="insert" />
		</div>
	);
}
