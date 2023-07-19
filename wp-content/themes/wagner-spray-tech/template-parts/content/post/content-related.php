<?php
/**
 * Template part for displaying Post related content
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$blog_post_id = get_the_ID();

// Store the primary category (set/stored by Yoast plugin),
// or if empty store the assigned category term IDs.
$primary_cat_id = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_category' ) ?: wp_list_pluck( get_the_terms( $blog_post_id, 'category' ), 'term_id' );

// Build the related articles query arguments.
$args = [
	'post_type'              => 'post',
	'post_status'            => 'publish',
	'posts_per_page'         => 3,
	'orderby'                => 'post_date',
	'order'                  => 'DESC',
	'post__not_in'           => [ $blog_post_id ],
	'fields'                 => 'ids',
	'no_found_rows'          => true,
	'update_post_term_cache' => false,
];

// Add related category, if any are set.
if ( ! empty( $primary_cat_id ) ) {
	$args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		[
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $primary_cat_id,
		],
	];
}

$query       = new WP_Query( $args );
$posts_count = $query->post_count;

// If there are no related posts, bail early.
if ( $posts_count < 1 ) {
	return;
}

?>

<div class="c-post-content-related">
	<h2 class="c-post-content-related__heading">
		<?php esc_html_e( 'Related Posts', 'wagner-spray-tech' ); ?>
	</h2>

	<div class="grid-posts grid-posts__3">
		<?php
		// Loop through the related posts.
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				?>

				<div class="grid-col">
					<?php get_template_part( 'template-parts/cards/card', 'post' ); ?>
				</div>

				<?php
			}
		}

		wp_reset_postdata();
		?>
	</div>
</div>
