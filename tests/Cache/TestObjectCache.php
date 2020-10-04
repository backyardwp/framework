<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard object cache tests
 *
 * @package   backyard-cache
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Cache\Tests;

use Exception;
use WP_Error;
use Backyard\Cache\ObjectCache as Cache;

class TestObjectCache extends \WP_UnitTestCase {

	public function testRemembersValue() {

		$key = 'some-cache-key-' . uniqid();

		$callback = function () {
			return uniqid();
		};

		$value = Cache::remember( $key, $callback );

		$this->assertEquals(
			$value,
			Cache::remember( $key, $callback ),
			'Expected the same value to be returned on subsequent requests.'
		);

		$this->assertEquals( $value, wp_cache_get( $key ) );

	}

	public function testItDoesNotCacheExceptions() {

		$key = 'some-cache-key-' . uniqid();

		try {
			Cache::remember(
				$key,
				function () {
					throw new Exception( 'Something went wrong!' );
				}
			);

		} catch ( Exception $e ) {
			$this->assertFalse( wp_cache_get( $key ), 'Expected the exception to not be cached.' );
			return;
		}

		$this->fail( 'Did not receive expected exception!' );

	}

	public function testItDoesNotCacheWP_Error() {

		$key = 'some-cache-key-' . uniqid();

		Cache::remember(
			$key,
			function () {
				return new WP_Error( 'code', 'Something went wrong!' );
			}
		);

		$this->assertFalse( wp_cache_get( $key ), 'Expected the WP_Error to not be cached.' );

	}

	public function testItCanPullFromCache() {

		$key   = 'some-cache-key-' . uniqid();
		$value = uniqid();

		wp_cache_set( $key, $value );

		$this->assertEquals(
			$value,
			Cache::remember( $key, '__return_false' ),
			'Expected the cache value to be returned.'
		);

	}

	public function testItCanForgetDeletedCache() {

		$key = 'some-cache-key-' . uniqid();

		wp_cache_set( $key, 'some value' );

		$this->assertEquals( 'some value', Cache::forget( $key ), 'Expected to receive the cached value.' );
		$this->assertFalse( wp_cache_get( $key ), 'Expected the cached value to be removed.' );

	}

	public function testItRetrievesDefaultValueWhenForgotten() {
		$key = 'some-cache-key-' . uniqid();

		$this->assertEquals( 'some value', Cache::forget( $key, null, 'some value' ), 'Expected to receive the default value.' );
		$this->assertFalse( wp_cache_get( $key ), 'Expected the cached value to remain empty.' );

	}

}
