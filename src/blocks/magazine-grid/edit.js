import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

export default function Edit({ attributes, setAttributes }) {
	const {
		firstPostCount,
		secondSetCount,
		thirdSetCount,
		showSecondSet,
		showThirdSet,
	} = attributes;

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
					<RangeControl
						label="Second Set Count"
						value={secondSetCount}
						onChange={(value) => setAttributes({ secondSetCount: value })}
						min={0}
						max={4}
						disabled={!showSecondSet}
					/>
					<ToggleControl
						label="Show Third Set"
						checked={showThirdSet}
						onChange={(value) => setAttributes({ showThirdSet: value })}
					/>
					<RangeControl
						label="Third Set Count"
						value={thirdSetCount}
						onChange={(value) => setAttributes({ thirdSetCount: value })}
						min={0}
						max={4}
						disabled={!showThirdSet}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				<p>Preview: Magazine Grid</p>
                <PostList count={firstPostCount} />
				<ul>
					<li><strong>First Posts:</strong> {firstPostCount}</li>
					{showSecondSet && <li><strong>Second Set:</strong> {secondSetCount}</li>}
					{showThirdSet && <li><strong>Third Set:</strong> {thirdSetCount}</li>}
				</ul>
			</div>
		</>
	);
}

const PostList = ({ count = 3 }) => {
	const posts = useSelect(
		(select) =>
			select(coreStore).getEntityRecords('postType', 'post', {
				per_page: count,
			}),
		[count]
	);

	if (!posts) return <p>Loading posts…</p>;
	if (posts.length === 0) return <p>No posts found.</p>;

	return (
		<ul>
			{posts.map((post) => (
				<li key={post.id}>
					<a href={post.link}>{post.title.rendered}</a>
				</li>
			))}
		</ul>
	);
};

// export PostList;