<?php
/**
 * Displays header call-to-actions
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$has_primary_nav       = has_nav_menu( 'primary' );
$has_primary_nav_items = wp_nav_menu(
	[
		'theme_location' => 'primary',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);

?>

<div class="c-site-header__cta">

	<a href="/cart" class="button cart" aria-label="<?php esc_html_e( 'View cart', 'wagner-spray-tech' ); ?>">
		<span><?php echo wagner_spray_tech_get_icon_svg( 'shopping_cart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	</a>

	<button class="button search js-header-search-toggle" aria-label="<?php esc_html_e( 'Toggle search', 'wagner-spray-tech' ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search Wagner Spray Tech', 'wagner-spray-tech' ); ?></span>
		<span><?php echo wagner_spray_tech_get_icon_svg( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	</button>

	<div class="c-site-header__menu-button-container">

		<?php if ( $has_primary_nav && $has_primary_nav_items ) : ?>
			<button id="primary-open-menu" class="button open" aria-label="<?php esc_html_e( 'Open main navigation menu', 'wagner-spray-tech' ); ?>">
				<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'wagner-spray-tech' ); ?></span>
				<span><?php echo wagner_spray_tech_get_icon_svg( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="hide-visually expanded-text"><?php esc_html_e( 'expanded', 'wagner-spray-tech' ); ?></span>
			</button>

			<button id="primary-close-menu" class="button close" aria-label="<?php esc_html_e( 'Close main navigation menu', 'wagner-spray-tech' ); ?>">
				<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'wagner-spray-tech' ); ?></span>
				<span><?php echo wagner_spray_tech_get_icon_svg( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="hide-visually collapsed-text"><?php esc_html_e( 'collapsed', 'wagner-spray-tech' ); ?></span>
			</button>
		<?php endif; ?>

	</div>

</div>
