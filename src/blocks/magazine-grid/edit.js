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
import { useEffect, useState } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
	const { postCount, postType } = attributes;

	const [posts, setPosts] = useState([]);

	const postTypes = useSelect((select) => {
		const types = select(coreStore).getPostTypes({ per_page: -1 });
		return types ? types.filter((type) => type.viewable) : [];
	}, []);

	const fetchedPosts = useSelect(
		(select) =>
			select(coreStore).getEntityRecords('postType', postType, {
				per_page: postCount,
				_embed: true,
			}) || [],
		[postCount, postType]
	);

	// Sync local state to re-render on changes
	useEffect(() => {
		setPosts(Array.isArray(fetchedPosts) ? fetchedPosts : []);
	}, [fetchedPosts]);

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

					{postTypes.length === 0 ? (
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
				<PostList posts={posts} />
			</div>
		</>
	);
}
