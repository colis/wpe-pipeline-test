<?php
/**
 * Wagner Spray Tech Block - Content Selector - Render
 *
 * @package WagnerSprayTech
 * @since 1.1.0
 */

// Useful Attributes.
$template     = WAGNERSPRAYTECH_BLOCKS_PATH . $attributes['selectedBlockTypeRenderPath'];
$is_dynamic   = $attributes['isDynamic'] ?? false;
$layout       = $attributes['layout'] ?? 'grid';
$max_results  = $attributes['maxResults'] ?? 4;
$content_type = $attributes['contentTypes'][0] ?? 'post';

$post_ids = array_map(
	function( $post ) {
		return $post['id'];
	},
	$attributes['selectedPosts']
);

// Construct the query.
$shared_args = [
	'posts_per_page'         => $max_results,
	'fields'                 => 'ids',
	'no_found_rows'          => true,
	'ignore_sticky_posts'    => true,
	'update_post_term_cache' => false,
	'update_post_meta_cache' => false,
];

$post_args = [
	'post_type' => 'any',
	'post__in'  => $post_ids,
	'orderby'   => 'post__in',
];

$dynamic_args = [
	'post_type' => $content_type,
];
if ( ! empty( $attributes['author']['id'] ) ) {
	$dynamic_args['author'] = $attributes['author']['id'];
}
// phpcs:disable
if ( ! empty( $attributes['taxonomyFilters'] ) ) {
	$dynamic_args['tax_query'] = [
		'relation' => 'AND',
	];
	foreach ( $attributes['taxonomyFilters'] as $taxonomy_filter ) {
		$dynamic_args['tax_query'][] = [
			'taxonomy' => $taxonomy_filter['termTaxonomy'],
			'field'    => 'term_id',
			'terms'    => $taxonomy_filter['termId'],
		];
	}
}
// phpcs:enable

// Use the dynamic args if the user has selected the isDynamic toggle.
$query_args = $is_dynamic ? array_merge( $shared_args, $dynamic_args ) : array_merge( $shared_args, $post_args );

// Start the query.
$query = new \WP_Query( $query_args );
if ( $query->have_posts() ) {

	// Construct some attributes for grid and carousel layouts.
	if ( $layout === 'grid' ) {
		$grid_data = 'data-grid-columns="' . $attributes['gridColumns'] . '"';
	}

	$slider_data_attributes = '';
	if ( $layout === 'carousel' ) {
		$slider_columns         = $attributes['sliderColumns'];
		$slider_data_attributes = 'data-desktop-slides="' . $slider_columns . '"';
	}

	?>

	<div class="wst-blocks-content-selector wst-blocks-content-selector--<?php echo \esc_attr( $layout ); ?>" <?php echo \wp_kses_post( $grid_data ); ?> >

		<?php if ( $layout === 'carousel' ) { ?>

		<div class="wst-blocks-glide" <?php echo wp_kses_post( $slider_data_attributes ); ?>>

			<div class="glide__track" data-glide-el="track">
				<ul class="glide__slides">

			<?php
		}

		while ( $query->have_posts() ) {
			$query->the_post();

			include $template;
		}

		if ( $layout === 'carousel' ) {
			?>

				</ul>
			</div>

			<div class="glide__arrows" data-glide-el="controls">
				<button class="glide__arrow glide__arrow--left" data-glide-dir="<?php echo esc_attr( '<' ); ?>" aria-label="Previous slide">
					<i class="icon icon-arrow-left"></i>
				</button>
				<button class="glide__arrow glide__arrow--right" data-glide-dir="<?php echo esc_attr( '>' ); ?>" aria-label="Next slide">
					<i class="icon icon-arrow-white-right"></i>
				</button>
			</div>
		</div>

		<?php } ?>

	</div>

	<?php
	\wp_reset_postdata();

}
