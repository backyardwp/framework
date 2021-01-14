<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Uses tables to render forms. This is usually used within the admin panel.
 *
 * @package   backyard-framework
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Forms\Renderers;

use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Tel;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Url;

/**
 * Tabled forms layout for admin pages.
 */
class TableFormLayout extends CustomFormRenderer {

	/**
	 * Automatically add classes to some field types.
	 * Add special classes when the form has validation errors.
	 *
	 * @return void
	 */
	private function setupClasses() {

		foreach ( $this->form as $field ) {

			$classes = $field->getAttribute( 'class' );

			$classes .= ' bk-input';

			if ( $field instanceof Submit ) {
				$classes .= ' button button-primary';
			}

			if (
				$field instanceof Text ||
				$field instanceof Email ||
				$field instanceof Password ||
				$field instanceof Tel ||
				$field instanceof Url
			) {
				$classes .= ' regular-text';
			}

			if ( ! empty( $field->getMessages() ) ) {
				$classes .= ' invalid-input';
			}

			$field->setAttribute( 'class', trim( $classes ) );
		}

		// Add a class when the form has validation errors.
		if ( ! empty( $this->form->getMessages() ) ) {
			$this->form->setAttribute( 'class', 'invalid-form' );
		}
	}

	/**
	 * Render a tabled form.
	 *
	 * @return string
	 */
	public function render() {

		$templates = $this->getTemplatesEngine();

		$this->setupClasses();

		return $templates->render( 'vendor::forms/table-layout', [ 'form' => $this->form ] );

	}

}
