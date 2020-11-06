<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Add support for form fields ordering via a priority config option.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extensions\Priority;

use Symfony\Component\Form\AbstractExtension;

/**
 * Priority extension
 */
class PriorityExtension extends AbstractExtension {

	/**
	 * Load the type extension for forms.
	 *
	 * @return array
	 */
	protected function loadTypeExtensions() {
		return [
			new PriorityFormTypeExtension(),
		];
	}

}
