<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Sanitization helper.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Utils;

/**
 * Sanitization utilities.
 */
class Sanitizer {

	/**
	 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
	 * Non scalar values are ignored.
	 *
	 * @param string|array $var variable to clean
	 * @return string|array
	 */
	public static function clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( [ self::class, 'clean' ], $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
	/**
	 * Sanitize textareas but mantain line breaks.
	 *
	 * @param string $var textarea content
	 * @return string
	 */
	public static function cleanTextarea( $var ) {
		return implode( "\n", array_map( [ self::class, 'clean' ], explode( "\n", $var ) ) );
	}

}
