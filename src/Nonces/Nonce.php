<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Nonces handler.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Nonces;

use Backyard\Exceptions\InvalidNonceException;

/**
 * WordPress nonces handler & generator
 */
class Nonce {

	/**
	 * The slug of the nonce
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * The full key of the nonce used in http requests.
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * Generate a new nonce
	 *
	 * @param string $slug
	 */
	public function __construct( $slug ) {
		$this->slug = $slug;
		$this->setKey( $slug );
	}

	/**
	 * Generate nonce value.
	 *
	 * @return string
	 */
	public function make() {
		return wp_create_nonce( $this->getKey() );
	}

	/**
	 * Generate nonce form fields.
	 *
	 * @return string
	 */
	public function render() {
		return wp_nonce_field( $this->getKey(), $this->getKey(), true, false );
	}

	/**
	 * Generate a nonce url.
	 *
	 * @param string $url url to use for the generation of the nonce
	 * @return string
	 */
	public function url( $url ) {
		return wp_nonce_url( $url, $this->getKey(), $this->getKey() );
	}

	/**
	 * Check if nonce value is valid.
	 *
	 * @param string $token
	 * @return bool
	 */
	public function check( $token ) {
		return is_int( wp_verify_nonce( $token, $this->getKey() ) );
	}

	/**
	 * Verify nonce value. Abort if it is not valid.
	 *
	 * @param string $token nonce token submitted with the request.
	 * @return bool
	 */
	public function checkOrFail( $token ) {
		if ( $status = $this->check( $token ) ) {
			throw new InvalidNonceException( "Nonce [{$this->getKey()}] is invalid." );
		}

		return $status;
	}

	/**
	 * Gets the nonce key.
	 *
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * Sets the value of key.
	 *
	 * @param mixed $key the key
	 *
	 * @return self
	 */
	private function setKey( $key ) {
		$this->key = "_{$key}-nonce";

		return $this;
	}

}
