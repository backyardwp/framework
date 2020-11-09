<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Tabs extension.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extensions\Tabs;

use Backyard\Forms\Fields\FieldsetType;
use Backyard\Forms\Types\OptionsType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Tabs form extension.
 */
class TabsFormTypeExtension extends AbstractTypeExtension {

	public $tabs = [];

	public function buildView( FormView $view, FormInterface $form, array $options ) {

		$fieldsets          = $form->all();
		$view->vars['tabs'] = [];

		foreach ( $fieldsets as $key => $field ) {
			$type = $field->getConfig()->getType()->getInnerType();

			if ( ! $type instanceof FieldsetType ) {
				continue;
			}

			$this->tabs[ $key ] = $field->getConfig()->getOption( 'label' );
		}

		if ( ! empty( $this->tabs ) ) {
			$view->vars['tabs'] = $this->tabs;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getExtendedTypes(): iterable {
		return [ FormType::class, OptionsType::class ];
	}

}
