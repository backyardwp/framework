<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard transients helper
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Cache;

/**
 * Transients helper.
 */
class Transient {

	/**
	 * Retrieve a value from transients. If it doesn't exist, run the $callback to generate and
	 * cache the value.
	 *
	 * @param string   $key      The transient key.
	 * @param callable $callback The callback used to generate and cache the value.
	 * @param int      $expire   Optional. The number of seconds before the cache entry should expire.
	 *                           Default is 0 (as long as possible).
	 *
	 * @return mixed The value returned from $callback, pulled from transients when available.
	 */
	public static function remember( $key, $callback, $expire = 0 ) {

		$cached = get_transient( $key );

		if ( false !== $cached ) {
			return $cached;
		}

		$value = $callback();

		if ( ! is_wp_error( $value ) ) {
			set_transient( $key, $value, $expire );
		}

		return $value;

	}

	/**
	 * Retrieve and subsequently delete a value from the transient cache.
	 *
	 * @param string $key     The transient key.
	 * @param mixed  $default Optional. The default value to return if the given key doesn't
	 *                        exist in transients. Default is null.
	 *
	 * @return mixed The cached value, when available, or $default.
	 */
	public static function forget( $key, $default = null ) {
		$cached = get_transient( $key );

		if ( false !== $cached ) {
			delete_transient( $key );

			return $cached;
		}

		return $default;
	}

	/**
	 * Get a transient from the database.
	 *
	 * @param string $key key
	 * @return mixed
	 */
	public static function get( $key ) {
		return get_transient( $key );
	}

}
