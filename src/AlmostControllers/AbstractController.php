<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Base almost controller.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\AlmostControllers;

use Backyard\Application;
use Backyard\Contracts\AlmostControllerInterface;
use Backyard\Templates\Engine;
use Backyard\Utils\RequestFactory;
use Laminas\Diactoros\ServerRequest;
use Backyard\Forms\Form;
use Backyard\AdminPages\MenuPage;

/**
 * Base class to be extended for each "Almost" controller.
 */
abstract class AbstractController implements AlmostControllerInterface {

	/**
	 * HTTP Requet instance.
	 *
	 * @var ServerRequest
	 */
	protected $request;

	/**
	 * Currently logged in user performing the request.
	 * Returns false when the user is not logged in.
	 *
	 * @var \WP_User|boolean
	 */
	protected $user;

	/**
	 * Plugin templates engine instance.
	 *
	 * @var Engine
	 */
	protected $templates;

	/**
	 * Form assigned to the controller.
	 *
	 * @var Form
	 */
	protected $form;

	/**
	 * Optional admin menu page assigned to the controller.
	 * Admin pages should only be assigned when the controller
	 * is used to manage admin pages.
	 *
	 * @var MenuPage
	 */
	protected $menuPage;

	/**
	 * Setup the controller.
	 */
	public function __construct() {
		$this->setCurrentUser();
		$this->setRequest( RequestFactory::create() );

		$plugin = ( Application::get() )->plugin;

		if ( $plugin->has( Engine::class ) ) {
			$this->setTemplatesEngine( $plugin->get( Engine::class ) );
		}
	}

	/**
	 * Sets the request instance.
	 *
	 * @param ServerRequest $request HTTP request instance.
	 * @return $this For chain calls.
	 */
	public function setRequest( ServerRequest $request ) {
		$this->request = $request;

		return $this;
	}

	/**
	 * Returns the request instance.
	 *
	 * @return ServerRequest HTTP request instance.
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Sets the user currently performing the request.
	 *
	 * @return $this For chain calls.
	 */
	public function setCurrentUser() {
		if ( is_user_logged_in() ) {
			$this->user = wp_get_current_user();
		} else {
			$this->user = false;
		}

		return $this;
	}

	/**
	 * Get the user that is currently performing the request.
	 *
	 * @return \WP_User|bool false when no user is logged in.
	 */
	public function getCurrentUser() {
		return $this->user;
	}

	/**
	 * Setup the templates engine for use by the controller.
	 *
	 * @param Engine $engine
	 * @return $this for chain calls.
	 */
	protected function setTemplatesEngine( Engine $engine ) {
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
	 * Assign an admin menu page to the controller.
	 * Should only be used for controllers that handle admin pages.
	 *
	 * @param MenuPage $page
	 * @return $this For chain calls
	 */
	public function setMenuPage( MenuPage $page ) {
		$this->menuPage = $page;

		return $this;
	}

	/**
	 * Get the menu page assigned to the controller.
	 *
	 * @return MenuPage false when no page is assigned.
	 */
	public function getMenuPage() {
		return $this->menuPage;
	}

	/**
	 * Assign a form to the controller.
	 *
	 * @param string $formClass form class path
	 * @param string $formName optional form name argument used when instantiating the form.
	 * @return $this For chain calls.
	 */
	public function setForm( string $formClass, $formName = false ) {
		if ( $formName ) {
			$this->form = new $formClass( $formName );
		} elseif ( $this->getMenuPage() instanceof MenuPage ) {
			$this->form = new $formClass( $this->getMenuPage()->getMenuSlug() );
		} else {
			$this->form = new $formClass();
		}

		return $this;
	}

	/**
	 * Get the form assigned to the controller.
	 *
	 * @return Form
	 */
	public function getForm() {
		return $this->form;
	}
}
