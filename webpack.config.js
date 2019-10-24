/*
	TODO:
	- icons (svg? fontello? icomoon)
	- fix po watch
*/
// Utils
const path = require('path');
const glob = require('glob');

// Plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

// Base config
var config = {
	// In
	entry: {
		app: [
			'./src/js/app.js', // JS
			'./src/sass/app.scss' // SASS
		].concat(glob.sync('./languages/*.po')), // PO-files
	},

	// n out
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'dist')
	},

	// Plug-ins
	plugins: [
		// Clean dist/
		new CleanWebpackPlugin(),

		// CSS Extractor
		new MiniCssExtractPlugin({
			filename: '[name].css'
		}),

		// Copy assets
		new CopyWebpackPlugin([
			{from: 'src/assets/', to: 'assets/', ignore: ['.DS_Store']}
		]),

		// Handle Vue SFC
		new VueLoaderPlugin()
	],

	// Config
	module: {
		rules: [
			// Vue
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			},

			// PO-files
			{
				test: /\.po$/,
				loader: 'file-loader?name=[name].mo!po2mo-loader'
			},

			// JS
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [
					// Babel
					{
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env']
						}
					},
					// Glob
					{loader: 'import-glob-loader'}
				]
			},

			// SASS
			{
				test: /\.scss$/,
				exclude: /node_modules/,
				use: [
					// Extract CSS(???)
					{loader: MiniCssExtractPlugin.loader},

					// Enable importing CSS(???)
					{loader: 'css-loader'},

					// PostCSS (autoprefixer etc)
					{
						loader: 'postcss-loader',
						options: {
							plugins: [
								require('autoprefixer')
							]
						}
					},

					// SASS
					{loader: 'sass-loader'},

					// Glob
					{loader: 'import-glob-loader'}
				]
			}
		]
	}
};

// Finish config
module.exports = (env, argv) => {
	// Dev only
	if (argv.mode === 'development') {
		// Watch
		config.watch = true;
		config.watchOptions = {
			ignored: /node_modules/
		};

		// Sourcemaps
		config.devtool = 'source-map';
	}

	return config;
};
