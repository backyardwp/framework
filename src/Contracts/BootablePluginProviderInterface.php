<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Bootable plugin provider interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

use League\Container\ServiceProvider\ServiceProviderInterface;

interface BootablePluginProviderInterface extends ServiceProviderInterface {

	/**
	 * Method will be invoked when the plugin container runs the "boot" method
	 * to hook itself to the plugins_loaded WP Hook.
	 *
	 * @return void
	 */
	public function bootPlugin();
}
