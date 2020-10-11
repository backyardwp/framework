<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Register the twig functionality within the plugin.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Twig;

use Backyard\Contracts\BootablePluginProviderInterface;
use Backyard\Exceptions\MissingConfigurationException;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Registers the Twig templating engine functionality into the plugin.
 */
class TwigServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface, BootablePluginProviderInterface {

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
		'twig.loader',
		'twig',
	];

	/**
	 * Add the file system loader into the plugin.
	 *
	 * The createTwigCacheFolder() method creates a subfolder within the wp-uploads folder
	 * where cache files generated for twig templates are stored.
	 *
	 * The deleteTwigCacheFolder() method deletes the folder previously created.
	 *
	 * @return void
	 * @throws MissingConfigurationException When the plugin configuration is missing the views_path specification.
	 */
	public function boot() {

		$container = $this->getContainer();

		if ( ! $container->config( 'views_path' ) ) {
			throw new MissingConfigurationException( 'Twig service provider requires "views_path" to be configured.' );
		}

		$path = $container->basePath( $container->config( 'views_path' ) );

		$container
			->add( FilesystemLoader::class )
			->addArgument( $path )
			->addTag( 'twig.loader' )
			->setShared();

		$cachePath = trailingslashit( wp_upload_dir()['basedir'] ) . $this->getContainer()->getDirectoryName() . '-twig-cache';

		$this->getContainer()
			->add( Environment::class )
			->addArgument( $this->getContainer()->get( FilesystemLoader::class ) )
			->addArgument(
				[
					'cache'       => $cachePath,
					'auto_reload' => true,
				]
			)
			->addTag( 'twig' )
			->setShared();

		// Register macros.
		$container::macro(
			'createTwigCacheFolder',
			function() use ( $container ) {
				$customFolder = trailingslashit( wp_upload_dir()['basedir'] ) . $container->getDirectoryName() . '-twig-cache';
				if ( ! is_dir( $customFolder ) ) {
					wp_mkdir_p( $customFolder );
				}
			}
		);

		$container::macro(
			'deleteTwigCacheFolder',
			function() use ( $container ) {
				WP_Filesystem();
				global $wp_filesystem;
				$customFolder = trailingslashit( wp_upload_dir()['basedir'] ) . $container->getDirectoryName() . '-twig-cache';
				if ( is_dir( $customFolder ) ) {
					$wp_filesystem->delete( $customFolder, true );
				}
			}
		);

	}

	/**
	 * @return void
	 */
	public function register() {}

	/**
	 * When the plugin is booted, register a new macro.
	 *
	 * Adds the `twig()` method that returns an instance of the Twig\Environment class.
	 *
	 * @return void
	 */
	public function bootPlugin() {

		$instance = $this;

		$this->getContainer()::macro(
			'twig',
			function() use ( $instance ) {
				return $instance->getContainer()->get( Environment::class );
			}
		);

	}

}
