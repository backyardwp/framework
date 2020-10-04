<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Admin notice markup
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Redirects;

use Backyard\Utils\Str;

/**
 * Admin notice markup generator.
 */
class AdminNotice {

	/**
	 * Display a dismissible notice.
	 *
	 * @param array $data
	 */
	public static function dismissible( $data ) {

		$classes = 'notice-' . $data['type'];
		if ( ! empty( $data ) ) {
			if ( Str::startsWith( $data['message'], '<' ) ) {
				$message = $data['message'];
			} else {
				$message = '<p>' . $data['message'] . '</p>';
			}
			?>
			<div class="notice backyard-admin-notice <?php echo esc_attr( $classes ); ?> is-dismissible">
				<?php echo wp_kses_post( $message ); ?>
			</div>
			<?php
		}
	}

	/**
	 *  Display a permanent notice
	 *
	 * @param array $data
	 */
	public static function permanent( $data ) {
		$classes = 'notice-' . $data['type'];
		if ( ! empty( $data ) ) {
			if ( Str::startsWith( $data['message'], '<' ) ) {
				$message = $data['message'];
			} else {
				$message = '<p>' . $data['message'] . '</p>';
			}
			?>
			<div class="notice backyard-admin-notice <?php echo esc_attr( $classes ); ?>">
				<?php echo wp_kses_post( $message ); ?>
			</div>
			<?php
		}
	}

}
