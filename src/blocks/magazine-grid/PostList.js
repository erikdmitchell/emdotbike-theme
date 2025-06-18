import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

// featured image
const getFeaturedImage = (post, size = 'full') => {
	const media = post._embedded?.['wp:featuredmedia']?.[0];
	if (!media) return null;

	return (
		media.media_details?.sizes?.[size]?.source_url ||
		media.source_url ||
		null
	);
};

// excerpt
const stripHTML = (html) => html.replace(/<[^>]+>/g, '');

const getExcerpt = (post, length = 55) => {
	const raw = post.excerpt?.rendered || '';
	const text = stripHTML(raw).trim();
	return text.split(/\s+/).slice(0, length).join(' ') + '…';
};

const PostList = ({ count = 3, postType = 'post' }) => {
	const posts = useSelect(
		(select) =>
			select(coreStore).getEntityRecords('postType', postType, {
				per_page: count,
				_embed: true, // 👈 THIS is critical for featured images
			}),
		[count, postType]
	);

	if (!posts) return <p>Loading {postType}…</p>;
	if (posts.length === 0) return <p>No {postType}s found.</p>;

	return (
		<div className="mag-grid">
			{posts.map((post, key) => {
				let imageSize = 'home-grid';
				let classes = 'mag-post-image';
				let excerptLength = 50;

				if (key === 0) {
					imageSize = 'home-grid-featured';
					excerptLength = 110;
				} else if (key === 1) {
					imageSize = 'home-grid-tall';
					classes += ' tall';
					excerptLength = 120;
				}

				const imageUrl = getFeaturedImage(post, imageSize);
				const excerpt = getExcerpt(post, excerptLength);

				return (
					<div
						key={post.id}
						className={`mag-grid-post mag-post-${key}`}
					>
						{imageUrl && (
							<div className={classes}>
								<img src={imageUrl} alt="" />
							</div>
						)}
						<div className="mag-post-title">
							<h2>
								<a
									href={post.link}
									target="_blank"
									rel="noopener noreferrer"
								>
									{post.title?.rendered || '(No title)'}
								</a>
							</h2>
						</div>
						<div className="mag-post-excerpt">
							<p>{excerpt}</p>
						</div>
					</div>
				);
			})}
		</div>
	);
};

export default PostList;
