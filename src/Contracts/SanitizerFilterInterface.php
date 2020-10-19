<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Sanitization filter interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

interface SanitizerFilterInterface {
	/**
	 *  Return the result of applying this filter to the given input.
	 *
	 * @param  mixed $value
	 * @param array $options
	 * @return mixed
	 */
	public function apply( $value, $options = []);
}
