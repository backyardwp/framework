<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard nonces test.
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests;

use Backyard\Nonces\Nonce;
use Backyard\Nonces\NonceFactory;

class TestNonces extends \WP_UnitTestCase {

	public $slug = 'nonceSlug';

	public function testCreateNonceInstance() {

		$nonce = new Nonce( $this->slug );

		$this->assertEquals( $nonce->getKey(), "_{$this->slug}-nonce" );

	}

	public function testGenerateNonceUrl() {

		$nonce = new Nonce( $this->slug );

		$this->assertTrue( strpos( $nonce->url( 'http://example.com' ), "?_{$this->slug}-nonce" ) !== false );

	}

	public function testGenerateNonceField() {

		$nonce = new Nonce( $this->slug );

		$expected = '<input type="hidden" id="_' . $this->slug . '-nonce" name="_' . $this->slug . '-nonce" value="' . $nonce->make() . '" /><input type="hidden" name="_wp_http_referer" value="" />';

		$this->assertEquals( $nonce->render(), $expected );

	}

	public function testValidateNonce() {

		$user = $this->factory->user->create_and_get(
			array(
				'user_login' => 'waldo',
				'user_pass'  => null,
				'role'       => 'subscriber',
			)
		);

		$this->assertTrue( 0 !== $user->ID );

		wp_set_current_user( $user->ID );

		$nonce = new Nonce( $this->slug );

		$_POST[ $nonce->getKey() ] = $nonce->make();

		$this->assertTrue( $nonce->check( $_POST[ $nonce->getKey() ] ) );

	}

	public function testFactoryValidation() {

		$user = $this->factory->user->create_and_get(
			array(
				'user_login' => 'waldo',
				'user_pass'  => null,
				'role'       => 'subscriber',
			)
		);

		wp_set_current_user( $user->ID );

		$nonce = new Nonce( $this->slug );

		$_POST[ $nonce->getKey() ] = $nonce->make();

		$this->assertTrue( NonceFactory::verify( $this->slug ) );

	}

}
