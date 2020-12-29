<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Definition of the public contract to be available on a controller instance.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

interface RenderableAdminPageControllerInterface {

	/**
	 * Render the content of the page in the admin panel.
	 *
	 * @param AdminPageInterface $adminPage
	 * @return void
	 */
	public function render( AdminPageInterface $adminPage );

}
