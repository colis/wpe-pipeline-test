<?php
/**
 * Core Plugin Starter MetaTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

/**
 * Core Plugin Starter MetaTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait MetaTrait {

	/**
	 * Return all post meta filtered by meta_key.
	 *
	 * @param string $meta_key The meta key to filter by.
	 *
	 * @return array
	 */
	protected function get_all_meta_by_key( string $meta_key ): array {

		global $wpdb;

		$meta_key = (string) esc_sql( $meta_key );

		// phpcs:ignore
		$query = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = %s";

		// phpcs:ignore
		return $wpdb->get_results( $wpdb->prepare( $query, $meta_key ), ARRAY_A ) ?? [];
	}
}
