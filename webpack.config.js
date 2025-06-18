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
		js: path.resolve(__dirname, './src/js'),
		admin: path.resolve(__dirname, './src/admin'),
	},
	output: {
		base: path.resolve(__dirname, './assets'),
		js: path.resolve(__dirname, './assets/js'),
		admin: path.resolve(__dirname, './assets/js/admin'),
	},
	cache: path.resolve(__dirname, './.webpack_cache'),
};

/**
 * Special folder configurations
 */
const SPECIAL_FOLDERS = {
	combine: ['connectors'],
	separate: ['marketoForms'],
};

/**
 * Helper Functions
 */
const helpers = {
	/**
	 * Get entry points from directories containing index.js
	 * @param {string} basePath - Base directory path
	 * @return {Object} Entry points object
	 */
	getDirectoryEntries: (basePath) => {
		if (!fs.existsSync(basePath)) {
			return {};
		}

		return fs
			.readdirSync(basePath)
			.filter((dir) =>
				fs.statSync(path.join(basePath, dir)).isDirectory()
			)
			.reduce((entries, dir) => {
				const entryPath = path.join(basePath, dir, 'index.js');
				if (fs.existsSync(entryPath)) {
					entries[dir] = entryPath;
				}
				return entries;
			}, {});
	},

	/**
	 * Get entry points from JS files in a directory
	 * @param {string} basePath - Base directory path
	 * @param {Array}  exclude  - Files to exclude
	 * @return {Object} Entry points object
	 */
	getFileEntries: (basePath, exclude = []) => {
		if (!fs.existsSync(basePath)) {
			return {};
		}

		return fs
			.readdirSync(basePath)
			.filter((file) => file.endsWith('.js') && !exclude.includes(file))
			.reduce((entries, file) => {
				const entryName = path.parse(file).name;
				entries[entryName] = path.join(basePath, file);
				return entries;
			}, {});
	},

	/**
	 * Get combined entries for specific folders
	 * @param {string} basePath - Base directory path
	 * @param {Array}  folders  - Folders to combine
	 * @return {Object} Combined entries object
	 */
	getCombinedFolderEntries: (basePath, folders) => {
		const entries = {};

		folders.forEach((folder) => {
			const folderPath = path.join(basePath, folder);

			if (fs.existsSync(folderPath)) {
				try {
					const folderFiles = fs
						.readdirSync(folderPath)
						.filter((file) => file.endsWith('.js'))
						.map((file) => path.join(folderPath, file));

					if (folderFiles.length) {
						entries[folder] = folderFiles;
					}
				} catch (err) {
					console.error(`Error reading folder: ${folderPath}`, err);
				}
			}
		});

		return entries;
	},

	/**
	 * Get entries for folders that should be processed separately
	 * @param {string} basePath - Base directory path
	 * @param {Array}  folders  - Folders to process separately
	 * @param {Array}  exclude  - Files to exclude
	 * @return {Object} Entries object
	 */
	getSeparateFolderEntries: (basePath, folders, exclude = []) => {
		const entries = {};

		folders.forEach((folder) => {
			const folderPath = path.join(basePath, folder);

			if (fs.existsSync(folderPath)) {
				try {
					const folderEntries = fs
						.readdirSync(folderPath)
						.filter(
							(file) =>
								file.endsWith('.js') && !exclude.includes(file)
						)
						.reduce((acc, file) => {
							const entryName = path.parse(file).name;
							acc[`${folder}/${entryName}`] = path.join(
								folderPath,
								file
							);
							return acc;
						}, {});

					Object.assign(entries, folderEntries);
				} catch (err) {
					console.error(`Error reading folder: ${folderPath}`, err);
				}
			}
		});

		return entries;
	},
};

/**
 * Entry Points
 */
// Admin entries
const adminEntries = {
	...helpers.getCombinedFolderEntries(PATHS.src.admin, ['acf']),
	admin: path.join(PATHS.src.admin, 'main.js'),
	readOnlyAdminUser: path.join(PATHS.src.admin, 'readOnlyAdminUser.js'),
	archivePage: path.join(PATHS.src.admin, 'archivePage.js'),
};

// Base entries
const baseEntries = {
	...helpers.getFileEntries(PATHS.src.js, ['mkto-forms2.min.js']),
	...helpers.getCombinedFolderEntries(PATHS.src.js, SPECIAL_FOLDERS.combine),
	...helpers.getSeparateFolderEntries(
		PATHS.src.js,
		SPECIAL_FOLDERS.separate,
		['mkto-forms2.min.js']
	),
	featuredResources: path.join(PATHS.src.js, 'featured-resources/main.js'),
	subscribeToPage: path.join(PATHS.src.js, 'subscribe-to-page/main.js'),
	bcScripts: path.join(PATHS.src.js, 'main/main.js'),
	bcMarketo: path.join(PATHS.src.js, 'marketoForms/bcMarketo/main.js'),
	index: path.join(PATHS.src.js, 'index.js'),
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
			'@admin': PATHS.src.admin,
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
		new CopyPlugin({
			patterns: [
				{
					from: path.join(
						PATHS.src.js,
						'marketoForms/mkto-forms2.min.js'
					),
					to: path.join(
						PATHS.output.js,
						'marketoForms/mkto-forms2.min.js'
					),
					noErrorOnMissing: true,
					force: false,
				},
				{
					from: path.join(PATHS.src.js, 'libraries'),
					to: path.join(PATHS.output.js, 'libraries'),
					globOptions: {
						ignore: ['**/*.map', '**/test/**'],
					},
					force: false,
				},
			],
		}),
	],
};

// Admin configuration
const adminConfig = {
	...defaultConfig,
	...commonConfig,
	name: 'admin',
	entry: adminEntries,
	output: {
		filename: '[name].js',
		path: PATHS.output.admin,
		clean: false,
	},
	plugins: [
		...defaultConfig.plugins,
		new MiniCssExtractPlugin({
			filename: '../../css/admin/[name].css',
			chunkFilename: '../../css/admin/[id].css',
		}),
	],
};

// Export configurations
module.exports = [baseConfig, adminConfig];
