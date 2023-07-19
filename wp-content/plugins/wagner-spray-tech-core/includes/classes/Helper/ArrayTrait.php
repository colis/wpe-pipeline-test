<?php
/**
 * Core Plugin Starter Array Helpers
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

/**
 * Core Plugin Starter ArrayTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait ArrayTrait {

	/**
	 * Case-insensitive in_array.
	 *
	 * @param mixed $needle Search value.
	 * @param array $haystack Array to search.
	 *
	 * @return bool
	 */
	protected function in_array_i( mixed $needle, array $haystack ): bool {
		return in_array( strtolower( $needle ), array_map( 'strtolower', $haystack ), true );
	}
}
