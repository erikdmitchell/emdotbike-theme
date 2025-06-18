import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

const PostList = ({ count = 3, postType = 'post' }) => {
	const posts = useSelect(
		(select) =>
			select(coreStore).getEntityRecords('postType', postType, {
				per_page: count,
			}),
		[count, postType]
	);

	if (!posts) return <p>Loading {postType}…</p>;
	if (posts.length === 0) return <p>No {postType}s found.</p>;

	return (
		<ul>
			{posts.map((post) => (
				<li key={post.id}>
					<a href={post.link} target="_blank" rel="noopener noreferrer">
						{post.title?.rendered || '(no title)'}
					</a>
				</li>
			))}
		</ul>
	);
};

export default PostList;