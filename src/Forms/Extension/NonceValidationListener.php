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
use Backyard\Nonces\NonceFactory;

/**
 * Handles validation of nonces when submitting forms.
 */
class NonceValidationListener implements EventSubscriberInterface {

	/**
	 * Nonce instance.
	 *
	 * @var Nonce
	 */
	protected $nonceSlug;

	/**
	 * Get things started.
	 *
	 * @param string $nonceSlug nonce slug.
	 */
	public function __construct( string $nonceSlug ) {
		$this->nonceSlug = $nonceSlug;
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

		$form         = $event->getForm();
		$config       = $form->getConfig();
		$errorMessage = $config->hasOption( 'nonce_message' ) ? $config->getOption( 'nonce_message' ) : 'Something went wrong, nonce validation has failed. Please try again.';

		if ( ! NonceFactory::verify( $this->nonceSlug ) ) {
			$form->addError( new FormError( $errorMessage ) );
		}
	}

}
