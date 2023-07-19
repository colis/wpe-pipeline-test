<?php
/**
 * Product Series CPT.
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore\PostType;

/**
 * ProductType CPT.
 *
 * @package WagnerSprayTechCore\PostType
 */
class ProductSeries extends BasePostTypeAbstract {

	public const NAME = 'product-series';
	public const SLUG = 'product_series';
	public const ICON = 'dashicons-products';

	/**
	 * Product Types are  hierarchical.
	 *
	 * @return array
	 */
	public function get_arguments(): array {
		return [
			'hierarchical' => true,
		];
	}


	/**
	 * If hierarchical, page-attributes must be supported.
	 *
	 * @return string[]
	 */
	public function get_supports(): array {
		return [
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'author',
			'excerpt',
			'custom-fields',
			'page-attributes',
		];
	}

	/**
	 * Custom How To labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'           => __( 'Product Series', 'wagner-spray-tech-core' ),
			'menu_name'      => __( 'Product Series', 'wagner-spray-tech-core' ),
			'name_admin_bar' => __( 'Product Series', 'wagner-spray-tech-core' ),
			'all_items'      => __( 'All Product Series', 'wagner-spray-tech-core' ),
			'view_items'     => __( 'View Product Series', 'wagner-spray-tech-core' ),
			'search_items'   => __( 'Search Product Series', 'wagner-spray-tech-core' ),
			'archives'       => __( 'Product Series Archives', 'wagner-spray-tech-core' ),
			'attributes'     => __( 'Product Series Attributes', 'wagner-spray-tech-core' ),
		];
	}
}
