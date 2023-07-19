<?php
/**
 * Template part for displaying post content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

<?php do_action( 'wagner_spray_tech_single_header' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'wagner_spray_tech_single_content_header' ); ?>

	<div class="entry-content">
		<?php
		do_action( 'wagner_spray_tech_single_content_before' );

		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wagner-spray-tech' ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				get_the_title()
			)
		);

		do_action( 'wagner_spray_tech_single_content_after' );
		?>
	</div><!-- .entry-content -->

	<?php do_action( 'wagner_spray_tech_single_content_footer' ); ?>

</article>

<?php do_action( 'wagner_spray_tech_single_footer' ); ?>
