<?php
/**
 * Base class that all CPTs should extend from.
 *
 * @package WagnerSprayTechCore\PostType
 */

namespace WagnerSprayTechCore\PostType;

use WagnerSprayTechCore\BaseAbstract;
use function register_extended_post_type;

/**
 * Abstract class BaseCustomPostType.
 *
 * @package WagnerSprayTechCore\PostType
 */
abstract class BasePostTypeAbstract extends BaseAbstract {

	/**
	 * Register the custom post type.
	 */
	public function register(): void {

		$current_cpt = get_class( $this );

		$arguments = wp_parse_args(
			$this->get_arguments(),
			[
				'menu_position'       => 5,
				'menu_icon'           => $current_cpt::ICON,
				'delete_with_user'    => false,
				'public'              => true,
				'hierarchical'        => false,
				'show_in_rest'        => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'show_in_nav_menus'   => true,
				'labels'              => $this->get_labels(),
				'supports'            => $this->get_supports(),
				'admin_filters'       => $this->get_admin_filters(),
				'admin_cols'          => $this->get_admin_cols(),
				'template'            => $this->get_template(),
			]
		);

		register_extended_post_type( $current_cpt::NAME, $arguments );
	}


	/**
	 * Get the arguments that configure the custom post type.
	 *
	 * @return array Array of arguments.
	 */
	protected function get_arguments(): array {
		return [];
	}

	/**
	 * Get the labels array.
	 *
	 * @return array
	 */
	protected function get_labels(): array {
		return [];
	}

	/**
	 * Get the supports array.
	 *
	 * @return array
	 */
	protected function get_supports(): array {
		return [
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'author',
			'excerpt',
			'custom-fields',
		];
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

	/**
	 * Get the post default template array.
	 *
	 * @return array
	 */
	protected function get_template(): array {
		return [];
	}
}
