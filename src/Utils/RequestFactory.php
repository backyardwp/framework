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

namespace Backyard\Utils;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

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
	 * @return Request HTTP request.
	 */
	public static function create() {
		$get    = stripslashes_deep( $_GET );
		$post   = stripslashes_deep( $_POST );
		$cookie = stripslashes_deep( $_COOKIE );
		$server = stripslashes_deep( $_SERVER );

		$request = new Request( $get, $post, array(), $cookie, $_FILES, $server );

		if ( $request->headers->has( 'CONTENT_TYPE' )
			&& 0 === strpos( $request->headers->get( 'CONTENT_TYPE' ), 'application/x-www-form-urlencoded' )
			&& in_array( strtoupper( $request->server->get( 'REQUEST_METHOD', 'GET' ) ), array( 'PUT', 'DELETE', 'PATCH' ) )
		) {
			parse_str( $request->getContent(), $data );
			$request->request = new ParameterBag( $data );
		}

		return $request;
	}
}
