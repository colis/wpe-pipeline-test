<?php
/**
 * Wagner Spray Tech Digital River Integration Core Functionality
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Core
 */

namespace WagnerSprayTechDigitalRiverIntegration\Core;

use WagnerSprayTechCore\BaseAbstract;
use WP_Error;

/**
 * WordPress Core Functionality.
 */
class Core extends BaseAbstract {

	/**
	 * Script and Style enqueue contexts allowed.
	 */
	private const ENQUEUE_CONTEXTS = [ 'admin' ];


	/**
	 * Activate the plugin
	 *
	 * @return void
	 */
	public function activation_hook(): void {
		flush_rewrite_rules();
		do_action( 'wagnerspraytech_digital_river_integration_activated' );
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
		do_action( 'wagnerspraytech_digital_river_integration_deactivated' );
	}


	/**
	 * Registers the default textdomain.
	 *
	 * @return void
	 */
	public function i18n(): void {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'wagner-spray-tech-digital-river-integration' );
		load_textdomain( 'wagner-spray-tech-digital-river-integration', WP_LANG_DIR . '/wagner-spray-tech-digital-river-integration/wagner-spray-tech-digital-river-integration-' . $locale . '.mo' );
		load_plugin_textdomain( 'wagner-spray-tech-digital-river-integration', false, plugin_basename( WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_PATH ) . '/languages/' );
	}


	/**
	 * Add async/defer attributes to enqueued scripts that have the specified script_execution flag.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12009
	 *
	 * @param string $tag The script tag.
	 * @param string $handle The script handle.
	 *
	 * @return string
	 */
	public function script_loader_tag( string $tag, string $handle ): string {
		$script_execution = wp_scripts()->get_data( $handle, 'script_execution' );

		if ( ! $script_execution ) {
			return $tag;
		}

		if ( 'async' !== $script_execution && 'defer' !== $script_execution ) {
			return $tag;
		}

		// Abort adding async/defer for scripts that have this script as a dependency. _doing_it_wrong()?
		foreach ( wp_scripts()->registered as $script ) {
			if ( in_array( $handle, $script->deps, true ) ) {
				return $tag;
			}
		}

		// Add the attribute if it hasn't already been added.
		if ( ! preg_match( ":\s$script_execution(=|>|\s):", $tag ) ) {
			$tag = preg_replace( ':(?=></script>):', " $script_execution", $tag, 1 );
		}

		return $tag;
	}



	/**
	 * Generate an URL to a script.
	 *
	 * @param string $script Script file name (no .js extension).
	 * @param string $context Context for the script ('admin', 'frontend', or 'shared').
	 *
	 * @return string|WP_Error URL
	 */
	public function script_url( string $script, string $context ): string|WP_Error {
		if ( ! in_array( $context, self::ENQUEUE_CONTEXTS, true ) ) {
			return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in WagnerSprayTechDigitalRiverIntegration script loader.' );
		}

		return WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_URL . "dist/${context}/${script}.js";
	}

	/**
	 * Enqueue scripts for admin.
	 *
	 * @return void
	 */
	public function admin_scripts(): void {
		wp_enqueue_script(
			'wagnerspraytech_digital_river_integration_admin',
			$this->script_url( 'admin', 'admin' ),
			[],
			WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_VERSION,
			true
		);
	}

	/**
	 * Generate an URL to a stylesheet.
	 *
	 * @param string $stylesheet Stylesheet file name (no .css extension).
	 * @param string $context Context for the script ('admin', 'frontend', or 'shared').
	 *
	 * @return string|WP_Error URL
	 */
	public function style_url( string $stylesheet, string $context ): string|WP_Error {
		if ( ! in_array( $context, self::ENQUEUE_CONTEXTS, true ) ) {
			return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in WagnerSprayTechDigitalRiverIntegration stylesheet loader.' );
		}

		return WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_URL . "dist/${context}/${stylesheet}.css";
	}

	/**
	 * Enqueue styles for admin.
	 *
	 * @return void
	 */
	public function admin_styles(): void {
		wp_enqueue_style(
			'wagnerspraytech_digital_river_integration_admin',
			$this->style_url( 'admin', 'admin' ),
			[],
			WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_VERSION
		);
	}
}
