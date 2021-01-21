<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Displays navigation tabs using the wp-admin markup.
 *
 * @version   1.0.0
 * @package   backyard-framwork
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

use Backyard\Utils\DomAttributes;
use Backyard\Requests\RequestFactory;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/** @var \Backyard\Forms\Form $form */
if ( ! $form->hasTabs() ) {
	return;
}

$formTabs  = $form->getTabs();
$activeTab = $form->getActiveTab();
$request   = RequestFactory::create();

?>
<nav class="nav-tab-wrapper wp-clearfix">
	<?php foreach ( $formTabs as $key => $formTab ) : ?>
		<?php
			$linkAttributes = ( new DomAttributes() )->add(
				'admin-form-tab',
				[
					'href'  => esc_url( add_query_arg( [ 'tab' => esc_attr( $key ) ], $request->getUri()->__toString() ) ),
					'class' => $activeTab === $key ? 'nav-tab nav-tab-active' : 'nav-tab',
				]
			);
		?>
		<a <?php echo $linkAttributes->render( 'admin-form-tab' ); //phpcs:ignore ?>><?php echo esc_html( $formTab['label'] ); ?></a>
	<?php endforeach; ?>
</nav>
