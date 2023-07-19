<?php
/**
 * Template part for displaying Post sidebar content
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

<aside id="sidebar" class="c-site-sidebar c-post-sidebar" role="complementary">

	<?php if ( is_active_sidebar( 'blog-sidebar-widgets' ) ) : ?>
		<div class="c-post-sidebar-widgets widget-area">
			<?php dynamic_sidebar( 'blog-sidebar-widgets' ); ?>
		</div>
	<?php endif; ?>

</aside><!-- #sidebar -->
