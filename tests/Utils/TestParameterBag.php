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

use Backyard\Utils\ParameterBag;

class TestParameterBag extends \WP_UnitTestCase {

	/**
	 * @var ParameterBag
	 */
	private $container;

	public function setUp() {
		parent::setUp();

		$this->container = new ParameterBag( [ 'foo' => 'bar' ] );
	}

	public function testAdd() {
		$this->container->add( [ 'bar' => 'foo' ] );
		$this->assertEquals(
			[
				'foo' => 'bar',
				'bar' => 'foo',
			],
			$this->container->all()
		);
	}

	public function testAll() {
		$this->assertEquals( [ 'foo' => 'bar' ], $this->container->all() );
	}

	public function testCount() {
		$this->assertEquals( 1, $this->container->count() );
	}

	public function testGet() {
		$this->assertEquals( 'bar', $this->container->get( 'foo' ) );
		$this->assertEquals( 'notExistent', $this->container->get( 'bar', 'notExistent' ) );

	}

	public function testGetIterator() {
		$parameters = [
			'foo' => 'bar',
			'bar' => 'foo',
		];
		$container  = new ParameterBag( $parameters );

		$elements = 0;
		foreach ( $container as $parameter => $value ) {
			/* Cycle all the parameters to ensure we have all the expected ones */
			++$elements;

			$this->assertEquals( $parameters[ $parameter ], $value );
		}
		//
		// We will also need to ensure that we have the number of elements matching the expected
		$this->assertEquals( count( $parameters ), $elements );
	}

	public function testKeys() {
		$this->assertEquals( [ 'foo' ], $this->container->keys() );
	}

	public function testRemove() {
		$this->container->remove( 'foo' );
		$this->assertEmpty( $this->container->all() );
	}

	public function testReplace() {
		$this->container->replace( [ 'bar' => 'foo' ] );
		$this->assertEquals( [ 'bar' => 'foo' ], $this->container->all() );
	}

	public function testSet() {
		$this->container->set( 'foo', 'newValue' );
		$this->assertEquals( 'newValue', $this->container->get( 'foo' ) );
	}

	public function testSetNotExistent() {
		$this->container->set( 'notExistent', 'created' );
		$this->assertEquals( 'created', $this->container->get( 'notExistent' ) );
	}

}
