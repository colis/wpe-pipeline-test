<?php
/**
 * Base class for custom image size registration.
 *
 * @package WagnerSprayTechCore\Image
 */

namespace WagnerSprayTechCore\Image;

use WagnerSprayTechCore\BaseAbstract;

/**
 * Abstract class BaseImageAbstract.
 *
 * @package WagnerSprayTechCore\Image
 */
class BaseImageAbstract extends BaseAbstract {

	/**
	 * Register the custom image size.
	 */
	public function register(): void {
		$current_image_size = get_class( $this );

		\add_image_size(
			$current_image_size::NAME,
			$current_image_size::WIDTH,
			$current_image_size::HEIGHT,
			$current_image_size::CROP
		);
	}
}
