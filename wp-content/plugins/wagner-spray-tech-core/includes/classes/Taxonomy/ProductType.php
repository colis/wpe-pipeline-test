<?php
/**
 * Product Type taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

/**
 * ProductType Taxonomy.
 *
 * @package WagnerSprayTechCore\PostType
 */
class ProductType extends BaseTaxonomyAbstract {

	public const NAME = 'product_type_tax';

	/**
	 * Return the taxonomy arguments.
	 *
	 * @return array
	 */
	protected function get_arguments(): array {
		return [
			'hierarchical'      => false,
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
		return __( 'Product Type', 'wagner-spray-tech-core' );
	}

	/**
	 * Return the taxonomy labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'              => __( 'Product Types', 'wagner-spray-tech-core' ),
			'menu_name'         => __( 'Product Types', 'wagner-spray-tech-core' ),
			'all_items'         => __( 'All Product Types', 'wagner-spray-tech-core' ),
			'search_items'      => __( 'Search Product Types', 'wagner-spray-tech-core' ),
			'popular_items'     => __( 'Popular Product Types', 'wagner-spray-tech-core' ),

			// Singulars.
			'singular_name'     => __( 'Product Type', 'wagner-spray-tech-core' ),
			'parent_item_colon' => __( 'Parent Product Type:', 'wagner-spray-tech-core' ),
			'new_item_name'     => __( 'New Product Type Name', 'wagner-spray-tech-core' ),
			'add_new_item'      => __( 'Add New Product Type', 'wagner-spray-tech-core' ),
			'new_item'          => __( 'New Product Type', 'wagner-spray-tech-core' ),
			'edit_item'         => __( 'Edit Product Type', 'wagner-spray-tech-core' ),
			'update_item'       => __( 'Update Product Type', 'wagner-spray-tech-core' ),
			'view_item'         => __( 'View Product Type', 'wagner-spray-tech-core' ),

		];
	}
}
