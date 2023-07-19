import './index.css';
import { registerBlockType } from '@wordpress/blocks';
import edit from './edit';
import icon from './icon';
import save from './save';

registerBlockType( 'wst-blocks/accordion', {
	edit,
	icon,
	save,
} );
