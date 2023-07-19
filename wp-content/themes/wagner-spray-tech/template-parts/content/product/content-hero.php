<?php
/**
 * Template part for displaying Product hero content
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

?>
<header class="c-page-hero c-page-hero__product">

	<div class="wp-block-column c-post-hero__gallery">
		<?php
			// Tablet Up Gallery.
			get_template_part( 'template-parts/content/product/content-hero/gallery-thumbnails' );
			get_template_part( 'template-parts/content/product/content-hero/featured-image' );

		?>
	</div>


	<article class="wp-block-column c-post-hero__details">
		<?php get_template_part( 'template-parts/content/product/content-hero/details' ); ?>
	</article>


</header>




