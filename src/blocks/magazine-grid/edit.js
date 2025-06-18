import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	SelectControl,
	Spinner,
} from '@wordpress/components';
import PostList from './PostList';

export default function Edit({ attributes, setAttributes }) {
	const { postCount, postType } = attributes;

	const postTypes = useSelect(
		(select) =>
			select(coreStore)
				.getPostTypes({ per_page: -1 })
				?.filter((type) => type.viewable),
		[]
	);

	const isLoading = !postTypes;

	return (
		<>
			<InspectorControls>
				<PanelBody title="Post Grid Settings" initialOpen={true}>
					<RangeControl
						label="Post Count"
						value={postCount}
						onChange={(value) =>
							setAttributes({ postCount: value })
						}
						min={1}
						max={6}
					/>

					{isLoading ? (
						<Spinner />
					) : (
						<SelectControl
							label="Post Type"
							value={postType}
							options={postTypes.map((type) => ({
								label: type.labels.singular_name,
								value: type.slug,
							}))}
							onChange={(value) =>
								setAttributes({ postType: value })
							}
						/>
					)}
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				<PostList count={postCount} postType={postType} />
			</div>
		</>
	);
}

// export function save() {
//     return <PostList count={3} />;
// }
