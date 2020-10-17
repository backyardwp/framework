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

use Backyard\Forms\FormBuilder;
use Backyard\Forms\FormsServiceProvider;
use Backyard\Plugin;
use Backyard\Twig\Extensions\NonceFieldsExtension;
use Backyard\Twig\TwigServiceProvider;
use Backyard\Utils\Str;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;

class TestForms extends \WP_UnitTestCase {

	protected $form;

	protected $plugin;

	public function setUp() {
		$form = ( new FormBuilder() )->create()
			->add( 'task', TextType::class );

		$this->form = $form;

		$path   = realpath( __DIR__ . '/test-plugin', );
		$plugin = new Plugin( $path, realpath( __DIR__ . '/test-plugin/test-plugin.php' ), 'config' );

		$plugin->addServiceProvider( TwigServiceProvider::class );
		$plugin->addServiceProvider( FormsServiceProvider::class );
		$plugin->bootPluginProviders();

		$this->plugin = $plugin;
	}

	public function testCanCreateForm() {
		$this->assertInstanceOf( Form::class, $this->form );
		$this->assertEquals( 1, $this->form->count() );
		$this->assertTrue( $this->form->has( 'task' ) );
	}

	public function testTwigHasExtension() {
		$this->assertTrue( $this->plugin->twig()->hasExtension( FormExtension::class ) );
		$this->assertTrue( $this->plugin->twig()->hasExtension( NonceFieldsExtension::class ) );
	}

	public function testPluginCanRenderForm() {
		$output = $this->plugin->twig()->render( 'form_example.twig', [ 'form' => $this->form->createView() ] );
		$this->assertTrue( Str::contains( $output, '<form name="form"' ) );
	}

	public function testTwigCanRenderNonceFields() {
		$output = $this->plugin->twig()->render( 'nonce.twig' );
		$this->assertTrue( Str::contains( $output, '<input type="hidden" id="_myslug-nonce"' ) );
	}

}
