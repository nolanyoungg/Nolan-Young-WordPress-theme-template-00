<?php
/**
 * Protected upload storage.
 *
 * @package NYforms
 */

namespace NYforms;

defined( 'ABSPATH' ) || exit;

/**
 * Stores submission uploads outside the public WordPress directory by default.
 */
class Storage {
	/**
	 * Register attachment cleanup.
	 *
	 * @return void
	 */
	public static function hooks() {
		add_action( 'delete_attachment', array( __CLASS__, 'delete_attachment_file' ) );
	}

	/**
	 * Return the private storage directory.
	 *
	 * @return string
	 */
	public static function directory() {
		$directory = dirname( untrailingslashit( ABSPATH ) ) . '/nyforms-private';

		/**
		 * Filter the private upload directory.
		 *
		 * Configure a persistent path outside the public web root on managed
		 * hosts whose WordPress parent directory is not writable.
		 *
		 * @param string $directory Default directory.
		 */
		return untrailingslashit( (string) apply_filters( 'nyforms_private_storage_directory', $directory ) );
	}

	/**
	 * Store one validated upload and create its private attachment record.
	 *
	 * @param array  $file      Normalized PHP upload.
	 * @param string $mime_type Verified MIME type.
	 * @return int|\WP_Error
	 */
	public static function store( $file, $mime_type ) {
		$directory = self::directory();
		$filesystem = self::filesystem();
		if ( ! $filesystem || ! wp_mkdir_p( $directory ) || ! $filesystem->is_writable( $directory ) ) {
			return new \WP_Error( 'nyforms_storage_unavailable', __( 'Private upload storage is unavailable.', 'nyforms' ) );
		}

		self::write_protection_files( $directory );

		$extension = strtolower( (string) pathinfo( sanitize_file_name( $file['name'] ), PATHINFO_EXTENSION ) );
		$filename  = wp_generate_uuid4() . ( $extension ? '.' . $extension : '' );
		$path      = trailingslashit( $directory ) . $filename;

		if ( ! $filesystem->move( $file['tmp_name'], $path, true ) ) {
			return new \WP_Error( 'nyforms_storage_failed', __( 'The uploaded file could not be stored.', 'nyforms' ) );
		}

		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => sanitize_mime_type( $mime_type ),
				'post_title'     => sanitize_text_field( pathinfo( $file['name'], PATHINFO_FILENAME ) ),
				'post_status'    => 'private',
				'guid'           => '',
			)
		);

		if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
			wp_delete_file( $path );
			return is_wp_error( $attachment_id ) ? $attachment_id : new \WP_Error( 'nyforms_attachment_failed', __( 'The upload record could not be created.', 'nyforms' ) );
		}

		update_post_meta( $attachment_id, '_nyforms_private_path', $path );
		return (int) $attachment_id;
	}

	/**
	 * Resolve a private attachment path, with legacy attachment compatibility.
	 *
	 * @param int $attachment_id Attachment ID.
	 * @return string|false
	 */
	public static function path( $attachment_id ) {
		$path = (string) get_post_meta( absint( $attachment_id ), '_nyforms_private_path', true );
		if ( $path && 0 === strpos( wp_normalize_path( $path ), wp_normalize_path( self::directory() ) . '/' ) ) {
			return $path;
		}

		return get_attached_file( absint( $attachment_id ) );
	}

	/**
	 * Delete the private file associated with an attachment.
	 *
	 * @param int $attachment_id Attachment ID.
	 * @return void
	 */
	public static function delete_attachment_file( $attachment_id ) {
		$path = (string) get_post_meta( absint( $attachment_id ), '_nyforms_private_path', true );
		if ( $path && file_exists( $path ) ) {
			wp_delete_file( $path );
		}
	}

	/**
	 * Read a protected file through the WordPress filesystem API.
	 *
	 * @param string $path Absolute protected file path.
	 * @return string|false
	 */
	public static function contents( $path ) {
		$filesystem = self::filesystem();
		return $filesystem ? $filesystem->get_contents( $path ) : false;
	}

	/**
	 * Add defense-in-depth rules if the configured path is web reachable.
	 *
	 * @param string $directory Storage directory.
	 * @return void
	 */
	private static function write_protection_files( $directory ) {
		$filesystem = self::filesystem();
		if ( ! $filesystem ) {
			return;
		}

		$files = array(
			'.htaccess'  => "Require all denied\nDeny from all\n",
			'web.config' => "<?xml version=\"1.0\" encoding=\"UTF-8\"?><configuration><system.webServer><authorization><deny users=\"*\" /></authorization></system.webServer></configuration>\n",
			'index.php'  => "<?php\nhttp_response_code( 404 );\nexit;\n",
		);

		foreach ( $files as $filename => $contents ) {
			$path = trailingslashit( $directory ) . $filename;
			if ( ! $filesystem->exists( $path ) ) {
				$filesystem->put_contents( $path, $contents, FS_CHMOD_FILE );
			}
		}
	}

	/**
	 * Initialize and return the WordPress filesystem implementation.
	 *
	 * @return \WP_Filesystem_Base|false
	 */
	private static function filesystem() {
		global $wp_filesystem;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! $wp_filesystem && ! WP_Filesystem() ) {
			return false;
		}

		return $wp_filesystem;
	}
}
