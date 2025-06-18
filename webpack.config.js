/**
 * Optimized Webpack Configuration for Emdotbike Theme
 */
const defaultConfig = require('@wordpress/scripts/config/webpack.config.js');
const CopyPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const fs = require('fs');
const path = require('path');

// Environment detection
const isDevelopment = process.env.NODE_ENV !== 'production';

/**
 * Path Constants
 */
const PATHS = {
	root: __dirname,
	src: {
		base: path.resolve(__dirname, './src'),
		sass: path.resolve(__dirname, './src/sass'),
        js: path.resolve(__dirname, './src/js'),
	},
	output: {
		base: path.resolve(__dirname, './assets'),
		js: path.resolve(__dirname, './assets/js'),
	},
	cache: path.resolve(__dirname, './.webpack_cache'),
};

/**
 * Entry Points
 */
const baseEntries = {
	// style: path.join(PATHS.src., 'index.js'),
};

/**
 * Webpack Configuration
 */
// Common configuration
const commonConfig = {
	mode: isDevelopment ? 'development' : 'production',
	devtool: isDevelopment ? 'source-map' : false,
	cache: {
		type: 'filesystem',
		cacheDirectory: PATHS.cache,
		buildDependencies: {
			config: [__filename],
		},
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env', '@babel/preset-react'],
						cacheDirectory: true,
					},
				},
			},
			{
				test: /\.scss$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: isDevelopment,
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: isDevelopment,
						},
					},
				],
			},
			{
				test: /\.(png|jpe?g|gif|svg)$/i,
				type: 'asset/resource',
				generator: {
					filename: 'images/[name][hash][ext]',
				},
			},
		],
	},
	resolve: {
		extensions: [
			'.js',
			'.jsx',
			'.scss',
			'.css',
			'.png',
			'.jpg',
			'.jpeg',
			'.gif',
			'.svg',
		],
		alias: {
			'@src': PATHS.src.base,
			'@js': PATHS.src.js,
		},
	},
	watchOptions: {
		ignored: /node_modules/,
		aggregateTimeout: 300,
		poll: 1000,
	},
	optimization: {
		splitChunks: {
			cacheGroups: {
				commons: {
					test: /[\\/]node_modules[\\/](react|react-dom)[\\/]/,
					name: 'vendor-react',
					chunks: 'all',
				},
			},
		},
	},
};

// Base configuration
const baseConfig = {
	...defaultConfig,
	...commonConfig,
	name: 'base',
	entry: baseEntries,
	output: {
		filename: '[name].js',
		path: PATHS.output.js,
		clean: false,
	},
	plugins: [
		...defaultConfig.plugins,
		new MiniCssExtractPlugin({
			filename: '../css/[name].css',
			chunkFilename: '../css/[id].css',
		}),
	],
};

// Export configurations
module.exports = [baseConfig];
