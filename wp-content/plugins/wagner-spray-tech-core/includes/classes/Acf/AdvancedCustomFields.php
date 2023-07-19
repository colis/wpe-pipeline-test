<?php
/**
 * Wagner Spray Tech Core Plugin ACF Functionality
 *
 * @package WagnerSprayTechCore\Core
 */

namespace WagnerSprayTechCore\Acf;

use WagnerSprayTechCore\BaseAbstract;

/**
 * WordPress Acf Functionality.
 */
class AdvancedCustomFields extends BaseAbstract {

	/**
	 * Register variables.
	 */
	const SITE_OPTIONS_NAME = 'site-options';

	/**
	 * Registers a custom options page through ACF.
	 */
	public function register_acf_settings_page(): void {

		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				[
					'page_title' => __( 'Site Options', 'wagner-spray-tech-core' ),
					'menu_title' => __( 'Site Options', 'wagner-spray-tech-core' ),
					'menu_slug'  => self::SITE_OPTIONS_NAME,
					'capability' => 'activate_plugins',
					'redirect'   => false,
				]
			);
		}
	}

	/**
	 * Registers ACF fields for site options, custom post types, taxonomies and blocks.
	 */
	public function register_acf_local_fields(): void {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			foreach ( glob( __DIR__ . '/Fields/*.php' ) as $file ) {
				require_once $file;
			}
		}
	}
}
