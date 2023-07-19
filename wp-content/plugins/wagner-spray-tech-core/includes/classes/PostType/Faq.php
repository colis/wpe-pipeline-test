<?php
/**
 * FAQ CPT.
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore\PostType;

/**
 * FAQ CPT.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Faq extends BasePostTypeAbstract {

	public const NAME = 'faq';
	public const SLUG = 'faq';
	public const ICON = 'dashicons-search';

		/**
		 * Custom How To labels.
		 *
		 * @return array
		 */
	protected function get_labels(): array {
		return [
			// Plurals.
			'name'           => __( 'FAQs', 'wagner-spray-tech-core' ),
			'menu_name'      => __( 'FAQs', 'wagner-spray-tech-core' ),
			'name_admin_bar' => __( 'FAQs', 'wagner-spray-tech-core' ),
			'all_items'      => __( 'All FAQs', 'wagner-spray-tech-core' ),
			'view_items'     => __( 'View FAQs', 'wagner-spray-tech-core' ),
			'search_items'   => __( 'Search FAQs', 'wagner-spray-tech-core' ),
			'archives'       => __( 'FAQs Archives', 'wagner-spray-tech-core' ),
			'attributes'     => __( 'FAQs Attributes', 'wagner-spray-tech-core' ),
		];
	}
}
