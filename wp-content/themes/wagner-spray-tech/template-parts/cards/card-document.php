<?php
/**
 * Document Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

$card_post_id = $args['post']['id'] ?? get_the_ID();
$card_type    = get_field( 'type', $card_post_id ) ?? '';
$file_name    = get_the_title( $card_post_id );
$file_link    = wp_get_attachment_url( get_field( 'file', $card_post_id ) ) ?? '';

?>

<article id="post-<?php echo esc_attr( $card_post_id ); ?>" class="grid-card c-card c-card-document wst-blocks-document-card">
	<div class="wst-blocks-document-card__title">
		<?php echo esc_html( $card_type ); ?>
	</div>
	<a href="<?php echo esc_url( $file_link ); ?>" target="_blank" class="wst-blocks-document-card__button">
		<?php echo esc_html( $file_name ); ?>
	</a>
</article>
