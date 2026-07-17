<?php
namespace NYforms;

defined( 'ABSPATH' ) || exit;

class Schema {
	const FORMAT_VERSION = 1;

	public static function sanitize_form( $form ) {
		$form = is_array( $form ) ? $form : array();
		$clean = array(
			'format_version' => self::FORMAT_VERSION,
			'title' => sanitize_text_field( $form['title'] ?? '' ),
			'description' => wp_kses_post( $form['description'] ?? '' ),
			'css_class' => sanitize_html_class( $form['css_class'] ?? '' ),
			'fields' => array(),
			'confirmations' => self::sanitize_confirmations( $form['confirmations'] ?? array() ),
			'notifications' => self::sanitize_notifications( $form['notifications'] ?? array() ),
			'settings' => self::sanitize_settings( $form['settings'] ?? array() ),
		);
		if ( '' === $clean['title'] ) { return new \WP_Error( 'nyforms_invalid_title', __( 'A form title is required.', 'nyforms' ) ); }
		$keys = array();
		foreach ( (array) ( $form['fields'] ?? array() ) as $field ) {
			$field = Fields::sanitize( $field );
			if ( is_wp_error( $field ) ) { return $field; }
			if ( isset( $keys[ $field['key'] ] ) ) { return new \WP_Error( 'nyforms_duplicate_key', __( 'Every field key must be unique.', 'nyforms' ) ); }
			$keys[ $field['key'] ] = true;
			$clean['fields'][] = $field;
		}
		$references = array_keys( $keys );
		foreach ( array_merge( $clean['fields'], $clean['confirmations'], $clean['notifications'] ) as $item ) {
			if ( ! empty( $item['conditions'] ) && ! Conditions::valid( $item['conditions'], $references ) ) { return new \WP_Error( 'nyforms_invalid_conditions', __( 'A conditional rule references an unavailable field.', 'nyforms' ) ); }
		}
		return $clean;
	}

	private static function sanitize_settings( $settings ) {
		return array( 'honeypot' => ! empty( $settings['honeypot'] ), 'progress' => ! empty( $settings['progress'] ), 'save_resume' => ! empty( $settings['save_resume'] ), 'retention_days' => absint( $settings['retention_days'] ?? 0 ) );
	}
	private static function sanitize_confirmations( $items ) {
		$out = array(); foreach ( (array) $items as $item ) { $type = in_array( $item['type'] ?? 'message', array( 'message', 'page', 'url' ), true ) ? $item['type'] : 'message'; $value = 'message' === $type ? wp_kses_post( $item['value'] ?? '' ) : ( 'page' === $type ? (string) absint( $item['value'] ?? 0 ) : esc_url_raw( $item['value'] ?? '' ) ); $out[] = array( 'type' => $type, 'value' => $value, 'conditions' => Conditions::sanitize( $item['conditions'] ?? array() ) ); } return $out ?: array( array( 'type' => 'message', 'value' => __( 'Thank you. Your submission has been received.', 'nyforms' ), 'conditions' => array() ) );
	}
	private static function sanitize_notifications( $items ) {
		$out = array(); foreach ( (array) $items as $item ) { $out[] = array( 'to' => sanitize_text_field( $item['to'] ?? '' ), 'subject' => sanitize_text_field( $item['subject'] ?? '' ), 'message' => wp_kses_post( $item['message'] ?? '' ), 'from_name' => sanitize_text_field( $item['from_name'] ?? '' ), 'from_email' => sanitize_email( $item['from_email'] ?? '' ), 'reply_to' => sanitize_text_field( $item['reply_to'] ?? '' ), 'conditions' => Conditions::sanitize( $item['conditions'] ?? array() ) ); } return $out;
	}
}
