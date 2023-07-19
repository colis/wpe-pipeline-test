<?php
/**
 * Core Plugin Starter TaxonomyTrait helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

use WP_Term_Query;

/**
 * Core Plugin Starter TaxonomyTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait TaxonomyTrait {


	/**
	 * Return taxonomy terms filtered by meta key and value
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @param string $meta_key Key to look for.
	 * @param string $meta_value Value to look for.
	 *
	 * @return array
	 */
	protected function get_term_by_meta( string $taxonomy, string $meta_key, string $meta_value ): array {

		$args = [
			'fields'       => 'ids',
			'taxonomy'     => $taxonomy,
			'hide_empty'   => false,
			'meta_key'     => $meta_key, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'   => $meta_value, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'meta_compare' => '=',
		];

		return ( new WP_Term_Query( $args ) )->terms ?? [];
	}

	/**
	 * Return a term id based on a related (shadow) post meta value
	 *
	 * @param string $post_meta_key Post meta key to use.
	 * @param string $term_meta_key Term meta key to use.
	 * @param string $post_meta_value Post meta value to look up.
	 *
	 * @return int
	 */
	protected function get_term_id_from_post_meta( string $post_meta_key, string $term_meta_key, string $post_meta_value ): int {
		global $wpdb;

		$post_meta_key   = (string) esc_sql( $post_meta_key );
		$term_meta_key   = (string) esc_sql( $term_meta_key );
		$post_meta_value = (string) esc_sql( $post_meta_value );

		$query = "
				SELECT w.term_id
				FROM {$wpdb->prefix}postmeta wp
				LEFT JOIN {$wpdb->prefix}termmeta w
				ON wp.post_id = w.meta_value
				WHERE wp.meta_key = '{$post_meta_key}' AND wp.meta_value = %s
				AND w.meta_key = '{$term_meta_key}'";

		$prepare = $wpdb->prepare( $query, $post_meta_value ); // phpcs:ignore

		return absint( $wpdb->get_var( $prepare ) ); // phpcs:ignore
	}
}
