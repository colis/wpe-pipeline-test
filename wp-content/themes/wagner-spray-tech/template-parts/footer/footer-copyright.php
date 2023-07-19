<?php
/**
 * Displays the footer copyright area
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$has_copyright_nav       = has_nav_menu( 'footer-copyright' );
$has_copyright_nav_items = wp_nav_menu(
	[
		'theme_location' => 'footer-copyright',
		'fallback_cb'    => false,
		'echo'           => false,
	]
);

?>

<div class="wp-block-group has-black-background-color has-background footer-copyright">
	
	<p class="has-white-color has-text-color">Social media icons placeholder!</p>

	<div class="wp-block-group footer-copyright-middle-section">

		<?php if ( $has_copyright_nav && $has_copyright_nav_items ) : ?>
			<nav id="footer-copyright-navigation" class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer copyright', 'wagner-spray-tech' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location'  => 'footer-copyright',
						'menu_class'      => 'menu-wrapper',
						'container_class' => 'footer-copyright-menu',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 4,
					]
				);
				?>
			</nav>
		<?php endif; ?>

		<p class="has-white-color has-text-color">©2023 Wagner Spraytech. All Rights Reserved</p>

	</div>

	<figure class="wp-block-image size-full"><img src="https://wagnertech.wpengine.com/wp-content/uploads/2023/07/wagner-footer-logo.svg" alt="Wagner Company Logo"/></figure>

</div>
