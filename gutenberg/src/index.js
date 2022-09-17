import { registerBlockType } from '@wordpress/blocks';
import { sliderIcon } from './icons';
import edit from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType( metadata, {
	icon: sliderIcon,
	edit,
	save,
});
