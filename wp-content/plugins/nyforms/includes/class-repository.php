<?php
namespace NYforms;

defined( 'ABSPATH' ) || exit;
class Repository {
	public function forms_table() {
		global $wpdb;
		return $wpdb->prefix . 'nyforms_forms'; }
	public function entries_table() {
		global $wpdb;
		return $wpdb->prefix . 'nyforms_entries'; }
	public function create_form( $data ) {
		global $wpdb;
		$form = Schema::sanitize_form( $data );
		if ( is_wp_error( $form ) ) {
			return $form;
		} $now = current_time( 'mysql', true );
		$wpdb->insert(
			$this->forms_table(),
			array(
				'title'      => $form['title'],
				'status'     => 'draft',
				'definition' => wp_json_encode( $form ),
				'revision'   => 1,
				'created_by' => get_current_user_id(),
				'created_at' => $now,
				'updated_at' => $now,
			),
			array( '%s', '%s', '%s', '%d', '%d', '%s', '%s' )
		);
		return (int) $wpdb->insert_id; }
	public function update_form( $id, $data ) {
		global $wpdb;
		$existing = $this->form( $id );
		if ( ! $existing ) {
			return new \WP_Error( 'nyforms_not_found', __( 'Form not found.', 'nyforms' ) );
		} $form = Schema::sanitize_form( $data );
		if ( is_wp_error( $form ) ) {
			return $form;
		} $revision = $existing['revision'] + 1;
		$wpdb->update(
			$this->forms_table(),
			array(
				'title'      => $form['title'],
				'definition' => wp_json_encode( $form ),
				'revision'   => $revision,
				'updated_at' => current_time( 'mysql', true ),
			),
			array( 'id' => absint( $id ) ),
			array( '%s', '%s', '%d', '%s' ),
			array( '%d' )
		);
		return $this->form( $id ); }
	public function form( $id ) {
		global $wpdb;
		$row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $this->forms_table(), $id ), ARRAY_A );
		if ( $row ) {
			$row['definition'] = json_decode( $row['definition'], true );
		} return $row; }
	public function forms( $search = '', $status = '' ) {
		global $wpdb;
		$sql   = 'SELECT f.*, COUNT(e.id) AS entries, SUM(CASE WHEN e.is_read = 0 AND e.status = "active" THEN 1 ELSE 0 END) AS unread FROM %i f LEFT JOIN %i e ON f.id = e.form_id';
		$where = array();
		$args  = array( $this->forms_table(), $this->entries_table() );
		if ( $search ) {
			$where[] = 'f.title LIKE %s';
			$args[]  = '%' . $wpdb->esc_like( $search ) . '%';
		} if ( $status ) {
			$where[] = 'f.status = %s';
			$args[]  = $status;
		} if ( $where ) {
			$sql .= ' WHERE ' . implode( ' AND ', $where );
		} $sql .= ' GROUP BY f.id ORDER BY f.updated_at DESC';
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,PluginCheck.Security.DirectDB.UnescapedDBParameter -- Query clauses are plugin-owned and all identifiers and values use placeholders.
		return $wpdb->get_results( $wpdb->prepare( $sql, $args ), ARRAY_A ); }
	public function duplicate( $id ) {
		$form = $this->form( $id );
		if ( ! $form ) {
			return new \WP_Error( 'nyforms_not_found' );
		} $data        = $form['definition'];
		/* translators: %s: Original form title. */
		$data['title'] = sprintf( __( '%s copy', 'nyforms' ), $form['title'] );
		return $this->create_form( $data ); }
	public function set_form_status( $id, $status ) {
		global $wpdb;
		if ( ! in_array( $status, array( 'active', 'draft', 'inactive', 'trash' ), true ) ) {
			return false;
		} return false !== $wpdb->update(
			$this->forms_table(),
			array(
				'status'     => $status,
				'updated_at' => current_time( 'mysql', true ),
			),
			array( 'id' => absint( $id ) ),
			array( '%s', '%s' ),
			array( '%d' )
		); }
	public function delete_form( $id ) {
		global $wpdb;
		$id        = absint( $id );
		$entry_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT id FROM %i WHERE form_id = %d', $this->entries_table(), $id ) );
		foreach ( $entry_ids as $entry_id ) {
			$this->delete_entry( $entry_id );
		} $wpdb->delete( $wpdb->prefix . 'nyforms_events', array( 'form_id' => $id ), array( '%d' ) );
		return false !== $wpdb->delete( $this->forms_table(), array( 'id' => $id ), array( '%d' ) ); }
	public function create_entry( $form, $values, $hash ) {
		global $wpdb;
		$now      = current_time( 'mysql', true );
		$inserted = $wpdb->insert(
			$this->entries_table(),
			array(
				'form_id'       => $form['id'],
				'form_revision' => $form['revision'],
				'submitted_by'  => get_current_user_id(),
				'source_url'    => esc_url_raw( wp_get_referer() ?: '' ),
				'request_hash'  => $hash,
				'submitted_at'  => $now,
				'updated_at'    => $now,
			),
			array( '%d', '%d', '%d', '%s', '%s', '%s', '%s' )
		);
		if ( false === $inserted ) {
			return new \WP_Error( 'nyforms_entry_insert_failed', __( 'The submission could not be saved.', 'nyforms' ) );
		} $id  = (int) $wpdb->insert_id;
		$table = $wpdb->prefix . 'nyforms_entry_values';
		foreach ( $values as $key => $value ) {
			if ( false === $wpdb->insert(
				$table,
				array(
					'entry_id'  => $id,
					'field_key' => $key,
					'value'     => maybe_serialize( $value ),
				),
				array( '%d', '%s', '%s' )
			) ) {
				$this->delete_entry( $id );
				return new \WP_Error( 'nyforms_entry_value_insert_failed', __( 'The submission values could not be saved.', 'nyforms' ) );
			}
		} return $id; }
	public function attach_file( $entry_id, $field_key, $attachment_id, $original_name, $mime_type ) {
		global $wpdb;
		return $wpdb->insert(
			$wpdb->prefix . 'nyforms_entry_files',
			array(
				'entry_id'      => $entry_id,
				'field_key'     => $field_key,
				'attachment_id' => $attachment_id,
				'original_name' => $original_name,
				'mime_type'     => $mime_type,
			),
			array( '%d', '%s', '%d', '%s', '%s' )
		); }
	public function entries( $form_id, $status = 'active', $search = '', $limit = 50, $offset = 0, $field_key = '' ) {
		global $wpdb;
		$sql  = 'SELECT * FROM %i WHERE form_id = %d';
		$args = array( $this->entries_table(), absint( $form_id ) );
		if ( 'all' === $status ) {
			$sql .= ' AND status != "trashed"';
		} elseif ( 'unread' === $status ) {
			$sql .= ' AND status = "active" AND is_read = 0';
		} elseif ( 'starred' === $status ) {
			$sql .= ' AND status = "active" AND is_starred = 1';
		} else {
			$sql   .= ' AND status = %s';
			$args[] = $status;
		} if ( $search ) {
			$sql   .= ' AND id IN (SELECT entry_id FROM %i WHERE ' . ( $field_key ? 'field_key = %s AND ' : '' ) . 'value LIKE %s)';
			$args[] = $wpdb->prefix . 'nyforms_entry_values';
			if ( $field_key ) {
				$args[] = sanitize_key( $field_key );
			} $args[] = '%' . $wpdb->esc_like( $search ) . '%';
		} $sql .= ' ORDER BY submitted_at DESC LIMIT %d OFFSET %d';
		$args[] = absint( $limit );
		$args[] = absint( $offset );
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,PluginCheck.Security.DirectDB.UnescapedDBParameter -- Query clauses are plugin-owned and all identifiers and values use placeholders.
		return $wpdb->get_results( $wpdb->prepare( $sql, $args ), ARRAY_A ); }
	public function entry_count( $form_id, $status = 'active', $search = '', $field_key = '' ) {
		global $wpdb;
		$sql  = 'SELECT COUNT(*) FROM %i WHERE form_id = %d';
		$args = array( $this->entries_table(), absint( $form_id ) );
		if ( 'all' === $status ) {
			$sql .= ' AND status != "trashed"';
		} elseif ( 'unread' === $status ) {
			$sql .= ' AND status = "active" AND is_read = 0';
		} elseif ( 'starred' === $status ) {
			$sql .= ' AND status = "active" AND is_starred = 1';
		} else {
			$sql   .= ' AND status = %s';
			$args[] = $status;
		} if ( $search ) {
			$sql   .= ' AND id IN (SELECT entry_id FROM %i WHERE ' . ( $field_key ? 'field_key = %s AND ' : '' ) . 'value LIKE %s)';
			$args[] = $wpdb->prefix . 'nyforms_entry_values';
			if ( $field_key ) {
				$args[] = sanitize_key( $field_key );
			}
			$args[] = '%' . $wpdb->esc_like( $search ) . '%';
		}
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,PluginCheck.Security.DirectDB.UnescapedDBParameter -- Query clauses are plugin-owned and all identifiers and values use placeholders.
		return (int) $wpdb->get_var( $wpdb->prepare( $sql, $args ) ); }
	public function entry_counts( $form_id ) {
		global $wpdb;
		$row = $wpdb->get_row( $wpdb->prepare( 'SELECT COUNT(*) AS total, SUM(status = "active" AND is_read = 0) AS unread, SUM(status = "active" AND is_starred = 1) AS starred, SUM(status = "spam") AS spam, SUM(status = "trashed") AS trashed FROM %i WHERE form_id = %d', $this->entries_table(), absint( $form_id ) ), ARRAY_A );
		return array_map( 'absint', $row ?: array() ); }
	public function update_entry_status( $id, $status, $read = null ) {
		global $wpdb;
		$data    = array(
			'status'     => $status,
			'updated_at' => current_time( 'mysql', true ),
		);
		$formats = array( '%s', '%s' );
		if ( null !== $read ) {
			$data['is_read'] = (int) $read;
			$formats[]       = '%d';
		} return false !== $wpdb->update( $this->entries_table(), $data, array( 'id' => absint( $id ) ), $formats, array( '%d' ) ); }
	public function update_entry_starred( $id, $starred ) {
		global $wpdb;
		return false !== $wpdb->update(
			$this->entries_table(),
			array(
				'is_starred' => (int) $starred,
				'updated_at' => current_time( 'mysql', true ),
			),
			array( 'id' => absint( $id ) ),
			array( '%d', '%s' ),
			array( '%d' )
		); }
	public function delete_entry( $id ) {
		global $wpdb;
		$id             = absint( $id );
		$attachment_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT attachment_id FROM %i WHERE entry_id = %d', $wpdb->prefix . 'nyforms_entry_files', $id ) );
		foreach ( $attachment_ids as $attachment_id ) {
			wp_delete_attachment( absint( $attachment_id ), true );
		} $wpdb->delete( $wpdb->prefix . 'nyforms_entry_values', array( 'entry_id' => $id ), array( '%d' ) );
		$wpdb->delete( $wpdb->prefix . 'nyforms_entry_files', array( 'entry_id' => $id ), array( '%d' ) );
		return false !== $wpdb->delete( $this->entries_table(), array( 'id' => $id ), array( '%d' ) ); }
	public function files_for_entry( $entry_id ) {
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %i WHERE entry_id = %d', $wpdb->prefix . 'nyforms_entry_files', $entry_id ), ARRAY_A ); }
	public function file( $id ) {
		global $wpdb;
		return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $wpdb->prefix . 'nyforms_entry_files', $id ), ARRAY_A ); }
	public function entry( $id ) {
		global $wpdb;
		$entry = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $this->entries_table(), $id ), ARRAY_A );
		if ( ! $entry ) {
			return null;
		} $rows          = $wpdb->get_results( $wpdb->prepare( 'SELECT field_key,value FROM %i WHERE entry_id = %d', $wpdb->prefix . 'nyforms_entry_values', $id ), ARRAY_A );
		$entry['values'] = array();
		foreach ( $rows as $row ) {
			$entry['values'][ $row['field_key'] ] = maybe_unserialize( $row['value'] );
		} return $entry; }
	public function forms_count( $query = array() ) {
		global $wpdb;
		$where = array( '1=1' );
		$args  = array( $this->forms_table() );
		if ( ! empty( $query['search'] ) ) {
			$where[] = 'title LIKE %s';
			$args[]  = '%' . $wpdb->esc_like( $query['search'] ) . '%';
		} if ( ! empty( $query['status'] ) ) {
			$where[] = 'status = %s';
			$args[]  = $query['status'];
		} $sql = 'SELECT COUNT(*) FROM %i WHERE ' . implode( ' AND ', $where );
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,PluginCheck.Security.DirectDB.UnescapedDBParameter -- Query clauses are plugin-owned and all identifiers and values use placeholders.
		return (int) $wpdb->get_var( $wpdb->prepare( $sql, $args ) ); }
	public function forms_api( $query = array() ) {
		global $wpdb;
		$where = array( '1=1' );
		$args  = array( $this->forms_table(), $this->entries_table() );
		if ( ! empty( $query['search'] ) ) {
			$where[] = 'f.title LIKE %s';
			$args[]  = '%' . $wpdb->esc_like( $query['search'] ) . '%';
		} if ( ! empty( $query['status'] ) ) {
			$where[] = 'f.status = %s';
			$args[]  = $query['status'];
		} $orderby = in_array( $query['orderby'] ?? '', array( 'title', 'status', 'created_at', 'updated_at' ), true ) ? $query['orderby'] : 'updated_at';
		$order     = 'ASC' === ( $query['order'] ?? '' ) ? 'ASC' : 'DESC';
		$per_page  = min( 100, max( 1, absint( $query['per_page'] ?? 20 ) ) );
		$offset    = ( max( 1, absint( $query['page'] ?? 1 ) ) - 1 ) * $per_page;
		$sql       = 'SELECT f.*, COUNT(e.id) AS entries, SUM(CASE WHEN e.is_read = 0 AND e.status = "active" THEN 1 ELSE 0 END) AS unread FROM %i f LEFT JOIN %i e ON f.id = e.form_id WHERE ' . implode( ' AND ', $where ) . ' GROUP BY f.id ORDER BY %i ' . $order . ' LIMIT %d OFFSET %d';
		$args[]    = $orderby;
		$args[]    = $per_page;
		$args[]    = $offset;
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,PluginCheck.Security.DirectDB.UnescapedDBParameter -- Query clauses are plugin-owned and all identifiers and values use placeholders.
		return $wpdb->get_results( $wpdb->prepare( $sql, $args ), ARRAY_A ); }
	private function entries_where( $form_id, $query, &$args ) {
		global $wpdb;
		$where  = array( 'form_id = %d' );
		$args[] = absint( $form_id );
		$status = $query['status'] ?? 'active';
		if ( 'all' === $status ) {
			$where[] = 'status != "trashed"';
		} elseif ( 'unread' === $status ) {
			$where[] = 'status = "active" AND is_read = 0';
		} elseif ( 'starred' === $status ) {
			$where[] = 'status = "active" AND is_starred = 1';
		} else {
			$where[] = 'status = %s';
			$args[]  = $status;
		} $after = ! empty( $query['after'] ) ? strtotime( $query['after'] ) : false;
		if ( false !== $after ) {
			$where[] = 'submitted_at >= %s';
			$args[]  = gmdate( 'Y-m-d H:i:s', $after );
		} $before = ! empty( $query['before'] ) ? strtotime( $query['before'] ) : false;
		if ( false !== $before ) {
			$where[] = 'submitted_at <= %s';
			$args[]  = gmdate( 'Y-m-d H:i:s', $before );
		} if ( ! empty( $query['search'] ) ) {
			$where[] = 'id IN (SELECT entry_id FROM %i WHERE ' . ( ! empty( $query['field'] ) ? 'field_key = %s AND ' : '' ) . 'value LIKE %s)';
			$args[]  = $wpdb->prefix . 'nyforms_entry_values';
			if ( ! empty( $query['field'] ) ) {
				$args[] = sanitize_key( $query['field'] );
			} $args[] = '%' . $wpdb->esc_like( $query['search'] ) . '%';
		} return implode( ' AND ', $where ); }
	public function entries_count_api( $form_id, $query ) {
		global $wpdb;
		$args  = array( $this->entries_table() );
		$where = $this->entries_where( $form_id, $query, $args );
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,PluginCheck.Security.DirectDB.UnescapedDBParameter -- Query clauses are plugin-owned and all identifiers and values use placeholders.
		return (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i WHERE ' . $where, $args ) ); }
	public function entries_api( $form_id, $query ) {
		global $wpdb;
		$args     = array( $this->entries_table() );
		$where    = $this->entries_where( $form_id, $query, $args );
		$orderby  = in_array( $query['orderby'] ?? '', array( 'id', 'submitted_at', 'updated_at', 'status' ), true ) ? $query['orderby'] : 'submitted_at';
		$order    = 'ASC' === ( $query['order'] ?? '' ) ? 'ASC' : 'DESC';
		$per_page = min( 1000, max( 1, absint( $query['per_page'] ?? 20 ) ) );
		$offset   = ( max( 1, absint( $query['page'] ?? 1 ) ) - 1 ) * $per_page;
		$args[]   = $orderby;
		$args[]   = $per_page;
		$args[]   = $offset;
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber,PluginCheck.Security.DirectDB.UnescapedDBParameter -- The WHERE and direction clauses are assembled from plugin-owned fragments and strict allowlists.
		$items    = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %i WHERE ' . $where . ' ORDER BY %i ' . $order . ' LIMIT %d OFFSET %d', $args ), ARRAY_A );
		foreach ( $items as &$item ) {
			$detail         = $this->entry( $item['id'] );
			$item['values'] = $detail['values'];
		} return $items; }
	public function event( $type, $form_id = 0, $entry_id = 0, $context = array() ) {
		global $wpdb;
		return $wpdb->insert(
			$wpdb->prefix . 'nyforms_events',
			array(
				'form_id'    => absint( $form_id ),
				'entry_id'   => absint( $entry_id ),
				'event_type' => sanitize_key( $type ),
				'context'    => wp_json_encode( $context ),
				'created_at' => current_time( 'mysql', true ),
			),
			array( '%d', '%d', '%s', '%s', '%s' )
		); }
	public function events_count() {
		global $wpdb;
		return (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i', $wpdb->prefix . 'nyforms_events' ) ); }
	public function events( $page = 1, $per_page = 20 ) {
		global $wpdb;
		$per_page = min( 100, max( 1, absint( $per_page ) ) );
		$offset   = ( max( 1, absint( $page ) ) - 1 ) * $per_page;
		$rows     = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %i ORDER BY created_at DESC LIMIT %d OFFSET %d', $wpdb->prefix . 'nyforms_events', $per_page, $offset ), ARRAY_A );
		foreach ( $rows as &$row ) {
			$row['context'] = json_decode( $row['context'], true );
		} return $rows; }
}
