<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Priority extension.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extensions\Priority;

use Backyard\Forms\Types\OptionsType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Priority extension class.
 */
class PriorityFormTypeExtension extends AbstractTypeExtension {

	/**
	 * Setup support for the priority config option.
	 *
	 * @param OptionsResolver $resolver
	 * @return void
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults(
			[
				'priority' => false,
			]
		);
	}

	/**
	 * Rearrange fields in the view by checking their priority option.
	 *
	 * @param FormView      $view
	 * @param FormInterface $form
	 * @param array         $options
	 * @return void
	 */
	public function finishView( FormView $view, FormInterface $form, array $options ) {

		$fields        = $view->children;
		$priorityList  = [];
		$orderedFields = [];

		foreach ( $fields as $key => $registeredField ) {
			$priority = $form->get( $key )->getConfig()->getOption( 'priority' );

			if ( $priority === false ) {
				$priority = array_search( $key, array_keys( $fields ), true );
			}

			$priorityList[ $key ] = $priority;
		}

		asort( $priorityList );

		foreach ( $priorityList as $fieldKey => $priorityValue ) {
			if ( $view->offsetExists( $fieldKey ) ) {
				$orderedFields[ $fieldKey ] = $view->offsetGet( $fieldKey );
				$view->offsetUnset( $fieldKey );
			}
		}

		$view->children = $orderedFields + $view->children;

		parent::finishView( $view, $form, $options );
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getExtendedTypes(): iterable {
		return [ FormType::class, OptionsType::class ];
	}

}
