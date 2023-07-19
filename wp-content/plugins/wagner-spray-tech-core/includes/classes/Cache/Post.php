<?php
/**
 * Core Plugin Starter Post Cache Class
 *
 * @package WagnerSprayTechCore\Cache
 */

namespace WagnerSprayTechCore\Cache;

use WagnerSprayTechCore\BaseAbstract;

/**
 * Core Plugin Starter Post Cache Class
 *
 * @package WagnerSprayTechCore\Cache
 */
class Post extends BaseAbstract {


	/**
	 * Cached version of get_page_by_title so that we're not making unnecessary SQL all the time
	 *
	 * @param string $title Page title.
	 * @param string $output Optional. Output type; OBJECT*, ARRAY_N, or ARRAY_A.
	 * @param string $post_type Optional. Post type; default is 'page'.
	 * @return \WP_Post|null WP_Post on success or null on failure
	 * @link https://docs.wpvip.com/technical-references/caching/uncached-functions/ Uncached Functions
	 */
	public static function cached_get_page_by_title( string $title, string $output = OBJECT, string $post_type = 'page' ): \WP_Post|null {
		$cache_key = $post_type . '_' . sanitize_key( $title );
		$page_id   = wp_cache_get( $cache_key, 'get_page_by_title' );

		if ( false === $page_id ) {
			$page    = get_post_by( $title, OBJECT, $post_type );
			$page_id = $page->ID ?? 0;
			wp_cache_set( $cache_key, $page_id, 'get_page_by_title', 3 * HOUR_IN_SECONDS ); // We only store the ID to keep our footprint small.
		}

		if ( $page_id ) {
			return get_post( $page_id, $output );
		}

		return null;
	}

	/**
	 * Flush the cache for published pages so we don't end up with stale data
	 *
	 * @param string   $new_status The post's new status.
	 * @param string   $old_status The post's previous status.
	 * @param \WP_Post $post The post.
	 * @link https://docs.wpvip.com/technical-references/caching/uncached-functions/ Uncached Functions
	 */
	public static function flush_get_page_by_title_cache( string $new_status, string $old_status, \WP_Post $post ): void {
		if ( 'publish' === $new_status || 'publish' === $old_status ) {
			wp_cache_delete( $post->post_type . '_' . sanitize_key( $post->post_title ), 'get_page_by_title' );
		}
	}



	/**
	 * Cached version of get_page_by_path so that we're not making unnecessary SQL all the time
	 *
	 * @param string       $page_path Page or CPT path.
	 * @param string       $output Optional. Output type; OBJECT*, ARRAY_N, or ARRAY_A.
	 * @param string|array $post_type Optional. Post type; default is 'page'.
	 * @return \WP_Post|null WP_Post on success or null on failure
	 * @throws \Exception On random_int failure.
	 * @link https://docs.wpvip.com/technical-references/caching/uncached-functions/ Uncached Functions
	 */
	public static function cached_get_page_by_path( string $page_path, string $output = OBJECT, string|array $post_type = 'page' ): \WP_Post|null {
		if ( is_array( $post_type ) ) {
			// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_serialize
			$cache_key = sanitize_key( $page_path ) . '_' . md5( serialize( $post_type ) );
		} else {
			$cache_key = $post_type . '_' . sanitize_key( $page_path );
		}

		$page_id = wp_cache_get( $cache_key, 'get_page_by_path' );

		if ( false === $page_id ) {
			$page    = get_page_by_path( $page_path, $output, $post_type );
			$page_id = $page->ID ?? 0;
			if ( 0 === $page_id ) {
				// phpcs:ignore WordPressVIPMinimum.Performance.LowExpiryCacheTime.CacheTimeUndetermined
				wp_cache_set( $cache_key, $page_id, 'get_page_by_path', ( 1 * HOUR_IN_SECONDS + random_int( 0, HOUR_IN_SECONDS ) ) ); // We only store the ID to keep our footprint small.
			} else {
				wp_cache_set( $cache_key, $page_id, 'get_page_by_path', 0 ); // We only store the ID to keep our footprint small.
			}
		}

		if ( $page_id ) {
			return get_post( $page_id, $output );
		}

		return null;
	}

	/**
	 * Flush the cache for published pages so we don't end up with stale data
	 *
	 * @param string   $new_status The post's new status.
	 * @param string   $old_status The post's previous status.
	 * @param \WP_Post $post       The post.
	 *
	 * @link https://docs.wpvip.com/technical-references/caching/uncached-functions/ Uncached Functions
	 */
	public static function flush_get_page_by_path_cache( string $new_status, string $old_status, \WP_Post $post ): void {
		if ( 'publish' === $new_status || 'publish' === $old_status ) {
			$page_path = get_page_uri( $post->ID );
			wp_cache_delete( $post->post_type . '_' . sanitize_key( $page_path ), 'get_page_by_path' );
		}
	}


	/**
	 * Cached version of url_to_postid, which can be expensive.
	 *
	 * Examine a url and try to determine the post ID it represents.
	 *
	 * @param string $url Permalink to check.
	 * @return int Post ID, or 0 on failure.
	 */
	public static function cached_url_to_postid( string $url ): int {
		$cache_key = md5( $url );
		$post_id   = wp_cache_get( $cache_key, 'url_to_postid' );

		if ( false === $post_id ) {
			$post_id = url_to_postid( $url ); // returns 0 on failure, so need to catch the false condition.
			wp_cache_set( $cache_key, $post_id, 'url_to_postid', 3 * HOUR_IN_SECONDS );
		}

		return (int) $post_id;
	}

	/**
	 * Flush the cache for published pages so we don't end up with stale data
	 *
	 * @param string   $new_status The post's new status.
	 * @param string   $old_status The post's previous status.
	 * @param \WP_Post $post       The post.
	 *
	 * @return void
	 */
	public static function flush_cached_url_to_postid( string $new_status, string $old_status, \WP_Post $post ): void {
		if ( 'publish' !== $new_status && 'publish' !== $old_status ) {
			return;
		}

		$url = get_permalink( $post->ID );
		wp_cache_delete( md5( $url ), 'url_to_postid' );
	}
}
