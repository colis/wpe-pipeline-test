<?php
/**
 * Difficulty Type taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

use WagnerSprayTechCore\PostType\{HowTo as HowToCpt, Product as ProductCpt, Project as ProjectCpt, ProductSeries as ProductSeriesCpt, ProjectType as ProjectTypeCpt};

/**
 * Difficulty Taxonomy.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Difficulty extends BaseTaxonomyAbstract {

	public const NAME = 'difficulty_tax';

	public const CUSTOM_POST_TYPES = [
		ProductCpt::NAME,
		ProductSeriesCpt::NAME,
		ProjectCpt::NAME,
		ProjectTypeCpt::NAME,
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
		return __( 'Project Difficulty', 'wagner-spray-tech-core' );
	}

	/**
	 * Return the taxonomy labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'              => __( 'Difficulties', 'wagner-spray-tech-core' ),
			'menu_name'         => __( 'Difficulties', 'wagner-spray-tech-core' ),
			'all_items'         => __( 'All Difficulties', 'wagner-spray-tech-core' ),
			'search_items'      => __( 'Search Difficulties', 'wagner-spray-tech-core' ),
			'popular_items'     => __( 'Popular Difficulties', 'wagner-spray-tech-core' ),

			// Singulars.
			'singular_name'     => __( 'Difficulty', 'wagner-spray-tech-core' ),
			'parent_item_colon' => __( 'Parent Difficulty:', 'wagner-spray-tech-core' ),
			'new_item_name'     => __( 'New Difficulty Name', 'wagner-spray-tech-core' ),
			'add_new_item'      => __( 'Add New Difficulty', 'wagner-spray-tech-core' ),
			'new_item'          => __( 'New Difficulty', 'wagner-spray-tech-core' ),
			'edit_item'         => __( 'Edit Difficulty', 'wagner-spray-tech-core' ),
			'update_item'       => __( 'Update Difficulty', 'wagner-spray-tech-core' ),
			'view_item'         => __( 'View Difficulty', 'wagner-spray-tech-core' ),
		];
	}

	/**
	 * Create the default terms.
	 *
	 * @return void
	 */
	protected function create_default_terms(): void {

		$default_terms = [
			'Beginner',
			'Intermediate',
			'Advanced',
		];

		foreach ( $default_terms as $term_name ) {
			\wp_insert_term( $term_name, self::NAME );
		}
	}
}
