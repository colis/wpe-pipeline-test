<?php
/**
 * Displays Navigation
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

<?php if ( $has_primary_nav && $has_primary_nav_items ) : ?>
	<nav id="site-navigation" class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Main', 'wagner-spray-tech' ); ?>">
		<?php
		wp_nav_menu(
			[
				'theme_location'  => 'primary',
				'menu_class'      => 'menu-wrapper',
				'container_class' => 'primary-menu-container',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'depth'           => 4,
			]
		);
		?>
	</nav>
<?php endif; ?>
