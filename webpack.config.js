const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
	...defaultConfig,

	entry: {
		index: path.resolve(__dirname, 'src/index.js'),
		emdotbike: path.resolve(__dirname, 'src/js/emdotbike.js'),
	},

	output: {
		// Set a base path — required
		path: path.resolve(__dirname, 'build'),

		// Dynamically assign output filenames and subfolders
		filename: (pathData) => {
			switch (pathData.chunk.name) {
				case 'emdotbike':
					return '../assets/js/emdotbike.js'; // ✅ outside build folder
				case 'index':
					return 'index.js'; // ✅ inside build
				default:
					return '[name].js'; // fallback
			}
		},
		clean: false, // Don't wipe folders
	},
};