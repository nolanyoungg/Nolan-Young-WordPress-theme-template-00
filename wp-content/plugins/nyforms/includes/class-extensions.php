<?php
namespace NYforms;
defined( 'ABSPATH' ) || exit;

interface Field_Type { public function type(); public function sanitize( $field ); public function validate( $value, $field ); public function render( $field, $value, $error ); }
interface Anti_Spam_Provider { public function key(); public function evaluate( $form, $values ); }
interface Notification_Provider { public function key(); public function send( $notification, $form, $values, $entry_id ); }
class Extensions {
	public static function field_types() { return apply_filters( 'nyforms_field_types', array() ); }
	public static function field_type( $type ) { foreach ( self::field_types() as $field_type ) { if ( $field_type instanceof Field_Type && $type === $field_type->type() ) { return $field_type; } } return null; }
	public static function spam_providers() { return apply_filters( 'nyforms_spam_providers', array() ); }
	public static function notification_providers() { return apply_filters( 'nyforms_notification_providers', array() ); }
}
