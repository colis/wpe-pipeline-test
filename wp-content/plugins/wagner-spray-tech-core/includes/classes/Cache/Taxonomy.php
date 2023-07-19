<?php
/**
 * Core Plugin Starter Taxonomy Cache Class
 *
 * @package WagnerSprayTechCore\Cache
 */

namespace WagnerSprayTechCore\Cache;

use WagnerSprayTechCore\BaseAbstract;

/**
 * Core Plugin Starter Taxonomy Cache Class
 *
 * @package WagnerSprayTechCore\Cache
 */
class Taxonomy extends BaseAbstract {

	/**
	 * Cached version of get_term_by.
	 *
	 * Many calls to get_term_by (with name or slug lookup) across on a single pageload can easily add up the query count.
	 * This function helps prevent that by adding a layer of caching.
	 *
	 * @param string     $field Either 'slug', 'name', or 'id'.
	 * @param string|int $value Search for this term value.
	 * @param string     $taxonomy TaxonomyTrait Name.
	 * @param string     $filter Optional. Default is 'raw' or no WordPress defined filter will applied.
	 * @return \WP_Term|bool|null Term Row from database in the type specified by $filter. Will return false if $taxonomy does not exist or $term was not found.
	 * @link https://docs.wpvip.com/technical-references/caching/uncached-functions/ Uncached Functions
	 */
	public static function cached_get_term_by( string $field, string|int $value, string $taxonomy, string $filter = 'raw' ): \WP_Term|null|bool {

		// Always try to return an obvious type.
		$output = OBJECT;

		// ID lookups are already cached.
		if ( 'id' === $field ) {
			return get_term_by( $field, $value, $taxonomy, $output, $filter );
		}

		$cache_key = $field . '|' . $taxonomy . '|' . md5( $value );
		$term_id   = wp_cache_get( $cache_key, 'get_term_by' );

		if ( false === $term_id ) {
			$term = get_term_by( $field, $value, $taxonomy, $output, $filter );
			if ( $term && ! is_wp_error( $term ) ) {
				wp_cache_set( $cache_key, $term->term_id, 'get_term_by', 4 * HOUR_IN_SECONDS );
			} else {
				wp_cache_set( $cache_key, 0, 'get_term_by', 15 * MINUTE_IN_SECONDS ); // if we get an invalid value, let's cache it anyway but for a shorter period of time.
			}
		} else {
			$term = get_term( $term_id, $taxonomy, $output, $filter );
		}

		if ( is_wp_error( $term ) ) {
			$term = false;
		}

		return $term;
	}

	/**
	 * Properly clear wpcom_vip_get_term_by() cache when a term is updated
	 *
	 * @param int|string $term_id The term to flush.
	 * @param string     $taxonomy The term taxonomy to flush.
	 */
	public static function wp_flush_get_term_by_cache( int|string $term_id, string $taxonomy ): void {
		$term = get_term_by( 'id', $term_id, $taxonomy );
		if ( ! $term ) {
			return;
		}
		foreach ( [ 'name', 'slug' ] as $field ) {
			$cache_key   = $field . '|' . $taxonomy . '|' . md5( $term->$field );
			$cache_group = 'get_term_by';
			wp_cache_delete( $cache_key, $cache_group );
		}
	}


	/**
	 * Cached version of term_exists()
	 *
	 * Term exists calls can pile up on a single pageload.
	 * This function adds a layer of caching to prevent lots of queries.
	 *
	 * @param int|string $term The term to check can be id, slug or name.
	 * @param string     $taxonomy The taxonomy name to use.
	 * @param int        $parent_id Optional. ID of parent term under which to confine the exists search.
	 * @return mixed Returns null if the term does not exist. Returns the term ID
	 *               if no taxonomy is specified and the term ID exists. Returns
	 *               an array of the term ID and the term taxonomy ID the taxonomy
	 *               is specified and the pairing exists.
	 */
	public static function cached_term_exists( int|string $term, string $taxonomy = '', int $parent_id = 0 ): mixed {
		// If $parent is not null, let's skip the cache.
		if ( 0 !== $parent_id ) {
			return term_exists( $term, $taxonomy, $parent_id );
		}

		if ( ! empty( $taxonomy ) ) {
			$cache_key = $term . '|' . $taxonomy;
		} else {
			$cache_key = $term;
		}

		$cache_value = wp_cache_get( $cache_key, 'term_exists' );

		// term_exists frequently returns null, but (happily) never false.
		if ( false === $cache_value ) {
			$term_exists = term_exists( $term, $taxonomy );
			wp_cache_set( $cache_key, $term_exists, 'term_exists', 3 * HOUR_IN_SECONDS );
		} else {
			$term_exists = $cache_value;
		}

		if ( is_wp_error( $term_exists ) ) {
			$term_exists = null;
		}

		return $term_exists;
	}


	/**
	 * Properly clear cached_term_exists() cache when a term is updated
	 *
	 * @param string|int $term Term to delete cache for.
	 * @param int        $tt_id Term taxonomy id.
	 * @param string     $taxonomy Taxonomy name.
	 * @param \WP_Term   $deleted_term Deleted WP_term object.
	 */
	public static function wp_flush_term_exists( string|int $term, int $tt_id, string $taxonomy, \WP_Term $deleted_term ): void {
		foreach ( [ 'term_id', 'name', 'slug' ] as $field ) {
			$cache_key   = $deleted_term->$field . '|' . $taxonomy;
			$cache_group = 'term_exists';
			wp_cache_delete( $cache_key, $cache_group );
		}
	}
}
