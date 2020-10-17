<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Add nonces validation when submitting forms.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extensions\Nonce;

use Symfony\Component\Form\AbstractExtension;

/**
 * Nonces validation extension.
 */
class NonceExtension extends AbstractExtension {

	/**
	 * Load the type extension for forms.
	 *
	 * @return array
	 */
	protected function loadTypeExtensions() {
		return [
			new NonceFormTypeExtension(),
		];
	}

}
