<?php
/**
 * Project Type CPT.
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore\PostType;

/**
 * ProjectType CPT.
 *
 * @package WagnerSprayTechCore\PostType
 */
class ProjectType extends BasePostTypeAbstract {

	public const NAME = 'project-type';
	public const SLUG = 'project_type';
	public const ICON = 'dashicons-format-status';

	/**
	 * Project Types are  hierarchical.
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
}
