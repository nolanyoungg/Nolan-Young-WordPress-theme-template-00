<?php
class NYforms_Schema_And_Conditions_Test extends WP_UnitTestCase {
	public function test_rejects_duplicate_field_keys() { $result = \NYforms\Schema::sanitize_form( array( 'title' => 'Contact', 'fields' => array( array( 'key' => 'email', 'type' => 'email' ), array( 'key' => 'email', 'type' => 'text' ) ) ) ); $this->assertWPError( $result ); }
	public function test_conditions_support_all_and_any() { $logic = array( 'match' => 'all', 'rules' => array( array( 'field' => 'choice', 'operator' => 'equals', 'value' => 'yes' ) ) ); $this->assertTrue( \NYforms\Conditions::matches( $logic, array( 'choice' => 'yes' ) ) ); $this->assertFalse( \NYforms\Conditions::matches( $logic, array( 'choice' => 'no' ) ) ); }
	public function test_email_validation_rejects_invalid_input() { $field = \NYforms\Fields::sanitize( array( 'key' => 'email', 'type' => 'email', 'label' => 'Email', 'required' => true ) ); $this->assertWPError( \NYforms\Fields::validate( $field, 'not-an-email' ) ); }
}
