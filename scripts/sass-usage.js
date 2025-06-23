/* eslint-disable no-console */
// scripts/sass-usage.js
const sassGraph = require('sass-graph');
const graph = sassGraph.parseDir('./src/sass', { extensions: ['scss'] });

for (const file in graph.index) {
	const entry = graph.index[file];
	console.log(`\n${file}`);
	if (entry.imports.length === 0) {
		console.log('  No imports.');
	} else {
		console.log('  Imports:');
		entry.imports.forEach((imp) => {
			console.log(`    - ${imp}`);
		});
	}
}
