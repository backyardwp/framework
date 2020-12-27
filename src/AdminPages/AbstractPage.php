<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Admin pages creator.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\AdminPages;

use Backyard\Contracts\AdminPageInterface;

/**
 * Base definition of wp-admin menu page.
 */
abstract class AbstractPage implements AdminPageInterface {

	/**
	 * @var string Page name.
	 */
	protected $name;

	/**
	 * @var string Page title.
	 */
	protected $pageTitle;

	/**
	 * @var string Page menu title.
	 */
	protected $menuTitle;

	/**
	 * @var string Capability to access to the page.
	 */
	protected $capability;

	/**
	 * @var string Page menu slug.
	 */
	protected $menuSlug;

	/**
	 * @inheritdoc
	 */
	public function lateConstruct() {
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @inheritdoc
	 */
	public function setName( $name ) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getPageTitle() {
		return $this->pageTitle;
	}

	/**
	 * @inheritdoc
	 */
	public function setPageTitle( $title ) {
		$this->pageTitle = $title;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getMenuTitle() {
		return $this->menuTitle;
	}

	/**
	 * @inheritdoc
	 */
	public function setMenuTitle( $title ) {
		$this->menuTitle = $title;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getCapability() {
		return $this->capability;
	}

	/**
	 * @inheritdoc
	 */
	public function setCapability( $cap ) {
		$this->capability = $cap;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getMenuSlug() {
		return $this->menuSlug;
	}

	/**
	 * @inheritdoc
	 */
	public function setMenuSlug( $menuSlug ) {
		$this->menuSlug = $menuSlug;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function render() {
		$this->getView()->render( $this );
	}

	/**
	 * Method for enqueuing required JS and CSS files.
	 *
	 * @return void
	 */
	public function enqueueScriptStyles() {
	}

}
