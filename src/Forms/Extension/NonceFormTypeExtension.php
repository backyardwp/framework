<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Nonce form type.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Nonce form type class.
 */
class NonceFormTypeExtension extends AbstractTypeExtension {

	/**
	 * Register the nonce verification event when enabled.
	 *
	 * @param FormBuilderInterface $builder form instance.
	 * @param array                $options options set for the form.
	 * @return void
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		if ( ! $options['nonce'] ) {
			return;
		}

		$builder->addEventSubscriber( new NonceValidationListener( $options['nonce'] ) );
	}

	/**
	 * Setup nonce validation as disabled by default.
	 *
	 * @param OptionsResolver $resolver
	 * @return void
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults(
			[
				'nonce' => false,
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
