<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard forms test.
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests\AdminPages;

use Backyard\AdminPages\AbstractPage;

class TestAbstractPage extends \WP_UnitTestCase {

	/**
	 * @var AbstractPage
	 */
	protected $stub;

	public function setUp() {
		parent::setUp();
		$this->stub = $this->getMockForAbstractClass( AbstractPage::class );
	}

	public function testGetterAndSetterName() {
		$value = 'test-name';

		$this->assertNull( $this->stub->getName() );
		$this->assertSame( $this->stub, $this->stub->setName( $value ) );
		$this->assertSame( $value, $this->stub->getName() );
	}

	public function testGetterAndSetterPageTitle() {
		$value = 'Test Page Title';

		$this->assertNull( $this->stub->getPageTitle() );
		$this->assertSame( $this->stub, $this->stub->setPageTitle( $value ) );
		$this->assertSame( $value, $this->stub->getPageTitle() );
	}

	public function testGetterAndSetterMenuTitle() {
		$value = 'Test Menu Title';

		$this->assertNull( $this->stub->getMenuTitle() );
		$this->assertSame( $this->stub, $this->stub->setMenuTitle( $value ) );
		$this->assertSame( $value, $this->stub->getMenuTitle() );
	}

	public function testGetterAndSetterCapability() {
		$value = 'test_manage_options';

		$this->assertNull( $this->stub->getCapability() );
		$this->assertSame( $this->stub, $this->stub->setCapability( $value ) );
		$this->assertSame( $value, $this->stub->getCapability() );
	}

	public function testGetterAndSetterMenuSlug() {
		$value = 'test-menu-slug';

		$this->assertNull( $this->stub->getMenuSlug() );
		$this->assertSame( $this->stub, $this->stub->setMenuSlug( $value ) );
		$this->assertSame( $value, $this->stub->getMenuSlug() );
	}
}
