<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard forms sanitization filter.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Filters;

use Laminas\Filter\FilterInterface;

/**
 * WP sanitize_text_field form filter.
 *
 * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
 */
class SanitizeTextField implements FilterInterface {

	/**
	 * @inheritDoc
	 */
	public function filter( $value ) {
		return sanitize_text_field( $value );
	}

}
