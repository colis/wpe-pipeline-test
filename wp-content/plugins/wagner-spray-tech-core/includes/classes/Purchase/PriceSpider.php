<?php
/**
 * Price Spider Integration.
 *
 * @package WagnerSprayTechCore\Purchase
 */

namespace WagnerSprayTechCore\Purchase;

use WagnerSprayTechCore\BaseAbstract;



/**
 * Price Spider Integration.
 *
 * @package WagnerSprayTechCore\Purchase
 */
class PriceSpider extends BaseAbstract {


	public const SCRIPT_HANDLE = 'wagnerspraytech_price_spider';


	/**
	 * Enqueue the price spider script.
	 *
	 * @return void
	 */
	public function scripts(): void {

		global $post;

		if ( empty( $post ) ) {
			return;
		}

		if ( BuyButton::get_options( $post->ID )['flags'] !== 'price-spider' ) {
			return;
		}

		wp_enqueue_script(
			handle: self::SCRIPT_HANDLE,
			src:'//cdn.pricespider.com/1/lib/ps-widget.js',
			ver: 2,
			in_footer: true
		);
	}
}
