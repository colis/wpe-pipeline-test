<?php
/**
 * Template part for displaying Post author content
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

global $post;

$social_content  = '';
$blog_post_id    = get_the_ID();
$author_id       = $post->post_author;
$author_facebook = get_the_author_meta( 'facebook', $author_id );
$author_twitter  = get_the_author_meta( 'twitter', $author_id );

// Build author name content.

$name_content = sprintf(
	'<h3 class="c-post-content-author__name">
		%s
		<a href="%s">%s</a>
	</h3>',
	__( 'Author:', 'wagner-spray-tech' ),
	esc_url( get_author_posts_url( $author_id ) ),
	get_the_author_meta( 'display_name', $author_id ),
);

// Build author social content.

if ( ! empty( $author_facebook ) && ! empty( $author_twitter ) ) {
	$social_content .= sprintf(
		'%s %s %s',
		__( 'Follow', 'wagner-spray-tech' ),
		get_the_author_meta( 'display_name', $author_id ),
		__( 'on', 'wagner-spray-tech' ),
	);
}

// Build author posts content.

$posts_content = sprintf(
	'%s <a href="%s">%s</a>',
	__( 'More articles by', 'wagner-spray-tech' ),
	esc_url( get_author_posts_url( $author_id ) ),
	get_the_author_meta( 'display_name', $author_id ),
);

?>

<div class="c-post-content-author">

	<div class="c-post-content-author__img">
		<?php echo get_avatar( $author_id, 90 ); ?>
	</div>

	<div class="c-post-content-author__content">
		<?php echo wp_kses_post( $name_content ); ?>
		<p><?php echo wp_kses_post( get_the_author_meta( 'description', $author_id ) ); ?>
	</div>

	<div class="c-post-content-author__footer">

		<div class="c-post-content-author__social">
			<?php echo wp_kses_post( $social_content ); ?>

			<?php if ( ! empty( $author_facebook ) ) : ?>
				<a class="c-post-content-author__social-link" href="<?php echo esc_url( $author_facebook ); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo wagner_spray_tech_get_icon_svg( 'facebook_f', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Facebook', 'wagner-spray-tech' ); ?></span>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $author_twitter ) ) : ?>
				<a class="c-post-content-author__social-link" href="<?php echo esc_url( $author_twitter ); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo wagner_spray_tech_get_icon_svg( 'twitter', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Facebook', 'wagner-spray-tech' ); ?></span>
				</a>
			<?php endif; ?>
		</div>

		<div class="c-post-content-author__posts">
			<?php echo wp_kses_post( $posts_content ); ?>
		</div>

	</div>

</div>
