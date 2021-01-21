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

use Backyard\Requests\RequestFactory;
use Laminas\Diactoros\ServerRequest;

class TestRequestFactory extends \WP_UnitTestCase {

	public function testFactoryCreation() {

		$request = RequestFactory::create();

		$this->assertInstanceOf( ServerRequest::class, $request );

	}

	public function testCaptureFromGlobals() {

		$_GET['foo1']    = 'bar1';
		$_POST['foo2']   = 'bar2';
		$_COOKIE['foo3'] = 'bar3';
		$_SERVER['foo5'] = 'bar5';

		$request = RequestFactory::create();

		$this->assertSame( 'bar1', $request->getQueryParams()['foo1'] );
		$this->assertSame( 'bar2', $request->getParsedBody()['foo2'] );
		$this->assertSame( 'bar3', $request->getCookieParams()['foo3'] );

	}

}
