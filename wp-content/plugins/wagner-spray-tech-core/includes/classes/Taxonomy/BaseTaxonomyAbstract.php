<?php
/**
 * Base class that all Taxonomies should extend from.
 *
 * @package WagnerSprayTechCore\Taxonomy
 */

namespace WagnerSprayTechCore\Taxonomy;

use WagnerSprayTechCore\BaseAbstract;
use WagnerSprayTechCore\PostType\Document as DocumentCpt;
use WagnerSprayTechCore\PostType\Faq as FaqCpt;
use WagnerSprayTechCore\PostType\HowTo as HowToCpt;
use WagnerSprayTechCore\PostType\Product as ProductCpt;
use WagnerSprayTechCore\PostType\Project as ProjectCpt;
use WagnerSprayTechCore\PostType\Testimonial as TestimonialCpt;
use function register_extended_taxonomy;
use function Shadow_Taxonomy\Core\create_relationship;

/**
 * Base class that all Taxonomies should extend from.
 */
abstract class BaseTaxonomyAbstract extends BaseAbstract {

	public const CUSTOM_POST_TYPES = [
		ProductCpt::NAME,
		ProjectCpt::NAME,
		HowToCpt::NAME,
		FaqCpt::NAME,
		TestimonialCpt::NAME,
		DocumentCpt::NAME,
		'post',
		'page',
		'wpsl_stores',
	];

	public const SHOW_UI = true;

	public const IS_SHADOW = false;

	public const SHADOW_CPT_NAMES = [];

	/**
	 * Register the custom taxonomy.
	 */
	public function register(): void {

		$current_tax = get_class( $this );

		$args = \wp_parse_args(
			$this->get_arguments(),
			[
				'labels'             => $this->get_labels(),
				'description'        => $this->get_description(),
				'hierarchical'       => true,
				'public'             => true,
				'show_ui'            => $current_tax::SHOW_UI,
				'show_admin_column'  => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => true,
				'show_in_quick_edit' => true,
				'show_in_rest'       => true,
				'show_tagcloud'      => false,
				'capabilities'       => $this->get_capabilities(),
				'admin_filters'      => $this->get_admin_filters(),
				'admin_cols'         => $this->get_admin_cols(),
			]
		);

		register_extended_taxonomy( $current_tax::NAME, $current_tax::CUSTOM_POST_TYPES, $args );

		// If the taxonomy being registered is set as a shadow taxonomy, create the relationship.
		if ( $current_tax::IS_SHADOW ) {
			foreach ( $current_tax::SHADOW_CPT_NAMES as $cpt_name ) {
				create_relationship( $cpt_name, $current_tax::NAME );
			}
		}

		// Setup any default terms if necessary.
		$this->create_default_terms();
	}


	/**
	 * Return the labels for the taxonomy.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [];
	}

	/**
	 * Return the description for the taxonomy.
	 *
	 * @return string
	 */
	protected function get_description(): string {
		return '';
	}

	/**
	 * Get the arguments that configure the custom taxonomy.
	 *
	 * @return array Array of arguments.
	 */
	protected function get_arguments(): array {
		return [];
	}

	/**
	 * Get the capabilities for the taxonomy.
	 *
	 * @return array
	 */
	protected function get_capabilities(): array {
		return [];
	}

	/**
	 * Set any default terms for the taxonomy.
	 *
	 * @return void
	 */
	protected function create_default_terms(): void {
		// Do nothing by default.
	}

	/**
	 * Get the admin filters array.
	 *
	 * @return array
	 */
	protected function get_admin_filters(): array {
		return [];
	}

	/**
	 * Get the admin columns array.
	 *
	 * @return array
	 */
	protected function get_admin_cols(): array {
		return [];
	}
}
