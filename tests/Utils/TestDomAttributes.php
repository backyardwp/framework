<?php // phpcs:ignore WordPress.Files.FileName
/**
 * DomAttributes class tests
 *
 * @package   backyard-cache
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Utils\Tests;

use Backyard\Utils\DomAttributes;

class TestDomAttributes extends \WP_UnitTestCase {

	/**
	 * Attributes class
	 *
	 * @var DomAttributes
	 */
	public $attrs;

	public function setUp() {
		$this->attrs = new DomAttributes();
	}

	public function testCanInstance() {
		$this->assertInstanceOf( DomAttributes::class, $this->attrs );
	}

	public function testCanAddAttributes() {

		$this->attrs->add(
			'test',
			[
				'class' => 'color-primary',
				'id'    => 'unique_id',
			]
		);

		$this->assertTrue( $this->attrs->has( 'test' ) );

	}

	public function testCanGetAttributes() {

		$attr = [
			'class' => 'color-primary',
			'id'    => 'unique_id',
		];

		$this->attrs->add( 'test', $attr );

		$this->assertEquals( $attr, $this->attrs->get( 'test' ), '' );

	}

	public function testCanRemoveAttributes() {

		$attr = [
			'class' => 'color-primary',
			'id'    => 'unique_id',
		];

		$this->attrs->add( 'test', $attr );
		$this->attrs->remove( 'test' );

		$this->assertFalse( $this->attrs->has( 'test' ) );

	}

	public function testCanRender() {

		$this->attrs->add(
			'test',
			[
				'class' => 'color-primary',
				'id'    => 'unique_id',
			]
		);

		$attr = $this->attrs->render( 'test' );
		$this->assertStringContainsString( ' class="color-primary" id="unique_id"', $attr, '' );

	}

	public function testContextRemovalAfterRendering() {

		$this->attrs->add(
			'test',
			[
				'class' => 'color-primary',
				'id'    => 'unique_id',
			]
		);

		$attr = $this->attrs->render( 'test' );

		$this->assertFalse( $this->attrs->has( 'test' ), '' );

	}

	public function testAttributeRemovedWhenEmpty() {

		$this->attrs->add(
			'test-with-key-value-first',
			[

				'id'    => 'unique_id',
				'class' => '',
				'attr1' => null,
				'attr2' => false,
				'attr3' => 0,
			]
		);

		$attr = $this->attrs->render( 'test-with-key-value-first' );
		$this->assertEquals( ' id="unique_id"', $attr, '' );

		$this->attrs->add(
			'test-with-key-null-first',
			[
				'class' => '',
				'attr1' => null,
				'attr2' => false,
				'attr3' => 0,
				'id'    => 'unique_id',
			]
		);

		$attr = $this->attrs->render( 'test-with-key-null-first' );
		$this->assertEquals( ' id="unique_id"', $attr, '' );

	}

	public function testAttributeHasNoValueWhenTrue() {

		$this->attrs->add(
			'test',
			[
				'class'           => 'color-primary',
				'attrWithNoValue' => true,
				'id'              => 'unique_id',
			]
		);

		$attr = $this->attrs->render( 'test' );
		$this->assertEquals( ' class="color-primary" attrWithNoValue id="unique_id"', $attr, '' );

	}

	public function testEmptyReturnWhenNoAttributeGiven() {
		$this->attrs->add( 'test', [] );

		$attr = $this->attrs->render( 'test' );
		$this->assertEmpty( $attr, '' );
		$this->assertIsString( $attr, '' );
	}

}
