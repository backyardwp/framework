<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Sanitizer filter.
 *
 * @package   backyard-framwork
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Sanitizer\Filters;

use Backyard\Contracts\SanitizerFilterInterface;

/**
 * Sanitizer trim filter.
 */
class Trim implements SanitizerFilterInterface {
	/**
	 * Trims the given string.
	 *
	 * @param string $value
	 * @param array  $options
	 * @return string
	 */
	public function apply( $value, $options = [] ) {
		return is_string( $value ) ? trim( $value ) : $value;
	}
}
