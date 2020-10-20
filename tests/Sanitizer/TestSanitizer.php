<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard sanitization rules testing.
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests\Sanitizer;

use Backyard\Sanitizer\Sanitizer;
use InvalidArgumentException;

class TestSanitizer extends \WP_UnitTestCase {

	public function sanitize( $data, $rules ) {
		$sanitizer = new Sanitizer( $data, $rules );
		return $sanitizer->sanitize();
	}

	public function testInputUnchangedIfNoFilter() {
		$data  = [
			'name' => '  HellO EverYboDy   ',
		];
		$rules = [
			'name' => '',
		];
		$data  = $this->sanitize( $data, $rules );
		$this->assertEquals( '  HellO EverYboDy   ', $data['name'] );
	}

	public function testFiltersAsArray() {
		$data  = [
			'name' => '<strong>Test</strong>',
		];
		$rules = [
			'name' => [ 'sanitize_text_field' ],
		];
		$data  = $this->sanitize( $data, $rules );
		$this->assertEquals( 'Test', $data['name'] );
	}

	public function testWildcardFilters() {

		$data = [
			'name' => [
				'first' => '<strong>John</strong>',
				'last'  => '</strong>Doe</strong>',
			],
		];

		$rules = [
			'name.*' => 'sanitize_text_field',
		];

		$data = $this->sanitize( $data, $rules );

		$sanitized = [
			'name' => [
				'first' => 'John',
				'last'  => 'Doe',
			],
		];

		$this->assertEquals( $sanitized, $data );

	}

	public function testItThrowsExceptionWhenFilterNotFound() {

		$this->expectException( InvalidArgumentException::class );
		$data  = [
			'name' => '  HellO EverYboDy   ',
		];
		$rules = [
			'name' => 'non-filter',
		];
		$data  = $this->sanitize( $data, $rules );

	}

	public function testSanitizesOnlySpecifiedData() {

		$data = [
			'title' => '<strong>Test</strong>',
		];

		$rules = [
			'title' => 'sanitize_text_field',
			'name'  => 'strip_tags',
		];

		$data = $this->sanitize( $data, $rules );

		$this->assertArrayNotHasKey( 'name', $data );
		$this->assertArrayHasKey( 'title', $data );
		$this->assertEquals( 1, count( $data ) );

	}

	public function testCanUseClosureAsFilter() {

		$data = [
			'name' => ' Sina ',
		];

		$rules = [
			'name' => [
				'strip_tags',
				function ( $value ) {
						return strtoupper( $value );
				},
			],
		];

		$data = $this->sanitize( $data, $rules );
		$this->assertEquals( 'SINA', $data['name'] );

	}

}
