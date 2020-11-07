<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Admin options form type.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * Admin options form type class.
 */
class OptionsType extends AbstractType {

	public function getParent() {
		return FormType::class;
	}

}
