<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Closure sanitization rule class.
 *
 * @package   backyard-framwork
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Sanitizer;

use Backyard\Contracts\ValidationRuleInterface as RuleContract;

/**
 * Sanitization rule as a closure.
 */
class ClosureSanitizationRule implements RuleContract {

	/**
	 * The callback that validates the attribute.
	 *
	 * @var \Closure
	 */
	public $callback;

	/**
	 * Indicates if the validation callback failed.
	 *
	 * @var bool
	 */
	public $failed = false;

	/**
	 * The validation error message.
	 *
	 * @var string|null
	 */
	public $message;

	/**
	 * Create a new Closure based validation rule.
	 *
	 * @param  \Closure $callback
	 * @return void
	 */
	public function __construct( $callback ) {
		$this->callback = $callback;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes( $attribute, $value ) {
		$this->failed = false;

		$this->callback->__invoke(
			$attribute,
			$value,
			function ( $message ) {
				$this->failed = true;

				$this->message = $message;
			}
		);

		return ! $this->failed;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return $this->message;
	}
}
