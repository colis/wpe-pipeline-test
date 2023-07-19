<?php
/**
 * Wagner Spray Tech Digital River Sync Admin Form.
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Admin
 */

namespace WagnerSprayTechDigitalRiverIntegration\Admin;

use WagnerSprayTechCore\BaseAbstract;

/**
 * Digital River Sync Admin Forms.
 */
class Form extends BaseAbstract {

	/**
	 * Render a form.
	 *
	 * @param string $settings_name The name of the settings group.
	 * @param string $text Form description text.
	 * @param string $submit_button_text The text to display on the submit button.
	 * @param string $action Optional form action.
	 * @param array  $form_fields Optional extra form fields.
	 * @param string $method Optional form method.
	 * @param string $class_name Optional extra class name to add to the form.
	 * @param string $extra_content Optional extra content to add to the form.
	 *
	 * @return void
	 */
	public function render( string $settings_name = '', string $text = '', string $submit_button_text = '', string $action = '', array $form_fields = [], string $method = 'get', string $class_name = 'form', string $extra_content = '' ): void {

		echo sprintf( '<form method="%s" action="%s" class="%s">', $method, esc_url( $action ), esc_attr( $class_name ) ); // phpcs:ignore
		echo sprintf( '<p>%s</p>', esc_html( $text ) ); // Form description text.
		if ( ! empty( $settings_name ) ) {
			echo sprintf( '<input type="hidden" name="action" value="%s">', esc_attr( $settings_name ) ); // Form action.
		}
		echo $this->get_form_fields( $form_fields ); // phpcs:ignore
		wp_nonce_field( $settings_name . '_nonce', $settings_name . '_nonce' ); // Form nonce.

		if ( ! empty( $submit_button_text ) ) {
			submit_button( $submit_button_text );
		}

		echo wp_kses_post( $extra_content );
		echo '</form>';
	}

	/**
	 * Generate form fields.
	 *
	 * @param array $form_fields Form fields array ['name'=> 'name', 'type'=>'type', 'label' => 'table', 'tag' => 'input', 'options'=> ['key' => 'value'], 'placeholder' => 'placeholder', 'default_value' => 'default_value' ].
	 *
	 * @return string
	 */
	private function get_form_fields( array $form_fields ): string {

		$rtn = [];

		if ( empty( $form_fields ) ) {
			return '';
		}

		foreach ( $form_fields as $field ) {

			$rtn[] = $this->get_form_field(
				name: $field['name'] ?? uniqid( '', true ),
				type: $field['type'] ?? 'text',
				label: $field['label'] ?? '',
				tag: $field['tag'] ?? 'input',
				options: $field['options'] ?? [],
				placeholder: $field['placeholder'] ?? '',
				default_value: $field['default_value'] ?? ''
			);

		}

		return implode( PHP_EOL, $rtn );
	}


	/**
	 * Create a form field.
	 *
	 * @param string $name Field name.
	 * @param string $type Field type.
	 * @param string $label Field label.
	 * @param string $tag Field tag.
	 * @param array  $options Field options.
	 * @param string $placeholder Field placeholder.

	 * @param string $default_value Field default value.
	 *
	 * @return string
	 */
	private function get_form_field( string $name, string $type, string $label = '', string $tag = 'input', array $options = [], string $placeholder = '', string $default_value = '' ): string {

		$rtn   = [];
		$rtn[] = '<div>';

		if ( ! empty( $label ) ) {
			$rtn[] = '<label for="' . sanitize_title( $name ) . '">' . esc_html( $label ) . '</label>';
		}

		$rtn[] = '<' . $tag . ' ';
		$rtn[] = 'id="' . sanitize_title( $name ) . '" ';
		$rtn[] = 'name="' . sanitize_title( $name ) . '" ';
		$rtn[] = 'type="' . esc_attr( $type ) . '" ';
		if ( ! empty( $placeholder ) ) {
			$rtn[] = 'placeholder="' . esc_attr( $placeholder ) . '" ';
		}
		if ( ! empty( $default_value ) ) {
			$rtn[] = 'value="' . esc_attr( $default_value ) . '" ';
		}
		$rtn[] = '>';

		if ( ! empty( $options ) ) {
			foreach ( $options as $key => $value ) {
				$rtn[] = '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
			}
			$rtn[] = '</' . $tag . '>';
		}

		$rtn[] = '</div>';

		return implode( '', $rtn );
	}
}
