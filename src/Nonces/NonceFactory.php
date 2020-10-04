<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Nonces factory.
 *
 * @package   backyard-nonces
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Nonces;

use Backyard\Utils\RequestFactory;

/**
 * Nonce factory
 */
class NonceFactory {

	/**
	 * Create nonce.
	 *
	 * @param  string $slug
	 * @return string
	 */
	public static function create( $slug ) {
		return ( self::make( $slug ) )->make();
	}

	/**
	 * Render nonce form fields.
	 *
	 * @param  string $slug
	 * @return string
	 */
	public static function fields( $slug ) {
		return ( self::make( $slug ) )->render();
	}

	/**
	 * Verify nonce value.
	 *
	 * @param  string $slug
	 * @return bool
	 */
	public static function verify( $slug ) {
		$nonce = self::make( $slug );

		return $nonce->check( ( RequestFactory::create() )->request->get( $nonce->getKey() ) );
	}

	/**
	 * Verify nonce value.
	 *
	 * @param  string $slug
	 * @param  string $token
	 * @return bool
	 */
	public static function check( $slug, $token ) {
		return ( self::make( $slug ) )->check( $token );
	}

	/**
	 * Create Nonce instance.
	 *
	 * @param  string $slug
	 *
	 * @return Nonce
	 */
	private static function make( $slug ) {
		return new Nonce( $slug );
	}

}
