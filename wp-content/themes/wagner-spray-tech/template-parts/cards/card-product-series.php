<?php
/**
 * Product Series Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

$card_post_id   = $args['post']['id'] ?? get_the_ID();
$card_title     = get_the_title( $card_post_id ) ?? '';
$card_link      = get_permalink( $card_post_id ) ?? '';
$featured_image = get_the_post_thumbnail( $card_post_id, 'medium' ) ?? '';
$inline_styles  = isset( $color ) ? 'style="border-bottom-color: ' . $color . ';"' : '';

?>

<a href="<?php echo esc_url( $card_link ); ?>" class="grid-card c-card c-card-product-series wst-blocks-product-series-card">
	<article id="post-<?php echo esc_attr( $card_post_id ); ?>" <?php echo wp_kses_post( $inline_styles ); ?> >
		<?php if ( ! empty( $card_title ) ) : ?>
			<h3 class="wst-blocks-product-series-card__title">
				<?php echo esc_html( $card_title ); ?>
			</h3>
		<?php endif; ?>

		<?php if ( ! empty( $subtitle ) ) : ?>
			<h4 class="wst-blocks-product-series-card__subtitle">
				<?php echo esc_html( $subtitle ); ?>
			</h4>
		<?php endif; ?>

		<?php if ( ! empty( $featured_image ) ) : ?>
			<figure class="wst-blocks-product-series-card__image">
				<?php echo wp_kses_post( $featured_image ); ?>
			</figure>
		<?php endif; ?>
	</article>
</a>
