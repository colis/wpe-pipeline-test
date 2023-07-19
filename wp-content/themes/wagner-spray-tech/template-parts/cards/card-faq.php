<?php
/**
 * FAQ Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

$card_post_id = $args['post']['id'] ?? get_the_ID();
$card_title   = get_the_title( $card_post_id );
$card_excerpt = get_the_excerpt( $card_post_id );
$card_link    = get_permalink( $card_post_id );

?>

<div id="post-<?php echo esc_attr( $card_post_id ); ?>" class="grid-card c-card c-card-faq wp-block-group has-gray-100-background-color has-background is-vertical is-layout-flex wst-blocks-related-faq-card">

	<?php if ( ! empty( $card_title ) ) : ?>
		<h4 class="wp-block-heading has-large-font-size">
			<?php echo esc_html( $card_title ); ?>
		</h4>
	<?php endif; ?>

	<?php if ( ! empty( $card_excerpt ) ) : ?>
		<p class="wst-blocks-related-faq-card__excerpt">
			<?php echo esc_html( $card_excerpt ); ?>
		</p>
	<?php endif; ?>

	<?php if ( ! empty( $card_link ) ) : ?>
		<a href="<?php echo esc_url( $card_link ); ?>" class="wst-blocks-related-faq-card__button">
				<?php esc_html_e( 'View Title', 'wagner-spray-tech' ); ?>
		</a>
	<?php endif; ?>

</div>
