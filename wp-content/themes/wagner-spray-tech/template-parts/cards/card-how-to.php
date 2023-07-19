<?php
/**
 * How-To Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

$card_post_id   = $args['post']['id'] ?? get_the_ID();
$card_title     = get_the_title( $card_post_id );
$featured_image = get_the_post_thumbnail( $card_post_id, 'medium' );
$excerpt        = get_the_excerpt( $card_post_id );
$permalink      = get_the_permalink( $card_post_id );
// Card is styled as a css grid, the children should exist as elements even if empty.
?>

<article id="post-<?php echo esc_attr( $card_post_id ); ?>" class="grid-card c-card c-card-how-to wst-blocks-how-to-card">
	<figure class="wst-blocks-how-to-card__image">
		<a href="<?php echo esc_url( $permalink ); ?>">
			<?php echo ! empty( $featured_image ) ? wp_kses_post( $featured_image ) : ''; ?>
		</a>
	</figure>

	<h3 class="wst-blocks-how-to-card__title">
		<a href="<?php echo esc_url( $permalink ); ?>">
			<?php echo esc_html( $card_title ?? '' ); ?>
		</a>
	</h3>

	<p class="wst-blocks-how-to-card__excerpt">
		<a href="<?php echo esc_url( $permalink ); ?>">
			<?php echo esc_html( wp_strip_all_tags( $excerpt ?? '', true ) ); ?>
		</a>
	</p>

	<a href="<?php echo esc_url( $permalink ); ?>" class="wst-blocks-how-to-card__button">
		<?php esc_html_e( 'More', 'wagner-spray-tech' ); ?>
	</a>
</article>
