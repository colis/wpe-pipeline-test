<?php
/**
 * Search & Filter Pro - Results Template
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $query->have_posts() ) {
	?>

	<div class="grid-posts grid-posts__3 grid-gap-col-s grid-gap-row-xl">
		<?php
		while ( $query->have_posts() ) {
			$query->the_post();
			?>

			<div class="grid-col">
				<?php get_template_part( 'template-parts/cards/card', get_post_type() ); ?>
			</div>

			<?php
		}
		?>
	</div>

	<?php if ( function_exists( 'wp_pagenavi' ) ) : ?>
		<div class="pagination sf-navigation">
			<?php
			wp_pagenavi(
				[ 'query' => $query ]
			);
			?>
		</div>
	<?php endif; ?>

	<?php
} else {
	?>

	<p>
		<?php esc_html_e( 'Sorry, nothing matched your search terms. Please try again.', 'wagner-spray-tech' ); ?>
	</p>

	<?php
}
