<?php

class NYforms_Renderer_Test extends WP_UnitTestCase {
	public function set_up() {
		parent::set_up();
		\NYforms\Installer::activate();
	}

	public function test_renders_supported_core_fields_with_labels() {
		$fields = array();
		foreach ( array( 'text', 'textarea', 'email', 'phone', 'number', 'url', 'date', 'time', 'select', 'radio', 'checkbox', 'consent', 'hidden', 'file' ) as $type ) {
			$fields[] = array( 'key' => 'field_' . $type, 'type' => $type, 'label' => ucfirst( $type ), 'choices' => array( array( 'label' => 'Choice', 'value' => 'choice' ) ) );
		}
		$id = \NYforms\Plugin::instance()->repository->create_form( array( 'title' => 'Renderer fields', 'fields' => $fields ) );
		$markup = \NYforms\Plugin::instance()->renderer->render( $id );
		$this->assertStringContainsString( 'nyforms-field--email', $markup );
		$this->assertStringContainsString( 'type="file"', $markup );
		$this->assertStringContainsString( 'for="nyforms-field_email"', $markup );
	}

	public function test_renders_multi_page_navigation_and_saved_values() {
		$id = \NYforms\Plugin::instance()->repository->create_form( array( 'title' => 'Paged form', 'settings' => array( 'save_resume' => true ), 'fields' => array( array( 'key' => 'name', 'type' => 'text', 'label' => 'Name' ), array( 'key' => 'next', 'type' => 'page', 'label' => 'Next step' ), array( 'key' => 'email', 'type' => 'email', 'label' => 'Email' ) ) ) );
		$_GET['nyforms_resume'] = 'renderer-test';
		set_transient( 'nyforms_resume_renderer-test', array( 'form_id' => $id, 'values' => array( 'name' => 'Saved value' ) ), HOUR_IN_SECONDS );
		$markup = \NYforms\Plugin::instance()->renderer->render( $id );
		unset( $_GET['nyforms_resume'] );
		$this->assertSame( 2, substr_count( $markup, 'nyforms-page-panel' ) );
		$this->assertStringContainsString( 'Save and continue later', $markup );
		$this->assertStringContainsString( 'Saved value', $markup );
	}
}
