<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
			?>

			<header class="page-header">
				<?php
				printf(
					/* translators: 1: search result title. 2: search term. */
					'<h1 class="page-title">%1$s <span class="page-description search-term">%2$s</span></h1>',
					esc_html_e( 'Search results for:', 'wagner-spray-tech' ),
					get_search_query()
				);
				?>
			</header><!-- .page-header -->

			<?php
			while ( have_posts() ) {
				the_post();

				get_template_part( 'template-parts/cards/card', 'media' );
			}

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
