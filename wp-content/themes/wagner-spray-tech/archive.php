<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="c-content-area">
		<main id="main" class="c-site-main c-archive-main" role="main">

		<?php
		if ( have_posts() ) {
			?>

			<header class="c-archive-header alignfull">
				<div class="o-container">
					<?php the_archive_title(); ?>
					<?php the_archive_description( '<p class="archive-description">', '</p>' ); ?>
				</div>
			</header>

			<?php do_action( 'wagner_spray_tech_archive_content_header' ); ?>

			<div class="grid-posts grid-posts__3">

				<?php
				// Start the Loop.
				while ( have_posts() ) :
					the_post();
					?>

					<div class="grid-col">
						<?php get_template_part( 'template-parts/cards/card', 'post' ); ?>
					</div>

					<?php
					// End the loop.
				endwhile;
				?>

			</div>

			<?php
			// Numbered pagination.
			wagner_spray_tech_the_posts_pagination();
		} else {
			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );
		}
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
