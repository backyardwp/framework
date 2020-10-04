<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Redirects helper.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Redirects;

use Backyard\Cache\Transient;

/**
 * Redirects helper.
 */
class Redirect {

	/**
	 * URL to redirect to.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * Plugin prefix label used for transient naming.
	 *
	 * @var string
	 */
	protected $cachePrefix;

	/**
	 * Get redirects started
	 *
	 * @param string $prefix plugin prefix
	 */
	public function __construct( $prefix ) {
		$this->cachePrefix = $prefix;
	}

	/**
	 * Get the cache prefix string.
	 *
	 * @return string
	 */
	public function getCachePrefix() {
		return $this->cachePrefix;
	}

	/**
	 * Redirect to an url.
	 *
	 * @param string $url url
	 * @return Redirect $this
	 */
	public function toUrl( $url ) {
		$this->url = esc_url_raw( $url );

		return $this;
	}

	/**
	 * Get the url of the redirect.
	 *
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Redirect back to referrer. Must be the same host.
	 *
	 * @return Redirect $this
	 */
	public function back() {
		$ref       = $_SERVER['HTTP_REFERER']; //phpcs:ignore
		$scheme    = is_ssl() ? 'https' : 'http';
		$same_host = home_url( '/', $scheme );
		if ( substr( $ref, 0, strlen( $same_host ) ) === $same_host ) {
			$this->url = $ref;
		} else {
			$this->url = home_url( '/', $scheme );
		}

		return $this;
	}

	/**
	 * Execute a redirect that displays an admin notice.
	 *
	 * @param string $message the content of the message.
	 * @param string $type type of message.
	 * @return Redirect $this
	 */
	public function withNotice( $message, $type = 'success' ) {

		Transient::remember(
			"{$this->getCachePrefix()}_admin_notice",
			function() use ( $type, $message ) {
				return [
					'type'    => $type,
					'message' => $message,
				];
			},
			MINUTE_IN_SECONDS
		);

		return $this;

	}

	/**
	 * Execute the redirect.
	 *
	 * @return void
	 */
	public function now() {
		wp_redirect( $this->url );
		exit();
	}
}
