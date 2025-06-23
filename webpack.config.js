const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: './src/sass/style.scss',
	output: {
		path: path.resolve(__dirname),
		filename: 'style.js', // dummy JS file, not used
	},
	module: {
		rules: [
			{
				test: /\.scss$/,
				use: [
					MiniCssExtractPlugin.loader, // extract CSS to a file
					'css-loader',
					'sass-loader',
				],
			},
		],
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'style.css', // output to root as style.css
		}),
	],
	mode: 'production', // or 'development' for dev builds
};
