<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Test sanitization utility.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Utils\Tests;

use Backyard\Utils\Sanitizer;

class TestSanitizer extends \WP_UnitTestCase {

	public function testTextSanitization() {
		$this->assertSame( Sanitizer::clean( '<strong>test</strong>' ), 'test' );
		$this->assertSame( Sanitizer::clean( [ '<strong>test</strong>', '<strong>test</strong>' ] ), [ 'test', 'test' ] );
	}

	public function testTextareaSanitization() {
		$this->assertEquals( "foo\ncleaned\nbar", Sanitizer::cleanTextarea( "foo\n<script>alert();</script>cleaned\nbar" ) );
	}

}
