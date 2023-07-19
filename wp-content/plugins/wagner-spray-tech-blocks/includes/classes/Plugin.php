<?php
/**
 * Wagner Spray Tech Blocks
 *
 * @package WagnerSprayTechBlocks
 */

namespace WagnerSprayTechBlocks;

use WagnerSprayTechCore\BaseAbstract;
use WagnerSprayTechBlocks\Core\Core;
use WagnerSprayTechBlocks\Blocks\Blocks;

/**
 * Wagner Spray Tech Blocks Plugin main class.
 */
class Plugin extends BaseAbstract {

	/**
	 * Set up the container deps and fire off all WordPress hooks used in this plugin.
	 */
	public function register(): void {
		try {
			$this->activation_hooks();
			$this->actions();
			$this->filters();
		} catch ( \Exception $e ) {
			echo esc_html( $e->getMessage() );
		}
	}

	/**
	 * Plugin activation and deactivation hooks.
	 *
	 * @return void
	 */
	private function activation_hooks(): void {
		register_activation_hook( __FILE__, [ $this->app->get( Core::class ), 'activation_hook' ] );
		register_deactivation_hook( __FILE__, [ $this->app->get( Core::class ), 'deactivation_hook' ] );
	}

	/**
	 * Invoke all add_action, remove_action, do_action hooks in here.
	 *
	 * @return void
	 */
	private function actions(): void {
		add_action( 'init', [ $this->app->get( Blocks::class ), 'wst_blocks_register_blocks' ] );
		add_action( 'block_categories_all', [ $this->app->get( Blocks::class ), 'wst_blocks_register_block_category' ] );
		add_action( 'wp_enqueue_scripts', [ $this->app->get( Core::class ), 'wst_blocks_register_scripts' ] );
		do_action( 'wagner_spray_tech_blocks_loaded' );
	}

	/**
	 * Invoke all add_filter, remove_filter, do_filter hooks in here.
	 *
	 * @return void
	 */
	private function filters(): void {}
}
