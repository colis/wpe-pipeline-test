<?php
/**
 * The template for displaying latest posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$the_post_id = get_queried_object_id();

get_header();
?>

	<section id="primary" class="c-content-area">
		<main id="main" class="c-site-main c-archive-main" role="main">

		<?php
		if ( have_posts() ) {
			?>

			<header class="c-archive-header alignfull">
				<div class="o-container">
					<h1 class="page-title"><?php echo esc_html( get_the_title( $the_post_id ) ); ?></h1>
				</div>
			</header><!-- .page-header -->

			<?php do_action( 'wagner_spray_tech_archive_content_header' ); ?>

			<div class="grid-posts grid-posts__3">

				<?php
				// Start the Loop.
				while ( have_posts() ) :
					the_post();
					?>

					<div class="grid-col">
						<?php get_template_part( 'template-parts/cards/card', 'media' ); ?>
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
