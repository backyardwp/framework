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

/**
 * wp-admin menu page register.
 */
class MenuPage extends AbstractPage implements AdminMenuPageInterface {

	/**
	 * @var string Url to icon or short name of icon or base-64 icon.
	 */
	protected $icon;

	/**
	 * @var int Position in the menu.
	 */
	protected $position;

	/**
	 * @inheritdoc
	 */
	public function register() {
		$page = add_menu_page(
			$this->getPageTitle(),
			$this->getMenuTitle(),
			$this->getCapability(),
			$this->getMenuSlug(),
			array( $this, 'render' ),
			$this->getIcon(),
			$this->getPosition()
		);

		// All functions attached to actions runs in 2 scenarios:
		// 1. Particular settings page loaded (load-$page action).
		// 2. When page settings is saving (admin_action_update action)

		// Fully build the page object
		add_action( 'load-' . $page, array( $this, 'lateConstruct' ) );
		add_action( 'admin_action_update', array( $this, 'lateConstruct' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScriptStyles' ) );

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function unRegister() {
		$result = remove_menu_page( $this->getMenuSlug() );

		if ( ! $result ) {
			throw new \Exception();
		}

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getURL() {
		return add_query_arg(
			'page',
			$this->getMenuSlug(),
			admin_url( 'options-general.php' )
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @inheritdoc
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @inheritdoc
	 */
	public function setPosition( $position ) {
		$this->position = $position;
		return $this;
	}
}
