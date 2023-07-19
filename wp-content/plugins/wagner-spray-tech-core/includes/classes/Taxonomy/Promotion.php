<?php
/**
 * Promotion taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

use WagnerSprayTechCore\PostType\{HowTo as HowToCpt, Product as ProductCpt, Project as ProjectCpt};

/**
 * Promotion Taxonomy.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Promotion extends BaseTaxonomyAbstract {

	public const NAME = 'promotion_tax';

	public const CUSTOM_POST_TYPES = [
		'post',
		ProductCpt::NAME,
		ProjectCpt::NAME,
		HowToCpt::NAME,
	];


	/**
	 * Return the taxonomy arguments.
	 *
	 * @return array
	 */
	protected function get_arguments(): array {
		return [
			'hierarchical' => false,
		];
	}

	/**
	 * Return the taxonomy description.
	 *
	 * @return string
	 */
	protected function get_description(): string {
		return __( 'Promotion', 'wagner-spray-tech-core' );
	}

	/**
	 * Return the taxonomy labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'              => __( 'Promotions', 'wagner-spray-tech-core' ),
			'menu_name'         => __( 'Promotions', 'wagner-spray-tech-core' ),
			'all_items'         => __( 'All Promotions', 'wagner-spray-tech-core' ),
			'search_items'      => __( 'Search Promotions', 'wagner-spray-tech-core' ),
			'popular_items'     => __( 'Popular Promotions', 'wagner-spray-tech-core' ),

			// Singulars.
			'singular_name'     => __( 'Promotion', 'wagner-spray-tech-core' ),
			'parent_item_colon' => __( 'Parent Promotion:', 'wagner-spray-tech-core' ),
			'new_item_name'     => __( 'New Promotion Name', 'wagner-spray-tech-core' ),
			'add_new_item'      => __( 'Add New Promotion', 'wagner-spray-tech-core' ),
			'new_item'          => __( 'New Promotion', 'wagner-spray-tech-core' ),
			'edit_item'         => __( 'Edit Promotion', 'wagner-spray-tech-core' ),
			'update_item'       => __( 'Update Promotion', 'wagner-spray-tech-core' ),
			'view_item'         => __( 'View Promotion', 'wagner-spray-tech-core' ),
		];
	}
}
