'use strict';

const path = require('path');

module.exports = {
	resolve: {
		extensions: ['.js', '.jsx'],
		modules: ['node_modules']
	},
	context: __dirname,
	entry: {
		app: './resources/src/js/index.js',
		suscription: './resources/src/js/app/suscription.js',
		animations: './resources/src/js/app/web-animations.js',
		support: './resources/src/js/app/support.js',
		forgotpassword: './resources/src/js/app/forgotpassword.js'
	},
	output: {
		path: path.resolve(__dirname, 'public/js'),
		filename: '[name].js',
		publicPath: '/'
	},
	devtool: 'inline-soure-map',
	module: {
		rules: [
			{
				exclude: /(node_modules|bower_components)/,
				test: /(\.js|\.jsx)$/,
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: ['es2015', 'react']
						}
					}
				]
			}
		]
	},
	watchOptions: {
		poll: 1000
	}
};
