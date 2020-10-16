<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Symfony forms builder.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms;

use Backyard\Forms\Extension\NonceExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;

/**
 * Backyard framework forms builder powered by Symfony.
 */
class FormBuilder {

	/**
	 * @var \Symfony\Component\Form\FormFactoryBuilderInterface
	 */
	protected $formFactoryBuilder;

	/**
	 * Create a form.
	 *
	 * @param string $className Symfony form type class name.
	 * @param null   $data initial data of the form.
	 * @param array  $options form options.
	 * @return \Symfony\Component\Form\FormInterface
	 */
	public function create( $className = null, $data = null, $options = [] ) {
		$formType = FormType::class;

		if ( empty( $className ) ) {
			$className = $formType;
		}

		return $this->getFormFactory()->create( $className, $data, $options );
	}

	/**
	 * @return \Symfony\Component\Form\FormFactoryInterface
	 */
	public function getFormFactory() {
		return $this->getFormFactoryBuilder()->getFormFactory();
	}

	/**
	 * @return \Symfony\Component\Form\FormFactoryBuilderInterface
	 */
	public function getFormFactoryBuilder() {
		if ( ! $this->formFactoryBuilder ) {
			$this->formFactoryBuilder = Forms::createFormFactoryBuilder();
		}

		$validator = Validation::createValidatorBuilder()
			->getValidator();

		$this->formFactoryBuilder->addExtension( new HttpFoundationExtension() );
		$this->formFactoryBuilder->addExtension( new ValidatorExtension( $validator ) );
		$this->formFactoryBuilder->addExtension( new NonceExtension() );

		return $this->formFactoryBuilder;
	}

	/**
	 * Add an extension to the form builder.
	 *
	 * @param FormExtensionInterface $extension
	 * @return $this
	 */
	public function addExtension( FormExtensionInterface $extension ) {
		$this->getFormFactoryBuilder()->addExtension( $extension );

		return $this;
	}

	/**
	 * Add a type extension to the form builder.
	 *
	 * @param FormTypeExtensionInterface $typeExtension
	 * @return $this
	 */
	public function addTypeExtension( FormTypeExtensionInterface $typeExtension ) {
		$this->getFormFactoryBuilder()->addTypeExtension( $typeExtension );
		return $this;
	}
}
