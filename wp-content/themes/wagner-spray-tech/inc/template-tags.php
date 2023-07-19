<?php
/**
 * Custom template tags for this theme
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

use WagnerSprayTechCore\Taxonomy\ProductSeries;


if ( ! function_exists( 'wagner_spray_tech_breadcrumbs' ) ) :

	/**
	 * Echo a breadcrumbs list for all pages based on the current page's ancestors
	 */
	function wagner_spray_tech_breadcrumbs(): void {

		$post_ancestry = array_merge_recursive(
			[ get_the_ID() ],  // Current series post id.
			get_post_ancestors( get_the_ID() ), // Series parent post ids.
			[ absint( get_option( 'page_on_front' ) ) ] // Homepage id.
		);

		echo '<nav class="c-breadcrumbs c-breadcrumbs__product"><ul class="c-breadcrumbs__list">';
		foreach ( array_reverse( $post_ancestry ) as $post_id ) {
			echo '<li>';
			echo '<a href="' . esc_url( get_permalink( $post_id ) ) . '">' . esc_html( get_the_title( $post_id ) ) . '</a>';
			echo '</li>';
		}
		echo '</ul></nav>';
	}

endif;



if ( ! function_exists( 'wagner_spray_tech_product_breadcrumbs' ) ) :
	/**
	 * Echo a product series ancestors breadcrumbs list
	 *
	 * @return void
	 */
	function wagner_spray_tech_product_breadcrumbs(): void {

		$product_series_terms = wp_get_post_terms( post_id: get_the_ID(), taxonomy: ProductSeries::NAME );

		if ( empty( $product_series_terms ) ) {
			return;
		}

		$product_series_post_id = get_shadow( object_id: $product_series_terms[0]->term_id, shadow_name: ProductSeries::NAME, object_type: 'term' )['id'];
		$post_ancestry          = array_merge_recursive(
			[ $product_series_post_id ],  // Current series post id.
			get_post_ancestors( $product_series_post_id ), // Series parent post ids.
			[ absint( get_option( 'page_on_front' ) ) ] // Homepage id.
		);

		echo '<nav class="c-breadcrumbs c-breadcrumbs__product"><ul class="c-breadcrumbs__list">';
		foreach ( array_reverse( $post_ancestry ) as $post_id ) {
			echo '<li>';
			echo '<a href="' . esc_url( get_permalink( $post_id ) ) . '">' . esc_html( get_the_title( $post_id ) ) . '</a>';
			echo '</li>';
		}
		echo '</ul></nav>';
	}
endif;


if ( ! function_exists( 'wagner_spray_tech_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function wagner_spray_tech_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			wagner_spray_tech_get_icon_svg( 'calendar', 16 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_url( get_permalink() ),
			wp_kses_post( $time_string )
		);
	}
endif;

if ( ! function_exists( 'wagner_spray_tech_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function wagner_spray_tech_posted_by() {
		printf(
		/* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */
			'<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			wagner_spray_tech_get_icon_svg( 'person', 16 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_html__( 'Posted by', 'wagner-spray-tech' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'wagner_spray_tech_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function wagner_spray_tech_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo wagner_spray_tech_get_icon_svg( 'comment', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( _x( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'wagner-spray-tech' ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'wagner_spray_tech_entry_meta_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function wagner_spray_tech_entry_meta_footer() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
			wagner_spray_tech_posted_by();

			// Posted on.
			wagner_spray_tech_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( esc_html_e( ', ', 'wagner-spray-tech' ) );
			if ( $categories_list ) {
				printf(
				/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
					'<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
					wagner_spray_tech_get_icon_svg( 'category', 16 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html__( 'Posted in', 'wagner-spray-tech' ),
					wp_kses_post( $categories_list )
				);
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'wagner-spray-tech' ) );
			if ( $tags_list ) {
				printf(
				/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
					'<span class="tags-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
					wagner_spray_tech_get_icon_svg( 'tag', 16 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html__( 'Tags:', 'wagner-spray-tech' ),
					wp_kses_post( $tags_list )
				);
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			wagner_spray_tech_comment_count();
		}
	}
endif;

if ( ! function_exists( 'wagner_spray_tech_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function wagner_spray_tech_post_thumbnail() {
		if ( ! wagner_spray_tech_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<figure class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</figure><!-- .post-thumbnail -->

			<?php
		else :
			?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true"
					tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
			</figure>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wagner_spray_tech_the_post_navigation' ) ) :
	/**
	 * Displays navigation between posts.
	 */
	function wagner_spray_tech_the_post_navigation() {
		if ( is_singular( 'attachment' ) ) {
			// Parent post navigation.
			the_post_navigation(
				[
					/* translators: %s: parent post link */
					'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'wagner-spray-tech' ), '%title' ),
				]
			);
		} elseif ( is_singular( 'post' ) ) {
			// Previous/next post navigation.
			the_post_navigation(
				[
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'wagner-spray-tech' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'wagner-spray-tech' ) . '</span>' .
									'<span class="post-title screen-reader-text">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'wagner-spray-tech' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'wagner-spray-tech' ) . '</span>' .
									'<span class="post-title screen-reader-text">%title</span>',
				]
			);
		}
	}
endif;

if ( ! function_exists( 'wagner_spray_tech_the_posts_pagination' ) ) :
	/**
	 * Displays pagination between post pages.
	 */
	function wagner_spray_tech_the_posts_pagination() {
		the_posts_pagination(
			[
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					wagner_spray_tech_get_icon_svg( 'chevron_left', 22 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					__( 'Newer posts', 'wagner-spray-tech' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Older posts', 'wagner-spray-tech' ),
					wagner_spray_tech_get_icon_svg( 'chevron_right', 22 ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				),
			]
		);
	}
endif;
