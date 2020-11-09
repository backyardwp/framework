<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Custom field type.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Fields;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldsetType extends AbstractType {

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver
			->setDefaults(
				[
					'legend'       => '',
					'inherit_data' => true,
					'options'      => array(),
					'fields'       => array(),
					'label'        => false,
				]
			)
			->addAllowedTypes( 'fields', [ 'array', 'callable' ] );
	}

	public function buildForm( FormBuilderInterface $builder, array $options ) {
		if ( ! empty( $options['fields'] ) ) {
			if ( is_callable( $options['fields'] ) ) {
				$options['fields']($builder);
			} elseif ( is_array( $options['fields'] ) ) {
				foreach ( $options['fields'] as $field ) {
					$builder->add( $field['name'], $field['type'], $field['attr'] );
				}
			}
		}
	}

	public function buildView( FormView $view, FormInterface $form, array $options ) {
		if ( false !== $options['legend'] ) {
			$view->vars['legend'] = $options['legend'];
		}
	}

	public function getName() {
		return 'fieldset';
	}

	public function getParent() {
		return FormType::class;
	}

}
