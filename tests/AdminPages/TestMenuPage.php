<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard pages test.
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests\AdminPages;

use Backyard\AdminPages\MenuPage;

class TestMenuPage extends \WP_UnitTestCase {

	/**
	 * @var MenuPage
	 */
	protected $stub;

	public function setUp() {
		parent::setUp();
		$this->stub = new MenuPage();
		$this->stub
			->setPageTitle( 'Test Page Title' )
			->setMenuTitle( 'Test Menu Title' )
			->setCapability( 'test_capability' )
			->setMenuSlug( 'test-menu-slug' )
			->setIcon( 'dashicons-admin-site' )
			->setPosition( 100 );
	}

	public function testRegister() {
		$this->assertSame( $this->stub, $this->stub->register() );
	}

	/**
	 * @depends testRegister
	 */
	public function testUnRegister() {

		$this->stub->register();

		$this->assertSame( $this->stub, $this->stub->unRegister() );

		try {
			$this->stub->unRegister();
		} catch ( \Exception $exception ) {
			$this->assertTrue( is_a( $exception, \Exception::class ) );
		}
	}

	public function testGetURL() {
		$this->assertSame(
			'http://example.org/wp-admin/options-general.php?page=test-menu-slug',
			$this->stub->getURL()
		);
	}

	public function testGetterAndSetterIcon() {
		$this->assertSame( 'dashicons-admin-site', $this->stub->getIcon() );
		$this->assertSame( $this->stub, $this->stub->setIcon( 'dashicons-admin-site' ) );
	}

	public function testGetterAndSetterPosition() {
		$this->assertSame( 100, $this->stub->getPosition() );
		$this->assertSame( $this->stub, $this->stub->setPosition( 100 ) );
	}
}
