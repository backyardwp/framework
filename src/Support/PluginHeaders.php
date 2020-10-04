<?php // phpcs:ignore WordPress.Files.FileName
/**
 * List of plugin headers recognized by the application
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Support;

trait PluginHeaders {

	/**
	 * Plugin file headers.
	 *
	 * @var array
	 */
	public $headers = [
		'name'          => 'Plugin Name',
		'plugin_uri'    => 'Plugin URI',
		'plugin_prefix' => 'Plugin Prefix',
		'description'   => 'Description',
		'version'       => 'Version',
		'author'        => 'Author',
		'author_uri'    => 'Author URI',
		'license'       => 'License',
		'license_uri'   => 'License URI',
		'text_domain'   => 'Text Domain',
		'domain_path'   => 'Domain Path',
		'domain_var'    => 'Domain Var',
		'network'       => 'Network',
	];
}
