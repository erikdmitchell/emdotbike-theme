import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('emdotbike/magazine-grid', {
	edit() {
		return (
			<div {...useBlockProps()}>
				<p>Preview: Magazine Grid (dynamic block)</p>
			</div>
		);
	},
	save() {
		return null; // dynamic block
	},
});
