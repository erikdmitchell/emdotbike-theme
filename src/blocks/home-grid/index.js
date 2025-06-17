import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('emdotbike/home-grid', {
	edit() {
		return (
			<div {...useBlockProps()}>
				<p>Preview: Home Grid (dynamic)</p>
			</div>
		);
	},
	save() {
		return null;
	},
});