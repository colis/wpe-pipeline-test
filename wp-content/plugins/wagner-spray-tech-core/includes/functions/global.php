<?php
/**
 * Expose Global Functions from plugin functionality.
 *
 * @param int $post_id The ID of the post to get the buy button for.
 *
 * @package WagnerSprayTechCore
 */

use WagnerSprayTechCore\Purchase\BuyButton;


/**
 * Render buy now button.
 *
 * @param int $post_id The ID of the post to get the buy button for.
 * @return void
 */
function wagner_spray_tech_cart_btn( int $post_id ): void {
	$buy_button = BuyButton::get_options( $post_id );
	$href       = '';
	$class_name = $buy_button['class_name'];

	if ( ! empty( $buy_button['url'] ) ) {
		$href = sprintf( 'href="%s" ', $buy_button['url'] );
	}

	if ( 'price-spider' === $buy_button['flags'] ) {
		get_template_part( 'template-parts/product/price-spider' );
	} else {
		echo wp_kses_post( sprintf( '<a %s class="wp-block-button__link wp-element-button %s">%s</a>', $href, $class_name, $buy_button['text'] ) );

	}
}


/**
 * Replacement for get_page_by_title which is deprecated in WP 6.2. This adds the ability to get a post by any valid key name.
 *
 * @param string       $value The value to search for.
 * @param string       $output Optional. The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which correspond to a WP_Post object, an associative array, or a numeric array, respectively. Default OBJECT.
 * @param string|array $post_type Optional. Post type or array of post types. Default 'post'.
 * @param string       $key Optional. The column key to search for. Default 'title'.
 * @url https://developer.wordpress.org/reference/classes/wp_query/
 *
 * @return WP_Post|array|null
 */
function get_post_by( string $value, string $output = OBJECT, string|array $post_type = 'post', string $key = 'name' ): WP_Post|array|null {

	$args = [
		$key                     => $value,
		'posts_per_page'         => 1,
		'post_type'              => $post_type,
		'post_status'            => ( 'attachment' === $post_type ) ? 'inherit' : 'publish',
		'fields'                 => 'ids',
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
	];

	$query   = new WP_Query( $args );
	$post_id = current( $query->get_posts() );

	return $post_id ? get_post( $post_id, $output ) : null;
}


/**
 * Return the shadow of a post or term.
 *
 * @param int    $object_id  The ID of the object to get the shadow for.
 * @param string $shadow_name The name of the shadow to get.
 * @param string $object_type The type of object to get the shadow for. Either 'post' or 'term'.
 * @param string $fields The fields to return. Either 'ids' or 'all'.
 *
 * @return array ['id' => int, 'object' => array, 'shadow_type' => string]
 */
function get_shadow( int $object_id, string $shadow_name, string $object_type = 'post', string $fields = 'ids' ): array {

	$id          = 0;
	$object      = [];
	$shadow_type = '';

	switch ( $object_type ) {
		case 'term':
			$id          = absint( get_term_meta( $object_id, sprintf( 'shadow_%s_post_id', $shadow_name ), true ) );
			$shadow_type = 'post';
			if ( $fields === 'all' && ! empty( $id ) ) {
				$object = get_post( $id );
			}
			break;

		case 'post':
			$id          = absint( get_post_meta( $object_id, sprintf( 'shadow_%s_term_id', $shadow_name ), true ) );
			$shadow_type = 'taxonomy';
			if ( $fields === 'all' && ! empty( $id ) ) {
				$object = get_term( $id );
			}
			break;

	}

	return [
		'id'          => $id,
		'object'      => $object,
		'shadow_type' => $shadow_type,
	];
}
