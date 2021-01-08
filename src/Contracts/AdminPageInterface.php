<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Admin page interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

use Backyard\Contracts\ViewInterface;

/**
 * Interface PageInterface represents single admin page in WordPress.
 *
 * Use this interface to create your page or use predefined classes which implements
 * this interface.
 */
interface AdminPageInterface {

	/**
	 * Returns name of the page.
	 *
	 * @return string Name of the page.
	 */
	public function getName();

	/**
	 * Sets name of the page.
	 *
	 * @param string $name Name of the page.
	 *
	 * @return $this For chain calls.
	 */
	public function setName( $name );

	/**
	 * Returns the page title.
	 *
	 * @return string Title of the page.
	 */
	public function getPageTitle();

	/**
	 * Setups the page title.
	 *
	 * @param string $title Title of the page.
	 *
	 * @return $this For chain calls.
	 */
	public function setPageTitle( $title);

	/**
	 * Returns the menu page title.
	 *
	 * Used as label (title) in WordPress aside menu.
	 *
	 * @return string Menu title of the page.
	 */
	public function getMenuTitle();

	/**
	 * Sets the menu page title.
	 *
	 * @param string $title Menu title of the page.
	 *
	 * @return $this For chain calls.
	 */
	public function setMenuTitle( $title);

	/**
	 * Returns capability needed to access to the page.
	 *
	 * @return string Capability.
	 */
	public function getCapability();

	/**
	 * Sets capability needed to access to the page.
	 *
	 * @param string $capability WordPress capability.
	 *
	 * @return $this For chain calls.
	 */
	public function setCapability( $capability);

	/**
	 * Returns page menu slug.
	 *
	 * Used in URL.
	 *
	 * @return string Menu slug.
	 */
	public function getMenuSlug();

	/**
	 * Sets page menu slug.
	 *
	 * @param string $menuSlug Menu slug.
	 *
	 * @return $this For chain calls.
	 */
	public function setMenuSlug( $menuSlug);

	/**
	 * Register the page in WordPress Pages-Settings API.
	 *
	 * After calling this method the page available in WordPress.
	 *
	 * @return $this For chain calls.
	 */
	public function register();

	/**
	 * Un register the page in WordPress Pages-Settings API.
	 *
	 * @throws \Exception If page not removed (WordPress not found this page as registered page).
	 *
	 * @return $this For chain calls.
	 */
	public function unRegister();

	/**
	 * Returns the page url.
	 *
	 * @return string The page url.
	 */
	public function getURL();

	/**
	 * Attach a view to the page.
	 *
	 * @param string $viewClass
	 * @return $this for chain call.
	 */
	public function attachView( string $viewClass );

	/**
	 * Get the View instance attached to the page.
	 *
	 * @return ViewInterface
	 */
	public function getView();

}
