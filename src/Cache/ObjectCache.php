<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard object cache helper
 *
 * @package   backyard-cache
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Cache;

/**
 * Object cache helper
 */
class ObjectCache {

	/**
	 * Retrieve a value from the object cache. If it doesn't exist, run the $callback to generate and
	 * cache the value.
	 *
	 * @param string   $key      The cache key.
	 * @param callable $callback The callback used to generate and cache the value.
	 * @param string   $group    Optional. The cache group. Default is empty.
	 * @param int      $expire   Optional. The number of seconds before the cache entry should expire.
	 *                           Default is 0 (as long as possible).
	 *
	 * @return mixed The value returned from $callback, pulled from the cache when available.
	 */
	public static function remember( $key, $callback, $group = '', $expire = 0 ) {

		$found  = false;
		$cached = wp_cache_get( $key, $group, false, $found );

		if ( false !== $found ) {
			return $cached;
		}

		$value = $callback();

		if ( ! is_wp_error( $value ) ) {
			wp_cache_set( $key, $value, $group, $expire );
		}

		return $value;

	}

	/**
	 * Retrieve and subsequently delete a value from the object cache.
	 *
	 * @param string $key     The cache key.
	 * @param string $group   Optional. The cache group. Default is empty.
	 * @param mixed  $default Optional. The default value to return if the given key doesn't
	 *                        exist in the object cache. Default is null.
	 *
	 * @return mixed The cached value, when available, or $default.
	 */
	public static function forget( $key, $group = '', $default = null ) {
		$found  = false;
		$cached = wp_cache_get( $key, $group, false, $found );

		if ( false !== $found ) {
			wp_cache_delete( $key, $group );

			return $cached;
		}

		return $default;
	}

}
