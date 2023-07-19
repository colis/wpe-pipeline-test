import { registerBlockType } from '@wordpress/blocks';
import edit from './edit';
import block from './block.json';
const { attributes } = block;
import './index.css';

registerBlockType( 'wst-blocks/content-selector', {
	title: 'Content Selector',
	description: 'Create a list/grid of content types.',
	category: 'wst-blocks',
	keywords: [ 'cards', 'content' ],
	icon: 'megaphone',
	attributes,
	edit,
	anchor: false,
	supports: {
		align: false,
		spacing: {
			padding: [ 'top', 'bottom' ],
		},
	},
} );
