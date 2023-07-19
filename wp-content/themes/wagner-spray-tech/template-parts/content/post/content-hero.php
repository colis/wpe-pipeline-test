<?php
/**
 * Template part for displaying Post hero content
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

global $post;

$blog_post_id  = get_the_ID();
$author_id     = $post->post_author;
$taxonomy_slug = 'category';
$featured_img  = ( has_post_thumbnail( $blog_post_id ) ) ?: 'c-post-hero__no-img';

// Build the comments content.

$comments_content = sprintf(
	'<a href="#comments">%s %s</a>',
	get_comments_number( $blog_post_id ),
	( get_comments_number( $blog_post_id ) === 1 ) ? __( 'comment', 'wagner-spray-tech' ) : __( 'comments', 'wagner-spray-tech' ),
);

?>

<header class="wp-block-cover alignfull ui-component--page-hero c-post-hero <?php echo esc_attr( $featured_img ); ?>">
	<span aria-hidden="true" class="has-background-dim-60 wp-block-cover__gradient-background has-background-dim"></span>
	<?php echo get_the_post_thumbnail( $blog_post_id, 'large', [ 'class' => 'wp-block-cover__image-background' ] ); ?>

	<div class="wp-block-cover__inner-container">
		<span class="c-post-hero__date"><?php echo esc_html( get_the_date() ); ?></span>
		<?php the_title( '<h1 class="has-white-color has-text-color entry-title">', '</h1>' ); ?>

		<div class="c-post-hero__meta">
			<span class="c-post-hero__author">
				<?php esc_html_e( 'By', 'wagner-spray-tech' ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></a>
			</span> /
			<span class="c-post-hero__cats"><?php the_terms( $blog_post_id, $taxonomy_slug, ' ', ', ' ); ?></span> /
			<span class="c-post-hero__comments"><?php echo wp_kses_post( $comments_content ); ?></span>
		</div>
	</div>
</header>
