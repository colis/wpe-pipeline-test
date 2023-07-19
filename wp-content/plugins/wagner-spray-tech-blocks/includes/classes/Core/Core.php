<?php
/**
 * Wagner Spray Tech Blocks Core Functionality
 *
 * @package WagnerSprayTechBlocks\Core
 */

namespace WagnerSprayTechBlocks\Core;

use WagnerSprayTechCore\BaseAbstract;

/**
 * WordPress Core Functionality.
 */
class Core extends BaseAbstract {

	/**
	 * Activate the plugin
	 *
	 * @return void
	 */
	public function activation_hook(): void {
		flush_rewrite_rules();
		do_action( 'wagner_spray_tech_blocks_activated' );
	}

	/**
	 * Deactivate the plugin
	 *
	 * Uninstall routines should be in uninstall.php
	 *
	 * @return void
	 */
	public function deactivation_hook(): void {
		flush_rewrite_rules();
		do_action( 'wagner_spray_tech_blocks_deactivated' );
	}

	/**
	 * Register scripts for front-end.
	 *
	 * @return void
	 */
	public function wst_blocks_register_scripts(): void {
		wp_register_script(
			'glide-js',
			WAGNERSPRAYTECH_BLOCKS_URL . 'lib/glide/glide.min.js',
			[],
			WAGNERSPRAYTECH_BLOCKS_VERSION,
			true
		);

		wp_register_style(
			'glide-core-css',
			WAGNERSPRAYTECH_BLOCKS_URL . 'lib/glide/glide.core.min.css',
			[],
			WAGNERSPRAYTECH_BLOCKS_VERSION,
			'screen'
		);
	}
}
