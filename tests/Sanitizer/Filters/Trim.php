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

namespace Backyard\Tests\Sanitizer\Filters;

use Backyard\Sanitizer\Sanitizer;

class TestTrim extends \WP_UnitTestCase {

	public function sanitize( $data, $rules ) {
		$sanitizer = new Sanitizer( $data, $rules );
		return $sanitizer->sanitize();
	}

	public function testItCanTrimStrings() {
		$data  = [
			'name' => '  Test  ',
		];
		$rules = [
			'name' => 'trim',
		];
		$data  = $this->sanitize( $data, $rules );
		$this->assertEquals( 'Test', $data['name'] );
	}

}
