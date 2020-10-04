<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Registers the redirect functionality within the plugin.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Redirects;

use Backyard\Cache\Transient;
use Backyard\Contracts\BootablePluginProviderInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Register the redirect functionality within the plugin.
 */
class RedirectServiceProvider extends AbstractServiceProvider implements BootablePluginProviderInterface {

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
		'redirect',
	];

	/**
	 * Register the redirects functionality within the plugin's container.
	 *
	 * @return void
	 */
	public function register() {

		$prefix = $this->getContainer()->getDirectoryName();

		$this->getContainer()
			->add( 'redirect', Redirect::class )
			->addArgument( $prefix );

	}

	/**
	 * Register methods within the plugin container after the plugins_loaded hook.
	 * Load notices via the hook.
	 *
	 * @return void
	 */
	public function bootPlugin() {

		$instance = $this;
		$prefix   = $this->getContainer()->getDirectoryName();

		$this->getContainer()::macro(
			'redirect',
			function() use ( $instance ) {
				return $instance->getContainer()->get( 'redirect' );
			}
		);

		add_action(
			'admin_notices',
			function() use ( $prefix ) {

				$data = Transient::get( "{$prefix}_admin_notice" );

				if ( ! empty( $data ) && is_array( $data ) ) {
					Transient::forget( "{$prefix}_admin_notice" );
					AdminNotice::dismissible( $data );
				}
			}
		);

	}

}
