<?php
/**
 * Core Plugin Starter Strings Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */

namespace WagnerSprayTechCore\Helper;

/**
 * Core Plugin Starter StringTrait Helper Trait
 *
 * @package WagnerSprayTechCore\Helper
 */
trait StringTrait {

	/**
	 * Return paragraphed text by splitting all new line breaks and wrapping in p tags.
	 *
	 * @param string $input_string The input string.
	 *
	 * @return string
	 */
	protected function nl2p( string $input_string ): string {
		$paragraphs = '';

		if ( empty( $input_string ) ) {
			return $paragraphs;
		}

		foreach ( explode( "\n", $input_string ) as $line ) {
			if ( trim( $line ) ) {
				$paragraphs .= '<p>' . $line . '</p>';
			}
		}

		return $paragraphs;
	}

	/**
	 * Create telephone href hyperlink from a phone number.
	 *
	 * @param string $phone_number The phone number to create a link for.
	 *
	 * @return string
	 */
	protected function phone_number( string $phone_number ): string {
		$phone_number_link = str_replace( ' ', '-', $phone_number );

		return sprintf(
			'tel:%s',
			$phone_number_link,
		);
	}
}
