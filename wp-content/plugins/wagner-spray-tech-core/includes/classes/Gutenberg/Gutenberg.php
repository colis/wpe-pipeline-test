<?php
/**
 * Gutenberg related functionalities.
 *
 * @package WagnerSprayTechCore\Gutenberg
 */

namespace WagnerSprayTechCore\Gutenberg;

use WagnerSprayTechCore\BaseAbstract;

/**
 * Class Gutenberg
 *
 * @package WagnerSprayTechCore
 */
class Gutenberg extends BaseAbstract {

	/**
	 * Add/remove theme support for Gutenberg features.
	 *
	 * @return void
	 */
	public function register_gutenberg_theme_support(): void {

		// Add theme support for selective refresh for widgets.
		\add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for block styles.
		\add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		\add_theme_support( 'editor-styles' );

		// Add support for responsive embedded content.
		\add_theme_support( 'responsive-embeds' );

		// Remove support for Core Block Patterns.
		\remove_theme_support( 'core-block-patterns' );
	}

	/**
	 * Enqueue the block editor assets.
	 *
	 * @return void
	 */
	public function enqueue_editor_assets(): void {
		$js_file  = 'dist/block-editor/scripts.js';
		$css_file = 'dist/block-editor/styles.css';

		$js_fileuri  = WAGNERSPRAYTECH_CORE_PLUGIN_URL . $js_file;
		$css_fileuri = WAGNERSPRAYTECH_CORE_PLUGIN_URL . $css_file;

		// Automatically load dependencies and version.
		$js_asset_file  = include WAGNERSPRAYTECH_CORE_PLUGIN_PATH . 'dist/block-editor/scripts.asset.php';
		$css_asset_file = include WAGNERSPRAYTECH_CORE_PLUGIN_PATH . 'dist/block-editor/styles.asset.php';

		\wp_enqueue_script(
			'wst-block-editor',
			$js_fileuri,
			$js_asset_file['dependencies'],
			$js_asset_file['version'],
			true
		);

		\wp_enqueue_style(
			'wst-block-editor-css',
			$css_fileuri,
			$css_asset_file['dependencies'],
			$css_asset_file['version']
		);
	}

	/**
	 * Update Reusable Blocks post type arguments.
	 *
	 * @param array  $args Array of arguments for registering a post type.
	 * @param string $post_type Post type key.
	 *
	 * @return array
	 */
	public function reusable_block_update_post_type_args( $args, $post_type ): array {

		// If the post type is not 'wp_block', bail early.
		if ( 'wp_block' !== $post_type ) {
			return $args ?? [];
		}

		// Add excerpt support.
		$args['supports'][] = 'excerpt';

		return $args ?? [];
	}

	/**
	 * Modify post columns for the Reusable Block post type.
	 *
	 * @param array $columns The post columns.
	 *
	 * @return array
	 */
	public function modify_wp_block_post_columns( array $columns ): array {
		unset( $columns['date'] );
		$columns['description'] = __( 'Description', 'wagner-spray-tech-core' );
		$columns['date']        = 'Date';

		return $columns;
	}

	/**
	 * Populate custom Reusable Block columns with data.
	 *
	 * @param string $column The name of the column to display.
	 * @param int    $post_id The current post ID.
	 *
	 * @return void
	 */
	public function add_wp_block_post_column_data( string $column, int $post_id ): void {
		$post = \get_post( $post_id );

		switch ( $column ) {
			case 'description':
				echo \wp_kses_post( $post->post_excerpt );
				break;
		}
	}
}
