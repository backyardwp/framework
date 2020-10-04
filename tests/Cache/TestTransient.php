<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard transient cache test
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
use Backyard\Cache\Transient;

class TestTransient extends \WP_UnitTestCase {

	public function testRemembersCachedValue() {

		$key = 'transient-key-' . uniqid();

		$callback = function() {
			return uniqid();
		};

		$cached = Transient::remember( $key, $callback );

		$this->assertEquals(
			$cached,
			Transient::remember( $key, $callback ),
			'Expected the same value to be returned on subsequent requests.'
		);

		$this->assertEquals( $cached, Transient::get( $key ) );

	}

	public function testDoesNotRememberExceptions() {

		$key = 'some-cache-key-' . uniqid();

		try {
			Transient::remember(
				$key,
				function () {
					throw new Exception( 'Something went wrong!' );
				}
			);

		} catch ( Exception $e ) {
			$this->assertFalse( Transient::get( $key ), 'Expected the exception to not be cached.' );
			return;
		}

		$this->fail( 'Did not receive expected exception!' );

	}

	public function testDoesNotRememberWP_Error() {

		$key = 'some-cache-key-' . uniqid();

		Transient::remember(
			$key,
			function () {
				return new WP_Error( 'code', 'Something went wrong!' );
			}
		);

		$this->assertFalse( Transient::get( $key ), 'Expected the WP_Error to not be cached.' );

	}

	public function testDoesPullFromCache() {

		$key = 'some-cache-key-' . uniqid();

		$value = uniqid();

		set_transient( $key, $value );

		$this->assertEquals(
			$value,
			Transient::remember( $key, '__return_false' ),
			'Expected the cache value to be returned.'
		);

	}

	public function testCanForgetCache() {

		$key = 'some-cache-key-' . uniqid();

		set_transient( $key, 'some value' );

		$this->assertEquals( 'some value', Transient::forget( $key ), 'Expected to receive the cached value.' );

		$this->assertFalse( Transient::get( $key ), 'Expected the cached value to be removed.' );

	}

	public function testForgottenCacheFallsbackToDefault() {

		$key = 'some-cache-key-' . uniqid();

		$this->assertEquals( 'some value', Transient::forget( $key, 'some value' ), 'Expected to receive the default value.' );
		$this->assertFalse( Transient::get( $key ), 'Expected the cached value to remain empty.' );

	}

}
