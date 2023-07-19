<?php
/**
 * Template part for displaying Post footer content
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$blog_post_id   = get_the_ID();
$post_tag_terms = get_the_tags( $blog_post_id ) ?: '';

// If there are no tags, bail early.
if ( empty( $post_tag_terms ) ) {
	return;
}

?>

<div class="c-post-content-footer">

	<div class="wp-block-tag-cloud">
		<span class="c-post-content-footer__heading"><?php esc_html_e( 'Tags', 'wagner-spray-tech' ); ?></span>
		<?php foreach ( $post_tag_terms as $post_tag_term ) : ?>
			<a href="<?php echo esc_url( get_term_link( $post_tag_term->term_id, $post_tag_term->taxonomy ) ); ?>" class="tag-cloud-link"><?php echo esc_html( $post_tag_term->name ); ?></a>
		<?php endforeach; ?>
	</div>

</div>
