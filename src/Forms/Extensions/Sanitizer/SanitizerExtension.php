<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Add sanitization when submitting forms.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extensions\Sanitizer;

use Symfony\Component\Form\AbstractExtension;

/**
 * Sanitizer extension.
 */
class SanitizerExtension extends AbstractExtension {

	/**
	 * Load the type extension for forms.
	 *
	 * @return array
	 */
	protected function loadTypeExtensions() {
		return [
			new SanitizerFormTypeExtension(),
		];
	}

}
