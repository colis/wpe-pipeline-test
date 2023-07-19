<?php
/**
 * Core Plugin Starter CacheTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

/**
 * Core Plugin Starter CacheTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait CacheTrait {

	/**
	 * Create and return the results of $callback, either from cache or generated fresh
	 *
	 * @param mixed  $callback The callback function - can be from a class [ class, 'function'].
	 * @param  array  $args Callback argument as a named array, each key will be the param name.
	 * @param  string $cache_name Optional cache name, if not set the callback function name will be used.
	 * @param  int    $cache_max_lifetime Cache maximum lifetime.
	 *
	 * @return mixed
	 */
	protected function cache_callback_function( mixed $callback, array $args = [], string $cache_name = '', int $cache_max_lifetime = 300 ): mixed {

		if ( empty( $cache_name ) ) {
			$cache_name = is_array( $callback ) ? implode( '_', array_map( 'sanitize_title', $callback ) ) : (string) $callback;
		}

		$cache_name         = substr( $cache_name, 0, 171 );
		$cache_max_lifetime = absint( $cache_max_lifetime );
		$data               = get_transient( $cache_name );

		if ( ! empty( $data ) ) {
			return $data;
		}

		$data = call_user_func_array( $callback, $args );
		set_transient( $cache_name, $data, $cache_max_lifetime );

		return $data;
	}
}
