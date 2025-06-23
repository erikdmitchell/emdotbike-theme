const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
	...defaultConfig,
	module: {
		rules: [
			// Keep all existing rules from default config
			...defaultConfig.module.rules,
			// Add SCSS processing for your theme styles
			{
				test: /\.scss$/,
				use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
			},
		],
	},
	plugins: [
		// Keep all existing plugins
		...defaultConfig.plugins,
		// Add CSS extraction
		new MiniCssExtractPlugin({
			filename: 'style.css',
		}),
	],
};
