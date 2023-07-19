<?php
/**
 * Product Type taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

use WagnerSprayTechCore\PostType\ProductSeries as ProductSeriesCpt;

/**
 * ProductSeries Taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */
class ProductSeries extends BaseTaxonomyAbstract {

	public const NAME      = 'product_series_tax';
	public const IS_SHADOW = true;

	public const SHADOW_CPT_NAMES = [ ProductSeriesCpt::NAME ];

	/**
	 * Return the taxonomy arguments.
	 *
	 * @return array
	 */
	protected function get_arguments(): array {
		return [
			'show_admin_column' => true,
			'show_in_menu'      => true,
		];
	}

	/**
	 * Return the taxonomy description.
	 *
	 * @return string
	 */
	protected function get_description(): string {
		return __( 'Product Series', 'wagner-spray-tech-core' );
	}

	/**
	 * Return the taxonomy labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'              => __( 'Product Series', 'wagner-spray-tech-core' ),
			'menu_name'         => __( 'Product Series', 'wagner-spray-tech-core' ),
			'all_items'         => __( 'All Product Series', 'wagner-spray-tech-core' ),
			'search_items'      => __( 'Search Product Series', 'wagner-spray-tech-core' ),
			'popular_items'     => __( 'Popular Product Series', 'wagner-spray-tech-core' ),

			// Singulars.
			'singular_name'     => __( 'Product Series', 'wagner-spray-tech-core' ),
			'parent_item_colon' => __( 'Parent Product Series:', 'wagner-spray-tech-core' ),
			'new_item_name'     => __( 'New Product Type Series', 'wagner-spray-tech-core' ),
			'add_new_item'      => __( 'Add New Product Series', 'wagner-spray-tech-core' ),
			'new_item'          => __( 'New Product Series', 'wagner-spray-tech-core' ),
			'edit_item'         => __( 'Edit Product Series', 'wagner-spray-tech-core' ),
			'update_item'       => __( 'Update Product Series', 'wagner-spray-tech-core' ),
			'view_item'         => __( 'View Product Series', 'wagner-spray-tech-core' ),

		];
	}
}
