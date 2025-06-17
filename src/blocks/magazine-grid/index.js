import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';

registerBlockType('emdotbike/magazine-grid', {
	edit: Edit,
	save: () => null, // dynamic block
});