<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WagnerSprayTech
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="c-comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="c-comments-area__title">
			<?php
			$wagner_spray_tech_comment_count = get_comments_number();
			if ( '1' === $wagner_spray_tech_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( '1 Comment', 'wagner-spray-tech' )
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comment', '%1$s Comments', $wagner_spray_tech_comment_count, 'comments title', 'wagner-spray-tech' ) ),
					esc_html( number_format_i18n( $wagner_spray_tech_comment_count ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="c-comments-area__list">
			<?php
			wp_list_comments(
				[
					'avatar_size' => 42,
					'style'       => 'ol',
					'type'        => 'comment',
				]
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wagner-spray-tech' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form(
		[
			'logged_in_as' => null,
			'title_reply'  => esc_html__( 'Leave a reply', 'wagner-spray-tech' ),
		]
	);
	?>

</div><!-- #comments -->
