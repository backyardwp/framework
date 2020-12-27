<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Menu page.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\AdminPages;

use Backyard\Contracts\AdminMenuPageInterface;
use Backyard\Contracts\AdminVirtualMenuPageInterface;

/**
 * wp-admin virtual page.
 */
class VirtualMenuPage extends MenuPage implements AdminVirtualMenuPageInterface {

	/**
	 * @var AdminMenuPageInterface Page instance which is used by this virtual page.
	 */
	protected $virtualPage;

	/**
	 * Returns virtual page.
	 *
	 * @return AdminMenuPageInterface Page instance.
	 */
	public function getVirtualPage() {
		return $this->virtualPage;
	}

	/**
	 * Sets virtual page.
	 *
	 * @param AdminMenuPageInterface $page Page instance.
	 *
	 * @return $this For chain calls.
	 */
	public function setVirtualPage( AdminMenuPageInterface $page ) {
		$this->virtualPage = $page;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function render() {
		$this->getVirtualPage()->render();
	}

	/**
	 * @inheritdoc
	 */
	public function lateConstruct() {
		$this->getVirtualPage()->lateConstruct();
		return $this;
	}

}
