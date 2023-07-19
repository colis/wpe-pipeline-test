<?php
/**
 * Buy Now Button Logic.
 *
 * @package WagnerSprayTechCore\Purchase
 */

namespace WagnerSprayTechCore\Purchase;

use WagnerSprayTechCore\Taxonomy\ProductType;
use WagnerSprayTechCore\Taxonomy\ProductCategory;

/**
 * Buy Now Button Logic.
 *
 * @package WagnerSprayTechCore\Purchase
 */
class BuyButton {


	/**
	 * Return the appropriate buy button for each product.
	 *
	 * @notes https://americaneagle.atlassian.net/wiki/spaces/WST/pages/150463784124688/Button+Logic+on+product+parts+and+accessories
	 * @param int $post_id The ID of the post to get the buy button for.
	 *
	 * @return array
	 */
	public static function get_options( int $post_id ): array {

		$post_status           = get_post_status( $post_id );
		$product_type_category = wp_get_post_terms( $post_id, ProductCategory::NAME, [ 'fields' => 'names' ] )[0] ?? '';
		$purchasable           = get_post_meta( $post_id, 'purchasable', true );
		$inventory_status      = get_post_meta( $post_id, 'inventory_status', true );
		$add_to_cart_pixel     = get_post_meta( $post_id, 'add_to_cart_pixel', true );
		$product_permalink     = get_permalink( $post_id );

		$rtn = [
			'url'        => $product_permalink,
			'text'       => 'Learn More',
			'class_name' => 'is-internal-link',
			'flags'      => 'internal-link',
		];

		if ( 'publish' !== $post_status ) {
			return $rtn;
		}

		if ( get_the_permalink() === $product_permalink ) {

			switch ( $product_type_category ) {

				case 'Accessory':
					$rtn = [
						'url'        => $purchasable ? $add_to_cart_pixel : '',
						'text'       => $purchasable ? 'Add to Basket' : 'Out of Stock',
						'class_name' => $purchasable ? 'is-wagner-store' : 'is-out-of-stock',
						'flags'      => 'out-of-stock',
					];
					break;

				case 'Part':
					if ( ! $inventory_status ) {

						$rtn = [
							'url'        => '',
							'text'       => 'Out of Stock',
							'class_name' => 'is-out-of-stock',
							'flags'      => 'out-of-stock',
						];

					} else {
						$rtn = [
							'url'        => $purchasable ? $add_to_cart_pixel : '',
							'text'       => $purchasable ? 'Add to Basket' : 'Out of Stock',
							'class_name' => $purchasable ? 'is-wagner-store' : 'is-out-of-stock',
							'flags'      => 'out-of-stock',
						];
					}

					break;

				case 'Product':
					$rtn = [
						'url'        => '',
						'text'       => '',
						'class_name' => '',
						'flags'      => 'price-spider',
					];
					break;
			}
		}

		return $rtn;
	}


	/**
	 * Get the product type category.
	 *
	 * @param int $post_id The ID of the post to get the product type category for.
	 *
	 * @return string
	 */
	private static function get_product_type_category( int $post_id ): string {
		$product_type = current( wp_get_post_terms( $post_id, ProductType::NAME, [ 'fields' => 'ids' ] ) );

		return get_term_meta( $product_type, 'category', true ) ?? '';
	}
}
