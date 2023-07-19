<?php
/**
 * Testimonial CPT.
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore\PostType;

/**
 * Testimonial CPT.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Testimonial extends BasePostTypeAbstract {

	public const NAME = 'testimonial';
	public const SLUG = 'testimonial';
	public const ICON = 'dashicons-testimonial';

	/**
	 * Get the supports.
	 *
	 * @return array
	 */
	protected function get_supports(): array {
		return [
			'title',
		];
	}
}
