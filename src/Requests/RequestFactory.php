<?php // phpcs:ignore WordPress.Files.FileName
/**
 * HTTP Requests factory.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Requests;

use Backyard\Utils\ParameterBag;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;

/**
 * HTTP Request instance.
 */
class RequestFactory {
	/**
	 * Returns HTTP request instance.
	 *
	 * @see wp_magic_quotes
	 * @see stripslashes_deep
	 *
	 * @return ServerRequest HTTP request.
	 */
	public static function create() {

		// Not processing anything here.
		$get    = stripslashes_deep( $_GET ); //phpcs:ignore
		$post   = stripslashes_deep( $_POST ); //phpcs:ignore
		$cookie = stripslashes_deep( $_COOKIE );
		$server = stripslashes_deep( $_SERVER );
		$files  = stripslashes_deep( $_FILES );

		$request = ServerRequestFactory::fromGlobals(
			$server,
			$get,
			$post,
			$cookie,
			$files
		);

		return $request;
	}

	/**
	 * Get $_POST data through a parameters bag.
	 *
	 * @param boolean|ServerRequest $request
	 * @return ParameterBag
	 */
	public static function getPostedData( $request = false ) {

		if ( ! $request instanceof ServerRequest ) {
			$request = self::create();
		}

		return new ParameterBag( $request->getParsedBody() );

	}

	/**
	 * Get $_GET data through a parameters bag.
	 *
	 * @param boolean|ServerRequest $request
	 * @return ParameterBag
	 */
	public static function getQueryParams( $request = false ) {

		if ( ! $request instanceof ServerRequest ) {
			$request = self::create();
		}

		return new ParameterBag( $request->getQueryParams() );

	}

}
