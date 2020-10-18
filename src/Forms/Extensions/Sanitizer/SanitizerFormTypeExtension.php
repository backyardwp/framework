<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Sanitizer form type.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extensions\Sanitizer;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Sanitizer form extension.
 */
class SanitizerFormTypeExtension extends AbstractTypeExtension {

	/**
	 * Register the sanitization event for the form.
	 *
	 * @param FormBuilderInterface $builder form instance.
	 * @param array                $options options set for the form.
	 * @return void
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		if ( $options['sanitizer'] === false ) {
			return;
		}

		$builder->addEventSubscriber( new SanitizerListener() );

	}

	/**
	 * Setup form sanitization enabled by default.
	 *
	 * @param OptionsResolver $resolver
	 * @return void
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults(
			[
				'sanitizer' => true,
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getExtendedTypes(): iterable {
		return [ FormType::class ];
	}

}
