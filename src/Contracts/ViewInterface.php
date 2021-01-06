<?php // phpcs:ignore WordPress.Files.FileName
/**
 * View class interface.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Contracts;

use Backyard\Templates\Engine;

interface ViewInterface {

	public function setTemplatesEngine( Engine $engine );

	public function templates();

	public function render();

}
