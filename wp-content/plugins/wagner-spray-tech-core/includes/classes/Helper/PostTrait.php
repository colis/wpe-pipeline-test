<?php
/**
 * Core Plugin Starter PostTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

use WP_Query;

/**
 * Core Plugin Starter PostTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait PostTrait {

	/**
	 * Return the first immediate child of a parent post
	 *
	 * @param int    $parent_id The parent post id.
	 * @param string $post_type The post type.
	 *
	 * @return int
	 */
	protected function get_post_id_by_parent( int $parent_id, string $post_type = 'any' ): int {

		$args = [
			'posts_per_page'         => 1,
			'post_type'              => $post_type,
			'post_status'            => ( 'attachment' === $post_type ) ? 'inherit' : 'publish',
			'post_parent'            => $parent_id,
			'fields'                 => 'ids',
			'cache_result'           => false,
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		];

		$rtn = ( new WP_Query( $args ) )->get_posts() ?? [ 0 ];

		return (int) current( $rtn );
	}

	/**
	 * Shortcut to get all posts for a type using vip cached wp_query and recommended args.
	 *
	 * @param string $post_type The post type name.
	 * @param int    $posts_per_page   Amount of posts to return, 1 by default.
	 *
	 * @return array
	 */
	protected function get_post_ids_by_cpt( string $post_type, int $posts_per_page = 1 ): array {

		$args = [
			'posts_per_page'         => $posts_per_page,
			'post_type'              => $post_type,
			'post_status'            => ( 'attachment' === $post_type ) ? 'inherit' : 'publish',
			'fields'                 => 'ids',
			'cache_result'           => false,
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		];

		return ( new WP_Query( $args ) )->get_posts() ?? [];
	}

	/**
	 * Return an array of posts based on a taxonomy term query
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @param mixed  $terms Taxonomy term(s).
	 * @param string $field Term field: term_id, name, slug or term_taxonomy_id.
	 * @param int    $posts_per_page Amount of posts to return, 1 by default.
	 *
	 * @return array
	 */
	protected function get_post_ids_by_term( string $taxonomy, mixed $terms, string $field = 'term_id', int $posts_per_page = 1 ): array {

		$args = [
			'posts_per_page'      => $posts_per_page, //phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
			'post_type'           => 'any',
			'fields'              => 'ids',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'tax_query'           => [ //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				[
					'taxonomy' => $taxonomy,
					'field'    => $field,
					'terms'    => $terms,
				],
			],
		];

		return ( new WP_Query( $args ) )->get_posts();
	}


	/**
	 * Reusable method to get a post id (or 0 on fail) by post meta key => value
	 *
	 * @param string $key Meta Key.
	 * @param string $value Meta Value.
	 * @param string $post_type CPT slug.
	 * @param int    $posts_per_page Amount of posts to return, 1 by default.
	 *
	 * @return array
	 */
	protected function get_post_ids_by_meta_key(
		string $key,
		string $value,
		string $post_type = 'any',
		int $posts_per_page = 1
	): array {

		$args = [
			'posts_per_page' => $posts_per_page,
			'post_type'      => $post_type,
			'fields'         => 'ids',
			'post_status'    => ( 'attachment' === $post_type ) ? 'inherit' : 'publish',
			'no_found_rows'  => true,
			'meta_query'     => [ //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				[
					'key'   => $key,
					'value' => $value,
				],
			],
		];

		return ( new WP_Query( $args ) )->get_posts();
	}
}
