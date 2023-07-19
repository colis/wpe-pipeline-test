<?php
/**
 * Project CPT.
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore\PostType;

use WagnerSprayTechCore\Taxonomy\{Product as ProductTaxonomy,
	ProductSeries as ProductSeriesTaxonomy,
	ProductType as ProductTypeTaxonomy,
	ProjectType as ProjectTypeTaxonomy};

/**
 * Project CPT.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Project extends BasePostTypeAbstract {

	public const NAME = 'project';
	public const SLUG = 'project';
	public const ICON = 'dashicons-format-status';

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
}
