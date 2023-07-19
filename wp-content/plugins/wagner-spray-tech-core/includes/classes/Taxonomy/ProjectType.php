<?php
/**
 * Project Type taxonomy.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

use WagnerSprayTechCore\PostType\ProjectType as ProjectTypeCpt;

/**
 * ProjectType Taxonomy.
 *
 * @package WagnerSprayTechCore\PostType
 */
class ProjectType extends BaseTaxonomyAbstract {

	public const NAME             = 'project_type_tax';
	public const IS_SHADOW        = true;
	public const SHADOW_CPT_NAMES = [ ProjectTypeCpt::NAME ];

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
		return __( 'Project Type', 'wagner-spray-tech-core' );
	}

	/**
	 * Return the taxonomy labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'              => __( 'Project Types', 'wagner-spray-tech-core' ),
			'menu_name'         => __( 'Project Types', 'wagner-spray-tech-core' ),
			'all_items'         => __( 'All Project Types', 'wagner-spray-tech-core' ),
			'search_items'      => __( 'Search Project Types', 'wagner-spray-tech-core' ),
			'popular_items'     => __( 'Popular Project Types', 'wagner-spray-tech-core' ),

			// Singulars.
			'singular_name'     => __( 'Project Type', 'wagner-spray-tech-core' ),
			'parent_item_colon' => __( 'Parent Project Type:', 'wagner-spray-tech-core' ),
			'new_item_name'     => __( 'New Project Type Name', 'wagner-spray-tech-core' ),
			'add_new_item'      => __( 'Add New Project Type', 'wagner-spray-tech-core' ),
			'new_item'          => __( 'New Project Type', 'wagner-spray-tech-core' ),
			'edit_item'         => __( 'Edit Project Type', 'wagner-spray-tech-core' ),
			'update_item'       => __( 'Update Project Type', 'wagner-spray-tech-core' ),
			'view_item'         => __( 'View Project Type', 'wagner-spray-tech-core' ),
		];
	}
}
