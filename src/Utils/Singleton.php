<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Singleton class
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Utils;

/**
 * Singleton class
 */
class Singleton {

	/**
	 * Object instances
	 *
	 * @var array
	 */
	protected static $instances = [];

	/**
	 * Constructor
	 */
	protected function __construct() {}

	/**
	 * Clone method
	 *
	 * @return void
	 */
	protected function __clone() {}

	/**
	 * Wakeup method
	 *
	 * @throws \Exception When used.
	 */
	public function __wakeup() {
		throw new \Exception( 'Cannot unserialize singleton' );
	}

	/**
	 * Gets the instance
	 *
	 * @return Singleton
	 */
	public static function get() {
		$class = get_called_class();
		$args  = func_get_args();

		if ( ! isset( self::$instances[ $class ] ) ) {
			self::$instances[ $class ] = new static( ...$args );
		}

		return self::$instances[ $class ];
	}

}
