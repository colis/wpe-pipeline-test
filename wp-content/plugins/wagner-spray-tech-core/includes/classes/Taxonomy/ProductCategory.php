<?php
/**
 * Product Type taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

use WagnerSprayTechCore\PostType\Product as ProductCpt;

/**
 * ProductCategory Taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */
class ProductCategory extends BaseTaxonomyAbstract {

	public const NAME = 'product_category_tax';

	public const CUSTOM_POST_TYPES = [
		ProductCpt::NAME,
	];

	/**
	 * Return the taxonomy arguments.
	 *
	 * @return array
	 */
	protected function get_arguments(): array {
		return [
			'show_admin_column' => false,
			'show_in_menu'      => true,
			'hierarchical'      => false,
		];
	}

	/**
	 * Return the taxonomy description.
	 *
	 * @return string
	 */
	protected function get_description(): string {
		return __( 'Product Category', 'wagner-spray-tech-core' );
	}

	/**
	 * Return the taxonomy labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'              => __( 'Product Categories', 'wagner-spray-tech-core' ),
			'menu_name'         => __( 'Product Categories', 'wagner-spray-tech-core' ),
			'all_items'         => __( 'All Product Categories', 'wagner-spray-tech-core' ),
			'search_items'      => __( 'Search Product Categories', 'wagner-spray-tech-core' ),
			'popular_items'     => __( 'Popular Product Categories', 'wagner-spray-tech-core' ),

			// Singulars.
			'singular_name'     => __( 'Product Category', 'wagner-spray-tech-core' ),
			'parent_item_colon' => __( 'Parent Product Category:', 'wagner-spray-tech-core' ),
			'new_item_name'     => __( 'New Product Type Category', 'wagner-spray-tech-core' ),
			'add_new_item'      => __( 'Add New Product Category', 'wagner-spray-tech-core' ),
			'new_item'          => __( 'New Product Category', 'wagner-spray-tech-core' ),
			'edit_item'         => __( 'Edit Product Category', 'wagner-spray-tech-core' ),
			'update_item'       => __( 'Update Product Category', 'wagner-spray-tech-core' ),
			'view_item'         => __( 'View Product Category', 'wagner-spray-tech-core' ),

		];
	}
}
