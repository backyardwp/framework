<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Validation rule interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

interface ValidationRuleInterface {

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes( $attribute, $value);

	/**
	 * Get the validation error message.
	 *
	 * @return string|array
	 */
	public function message();
}
