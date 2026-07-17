<?php
namespace NYforms;
defined( 'ABSPATH' ) || exit;
class Conditions {
	public static function sanitize( $logic ) { if ( empty( $logic['rules'] ) || ! is_array( $logic['rules'] ) ) { return array(); } $rules = array(); foreach ( $logic['rules'] as $rule ) { $rules[] = array( 'field' => sanitize_key( $rule['field'] ?? '' ), 'operator' => in_array( $rule['operator'] ?? '', array( 'equals', 'not_equals', 'checked', 'unchecked' ), true ) ? $rule['operator'] : 'equals', 'value' => sanitize_text_field( $rule['value'] ?? '' ) ); } return array( 'match' => 'any' === ( $logic['match'] ?? '' ) ? 'any' : 'all', 'rules' => $rules ); }
	public static function valid( $logic, $keys ) { foreach ( (array) ( $logic['rules'] ?? array() ) as $rule ) { if ( ! in_array( $rule['field'] ?? '', $keys, true ) ) { return false; } } return true; }
	public static function matches( $logic, $values ) { if ( empty( $logic['rules'] ) ) { return true; } $matches = array(); foreach ( $logic['rules'] as $rule ) { $value = $values[ $rule['field'] ] ?? ''; $value = is_array( $value ) ? $value : array( $value ); $target = (string) $rule['value']; switch ( $rule['operator'] ) { case 'not_equals': $matches[] = ! in_array( $target, array_map( 'strval', $value ), true ); break; case 'checked': $matches[] = ! empty( $value ); break; case 'unchecked': $matches[] = empty( $value ); break; default: $matches[] = in_array( $target, array_map( 'strval', $value ), true ); } } return 'any' === ( $logic['match'] ?? 'all' ) ? in_array( true, $matches, true ) : ! in_array( false, $matches, true ); }
}
