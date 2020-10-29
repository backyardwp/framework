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

use Backyard\Utils\Sanitizer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
			$data   = $event->getData();
			$fields = $form->all();

			$event->setData( $this->sanitizeData( $data, $fields ) );
		}

	}

	/**
	 * Generate the sanitized array of submitted data.
	 *
	 * @param array $data data of the form
	 * @param array $fields fields list
	 * @return array
	 */
	private function sanitizeData( $data, $fields ) {

		$sanitized = [];

		if ( ! is_array( $data ) ) {
			return $sanitized;
		}

		foreach ( $fields as $field ) {

			if ( ! array_key_exists( $field->getName(), $data ) ) {
				continue;
			}

			$type   = $field->getConfig()->getType()->getInnerType();
			$config = $field->getConfig();

			if ( $config->hasOption( 'sanitizer' ) && $config->getOption( 'sanitizer' ) === false ) {
				$sanitized[ $field->getName() ] = $data[ $field->getName() ];
			} else {
				switch ( $type ) {
					case TextareaType::class:
						$sanitized[ $field->getName() ] = Sanitizer::cleanTextarea( $data[ $field->getName() ] );
						break;
					default:
						$sanitized[ $field->getName() ] = Sanitizer::clean( $data[ $field->getName() ] );
						break;
				}
			}
		}

		return $sanitized;

	}

}
