const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
	...defaultConfig,

	entry: {
		emdotbike: path.resolve(__dirname, 'src/js/emdotbike.js'),
	},

	output: {
		// 👇 This puts the output in your actual assets/js/ folder
		path: path.resolve(__dirname, 'assets/js'),
		filename: '[name].js',
		clean: false, // prevent deleting everything else in assets/js/
	},
};