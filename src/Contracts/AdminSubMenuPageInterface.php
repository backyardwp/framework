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

interface AdminSubMenuPageInterface extends AdminPageInterface {

	/**
	 * Returns parent page.
	 *
	 * @return AdminMenuPageInterface Parent page.
	 */
	public function getParentPage();

	/**
	 * Sets parent page.
	 *
	 * @param AdminMenuPageInterface $page Parent page.
	 *
	 * @return $this For chain calls.
	 */
	public function setParentPage( AdminMenuPageInterface $page);

	/**
	 * Returns parent page slug.
	 *
	 * @return string Parent slug.
	 */
	public function getParentSlug();

	/**
	 * Sets parent page slug.
	 *
	 * @param string $slug Parent slug.
	 *
	 * @return $this For chain calls.
	 */
	public function setParentSlug( $slug);
}
