<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Add forms support to Twig.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms;

use Backyard\Exceptions\MissingConfigurationException;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Twig\Environment;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

/**
 * Extend the twig functionality to support forms.
 */
class FormsServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface {

	/**
	 * When the provider is booted, hook into Twig and
	 * add forms rendering support.
	 *
	 * @throws MissingConfigurationException When the required configuration value is missing.
	 * @return void
	 */
	public function boot() {

		$defaultTemplates = $this->getContainer()->config( 'default_forms_templates' );

		if ( empty( $defaultTemplates ) || ! is_array( $defaultTemplates ) ) {
			throw new MissingConfigurationException( 'The "default_forms_templates" config is missing or is not an array.' );
		}

		$twig = $this->getContainer()->get( Environment::class );

		$formEngine = new TwigRendererEngine( $defaultTemplates, $twig );

		$twig->addRuntimeLoader(
			new FactoryRuntimeLoader(
				[
					FormRenderer::class => function () use ( $formEngine ) {
						return new FormRenderer( $formEngine );
					},
				]
			)
		);

		$twig->addExtension( new FormExtension() );
	}

	/**
	 * @return void
	 */
	public function register() {}
}
