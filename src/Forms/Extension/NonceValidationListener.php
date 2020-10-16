<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Add nonces validation when submitting forms.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Extension;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Backyard\Nonces\Nonce;

/**
 * Handles validation of nonces when submitting forms.
 */
class NonceValidationListener implements EventSubscriberInterface {

	/**
	 * Nonce instance.
	 *
	 * @var Nonce
	 */
	protected $nonce;

	/**
	 * Get things started.
	 *
	 * @param Nonce $nonce nonce instance
	 */
	public function __construct( Nonce $nonce ) {
		$this->nonce = $nonce;
	}

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
		$form = $event->getForm();

		$form->addError( new FormError( 'Nonce error' ) );
	}

}
