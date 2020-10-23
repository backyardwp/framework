<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Add sanitization event to the form.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extensions\Sanitizer;

use Backyard\Application;
use Backyard\Sanitizer\Sanitizer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Sanitize fields of the form.
 */
class SanitizerListener implements EventSubscriberInterface {

	/**
	 * Setup the list of events for the form.
	 *
	 * @return array
	 */
	public static function getSubscribedEvents() {
		return [
			FormEvents::SUBMIT => 'onSubmission',
		];
	}

	/**
	 * Handle sanitization when the form is submitted.
	 *
	 * @param FormEvent $event
	 * @return void
	 */
	public function onSubmission( FormEvent $event ) {

		$form = $event->getForm();

		if ( $form->isRoot() ) {
			$data        = $event->getData();
			$fields      = $form->all();
			$definitions = $this->getFieldsDefinition( $fields );

			$sanitized = ( new Sanitizer( $data, $definitions ) )->sanitize();

			$event->setData( $sanitized );
		}

	}

	/**
	 * Get the sanitization definitions for fields based on their type.
	 *
	 * @param array $fields
	 * @return array
	 */
	private function getFieldsDefinition( $fields ) {

		$definition = [];

		foreach ( $fields as $field ) {

			$type = $field->getConfig()->getType()->getInnerType();

			switch ( $type ) {
				case TextType::class:
					$definition[ $field->getName() ] = [ 'sanitize_text_field' ];
					break;
				default:
					$definition[ $field->getName() ] = [ 'sanitize_text_field' ];
					break;
			}
		}

		return $definition;

	}

}
