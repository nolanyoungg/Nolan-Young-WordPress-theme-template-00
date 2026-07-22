<?php
class NYforms_Repository_Test extends WP_UnitTestCase {
	public function set_up() {
		parent::set_up();
		\NYforms\Installer::activate();
	}

	public function test_form_can_be_created_updated_and_duplicated() { $repo = \NYforms\Plugin::instance()->repository; $id = $repo->create_form( array( 'title' => 'Contact', 'fields' => array( array( 'key' => 'email', 'type' => 'email', 'label' => 'Email' ) ) ) ); $this->assertIsInt( $id ); $form = $repo->update_form( $id, array( 'title' => 'Contact revised', 'fields' => array() ) ); $this->assertSame( 'Contact revised', $form['title'] ); $copy = $repo->duplicate( $id ); $this->assertIsInt( $copy ); }
	public function test_privacy_eraser_completes_multiple_batches() { $repo = \NYforms\Plugin::instance()->repository; $form_id = $repo->create_form( array( 'title' => 'Privacy', 'fields' => array( array( 'key' => 'email', 'type' => 'email', 'label' => 'Email' ) ) ) ); $form = $repo->form( $form_id ); for ( $index = 0; $index < 101; $index++ ) { $repo->create_entry( $form, array( 'email' => 'person@example.com' ), 'test-' . $index ); } $privacy = new \NYforms\Privacy(); $first = $privacy->eraser( 'person@example.com' ); $this->assertFalse( $first['done'] ); $second = $privacy->eraser( 'person@example.com', 2 ); $this->assertFalse( $second['done'] ); $third = $privacy->eraser( 'person@example.com', 3 ); $this->assertTrue( $third['done'] ); $this->assertSame( 0, $repo->entry_count( $form_id, 'all' ) ); }
}
