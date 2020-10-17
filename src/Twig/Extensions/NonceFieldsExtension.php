<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Twig extension
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Twig\Extensions;

use Backyard\Nonces\NonceFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Register a new nonceField function extension within twig.
 */
class NonceFieldsExtension extends AbstractExtension {

	/**
	 * Register the nonceFields function.
	 *
	 * @return array
	 */
	public function getFunctions() {
		return [
			new TwigFunction( 'nonceFields', [ $this, 'nonceFields' ] ),
		];
	}

	/**
	 * Render nonce fields.
	 *
	 * @param string $slug nonce slug
	 * @return void
	 */
	public function nonceFields( $slug ) {
		echo NonceFactory::fields( $slug ); //phpcs:ignore
	}

}
