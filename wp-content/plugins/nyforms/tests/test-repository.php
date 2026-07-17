<?php
class NYforms_Repository_Test extends WP_UnitTestCase {
	public function set_up() {
		parent::set_up();
		\NYforms\Installer::activate();
	}

	public function test_form_can_be_created_updated_and_duplicated() { $repo = \NYforms\Plugin::instance()->repository; $id = $repo->create_form( array( 'title' => 'Contact', 'fields' => array( array( 'key' => 'email', 'type' => 'email', 'label' => 'Email' ) ) ) ); $this->assertIsInt( $id ); $form = $repo->update_form( $id, array( 'title' => 'Contact revised', 'fields' => array() ) ); $this->assertSame( 'Contact revised', $form['title'] ); $copy = $repo->duplicate( $id ); $this->assertIsInt( $copy ); }
}
