const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ZipPlugin = require('zip-webpack-plugin');

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
  mode: isProduction ? 'production' : 'development',
  
  entry: {
    // Main stylesheet
    style: './sass/style.scss',
    // Editor stylesheet
    editor: './sass/editor.scss',
    // JavaScript files
    main: './src/js/main.js', // You may need to create this as an entry point
  },

  output: {
    path: path.resolve(__dirname, 'assets'),
    filename: 'js/[name]' + (isProduction ? '.min.js' : '.js'),
    clean: false, // Don't clean the entire assets folder
  },

  devtool: isProduction ? 'source-map' : 'eval-source-map',

  module: {
    rules: [
      // SCSS/CSS processing
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
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
              sourceMap: true,
              sassOptions: {
                outputStyle: 'expanded',
              },
            },
          },
        ],
      },

      // JavaScript processing
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },

      // Font files
      {
        test: /\.(ttf|otf|eot|woff|woff2)$/,
        type: 'asset/resource',
        generator: {
          filename: 'fonts/[name][ext]',
        },
      },

      // Image files
      {
        test: /\.(png|jpg|jpeg|gif|svg)$/,
        type: 'asset/resource',
        generator: {
          filename: 'images/[name][ext]',
        },
      },
    ],
  },

  plugins: [
    // Extract CSS into separate files
    new MiniCssExtractPlugin({
      filename: (pathData) => {
        // Main style.scss always goes to root as style.css (no minification)
        if (pathData.chunk.name === 'style') {
          return '../style.css';
        }
        // Other CSS files can be minified
        return 'css/[name]' + (isProduction ? '.min.css' : '.css');
      },
    }),

    // Copy static files for build
    ...(isProduction ? [
      new CopyWebpackPlugin({
        patterns: [
          {
            from: '**/*',
            to: '../build',
            globOptions: {
              ignore: [
                '**/node_modules/**',
                '**/src/**',
                '**/sass/**',
                '**/vendor/**',
                '**/composer.json',
                '**/composer.lock',
                '**/gulpfile.js',
                '**/webpack.config.js',
                '**/package.json',
                '**/package-lock.json',
                '**/phpcs.ruleset.xml',
                '**/.stylelintrc',
                '**/svn/**',
                '**/*.scss',
                '**/assets/css/*.css', // Exclude non-minified CSS
                '**/assets/js/*.js',   // Exclude non-minified JS
                '!**/*.min.css',       // But include minified files
                '!**/*.min.js',
              ],
            },
          },
        ],
      }),

      // Create zip file for distribution
      new ZipPlugin({
        path: '../',
        filename: 'emdotbike.zip',
        pathPrefix: 'build/',
      }),
    ] : []),
  ],

  optimization: {
    minimize: isProduction,
    minimizer: [
      new TerserPlugin({
        terserOptions: {
          format: {
            comments: false,
          },
        },
        extractComments: false,
      }),
      new CssMinimizerPlugin({
        // Exclude style.css from minification
        exclude: /style\.css$/,
        minimizerOptions: {
          preset: [
            'default',
            {
              discardComments: { removeAll: true },
            },
          ],
        },
      }),
    ],
  },

  resolve: {
    extensions: ['.js', '.scss', '.css'],
  },

  stats: {
    children: false,
    entrypoints: false,
    modules: false,
  },
};