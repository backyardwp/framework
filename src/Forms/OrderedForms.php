<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Allows ordering of form fields.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait OrderedForms {

	/**
	 * Setup form sanitization enabled by default.
	 *
	 * @param OptionsResolver $resolver
	 * @return void
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults(
			[
				'priority' => true,
			]
		);
	}

	public function finishView( FormView $view, FormInterface $form, array $options ) {

		$definedFields = $view->children;

		foreach ( $definedFields as $key => $field ) {

			$field = $view->offsetGet( $key );

			var_dump( $field );

		}

		parent::finishView( $view, $form, $options );

	}

}
