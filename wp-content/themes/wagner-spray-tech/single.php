<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

get_header();
?><section id="primary" class="c-content-area c-<?php echo esc_attr( get_post_type() ); ?>">
		<main id="main" class="c-site-main" role="main">

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content-single' );
			endwhile;
			?>

		</main><!-- #main -->

	</section><!-- #primary -->
<?php
get_footer();
