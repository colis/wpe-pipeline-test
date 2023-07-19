import { registerBlockType } from '@wordpress/blocks';
import edit from './edit';
import block from './block.json';

const {
	name,
	title,
	description,
	category,
	keywords,
	icon,
	attributes,
	supports,
} = block;

registerBlockType( name, {
	title,
	description,
	category,
	keywords,
	icon,
	attributes,
	edit,
	anchor: false,
	supports,
} );
