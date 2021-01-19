<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard views testing
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests;

use Backyard\Templates\Engine;
use Backyard\Views\View;

class TestViews extends \WP_UnitTestCase {

	public function testViewHasEngine() {

		$view = new MyView();

		$this->assertInstanceOf( Engine::class, $view->templates() );

	}

	public function testViewCanRender() {

		$view = new MyView();

		ob_start();

		$view->render();

		$output = ob_get_clean();

		$this->assertEquals( 'testing', trim( $output ) );

	}

}

class MyView extends View {

	public function render() {
		echo $this->templates()->render( 'vendor::test' );
	}

}
