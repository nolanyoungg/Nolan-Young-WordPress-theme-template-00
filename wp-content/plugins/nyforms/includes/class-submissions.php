<?php
namespace NYforms;

defined( 'ABSPATH' ) || exit;
class Submissions {
	public function handle() {
		$action = sanitize_key( wp_unslash( $_POST['nyforms_action'] ?? '' ) );
		if ( ! in_array( $action, array( 'submit', 'save' ), true ) ) {
			return; }
		$form_id = absint( $_POST['nyforms_form_id'] ?? 0 );
		$form    = Plugin::instance()->repository->form( $form_id );
		if ( ! $form || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nyforms_token'] ?? '' ) ), 'nyforms_submit_' . $form_id ) ) {
			$this->fail( $form_id, array( 'form' => __( 'Your form session has expired. Please try again.', 'nyforms' ) ) ); }
		if ( 'save' === $action ) {
			$this->save_resume( $form ); }
		if ( ! empty( $_POST['nyforms_website'] ) || ! $this->rate_allowed() || ! $this->recaptcha_valid() ) {
			$this->fail( $form_id, array( 'form' => __( 'We could not process this submission.', 'nyforms' ) ) ); }
		// Values are unslashed here and sanitized by Fields::validate() below.
		$raw    = wp_unslash( $_POST['nyforms_values'] ?? array() ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$values = array();
		$errors = array();
		foreach ( $form['definition']['fields'] as $field ) {
			if ( in_array( $field['type'], array( 'html', 'section', 'page', 'file', 'total', 'calculation' ), true ) || ! Conditions::matches( $field['visibility'], $raw ) ) {
				continue;
			} $value = $raw[ $field['key'] ] ?? '';
			$valid   = Fields::validate( $field, $value );
			if ( is_wp_error( $valid ) ) {
				$errors[ $field['key'] ] = $valid->get_error_message();
			} else {
				$values[ $field['key'] ] = $valid; }
		}
		foreach ( $form['definition']['fields'] as $field ) {
			if ( 'file' !== $field['type'] ) {
				continue;
			}
			$files = isset( $_FILES['nyforms_files'] ) && is_array( $_FILES['nyforms_files'] ) ? $_FILES['nyforms_files'] : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			if ( empty( $files['name'][ $field['key'] ] ) ) {
				if ( $field['required'] ) {
					/* translators: %s: Form field label. */
					$errors[ $field['key'] ] = sprintf( __( '%s is required.', 'nyforms' ), $field['label'] );
				} continue;
			} $file = array(
				'name'     => sanitize_file_name( wp_unslash( $files['name'][ $field['key'] ] ) ),
				'type'     => sanitize_mime_type( $files['type'][ $field['key'] ] ?? '' ),
				'tmp_name' => sanitize_text_field( $files['tmp_name'][ $field['key'] ] ?? '' ),
				'error'    => absint( $files['error'][ $field['key'] ] ?? UPLOAD_ERR_NO_FILE ),
				'size'     => absint( $files['size'][ $field['key'] ] ?? 0 ),
			);
			if ( UPLOAD_ERR_OK !== $file['error'] || $file['size'] > $field['max_size'] ) {
				$errors[ $field['key'] ] = __( 'The uploaded file is too large or failed to upload.', 'nyforms' );
				continue;
			} $allowed = array_filter( array_map( 'trim', explode( ',', $field['allowed_types'] ) ) );
			$check     = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'] );
			if ( empty( $check['type'] ) || ( $allowed && ! in_array( $check['ext'], $allowed, true ) ) ) {
				$errors[ $field['key'] ] = __( 'This file type is not allowed.', 'nyforms' );
				continue;
			} $values[ $field['key'] ] = array(
				'_upload' => $file,
				'_mime'   => $check['type'],
			); }
		foreach ( Extensions::spam_providers() as $provider ) {
			if ( $provider instanceof Anti_Spam_Provider && ! $provider->evaluate( $form, $values ) ) {
				$this->fail( $form_id, array( 'form' => __( 'We could not process this submission.', 'nyforms' ) ) ); }
		}
		if ( $errors ) {
			$this->fail( $form_id, array( 'fields' => $errors ) ); }
		$uploads = array();
		foreach ( $values as $key => $value ) {
			if ( is_array( $value ) && isset( $value['_upload'] ) ) {
				$uploads[ $key ] = $value;
				$values[ $key ]  = $value['_upload']['name'];
			}
		} $hash   = hash_hmac( 'sha256', $form_id . '|' . wp_json_encode( $values ), wp_salt( 'nonce' ) );
		$entry_id = Plugin::instance()->repository->create_entry( $form, $values, $hash );
		if ( is_wp_error( $entry_id ) || ! $entry_id ) {
			$this->fail( $form_id, array( 'form' => __( 'Your submission could not be saved. Please try again.', 'nyforms' ) ) );
		} foreach ( $uploads as $key => $upload ) {
			$stored = $this->store_file( $entry_id, $key, $upload );
			if ( is_wp_error( $stored ) ) {
				Plugin::instance()->repository->delete_entry( $entry_id );
				$this->fail( $form_id, array( 'form' => $stored->get_error_message() ) );
			}
		} do_action( 'nyforms_entry_created', $entry_id, $form, $values );
		Plugin::instance()->notifications->send( $form, $values, $entry_id );
		$confirmation = $this->confirmation( $form['definition']['confirmations'], $values );
		if ( 'url' === $confirmation['type'] && 0 === strpos( $confirmation['value'], 'https://' ) ) {
			wp_safe_redirect( $confirmation['value'] );
			exit;
		} if ( 'page' === $confirmation['type'] ) {
			$url = get_permalink( absint( $confirmation['value'] ) );
			if ( $url ) {
				wp_safe_redirect( $url );
				exit; }
		}
		$key     = wp_generate_password( 20, false, false );
		$message = Plugin::instance()->notifications->tokens( (string) ( $confirmation['value'] ?? '' ), $form, $values, $entry_id );
		set_transient(
			'nyforms_confirmation_' . $key,
			array(
				'form_id' => $form_id,
				'message' => $message,
			),
			MINUTE_IN_SECONDS * 5
		);
		wp_safe_redirect(
			add_query_arg(
				array(
					'nyforms_submitted'    => $form_id,
					'nyforms_confirmation' => $key,
				),
				$this->return_url()
			)
		);
		exit;
	}
	private function confirmation( $items, $values ) {
		foreach ( $items as $item ) {
			if ( ! empty( $item['enabled'] ) && Conditions::matches( $item['conditions'], $values ) ) {
				return $item;
			}
		}

		return array(
			'type'  => 'message',
			'value' => '',
		);
	}
	private function save_resume( $form ) {
		if ( empty( $form['definition']['settings']['save_resume'] ) ) {
			$this->fail( $form['id'], array( 'form' => __( 'Saving is not enabled for this form.', 'nyforms' ) ) ); }
		$values = array();
		// The submission nonce was verified by handle() before this method runs.
		foreach ( (array) wp_unslash( $_POST['nyforms_values'] ?? array() ) as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$values[ sanitize_key( $key ) ] = is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : sanitize_textarea_field( $value ); }
		$key = wp_generate_password( 32, false, false );
		set_transient(
			'nyforms_resume_' . $key,
			array(
				'form_id' => $form['id'],
				'values'  => $values,
			),
			WEEK_IN_SECONDS
		);
		$url = add_query_arg(
			array(
				'nyforms_resume' => $key,
				'nyforms_saved'  => 1,
			),
			$this->return_url()
		);
		wp_safe_redirect( $url );
		exit;
	}
	private function rate_allowed() {
		$remote_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$key            = 'nyforms_rate_' . md5( wp_privacy_anonymize_ip( $remote_address ) );
		$count = (int) get_transient( $key );
		$limit = absint( ( get_option( 'nyforms_settings', array() )['rate_limit'] ?? 10 ) );
		if ( $count >= $limit ) {
			return false;
		} set_transient( $key, $count + 1, HOUR_IN_SECONDS );
		return true; }
	private function recaptcha_valid() {
		$settings = get_option( 'nyforms_settings', array() );
		if ( empty( $settings['recaptcha_enabled'] ) ) {
			return true;
		} $secret = sanitize_text_field( $settings['recaptcha_secret_key'] ?? '' );
		// The submission nonce was verified by handle() before this method runs.
		$token    = sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( '' === $secret || '' === $token ) {
			return false;
		}
		$remote_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$response       = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			array(
				'timeout' => 10,
				'body'    => array(
					'secret'   => $secret,
					'response' => $token,
					'remoteip' => wp_privacy_anonymize_ip( $remote_address ),
				),
			)
		);
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return false;
		} $body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( empty( $body['success'] ) ) {
			return false;
		} $expected = wp_parse_url( home_url(), PHP_URL_HOST );
		$hostname   = sanitize_text_field( $body['hostname'] ?? '' );
		return ! $hostname || ! $expected || $hostname === $expected || substr( $hostname, -strlen( '.' . $expected ) ) === '.' . $expected; }
	private function store_file( $entry_id, $field_key, $upload ) {
		$attachment = Storage::store( $upload['_upload'], $upload['_mime'] );
		if ( is_wp_error( $attachment ) ) {
			return $attachment;
		} if ( ! Plugin::instance()->repository->attach_file( $entry_id, $field_key, $attachment, $upload['_upload']['name'], $upload['_mime'] ) ) {
			wp_delete_attachment( $attachment, true );
			return new \WP_Error( 'nyforms_file_record_failed', __( 'The upload record could not be saved.', 'nyforms' ) );
		} return true; }
	private function fail( $form_id, $errors ) {
		$key = wp_generate_password( 20, false, false );
		set_transient( 'nyforms_errors_' . $key, $errors, MINUTE_IN_SECONDS * 5 );
		wp_safe_redirect( add_query_arg( 'nyforms_errors', $key, $this->return_url() ) );
		exit; }

	/**
	 * Return the validated page that contained the submitted form.
	 *
	 * The wp_get_referer() helper deliberately rejects a same-page referer, which is the
	 * normal target for a form without an explicit action attribute.
	 *
	 * @return string
	 */
	private function return_url() {
		$referer = wp_get_raw_referer();

		return wp_validate_redirect( $referer ? $referer : '', home_url( '/' ) );
	}
}
