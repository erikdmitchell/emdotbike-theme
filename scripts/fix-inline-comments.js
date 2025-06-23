/* eslint-disable no-console */
// scripts/fix-inline-comments.js
const fs = require('fs');
const path = require('path');
const glob = require('glob');

const scssFiles = glob.sync('src/sass/**/*.scss'); // Adjust if needed

scssFiles.forEach((file) => {
	const fullPath = path.resolve(file);
	const original = fs.readFileSync(fullPath, 'utf8');
	let changed = original;

	// Match property lines with inline //
	changed = changed.replace(
		/^(\s*[^\/\n]+?;\s*)\/\/(.*)$/gm,
		(_, prop, comment) => `${prop}/*${comment.trim()} */`
	);

	if (changed !== original) {
		fs.writeFileSync(fullPath, changed, 'utf8');
		console.log(`✅ Updated: ${file}`);
	}
});
