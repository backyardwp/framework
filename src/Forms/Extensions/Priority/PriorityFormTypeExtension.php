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
				'priority' => 1,
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getExtendedTypes(): iterable {
		return [ FormType::class, OptionsType::class ];
	}

}
