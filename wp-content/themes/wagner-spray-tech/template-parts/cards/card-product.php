<?php
/**
 * Product Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

$card_post_id   = $args['post']['id'] ?? get_the_ID();
$card_title     = get_the_title( $card_post_id );
$featured_image = get_the_post_thumbnail( $card_post_id, 'medium' );
$price          = get_field( 'wst_product_price', $card_post_id );
?>

<article id="post-<?php echo esc_attr( $card_post_id ); ?>" class="grid-card c-card c-card-product wst-blocks-product-card">
	<?php if ( ! empty( $featured_image ) ) : ?>
		<figure class="wst-blocks-product-card__image">
			<?php echo wp_kses_post( $featured_image ); ?>
		</figure>
	<?php endif; ?>

	<?php if ( ! empty( $card_title ) ) : ?>
		<h3 class="wst-blocks-product-card__title">
			<?php echo esc_html( $card_title ); ?>
		</h3>
	<?php endif; ?>

	<?php if ( ! empty( $price ) ) : ?>
		<p class="wst-blocks-product-card__price">
			<?php echo esc_html( $price ); ?>
		</p>
	<?php endif; ?>

	<?php
	if ( function_exists( 'wagner_spray_tech_cart_btn' ) ) {
		wagner_spray_tech_cart_btn( (int) $card_post_id ?? 0 );
	}
	?>
</article>
