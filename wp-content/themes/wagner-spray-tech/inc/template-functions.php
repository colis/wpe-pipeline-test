<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

use WagnerSprayTechCore\PostType\Product as ProductCPT;

/**
 * Filters the default archive titles.
 *
 * @param string $title The title.
 * @param string $original_title The original title.
 * @param string $prefix The title prefix.
 *
 * @return string
 */
function wagner_spray_tech_get_the_archive_title( $title, $original_title, $prefix ) {
	if ( is_category() ) {
		$prefix = '';
		$title  = '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$prefix = '';
		$title  = '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Author: ', 'wagner-spray-tech' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Yearly: ', 'wagner-spray-tech' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'wagner-spray-tech' ) ) . '</span>';
	} elseif ( is_month() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Monthly: ', 'wagner-spray-tech' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'wagner-spray-tech' ) ) . '</span>';
	} elseif ( is_day() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Daily: ', 'wagner-spray-tech' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$prefix = '';
		$cpt    = get_post_type_object( get_queried_object()->name );
		$title  = sprintf(
			/* translators: %s: Post type archive name */
			esc_html( '%s' ),
			$cpt->labels->archives
		);
	} elseif ( is_tax() ) {
		$prefix = '';
		$tax    = get_queried_object();
		$title  = sprintf(
			/* translators: %s: Taxonomy name */
			esc_html( '%s' ),
			$tax->name
		);
	} else {
		$prefix = '';
		$title  = '<span class="archive-prefix">' . __( 'Archives: ', 'wagner-spray-tech' ) . ' </span>';
	}

	return '<h1 class="page-title">' . $prefix . $title . '</h1>';
}
add_filter( 'get_the_archive_title', 'wagner_spray_tech_get_the_archive_title', 10, 3 );



/**
 * Output the relevant details after the main site header.
 *
 * @return void
 */
function wagner_spray_tech_single_after_header(): void {

	switch ( get_post_type() ) {
		case ProductCPT::NAME:
			// Breadcrumbs.
			wagner_spray_tech_product_breadcrumbs();
			break;

		default:
			// Breadcrumbs.
			wagner_spray_tech_breadcrumbs();
			break;
	}
}
add_action( 'wagner_spray_tech_single_after_header', 'wagner_spray_tech_single_after_header' );


/**
 * Output the relevant single content header for the current post.
 *
 * @return void
 */
function wagner_spray_tech_single_content_header(): void {
	switch ( get_post_type() ) {
		case ProductCPT::NAME:
			get_template_part( 'template-parts/content/product/content', 'hero' );
			break;
	}
}
add_action( 'wagner_spray_tech_single_content_header', 'wagner_spray_tech_single_content_header' );

/**
 * Output the relevant single content before for the current post.
 *
 * @return void
 */
function wagner_spray_tech_single_content_before() {
}
add_action( 'wagner_spray_tech_single_content_before', 'wagner_spray_tech_single_content_before' );

/**
 * Output the relevant single content after for the current post.
 *
 * @return void
 */
function wagner_spray_tech_single_content_after() {
	switch ( get_post_type() ) {
		case 'post':
			get_template_part( 'template-parts/content/post/content-footer' );
			get_template_part( 'template-parts/global/share/social-share' );
			break;
	}
}
add_action( 'wagner_spray_tech_single_content_after', 'wagner_spray_tech_single_content_after' );

/**
 * Output the relevant single content footer for the current post.
 *
 * @return void
 */
function wagner_spray_tech_single_content_footer() {
	switch ( get_post_type() ) {
		case 'post':
			get_template_part( 'template-parts/content/post/content-author' );
			get_template_part( 'template-parts/content/post/content-related' );
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			break;
		default:
	}
}
add_action( 'wagner_spray_tech_single_content_footer', 'wagner_spray_tech_single_content_footer' );


/**
 * Add difficulty term to any primary menu items if available.
 *
 * @param array   $items Menu Items.
 * @param WP_Term $menu Menu Object.
 *
 * @return array
 */
function wagner_wp_customise_primary_menu_items( array $items, WP_Term $menu ): array {

	if ( 'primary' !== $menu->slug ) {
		return $items;
	}

	foreach ( $items as $k => $post ) {
		$difficulty_terms = wp_get_post_terms( $post->object_id, 'difficulty_tax' );
		if ( ! empty( $difficulty_terms ) ) {
			$difficulty_term = $difficulty_terms[0];
			$post->title     = $post->title . '<span>(' . $difficulty_term->name . ')</span>';
		}
	}

	return $items;
}
add_filter( 'wp_get_nav_menu_items', 'wagner_wp_customise_primary_menu_items', 10, 2 );
