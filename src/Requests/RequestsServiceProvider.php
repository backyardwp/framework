<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Registers the http requests functionality within the plugin.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Requests;

use Backyard\Contracts\BootablePluginProviderInterface;
use Backyard\Utils\RequestFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Registers the templates functionality within the plugin.
 */
class RequestsServiceProvider extends AbstractServiceProvider implements BootablePluginProviderInterface {

	/**
	 * The provided array is a way to let the container
	 * know that a service is provided by this service
	 * provider. Every service that is registered via
	 * this service provider must have an alias added
	 * to this array or it will be ignored.
	 *
	 * @var array
	 */
	protected $provides = [
		'request',
	];

	/**
	 * Register the templates functionality within the plugin's container.
	 *
	 * @return void
	 * @throws MissingConfigurationException When the require config is missing.
	 */
	public function register() {

		/** @var \Backyard\Plugin $container */
		$container = $this->getContainer();

		$container->add( 'request', RequestFactory::create() );

	}

	/**
	 * Register a new macro.
	 *
	 * @return void
	 */
	public function bootPlugin() {

		$instance = $this;

		$this->getContainer()::macro(
			'request',
			function() use ( $instance ) {
				return $instance->getContainer()->get( 'request' );
			}
		);
	}

}
