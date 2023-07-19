<?php
/**
 * Displays the footer menu container
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$has_footer_products_nav       = has_nav_menu( 'footer-products' );
$has_footer_products_nav_items = wp_nav_menu(
	[
		'theme_location' => 'footer-products',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);

$has_footer_how_to_nav       = has_nav_menu( 'footer-how-to' );
$has_footer_how_to_nav_items = wp_nav_menu(
	[
		'theme_location' => 'footer-how-to',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);

$has_footer_projects_nav       = has_nav_menu( 'footer-projects' );
$has_footer_projects_nav_items = wp_nav_menu(
	[
		'theme_location' => 'footer-projects',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);

$has_footer_parts_nav       = has_nav_menu( 'footer-parts' );
$has_footer_parts_nav_items = wp_nav_menu(
	[
		'theme_location' => 'footer-parts',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);

$has_footer_support_nav       = has_nav_menu( 'footer-support' );
$has_footer_support_nav_items = wp_nav_menu(
	[
		'theme_location' => 'footer-support',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);

$has_footer_about_nav       = has_nav_menu( 'footer-about' );
$has_footer_about_nav_items = wp_nav_menu(
	[
		'theme_location' => 'footer-about',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);
?>

<div class="wp-block-columns footer-right-side has-black-background-color has-background">

	<div class="wp-block-column">

		<?php if ( $has_footer_products_nav && $has_footer_products_nav_items ) : ?>
			<nav id="footer-products-navigation" class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer products', 'wagner-spray-tech' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer-products',
						'menu_class'     => 'menu-footer-products',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'          => 4,
					]
				);
				?>
			</nav>
		<?php endif; ?>

	</div>

	<div class="wp-block-column">

		<?php if ( $has_footer_how_to_nav && $has_footer_how_to_nav_items ) : ?>
			<nav id="footer-how-to-navigation" class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer How to', 'wagner-spray-tech' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer-how-to',
						'menu_class'     => 'menu-footer-how-to',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'          => 4,
					]
				);
				?>
			</nav>
		<?php endif; ?>

		<?php if ( $has_footer_projects_nav && $has_footer_projects_nav_items ) : ?>
			<nav id="footer-projects-navigation" class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer projects', 'wagner-spray-tech' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer-projects',
						'menu_class'     => 'menu-footer-projects',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'          => 4,
					]
				);
				?>
			</nav>
		<?php endif; ?>

		<?php if ( $has_footer_parts_nav && $has_footer_parts_nav_items ) : ?>
			<nav id="footer-parts-navigation" class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer parts', 'wagner-spray-tech' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer-parts',
						'menu_class'     => 'menu-footer-parts',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'          => 4,
					]
				);
				?>
			</nav>
		<?php endif; ?>

	</div>

	<div class="wp-block-column">

		<?php if ( $has_footer_support_nav && $has_footer_support_nav_items ) : ?>
			<nav id="footer-support-navigation" class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer support', 'wagner-spray-tech' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer-support',
						'menu_class'     => 'menu-footer-support',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'          => 4,
					]
				);
				?>
			</nav>
		<?php endif; ?>

		<?php if ( $has_footer_about_nav && $has_footer_about_nav_items ) : ?>
			<nav id="footer-about-navigation" class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer about', 'wagner-spray-tech' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer-about',
						'menu_class'     => 'menu-footer-about',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'          => 4,
					]
				);
				?>
			</nav>
		<?php endif; ?>

	</div>

</div>
