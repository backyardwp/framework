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
use Backyard\AdminPages\SubMenuPage;

class TestSubMenuPage extends \WP_UnitTestCase {

	/**
	 * @var SubMenuPage
	 */
	protected $stub;

	public function setUp() {
		parent::setUp();
		$this->stub = new SubMenuPage();
		$this->stub
			->setParentSlug( 'tools.php' )
			->setPageTitle( 'Test Page Title' )
			->setMenuTitle( 'Test Menu Title' )
			->setCapability( 'manage_options' )
			->setMenuSlug( 'test-menu-slug' );
	}

	public function testRegister() {
		$this->assertSame( $this->stub, $this->stub->register() );
		$this->stub->unRegister();
	}

	public function testGetURL() {
		$this->assertSame(
			'http://example.org/wp-admin/admin.php?page=test-menu-slug',
			$this->stub->getURL()
		);
	}

	public function testGetterAndSetterParentSlug() {
		$this->assertSame( 'tools.php', $this->stub->getParentSlug() );
		$this->assertSame( $this->stub, $this->stub->setParentSlug( 'tools.php' ) );
	}

	public function testGetterAndSetterParentPage() {
		$value = new MenuPage();

		$this->assertNull( $this->stub->getParentPage() );
		$this->assertSame( $this->stub, $this->stub->setParentPage( $value ) );
		$this->assertSame( $value, $this->stub->getParentPage() );
	}
}
