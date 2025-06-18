const defaultConfig = require('@wordpress/scripts/config/webpack.config.js');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const path = require('path');

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
  ...defaultConfig,
  
  entry: {
    // Keep the default wp-scripts entries (handles src/index.js -> build/index.js)
    ...defaultConfig.entry,
    
    // Add theme SASS entries
    'theme-style': './sass/style.scss',
    'theme-editor': './sass/editor.scss',
  },

  module: {
    rules: [
      // Keep all existing wp-scripts rules
      ...defaultConfig.module.rules,
      
      // Add SASS rule specifically for theme files
      {
        test: /\.scss$/,
        include: path.resolve(__dirname, 'sass'),
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  [
                    'autoprefixer',
                    {
                      overrideBrowserslist: [
                        'last 2 versions',
                        '> 1%',
                        'safari 5',
                        'ie 8',
                        'ie 9',
                        'opera 12.1',
                        'ios 6',
                        'android 4',
                      ],
                      cascade: false,
                    },
                  ],
                ],
              },
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sassOptions: {
                outputStyle: 'expanded',
              },
            },
          },
        ],
      },
    ],
  },

  plugins: [
    // Keep all wp-scripts plugins
    ...defaultConfig.plugins,
    
    // Add plugins for theme SASS
    new RemoveEmptyScriptsPlugin(),
    new MiniCssExtractPlugin({
      filename: (pathData) => {
        if (pathData.chunk.name === 'theme-style') {
          return '../style.css';
        }
        if (pathData.chunk.name === 'theme-editor') {
          return '../assets/css/editor.css';
        }
        // Default behavior for blocks
        return '[name].css';
      },
    }),
  ],
};