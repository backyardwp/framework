<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard view base class.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Views;

use Backyard\Application;
use Backyard\Contracts\ViewInterface;
use Backyard\Templates\Engine;

/**
 * View class used to render content of pages.
 */
abstract class View implements ViewInterface {

	/**
	 * Plugin templates engine instance.
	 *
	 * @var Engine
	 */
	protected $engine;

	/**
	 * Get the view started.
	 */
	public function __construct() {
		$plugin = ( Application::get() )->plugin;

		if ( $plugin->has( Engine::class ) ) {
			$this->setTemplatesEngine( $plugin->get( Engine::class ) );
		}
	}

	/**
	 * Setup the templates engine for use by the controller.
	 *
	 * @param Engine $engine
	 * @return View
	 */
	public function setTemplatesEngine( Engine $engine ) {
		$this->engine = $engine;

		return $this;
	}

	/**
	 * Get the plugin's template engine instance.
	 *
	 * @return Engine
	 */
	public function templates() {
		return $this->engine;
	}

	/**
	 * Render the view
	 *
	 * @return void
	 */
	abstract public function render();

}
