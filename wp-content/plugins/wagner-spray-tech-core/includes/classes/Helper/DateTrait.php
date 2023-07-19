<?php
/**
 * Core Plugin Starter Date Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

/**
 * Core Plugin Starter DateTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait DateTrait {

	/**
	 * Wrapper around DateTime to use so that most date strings in site are returned as same formatted string.
	 *
	 * @param string $input_date_string Input date string, if empty return nothing.
	 * @param string $return_format Date format to return, default is m/d/Y.
	 *
	 * @return string
	 */
	protected function generate_date_string( string $input_date_string = '', string $return_format = 'F j, Y' ): string {

		if ( empty( $input_date_string ) ) {
			return '';
		}

		try {
			return ( new \DateTime( $input_date_string ) )->format( $return_format );
		} catch ( \Exception $e ) {
			return $e->getMessage();
		}
	}
}
