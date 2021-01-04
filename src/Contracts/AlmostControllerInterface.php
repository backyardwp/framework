<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Controllers interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

use Backyard\AdminPages\MenuPage;
use Laminas\Diactoros\ServerRequest;

interface AlmostControllerInterface {

	/**
	 * Returns the request instance.
	 *
	 * @return ServerRequest HTTP request instance.
	 */
	public function getRequest();

	/**
	 * Sets the request instance.
	 *
	 * @param ServerRequest $request HTTP request instance.
	 *
	 * @return $this For chain calls.
	 */
	public function setRequest( ServerRequest $request );

	/**
	 * Get the user that is currently performing the request.
	 *
	 * @return \WP_User|bool false when no user is logged in.
	 */
	public function getCurrentUser();

	/**
	 * Sets the user instance of the user performing the request.
	 *
	 * @return $this For chain calls.
	 */
	public function setCurrentUser();

	/**
	 * Assign an admin menu page to the controller.
	 * Should only be used for controllers that handle admin pages.
	 *
	 * @param MenuPage $page
	 * @return $this For chain calls
	 */
	public function setMenuPage( MenuPage $page );

	/**
	 * Get the menu page assigned to the controller.
	 *
	 * @return MenuPage|bool false when no page is assigned.
	 */
	public function getMenuPage();

}
