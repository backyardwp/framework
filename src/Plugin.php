<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard plugin foundation.
 *
 * @package   backyard-framwork
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard;

use Backyard\Contracts\BootablePluginProviderInterface;
use Backyard\Support\IncludesFiles;
use Backyard\Support\PluginHeaders;
use Backyard\Support\WordPressFileHeaders;
use Configula\ConfigFactory;
use Illuminate\Support\Traits\Macroable;
use League\Container\Container;

/**
 * Backyard plugin container definition.
 */
class Plugin extends Container {

	use PluginHeaders;
	use WordPressFileHeaders;
	use IncludesFiles;
	use Macroable;

	/**
	 * Framwork version.
	 *
	 * @var string
	 */
	const VERSION = '0.1.0';

	/**
	 * @var string
	 */
	protected $filePath;

	/**
	 * @var string
	 */
	protected $basePath;

	/**
	 * @var string
	 */
	protected $directoryName;

	/**
	 * @var string
	 */
	protected $configFolder;

	/**
	 * Configuration repository
	 *
	 * @var ConfigFactory
	 */
	protected $config;

	/**
	 * @var array
	 */
	protected $parsedHeaders = [];

	/**
	 * Indicates if the plugin has booted.
	 *
	 * @var bool
	 */
	protected $booted = false;

	/**
	 * Create a new Backyard powered plugin instance.
	 *
	 * @param string $basePath path of the plugin
	 * @param string $filePath path of the plugin entry file
	 * @param string $configFolder relative path to the configuration folder.
	 */
	public function __construct( $basePath, $filePath, $configFolder = null ) {
		parent::__construct();

		$this->setBasePath( $basePath );
		$this->setFilePath( $filePath );
		$this->setDirectoryName();
		$this->processParsedHeaders();
		$this->setConstants();

		if ( $configFolder ) {
			$this->loadConfigurationFromFolder( $configFolder );
		}
	}

	/**
	 * Get the base path of the plugin.
	 *
	 * @param string $path Optional path to append to the base path.
	 *
	 * @return string
	 */
	public function basePath( $path = '' ) {
		return $this->basePath . ( $path ? DIRECTORY_SEPARATOR . $path : $path );
	}

	/**
	 * Set the base path for the plugin.
	 *
	 * @param string $basePath
	 */
	public function setBasePath( $basePath ) {
		$this->basePath = rtrim( $basePath, '\/' );
	}

	/**
	 * Set the path to the plugin's entry file.
	 *
	 * @param string $filePath
	 * @return void
	 */
	public function setFilePath( $filePath ) {
		$this->filePath = rtrim( $filePath, '\/' );
	}

	/**
	 * Return the path to the plugin's entry file.
	 *
	 * @return string
	 */
	public function getEntryFilePath() {
		return $this->filePath;
	}

	/**
	 * Set the plugin directory name.
	 *
	 * @return void
	 */
	public function setDirectoryName() {
		$pos                 = strrpos( $this->basePath, DIRECTORY_SEPARATOR );
		$this->directoryName = substr( $this->basePath, $pos + 1 );
	}

	/**
	 * Return the plugin directory name.
	 *
	 * @return string
	 */
	public function getDirectoryName(): string {
		return $this->directoryName;
	}

	/**
	 * Return the plugin root URL.
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public function getUrl( string $path = '' ): string {
		return plugins_url( $path, $this->filePath );
	}

	/**
	 * Return a plugin header.
	 *
	 * @param string $header
	 *
	 * @return string|null
	 */
	public function getHeader( string $header ) {
		return $this->parsedHeaders[ $header ] ?? null;
	}

	/**
	 * Process the plugin entry file headers.
	 *
	 * @return void
	 */
	protected function processParsedHeaders() {
		$this->parsedHeaders = $this->headers( $this->filePath, $this->headers );
	}

	/**
	 * Load configuration files from a folder.
	 *
	 * @param string $folder relative path to the configuration folder.
	 * @return void
	 */
	protected function loadConfigurationFromFolder( $folder ) {
		$this->configFolder = $folder;
		$this->config       = ConfigFactory::loadPath( $this->basePath( $folder ) );
	}

	/**
	 * Return a plugin configuration value.
	 *
	 * @param string $key     Key configuration short name.
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function config( string $key, $default = false ) {
		return $this->config->get( $key, $default );
	}

	/**
	 * Get the version number of the framework.
	 *
	 * @return string
	 */
	public function version() {
		return static::VERSION;
	}

	/**
	 * Determine if the plugin has booted.
	 *
	 * @return bool
	 */
	public function isBooted() {
		return $this->booted;
	}

	/**
	 * Set plugin headers and plugin constants.
	 *
	 * @return void
	 */
	protected function setConstants() {

		$version = $this->getHeader( 'version' ) ?? false;
		$prefix  = $this->getHeader( 'plugin_prefix' );

		if ( ! defined( "{$prefix}_VERSION" ) ) {
			define( "{$prefix}_VERSION", $version );
		}

		if ( ! defined( "{$prefix}_PLUGIN_FILE" ) ) {
			define( "{$prefix}_PLUGIN_FILE", $this->filePath );
		}

		if ( ! defined( "{$prefix}_PLUGIN_BASE" ) ) {
			define( "{$prefix}_PLUGIN_BASE", plugin_basename( constant( "{$prefix}_PLUGIN_FILE" ) ) );
		}

		if ( ! defined( "{$prefix}_PLUGIN_DIR" ) ) {
			define( "{$prefix}_PLUGIN_DIR", plugin_dir_path( constant( "{$prefix}_PLUGIN_FILE" ) ) );
		}

		if ( ! defined( "{$prefix}_PLUGIN_URL" ) ) {
			define( "{$prefix}_PLUGIN_URL", plugin_dir_url( constant( "{$prefix}_PLUGIN_FILE" ) ) );
		}
	}

	/**
	 * Load plugin's textdomain.
	 *
	 * @return void
	 */
	public function loadPluginTextDomain() {
		load_plugin_textdomain( $this->getHeader( 'text_domain' ), false, $this->basePath( ltrim( $this->getHeader( 'domain_path' ), '/' ) ) );
	}

	/**
	 * Trigger callback on activation of the plugin.
	 *
	 * @param \Closure $activation
	 * @return void
	 */
	public function onActivation( \Closure $activation ) {

		$instance = $this;

		register_activation_hook(
			$this->filePath,
			function () use ( $activation, $instance ) {
				try {
					call_user_func_array( $activation, [ $instance ] );
				} catch ( \Exception $e ) {
					deactivate_plugins( basename( $this->filePath ) );
					wp_die( $e->getMessage() ); //phpcs:ignore
				}
			}
		);

	}

	/**
	 * Trigger callback on plugin deactivation.
	 *
	 * @param \Closure $deactivation
	 * @return void
	 */
	public function onDeactivation( \Closure $deactivation ) {

		$instance = $this;

		register_deactivation_hook(
			$this->filePath,
			function () use ( $deactivation, $instance ) {
				try {
					call_user_func_array( $deactivation, [ $instance ] );
				} catch ( \Exception $e ) {
					wp_die( $e->getMessage() ); //phpcs:ignore
				}
			}
		);

	}

	/**
	 * Boot plugin providers.
	 *
	 * @return void
	 */
	public function bootPluginProviders() {
		foreach ( $this->providers as $provider ) {
			if ( $provider instanceof BootablePluginProviderInterface ) {
				$provider->bootPlugin();
			}
		}
	}

	/**
	 * Boot the plugin by running it up to the WordPress plugins_loaded hook.
	 *
	 * @param \Closure $boot
	 * @return void
	 */
	public function boot( \Closure $boot ) {

		$instance = $this;

		add_action(
			'plugins_loaded',
			function () use ( $boot, $instance ) {
				try {
					$instance->bootPluginProviders();
					$instance->booted = true;
					call_user_func_array( $boot, [ $instance ] );
				} catch ( \Exception $e ) {
					wp_die( $e->getMessage() ); //phpcs:ignore
				}
			}
		);
	}
}
