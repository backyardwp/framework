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
 * Sanitizer conditional filter.
 */
class FilterIf implements SanitizerFilterInterface {
	/**
	 * Checks if filters should run if there is value passed that matches.
	 *
	 * @param array $values
	 * @param array $options
	 * @return string
	 */
	public function apply( $values, $options = [] ) {
		return array_key_exists( $options[0], $values ) && $values[ $options[0] ] === $options[1];
	}
}
