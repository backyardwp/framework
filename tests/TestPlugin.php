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
use League\Container\ServiceProvider\AbstractServiceProvider;

class TestPlugin extends \WP_UnitTestCase {

	protected $plugin;

	public function setUp() {
		$path         = realpath( __DIR__ . '/test-plugin', );
		$plugin       = new Plugin( $path, realpath( __DIR__ . '/test-plugin/test-plugin.php' ), 'config' );
		$this->plugin = $plugin;
	}

	public function testPathsDefinition() {
		$plugin = $this->plugin;
		$path   = realpath( __DIR__ . '/test-plugin' );

		$this->assertEquals( $path, $plugin->basePath() );
		$this->assertEquals( $plugin->getEntryFilePath(), realpath( __DIR__ . '/test-plugin/test-plugin.php' ) );
		$this->assertEquals( 'test-plugin', $plugin->getDirectoryName() );
	}

	public function testPluginHeaders() {
		$plugin = $this->plugin;

		$this->assertEquals( 'Backyard example plugin', $plugin->getHeader( 'name' ) );
		$this->assertEquals( '0.1.0', $plugin->getHeader( 'version' ) );
		$this->assertEquals( 'TD', $plugin->getHeader( 'plugin_prefix' ) );
	}

	public function testServiceProvidersAreBoundWhenRegistered() {
		$this->plugin->addServiceProvider( ServiceProviderExample::class );
		$this->assertTrue( $this->plugin->has( 'wp' ) );
	}

	public function testPluginConstants() {

		$plugin = $this->plugin;

		$this->assertTrue( defined( "{$plugin->getHeader( 'plugin_prefix' )}_VERSION" ) );
		$this->assertTrue( defined( "{$plugin->getHeader( 'plugin_prefix' )}_PLUGIN_FILE" ) );
		$this->assertTrue( defined( "{$plugin->getHeader( 'plugin_prefix' )}_PLUGIN_BASE" ) );
		$this->assertTrue( defined( "{$plugin->getHeader( 'plugin_prefix' )}_PLUGIN_DIR" ) );
		$this->assertTrue( defined( "{$plugin->getHeader( 'plugin_prefix' )}_PLUGIN_URL" ) );

	}

	public function testPluginConfiguration() {
		$plugin = $this->plugin;
		$this->assertEquals( 'value', $plugin->config( 'test' ) );
	}

	public function testPluginCanIncludeFiles() {
		$this->plugin->includes( $this->plugin->basePath() . '/includes' );
		$this->assertTrue( defined( 'BACKYARD_TEST_INCLUSION' ) );
	}

}

class ServiceProviderExample extends AbstractServiceProvider {
	protected $provides = [
		'wp',
	];

	public function register() {
		$this->getContainer()->add( 'wp', 'hello' );
	}
}
