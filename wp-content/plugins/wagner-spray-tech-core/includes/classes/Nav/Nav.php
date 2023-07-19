<?php
/**
 * Wagner Spray Tech Core Plugin Core Functionality
 *
 * @package WagnerSprayTechCore\Nav
 */

namespace WagnerSprayTechCore\Nav;

use WagnerSprayTechCore\BaseAbstract;
use WP_Post;

/**
 * WordPress Nav Functionality.
 */
class Nav extends BaseAbstract {

	/**
	 * Register custom navigation locations.
	 */
	public function register_nav_menus(): void {
		\register_nav_menus(
			[
				'primary'          => __( 'Primary Navigation', 'wagner-spray-tech-core' ),
				'footer'           => __( 'Footer Navigation', 'wagner-spray-tech-core' ),
				'social'           => __( 'Social Links', 'wagner-spray-tech-core' ),
				'footer-copyright' => __( 'Footer Copyright', 'wagner-spray-tech-core' ),
				'footer-products'  => __( 'Footer Products', 'wagner-spray-tech-core' ),
				'footer-how-to'    => __( 'Footer How-to', 'wagner-spray-tech-core' ),
				'footer-projects'  => __( 'Footer Projects', 'wagner-spray-tech-core' ),
				'footer-parts'     => __( 'Footer Parts & Accessories', 'wagner-spray-tech-core' ),
				'footer-support'   => __( 'Footer Support', 'wagner-spray-tech-core' ),
				'footer-about'     => __( 'Footer About Wagner', 'wagner-spray-tech-core' ),
			],
		);
	}

	/**
	 * WCAG 2.0 Attributes for Dropdown Menus
	 *
	 * Adjustments to menu attributes to support WCAG 2.0
	 * recommendations for flyout and dropdown menus.
	 *
	 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
	 *
	 * @param array   $attrs The HTML attributes.
	 * @param WP_Post $item The current menu item.
	 */
	public function nav_menu_link_attributes( array $attrs, WP_Post $item ): array {

		// Classes we expect to add [aria-haspopup] and [aria-expanded] to.
		$classes = [
			'menu-item-has-children',
		];

		// Add [aria-haspopup] and [aria-expanded] to menu items that have children.
		$item_has_children = array_intersect( $classes, $item->classes );
		if ( $item_has_children ) {
			$attrs['aria-haspopup'] = 'true';
			$attrs['aria-expanded'] = 'false';
		}

		return $attrs;
	}
}
