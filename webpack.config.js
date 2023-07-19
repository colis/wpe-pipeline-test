/**
 * Define paths
 */
const themePath = './wp-content/themes/wagner-spray-tech';
const corePluginPath = './wp-content/plugins/wagner-spray-tech-core';
const digitalRiverPluginPath =
	'./wp-content/plugins/wagner-spray-tech-digital-river-integration';

/**
 * External dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );

/**
 * Configurations
 */
// Project shared configuration.
const projectConfig = {
	...defaultConfig,
	optimization: {
		...defaultConfig.optimization,
		minimizer: [
			...defaultConfig.optimization.minimizer,
			new CssMinimizerPlugin(),
		],
	},
};

// Theme configuration.
const themeConfig = {
	...projectConfig,
	entry: {
		frontend: [
			`${ themePath }/assets/js/index.js`,
			`${ themePath }/assets/sass/style.scss`,
		],
		admin: [ `${ themePath }/assets/sass/admin.scss` ],
	},
	output: {
		path: path.resolve( __dirname, `${ themePath }/dist` ),
	},
	plugins: [
		...defaultConfig.plugins.slice( 2 ), // Ignore the existing CleanWebpackPlugin & CopyWebpackPlugin plugin.
		new CopyWebpackPlugin( {
			patterns: [
				{
					from: path.resolve(
						__dirname,
						`${ themePath }/assets/fonts`
					),
					to: path.resolve( __dirname, `${ themePath }/dist/fonts` ),
				},
			],
		} ),
		new CopyWebpackPlugin( {
			patterns: [
				{
					from: path.resolve(
						__dirname,
						`${ themePath }/assets/svg`
					),
					to: path.resolve( __dirname, `${ themePath }/dist/svg` ),
				},
			],
		} ),
	],
};

// Core plugin admin configuration.
const corePluginAdminConfig = {
	...projectConfig,
	entry: {
		admin: [
			`${ corePluginPath }/assets/js/admin/admin.js`,
			`${ corePluginPath }/assets/css/admin/admin-style.css`,
		],
	},
	output: {
		path: path.resolve( __dirname, `${ corePluginPath }/dist/admin` ),
	},
	plugins: [ ...defaultConfig.plugins.slice( 1 ) ], // Ignore the existing CleanWebpackPlugin plugin.
};

// Core plugin block editor configuration.
const corePluginBlockEditorConfig = {
	...projectConfig,
	entry: {
		scripts: [
			`${ corePluginPath }/includes/block-editor/block-editor.js`,
		],
		styles: [
			`${ corePluginPath }/includes/block-editor/assets/sass/block-editor.scss`,
		],
	},
	output: {
		path: path.resolve(
			__dirname,
			`${ corePluginPath }/dist/block-editor`
		),
	},
	plugins: [ ...defaultConfig.plugins.slice( 1 ) ], // Ignore the existing CleanWebpackPlugin plugin.
};

// Core plugin frontend configuration.
const corePluginFrontEndConfig = {
	...projectConfig,
	entry: {
		frontend: [
			`${ corePluginPath }/assets/js/frontend/frontend.js`,
			`${ corePluginPath }/assets/css/frontend/frontend-style.css`,
		],
	},
	output: {
		path: path.resolve( __dirname, `${ corePluginPath }/dist/frontend` ),
	},
	plugins: [ ...defaultConfig.plugins.slice( 1 ) ], // Ignore the existing CleanWebpackPlugin plugin.
};

// Core plugin frontend configuration.
const corePluginSharedConfig = {
	...projectConfig,
	entry: {
		shared: [
			`${ corePluginPath }/assets/js/shared/shared.js`,
			`${ corePluginPath }/assets/css/shared/shared-style.css`,
		],
	},
	output: {
		path: path.resolve( __dirname, `${ corePluginPath }/dist/shared` ),
	},
	plugins: [ ...defaultConfig.plugins.slice( 1 ) ], // Ignore the existing CleanWebpackPlugin plugin.
};

const DigitalRiverIntegrationPluginAdminConfig = {
	...projectConfig,
	entry: {
		admin: [
			`${ digitalRiverPluginPath }/assets/js/admin/admin.js`,
			`${ digitalRiverPluginPath }/assets/css/admin/admin-style.css`,
		],
	},
	output: {
		path: path.resolve(
			__dirname,
			`${ digitalRiverPluginPath }/dist/admin`
		),
	},
	plugins: [ ...defaultConfig.plugins.slice( 1 ) ], // Ignore the existing CleanWebpackPlugin plugin.
};

// Process configurations.
module.exports = [
	themeConfig,
	corePluginAdminConfig,
	corePluginBlockEditorConfig,
	corePluginFrontEndConfig,
	corePluginSharedConfig,
	DigitalRiverIntegrationPluginAdminConfig,
];
