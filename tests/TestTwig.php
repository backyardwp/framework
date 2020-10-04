<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard twig testing
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests;

use Backyard\Plugin;
use Backyard\Twig\TwigServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TestTwig extends \WP_UnitTestCase {

	protected $plugin;

	public function setUp() {
		$path   = realpath( __DIR__ . '/test-plugin' );
		$plugin = new Plugin( $path, realpath( __DIR__ . '/test-plugin/test-plugin.php' ), 'config' );
		$plugin->addServiceProvider( TwigServiceProvider::class );
		$plugin->bootPluginProviders();
		$this->plugin = $plugin;
	}

	public function testServiceProviderRegistration() {

		$this->assertTrue( $this->plugin->has( 'twig' ) );
		$this->assertTrue( $this->plugin->has( 'twig.loader' ) );

		$this->assertInstanceOf( Environment::class, $this->plugin->get( 'twig' ) );
		$this->assertInstanceOf( FilesystemLoader::class, $this->plugin->get( 'twig.loader' ) );

	}

	public function testTwigMacroRegistration() {
		$this->assertInstanceOf( Environment::class, $this->plugin->twig() );
	}

	public function testCanCreateCacheFolderFromMacro() {
		$this->plugin->createTwigCacheFolder();
		$this->assertTrue( is_dir( trailingslashit( wp_upload_dir()['basedir'] ) . $this->plugin->getDirectoryName() . '-twig-cache' ) );
	}

	public function testCanRenderBasic() {
		$output = $this->plugin->twig()->render( 'basic.twig' );
		$this->assertEquals( 'hello world', trim( $output ) );
	}

	public function testCanRenderWithVariables() {
		$output = $this->plugin->twig()->render( 'variable.twig', [ 'name' => 'Bob' ] );
		$this->assertEquals( 'hello Bob', trim( $output ) );
	}

	public function testCanDeleteCacheFolderFromMacro() {
		$this->testCanCreateCacheFolderFromMacro();
		$this->plugin->deleteTwigCacheFolder();
		$this->assertFalse( is_dir( trailingslashit( wp_upload_dir()['basedir'] ) . $this->plugin->getDirectoryName() . '-twig-cache' ) );

	}

}
