<?php
namespace NYforms;
defined( 'ABSPATH' ) || exit;
class Renderer {
	public function render( $form_id, $args = array() ) {
		$form = Plugin::instance()->repository->form( absint( $form_id ) );
		if ( ! $form || 'active' !== $form['status'] ) { return current_user_can( 'nyforms_manage_forms' ) ? '<p>' . esc_html__( 'NYforms form unavailable.', 'nyforms' ) . '</p>' : ''; }
		$definition = $form['definition'];
		$resume_values = $this->resume_values( $form );
		$submitted = isset( $_GET['nyforms_submitted'] ) && absint( $_GET['nyforms_submitted'] ) === (int) $form['id'];
		if ( $submitted ) {
			$confirmation = $this->submitted_message( $form );
			return '<div class="nyforms-confirmation" role="status">' . wp_kses_post( $confirmation ) . '</div>';
		}
		$errors = isset( $_GET['nyforms_errors'] ) ? get_transient( 'nyforms_errors_' . sanitize_key( $_GET['nyforms_errors'] ) ) : array();
		if ( isset( $_GET['nyforms_errors'] ) ) { delete_transient( 'nyforms_errors_' . sanitize_key( $_GET['nyforms_errors'] ) ); }
		wp_enqueue_style( 'nyforms-frontend' );
		wp_enqueue_script( 'nyforms-frontend' );
		ob_start();
		?><form class="nyforms-form <?php echo esc_attr( $definition['css_class'] ); ?>" method="post" enctype="multipart/form-data" novalidate>
			<input type="hidden" name="nyforms_action" value="submit"><input type="hidden" name="nyforms_form_id" value="<?php echo esc_attr( $form['id'] ); ?>"><input type="hidden" name="nyforms_token" value="<?php echo esc_attr( wp_create_nonce( 'nyforms_submit_' . $form['id'] ) ); ?>">
			<?php if ( ! empty( $definition['honeypot'] ) || ! empty( $definition['settings']['honeypot'] ) ) : ?><p class="nyforms-honeypot" aria-hidden="true"><label><?php esc_html_e( 'Leave this field empty', 'nyforms' ); ?><input type="text" name="nyforms_website" tabindex="-1" autocomplete="off"></label></p><?php endif; ?>
			<?php if ( ! empty( $errors['form'] ) ) : ?><div class="nyforms-error" role="alert"><?php echo esc_html( $errors['form'] ); ?></div><?php endif; ?>
			<?php $page_count = 0; $page_open = false; foreach ( $definition['fields'] as $field ) { if ( 'page' === $field['type'] ) { if ( $page_open ) { echo '</div>'; } $page_open = true; $page_count++; echo '<div class="nyforms-page-panel" data-nyforms-page="' . esc_attr( $page_count ) . '"><h3>' . esc_html( $field['label'] ) . '</h3>'; continue; } if ( ! $page_open ) { $page_open = true; $page_count = 1; echo '<div class="nyforms-page-panel" data-nyforms-page="1">'; } $this->field( $field, $errors['fields'][ $field['key'] ] ?? '', $resume_values[ $field['key'] ] ?? null ); } if ( $page_open ) { echo '</div>'; } ?>
			<div class="nyforms-navigation" data-nyforms-pages="<?php echo esc_attr( $page_count ); ?>"><?php if ( $page_count > 1 && ! empty( $definition['settings']['progress'] ) ) : ?><span class="nyforms-progress" aria-live="polite"></span><?php endif; ?><button type="button" class="nyforms-previous" hidden><?php esc_html_e( 'Back', 'nyforms' ); ?></button><button type="button" class="nyforms-next"<?php echo 1 === $page_count ? ' hidden' : ''; ?>><?php esc_html_e( 'Next', 'nyforms' ); ?></button><span class="nyforms-submit-wrap"><button type="submit" class="nyforms-submit"><?php esc_html_e( 'Send', 'nyforms' ); ?></button><?php if ( ! empty( $definition['settings']['save_resume'] ) ) : ?> <button type="submit" class="nyforms-save" name="nyforms_action" value="save"><?php esc_html_e( 'Save and continue later', 'nyforms' ); ?></button><?php endif; ?></span></div>
		</form><?php
		return (string) ob_get_clean();
	}
	private function message_confirmation( $confirmations ) {
		foreach ( (array) $confirmations as $confirmation ) {
			if ( 'message' === ( $confirmation['type'] ?? '' ) ) {
				return (string) ( $confirmation['value'] ?? '' );
			}
		}
		return __( 'Thank you. Your submission has been received.', 'nyforms' );
	}
	private function submitted_message( $form ) {
		$key = isset( $_GET['nyforms_confirmation'] ) ? sanitize_key( $_GET['nyforms_confirmation'] ) : '';
		$data = $key ? get_transient( 'nyforms_confirmation_' . $key ) : false;
		if ( is_array( $data ) && (int) ( $data['form_id'] ?? 0 ) === (int) $form['id'] ) {
			delete_transient( 'nyforms_confirmation_' . $key );
			return (string) ( $data['message'] ?? '' );
		}
		return $this->message_confirmation( $form['definition']['confirmations'] );
	}
	private function resume_values( $form ) {
		$key = isset( $_GET['nyforms_resume'] ) ? sanitize_key( $_GET['nyforms_resume'] ) : '';
		$data = $key ? get_transient( 'nyforms_resume_' . $key ) : false;
		return is_array( $data ) && (int) ( $data['form_id'] ?? 0 ) === (int) $form['id'] && is_array( $data['values'] ?? null ) ? $data['values'] : array();
	}
	private function field( $field, $error, $saved_value = null ) {
		if ( in_array( $field['type'], array( 'html','section','page' ), true ) ) { echo '<section class="nyforms-' . esc_attr( $field['type'] ) . '">'; echo 'html' === $field['type'] ? wp_kses_post( $field['description'] ) : '<h3>' . esc_html( $field['label'] ) . '</h3>'; echo '</section>'; return; }
		if ( in_array( $field['type'], array( 'total', 'calculation' ), true ) ) { echo '<div class="nyforms-field nyforms-' . esc_attr( $field['type'] ) . '" data-nyforms-formula="' . esc_attr( $field['formula'] ) . '"><strong>' . esc_html( $field['label'] ) . '</strong><output data-nyforms-result>0.00</output></div>'; return; }
		$id = 'nyforms-' . $field['key']; $required = $field['required'] ? ' required aria-required="true"' : ''; $described = $error ? ' aria-describedby="' . esc_attr( $id ) . '-error"' : '';
		echo '<div class="nyforms-field nyforms-field--' . esc_attr( $field['type'] ) . ' ' . esc_attr( $field['css_class'] ) . '" data-nyforms-key="' . esc_attr( $field['key'] ) . '" data-nyforms-price="' . esc_attr( $field['price'] ) . '" data-nyforms-visibility="' . esc_attr( wp_json_encode( $field['visibility'] ) ) . '"><label for="' . esc_attr( $id ) . '">' . esc_html( $field['label'] ) . ( $field['required'] ? ' <span aria-hidden="true">*</span>' : '' ) . '</label>';
		if ( $field['description'] ) { echo '<div class="nyforms-description">' . wp_kses_post( $field['description'] ) . '</div>'; }
		$name = 'nyforms_values[' . $field['key'] . ']';
		$value = null === $saved_value ? $field['default'] : $saved_value;
		if ( 'textarea' === $field['type'] || 'address' === $field['type'] ) { echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '"' . $required . $described . '>' . esc_textarea( is_array( $value ) ? implode( ', ', $value ) : $value ) . '</textarea>'; }
		elseif ( in_array( $field['type'], array( 'select','radio','checkbox','option' ), true ) ) { $multiple = in_array( $field['type'], array( 'checkbox','option' ), true ); $selected = (array) $value; if ( 'select' === $field['type'] ) { echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . ( $multiple ? '[]' : '' ) . '"' . $required . $described . '>'; foreach ( $field['choices'] as $choice ) { echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( in_array( $choice['value'], $selected, true ), true, false ) . '>' . esc_html( $choice['label'] ) . '</option>'; } echo '</select>'; } else { foreach ( $field['choices'] as $i => $choice ) { $choice_id = $id . '-' . $i; echo '<label for="' . esc_attr( $choice_id ) . '"><input id="' . esc_attr( $choice_id ) . '" type="' . ( $multiple ? 'checkbox' : 'radio' ) . '" name="' . esc_attr( $name ) . ( $multiple ? '[]' : '' ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( in_array( $choice['value'], $selected, true ), true, false ) . $required . '> ' . esc_html( $choice['label'] ) . '</label>'; } } }
		elseif ( 'consent' === $field['type'] ) { echo '<label><input id="' . esc_attr( $id ) . '" type="checkbox" name="' . esc_attr( $name ) . '" value="yes"' . $required . '> ' . esc_html( $field['label'] ) . '</label>'; }
		else { $type = array( 'text','email','url','date','time','number','file','hidden' ); $type = in_array( $field['type'], $type, true ) ? $field['type'] : 'text'; if ( 'phone' === $field['type'] ) { $type = 'tel'; } $input_name = 'file' === $type ? 'nyforms_files[' . $field['key'] . ']' : $name; echo '<input id="' . esc_attr( $id ) . '" type="' . esc_attr( $type ) . '" name="' . esc_attr( $input_name ) . '"' . ( 'file' === $type ? '' : ' value="' . esc_attr( is_array( $value ) ? implode( ', ', $value ) : $value ) . '"' ) . ' placeholder="' . esc_attr( $field['placeholder'] ) . '"' . $required . $described . '>'; }
		if ( $error ) { echo '<p id="' . esc_attr( $id ) . '-error" class="nyforms-error" role="alert">' . esc_html( $error ) . '</p>'; } if ( $field['help'] ) { echo '<div class="nyforms-help">' . wp_kses_post( $field['help'] ) . '</div>'; } echo '</div>';
	}
}
