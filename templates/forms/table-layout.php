<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Displays forms through a table layout.
 *
 * @version   1.0.0
 * @package   backyard-framwork
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

use Backyard\Forms\Elements\Nonce;
use Backyard\Utils\DomAttributes;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Submit;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$submitButton = false;

$activeTab = $form->getActiveTab();

?>

<div class="backyard-form table-layout">

	<?php $this->insert( 'admin-nav-tabs', [ 'form' => $form ] ); ?>

	<?php echo $form->getRenderer()->form()->openTag( $form ); //phpcs:ignore ?>

	<table class="form-table" role="presentation">

		<?php foreach ( $form as $field ) : ?>

			<?php
			if ( $field instanceof Submit ) {
				$submitButton = $field;
				continue;
			}

			$rowAttributes = ( new DomAttributes() )->add(
				'form-row',
				[
					'class' => ( $field instanceof Hidden || $field instanceof Nonce ) ? 'bk-hidden' : false,
				]
			);

			?>

			<tr <?php echo $rowAttributes->render( 'form-row' ); //phpcs:ignore ?>>
				<?php if ( ! empty( $field->getLabel() ) ) : ?>
					<th scope="row">
						<?php echo wp_kses_post( $form->getRenderer()->formLabel( $field ) ); ?>
					</th>
				<?php endif; ?>
				<td>
					<?php echo $form->getRenderer()->formElement( $field ); //phpcs:ignore ?>

					<?php if ( ! empty( $field->getOption( 'hint' ) ) ) : ?>
						<?php if ( $field instanceof Checkbox ) : ?>
							<span class="description">
								<?php echo wp_kses_post( $field->getOption( 'hint' ) ); ?>
							</span>
						<?php else : ?>
							<p class="description">
								<?php echo wp_kses_post( $field->getOption( 'hint' ) ); ?>
							</p>
						<?php endif; ?>
					<?php endif; ?>

					<?php echo $form->getRenderer()->formElementErrors( $field, [ 'class' => 'bk-input-errors notice notice-error notice-alt' ] ); //phpcs:ignore ?>

				</td>
			</tr>
		<?php endforeach; ?>

	</table>

	<?php if ( $submitButton ) : ?>
		<p class="submit">
			<?php echo $form->getRenderer()->formInput( $submitButton ); //phpcs:ignore ?>
		</p>
	<?php endif; ?>

	<?php echo $form->getRenderer()->form()->closeTag( $form ); //phpcs:ignore ?>

</div>
