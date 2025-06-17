import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		firstPostCount,
		secondSetCount,
		thirdSetCount,
		showSecondSet,
		showThirdSet
	} = attributes;

	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title="Post Grid Settings" initialOpen={true}>
					<RangeControl
						label="First Post Count"
						value={firstPostCount}
						onChange={(value) => setAttributes({ firstPostCount: value })}
						min={1}
						max={3}
					/>
					<ToggleControl
						label="Show Second Set"
						checked={showSecondSet}
						onChange={(value) => setAttributes({ showSecondSet: value })}
					/>
					{showSecondSet && (
						<RangeControl
							label="Second Set Count"
							value={secondSetCount}
							onChange={(value) => setAttributes({ secondSetCount: value })}
							min={0}
							max={4}
						/>
					)}
					<ToggleControl
						label="Show Third Set"
						checked={showThirdSet}
						onChange={(value) => setAttributes({ showThirdSet: value })}
					/>
					{showThirdSet && (
						<RangeControl
							label="Third Set Count"
							value={thirdSetCount}
							onChange={(value) => setAttributes({ thirdSetCount: value })}
							min={0}
							max={4}
						/>
					)}
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<p><strong>Magazine Grid</strong> – configured preview</p>
			</div>
		</>
	);
}