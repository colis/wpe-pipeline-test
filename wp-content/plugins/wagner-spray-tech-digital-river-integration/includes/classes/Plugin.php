<?php
/**
 * Wagner Spray Tech Digital River Integration
 *
 * @package WagnerSprayTechDigitalRiverIntegration
 */

namespace WagnerSprayTechDigitalRiverIntegration;

use WagnerSprayTechCore\BaseAbstract;
use WagnerSprayTechDigitalRiverIntegration\Core\Core;
use WagnerSprayTechDigitalRiverIntegration\Settings\Sync;
use WagnerSprayTechDigitalRiverIntegration\Data\Report;

/**
 * Wagner Spray Tech Digital River Integration Plugin main class.
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

		add_action( 'init', [ $this->app->get( Core::class ), 'i18n' ] );

		add_action( 'admin_enqueue_scripts', [ $this->app->get( Core::class ), 'admin_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this->app->get( Core::class ), 'admin_styles' ] );

		// Admin Page.
		add_action( 'admin_init', [ $this->app->get( Sync::class ), 'configure' ] );
		add_action( 'admin_menu', [ $this->app->get( Sync::class ), 'add_options_page' ] );

		// Form process.
		add_action( 'wp_ajax_digital_river_sync', [ $this->app->get( Sync::class ), 'process' ] );

		// Reporting.
		add_action( 'admin_init', [ $this->app->get( Report::class ), 'create_custom_table' ] );

		do_action( 'wagnerspraytech_digital_river_integration_loaded' );
	}

	/**
	 * Invoke all add_filter, remove_filter, do_filter hooks in here.
	 *
	 * @return void
	 */
	private function filters(): void {
	}
}
