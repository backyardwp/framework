<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard application foundation
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests;

use Backyard\Plugin;
use Backyard\Requests\RequestsServiceProvider;
use Laminas\Diactoros\ServerRequest;

class TestRequests extends \WP_UnitTestCase {

	protected $plugin;

	public function setUp() {
		$path   = realpath( __DIR__ . '/test-plugin', );
		$plugin = new Plugin( $path, realpath( __DIR__ . '/test-plugin/test-plugin.php' ), 'config' );

		$plugin->addServiceProvider( RequestsServiceProvider::class );

		$plugin->bootPluginProviders();

		$this->plugin = $plugin;
	}

	public function testRequestsInstance() {
		$this->assertTrue( $this->plugin->has( 'request' ) );
	}

	public function testMacroRegistration() {
		$this->assertInstanceOf( ServerRequest::class, $this->plugin->request() );
	}

}
