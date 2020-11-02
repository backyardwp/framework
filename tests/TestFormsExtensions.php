<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard forms testing.
 *
 * @package   backyard-foundation
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Tests;

use Backyard\Forms\Extensions\Nonce\NonceExtension;
use Backyard\Forms\Extensions\Sanitizer\SanitizerExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Test\TypeTestCase;

class TestFormsExtension extends TypeTestCase {

	protected function getExtensions() {
		return [
			new NonceExtension(),
			new SanitizerExtension(),
		];
	}

	public function testNonceExtensionOptionDefault() {
		$form   = $this->factory->create( FormType::class, [] );
		$config = $form->getConfig();

		$this->assertTrue( $config->hasOption( 'nonce' ) );
		$this->assertSame( $config->getOption( 'nonce' ), false );
	}

	public function testNonceExtensionSubmissionFails() {

		$form = $this->factory
			->createBuilder(
				FormType::class,
				null,
				[
					'nonce' => 'testing',
				]
			)
			->add( 'child', TextType::class )
			->getForm();

		$form->submit( [ 'child' => 'foobar' ] );

		$this->assertFalse( $form->isValid() );

	}

	public function testSanitizerExtensionOptionDefault() {

		$form   = $this->factory->create( FormType::class, [] );
		$config = $form->getConfig();

		$this->assertTrue( $config->hasOption( 'sanitizer' ) );
		$this->assertSame( $config->getOption( 'sanitizer' ), true );

	}

	public function testFormInputsAreSanitized() {

		$form = $this->factory
			->createBuilder(
				FormType::class,
				null,
				[
					'nonce' => 'testing',
				]
			)
			->add( 'child', TextType::class )
			->getForm();

		$form->submit( [ 'child' => '<strong>test</strong>' ] );

		$this->assertSame( $form->getData()['child'], 'test' );

	}

	public function testFormInputsAreNotSanitizedWhenSpecified() {

		$form = $this->factory
			->createBuilder(
				FormType::class,
				null,
				[
					'nonce' => 'testing',
				]
			)
			->add( 'child', TextType::class )
			->add( 'child_2', TextType::class, [ 'sanitizer' => false ] )
			->getForm();

		$form->submit(
			[
				'child'   => '<strong>test</strong>',
				'child_2' => '<strong>value</strong>',
			]
		);

		$this->assertSame( $form->getData()['child'], 'test' );
		$this->assertSame( $form->getData()['child_2'], '<strong>value</strong>' );

	}

}
