<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard admin form class.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms;

/**
 * Handles forms generally used in admin screens.
 * This form is processed via the admin_init hook.
 */
abstract class AdminForm extends Form {

	/**
	 * @inheritdoc
	 */
	const HOOK = 'admin_init';

}
