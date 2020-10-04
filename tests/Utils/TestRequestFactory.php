<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard http requests test.
 *
 * @package   backyard-cache
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Utils\Tests;

use Backyard\Utils\RequestFactory;
use Symfony\Component\HttpFoundation\Request;

class TestTransient extends \WP_UnitTestCase {

	public function testFactoryCreation() {

		$request = RequestFactory::create();

		$this->assertInstanceOf( Request::class, $request );

	}

	public function testCaptureFromGlobals() {

		$_GET['foo1']    = 'bar1';
		$_POST['foo2']   = 'bar2';
		$_COOKIE['foo3'] = 'bar3';
		$_FILES['foo4']  = array( 'bar4' );
		$_SERVER['foo5'] = 'bar5';

		$request = RequestFactory::create();
		$this->assertSame( 'bar1', $request->query->get( 'foo1' ) );
		$this->assertSame( 'bar2', $request->request->get( 'foo2' ) );
		$this->assertSame( 'bar3', $request->cookies->get( 'foo3' ) );
		$this->assertSame( array( 'bar4' ), $request->files->get( 'foo4' ) );
		$this->assertSame( 'bar5', $request->server->get( 'foo5' ) );

	}

}
