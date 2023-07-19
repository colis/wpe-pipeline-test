<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="c-content-area">
		<main id="main" class="c-site-main" role="main">

		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );
			}

			// Numbered pagination.
			wagner_spray_tech_the_posts_pagination();
		} else {
			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content-none' );
		}
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php
get_footer();
