<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Admin options form type.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Types;

use Backyard\Forms\OrderedForms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Admin options form type class.
 */
class OptionsType extends AbstractType {

	/**
	 * Inject fields that should always belong to the form.
	 *
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 * @return void
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ): void {
		$builder
			->add(
				'title',
				TextType::class,
				[
					'label' => 'Something here',
					'priority' => 1
				]
			);
	}

	public function getParent()
	{
		return FormType::class;
	}

}
