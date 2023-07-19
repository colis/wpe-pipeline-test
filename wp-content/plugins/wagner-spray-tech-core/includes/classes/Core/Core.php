<?php
/**
 * Wagner Spray Tech Core Plugin Core Functionality
 *
 * @package WagnerSprayTechCore\Core
 */

namespace WagnerSprayTechCore\Core;

use WagnerSprayTechCore\BaseAbstract;
use WP_Error;

/**
 * WordPress Core Functionality.
 */
class Core extends BaseAbstract {

	/**
	 * Script and Style enqueue contexts allowed.
	 */
	private const ENQUEUE_CONTEXTS = [ 'admin', 'frontend', 'shared' ];


	/**
	 * Activate the plugin
	 *
	 * @return void
	 */
	public function activation_hook(): void {
		flush_rewrite_rules();
		do_action( 'wagnerspraytech_core_plugin_activated' );
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
		do_action( 'wagnerspraytech_core_plugin_deactivated' );
	}


	/**
	 * Registers the default textdomain.
	 *
	 * @return void
	 */
	public function i18n(): void {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'wagner-spray-tech-core' );
		load_textdomain( 'wagner-spray-tech-core', WP_LANG_DIR . '/wagner-spray-tech-core/wagner-spray-tech-core-' . $locale . '.mo' );
		load_plugin_textdomain( 'wagner-spray-tech-core', false, plugin_basename( WAGNERSPRAYTECH_CORE_PLUGIN_PATH ) . '/languages/' );
	}


	/**
	 * Add async/defer attributes to enqueued scripts that have the specified script_execution flag.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12009
	 *
	 * @param  string $tag  The script tag.
	 * @param  string $handle  The script handle.
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
	 * Enqueue scripts for front-end.
	 *
	 * @return void
	 */
	public function scripts(): void {
		wp_enqueue_script(
			'wagnerspraytech_core_plugin_shared',
			$this->script_url( 'shared', 'shared' ),
			[],
			WAGNERSPRAYTECH_CORE_PLUGIN_VERSION,
			true
		);

		wp_enqueue_script(
			'wagnerspraytech_core_plugin_frontend',
			$this->script_url( 'frontend', 'frontend' ),
			[],
			WAGNERSPRAYTECH_CORE_PLUGIN_VERSION,
			true
		);
	}

	/**
	 * Generate an URL to a script.
	 *
	 * @param  string $script  Script file name (no .js extension).
	 * @param  string $context  Context for the script ('admin', 'frontend', or 'shared').
	 *
	 * @return string|WP_Error URL
	 */
	public function script_url( string $script, string $context ): string|WP_Error {
		if ( ! in_array( $context, self::ENQUEUE_CONTEXTS, true ) ) {
			return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in WagnerSprayTechCore script loader.' );
		}

		return WAGNERSPRAYTECH_CORE_PLUGIN_URL . "dist/${context}/${script}.js";
	}

	/**
	 * Enqueue scripts for admin.
	 *
	 * @return void
	 */
	public function admin_scripts(): void {
		wp_enqueue_script(
			'wagnerspraytech_core_plugin_shared',
			$this->script_url( 'shared', 'shared' ),
			[],
			WAGNERSPRAYTECH_CORE_PLUGIN_VERSION,
			true
		);

		wp_enqueue_script(
			'wagnerspraytech_core_plugin_admin',
			$this->script_url( 'admin', 'admin' ),
			[],
			WAGNERSPRAYTECH_CORE_PLUGIN_VERSION,
			true
		);
	}

	/**
	 * Enqueue styles for front-end.
	 *
	 * @return void
	 */
	public function styles(): void {
		wp_enqueue_style(
			'wagnerspraytech_core_plugin_shared',
			$this->style_url( 'shared', 'shared' ),
			[],
			WAGNERSPRAYTECH_CORE_PLUGIN_VERSION
		);

		if ( is_admin() ) {
			wp_enqueue_style(
				'wagnerspraytech_core_plugin_admin',
				$this->style_url( 'admin', 'admin' ),
				[],
				WAGNERSPRAYTECH_CORE_PLUGIN_VERSION
			);
		} else {
			wp_enqueue_style(
				'wagnerspraytech_core_plugin_frontend',
				$this->style_url( 'frontend', 'frontend' ),
				[],
				WAGNERSPRAYTECH_CORE_PLUGIN_VERSION
			);
		}
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
			return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in WagnerSprayTechCore stylesheet loader.' );
		}

		return WAGNERSPRAYTECH_CORE_PLUGIN_URL . "dist/${context}/${stylesheet}.css";
	}

	/**
	 * Enqueue styles for admin.
	 *
	 * @return void
	 */
	public function admin_styles(): void {
		wp_enqueue_style(
			'wagnerspraytech_core_plugin_shared',
			$this->style_url( 'shared', 'shared' ),
			[],
			WAGNERSPRAYTECH_CORE_PLUGIN_VERSION
		);

		wp_enqueue_style(
			'wagnerspraytech_core_plugin_admin',
			$this->style_url( 'admin', 'admin' ),
			[],
			WAGNERSPRAYTECH_CORE_PLUGIN_VERSION
		);
	}

	/**
	 * Customize the length of the post excerpt.
	 *
	 * @param int $length The excerpt length.
	 *
	 * @return int
	 */
	public function wagner_excerpt_length( int $length ): int {
		$length = 30;

		return $length;
	}

	/**
	 * Customize the post excerpt more value.
	 *
	 * @param string $more The excerpt more value.
	 *
	 * @return string
	 */
	public function wagner_excerpt_more( string $more ): string {
		$more = '...';

		return $more;
	}

	/**
	 * Add post excerpt support.
	 *
	 * @return void
	 */
	public function wagner_excerpt_support(): void {
		\add_post_type_support( 'page', 'excerpt' );
	}
}
