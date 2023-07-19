<?php
/**
 * How To CPT.
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore\PostType;

use WagnerSprayTechCore\Taxonomy\Product as ProductTaxonomy;
use WagnerSprayTechCore\Taxonomy\ProductSeries as ProductSeriesTaxonomy;
use WagnerSprayTechCore\Taxonomy\ProductType as ProductTypeTaxonomy;
use WagnerSprayTechCore\Taxonomy\ProjectType as ProjectTypeTaxonomy;

/**
 * How To CPT.
 *
 * @package WagnerSprayTechCore\PostType
 */
class HowTo extends BasePostTypeAbstract {

	public const NAME = 'how-to';
	public const SLUG = 'how_to';
	public const ICON = 'dashicons-welcome-learn-more';

	/**
	 * How To are  hierarchical.
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
	 * Get the admin columns array.
	 *
	 * @return array
	 */
	protected function get_admin_cols(): array {
		return [
			ProductTaxonomy::NAME       => [
				'title'    => 'Related Products',
				'taxonomy' => ProductTaxonomy::NAME,
			],
			ProductSeriesTaxonomy::NAME => [
				'title'    => 'Product Series',
				'taxonomy' => ProductSeriesTaxonomy::NAME,
			],
			ProductTypeTaxonomy::NAME   => [
				'title'    => 'Product Type',
				'taxonomy' => ProductTypeTaxonomy::NAME,
			],
			ProjectTypeTaxonomy::NAME   => [
				'title'    => 'Project Type',
				'taxonomy' => ProjectTypeTaxonomy::NAME,
			],
		];
	}

	/**
	 * Get the labels.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'           => __( 'How To\'s', 'wagner-spray-tech-core' ),
			'menu_name'      => __( 'How To\'s', 'wagner-spray-tech-core' ),
			'name_admin_bar' => __( 'How To\'s', 'wagner-spray-tech-core' ),
			'all_items'      => __( 'All How To\'s', 'wagner-spray-tech-core' ),
			'view_items'     => __( 'View How To\'s', 'wagner-spray-tech-core' ),
			'search_items'   => __( 'Search How To\'s', 'wagner-spray-tech-core' ),
			'archives'       => __( 'How To\'s Archives', 'wagner-spray-tech-core' ),
			'attributes'     => __( 'How To\'s Attributes', 'wagner-spray-tech-core' ),
		];
	}
}
