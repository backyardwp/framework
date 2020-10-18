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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
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
			FormEvents::PRE_SUBMIT => 'preSubmit',
		];
	}

	/**
	 * Handle the nonce validation before submitting the form.
	 *
	 * @param FormEvent $event
	 * @return void
	 */
	public function preSubmit( FormEvent $event ) {

		$form   = $event->getForm();
		$data   = $form->getData();
		$fields = $form->all();

	}

	private function getFieldsDefinition( $fields ) {

		$definition = [];

		foreach ( $fields as $field ) {

		}

		return $definition;

	}

}
