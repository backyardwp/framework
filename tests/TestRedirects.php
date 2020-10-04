<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard redirects test.
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests;

use Backyard\Cache\Transient;
use Backyard\Plugin;
use Backyard\Redirects\Redirect;
use Backyard\Redirects\RedirectServiceProvider;
use DOMDocument;
use DOMXPath;

class TestRedirects extends \WP_UnitTestCase {

	protected $plugin;

	protected function doAdminNotices() {
		ob_start();
		do_action( 'admin_notices' );
		$output = ob_get_contents();
		ob_end_clean();

		$dom = new DOMDocument();
		if ( $output !== '' ) {
			$dom->loadHTML( $output );
		}
		return new DOMXPath( $dom );
	}

	protected function getNotices( DOMXPath $xpath ) {
		$noticeQuery = ".//div[contains(concat(' ', normalize-space(@class), ' '), ' notice ')]";
		return $xpath->query( $noticeQuery );
	}

	protected function assertNoticeCount( DOMXPath $output, $expectedNumberOfNotices, $message = '' ) {
		$notices = $this->getNotices( $output );
		$this->assertEquals( $expectedNumberOfNotices, $notices->length, $message );
	}

	protected function assertNoticeHasClass( DOMXPath $output, $className, $message = '', $index = 0 ) {
		$results = $this->getNotices( $output );
		$notice  = $results->item( $index );

		if ( $notice === null ) {
			$this->assertNotNull( $notice, $message );
			return;
		}

		$classes = explode( ' ', $notice->getAttribute( 'class' ) );
		$this->assertContains( $className, $classes, $message );
	}

	public function setUp() {
		$path   = realpath( __DIR__ . '/test-plugin' );
		$plugin = new Plugin( $path, realpath( __DIR__ . '/test-plugin/test-plugin.php' ) );
		$plugin->addServiceProvider( RedirectServiceProvider::class );
		$plugin->bootPluginProviders();
		$this->plugin = $plugin;
	}

	public function testServiceProviderRegistration() {
		$this->assertTrue( $this->plugin->has( 'redirect' ) );
		$this->assertInstanceOf( Redirect::class, $this->plugin->get( 'redirect' ) );
	}

	public function testServiceProviderMacroable() {
		$this->assertInstanceOf( Redirect::class, $this->plugin->redirect() );
	}

	public function testCachePrefix() {
		$this->assertEquals( 'test-plugin', $this->plugin->redirect()->getCachePrefix() );
	}

	public function testUrlSetter() {
		$redirect = $this->plugin->redirect()->toUrl( 'https://example.com' );
		$this->assertEquals( 'https://example.com', $redirect->getUrl() );
	}

	public function testTransientSetup() {
		$this->plugin->redirect()->withNotice( 'message' );
		$prefix = $this->plugin->getDirectoryName();

		$this->assertTrue( ! empty( Transient::get( "{$prefix}_admin_notice" ) ) );
	}

	public function testNoticeOutput() {

		$this->plugin->redirect()->withNotice( 'message' );
		$output = $this->doAdminNotices();

		$this->assertNoticeCount( $output, 1 );
		$this->assertNoticeHasClass( $output, 'notice-success' );
		$this->assertNoticeHasClass( $output, 'backyard-admin-notice' );
	}

}
