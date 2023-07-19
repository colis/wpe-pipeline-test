<?php
/**
 * Slug (post_name) functionality.
 *
 * @package WagnerSprayTechCore\Slug
 */

namespace WagnerSprayTechCore\Slug;

use WagnerSprayTechCore\BaseAbstract;
use WagnerSprayTechCore\PostType\ProductSeries;

/**
 * Slug (post_name) functionality.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Slug extends BaseAbstract {


	private const ALLOW_DUPLICATE_SLUG_CPT = [
		ProductSeries::NAME,
	];


	/**
	 * Allow duplicate slugs for specific post types.
	 *
	 * @param string $slug The slug to be used.
	 * @param int    $post_ID The post ID.
	 * @param string $post_status The post status.
	 * @param string $post_type The post type.
	 * @param int    $post_parent The post parent ID.
	 * @param string $original_slug The original slug.
	 *
	 * @return string
	 */
	public function allow_duplicate_slugs( string $slug, int $post_ID, string $post_status, string $post_type, int $post_parent, string $original_slug ): string {

		if ( ! in_array( $post_type, self::ALLOW_DUPLICATE_SLUG_CPT, true ) ) {
			return $slug;
		}

		return $original_slug;
	}
}
