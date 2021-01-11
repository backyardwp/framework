<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Assets enqueue page interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

/**
 * Interface EnqueueAssetsInterface represents a page/resource
 * that has enqueueable assets.
 */
interface EnqueueAssetsInterface {

	/**
	 * Register and/or enqueue assets.
	 *
	 * @return void
	 */
	public function enqueueAssets();

}
