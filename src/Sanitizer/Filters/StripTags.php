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
 * Sanitizer strip tags filter.
 */
class StripTags implements SanitizerFilterInterface {
	/**
	 * Strip tags from the given string.
	 *
	 * @param string $value
	 * @param array  $options
	 * @return string
	 */
	public function apply( $value, $options = [] ) {
		return is_string( $value ) ? wp_strip_all_tags( $value ) : $value;
	}
}
