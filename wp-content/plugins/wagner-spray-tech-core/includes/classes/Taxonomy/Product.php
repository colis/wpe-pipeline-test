<?php
/**
 * Product Shadow taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

use WagnerSprayTechCore\PostType\Product as ProductCpt;

/**
 * ProjectType Taxonomy.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Product extends BaseTaxonomyAbstract {

	public const NAME      = 'product_tax';
	public const IS_SHADOW = true;

	public const SHADOW_CPT_NAMES = [ ProductCpt::NAME ];

	/**
	 * Return the taxonomy arguments.
	 *
	 * @return array
	 */
	protected function get_arguments(): array {
		return [
			'show_admin_column' => false,
			'show_in_menu'      => true,
		];
	}

	/**
	 * Return the taxonomy description.
	 *
	 * @return string
	 */
	protected function get_description(): string {
		return __( 'Product Shadow', 'wagner-spray-tech-core' );
	}

	/**
	 * Return the taxonomy labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'              => __( 'Products', 'wagner-spray-tech-core' ),
			'menu_name'         => __( 'Products', 'wagner-spray-tech-core' ),
			'all_items'         => __( 'All Products', 'wagner-spray-tech-core' ),
			'search_items'      => __( 'Search Products', 'wagner-spray-tech-core' ),
			'popular_items'     => __( 'Popular Products', 'wagner-spray-tech-core' ),

			// Singulars.
			'singular_name'     => __( 'Product', 'wagner-spray-tech-core' ),
			'parent_item_colon' => __( 'Parent Product:', 'wagner-spray-tech-core' ),
			'new_item_name'     => __( 'New Product Name', 'wagner-spray-tech-core' ),
			'add_new_item'      => __( 'Add New Product', 'wagner-spray-tech-core' ),
			'new_item'          => __( 'New Product', 'wagner-spray-tech-core' ),
			'edit_item'         => __( 'Edit Product', 'wagner-spray-tech-core' ),
			'update_item'       => __( 'Update Product', 'wagner-spray-tech-core' ),
			'view_item'         => __( 'View Product', 'wagner-spray-tech-core' ),

		];
	}
}
