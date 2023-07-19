<?php
/**
 * Template part for displaying Product hero Featured Image.
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

global $post;

$video = get_field( 'featured_video' );

?><figure class="wp-block-image size-full is-resized featured-image">
	<?php the_post_thumbnail( 'full', [ 'alt' => get_the_title() ] ); ?>
</figure>
