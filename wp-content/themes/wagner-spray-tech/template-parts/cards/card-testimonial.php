<?php
/**
 * Testimonial Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

$card_post_id     = $args['post']['id'] ?? get_the_ID();
$testimonial      = get_field( 'testimonial', $card_post_id ) ?? get_the_excerpt( $card_post_id );
$subtitle         = get_field( 'subtitle', $card_post_id ) ?? '';
$background_color = get_field( 'background_color', $card_post_id ) ?? '';
$cite             = get_field( 'cite', $card_post_id ) ?? get_the_title( $card_post_id );
$cite_link        = get_field( 'link', $card_post_id ) ?? get_the_permalink( $card_post_id );
$background_image = get_field( 'background_image', $card_post_id ) ? wp_get_attachment_image( get_field( 'background_image', $card_post_id ), 'medium' ) : '';
$icon             = get_field( 'icon', $card_post_id ) ? wp_get_attachment_image( get_field( 'icon', $card_post_id ) ) : get_the_post_thumbnail( $card_post_id, 'medium' );
$theme            = get_field( 'theme', $card_post_id ) ?? 'light';

?>

<article id="post-<?php echo esc_attr( $card_post_id ); ?>" class="grid-card c-card c-card-testimonial wst-blocks-testimonial-card is-theme-<?php echo esc_attr( strtolower( $theme ) ); ?>" style="background-color: <?php echo esc_attr( $background_color ); ?>">
	<h3 class="wst-blocks-testimonial-card__testimonial">
		<?php echo wp_kses_post( $testimonial ); ?>
	</h3>

	<?php if ( ! empty( $subtitle ) ) : ?>
		<h4 class="wst-blocks-testimonial-card__subtitle">
			<?php echo esc_attr( $subtitle ); ?>
		</h4>
	<?php endif; ?>

	<?php if ( ! empty( $cite ) ) : ?>
		<a class="wst-blocks-testimonial-card__cite" href="<?php echo esc_url( $cite_link ); ?>">
			<?php echo esc_attr( $cite ); ?>
		</a>
	<?php endif; ?>

	<?php if ( ! empty( $background_image ) ) : ?>
		<figure class="wst-blocks-testimonial-card__background_image">
			<?php echo wp_kses_post( $background_image ); ?>
		</figure>
	<?php endif; ?>

	<?php if ( ! empty( $icon ) ) : ?>
		<figure class="wst-blocks-testimonial-card__icon">
			<?php echo wp_kses_post( $icon ); ?>
		</figure>
	<?php endif; ?>
</article>
