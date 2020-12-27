<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Toplevel menu page interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

interface AdminMenuPageInterface extends AdminPageInterface {

	/**
	 * Returns the page icon.
	 *
	 * @return string Page icon name or base-64 encoded.
	 */
	public function getIcon();

	/**
	 * Sets the page icon.
	 *
	 * @param string $icon Page icon.
	 *
	 * @return $this For chain calls.
	 */
	public function setIcon( $icon);

	/**
	 * Returns the page position.
	 *
	 * @return int Page position.
	 */
	public function getPosition();

	/**
	 * Sets the page position.
	 *
	 * @param int $position Page position.
	 *
	 * @return $this For chain calls.
	 */
	public function setPosition( $position);
}
