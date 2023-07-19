<?php
/**
 * Core Plugin Starter UserTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

/**
 * Core Plugin Starter UserTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait UserTrait {

	/**
	 * Return a user ID by field and value
	 *
	 * @param  string $field User field name: slug, name, email.
	 * @param  string $value Value.
	 *
	 * @return int
	 */
	protected function get_user_id_by( string $field, string $value ): int {

		$rtn  = 0;
		$user = get_user_by( $field, $value );
		if ( ! empty( $user ) ) {
			$rtn = $user->ID;
		}

		return $rtn;
	}
}
