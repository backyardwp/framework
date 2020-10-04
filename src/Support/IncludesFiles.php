<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Automatically include files of a specified folder.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Support;

use Symfony\Component\Finder\Finder;

trait IncludesFiles {

	/**
	 * Automatically includes all .php files found on a specified
	 * directory path.
	 *
	 * @param string|array $path
	 * @param string       $pattern
	 *
	 * @return void
	 */
	public function includes( $path, string $pattern = '*.php' ) {
		foreach ( Finder::create()->files()->name( $pattern )->in( $path )->sortByName() as $file ) {
			/** @var \SplFileInfo $file */
			@include $file->getRealPath();
		}
	}
}
